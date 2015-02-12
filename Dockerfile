FROM centos:centos6.6

MAINTAINER wujian@wujian360.cn

COPY mariadb.repo /etc/yum.repos.d/mariadb.repo

COPY MySQLdb1-master /MySQLdb1-master

COPY pymongo-2.7 /pymongo-2.7

COPY redis-2.10.3 /redis-2.10.3

COPY php /var/www/html

COPY python /python

RUN chmod 755 /python/install.sh

RUN yum install -y httpd php php-mysql wget unzip gcc libffi-devel python-devel openssl-devel tar MariaDB

