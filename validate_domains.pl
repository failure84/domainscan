#!/usr/bin/perl

use Data::Validate::Domain qw(is_domain);

while (my $line = <STDIN>)
{
	chomp $line;
	my $suspect = $line;
	print "Domain $suspect is ";
	my $test = is_domain($suspect);
	if ($test) {
		print "Valid.\n";
	} else {
		print "Invalid.\n";
	}
}
