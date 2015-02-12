<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="header">  
            <h1 class="page-title"><?php echo $this->lang->line('_Settings'); ?></h1>
</div>
     
<ul class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><?php echo $this->lang->line('home'); ?></a> <span class="divider">/</span></li>
            <li class="active"><?php echo $this->lang->line('_Servers Configure'); ?></li><span class="divider">/</span></li>
            <li class="active"><?php echo $this->lang->line('_Settings'); ?></li>
</ul>

<div class="container-fluid">
<div class="row-fluid">


  
<?php if ($success_code!==0) { ?>
<div class="alert alert-success">
<?php echo $this->lang->line('settings_update_success'); ?>
</div>
<?php } ?>                


<form name="form" class="form-horizontal" method="post" action="<?php echo site_url('settings/save') ?>" >
<input type="hidden" name="submit" value="save"/> 
   
<div class="btn-toolbar">
    <button type="submit" class="btn btn-primary"><i class="icon-save"></i> <?php echo $this->lang->line('save'); ?></button>
  <div class="btn-group"></div>
</div>
<div style="height: 20px;"></div>
<h2><?php echo $this->lang->line('monitor'); ?></h2>
<hr>

<div class="control-group success">
    <label class="control-label" for="">*<?php echo $this->lang->line('monitor'); ?></label>
    <div class="controls">
        <select name="monitor" id="monitor" class="input-small">
         <option value="1" <?php echo set_selected(1,$settings['monitor']) ?> ><?php echo $this->lang->line('on'); ?></option>
         <option value="0" <?php echo set_selected(0,$settings['monitor']) ?> ><?php echo $this->lang->line('off'); ?></option>
        </select>
        <span class="help-inline"></span>
    </div>
   </div>
   <div class="control-group success">
    <label class="control-label" for="">*<?php echo $this->lang->line('monitor_mysql'); ?></label>
    <div class="controls">
        <select name="monitor_mysql" id="monitor_mysql" class="input-small">
         <option value="1" <?php echo set_selected(1,$settings['monitor_mysql']) ?> ><?php echo $this->lang->line('on'); ?></option>
         <option value="0" <?php echo set_selected(0,$settings['monitor_mysql']) ?> ><?php echo $this->lang->line('off'); ?></option>
        </select>
        <span class="help-inline"></span>
    </div>
   </div>
   
   <div class="control-group success">
    <label class="control-label" for="">*<?php echo $this->lang->line('monitor_oracle'); ?></label>
    <div class="controls">
        <select name="monitor_oracle" id="monitor_oracle" class="input-small">
         <option value="1" <?php echo set_selected(1,$settings['monitor_oracle']) ?> ><?php echo $this->lang->line('on'); ?></option>
         <option value="0" <?php echo set_selected(0,$settings['monitor_oracle']) ?> ><?php echo $this->lang->line('off'); ?></option>
        </select>
        <span class="help-inline"></span>
    </div>
   </div>
   
   <div class="control-group success">
    <label class="control-label" for="">*<?php echo $this->lang->line('monitor_mongodb'); ?></label>
    <div class="controls">
        <select name="monitor_mongodb" id="monitor_mongodb" class="input-small">
         <option value="1" <?php echo set_selected(1,$settings['monitor_mongodb']) ?> ><?php echo $this->lang->line('on'); ?></option>
         <option value="0" <?php echo set_selected(0,$settings['monitor_mongodb']) ?> ><?php echo $this->lang->line('off'); ?></option>
        </select>
        <span class="help-inline"></span>
    </div>
   </div>

   <div class="control-group success">
    <label class="control-label" for="">*<?php echo $this->lang->line('monitor_redis'); ?></label>
    <div class="controls">
        <select name="monitor_redis" id="monitor_redis" class="input-small">
         <option value="1" <?php echo set_selected(1,$settings['monitor_redis']) ?> ><?php echo $this->lang->line('on'); ?></option>
         <option value="0" <?php echo set_selected(0,$settings['monitor_redis']) ?> ><?php echo $this->lang->line('off'); ?></option>
        </select>
        <span class="help-inline"></span>
    </div>
   </div>
   
   <div class="control-group success">
    <label class="control-label" for="">*<?php echo $this->lang->line('monitor_os'); ?></label>
    <div class="controls">
        <select name="monitor_os" id="monitor_os" class="input-small">
         <option value="1" <?php echo set_selected(1,$settings['monitor_os']) ?> ><?php echo $this->lang->line('on'); ?></option>
         <option value="0" <?php echo set_selected(0,$settings['monitor_os']) ?> ><?php echo $this->lang->line('off'); ?></option>
        </select>
        <span class="help-inline"></span>
    </div>
   </div>

   <div class="control-group success">
    <label class="control-label" for="">*<?php echo $this->lang->line('frequency_monitor'); ?></label>
    <div class="controls">
        <select name="frequency_monitor" id="frequency_monitor" class="input-medium">
         <option value="30" <?php echo set_selected(30,$settings['frequency_monitor']) ?>>30 <?php echo $this->lang->line('date_seconds'); ?></option>
         <option value="60" <?php echo set_selected(60,$settings['frequency_monitor']) ?>>1 <?php echo $this->lang->line('date_minutes'); ?></option>
         <option value="120" <?php echo set_selected(120,$settings['frequency_monitor']) ?>>2 <?php echo $this->lang->line('date_minutes'); ?></option>
         <option value="180" <?php echo set_selected(180,$settings['frequency_monitor']) ?>>3 <?php echo $this->lang->line('date_minutes'); ?></option>
         <option value="300" <?php echo set_selected(300,$settings['frequency_monitor']) ?>>5 <?php echo $this->lang->line('date_minutes'); ?></option>
        </select>
        <span class="help-inline"></span>
    </div>
   </div>
   
<h2><?php echo $this->lang->line('alarm'); ?></h2>
<hr>

   
   <div class="control-group error">
    <label class="control-label" for="">*<?php echo $this->lang->line('alarm'); ?></label>
    <div class="controls">
        <select name="alarm" id="alarm" class="input-small">
         <option value="1" <?php echo set_selected(1,$settings['alarm']) ?> ><?php echo $this->lang->line('on'); ?></option>
         <option value="0" <?php echo set_selected(0,$settings['alarm']) ?> ><?php echo $this->lang->line('off'); ?></option>
        </select>
        <span class="help-inline"></span>
    </div>
   </div>
   
    <div class="control-group error">
    <label class="control-label" for="">*<?php echo $this->lang->line('send_alarm_mail'); ?></label>
    <div class="controls">
        <select name="send_alarm_mail" id="send_alarm_mail" class="input-small">
         <option value="1" <?php echo set_selected(1,$settings['send_alarm_mail']) ?> ><?php echo $this->lang->line('on'); ?></option>
         <option value="0" <?php echo set_selected(0,$settings['send_alarm_mail']) ?> ><?php echo $this->lang->line('off'); ?></option>
        </select>
        <span class="help-inline"></span>
    </div>
   </div>
   
   
   <div class="control-group error">
    <label class="control-label" for="">*<?php echo $this->lang->line('send_mail_max_count'); ?></label>
    <div class="controls">
        <select name="send_mail_max_count" id="send_mail_max_count" class="input-medium">
         <option value="1" <?php echo set_selected(1,$settings['send_mail_max_count']) ?>>1</option>
         <option value="2" <?php echo set_selected(2,$settings['send_mail_max_count']) ?>>2</option>
         <option value="3" <?php echo set_selected(3,$settings['send_mail_max_count']) ?>>3</option>
         <option value="5" <?php echo set_selected(5,$settings['send_mail_max_count']) ?>>5</option>
         <option value="10" <?php echo set_selected(10,$settings['send_mail_max_count']) ?>>10</option>
        </select>
    </div>
   </div>
   
   <div class="control-group error">
    <label class="control-label" for="">*<?php echo $this->lang->line('send_mail_sleep_time'); ?></label>
    <div class="controls">
        <select name="send_mail_sleep_time" id="send_mail_sleep_time" class="input-medium">
         <option value="15" <?php echo set_selected(15,$settings['send_mail_sleep_time']) ?>>15 <?php echo $this->lang->line('date_minutes'); ?></option>
         <option value="30" <?php echo set_selected(30,$settings['send_mail_sleep_time']) ?>>30 <?php echo $this->lang->line('date_minutes'); ?></option>
         <option value="60" <?php echo set_selected(60,$settings['send_mail_sleep_time']) ?>>1 <?php echo $this->lang->line('date_hours'); ?></option>
         <option value="120" <?php echo set_selected(120,$settings['send_mail_sleep_time']) ?>>2 <?php echo $this->lang->line('date_hours'); ?></option>
         <option value="180" <?php echo set_selected(180,$settings['send_mail_sleep_time']) ?>>3 <?php echo $this->lang->line('date_hours'); ?></option>
         <option value="360" <?php echo set_selected(360,$settings['send_mail_sleep_time']) ?>>6 <?php echo $this->lang->line('date_hours'); ?></option>
         <option value="720" <?php echo set_selected(720,$settings['send_mail_sleep_time']) ?>>12 <?php echo $this->lang->line('date_hours'); ?></option>
         <option value="1440" <?php echo set_selected(1440,$settings['send_mail_sleep_time']) ?>>24 <?php echo $this->lang->line('date_hours'); ?></option>
         <option value="2880" <?php echo set_selected(2880,$settings['send_mail_sleep_time']) ?>>48 <?php echo $this->lang->line('date_hours'); ?></option>
        </select>
    </div>
   </div>

   <div class="control-group error">
    <label class="control-label" for="">*<?php echo $this->lang->line('alarm_mail_to_list'); ?></label>
    <div class="controls">
      <input type="text" id="send_mail_to_list"  name="send_mail_to_list" value="<?php echo $settings['send_mail_to_list'] ?>" class="input-xxlarge">
      <span class="help-inline"><?php echo $this->lang->line('many_people_separation'); ?></span>
    </div>
   </div>
   
   
    <div class="control-group error">
    <label class="control-label" for="">*<?php echo $this->lang->line('send_alarm_sms'); ?></label>
    <div class="controls">
        <select name="send_alarm_sms" id="send_alarm_sms" class="input-small">
         <option value="1" <?php echo set_selected(1,$settings['send_alarm_sms']) ?> ><?php echo $this->lang->line('on'); ?></option>
         <option value="0" <?php echo set_selected(0,$settings['send_alarm_sms']) ?> ><?php echo $this->lang->line('off'); ?></option>
        </select>
        <span class="help-inline"></span>
    </div>
   </div>
   
   
   <div class="control-group error">
    <label class="control-label" for="">*<?php echo $this->lang->line('send_sms_max_count'); ?></label>
    <div class="controls">
        <select name="send_sms_max_count" id="send_sms_max_count" class="input-medium">
         <option value="1" <?php echo set_selected(1,$settings['send_sms_max_count']) ?>>1</option>
         <option value="2" <?php echo set_selected(2,$settings['send_sms_max_count']) ?>>2</option>
         <option value="3" <?php echo set_selected(3,$settings['send_sms_max_count']) ?>>3</option>
         <option value="5" <?php echo set_selected(5,$settings['send_sms_max_count']) ?>>5</option>
         <option value="10" <?php echo set_selected(10,$settings['send_sms_max_count']) ?>>10</option>
        </select>
    </div>
   </div>
   
   <div class="control-group error">
    <label class="control-label" for="">*<?php echo $this->lang->line('send_sms_sleep_time'); ?></label>
    <div class="controls">
        <select name="send_sms_sleep_time" id="send_sms_sleep_time" class="input-medium">
         <option value="15" <?php echo set_selected(15,$settings['send_sms_sleep_time']) ?>>15 <?php echo $this->lang->line('date_minutes'); ?></option>
         <option value="30" <?php echo set_selected(30,$settings['send_sms_sleep_time']) ?>>30 <?php echo $this->lang->line('date_minutes'); ?></option>
         <option value="60" <?php echo set_selected(60,$settings['send_sms_sleep_time']) ?>>1 <?php echo $this->lang->line('date_hours'); ?></option>
         <option value="120" <?php echo set_selected(120,$settings['send_sms_sleep_time']) ?>>2 <?php echo $this->lang->line('date_hours'); ?></option>
         <option value="180" <?php echo set_selected(180,$settings['send_sms_sleep_time']) ?>>3 <?php echo $this->lang->line('date_hours'); ?></option>
         <option value="360" <?php echo set_selected(360,$settings['send_sms_sleep_time']) ?>>6 <?php echo $this->lang->line('date_hours'); ?></option>
         <option value="720" <?php echo set_selected(720,$settings['send_sms_sleep_time']) ?>>12 <?php echo $this->lang->line('date_hours'); ?></option>
         <option value="1440" <?php echo set_selected(1440,$settings['send_sms_sleep_time']) ?>>24 <?php echo $this->lang->line('date_hours'); ?></option>
         <option value="2880" <?php echo set_selected(2880,$settings['send_sms_sleep_time']) ?>>48 <?php echo $this->lang->line('date_hours'); ?></option>
        </select>
    </div>
   </div>

   <div class="control-group error">
    <label class="control-label" for=""><?php echo $this->lang->line('alarm_sms_to_list'); ?></label>
    <div class="controls">
      <input type="text" id="send_sms_to_list"  name="send_sms_to_list" value="<?php echo $settings['send_sms_to_list'] ?>" class="input-xxlarge">
      <span class="help-inline"><?php echo $this->lang->line('many_people_separation'); ?></span>
    </div>
   </div>
   
<!--
   <div class="control-group error">
    <label class="control-label" for=""><?php echo $this->lang->line('report_mail_to_list'); ?></label>
    <div class="controls">
      <input type="text" id="report_mail_to_list"  name="report_mail_to_list" value="<?php echo $settings['report_mail_to_list'] ?>" class="input-xxlarge">
      <span class="help-inline"><?php echo $this->lang->line('many_people_separation'); ?></span>
    </div>
   </div>
 -->  

<h2><?php echo $this->lang->line('mail'); ?></h2>
<hr>


<div class="control-group info">
    <label class="control-label" for="">*<?php echo $this->lang->line('mailprotocol'); ?></label>
    <div class="controls">
      <input type="text" id="mailprotocol" readonly name="mailprotocol" value="<?php echo $settings['mailprotocol'] ?>" class="input-large">
    </div>
   </div>
   <div class="control-group info">
    <label class="control-label" for="">*<?php echo $this->lang->line('mailtype'); ?></label>
    <div class="controls">
      <input type="text" id="mailtype" readonly name="mailtype" value="<?php echo $settings['mailtype'] ?>" class="input-large">
    </div>
   </div>
   <div class="control-group info">
    <label class="control-label" for="">*<?php echo $this->lang->line('smtp_host'); ?></label>
    <div class="controls">
      <input type="text" id="smtp_host"  name="smtp_host" value="<?php echo $settings['smtp_host'] ?>" class="input-large">
    </div>
   </div>
   <div class="control-group info">
    <label class="control-label" for="">*<?php echo $this->lang->line('smtp_port'); ?></label>
    <div class="controls">
      <input type="text" id="smtp_port"  name="smtp_port" value="<?php echo $settings['smtp_port'] ?>" class="input-large">
    </div>
   </div>
   <div class="control-group info">
    <label class="control-label" for="">*<?php echo $this->lang->line('smtp_user'); ?></label>
    <div class="controls">
      <input type="text" id="smtp_user"  name="smtp_user" value="<?php echo $settings['smtp_user'] ?>" class="input-large">
    </div>
   </div>
   <div class="control-group info">
    <label class="control-label" for="">*<?php echo $this->lang->line('smtp_pass'); ?></label>
    <div class="controls">
      <input type="password" id="smtp_pass"  name="smtp_pass" value="<?php echo $settings['smtp_pass'] ?>" class="input-large">
    </div>
   </div>
   <div class="control-group info">
    <label class="control-label" for="">*<?php echo $this->lang->line('smtp_timeout'); ?></label>
    <div class="controls">
      <input type="text" id="smtp_timeout"  name="smtp_timeout" value="<?php echo $settings['smtp_timeout'] ?>" class="input-large">
    </div>
   </div>
   <div class="control-group info">
    <label class="control-label" for="">*<?php echo $this->lang->line('mailfrom'); ?></label>
    <div class="controls">
      <input type="text" id="mailfrom"  name="mailfrom" value="<?php echo $settings['mailfrom'] ?>" class="input-large">
    </div>
   </div>


<h2><?php echo $this->lang->line('sms'); ?></h2>
<hr>

	<div class="control-group error">
    <label class="control-label" for="">*<?php echo $this->lang->line('sms_type'); ?></label>
    <div class="controls">
        <select name="smstype" id="smstype" class="input-medium">
         <option value="fetion" <?php echo set_selected('fetion',$settings['smstype']) ?>>Fetion</option>
         <option value="api" <?php echo set_selected('api',$settings['smstype']) ?>>Api</option>
        </select>
    </div>
   </div>

   <div class="control-group info">
    <label class="control-label" for="">*<?php echo $this->lang->line('fetion_user'); ?></label>
    <div class="controls">
      <input type="text" id="sms_fetion_user"  name="sms_fetion_user" value="<?php echo $settings['sms_fetion_user'] ?>" class="input-large">
    </div>
   </div>
   <div class="control-group info">
    <label class="control-label" for="">*<?php echo $this->lang->line('fetion_pass'); ?></label>
    <div class="controls">
      <input type="password" id="sms_fetion_pass"  name="sms_fetion_pass" value="<?php echo $settings['sms_fetion_pass'] ?>" class="input-large">
    </div>
   </div>
   
   
     
<hr>    

  <div class="btn-toolbar">
    <button type="submit" class="btn btn-primary"><i class="icon-save"></i> <?php echo $this->lang->line('save'); ?></button>
  <div class="btn-group"></div>
</div>
                                    
</form>

