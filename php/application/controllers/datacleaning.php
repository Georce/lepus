<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class Datacleaning extends Front_Controller {
    function __construct(){
		parent::__construct();
        $this->load->model("option_model","option");
		$this->load->library('form_validation');
	
	}
    
    /**
     * 首页
     */
    public function index(){
        $data['success_code']=0;
        $save=$this->uri->segment(3);
        if($save){
            $data['success_code']=1;
        }
        $option=$this->option->get_option();
        $data['option']=$option;
        $data["cur_nav"]="datacleaning_index";
        $this->layout->view("datacleaning/index",$data);
    }
    
    
    
}

/* End of file datacleaning.php */
/* Location: ./application/controllers/datacleaning.php */