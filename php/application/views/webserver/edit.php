<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="header">  
            <h1 class="page-title"><?php echo $this->lang->line('_WebServer Site'); ?> <?php echo $this->lang->line('edit'); ?></h1>
</div>
     
<ul class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><?php echo $this->lang->line('home'); ?></a> <span class="divider">/</span></li>
            <li class="active"><?php echo $this->lang->line('_WebServer Monitor'); ?></li><span class="divider">/</span></li>
            <li class="active"><?php echo $this->lang->line('_WebServer Site'); ?></li>
</ul>

<div class="container-fluid">
<div class="row-fluid">

<form name="form" class="form-horizontal" method="post" action="<?php echo site_url('webserver/edit') ?>" >
<input type="hidden" name="submit" value="edit"/> 
<input type='hidden'  name='id' value=<?php echo $record['id'] ?> />
<div class="btn-toolbar">
    <button type="submit" class="btn btn-primary"><i class="icon-save"></i> <?php echo $this->lang->line('save'); ?></button>
    <a class="btn btn " href="<?php echo site_url('webserver/index') ?>"><i class="icon-list"></i> <?php echo $this->lang->line('list'); ?></a>
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
    <label class="control-label" for="">*<?php echo $this->lang->line('domain'); ?></label>
    <div class="controls">
      <input type="text" id=""  name="domain"  placeholder="" value="<?php echo $record['domain']; ?>" >
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
    <label class="control-label" for=""><?php echo $this->lang->line('request'); ?></label>
    <div class="controls">
      <input type="text" id="request"  name="request" value="<?php echo $record['request']; ?>" >
      <span class="help-inline"></span>
    </div>
   </div>
    <div class="control-group">
    <label class="control-label" for="">*<?php echo $this->lang->line('status'); ?></label>
    <div class="controls">
        <select name="status" id="status" class="input-small">
         <option value="1" <?php echo set_selected(1,$record['status']) ?> ><?php echo $this->lang->line('enabled'); ?></option>
         <option value="0" <?php echo set_selected(0,$record['status']) ?> ><?php echo $this->lang->line('disable'); ?></option>
        </select>
    </div>
   </div>
   <div class="control-group">
    <label class="control-label" for=""><?php echo $this->lang->line('send_mail'); ?></label>
    <div class="controls">
        <select name="send_mail" id="send_mail" class="input-small">
         <option value="1" <?php echo set_selected(1,$record['send_mail']) ?> ><?php echo $this->lang->line('on'); ?></option>
         <option value="0" <?php echo set_selected(0,$record['send_mail']) ?> ><?php echo $this->lang->line('off'); ?></option>
        </select>
    </div>
   </div>
    <div class="control-group">
    <label class="control-label" for=""><?php echo $this->lang->line('mail_to_list'); ?></label>
    <div class="controls">
      <input type="text" id="mail_to_list"  name="mail_to_list" value="<?php echo $record['mail_to_list']; ?>" >
      <span class="help-inline"></span>
    </div>
   </div> 
   
</div>

</form>

