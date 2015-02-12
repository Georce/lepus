<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class Application extends Front_Controller {
    function __construct(){
		parent::__construct();
  
        $this->load->model('application_model','app');
		$this->load->library('form_validation');
	
	}
    
    /**
     * 首页
     */
    public function index(){
        parent::check_privilege();
        $this->db->where("is_delete", 0);
        $data["datalist"]=$this->app->get_total_record();
        $this->db->where("is_delete", 0);
        $data["datacount"]=$this->app->get_total_rows();
        $data["cur_nav"]="application_index";
        $this->layout->view("application/index",$data);
    }
    
    
    
    /**
     * 添加
     */
    public function add(){
        parent::check_privilege();
        /*
		 * 提交添加后处理
		 */
		$data['error_code']=0;
		if(isset($_POST['submit']) && $_POST['submit']=='add')
        {
			$this->form_validation->set_rules('name',  'lang:name', 'trim|required|alpha_dash|min_length[3]|max_length[16]|is_unique[db_application.name]|xss_clean');
			$this->form_validation->set_rules('display_name',  'lang:display_name', 'trim|required|xss_clean');
			if ($this->form_validation->run() == FALSE)
			{
				$data['error_code']='validation_error';
			}
			else
			{
					$data['error_code']=0;
					$data = array(
						'name'=>$this->input->post('name'),
						'display_name'=>$this->input->post('display_name'),
                        'db_type'=>$this->input->post('db_type'),
                        'status'=>$this->input->post('status'),
					);
					$this->app->insert($data);
                    redirect(site_url('application/index'));
            }
        }
        //print $data['error_code'];exit;   
        $data["cur_nav"]="application_add";
        $this->layout->view("application/add",$data);
    }
    
    /**
     * 编辑
     */
    public function edit($id){
        
        parent::check_privilege();
        
        $id  = !empty($id) ? $id : $_POST['id'];
        /*
		 * 提交编辑后处理
		 */
        $data['error_code']=0;
		if(isset($_POST['submit']) && $_POST['submit']=='edit')
        {
            $this->form_validation->set_rules('name',  'lang:name', 'trim|required|alpha_dash|min_length[3]|max_length[16]|xss_clean');
			$this->form_validation->set_rules('display_name',  'lang:display_name', 'trim|required|xss_clean');
			if ($this->form_validation->run() == FALSE)
			{
				$data['error_code']='validation_error';
			}
			else
			{
					$data['error_code']=0;
					$data = array(
						'name'=>$this->input->post('name'),
						'display_name'=>$this->input->post('display_name'),
                        'db_type'=>$this->input->post('db_type'),
                        'status'=>$this->input->post('status'),
					);
					$this->app->update($data,$id);
                    redirect(site_url('application/index'));
            }
        }
        
        
		$record = $this->app->get_record_by_id($id);
		if(!$id || !$record){
			show_404();
		}
        else{
            $data['record']= $record;
        }
          
        $data["cur_nav"]="application_edit";
        $this->layout->view("application/edit",$data);
    }
    
    /**
     * 加入回收站
     */
    function delete($id){
        parent::check_privilege();
        if($id){
            $data = array(
				'is_delete'=>1
            );
		    $this->app->update($data,$id);
            redirect(site_url('application/index'));
        }
    }
    
    /**
     * 回收站
     */
    public function trash(){
        parent::check_privilege();
        $this->db->where("is_delete", 1);
        $data["datalist"]=$this->app->get_total_record();
        $this->db->where("is_delete", 1);
        $data["datacount"]=$this->app->get_total_rows();
        $data["cur_nav"]="application_trash";
        $this->layout->view("application/trash",$data);
    }
    
    /**
     * 恢复
     */
    function recover($id){
        parent::check_privilege('application/trash');
        if($id){
            $data = array(
				'is_delete'=>0
            );
		    $this->app->update($data,$id);
            redirect(site_url('application/trash'));
        }
    }  
    
    /**
     * 彻底删除
     */
    function forever_delete($id){
        parent::check_privilege('application/trash');
        if($id){
            //检查该数据是否是回收站数据
            $record = $this->app->get_record_by_id($id);
            $is_delete = $record['is_delete'];
            if($is_delete==1){
                $this->app->delete($id);
            }
            redirect(site_url('application/trash'));
        }
        
    }
    
    
}

/* End of file application.php */
/* Location: ./application/controllers/application.php */