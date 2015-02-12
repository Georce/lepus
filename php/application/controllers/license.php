<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class License extends CI_Controller {
    function __construct(){
		parent::__construct();
	
	}
    public function index(){

    	$lang_current = $this->input->cookie('lang_current');
        $lang_support = config_item('support_language');
        $lang_default = config_item('language');
        
        $lang_current = ( FALSE !== in_array($lang_current, $lang_support) ) ? $lang_current : $lang_default;
        $this->config->set_item('language', $lang_current);
        $this->lang->load('mtop_system', $lang_current);
        $this->lang->load('mtop_menu', $lang_current);
        $this->lang->load('mtop_content', $lang_current);
        $this->lang->load('date', $lang_current);

        require_once BASEPATH.'license.php';
		require_once BASEPATH.'getmacaddr.php';
		$mac = new GetMacAddr(PHP_OS);  
        $server_mac_addr=$mac->mac_addr;
        $data['license_data'] = $license_data;
		$data['my_server_mac_addr'] = $server_mac_addr;
        $this->layout->view("license/index",$data);
    }

    public function error(){
        $lang_current = $this->input->cookie('lang_current');
        $lang_support = config_item('support_language');
        $lang_default = config_item('language');
        
        $lang_current = ( FALSE !== in_array($lang_current, $lang_support) ) ? $lang_current : $lang_default;
        $this->config->set_item('language', $lang_current);
        $this->lang->load('mtop_system', $lang_current);
        $this->lang->load('mtop_menu', $lang_current);
        $this->lang->load('mtop_content', $lang_current);
        $this->lang->load('date', $lang_current);
        $this->layout->view("license/error");
    }

    public function upgrade(){
        $lang_current = $this->input->cookie('lang_current');
        $lang_support = config_item('support_language');
        $lang_default = config_item('language');
        
        $lang_current = ( FALSE !== in_array($lang_current, $lang_support) ) ? $lang_current : $lang_default;
        $this->config->set_item('language', $lang_current);
        $this->lang->load('mtop_system', $lang_current);
        $this->lang->load('mtop_menu', $lang_current);
        $this->lang->load('mtop_content', $lang_current);
        $this->lang->load('date', $lang_current);
        $this->layout->view("license/upgrade");
    }

    public function renew(){
        $lang_current = $this->input->cookie('lang_current');
        $lang_support = config_item('support_language');
        $lang_default = config_item('language');
        
        $lang_current = ( FALSE !== in_array($lang_current, $lang_support) ) ? $lang_current : $lang_default;
        $this->config->set_item('language', $lang_current);
        $this->lang->load('mtop_system', $lang_current);
        $this->lang->load('mtop_menu', $lang_current);
        $this->lang->load('mtop_content', $lang_current);
        $this->lang->load('date', $lang_current);
        $this->layout->view("license/renew");
    }
    
}

/* End of file license.php */
/* Location: ./application/controllers/license.php */