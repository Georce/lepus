<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class Privilege extends Front_Controller  {
    function __construct(){
	    parent::__construct();
        
        $this->load->model("privilege_model","privilege");
        $this->load->model("menu_model","menu");
        $this->load->library('form_validation');
        
	}
    
    /*
    * 权限节点管理
    */
    
    public function index(){
        parent::check_privilege();
        $result=$this->privilege->get_total_record();
        $data['datalist']=$result['datalist'];
        $data['datacount']=$result['datacount'];
        $data["cur_nav"]="privilege_index";
        $this->layout->view("privilege/index",$data);
    }
    
    /**
     * 添加权限节点
     */
    public function add(){
        parent::check_privilege();
        /*
		 * 提交添加后处理
		 */
		$data['error_code']=0;
		if(isset($_POST['submit']) && $_POST['submit']=='add')
        {
		    $this->form_validation->set_rules('privilege_title',  'lang:privilege_title', 'trim|required|is_unique[admin_privilege.privilege_title]|xss_clean');
            $this->form_validation->set_rules('action',  'lang:action', 'trim|required');
            $this->form_validation->set_rules('display_order',  'lang:display_order', 'trim|required|integer');
			if ($this->form_validation->run() == FALSE)
			{
				$data['error_code']='validation_error';
			}
			else
			{
					$data['error_code']=0;
					$data = array(
						'privilege_title'=>$this->input->post('privilege_title'),
                        'action'=>$this->input->post('action'),
                        'menu_id'=>$this->input->post('menu_id'),
                        'display_order'=>$this->input->post('display_order'),
					);
					$this->privilege->insert($data);
                    redirect(site_url('privilege/index'));
            }
        }
        
        $menu_record=$this->menu->get_total_record();
        $data['menu_record_tree']=get_menu_record_tree($menu_record['datalist']);   
        $data["cur_nav"]="privilege_add";
        $this->layout->view("privilege/add",$data);
    }
    
    /**
     * 编辑权限节点
     */
    public function edit(){
        parent::check_privilege();
        $id=$this->uri->segment(3);
        $id  = !empty($id) ? $id : $_POST['privilege_id'];
        /*
		 * 提交编辑后处理
		 */
        $data['error_code']=0;
		if(isset($_POST['submit']) && $_POST['submit']=='edit')
        {
			$this->form_validation->set_rules('privilege_title',  'lang:privilege_title', 'trim|required|xss_clean');
            $this->form_validation->set_rules('action',  'lang:action', 'trim|required');
            $this->form_validation->set_rules('display_order',  'lang:display_order', 'trim|required|integer');
			if ($this->form_validation->run() == FALSE)
			{
				$data['error_code']='validation_error';
			}
			else
			{
					$data['error_code']=0;
					$data = array(
						'privilege_title'=>$this->input->post('privilege_title'),
                        'action'=>$this->input->post('action'),
                        'menu_id'=>$this->input->post('menu_id'),
                        'display_order'=>$this->input->post('display_order'),
					);
                    
					$this->privilege->update($data,$id);
                    redirect(site_url('privilege/index'));
            }
        }
        
        
		$record = $this->privilege->get_record_by_id($id);
		if(!$id || !$record){
			show_404();
		}
        else{
            $data['record']= $record;
        }
        $menu_record=$this->menu->get_total_record();
        $data['menu_record_tree']=get_menu_record_tree($menu_record['datalist']);  
        $this->layout->view("privilege/edit",$data);
    }
    
    /**
     * 彻底删除权限节点
     */
    function forever_delete($id){
        parent::check_privilege();
        if($id){
            $this->privilege->delete($id);
            redirect(site_url('privilege/index'));
        }
        
    }
    
	

}

/* End of file privilege.php */
/* Location: ./application/controllers/privilege.php */