<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="header">  
            <h1 class="page-title"><?php echo $this->lang->line('_Oracle'); ?> <?php echo $this->lang->line('edit'); ?></h1>
</div>
     
<ul class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><?php echo $this->lang->line('home'); ?></a> <span class="divider">/</span></li>
            <li class="active"><?php echo $this->lang->line('_Servers Configure'); ?></li><span class="divider">/</span></li>
            <li class="active"><?php echo $this->lang->line('_Oracle'); ?></li>
</ul>

<div class="container-fluid">
<div class="row-fluid">

<form name="form" class="form-horizontal" method="post" action="<?php echo site_url('servers_oracle/edit') ?>" >
<input type="hidden" name="submit" value="edit"/> 
<input type='hidden'  name='id' value=<?php echo $record['id'] ?> />
<div class="btn-toolbar">
    <button type="submit" class="btn btn-primary"><i class="icon-save"></i> <?php echo $this->lang->line('save'); ?></button>
    <a class="btn btn " href="<?php echo site_url('servers_oracle/index') ?>"><i class="icon-list"></i> <?php echo $this->lang->line('list'); ?></a>
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
      <input type="text" id=""  name="host" value="<?php echo $record['host']; ?>" >
      <span class="help-inline"></span>
    </div>
   </div>
   
   <div class="control-group">
    <label class="control-label" for="">*<?php echo $this->lang->line('port'); ?></label>
    <div class="controls">
      <input type="text" id=""  name="port" value="<?php echo $record['port']; ?>" >
      <span class="help-inline"></span>
    </div>
   </div>
   
   <div class="control-group">
    <label class="control-label" for="">*<?php echo $this->lang->line('dsn'); ?></label>
    <div class="controls">
      <input type="text" id=""  name="dsn" value="<?php echo $record['dsn']; ?>" >
      <span class="help-inline"></span>
    </div>
   </div>
   
   <div class="control-group">
    <label class="control-label" for="">*<?php echo $this->lang->line('username'); ?></label>
    <div class="controls">
      <input type="text" id=""  name="username" value="<?php echo $record['username']; ?>" >
      <span class="help-inline"></span>
    </div>
   </div>
   
   <div class="control-group">
    <label class="control-label" for="">*<?php echo $this->lang->line('password'); ?></label>
    <div class="controls">
      <input type="password" id=""  name="password" value="<?php echo $record['password']; ?>" >
      <span class="help-inline"></span>
    </div>
   </div>
   
   <div class="control-group">
    <label class="control-label" for="">*<?php echo $this->lang->line('tags'); ?></label>
    <div class="controls">
      <input type="text" id=""  name="tags" value="<?php echo $record['tags']; ?>" >
      <span class="help-inline"></span>
    </div>
   </div>
   
   <hr />
   
    <div class="control-group">
    <label class="control-label" for=""><?php echo $this->lang->line('monitor'); ?></label>
    <div class="controls">
        <select name="monitor" id="monitor" class="input-small">
         <option value="1"  <?php echo set_selected(1,$record['monitor']) ?>><?php echo $this->lang->line('on'); ?></option>
         <option value="0"  <?php echo set_selected(0,$record['monitor']) ?>><?php echo $this->lang->line('off'); ?></option>
        </select>
    </div>
   </div>
    <div class="control-group">
    <label class="control-label" for=""><?php echo $this->lang->line('send_mail'); ?></label>
    <div class="controls">
        <select name="send_mail" id="send_mail" class="input-small">
         <option value="1"  <?php echo set_selected(1,$record['send_mail']) ?>><?php echo $this->lang->line('on'); ?></option>
         <option value="0"  <?php echo set_selected(0,$record['send_mail']) ?>><?php echo $this->lang->line('off'); ?></option>
        </select>
         &nbsp;&nbsp;<?php echo $this->lang->line('alarm_mail_to_list'); ?>
        <div class="input-prepend">
            <span class="add-on">@</span>
            <input type="text" id="send_mail_to_list"  class="input-xlarge" placeholder="<?php echo $this->lang->line('many_people_separation'); ?>" name="send_mail_to_list" value="<?php echo $record['send_mail_to_list']; ?>" >
        </div>
    </div>
   </div>
   <div class="control-group">
    <label class="control-label" for=""><?php echo $this->lang->line('send_sms'); ?></label>
    <div class="controls">
        <select name="send_sms" id="send_sms" class="input-small">
         <option value="1"  <?php echo set_selected(1,$record['send_sms']) ?>><?php echo $this->lang->line('on'); ?></option>
         <option value="0"  <?php echo set_selected(0,$record['send_sms']) ?>><?php echo $this->lang->line('off'); ?></option>
        </select>
         &nbsp;&nbsp;<?php echo $this->lang->line('alarm_sms_to_list'); ?>
        <div class="input-prepend">
            <span class="add-on">@</span>
            <input type="text" id="send_sms_to_list"  class="input-xlarge" placeholder="<?php echo $this->lang->line('many_people_separation'); ?>" name="send_sms_to_list" value="<?php echo $record['send_sms_to_list']; ?>" >
        </div>
    </div>
   </div>
   
   
   <div class="control-group">
    <label class="control-label" for=""><?php echo $this->lang->line('session_total'); ?>  <?php echo $this->lang->line('alarm'); ?></label>
    <div class="controls">
        <select name="alarm_session_total" id="alarm_session_total" class="input-small">
         <option value="1" <?php echo set_selected(1,$record['alarm_session_total']) ?> ><?php echo $this->lang->line('on'); ?></option>
         <option value="0" <?php echo set_selected(0,$record['alarm_session_total']) ?> ><?php echo $this->lang->line('off'); ?></option>
        </select>
        &nbsp;&nbsp;<?php echo $this->lang->line('threshold_warning'); ?>&nbsp;<input type="text" id="threshold_warning_session_total" class="input-small" placeholder="" name="threshold_warning_session_total" value="<?php echo $record['threshold_warning_session_total']; ?>" >
        &nbsp;&nbsp;<?php echo $this->lang->line('threshold_critical'); ?>&nbsp;<input type="text" id="threshold_critical_session_total" class="input-small" placeholder="" name="threshold_critical_session_total" value="<?php echo $record['threshold_critical_session_total']; ?>" >
    </div>
   </div>
   
   <div class="control-group">
    <label class="control-label" for=""><?php echo $this->lang->line('session_actives'); ?>  <?php echo $this->lang->line('alarm'); ?></label>
    <div class="controls">
        <select name="alarm_session_actives" id="alarm_session_actives" class="input-small">
         <option value="1" <?php echo set_selected(1,$record['alarm_session_actives']) ?> ><?php echo $this->lang->line('on'); ?></option>
         <option value="0" <?php echo set_selected(0,$record['alarm_session_actives']) ?> ><?php echo $this->lang->line('off'); ?></option>
        </select>
        &nbsp;&nbsp;<?php echo $this->lang->line('threshold_warning'); ?>&nbsp;<input type="text" id="threshold_warning_session_actives" class="input-small" placeholder="" name="threshold_warning_session_actives" value="<?php echo $record['threshold_warning_session_actives']; ?>" >
        &nbsp;&nbsp;<?php echo $this->lang->line('threshold_critical'); ?>&nbsp;<input type="text" id="threshold_critical_session_actives" class="input-small" placeholder="" name="threshold_critical_session_actives" value="<?php echo $record['threshold_critical_session_actives']; ?>" >
    </div>
   </div>
   
   <div class="control-group">
    <label class="control-label" for=""><?php echo $this->lang->line('session_waits'); ?>  <?php echo $this->lang->line('alarm'); ?></label>
    <div class="controls">
        <select name="alarm_session_waits" id="alarm_session_waits" class="input-small">
         <option value="1" <?php echo set_selected(1,$record['alarm_session_waits']) ?> ><?php echo $this->lang->line('on'); ?></option>
         <option value="0" <?php echo set_selected(0,$record['alarm_session_waits']) ?> ><?php echo $this->lang->line('off'); ?></option>
        </select>
        &nbsp;&nbsp;<?php echo $this->lang->line('threshold_warning'); ?>&nbsp;<input type="text" id="threshold_warning_session_waits" class="input-small" placeholder="" name="threshold_warning_session_waits" value="<?php echo $record['threshold_warning_session_waits']; ?>" >
        &nbsp;&nbsp;<?php echo $this->lang->line('threshold_critical'); ?>&nbsp;<input type="text" id="threshold_critical_session_waits" class="input-small" placeholder="" name="threshold_critical_session_waits" value="<?php echo $record['threshold_critical_session_waits']; ?>" >
    </div>
   </div>
   
   <div class="control-group">
    <label class="control-label" for=""><?php echo $this->lang->line('tbs'); ?>  <?php echo $this->lang->line('alarm'); ?></label>
    <div class="controls">
        <select name="alarm_tablespace" id="alarm_tablespace" class="input-small">
         <option value="1" <?php echo set_selected(1,$record['alarm_tablespace']) ?> ><?php echo $this->lang->line('on'); ?></option>
         <option value="0" <?php echo set_selected(0,$record['alarm_tablespace']) ?>><?php echo $this->lang->line('off'); ?></option>
        </select>
        &nbsp;&nbsp;<?php echo $this->lang->line('threshold_warning'); ?>&nbsp;<input type="text" id="threshold_warning_tablespace" class="input-small" placeholder="" name="threshold_warning_tablespace" value="<?php echo $record['threshold_warning_tablespace']; ?>" >%
        &nbsp;&nbsp;<?php echo $this->lang->line('threshold_critical'); ?>&nbsp;<input type="text" id="threshold_critical_tablespace" class="input-small" placeholder="" name="threshold_critical_tablespace" value="<?php echo $record['threshold_critical_tablespace']; ?>" >%
    </div>
   </div>
  
   
</div>

</form>

