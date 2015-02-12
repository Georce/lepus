<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class Widget extends Front_Controller {

    function __construct(){
		parent::__construct();
		
	}
    

    public function index(){
        $data["cur_nav"]="widget";
        $this->layout->view("widget/index",$data);
    }
    
    public function bigtable(){
        $sql="select a.*,b.host,b.port from mysql_widget_bigtable a,servers b where a.server_id=b.id order by a.table_size desc";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0)
		{
			$datalist=$query->result_array();
            $data['datalist']=$datalist;
		}
        
        $data["cur_nav"]="widget";
        $this->layout->view("widget/bigtable",$data);
    }
    
    public function hit_rate(){
        $sql="select a.*,b.host,b.port from mysql_widget_hit_rate a,servers b where a.server_id=b.id ";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0)
		{
			$datalist=$query->result_array();
            $data['datalist']=$datalist;
		}
        
        $data["cur_nav"]="widget";
        $this->layout->view("widget/hit_rate",$data);
    }
    
     public function connect(){
        $sql="select a.*,b.host,b.port from mysql_widget_connect a,servers b where a.server_id=b.id order by connect_count desc";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0)
		{
			$datalist=$query->result_array();
            $data['datalist']=$datalist;
		}
        
        $data["cur_nav"]="widget";
        $this->layout->view("widget/connect",$data);
    }
    
   
    
}

/* End of file widget.php */
/* Location: ./application/controllers/widget.php */