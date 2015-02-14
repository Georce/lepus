#!/bin/bash
set -e

DB_NAME="lepus"
DB_USER="lepus_user"
DB_PASS="password"

DB_REMOTE_ROOT_NAME=${DB_REMOTE_ROOT_NAME:-}
DB_REMOTE_ROOT_PASS=${DB_REMOTE_ROOT_PASS:-}
DB_REMOTE_ROOT_HOST=${DB_REMOTE_ROOT_HOST:-"172.17.42.1"}

# fix permissions and ownership of /var/lib/mysql
mkdir -p -m 700 /var/lib/mysql
chown -R mysql:mysql /var/lib/mysql

# initialize MySQL data directory
if [ ! -d /var/lib/mysql/mysql ]; then
  echo "Installing database..."
  mysql_install_db --user=mysql >/dev/null 2>&1
  
  # start mysql server
  echo "Starting MySQL server..."
  /usr/bin/mysqld_safe >/dev/null 2>&1 &
  
   # wait for mysql server to start (max 30 seconds)
  timeout=30
  echo -n "Waiting for database server to accept connections"
  while ! /usr/bin/mysqladmin -u root status >/dev/null 2>&1
  do
    timeout=$(($timeout - 1))
    if [ $timeout -eq 0 ]; then
      echo -e "\nCould not connect to database server. Aborting..."
      exit 1
    fi
    echo -n "."
    sleep 1
  done
  echo
  
  /usr/bin/mysqladmin shutdown
fi

# create new user / database
if [ -n "${DB_USER}" -o -n "${DB_NAME}" ]; then
  /usr/bin/mysqld_safe >/dev/null 2>&1 &
  
  # wait for mysql server to start (max 30 seconds)
  timeout=30
  while ! /usr/bin/mysqladmin -u root status >/dev/null 2>&1
  do
    timeout=$(($timeout - 1))
    if [ $timeout -eq 0 ]; then
      echo "Could not connect to mysql server. Aborting..."
      exit 1
    fi
    sleep 1
  done
  
  if [ -n "${DB_NAME}" ]; then
    for db in $(awk -F',' '{for (i = 1 ; i <= NF ; i++) print $i}' <<< "${DB_NAME}"); do
      echo "Creating database \"$db\"..."
	  mysql -e "CREATE DATABASE IF NOT EXISTS \`$db\` DEFAULT CHARACTER SET \`utf8\` COLLATE \`utf8_general_ci\`;"
	  if [ -n "${DB_USER}" ]; then
          echo "Granting access to database \"$db\" for user \"${DB_USER}\"..."
		  mysql -e "GRANT ALL PRIVILEGES ON \`$db\`.* TO '${DB_USER}' IDENTIFIED BY '${DB_PASS}';"
		  mysql -e "GRANT ALL PRIVILEGES ON \`$db\`.* TO '${DB_USER}'@"localhost" IDENTIFIED BY '${DB_PASS}';"
        fi
      done
  fi
  /usr/bin/mysqladmin shutdown
fi

# migrate database
if [ -d /var/lib/mysql/lepus ]; then
  /usr/bin/mysqld_safe >/dev/null 2>&1 &
    
  # wait for mysql server to start (max 30 seconds)
  timeout=30
  while ! /usr/bin/mysqladmin -u root status >/dev/null 2>&1
  do
    timeout=$(($timeout - 1))
    if [ $timeout -eq 0 ]; then
      echo "Could not connect to mysql server. Aborting..."
      exit 1
    fi
    sleep 1
  done
  
	QUERY="SELECT count(*) FROM information_schema.tables WHERE table_schema = 'lepus';"
	COUNT=$(mysql -ss -e "${QUERY}")
	if [ -z "${COUNT}" -o ${COUNT} -eq 0 ]; then
		echo "Setting up Lepus for firstrun. Please be patient, this could take a while..."
		mysql lepus -e "source /lepus/sql/lepus_table.sql"
		sleep 10
		mysql lepus -e "source /lepus/sql/lepus_data.sql"
	fi
	sleep 1
	
	/usr/bin/mysqladmin shutdown
fi

service httpd restart

service mysql restart

lepus start

ping 127.0.0.1 >> /dev/null