#!/usr/bin/env python
import os
import sys
import string
import time
import datetime
import MySQLdb
import redis
import logging
import logging.config
logging.config.fileConfig("etc/logger.ini")
logger = logging.getLogger("lepus")
path='./include'
sys.path.insert(0,path)
import functions as func
from multiprocessing import Process;

def check_value(info,key):
    try:
        key_tmp = key
        key_tmp = info['%s' %(key)]
        if key_tmp==key:
           key_tmp='-1'
           logger_msg="check redis %s:%s : %s is not supported for this version" %(host,port,key)
           logger.warning(logger_msg)
    except:
        key_tmp='-1'
        logger_msg="check redis %s:%s : %s is not supported for this version" %(host,port,key)
        logger.waring(logger_msg)

    finally:
        return key_tmp
    
     

def check_redis(host,port,passwd,server_id,tags):
    try:
        r=redis.StrictRedis(host=host,port=int(port),password=passwd,db=0,socket_timeout=3,charset='utf-8') 
        info=r.info()
        time.sleep(1)
        info_2=r.info()
        # Server
        redis_version = info['redis_version']
        redis_git_sha1 = info['redis_git_sha1']
        redis_git_dirty = info['redis_git_dirty']
        arch_bits = info['arch_bits']
        multiplexing_api = info['multiplexing_api']
        gcc_version = info['gcc_version']
        process_id = info['process_id']
        uptime_in_seconds = info['uptime_in_seconds']
        uptime_in_days = info['uptime_in_days']
        lru_clock = info['lru_clock']
        os = check_value(info,'os')
        redis_mode = check_value(info,'redis_mode')
        hz = check_value(info,'hz')
        run_id = check_value(info,'run_id')
        tcp_port = check_value(info,'tcp_port')

        # Clients 
        connected_clients = info['connected_clients']
        client_longest_output_list = info['client_longest_output_list']
        client_biggest_input_buf = info['client_biggest_input_buf']
        blocked_clients = info['blocked_clients']
        # Memory
        used_memory = info['used_memory']
        used_memory_human = info['used_memory_human']
        used_memory_rss = info['used_memory_rss']
        used_memory_peak = info['used_memory_peak']
        used_memory_peak_human = info['used_memory_peak_human']
        used_memory_lua = check_value(info,'used_memory_lua')
        mem_fragmentation_ratio = info['mem_fragmentation_ratio']
        mem_allocator = info['mem_allocator']
        # Persistence
        loading = info['loading']
        rdb_changes_since_last_save = check_value(info,'rdb_changes_since_last_save')
        rdb_bgsave_in_progress = check_value(info,'rdb_bgsave_in_progress')
        rdb_last_save_time = check_value(info,'rdb_last_save_time')
        rdb_last_bgsave_status = check_value(info,'rdb_last_bgsave_status')
        rdb_last_bgsave_time_sec = check_value(info,'rdb_last_bgsave_time_sec')
        rdb_current_bgsave_time_sec = check_value(info,'rdb_current_bgsave_time_sec')
        aof_enabled = check_value(info,'aof_enabled')
        aof_rewrite_in_progress = check_value(info,'aof_rewrite_in_progress')
        aof_rewrite_scheduled = check_value(info,'aof_rewrite_scheduled')
        aof_last_rewrite_time_sec = check_value(info,'aof_last_rewrite_time_sec')
        aof_current_rewrite_time_sec = check_value(info,'aof_current_rewrite_time_sec')
        aof_last_bgrewrite_status = check_value(info,'aof_last_bgrewrite_status')
        # Stats
        total_connections_received = check_value(info,'total_connections_received')
        total_commands_processed = check_value(info,'total_commands_processed')
        current_commands_processed = int(info_2['total_commands_processed'] - info['total_commands_processed'])
        instantaneous_ops_per_sec = check_value(info,'instantaneous_ops_per_sec')
        rejected_connections = check_value(info,'rejected_connections')

        expired_keys = info['expired_keys']
        evicted_keys = info['evicted_keys']
        keyspace_hits = info['keyspace_hits']
        keyspace_misses = info['keyspace_misses']
        pubsub_channels = info['pubsub_channels']
        pubsub_patterns = info['pubsub_patterns']
        latest_fork_usec = info['latest_fork_usec']
        # Replication
        role = info['role']
        connected_slaves = info['connected_slaves']
        
        # CPU
        used_cpu_sys = info['used_cpu_sys']
        used_cpu_user = info['used_cpu_user']
        used_cpu_sys_children = info['used_cpu_sys_children']
        used_cpu_user_children = info['used_cpu_user_children']

        # replication
        if role == 'slave':
           #print info
           master_host = info['master_host']
           master_port = info['master_port']
           master_link_status = info['master_link_status']
           master_last_io_seconds_ago = info['master_last_io_seconds_ago']
           master_sync_in_progress = info['master_sync_in_progress']
           #slave_repl_offset = info['slave_repl_offset']
           slave_priority = check_value(info,'slave_priority')
           slave_read_only = check_value(info,'slave_read_only')
           master_server_id = func.mysql_query("SELECT id FROM db_servers_redis WHERE host='%s' AND port='%s' limit 1;" %(master_host,master_port))
           master_server_id = master_server_id[0][0]
           role_new='s'
        else:
           master_host = '-1'
           master_port = '-1'
           master_link_status= '-1'
           master_last_io_seconds_ago = '-1'
           master_sync_in_progress = '-1'
           #slave_repl_offset = '---'
           slave_priority = '-1'
           slave_read_only = '-1'
           master_server_id = '-1'
           role_new='m'

        #add redis_status
        connect=1
        sql = "insert into redis_status(server_id,host,port,tags,redis_role,connect,redis_version,redis_git_sha1,redis_git_dirty,redis_mode,os,arch_bits,multiplexing_api,gcc_version,process_id,run_id,tcp_port,uptime_in_seconds,uptime_in_days,hz,lru_clock,connected_clients,client_longest_output_list,client_biggest_input_buf,blocked_clients,used_memory,used_memory_human,used_memory_rss,used_memory_peak,used_memory_peak_human,used_memory_lua,mem_fragmentation_ratio,mem_allocator,loading,rdb_changes_since_last_save,rdb_bgsave_in_progress,rdb_last_save_time,rdb_last_bgsave_status,rdb_last_bgsave_time_sec,rdb_current_bgsave_time_sec,aof_enabled,aof_rewrite_in_progress,aof_rewrite_scheduled,aof_last_rewrite_time_sec,aof_current_rewrite_time_sec,aof_last_bgrewrite_status,total_connections_received,total_commands_processed,current_commands_processed,instantaneous_ops_per_sec,rejected_connections,expired_keys,evicted_keys,keyspace_hits,keyspace_misses,pubsub_channels,pubsub_patterns,latest_fork_usec,used_cpu_sys,used_cpu_user,used_cpu_sys_children,used_cpu_user_children) values(%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s);"
        param = (server_id,host,port,tags,role,connect,redis_version,redis_git_sha1,redis_git_dirty,redis_mode,os,arch_bits,multiplexing_api,gcc_version,process_id,run_id,tcp_port,uptime_in_seconds,uptime_in_days,hz,lru_clock,connected_clients,client_longest_output_list,client_biggest_input_buf,blocked_clients,used_memory,used_memory_human,used_memory_rss,used_memory_peak,used_memory_peak_human,used_memory_lua,mem_fragmentation_ratio,mem_allocator,loading,rdb_changes_since_last_save,rdb_bgsave_in_progress,rdb_last_save_time,rdb_last_bgsave_status,rdb_last_bgsave_time_sec,rdb_current_bgsave_time_sec,aof_enabled,aof_rewrite_in_progress,aof_rewrite_scheduled,aof_last_rewrite_time_sec,aof_current_rewrite_time_sec,aof_last_bgrewrite_status,total_connections_received,total_commands_processed,current_commands_processed,instantaneous_ops_per_sec,rejected_connections,expired_keys,evicted_keys,keyspace_hits,keyspace_misses,pubsub_channels,pubsub_patterns,latest_fork_usec,used_cpu_sys,used_cpu_user,used_cpu_sys_children,used_cpu_user_children)
        func.mysql_exec(sql,param)

        #add redis_replication
        sql_1 = "insert into redis_replication(server_id,tags,host,port,role,master_server_id,master_host,master_port,master_link_status,master_last_io_seconds_ago,master_sync_in_progress,slave_priority,slave_read_only,connected_slaves) values(%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s);"
        param_1 = (server_id,tags,host,port,role,master_server_id,master_host,master_port,master_link_status,master_last_io_seconds_ago,master_sync_in_progress,slave_priority,slave_read_only,connected_slaves)
        func.mysql_exec(sql_1,param_1)
        func.update_db_status_init(role_new,redis_version,host,port,tags)

    except Exception, e:
        logger_msg="check redis %s:%s : %s" %(host,port,e)
        logger.warning(logger_msg)
   
        try:
            connect=0
            sql="insert into redis_status(server_id,host,port,tags,connect) values(%s,%s,%s,%s,%s)"
            param=(server_id,host,port,tags,connect)
            func.mysql_exec(sql,param)

        except Exception, e:
            logger.error(e)
            sys.exit(1)
        finally:
            sys.exit(1)

    finally:
        func.check_db_status(server_id,host,port,tags,'redis')   
        sys.exit(1)


def main():

    func.mysql_exec("insert into redis_status_history SELECT *,LEFT(REPLACE(REPLACE(REPLACE(create_time,'-',''),' ',''),':',''),12) from redis_status;",'')
    func.mysql_exec('delete from redis_status;','')
    func.mysql_exec("insert into redis_replication_history SELECT *,LEFT(REPLACE(REPLACE(REPLACE(create_time,'-',''),' ',''),':',''),12) from redis_replication;",'')
    func.mysql_exec('delete from redis_replication;','')

    servers = func.mysql_query('select id,host,port,password,tags from db_servers_redis where is_delete=0 and monitor=1;')

    logger.info("check redis controller started.")

    if servers:
         plist = []

         for row in servers:
             server_id=row[0]
             host=row[1]
             port=row[2]
             passwd=row[3]
             tags=row[4]
             p = Process(target = check_redis, args = (host,port,passwd,server_id,tags))
             plist.append(p)
             p.start()

         for p in plist:
             p.join()

    else:
         logger.warning("check redis: not found any servers")

    logger.info("check redis controller finished.")

if __name__=='__main__':
    main()
