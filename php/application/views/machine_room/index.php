<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="header">  
            <h1 class="page-title"><?php echo $this->lang->line('_Machine Room'); ?> <?php echo $this->lang->line('list'); ?></h1>
</div>
     
<ul class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><?php echo $this->lang->line('home'); ?></a> <span class="divider">/</span></li>
            <li class="active"><?php echo $this->lang->line('_Servers Configure'); ?><span class="divider">/</span></li>
            <li class="active"><?php echo $this->lang->line('_Machine Room'); ?></li>
</ul>

<div class="container-fluid">
<div class="row-fluid">
 
<div class="btn-toolbar">
    <a class="btn btn-primary " href="<?php echo site_url('machine_room/add') ?>"><i class="icon-plus"></i> <?php echo $this->lang->line('add'); ?></a>
  <div class="btn-group"></div>
</div>

<div class="well">
    <table class="table table-hover ">
      <thead>
        <tr>
          <th><?php echo $this->lang->line('name'); ?></th>
          <th><?php echo $this->lang->line('machine_room_address'); ?></th>
          <th><?php echo $this->lang->line('on_duty_tel'); ?></th>
          <th><?php echo $this->lang->line('remark'); ?></th>
		  <th><?php echo $this->lang->line('enabled'); ?></th>
          <th style="width: 30px;"></th>
        </tr>
      </thead>
      <tbody>
 <?php if(!empty($datalist)) {?>
 <?php foreach ($datalist  as $item):?>
    <tr>
		<td><strong><?php echo $item['name'] ?></strong></td>
        <td><?php echo $item['address'] ?></td>
        <td><?php echo $item['on_duty_tel'] ?></td>
        <td><?php echo $item['remark'] ?></td>
		<td><?php echo check_status($item['status']) ?></td>
        <td><a href="<?php echo site_url('machine_room/edit/'.$item['id']) ?>"  title="<?php echo $this->lang->line('edit'); ?>" ><i class="icon-pencil"></i></a>&nbsp;
        <a href="<?php echo site_url('machine_room/forever_delete/'.$item['id']) ?>" class="confirm_delete" title="<?php echo $this->lang->line('forever_delete'); ?>" ><i class="icon-remove"></i></a>
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
<font color="red"><?php echo $this->lang->line('no_record'); ?></font>
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