<?php 
class Alarm_model extends CI_Model{

	protected $table='alarm_history';
    
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
        $this->db->limit($limit,$offset);
        $query = $this->db->get($this->table);
		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
	}
    
	
    
}

/* End of file alarm_model.php */
/* Location: ./application/models/alarm_model.php */