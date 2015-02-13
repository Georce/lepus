#!/bin/env python
#-*-coding:utf-8-*-
import os
import sys
import string
import time
import datetime
import MySQLdb
import logging
import logging.config
logging.config.fileConfig("etc/logger.ini")
logger = logging.getLogger("lepus")
path='./include'
sys.path.insert(0,path)
import functions as func
import sendmail
import sendsms_fx
import sendsms_api

send_mail_max_count = func.get_option('send_mail_max_count')
send_mail_sleep_time = func.get_option('send_mail_sleep_time')
mail_to_list_common = func.get_option('send_mail_to_list')

send_sms_max_count = func.get_option('send_sms_max_count')
send_mail_sleep_time = func.get_option('send_mail_sleep_time')
send_sms_sleep_time = func.get_option('send_sms_sleep_time')
sms_to_list_common = func.get_option('send_sms_to_list')

def get_alarm_mysql_status():
    sql="select a.server_id,a.connect,a.threads_connected,a.threads_running,a.threads_waits,a.create_time,a.host,a.port,b.alarm_threads_connected,b.alarm_threads_running,alarm_threads_waits,b.threshold_warning_threads_connected,b.threshold_critical_threads_connected,b.threshold_warning_threads_running,b.threshold_critical_threads_running,threshold_warning_threads_waits,threshold_critical_threads_waits,b.send_mail,b.send_mail_to_list,b.send_sms,b.send_sms_to_list,b.tags,'mysql' as db_type from mysql_status a, db_servers_mysql b where a.server_id=b.id;"
    result=func.mysql_query(sql)
    if result <> 0:
        for line in result:
            server_id=line[0]
            connect=line[1]
            threads_connected=line[2]
            threads_running=line[3]
            threads_waits=line[4]
            create_time=line[5]
            host=line[6]
            port=line[7]
            alarm_threads_connected=line[8]
            alarm_threads_running=line[9]
            alarm_threads_waits=line[10]
            threshold_warning_threads_connected=line[11]
            threshold_critical_threads_connected=line[12]
            threshold_warning_threads_running=line[13]
            threshold_critical_threads_running=line[14]
            threshold_warning_threads_waits=line[15]
            threshold_critical_threads_waits=line[16]
            send_mail=line[17]
            send_mail_to_list=line[18]
            send_sms=line[19]
            send_sms_to_list=line[20]
            tags=line[21]
            db_type=line[22]
            if send_mail_to_list is None or  send_mail_to_list.strip()=='':
                send_mail_to_list = mail_to_list_common
            if send_sms_to_list is None or  send_sms_to_list.strip()=='':
                send_sms_to_list = sms_to_list_common
            if connect <> 1:
                send_mail = func.update_send_mail_status(server_id,db_type,'connect',send_mail,send_mail_max_count)
                send_sms  = func.update_send_sms_status(server_id,db_type,'connect',send_sms,send_sms_max_count)
                func.add_alarm(server_id,tags,host,port,create_time,db_type,'connect','down','critical','mysql server down',send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                func.update_db_status('connect','3',host,port,create_time,'connect','down','critical')
                func.update_db_status('sessions','-1',host,port,'','','','')
                func.update_db_status('actives','-1',host,port,'','','','')
                func.update_db_status('waits','-1',host,port,'','','','')
                func.update_db_status('repl','-1',host,port,'','','','')
                func.update_db_status('repl_delay','-1',host,port,'','','','')
            else:
                func.check_if_ok(server_id,tags,host,port,create_time,db_type,'connect','up','mysql server up',send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                func.update_db_status('connect','1',host,port,create_time,'connect','up','ok')

                if int(alarm_threads_connected)==1:
                    if int(threads_connected)>=int(threshold_critical_threads_connected):
                        send_mail = func.update_send_mail_status(server_id,db_type,'threads_connected',send_mail,send_mail_max_count) 
                        send_sms = func.update_send_sms_status(server_id,db_type,'threads_connected',send_sms,send_sms_max_count) 
                        func.add_alarm(server_id,tags,host,port,create_time,db_type,'threads_connected',threads_connected,'critical','too many threads connected',send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                        func.update_db_status('sessions',3,host,port,create_time,'threads_connected',threads_connected,'critical')
                    elif int(threads_connected)>=int(threshold_warning_threads_connected):
                        send_mail = func.update_send_mail_status(server_id,db_type,'threads_connected',send_mail,send_mail_max_count) 
                        send_sms = func.update_send_sms_status(server_id,db_type,'threads_connected',send_sms,send_sms_max_count) 
                        func.add_alarm(server_id,tags,host,port,create_time,db_type,'threads_connected',threads_connected,'warning','too many threads connected',send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                        func.update_db_status('sessions',2,host,port,create_time,'threads_connected',threads_connected,'warning')
                    else:
                        func.update_db_status('sessions',1,host,port,create_time,'threads_connected',threads_connected,'ok')
                        func.check_if_ok(server_id,tags,host,port,create_time,db_type,'threads_connected',threads_connected,'threads connected ok',send_mail,send_mail_to_list,send_sms,send_sms_to_list)

                if int(alarm_threads_running)==1:
                    if int(threads_running)>=int(threshold_critical_threads_running):
                        send_mail = func.update_send_mail_status(server_id,db_type,'threads_running',send_mail,send_mail_max_count) 
                        send_sms = func.update_send_sms_status(server_id,db_type,'threads_running',send_sms,send_sms_max_count) 
                        func.add_alarm(server_id,tags,host,port,create_time,db_type,'threads_running',threads_running,'critical','too many threads running',send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                        func.update_db_status('actives',3,host,port,create_time,'threads_running',threads_running,'critical')
                    elif int(threads_running)>=int(threshold_warning_threads_running):
                         send_mail = func.update_send_mail_status(server_id,db_type,'threads_running',send_mail,send_mail_max_count) 
                         send_sms = func.update_send_sms_status(server_id,db_type,'threads_running',send_sms,send_sms_max_count) 
                         func.add_alarm(server_id,tags,host,port,create_time,db_type,'threads_running',threads_running,'warning','too many threads running',send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                         func.update_db_status('actives',2,host,port,create_time,'threads_running',threads_running,'warning')
                    else:
                         func.update_db_status('actives',1,host,port,create_time,'threads_running',threads_running,'ok')
                         func.check_if_ok(server_id,tags,host,port,create_time,db_type,'threads_running',threads_running,'threads running ok',send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                         
                if int(alarm_threads_waits)==1:
                    if int(threads_waits)>=int(threshold_critical_threads_waits):
                        send_mail = func.update_send_mail_status(server_id,db_type,'threads_waits',send_mail,send_mail_max_count) 
                        send_sms = func.update_send_sms_status(server_id,db_type,'threads_waits',send_sms,send_sms_max_count) 
                        func.add_alarm(server_id,tags,host,port,create_time,db_type,'threads_waits',threads_waits,'critical','too many threads waits',send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                        func.update_db_status('waits',3,host,port,create_time,'threads_waits',threads_waits,'critical')
                    elif int(threads_waits)>=int(threshold_warning_threads_running):
                         send_mail = func.update_send_mail_status(server_id,db_type,'threads_waits',send_mail,send_mail_max_count) 
                         send_sms = func.update_send_sms_status(server_id,db_type,'threads_waits',send_sms,send_sms_max_count) 
                         func.add_alarm(server_id,tags,host,port,create_time,db_type,'threads_waits',threads_waits,'warning','too many threads waits',send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                         func.update_db_status('waits',2,host,port,create_time,'threads_waits',threads_waits,'warning')
                    else:
                         func.update_db_status('waits',1,host,port,create_time,'threads_waits',threads_waits,'ok')
                         func.check_if_ok(server_id,tags,host,port,create_time,db_type,'threads_waits',threads_waits,'threads waits ok',send_mail,send_mail_to_list,send_sms,send_sms_to_list)

    else:
       pass


def get_alarm_mysql_replcation():
    sql = "select a.server_id,a.slave_io_run,a.slave_sql_run,a.delay,a.create_time,b.host,b.port,b.alarm_repl_status,b.alarm_repl_delay,b.threshold_warning_repl_delay,b.threshold_critical_repl_delay,b.send_mail,b.send_mail_to_list,b.send_sms,b.send_sms_to_list,b.tags,'mysql' as db_type from mysql_replication a, db_servers_mysql b  where a.server_id=b.id and a.is_slave='1';"
    result=func.mysql_query(sql)
    if result <> 0:
        for line in result:
            server_id=line[0]
            slave_io_run=line[1]
            slave_sql_run=line[2]
            delay=line[3]
            create_time=line[4]
            host=line[5]
            port=line[6]
            alarm_repl_status=line[7]
            alarm_repl_delay=line[8]
            threshold_warning_repl_delay=line[9]
            threshold_critical_repl_delay=line[10]
            send_mail=line[11]
            send_mail_to_list=line[12]
            send_sms=line[13]
            send_sms_to_list=line[14]
            tags=line[15]
            db_type=line[16]
            
            if send_mail_to_list is None or  send_mail_to_list.strip()=='':
                send_mail_to_list = mail_to_list_common
            if send_sms_to_list is None or  send_sms_to_list.strip()=='':
                send_sms_to_list = sms_to_list_common
                
            if int(alarm_repl_status)==1:
                if (slave_io_run== "Yes") and (slave_sql_run== "Yes"):
                    func.check_if_ok(server_id,tags,host,port,create_time,db_type,'replication','IO:'+slave_io_run+',SQL:'+slave_sql_run,'replication ok',send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                    func.update_db_status('repl',1,host,port,create_time,'replication','IO:'+slave_io_run+',SQL:'+slave_sql_run,'ok')
                    if int(alarm_repl_delay)==1:
                        if int(delay)>=int(threshold_critical_repl_delay):
                            send_mail = func.update_send_mail_status(server_id,db_type,'repl_delay',send_mail,send_mail_max_count) 
                            send_sms = func.update_send_sms_status(server_id,db_type,'repl_delay',send_sms,send_sms_max_count) 
                            func.add_alarm(server_id,tags,host,port,create_time,db_type,'repl_delay',delay,'critical','replication has delay',send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                            func.update_db_status('repl_delay',3,host,port,create_time,'repl_delay',delay,'critical')
                        elif int(delay)>=int(threshold_warning_repl_delay):
                            send_mail = func.update_send_mail_status(server_id,db_type,'repl_delay',send_mail,send_mail_max_count) 
                            send_sms = func.update_send_sms_status(server_id,db_type,'repl_delay',send_sms,send_sms_max_count) 
                            func.add_alarm(server_id,tags,host,port,create_time,db_type,'repl_delay',delay,'warning','replication has delay',send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                            func.update_db_status('repl_delay',2,host,port,create_time,'repl_delay',delay,'warning')
                        else:
                            func.check_if_ok(server_id,tags,host,port,create_time,db_type,'repl_delay',delay,'replication delay ok',send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                            func.update_db_status('repl_delay',1,host,port,create_time,'repl_delay',delay,'ok')
		else:
                    send_mail = func.update_send_mail_status(server_id,db_type,'replication',send_mail,send_mail_max_count)
                    send_sms = func.update_send_sms_status(server_id,db_type,'replication',send_sms,send_sms_max_count) 
                    func.add_alarm(server_id,tags,host,port,create_time,db_type,'replication','IO:'+slave_io_run+',SQL:'+slave_sql_run,'critical','replication stop',send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                    func.update_db_status('repl',3,host,port,create_time,'replication','IO:'+slave_io_run+',SQL:'+slave_sql_run,'critical')
                    func.update_db_status('repl_delay','-1',host,port,'','','','')
    else:
       pass


def get_alarm_oracle_status():
    sql = "select a.server_id,a.connect,a.session_total,a.session_actives,a.session_waits,a.create_time,b.host,b.port,b.alarm_session_total,b.alarm_session_actives,b.alarm_session_waits,b.threshold_warning_session_total,b.threshold_critical_session_total,b.threshold_warning_session_actives,b.threshold_critical_session_actives,b.threshold_warning_session_waits,b.threshold_critical_session_waits,b.send_mail,b.send_mail_to_list,b.send_sms,b.send_sms_to_list,b.tags,'oracle' as db_type from oracle_status a, db_servers_oracle b where a.server_id=b.id;"
    result=func.mysql_query(sql)
    if result <> 0:
        for line in result:
            server_id=line[0]
            connect=line[1]
            session_total=line[2]
            session_actives=line[3]
            session_waits=line[4]
            create_time=line[5]
            host=line[6]
            port=line[7]
            alarm_session_total=line[8]
            alarm_session_actives=line[9]
            alarm_session_waits=line[10]
            threshold_warning_session_total=line[11]
            threshold_critical_session_total=line[12]
            threshold_warning_session_actives=line[13]
            threshold_critical_session_actives=line[14]
            threshold_warning_session_waits=line[15]
            threshold_critical_session_waits=line[16]
            send_mail=line[17]
            send_mail_to_list=line[18]
            send_sms=line[19]
            send_sms_to_list=line[20]
            tags=line[21]
            db_type=line[22]
        
            if send_mail_to_list is None or  send_mail_to_list.strip()=='':
                send_mail_to_list = mail_to_list_common
            if send_sms_to_list is None or  send_sms_to_list.strip()=='':
                send_sms_to_list = sms_to_list_common
                
            if connect <> 1:
                send_mail = func.update_send_mail_status(server_id,db_type,'connect',send_mail,send_mail_max_count)
                send_sms = func.update_send_sms_status(server_id,db_type,'connect',send_sms,send_sms_max_count) 
                func.add_alarm(server_id,tags,host,port,create_time,db_type,'connect','down','critical','oracle server down',send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                func.update_db_status('connect','3',host,port,create_time,'connect','down','critical')
                func.update_db_status('sessions','-1',host,port,'','','','')
                func.update_db_status('actives','-1',host,port,'','','','')
                func.update_db_status('waits','-1',host,port,'','','','')
                func.update_db_status('repl','-1',host,port,'','','','')
                func.update_db_status('repl_delay','-1',host,port,'','','','')
            else:
                func.check_if_ok(server_id,tags,host,port,create_time,db_type,'connect','up','oracle server up',send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                func.update_db_status('connect','1',host,port,create_time,'connect','up','ok')
                if int(alarm_session_total)==1:
                    if int(session_total) >= int(threshold_critical_session_total):
                        send_mail = func.update_send_mail_status(server_id,db_type,'session_total',send_mail,send_mail_max_count)
                        send_sms = func.update_send_sms_status(server_id,db_type,'session_total',send_sms,send_sms_max_count) 
                        func.add_alarm(server_id,tags,host,port,create_time,db_type,'session_total',session_total,'critical','too many sessions',send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                        func.update_db_status('sessions',3,host,port,create_time,'session_total',session_total,'critical')
                    elif int(session_total) >= int(threshold_warning_session_total):
                        send_mail = func.update_send_mail_status(server_id,db_type,'session_total',send_mail,send_mail_max_count)
                        send_sms = func.update_send_sms_status(server_id,db_type,'session_total',send_sms,send_sms_max_count) 
                        func.add_alarm(server_id,tags,host,port,create_time,db_type,'session_total',session_total,'warning','too many sessions',send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                        func.update_db_status('sessions',2,host,port,create_time,'session_total',session_total,'warning')
                    else:
                        func.check_if_ok(server_id,tags,host,port,create_time,db_type,'session_total',session_total,'sessions ok',send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                        func.update_db_status('sessions',1,host,port,create_time,'session_total',session_total,'ok')
        
                if int(alarm_session_actives)==1:
                    if int(session_actives) >= int(threshold_critical_session_actives):
                        send_mail = func.update_send_mail_status(server_id,db_type,'session_actives',send_mail,send_mail_max_count)
                        send_sms = func.update_send_sms_status(server_id,db_type,'session_actives',send_sms,send_sms_max_count) 
                        func.add_alarm(server_id,tags,host,port,create_time,db_type,'session_actives',session_actives,'critical','too many active sessions',send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                        func.update_db_status('actives',3,host,port,create_time,'session_actives',session_actives,'critical')
                    elif int(session_actives) >= int(threshold_warning_session_actives):
                        send_mail = func.update_send_mail_status(server_id,db_type,'session_actives',send_mail,send_mail_max_count)
                        send_sms = func.update_send_sms_status(server_id,db_type,'session_actives',send_sms,send_sms_max_count) 
                        func.add_alarm(server_id,tags,host,port,create_time,db_type,'session_actives',session_actives,'warning','too many active sessions',send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                        func.update_db_status('actives',2,host,port,create_time,'session_actives',session_actives,'warning')
                    else:
                        func.check_if_ok(server_id,tags,host,port,create_time,db_type,'session_actives',session_actives,'active sessions ok',send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                        func.update_db_status('actives',1,host,port,create_time,'session_actives',session_actives,'ok')

	        if int(alarm_session_waits)==1:
                    if int(session_waits) >= int(threshold_critical_session_waits):
                        send_mail = func.update_send_mail_status(server_id,db_type,'session_waits',send_mail,send_mail_max_count)
                        send_sms = func.update_send_sms_status(server_id,db_type,'session_waits',send_sms,send_sms_max_count) 
                        func.add_alarm(server_id,tags,host,port,create_time,db_type,'session_waits',session_waits,'critical','too many waits sessions',send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                        func.update_db_status('waits',3,host,port,create_time,'session_waits',session_waits,'critical')
                    elif int(session_waits) >= int(threshold_warning_session_waits):
                        send_mail = func.update_send_mail_status(server_id,db_type,'session_waits',send_mail,send_mail_max_count)
                        send_sms = func.update_send_sms_status(server_id,db_type,'session_waits',send_sms,send_sms_max_count) 
                        func.add_alarm(server_id,tags,host,port,create_time,db_type,'session_waits',session_waits,'warning','too many waits sessions',send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                        func.update_db_status('waits',2,host,port,create_time,'session_waits',session_waits,'warning')
                    else:                        
                        func.check_if_ok(server_id,tags,host,port,create_time,db_type,'session_waits',session_waits,'waits sessions ok',send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                        func.update_db_status('waits',1,host,port,create_time,'session_waits',session_waits,'ok')
	



    else:
       pass


def get_alarm_oracle_tablespace():
    sql = "select a.server_id,a.tablespace_name,a.total_size,a.used_size,a.avail_size,a.used_rate,a.create_time,b.host,b.port,b.alarm_tablespace,b.threshold_warning_tablespace,b.threshold_critical_tablespace,b.send_mail,b.send_mail_to_list,b.send_sms,b.send_sms_to_list,b.tags,'oracle' as db_type from oracle_tablespace a, db_servers_oracle b where a.server_id=b.id  order by SUBSTRING_INDEX(used_rate,'%',1)+0 asc;"
    result=func.mysql_query(sql)
    if result <> 0:
        for line in result:
            server_id=line[0]
            tablespace_name=line[1]
            total_size=line[2]
            used_size=line[3]
            avail_size=line[4]
            used_rate=line[5]
            create_time=line[6]
            host=line[7]
            port=line[8]
            alarm_tablespace=line[9]
            threshold_warning_tablespace=line[10]
            threshold_critical_tablespace=line[11]
            send_mail=line[12]
            send_mail_to_list=line[13]
            send_sms=line[14]
            send_sms_to_list=line[15]
            tags=line[16]
            db_type=line[17]

            used_rate_arr=used_rate.split("%")
            used_rate_int=int(used_rate_arr[0])
            
            if send_mail_to_list is None or  send_mail_to_list.strip()=='':
                send_mail_to_list = mail_to_list_common
            if send_sms_to_list is None or  send_sms_to_list.strip()=='':
                send_sms_to_list = sms_to_list_common
                
            if int(alarm_tablespace)==1:
                if int(used_rate_int) >= int(threshold_critical_tablespace):
                    send_mail = func.update_send_mail_status(server_id,db_type,'tablespace(%s)' %(tablespace_name),send_mail,send_mail_max_count)
                    send_sms = func.update_send_sms_status(server_id,db_type,'tablespace(%s)' %(tablespace_name),send_sms,send_sms_max_count) 
                    func.add_alarm(server_id,tags,host,port,create_time,db_type,'tablespace(%s)' %(tablespace_name),used_rate,'critical','tablespace %s usage reach %s' %(tablespace_name,used_rate),send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                    func.update_db_status('tablespace',3,host,port,create_time,'tablespace(%s)' %(tablespace_name),used_rate,'critical')
                elif int(used_rate_int) >= int(threshold_warning_tablespace):
                    send_mail = func.update_send_mail_status(server_id,db_type,'tablespace(%s)' %(tablespace_name),send_mail,send_mail_max_count)
                    send_sms = func.update_send_sms_status(server_id,db_type,'tablespace(%s)' %(tablespace_name),send_sms,send_sms_max_count) 
                    func.add_alarm(server_id,tags,host,port,create_time,db_type,'tablespace(%s)' %(tablespace_name),used_rate,'warning','tablespace %s usage reach %s' %(tablespace_name,used_rate),send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                    func.update_db_status('tablespace',2,host,port,create_time,'tablespace(%s)' %(tablespace_name),used_rate,'warning')
                else:
                    func.check_if_ok(server_id,tags,host,port,create_time,db_type,'tablespace(%s)' %(tablespace_name),used_rate,'tablespace %s usage ok' %(tablespace_name),send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                    func.update_db_status('tablespace',1,host,port,create_time,'tablespace','max(%s:%s)' %(tablespace_name,used_rate),'ok')
    else:
       pass



def get_alarm_mongodb_status():
    sql = "select a.server_id,a.connect,a.connections_current,a.globalLock_activeClients,a.globalLock_currentQueue,a.create_time,b.host,b.port,b.alarm_connections_current,b.alarm_active_clients,b.alarm_current_queue,b.threshold_warning_connections_current,b.threshold_critical_connections_current,b.threshold_warning_active_clients,b.threshold_critical_active_clients,b.threshold_warning_current_queue,b.threshold_critical_current_queue,b.send_mail,b.send_mail_to_list,b.send_sms,b.send_sms_to_list,b.tags,'mongodb' as db_type from mongodb_status a, db_servers_mongodb b where a.server_id=b.id;"
    result=func.mysql_query(sql)
    if result <> 0:
        for line in result:
            server_id=line[0]
            connect=line[1]
            connections_current=line[2]
            globalLock_activeClients=line[3]
	    globalLock_currentQueue=line[4]
            create_time=line[5]
            host=line[6]
            port=line[7]
            alarm_connections_current=line[8]
            alarm_active_clients=line[9]
            alarm_current_queue=line[10]
            threshold_warning_connections_current=line[11]
            threshold_critical_connections_current=line[12]
            threshold_warning_active_clients=line[13]
            threshold_critical_active_clients=line[14]
            threshold_warning_current_queue=line[15]
            threshold_critical_current_queue=line[16]
            send_mail=line[17]
            send_mail_to_list=line[18]
            send_sms=line[19]
            send_sms_to_list=line[20]
            tags=line[21]
            db_type=line[22]
	    
            if send_mail_to_list is None or  send_mail_to_list.strip()=='':
                send_mail_to_list = mail_to_list_common
            if send_sms_to_list is None or  send_sms_to_list.strip()=='':
                send_sms_to_list = sms_to_list_common
                
            if connect <> 1:
                send_mail = func.update_send_mail_status(server_id,db_type,'connect',send_mail,send_mail_max_count)
                send_sms = func.update_send_sms_status(server_id,db_type,'connect',send_sms,send_sms_max_count) 
                func.add_alarm(server_id,tags,host,port,create_time,db_type,'connect','down','critical','mongodb server down',send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                func.update_db_status('connect','3',host,port,create_time,'connect','down','critical')
                func.update_db_status('sessions','-1',host,port,'','','','')
                func.update_db_status('actives','-1',host,port,'','','','')
                func.update_db_status('waits','-1',host,port,'','','','')
                func.update_db_status('repl','-1',host,port,'','','','')
                func.update_db_status('repl_delay','-1',host,port,'','','','')
            else:
                func.check_if_ok(server_id,tags,host,port,create_time,db_type,'connect','up','mongodb server up',send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                func.update_db_status('connect','1',host,port,create_time,'connect','up','ok')
                if int(alarm_connections_current)==1:
                    if int(connections_current) >= int(threshold_critical_connections_current):
                        send_mail = func.update_send_mail_status(server_id,db_type,'connections_current',send_mail,send_mail_max_count)
                        send_sms = func.update_send_sms_status(server_id,db_type,'connections_current',send_sms,send_sms_max_count) 
                        func.add_alarm(server_id,tags,host,port,create_time,db_type,'connections_current',connections_current,'critical','too many connections current',send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                        func.update_db_status('sessions',3,host,port,create_time,'connections_current',connections_current,'critical')
                    elif int(connections_current) >= int(threshold_warning_connections_current):
                        send_mail = func.update_send_mail_status(server_id,db_type,'connections_current',send_mail,send_mail_max_count)
                        send_sms = func.update_send_sms_status(server_id,db_type,'connections_current',send_sms,send_sms_max_count) 
                        func.add_alarm(server_id,tags,host,port,create_time,db_type,'connections_current',connections_current,'critical','too many connections current',send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                        func.add_alarm(server_id,tags,host,port,create_time,db_type,'connections_current',connections_current,'warning','too many connections current',send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                        func.update_db_status('sessions',2,host,port,create_time,'connections_current',connections_current,'warning')
                    else:
                        func.check_if_ok(server_id,tags,host,port,create_time,db_type,'connections_current',connections_current,'connections current ok',send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                        func.update_db_status('sessions',1,host,port,create_time,'connections_current',connections_current,'ok')
		
		if int(alarm_active_clients)==1:
                    if int(globalLock_activeClients) >= int(threshold_critical_active_clients):
                        send_mail = func.update_send_mail_status(server_id,db_type,'active_clients',send_mail,send_mail_max_count)
                        send_sms = func.update_send_sms_status(server_id,db_type,'active_clients',send_sms,send_sms_max_count) 
                        func.add_alarm(server_id,tags,host,port,create_time,db_type,'connections_current',connections_current,'critical','too many connections current',send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                        func.add_alarm(server_id,tags,host,port,create_time,db_type,'active_clients',globalLock_activeClients,'critical','too many active clients',send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                        func.update_db_status('actives',3,host,port,create_time,'active_clients',globalLock_activeClients,'critical')
                    elif int(globalLock_activeClients) >= int(threshold_warning_active_clients):
                        send_mail = func.update_send_mail_status(server_id,db_type,'active_clients',send_mail,send_mail_max_count)
                        send_sms = func.update_send_sms_status(server_id,db_type,'active_clients',send_sms,send_sms_max_count) 
                        func.add_alarm(server_id,tags,host,port,create_time,db_type,'active_clients',globalLock_activeClients,'warning','too many active clients',send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                        func.update_db_status('actives',2,host,port,create_time,'active_clients',globalLock_activeClients,'warning')
                    else:
                        func.check_if_ok(server_id,tags,host,port,create_time,db_type,'active_clients',globalLock_activeClients,'active clients ok',send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                        func.update_db_status('actives',1,host,port,create_time,'active_clients',globalLock_activeClients,'ok')

		if int(alarm_current_queue)==1:
                    if int(globalLock_currentQueue) >= int(threshold_critical_current_queue):
                        send_mail = func.update_send_mail_status(server_id,db_type,'current_queue',send_mail,send_mail_max_count)
                        send_sms = func.update_send_sms_status(server_id,db_type,'current_queue',send_sms,send_sms_max_count) 
                        func.add_alarm(server_id,tags,host,port,create_time,db_type,'current_queue',globalLock_currentQueue,'critical','too many current queue',send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                        func.update_db_status('waits',3,host,port,create_time,'current_queue',globalLock_currentQueue,'critical')
                    elif int(globalLock_currentQueue) >= int(threshold_warning_current_queue):
                        send_mail = func.update_send_mail_status(server_id,db_type,'current_queue',send_mail,send_mail_max_count)
                        send_sms = func.update_send_sms_status(server_id,db_type,'current_queue',send_sms,send_sms_max_count) 
                        func.add_alarm(server_id,tags,host,port,create_time,db_type,'current_queue',globalLock_currentQueue,'warning','too many current queue',send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                        func.update_db_status('waits',2,host,port,create_time,'current_queue',globalLock_currentQueue,'warning')
                    else:                        
                        func.check_if_ok(server_id,tags,host,port,create_time,db_type,'current_queue',globalLock_currentQueue,'current queue ok',send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                        func.update_db_status('waits',1,host,port,create_time,'current_queue',globalLock_currentQueue,'ok')


    else:
       pass



def get_alarm_redis_status():
    sql = "select a.server_id,a.connect,a.connected_clients,a.current_commands_processed,a.blocked_clients,a.create_time,b.host,b.port,b.alarm_connected_clients,b.alarm_command_processed,b.alarm_blocked_clients,b.threshold_warning_connected_clients,b.threshold_critical_connected_clients,b.threshold_warning_command_processed,b.threshold_critical_command_processed,b.threshold_warning_blocked_clients,b.threshold_critical_blocked_clients,b.send_mail,b.send_mail_to_list,b.send_sms,b.send_sms_to_list,b.tags,'redis' as db_type from redis_status a, db_servers_redis b where a.server_id=b.id ;"
    result=func.mysql_query(sql)
    if result <> 0:
        for line in result:
            server_id=line[0]
            connect=line[1]
            connected_clients=line[2]
            current_commands_processed=line[3]
            blocked_clients=line[4]
            create_time=line[5]
            host=line[6]
            port=line[7]
            alarm_connected_clients=line[8]
            alarm_command_processed=line[9]
            alarm_blocked_clients=line[10]
            threshold_warning_connected_clients=line[11]
            threshold_critical_connected_clients=line[12]
            threshold_warning_command_processed=line[13]
            threshold_critical_command_processed=line[14]
            threshold_warning_blocked_clients=line[15]
            threshold_critical_blocked_clients=line[16]
            send_mail=line[17]
            send_mail_to_list=line[18]
            send_sms=line[19]
            send_sms_to_list=line[20]
            tags=line[21]
            db_type=line[22]

            if send_mail_to_list is None or  send_mail_to_list.strip()=='':
                send_mail_to_list = mail_to_list_common
            if send_sms_to_list is None or  send_sms_to_list.strip()=='':
                send_sms_to_list = sms_to_list_common

	    if connect <> 1:
                send_mail = func.update_send_mail_status(server_id,db_type,'connect',send_mail,send_mail_max_count)
                send_sms = func.update_send_sms_status(server_id,db_type,'connect',send_sms,send_sms_max_count) 
                func.add_alarm(server_id,tags,host,port,create_time,db_type,'connect','down','critical','redis server down',send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                func.update_db_status('connect','3',host,port,create_time,'connect','down','critical')
                func.update_db_status('sessions','-1',host,port,'','','','')
                func.update_db_status('actives','-1',host,port,'','','','')
                func.update_db_status('waits','-1',host,port,'','','','')
                func.update_db_status('repl','-1',host,port,'','','','')
                func.update_db_status('repl_delay','-1',host,port,'','','','')
            else:
                func.check_if_ok(server_id,tags,host,port,create_time,db_type,'connect','up','redis server up',send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                func.update_db_status('connect','1',host,port,create_time,'connect','up','ok')

                if int(alarm_connected_clients)==1:
                    if int(connected_clients) >= int(threshold_critical_connected_clients):
                        send_mail = func.update_send_mail_status(server_id,db_type,'connected_clients',send_mail,send_mail_max_count)
                        send_sms = func.update_send_sms_status(server_id,db_type,'connected_clients',send_sms,send_sms_max_count) 
                        func.add_alarm(server_id,tags,host,port,create_time,db_type,'connected_clients',connected_clients,'critical','too many connected clients',send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                        func.update_db_status('sessions',3,host,port,create_time,'connected_clients',connected_clients,'critical')
                    elif int(connected_clients) >= int(threshold_warning_connected_clients):
                        send_mail = func.update_send_mail_status(server_id,db_type,'connected_clients',send_mail,send_mail_max_count)
                        send_sms = func.update_send_sms_status(server_id,db_type,'connected_clients',send_sms,send_sms_max_count) 
                        func.add_alarm(server_id,tags,host,port,create_time,db_type,'connected_clients',connected_clients,'warning','too many connected clients',send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                        func.update_db_status('sessions',2,host,port,create_time,'connected_clients',connected_clients,'warning')
                    else:
                        func.check_if_ok(server_id,tags,host,port,create_time,db_type,'connected_clients',connected_clients,'connected clients ok',send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                        func.update_db_status('sessions',1,host,port,create_time,'connected_clients',connected_clients,'ok')

                if int(alarm_command_processed)==1:
                    if int(current_commands_processed) >= int(threshold_critical_command_processed):
                        send_mail = func.update_send_mail_status(server_id,db_type,'command_processed',send_mail,send_mail_max_count)
                        send_sms = func.update_send_sms_status(server_id,db_type,'command_processed',send_sms,send_sms_max_count) 
                        func.add_alarm(server_id,tags,host,port,create_time,db_type,'command_processed',current_commands_processed,'critical','too many command processed',send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                        func.update_db_status('actives',3,host,port,create_time,'command_processed',current_commands_processed,'critical')
                    elif int(current_commands_processed) >= int(threshold_warning_command_processed):
                        send_mail = func.update_send_mail_status(server_id,db_type,'command_processed',send_mail,send_mail_max_count)
                        send_sms = func.update_send_sms_status(server_id,db_type,'command_processed',send_sms,send_sms_max_count) 
                        func.add_alarm(server_id,tags,host,port,create_time,db_type,'command_processed',current_commands_processed,'warning','too many command processed',send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                        func.update_db_status('actives',2,host,port,create_time,'command_processed',current_commands_processed,'warning')
                    else:
                        func.check_if_ok(server_id,tags,host,port,create_time,db_type,'command_processed',current_commands_processed,'command processed ok',send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                        func.update_db_status('actives',1,host,port,create_time,'command_processed',current_commands_processed,'ok')

                if int(alarm_blocked_clients)==1:
                    if int(blocked_clients) >= int(threshold_critical_blocked_clients):
                        send_mail = func.update_send_mail_status(server_id,db_type,'blocked_clients',send_mail,send_mail_max_count)
                        send_sms = func.update_send_sms_status(server_id,db_type,'blocked_clients',send_sms,send_sms_max_count) 
                        func.add_alarm(server_id,tags,host,port,create_time,db_type,'blocked_clients',blocked_clients,'critical','too many blocked clients',send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                        func.update_db_status('waits',3,host,port,create_time,'blocked_clients',blocked_clients,'critical')
                    elif int(blocked_clients) >= int(threshold_warning_blocked_clients):
                        send_mail = func.update_send_mail_status(server_id,db_type,'blocked_clients',send_mail,send_mail_max_count)
                        send_sms = func.update_send_sms_status(server_id,db_type,'blocked_clients',send_sms,send_sms_max_count) 
                        func.add_alarm(server_id,tags,host,port,create_time,db_type,'blocked_clients',blocked_clients,'warning','too many blocked clients',send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                        func.update_db_status('waits',2,host,port,create_time,'blocked_clients',blocked_clients,'warning')
                    else:
                        func.check_if_ok(server_id,tags,host,port,create_time,db_type,'blocked_clients',blocked_clients,'blocked clients ok',send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                        func.update_db_status('waits',1,host,port,create_time,'blocked_clients',blocked_clients,'ok')


    else:
       pass



def get_alarm_os_status():
    sql = "select a.ip,a.hostname,a.snmp,a.process,a.load_1,a.cpu_idle_time,a.mem_usage_rate,a.create_time,b.tags,b.alarm_os_process,b.alarm_os_load,b.alarm_os_cpu,b.alarm_os_memory,b.threshold_warning_os_process,b.threshold_critical_os_process,b.threshold_warning_os_load,b.threshold_critical_os_load,b.threshold_warning_os_cpu,b.threshold_critical_os_cpu,b.threshold_warning_os_memory,b.threshold_critical_os_memory,b.send_mail,b.send_mail_to_list,b.send_sms,b.send_sms_to_list from os_status a,db_servers_os b where a.ip=b.host"
    result=func.mysql_query(sql)
    if result <> 0:
        for line in result:
	    host=line[0]
            hostname=line[1]
            snmp=line[2]
            process=line[3]
            load_1=line[4]
            cpu_idle=line[5]
            memory_usage=line[6]
            create_time=line[7]
            tags=line[8]
            alarm_os_process=line[9]
            alarm_os_load=line[10]
            alarm_os_cpu=line[11]
            alarm_os_memory=line[12]
            threshold_warning_os_process=line[13]
            threshold_critical_os_process=line[14]
            threshold_warning_os_load=line[15]
            threshold_critical_os_load=line[16]
            threshold_warning_os_cpu=line[17]
            threshold_critical_os_cpu=line[18]
            threshold_warning_os_memory=line[19]
            threshold_critical_os_memory=line[20]
            send_mail=line[21]
            send_mail_to_list=line[22]
            send_sms=line[23]
            send_sms_to_list=line[24]

            server_id=0
            tags=tags
            db_type="os"
            port=''

            if send_mail_to_list is None or  send_mail_to_list.strip()=='':
                send_mail_to_list = mail_to_list_common
            if send_sms_to_list is None or  send_sms_to_list.strip()=='':
                send_sms_to_list = sms_to_list_common
                
            if snmp <> 1:
                send_mail = func.update_send_mail_status(host,db_type,'snmp_server',send_mail,send_mail_max_count)
                send_sms = func.update_send_sms_status(host,db_type,'snmp_server',send_sms,send_sms_max_count)
                func.add_alarm(server_id,tags,host,port,create_time,db_type,'snmp_server','down','critical','snmp server down',send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                func.update_db_status('snmp','3',host,'',create_time,'snmp_server','down','critical')
                func.update_db_status('process','-1',host,'','','','','')
                func.update_db_status('load_1','-1',host,'','','','','')
                func.update_db_status('cpu','-1',host,'','','','','')
                func.update_db_status('memory','-1',host,'','','','','')
                func.update_db_status('network','-1',host,'','','','','')
                func.update_db_status('disk','-1',host,'','','','','')
            else:
                func.check_if_ok(server_id,tags,host,port,create_time,db_type,'snmp_server','up','snmp server up',send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                func.update_db_status('snmp',1,host,'',create_time,'snmp_server','up','ok')

                if int(alarm_os_process)==1:
                    if int(process) >= int(threshold_critical_os_process):
                        send_mail = func.update_send_mail_status(host,db_type,'process',send_mail,send_mail_max_count)
                        send_sms = func.update_send_sms_status(host,db_type,'process',send_sms,send_sms_max_count)
                        func.add_alarm(server_id,tags,host,port,create_time,db_type,'process',process,'critical','too more process running',send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                        func.update_db_status('process',3,host,'',create_time,'process',process,'critical')
                    elif int(process) >= int(threshold_warning_os_process):
                        send_mail = func.update_send_mail_status(host,db_type,'process',send_mail,send_mail_max_count)
                        send_sms = func.update_send_sms_status(host,db_type,'process',send_sms,send_sms_max_count)
                        func.add_alarm(server_id,tags,host,port,create_time,db_type,'process',process,'warning','too more process running',send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                        func.update_db_status('process',2,host,'',create_time,'process',process,'warning')
                    else:
                        func.update_db_status('process',1,host,'',create_time,'process',process,'ok')
                        func.check_if_ok(server_id,tags,host,port,create_time,db_type,'process',process,'process running ok',send_mail,send_mail_to_list,send_sms,send_sms_to_list)

                if int(alarm_os_load)==1:
                    if int(load_1) >= int(threshold_critical_os_load):
                        send_mail = func.update_send_mail_status(host,db_type,'load',send_mail,send_mail_max_count)
                        send_sms = func.update_send_sms_status(host,db_type,'load',send_sms,send_sms_max_count)
                        func.add_alarm(server_id,tags,host,port,create_time,db_type,'load',load_1,'critical','too high load',send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                        func.update_db_status('load_1',3,host,'',create_time,'load',load_1,'critical')
                    elif int(load_1) >= int(threshold_warning_os_load):
                        send_mail = func.update_send_mail_status(server_id,db_type,'load',send_mail,send_mail_max_count)
                        send_sms = func.update_send_sms_status(host,db_type,'load',send_sms,send_sms_max_count)
                        func.add_alarm(server_id,tags,host,port,create_time,db_type,'load',load_1,'warning','too high load',send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                        func.update_db_status('load_1',2,host,'',create_time,'load',load_1,'warning')
                    else:
                        func.check_if_ok(server_id,tags,host,port,create_time,db_type,'load',load_1,'load ok',send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                        func.update_db_status('load_1',1,host,'',create_time,'load',load_1,'ok')

                if int(alarm_os_cpu)==1:
                    threshold_critical_os_cpu = int(100-threshold_critical_os_cpu)
                    threshold_warning_os_cpu = int(100-threshold_warning_os_cpu)
                    if int(cpu_idle) <= int(threshold_critical_os_cpu):
                        send_mail = func.update_send_mail_status(host,db_type,'cpu_idle',send_mail,send_mail_max_count)
                        send_sms = func.update_send_sms_status(host,db_type,'cpu_idle',send_sms,send_sms_max_count)
                        func.add_alarm(server_id,tags,host,port,create_time,db_type,'cpu_idle',str(cpu_idle)+'%','critical','too little cpu idle',send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                        func.update_db_status('cpu',3,host,'',create_time,'cpu_idle',str(cpu_idle)+'%','critical')
                    elif int(cpu_idle) <= int(threshold_warning_os_cpu):
                        send_mail = func.update_send_mail_status(host,db_type,'cpu_idle',send_mail,send_mail_max_count)
                        send_sms = func.update_send_sms_status(host,db_type,'cpu_idle',send_sms,send_sms_max_count)
                        func.add_alarm(server_id,tags,host,port,create_time,db_type,'cpu_idle',str(cpu_idle)+'%','warning','too little cpu idle',send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                        func.update_db_status('cpu',2,host,'',create_time,'cpu_idle',str(cpu_idle)+'%','warning')
                    else:
                        func.check_if_ok(server_id,tags,host,port,create_time,db_type,'cpu_idle',str(cpu_idle)+'%','cpu idle ok',send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                        func.update_db_status('cpu',1,host,'',create_time,'cpu_idle',str(cpu_idle)+'%','ok')

                if int(alarm_os_memory)==1:
                    if memory_usage:
                        memory_usage_int = int(memory_usage.split('%')[0])
                    else:
                        memory_usage_int = 0 
                    if int(memory_usage_int) >= int(threshold_critical_os_memory):
                        send_mail = func.update_send_mail_status(host,db_type,'memory',send_mail,send_mail_max_count)
                        send_sms = func.update_send_sms_status(host,db_type,'memory',send_sms,send_sms_max_count)
                        func.add_alarm(server_id,tags,host,port,create_time,db_type,'memory',memory_usage,'critical','too more memory usage',send_mail,send_mail_to_list,send_sms,send_sms_to_list) 
                        func.update_db_status('memory',3,host,'',create_time,'memory',memory_usage,'critical')
                    elif int(memory_usage_int) >= int(threshold_warning_os_memory):
                        send_mail = func.update_send_mail_status(host,db_type,'memory',send_mail,send_mail_max_count)
                        send_sms = func.update_send_sms_status(host,db_type,'memory',send_sms,send_sms_max_count)
                        func.add_alarm(server_id,tags,host,port,create_time,db_type,'memory',memory_usage,'warning','too more memory usage',send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                        func.update_db_status('memory',2,host,'',create_time,'memory',memory_usage,'warning')
                    else:
                        func.check_if_ok(server_id,tags,host,port,create_time,db_type,'memory',memory_usage,'memory usage ok',send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                        func.update_db_status('memory',1,host,'',create_time,'memory',memory_usage,'ok') 


    else:
       pass



def get_alarm_os_disk():
    sql="select a.ip,a.mounted,a.used_rate,a.create_time,b.tags,b.alarm_os_disk,b.threshold_warning_os_disk,b.threshold_critical_os_disk,b.send_mail,b.send_mail_to_list,b.send_sms,b.send_sms_to_list  from os_disk a,db_servers_os b where a.ip=b.host group by ip,mounted order by SUBSTRING_INDEX(used_rate,'%',1)+0 asc;"
    result=func.mysql_query(sql)
    if result <> 0:
        for line in result:
            host=line[0]
            mounted=line[1]
            used_rate=line[2]
            create_time=line[3]
            tags=line[4]
            alarm_os_disk=line[5]
            threshold_warning_os_disk=line[6]
            threshold_critical_os_disk=line[7]
            send_mail=line[8]
            send_mail_to_list=line[9]
            send_sms=line[10]
            send_sms_to_list=line[11]

	    server_id=0
            tags=tags
            db_type="os"
            port=''

            used_rate_arr=used_rate.split("%")
            used_rate_int=int(used_rate_arr[0])
            
            if send_mail_to_list is None or  send_mail_to_list.strip()=='':
                send_mail_to_list = mail_to_list_common
            if send_sms_to_list is None or  send_sms_to_list.strip()=='':
                send_sms_to_list = sms_to_list_common
                
            if int(alarm_os_disk)==1:
                if int(used_rate_int) >= int(threshold_critical_os_disk):
                    send_mail = func.update_send_mail_status(host,db_type,'disk_usage(%s)' %(mounted),send_mail,send_mail_max_count)
                    send_sms = func.update_send_sms_status(host,db_type,'disk_usage(%s)' %(mounted),send_sms,send_sms_max_count)
                    func.add_alarm(server_id,tags,host,port,create_time,db_type,'disk_usage(%s)' %(mounted),used_rate,'critical','disk %s usage reach %s' %(mounted,used_rate),send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                    func.update_db_status('disk',3,host,'',create_time,'disk_usage(%s)' %(mounted),used_rate,'critical')
                elif int(used_rate_int) >= int(threshold_warning_os_disk):
                    send_mail = func.update_send_mail_status(host,db_type,'disk_usage(%s)' %(mounted),send_mail,send_mail_max_count)
                    send_sms = func.update_send_sms_status(host,db_type,'disk_usage(%s)' %(mounted),send_sms,send_sms_max_count)
                    func.add_alarm(server_id,tags,host,port,create_time,db_type,'disk_usage(%s)' %(mounted),used_rate,'warning','disk %s usage reach %s' %(mounted,used_rate),send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                    func.update_db_status('disk',2,host,'',create_time,'disk_usage(%s)' %(mounted),used_rate,'warning')
                else:
                    func.check_if_ok(server_id,tags,host,port,create_time,db_type,'disk_usage(%s)' %(mounted),used_rate,'disk %s usage ok' %(mounted),send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                    func.update_db_status('disk',1,host,'',create_time,'disk_usage','max(%s:%s)' %(mounted,used_rate),'ok')
    else:
       pass


def get_alarm_os_network():
    sql="select a.ip,a.if_descr,a.in_bytes,a.out_bytes,sum(in_bytes+out_bytes) sum_bytes,a.create_time,b.tags,b.alarm_os_network,b.threshold_warning_os_network,b.threshold_critical_os_network,b.send_mail,b.send_mail_to_list,b.send_sms,b.send_sms_to_list  from os_net a,db_servers_os b where a.ip=b.host group by ip,if_descr order by sum(in_bytes+out_bytes) asc;"
    result=func.mysql_query(sql)
    if result <> 0:
        for line in result:
            host=line[0]
            if_descr=line[1]
            in_bytes=line[2]
            out_bytes=line[3]
            sum_bytes=line[4]
            create_time=line[5]
            tags=line[6]
            alarm_os_network=line[7]
            threshold_warning_os_network=(line[8])*1024*1024
            threshold_critical_os_network=(line[9])*1024*1024
            send_mail=line[10]
            send_mail_to_list=line[11]
            send_sms=line[12]
            send_sms_to_list=line[13]

            server_id=0
            tags=tags
            db_type="os"
            port=''

            if send_mail_to_list is None or  send_mail_to_list.strip()=='':
                send_mail_to_list = mail_to_list_common
            if send_sms_to_list is None or  send_sms_to_list.strip()=='':
                send_sms_to_list = sms_to_list_common
                
            if int(alarm_os_network)==1:
                if int(sum_bytes) >= int(threshold_critical_os_network):
                    send_mail = func.update_send_mail_status(host,db_type,'network(%s)' %(if_descr),send_mail,send_mail_max_count)
                    send_sms = func.update_send_sms_status(host,db_type,'network(%s)' %(if_descr),send_sms,send_sms_max_count)
                    func.add_alarm(server_id,tags,host,port,create_time,db_type,'network(%s)' %(if_descr),'in:%s,out:%s' %(in_bytes,out_bytes),'critical','network %s bytes reach %s' %(if_descr,sum_bytes),send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                    func.update_db_status('network',3,host,'',create_time,'network(%s)'%(if_descr),'in:%s,out:%s' %(in_bytes,out_bytes),'critical')
                elif int(sum_bytes) >= int(threshold_warning_os_network):
                    send_mail = func.update_send_mail_status(host,db_type,'network(%s)' %(if_descr),send_mail,send_mail_max_count)
                    send_sms = func.update_send_sms_status(host,db_type,'network(%s)' %(if_descr),send_sms,send_sms_max_count)
                    func.add_alarm(server_id,tags,host,port,create_time,db_type,'network(%s)'%(if_descr),'in:%s,out:%s' %(in_bytes,out_bytes),'warning','network %s bytes reach %s' %(if_descr,sum_bytes),send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                    func.update_db_status('network',2,host,'',create_time,'network(%s)'%(if_descr),'in:%s,out:%s' %(in_bytes,out_bytes),'warning')
                else:
                    func.check_if_ok(server_id,tags,host,port,create_time,db_type,'network(%s)'%(if_descr),'in:%s,out:%s' %(in_bytes,out_bytes),'network %s bytes ok' %(if_descr),send_mail,send_mail_to_list,send_sms,send_sms_to_list)
                    func.update_db_status('network',1,host,'',create_time,'network','max(%s-in:%s,out:%s)' %(if_descr,in_bytes,out_bytes),'ok')
    else:
       pass


def send_alarm():
    sql = "select tags,host,port,create_time,db_type,alarm_item,alarm_value,level,message,send_mail,send_mail_to_list,send_sms,send_sms_to_list,id alarm_id from alarm;"
    result=func.mysql_query(sql)
    if result <> 0:
        send_alarm_mail = func.get_option('send_alarm_mail')
        send_alarm_sms = func.get_option('send_alarm_sms')
        for line in result:
            tags=line[0]
            host=line[1]
            port=line[2]
            create_time=line[3]
            db_type=line[4]
            alarm_item=line[5]
            alarm_value=line[6]
            level=line[7]
            message=line[8]
            send_mail=line[9]
            send_mail_to_list=line[10]
            send_sms=line[11]
            send_sms_to_list=line[12]
            alarm_id=line[13]

            if port:
               server = host+':'+port
            else:
               server = host

            if send_mail_to_list:
                mail_to_list=send_mail_to_list.split(';')
            else:
                send_mail=0 

            if send_sms_to_list:
                sms_to_list=send_sms_to_list.split(';')
            else:
                send_sms=0

            if int(send_alarm_mail)==1:
                if send_mail==1:
                    mail_subject='['+level+'] '+db_type+'-'+tags+'-'+server+' '+message+' Time:'+create_time.strftime('%Y-%m-%d %H:%M:%S')
                    mail_content="""
                         Type: %s\n<br/>
                         Tags: %s\n<br/> 
                         Host: %s:%s\n<br/> 
                        Level: %s\n<br/>
                         Item: %s\n<br/>  
                        Value: %s\n<br/> 
                       Message: %s\n<br/> 
                         
                    """ %(db_type,tags,host,port,level,alarm_item,alarm_value,message)
                    result = sendmail.send_mail(mail_to_list,mail_subject,mail_content)
                    if result:
                        send_mail_status=1
                    else:
                        send_mail_status=0
                else:
                    send_mail_status=0
            else:
                send_mail_status=0
 
            if int(send_alarm_sms)==1:
                if send_sms==1:
                   sms_msg='['+level+'] '+db_type+'-'+tags+'-'+server+' '+message+' Time:'+create_time.strftime('%Y-%m-%d %H:%M:%S')
                   send_sms_type = func.get_option('smstype')
                   if send_sms_type == 'fetion':
                      result = sendsms_fx.send_sms(sms_to_list,sms_msg,db_type,tags,host,port,level,alarm_item,alarm_value,message)
                   else:
                      result = sendsms_api.send_sms(sms_to_list,sms_msg,db_type,tags,host,port,level,alarm_item,alarm_value,message)

                   if result:
                      send_sms_status=1
                   else:
                      send_sms_status=0
                else:
                   send_sms_status=0  
            else:
                send_sms_status=0

            try:
                sql="insert into alarm_history(server_id,tags,host,port,create_time,db_type,alarm_item,alarm_value,level,message,send_mail,send_mail_to_list,send_sms,send_sms_to_list,send_mail_status,send_sms_status) select server_id,tags,host,port,create_time,db_type,alarm_item,alarm_value,level,message,send_mail,send_mail_to_list,send_sms,send_sms_to_list,%s,%s from alarm where id=%s;"
                param=(send_mail_status,send_sms_status,alarm_id)
                func.mysql_exec(sql,param)
            except Exception, e:
                print e 

        func.mysql_exec("delete from alarm",'')

    else:
        pass


def check_send_alarm_sleep():
    send_mail_sleep_time = func.get_option('send_mail_sleep_time')
    send_sms_sleep_time = func.get_option('send_sms_sleep_time')

    if send_mail_sleep_time:
        now_time = time.strftime('%Y-%m-%d %H:%M:%S', time.localtime())
        format="%Y-%m-%d %H:%M:%S"
        send_mail_sleep_time_format = "%d" %(int(send_mail_sleep_time))
        result=datetime.datetime(*time.strptime(now_time,format)[:6])-datetime.timedelta(minutes=int(send_mail_sleep_time_format))
        sleep_alarm_time= result.strftime(format)
        sql="delete from alarm_temp where alarm_type='mail' and create_time <= %s"
        param=(sleep_alarm_time)
        func.mysql_exec(sql,param)

    if send_sms_sleep_time:
        now_time = time.strftime('%Y-%m-%d %H:%M:%S', time.localtime())
        format="%Y-%m-%d %H:%M:%S"
        send_sms_sleep_time_format = "%d" %(int(send_sms_sleep_time))
        result=datetime.datetime(*time.strptime(now_time,format)[:6])-datetime.timedelta(minutes=int(send_sms_sleep_time_format))
        sleep_alarm_time= result.strftime(format)
        sql="delete from alarm_temp where alarm_type='sms' and create_time <= %s"
        param=(sleep_alarm_time)
        func.mysql_exec(sql,param)


def main():

    logger.info("alarm controller started.")
    
    check_send_alarm_sleep()

    monitor_mysql = func.get_option('monitor_mysql')
    monitor_mongodb = func.get_option('monitor_mongodb')
    monitor_oracle = func.get_option('monitor_oracle')
    monitor_redis = func.get_option('monitor_redis')
    monitor_os = func.get_option('monitor_os')
    
    if monitor_mysql=="1":
        get_alarm_mysql_status()
        get_alarm_mysql_replcation()
        
    if monitor_oracle=="1":
        get_alarm_oracle_status()
        get_alarm_oracle_tablespace()
        
    if monitor_mongodb=="1":
        get_alarm_mongodb_status()
        
    if monitor_redis=="1":
        get_alarm_redis_status()

    if monitor_os=="1":
        get_alarm_os_status()
        get_alarm_os_disk()
        get_alarm_os_network()
        
    send_alarm()
    func.update_check_time() 
    logger.info("alarm controller finished.")

if __name__ == '__main__':
    main()










