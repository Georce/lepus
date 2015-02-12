<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class Settings extends Front_Controller {
    function __construct(){
		parent::__construct();
        $this->load->model("option_model","settings");
		$this->load->library('form_validation');
	
	}
    
    /**
     * 首页
     */
    public function index(){
        parent::check_privilege();
        $data['success_code']=0;
        $save=$this->uri->segment(3);
        if($save){
            $data['success_code']=1;
        }
        $settings=$this->settings->get_option();
        $data['settings']=$settings;
        $this->layout->view("settings/index",$data);
    }
    
     /**
     * 保存选项
     */
    public function save(){
        parent::check_privilege();
        if(isset($_POST['submit']) && $_POST['submit']=='save')
        {
	        $post=$_POST;
            foreach($post as $key=>$val){
                $data['value']=$val;
                $this->settings->update($data,$key);
            }
 
            redirect(site_url('settings/index/save'));
            
        }
        
    }
    
}

/* End of file settings.php */
/* Location: ./application/controllers/settings.php */