#!/bin/env python
#-*-coding:utf-8-*-
import os
import sys
import string
import time
import datetime
import MySQLdb

class MySQL:
    def __int__(self,host,port,user,passwd,dbname,timeout,charset):
        self.host = host
        self.port = port
        self.user = user
        self.passwd = passwd
        self.dbname = test
        self.timeout = timeout
        self.charset = charset

    def db_connect(self):
        connect=MySQLdb.connect(host=self.host,user=self.user,passwd=self.passwd,port=int(self.port),connect_timeout=int(self.timeout),charset=self.charset)
        return connect


    def execute(self,sql,param):
        conn=MySQLdb.connect(host=self.host,user=self.user,passwd=self.passwd,port=int(self.port),connect_timeout=int(self.timeout),charset=self.charset)
        conn.select_db(self.dbname)
        cursor = conn.cursor()
        if param <> '':
            cursor.execute(sql,param)
        else:
            cursor.execute(sql)
        conn.commit()
        cursor.close()
        conn.close()

    def query(self,sql):
        conn=MySQLdb.connect(host=self.host,user=self.user,passwd=self.passwd,port=int(self.port),connect_timeout=int(self.timeout),charset=self.charset)
        conn.select_db(self.dbname)
        cursor = conn.cursor()
        count=cursor.execute(sql)
        if count == 0 :
            result=0
        else:
            result=cursor.fetchall()
        return result
        cursor.close()
        conn.close()

    def get_option(self,key):
        conn=MySQLdb.connect(host=self.host,user=self.user,passwd=self.passwd,port=int(self.port),connect_timeout=int(self.timeout),charset=self.charset)
        conn.select_db(self.dbname)
        cursor = conn.cursor()
        sql="select value from options where name=+'"+key+"'"
        count=cursor.execute(sql)
        if count == 0 :
            result=0
        else:
            result=cursor.fetchone()
        return result[0]
        cursor.close()
        conn.close() 


