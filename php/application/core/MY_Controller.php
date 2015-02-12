<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
abstract class Front_Controller extends CI_Controller
{
	
	
	/**
     * 构造函数
     *
     * @access  public
     * @return  void
     */
	public function __construct()
	{
		parent::__construct();
        self::__init_language();
        self::__check_login();
  
        
              
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
        $this->lang->load('date', $lang_current);
        return;
	}

	
	/*
	 * 检查用户是否登录
	 */
	private function __check_login(){
		if( ($this->session->userdata('logged_in') != 1) ){
			$return_url   =  current_url();
			redirect(site_url('/login').'?return_url='.$return_url);
            return ;
		}
	}
    
    public function check_privilege($action=''){
        $this->load->model("user_model","user");
        $this->load->model("auth_model","auth");
        $username = $this->user->get_username();
        $action = !empty($action) ? $action : $this->user->get_user_current_action();
        //echo $action;exit;
        if($this->auth->check_user_privilege($username,$action) == false)
		{
            redirect(site_url('error/permission_denied'));
			return ;
		}        
    }
    
    public function sys_logging($action){
        $user_id =   $this->user->get_uid();
        $action = !empty($action) ? $action : $this->user->get_user_current_action();
        $client_ip = get_client_ip();
        $data = array(
            'user_id'=>$user_id,
            'action'=>$action,
            'client_ip'=>$client_ip,
        );   
	    $this->db->insert('admin_log', $data);
    }

		
}	