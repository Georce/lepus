<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class Menu extends Front_Controller  {
    function __construct(){
	    parent::__construct();
        $this->load->model("menu_model","menu");
        $this->load->library('form_validation');
        
	}
    
    /*
    * 菜单管理
    */
    
    public function index(){
        parent::check_privilege();
        $result=$this->menu->get_total_record();
        $data['datalist']=get_menu_record_tree($result['datalist']);
        $data['datacount']=$result['datacount'];
        $data["cur_nav"]="menu_index";
        $this->layout->view("menu/index",$data);
    }
    
    /**
     * 添加菜单
     */
    public function add(){
        parent::check_privilege();
        /*
		 * 提交添加后处理
		 */
		$data['error_code']=0;
		if(isset($_POST['submit']) && $_POST['submit']=='add')
        {
		    $this->form_validation->set_rules('menu_title',  'lang:menu_title', 'trim|required|min_length[2]|max_length[40]|xss_clean');
            $this->form_validation->set_rules('menu_url',  'lang:menu_url', 'trim|required|xss_clean');
            $this->form_validation->set_rules('display_order',  'lang:display_order', 'trim|required|integer');
        
			if ($this->form_validation->run() == FALSE)
			{
				$data['error_code']='validation_error';
			}
			else
			{
					$data['error_code']=0;
                    $menu_level=$this->menu->get_level_by_parant_id($this->input->post('parent_id'));
					$data = array(
                        'menu_level'=>$menu_level,
                        'parent_id'=>$this->input->post('parent_id'),
						'menu_title'=>$this->input->post('menu_title'),
                        'menu_url'=>$this->input->post('menu_url'),
                        'menu_icon'=>$this->input->post('menu_icon'),
                        'display_order'=>$this->input->post('display_order'),
                        'status'=>$this->input->post('status'),
					);
					$this->menu->insert($data);
                    redirect(site_url('menu/index'));
            }
        }
        
        $menu_record=$this->menu->get_total_record();
        $data['menu_record_tree']=get_menu_record_tree($menu_record['datalist']);
        $data["cur_nav"]="menu_add";
        $this->layout->view("menu/add",$data);
    }
    
    /**
     * 编辑菜单
     */
    public function edit(){
        parent::check_privilege();
        $menu_id=$this->uri->segment(3);
        $menu_id  = !empty($menu_id) ? $menu_id : $_POST['menu_id'];
        /*
		 * 提交编辑后处理
		 */
        $data['error_code']=0;
		if(isset($_POST['submit']) && $_POST['submit']=='edit')
        {
			$this->form_validation->set_rules('menu_title',  'lang:menu_title', 'trim|required|min_length[2]|max_length[40]|xss_clean');
            $this->form_validation->set_rules('menu_url',  'lang:menu_url', 'trim|required|xss_clean');
            $this->form_validation->set_rules('display_order',  'lang:display_order', 'trim|required|integer');
			if ($this->form_validation->run() == FALSE)
			{
				$data['error_code']='validation_error';
			}
			else
			{
					$data['error_code']=0;
                    if($this->input->post('parent_id')==$menu_id){
                        $data['error_code']=2;
                    }
                    else{
                        $menu_level=$this->menu->get_level_by_parant_id($this->input->post('parent_id'));
					    $data = array(
                        'menu_level'=>$menu_level,
                        'parent_id'=>$this->input->post('parent_id'),
						'menu_title'=>$this->input->post('menu_title'),
                        'menu_url'=>$this->input->post('menu_url'),
                        'menu_icon'=>$this->input->post('menu_icon'),
                        'display_order'=>$this->input->post('display_order'),
                        'status'=>$this->input->post('status'),
					    );
					    $this->menu->update($data,$menu_id);
                        redirect(site_url('menu/index'));
                    }
					
            }
        }
        
        
		$record = $this->menu->get_record_by_id($menu_id);
		if(!$menu_id || !$record){
			show_404();
		}
        else{
            $data['record']= $record;
        }
        
        $menu_record=$this->menu->get_total_record();
        $data['menu_record_tree']=get_menu_record_tree($menu_record['datalist']);
        $data['parent_id']=$this->menu->get_parent_id($menu_id);
        //echo $data['parent_id'];exit;  
        $data["cur_nav"]="menu_edit";
        $this->layout->view("menu/edit",$data);
    }
    
    /**
     * 彻底删除菜单
     */
    function forever_delete($id){
        parent::check_privilege();
        if($id){
            $this->menu->delete($id);
            redirect(site_url('menu/index'));
        }
        
    }
    
	


}

/* End of file menu.php */
/* Location: ./application/controllers/menu.php */