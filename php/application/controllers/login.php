<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class Login extends CI_Controller  {
    function __construct(){
	    parent::__construct();
        self::__init_language();
        $this->load->model("user_model","user");
        $this->load->library('form_validation');
        
        
        
	}
    
    /*
	 * 检查语言配置设置默认语言
	 */
	private function __init_language(){
		$lang_current = $this->input->cookie('lang_current');
        $lang_support = config_item('support_language');
        $lang_default = config_item('language');
        
        $lang_current = ( FALSE !== in_array($lang_current, $lang_support) ) ? $lang_current : $lang_default;
        $this->config->set_item('language', $lang_current);
        $this->lang->load('mtop_system', $lang_current);
        $this->lang->load('mtop_menu', $lang_current);
        $this->lang->load('mtop_content', $lang_current);
        $cookie = array(
            'name'   => 'lang_current',
            'value'  => $lang_current,
            'expire' => 3600 * 24 * 365,
        );
        $this->input->set_cookie($cookie);
        return;
	}
    
    
    /*
	 * 用户登录
	 */
	public function index(){
		//检查是否已经登录，如果已登录直接跳转首页
		if( ($this->session->userdata('logged_in') == 1) ){
			redirect(base_url());
		}
		
		/*
		 * 提交登录后处理
		*/
		$data['error_code']=0;
		//判断是否是登录提交
		if(isset($_POST['login']) && $_POST['login']=='doing'){
			$this->form_validation->set_rules('username',  'lang:username', 'trim|required');
			$this->form_validation->set_rules('password',  'lang:password', 'trim|required|min_length[5]|max_length[18]');
	
			if ($this->form_validation->run() == FALSE)
			{
				$data['error_code']='validation_error';
			}
			else
			{
				
					$user_data=$this->user->check_user();
					if(!$user_data){
						$data['error_code']='user_check_fail';
					}
					else{
						$data['error_code']=0;
						//更新登录信息
						$uid=$user_data['user_id'];
						$this->user->update_login($uid);
						//记录session
						$newdata = array(
								'uid'=>$user_data['user_id'],
                                'username'=>$user_data['username'],
								'login_count'     => $user_data['login_count'],
								'last_login_ip'     => $user_data['last_login_ip'],
								'last_login_time'     => $user_data['last_login_time'],
								'logged_in' => TRUE
						);
						$this->session->set_userdata($newdata);
                        //记录登录日志
                        $log_data = array(
                            'user_id'=>$uid,
                            'action'=>'login',
                            'client_ip'=>get_client_ip(),
                        );   
	                    $this->db->insert('admin_log',$log_data);
						//登录成功,跳转至登录前页面
						redirect($this->input->post('return_url'));
					}	
				
			}
		}
		
		/*
		 * 页面展示和输出部分
		*/
		$data['cur_nav']='login';
		$data['site_title']='用户登录';
	 	$data['return_url'] = isset($_GET['return_url']) ? $_GET['return_url'] : base_url();	 //登录后返回url
		$this->load->model("lepus_model","lepus"); 
        $lepus_status=$this->lepus->get_lepus_status();
        $data['lepus_status']=$lepus_status;
        $this->load->view('login',$data);
		
	}
    
   	public function logout(){
		$this->session->unset_userdata('logged_in');
		$this->session->unset_userdata('username');
		$this->session->sess_destroy();
		redirect(base_url());
	}
	
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */