#!/bin/sh

cat *.sql > temp.sql
mysql -p dev_picks < temp.sql
rm temp.sql
