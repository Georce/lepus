<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class Index extends Front_Controller {
    function __construct(){
		parent::__construct();
        $this->load->model("lepus_model","lepus"); 
	
	}
    
    public function index(){
        //for mysql
        $mysql_statistics = array();
        $data["servers_mysql_count"] = $this->db->query("select count(*) as num from db_servers_mysql where is_delete=0")->row()->num;
		$data["servers_oracle_count"] = $this->db->query("select count(*) as num from db_servers_oracle where is_delete=0")->row()->num;
		$data["servers_mongodb_count"] = $this->db->query("select count(*) as num from db_servers_mongodb where is_delete=0")->row()->num;
		$data["servers_redis_count"] = $this->db->query("select count(*) as num from db_servers_redis where is_delete=0")->row()->num;
		$data["servers_os_count"] = $this->db->query("select count(*) as num from db_servers_os where is_delete=0")->row()->num;
        
        
		$lepus_status=$this->lepus->get_lepus_status();
        $data['lepus_status']=$lepus_status;
        
        $setval["host"]=isset($_GET["host"]) ? $_GET["host"] : "";
        $setval["tags"]=isset($_GET["tags"]) ? $_GET["tags"] : "";
        $setval["db_type"]=isset($_GET["db_type"]) ? $_GET["db_type"] : "";
        $setval["order"]=isset($_GET["order"]) ? $_GET["order"] : "";
        $setval["order_type"]=isset($_GET["order_type"]) ? $_GET["order_type"] : "";
        $data["setval"]=$setval;

        //$data['db_status'] = $this->db->query("select db_status.* from db_status where db_status.db_type in('mysql', 'oracle', 'mongodb', 'redis') order by db_status.db_type_sort asc,db_status.host asc, db_status.tags asc,db_status.role asc;")->result_array();
        $data['db_status'] = $this->lepus->get_db_status();
        
        $this->layout->view("index/index",$data);
    }
    

    
}

/* End of file index.php */
/* Location: ./application/controllers/index.php */