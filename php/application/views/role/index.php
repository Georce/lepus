<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="header">  
            <h1 class="page-title"><?php echo $this->lang->line('role'); ?> <?php echo $this->lang->line('list'); ?></h1>
</div>
     
<ul class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><?php echo $this->lang->line('home'); ?></a> <span class="divider">/</span></li>
            <li class="active"><?php echo $this->lang->line('permission_system'); ?></li><span class="divider">/</span></li>
            <li class="active"><?php echo $this->lang->line('role'); ?></li>
</ul>

<div class="container-fluid">
<div class="row-fluid">
 
<div class="btn-toolbar">
    <a class="btn btn-primary " href="<?php echo site_url('role/add') ?>"><i class="icon-plus"></i> <?php echo $this->lang->line('add'); ?></a>
  <div class="btn-group"></div>
</div>

<script src="lib/jquery.skygqbox.1.3.js" type="text/javascript"></script>

<div class="well">
    <table class="table table-hover ">
      <thead>
        <tr>
          <th>#</th>
          <th><?php echo $this->lang->line('role'); ?></th>
          <th><?php echo $this->lang->line('privilege'); ?></th>
          <th style="width: 30px;"></th>
        </tr>
      </thead>
      <tbody>
 <?php if(!empty($datalist)) {?>
 <?php foreach ($datalist  as $item):?>
     <tr>
          <td><?php echo $item['role_id'] ?></td>
          <td><?php echo $item['role_name'] ?></td>
          <td><a href="<?php echo site_url('auth/index/role_id/'.$item['role_id']) ?>" ><?php echo $this->lang->line('privilege_assignments'); ?></a></td>
          <td>
              <a href="<?php echo site_url('role/edit/'.$item['role_id']) ?>" title="<?php echo $this->lang->line('edit'); ?>" ><i class="icon-pencil"></i></a>&nbsp;
              <a href="<?php echo site_url('role/forever_delete/'.$item['role_id']) ?>" class="confirm_delete" title="<?php echo $this->lang->line('forever_delete'); ?>" ><i class="icon-remove"></i></a>
          </td>
     </tr>
 <?php endforeach;?>
<tr>
<td colspan="6">
<font color="#000000"><?php echo $this->lang->line('total_record'); ?> <?php echo $datacount; ?></font>
</td>
</tr>
 <?php }else{  ?>
<tr>
<td colspan="4">
<font color="red"><?php echo $this->lang->line('no_record'); ?> </font>
</td>
</tr>
<?php } ?>      
      </tbody>
    </table>
</div>


<script type="text/javascript">
	$(' .confirm_delete').click(function(){
		return confirm("<?php echo $this->lang->line('forever_delete_confirm'); ?>");	
	});
</script>


