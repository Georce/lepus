<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class redis extends Front_Controller {

    function __construct(){
		parent::__construct();
        $this->load->model('servers_redis_model','server');
        $this->load->model("option_model","option");
		$this->load->model("redis_model","redis");
        $this->load->model("os_model","os");  
	}

        public function index2(){

        $redis_statistics = array();
        $redis_statistics["redis_servers_up"] = $this->db->query("select count(*) as num from redis_status where connect=1")->row()->num;
        $redis_statistics["redis_servers_down"] = $this->db->query("select count(*) as num from redis_status  where connect!=1")->row()->num;
        $data["redis_statistics"] = $redis_statistics;
        //print_r($mysql_statistics);
        $data["redis_versions"] = $this->db->query("select redis_version as versions, count(*) as num from redis_status where redis_version !='0' GROUP BY versions")->result_array();
        
        $data['redis_connected_clients_ranking'] = $this->db->query("select server.host,server.port,status.connected_clients
        value from redis_status status left join db_servers_redis server
on `status`.server_id=`server`.id order by connected_clients desc limit 10;")->result_array();
        $data['redis_used_memory_ranking'] = $this->db->query("select server.host,server.port,status.used_memory
        value from redis_status status left join db_servers_redis server
on `status`.server_id=`server`.id order by used_memory desc limit 10;")->result_array();
       
        $this->layout->view("redis/index",$data);
    }

    
    public function index()
	{
        parent::check_privilege();
        $data["datalist"]=$this->redis->get_status_total_record();

        $setval["host"]=isset($_GET["host"]) ? $_GET["host"] : "";
        $setval["tags"]=isset($_GET["tags"]) ? $_GET["tags"] : "";
        
        $setval["order"]=isset($_GET["order"]) ? $_GET["order"] : "";
        $setval["order_type"]=isset($_GET["order_type"]) ? $_GET["order_type"] : "";
        $data["setval"]=$setval;
  
        $this->layout->view("redis/index",$data);
    }

     public function memory()
        {
        parent::check_privilege();
        $data["datalist"]=$this->redis->get_status_total_record(1);

        $setval["host"]=isset($_GET["host"]) ? $_GET["host"] : "";
        $setval["tags"]=isset($_GET["tags"]) ? $_GET["tags"] : "";
        
        $setval["order"]=isset($_GET["order"]) ? $_GET["order"] : "";
        $setval["order_type"]=isset($_GET["order_type"]) ? $_GET["order_type"] : "";
        $data["setval"]=$setval;
        
        
        $this->layout->view("redis/memory",$data);
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
        
        //图表
        $chart_reslut=array();              
        for($i=$begin_time;$i>=0;$i--){
            $timestamp=time()-60*$i;
            $time= date('YmdHi',$timestamp);
            $has_record = $this->redis->check_has_record($server_id,$time);
            if($has_record){
                $chart_reslut[$i]['time']=date('Y-m-d H:i',$timestamp);
                $dbdata=$this->redis->get_status_chart_record($server_id,$time);
                $chart_reslut[$i]['connected_clients'] = $dbdata['connected_clients'];
                $chart_reslut[$i]['blocked_clients'] = $dbdata['blocked_clients']; 

                $chart_reslut[$i]['keyspace_hits'] = $dbdata['keyspace_hits'];
                $chart_reslut[$i]['keyspace_misses'] = $dbdata['keyspace_misses'];

                $chart_reslut[$i]['expired_keys'] = $dbdata['expired_keys'];
                $chart_reslut[$i]['evicted_keys'] = $dbdata['evicted_keys'];

                $chart_reslut[$i]['rejected_connections'] = $dbdata['rejected_connections'];
                $chart_reslut[$i]['total_commands_processed'] = $dbdata['total_commands_processed'];
                $chart_reslut[$i]['instantaneous_ops_per_sec'] = $dbdata['instantaneous_ops_per_sec'];
                

            }  
        }
        $data['chart_reslut']=$chart_reslut;
    
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
        $data['cur_server_id']=$server_id;
        $data["cur_server"] = $this->server->get_servers($server_id);
        $this->layout->view('redis/chart',$data);
    }

   
   public function replication()
        {
        
        parent::check_privilege();
        $datalist=$this->redis->get_replication_total_record();
        
        if(empty($_GET["search"])){
            $datalist = get_redis_replication_tree($datalist);
        }
        

        $setval["role"]=isset($_GET["role"]) ? $_GET["role"] : "";
        $setval["order"]=isset($_GET["order"]) ? $_GET["order"] : "";
        $setval["order_type"]=isset($_GET["order_type"]) ? $_GET["order_type"] : "";
        $data["setval"]=$setval;
        
        
        $data['datalist']=$datalist;

        $this->layout->view("redis/replication",$data);
        }
    
}

/* End of file redis.php */
/* Location: ./application/controllers/redis.php */