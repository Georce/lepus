<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class Task extends CI_Controller {
    function __construct()
    {
		  parent::__construct();
      $this->load->model("option_model","settings");
	}
    
    public function send_mysql_slowquery_mail()
    {
        $query_getservers = $this->db->query("select id,host,port,send_slowquery_to_list from db_servers_mysql where slow_query=1 and send_slowquery_to_list != '';");
		if ($query_getservers->num_rows() > 0)
		{
			$servers = $query_getservers->result_array();
            foreach($servers as $item){
                $server_id = $item['id'];
                $server = $item['host'].':'.$item['port'];
                $send_mail_to_list = $item['send_slowquery_to_list'];
                $query_last_sendmail_time = $this->db->query("select sendmail_time from mysql_slow_query_sendmail_log where server_id=$server_id and sendmail_status=1 order by sendmail_time desc limit 1;");
                if ($query_last_sendmail_time->num_rows() > 0){
                    $last_sendmail_time = $query_last_sendmail_time->row()->sendmail_time;
                    $ext_where = " and last_seen>'$last_sendmail_time'";
                }
                else{
                    $ext_where='';
                }
                $query_slowquery = $this->db->query("select review.*,history.* from mysql_slow_query_review review join mysql_slow_query_review_history history on review.`checksum`=history.checksum and serverid_max=$server_id and db_max!='information_schema' and fingerprint!='commit' and user_max!='root' $ext_where order by query_time_sum desc limit 20;");
                if ($query_slowquery->num_rows() > 0)
		        {
			         $slowquery = $query_slowquery->result_array();
                     $mail_header = "<p>Hi All:<br/> 下面的慢查询语句或许会影响到数据库的稳定性和健康性，请您在收到此邮件后及时优化语句或代码。数据库的稳定性需要大家的共同努力,感谢您的配合！</p>";
                     $table_header="<table border=1 bgcolor=#dae8fb style='font-size: 12px;' >
                                    <tr>
                                    <th colspan=12>MySQL慢查询自动推送邮件 主机:".$server."</th>
                                    </tr>
                                    <tr>
                                 <th>checksum</th>
                                 <th>数据库 </th>
                                 <th>用户</th>	
                                 <th>抽象语句</th>
                                 <th>SQL示例</th>
                                 <th>执行次数</th>
                                 <th>执行总时间</th>
                                 <th>最大执行时间</th>
                                 <th>最大锁时间</th>
                                 <th>最大返回结果数</th>
                                 <th>最大扫描行数</th>
                                 <th>最近执行</th>
                                 </tr>
                                    ";
                     $table_content='';
                     foreach($slowquery as $record){
                        $table_record = "
  
                           <tr>
                                <td> ".$record['checksum']."  </td>	
                                <td> ".$record['db_max']."  </td>	
                                <td> ".$record['user_max']."  </td>			
                                <td> ".$record['fingerprint']."  </td>	
                                <td> ".$record['sample']."  </td>
                                <td> ".$record['ts_cnt']."  </td>
                                <td> ".$record['Query_time_sum']."  </td>	
                                <td> ".$record['Query_time_max']."  </td>	
                                <td> ".$record['Lock_time_max']."  </td>	
                                <td> ".$record['Rows_sent_max']."  </td>	
                                <td> ".$record['Rows_examined_max']."  </td>
                                <td> ".$record['last_seen']."  </td>	
	                       </tr>
                        ";
                        $table_content =$table_content.$table_record;   
                      }
                     
                      $table_footer="</table>";
                      $table_content = $mail_header.$table_header.$table_content.$table_footer;
                      //发送邮件
                      $uri='';
				 	            $title="您的MySQL数据库".$server."发现慢查询,请及时优化.";
				 	            $content =
				 	            $table_content.
				 	            "<br> 该邮件由Lepus系统自动发出，请勿回复，语句详细执行情况请登录Lepus系统查看.";
			
                      $send_mail_to_list = array_filter(explode(';',$send_mail_to_list));
                      /*foreach($send_mail_to_list as $item){
                            $send_mail_to_list_new[] = $item.'@mail.com';
                      }*/
        
				 	            $this->load->library('email');
                      $this->email->clear();

                      $config['protocol'] = 'smtp';
                      $config['mailtype'] = 'html';
                      $config['charset'] = 'utf-8';
                      $config['smtp_host'] = $this->settings->get_option_item('smtp_host');
                      $config['smtp_port'] = $this->settings->get_option_item('smtp_port');
                      $config['smtp_user'] = $this->settings->get_option_item('smtp_user');
                      $config['smtp_pass'] = $this->settings->get_option_item('smtp_pass');
                      $config['smtp_timeout'] = $this->settings->get_option_item('smtp_timeout');
                      $mailfrom = $this->settings->get_option_item('mailfrom');
                      $this->email->initialize($config);

				 	            $this->email->from($mailfrom);
				 	            $this->email->to($send_mail_to_list);
				 	            $this->email->subject($title);
				 	            $this->email->message($content);
				 	            if( ! $this->email->send()){
                         $this->db->query("insert into mysql_slow_query_sendmail_log(server_id,sendmail_status,sendmail_info) values($server_id,0,'Send slowquery mail fail!');");
                         echo $server." Send slowquery mail Fail!</br>";
				 	            }
                      else{
                         //add tag
                         $this->db->query("insert into mysql_slow_query_sendmail_log(server_id,sendmail_status,sendmail_info) values($server_id,1,'Send slowquery mail success!');");
                         echo $server." Send slowquery mail seccess!</br>";
                      }
                    
                 }
                 else{
                    $this->db->query("insert into mysql_slow_query_sendmail_log(server_id,sendmail_status,sendmail_info) values($server_id,-1,'No last slowquery found!');");
                    echo $server." No last slowquery found!</br>";
                 }
            }
        }
        
        
    }
    
    
    function send_report_mail()
    {
            
            //Overview

            $mysql_servers_up = $this->db->query("select count(*) as num from mysql_status where connect=1")->row()->num;
            $mysql_servers_down = $this->db->query("select count(*) as num from mysql_status  where connect!=1")->row()->num;

            $mongodb_servers_up = $this->db->query("select count(*) as num from mongodb_status where ok=1")->row()->num;
            $mongodb_servers_down = $this->db->query("select count(*) as num from mongodb_status  where ok!=1")->row()->num;

            $os_snmp_up = $this->db->query("select count(*) as num from os_resource where snmp=1")->row()->num;
            $os_snmp_down = $this->db->query("select count(*) as num from os_resource  where snmp!=1")->row()->num;

 
            $table_overview = "
              <table border=1 bgcolor=#dae8fb style='font-size: 12px;' >
                                <tr>
                                    <th colspan=6>数据库概况</th>
                                </tr>
                                <tr>
                                <td> MySQL Up </td>
                                <td> MySQL Down </td>
                                <td> MongoDB Up </td>
                                <td> MongoDB Down </td>
                                <td> OS SNMP Up </td>
                                <td> OS SNMP Down </td>
                                 </tr>
                                 <tr>
                                <td>".$mysql_servers_up."</td>
                                <td>".$mysql_servers_down."</td>  
                                <td>".$mongodb_servers_up." </td>  
                                <td>".$mongodb_servers_down."</td>  
                                <td>".$os_snmp_up." </td>
                                <td>".$os_snmp_down." </td>  
                      
                              </tr>
              </table>
            ";

            //last alarm
            $last_alarm = $this->db->query("select * from alarm_history order by id desc limit 10;")->result_array();
            $table_header="<table border=1 bgcolor=#dae8fb style='font-size: 12px;' >
                                <tr>
                                    <th colspan=7>最新告警</th>
                                </tr>
                                <tr>
                                <td>host</td>
                                <td>application</td>
                                <td>db_type</td>
                                <td>level</td>
                                <td>message</td>
                                <td>value</td>
                                <td>monitor_time</td>
                                 </tr>
                                    ";
            $table_content='';
            foreach($last_alarm as $record){
                $table_record = "
  
                           <tr>
                                <td> ".$record['host'].":".$record['port']."</td>
                                <td> ".$record['application']." </td> 
                                <td> ".$record['db_type']."</td> 
                                <td> ".$record['level']."</td>
                                <td> ".$record['message']."</td>  
                                <td> ".$record['alarm_value']."</td>  
                                <td> ".$record['create_time']."</td> 
                         </tr>
                        ";
                $table_content =$table_content.$table_record;   
            }
                     
            $table_footer="</table>";
            $table_content_alarm = $table_header.$table_content.$table_footer;


            //mysql thread top 10
            $top_mysql_thread = $this->db->query("select server.host,server.port,status.threads_running,`status`.threads_connected,queries_persecond,transaction_persecond,app.`name` appname  from mysql_status status left join db_servers_mysql server
on `status`.server_id=`server`.id join db_application app where `server`.application_id=app.id order by threads_running desc limit 10;")->result_array();
            $table_header="<table border=1 bgcolor=#dae8fb style='font-size: 12px;' >
                                <tr>
                                    <th colspan=6>MySQL性能Top10</th>
                                </tr>
                                <tr>
                                <td>host</td>
                                <td>app</td>
                                <td>threads_running</td>
                                <td>threads_connected</td>
                                <td>queries_persecond</td>
                                <td>transaction_persecond</td>
                                 </tr>
                                    ";
            $table_content='';
            foreach($top_mysql_thread as $record){
                $table_record = "
  
                           <tr>
                                <td> ".$record['host'].":".$record['port']."  </td>
                                <td> ".$record['appname']."  </td>	
                                <td> ".$record['threads_running']."  </td>	
                                <td> ".$record['threads_connected']."  </td>	
                                <td> ".$record['queries_persecond']."  </td>
                                <td> ".$record['transaction_persecond']."  </td>	
                   		
	                       </tr>
                        ";
                $table_content =$table_content.$table_record;   
            }
            $table_footer="</table>";
            $table_content_mysql_thread = $table_header.$table_content.$table_footer;
            
            //mongodb connection top 10
            $top_mongodb_connections = $this->db->query("select server.host,server.port,`status`.connections_current,`status`.connections_available,`status`.opcounters_query_persecond,
`status`.opcounters_insert_persecond,`status`.opcounters_update_persecond,`status`.opcounters_delete_persecond,app.name appname from mongodb_status status left join db_servers_mongodb server
on `status`.server_id=`server`.id  join db_application app where `server`.application_id=app.id order by connections_current desc limit 10;")->result_array();
            $table_header="<table border=1 bgcolor=#dae8fb style='font-size: 12px;' >
                                <tr>
                                    <th colspan=8>MongoDB性能Top10</th>
                                </tr>
                                <tr>
                                <td>host</td>
                                <td>app</td>
                                <td>connections_current</td>
                                <td>connections_available</td>
                                <td>query</td>
                                <td>insert</td>
                                <td>update</td>
                                <td>delete</td>
                                 </tr>
                                    ";
            $table_content='';
            foreach($top_mongodb_connections as $record){
                $table_record = "
  
                           <tr>
                                <td> ".$record['host'].":".$record['port']."  </td>
                                <td> ".$record['appname']."  </td>	
                                <td> ".$record['connections_current']."  </td>	
                                <td> ".$record['connections_available']."  </td>	
                                <td> ".$record['opcounters_query_persecond']."  </td>
                                <td> ".$record['opcounters_insert_persecond']."  </td>
                                <td> ".$record['opcounters_update_persecond']."  </td>
                                <td> ".$record['opcounters_delete_persecond']."  </td>	
                   		
	                       </tr>
                        ";
                $table_content =$table_content.$table_record;   
            }
            $table_footer="</table>";
            $table_content_mongodb = $table_header.$table_content.$table_footer;
            
            
            //cupload top 10
            $top_cpuload = $this->db->query("select ip,load_1,load_5,load_15,process,cpu_idle_time  from os_resource order by load_1 desc limit 10;")->result_array();
            $table_header="<table border=1 bgcolor=#dae8fb style='font-size: 12px;' >
                                <tr>
                                    <th colspan=6>系统CPU负载Top10</th>
                                </tr>
                                <tr>
                                <td>ip</td>
                                <td>load_1</td>
                                <td>load_5</td>
                                <td>load_15</td>
                                <td>process</td>
                                <td>cpu idle</td>
                                 </tr>
                                    ";
            $table_content='';
            foreach($top_cpuload as $record){
                $table_record = "
  
                           <tr>
                                <td> ".$record['ip']."  </td>	
                                <td> ".$record['load_1']."  </td>	
                                <td> ".$record['load_5']."  </td>	
                                <td> ".$record['load_15']."  </td>
                                <td> ".$record['process']."  </td>	
                                <td> ".$record['cpu_idle_time']."%  </td>		
	                       </tr>
                        ";
                $table_content =$table_content.$table_record;   
            }
                     
            $table_footer="</table>";
            $table_content_cpuload = $table_header.$table_content.$table_footer;
            
            //disk top 10
            $top_diskusage = $this->db->query("select ip,mounted,total_size,used_size,avail_size,used_rate from os_diskinfo group by CONCAT(ip,mounted) order by cast(SUBSTRING_INDEX(used_rate,'%',1) as unsigned) desc limit 10;")->result_array();
            $table_header="<table border=1 bgcolor=#dae8fb style='font-size: 12px;' >
                                    <tr>
                                    <th colspan=6>系统磁盘使用率Top10</th>
                                    </tr>
                                    <tr>
                                <td>ip</td>
                                <td>mounted</td>
                                <td>total_size</td>
                                <td>used_size</td>
                                <td>avail_size</td>
                                <td>used_rate</td>
                                 </tr>
                                    ";
            $table_content='';
            foreach($top_diskusage as $record){
                $table_record = "
  
                           <tr>
                                <td> ".$record['ip']."  </td>	
                                <td> ".$record['mounted']."  </td>	
                                <td> ".format_kbytes($record['total_size'])."  </td>	
                                <td> ".format_kbytes($record['used_size'])."  </td>	
                                <td> ".format_kbytes($record['avail_size'])."  </td>	
                                <td> ".$record['used_rate']."  </td>		
	                       </tr>
                        ";
                $table_content =$table_content.$table_record;   
            }
                     
            $table_footer="</table>";
            $table_content_disk = $table_header.$table_content.$table_footer;
            
            
            //echo $table_overview."</p>".$table_content_alarm."</p>".$table_content_mysql_thread."</p>".$table_content_mongodb."</p>".$table_content_cpuload."</p>".$table_content_disk;
            $title="数据库服务器健康检查报告";
            $content=$table_overview."</p>".$table_content_alarm."</p>".$table_content_mysql_thread."</p>".$table_content_mongodb."</p>".$table_content_cpuload."</p>".$table_content_disk;
            
            
            $this->load->library('email');
            $this->email->clear();

            $config['protocol'] = 'smtp';
            $config['mailtype'] = 'html';
            $config['charset'] = 'utf-8';
            $config['smtp_host'] = $this->settings->get_option_item('smtp_host');
            $config['smtp_port'] = $this->settings->get_option_item('smtp_port');
            $config['smtp_user'] = $this->settings->get_option_item('smtp_user');
            $config['smtp_pass'] = $this->settings->get_option_item('smtp_pass');
            $config['smtp_timeout'] = $this->settings->get_option_item('smtp_timeout');
            $mailfrom = $this->settings->get_option_item('mailfrom');
            $report_mail_to_list = $this->settings->get_option_item('report_mail_to_list');
            $this->email->initialize($config);

            $this->email->from($mailfrom);
            $this->email->to($report_mail_to_list);
            $this->email->subject($title);
            $this->email->message($content);
				 	  if( ! $this->email->send()){
                  
                         echo " Send report mail Fail!</br>";
            }
            else{
                         
                         echo " Send report mail seccess!</br>";
            }
            
                      
                      
  
  }
    

    
}

/* End of file task.php */
/* Location: ./application/controllers/task.php */