<div class="header">
            
            <h1 class="page-title"><?php echo $this->lang->line('_Redis'); ?> <?php echo $this->lang->line('_Memory Monitor'); ?></h1>
</div>
        
<ul class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><?php echo $this->lang->line('home'); ?></a> <span class="divider">/</span></li>
            <li class="active"><?php echo $this->lang->line('_Redis Monitor'); ?></li><span class="divider">/</span></li>
            <li class="active"><?php echo $this->lang->line('_Memorys Monitor'); ?></li>
            <span class="right"><?php echo $this->lang->line('the_latest_acquisition_time'); ?>:<?php if(!empty($datalist)){ echo $datalist[0]['create_time'];} else {echo $this->lang->line('the_monitoring_process_is_not_started');} ?></span>
</ul>

<div class="container-fluid">
<div class="row-fluid">
 
<script src="lib/bootstrap/js/bootstrap-switch.js"></script>
<link href="lib/bootstrap/css/bootstrap-switch.css" rel="stylesheet"/>
                    
<div class="ui-state-default ui-corner-all" style="height: 45px;" >
<p><span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-search"></span>                 
<form name="form" class="form-inline" method="get" action="" >
 
   <input type="text" id="host"  name="host" value="" placeholder="<?php echo $this->lang->line('please_input_host'); ?>" class="input-medium" >
  <input type="text" id="tags"  name="tags" value="" placeholder="<?php echo $this->lang->line('please_input_tags'); ?>" class="input-medium" >
  
  
  <select name="order" class="input-small" style="width: 130px;">
  <option value=""><?php echo $this->lang->line('sort'); ?></option>
  <option value="id" <?php if($setval['order']=='id') echo "selected"; ?> ><?php echo $this->lang->line('default'); ?></option>
  <option value="host" <?php if($setval['order']=='host') echo "selected"; ?> ><?php echo $this->lang->line('host'); ?></option>
  <option value="uptime_in_seconds" <?php if($setval['order']=='uptime_in_seconds') echo "selected"; ?> ><?php echo $this->lang->line('uptime'); ?></option>
  <option value="connected_clients" <?php if($setval['order']=='connected_clients') echo "selected"; ?> ><?php echo $this->lang->line('connections'); ?></option>

  </select>
  <select name="order_type" class="input-small" style="width: 70px;">
  <option value="asc" <?php if($setval['order_type']=='asc') echo "selected"; ?> ><?php echo $this->lang->line('asc'); ?></option>
  <option value="desc" <?php if($setval['order_type']=='desc') echo "selected"; ?> ><?php echo $this->lang->line('desc'); ?></option>
  </select>

  <button type="submit" class="btn btn-success"><i class="icon-search"></i> <?php echo $this->lang->line('search'); ?></button>
  <a href="<?php echo site_url('lp_redis/health') ?>" class="btn btn-warning"><i class="icon-repeat"></i> <?php echo $this->lang->line('reset'); ?></a>
  <button id="refresh" class="btn btn-info"><i class="icon-refresh"></i> <?php echo $this->lang->line('refresh'); ?></button>
</form>                
</div>


<div class="well">
    <table class="table table-hover table-condensed ">
      <thead>
        <tr style="font-size: 12px;">
		<th colspan="2"><center><?php echo $this->lang->line('servers'); ?></center></th>
        <th colspan="6"><center><?php echo $this->lang->line('used_memory'); ?></center></th>
        <th colspan="2"><center><?php echo $this->lang->line('other'); ?></center></th>
        <th ></th>
	   </tr>
        <tr style="font-size: 12px;">
        <th><?php echo $this->lang->line('host'); ?></th> 
        <th><?php echo $this->lang->line('tags'); ?></th> 
    <th><?php echo $this->lang->line('total'); ?></th>
    <th><?php echo $this->lang->line('total'); ?>(<?php echo $this->lang->line('human'); ?>)</th>
		<th><?php echo $this->lang->line('rss'); ?></th>
        <th><?php echo $this->lang->line('peak'); ?></th>
        <th><?php echo $this->lang->line('peak'); ?>(<?php echo $this->lang->line('human'); ?>)</th>
        <th><?php echo $this->lang->line('lua'); ?></th>
        <th><?php echo $this->lang->line('mem_fragmentation_ratio'); ?></th>
        <th><?php echo $this->lang->line('mem_allocator'); ?></th>
        <th><?php echo $this->lang->line('chart'); ?></th>
	    </tr>
      </thead>
      <tbody>
 <?php if(!empty($datalist)) {?>
 <?php foreach ($datalist  as $item):?>
    <tr style="font-size: 12px;">
        <td><?php echo $item['host'] ?>:<?php echo $item['port'] ?></td>
		<td><?php echo $item['tags'] ?></td>
        <td><?php echo check_value($item['used_memory']) ?></td>
        <td><?php echo check_value($item['used_memory_human']) ?></td>
        <td><?php echo check_value($item['used_memory_rss']) ?></td>
        <td><?php echo check_value($item['used_memory_peak']) ?></td>
        <td><?php echo check_value($item['used_memory_peak_human']) ?></td>
        <td><?php echo check_value($item['used_memory_lua']) ?></td>
        <td><?php echo check_value($item['mem_fragmentation_ratio']) ?>%</td>
        <td><?php echo check_value($item['mem_allocator']) ?></td>
     
        <td><a href="<?php echo site_url('lp_redis/chart/'.$item['server_id']) ?>"><img src="./images/chart.gif"/></a></a></td>
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

