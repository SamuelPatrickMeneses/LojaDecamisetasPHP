#!/bin/bash

CURENT=$(pwd)
HERE="$( dirname $(readlink -f $0))"

cd $HERE

source ../.env
echo "
CREATE DATABASE IF NOT EXISTS ${DB_NAME};
use ${DB_NAME};
CREATE USER IF NOT EXISTS '${DB_USER}'@'%' IDENTIFIED BY '${DB_PASSWORD}';
GRANT DELETE, INSERT, SELECT, UPDATE ON ${DB_NAME}.* TO '${DB_USER}'@'%';
$(cat ./ddl.sql)
"

cd $CURENT
