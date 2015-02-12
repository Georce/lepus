<?php 
class Webserver_model extends CI_Model{

    protected $table='webserver';
    protected $table_health='webserver_health';
    
	function get_total_rows(){
		$this->db->from($this->table);
        return $this->db->count_all_results();
	}
    
    function get_total_record(){
        $query = $this->db->get($this->table);
		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
	}
    
    function get_total_record_paging($limit,$offset){
        $query = $this->db->get($this->table,$limit,$offset);
		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
	}
    
    
   	/*
	 * 根据id获取单条记录
	 */
	function get_record_by_id($id){
		$query = $this->db->get_where($this->table, array('id' =>$id));
		if ($query->num_rows() > 0)
		{
			return $query->row_array();
		}
	}
    
    /*
    * 插入数据
    */
   	public function insert($data){		
		$this->db->insert($this->table, $data);
	}
    
    /*
	 * 更新信息
	*/
	public function update($data,$id){
		$this->db->where('id', $id);
		$this->db->update($this->table, $data);
	}
    
    /*
	 * 删除信息
	*/
	public function delete($id){
		$this->db->where('id', $id);
		$this->db->delete($this->table);
	}
    
    /*
    *获取监控状态数据
    */
    function get_total_health_rows(){
		$this->db->from($this->table_health);
        return $this->db->count_all_results();
	}
    
    function get_total_health_record_paging($limit,$offset){
        $query = $this->db->get($this->table_health,$limit,$offset);
		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
	}
	
    
}

/* End of file webserver_model.php */
/* Location: ./application/models/webserver_model.php */