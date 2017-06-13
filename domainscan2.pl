#!/usr/bin/perl

use strict;
use warnings;

# Modules
use DBI;
use DBD::mysql;
use Net::DNS;
use Parallel::ForkManager;

# Variables
my $MAX_PROCESSES = 50;
my $VERSION = '2.0';
my $DEBUG = 0;

my $Limit = 8000000;
my $StartTime = time;

# STATS
my $stats_new = 0;
my $stats_old = 0;
my $stats_error = 0;

# Hello message
print "Start Domainscan (v" . $VERSION . ") " . localtime() . "\n";
print "Written by Patrik Båt <patrik.bat\@nactum.se>\n";

# MySQL
my $database = 'domainscan';
my $hostname = 'localhost';
my $port = 3306;
my $username = 'domainscan';
my $password = 'PASSWORD';
my $dsn = "DBI:mysql:database=$database;host=$hostname;port=$port";
my $dbh = DBI->connect($dsn, $username, $password)
	or die "Unable to connect to MySQL at $hostname.\n";
my $domains = $dbh->prepare("SELECT id,name,errors FROM domains WHERE errors < 5 ORDER BY RAND() LIMIT $Limit"); # domains list

# constructs
my $lookup = Net::DNS::Resolver->new;
my $pm = new Parallel::ForkManager($MAX_PROCESSES, '/tmp/');

# Functions
sub insert_records($$$$) {
	# insert domains_records
	my ($domain_id, $name, $value, $type) = @_; 

	my $dbh = DBI->connect($dsn, $username, $password) or die; 
	my $insert = $dbh->prepare('INSERT INTO domains_records SET domain_id = ?, name = ?, value = ?, type = ?, created = NOW(), modified = NOW()');
	my $status = $insert->execute($domain_id, $name, $value, $type)
		or die $dbh->errstr;
	$insert->finish();
	$dbh->disconnect();
	return $status;
}

sub check_for_record($$$$) {
	# search for the same domains_records
	my ($domain_id, $name, $value, $type) = @_;

	my $dbh = DBI->connect($dsn, $username, $password) or die; 
	my $select = $dbh->prepare("SELECT id FROM domains_records WHERE domain_id = ? AND name = ? AND value = ? AND type = ?");
	$select->execute($domain_id, $name, $value, $type)
		or die $dbh->errstr;

	my $domains_records_id = 0;
	my @domains_records_id = $select->fetchrow_array();
	if ($domains_records_id[0]) {
		$domains_records_id += $domains_records_id[0];
	}
	$select->finish();
	return $domains_records_id;
}

sub dns_error($$) {
	# How to set error count or clear errors
	my ($id, $clear) = @_;
	# clear, 1 = set errors to 0
	# clear, 0 = error + 1
	my $status;

	my $dbh = DBI->connect($dsn, $username, $password) or die; 
	if ($clear) {
		$status = $dbh->do("UPDATE domains set errors = 0 WHERE id = $id")
			or die $dbh->errstr;
	} else {
		$status = $dbh->do("UPDATE domains set errors = errors + 1 WHERE id = $id")
			or die $dbh->errstr;
	}
	$dbh->disconnect();
	return $status;
}

sub new_mx($) {
	# tell domains we have a new MX
	my $id = shift;

	my $dbh = DBI->connect($dsn, $username, $password) or die; 
	my $status = $dbh->do("UPDATE domains set errors = 0, new_mx = NOW() WHERE id = $id")
		or die $dbh->errstr;

	$dbh->disconnect();
	return $status;
}

sub update_current_time($) {
	# update modified to NOW for domains_records
	my $domains_records_id = shift;

	my $dbh = DBI->connect($dsn, $username, $password) or die;
	my $status = $dbh->do("UPDATE domains_records set modified = NOW() WHERE id = $domains_records_id")
		or die $dbh->errstr;

	$dbh->disconnect();
	return $status;
}

$pm->run_on_start( sub {
	my ($pid, $ident)=@_;
	print "** $ident started, pid: $pid, time: " . time . "\n";
});

$pm->run_on_finish( sub {
 my ($pid, $exit_code, $ident, $exit_signal, $core_dump, $data_structure_reference) = @_;

      # retrieve data structure from child
      if (defined($data_structure_reference)) {  # children are not forced to send anything
        my $string = ${$data_structure_reference};  # child passed a string reference
	my ($child_stats_new, $child_stats_old, $child_stats_error) = split /,/, $string;
	$stats_new = $stats_new + $child_stats_new;
	$stats_old = $stats_old + $child_stats_old;
	$stats_error = $stats_error + $child_stats_error;
      }
      else {  # problems occurring during storage or retrieval will throw a warning
        print qq|No message received from child process $pid!\n|;
      }
});

# fetch domains
$domains->execute()
		or die $dbh->errstr;

print "Start MainParser and fork.\n";
DOMAINSCAN:
while (my $domain = $domains->fetchrow_hashref) {
	# run jobs in pararell
	my $pid = $pm->start($domain->{'name'}) and next DOMAINSCAN;
	my $child_start = time;

	# STATS
	my $child_stats_new = 0;
	my $child_stats_old = 0;
	my $child_stats_error = 0;

	# print info
	print " ** $domain->{'name'}, id: ($domain->{'id'}), mx: ";

	# do MX lookup
	my @mx = mx($lookup, $domain->{'name'});
	if (!@mx) {
		# no MX found
		$child_stats_error++;
		print "mx lookup error ";
		dns_error($domain->{'id'}, 0);
	} else {
		# MX found
		print "found mx, DRI: ( ";
		foreach my $mx (@mx) {
			# loop thru all MXes

			# check if there is already a record.
			my $domains_records_id = check_for_record($domain->{'id'}, $mx->exchange, $mx->preference, 'MX');
			if ($domains_records_id gt 0) {
				# if it exists update modifed to NOW
				$child_stats_old++;
				print "old(" . $domains_records_id . ") ";
				update_current_time($domains_records_id);

				if ($domain->{'errors'} gt 0) {
					# if there was an error before lets clear the error count
					dns_error($domain->{'id'}, 1);
				}
			} else {
				$child_stats_new++;
				# if it dosnt exists insert it and tell domains that it has a new MX
				print "new(" . $domains_records_id . ") ";
				insert_records($domain->{'id'}, $mx->exchange, $mx->preference, 'MX');
				new_mx($domain->{'id'}); 
			}
		}
		print ") ";
	}
	# runtime
	my $child_end = time;
	my $runtime = $child_end - $child_start;
	print "runtime: " . $runtime . "\n";

	# print stats
	my $stats = "$child_stats_new,$child_stats_old,$stats_error";
	$pm->finish(0, \$stats); # Terminates the child process
}
# wait for all the cildren
$pm->wait_all_children();

# end
$domains->finish();
$dbh->disconnect();

# STATS
print "\nSTATS: new: " . $stats_new . ", old: " . $stats_old . ", error: " . $stats_error . "\n";

# print how long time we runned the script
my $ElapsedTime = time - $StartTime;
print "Elapsed Time: " . $ElapsedTime . "s\n";
print "Done Domainscan (v" . $VERSION . ") " . localtime() . "\n";
