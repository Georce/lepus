FROM centos:centos6.6

MAINTAINER wujian@wujian360.cn

COPY mariadb.repo /etc/yum.repos.d/mariadb.repo

COPY lepus /lepus

RUN yum install -y httpd php php-mysql gcc libffi-devel python-devel openssl-devel tar MariaDB && rpm -ivh http://yum.mariadb.org/10.0/centos6-amd64/rpms/MariaDB-10.0.16-centos6-x86_64-devel.rpm && yum clean all && rm -rf /var/lib/mysql && cd /lepus/MySQLdb1-master/ && python setup.py build && python setup.py install && cd /lepus/pymongo-2.7/ && python setup.py install && cd /lepus/redis-2.10.3/ && python setup.py install

COPY php /var/www/html

RUN chmod 755 /lepus/python/lepus* && chmod 755 /lepus/run.sh

EXPOSE 3306

EXPOSE 80

CMD ["/lepus/run.sh"]
