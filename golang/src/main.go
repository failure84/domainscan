package main

import (
	"database/sql"
	"fmt"
	"log"
	"net"
	"os"
	"strings"
	"time"

	_ "github.com/go-sql-driver/mysql"
)

var mysqlPassword string

// Domainscaner interface
type Domainscaner interface {
	mx(string) ([]*net.MX, error)
	iplookup(string) ([]net.IP, error)
	checkForRecord(int, string, uint16) int
	updateTime(int) error
	insertRecord(int, string, uint16) error
	connect() *sql.DB
	mainParser(int, int, int, chan int)
}

// Domainscan interface
type Domainscan struct {
	db *sql.DB
}

// Domain mysql structure
type domains struct {
	ID     int    `json:"id"`
	Name   string `json:"name"`
	Errors uint16 `json:"errors"`
}

// New object
func New() Domainscaner {
	return &Domainscan{}
}

func (ds *Domainscan) mx(domain string) ([]*net.MX, error) {
	mx, err := net.LookupMX(domain)

	return mx, err
}

func (ds *Domainscan) iplookup(domain string) ([]net.IP, error) {
	ip, err := net.LookupIP(domain)
	return ip, err
}

func (ds *Domainscan) updateTime(domainRecordID int) error {
	_, err := ds.db.Exec("UPDATE domains_records set modified = NOW() WHERE id = ?", domainRecordID)

	return err
}

func (ds *Domainscan) updateErrorCount(domainID int, ok bool) error {
	var err error
	if ok {
		_, err = ds.db.Exec("UPDATE domains set errors = 0 WHERE id = ?", domainID)
	} else {
		_, err = ds.db.Exec("UPDATE domains set errors = errors + 1 WHERE id = ?", domainID)
	}

	return err
}

func (ds *Domainscan) insertRecord(domainID int, mxHost string, MxPref uint16) error {
	_, err := ds.db.Exec("INSERT INTO domains_records SET domain_id = ?, name = ?, value = ?, type = ?, created = NOW(), modified = NOW()", domainID, mxHost, MxPref, "MX")

	if err != nil {
		return err
	}

	_, err = ds.db.Exec("UPDATE domains set new_mx = NOW() WHERE id = ?", domainID)

	return err
}

func (ds *Domainscan) checkForRecord(domainID int, domainMx string, domainMxPref uint16) int {
	var id int
	ds.db.QueryRow("SELECT id FROM domains_records WHERE domain_id = ? AND name = ? AND value = ?", domainID, domainMx, domainMxPref).Scan(&id)

	if id != 0 {
		return id
	}

	return 0
}

func (ds *Domainscan) connect() *sql.DB {
	var err error
	ds.db, err = sql.Open("mysql", "domainscan:"+mysqlPassword+"@tcp(db-01.nactum.lan:3306)/domainscan")

	if err != nil {
		log.Fatal(err.Error())
	}

	if err = ds.db.Ping(); err != nil {
		log.Fatal("DB unreachable:", err)
	}

	return ds.db
}

func (ds *Domainscan) mainParser(cpu int, limit1 int, limit2 int, c chan int) {
	fmt.Println("Starting Domainscanner...")

	db := ds.connect()
	defer db.Close()
	db.SetMaxOpenConns(50)
	db.SetMaxIdleConns(0)
	db.SetConnMaxLifetime(10 * time.Second)

	results, err := db.Query("SELECT id,name,errors FROM domains WHERE errors <= 5 LIMIT ?, ?", limit1, limit2)
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
		fmt.Printf("[%d] DID: %d name: %s errors: %d\n", cpu, domain.ID, domain.Name, domain.Errors)
		getMx, err := ds.mx(domain.Name)

		if err != nil {
			// update error count on domain.
			fmt.Printf("[E] DID: %d Error looking up MX for %s updating error count.\n", domain.ID, domain.Name)
			ds.updateErrorCount(domain.ID, false)
		} else {
			ds.updateErrorCount(domain.ID, true)
		}

		for _, mx := range getMx {
			mxHost := strings.TrimRight(mx.Host, ".")
			domainRecordID := ds.checkForRecord(domain.ID, mxHost, mx.Pref)
			if domainRecordID != 0 {
				fmt.Printf("[%d] DID: %d\tMX: %s Prio: %d Status: OldMX, ID: %d.\n", cpu, domain.ID, mx.Host, mx.Pref, domainRecordID)
				err := ds.updateTime(domainRecordID)
				if err != nil {
					fmt.Printf("[E] DID: %d\t\tFailed to update time for record: %d", domain.ID, domainRecordID)
				}
			} else {
				fmt.Printf("[%d] DID: %d\tMX: %s Prio: %d Status: NewMX.\n", cpu, domain.ID, mx.Host, mx.Pref)
				ds.insertRecord(domain.ID, mxHost, mx.Pref)
			}

		}
	}
	c <- 1 // signal that this piece is done
}

func main() {
	// How many CPU do you have?
	const numCPU = 8
	// This is where we define how many records per run on x cores of cpu
	const Reruns = 1500

	// Make Channels
	c := make(chan int, numCPU)

	// Calculate base.
	base := (13000000 / numCPU) / Reruns

	// set roof and floor to zero
	roof := 0
	floor := 0

	// The Object.
	ds := New()

	for o := 0; o < int(Reruns); o++ {
		for i := 0; i < numCPU; i++ {
			roof = roof + base
			diff := roof - floor
			fmt.Fprintf(os.Stderr, "Run: %d CPU: %d: %d - %d diff: %d base: %d\n", o, i, floor, roof, diff, base)
			go ds.mainParser(i, floor, roof, c)
			floor = floor + base

		}
		for w := 0; w < numCPU; w++ {
			<-c // wait for one task to complete
			fmt.Printf("CPU: %d is done.\n", w)
		}
	}
}
