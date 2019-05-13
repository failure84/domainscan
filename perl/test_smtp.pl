#!/usr/bin/perl -w

use Net::SMTP;

$smtp = Net::SMTP->new('eternity.nactum.net');
print "smtp banner: ", $smtp->banner,"\n";
$smtp->quit;

