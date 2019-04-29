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
	getMaxID() int
	updateTime(int) error
	insertRecord(int, string, uint16) error
	connect() *sql.DB
	mainParser(int, int, int, int, chan int)
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

func (ds *Domainscan) getMaxID() int {
	var id int
	ds.db.QueryRow("SELECT MAX(id) FROM domains").Scan(&id)

	return id
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

// not a pointer need a object per thread.
func (ds *Domainscan) mainParser(run int, cpu int, limit1 int, limit2 int, c chan int) {
	results, err := ds.db.Query("SELECT id,name,errors FROM domains WHERE errors <= 5 AND id BETWEEN ? AND ?", limit1, limit2)

	if err != nil {
		log.Fatal(err.Error())
	}

	//	defer results.Close()

	for results.Next() {
		//time.Sleep(500 * time.Millisecond)
		var domain domains
		// for each row, scan the result into our tag composite object
		err = results.Scan(&domain.ID, &domain.Name, &domain.Errors)
		if err != nil {
			panic(err.Error()) // proper error handling instead of panic in your app
		}
		// and then print out the tag's Name attribute
		// fmt.Printf("[%d] DID: %d name: %s errors: %d\n", cpu, domain.ID, domain.Name, domain.Errors)
		getMx, err := ds.mx(domain.Name)

		if err != nil {
			// update error count on domain.
			fmt.Printf("[%d:%d:%d] %s: Error looking up MX, updating error count.\n", run, cpu, domain.ID, domain.Name)
			ds.updateErrorCount(domain.ID, false)
		} else {
			ds.updateErrorCount(domain.ID, true)
		}

		for _, mx := range getMx {
			mxHost := strings.TrimRight(mx.Host, ".")
			domainRecordID := ds.checkForRecord(domain.ID, mxHost, mx.Pref)
			if domainRecordID != 0 {
				fmt.Printf("[%d:%d:%d] %s:\tMX: %s Prio: %d Status: OldMX, ID: %d.\n", run, cpu, domain.ID, domain.Name, mx.Host, mx.Pref, domainRecordID)
				err := ds.updateTime(domainRecordID)
				if err != nil {
					fmt.Fprintf(os.Stderr, "[%d:%d:%d] Error updating record for %s, err: %v\n", run, cpu, domain.ID, domain.Name, err)
					//return
				}
			} else {
				fmt.Printf("[%d:%d:%d] %s:\tMX: %s Prio: %d Status: NewMX.\n", run, cpu, domain.ID, domain.Name, mx.Host, mx.Pref)
				err := ds.insertRecord(domain.ID, mxHost, mx.Pref)
				if err != nil {
					fmt.Fprintf(os.Stderr, "[%d:%d:%d] Error inserting record for %s, err: %v\n", run, cpu, domain.ID, domain.Name, err)
					//return
				}
			}

		}
	}
	c <- cpu // signal that this piece is done
}

func printLogo() {
	fmt.Fprint(os.Stderr, "  ______   _______  __   __  _______  ___   __    _  _______  _______  _______  __    _\n")
	fmt.Fprint(os.Stderr, " |      | |       ||  |_|  ||   _   ||   | |  |  | ||       ||       ||   _   ||  |  | |\n")
	fmt.Fprint(os.Stderr, " |  _    ||   _   ||       ||  |_|  ||   | |   |_| ||  _____||       ||  |_|  ||   |_| |\n")
	fmt.Fprint(os.Stderr, " | | |   ||  | |  ||       ||       ||   | |       || |_____ |       ||       ||       |\n")
	fmt.Fprint(os.Stderr, " | |_|   ||  |_|  ||       ||       ||   | |  _    ||_____  ||      _||       ||  _    |\n")
	fmt.Fprint(os.Stderr, " |       ||       || ||_|| ||   _   ||   | | | |   | _____| ||     |_ |   _   || | |   |\n")
	fmt.Fprint(os.Stderr, " |______| |_______||_|   |_||__| |__||___| |_|  |__||_______||_______||__| |__||_|  |__|\n\n")
}

func main() {
	const numCPU = 8
	roof := 0
	floor := 1
	ds := New()
	c := make(chan int, numCPU)
	// This is where we define how many records per run on x cores of cpu
	Reruns := 300
	dbMax := ds.connect()
	maxID := ds.getMaxID()
	dbMax.Close()
	base := (maxID / numCPU) / Reruns
	diff := base - floor
	printLogo()
	fmt.Fprintf(os.Stderr, "MySQL Password: %s\n", mysqlPassword)
	fmt.Fprintf(os.Stderr, "Runs per CPU: %d MaxID: %d\n", diff, maxID)
	for run := 0; run < Reruns; run++ {
		db := ds.connect()
		db.SetMaxOpenConns(500)
		db.SetMaxIdleConns(10)
		db.SetConnMaxLifetime(60 * time.Second)

		defer db.Close()

		for startCPU := 0; startCPU < numCPU; startCPU++ {
			roof = roof + base
			fmt.Fprintf(os.Stderr, "RUN: %d CPU: %d Starting at: %v (%d - %d)\n", run, startCPU, time.Now().Format(time.UnixDate), floor, roof)
			go ds.mainParser(run, startCPU, floor, roof, c)
			floor = floor + base

		}
		for areWeDone := 0; areWeDone < numCPU; areWeDone++ {
			doneCPU := <-c // wait for one task to complete
			fmt.Fprintf(os.Stderr, "RUN: %d CPU: %d Scanned: %d at: %v\n", run, doneCPU, diff, time.Now().Format(time.UnixDate))
		}
	}
}

// END
