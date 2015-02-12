<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="header">  
            <h1 class="page-title"><?php echo $this->lang->line('privilege'); ?> <?php echo $this->lang->line('edit'); ?></h1>
</div>
     
<ul class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><?php echo $this->lang->line('home'); ?></a> <span class="divider">/</span></li>
            <li class="active"><?php echo $this->lang->line('permission_system'); ?></li><span class="divider">/</span></li>
            <li class="active"><?php echo $this->lang->line('privilege'); ?></li>
</ul>

<div class="container-fluid">
<div class="row-fluid">

<form name="form" class="form-horizontal" method="post" action="<?php echo site_url('privilege/edit') ?>" >
<input type="hidden" name="submit" value="edit"/> 
<input type='hidden'  name='privilege_id' value=<?php echo $record['privilege_id'] ?> />
<div class="btn-toolbar">
    <button type="submit" class="btn btn-primary"><i class="icon-save"></i> <?php echo $this->lang->line('save'); ?></button>
    <a class="btn btn " href="<?php echo site_url('privilege/index') ?>"><i class="icon-list"></i> <?php echo $this->lang->line('list'); ?></a>
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
    <label class="control-label" for="">*<?php echo $this->lang->line('privilege_title'); ?></label>
    <div class="controls">
      <input type="text" id="privilege_title"  name="privilege_title" value="<?php echo set_value('privilege_title',$record['privilege_title']); ?>" >
    </div>
   </div>
   <div class="control-group">
    <label class="control-label" for="">*<?php echo $this->lang->line('action'); ?></label>
    <div class="controls">
      <input type="text" id="action"  name="action" value="<?php echo set_value('action',$record['action'] ); ?>" >
    </div>
   </div>
   <div class="control-group">
    <label class="control-label" for=""><?php echo $this->lang->line('menu'); ?></label>
    <div class="controls">
        <select name="menu_id" id="menu_id" >
         <option value="0"  ><?php echo $this->lang->line('select'); ?></option>
          <?php if(!empty($menu_record_tree)) {?>
          <?php foreach ($menu_record_tree  as $item):?>
          <option value="<?php echo $item['menu_id']; ?>" <?php echo set_selected($record['menu_id'],$item['menu_id']) ?>  ><?php echo $item['str_repeat'].$item['menu_title']; ?></option>
          <?php endforeach;?>
          <?php } ?>
        </select>
    </div>
   </div>
    <div class="control-group">
    <label class="control-label" for=""><?php echo $this->lang->line('display_order'); ?></label>
    <div class="controls">
      <input type="text" id="display_order"  name="display_order" value="<?php echo set_value('display_order',$record['display_order']); ?>" >
    </div>
   </div>
   
</div>



</form>

