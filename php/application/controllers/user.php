<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class User extends Front_Controller  {
    function __construct(){
	    parent::__construct();
        $this->load->model("user_model","user");
        $this->load->library('form_validation');
        
	}
    
    /*
    * 用户管理
    */
    
    public function index(){
        parent::check_privilege();
        $result=$this->user->get_total_record();
        $data['datalist']=$result['datalist'];
        $data['datacount']=$result['datacount'];
        $data["cur_nav"]="user_index";
        $this->layout->view("user/index",$data);
    }
    
    /**
     * 添加用户
     */
    public function add(){
        parent::check_privilege();
        /*
		 * 提交添加后处理
		 */
		$data['error_code']=0;
		if(isset($_POST['submit']) && $_POST['submit']=='add')
        {
		    $this->form_validation->set_rules('username',  'lang:username', 'trim|required|min_length[2]|max_length[18]|is_unique[admin_user.username]|xss_clean');
   			$this->form_validation->set_rules('password',  'lang:password', 'trim|required|min_length[6]|max_length[18]');
			$this->form_validation->set_rules('confirm_password',  'lang:confirm_password', 'trim|required|matches[password]');
            $this->form_validation->set_rules('realname',  'lang:realname', 'trim|required');
			$this->form_validation->set_rules('email',  'lang:email', 'trim|valid_email|is_unique[admin_user.email]');
            $this->form_validation->set_rules('mobile',  'lang:mobile', 'trim|integer');

			if ($this->form_validation->run() == FALSE)
			{
				$data['error_code']='validation_error';
			}
			else
			{
					$data['error_code']=0;
					$data = array(
						'username'=>$this->input->post('username'),
                        'password'=>md5($this->input->post('password')),
                        'realname'=>$this->input->post('realname'),
						'email'=>$this->input->post('email'),
						'mobile'=>$this->input->post('mobile'),
						'login_count'=>0,
                        'status'=>$this->input->post('status')
					);
					$this->user->insert($data);
                    redirect(site_url('user/index'));
            }
        }
  
        $data["cur_nav"]="user_add";
        $this->layout->view("user/add",$data);
    }
    
    /**
     * 编辑用户
     */
    public function edit(){
        parent::check_privilege();
        $id=$this->uri->segment(3);
        $id  = !empty($id) ? $id : $_POST['user_id'];
        /*
		 * 提交编辑后处理
		 */
        $data['error_code']=0;
		if(isset($_POST['submit']) && $_POST['submit']=='edit')
        {
			$this->form_validation->set_rules('realname',  'lang:realname', 'trim|required');
            $this->form_validation->set_rules('password',  'lang:password', 'trim|min_length[6]|max_length[18]');
			$this->form_validation->set_rules('email',  'lang:email', 'trim|valid_email');
            $this->form_validation->set_rules('mobile',  'lang:mobile', 'trim|integer');
			if ($this->form_validation->run() == FALSE)
			{
				$data['error_code']='validation_error';
			}
			else
			{
					$data['error_code']=0;
					$data = array(
						'username'=>$this->input->post('username'),
                        'realname'=>$this->input->post('realname'),
						'email'=>$this->input->post('email'),
						'mobile'=>$this->input->post('mobile'),
                        'status'=>$this->input->post('status')
					);
                    $password=$this->input->post('password');
                    if(!empty($password)){
                        $data['password']=md5($password);
                    }
					$this->user->update($data,$id);
                    redirect(site_url('user/index'));
            }
        }
        
        
		$record = $this->user->get_record_by_id($id);
		if(!$id || !$record){
			show_404();
		}
        else{
            $data['record']= $record;
        }
          
        $data["cur_nav"]="user_edit";
        $this->layout->view("user/edit",$data);
    }
    
    /**
     * 彻底删除
     */
    function forever_delete($id){
        parent::check_privilege();
        if($id){
            $this->user->delete($id);
            redirect(site_url('user/index'));
        }
        
    }
    
	

    
    /*
	 * 用户密码信息修改
	*/
	public function password(){
	
		$uid  = $this->session->userdata('uid');
		$data = $this->user->get_user_by_id($uid);
		if(!$uid || !$data){
			redirect(site_url());
		}
	
		/*
		 * 提交修改后处理
		*/
		$data['error_code']=0;
		$data['success_code']=0;
		if(isset($_POST['pwd']) && $_POST['pwd']=='doing'){
			$this->form_validation->set_rules('old_password',  'lang:old_password', 'trim|required');
			$this->form_validation->set_rules('new_password',  'lang:new_password', 'trim|required|min_length[5]|max_length[18]');
			$this->form_validation->set_rules('new_password_conf',  'lang:new_password_conf', 'trim|required|matches[new_password]');
			if ($this->form_validation->run() == FALSE)
			{
				$data['error_code']='validation_error';
			}
			else{
				//echo md5($this->input->post('old_password'));
				$check_pwd = $this->user->check_old_password($uid,$this->input->post('old_password'));
				if(!$check_pwd){
					$data['error_code']='old_password_fail';
				}
				else{
					$data['error_code']=0;
					//更新信息
					$data_new = array(
							'password'=>md5($this->input->post('new_password')),
					);
					$this->user->update($data_new,$uid);
					$data['success_code']='1';
					
				}
				
			}
		}
				
		$data['cur_nav']='user_password';
		$data['site_title']='修改密码';;
		$this->layout->view('user/password',$data);
	
	}
}

/* End of file user.php */
/* Location: ./application/controllers/user.php */