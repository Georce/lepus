<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class Lp_mongodb extends Front_Controller {

    function __construct(){
		parent::__construct();
        $this->load->model('servers_mongodb_model','server');
        $this->load->model("option_model","option");
		$this->load->model("mongodb_model","mongodb");
        $this->load->model("os_model","os");  
	}

        public function index2(){

        $mongodb_statistics = array();
        $mongodb_statistics["mongodb_servers_up"] = $this->db->query("select count(*) as num from mongodb_status where ok=1")->row()->num;
        $mongodb_statistics["mongodb_servers_down"] = $this->db->query("select count(*) as num from mongodb_status  where ok!=1")->row()->num;
        $data["mongodb_statistics"] = $mongodb_statistics;
        //print_r($mysql_statistics);
        $data["mongodb_versions"] = $this->db->query("select version as versions, count(*) as num from mongodb_status where version !='0' GROUP BY versions")->result_array();
        
        $data['mongodb_connections_current_ranking'] = $this->db->query("select server.host,server.port,status.connections_current
        value from mongodb_status status left join db_servers_mongodb server
on `status`.server_id=`server`.id order by connections_current desc limit 10;")->result_array();
        $data['mongodb_query_ranking'] = $this->db->query("select server.host,server.port,status.opcounters_query_persecond
        value from mongodb_status status left join db_servers_mongodb server
on `status`.server_id=`server`.id order by opcounters_query_persecond desc limit 10;")->result_array();
       
        $this->layout->view("mongodb/index",$data);
    }

    
	public function index()
	{
        parent::check_privilege();
        $data["datalist"]=$this->mongodb->get_status_total_record();

        $setval["host"]=isset($_GET["host"]) ? $_GET["host"] : "";
        $setval["tags"]=isset($_GET["tags"]) ? $_GET["tags"] : "";
        $setval["connections_current"]=isset($_GET["connections_current"]) ? $_GET["connections_current"] : "";
        $setval["opcounters_query_persecond"]=isset($_GET["opcounters_query_persecond"]) ? $_GET["opcounters_query_persecond"] : "";
        $setval["order"]=isset($_GET["order"]) ? $_GET["order"] : "";
        $setval["order_type"]=isset($_GET["order_type"]) ? $_GET["order_type"] : "";
        $data["setval"]=$setval;

        $this->layout->view("mongodb/index",$data);
	}
    
    public function indexes()
	{
        parent::check_privilege();
        $data["datalist"]=$this->mongodb->get_status_total_record(1);
        
        $setval["host"]=isset($_GET["host"]) ? $_GET["host"] : "";
        $setval["tags"]=isset($_GET["tags"]) ? $_GET["tags"] : "";
        $data["setval"]=$setval;
        $this->layout->view("mongodb/indexes",$data);
	}
    
    public function memory()
	{
        parent::check_privilege();
        $data["datalist"]=$this->mongodb->get_status_total_record(1);
        
        $setval["host"]=isset($_GET["host"]) ? $_GET["host"] : "";
        $setval["tags"]=isset($_GET["tags"]) ? $_GET["tags"] : "";
        $data["setval"]=$setval;
        $this->layout->view("mongodb/memory",$data);
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

        $connections_current = $this->db->query("select connections_current as num from mongodb_status_history where connect=1 and server_id=$server_id order by id desc limit 1")->row()->num;
        $connections_available = $this->db->query("select connections_available as num from mongodb_status_history where connect=1 and server_id=$server_id order by id desc limit 1")->row()->num;
        $indexCounters_hits = $this->db->query("select indexCounters_hits as num from mongodb_status_history where connect=1 and server_id=$server_id order by id desc limit 1")->row()->num;
        $indexCounters_misses = $this->db->query("select indexCounters_misses as num from mongodb_status_history where connect=1 and server_id=$server_id order by id desc limit 1")->row()->num;

        
        $data['connections_used'] = $connections_current;
        $data['connections_unused'] = $connections_available;
        $data['indexCounters_hits'] = $indexCounters_hits;
        $data['indexCounters_misses'] = $indexCounters_misses;
 
        
        //图表
        $chart_reslut=array();              
        for($i=$begin_time;$i>=0;$i--){
            $timestamp=time()-60*$i;
            $time= date('YmdHi',$timestamp);
            $has_record = $this->mongodb->check_has_record($server_id,$time);
            if($has_record){
                $chart_reslut[$i]['time']=date('Y-m-d H:i',$timestamp);
                $dbdata=$this->mongodb->get_status_chart_record($server_id,$time);
                $chart_reslut[$i]['connections_current'] = $dbdata['connections_current'];
                $chart_reslut[$i]['connections_available'] = $dbdata['connections_available']; 
                $chart_reslut[$i]['indexCounters_missRatio'] = $dbdata['indexCounters_missRatio'];
                $chart_reslut[$i]['network_bytesIn_persecond'] = $dbdata['network_bytesIn_persecond'];
                $chart_reslut[$i]['network_bytesOut_persecond'] = $dbdata['network_bytesOut_persecond'];
                $chart_reslut[$i]['network_numRequests_persecond'] = $dbdata['network_numRequests_persecond'];
                $chart_reslut[$i]['opcounters_insert_persecond'] = $dbdata['opcounters_insert_persecond'];
                $chart_reslut[$i]['opcounters_query_persecond'] = $dbdata['opcounters_query_persecond'];
                $chart_reslut[$i]['opcounters_update_persecond'] = $dbdata['opcounters_update_persecond'];
                $chart_reslut[$i]['opcounters_delete_persecond'] = $dbdata['opcounters_delete_persecond'];

                $chart_reslut[$i]['indexCounters_missRatio'] = $dbdata['indexCounters_missRatio'];
                $chart_reslut[$i]['indexCounters_accesses'] = $dbdata['indexCounters_accesses'];
                $chart_reslut[$i]['indexCounters_hits'] = $dbdata['indexCounters_hits'];
                $chart_reslut[$i]['indexCounters_misses'] = $dbdata['indexCounters_misses'];
                $chart_reslut[$i]['indexCounters_resets'] = $dbdata['indexCounters_resets'];

                $chart_reslut[$i]['mem_resident'] = $dbdata['mem_resident'];
                $chart_reslut[$i]['mem_virtual'] = $dbdata['mem_virtual'];
                $chart_reslut[$i]['mem_mapped'] = $dbdata['mem_mapped'];
                $chart_reslut[$i]['mem_mappedWithJournal'] = $dbdata['mem_mappedWithJournal'];
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
        $this->layout->view('mongodb/chart',$data);
    }

    public function indexes_chart()
    {
        parent::check_privilege();
        $server_id = $this->uri->segment(3);
        $server_id=!empty($server_id) ? $server_id : "0";
        $begin_time = $this->uri->segment(4);
        $begin_time=!empty($begin_time) ? $begin_time : "60";
        $time_span = $this->uri->segment(5);
        $time_span=!empty($time_span) ? $time_span : "hour";
        
        //图表
        $chart_reslut=array();              
        for($i=$begin_time;$i>=0;$i--){
            $timestamp=time()-60*$i;
            $time= date('YmdHi',$timestamp);
            $has_record = $this->mongodb->check_has_record($server_id,$time);
            if($has_record){
                $chart_reslut[$i]['time']=date('Y-m-d H:i',$timestamp);
                $dbdata=$this->mongodb->get_status_chart_record($server_id,$time); 
                $chart_reslut[$i]['indexCounters_missRatio'] = $dbdata['indexCounters_missRatio'];
                $chart_reslut[$i]['indexCounters_accesses'] = $dbdata['indexCounters_accesses'];
                $chart_reslut[$i]['indexCounters_hits'] = $dbdata['indexCounters_hits'];
                $chart_reslut[$i]['indexCounters_misses'] = $dbdata['indexCounters_misses'];
                $chart_reslut[$i]['indexCounters_resets'] = $dbdata['indexCounters_resets'];
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
        $data['cur_server_id']=$server_id;
        $data["cur_server"] = $this->server->get_servers($server_id);
        $this->layout->view('mongodb/indexes_chart',$data);
    }

    public function memory_chart()
    {
        parent::check_privilege();
        $server_id = $this->uri->segment(3);
        $server_id=!empty($server_id) ? $server_id : "0";
        $begin_time = $this->uri->segment(4);
        $begin_time=!empty($begin_time) ? $begin_time : "60";
        $time_span = $this->uri->segment(5);
        $time_span=!empty($time_span) ? $time_span : "hour";
        
        //图表
        $chart_reslut=array();              
        for($i=$begin_time;$i>=0;$i--){
            $timestamp=time()-60*$i;
            $time= date('YmdHi',$timestamp);
            $has_record = $this->mongodb->check_has_record($server_id,$time);
            if($has_record){
                $chart_reslut[$i]['time']=date('Y-m-d H:i',$timestamp);
                $dbdata=$this->mongodb->get_status_chart_record($server_id,$time); 
                $chart_reslut[$i]['mem_resident'] = $dbdata['mem_resident'];
                $chart_reslut[$i]['mem_virtual'] = $dbdata['mem_virtual'];
                $chart_reslut[$i]['mem_mapped'] = $dbdata['mem_mapped'];
                $chart_reslut[$i]['mem_mappedWithJournal'] = $dbdata['mem_mappedWithJournal'];
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
        $data['cur_server_id']=$server_id;
        $data["cur_server"] = $this->server->get_servers($server_id);
        $this->layout->view('mongodb/memory_chart',$data);
    }
 
    
    
}

/* End of file mongodb.php */
/* Location: ./application/controllers/mongodb.php */
