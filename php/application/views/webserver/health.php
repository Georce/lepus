
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="header">  
            <h1 class="page-title"><?php echo $this->lang->line('_WebServer Health'); ?> </h1>
</div>
     
<ul class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><?php echo $this->lang->line('home'); ?></a> <span class="divider">/</span></li>
            <li class="active"><?php echo $this->lang->line('_WebServer Monitor'); ?></li><span class="divider">/</span></li>
            <li class="active"><?php echo $this->lang->line('_WebServer Health'); ?></li>
</ul>

<div class="container-fluid">
<div class="row-fluid">
 
<script language="javascript" src="./lib/DatePicker/WdatePicker.js"></script>
                    
<div class="ui-state-default ui-corner-all" style="height: 45px;" >
<p><span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-search"></span>                 
<form name="form" class="form-inline" method="get" action="" >
  
  <input placeholder="<?php echo $this->lang->line('web_url'); ?>" class="" style="width:180px;" type="text" name="web_url" id="web_url" value="<?php echo $setval['web_url']; ?>"  />
  <input class="Wdate" style="width:130px;" type="text" name="stime" id="start_time>" value="<?php echo $setval['stime'] ?>" onFocus="WdatePicker({doubleCalendar:false,isShowClear:false,readOnly:false,dateFmt:'yyyy-MM-dd HH:mm'})"/>
  <input class="Wdate" style="width:130px;" type="text" name="etime" id="end_time>" value="<?php echo $setval['etime'] ?>" onFocus="WdatePicker({doubleCalendar:false,isShowClear:false,readOnly:false,startDate:'1980-05-01',dateFmt:'yyyy-MM-dd HH:mm'})"/>

  <button type="submit" class="btn btn-success"><i class="icon-search"></i> <?php echo $this->lang->line('search'); ?></button>
  <a href="<?php echo site_url('lp_mysql/process') ?>" class="btn btn-warning"><i class="icon-repeat"></i> <?php echo $this->lang->line('reset'); ?></a>
  <button id="refresh" class="btn btn-info"><i class="icon-refresh"></i> <?php echo $this->lang->line('refresh'); ?></button>
  
</form>                
</div>


<div class="well">
    <table class="table table-hover table-condensed" style="font-size: 12px;">
      <thead>
        <th><?php echo $this->lang->line('web_url'); ?></th>
        <th><?php echo $this->lang->line('status_code'); ?></th>
        <th><?php echo $this->lang->line('version'); ?></th>
        <th><?php echo $this->lang->line('message'); ?></th>
        <th><?php echo $this->lang->line('monitor_time'); ?></th>
        <th><?php echo $this->lang->line('send_mail'); ?></th>
        <th><?php echo $this->lang->line('send_success'); ?></th>
      </thead>
      <tbody>
<?php if(!empty($datalist)) {?>
 <?php foreach ($datalist  as $item):?>
    <tr class="warning">
		<td><?php echo $item['web_url'] ?></td>
        <td><?php echo $item['status_code'] ?></td>
        <td><?php echo $item['version'] ?></td>
        <td><?php if($item['message']=='OK'){ ?> <span class="label label-success">OK</span> <?php }else{  ?><span class="label label-important"><?php echo $item['message'] ?></span> <?php } ?></td>
        <td><?php echo $item['create_time'] ?></td>
        <td><?php if($item['message']!='OK'){ echo check_status($item['send_mail']); }else{ echo "------"; } ?></td>
        <td><?php if($item['message']!='OK'){ echo check_status($item['send_mail_status']) ; }else{ echo "------"; } ?></td>
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