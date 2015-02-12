<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class Language extends CI_Controller {
    function __construct(){
		parent::__construct();
	
	}
    
    public function switchover(){
        $this->load->helper('cookie');
        $lang_url = $this->uri->segment(3);
        $lang_support = config_item('support_language');
        $lang_default = config_item('language');
        
        $lang_current = ( FALSE !== in_array($lang_url, $lang_support) ) ? $lang_url : $lang_default;
        $cookie = array(
            'name'   => 'lang_current',
            'value'  => $lang_current,
            'expire' => 3600 * 24 * 365,
        );
        $this->input->set_cookie($cookie);
        $return_url = !empty($_GET['return_url']) ? $_GET['return_url'] : site_url('index/index');
        redirect($return_url);
    }
    

    
}

/* End of file index.php */
/* Location: ./application/controllers/index.php */