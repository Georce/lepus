<div class="header">
            
            <h1 class="page-title"><?php echo $this->lang->line('_CPU'); ?></h1>
</div>
        
<ul class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><?php echo $this->lang->line('home'); ?></a> <span class="divider">/</span></li>
            <li class="active"><?php echo $this->lang->line('_OS Monitor'); ?></li><span class="divider">/</span></li>
            <li class="active"><?php echo $this->lang->line('_CPU'); ?></li>
            <span class="right"><?php echo $this->lang->line('the_latest_acquisition_time'); ?>:<?php if(!empty($datalist)){ echo $datalist[0]['create_time'];} else {echo $this->lang->line('the_monitoring_process_is_not_started');} ?></span>
</ul>

<div class="container-fluid">
<div class="row-fluid">

<div class="ui-state-default ui-corner-all" style="height: 45px;" >
<p><span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-search"></span>                 
<form name="form" class="form-inline" method="get" action="<?php site_url('lp_os/cpu') ?>" >
 <select name="application_id" class="input-small" style="width: 120px;">
  <option value=""><?php echo $this->lang->line('application'); ?></option>
  <?php foreach ($application  as $item):?>
  <option value="<?php echo $item['id'];?>" <?php if($setval['application_id']==$item['id']) echo "selected"; ?> ><?php echo $item['display_name'] ?></option>
   <?php endforeach;?>
 </select>
  <input placeholder="<?php echo $this->lang->line('ip_address'); ?>" class="" style="width:150px;" type="text" name="host" id="host" value="<?php echo $setval['host']; ?>"  />
  <button type="submit" class="btn btn-success"><i class="icon-search"></i> <?php echo $this->lang->line('search'); ?></button>
  <a href="<?php echo site_url('lp_os/cpu') ?>" class="btn btn-warning"><i class="icon-repeat"></i> <?php echo $this->lang->line('reset'); ?></a>
</form>                
</div> 

<div class="well">
    <table class="table table-hover table-condensed ">
      <thead>
        <tr style="font-size: 12px;">
        <th>ip</th> 
        <th>process</th> 
		<th>load_1</th>
        <th>load_5</th>
        <th>load_15</th>
        <th>cpu_user_time</th>
        <th>cpu_system_time</th>
        <th>cpu_idle_time</th>
        <th><?php echo $this->lang->line('chart'); ?></th>
	    </tr>
      </thead>
      <tbody>
 <?php if(!empty($datalist)) {?>
 <?php foreach ($datalist  as $item):?>
    <tr style="font-size: 12px;">
        <td><?php echo $item['ip'] ?></td>
		<td><?php echo $item['process'] ?></td>
        <td><?php echo $item['load_1'] ?></td>
        <td><?php echo $item['load_5'] ?></td>
        <td><?php echo $item['load_15'] ?></td>
        <td><?php echo $item['cpu_user_time'] ?>%</td>
        <td><?php echo $item['cpu_system_time'] ?>%</td>
        <td><?php echo $item['cpu_idle_time'] ?>%</td>
        <td><a href="<?php echo site_url('lp_os/cpu_chart/'.$item['ip']) ?>"><img src="./images/chart.gif"/></a></a></td>
	</tr>
 <?php endforeach;?>
 <?php }else{  ?>
<tr>
<td colspan="9">
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

