<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class Role extends Front_Controller  {
    function __construct(){
	    parent::__construct();
        
        $this->load->model("role_model","role");
        $this->load->model("privilege_model","privilege");
        $this->load->library('form_validation');
        
        
	}
    
    /*
    * 角色管理
    */
    
    public function index(){
        parent::check_privilege();
        $result=$this->role->get_total_record();
        $data['datalist']=$result['datalist'];
        $data['datacount']=$result['datacount'];
        $data["cur_nav"]="role_index";
        $this->layout->view("role/index",$data);
    }
    
    /**
     * 添加角色
     */
    public function add(){
        parent::check_privilege();
        /*
		 * 提交添加后处理
		 */
		$data['error_code']=0;
		if(isset($_POST['submit']) && $_POST['submit']=='add')
        {
		    $this->form_validation->set_rules('role_name',  'lang:role_name', 'trim|required|min_length[2]|max_length[16]|is_unique[admin_role.role_name]|xss_clean');

			if ($this->form_validation->run() == FALSE)
			{
				$data['error_code']='validation_error';
			}
			else
			{
					$data['error_code']=0;
					$data = array(
						'role_name'=>$this->input->post('role_name'),
					);
					$this->role->insert($data);
                    redirect(site_url('role/index'));
            }
        }
        
        $data["cur_nav"]="role_add";
        $this->layout->view("role/add",$data);
    }
    
    /**
     * 编辑角色
     */
    public function edit(){
        parent::check_privilege();
        $id=$this->uri->segment(3);
        $id  = !empty($id) ? $id : $_POST['role_id'];
        /*
		 * 提交编辑后处理
		 */
        $data['error_code']=0;
		if(isset($_POST['submit']) && $_POST['submit']=='edit')
        {
			$this->form_validation->set_rules('role_name',  'lang:role_name', 'trim|required|min_length[2]|max_length[16]');
			if ($this->form_validation->run() == FALSE)
			{
				$data['error_code']='validation_error';
			}
			else
			{
					$data['error_code']=0;
					$data = array(
						'role_name'=>$this->input->post('role_name'),
					);
                    
					$this->role->update($data,$id);
                    redirect(site_url('role/index'));
            }
        }
        
        
		$record = $this->role->get_record_by_id($id);
		if(!$id || !$record){
			show_404();
		}
        else{
            $data['record']= $record;
        }
          
        $data["cur_nav"]="role_edit";
        $this->layout->view("role/edit",$data);
    }
    
    /**
     * 彻底删除角色
     */
    function forever_delete($id){
        parent::check_privilege();
        if($id){
            $this->role->delete($id);
            redirect(site_url('role/index'));
        }
        
    }
    
    
	
}

/* End of file role.php */
/* Location: ./application/controllers/role.php */