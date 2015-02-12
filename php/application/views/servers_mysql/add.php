<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="header">  
            <h1 class="page-title"><?php echo $this->lang->line('_MySQL'); ?> <?php echo $this->lang->line('add'); ?></h1>
</div>
     
<ul class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><?php echo $this->lang->line('home'); ?></a> <span class="divider">/</span></li>
            <li class="active"><?php echo $this->lang->line('_Servers Configure'); ?></li><span class="divider">/</span></li>
            <li class="active"><?php echo $this->lang->line('_MySQL'); ?></li>
</ul>

<div class="container-fluid">
<div class="row-fluid">

<form name="form" class="form-horizontal" method="post" action="<?php echo site_url('servers_mysql/add') ?>" >
<input type="hidden" name="submit" value="add"/> 
<div class="btn-toolbar">
    <button type="submit" class="btn btn-primary"><i class="icon-save"></i> <?php echo $this->lang->line('save'); ?></button>
    <a class="btn btn " href="<?php echo site_url('servers_mysql/index') ?>"><i class="icon-list"></i> <?php echo $this->lang->line('list'); ?></a>
  <div class="btn-group"></div>
</div>

<?php if ($error_code!==0) { ?>
<div class="alert alert-error">
<button type="button" class="close" data-dismiss="alert">×</button>
<?php echo validation_errors(); ?>
</div>
<?php } ?>

<div class="well">

  
   <div class="control-group">
    <label class="control-label" for="">*<?php echo $this->lang->line('host'); ?></label>
    <div class="controls">
      <input type="text" id=""  name="host" value="<?php echo set_value('host'); ?>" >
      <span class="help-inline"></span>
    </div>
   </div>
   
   <div class="control-group">
    <label class="control-label" for="">*<?php echo $this->lang->line('port'); ?></label>
    <div class="controls">
      <input type="text" id=""  name="port" value="<?php echo set_value('port','3306'); ?>" >
      <span class="help-inline"></span>
    </div>
   </div>
   
   <div class="control-group">
    <label class="control-label" for="">*<?php echo $this->lang->line('username'); ?></label>
    <div class="controls">
      <input type="text" id=""  name="username" value="<?php echo set_value('username'); ?>" >
      <span class="help-inline"></span>
    </div>
   </div>
   
   <div class="control-group">
    <label class="control-label" for="">*<?php echo $this->lang->line('password'); ?></label>
    <div class="controls">
      <input type="password" id=""  name="password" value="<?php echo set_value('password'); ?>" >
      <span class="help-inline"></span>
    </div>
   </div>
   
   <div class="control-group">
    <label class="control-label" for="">*<?php echo $this->lang->line('tags'); ?></label>
    <div class="controls">
      <input type="text" id=""  name="tags" value="<?php echo set_value('tags'); ?>" >
      <span class="help-inline"></span>
    </div>
   </div>
   
   <hr />
    <div class="control-group">
    <label class="control-label" for=""><?php echo $this->lang->line('monitor'); ?></label>
    <div class="controls">
        <select name="monitor" id="monitor" class="input-small">
         <option value="1"  ><?php echo $this->lang->line('on'); ?></option>
         <option value="0"  ><?php echo $this->lang->line('off'); ?></option>
        </select>
    </div>
   </div>
   
    <div class="control-group">
    <label class="control-label" for=""><?php echo $this->lang->line('send_mail'); ?></label>
    <div class="controls">
        <select name="send_mail" id="send_mail" class="input-small">
         <option value="1"  ><?php echo $this->lang->line('on'); ?></option>
         <option value="0"  ><?php echo $this->lang->line('off'); ?></option>
        </select>
         &nbsp;&nbsp;<?php echo $this->lang->line('alarm_mail_to_list'); ?>
        <div class="input-prepend">
            <span class="add-on">@</span>
            <input type="text" id="send_mail_to_list"  class="input-xlarge" placeholder="<?php echo $this->lang->line('many_people_separation'); ?>" name="send_mail_to_list" value="" >
        </div>
    </div>
    </div>
    
    <div class="control-group">
    <label class="control-label" for=""><?php echo $this->lang->line('send_sms'); ?></label>
    <div class="controls">
        <select name="send_sms" id="send_sms" class="input-small">
         <option value="0"  ><?php echo $this->lang->line('off'); ?></option>
         <option value="1"  ><?php echo $this->lang->line('on'); ?></option>
        </select>
         &nbsp;&nbsp;<?php echo $this->lang->line('alarm_sms_to_list'); ?>
        <div class="input-prepend">
            <span class="add-on">@</span>
            <input type="text" id="send_sms_to_list"  class="input-xlarge" placeholder="<?php echo $this->lang->line('many_people_separation'); ?>" name="send_sms_to_list" value="" >
        </div>
    </div>
    </div>
    
    <div class="control-group">
    <label class="control-label" for=""><?php echo $this->lang->line('slowquery'); ?></label>
    <div class="controls" >
        <select name="slow_query" id="slow_query" class="input-small">
         <option value="1"  ><?php echo $this->lang->line('on'); ?></option>
         <option value="0" selected="selected" ><?php echo $this->lang->line('off'); ?></option>
        </select>
        &nbsp;&nbsp;<?php echo $this->lang->line('slowquery_send_mail_to'); ?>
        <div class="input-prepend">
            <span class="add-on">@</span>
            <input type="text" id="send_slowquery_to_list"  class="input-xlarge" placeholder="<?php echo $this->lang->line('many_people_separation'); ?>" name="send_slowquery_to_list" value="" >
        </div>

    </div>
    </div>
     <div class="control-group">
    <label class="control-label" for=""><?php echo $this->lang->line('_BigTable Analysis'); ?></label>
    <div class="controls">
        <select name="bigtable_monitor" id="bigtable_monitor" class="input-small">
         <option value="0"  ><?php echo $this->lang->line('off'); ?></option>
         <option value="1"  ><?php echo $this->lang->line('on'); ?></option>
        </select>
    </div>
    </div>
    
    <div class="control-group">
    <label class="control-label" for=""><?php echo $this->lang->line('binlog_auto_purge'); ?></label>
    <div class="controls">
        <select name="binlog_auto_purge" id="binlog_auto_purge" class="input-small">
         <option value="0"  ><?php echo $this->lang->line('off'); ?></option>
         <option value="1"  ><?php echo $this->lang->line('on'); ?></option>
         
        </select>
        &nbsp;&nbsp;<?php echo $this->lang->line('binlog_store_days'); ?>&nbsp;<input type="text" id="binlog_store_days" class="input-small"  name="binlog_store_days" value="30" >
    </div>
   </div>
    
    <div class="control-group">
    <label class="control-label" for=""><?php echo $this->lang->line('threads_connected'); ?>  <?php echo $this->lang->line('alarm'); ?></label>
    <div class="controls">
        <select name="alarm_threads_connected" id="alarm_threads_connected" class="input-small">
         <option value="1"  ><?php echo $this->lang->line('on'); ?></option>
         <option value="0"  ><?php echo $this->lang->line('off'); ?></option>
        </select>
        &nbsp;&nbsp;<?php echo $this->lang->line('threshold_warning'); ?>&nbsp;<input type="text" id="threshold_warning_threads_connected" class="input-small" placeholder="" name="threshold_warning_threads_connected" value="1000" >
        &nbsp;&nbsp;<?php echo $this->lang->line('threshold_critical'); ?>&nbsp;<input type="text" id="threshold_critical_threads_connected" class="input-small" placeholder="" name="threshold_critical_threads_connected" value="3000" >
    </div>
   </div>
    
   <div class="control-group">
    <label class="control-label" for=""><?php echo $this->lang->line('threads_running'); ?> <?php echo $this->lang->line('alarm'); ?></label>
    <div class="controls">
        <select name="alarm_threads_running" id="alarm_threads_running" class="input-small">
         <option value="1"  ><?php echo $this->lang->line('on'); ?></option>
         <option value="0"  ><?php echo $this->lang->line('off'); ?></option>
        </select>
        &nbsp;&nbsp;<?php echo $this->lang->line('threshold_warning'); ?>&nbsp;<input type="text" id="threshold_warning_threads_running" class="input-small" placeholder="" name="threshold_warning_threads_running" value="10" >
        &nbsp;&nbsp;<?php echo $this->lang->line('threshold_critical'); ?>&nbsp;<input type="text" id="threshold_critical_threads_running" class="input-small" placeholder="" name="threshold_critical_threads_running" value="30" >
    </div>
   </div>
   
   <div class="control-group">
    <label class="control-label" for=""><?php echo $this->lang->line('threads_waits'); ?> <?php echo $this->lang->line('alarm'); ?></label>
    <div class="controls">
        <select name="alarm_threads_waits" id="alarm_threads_waits" class="input-small">
         <option value="1"  ><?php echo $this->lang->line('on'); ?></option>
         <option value="0"  ><?php echo $this->lang->line('off'); ?></option>
        </select>
        &nbsp;&nbsp;<?php echo $this->lang->line('threshold_warning'); ?>&nbsp;<input type="text" id="threshold_warning_threads_waits" class="input-small" placeholder="" name="threshold_warning_threads_waits" value="5" >
        &nbsp;&nbsp;<?php echo $this->lang->line('threshold_critical'); ?>&nbsp;<input type="text" id="threshold_critical_threads_waits" class="input-small" placeholder="" name="threshold_critical_threads_waits" value="15" >
    </div>
   </div>
   
    <div class="control-group">
    <label class="control-label" for=""><?php echo $this->lang->line('replication'); ?> <?php echo $this->lang->line('alarm'); ?></label>
    <div class="controls">
        <select name="alarm_repl_status" id="alarm_repl_status" class="input-small">
         <option value="1"  ><?php echo $this->lang->line('on'); ?></option>
         <option value="0"  ><?php echo $this->lang->line('off'); ?></option>
        </select>
    </div>
   </div>
    <div class="control-group">
    <label class="control-label" for=""><?php echo $this->lang->line('delay'); ?> <?php echo $this->lang->line('alarm'); ?></label>
    <div class="controls">
        <select name="alarm_repl_delay" id="alarm_repl_delay" class="input-small">
         <option value="1"  ><?php echo $this->lang->line('on'); ?></option>
         <option value="0"  ><?php echo $this->lang->line('off'); ?></option>
        </select>
        &nbsp;&nbsp;<?php echo $this->lang->line('threshold_warning'); ?>&nbsp;<input type="text" id="threshold_warning_repl_delay" class="input-small" placeholder="" name="threshold_warning_repl_delay" value="60" >
        &nbsp;&nbsp;<?php echo $this->lang->line('threshold_critical'); ?>&nbsp;<input type="text" id="threshold_critical_repl_delay" class="input-small" placeholder="" name="threshold_critical_repl_delay" value="600" >
    </div>
    </div>
   
   
</div>


</form>

