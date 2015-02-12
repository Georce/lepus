<?php 
class Option_model extends CI_Model{

    protected $table='options';
    
	
   	/*
	 * 获取选项
	 */
	function get_option(){
		$query = $this->db->get($this->table);
		if ($query->num_rows() > 0)
		{
	        $result=$query->result_array();
            foreach($result as $r){
                $key=$r['name'];
                $value=$r['value'];
                $data[$key]=$value;
            }
         
            return $data;
		}
	}
    
    /*
	 * 获取单个选项
	 */
	function get_option_item($key){
        $this->db->where('name',$key);
		$query = $this->db->get($this->table);
		if ($query->num_rows() > 0)
		{
	        $result=$query->row_array();
            if($result){
                return $result['value'];
            }
		}
	}
    
    
    /*
	 * 更新信息
	*/
	public function update($data,$key){
		$this->db->where('name', $key);
		$this->db->update($this->table, $data);
	}
    
	
    
}

/* End of file option_model.php */
/* Location: ./application/models/option_model.php */