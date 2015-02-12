<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="header">  
            <h1 class="page-title"><?php echo $this->lang->line('user'); ?> <?php echo $this->lang->line('list'); ?></h1>
</div>
     
<ul class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><?php echo $this->lang->line('home'); ?></a> <span class="divider">/</span></li>
            <li class="active"><?php echo $this->lang->line('permission_system'); ?></li><span class="divider">/</span></li>
            <li class="active"><?php echo $this->lang->line('user'); ?></li>
</ul>

<div class="container-fluid">
<div class="row-fluid">
 
<div class="btn-toolbar">
    <a class="btn btn-primary " href="<?php echo site_url('user/add') ?>"><i class="icon-plus"></i> <?php echo $this->lang->line('add'); ?></a>
  <div class="btn-group"></div>
</div>

<div class="well">
    <table class="table table-hover ">
      <thead>
        <tr>
          <th>#</th>
          <th><?php echo $this->lang->line('username'); ?></th>
          <th><?php echo $this->lang->line('realname'); ?></th>
          <th><?php echo $this->lang->line('email'); ?></th>
          <th><?php echo $this->lang->line('mobile'); ?></th>
          <th><?php echo $this->lang->line('login_count'); ?></th>
          <th><?php echo $this->lang->line('last_login_ip'); ?></th>
          <th><?php echo $this->lang->line('last_login_time'); ?></th>
          <th><?php echo $this->lang->line('role'); ?></th>
          <th style="width: 30px;"></th>
        </tr>
      </thead>
      <tbody>
 <?php if(!empty($datalist)) {?>
 <?php foreach ($datalist  as $item):?>
     <tr>
          <td><?php echo $item['user_id'] ?></td>
          <td><?php echo $item['username'] ?></td>
          <td><?php echo $item['realname'] ?></td>
          <td><?php echo $item['email'] ?></td>
          <td><?php echo $item['mobile'] ?></td>
          <td><?php echo $item['login_count'] ?></td>
          <td><?php echo $item['last_login_ip'] ?></td>
          <td><?php echo $item['last_login_time'] ?></td>
          <td><a href="<?php echo site_url('auth/index/user_id/'.$item['user_id']) ?>" ><?php echo $this->lang->line('role_assignments'); ?></a></td>
          <td>
              <a href="<?php echo site_url('user/edit/'.$item['user_id']) ?>" title="<?php echo $this->lang->line('edit'); ?>" ><i class="icon-pencil"></i></a>&nbsp;
              <a href="<?php echo site_url('user/forever_delete/'.$item['user_id']) ?>" class="confirm_delete" title="<?php echo $this->lang->line('forever_delete'); ?>" ><i class="icon-remove"></i></a>
          </td>
     </tr>
 <?php endforeach;?>
<tr>
<td colspan="10">
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