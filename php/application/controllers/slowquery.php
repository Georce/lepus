<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class Slowquery extends Front_Controller {
    function __construct(){
		parent::__construct();
	    $this->load->model('application_model','app');
        $this->load->model('servers_model','server');
        $this->load->model("option_model","option");
        $this->load->model("slowquery_model","slowquery");
	}
    
    public function index(){
        
        $data["server"]=$servers=$this->server->get_total_slowquery_server();
        //print_r($servers);exit;
        
        $server_id=isset($_GET["server_id"]) ? $_GET["server_id"] : "";
        if(empty($server_id)){
            if(!empty($servers)){
            $server_id=$servers[0]['id'];
            }
            else{
                $server_id=0;
            }
        }
        
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
        
        //分页
		$this->load->library('pagination');
		$config['base_url'] = $current_url;
		$config['total_rows'] = $this->slowquery->get_total_rows($server_id);
		$config['per_page'] = 50;
		$config['num_links'] = 5;
		$config['page_query_string'] = TRUE;
		$config['use_page_numbers'] = TRUE;
		$this->pagination->initialize($config);
		$offset = !empty($_GET['per_page']) ? $_GET['per_page'] : 1;
        
        
        $stime = !empty($_GET["stime"])? $_GET["stime"]: date('Y-m-d H:i',time()-3600*24*7);
        $etime = !empty($_GET["etime"])? $_GET["etime"]: date('Y-m-d H:i',time());
        $this->db->where("last_seen >=", $stime);
        $this->db->where("last_seen <=", $etime);
        $setval["stime"]=$stime;
        $setval["etime"]=$etime;
        
        
        $order = !empty($_GET["order"])? $_GET["order"]: 'last_seen';
        $order_type = !empty($_GET["order_type"])? $_GET["order_type"]: 'desc';
        $this->db->order_by($order,$order_type);
        $setval["order"]=$order;
        $setval["order_type"]=$order_type;
        
        $data["datalist"]=$this->slowquery->get_total_record_slowquery($config['per_page'],($offset-1)*$config['per_page'],$server_id);
        
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
            $reslut_day[$i]['num'] = $this->db->query("select count(*) as num from mysql_slow_query_review$ext where DATE_FORMAT(last_seen,'%Y-%m-%d')='$date' ")->row()->num;;
        }
        $data['analyze_day']=$reslut_day;
        //月图表
        $reslut_month=array();
        for($i=12;$i>=0;$i--){
            $time=time()-3600*24*$i*31;
            $reslut_month[$i]['month']=$date= date('Y-m',$time);
            $reslut_month[$i]['num'] = $this->db->query("select count(*) as num from mysql_slow_query_review$ext where DATE_FORMAT(last_seen,'%Y-%m')='$date' ")->row()->num;;
        }
        $data['analyze_month']=$reslut_month;
        //print_r($reslut_month);exit;

        $setval["server_id"]=$server_id;
        

        $data["setval"]=$setval;
        $data["cur_servers"] = $this->server->get_servers($server_id);
        
        $data["cur_nav"]="slowquery_index";
        $this->layout->view("slowquery/index",$data);
    }
    
    public function detail(){
        $checksum=$this->uri->segment(3);
        $server_id=$this->uri->segment(4);
        $record = $this->slowquery->get_record_by_checksum($server_id,$checksum);
		if(!$checksum || !$record){
			show_404();
		}
        else{
            $data['record']= $record;
        }
        //print_r($data['record']);
        $data["cur_nav"]="slowquery_index";
        $this->layout->view("slowquery/detail",$data);
    }
    
}

/* End of file slowquery.php */
/* Location: ./application/controllers/slowquery.php */