#!//bin/env python
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
from multiprocessing import Process;


def admin_mysql_purge_binlog(host,port,user,passwd,binlog_store_days):
    datalist=[]
    try:
        connect=MySQLdb.connect(host=host,user=user,passwd=passwd,port=int(port),connect_timeout=2,charset='utf8')
        cur=connect.cursor()
        connect.select_db('information_schema')
        master_thread=cur.execute("select * from information_schema.processlist where COMMAND = 'Binlog Dump';")
        datalist=[]
        if master_thread >= 1:
            now=datetime.datetime.now()
            delta=datetime.timedelta(days=binlog_store_days)
            n_days=now-delta
            before_n_days= n_days.strftime('%Y-%m-%d %H:%M:%S')
	    cur.execute("purge binary logs before  '%s'" %(before_n_days));
            print  ("mysql %s:%s binlog been purge" %(host,port) )

    except MySQLdb.Error,e:
        pass
        print "Mysql Error %d: %s" %(e.args[0],e.args[1])


def main():

    user = func.get_config('mysql_db','username')
    passwd = func.get_config('mysql_db','password')
    servers=func.mysql_query("select host,port,binlog_store_days from db_servers_mysql where is_delete=0 and monitor=1 and binlog_auto_purge=1;")
    if servers:
         print("%s: admin mysql purge binlog controller started." % (time.strftime('%Y-%m-%d %H:%M:%S', time.localtime()),));
         plist = []
         for row in servers:
             host=row[0]
             port=row[1]
             binlog_store_days=row[2]
             p = Process(target = admin_mysql_purge_binlog, args = (host,port,user,passwd,binlog_store_days))
             plist.append(p)
         for p in plist:
             p.start()
         time.sleep(60)
         for p in plist:
             p.terminate()
         for p in plist:
             p.join()
         print("%s: admin mysql purge binlog controller finished." % (time.strftime('%Y-%m-%d %H:%M:%S', time.localtime()),))


if __name__=='__main__':
    main()
