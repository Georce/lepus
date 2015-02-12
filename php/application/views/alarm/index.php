<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="header">  
            <h1 class="page-title"><?php echo $this->lang->line('_Alarm List'); ?> </h1>
</div>
     
<ul class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><?php echo $this->lang->line('home'); ?></a> <span class="divider">/</span></li>
            <li class="active"><?php echo $this->lang->line('_Alarm Panel'); ?></li><span class="divider">/</span></li>
            <li class="active"><?php echo $this->lang->line('_Alarm List'); ?></li>
</ul>

<div class="container-fluid">
<div class="row-fluid">
 
<script language="javascript" src="./lib/DatePicker/WdatePicker.js"></script>
                    
<div class="ui-state-default ui-corner-all" style="height: 45px;" >
<p><span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-search"></span>                 
<form name="form" class="form-inline" method="get" action="" >
  
  <select name="level" class="input-small" style="width: 100px;" >
  <option value=""><?php echo $this->lang->line('level'); ?></option>
  <option value="warning" <?php if($setval['level']=='warning') echo "selected"; ?> ><?php echo $this->lang->line('warning'); ?></option>
  <option value="critical" <?php if($setval['level']=='critical') echo "selected"; ?> ><?php echo $this->lang->line('critical'); ?></option>
  <option value="ok" <?php if($setval['level']=='ok') echo "selected"; ?> ><?php echo $this->lang->line('ok'); ?></option>
  </select>
   <input class="Wdate" style="width:130px;" type="text" name="stime" id="start_time>" value="<?php echo $setval['stime'] ?>" onFocus="WdatePicker({doubleCalendar:false,isShowClear:false,readOnly:false,dateFmt:'yyyy-MM-dd HH:mm'})"/>
  <input class="Wdate" style="width:130px;" type="text" name="etime" id="end_time>" value="<?php echo $setval['etime'] ?>" onFocus="WdatePicker({doubleCalendar:false,isShowClear:false,readOnly:false,startDate:'1980-05-01',dateFmt:'yyyy-MM-dd HH:mm'})"/>

  <button type="submit" class="btn btn-success"><i class="icon-search"></i> <?php echo $this->lang->line('search'); ?></button>
  <a href="<?php echo site_url('') ?>" class="btn btn-warning"><i class="icon-repeat"></i> <?php echo $this->lang->line('reset'); ?></a>
  <button id="refresh" class="btn btn-info"><i class="icon-refresh"></i> <?php echo $this->lang->line('refresh'); ?></button>
  
</form>                
</div>


<div class="well">
    <table class="table table-hover table-condensed" style="font-size: 12px;">
      <thead>
        <th><?php echo $this->lang->line('host'); ?></th>
        <th><?php echo $this->lang->line('tags'); ?></th>
        <th><?php echo $this->lang->line('type'); ?></th>
        <th><?php echo $this->lang->line('item'); ?></th>
        <th><?php echo $this->lang->line('level'); ?></th>
        <th><?php echo $this->lang->line('message'); ?></th>
        <th><?php echo $this->lang->line('value'); ?></th>
        <th><?php echo $this->lang->line('monitor_time'); ?></th>
        <th><?php echo $this->lang->line('mail'); ?></th>
        <th><?php echo $this->lang->line('sms'); ?></th>
      </thead>
      <tbody>
<?php if(!empty($datalist)) {?>
 <?php foreach ($datalist  as $item):?>
    <tr class="warning">
		<td><?php echo $item['host'].":".$item['port'] ?></td>
        <td><?php echo $item['tags'] ?></td>
        <td><?php echo $item['db_type'] ?></td>
        <td><?php echo $item['alarm_item'] ?></td>
        <td><?php if($item['level']=='critical'){ ?> <span class="label label-important"><?php echo $this->lang->line('critical'); ?></span> <?php }else if($item['level']=='warning'){  ?><span class="label label-warning"><?php echo $this->lang->line('warning'); ?></span> <?php }else{?> <span class="label label-success"><?php echo $this->lang->line('ok'); ?></span>  <?php } ?></td>
        <td><?php echo $item['message'] ?></td>
        <td><span class="label label-info"><?php echo $item['alarm_value']  ?></span></td>
        <td><?php echo $item['create_time'] ?></td>
        <td><?php echo check_mail($item['send_mail']) ?></td>
        <td><?php echo check_mail($item['send_sms']) ?></td>
 
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

<div class="" style="margin-top: 8px;padding: 8px;">
<center><?php echo $this->pagination->create_links(); ?></center>
</div>

 <script type="text/javascript">
    $('#refresh').click(function(){
        document.location.reload(); 
    })
 </script>