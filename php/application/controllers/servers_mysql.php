<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class Servers_mysql extends Front_Controller {
    function __construct(){
		parent::__construct();
        $this->load->model('servers_mysql_model','servers');
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
        
        $sql="select * from db_servers_mysql  where is_delete=0 $ext_where order by id asc";
        
        $result=$this->servers->get_total_record_sql($sql);
        $data["datalist"]=$result['datalist'];
        $data["datacount"]=$result['datacount'];
        $this->layout->view("servers_mysql/index",$data);
    }
    
    /**
     * 回收站
     */
    public function trash(){
        parent::check_privilege();
        $sql="select * from db_servers_mysql  where is_delete=1 order by id asc";
        $result=$this->servers->get_total_record_sql($sql);
        $data["datalist"]=$result['datalist'];
        $data["datacount"]=$result['datacount'];
        $this->layout->view("servers_mysql/trash",$data);
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
            $this->form_validation->set_rules('username',  'lang:username', 'trim|required');
			$this->form_validation->set_rules('password',  'lang:password', 'trim|required');
			$this->form_validation->set_rules('tags',  'lang:tags', 'trim|required');
            $this->form_validation->set_rules('binlog_store_days',  'lang:binlog_store_days', 'trim|required|integer');
            $this->form_validation->set_rules('threshold_warning_threads_connected',  'lang:alarm_threshold', 'trim|required|integer');
            $this->form_validation->set_rules('threshold_warning_threads_running',  'lang:alarm_threshold', 'trim|required|integer');
			$this->form_validation->set_rules('threshold_warning_threads_waits',  'lang:alarm_threshold', 'trim|required|integer');
            $this->form_validation->set_rules('threshold_warning_repl_delay',  'lang:alarm_threshold', 'trim|required|integer');
            $this->form_validation->set_rules('threshold_critical_threads_connected',  'lang:alarm_threshold', 'trim|required|integer');
            $this->form_validation->set_rules('threshold_critical_threads_running',  'lang:alarm_threshold', 'trim|required|integer');
			$this->form_validation->set_rules('threshold_critical_threads_waits',  'lang:alarm_threshold', 'trim|required|integer');
            $this->form_validation->set_rules('threshold_critical_repl_delay',  'lang:alarm_threshold', 'trim|required|integer');
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
						'username'=>$this->input->post('username'),
						'password'=>$this->input->post('password'),
					    'tags'=>$this->input->post('tags'),
                        'monitor'=>$this->input->post('monitor'),
                        'send_mail'=>$this->input->post('send_mail'),
						'send_sms'=>$this->input->post('send_sms'),
                        'slow_query'=>$this->input->post('slow_query'),
                        'send_mail_to_list'=>$this->input->post('send_mail_to_list'),
						'send_sms_to_list'=>$this->input->post('send_sms_to_list'),
                        'send_slowquery_to_list'=>$this->input->post('send_slowquery_to_list'),
                        'bigtable_monitor'=>$this->input->post('bigtable_monitor'),
                        'binlog_auto_purge'=>$this->input->post('binlog_auto_purge'),
                        'binlog_store_days'=>$this->input->post('binlog_store_days'),
                        'alarm_threads_connected'=>$this->input->post('alarm_threads_connected'),
                        'alarm_threads_running'=>$this->input->post('alarm_threads_running'),
						'alarm_threads_waits'=>$this->input->post('alarm_threads_waits'),
                        'alarm_repl_status'=>$this->input->post('alarm_repl_status'),
                        'alarm_repl_delay'=>$this->input->post('alarm_repl_delay'),
                        'threshold_warning_threads_connected'=>$this->input->post('threshold_warning_threads_connected'),
                        'threshold_critical_threads_connected'=>$this->input->post('threshold_critical_threads_connected'),
                        'threshold_warning_threads_running'=>$this->input->post('threshold_warning_threads_running'),
                        'threshold_critical_threads_running'=>$this->input->post('threshold_critical_threads_running'),
						'threshold_warning_threads_waits'=>$this->input->post('threshold_warning_threads_waits'),
                        'threshold_critical_threads_waits'=>$this->input->post('threshold_critical_threads_waits'),
                        'threshold_warning_repl_delay'=>$this->input->post('threshold_warning_repl_delay'),
                        'threshold_critical_repl_delay'=>$this->input->post('threshold_critical_repl_delay'),
					);
					$this->servers->insert($data);
                    redirect(site_url('servers_mysql/index'));
            }
        }
           
        $this->layout->view("servers_mysql/add",$data);
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
            $this->form_validation->set_rules('username',  'lang:username', 'trim|required');
			$this->form_validation->set_rules('password',  'lang:password', 'trim|required');
			$this->form_validation->set_rules('tags',  'lang:tags', 'trim|required');
            $this->form_validation->set_rules('binlog_store_days',  'lang:binlog_store_days', 'trim|required|integer');
            $this->form_validation->set_rules('threshold_warning_threads_connected',  'lang:alarm_threshold', 'trim|required|integer');
            $this->form_validation->set_rules('threshold_warning_threads_running',  'lang:alarm_threshold', 'trim|required|integer');
			$this->form_validation->set_rules('threshold_warning_threads_waits',  'lang:alarm_threshold', 'trim|required|integer');
            $this->form_validation->set_rules('threshold_warning_repl_delay',  'lang:alarm_threshold', 'trim|required|integer');
            $this->form_validation->set_rules('threshold_critical_threads_connected',  'lang:alarm_threshold', 'trim|required|integer');
            $this->form_validation->set_rules('threshold_critical_threads_running',  'lang:alarm_threshold', 'trim|required|integer');
			$this->form_validation->set_rules('threshold_critical_threads_waits',  'lang:alarm_threshold', 'trim|required|integer');
            $this->form_validation->set_rules('threshold_critical_repl_delay',  'lang:alarm_threshold', 'trim|required|integer');
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
						'username'=>$this->input->post('username'),
						'password'=>$this->input->post('password'),
					    'tags'=>$this->input->post('tags'),
                        'monitor'=>$this->input->post('monitor'),
                        'send_mail'=>$this->input->post('send_mail'),
						'send_sms'=>$this->input->post('send_sms'),
                        'slow_query'=>$this->input->post('slow_query'),
                        'send_mail_to_list'=>$this->input->post('send_mail_to_list'),
						'send_sms_to_list'=>$this->input->post('send_sms_to_list'),
                        'send_slowquery_to_list'=>$this->input->post('send_slowquery_to_list'),
                        'bigtable_monitor'=>$this->input->post('bigtable_monitor'),
                        'binlog_auto_purge'=>$this->input->post('binlog_auto_purge'),
                        'binlog_store_days'=>$this->input->post('binlog_store_days'),
                        'alarm_threads_connected'=>$this->input->post('alarm_threads_connected'),
                        'alarm_threads_running'=>$this->input->post('alarm_threads_running'),
						'alarm_threads_waits'=>$this->input->post('alarm_threads_waits'),
                        'alarm_repl_status'=>$this->input->post('alarm_repl_status'),
                        'alarm_repl_delay'=>$this->input->post('alarm_repl_delay'),
                        'threshold_warning_threads_connected'=>$this->input->post('threshold_warning_threads_connected'),
                        'threshold_critical_threads_connected'=>$this->input->post('threshold_critical_threads_connected'),
                        'threshold_warning_threads_running'=>$this->input->post('threshold_warning_threads_running'),
                        'threshold_critical_threads_running'=>$this->input->post('threshold_critical_threads_running'),
						'threshold_warning_threads_waits'=>$this->input->post('threshold_warning_threads_waits'),
                        'threshold_critical_threads_waits'=>$this->input->post('threshold_critical_threads_waits'),
                        'threshold_warning_repl_delay'=>$this->input->post('threshold_warning_repl_delay'),
                        'threshold_critical_repl_delay'=>$this->input->post('threshold_critical_repl_delay'),
					);
					$this->servers->update($data,$id);
					if($this->input->post('monitor')!=1){
						$this->servers->db_status_remove($id);	
					}
                    redirect(site_url('servers_mysql/index'));
            }
        }
        
		$record = $this->servers->get_record_by_id($id);
		if(!$id || !$record){
			show_404();
		}
        else{
            $data['record']= $record;
        }
          
        $this->layout->view("servers_mysql/edit",$data);
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
            redirect(site_url('servers_mysql/index'));
        }
    }
    
    /**
     * 恢复
     */
    function recover($id){
        parent::check_privilege('servers_mysql/trash');
        
        if($id){
            $data = array(
				'is_delete'=>0
            );
		    $this->servers->update($data,$id);
            redirect(site_url('servers_mysql/trash'));
        }
    }  
    
    /**
     * 彻底删除
     */
    function forever_delete($id){
        parent::check_privilege('servers_mysql/trash');
        if($id){
            //检查该数据是否是回收站数据
            $record = $this->servers->get_record_by_id($id);
            $is_delete = $record['is_delete'];
            if($is_delete==1){
                $this->servers->delete($id);
            }
            redirect(site_url('servers_mysql/trash'));
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
			  $username = $this->input->post('username_'.$n);
			  $password = $this->input->post('password_'.$n);
              $tags = $this->input->post('tags_'.$n);
              if(!empty($host) && !empty($port) && !empty($username) && !empty($password) && !empty($tags)){
                 
                 $data['error_code']=0;
					$data = array(
                        'host'=>$host,
						'port'=>$port,
					    'username'=>$username,
						'password'=>$password,
						'tags'=>$tags,
                        'monitor'=>$this->input->post('monitor_'.$n),
                        'send_mail'=>$this->input->post('send_mail_'.$n),
						'send_sms'=>$this->input->post('send_sms_'.$n),
                        'alarm_threads_connected'=>$this->input->post('alarm_threads_connected_'.$n),
                        'alarm_threads_running'=>$this->input->post('alarm_threads_running_'.$n),
						'alarm_threads_waits'=>$this->input->post('alarm_threads_waits_'.$n),
                        'alarm_repl_status'=>$this->input->post('alarm_repl_status_'.$n),
                        'alarm_repl_delay'=>$this->input->post('alarm_repl_delay_'.$n),
					);
					$this->servers->insert($data);
              }
		   }
           redirect(site_url('servers_mysql/index'));
        }
       
        $this->layout->view("servers_mysql/batch_add",$data);
     }
    
    
}

/* End of file servers_mysql.php */
/* Location: ./servers/controllers/servers_mysql.php */