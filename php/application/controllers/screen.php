<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class Screen extends Front_Controller {

    function __construct(){
		parent::__construct();
		
	}
    

    public function index(){

    	$mysql_statistics = array();
        $mysql_statistics["mysql_servers_up"] = $this->db->query("select count(*) as num from mysql_status where connect=1")->row()->num;
        $mysql_statistics["mysql_servers_down"] = $this->db->query("select count(*) as num from mysql_status  where connect!=1")->row()->num;
        $mysql_statistics["master_mysql_instance"] = $this->db->query("select count(*) as num from mysql_replication where is_master=1")->row()->num;
        $mysql_statistics["slave_mysql_instance"] = $this->db->query("select count(*) as num from mysql_replication where is_slave=1")->row()->num;
        
        $mysql_statistics["normal_mysql_replication"] = $this->db->query("select count(*) as num from mysql_replication where is_slave=1 and (slave_io_run='Yes' and slave_sql_run='Yes') ")->row()->num;
        $mysql_statistics["exception_mysql_replication"] = $this->db->query("select count(*) as num from mysql_replication where is_slave=1 and  (slave_io_run!='Yes' or slave_sql_run!='Yes') ")->row()->num;
        
        $data["mysql_statistics"] = $mysql_statistics;
        //print_r($mysql_statistics);
        $data["mysql_versions"] = $this->db->query("select version as versions, count(*) as num from mysql_status where version !='0' GROUP BY versions")->result_array();
        
        $data['mysql_qps_ranking'] = $this->db->query("select server.host,server.port,status.queries_persecond
        value from mysql_status status left join db_servers_mysql server
on `status`.server_id=`server`.id order by queries_persecond desc limit 10;")->result_array();
        $data['mysql_tps_ranking'] = $this->db->query("select server.host,server.port,status.transaction_persecond value from mysql_status status left join db_servers_mysql server
on `status`.server_id=`server`.id order by transaction_persecond desc limit 10;")->result_array();
        $data['mysql_threads_connected_ranking'] = $this->db->query("select server.host,server.port,status.threads_connected value from mysql_status status left join db_servers_mysql server
on `status`.server_id=`server`.id order by threads_connected desc limit 10;")->result_array();
        $data['mysql_threads_running_ranking'] = $this->db->query("select server.host,server.port,status.threads_running value from mysql_status status left join db_servers_mysql server
on `status`.server_id=`server`.id order by threads_running desc limit 10;")->result_array();
//print_r($data['mysql_thread_ranking']);
        
        $data['last_alarmlist'] = $this->db->query("select * from  alarm_history   order by create_time desc limit 8;")->result_array();

        $data["cur_nav"]="screen";

        $this->layoutfull->view("screen/index",$data);
    }


    function ajax_get_cpu(){
         $data = $this->db->query("SELECT os.tags, (100-SUBSTRING_INDEX(avg(cpu_idle_time),'.',1)) cpu_used_time,SUBSTRING_INDEX(avg(cpu_idle_time),'.',1) cpu_idle_time 
FROM (SELECT * FROM os_status_history WHERE create_time>=ADDDATE(NOW(),INTERVAL -5 MINUTE) order BY create_time DESC) his
JOIN db_servers_os os ON his.ip=os.host and his.snmp=1
group by ip order by cpu_idle_time asc limit 10;")->result_array();
         $result = array();
         foreach($data as $item){
                $result['category'][] = $item['tags'];
                $result['series']['used'][] = $item['cpu_used_time'];
                $result['series']['idle'][] = $item['cpu_idle_time'];
         }
         $php_json = json_encode($result); 
         print_r($php_json) ;

    }
    


   function ajax_get_net(){
         $data = $this->db->query("select os.tags,TRUNCATE(avg(his.in_bytes+his.out_bytes)/1024,0) bytes
FROM os_net_history  his
JOIN db_servers_os os ON his.ip=os.host 
WHERE his.create_time>=ADDDATE(NOW(),INTERVAL -5 MINUTE)
GROUP BY os.tags
ORDER BY bytes DESC limit 10")->result_array();
         $result = array();
         foreach($data as $item){
                $result['category'][] = $item['tags'];
                $result['series']['bytes'][] = $item['bytes'];
              
         }
         $php_json = json_encode($result); 
         print_r($php_json) ;

    }


    function ajax_get_diskio(){
         $data = $this->db->query("select os.tags,TRUNCATE(sum(his.disk_io_writes),0) io_writes,TRUNCATE(avg(his.disk_io_reads),0) io_reads
FROM os_diskio_history  his
JOIN db_servers_os os ON his.ip=os.host 
WHERE his.create_time>=ADDDATE(NOW(),INTERVAL -5 MINUTE)
GROUP BY os.tags
ORDER BY io_writes DESC limit 10;")->result_array();
         $result = array();
         foreach($data as $item){
                $result['category'][] = $item['tags'];
                $result['series']['io_writes'][] = $item['io_writes'];
                $result['series']['io_reads'][] = $item['io_reads'];
         }
         $php_json = json_encode($result); 
         print_r($php_json) ;

    }


    function ajax_get_alarm(){
         $data_array = $this->db->query("select * from  alarm_history WHERE create_time>=ADDDATE(NOW(),INTERVAL -6 Hour)  order by create_time desc limit 8;")->result_array();
         
         $table_header="
        <table class='table table-bordered table-condensed' style='font-family: 微软雅黑;'>
        <tr>
        <td><center>".$this->lang->line('host')."</center></td>
        <td><center>".$this->lang->line('tags')."</center></td>
        <td><center>".$this->lang->line('type')."</center></td>
        <td><center>".$this->lang->line('level')."</center></td>
        <td><center>".$this->lang->line('item')."</center></td>
        <td><center>".$this->lang->line('value')."</center></td>
        <td><center>".$this->lang->line('time')."</center></td>
        </tr>
         ";

          $table_content='';
          foreach($data_array as $record)
          {
             $table_record = "
                <tr ".check_alarm_level_2($record['level'])." >
                <td>".$record['host'].":".$record['port']."</td>
                <td>".$record['tags']." </td>
                <td>".$record['db_type']." </td>
                <td>".$record['level']." </td>
                <td>".$record['alarm_item']." </td>
                <td>".$record['alarm_value']." </td>
                <td>".$record['create_time']." </td>
               </tr>" ;
                
                $table_content = $table_content.$table_record;   
         }

         $table_footer="</table>";
         $table_content = $table_header.$table_content.$table_footer;
        
         print_r($table_content) ;

    }


    function ajax_get_db_waits(){
        //线性图表
        $reslut=array();
        $mysql_data=0;
        $oracle_data=0;
        $mongodb_data=0;
        $redis_data=0;
        $begin_time=8;
        for($i=$begin_time;$i>0;$i--){
            $timestamp=time()-60*$i;
            $time= date('YmdHi',$timestamp);
     
            $result['category'][] = date('H:i',$timestamp);

            $mysql_result = $this->db->query("select temp.sums from (select ymdhi,sum(threads_running) sums from mysql_status_history where connect=1 group by ymdhi order by ymdhi desc limit 10) temp where temp.ymdhi='".$time."'  ")->row();
			if($mysql_result){
                $mysql_data=$mysql_result->sums;
            }

            $oracle_result = $this->db->query("select temp.sums from (select ymdhi,sum(session_actives) sums from oracle_status_history where connect=1 group by ymdhi order by ymdhi desc limit 10) temp where temp.ymdhi='".$time."'  ")->row();
            if($oracle_result){
                $oracle_data=$oracle_result->sums;
            }

            $mongodb_result = $this->db->query("select temp.sums from (select ymdhi,sum(globalLock_activeClients) sums from mongodb_status_history where connect=1 group by ymdhi order by ymdhi desc limit 10) temp where temp.ymdhi='".$time."'  ")->row();
            if($mongodb_result){
                $mongodb_data=$mongodb_result->sums;
            }

            $redis_result = $this->db->query("select ymdhi,temp.sums from (select ymdhi,sum(current_commands_processed) sums from redis_status_history where connect=1 group by ymdhi order by ymdhi desc limit 10) temp where temp.ymdhi='".$time."'  ")->row();
            if($redis_result){
                $redis_data=$redis_result->sums;
            }
           

            $result['series']['mysql_waits'][] = $mysql_data;
            $result['series']['oracle_waits'][] = $oracle_data;
            $result['series']['mongodb_waits'][] = $mongodb_data;
            $result['series']['redis_waits'][] = $redis_data;
            
        }
        
        $php_json = json_encode($result); 
        print_r($php_json) ;
    }
    
	function ajax_get_mysql(){
         $data = $this->db->query("select tags,threads_running,threads_waits from mysql_status status where status.connect=1  order by status.threads_running desc limit 10;")->result_array();
         $result = array();
         foreach($data as $item){
                $result['category'][] = $item['tags'];
                $result['series']['threads_running'][] = $item['threads_running'];
                $result['series']['threads_waits'][] = $item['threads_waits'];
         }
         $php_json = json_encode($result); 
         print_r($php_json) ;

    }

    function ajax_get_oracle(){
         $data = $this->db->query("select tags,session_actives,session_waits from oracle_status status where status.connect=1  order by status.session_actives desc limit 10;")->result_array();
         $result = array();
         foreach($data as $item){
                $result['category'][] = $item['tags'];
                $result['series']['session_actives'][] = $item['session_actives'];
                $result['series']['session_waits'][] = $item['session_waits'];
         }
         $php_json = json_encode($result); 
         print_r($php_json) ;

    }

    function ajax_get_mongodb(){
         $data = $this->db->query("select tags,connections_current from mongodb_status status where status.connect=1  order by status.connections_current desc limit 10;")->result_array();
         $result = array();
         foreach($data as $item){
                $result['category'][] = $item['tags'];
                $result['series']['connections_current'][] = $item['connections_current'];

         }
         $php_json = json_encode($result); 
         print_r($php_json) ;

    }

}



/* End of file widget.php */
/* Location: ./application/controllers/widget.php */