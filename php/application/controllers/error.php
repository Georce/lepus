<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class Error extends Front_Controller {
    function __construct(){
		parent::__construct();
	
	}

    public function permission_denied(){

        $this->layout->view("error/permission_denied");
    }
    
}

/* End of file error.php */
/* Location: ./application/controllers/error.php */