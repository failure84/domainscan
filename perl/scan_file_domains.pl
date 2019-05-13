#!/usr/bin/perl

use strict;
use warnings;

use DBI;
use DBD::mysql;
use Net::DNS;
use Parallel::ForkManager;
use Data::Validate::Domain qw(is_domain);

my $res   = Net::DNS::Resolver->new;
my $MAX_PROCESSES = 50;

my $database = 'domainscan';
my $hostname = 'localhost';
my $port = 3306;
my $username = 'domainscan';
my $password = 'PASSWORD';

my $dsn = "DBI:mysql:database=$database;host=$hostname;port=$port";

my $dbh = DBI->connect($dsn, $username, $password);

if ($dbh) {
        print "Connected to MySQL at $hostname.\n";
}
else {
        print "Unable to connect to MySQL at $hostname.\n";
	exit(1);
}

my $pm = new Parallel::ForkManager($MAX_PROCESSES);


while (my $line = <STDIN>) {
        chomp $line;
	my $pid = $pm->start and next;

        my $suspect = $line;
        my $test = is_domain($suspect);

        print "Domain: $suspect is ";
        if ($test) {
                print "VALID, ";
		my $dsn = "DBI:mysql:database=$database;host=$hostname;port=$port";

		my $dbh = DBI->connect($dsn, $username, $password);

		if ($dbh) {
			#print "Connected to MySQL at $hostname.\n";
		}
		else {
			#print "Unable to connect to MySQL at $hostname.\n";
			exit(1);
		}

		my $look_for_domain = $dbh->prepare('select id from domains where name = ?');
		$look_for_domain->execute($line);
		
		my $domains_id = 0;
		my @domains_id = $look_for_domain->fetchrow_array();
		if ($domains_id[0]) {
			$domains_id += $domains_id[0];
			print "found in the DB ($domains_id)\n";
		} else {
			print "is new, ";

			my $insert_records = $dbh->prepare("INSERT IGNORE INTO domains SET name = ?, created = NOW(), modified = NOW()");
			my @mx = mx($res, $line);
			if (!@mx) {
				printf "NO MX FOUND\n";
			} else {
				printf "MX FOUND: ";
				if($insert_records->execute($line)) {
					printf "(INSERT OK)\n";
				} else {
					printf "(INSERT NOT OK)\n";
				}
				$insert_records->finish();
			}
		}
        } else {
                print "INVALID.\n";
        }
	$pm->finish; # Terminates the child process
}
$pm->wait_all_children();
$dbh->disconnect();
