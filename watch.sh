#!/bin/sh

while [ true ]; do
	php parse.php getspreads >> spreads.txt
	echo >> spreads.txt
	sleep 10
done
