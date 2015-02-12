#!/usr/bin/env python
#coding:utf-8
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
import lepus_mysql as mysql
from multiprocessing import Process;


def check_mysql(host,port,username,password,server_id,tags):
    try:
        conn=MySQLdb.connect(host=host,user=username,passwd=password,port=int(port),connect_timeout=3,charset='utf8')
        cur=conn.cursor()
        conn.select_db('information_schema')
        #cur.execute('flush hosts;')
        ############################# CHECK MYSQL ####################################################
        mysql_variables = func.get_mysql_variables(cur)
        mysql_status = func.get_mysql_status(cur)       
        time.sleep(1)
        mysql_status_2 = func.get_mysql_status(cur)
        ############################# GET VARIABLES ###################################################
        version = func.get_item(mysql_variables,'version')
        key_buffer_size = func.get_item(mysql_variables,'key_buffer_size')
        sort_buffer_size = func.get_item(mysql_variables,'sort_buffer_size')
        join_buffer_size = func.get_item(mysql_variables,'join_buffer_size')
        max_connections = func.get_item(mysql_variables,'max_connections')
        max_connect_errors = func.get_item(mysql_variables,'max_connect_errors')
        open_files_limit = func.get_item(mysql_variables,'open_files_limit')
        table_open_cache = func.get_item(mysql_variables,'table_open_cache')
        max_tmp_tables = func.get_item(mysql_variables,'max_tmp_tables')
        max_heap_table_size = func.get_item(mysql_variables,'max_heap_table_size')
        max_allowed_packet = func.get_item(mysql_variables,'max_allowed_packet')
        ############################# GET INNODB INFO ##################################################
        #innodb variables
        innodb_version = func.get_item(mysql_variables,'innodb_version')
        innodb_buffer_pool_instances = func.get_item(mysql_variables,'innodb_buffer_pool_instances')
        innodb_buffer_pool_size = func.get_item(mysql_variables,'innodb_buffer_pool_size')
        innodb_doublewrite = func.get_item(mysql_variables,'innodb_doublewrite')
        innodb_file_per_table = func.get_item(mysql_variables,'innodb_file_per_table')
        innodb_flush_log_at_trx_commit = func.get_item(mysql_variables,'innodb_flush_log_at_trx_commit')
        innodb_flush_method = func.get_item(mysql_variables,'innodb_flush_method')
        innodb_force_recovery = func.get_item(mysql_variables,'innodb_force_recovery')
        innodb_io_capacity = func.get_item(mysql_variables,'innodb_io_capacity')
        innodb_read_io_threads = func.get_item(mysql_variables,'innodb_read_io_threads')
        innodb_write_io_threads = func.get_item(mysql_variables,'innodb_write_io_threads')
        #innodb status
        innodb_buffer_pool_pages_total = int(func.get_item(mysql_status,'Innodb_buffer_pool_pages_total'))
        innodb_buffer_pool_pages_data = int(func.get_item(mysql_status,'Innodb_buffer_pool_pages_data'))
        innodb_buffer_pool_pages_dirty = int(func.get_item(mysql_status,'Innodb_buffer_pool_pages_dirty'))
        innodb_buffer_pool_pages_flushed = int(func.get_item(mysql_status,'Innodb_buffer_pool_pages_flushed'))
        innodb_buffer_pool_pages_free = int(func.get_item(mysql_status,'Innodb_buffer_pool_pages_free'))
        innodb_buffer_pool_pages_misc = int(func.get_item(mysql_status,'Innodb_buffer_pool_pages_misc'))
        innodb_page_size = int(func.get_item(mysql_status,'Innodb_page_size'))
        innodb_pages_created = int(func.get_item(mysql_status,'Innodb_pages_created'))
        innodb_pages_read = int(func.get_item(mysql_status,'Innodb_pages_read'))
        innodb_pages_written = int(func.get_item(mysql_status,'Innodb_pages_written'))
        innodb_row_lock_current_waits = int(func.get_item(mysql_status,'Innodb_row_lock_current_waits'))
        #innodb persecond info
        innodb_buffer_pool_read_requests_persecond = int(func.get_item(mysql_status_2,'Innodb_buffer_pool_read_requests')) - int(func.get_item(mysql_status,'Innodb_buffer_pool_read_requests'))
        innodb_buffer_pool_reads_persecond = int(func.get_item(mysql_status_2,'Innodb_buffer_pool_reads')) - int(func.get_item(mysql_status,'Innodb_buffer_pool_reads'))
        innodb_buffer_pool_write_requests_persecond = int(func.get_item(mysql_status_2,'Innodb_buffer_pool_write_requests')) - int(func.get_item(mysql_status,'Innodb_buffer_pool_write_requests'))
        innodb_buffer_pool_pages_flushed_persecond = int(func.get_item(mysql_status_2,'Innodb_buffer_pool_pages_flushed')) - int(func.get_item(mysql_status,'Innodb_buffer_pool_pages_flushed'))
        innodb_rows_deleted_persecond = int(func.get_item(mysql_status_2,'Innodb_rows_deleted')) - int(func.get_item(mysql_status,'Innodb_rows_deleted'))
        innodb_rows_inserted_persecond = int(func.get_item(mysql_status_2,'Innodb_rows_inserted')) - int(func.get_item(mysql_status,'Innodb_rows_inserted'))
        innodb_rows_read_persecond = int(func.get_item(mysql_status_2,'Innodb_rows_read')) - int(func.get_item(mysql_status,'Innodb_rows_read'))
        innodb_rows_updated_persecond = int(func.get_item(mysql_status_2,'Innodb_rows_updated')) - int(func.get_item(mysql_status,'Innodb_rows_updated'))
        ############################# GET STATUS ##################################################
        connect = 1
        uptime = func.get_item(mysql_status,'Uptime')
        open_files = func.get_item(mysql_status,'Open_files')
        open_tables = func.get_item(mysql_status,'Open_tables')
        threads_connected = func.get_item(mysql_status,'Threads_connected')
        threads_running = func.get_item(mysql_status,'Threads_running')
        threads_created = func.get_item(mysql_status,'Threads_created')
        threads_cached = func.get_item(mysql_status,'Threads_cached')
        threads_waits = mysql.get_waits(conn)
        connections = func.get_item(mysql_status,'Connections')
        aborted_clients = func.get_item(mysql_status,'Aborted_clients')
        aborted_connects = func.get_item(mysql_status,'Aborted_connects')
        key_blocks_not_flushed = func.get_item(mysql_status,'Key_blocks_not_flushed')
        key_blocks_unused = func.get_item(mysql_status,'Key_blocks_unused')
        key_blocks_used = func.get_item(mysql_status,'Key_blocks_used')
        ############################# GET STATUS PERSECOND ##################################################
        connections_persecond = int(func.get_item(mysql_status_2,'Connections')) - int(func.get_item(mysql_status,'Connections'))
        bytes_received_persecond = (int(func.get_item(mysql_status_2,'Bytes_received')) - int(func.get_item(mysql_status,'Bytes_received')))/1024
        bytes_sent_persecond = (int(func.get_item(mysql_status_2,'Bytes_sent')) - int(func.get_item(mysql_status,'Bytes_sent')))/1024
        com_select_persecond = int(func.get_item(mysql_status_2,'Com_select')) - int(func.get_item(mysql_status,'Com_select'))
        com_insert_persecond = int(func.get_item(mysql_status_2,'Com_insert')) - int(func.get_item(mysql_status,'Com_insert'))
        com_update_persecond = int(func.get_item(mysql_status_2,'Com_update')) - int(func.get_item(mysql_status,'Com_update'))
        com_delete_persecond = int(func.get_item(mysql_status_2,'Com_delete')) - int(func.get_item(mysql_status,'Com_delete'))
        com_commit_persecond = int(func.get_item(mysql_status_2,'Com_commit')) - int(func.get_item(mysql_status,'Com_commit'))
        com_rollback_persecond = int(func.get_item(mysql_status_2,'Com_rollback')) - int(func.get_item(mysql_status,'Com_rollback'))
        questions_persecond = int(func.get_item(mysql_status_2,'Questions')) - int(func.get_item(mysql_status,'Questions'))
        queries_persecond = int(func.get_item(mysql_status_2,'Queries')) - int(func.get_item(mysql_status,'Queries'))
        transaction_persecond = (int(func.get_item(mysql_status_2,'Com_commit')) + int(func.get_item(mysql_status_2,'Com_rollback'))) - (int(func.get_item(mysql_status,'Com_commit')) + int(func.get_item(mysql_status,'Com_rollback')))
        created_tmp_disk_tables_persecond = int(func.get_item(mysql_status_2,'Created_tmp_disk_tables')) - int(func.get_item(mysql_status,'Created_tmp_disk_tables'))
        created_tmp_files_persecond = int(func.get_item(mysql_status_2,'Created_tmp_files')) - int(func.get_item(mysql_status,'Created_tmp_files'))
        created_tmp_tables_persecond = int(func.get_item(mysql_status_2,'Created_tmp_tables')) - int(func.get_item(mysql_status,'Created_tmp_tables'))
        table_locks_immediate_persecond = int(func.get_item(mysql_status_2,'Table_locks_immediate')) - int(func.get_item(mysql_status,'Table_locks_immediate'))
        table_locks_waited_persecond = int(func.get_item(mysql_status_2,'Table_locks_waited')) - int(func.get_item(mysql_status,'Table_locks_waited'))
        key_read_requests_persecond = int(func.get_item(mysql_status_2,'Key_read_requests')) - int(func.get_item(mysql_status,'Key_read_requests'))
        key_reads_persecond = int(func.get_item(mysql_status_2,'Key_reads')) - int(func.get_item(mysql_status,'Key_reads'))
        key_write_requests_persecond = int(func.get_item(mysql_status_2,'Key_write_requests')) - int(func.get_item(mysql_status,'Key_write_requests'))
        key_writes_persecond = int(func.get_item(mysql_status_2,'Key_writes')) - int(func.get_item(mysql_status,'Key_writes'))
        ############################# GET MYSQL HITRATE ##################################################
        if (string.atof(func.get_item(mysql_status,'Qcache_hits')) + string.atof(func.get_item(mysql_status,'Com_select'))) <> 0:
            query_cache_hitrate = string.atof(func.get_item(mysql_status,'Qcache_hits')) / (string.atof(func.get_item(mysql_status,'Qcache_hits')) + string.atof(func.get_item(mysql_status,'Com_select')))
            query_cache_hitrate =  "%9.2f" %query_cache_hitrate
        else:
            query_cache_hitrate = 0

        if string.atof(func.get_item(mysql_status,'Connections')) <> 0:
            thread_cache_hitrate = 1 - string.atof(func.get_item(mysql_status,'Threads_created')) / string.atof(func.get_item(mysql_status,'Connections'))
            thread_cache_hitrate =  "%9.2f" %thread_cache_hitrate
        else:
            thread_cache_hitrate = 0

        if string.atof(func.get_item(mysql_status,'Key_read_requests')) <> 0:
            key_buffer_read_rate = 1 - string.atof(func.get_item(mysql_status,'Key_reads')) / string.atof(func.get_item(mysql_status,'Key_read_requests'))
            key_buffer_read_rate =  "%9.2f" %key_buffer_read_rate
        else:
            key_buffer_read_rate = 0

        if string.atof(func.get_item(mysql_status,'Key_write_requests')) <> 0:
            key_buffer_write_rate = 1 - string.atof(func.get_item(mysql_status,'Key_writes')) / string.atof(func.get_item(mysql_status,'Key_write_requests'))
            key_buffer_write_rate =  "%9.2f" %key_buffer_write_rate
        else:
            key_buffer_write_rate = 0
        
        if (string.atof(func.get_item(mysql_status,'Key_blocks_used'))+string.atof(func.get_item(mysql_status,'Key_blocks_unused'))) <> 0:
            key_blocks_used_rate = string.atof(func.get_item(mysql_status,'Key_blocks_used')) / (string.atof(func.get_item(mysql_status,'Key_blocks_used'))+string.atof(func.get_item(mysql_status,'Key_blocks_unused')))
            key_blocks_used_rate =  "%9.2f" %key_blocks_used_rate
        else:
            key_blocks_used_rate = 0

        if (string.atof(func.get_item(mysql_status,'Created_tmp_disk_tables'))+string.atof(func.get_item(mysql_status,'Created_tmp_tables'))) <> 0:
            created_tmp_disk_tables_rate = string.atof(func.get_item(mysql_status,'Created_tmp_disk_tables')) / (string.atof(func.get_item(mysql_status,'Created_tmp_disk_tables'))+string.atof(func.get_item(mysql_status,'Created_tmp_tables')))
            created_tmp_disk_tables_rate =  "%9.2f" %created_tmp_disk_tables_rate
        else:
            created_tmp_disk_tables_rate = 0

        if string.atof(max_connections) <> 0:
            connections_usage_rate = string.atof(threads_connected)/string.atof(max_connections)
            connections_usage_rate =  "%9.2f" %connections_usage_rate
        else:
            connections_usage_rate = 0

        if string.atof(open_files_limit) <> 0:            
            open_files_usage_rate = string.atof(open_files)/string.atof(open_files_limit)
            open_files_usage_rate =  "%9.2f" %open_files_usage_rate
        else:
            open_files_usage_rate = 0

        if string.atof(table_open_cache) <> 0:            
            open_tables_usage_rate = string.atof(open_tables)/string.atof(table_open_cache)
            open_tables_usage_rate =  "%9.2f" %open_tables_usage_rate
        else:
            open_tables_usage_rate = 0
  
        #repl
        slave_status=cur.execute('show slave status;')
        if slave_status <> 0:
            role='slave'
            role_new='s'
        else:
            role='master'
            role_new='m'

        ############################# INSERT INTO SERVER ##################################################
        sql = "insert into mysql_status(server_id,host,port,tags,connect,role,uptime,version,max_connections,max_connect_errors,open_files_limit,table_open_cache,max_tmp_tables,max_heap_table_size,max_allowed_packet,open_files,open_tables,threads_connected,threads_running,threads_waits,threads_created,threads_cached,connections,aborted_clients,aborted_connects,connections_persecond,bytes_received_persecond,bytes_sent_persecond,com_select_persecond,com_insert_persecond,com_update_persecond,com_delete_persecond,com_commit_persecond,com_rollback_persecond,questions_persecond,queries_persecond,transaction_persecond,created_tmp_tables_persecond,created_tmp_disk_tables_persecond,created_tmp_files_persecond,table_locks_immediate_persecond,table_locks_waited_persecond,key_buffer_size,sort_buffer_size,join_buffer_size,key_blocks_not_flushed,key_blocks_unused,key_blocks_used,key_read_requests_persecond,key_reads_persecond,key_write_requests_persecond,key_writes_persecond,innodb_version,innodb_buffer_pool_instances,innodb_buffer_pool_size,innodb_doublewrite,innodb_file_per_table,innodb_flush_log_at_trx_commit,innodb_flush_method,innodb_force_recovery,innodb_io_capacity,innodb_read_io_threads,innodb_write_io_threads,innodb_buffer_pool_pages_total,innodb_buffer_pool_pages_data,innodb_buffer_pool_pages_dirty,innodb_buffer_pool_pages_flushed,innodb_buffer_pool_pages_free,innodb_buffer_pool_pages_misc,innodb_page_size,innodb_pages_created,innodb_pages_read,innodb_pages_written,innodb_row_lock_current_waits,innodb_buffer_pool_pages_flushed_persecond,innodb_buffer_pool_read_requests_persecond,innodb_buffer_pool_reads_persecond,innodb_buffer_pool_write_requests_persecond,innodb_rows_read_persecond,innodb_rows_inserted_persecond,innodb_rows_updated_persecond,innodb_rows_deleted_persecond,query_cache_hitrate,thread_cache_hitrate,key_buffer_read_rate,key_buffer_write_rate,key_blocks_used_rate,created_tmp_disk_tables_rate,connections_usage_rate,open_files_usage_rate,open_tables_usage_rate) values(%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s);"
        param = (server_id,host,port,tags,connect,role,uptime,version,max_connections,max_connect_errors,open_files_limit,table_open_cache,max_tmp_tables,max_heap_table_size,max_allowed_packet,open_files,open_tables,threads_connected,threads_running,threads_waits,threads_created,threads_cached,connections,aborted_clients,aborted_connects,connections_persecond,bytes_received_persecond,bytes_sent_persecond,com_select_persecond,com_insert_persecond,com_update_persecond,com_delete_persecond,com_commit_persecond,com_rollback_persecond,questions_persecond,queries_persecond,transaction_persecond,created_tmp_tables_persecond,created_tmp_disk_tables_persecond,created_tmp_files_persecond,table_locks_immediate_persecond,table_locks_waited_persecond,key_buffer_size,sort_buffer_size,join_buffer_size,key_blocks_not_flushed,key_blocks_unused,key_blocks_used,key_read_requests_persecond,key_reads_persecond,key_write_requests_persecond,key_writes_persecond,innodb_version,innodb_buffer_pool_instances,innodb_buffer_pool_size,innodb_doublewrite,innodb_file_per_table,innodb_flush_log_at_trx_commit,innodb_flush_method,innodb_force_recovery,innodb_io_capacity,innodb_read_io_threads,innodb_write_io_threads,innodb_buffer_pool_pages_total,innodb_buffer_pool_pages_data,innodb_buffer_pool_pages_dirty,innodb_buffer_pool_pages_flushed,innodb_buffer_pool_pages_free,innodb_buffer_pool_pages_misc,innodb_page_size,innodb_pages_created,innodb_pages_read,innodb_pages_written,innodb_row_lock_current_waits,innodb_buffer_pool_pages_flushed_persecond,innodb_buffer_pool_read_requests_persecond,innodb_buffer_pool_reads_persecond,innodb_buffer_pool_write_requests_persecond,innodb_rows_read_persecond,innodb_rows_inserted_persecond,innodb_rows_updated_persecond,innodb_rows_deleted_persecond,query_cache_hitrate,thread_cache_hitrate,key_buffer_read_rate,key_buffer_write_rate,key_blocks_used_rate,created_tmp_disk_tables_rate,connections_usage_rate,open_files_usage_rate,open_tables_usage_rate)
        func.mysql_exec(sql,param)
        func.update_db_status_init(role_new,version,host,port,tags)

        #check mysql process
        processlist=cur.execute('select * from information_schema.processlist where DB !="information_schema" and command !="Sleep";')
        if processlist:
            for line in cur.fetchall():
                sql="insert into mysql_processlist(server_id,host,port,tags,pid,p_user,p_host,p_db,command,time,status,info) values(%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)"
                param=(server_id,host,port,tags,line[0],line[1],line[2],line[3],line[4],line[5],line[6],line[7])
                func.mysql_exec(sql,param)

        #check mysql connected
        connected=cur.execute("select SUBSTRING_INDEX(host,':',1) as connect_server, user connect_user,db connect_db, count(SUBSTRING_INDEX(host,':',1)) as connect_count  from information_schema.processlist where db is not null and db!='information_schema' and db !='performance_schema' group by connect_server ;");
        if connected:
            for line in cur.fetchall():
                sql="insert into mysql_connected(server_id,host,port,tags,connect_server,connect_user,connect_db,connect_count) values(%s,%s,%s,%s,%s,%s,%s,%s);"
                param =(server_id,host,port,tags,line[0],line[1],line[2],line[3])
                func.mysql_exec(sql,param)

        #check mysql replication
        master_thread=cur.execute("select * from information_schema.processlist where COMMAND = 'Binlog Dump' or COMMAND = 'Binlog Dump GTID';")
        slave_status=cur.execute('show slave status;')
        datalist=[]
        if master_thread >= 1:
            datalist.append(int(1))
            if slave_status <> 0:
                datalist.append(int(1))
            else:
                datalist.append(int(0))
        else:
            datalist.append(int(0))
            if slave_status <> 0:
                datalist.append(int(1))
            else:
                datalist.append(int(0))


        if slave_status <> 0:
            gtid_mode=cur.execute("select * from information_schema.global_variables where variable_name='gtid_mode';")
            result=cur.fetchone()
            if result:
                gtid_mode=result[1]
            else:
                gtid_mode='OFF'
            datalist.append(gtid_mode)
            read_only=cur.execute("select * from information_schema.global_variables where variable_name='read_only';")
            result=cur.fetchone()
            datalist.append(result[1])
            slave_info=cur.execute('show slave status;')
            result=cur.fetchone()
            master_server=result[1]
            master_port=result[3]
            slave_io_run=result[10]
            slave_sql_run=result[11]
            delay=result[32]
            current_binlog_file=result[9]
            current_binlog_pos=result[21]
            master_binlog_file=result[5]
            master_binlog_pos=result[6]

            datalist.append(master_server)
            datalist.append(master_port)
            datalist.append(slave_io_run)
            datalist.append(slave_sql_run)
            datalist.append(delay)
            datalist.append(current_binlog_file)
            datalist.append(current_binlog_pos)
            datalist.append(master_binlog_file)
            datalist.append(master_binlog_pos)
            datalist.append(0)

        elif master_thread >= 1:
            gtid_mode=cur.execute("select * from information_schema.global_variables where variable_name='gtid_mode';")
            result=cur.fetchone()
            if result:
                gtid_mode=result[1]
            else:
                gtid_mode='OFF'
            datalist.append(gtid_mode)
            read_only=cur.execute("select * from information_schema.global_variables where variable_name='read_only';")
            result=cur.fetchone()
            datalist.append(result[1])
            datalist.append('---')
            datalist.append('---')
            datalist.append('---')
            datalist.append('---')
            datalist.append('---')
            datalist.append('---')
            datalist.append('---')
            master=cur.execute('show master status;')
            master_result=cur.fetchone()
            datalist.append(master_result[0])
            datalist.append(master_result[1])
            binlog_file=cur.execute('show master logs;')
            binlogs=0
            if binlog_file:
                for row in cur.fetchall():
                    binlogs = binlogs + row[1]
                datalist.append(binlogs)
        else:
            datalist=[]

        result=datalist
        if result:
            sql="insert into mysql_replication(server_id,tags,host,port,is_master,is_slave,gtid_mode,read_only,master_server,master_port,slave_io_run,slave_sql_run,delay,current_binlog_file,current_binlog_pos,master_binlog_file,master_binlog_pos,master_binlog_space) values(%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)"
            param=(server_id,tags,host,port,result[0],result[1],result[2],result[3],result[4],result[5],result[6],result[7],result[8],result[9],result[10],result[11],result[12],result[13])
            func.mysql_exec(sql,param)

        cur.close()
        exit

    except MySQLdb.Error,e:
        logger_msg="check mysql %s:%s failure: %d %s" %(host,port,e.args[0],e.args[1])
        logger.warning(logger_msg)
        logger_msg="check mysql %s:%s failure: sleep 3 seconds and check again." %(host,port)
        logger.warning(logger_msg)
        time.sleep(3)
        try:
            conn=MySQLdb.connect(host=host,user=username,passwd=password,port=int(port),connect_timeout=3,charset='utf8')
            cur=conn.cursor()
            conn.select_db('information_schema')
        except MySQLdb.Error,e:
            logger_msg="check mysql second %s:%s failure: %d %s" %(host,port,e.args[0],e.args[1])
            logger.warning(logger_msg)
            connect = 0
            sql="insert into mysql_status(server_id,host,port,tags,connect) values(%s,%s,%s,%s,%s)"
            param=(server_id,host,port,tags,connect)
            func.mysql_exec(sql,param)
   
    try:  
        func.check_db_status(server_id,host,port,tags,'mysql')   
    except Exception, e:
        logger.error(e)
        sys.exit(1)
         
   

def main():

    func.mysql_exec("insert into mysql_status_history SELECT *,LEFT(REPLACE(REPLACE(REPLACE(create_time,'-',''),' ',''),':',''),12) from mysql_status",'')
    func.mysql_exec('delete from mysql_status;','')

    func.mysql_exec("insert into mysql_replication_history SELECT *,LEFT(REPLACE(REPLACE(REPLACE(create_time,'-',''),' ',''),':',''),12) from mysql_replication",'')
    func.mysql_exec('delete from mysql_replication;','')
    #get mysql servers list
    servers = func.mysql_query('select id,host,port,username,password,tags from db_servers_mysql where is_delete=0 and monitor=1;')

    logger.info("check mysql controller started.")

    if servers:
         plist = []
         for row in servers:
             server_id=row[0]
             host=row[1]
             port=row[2]
             username=row[3]
             password=row[4]
             tags=row[5]
             #thread.start_new_thread(check_mysql, (host,port,user,passwd,server_id,application_id))
             #time.sleep(1)
             p = Process(target = check_mysql, args = (host,port,username,password,server_id,tags))
             plist.append(p)
         for p in plist:
             p.start()
         time.sleep(10)
         for p in plist:
             p.terminate()	
         for p in plist:
             p.join()
         
    else:
         logger.warning("check mysql: not found any servers")

    logger.info("check mysql controller finished.")


if __name__=='__main__':
    main()
