<?php 
class MySQL_model extends CI_Model{

	function insert($table,$data){		
		$this->db->insert($table, $data);
	}   

	function get_total_rows($table){
		$this->db->from($table);
		return $this->db->count_all_results();
	}


    
    function get_total_record($table){
        $query = $this->db->get($table);
		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
	}
    
    function get_total_record_paging($table,$limit,$offset){
        $query = $this->db->get($table,$limit,$offset);
		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
	}
    
    function get_total_record_sql($sql){
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0)
		{
			$result['datalist']=$query->result_array();
            $result['datacount']=$query->num_rows();
            return $result;
		}
    }
    
	
    function get_status_total_record($health=''){
        
        $this->db->select('*');
        $this->db->from('mysql_status');

        if($health==1){
            $this->db->where("connect", 1);
        }

        !empty($_GET["host"]) && $this->db->like("host", $_GET["host"]);
        !empty($_GET["tags"]) && $this->db->like("tags", $_GET["tags"]);

        !empty($_GET["connect"]) && $this->db->where("connect", $_GET["connect"]);
        !empty($_GET["threads_connected"]) && $this->db->where("threads_connected >", (int)$_GET["threads_connected"]);
        !empty($_GET["threads_running"]) && $this->db->where("threads_running >", (int)$_GET["threads_running"]);
        
        if(!empty($_GET["order"]) && !empty($_GET["order_type"])){
            $this->db->order_by($_GET["order"],$_GET["order_type"]);
        }
        else{
            $this->db->order_by('tags asc');
        }
        
        $query = $this->db->get();

        if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
    }
    
    function get_process_total_record(){
        
        $this->db->select('process.*,servers.host as server,servers.port,application.display_name application');
        $this->db->from('mysql_process process');
        $this->db->join('db_servers_mysql servers', 'process.server_id=servers.id', 'left');
        $this->db->join('db_application application', 'servers.application_id=application.id', 'left');
        
        !empty($_GET["application_id"]) && $this->db->where("process.application_id", $_GET["application_id"]);
        !empty($_GET["server_id"]) && $this->db->where("process.server_id", $_GET["server_id"]);
        if(!empty($_GET["sleep"]) && $_GET["sleep"]=1){
            $this->db->where("process.command","Sleep");
        }
        else{
            $this->db->where("process.command <>","Sleep");
			$this->db->where("process.status <>","");
        }

        $query = $this->db->get();
        if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
    }
    
    function get_replication_total_record(){
        
        $this->db->select('repl.*,servers.host,servers.port,servers.tags');
        $this->db->from('mysql_replication repl');
        $this->db->join('db_servers_mysql servers', 'repl.server_id=servers.id', 'left');
        
        !empty($_GET["host"]) && $this->db->like("repl.host", $_GET["host"]);
        !empty($_GET["tags"]) && $this->db->like("repl.tags", $_GET["tags"]);

        if(!empty($_GET["role"]) ){
            $this->db->where($_GET["role"], 1);
        }
        !empty($_GET["delay"]) && $this->db->where("delay >", (int)$_GET["delay"]);
        if(!empty($_GET["order"]) && !empty($_GET["order_type"])){
            $this->db->order_by($_GET["order"],$_GET["order_type"]);
        }
        
        $query = $this->db->get();
        if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
    }
    
    function get_bigtable_total_record(){
        
        $this->db->select('*');
        $this->db->from('mysql_bigtable');
        
        !empty($_GET["host"]) && $this->db->like("host", $_GET["host"]);
        !empty($_GET["tags"]) && $this->db->like("tags", $_GET["tags"]);
        
        $this->db->order_by('table_size','desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
    }
    
    
    
    function get_slowquery_total_rows($server_id){
	    if($server_id && $server_id!=0){
            $ext = ' and b.serverid_max='.$server_id;
        }
        else{
            $ext='';
        }
        
		$this->db->select('*');
        $this->db->from("mysql_slow_query_review a");
        $this->db->join("mysql_slow_query_review_history b", "a.checksum=b.checksum $ext ",'');
		return $this->db->count_all_results();
	}
    
 
	
    function get_slowquery_total_record($limit,$offset,$server_id){
        if($server_id && $server_id!=0){
            $ext = ' and b.serverid_max='.$server_id;
        }
        else{
            $ext='';
        }
        
        $this->db->select('a.checksum,a.fingerprint,a.sample,a.first_seen,a.last_seen,
b.serverid_max,b.db_max,b.user_max,b.ts_min,b.ts_max,sum(b.ts_cnt) ts_cnt, sum(b.Query_time_sum)/sum(b.ts_cnt) Query_time_avg, max(b.Query_time_max) Query_time_max, min(b.Query_time_min) Query_time_min,b.Query_time_sum Query_time_sum,
max(b.Lock_time_max) Lock_time_max, min(b.Lock_time_min) Lock_time_min,sum(b.Lock_time_sum) Lock_time_sum');
        $this->db->from("mysql_slow_query_review a");
        $this->db->join("mysql_slow_query_review_history b", "a.checksum=b.checksum $ext ",'');
		$this->db->group_by('a.checksum');
        $this->db->order_by('Query_time_sum','desc');
        
        $this->db->limit($limit,$offset);
        
        $query = $this->db->get();
        if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
    }
    
    function get_slowquery_record_top10($server_id,$begin_time,$end_time){
   
        $this->db->where("last_seen >=", $begin_time);
        $this->db->where("last_seen <=", $end_time);
        $this->db->select('s.*,sh.*');
        $this->db->from("mysql_slow_query_review s");
        $this->db->join("mysql_slow_query_review_history sh", "s.checksum=sh.checksum and sh.serverid_max=$server_id",'');
        $this->db->group_by('s.checksum');
        $this->db->order_by('Query_time_sum','desc');
        $this->db->limit(10);
        
        $query = $this->db->get();
        if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
    }
    
     
    
   

	function get_slowquery_record_by_checksum($checksum){
	   
	    $this->db->select('s.*,sh.*');
        $this->db->from("mysql_slow_query_review s");
        $this->db->join("mysql_slow_query_review_history sh", 's.checksum=sh.checksum');
		$this->db->where('s.checksum',$checksum);
        $query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			return $query->row_array();
		}
	}
    
    function get_slowquery_analyze_day($server_id){
        if($server_id && $server_id!=0){
            $ext = '_'.$server_id;
        }
        else{
            $ext='';
        }
        $query=$this->db->query("select * from (select DATE_FORMAT(last_seen,'%Y-%m-%d') as days,count(*) as count from mysql_slow_query_review$ext  group by days order by days desc limit 10) as total order by days asc ;");
        if ($query->num_rows() > 0)
        {
           return $query->result_array(); 
        }
    }
    
    
    function get_total_host(){
        $query=$this->db->query("select host  from mysql_status order by host;");
        if ($query->num_rows() > 0)
        {
           return $query->result_array(); 
        }
    }
    
    function get_total_application(){
        $query=$this->db->query("select application from mysql_status group by application order by application;");
        if ($query->num_rows() > 0)
        {
           return $query->result_array(); 
        }
    }

	function get_status_chart_record($server_id,$time){
        $query=$this->db->query("select * from mysql_status_history  where server_id=$server_id and YmdHi=$time limit 1; ");
        if ($query->num_rows() > 0)
        {
           return $query->row_array(); 
        }
    }
    
    

    
    function get_replication_chart_record($server_id,$time){
        $query=$this->db->query("select slave_io_run,slave_sql_run,delay from mysql_replication_history where server_id=$server_id and YmdHi=$time limit 1; ");
        if ($query->num_rows() > 0)
        {
           return $query->row_array(); 
        }
    }
    
    function get_mysql_info_by_server_id($server_id){
        $query=$this->db->query("select * from mysql_status_history where server_id=$server_id order by id desc limit 1;");
        if ($query->num_rows() > 0)
        {
           return $query->row_array(); 
        }
    }
    
    function get_bigtable_chart_record($server_id,$table_name,$time){
        $query=$this->db->query("select table_size from mysql_bigtable_history where server_id=$server_id and table_name='$table_name' and Ymd=$time order by id desc limit 1; ");
        if ($query->num_rows() > 0)
        {
           return $query->row_array(); 
        }
    }

    function check_has_record($server_id,$time){
        $query=$this->db->query("select id from mysql_status_history where server_id=$server_id and YmdHi=$time");
        if ($query->num_rows() > 0)
        {
           return true; 
        }
        else{
            return false;
        }
    }
    
    

}

/* End of file mysql_model.php */
/* Location: ./application/models/mysql_model.php */