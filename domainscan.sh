#!/bin/bash

if [ -f /tmp/domainscan.lock ]; then
	echo "already running"
	exit 1
fi
touch /tmp/domainscan.lock

echo "start main job"

/root/domainscan2.pl

echo "exec cronjobs"

mysql -u root -pPASSWORD -e "update domains_records AS DR set DR.vendor_id = (select VM.vendor_id from vendors_mxs as VM where DR.name LIKE CONCAT('%', VM.value));" domainscan

mysql -u root -pPASSWORD -e "update domains_records as DR set DR.vendor_id = 1 where DR.vendor_id IS NULL;" domainscan

mysql -u root -pPASSWORD -e "update domains set vendor_id = IFNULL((select vendor_id from domains_records where domain_id = domains.id order by modified desc limit 1), 1) where id = domains.id;" domainscan

mysql -u root -pPASSWORD -e "insert into stats ( id, date, vendor_id, total_domains) SELECT NULL, NOW(), Vendors.id, (     COUNT(Domains.id)   ) AS `total_domains`  FROM    vendors Vendors    INNER JOIN domains Domains ON Vendors.id = (Domains.vendor_id)  GROUP BY    Domains.vendor_id  ORDER BY    total_domains DESC;" domainscan

#mysql -u root -pPASSWORD -e "delete from domains_records where created < DATE_ADD(DATE(NOW()), INTERVAL -7 DAY);" domainscan

echo "done"

rm /tmp/domainscan.lock
