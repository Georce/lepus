<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="header">  
            <h1 class="page-title"><?php echo $this->lang->line('authorization'); ?></h1>
</div>
     
<ul class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><?php echo $this->lang->line('home'); ?></a> <span class="divider">/</span></li>
            <li class="active"><?php echo $this->lang->line('permission_system'); ?></li><span class="divider">/</span></li>
            <li class="active"><?php echo $this->lang->line('authorization'); ?></li>
</ul>

<script src="lib/jquery.skygqbox.1.3.js" type="text/javascript"></script>

<div class="container-fluid">

<?php if($error_code===0) { ?>
<div class="alert alert-success">
<button type="button" class="close" data-dismiss="alert">×</button>
<?php echo $this->lang->line('auth_success'); ?>
</div>
<?php } else if($error_code===1){ ?>
<div class="alert alert-error">
<button type="button" class="close" data-dismiss="alert">×</button>
<?php echo $this->lang->line('auth_success'); ?>
</div>
<?php } ?>
 
<div class="row-fluid">
    <div class="block span7">
        <p class="block-heading"><?php echo $this->lang->line('privilege_assignments'); ?></p>
        <div class="block-body">
            <h2><?php echo $this->lang->line('privilege_to_role'); ?></h2>
        <p>
        <form name="role_privilege" class="form-horizontal" method="post" onSubmit="return CheckForm1();" action="<?php echo site_url('auth/update_role_privilege') ?>" >
        <input type="hidden" name="submit" value="auth_role_privilege"/> 
        <select name="role_id" id="role_id" >
         <option value="0"  ><?php echo $this->lang->line('select_role'); ?></option>
          <?php if(!empty($role_list)) {?>
          <?php foreach ($role_list  as $item):?>
          <option value="<?php echo $item['role_id']; ?>" <?php if($role_id==$item['role_id']) echo "selected"; ?>  ><?php echo $item['role_name']; ?></option>
          <?php endforeach;?>
          <?php } ?>
        </select>
        </p>
        
        <div id="privilege_list">
          <?php if(!empty($privilege_list)) {?>
          <?php foreach ($privilege_list  as $item):?>
            <div class="privilege_checkbox"><input type="checkbox" name="privilege_id[]"  value="<?php echo $item['privilege_id']; ?>" <?php if(in_array($item['privilege_id'],$role_privilege)) echo "checked"; ?> /> <?php echo $item['privilege_title']; ?></div>
          <?php endforeach;?>
          <?php } ?>
        </div>
        <div class="clear"></div>
        <hr />
        <button type="submit" class="btn btn-primary"><i class="icon-save"></i> <?php echo $this->lang->line('save'); ?></button>
        <input type="checkbox" id="chkall" name="chkall" onclick="checkAll(this.form, 'id')"/>&nbsp;<?php echo $this->lang->line('check_all'); ?>
        </form>            
        </div>
    </div>
    
    
    <div class="block span5">
        <p class="block-heading"><?php echo $this->lang->line('role_assignments'); ?></p>
        <div class="block-body">
        <h2><?php echo $this->lang->line('role_to_user'); ?></h2>
        <form name="user_role" class="form-horizontal" method="post" onSubmit="return CheckForm2();" action="<?php echo site_url('auth/update_user_role') ?>" >
        <input type="hidden" name="submit" value="auth_user_role"/> 
        <select name="user_id" id="user_id" >
         <option value="0"  ><?php echo $this->lang->line('select_user'); ?></option>
          <?php if(!empty($user_list)) {?>
          <?php foreach ($user_list  as $item):?>
          <option value="<?php echo $item['user_id']; ?>" <?php if($user_id==$item['user_id']) echo "selected"; ?>  ><?php echo $item['username']; ?></option>
          <?php endforeach;?>
          <?php } ?>
        </select>
        </p>
        
        <div id="role_list">
          <?php if(!empty($role_list)) {?>
          <?php foreach ($role_list  as $item):?>
            <div class="role_checkbox"><input type="checkbox" name="role_id[]"  value="<?php echo $item['role_id']; ?>" <?php if(in_array($item['role_id'],$user_role)) echo "checked"; ?> /> <?php echo $item['role_name']; ?></div>
          <?php endforeach;?>
          <?php } ?>
        </div>
        <div class="clear"></div>
        <hr />
        <button type="submit" class="btn btn-primary"><i class="icon-save"></i> <?php echo $this->lang->line('save'); ?></button>
        <input type="checkbox" id="chkall" name="chkall" onclick="checkAll(this.form, 'id')"/>&nbsp;<?php echo $this->lang->line('check_all'); ?>
        </form>
        </div>
    </div>


<script language="javascript">
$(document).ready(function(){ 
	 //变更角色获取权限
     $('#role_id').change(function(){
       $.ajax({
	       type:'POST',
	       url:"<?php echo site_url('auth/ajax_privilege_list'); ?>",
	       data:{ role_id:$('#role_id').val() }, 
	       beforeSend:function(){
			 $("#privilege_list").html("数据加载中...");	  	
	       },  
	       success:function(data){
	           //alert(data);
	           if(data=='nodata')
	           {
	              $('#privilege_list').html("<font color=red>没有数据</font>");
	           }
               else
	           {
	               $('#privilege_list').html(data);
	           }
	       }
			
	   });
    });
     
     //变更用户获取角色
     $('#user_id').change(function(){
       $.ajax({
	       type:'POST',
	       url:"<?php echo site_url('auth/ajax_role_list'); ?>",
	       data:{ user_id:$('#user_id').val() }, 
	       beforeSend:function(){
			 $("#role_list").html("数据加载中...");	  	
	       },  
	       success:function(data){
	           //alert(data);
	           if(data=='nodata')
	           {
	               $('#role_list').html("<font color=red>没有数据</font>");
	           }
               else
	           {
	               $('#role_list').html(data);
	           }
	       }
			
	   });
    });
    
});

function checkAll(form, name) {
	for(var i = 0; i < form.elements.length; i++) {
		var e = form.elements[i];
		if(e.name.match(name)) {
			e.checked = form.elements['chkall'].checked;
		}
	}
}

function CheckForm1()
{
	if (document.role_privilege.role_id.value == 0) {
		alert("请选择要授权的角色.");
		return false;
	}
}

function CheckForm2()
{
	if (document.user_role.user_id.value == 0) {
		alert("请选择要授权的用户.");
		return false;
	}
}
  
</script>