<div class="header">
            
            <h1 class="page-title"><?php echo $this->lang->line('_BaseInfo'); ?></h1>
</div>
        
<ul class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><?php echo $this->lang->line('home'); ?></a> <span class="divider">/</span></li>
            <li class="active"><?php echo $this->lang->line('_OS Monitor'); ?></li><span class="divider">/</span></li>
            <li class="active"><?php echo $this->lang->line('_BaseInfo'); ?></li>
            <span class="right"><?php echo $this->lang->line('the_latest_acquisition_time'); ?>:<?php if(!empty($datalist)){ echo $datalist[0]['create_time'];} else {echo $this->lang->line('the_monitoring_process_is_not_started');} ?></span>
</ul>

<div class="container-fluid">
<div class="row-fluid">
 
<div class="ui-state-default ui-corner-all" style="height: 45px;" >
<p><span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-search"></span>                 
<form name="form" class="form-inline" method="get" action="<?php site_url('lp_os/baseinfo') ?>" >
 <select name="application_id" class="input-small" style="width: 120px;">
  <option value=""><?php echo $this->lang->line('application'); ?></option>
  <?php foreach ($application  as $item):?>
  <option value="<?php echo $item['id'];?>" <?php if($setval['application_id']==$item['id']) echo "selected"; ?> ><?php echo $item['display_name'] ?></option>
   <?php endforeach;?>
 </select>
  <select name="snmp" class="input-small" style="width: 120px;">
  <option value="1" <?php if($setval['snmp']=='1') echo "selected"; ?> >SNMP Up</option>
  <option value="0" <?php if($setval['snmp']=='0') echo "selected"; ?> >SNMP Down</option>
  </select>
  <input placeholder="<?php echo $this->lang->line('ip_address'); ?>" class="" style="width:150px;" type="text" name="host" id="host" value="<?php echo $setval['host']; ?>"  />
  <button type="submit" class="btn btn-success"><i class="icon-search"></i> <?php echo $this->lang->line('search'); ?></button>
  <a href="<?php echo site_url('lp_os/baseinfo') ?>" class="btn btn-warning"><i class="icon-repeat"></i> <?php echo $this->lang->line('reset'); ?></a>
</form>                
</div>

<div class="well">
    <table class="table table-hover table-condensed ">
      <thead>
        <tr style="font-size: 12px;">
        <th>ip</th>
        <th>application</th>
        <th>snmp</th> 
        <th>hostname</th> 
		<th>kernel</th>
        <th>system_date</th>
		<th>system_uptime</th>
		<th>create_time</th>
	    </tr>
      </thead>
      <tbody>
 <?php if(!empty($datalist)) {?>
 <?php foreach ($datalist  as $item):?>
    <tr style="font-size: 12px;">
        <td><?php echo $item['ip'] ?></td>
        <td><?php echo $item['application'] ?></td>
        <td><?php if($item['snmp']=='1'){ ?> <span class="label label-success">Up</span> <?php }else{  ?><span class="label label-important">Down</span> <?php } ?></td>
		<td><?php echo $item['hostname'] ?></td>
        <td><?php echo $item['kernel'] ?></td>
        <td><?php echo $item['system_date'] ?></td>
        <td><?php echo $item['system_uptime'] ?></td>
        <td><?php echo $item['create_time'] ?></td>
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

