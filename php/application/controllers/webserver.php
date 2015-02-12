<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class Webserver extends Front_Controller {
    function __construct(){
		parent::__construct();
  
        $this->load->model('webserver_model','webserver');
		$this->load->library('form_validation');
	
	}
    
    /**
     * 首页
     */
    public function index(){
        parent::check_privilege();
        $data["datalist"]=$this->webserver->get_total_record();
        $data["datacount"]=$this->webserver->get_total_rows();
        $this->layout->view("webserver/index",$data);
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
			$this->form_validation->set_rules('domain',  'lang:domain', 'trim|required|min_length[3]|max_length[50]');
			$this->form_validation->set_rules('port',  'lang:port', 'trim|required|min_length[2]|max_length[6]|integer');
			
            if ($this->form_validation->run() == FALSE)
			{
				$data['error_code']='validation_error';
			}
			else
			{
					$data['error_code']=0;
					$data = array(
						'domain'=>$this->input->post('domain'),
						'port'=>$this->input->post('port'),
                        'request'=>$this->input->post('request'),
                        'status'=>$this->input->post('status'),
                        'send_mail'=>$this->input->post('send_mail'),
                        'mail_to_list'=>$this->input->post('mail_to_list'),
					);
					$this->webserver->insert($data);
                    redirect(site_url('webserver/index'));
            }
        }
        $this->layout->view("webserver/add",$data);
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
            $this->form_validation->set_rules('domain',  'lang:domain', 'trim|required|min_length[3]|max_length[50]');
			$this->form_validation->set_rules('port',  'lang:port', 'trim|required|min_length[2]|max_length[6]|integer');
			
            if ($this->form_validation->run() == FALSE)
			{
				$data['error_code']='validation_error';
			}
			else
			{
					$data['error_code']=0;
					$data = array(
						'domain'=>$this->input->post('domain'),
						'port'=>$this->input->post('port'),
                        'request'=>$this->input->post('request'),
                        'status'=>$this->input->post('status'),
                        'send_mail'=>$this->input->post('send_mail'),
                        'mail_to_list'=>$this->input->post('mail_to_list'),
					);
					$this->webserver->update($data,$id);
                    redirect(site_url('webserver/index'));
            }
        }
        
        
		$record = $this->webserver->get_record_by_id($id);
		if(!$id || !$record){
			show_404();
		}
        else{
            $data['record']= $record;
        }
        $this->layout->view("webserver/edit",$data);
    }
    
   
    
    /**
     * 删除
     */
    function delete($id){
        parent::check_privilege('');
        if($id){
            //检查该数据是否是回收站数据
             $this->webserver->delete($id);
            redirect(site_url('webserver/index'));
        }
        
    }
    
    public function health(){  
        $stime = !empty($_GET["stime"])? $_GET["stime"]: date('Y-m-d H:i',time()-3600*24*30);
        $etime = !empty($_GET["etime"])? $_GET["etime"]: date('Y-m-d H:i',time());
        $this->db->where("create_time >=", $stime);
        $this->db->where("create_time <=", $etime);
        $web_url=isset($_GET["web_url"]) ? $_GET["web_url"] : "";
        if(!empty($web_url)){
            $this->db->like("web_url ", $web_url);
        }
        
        if(!empty($_GET["stime"])){
            $current_url= 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        }
        else{
            $current_url= 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'?noparam=1';
        }
        
        
        //分页
		$this->load->library('pagination');
		$config['base_url'] = $current_url;
		$config['total_rows'] = $this->webserver->get_total_health_rows();
		$config['per_page'] = 50;
		$config['num_links'] = 5;
		$config['page_query_string'] = TRUE;
		$config['use_page_numbers'] = TRUE;
		$this->pagination->initialize($config);
		$offset = !empty($_GET['per_page']) ? $_GET['per_page'] : 1;
        
        $stime = !empty($_GET["stime"])? $_GET["stime"]: date('Y-m-d H:i',time()-3600*24*30);
        $etime = !empty($_GET["etime"])? $_GET["etime"]: date('Y-m-d H:i',time());
        $this->db->where("create_time >=", $stime);
        $this->db->where("create_time <=", $etime);
        $web_url=isset($_GET["web_url"]) ? $_GET["web_url"] : "";
        if(!empty($web_url)){
            $this->db->like("web_url ", $web_url);
        }
        $this->db->order_by("id", "desc");

        $data['datalist'] = $this->webserver->get_total_health_record_paging($config['per_page'],($offset-1)*$config['per_page']);

        $setval["stime"]=$stime;
        $setval["etime"]=$etime;
        $setval["web_url"]=$web_url;
        $data["setval"]=$setval;
        
        $this->layout->view("webserver/health",$data);
    }
    
    
}

/* End of file webserver.php */
/* Location: ./webserver/controllers/webserver.php */