<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class Machine_room extends Front_Controller {
    function __construct(){
		parent::__construct();
        $this->load->model('machine_room_model','machine_room');
		$this->load->library('form_validation');
	
	}
    
        /**
     * 首页
     */
    public function index(){
        parent::check_privilege();
        $data["datalist"]=$this->machine_room->get_total_record();
        $data["datacount"]=$this->machine_room->get_total_rows();
        $data["cur_nav"]="machine_room_index";
        $this->layout->view("machine_room/index",$data);
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
            $this->form_validation->set_rules('name',  'lang:machine_room_name', 'trim|required|max_length[12]|is_unique[db_machine_room.name]|xss_clean');
            $this->form_validation->set_rules('code',  'lang:machine_room_code', 'trim|required|alpha_dash|min_length[1]|max_length[12]|is_unique[db_machine_room.name]|xss_clean');
            if ($this->form_validation->run() == FALSE)
            {
                $data['error_code']='validation_error';
            }
            else
            {
                    $data['error_code']=0;
                    $data = array(
                        'name'=>$this->input->post('name'),
                        'code'=>$this->input->post('code'),
                        'address'=>$this->input->post('address'),
                        'on_duty_tel'=>$this->input->post('on_duty_tel'),
                        'remark'=>$this->input->post('remark'),
                        'status'=>$this->input->post('status'),
                    );
                    $this->machine_room->insert($data);
                    redirect(site_url('machine_room/index'));
            }
        }
        $this->layout->view("machine_room/add",$data);
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
            $this->form_validation->set_rules('name',  'lang:name', 'trim|required|max_length[12]|xss_clean');
            $this->form_validation->set_rules('code',  'lang:machine_room_code', 'trim|required|alpha_dash|min_length[1]|max_length[12]|xss_clean');
            if ($this->form_validation->run() == FALSE)
            {
                $data['error_code']='validation_error';
            }
            else
            {
                    $data['error_code']=0;
                    $data = array(
                        'name'=>$this->input->post('name'),
                        'code'=>$this->input->post('code'),
                        'address'=>$this->input->post('address'),
                        'on_duty_tel'=>$this->input->post('on_duty_tel'),
                        'remark'=>$this->input->post('remark'),
                        'status'=>$this->input->post('status'),
                    );
                    $this->machine_room->update($data,$id);
                    redirect(site_url('machine_room/index'));
            }
        }
        
        
        $record = $this->machine_room->get_record_by_id($id);
        if(!$id || !$record){
            show_404();
        }
        else{
            $data['record']= $record;
        }
          
        $data["cur_nav"]="machine_room_edit";
        $this->layout->view("machine_room/edit",$data);
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
            $this->machine_room->update($data,$id);
            redirect(site_url('machine_room/index'));
        }
    }
    
    /**
     * 回收站
     */
    public function trash(){
        parent::check_privilege();
        $this->db->where("is_delete", 1);
        $data["datalist"]=$this->machine_room->get_total_record();
        $this->db->where("is_delete", 1);
        $data["datacount"]=$this->machine_room->get_total_rows();
        $data["cur_nav"]="machine_room_trash";
        $this->layout->view("machine_room/trash",$data);
    }
    
    /**
     * 恢复
     */
    function recover($id){
        parent::check_privilege('machine_room/trash');
        if($id){
            $data = array(
                'is_delete'=>0
            );
            $this->machine_room->update($data,$id);
            redirect(site_url('machine_room/trash'));
        }
    }  
    
    /**
     * 彻底删除
     */
    function forever_delete($id){
        parent::check_privilege();
        if($id){
            //检查该数据是否是回收站数据
            $record = $this->machine_room->get_record_by_id($id);
            if($record){
                $this->machine_room->delete($id);
            }
            redirect(site_url('machine_room/index'));
        }
        
    }
    
    
}

/* End of file machine_room.php */
/* Location: ./servers/controllers/machine_room.php */