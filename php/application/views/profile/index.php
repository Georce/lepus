<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="header">  
            <h1 class="page-title"><?php echo $this->lang->line('profile'); ?> </h1>
</div>
     
<ul class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><?php echo $this->lang->line('home'); ?></a> <span class="divider">/</span></li>
            <li class="active"><?php echo $this->lang->line('profile'); ?></li>
</ul>

<div class="container-fluid">
<div class="row-fluid">

<form name="form" class="form-horizontal" method="post" action="<?php echo site_url('profile/index') ?>" >
<input type="hidden" name="submit" value="save"/> 
<input type='hidden'  name='user_id' value=<?php echo $record['user_id'] ?> />
<div class="btn-toolbar">
    <button type="submit" class="btn btn-primary"><i class="icon-save"></i> <?php echo $this->lang->line('save'); ?></button>
    <a class="btn btn " href="<?php echo site_url('') ?>"><i class="icon-list"></i> <?php echo $this->lang->line('home'); ?></a>
  <div class="btn-group"></div>
</div>

<?php if ($error_code===1) { ?>
<div class="alert alert-error">
<button type="button" class="close" data-dismiss="alert">×</button>
<?php echo validation_errors(); ?>
</div>
<?php } else if($error_code===0) {?>
<div class="alert alert-success">
<button type="button" class="close" data-dismiss="alert">×</button>
<?php echo $this->lang->line('update_success'); ?>
</div>
<?php } ?>

<div class="well">
   
   <div class="control-group">
    <label class="control-label" for="">*<?php echo $this->lang->line('username'); ?></label>
    <div class="controls">
      <input type="text" id="username"   name="username" readonly value="<?php echo $record['username']; ?>" >
    </div>
   </div>
   <div class="control-group">
    <label class="control-label" for="">*<?php echo $this->lang->line('password'); ?></label>
    <div class="controls">
      <input type="text" id="password"  name="password" readonly value="" >
      <span class="help-inline"><?php echo $this->lang->line('edit_user_password_help'); ?></span>
    </div>
   </div>
   <div class="control-group">
    <label class="control-label" for="">*<?php echo $this->lang->line('realname'); ?></label>
    <div class="controls">
      <input type="text" id=""  name="realname" value="<?php echo $record['realname']; ?>" >
    </div>
   </div>
   <div class="control-group">
    <label class="control-label" for=""><?php echo $this->lang->line('email'); ?></label>
    <div class="controls">
      <input type="text" id=""  name="email" value="<?php echo $record['email']; ?>" >
    </div>
   </div>
   <div class="control-group">
    <label class="control-label" for=""><?php echo $this->lang->line('mobile'); ?></label>
    <div class="controls">
      <input type="text" id=""  name="mobile" value="<?php echo $record['mobile']; ?>" >
    </div>
   </div>
   
        <input type='hidden'  name='status' value="1" />

   
</div>

</form>

