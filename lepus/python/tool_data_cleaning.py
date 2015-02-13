#!/usr/bin/env python
#coding:utf-8
import os
import sys
import string
import time
import datetime
import MySQLdb
path='./include'
sys.path.insert(0,path)
import functions as func


def main():
    try:
        func.mysql_exec('delete from alarm_history;','')
    
    except Exception, e:
        print e
        sys.exit(1)

    finally:
        sys.exit(1)


if __name__=='__main__':
    main()
