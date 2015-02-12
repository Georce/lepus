<div class="header">
            
    <h1 class="page-title"><?php echo $this->lang->line('_Redis'); ?> <?php echo $this->lang->line('_Replication Monitor'); ?></h1>
</div>
        
<ul class="breadcrumb">
            <li><a href=""><?php echo $this->lang->line('home'); ?></a> <span class="divider">/</span></li>
            <li class="active"><?php echo $this->lang->line('_Redis Monitor'); ?></li><span class="divider">/</span></li>
            <li class="active"><?php echo $this->lang->line('_Replication Monitor'); ?></li>
            <span class="right"><?php echo $this->lang->line('the_latest_acquisition_time'); ?>:<?php if(!empty($datalist)){ echo $datalist[0]['create_time'];} else {echo $this->lang->line('the_monitoring_process_is_not_started');} ?></span>
</ul>

<div class="container-fluid">
<div class="row-fluid">
                    

<div class="ui-state-default ui-corner-all" style="height: 45px;" >
<p><span class="ui-icon ui-icon-search" style="float: left; margin-right: .3em;"></span>
                    
<form name="form" class="form-inline" method="get" action="<?php site_url('lp_mysql/replication') ?>" >
  <input type="hidden" name="search" value="submit" />
  
  <select name="application_id" class="input-small" style="width: 120px;">
  <option value=""><?php echo $this->lang->line('application'); ?></option>
  <?php foreach ($application  as $item):?>
  <option value="<?php echo $item['id'];?>" <?php if($setval['application_id']==$item['id']) echo "selected"; ?> ><?php echo $item['display_name'] ?></option>
   <?php endforeach;?>
  </select>
  
  <select name="server_id" class="input-small"  style="width: 120px;" >
  <option value=""><?php echo $this->lang->line('host'); ?></option>
  <?php foreach ($server as $item):?>
  <option value="<?php echo $item['id'];?>" <?php if($setval['server_id']==$item['id']) echo "selected"; ?> ><?php echo $item['host'];?>:<?php echo $item['port'];?></option>
   <?php endforeach;?>
  </select>
  
  <select name="role" class="input-small" >
  <option value=""><?php echo $this->lang->line('db_role'); ?></option>
  <option value="is_master" <?php if($setval['role']=='is_master') echo "selected"; ?> ><?php echo $this->lang->line('master'); ?></option>
  <option value="is_slave" <?php if($setval['role']=='is_slave') echo "selected"; ?> ><?php echo $this->lang->line('slave'); ?></option>
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
  <a href="<?php echo site_url('lp_redis/replication') ?>" class="btn btn-warning"><i class="icon-repeat"></i> <?php echo $this->lang->line('reset'); ?></a>
  <button id="refresh" class="btn btn-info"><i class="icon-refresh"></i> <?php echo $this->lang->line('refresh'); ?></button>

</form>               
</div>




<div class="well">
    <table class="table table-hover  table-condensed " style="font-size: 12px;">
      <thead>
        <tr>
		<th colspan="2"><center><?php echo $this->lang->line('servers'); ?></center></th>
    <th colspan="2"><center><?php echo $this->lang->line('health'); ?></center></th>
		<th colspan="4"><center>repl_backlog</center></th>

        <th ></th>
	   </tr>
        <tr>
        <th><?php echo $this->lang->line('host'); ?></th>
        <th><?php echo $this->lang->line('role'); ?></th>
        <th><?php echo $this->lang->line('read_only'); ?></th>
        <th><?php echo $this->lang->line('link_status'); ?></th>
        <th><?php echo $this->lang->line('delay'); ?></th>
        <th><?php echo $this->lang->line('repl_backlog_active'); ?></th>
        <th><?php echo $this->lang->line('repl_backlog_size'); ?></th>
        <th><?php echo $this->lang->line('repl_backlog_first_byte_offset'); ?></th>
        <th><?php echo $this->lang->line('repl_backlog_histlen'); ?></th>
  
	   </tr>
      </thead>
      <tbody>
<?php if(!empty($datalist)) {?>
 <?php foreach ($datalist  as $item):?>
    <tr>
        <td><?php  echo $item['host'].':'. $item['port'] ?></td>
        <td><?php echo $item['role'] ?></td>
        <td><?php echo $item['slave_read_only'] ?></td>
        <td><?php echo $item['master_link_status'] ?></td>
        <td><?php echo $item['master_last_io_seconds_ago'] ?></td>
        <td><?php echo $item['repl_backlog_active'] ?></td>
        <td><?php echo $item['repl_backlog_size'] ?></td>
        <td><?php echo $item['repl_backlog_first_byte_offset'] ?></td>
        <td><?php echo $item['repl_backlog_histlen'] ?></td>
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
