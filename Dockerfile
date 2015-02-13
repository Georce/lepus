FROM centos:centos6.6

MAINTAINER wujian@wujian360.cn

COPY mariadb.repo /etc/yum.repos.d/mariadb.repo

COPY lepus /lepus

RUN yum install -y httpd php php-mysql unzip gcc libffi-devel python-devel openssl-devel tar MariaDB && yum clean all

cd /lepus/MySQLdb1-master/ && python setup.py build && python setup.py install && cd /lepus/pymongo-2.7/ && python setup.py install && cd /lepus/redis-2.10.3/ && python setup.py install

COPY php /var/www/html

RUN chmod 755 /lepus/python/install.sh && ./lepus/python/install.sh 

EXPOSE 3306

EXPOSE 80

CMD ["/lepus/run.sh"]