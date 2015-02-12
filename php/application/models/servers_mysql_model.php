<?php 
class Servers_mysql_model extends CI_Model{

    protected $table='db_servers_mysql';
    
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
    
    function get_total_record_usage(){
        $this->db->where('is_delete',0);
        $query = $this->db->get($this->table);
		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
	}
    
    function get_total_record_awr(){
        $this->db->where('is_delete',0);
        $this->db->where('monitor',1);
        $query = $this->db->get($this->table);
		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
	}
    
    function get_total_record_slave(){
        $this->db->where('is_delete',0);
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
    
    function get_total_record_sql($sql){
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0)
		{
			$result['datalist']=$query->result_array();
            $result['datacount']=$query->num_rows();
            return $result;
		}
		
    }
    
    function get_total_slowquery_server(){
        $this->db->where('slow_query',1);
        $this->db->order_by('host','asc');
        $query = $this->db->get($this->table);
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
    
    function get_host_by_id($id)
    {
		$query = $this->db->get_where($this->table, array('id' =>$id));
		if ($query->num_rows() > 0)
		{
			 $result=$query->row_array();
             return $result['host'];
		}
	}
    
    function get_servers($server_id){
        $query = $this->db->get_where($this->table, array('id' =>$server_id));
		if ($query->num_rows() > 0)
		{
			$data=$query->row_array();
            return $data['host'].":".$data['port'];
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
	 * 删除db_status里面不监控的主机
	*/
	public function db_status_remove($id){
		$this->db->where('server_id', $id);
		$this->db->where('db_type', 'mysql');
		$this->db->delete('db_status');
	}
	
    
}

/* End of file servers_mysql_model.php */
/* Location: ./application/models/servers_mysql_model.php */