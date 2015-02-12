<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="header">  
            <h1 class="page-title"><?php echo $this->lang->line('_Application'); ?> <?php echo $this->lang->line('add'); ?></h1>
</div>
     
<ul class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><?php echo $this->lang->line('home'); ?></a> <span class="divider">/</span></li>
            <li class="active"><?php echo $this->lang->line('_Servers Configure'); ?></li><span class="divider">/</span></li>
            <li class="active"><?php echo $this->lang->line('_Application'); ?></li>
</ul>

<div class="container-fluid">
<div class="row-fluid">

<form name="form" class="form-horizontal" method="post" action="<?php echo site_url('application/add') ?>" >
<input type="hidden" name="submit" value="add"/> 
<div class="btn-toolbar">
    <button type="submit" class="btn btn-primary"><i class="icon-save"></i> <?php echo $this->lang->line('save'); ?></button>
    <a class="btn btn " href="<?php echo site_url('application/index') ?>"><i class="icon-list"></i> <?php echo $this->lang->line('list'); ?></a>
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
    <label class="control-label" for="">*<?php echo $this->lang->line('name'); ?></label>
    <div class="controls">
      <input type="text" id=""  name="name"  placeholder="" value="<?php echo set_value('name'); ?>" >
      <span class="help-inline"></span>
    </div>
   </div>
    <div class="control-group">
    <label class="control-label" for="">*<?php echo $this->lang->line('display_name'); ?></label>
    <div class="controls">
      <input type="text" id=""  name="display_name" placeholder=""  value="<?php echo set_value('display_name'); ?>" >
      <span class="help-inline"></span>
    </div>
   </div>
   <div class="control-group">
    <label class="control-label" for="">*<?php echo $this->lang->line('db_type'); ?></label>
    <div class="controls">
        <select name="db_type" id="db_type" class="input-medium">
         <option value="mysql"  ><?php echo $this->lang->line('mysql'); ?></option>
         <option value="mongodb"  ><?php echo $this->lang->line('mongodb'); ?></option>
         <option value="redis"  ><?php echo $this->lang->line('redis'); ?></option>
         <option value="oracle"  ><?php echo $this->lang->line('oracle'); ?></option>

        </select>
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

