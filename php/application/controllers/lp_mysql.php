<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class Lp_mySQL extends Front_Controller {

    function __construct(){
		parent::__construct();
        $this->load->model('servers_mysql_model','server');
        $this->load->model("option_model","option");
		$this->load->model("mysql_model","mysql");
        $this->load->model("os_model","os");  
	}
    
    public function index2(){
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
        $this->layout->view("mysql/index",$data);
    }
    

	public function index()
	{
        parent::check_privilege();
        $data["datalist"]=$this->mysql->get_status_total_record();

        $setval["host"]=isset($_GET["host"]) ? $_GET["host"] : "";
        $setval["tags"]=isset($_GET["tags"]) ? $_GET["tags"] : "";
        $setval["connect"]=isset($_GET["connect"]) ? $_GET["connect"] : "";
        $setval["threads_connected"]=isset($_GET["threads_connected"]) ? $_GET["threads_connected"] : "";
        $setval["threads_running"]=isset($_GET["threads_running"]) ? $_GET["threads_running"] : "";
        $setval["order"]=isset($_GET["order"]) ? $_GET["order"] : "";
        $setval["order_type"]=isset($_GET["order_type"]) ? $_GET["order_type"] : "";
        $data["setval"]=$setval;

        $this->layout->view("mysql/index",$data);
	}
    
    public function chart()
    {
        parent::check_privilege('');
        $server_id = $this->uri->segment(3);
        $server_id=!empty($server_id) ? $server_id : "0";
        $begin_time = $this->uri->segment(4);
        $begin_time=!empty($begin_time) ? $begin_time : "30";
        $time_span = $this->uri->segment(5);
        $time_span=!empty($time_span) ? $time_span : "min";


        //饼状图表
        $data=array();   

        $max_connections = $this->db->query("select max_connections as num from mysql_status_history where connect=1 and server_id=$server_id order by id desc limit 1")->row()->num;
        $threads_connected = $this->db->query("select threads_connected as num from mysql_status_history where connect=1 and server_id=$server_id order by id desc limit 1")->row()->num;
        $open_files_limit = $this->db->query("select open_files_limit as num from mysql_status_history where connect=1 and server_id=$server_id order by id desc limit 1")->row()->num;
        $open_files = $this->db->query("select open_files as num from mysql_status_history where connect=1 and server_id=$server_id order by id desc limit 1")->row()->num;
        $table_open_cache = $this->db->query("select table_open_cache as num from mysql_status_history where connect=1 and server_id=$server_id order by id desc limit 1")->row()->num;
        $open_tables = $this->db->query("select open_tables as num from mysql_status_history where connect=1 and server_id=$server_id order by id desc limit 1")->row()->num;
        
        $data['connections_used'] = $threads_connected;
        $data['connections_unused'] = $max_connections - $threads_connected;
        $data['open_files_used'] = $open_files;
        $data['open_files_unused'] = $open_files_limit - $open_files;
        $data['open_tables_used'] = $open_tables;
        $data['open_tables_unused'] = $table_open_cache - $open_tables;
        
        //线性图表
        $chart_reslut=array();

        for($i=$begin_time;$i>=0;$i--){
            $timestamp=time()-60*$i;
            $time= date('YmdHi',$timestamp);
            $has_record = $this->mysql->check_has_record($server_id,$time);
            if($has_record){
                    $chart_reslut[$i]['time']=date('Y-m-d H:i',$timestamp);
                    $dbdata=$this->mysql->get_status_chart_record($server_id,$time);
                    $chart_reslut[$i]['threads_running'] = $dbdata['threads_running'];
                    $chart_reslut[$i]['threads_connected'] = $dbdata['threads_connected'];
                    $chart_reslut[$i]['threads_created'] = $dbdata['threads_created'];
                    $chart_reslut[$i]['threads_cached'] = $dbdata['threads_cached'];
                    $chart_reslut[$i]['connections'] = $dbdata['connections'];
                    $chart_reslut[$i]['aborted_clients'] = $dbdata['aborted_clients'];
                    $chart_reslut[$i]['aborted_connects'] = $dbdata['aborted_connects'];
                    $chart_reslut[$i]['connections_persecond'] = $dbdata['connections_persecond'];
                    $chart_reslut[$i]['com_select_persecond'] = $dbdata['com_select_persecond'];
                    $chart_reslut[$i]['com_insert_persecond'] = $dbdata['com_insert_persecond'];
                    $chart_reslut[$i]['com_update_persecond'] = $dbdata['com_update_persecond'];
                    $chart_reslut[$i]['com_delete_persecond'] = $dbdata['com_delete_persecond'];
                    $chart_reslut[$i]['com_commit_persecond'] = $dbdata['com_commit_persecond'];
                    $chart_reslut[$i]['com_rollback_persecond'] = $dbdata['com_rollback_persecond'];
                    $chart_reslut[$i]['QPS'] = $dbdata['queries_persecond'];
                    $chart_reslut[$i]['TPS'] = $dbdata['transaction_persecond'];
                    $chart_reslut[$i]['questions_persecond'] = $dbdata['questions_persecond'];
                    $chart_reslut[$i]['queries_persecond'] = $dbdata['queries_persecond'];
                    $chart_reslut[$i]['bytes_received'] = $dbdata['bytes_received_persecond'];
                    $chart_reslut[$i]['bytes_sent'] = $dbdata['bytes_sent_persecond']; 

                    $chart_reslut[$i]['innodb_buffer_pool_reads_persecond'] = $dbdata['innodb_buffer_pool_reads_persecond'];
                    $chart_reslut[$i]['innodb_buffer_pool_pages_flushed_persecond'] = $dbdata['innodb_buffer_pool_pages_flushed_persecond'];
                    $chart_reslut[$i]['innodb_rows_read_persecond'] = $dbdata['innodb_rows_read_persecond'];
                    $chart_reslut[$i]['innodb_rows_inserted_persecond'] = $dbdata['innodb_rows_inserted_persecond'];
                    $chart_reslut[$i]['innodb_rows_updated_persecond'] = $dbdata['innodb_rows_updated_persecond'];
                    $chart_reslut[$i]['innodb_rows_deleted_persecond'] = $dbdata['innodb_rows_deleted_persecond'];

                    $chart_reslut[$i]['key_buffer_read_rate'] = $dbdata['key_buffer_read_rate'];
                    $chart_reslut[$i]['key_buffer_write_rate'] = $dbdata['key_buffer_write_rate'];
                    $chart_reslut[$i]['key_blocks_used_rate'] = $dbdata['key_blocks_used_rate'];
            }
            
  
        }
        $data['chart_reslut']=$chart_reslut;
        //print_r($chart_reslut);
    
        $chart_option=array();
        if($time_span=='min'){
            $chart_option['formatString']='%H:%M';
        }
        else if($time_span=='hour'){
            $chart_option['formatString']='%H:%M';
        }
        else if($time_span=='day'){
            $chart_option['formatString']='%m/%d %H:%M';
        }
        
        $data['chart_option']=$chart_option;
      
        $data['begin_time']=$begin_time;
        $data['cur_nav']='chart_index';
        $data["server"]=$servers=$this->server->get_total_record_usage();
        $data['cur_server_id']=$server_id;
        $data["cur_server"] = $this->server->get_servers($server_id);
        $this->layout->view('mysql/chart',$data);
    }
    
   	public function key_cache()
	{
        parent::check_privilege();
        $data["datalist"]=$this->mysql->get_status_total_record(1);
        $setval["host"]=isset($_GET["host"]) ? $_GET["host"] : "";
        $setval["tags"]=isset($_GET["tags"]) ? $_GET["tags"] : "";
        $setval["order"]=isset($_GET["order"]) ? $_GET["order"] : "";
        $setval["order_type"]=isset($_GET["order_type"]) ? $_GET["order_type"] : "";
        $data["setval"]=$setval;

        $this->layout->view("mysql/key_cache",$data);
	}
    
    public function key_cache_chart()
    {
        parent::check_privilege();
        $server_id = $this->uri->segment(3);
        $server_id=!empty($server_id) ? $server_id : "0";
        $begin_time = $this->uri->segment(4);
        $begin_time=!empty($begin_time) ? $begin_time : "60";
        $time_span = $this->uri->segment(5);
        $time_span=!empty($time_span) ? $time_span : "hour";
        
        //连接数图表
        $chart_reslut=array();              
        for($i=$begin_time;$i>=0;$i--){
            $timestamp=time()-60*$i;
            $time= date('YmdHi',$timestamp);
            $has_record = $this->mysql->check_has_record($server_id,$time);
            if($has_record){
                $chart_reslut[$i]['time']=date('Y-m-d H:i',$timestamp);
                $dbdata=$this->mysql->get_status_chart_record($server_id,$time);
                $chart_reslut[$i]['key_buffer_read_rate'] = $dbdata['key_buffer_read_rate'];
                $chart_reslut[$i]['key_buffer_write_rate'] = $dbdata['key_buffer_write_rate'];
                $chart_reslut[$i]['key_blocks_used_rate'] = $dbdata['key_blocks_used_rate'];
            }
        }
        $data['chart_reslut']=$chart_reslut;
    
        $chart_option=array();
        if($time_span=='hour'){
            $chart_option['formatString']='%H:%M';
        }
        else if($time_span=='day'){
            $chart_option['formatString']='%m/%d %H:%M';
        }
        
        $data['chart_option']=$chart_option;
        $data['begin_time']=$begin_time;
        $data["server"]=$servers=$this->server->get_total_record_usage();
        $data['cur_server_id']=$server_id;
        $data["cur_server"] = $this->server->get_servers($server_id);
        $this->layout->view('mysql/key_cache_chart',$data);
    }
    
    
    public function innodb()
	{
        parent::check_privilege();
        $data["datalist"]=$this->mysql->get_status_total_record(1);
        $setval["host"]=isset($_GET["host"]) ? $_GET["host"] : "";
        $setval["tags"]=isset($_GET["tags"]) ? $_GET["tags"] : "";
        $setval["order"]=isset($_GET["order"]) ? $_GET["order"] : "";
        $setval["order_type"]=isset($_GET["order_type"]) ? $_GET["order_type"] : "";
        $data["setval"]=$setval;
       
        $this->layout->view("mysql/innodb",$data);
	}
    
    public function innodb_chart()
    {
        parent::check_privilege();
        $server_id = $this->uri->segment(3);
        $server_id=!empty($server_id) ? $server_id : "0";
        $begin_time = $this->uri->segment(4);
        $begin_time=!empty($begin_time) ? $begin_time : "60";
        $time_span = $this->uri->segment(5);
        $time_span=!empty($time_span) ? $time_span : "hour";
        
        //连接数图表
        $chart_reslut=array();              
        for($i=$begin_time;$i>=0;$i--){
            $timestamp=time()-60*$i;
            $time= date('YmdHi',$timestamp);
            $chart_reslut[$i]['time']=date('Y-m-d H:i',$timestamp);
            $dbdata=$this->mysql->get_status_chart_record($server_id,$time);
            $chart_reslut[$i]['innodb_buffer_pool_reads_persecond'] = $dbdata['innodb_buffer_pool_reads_persecond'];
            $chart_reslut[$i]['innodb_buffer_pool_pages_flushed_persecond'] = $dbdata['innodb_buffer_pool_pages_flushed_persecond'];
            $chart_reslut[$i]['innodb_rows_read_persecond'] = $dbdata['innodb_rows_read_persecond'];
            $chart_reslut[$i]['innodb_rows_inserted_persecond'] = $dbdata['innodb_rows_inserted_persecond'];
            $chart_reslut[$i]['innodb_rows_updated_persecond'] = $dbdata['innodb_rows_updated_persecond'];
            $chart_reslut[$i]['innodb_rows_deleted_persecond'] = $dbdata['innodb_rows_deleted_persecond'];

        }
        $data['chart_reslut']=$chart_reslut;
    
        $chart_option=array();
        if($time_span=='hour'){
            $chart_option['formatString']='%H:%M';
        }
        else if($time_span=='day'){
            $chart_option['formatString']='%m/%d %H:%M';
        }
        
        $data['chart_option']=$chart_option;
        $data['begin_time']=$begin_time;
        $data["server"]=$servers=$this->server->get_total_record_usage();
        $data['cur_server_id']=$server_id;
        $data["cur_server"] = $this->server->get_servers($server_id);
        $this->layout->view('mysql/innodb_chart',$data);
    }
    
    public function resource()
	{
        parent::check_privilege();
        $data["datalist"]=$this->mysql->get_status_total_record(1);
        $setval["host"]=isset($_GET["host"]) ? $_GET["host"] : "";
        $setval["tags"]=isset($_GET["tags"]) ? $_GET["tags"] : "";
        $setval["order"]=isset($_GET["order"]) ? $_GET["order"] : "";
        $setval["order_type"]=isset($_GET["order_type"]) ? $_GET["order_type"] : "";
        $data["setval"]=$setval;
       
        $this->layout->view("mysql/resource",$data);
	}
    
    
    
    public function resource_chart()
    {
        parent::check_privilege();
        $server_id = $this->uri->segment(3);
        $server_id=!empty($server_id) ? $server_id : "0";
       
        
        //图表
        $data=array();              
        $max_connections = $this->db->query("select max_connections as num from mysql_status_history where connect=1 and server_id=$server_id order by id desc limit 1")->row()->num;
        $threads_connected = $this->db->query("select threads_connected as num from mysql_status_history where connect=1 and server_id=$server_id order by id desc limit 1")->row()->num;
        $open_files_limit = $this->db->query("select open_files_limit as num from mysql_status_history where connect=1 and server_id=$server_id order by id desc limit 1")->row()->num;
        $open_files = $this->db->query("select open_files as num from mysql_status_history where connect=1 and server_id=$server_id order by id desc limit 1")->row()->num;
        $table_open_cache = $this->db->query("select table_open_cache as num from mysql_status_history where connect=1 and server_id=$server_id order by id desc limit 1")->row()->num;
        $open_tables = $this->db->query("select open_tables as num from mysql_status_history where connect=1 and server_id=$server_id order by id desc limit 1")->row()->num;
        
        $data['connections_used'] = $threads_connected;
        $data['connections_unused'] = $max_connections - $threads_connected;
        $data['open_files_used'] = $open_files;
        $data['open_files_unused'] = $open_files_limit - $open_files;
        $data['open_tables_used'] = $open_tables;
        $data['open_tables_unused'] = $table_open_cache - $open_tables;
        
        $data["server"]=$servers=$this->server->get_total_record_slave();
        $data['cur_server_id']=$server_id;
        $data["cur_server"] = $this->server->get_servers($server_id);
        $this->layout->view('mysql/resource_chart',$data);
    }
   	
    public function replication()
	{
        
        parent::check_privilege();
        $datalist=$this->mysql->get_replication_total_record();
        
        if(empty($_GET["search"])){
            $datalist = get_replication_tree($datalist);
        }
        
        
        $setval["role"]=isset($_GET["role"]) ? $_GET["role"] : "";
        $setval["delay"]=isset($_GET["delay"]) ? $_GET["delay"] : "";
        $setval["order"]=isset($_GET["order"]) ? $_GET["order"] : "";
        $setval["order_type"]=isset($_GET["order_type"]) ? $_GET["order_type"] : "";
        $data["setval"]=$setval;
        
        
        $data['datalist']=$datalist;
        
        $data["cur_nav"]="mysql_replication";
        $this->layout->view("mysql/replication",$data);
	}
    
    
    public function replication_chart(){
        parent::check_privilege('mysql/replication');
        $server_id = $this->uri->segment(3);
        $server_id=!empty($server_id) ? $server_id : "0";
        $begin_time = $this->uri->segment(4);
        $begin_time=!empty($begin_time) ? $begin_time : "60";
        $time_span = $this->uri->segment(5);
        $time_span=!empty($time_span) ? $time_span : "hour";
        
        //连接数图表
        $chart_reslut=array();              
        for($i=$begin_time;$i>=0;$i--){
            $timestamp=time()-60*$i;
            $time= date('YmdHi',$timestamp);
            $chart_reslut[$i]['time']=date('Y-m-d H:i',$timestamp);
            $dbdata=$this->mysql->get_replication_chart_record($server_id,$time);
            $chart_reslut[$i]['delay'] = $dbdata['delay'];   
        }
        $data['chart_reslut']=$chart_reslut;
    
        $chart_option=array();
        if($time_span=='hour'){
            $chart_option['formatString']='%H:%M';
        }
        else if($time_span=='day'){
            $chart_option['formatString']='%m/%d %H:%M';
        }
        
        $data['chart_option']=$chart_option;
        
      
        $data['begin_time']=$begin_time;
        $data['cur_nav']='chart_index';
        $data["server"]=$servers=$this->server->get_total_record_slave();
        $data['cur_server_id']=$server_id;
        $data["cur_server"] = $this->server->get_servers($server_id);
        $this->layout->view('mysql/replication_chart',$data);
    }
    
    public function process()
	{
        parent::check_privilege();
        $data["datalist"]=$this->mysql->get_process_total_record();

        $setval["application_id"]=isset($_GET["application_id"]) ? $_GET["application_id"] : "";
        $setval["server_id"]=isset($_GET["server_id"]) ? $_GET["server_id"] : "";
        $setval["sleep"]=isset($_GET["sleep"]) ? $_GET["sleep"] : 0;
        $data["setval"]=$setval;
        
        $data["server"]=$this->server->get_total_record_usage();
        $data["application"]=$this->app->get_total_record_usage();
        $data["option_kill_process"]=$this->option->get_option_item('kill_process');
        $data["cur_nav"]="mysql_process";
        $this->layout->view("mysql/process",$data);
	}
    
    public function ajax_kill_process(){
        $server_id = $_GET['server_id'];
        $pid = $_GET['pid'];
        if(empty($server_id) || empty($pid)){
            echo "empty";
        }
        else{
            $data=array(
                'server_id'=>$server_id,
                'pid'=>$pid,
                'user_id'=>$this->session->userdata('uid'),
            );
            $this->mysql->insert('mysql_process_killed',$data);
            echo "success";
        }
        
    }
    
    public function slowquery(){
        parent::check_privilege();
        $data["server"]=$servers=$this->server->get_total_slowquery_server();
        
        $server_id=isset($_GET["server_id"]) ? $_GET["server_id"] : "";
        //$server_id=isset($_GET["tags"]) ? $_GET["tags"] : "";
        
        if(!empty($_GET["server_id"])){
            $current_url= 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        }
        else{
            $current_url= 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'?noparam=1';
        }
        
        $stime = !empty($_GET["stime"])? $_GET["stime"]: date('Y-m-d H:i',time()-3600*24*7);
        $etime = !empty($_GET["etime"])? $_GET["etime"]: date('Y-m-d H:i',time());
        $this->db->where("last_seen >=", $stime);
        $this->db->where("last_seen <=", $etime);
        $this->db->where("b.sample !=", 'commit');
        
        //分页
		$this->load->library('pagination');
		$config['base_url'] = $current_url;
		$config['total_rows'] = $this->mysql->get_slowquery_total_rows($server_id);
		$config['per_page'] = 25;
		$config['num_links'] = 5;
		$config['page_query_string'] = TRUE;
		$config['use_page_numbers'] = TRUE;
		$this->pagination->initialize($config);
		$offset = !empty($_GET['per_page']) ? $_GET['per_page'] : 1;
        
        $stime = !empty($_GET["stime"])? $_GET["stime"]: date('Y-m-d H:i',time()-3600*24*7);
        $etime = !empty($_GET["etime"])? $_GET["etime"]: date('Y-m-d H:i',time());
        $this->db->where("last_seen >=", $stime);
        $this->db->where("last_seen <=", $etime);
        $this->db->where("a.sample !=", 'commit');
		$this->db->where("b.db_max !=", 'information_schema');
        $setval["stime"]=$stime;
        $setval["etime"]=$etime;
        
        
        $order = !empty($_GET["order"])? $_GET["order"]: 'last_seen';
        $order_type = !empty($_GET["order_type"])? $_GET["order_type"]: 'desc';
        $this->db->order_by($order,$order_type);
        $setval["order"]=$order;
        $setval["order_type"]=$order_type;
        
        $data["datalist"]=$this->mysql->get_slowquery_total_record($config['per_page'],($offset-1)*$config['per_page'],$server_id);
        
        //慢查询图表
        if($server_id && $server_id!=0){
            $ext = '_'.$server_id;
        }
        else{
            $ext='';
        }
        //日图表
        $reslut_day=array();
        for($i=15;$i>=0;$i--){
            $time=time()-3600*24*$i;
            $reslut_day[$i]['day']=$date= date('Y-m-d',$time);
            $reslut_day[$i]['num'] = $this->db->query("select count(*) as num from mysql_slow_query_review where DATE_FORMAT(last_seen,'%Y-%m-%d')='$date' ")->row()->num;;
        }
        $data['analyze_day']=$reslut_day;
        //月图表
        $reslut_month=array();
        for($i=12;$i>=0;$i--){
            $time=time()-3600*24*$i*31;
            $reslut_month[$i]['month']=$date= date('Y-m',$time);
            $reslut_month[$i]['num'] = $this->db->query("select count(*) as num from mysql_slow_query_review where DATE_FORMAT(last_seen,'%Y-%m')='$date' ")->row()->num;;
        }
        $data['analyze_month']=$reslut_month;
        //print_r($reslut_month);exit;

        $setval["server_id"]=$server_id;

        
        $data["setval"]=$setval;
        $data["cur_servers"] = $this->server->get_servers($server_id);
        
        $this->layout->view("mysql/slowquery",$data);
    }
    
    public function slowquery_detail(){
        parent::check_privilege();
        $checksum=$this->uri->segment(3);
        $record = $this->mysql->get_slowquery_record_by_checksum($checksum);
		if(!$checksum || !$record){
			show_404();
		}
        else{
            $data['record']= $record;
        }
        $setval["server_id"]=$record['serverid_max'];
        $data["setval"]=$setval;
        $this->layout->view("mysql/slowquery_detail",$data);
    }
    
    public function awrreport(){
        parent::check_privilege();
        $setval["begin_time"] =  date('Y-m-d H:i',time()-3600*2);
        $setval["end_time"] =  date('Y-m-d H:i',time());
        $data["setval"]=$setval;
        $data["server"]=$this->server->get_total_record_awr();
        $this->layout->view("mysql/awrreport",$data);
    }
    
    public function awrreport_create(){
        parent::check_privilege('lp_mysql/awrreport');
        $server_id=isset($_POST["server_id"]) ? $_POST["server_id"] : "";
    
        $host = $this->server->get_host_by_id($server_id);
        $begin_time = !empty($_POST["begin_time"])? $_POST["begin_time"]: date('Y-m-d H:i',time()-3600*1);
        $end_time = !empty($_POST["end_time"])? $_POST["end_time"]: date('Y-m-d H:i',time());
        $begin_timestamp = strtotime($begin_time);
        $end_timestamp = strtotime($end_time);
        $time_interval=($end_timestamp-$begin_timestamp)/60;
    
        $os_chart_reslut=array();              
        for($i=0;$i<$time_interval;$i++){
            $timestamp=$begin_timestamp+60*$i;
            $time= date('YmdHi',$timestamp);
            $os_chart_reslut[$i]['time']=date('Y-m-d H:i',$timestamp);
            $dbdata=$this->os->get_os_chart_record($host,$time);
            $os_chart_reslut[$i]['process'] = $dbdata['process'];
            $os_chart_reslut[$i]['load_1'] = $dbdata['load_1'];
            $os_chart_reslut[$i]['load_5'] = $dbdata['load_5'];
            $os_chart_reslut[$i]['load_15'] = $dbdata['load_15'];
            $os_chart_reslut[$i]['cpu_user_time'] = $dbdata['cpu_user_time'];
            $os_chart_reslut[$i]['cpu_system_time'] = $dbdata['cpu_system_time'];
            $os_chart_reslut[$i]['cpu_idle_time'] = $dbdata['cpu_idle_time'];
 
        }
        $data['os_chart_reslut']=$os_chart_reslut;
        
        
        $mysql_chart_reslut=array();                           
        for($i=0;$i<$time_interval;$i++){
            $timestamp=$begin_timestamp+60*$i;
            $time= date('YmdHi',$timestamp);
            $mysql_chart_reslut[$i]['time']=date('Y-m-d H:i',$timestamp);
            $dbdata=$this->mysql->get_status_chart_record($server_id,$time);
            $mysql_chart_reslut[$i]['open_files_limit'] = $dbdata['open_files_limit'];
            $mysql_chart_reslut[$i]['open_files'] = $dbdata['open_files'];
            $mysql_chart_reslut[$i]['table_open_cache'] = $dbdata['table_open_cache'];
            $mysql_chart_reslut[$i]['open_tables'] = $dbdata['open_tables'];
            $mysql_chart_reslut[$i]['max_connections'] = $dbdata['max_connections'];
            $mysql_chart_reslut[$i]['threads_running'] = $dbdata['threads_running'];
            $mysql_chart_reslut[$i]['threads_connected'] = $dbdata['threads_connected'];
            $mysql_chart_reslut[$i]['threads_created'] = $dbdata['threads_created'];
            $mysql_chart_reslut[$i]['threads_cached'] = $dbdata['threads_cached'];
            $mysql_chart_reslut[$i]['connections'] = $dbdata['connections'];
            $mysql_chart_reslut[$i]['aborted_clients'] = $dbdata['aborted_clients'];
            $mysql_chart_reslut[$i]['aborted_connects'] = $dbdata['aborted_connects'];
            $mysql_chart_reslut[$i]['connections_persecond'] = $dbdata['connections_persecond'];
            $mysql_chart_reslut[$i]['com_select_persecond'] = $dbdata['com_select_persecond'];
            $mysql_chart_reslut[$i]['com_insert_persecond'] = $dbdata['com_insert_persecond'];
            $mysql_chart_reslut[$i]['com_update_persecond'] = $dbdata['com_update_persecond'];
            $mysql_chart_reslut[$i]['com_delete_persecond'] = $dbdata['com_delete_persecond'];
            $mysql_chart_reslut[$i]['com_commit_persecond'] = $dbdata['com_commit_persecond'];
            $mysql_chart_reslut[$i]['com_rollback_persecond'] = $dbdata['com_rollback_persecond'];
            $mysql_chart_reslut[$i]['QPS'] = $dbdata['queries_persecond'];
            $mysql_chart_reslut[$i]['TPS'] = $dbdata['transaction_persecond'];
            $mysql_chart_reslut[$i]['questions_persecond'] = $dbdata['questions_persecond'];
            $mysql_chart_reslut[$i]['queries_persecond'] = $dbdata['queries_persecond'];
            $mysql_chart_reslut[$i]['Bytes_received'] = $dbdata['bytes_received_persecond'];
            $mysql_chart_reslut[$i]['Bytes_sent'] = $dbdata['bytes_sent_persecond'];  
        }
        $data['mysql_chart_reslut']=$mysql_chart_reslut;
        
    
        //Top10 SlowSQL      
        $data["top10_slowQuery"]=$this->mysql->get_slowquery_record_top10($server_id,$begin_time,$end_time);
        //print_r($data["top10_slowQuery"]);
        
        $data['mysql_info']=$this->mysql->get_mysql_info_by_server_id($server_id);
        
        $data['begin_time']=$begin_time;
        $data['end_time']=$end_time;
        $data['cur_host']=$host;
        $data["server"]=$this->server->get_total_record_awr();
        $this->load->view("mysql/awrreport_result",$data);
    }
    
    public function bigtable()
	{
        parent::check_privilege();
        $data["datalist"]=$this->mysql->get_bigtable_total_record();

        $setval["host"]=isset($_GET["host"]) ? $_GET["host"] : "";
        $setval["tags"]=isset($_GET["tags"]) ? $_GET["tags"] : "";
        $data["setval"]=$setval;

        $this->layout->view("mysql/bigtable",$data);
	}
    
    public function bigtable_chart(){
        parent::check_privilege();
        $server_id = $this->uri->segment(3);
        $server_id=!empty($server_id) ? $server_id : "0";
        $table_name = $this->uri->segment(4);
        $table_name=!empty($table_name) ? $table_name : "";
    
        //表增长趋势图表
        $chart_reslut=array();              
        for($i=0;$i<30;$i++){
            $timestamp=(time()-3600*24*30)+3600*24*$i;
            $time= date('Ymd',$timestamp);
            //echo $time.'<br/>';
            $chart_reslut[$i]['time']=date('Y-m-d',$timestamp);
            $dbdata=$this->mysql->get_bigtable_chart_record($server_id,$table_name,$time);
            $chart_reslut[$i]['table_size'] = !empty($dbdata['table_size']) ? $dbdata['table_size'] : '0';
        }
        $data['chart_reslut']=$chart_reslut;
    
        //print_r($chart_reslut);
      
        $data['cur_server_id']=$server_id;
        $data['cur_table_name']=$table_name;
        $data["cur_server"] = $this->server->get_servers($server_id);
        $this->layout->view('mysql/bigtable_chart',$data);
    }
    

    
    
}

/* End of file mysql.php */
/* Location: ./application/controllers/mysql.php */
