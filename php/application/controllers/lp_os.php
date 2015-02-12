<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class Lp_os extends Front_Controller {

    function __construct(){
		parent::__construct();
		$this->load->model("os_model","os");
        $this->load->model('servers_mysql_model','server');
        
	}
    
    public function index2(){
        $data['os_cpu_load_top5'] = $this->db->query("select ip,load_1,load_5,load_15,process value from os_resource order by load_1 desc limit 5;")->result_array();
        $data['os_cpu_usage_top10'] = $this->db->query("select ip,(cpu_user_time+cpu_system_time) value from os_resource order by value desc limit 10;")->result_array();
        $data['os_disk_usage_top10'] = $this->db->query("select ip,mounted,total_size,used_size,avail_size,used_rate from os_diskinfo group by CONCAT(ip,mounted) order by cast(SUBSTRING_INDEX(used_rate,'%',1) as unsigned) desc limit 10;")->result_array();
        $data['os_disk_io_top10'] = $this->db->query("select io.ip,io.fdisk,io.disk_io_reads,io.disk_io_writes,io.create_time,application.display_name application 
from os_diskio io  join db_application application on io.application_id=application.id
group by CONCAT(ip,left(fdisk,3)) order by (disk_io_reads+disk_io_writes)  desc limit 10;")->result_array();
        //print_r($data['mysql_threads_connected_ranking']);
        $this->layout->view("os/index",$data);
    }
    
    
    public function index()
	{
        parent::check_privilege();
        $result=$this->os->get_status_total_record();
        $data['datalist']=$result['datalist'];
        $data['datacount']=$result['datacount'];

        $setval["host"]=isset($_GET["host"]) ? $_GET["host"] : "";
        $setval["tags"]=isset($_GET["tags"]) ? $_GET["tags"] : "";
        
        $data["setval"]=$setval;
        $this->layout->view("os/index",$data);
	}
    
    public function cpu()
	{
        parent::check_privilege();
        $result=$this->os->get_total_resource_record_snmp_on();
        $data['datalist']=$result['datalist'];
        $data['datacount']=$result['datacount'];

        $setval["host"]=isset($_GET["host"]) ? $_GET["host"] : "";
        $setval["tags"]=isset($_GET["tags"]) ? $_GET["tags"] : "";
        $data["setval"]=$setval;
        $this->layout->view("os/cpu",$data);
	}
    
    public function memory()
	{
        parent::check_privilege();
        $result=$this->os->get_total_resource_record_snmp_on();
        $data['datalist']=$result['datalist'];
        $data['datacount']=$result['datacount'];
     
        $setval["host"]=isset($_GET["host"]) ? $_GET["host"] : "";
        $setval["tags"]=isset($_GET["tags"]) ? $_GET["tags"] : "";
        $data["setval"]=$setval;
        $this->layout->view("os/memory",$data);
	}
    
    public function disk()
	{
        parent::check_privilege();
        $result=$this->os->get_total_host();
        if(!empty($result)){
            foreach($result as $key=>$item)
            {
                $host = $item['ip'];
                $result[$key]['diskinfo'] = $this->os->get_diskinfo_record($host);
            }
        }
        
        //print_r($result);
        $data['datalist']=$result;
    
        $setval["host"]=isset($_GET["host"]) ? $_GET["host"] : "";
        $setval["tags"]=isset($_GET["tags"]) ? $_GET["tags"] : "";
        $data["setval"]=$setval;
        $this->layout->view("os/disk",$data);
	}
    
    public function disk_chart(){
        
        parent::check_privilege();
        $host = $this->uri->segment(3);
        $host=!empty($host) ? $host : "";
        $data['diskinfo'] = $this->os->get_disk_record($host);
        $data['cur_host']=$host;
        $this->layout->view('os/disk_chart',$data);
    }
    
    public function disk_io()
	{
        parent::check_privilege();
        $result=$this->os->get_total_diskio_record();
        $data['datalist']=$result['datalist'];
        $data['datacount']=$result['datacount'];
  
        $setval["host"]=isset($_GET["host"]) ? $_GET["host"] : "";
        $setval["tags"]=isset($_GET["tags"]) ? $_GET["tags"] : "";
        $setval["order"]=isset($_GET["order"]) ? $_GET["order"] : "";
        $setval["order_type"]=isset($_GET["order_type"]) ? $_GET["order_type"] : "";
        $data["setval"]=$setval;
        $this->layout->view("os/disk_io",$data);
	}
    
    public function disk_io_chart(){
        
        parent::check_privilege();
        $host = $this->uri->segment(3);
        $host=!empty($host) ? $host : "";
        $begin_time = $this->uri->segment(4);
        $begin_time=!empty($begin_time) ? $begin_time : "30";
        $time_span = $this->uri->segment(5);
        $time_span=!empty($time_span) ? $time_span : "hour";
        
        //图表
        $chart_reslut=array();              
        for($i=$begin_time;$i>=0;$i--){
            $timestamp=time()-60*$i;
            $time= date('YmdHi',$timestamp);
            $chart_reslut[$i]['time']=date('Y-m-d H:i',$timestamp);
            $dbdata=$this->os->get_os_diskio_chart_record($host,$time);
            $chart_reslut[$i]['disk_io_reads'] = $dbdata['disk_io_reads'];
            $chart_reslut[$i]['disk_io_writes'] = $dbdata['disk_io_writes'];

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
        $data['cur_host']=$host;
        $this->layout->view('os/disk_io_chart',$data);
    }
    
    
    
    
    public function chart(){
        
        parent::check_privilege();
        $host = $this->uri->segment(3);
        $host=!empty($host) ? $host : "";
        $begin_time = $this->uri->segment(4);
        $begin_time=!empty($begin_time) ? $begin_time : "30";
        $time_span = $this->uri->segment(5);
        $time_span=!empty($time_span) ? $time_span : "min";
        
        //连接数图表
        $chart_reslut=array();              
        for($i=$begin_time;$i>=0;$i--){
            $timestamp=time()-60*$i;
            $time= date('YmdHi',$timestamp);
			$has_record = $this->os->check_has_record($host,$time);
			if($has_record){
            	$chart_reslut[$i]['time']=date('Y-m-d H:i',$timestamp);
            	$dbdata=$this->os->get_os_chart_record($host,$time);
            	$chart_reslut[$i]['process'] = $dbdata['process'];
            	$chart_reslut[$i]['load_1'] = $dbdata['load_1'];
            	$chart_reslut[$i]['load_5'] = $dbdata['load_5'];
            	$chart_reslut[$i]['load_15'] = $dbdata['load_15'];
            	$chart_reslut[$i]['cpu_user_time'] = $dbdata['cpu_user_time'];
            	$chart_reslut[$i]['cpu_system_time'] = $dbdata['cpu_system_time'];
            	$chart_reslut[$i]['cpu_idle_time'] = $dbdata['cpu_idle_time'];
				$chart_reslut[$i]['mem_usage_rate'] = $dbdata['mem_usage_rate'];
				$chart_reslut[$i]['disk_io_reads_total'] = $dbdata['disk_io_reads_total'];
				$chart_reslut[$i]['disk_io_writes_total'] = $dbdata['disk_io_writes_total'];
				$chart_reslut[$i]['net_in_bytes_total'] = $dbdata['net_in_bytes_total'];
				$chart_reslut[$i]['net_out_bytes_total'] = $dbdata['net_out_bytes_total'];
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
        $data['cur_host']=$host;
        $data['last_record'] = $this->os->get_last_record($host);
		$data['diskinfo'] = $this->os->get_disk_record($host);
        $this->layout->view('os/chart',$data);
    }
    
    
    
}

/* End of file os.php */
/* Location: ./application/controllers/os.php */
