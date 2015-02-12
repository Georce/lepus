<?php 
class Menu_model extends CI_Model{


	protected $table='admin_menu';
	
	/*
	 * 保存信息
	 */
	public function insert($data){		
		$this->db->insert($this->table, $data);
	}
	
	/*
	 * 更新信息
	*/
	public function update($data,$id){
		$this->db->where('menu_id', $id);
		$this->db->update($this->table, $data);
	}
    
    /*
	 * 删除信息
	*/
	public function delete($id){
		$this->db->where('menu_id', $id);
		$this->db->delete($this->table);
	}
	
	
	/*
	 * 根据id获取信息
	 */
	function get_record_by_id($id){
		$query = $this->db->get_where($this->table, array('menu_id' =>$id));
		if ($query->num_rows() > 0)
		{
			return $query->row_array();
		}
	}
	
    
	/*
    *  查询数据列表
    */
    function get_total_record(){
        $this->db->order_by('display_order','asc');
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0)
		{
			$result['datalist']=$query->result_array();
            $result['datacount']=$query->num_rows();
            return $result;
		}
    }
    
    
    /*
    *根据parent_id获取menu_level
    */
    function get_level_by_parant_id($parant_id){
        if($parant_id==0){
            $level = 1;
        }
        else{
            $this->db->where('menu_id',$parant_id);
		    $query = $this->db->get($this->table);
            if ($query->num_rows() > 0)
		    {
			   $result=$query->row();
               $level = $result->menu_level +1;
		    }
        }
        return $level;
    }
    
    function get_parent_id($menu_id){
        if($menu_id!=0){
            $this->db->where('menu_id',$menu_id);
		    $query = $this->db->get($this->table);
            if ($query->num_rows() > 0)
		    {
			   $result=$query->row();
               $parent_id = $result->parent_id;
		    }
        }
        else{
            $parent_id=0;
        }
        return $parent_id;
    }


}

/* End of file menu_model.php */
/* Location: ./application/models/menu_model.php */