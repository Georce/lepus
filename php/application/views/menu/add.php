<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="header">  
            <h1 class="page-title"><?php echo $this->lang->line('menu'); ?> <?php echo $this->lang->line('add'); ?></h1>
</div>
     
<ul class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><?php echo $this->lang->line('home'); ?></a> <span class="divider">/</span></li>
            <li class="active"><?php echo $this->lang->line('permission_system'); ?></li><span class="divider">/</span></li>
            <li class="active"><?php echo $this->lang->line('menu'); ?></li>
</ul>

<div class="container-fluid">
<div class="row-fluid">

<form name="form" class="form-horizontal" method="post" action="<?php echo site_url('menu/add') ?>" >
<input type="hidden" name="submit" value="add"/> 
<div class="btn-toolbar">
    <button type="submit" class="btn btn-primary"><i class="icon-save"></i> <?php echo $this->lang->line('save'); ?></button>
    <a class="btn btn " href="<?php echo site_url('menu/index') ?>"><i class="icon-list"></i> <?php echo $this->lang->line('list'); ?></a>
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
    <label class="control-label" for="">*<?php echo $this->lang->line('parent_menu'); ?></label>
    <div class="controls">
        <select name="parent_id" id="parent_id" >
         <option value="0"  ><?php echo $this->lang->line('top_menu'); ?></option>
          <?php if(!empty($menu_record_tree)) {?>
          <?php foreach ($menu_record_tree  as $item):?>
          <option value="<?php echo $item['menu_id']; ?>"  ><?php echo $item['str_repeat'].$item['menu_title']; ?></option>
          <?php endforeach;?>
          <?php } ?>
        </select>
    </div>
   </div>
   <div class="control-group">
    <label class="control-label" for="">*<?php echo $this->lang->line('menu'); ?></label>
    <div class="controls">
      <input type="text" id="menu_title"  name="menu_title" value="<?php echo set_value('menu_title'); ?>" >
    </div>
   </div>
   <div class="control-group">
    <label class="control-label" for="">*<?php echo $this->lang->line('url'); ?></label>
    <div class="controls">
      <input type="text" id="menu_url"  name="menu_url" value="<?php echo set_value('menu_url'); ?>" >
    </div>
   </div>
   <div class="control-group">
    <label class="control-label" for=""><?php echo $this->lang->line('icon'); ?></label>
    <div class="controls">
      <input type="text" id="menu_icon"  name="menu_icon" value="<?php echo set_value('menu_icon'); ?>" >
    </div>
   </div>
   <div class="control-group">
    <label class="control-label" for=""><?php echo $this->lang->line('display_order'); ?></label>
    <div class="controls">
      <input type="text" id="display_order"  name="display_order" value="<?php echo set_value('display_order',0); ?>" >
    </div>
   </div>
   <div class="control-group">
    <label class="control-label" for=""><?php echo $this->lang->line('status'); ?></label>
    <div class="controls">
        <select name="status" id="status" >
         <option value="1"  ><?php echo $this->lang->line('display'); ?></option>
         <option value="0"  ><?php echo $this->lang->line('hidden'); ?></option>
        </select>
    </div>
   </div>
   
   
</div>

</form>

