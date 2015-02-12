#!/usr/bin/env python
#coding:utf-8
import os
import sys
import string
import time
import datetime
import MySQLdb
import pymongo
import bson
import logging
import logging.config
logging.config.fileConfig("etc/logger.ini")
logger = logging.getLogger("lepus")
path='./include'
sys.path.insert(0,path)
import functions as func
from multiprocessing import Process;


def check_mongodb(host,port,user,passwd,server_id,tags):
    try:
        connect = pymongo.Connection(host,int(port))
        db = connect['admin'] 
        db.authenticate(user,passwd)
        serverStatus=connect.admin.command(bson.son.SON([('serverStatus', 1), ('repl', 2)]))
        time.sleep(1)
        serverStatus_2=connect.admin.command(bson.son.SON([('serverStatus', 1), ('repl', 2)]))
        connect = 1
        ok = int(serverStatus['ok'])
        version = serverStatus['version']
        uptime = serverStatus['uptime']
        connections_current = serverStatus['connections']['current']
        connections_available = serverStatus['connections']['available']
        globalLock_activeClients = serverStatus['globalLock']['activeClients']['total']
        globalLock_currentQueue = serverStatus['globalLock']['currentQueue']['total']
        indexCounters_accesses = serverStatus['indexCounters']['accesses']
        indexCounters_hits = serverStatus['indexCounters']['hits']
        indexCounters_misses = serverStatus['indexCounters']['misses']
        indexCounters_resets = serverStatus['indexCounters']['resets']
        indexCounters_missRatio = serverStatus['indexCounters']['missRatio']
        #cursors_totalOpen = serverStatus['cursors']['totalOpen']
        #cursors_timeOut =  serverStatus['cursors']['timeOut']
        dur_commits = serverStatus['dur']['commits']
        dur_journaledMB = serverStatus['dur']['journaledMB']
        dur_writeToDataFilesMB = serverStatus['dur']['writeToDataFilesMB']
        dur_compression = serverStatus['dur']['compression']
        dur_commitsInWriteLock = serverStatus['dur']['commitsInWriteLock']
        dur_earlyCommits = serverStatus['dur']['earlyCommits']
        dur_timeMs_dt = serverStatus['dur']['timeMs']['dt']
        dur_timeMs_prepLogBuffer = serverStatus['dur']['timeMs']['prepLogBuffer']
        dur_timeMs_writeToJournal = serverStatus['dur']['timeMs']['writeToJournal']
        dur_timeMs_writeToDataFiles = serverStatus['dur']['timeMs']['writeToDataFiles']
        dur_timeMs_remapPrivateView = serverStatus['dur']['timeMs']['remapPrivateView']
        mem_bits = serverStatus['mem']['bits']
        mem_resident = serverStatus['mem']['resident']
        mem_virtual = serverStatus['mem']['virtual']
        mem_supported = serverStatus['mem']['supported']
        mem_mapped = serverStatus['mem']['mapped']
        mem_mappedWithJournal = serverStatus['mem']['mappedWithJournal']
        network_bytesIn_persecond = int(serverStatus_2['network']['bytesIn']) - int(serverStatus['network']['bytesIn'])
        network_bytesOut_persecond = int(serverStatus_2['network']['bytesOut']) - int(serverStatus['network']['bytesOut'])
        network_numRequests_persecond = int(serverStatus_2['network']['numRequests']) - int(serverStatus['network']['numRequests'])
        opcounters_insert_persecond = int(serverStatus_2['opcounters']['insert']) - int(serverStatus['opcounters']['insert'])
        opcounters_query_persecond = int(serverStatus_2['opcounters']['query']) - int(serverStatus['opcounters']['query'])
        opcounters_update_persecond = int(serverStatus_2['opcounters']['update']) - int(serverStatus['opcounters']['update'])
        opcounters_delete_persecond = int(serverStatus_2['opcounters']['delete']) - int(serverStatus['opcounters']['delete'])
        opcounters_command_persecond = int(serverStatus_2['opcounters']['command']) - int(serverStatus['opcounters']['command'])

        #replset
        try:
            repl=serverStatus['repl']
            setName=repl['setName']
            replset=1
            if repl['secondary']== True:
                repl_role='secondary'
                repl_role_new='s'
            else:
                repl_role='master'
                repl_role_new='m' 
        except:
            replset=0
            repl_role='master'
            repl_role_new='m'
            pass

        ##################### insert data to mysql server#############################
        sql = "insert into mongodb_status(server_id,host,port,tags,connect,replset,repl_role,ok,uptime,version,connections_current,connections_available,globalLock_currentQueue,globalLock_activeClients,indexCounters_accesses,indexCounters_hits,indexCounters_misses,indexCounters_resets,indexCounters_missRatio,dur_commits,dur_journaledMB,dur_writeToDataFilesMB,dur_compression,dur_commitsInWriteLock,dur_earlyCommits,dur_timeMs_dt,dur_timeMs_prepLogBuffer,dur_timeMs_writeToJournal,dur_timeMs_writeToDataFiles,dur_timeMs_remapPrivateView,mem_bits,mem_resident,mem_virtual,mem_supported,mem_mapped,mem_mappedWithJournal,network_bytesIn_persecond,network_bytesOut_persecond,network_numRequests_persecond,opcounters_insert_persecond,opcounters_query_persecond,opcounters_update_persecond,opcounters_delete_persecond,opcounters_command_persecond) values(%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s);"       
        param = (server_id,host,port,tags,connect,replset,repl_role,ok,uptime,version,connections_current,connections_available,globalLock_currentQueue,globalLock_activeClients,indexCounters_accesses,indexCounters_hits,indexCounters_misses,indexCounters_resets,indexCounters_missRatio,dur_commits,dur_journaledMB,dur_writeToDataFilesMB,dur_compression,dur_commitsInWriteLock,dur_earlyCommits,dur_timeMs_dt,dur_timeMs_prepLogBuffer,dur_timeMs_writeToJournal,dur_timeMs_writeToDataFiles,dur_timeMs_remapPrivateView,mem_bits,mem_resident,mem_virtual,mem_supported,mem_mapped,mem_mappedWithJournal,network_bytesIn_persecond,network_bytesOut_persecond,network_numRequests_persecond,opcounters_insert_persecond,opcounters_query_persecond,opcounters_update_persecond,opcounters_delete_persecond,opcounters_command_persecond)
        func.mysql_exec(sql,param)
        role='m'
        func.update_db_status_init(repl_role_new,version,host,port,tags)

    except Exception, e:
        logger_msg="check mongodb %s:%s : %s" %(host,port,e)
        logger.warning(logger_msg)

        try:
            connect=0
            sql="insert into mongodb_status(server_id,host,port,tags,connect) values(%s,%s,%s,%s,%s)"
            param=(server_id,host,port,tags,connect)
            func.mysql_exec(sql,param)

        except Exception, e:
            logger.error(e)
            sys.exit(1)
        finally:
            sys.exit(1)

    finally:
        func.check_db_status(server_id,host,port,tags,'mongodb')   
        sys.exit(1)



def main():

    func.mysql_exec("insert into mongodb_status_history SELECT *,LEFT(REPLACE(REPLACE(REPLACE(create_time,'-',''),' ',''),':',''),12) from mongodb_status;",'')
    func.mysql_exec('delete from mongodb_status;','')

    #get mongodb servers list
    servers = func.mysql_query('select id,host,port,username,password,tags from db_servers_mongodb where is_delete=0 and monitor=1;')

    logger.info("check mongodb controller started.")

    if servers:
         plist = []
         for row in servers:
             server_id=row[0]
             host=row[1]
             port=row[2]
             username=row[3]
             password=row[4]
             tags=row[5]
             p = Process(target = check_mongodb, args = (host,port,username,password,server_id,tags))
             plist.append(p)
             p.start()

         for p in plist:
             p.join()

    else:
         logger.warning("check mongodb: not found any servers")

    logger.info("check mongodb controller finished.")


if __name__=='__main__':
    main()
