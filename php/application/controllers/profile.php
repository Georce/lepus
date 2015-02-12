<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class Profile extends Front_Controller {
    function __construct(){
		parent::__construct();
        $this->load->model("user_model","user");
		$this->load->library('form_validation');
	
	}
    
    /**
     * 首页
     */
    public function index(){
        
        $uid=$this->session->userdata('uid');
        //echo $id;exit;
        /*
		 * 提交编辑后处理
		 */
        $data['error_code']='';
		if(isset($_POST['submit']) && $_POST['submit']=='save')
        {
	
            $this->form_validation->set_rules('realname',  'lang:realname', 'trim|required');
            $this->form_validation->set_rules('password',  'lang:password', 'trim|min_length[6]|max_length[18]');
			$this->form_validation->set_rules('email',  'lang:email', 'trim|valid_email');
            $this->form_validation->set_rules('mobile',  'lang:mobile', 'trim|integer');
			if ($this->form_validation->run() == FALSE)
			{
                $data['error_code']=1;
			}
			else
			{
					
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
					$this->user->update($data,$uid);
                    $data['error_code']=0;
            }
        }
        
		$record = $this->user->get_record_by_id($uid);
		if(!$uid || !$record){
			show_404();
		}
        else{
            $data['record']= $record;
        }
          
        $data["cur_nav"]="profile";
      
        $this->layout->view("profile/index",$data);
    }
    
    
    
}

/* End of file option.php */
/* Location: ./application/controllers/option.php */