#!/bin/sh
# allday 23:59 SchoolAttendTable update
mysql -u root -proot<<EOF
update Users.SchoolAttendTable set Type=1,Checking=2 where Type=0 and Checking=0;
EOF
