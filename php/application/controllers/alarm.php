<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class Alarm extends Front_Controller {
    function __construct(){
		parent::__construct();
	    $this->load->model("alarm_model","alarm");
	}
    
    public function index(){
        
        !empty($_GET["server_id"]) && $this->db->where("server_id", $_GET["server_id"]);
        !empty($_GET["level"]) && $this->db->where("level", $_GET["level"]);
        $stime = !empty($_GET["stime"])? $_GET["stime"]: date('Y-m-d H:i',time()-3600*24*30);
        $etime = !empty($_GET["etime"])? $_GET["etime"]: date('Y-m-d H:i',time()+60);
        $this->db->where("create_time >=", $stime);
        $this->db->where("create_time <=", $etime);
        
        if(!empty($_GET["stime"])){
            $current_url= 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        }
        else{
            $current_url= 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'?noparam=1';
        }
        
        //分页
		$this->load->library('pagination');
		$config['base_url'] = $current_url;
		$config['total_rows'] = $this->alarm->get_total_rows();
		$config['per_page'] = 30;
		$config['num_links'] = 5;
		$config['page_query_string'] = TRUE;
		$config['use_page_numbers'] = TRUE;
		$this->pagination->initialize($config);
		$offset = !empty($_GET['per_page']) ? $_GET['per_page'] : 1;
        
        !empty($_GET["server_id"]) && $this->db->where("server_id", $_GET["server_id"]);
        !empty($_GET["level"]) && $this->db->where("level", $_GET["level"]);
        $stime = !empty($_GET["stime"])? $_GET["stime"]: date('Y-m-d H:i',time()-3600*24*30);
        $etime = !empty($_GET["etime"])? $_GET["etime"]: date('Y-m-d H:i',time());
        $this->db->where("create_time >=", $stime);
        $this->db->where("create_time <=", $etime);
        $this->db->order_by("create_time", "desc");

        $data['datalist'] = $this->alarm->get_total_record_paging($config['per_page'],($offset-1)*$config['per_page']);
        
        $setval["level"]=isset($_GET["level"]) ? $_GET["level"] : "";
        $setval["stime"]=$stime;
        $setval["etime"]=$etime;
        $data["setval"]=$setval;
        
        $this->layout->view("alarm/index",$data);
    }
    
}

/* End of file alarm.php */
/* Location: ./application/controllers/alarm.php */