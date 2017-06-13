#!/usr/bin/perl

use strict;
use warnings;

use DBI;
use DBD::mysql;
use Net::DNS;
use Parallel::ForkManager;

my $res   = Net::DNS::Resolver->new;
my $MAX_PROCESSES = 40;

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
}

my $pm = new Parallel::ForkManager($MAX_PROCESSES);
my $sth = $dbh->prepare("SELECT id,name,errors FROM domains WHERE errors < 5 ORDER BY RAND() limit 4000000");
$sth->execute();
while (my $ref = $sth->fetchrow_hashref) {
	# run jobs in pararell
	my $pid = $pm->start and next;
	my $dsn = "DBI:mysql:database=$database;host=$hostname;port=$port";

	my $dbh = DBI->connect($dsn, $username, $password);
	#$dbh->trace(2);

	if ($dbh) {
		#print "Connected to MySQL at $hostname.\n";
	}
	else {
		#print "Unable to connect to MySQL at $hostname.\n";
		next;
	}

	my $insert_records = $dbh->prepare("INSERT INTO domains_records SET domain_id = ?, name = ?, value = ?, type = ?, created = NOW(), modified = NOW()");
	my $check_for_record = $dbh->prepare("SELECT id FROM domains_records WHERE domain_id = ? AND name = ? AND value = ? AND type = ?");

	print "Found a row: id = $ref->{'id'}, name = $ref->{'name'} ";
	my @mx = mx($res, $ref->{'name'});
	if (!@mx) {
		print " ERROR ";
		$dbh->do("UPDATE domains set errors = errors + 1 WHERE id = $ref->{'id'}");
	} else {
		print "FOUND MX ";
		foreach my $mx (@mx) {
			print $mx->preference . " " . $mx->exchange;

			# kolla här om record redan finns.
			$check_for_record->execute($ref->{'id'}, $mx->exchange, $mx->preference, 'MX');

			my $domains_records_id = 0;
			my @domains_records_id = $check_for_record->fetchrow_array();
			if ($domains_records_id[0]) {
				$domains_records_id += $domains_records_id[0];
			}
			print " DomainsRecords ID: " . $domains_records_id . " ";
			$check_for_record->finish();

			if ($domains_records_id gt 0) {
				# updatera modified till NOW.
				print "Record already exists";
				$dbh->do("UPDATE domains_records set modified = NOW() WHERE id = $domains_records_id");

				# Only do this if there is an error.
				if ($ref->{'errors'} gt 0) {
					$dbh->do("UPDATE domains set errors = 0 WHERE id = $ref->{'id'}");
				}
			} else {
				# annars stoppa in det.
				print "New MX record found, update domains and tell it we have a new_mx";
				$insert_records->execute($ref->{'id'}, $mx->exchange, $mx->preference, 'MX');
				$dbh->do("UPDATE domains set errors = 0, new_mx = NOW() WHERE id = $ref->{'id'}");
			}
		}
	}
	print "\n";
	$dbh->disconnect();
	$pm->finish; # Terminates the child process
	#last;
}
$pm->wait_all_children();
$sth->finish();
$dbh->disconnect();
