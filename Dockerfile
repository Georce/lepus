FROM centos:centos6.6

MAINTAINER wujian@wujian360.cn

COPY mariadb.repo /etc/yum.repos.d/mariadb.repo

COPY lepus /lepus

RUN yum install -y httpd php php-mysql gcc libffi-devel python-devel openssl-devel MariaDB && rpm -ivh http://yum.mariadb.org/10.0/centos6-amd64/rpms/MariaDB-10.0.16-centos6-x86_64-devel.rpm && yum clean all && rm -rf /var/lib/mysql

RUN cd /lepus/MySQLdb1-master/ && python setup.py build && python setup.py install && cd /lepus/pymongo-2.7/ && python setup.py install && cd /lepus/redis-2.10.3/ && python setup.py install

RUN mkdir -p /usr/local/lepus && cp -ap /lepus/python/* /usr/local/lepus/. && chmod 755 /lepus/python/lepus* && chmod 755 /lepus/run.sh

COPY php /var/www/html

CMD ["/lepus/run.sh"]