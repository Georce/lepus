<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class Auth extends Front_Controller  {
    function __construct(){
	    parent::__construct();
        
        $this->load->model("user_model","user");
        $this->load->model("role_model","role");
        $this->load->model("privilege_model","privilege");
        $this->load->model("auth_model","auth");
        
	}
    
    public function index(){
        parent::check_privilege();
        $id_type =$this->uri->segment(3);
        $id_type  = !empty($id_type) ? $id_type : '';
        $id =$this->uri->segment(4);
        $id  = !empty($id) ? $id : '';
        
        $data['role_id']=0;
        $data['user_id']=0;
        $data['role_privilege']=array();
        $data['user_role']=array();
        if($id_type=='role_id'){
            $data['role_id']= $id;
            $data['role_privilege']=$this->auth->get_role_privilege($id);
        }
        if($id_type=='user_id'){
            $data['user_id']= $id;
            $data['user_role']=$this->auth->get_user_role($id);
        }
        
        $users=$this->user->get_total_record();
        $data['user_list']=$users['datalist'];
        $roles=$this->role->get_total_record();
        $data['role_list']=$roles['datalist'];
        $privileges=$this->privilege->get_total_record();
        $data['privilege_list']=$privileges['datalist']; 
        
        
        
        $error_code =$this->uri->segment(5);
        $data['error_code'] = isset($error_code) ? $error_code : '';
        $data["cur_nav"]="auth_index";
        $this->layout->view("auth/index",$data);
    }
    
    function ajax_privilege_list(){
        $role_id = $_POST['role_id'];
        $role_privilege=$this->auth->get_role_privilege($role_id);
        $role_privilege = !empty($role_privilege) ? $role_privilege : array();
        $privileges=$this->privilege->get_total_record();
        $privilege_list=$privileges['datalist'];
        $result=$checked='';
        if(!empty($privilege_list)) {
            foreach($privilege_list as $item)
	        {
				if(in_array($item['privilege_id'],$role_privilege)){
				    $item['checked'] = "checked";
				}
                else{
                    $item['checked'] = "";
                }
                $result .= "
                <div class='privilege_checkbox'>
                <input type='checkbox' name='privilege_id[]' value=".$item['privilege_id']." ".$item['checked']." />".$item['privilege_title']." 
                </div>
				";
			}
            echo $result;
        }
	    else
	    {
			echo "nodata";
	    } 
    }
    
    function ajax_role_list(){
        $user_id = $_POST['user_id'];
        $user_role=$this->auth->get_user_role($user_id);
        $user_role = !empty($user_role) ? $user_role : array();
        $roles=$this->role->get_total_record();
        $role_list=$roles['datalist'];
        $result=$checked='';
        if(!empty($role_list)) {
            foreach($role_list as $item)
	        {
				if(in_array($item['role_id'],$user_role)){
				    $item['checked'] = "checked";
				}
                else{
                    $item['checked'] = "";
                }
                $result .= "
                <div class='role_checkbox'>
                <input type='checkbox' name='role_id[]' value=".$item['role_id']." ".$item['checked']." />".$item['role_name']." 
                </div>
				";
			}
            echo $result;
        }
	    else
	    {
			echo "nodata";
	    } 
    }
    
   
  

    
    /**
     * 更新角色授权
     */
    public function update_role_privilege(){
        parent::check_privilege();
        $role_id = !empty($_POST['role_id']) ? $_POST['role_id'] : '';
        $privilege_ids = !empty($_POST['privilege_id']) ? $_POST['privilege_id'] : '';
        /*
		 * 提交后处理
		 */
		$data['error_code']='';
		if(isset($_POST['submit']) && $_POST['submit']=='auth_role_privilege')
        {
              $result=$this->auth->update_role_privilege($role_id,$privilege_ids);
              if($result===true){
                 redirect(site_url('/auth/index/role_id/'.$role_id.'/0'));
              }
              else{
                 redirect(site_url('/auth/index/role_id/'.$role_id.'/1'));
              }
        } 
 
    } 
    
    /**
     * 更新角色授权
     */
    public function update_user_role(){
        parent::check_privilege();
        $user_id =  !empty($_POST['user_id']) ? $_POST['user_id'] : '';
        $role_ids = !empty($_POST['role_id']) ? $_POST['role_id'] : '';
        /*
		 * 提交后处理
		 */
		$data['error_code']='';
		if(isset($_POST['submit']) && $_POST['submit']=='auth_user_role')
        {
              $result=$this->auth->update_user_role($user_id,$role_ids);
              if($result===true){
                 redirect(site_url('/auth/index/user_id/'.$user_id.'/0'));
              }
              else{
                 redirect(site_url('/auth/index/user_id/'.$user_id.'/1'));
              }
        } 
 
    }  
	
}

/* End of file auth.php */
/* Location: ./application/controllers/auth.php */