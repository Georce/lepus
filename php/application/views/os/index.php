<div class="header">
            
            <h1 class="page-title"><?php echo $this->lang->line('host'); ?> <?php echo $this->lang->line('_Health Monitor'); ?></h1>
</div>
        
<ul class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><?php echo $this->lang->line('home'); ?></a> <span class="divider">/</span></li>
            <li class="active"><?php echo $this->lang->line('_OS Monitor'); ?></li><span class="divider">/</span></li>
            <li class="active"><?php echo $this->lang->line('_Health Monitor'); ?></li>
            <span class="right"><?php echo $this->lang->line('the_latest_acquisition_time'); ?>:<?php if(!empty($datalist)){ echo $datalist[0]['create_time'];} else {echo $this->lang->line('the_monitoring_process_is_not_started');} ?></span>
</ul>

<div class="container-fluid">
<div class="row-fluid">
 
<div class="ui-state-default ui-corner-all" style="height: 45px;" >
<p><span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-search"></span>                 
<form name="form" class="form-inline" method="get" action="<?php site_url('lp_os/baseinfo') ?>" >
 
 <input type="text" id="host"  name="host" value="<?php echo $setval['host']; ?>" placeholder="<?php echo $this->lang->line('please_input_host'); ?>" class="input-medium" >
 <input type="text" id="tags"  name="tags" value="<?php echo $setval['tags']; ?>" placeholder="<?php echo $this->lang->line('please_input_tags'); ?>" class="input-medium" >
  
  
  <button type="submit" class="btn btn-success"><i class="icon-search"></i> <?php echo $this->lang->line('search'); ?></button>
  <a href="<?php echo site_url('lp_os/index') ?>" class="btn btn-warning"><i class="icon-repeat"></i> <?php echo $this->lang->line('reset'); ?></a>
  <button id="refresh" class="btn btn-info"><i class="icon-refresh"></i> <?php echo $this->lang->line('refresh'); ?></button>
</form>                
</div>

<div class="well">
    <table class="table table-hover table-condensed ">
      <thead>
    <tr style="font-size: 12px;">
    <th colspan="3"><center><?php echo $this->lang->line('servers'); ?></center></th>
    <th colspan="3"><center><?php echo $this->lang->line('load'); ?></center></th>
    <th colspan="3"><center><?php echo $this->lang->line('cpu'); ?></center></th>
    <th colspan="2"><center><?php echo $this->lang->line('memory'); ?></center></th>
    <th colspan="2"><center><?php echo $this->lang->line('swap'); ?></center></th>
	<th colspan="2"><center><?php echo $this->lang->line('disk'); ?><?php echo $this->lang->line('io'); ?></center></th>
	<th colspan="2"><center><?php echo $this->lang->line('network'); ?></center></th>
        <th ></th>
     </tr>
        <tr style="font-size: 12px;">
        <th><?php echo $this->lang->line('host'); ?></th>
        <th>SNMP</th> 
        <th><?php echo $this->lang->line('process'); ?></th>
        <th><?php echo $this->lang->line('load'); ?>(1)</th>
        <th><?php echo $this->lang->line('load'); ?>(5)</th>
        <th><?php echo $this->lang->line('load'); ?>(15)</th>
        <th><?php echo $this->lang->line('user'); ?></th>
        <th><?php echo $this->lang->line('system'); ?></th>
        <th><?php echo $this->lang->line('idle'); ?></th>
        <th><?php echo $this->lang->line('total'); ?></th>
        <th><?php echo $this->lang->line('avail'); ?></th>
        <th><?php echo $this->lang->line('total'); ?></th>
        <th><?php echo $this->lang->line('avail'); ?></th>
		<th><?php echo $this->lang->line('read'); ?></th>
        <th><?php echo $this->lang->line('write'); ?></th>
		<th><?php echo $this->lang->line('in'); ?></th>
        <th><?php echo $this->lang->line('out'); ?></th>
        <th><?php echo $this->lang->line('chart'); ?></th>
	    </tr>
      </thead>
      <tbody>
 <?php if(!empty($datalist)) {?>
 <?php foreach ($datalist  as $item):?>
    <tr style="font-size: 12px;">
        <td><?php echo $item['ip'] ?></td>
        <td><?php if($item['snmp']=='1'){ ?> <span class="label label-success"><?php echo $this->lang->line('success'); ?></span> <?php }else{  ?><span class="label label-important"><?php echo $this->lang->line('failure'); ?></span> <?php } ?></td>
        <td><?php echo check_value($item['process']) ?></td>
        <td><?php echo check_value($item['load_1']) ?></td>
        <td><?php echo check_value($item['load_5']) ?></td>
        <td><?php echo check_value($item['load_15']) ?></td>
        <td><?php echo check_cpu($item['cpu_user_time']) ?></td>
        <td><?php echo check_cpu($item['cpu_system_time']) ?></td>
        <td><?php echo check_cpu($item['cpu_idle_time']) ?></td>
        <td><?php echo check_memory($item['mem_total']) ?></td>
        <td><?php echo check_memory($item['mem_free']) ?></td>
        <td><?php echo check_memory($item['swap_total']) ?></td>
        <td><?php echo check_memory($item['swap_avail']) ?></td>
		<td><?php echo $item['disk_io_reads_total'] ?></td>
        <td><?php echo $item['disk_io_writes_total'] ?></td>
		<td><?php echo format_bytes($item['net_in_bytes_total']) ?></td>
        <td><?php echo format_bytes($item['net_out_bytes_total']) ?></td>
        <td><?php if($item['snmp']=='1'){ ?><a href="<?php echo site_url('lp_os/chart/'.$item['ip']) ?>"><img src="./images/chart.gif"/></a> <?php }else{  ?>--- <?php } ?></td>
	</tr>
 <?php endforeach;?>
 <?php }else{  ?>
<tr>
<td colspan="8">
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

