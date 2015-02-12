<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="header">  
            <h1 class="page-title"><?php echo $this->lang->line('menu'); ?> <?php echo $this->lang->line('list'); ?></h1>
</div>
     
<ul class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><?php echo $this->lang->line('home'); ?></a> <span class="divider">/</span></li>
            <li class="active"><?php echo $this->lang->line('permission_system'); ?></li><span class="divider">/</span></li>
            <li class="active"><?php echo $this->lang->line('menu'); ?></li>
</ul>

<div class="container-fluid">
<div class="row-fluid">
 
<div class="btn-toolbar">
    <a class="btn btn-primary " href="<?php echo site_url('menu/add') ?>"><i class="icon-plus"></i> <?php echo $this->lang->line('add'); ?></a>
  <div class="btn-group"></div>
</div>

<div class="well">
    <table class="table table-hover ">
      <thead>
        <tr>
          <th><?php echo $this->lang->line('menu'); ?></th>
          <th><?php echo $this->lang->line('url'); ?></th>
          <th><?php echo $this->lang->line('icon'); ?></th>
          <th><?php echo $this->lang->line('display'); ?></th>
          <th><?php echo $this->lang->line('display_order'); ?></th>
          <th style="width: 30px;"></th>
        </tr>
      </thead>
      <tbody>
 <?php if(!empty($datalist)) {?>
 <?php foreach ($datalist  as $item):?>
     <tr>
          <td><?php echo $item['str_repeat'] ?><?php echo $item['menu_title'] ?></td>
          <td><?php echo $item['menu_url'] ?></td>
          <td><?php echo $item['menu_icon'] ?></td>
          <td><?php echo check_status($item['status']) ?></td>
          <td><?php echo $item['display_order'] ?></td>
          <td>
              <a href="<?php echo site_url('menu/edit/'.$item['menu_id']) ?>" title="<?php echo $this->lang->line('edit'); ?>" ><i class="icon-pencil"></i></a>&nbsp;
              <a href="<?php echo site_url('menu/forever_delete/'.$item['menu_id']) ?>" class="confirm_delete" title="<?php echo $this->lang->line('forever_delete'); ?>" ><i class="icon-remove"></i></a>
          </td>
     </tr>
 <?php endforeach;?>
 <?php }else{  ?>
<tr>
<td colspan="6">
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