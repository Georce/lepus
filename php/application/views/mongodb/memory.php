<div class="header">
            
            <h1 class="page-title"><?php echo $this->lang->line('mongodb'); ?> <?php echo $this->lang->line('_Memory Monitor'); ?></h1>
</div>
        
<ul class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><?php echo $this->lang->line('home'); ?></a> <span class="divider">/</span></li>
            <li class="active"><?php echo $this->lang->line('_MongoDB Monitor'); ?></li><span class="divider">/</span></li>
            <li class="active"><?php echo $this->lang->line('_Memory Monitor'); ?></li>
            <span class="right"><?php echo $this->lang->line('the_latest_acquisition_time'); ?>:<?php if(!empty($datalist)){ echo $datalist[0]['create_time'];} else {echo $this->lang->line('the_monitoring_process_is_not_started');} ?></span>
</ul>

<div class="container-fluid">
<div class="row-fluid">
 
<script src="lib/bootstrap/js/bootstrap-switch.js"></script>
<link href="lib/bootstrap/css/bootstrap-switch.css" rel="stylesheet"/>
                    
<div class="ui-state-default ui-corner-all" style="height: 45px;" >
<p><span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-search"></span>                 
<form name="form" class="form-inline" method="get" action="" >
 
   <input type="text" id="host"  name="host" value="" placeholder="<?php echo $this->lang->line('please_input_host'); ?>" class="input-medium" >
  <input type="text" id="tags"  name="tags" value="" placeholder="<?php echo $this->lang->line('please_input_tags'); ?>" class="input-medium" >
  

  <button type="submit" class="btn btn-success"><i class="icon-search"></i> <?php echo $this->lang->line('search'); ?></button>
  <a href="<?php echo site_url('lp_mongodb/indexes') ?>" class="btn btn-warning"><i class="icon-repeat"></i> <?php echo $this->lang->line('reset'); ?></a>
  <button id="refresh" class="btn btn-info"><i class="icon-refresh"></i> <?php echo $this->lang->line('refresh'); ?></button>
</form>                 
</div>


<div class="well">
    <table class="table table-hover table-condensed ">
      <thead>

        <tr style="font-size: 12px;">
        <th><?php echo $this->lang->line('host'); ?></th> 
        <th><?php echo $this->lang->line('tags'); ?></th> 
		<th><?php echo $this->lang->line('mem_bits'); ?></th>
        <th><?php echo $this->lang->line('mem_resident'); ?></th>
		<th><?php echo $this->lang->line('mem_virtual'); ?></th>
		<th><?php echo $this->lang->line('mem_supported'); ?></th>
        <th><?php echo $this->lang->line('mem_mapped'); ?></th>
        <th><?php echo $this->lang->line('mem_mappedWithJournal'); ?></th>
        <th><?php echo $this->lang->line('chart'); ?></th>
	    </tr>
      </thead>
      <tbody>
 <?php if(!empty($datalist)) {?>
 <?php foreach ($datalist  as $item):?>
    <tr style="font-size: 12px;">
        <td><?php echo $item['host'] ?>:<?php echo $item['port'] ?></td>
		<td><?php echo $item['tags'] ?></td>
        <td><?php echo $item['mem_bits'] ?></td>
        <td><?php echo format_mbytes($item['mem_resident']) ?></td>
        <td><?php echo format_mbytes($item['mem_virtual']) ?></td>
        <td><?php echo check_status($item['mem_supported']) ?></td>
        <td><?php echo format_mbytes($item['mem_mapped']) ?></td>
        <td><?php echo format_mbytes($item['mem_mappedWithJournal']) ?></td>
        <td><a href="<?php echo site_url('lp_mongodb/chart/'.$item['server_id']) ?>"><img src="./images/chart.gif"/></a></a></td>
     </tr>
 <?php endforeach;?>
 <?php }else{  ?>
<tr>
<td colspan="9">
<font color="red"><?php echo $this->lang->line('no_record'); ?></font>
</td>
</tr>
<?php } ?>      
      </tbody>
    </table>
</div>

 <script type="text/javascript">
    $('#refresh').click(function(){
        document.location.reload(); 
    })
 </script>

