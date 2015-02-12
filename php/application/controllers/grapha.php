<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Grapha extends Front_Controller {
    function __construct(){
		parent::__construct();
        ini_set("include_path", "D:/wwwroot/mysqlmtop/frontweb/public");
		$this->load->model("mysql_model","mysql");
        $this->load->model('application_model','app');
        $this->load->model('servers_model','server');   
	}
    
    
    
    
    
    public function active(){
        require_once ('jpgraph/jpgraph.php');
        require_once ('jpgraph/jpgraph_line.php');
        require_once ('jpgraph/jpgraph_date.php');
        require_once ('jpgraph/jpgraph_utils.inc.php');
        $dateUtils = new DateScaleUtils();
        
        $size=$this->uri->segment(3);
        $server_id=$this->uri->segment(4);
        $time=$this->uri->segment(5);
        
        $server=$this->server->get_record_by_id($server_id);
            
        $start = time()-$time;
        $mcount = $time/60;
        $data = array();
        $xdata = array();
        for( $i=0; $i < $mcount; ++$i ) {
            $time=$start + $i * 60;
            $xdata[$i] = $time;
            $date_min=date('YmdHi',$time);
            $query = $this->db->query("select active from mysql_status_history where server_id='$server_id' and YmdHi = '".$date_min."'; ");
            if ($query->num_rows() > 0)
            {
               $row = $query->row(); 
               $yresult= $row->active;

            }
            else{
                $yresult='0';
            }
            $ydata[$i] = intval($yresult);
        }
       
        

        // Create the graph. These two calls are always required
        if($size=='small'){
            $width=400;
            $height=260;
        }
        else if($size='large'){
            $width=1280;
            $height=400;
        }	
        $graph = new Graph($width, $height);
        //$graph->SetScale("textlin");
        $graph->SetScale('datelin');
        $graph->xaxis->SetLabelAngle(90);
        $graph->xaxis->scale->SetDateFormat('H:i');
        $graph->SetShadow();
        $graph->img->SetMargin(40,20,20,40);
        
        $dplot = new LinePlot($ydata,$xdata);
        $dplot->SetFillColor("blue@0.5");
        // Add the plot to the graph
        $graph->Add($dplot);
        
        $graph->xaxis->SetTextTickInterval(2);
        $grapha_title= $server['host'].":".$server['port']." ".$server['application']." active session";
        $graph->title->Set($grapha_title);
        $graph->xaxis->title->Set("");
        $graph->yaxis->title->Set("");

        $graph->title->SetFont(FF_FONT1,FS_BOLD);
        $graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
        $graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
       
        // Display the graph
        $graph->Stroke();
    }
    
    public function connections(){
        require_once ('jpgraph/jpgraph.php');
        require_once ('jpgraph/jpgraph_line.php');
        require_once ('jpgraph/jpgraph_date.php');
        
        $size=$this->uri->segment(3);
        $server_id=$this->uri->segment(4);
        $time=$this->uri->segment(5);
        
        $server=$this->server->get_record_by_id($server_id);
        
        $start = time()-$time;
        $mcount = $time/60;

        $data = array();
        $xdata = array();
        for( $i=0; $i < $mcount; ++$i ) {
            $time=$start + $i * 60;
            $xdata[$i] = $time;
            $date_min=date('YmdHi',$time);
            $query = $this->db->query("select connections from mysql_status_history where server_id='$server_id' and YmdHi = '".$date_min."'; ");
            if ($query->num_rows() > 0)
            {
               $row = $query->row(); 
               $yresult= $row->connections;

            }
            else{
                $yresult='0';
            }
            
            $ydata[$i] = $yresult;
        }
       
        // Create the graph. These two calls are always required
        if($size=='small'){
            $width=400;
            $height=260;
        }
        else if($size='large'){
            $width=1280;
            $height=400;
        }	
        $graph = new Graph($width, $height);
        //$graph->SetScale("textlin");
        $graph->SetScale('datelin');
        $graph->xaxis->SetLabelAngle(90);
        $graph->xaxis->scale->SetDateFormat('H:i');
        $graph->SetShadow();
        $graph->img->SetMargin(40,20,20,40);
        
        $dplot = new LinePlot($ydata,$xdata);
        $dplot->SetFillColor("green@0.5");
        // Add the plot to the graph
        $graph->Add($dplot);
        
        $graph->xaxis->SetTextTickInterval(2);
       $grapha_title= $server['host'].":".$server['port']." ".$server['application']." connections";
        $graph->title->Set($grapha_title);
        $graph->xaxis->title->Set("");
        $graph->yaxis->title->Set("");
   

        $graph->title->SetFont(FF_FONT1,FS_BOLD);
        $graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
        $graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
        $graph->Stroke();
    }
    
    public function qpstps(){
        require_once ('jpgraph/jpgraph.php');
        require_once ('jpgraph/jpgraph_line.php');
        require_once ('jpgraph/jpgraph_date.php');
        
        $size=$this->uri->segment(3);
        $server_id=$this->uri->segment(4);
        $time=$this->uri->segment(5);
        
        $server=$this->server->get_record_by_id($server_id);
        
        $start = time()-$time;
        $mcount = $time/60;

        $data = array();
        $xdata = array();
        
        for( $i=0; $i < $mcount; ++$i ) {
            $time=$start + $i * 60;
            $xdata[$i] = $time;
            $date_min=date('YmdHi',$time);
            $query = $this->db->query("select TPS from mysql_status_ext_history where server_id='$server_id' and YmdHi = '".$date_min."'; ");
            if ($query->num_rows() > 0)
            {
               $row = $query->row(); 
               $yresult= $row->TPS;

            }
            else{
                $yresult='0';
            }
            
            $ydata1[$i] = $yresult;
        }
        
        for( $i=0; $i < $mcount; ++$i ) {
            $time=$start + $i * 60;
            $xdata[$i] = $time;
            $date_min=date('YmdHi',$time);
            $query = $this->db->query("select QPS from mysql_status_ext_history where server_id='$server_id' and YmdHi = '".$date_min."'; ");
            if ($query->num_rows() > 0)
            {
               $row = $query->row(); 
               $yresult= $row->QPS;

            }
            else{
                $yresult='0';
            }
            
            $ydata2[$i] = $yresult;
        }
           

        // Create the graph. These two calls are always required
        if($size=='small'){
            $width=400;
            $height=260;
        }
        else if($size='large'){
            $width=1280;
            $height=400;
        }	
        $graph = new Graph($width, $height);
        //$graph->SetScale("textlin");
        $graph->SetScale('datelin');
        //$graph->SetY2Scale("lin"); 
        $graph->xaxis->SetLabelAngle(90);
        $graph->xaxis->scale->SetDateFormat('H:i');
        $graph->SetShadow();
        $graph->img->SetMargin(40,20,20,40);
        
        
        $dplot1 = new LinePlot($ydata2,$xdata);
        $dplot2 = new LinePlot($ydata1,$xdata);
        $dplot1->SetFillColor("orange@0.5");
        $dplot2->SetFillColor("red@0.5");
        // Create the accumulated graph
        //$accplot = new AccLinePlot($dplot);
        // Add the plot to the graph
        $graph->Add($dplot1);
        $graph->Add($dplot2);

        
        $graph->xaxis->SetTextTickInterval(2);
        $grapha_title= $server['host'].":".$server['port']." ".$server['application']." QPS/TPS";
        $graph->title->Set($grapha_title);
        $graph->xaxis->title->Set("");
        $graph->yaxis->title->Set("");
   

        $graph->title->SetFont(FF_FONT1,FS_BOLD);
        $graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
        $graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
        $graph->Stroke();
    }
    
    public function bytes_r(){
        require_once ('jpgraph/jpgraph.php');
        require_once ('jpgraph/jpgraph_line.php');
        require_once ('jpgraph/jpgraph_date.php');
        
        $size=$this->uri->segment(3);
        $server_id=$this->uri->segment(4);
        $time=$this->uri->segment(5);
        
        $server=$this->server->get_record_by_id($server_id);
        
        $start = time()-$time;
        $mcount = $time/60;

        $data = array();
        $xdata = array();
        for( $i=0; $i < $mcount; ++$i ) {
            $time=$start + $i * 60;
            $xdata[$i] = $time;
            $date_min=date('YmdHi',$time);
            $query = $this->db->query("select Bytes_received from mysql_status_ext_history where server_id='$server_id' and YmdHi = '".$date_min."'; ");
            if ($query->num_rows() > 0)
            {
               $row = $query->row(); 
               $yresult= $row->Bytes_received;

            }
            else{
                $yresult='0';
            }
            
            $ydata[$i] = $yresult;
        }
       
        // Create the graph. These two calls are always required
        if($size=='small'){
            $width=400;
            $height=260;
        }
        else if($size='large'){
            $width=1280;
            $height=400;
        }	
        $graph = new Graph($width, $height);
        //$graph->SetScale("textlin");
        $graph->SetScale('datelin');
        $graph->xaxis->SetLabelAngle(90);
        $graph->xaxis->scale->SetDateFormat('H:i');
        $graph->SetShadow();
        $graph->img->SetMargin(40,20,20,40);
        
        $dplot = new LinePlot($ydata,$xdata);
        $dplot->SetFillColor("green@0.3");
        // Add the plot to the graph
        $graph->Add($dplot);
        
        $graph->xaxis->SetTextTickInterval(2);
       $grapha_title= $server['host'].":".$server['port']." ".$server['application']." Received Flow(KB)";
        $graph->title->Set($grapha_title);
        $graph->xaxis->title->Set("");
        $graph->yaxis->title->Set("");
   

        $graph->title->SetFont(FF_FONT1,FS_BOLD);
        $graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
        $graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
        $graph->Stroke();
    }
    
    public function bytes_s(){
        require_once ('jpgraph/jpgraph.php');
        require_once ('jpgraph/jpgraph_line.php');
        require_once ('jpgraph/jpgraph_date.php');
        
        $size=$this->uri->segment(3);
        $server_id=$this->uri->segment(4);
        $time=$this->uri->segment(5);
        
        $server=$this->server->get_record_by_id($server_id);
        
        $start = time()-$time;
        $mcount = $time/60;

        $data = array();
        $xdata = array();
        for( $i=0; $i < $mcount; ++$i ) {
            $time=$start + $i * 60;
            $xdata[$i] = $time;
            $date_min=date('YmdHi',$time);
            $query = $this->db->query("select Bytes_sent from mysql_status_ext_history where server_id='$server_id' and YmdHi = '".$date_min."'; ");
            if ($query->num_rows() > 0)
            {
               $row = $query->row(); 
               $yresult= $row->Bytes_sent;

            }
            else{
                $yresult='0';
            }
            
            $ydata[$i] = $yresult;
        }
       
        // Create the graph. These two calls are always required
        if($size=='small'){
            $width=400;
            $height=260;
        }
        else if($size='large'){
            $width=1280;
            $height=400;
        }	
        $graph = new Graph($width, $height);
        //$graph->SetScale("textlin");
        $graph->SetScale('datelin');
        $graph->xaxis->SetLabelAngle(90);
        $graph->xaxis->scale->SetDateFormat('H:i');
        $graph->SetShadow();
        $graph->img->SetMargin(40,20,20,40);
        
        $dplot = new LinePlot($ydata,$xdata);
        $dplot->SetFillColor("orange@0.3");
        // Add the plot to the graph
        $graph->Add($dplot);
        
        $graph->xaxis->SetTextTickInterval(2);
       $grapha_title= $server['host'].":".$server['port']." ".$server['application']." Sent Flow(KB)";
        $graph->title->Set($grapha_title);
        $graph->xaxis->title->Set("");
        $graph->yaxis->title->Set("");
   

        $graph->title->SetFont(FF_FONT1,FS_BOLD);
        $graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
        $graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
        $graph->Stroke();
    }
    
    
    
}

/* End of file grapha.php */
/* Location: ./application/controllers/grapha.php */