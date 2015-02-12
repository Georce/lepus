<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="header">  
            <h1 class="page-title"><?php echo $this->lang->line('_Machine Room'); ?> <?php echo $this->lang->line('edit'); ?></h1>
</div>
     
<ul class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><?php echo $this->lang->line('home'); ?></a> <span class="divider">/</span></li>
            <li class="active"><?php echo $this->lang->line('_Servers Configure'); ?></li><span class="divider">/</span></li>
            <li class="active"><?php echo $this->lang->line('_Machine Room'); ?></li>
</ul>

<div class="container-fluid">
<div class="row-fluid">

<form name="form" class="form-horizontal" method="post" action="<?php echo site_url('machine_room/edit') ?>" >
<input type="hidden" name="submit" value="edit"/> 
<input type='hidden'  name='id' value=<?php echo $record['id'] ?> />
<div class="btn-toolbar">
    <button type="submit" class="btn btn-primary"><i class="icon-save"></i> <?php echo $this->lang->line('save'); ?></button>
    <a class="btn btn " href="<?php echo site_url('machine_room/index') ?>"><i class="icon-list"></i> <?php echo $this->lang->line('list'); ?></a>
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
    <label class="control-label" for="">*<?php echo $this->lang->line('machine_room_name'); ?></label>
    <div class="controls">
      <input type="text" id=""  name="name"  placeholder="" value="<?php echo $record['name']; ?>" >
      <span class="help-inline"></span>
    </div>
   </div>
   <div class="control-group">
    <label class="control-label" for="">*<?php echo $this->lang->line('machine_room_code'); ?></label>
    <div class="controls">
      <input type="text" id=""  name="code"  placeholder="" value="<?php echo $record['code']; ?>" >
      <span class="help-inline"></span>
    </div>
   </div>
    <div class="control-group">
    <label class="control-label" for=""><?php echo $this->lang->line('machine_room_address'); ?></label>
    <div class="controls">
      <input type="text" id=""  name="address" placeholder=""  value="<?php echo $record['address']; ?>" >
      <span class="help-inline"></span>
    </div>
   </div>
   <div class="control-group">
    <label class="control-label" for=""><?php echo $this->lang->line('on_duty_tel'); ?></label>
    <div class="controls">
      <input type="text" id=""  name="on_duty_tel" placeholder=""  value="<?php echo $record['on_duty_tel']; ?>" >
      <span class="help-inline"></span>
    </div>
   </div>
   <div class="control-group">
    <label class="control-label" for=""><?php echo $this->lang->line('remark'); ?></label>
    <div class="controls">
      <input type="text" id=""  name="remark" placeholder="" class="input-xxlarge"  value="<?php echo $record['remark']; ?>" >
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
   
</div>

</form>

