<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class Servers_redis extends Front_Controller {
    function __construct(){
		parent::__construct();
        $this->load->model('servers_redis_model','servers');
        $this->load->model('servers_os_model','servers_os');
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
        
        $sql="select * from db_servers_redis   where is_delete=0 $ext_where order by id asc";
        
        $result=$this->servers->get_total_record_sql($sql);
        $data["datalist"]=$result['datalist'];
        $data["datacount"]=$result['datacount'];
        
        $this->layout->view("servers_redis/index",$data);
    }
    
    /**
     * 回收站
     */
    public function trash(){
        parent::check_privilege();
        $sql="select * from db_servers_redis  where is_delete=1 order by id asc";
		$result=$this->servers->get_total_record_sql($sql);
        $data["datalist"]=$result['datalist'];
        $data["datacount"]=$result['datacount'];
        $this->layout->view("servers_redis/trash",$data);
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
            $this->form_validation->set_rules('port',  'lang:port', 'trim|required|min_length[4]|max_length[6]|integer');
			$this->form_validation->set_rules('password',  'lang:password', 'trim');
			$this->form_validation->set_rules('tags',  'lang:tags', 'trim|required');
			$this->form_validation->set_rules('threshold_warning_connected_clients',  'lang:alarm_threshold', 'trim|required|integer');
			$this->form_validation->set_rules('threshold_critical_connected_clients',  'lang:alarm_threshold', 'trim|required|integer');
			$this->form_validation->set_rules('threshold_warning_command_processed',  'lang:alarm_threshold', 'trim|required|integer');
			$this->form_validation->set_rules('threshold_critical_command_processed',  'lang:alarm_threshold', 'trim|required|integer');
			$this->form_validation->set_rules('threshold_warning_blocked_clients',  'lang:alarm_threshold', 'trim|required|integer');
			$this->form_validation->set_rules('threshold_critical_blocked_clients',  'lang:alarm_threshold', 'trim|required|integer');
			if ($this->form_validation->run() == FALSE)
			{
				$data['error_code']='validation_error';
			}
			else
			{
					$data['error_code']=0;
					$data = array(
						'host'=>$this->input->post('host'),
						'port'=>$this->input->post('port'),
						'password'=>$this->input->post('password'),
					    'tags'=>$this->input->post('tags'),
                        'monitor'=>$this->input->post('monitor'),
                        'send_mail'=>$this->input->post('send_mail'),
						'send_sms'=>$this->input->post('send_sms'),
                        'send_mail_to_list'=>$this->input->post('send_mail_to_list'),
						'send_sms_to_list'=>$this->input->post('send_sms_to_list'),
						'alarm_connected_clients'=>$this->input->post('alarm_connected_clients'),
						'alarm_command_processed'=>$this->input->post('alarm_command_processed'),
						'alarm_blocked_clients'=>$this->input->post('alarm_blocked_clients'),
						'threshold_warning_connected_clients'=>$this->input->post('threshold_warning_connected_clients'),
						'threshold_warning_command_processed'=>$this->input->post('threshold_warning_command_processed'),
						'threshold_warning_blocked_clients'=>$this->input->post('threshold_warning_blocked_clients'),
						'threshold_critical_connected_clients'=>$this->input->post('threshold_critical_connected_clients'),
						'threshold_critical_command_processed'=>$this->input->post('threshold_critical_command_processed'),
						'threshold_critical_blocked_clients'=>$this->input->post('threshold_critical_blocked_clients'),
					);
					$this->servers->insert($data);
                    redirect(site_url('servers_redis/index'));
            }
        }
    
        $this->layout->view("servers_redis/add",$data);
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
            $this->form_validation->set_rules('port',  'lang:port', 'trim|required|min_length[4]|max_length[6]|integer');
			$this->form_validation->set_rules('password',  'lang:password', 'trim');
			$this->form_validation->set_rules('tags',  'lang:tags', 'trim|required');
			$this->form_validation->set_rules('threshold_warning_connected_clients',  'lang:alarm_threshold', 'trim|required|integer');
			$this->form_validation->set_rules('threshold_critical_connected_clients',  'lang:alarm_threshold', 'trim|required|integer');
			$this->form_validation->set_rules('threshold_warning_command_processed',  'lang:alarm_threshold', 'trim|required|integer');
			$this->form_validation->set_rules('threshold_critical_command_processed',  'lang:alarm_threshold', 'trim|required|integer');
			$this->form_validation->set_rules('threshold_warning_blocked_clients',  'lang:alarm_threshold', 'trim|required|integer');
			$this->form_validation->set_rules('threshold_critical_blocked_clients',  'lang:alarm_threshold', 'trim|required|integer');
			
			if ($this->form_validation->run() == FALSE)
			{
				$data['error_code']='validation_error';
			}
			else
			{
					$data['error_code']=0;
					$data = array(
						'host'=>$this->input->post('host'),
						'port'=>$this->input->post('port'),
						'password'=>$this->input->post('password'),
					    'tags'=>$this->input->post('tags'),
                        'monitor'=>$this->input->post('monitor'),
                        'send_mail'=>$this->input->post('send_mail'),
						'send_sms'=>$this->input->post('send_sms'),
                        'send_mail_to_list'=>$this->input->post('send_mail_to_list'),
						'send_sms_to_list'=>$this->input->post('send_sms_to_list'),
						'alarm_connected_clients'=>$this->input->post('alarm_connected_clients'),
						'alarm_command_processed'=>$this->input->post('alarm_command_processed'),
						'alarm_blocked_clients'=>$this->input->post('alarm_blocked_clients'),
						'threshold_warning_connected_clients'=>$this->input->post('threshold_warning_connected_clients'),
						'threshold_warning_command_processed'=>$this->input->post('threshold_warning_command_processed'),
						'threshold_warning_blocked_clients'=>$this->input->post('threshold_warning_blocked_clients'),
						'threshold_critical_connected_clients'=>$this->input->post('threshold_critical_connected_clients'),
						'threshold_critical_command_processed'=>$this->input->post('threshold_critical_command_processed'),
						'threshold_critical_blocked_clients'=>$this->input->post('threshold_critical_blocked_clients'),
					);
					$this->servers->update($data,$id);
					if($this->input->post('monitor')!=1){
						$this->servers->db_status_remove($id);	
					}
                    redirect(site_url('servers_redis/index'));
            }
        }
        
		$record = $this->servers->get_record_by_id($id);
		if(!$id || !$record){
			show_404();
		}
        else{
            $data['record']= $record;
        }
          
        $data["cur_nav"]="servers_edit";
        $this->layout->view("servers_redis/edit",$data);
    }
    
    /**
     * 加入回收站
     */
    function delete($id){
        parent::check_privilege();
        if($id){
            $data = array(
				'is_delete'=>1
            );
		    $this->servers->update($data,$id);
			$this->servers->db_status_remove($id);
            redirect(site_url('servers_redis/index'));
        }
    }
    
    /**
     * 恢复
     */
    function recover($id){
        parent::check_privilege('servers_redis/trash');
        
        if($id){
            $data = array(
				'is_delete'=>0
            );
		    $this->servers->update($data,$id);
            redirect(site_url('servers_redis/trash'));
        }
    }  
    
    /**
     * 彻底删除
     */
    function forever_delete($id){
        parent::check_privilege('servers_redis/trash');
        if($id){
            //检查该数据是否是回收站数据
            $record = $this->servers->get_record_by_id($id);
            $is_delete = $record['is_delete'];
            if($is_delete==1){
                $this->servers->delete($id);
            }
            redirect(site_url('servers_redis/trash'));
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
              $port = $this->input->post('port_'.$n);
			  $password = $this->input->post('password_'.$n);
              $tags = $this->input->post('tags_'.$n);
              if(!empty($host) && !empty($port) &&  !empty($tags)){
                 
                 $data['error_code']=0;
					$data = array(
                        'host'=>$host,
						'port'=>$port,
						'password'=>$password,
						'tags'=>$tags,
                        'monitor'=>$this->input->post('monitor_'.$n),
                        'send_mail'=>$this->input->post('send_mail_'.$n),
						'send_sms'=>$this->input->post('send_sms_'.$n),
                        'alarm_connected_clients'=>$this->input->post('alarm_connected_clients_'.$n),
                        'alarm_command_processed'=>$this->input->post('alarm_command_processed_'.$n),
						'alarm_blocked_clients'=>$this->input->post('alarm_blocked_clients_'.$n),
					);
					$this->servers->insert($data);
              }
		   }
           redirect(site_url('servers_redis/index'));
        }

        $this->layout->view("servers_redis/batch_add",$data);
     }
    
    
}

/* End of file servers_redis.php */
/* Location: ./servers/controllers/servers_redis.php */