<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="header">  
            <h1 class="page-title"><?php echo $this->lang->line('user'); ?> <?php echo $this->lang->line('add'); ?></h1>
</div>
     
<ul class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><?php echo $this->lang->line('home'); ?></a> <span class="divider">/</span></li>
            <li class="active"><?php echo $this->lang->line('permission_system'); ?></li><span class="divider">/</span></li>
            <li class="active"><?php echo $this->lang->line('user'); ?></li>
</ul>

<div class="container-fluid">
<div class="row-fluid">

<form name="form" class="form-horizontal" method="post" action="<?php echo site_url('user/add') ?>" >
<input type="hidden" name="submit" value="add"/> 
<div class="btn-toolbar">
    <button type="submit" class="btn btn-primary"><i class="icon-save"></i> <?php echo $this->lang->line('save'); ?></button>
    <a class="btn btn " href="<?php echo site_url('user/index') ?>"><i class="icon-list"></i> <?php echo $this->lang->line('list'); ?></a>
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
    <label class="control-label" for="">*<?php echo $this->lang->line('username'); ?></label>
    <div class="controls">
      <input type="text" id="username"  name="username" value="<?php echo set_value('username'); ?>" >
    </div>
   </div>
   <div class="control-group">
    <label class="control-label" for="">*<?php echo $this->lang->line('password'); ?></label>
    <div class="controls">
      <input type="password" id="password"  name="password" value="<?php echo set_value('password'); ?>" >
    </div>
   </div>
   <div class="control-group">
    <label class="control-label" for="">*<?php echo $this->lang->line('confirm_password'); ?></label>
    <div class="controls">
      <input type="password" id="confirm_password"  name="confirm_password" value="<?php echo set_value('confirm_password'); ?>" >
    </div>
   </div>
   <div class="control-group">
    <label class="control-label" for="">*<?php echo $this->lang->line('realname'); ?></label>
    <div class="controls">
      <input type="text" id=""  name="realname" value="<?php echo set_value('realname'); ?>" >
    </div>
   </div>
   <div class="control-group">
    <label class="control-label" for=""><?php echo $this->lang->line('email'); ?></label>
    <div class="controls">
      <input type="text" id=""  name="email" value="<?php echo set_value('email'); ?>" >
    </div>
   </div>
   <div class="control-group">
    <label class="control-label" for=""><?php echo $this->lang->line('mobile'); ?></label>
    <div class="controls">
      <input type="text" id=""  name="mobile" value="<?php echo set_value('mobile'); ?>" >
    </div>
   </div>
    <div class="control-group">
    <label class="control-label" for="">*<?php echo $this->lang->line('status'); ?></label>
    <div class="controls">
        <select name="status" id="status" class="input-small">
         <option value="1"  ><?php echo $this->lang->line('enabled'); ?></option>
         <option value="0"  ><?php echo $this->lang->line('disable'); ?></option>
        </select>
    </div>
   </div>
   
</div>



</form>

