<div class="header">
            
    <h1 class="page-title"><?php echo $this->lang->line('mysql'); ?> <?php echo $this->lang->line('_Replication Monitor'); ?></h1>
</div>
        
<ul class="breadcrumb">
            <li><a href=""><?php echo $this->lang->line('home'); ?></a> <span class="divider">/</span></li>
            <li class="active"><?php echo $this->lang->line('_MySQL Monitor'); ?></li><span class="divider">/</span></li>
            <li class="active"><?php echo $this->lang->line('_Replication Monitor'); ?></li>
            <span class="right"><?php echo $this->lang->line('the_latest_acquisition_time'); ?>:<?php if(!empty($datalist)){ echo $datalist[0]['create_time'];} else {echo $this->lang->line('the_monitoring_process_is_not_started');} ?></span>
</ul>

<div class="container-fluid">
<div class="row-fluid">
                    
<script src="lib/bootstrap/js/bootstrap-switch.js"></script>
<link href="lib/bootstrap/css/bootstrap-switch.css" rel="stylesheet"/>

<div class="ui-state-default ui-corner-all" style="height: 45px;" >
<p><span class="ui-icon ui-icon-search" style="float: left; margin-right: .3em;"></span>
                    
<form name="form" class="form-inline" method="get" action="<?php site_url('lp_mysql/replication') ?>" >
  <input type="hidden" name="search" value="submit" />
  
   <input type="text" id="host"  name="host" value="" placeholder="<?php echo $this->lang->line('please_input_host'); ?>" class="input-medium" >
  <input type="text" id="tags"  name="tags" value="" placeholder="<?php echo $this->lang->line('please_input_tags'); ?>" class="input-medium" >
  
  <select name="role" class="input-small" >
  <option value=""><?php echo $this->lang->line('db_role'); ?></option>
  <option value="is_master" <?php if($setval['role']=='is_master') echo "selected"; ?> ><?php echo $this->lang->line('master'); ?></option>
  <option value="is_slave" <?php if($setval['role']=='is_slave') echo "selected"; ?> ><?php echo $this->lang->line('slave'); ?></option>
  </select>
  
  <select name="delay" class="input-small" style="width: 110px;">
  <option value=""><?php echo $this->lang->line('delay'); ?></option>
  <option value="30" <?php if($setval['delay']=='30') echo "selected"; ?> >> 30 <?php echo $this->lang->line('date_seconds'); ?></option>
  <option value="60" <?php if($setval['delay']=='60') echo "selected"; ?> >> 1 <?php echo $this->lang->line('date_minutes'); ?></option>
  <option value="300" <?php if($setval['delay']=='300') echo "selected"; ?> >> 5 <?php echo $this->lang->line('date_minutes'); ?></option>
  <option value="600" <?php if($setval['delay']=='600') echo "selected"; ?> >> 10 <?php echo $this->lang->line('date_minutes'); ?></option>
  <option value="1800" <?php if($setval['delay']=='1800') echo "selected"; ?> >> 30 <?php echo $this->lang->line('date_minutes'); ?></option>
  <option value="3600" <?php if($setval['delay']=='3600') echo "selected"; ?> >> 1 <?php echo $this->lang->line('date_hours'); ?></option>
  <option value="28800" <?php if($setval['delay']=='28800') echo "selected"; ?> >> 8 <?php echo $this->lang->line('date_hours'); ?></option>
  <option value="86400" <?php if($setval['delay']=='86400') echo "selected"; ?> >> 1 <?php echo $this->lang->line('date_dayss'); ?></option>
  </select>
  
  <select name="order" class="input-small" style="width: 130px;">
  <option value="id"><?php echo $this->lang->line('sort'); ?></option>
  <option value="id" <?php if($setval['order']=='id') echo "selected"; ?> ><?php echo $this->lang->line('id'); ?></option>
  <option value="delay" <?php if($setval['order']=='delay') echo "selected"; ?> ><?php echo $this->lang->line('delay'); ?></option>
  <option value="master_binlog_space" <?php if($setval['order']=='master_binlog_space') echo "selected"; ?> ><?php echo $this->lang->line('binlog_space'); ?></option>
  </select>
  
  </select>
  <select name="order_type" class="input-small" style="width: 70px;">
  <option value="asc" <?php if($setval['order_type']=='asc') echo "selected"; ?> ><?php echo $this->lang->line('asc'); ?></option>
  <option value="desc" <?php if($setval['order_type']=='desc') echo "selected"; ?> ><?php echo $this->lang->line('desc'); ?></option>
  </select>
  
  <button type="submit" class="btn btn-success"><i class="icon-search"></i> <?php echo $this->lang->line('search'); ?></button>
  <a href="<?php echo site_url('lp_mysql/replication') ?>" class="btn btn-warning"><i class="icon-repeat"></i> <?php echo $this->lang->line('reset'); ?></a>
  <button id="refresh" class="btn btn-info"><i class="icon-refresh"></i> <?php echo $this->lang->line('refresh'); ?></button>

</form>               
</div>




<div class="well">
    <table class="table table-hover  table-condensed " style="font-size: 12px;">
      <thead>
        <tr>
		<th colspan="5"><center><?php echo $this->lang->line('servers'); ?></center></th>
		<th colspan="3"><center><?php echo $this->lang->line('thread'); ?></center></th>
		<th colspan="2"><center><?php echo $this->lang->line('binary_logs'); ?></center></th>
		<th colspan="3"><center><?php echo $this->lang->line('master_postion'); ?></center></th>
        <th ></th>
	   </tr>
        <tr>
        <th><?php echo $this->lang->line('host'); ?></th>
        <th><?php echo $this->lang->line('tags'); ?></th>
        <th><?php echo $this->lang->line('db_role'); ?></th>
        <th><?php echo $this->lang->line('gtid_mode'); ?></th>
        <th><?php echo $this->lang->line('read_only'); ?></th>
		<th><?php echo $this->lang->line('io'); ?></th>
        <th><?php echo $this->lang->line('sql'); ?></th>
        <th><?php echo $this->lang->line('time_behind'); ?></th>
		<th><?php echo $this->lang->line('current_file'); ?></th>
		<th><?php echo $this->lang->line('postion'); ?></th>
        <th><?php echo $this->lang->line('binary_log'); ?></th>
		<th><?php echo $this->lang->line('postion'); ?></th>
        <th><?php echo $this->lang->line('space'); ?></th>
        <th><?php echo $this->lang->line('chart'); ?></th>
	   </tr>
      </thead>
      <tbody>
<?php if(!empty($datalist)) {?>
 <?php foreach ($datalist  as $item):?>
    <tr>
        <td><?php  echo $item['host'].':'. $item['port'] ?></td>
        <td><?php echo $item['tags'] ?></td>
        <td><?php echo check_role($item['is_master'],$item['is_slave']) ?></td>
        <td><?php echo $item['gtid_mode'] ?></td>
        <td><?php echo $item['read_only'] ?></td>
        <td><?php echo check_value($item['slave_io_run']) ?></td>
        <td><?php echo check_value($item['slave_sql_run']) ?></td>
		<td><?php echo check_delay($item['delay']) ?>  </td>
        <td><?php echo $item['current_binlog_file'] ?></td>
        <td><?php echo $item['current_binlog_pos'] ?></td>
        <td><?php echo $item['master_binlog_file'] ?></td>
        <td><?php echo $item['master_binlog_pos'] ?></td>
        <td><?php echo check_binlog_space($item['master_binlog_space']) ?></td>
        <td><?php if($item['is_slave']=='1' and $item['slave_io_run']=='Yes' and $item['slave_sql_run']=='Yes'){?><a href="<?php echo site_url('lp_mysql/replication_chart/'.$item['server_id']) ?>"><img src="./images/chart.gif"/></a><?php } ?>&nbsp;</td>
        
	</tr>
 <?php endforeach;?>
<?php }else{  ?>
<tr>
<td colspan="12">
<font color="red"><?php echo $this->lang->line('no_record'); ?></font>
</td>
</tr>
<?php } ?>   
      </tbody>
    </table>
</div>



 <script type="text/javascript">
    $('#refresh').click(function(){
        document.location.reload(); 
    })
 </script>
