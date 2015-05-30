#/**
# *
# * ━━━━━━神兽出没━━━━━━
# * 　　　┏┓　　　┏┓
# * 　　┏┛┻━━━┛┻┓
# * 　　┃　　　　　　　┃
# * 　　┃　　　━　　　┃
# * 　　┃　┳┛　┗┳　┃
# * 　　┃　　　　　　　┃
# * 　　┃　　　┻　　　┃
# * 　　┃　　　　　　　┃
# * 　　┗━┓　　　┏━┛Code is far away from bug with the animal protecting
# * 　　　　┃　　　┃    神兽保佑,代码无bug
# * 　　　　┃　　　┃
# * 　　　　┃　　　┗━━━┓
# * 　　　　┃　　　　　　　┣┓
# * 　　　　┃　　　　　　　┏┛
# * 　　　　┗┓┓┏━┳┓┏┛
# * 　　　　　┃┫┫　┃┫┫
# * 　　　　　┗┻┛　┗┻┛
# *
# * ━━━━━━感觉萌萌哒━━━━━━
# */
FROM index.alauda.cn/library/centos:6.6

MAINTAINER wujian@wujian360.cn "Please don't change yourself"

COPY mariadb.repo /etc/yum.repos.d/mariadb.repo

RUN yum install -y httpd php php-mysql gcc libffi-devel python-devel openssl-devel MariaDB MariaDB-devel unzip net-snmp* && yum clean all && rm -rf /var/lib/mysql

COPY lepus /lepus

RUN cd /lepus/MySQLdb1-master/ && python setup.py build && python setup.py install && cd /lepus/pymongo-2.7/ && python setup.py install && cd /lepus/redis-2.10.3/ && python setup.py install

RUN unzip /lepus/Lepus.zip && chmod +x /lepus_v3.7/python/install.sh && chmod +x /lepus/run.sh && cd /lepus_v3.7/python && sh install.sh 

RUN cp -ap /lepus_v3.7/php/* /var/www/html/.

RUN chmod +x /lepus/config.sh && sh /lepus/config.sh

CMD ["/lepus/run.sh"]
