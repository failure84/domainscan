#!/bin/bash
if [ -f /tmp/domainscan.lock ]; then
        echo "already running"
        exit 1
fi
touch /tmp/domainscan.lock

Date="$(date +%Y%m%d)"
./golang/bin/domainscan 2>./log/domainscan_${Date}_debug.log >./log/domainscan_${Date}.log
./scripts/domainscan_local.sh

gzip ./log/domainscan_${Date}_debug.log
gzip ./log/domainscan_${Date}.log

rm /tmp/domainscan.lock
