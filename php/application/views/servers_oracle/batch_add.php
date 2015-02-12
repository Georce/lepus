<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="header">  
            <h1 class="page-title"><?php echo $this->lang->line('_Oracle'); ?> <?php echo $this->lang->line('batch_add'); ?></h1>
</div>
     
<ul class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><?php echo $this->lang->line('home'); ?></a> <span class="divider">/</span></li>
            <li class="active"><?php echo $this->lang->line('_Servers Configure'); ?></li><span class="divider">/</span></li>
            <li class="active"><?php echo $this->lang->line('_Oracle'); ?></li>
</ul>

<div class="container-fluid">
<div class="row-fluid">

<form name="form" class="form-horizontal" method="post" action="<?php echo site_url('servers_oracle/batch_add') ?>" >
<input type="hidden" name="submit"  value="batch_add"/> 
<div class="btn-toolbar">
    <button type="submit" class="btn btn-primary confirm_add"><i class="icon-save"></i> <?php echo $this->lang->line('save'); ?></button>
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
  
    <table class="table table-hover table-bordered  ">
	<tr>
		<th colspan="6"><center><?php echo $this->lang->line('servers'); ?></center></th>
		<th colspan="3"><center><?php echo $this->lang->line('monitoring_switch'); ?></center></th>
        <th colspan="4"><center><?php echo $this->lang->line('alarm_items'); ?></center></th>
	</tr>
    <tr>
        <th><?php echo $this->lang->line('host'); ?></th>
        <th><?php echo $this->lang->line('port'); ?></th>
		<th><?php echo $this->lang->line('dsn'); ?></th>
        <th><?php echo $this->lang->line('username'); ?></th>
        <th><?php echo $this->lang->line('password'); ?></th>
        <th><?php echo $this->lang->line('tags'); ?></th>
		<th><?php echo $this->lang->line('monitor'); ?></th>
		<th><?php echo $this->lang->line('send_mail'); ?></th>
    	<th><?php echo $this->lang->line('send_sms'); ?></th>
        <th><?php echo $this->lang->line('session_total'); ?></th>
		<th><?php echo $this->lang->line('session_actives'); ?></th>
    	<th><?php echo $this->lang->line('session_waits'); ?></th>
        <th><?php echo $this->lang->line('tbs'); ?></th>
	</tr>
	
<?php for($n=1;$n<=10;$n++){ ?>
<input type="hidden" name="submit" value="batch_add"/>                             
<input type="hidden" name="ids[]" value="<?php echo $n ?>" /> 
    <tr style="font-size: 13px;">
        <td><input type="text" name="host_<?php echo $n ?>" class="input-small" placeholder="<?php echo $this->lang->line('host'); ?>" value=""></td>
        <td><input type="text" name="port_<?php echo $n ?>" class="input-mini" placeholder="<?php echo $this->lang->line('port'); ?>" value="1521"></td>
		 <td><input type="text" name="dsn_<?php echo $n ?>" class="input-mini" placeholder="<?php echo $this->lang->line('dsn'); ?>" value=""></td>
        <td><input type="text" name="username_<?php echo $n ?>" class="input-mini" placeholder="<?php echo $this->lang->line('username'); ?>" value=""></td>
        <td><input type="password" name="password_<?php echo $n ?>" class="input-mini" placeholder="<?php echo $this->lang->line('password'); ?>" value=""></td>
        <td><input type="text" name="tags_<?php echo $n ?>" class="input-mini" placeholder="<?php echo $this->lang->line('tags'); ?>" value=""></td>
        
        <td><select name="monitor_<?php echo $n ?>"  class="input-mini">
         <option value="1"  ><?php echo $this->lang->line('on'); ?></option>
         <option value="0"  ><?php echo $this->lang->line('off'); ?></option>
        </select></td>
        <td> <select name="send_mail_<?php echo $n ?>"  class="input-mini">
         <option value="1"  ><?php echo $this->lang->line('on'); ?></option>
         <option value="0"  ><?php echo $this->lang->line('off'); ?></option>
        </select></td>
        <td> <select name="send_sms_<?php echo $n ?>"  class="input-mini">
         <option value="1"  ><?php echo $this->lang->line('on'); ?></option>
         <option value="0"  ><?php echo $this->lang->line('off'); ?></option>
        </select></td>
        <td><select name="alarm_session_total_<?php echo $n ?>"  class="input-mini">
         <option value="1"  ><?php echo $this->lang->line('on'); ?></option>
         <option value="0"  ><?php echo $this->lang->line('off'); ?></option>
        </select></td>
        <td><select name="alarm_session_actives_<?php echo $n ?>"  class="input-mini">
         <option value="1"  ><?php echo $this->lang->line('on'); ?></option>
         <option value="0"  ><?php echo $this->lang->line('off'); ?></option>
        </select></td>
        <td><select name="alarm_session_waits_<?php echo $n ?>"  class="input-mini">
         <option value="1"  ><?php echo $this->lang->line('on'); ?></option>
         <option value="0"  ><?php echo $this->lang->line('off'); ?></option>
        </select></td>
        <td><select name="alarm_tablespace_<?php echo $n ?>"  class="input-mini">
         <option value="1"  ><?php echo $this->lang->line('on'); ?></option>
         <option value="0"  ><?php echo $this->lang->line('off'); ?></option>
        </select></td>
    
	</tr>
<?php } ?> 
                                                                                                     

</table>

   
</div>


</form>

<script type="text/javascript">
	$(' .confirm_add').click(function(){
		return confirm('确定要批量提交所有服务器？');	
	});
</script>