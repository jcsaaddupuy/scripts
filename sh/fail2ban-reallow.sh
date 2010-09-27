#!/bin/bash

#A simple script to reallow a blocked IP in fail2ban
#I'am not the author of tis script.

if [ $UID -eq 0 ]
then
 if [ $# -eq 1 ]
 then
	sudo iptables -D fail2ban-SSH -s $1 -j DROP
 else
	echo "You must provide an ip."
 fi
else
 echo "This script must be run by root"
fi
