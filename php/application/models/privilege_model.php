<?php 
class Privilege_model extends CI_Model{


	protected $table='admin_privilege';
	
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
		$this->db->where('privilege_id', $id);
		$this->db->update($this->table, $data);
	}
    
    /*
	 * 删除信息
	*/
	public function delete($id){
		$this->db->where('privilege_id', $id);
		$this->db->delete($this->table);
	}
	
	
	/*
	 * 根据id获取信息
	 */
	function get_record_by_id($id){
		$query = $this->db->get_where($this->table, array('privilege_id' =>$id));
		if ($query->num_rows() > 0)
		{
			return $query->row_array();
		}
	}
	
    
	/*
    *  查询数据列表
    */
    function get_total_record(){
        $this->db->select('privilege.*,menu.menu_title');
        $this->db->from('admin_privilege privilege');
        $this->db->join('admin_menu menu', 'privilege.menu_id=menu.menu_id', 'left');
        $this->db->order_by('display_order asc, privilege_id asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0)
		{
			$result['datalist']=$query->result_array();
            $result['datacount']=$query->num_rows();
            return $result;
		}
    }


}

/* End of file privilege_model.php */
/* Location: ./application/models/privilege_model.php */