#!/bin/bash

CURENT=$(pwd)
HERE="$( dirname $(readlink -f $0))"

cd $HERE

source ../.env
echo "
DROP DATABASE IF EXISTS ${DB_NAME};
DROP USER IF EXISTS '${DB_USER}'@'php';
"

cd $CURENT
