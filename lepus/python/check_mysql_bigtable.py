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
from multiprocessing import Process;

def check_mysql_bigtable(host,port,username,password,server_id,tags,bigtable_size):
    try:
        conn=MySQLdb.connect(host=host,user=username,passwd=password,port=int(port),connect_timeout=2,charset='utf8')
        curs=conn.cursor()
        conn.select_db('information_schema')
        try:
           bigtable=curs.execute("SELECT table_schema as 'DB',table_name as 'TABLE',CONCAT(ROUND(( data_length + index_length ) / ( 1024 * 1024 ), 2), '') 'TOTAL' , table_comment as COMMENT FROM information_schema.TABLES ORDER BY data_length + index_length DESC ;");
           if bigtable:
               for row in curs.fetchall():
                   datalist=[]
                   for r in row:
                      datalist.append(r)
                   result=datalist
                   if result:
                       table_size = float(string.atof(result[2]))
                       if table_size >= int(bigtable_size):
                          sql="insert into mysql_bigtable(server_id,host,port,tags,db_name,table_name,table_size,table_comment) values(%s,%s,%s,%s,%s,%s,%s,%s);"
                          param=(server_id,host,port,tags,result[0],result[1],result[2],result[3])
                          func.mysql_exec(sql,param)
        except :
           pass

        finally:
           curs.close()
           conn.close()
           sys.exit(1)

    except MySQLdb.Error,e:
        pass
        print "Mysql Error %d: %s" %(e.args[0],e.args[1])


def main():
    func.mysql_exec("insert into mysql_bigtable_history SELECT *,LEFT(REPLACE(REPLACE(REPLACE(create_time,'-',''),' ',''),':',''),8) from mysql_bigtable",'')
    func.mysql_exec('delete from mysql_bigtable;','')
    #get mysql servers list
    servers = func.mysql_query('select id,host,port,username,password,tags,bigtable_size from db_servers_mysql where is_delete=0 and monitor=1 and bigtable_monitor=1;')
    if servers:
        print("%s: check mysql bigtable controller started." % (time.strftime('%Y-%m-%d %H:%M:%S', time.localtime()),));
        plist = []
        for row in servers:
            server_id=row[0]
            host=row[1]
            port=row[2]
            username=row[3]
            password=row[4]
            tags=row[5]
            bigtable_size=row[6]
            p = Process(target = check_mysql_bigtable, args = (host,port,username,password,server_id,tags,bigtable_size))
            plist.append(p)
        for p in plist:
            p.start()
        time.sleep(15)
        for p in plist:
            p.terminate()
        for p in plist:
            p.join()
        print("%s: check mysql bigtable controller finished." % (time.strftime('%Y-%m-%d %H:%M:%S', time.localtime()),))
                     

if __name__=='__main__':
    main()
