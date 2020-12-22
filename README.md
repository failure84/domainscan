[![License: GPL v3](https://img.shields.io/badge/License-GPL%20v3-yellow.svg)](https://www.gnu.org/licenses/gpl-3.0)
[![Code: Perl](https://img.shields.io/badge/Code-Perl-green.svg?style=flat)](http://www.perl.org)
[![Code: PHP](https://img.shields.io/badge/Code-PHP-green.svg?style=flat)](http://www.php.net)
[![Code: Go](https://img.shields.io/badge/Code-Go-green.svg?style=flat)](https://golang.org)

[![Code: R](https://img.shields.io/badge/Code-R-green.svg?style=flat)](https://www.r-project.org)
[![Framework: GGPlot2](https://img.shields.io/badge/Framework-GGPlot2-blue.svg?style=flat)](http://ggplot2.org)
[![Framework: CakePHP](https://img.shields.io/badge/Framework-CakePHP-blue.svg?style=flat)](http://cakephp.org)

```
██████╗  ██████╗ ███╗   ███╗ █████╗ ██╗███╗   ██╗███████╗ ██████╗ █████╗ ███╗   ██╗.   
██╔══██╗██╔═══██╗████╗ ████║██╔══██╗██║████╗  ██║██╔════╝██╔════╝██╔══██╗████╗  ██║.   
██║  ██║██║   ██║██╔████╔██║███████║██║██╔██╗ ██║███████╗██║     ███████║██╔██╗ ██║.    
██║  ██║██║   ██║██║╚██╔╝██║██╔══██║██║██║╚██╗██║╚════██║██║     ██╔══██║██║╚██╗██║.   
██████╔╝╚██████╔╝██║ ╚═╝ ██║██║  ██║██║██║ ╚████║███████║╚██████╗██║  ██║██║ ╚████║.   
╚═════╝  ╚═════╝ ╚═╝     ╚═╝╚═╝  ╚═╝╚═╝╚═╝  ╚═══╝╚══════╝ ╚═════╝╚═╝  ╚═╝╚═╝  ╚═══╝.    
```                                                                                 

Collecting historical data about domains.

This is a service not a right.

GPL

# DB config
```
CREATE DATABASE `domainscan`

CREATE TABLE `domains` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `errors` int(10) unsigned NOT NULL DEFAULT '0',
  `new_mx` datetime DEFAULT NULL,
  `vendor_id` int(11) NOT NULL DEFAULT '1',
  `note` varchar(128) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `idx_name_vendor` (`name`,`vendor_id`),
  KEY `idx_vendor_id` (`vendor_id`),
  KEY `idx_id_name_errors` (`id`,`name`,`errors`)
) ENGINE=InnoDB AUTO_INCREMENT=12317138 DEFAULT CHARSET=latin1

domains_records | CREATE TABLE `domains_records` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `domain_id` int(11) NOT NULL,
  `vendor_id` int(11) DEFAULT '1',
  `name` varchar(255) DEFAULT NULL,
  `value` int(11) DEFAULT NULL,
  `type` varchar(6) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_name` (`domain_id`,`name`,`value`),
  KEY `domain_id` (`domain_id`),
  KEY `vendor_id` (`vendor_id`)
) ENGINE=InnoDB AUTO_INCREMENT=36471248 DEFAULT CHARSET=latin1

users | CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(20) DEFAULT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1

vendors | CREATE TABLE `vendors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `comment` text NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=latin1

vendors_mxs | CREATE TABLE `vendors_mxs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vendor_id` int(11) NOT NULL,
  `value` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `value` (`value`),
  KEY `idx_vendor_id` (`vendor_id`)
) ENGINE=InnoDB AUTO_INCREMENT=106 DEFAULT CHARSET=latin1

CREATE TABLE `stats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `vendor_id` int(11) NOT NULL,
  `total_domains` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=latin1
```
