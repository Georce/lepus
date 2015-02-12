<?php 
class Redis_model extends CI_Model{

	
    
    function get_total_record_sql($sql){
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0)
		{
			$result['datalist']=$query->result_array();
            $result['datacount']=$query->num_rows();
            return $result;
		}
    }
    
	
    function get_status_total_record($health=''){
        
        $this->db->select('*');
        $this->db->from('redis_status ');
        if($health==1){
            $this->db->where("connect", 1);
        }
        
        !empty($_GET["host"]) && $this->db->like("host", $_GET["host"]);
        !empty($_GET["tags"]) && $this->db->like("tags", $_GET["tags"]);
        
        if(!empty($_GET["order"]) && !empty($_GET["order_type"])){
            $this->db->order_by($_GET["order"],$_GET["order_type"]);
        }
        else{
            $this->db->order_by('tags asc');
        }
        
        $query = $this->db->get();
        if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
    }
    


	function get_status_chart_record($server_id,$time){
        $query=$this->db->query("select * from redis_status_history  where server_id=$server_id and YmdHi=$time limit 1; ");
        if ($query->num_rows() > 0)
        {
           return $query->row_array(); 
        }
    }
    
    function check_has_record($server_id,$time){
        $query=$this->db->query("select id from redis_status_history where server_id=$server_id and YmdHi=$time");
        if ($query->num_rows() > 0)
        {
           return true; 
        }
        else{
            return false;
        }
    }

     function get_replication_total_record(){
        
        $this->db->select('repl.*,servers.host,servers.port,application.display_name application');
        $this->db->from('redis_replication repl');
        $this->db->join('db_servers_redis servers', 'repl.server_id=servers.id', 'left');
        $this->db->join('db_application application', 'servers.application_id=application.id', 'left');
        
        !empty($_GET["application_id"]) && $this->db->where("repl.application_id", $_GET["application_id"]);
        !empty($_GET["server_id"]) && $this->db->where("repl.server_id", $_GET["server_id"]);
        if(!empty($_GET["role"]) ){
            $this->db->where('role', $_GET["role"]);
        }
        if(!empty($_GET["order"]) && !empty($_GET["order_type"])){
            $this->db->order_by($_GET["order"],$_GET["order_type"]);
        }
        
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            return $query->result_array();
        }
    }
    
    
    
    

}

/* End of file redis_model.php */
/* Location: ./application/models/redis_model.php */