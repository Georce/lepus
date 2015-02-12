<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class Lp_oracle extends Front_Controller {

    function __construct(){
		parent::__construct();
        $this->load->model('servers_oracle_model','server');
        $this->load->model("option_model","option");
		$this->load->model("oracle_model","oracle");
        $this->load->model("os_model","os");  
	}
    
   
	public function index()
	{
        parent::check_privilege();
        $data["datalist"]=$this->oracle->get_status_total_record();

        $setval["host"]=isset($_GET["host"]) ? $_GET["host"] : "";
        $setval["tags"]=isset($_GET["tags"]) ? $_GET["tags"] : "";
        
        $setval["connect"]=isset($_GET["connect"]) ? $_GET["connect"] : "";
        $setval["session_total"]=isset($_GET["session_total"]) ? $_GET["session_total"] : "";
        $setval["session_actives"]=isset($_GET["session_actives"]) ? $_GET["session_actives"] : "";
        $setval["order"]=isset($_GET["order"]) ? $_GET["order"] : "";
        $setval["order_type"]=isset($_GET["order_type"]) ? $_GET["order_type"] : "";
        $data["setval"]=$setval;

        $this->layout->view("oracle/index",$data);
	}
    
   	
    public function tablespace()
	{
        parent::check_privilege();
        $data["datalist"]=$this->oracle->get_tablespace_total_record();

        $setval["host"]=isset($_GET["host"]) ? $_GET["host"] : "";
        $setval["tags"]=isset($_GET["tags"]) ? $_GET["tags"] : "";
        
        $setval["order"]=isset($_GET["order"]) ? $_GET["order"] : "";
        $setval["order_type"]=isset($_GET["order_type"]) ? $_GET["order_type"] : "";
        $data["setval"]=$setval;

        $this->layout->view("oracle/tablespace",$data);
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
        
        //线性图表
        $chart_reslut=array();

        for($i=$begin_time;$i>=0;$i--){
            $timestamp=time()-60*$i;
            $time= date('YmdHi',$timestamp);
            $has_record = $this->oracle->check_has_record($server_id,$time);
            if($has_record){
                    $chart_reslut[$i]['time']=date('Y-m-d H:i',$timestamp);
                    $dbdata=$this->oracle->get_status_chart_record($server_id,$time);
                    $chart_reslut[$i]['session_total'] = $dbdata['session_total'];
                    $chart_reslut[$i]['session_actives'] = $dbdata['session_actives'];
                    $chart_reslut[$i]['session_waits'] = $dbdata['session_waits'];
                    $chart_reslut[$i]['processes'] = $dbdata['processes'];
                    $chart_reslut[$i]['session_logical_reads_persecond'] = $dbdata['session_logical_reads_persecond'];
                    $chart_reslut[$i]['physical_reads_persecond'] = $dbdata['physical_reads_persecond'];
                    $chart_reslut[$i]['physical_writes_persecond'] = $dbdata['physical_writes_persecond'];
                    $chart_reslut[$i]['physical_read_io_requests_persecond'] = $dbdata['physical_read_io_requests_persecond'];
                    $chart_reslut[$i]['physical_write_io_requests_persecond'] = $dbdata['physical_write_io_requests_persecond'];
                    $chart_reslut[$i]['db_block_changes_persecond'] = $dbdata['db_block_changes_persecond'];
                    $chart_reslut[$i]['os_cpu_wait_time'] = $dbdata['os_cpu_wait_time'];
                    $chart_reslut[$i]['logons_persecond'] = $dbdata['logons_persecond'];
                    $chart_reslut[$i]['logons_current'] = $dbdata['logons_current'];
                    $chart_reslut[$i]['opened_cursors_persecond'] = $dbdata['opened_cursors_persecond'];
                    $chart_reslut[$i]['opened_cursors_current'] = $dbdata['opened_cursors_current'];
                    $chart_reslut[$i]['user_commits_persecond'] = $dbdata['user_commits_persecond'];
                    $chart_reslut[$i]['user_rollbacks_persecond'] = $dbdata['user_rollbacks_persecond'];
                    $chart_reslut[$i]['user_calls_persecond'] = $dbdata['user_calls_persecond'];

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
        $this->layout->view('oracle/chart',$data);
    }
    
   
    
    
}

/* End of file oracle.php */
/* Location: ./application/controllers/oracle.php */
