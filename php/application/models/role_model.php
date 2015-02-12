<?php 
class Role_model extends CI_Model{


	protected $table='admin_role';
	
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
		$this->db->where('role_id', $id);
		$this->db->update($this->table, $data);
	}
    
    /*
	 * 删除信息
	*/
	public function delete($id){
		$this->db->where('role_id', $id);
		$this->db->delete($this->table);
	}
    
	
	/*
	 * 根据id获取信息
	 */
	function get_record_by_id($id){
		$query = $this->db->get_where($this->table, array('role_id' =>$id));
		if ($query->num_rows() > 0)
		{
			return $query->row_array();
		}
	}
	
    
	/*
    *  查询数据列表
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


}

/* End of file role_model.php */
/* Location: ./application/models/role_model.php */