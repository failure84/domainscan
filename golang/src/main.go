package main

import (
	"database/sql"
	"fmt"
	"log"
	"net"
	"os"
	"strings"

	_ "github.com/go-sql-driver/mysql"
)

var mysqlPassword string

// Domainscaner interface
type Domainscaner interface {
	mx(string) ([]*net.MX, error)
	iplookup(string) ([]net.IP, error)
	checkForRecord(uint64, string, uint16) uint64
	updateTime(uint64) error
	insertRecord(uint64, string, uint16) error
	connect() *sql.DB
	mainParser(chan bool)
}

// Domainscan interface
type Domainscan struct {
	db *sql.DB
}

// Domain mysql structure
type domains struct {
	ID     uint64 `json:"id"`
	Name   string `json:"name"`
	Errors uint16 `json:"errors"`
}

// New object
func New() Domainscaner {
	return &Domainscan{}
}

func (ds *Domainscan) mx(domain string) ([]*net.MX, error) {
	mx, err := net.LookupMX(domain)
	if err != nil {
		fmt.Fprintf(os.Stderr, "[E] Error resolving MX: %v\n", err)
	}
	return mx, err
}

func (ds *Domainscan) iplookup(domain string) ([]net.IP, error) {
	ip, err := net.LookupIP(domain)
	return ip, err
}

func (ds *Domainscan) updateTime(domainRecordID uint64) error {
	_, err := ds.db.Exec("UPDATE domains_records set modified = NOW() WHERE id = ?", domainRecordID)
	if err != nil {
		fmt.Printf("[E] Error updating time on %d with error: %v\n", domainRecordID, err)
	}

	return err
}

func (ds *Domainscan) updateErrorCount(domainID uint64, ok bool) error {
	var err error
	if ok {
		_, err = ds.db.Exec("UPDATE domains set errors = 0 WHERE id = ?", domainID)
	} else {
		_, err = ds.db.Exec("UPDATE domains set errors = errors + 1 WHERE id = ?", domainID)
	}

	return err
}

func (ds *Domainscan) insertRecord(domainID uint64, mxHost string, MxPref uint16) error {
	_, err := ds.db.Exec("INSERT INTO domains_records SET domain_id = ?, name = ?, value = ?, type = ?, created = NOW(), modified = NOW()", domainID, mxHost, MxPref, "MX")

	if err != nil {
		return err
	}

	_, err = ds.db.Exec("UPDATE domains set new_mx = NOW() WHERE id = ?", domainID)

	return err
}

func (ds *Domainscan) checkForRecord(domainID uint64, domainMx string, domainMxPref uint16) uint64 {
	var id uint64
	ds.db.QueryRow("SELECT id FROM domains_records WHERE domain_id = ? AND name = ? AND value = ?", domainID, domainMx, domainMxPref).Scan(&id)

	if id != 0 {
		return id
	}

	return 0
}

func (ds *Domainscan) connect() *sql.DB {
	var err error
	ds.db, err = sql.Open("mysql", "domainscan:" + mysqlPassword + "N@tcp(db-01.nactum.lan:3306)/domainscan")

	if err != nil {
		log.Fatal(err.Error())
	}

	if err = ds.db.Ping(); err != nil {
		log.Fatal("DB unreachable:", err)
	}

	return ds.db
}

func (ds *Domainscan) mainParser(channel1 chan bool) {
	fmt.Println("Starting Domainscanner...")

	db := ds.connect()
	defer db.Close()
	db.SetMaxOpenConns(50)
	//db.SetMaxIdleConns(2)
	//db.SetConnMaxLifetime(100 * time.Second)

	results, err := db.Query("SELECT id,name,errors FROM domains WHERE errors <= 5 LIMIT 500000")
	if err != nil {
		panic(err.Error()) // proper error handling instead of panic in your app
	}

	defer results.Close()

	for results.Next() {
		var domain domains
		// for each row, scan the result into our tag composite object
		err = results.Scan(&domain.ID, &domain.Name, &domain.Errors)
		if err != nil {
			panic(err.Error()) // proper error handling instead of panic in your app
		}
		// and then print out the tag's Name attribute
		fmt.Printf("[*] DID: %d name: %s errors: %d\n", domain.ID, domain.Name, domain.Errors)
		getMx, err := ds.mx(domain.Name)

		if err != nil {
			// update error count on domain.
			fmt.Printf("[E] DID: %d Error looking up MX for %s updating error count.\n", domain.ID, domain.Name)
			ds.updateErrorCount(domain.ID, false)
		} else {
			ds.updateErrorCount(domain.ID, true)
		}

		for _, mx := range getMx {
			fmt.Printf("[*] DID: %d\tMX: %s Prio: %d Status: ", domain.ID, mx.Host, mx.Pref)
			mxHost := strings.TrimRight(mx.Host, ".")
			domainRecordID := ds.checkForRecord(domain.ID, mxHost, mx.Pref)
			if domainRecordID != 0 {
				fmt.Printf("Found MX in DB, ID: %d.\n", domainRecordID)
				err := ds.updateTime(domainRecordID)
				if err != nil {
					fmt.Printf("[E] DID: %d\t\tFailed to update time for record: %d", domain.ID, domainRecordID)
				}
			} else {
				fmt.Printf("No MX found in DB.\n")
				ds.insertRecord(domain.ID, mxHost, mx.Pref)
			}

		}
	}
	channel1 <- true
}

func main() {
	ds := New()

	channel1 := make(chan bool)

	go ds.mainParser(channel1)

	if <-channel1 {
		fmt.Printf("Done.\n")
	}
}
