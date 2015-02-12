#!/bin/env python
#-*-coding:utf-8-*-

import MySQLdb
import string
import sys 
reload(sys) 
sys.setdefaultencoding('utf8')
import ConfigParser

def get_sessions(conn):
    try:
        curs=conn.cursor()
        curs.execute("select count(*) from v$session");
        result = curs.fetchone()[0]
        return result

    except Exception,e:
        return null    
        print e

    finally:
        curs.close()



def get_actives(conn):
    try:
        curs=conn.cursor()
        curs.execute("select count(*) from v$session where username not in('SYS','SYSTEM') and username is not null and STATUS='ACTIVE'");
        result = curs.fetchone()[0]
        return result

    except Exception,e:
        return null
        print e

    finally:
        curs.close()


def get_waits(conn):
    try:
        curs=conn.cursor()
        curs.execute("select count(1) from processlist where state <> '' and user <> 'repl' and time > 2");
        result = curs.fetchone()[0]
        return result

    except Exception,e:
        return null
        print e

    finally:
        curs.close()


def get_dg_stats(conn):
    try:
        curs=conn.cursor()
        curs.execute("SELECT substr((SUBSTR(VALUE,5)),0,2)*3600 + substr((SUBSTR(VALUE,5)),4,2)*60 + substr((SUBSTR(VALUE,5)),7,2) AS seconds,VALUE FROM v$dataguard_stats a WHERE NAME ='apply lag'");
        list = curs.fetchone()
        if list:
            result = 1
        else:
            result = 0
        return result

    except Exception,e:
        return null
        print e

    finally:
        curs.close()



def get_dg_delay(conn):
    try:
        curs=conn.cursor()
        curs.execute("SELECT substr((SUBSTR(VALUE,5)),0,2)*3600 + substr((SUBSTR(VALUE,5)),4,2)*60 + substr((SUBSTR(VALUE,5)),7,2) AS seconds,VALUE FROM v$dataguard_stats a WHERE NAME ='apply lag'");
        list = curs.fetchone()
        if list:
            result = list[0] 
        else:
            result = '---'
        return result

    except Exception,e:
        return null
        print e

    finally:
        curs.close()
