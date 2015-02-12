<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class Servers_os extends Front_Controller {
    function __construct(){
		parent::__construct();
        $this->load->model('servers_os_model','servers');
		$this->load->library('form_validation');
	
	}
    
    /**
     * 首页
     */
    public function index(){
        parent::check_privilege();
        
        $host=isset($_GET["host"]) ? $_GET["host"] : "";
        $tags=isset($_GET["tags"]) ? $_GET["tags"] : "";
        $setval["tags"]=$tags;
        $setval["host"]=$host;
        $data["setval"]=$setval;
        $ext_where=''; 
        if(!empty($host)){
            $ext_where=$ext_where."  and host like '%$host%' ";
        }
        if(!empty($tags)){
            $ext_where=" and tags like '%$tags%' ";
        }
        
        $sql="select * from db_servers_os  where is_delete=0 $ext_where order by id asc";
        
        $result=$this->servers->get_total_record_sql($sql);
        $data["datalist"]=$result['datalist'];
        $data["datacount"]=$result['datacount'];
        
        $this->layout->view("servers_os/index",$data);
    }
    
    /**
     * 回收站
     */
    public function trash(){
        parent::check_privilege();
        $sql="select * from db_servers_os  where is_delete=1 order by id asc";
        $result=$this->servers->get_total_record_sql($sql);
        $data["datalist"]=$result['datalist'];
        $data["datacount"]=$result['datacount'];
        $this->layout->view("servers_os/trash",$data);
    }
    
    
    /**
     * 添加
     */
    public function add(){
        parent::check_privilege();
        /*
		 * 提交添加后处理
		 */
		$data['error_code']=0;
		if(isset($_POST['submit']) && $_POST['submit']=='add')
        {
			$this->form_validation->set_rules('host',  'lang:host', 'trim|required');
			$this->form_validation->set_rules('community',  'lang:community', 'trim|required');
			$this->form_validation->set_rules('tags',  'lang:tags', 'trim|required');
			$this->form_validation->set_rules('threshold_warning_os_process',  'lang:alarm_threshold', 'trim|required|integer');
			$this->form_validation->set_rules('threshold_warning_os_load',  'lang:alarm_threshold', 'trim|required|integer');
			$this->form_validation->set_rules('threshold_warning_os_cpu',  'lang:alarm_threshold', 'trim|required|integer');
			$this->form_validation->set_rules('threshold_warning_os_network',  'lang:alarm_threshold', 'trim|required|integer');
			$this->form_validation->set_rules('threshold_warning_os_disk',  'lang:alarm_threshold', 'trim|required|integer');
			$this->form_validation->set_rules('threshold_warning_os_memory',  'lang:alarm_threshold', 'trim|required|integer');
			$this->form_validation->set_rules('threshold_critical_os_process',  'lang:alarm_threshold', 'trim|required|integer');
			$this->form_validation->set_rules('threshold_critical_os_load',  'lang:alarm_threshold', 'trim|required|integer');
			$this->form_validation->set_rules('threshold_critical_os_cpu',  'lang:alarm_threshold', 'trim|required|integer');
			$this->form_validation->set_rules('threshold_critical_os_network',  'lang:alarm_threshold', 'trim|required|integer');
			$this->form_validation->set_rules('threshold_critical_os_disk',  'lang:alarm_threshold', 'trim|required|integer');
			$this->form_validation->set_rules('threshold_critical_os_memory',  'lang:alarm_threshold', 'trim|required|integer');

			if ($this->form_validation->run() == FALSE)
			{
				$data['error_code']='validation_error';
			}
			else
			{
					$data['error_code']=0;
					$data = array(
						'host'=>$this->input->post('host'),
						'community'=>$this->input->post('community'),
					    'tags'=>$this->input->post('tags'),
                        'monitor'=>$this->input->post('monitor'),
                        'send_mail'=>$this->input->post('send_mail'),
						'send_sms'=>$this->input->post('send_sms'),
                        'send_mail_to_list'=>$this->input->post('send_mail_to_list'),
						'send_sms_to_list'=>$this->input->post('send_sms_to_list'),
						'alarm_os_process'=>$this->input->post('alarm_os_process'),
						'alarm_os_load'=>$this->input->post('alarm_os_load'),
						'alarm_os_cpu'=>$this->input->post('alarm_os_cpu'),
						'alarm_os_network'=>$this->input->post('alarm_os_network'),
						'alarm_os_disk'=>$this->input->post('alarm_os_disk'),
						'alarm_os_memory'=>$this->input->post('alarm_os_memory'),
						'threshold_warning_os_process'=>$this->input->post('threshold_warning_os_process'),
						'threshold_warning_os_load'=>$this->input->post('threshold_warning_os_load'),
						'threshold_warning_os_cpu'=>$this->input->post('threshold_warning_os_cpu'),
						'threshold_warning_os_network'=>$this->input->post('threshold_warning_os_network'),
						'threshold_warning_os_disk'=>$this->input->post('threshold_warning_os_disk'),
						'threshold_warning_os_memory'=>$this->input->post('threshold_warning_os_memory'),
						'threshold_critical_os_process'=>$this->input->post('threshold_critical_os_process'),
						'threshold_critical_os_load'=>$this->input->post('threshold_critical_os_load'),
						'threshold_critical_os_cpu'=>$this->input->post('threshold_critical_os_cpu'),
						'threshold_critical_os_network'=>$this->input->post('threshold_critical_os_network'),
						'threshold_critical_os_disk'=>$this->input->post('threshold_critical_os_disk'),
						'threshold_critical_os_memory'=>$this->input->post('threshold_critical_os_memory'),
                        'filter_os_disk'=>$this->input->post('filter_os_disk'),
					);
					$this->servers->insert($data);
                    redirect(site_url('servers_os/index'));
            }
        }
        
        $this->layout->view("servers_os/add",$data);
    }
    
    /**
     * 编辑
     */
    public function edit($id){
        parent::check_privilege();
        $id  = !empty($id) ? $id : $_POST['id'];
        /*
		 * 提交编辑后处理
		 */
        $data['error_code']=0;
		if(isset($_POST['submit']) && $_POST['submit']=='edit')
        {
            $this->form_validation->set_rules('host',  'lang:host', 'trim|required');
			$this->form_validation->set_rules('community',  'lang:community', 'trim|required');
			$this->form_validation->set_rules('tags',  'lang:tags', 'trim|required');
			$this->form_validation->set_rules('threshold_warning_os_process',  'lang:alarm_threshold', 'trim|required|integer');
			$this->form_validation->set_rules('threshold_warning_os_load',  'lang:alarm_threshold', 'trim|required|integer');
			$this->form_validation->set_rules('threshold_warning_os_cpu',  'lang:alarm_threshold', 'trim|required|integer');
			$this->form_validation->set_rules('threshold_warning_os_network',  'lang:alarm_threshold', 'trim|required|integer');
			$this->form_validation->set_rules('threshold_warning_os_disk',  'lang:alarm_threshold', 'trim|required|integer');
			$this->form_validation->set_rules('threshold_warning_os_memory',  'lang:alarm_threshold', 'trim|required|integer');
			$this->form_validation->set_rules('threshold_critical_os_process',  'lang:alarm_threshold', 'trim|required|integer');
			$this->form_validation->set_rules('threshold_critical_os_load',  'lang:alarm_threshold', 'trim|required|integer');
			$this->form_validation->set_rules('threshold_critical_os_cpu',  'lang:alarm_threshold', 'trim|required|integer');
			$this->form_validation->set_rules('threshold_critical_os_network',  'lang:alarm_threshold', 'trim|required|integer');
			$this->form_validation->set_rules('threshold_critical_os_disk',  'lang:alarm_threshold', 'trim|required|integer');
			$this->form_validation->set_rules('threshold_critical_os_memory',  'lang:alarm_threshold', 'trim|required|integer');
			
			if ($this->form_validation->run() == FALSE)
			{
				$data['error_code']='validation_error';
			}
			else
			{
					$data['error_code']=0;
					$data = array(
						'host'=>$this->input->post('host'),
						'community'=>$this->input->post('community'),
					    'tags'=>$this->input->post('tags'),
                        'monitor'=>$this->input->post('monitor'),
                        'send_mail'=>$this->input->post('send_mail'),
						'send_sms'=>$this->input->post('send_sms'),
                        'send_mail_to_list'=>$this->input->post('send_mail_to_list'),
						'send_sms_to_list'=>$this->input->post('send_sms_to_list'),
						'alarm_os_process'=>$this->input->post('alarm_os_process'),
						'alarm_os_load'=>$this->input->post('alarm_os_load'),
						'alarm_os_cpu'=>$this->input->post('alarm_os_cpu'),
						'alarm_os_network'=>$this->input->post('alarm_os_network'),
						'alarm_os_disk'=>$this->input->post('alarm_os_disk'),
						'alarm_os_memory'=>$this->input->post('alarm_os_memory'),
						'threshold_warning_os_process'=>$this->input->post('threshold_warning_os_process'),
						'threshold_warning_os_load'=>$this->input->post('threshold_warning_os_load'),
						'threshold_warning_os_cpu'=>$this->input->post('threshold_warning_os_cpu'),
						'threshold_warning_os_network'=>$this->input->post('threshold_warning_os_network'),
						'threshold_warning_os_disk'=>$this->input->post('threshold_warning_os_disk'),
						'threshold_warning_os_memory'=>$this->input->post('threshold_warning_os_memory'),
						'threshold_critical_os_process'=>$this->input->post('threshold_critical_os_process'),
						'threshold_critical_os_load'=>$this->input->post('threshold_critical_os_load'),
						'threshold_critical_os_cpu'=>$this->input->post('threshold_critical_os_cpu'),
						'threshold_critical_os_network'=>$this->input->post('threshold_critical_os_network'),
						'threshold_critical_os_disk'=>$this->input->post('threshold_critical_os_disk'),
						'threshold_critical_os_memory'=>$this->input->post('threshold_critical_os_memory'),
                        'filter_os_disk'=>$this->input->post('filter_os_disk'),
					);
					$this->servers->update($data,$id);
					//echo $this->input->post('host_old');exit;
					$this->servers->remove_hosts($this->input->post('host_old'));
                    redirect(site_url('servers_os/index'));
            }
        }
        
		$record = $this->servers->get_record_by_id($id);
		if(!$id || !$record){
			show_404();
		}
        else{
            $data['record']= $record;
        }

        $this->layout->view("servers_os/edit",$data);
    }
    
    /**
     * 加入回收站
     */
    function delete($id){
        parent::check_privilege();
		$host = $this->servers->get_host_by_id($id);
		if(!$id || !$host)
		{
			show_404();
		}
        else
		{
            $data = array(
				'is_delete'=>1
			);
		    $this->servers->update($data,$id);
			$this->servers->remove_hosts($host);
            redirect(site_url('servers_os/index'));
        }
    }
    
    /**
     * 恢复
     */
    function recover($id){
        parent::check_privilege('servers_os/trash');
        if($id){
            $data = array(
				'is_delete'=>0
            );
		    $this->servers->update($data,$id);
            redirect(site_url('servers_os/trash'));
        }
    }  
    
 
    
    /**
     * 彻底删除
     */
    function forever_delete($id){
        parent::check_privilege('servers_os/trash');
        if($id){
            //检查该数据是否是回收站数据
            $record = $this->servers->get_record_by_id($id);
            $is_delete = $record['is_delete'];
            if($is_delete==1){
                $this->servers->delete($id);
            }
            redirect(site_url('servers_os/trash'));
        }
        
    }
    
    /**
     * 批量添加
     */
     function batch_add(){
        parent::check_privilege();

        /*
		 * 提交批量添加后处理
		 */
		$data['error_code']=0;
		if(isset($_POST['submit']) && $_POST['submit']=='batch_add')
        {
            for($n=1;$n<=10;$n++){
			  $host = $this->input->post('host_'.$n);
              $community = $this->input->post('community_'.$n);
              $tags = $this->input->post('tags_'.$n);
              if(!empty($host) && !empty($community) && !empty($tags)){
                 $data['error_code']=0;
					$data = array(
						'host'=>$this->input->post('host'),
						'community'=>$this->input->post('community'),
					    'tags'=>$this->input->post('tags'),
                        'monitor'=>$this->input->post('monitor'),
                        'send_mail'=>$this->input->post('send_mail'),
						'send_sms'=>$this->input->post('send_sms'),
                        'send_mail_to_list'=>$this->input->post('send_mail_to_list'),
						'send_sms_to_list'=>$this->input->post('send_sms_to_list'),
						'alarm_os_process'=>$this->input->post('alarm_os_process'),
						'alarm_os_load'=>$this->input->post('alarm_os_load'),
						'alarm_os_cpu'=>$this->input->post('alarm_os_cpu'),
						'alarm_os_network'=>$this->input->post('alarm_os_network'),
						'alarm_os_disk'=>$this->input->post('alarm_os_disk'),
						'alarm_os_memory'=>$this->input->post('alarm_os_memory'),
					);
					$this->servers->insert($data);
              }
		   }
           redirect(site_url('servers_os/index'));
        }

        $this->layout->view("servers_os/batch_add",$data);
     }
    
    
}

/* End of file servers_os.php */
/* Location: ./servers/controllers/servers_os.php */