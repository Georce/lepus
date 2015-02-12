<?php 
class User_model extends CI_Model{


	protected $table='admin_user';
	
	/*
	 * 添加信息
	 */
	public function insert($data){		
		$this->db->insert($this->table, $data);
	}
	
	/*
	 * 更新信息
	*/
	public function update($data,$id){
		$this->db->where('user_id', $id);
		$this->db->update($this->table, $data);
	}
    
    /*
	 * 删除信息
	*/
	public function delete($id){
		$this->db->where('user_id', $id);
		$this->db->delete($this->table);
	}
    
    /*
	 * 根据id获取信息
	 */
	function get_record_by_id($id){
		$query = $this->db->get_where($this->table, array('user_id' =>$id));
		if ($query->num_rows() > 0)
		{
			return $query->row_array();
		}
	}
    
    /*
    *查询数据列表
    */
    function get_total_record(){
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0)
		{
			$result['datalist']=$query->result_array();
            $result['datacount']=$query->num_rows();
            return $result;
		}
    }
	
	/*
	 * 更新用户登录信息
	 */
	public function update_login($id){
		$data = array(
				'last_login_time'=>date('Y-m-d H:i:s'),
				'last_login_ip'=>$this->input->ip_address(),
		);
		$this->db->set('login_count', 'login_count+1',FALSE);
		$this->db->where('user_id', $id);
		$this->db->update($this->table,$data);
	}
    
    
	
	/*
	 * 检查用户是否合法
	 */
	public function check_user(){
		$username=$this->input->post('username');
		$password=$this->input->post('password');
		$this->db->where('username', $username);
		$this->db->where('password', md5($password));
		$this->db->where('status',1);
		$query = $this->db->get($this->table);
		if ($query->num_rows() > 0)
		{
			return $query->row_array();
		}
	}
	
	/*
	 * 检查当前用户的原密码是否正确
	*/
	public function check_old_password($uid,$password){
		$this->db->where('user_id', $uid);
		$this->db->where('password', md5($password));
		$this->db->where('status',1);
		$query = $this->db->get($this->table);
		if ($query->num_rows() > 0)
		{
			return $query->row_array();
		}
	}
	
	/*
	 * 根据uid获取用户信息
	 */
	function get_user_by_id($id){
		$query = $this->db->get_where($this->table, array('id' =>$id));
		if ($query->num_rows() > 0)
		{
			return $query->row_array();
		}
	}
	
	/*
	 * 根据用户名查询用户
	*/
	function get_user_by_username($username=''){
		$query = $this->db->get_where($this->table, array('username' =>$username));
		if ($query->num_rows() > 0)
		{
			return $query->row_array();
		}
	}
    
	
	/*
	 * 通过用户名更新用户密码
	*/
	public function update_password_by_username($data,$username){
		$this->db->where('username', $username);
		$this->db->update($this->table, $data);
	}
    
    public function get_username()
	{
		$username = $this->session->userdata('username');
		 return $username;
	}
    
    public function get_uid()
	{
		$username = $this->session->userdata('uid');
		 return $uid;
	}
    
    public function get_user_menus(){
        $this->load->model('auth_model');
        $username = $this->get_username();
		$menus = $this->auth_model->get_user_menus_by_username($username);
		return $menus;
    }
    
    public function get_user_current_action(){
        $controller = $this->uri->segment(1);
        $function = $this->uri->segment(2);
        $current_action = $controller.'/'.$function;
        return $current_action;
    }
    
    


}

/* End of file user_model.php */
/* Location: ./application/models/user_model.php */