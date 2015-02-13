#!/usr/bin/python
#coding:utf-8
import os
import sys
import string
import pymongo
import random

host='219.234.6.180'
port=27017
user='tt_monitor'
passwd='tt_monitor'
dbname='admin'

try:
    connect = pymongo.Connection(host,int(port))
    db = connect[dbname]
    db.authenticate(user,passwd)
    print "MongoDB server connect success!"

except Exception, e:
    print e
    sys.exit(1)

finally:
    sys.exit(1)

