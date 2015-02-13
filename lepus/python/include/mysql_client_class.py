#!/bin/env python
#-*-coding:utf-8-*-
import os
import sys
import string
import time
import datetime
import MySQLdb

class MySQL:
    def __int__(self,host,port,user,passwd,timeout,charset):
        self.host = host
        self.port = port
        self.user = user
        self.passwd = passwd
        self.timeout = timeout
        self.charset = charset

    def db_connect(self,host,port,user,passwd,timeout):
        connect=MySQLdb.connect(host=host,user=user,passwd=passwd,port=int(port),connect_timeout=int(timeout),charset='utf8')
        return connect

    def flush_hosts(self,cursor):
        cursor.execute('flush hosts;');

    def get_mysql_status(self,cursor):
        data=cursor.execute('show global status;');
        data_list=cursor.fetchall()
        data_dict={}
        for item in data_list:
            data_dict[item[0]] = item[1]
        return data_dict

    def get_mysql_variables(self,cursor):
        data=cursor.execute('show global variables;');
        data_list=cursor.fetchall()
        data_dict={}
        for item in data_list:
            data_dict[item[0]] = item[1]
        return data_dict

    def get_mysql_version(self,cursor):
        cursor.execute('select version();');
        return cursor.fetchone()[0]


