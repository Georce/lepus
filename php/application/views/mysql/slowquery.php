<div class="header">            
            <h1 class="page-title"><?php echo $this->lang->line('_MySQL'); ?> <?php echo $this->lang->line('_Slowquery Analysis'); ?></h1>
</div>
        
<ul class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><?php echo $this->lang->line('home'); ?></a> <span class="divider">/</span></li>
            <li class="active"><?php echo $this->lang->line('_MySQL Monitor'); ?></li><span class="divider">/</span></li>
            <li class="active"><?php echo $this->lang->line('_Slowquery Analysis'); ?></li>
</ul>

<div class="container-fluid">
<div class="row-fluid">
 
<script type="text/javascript">
$(document).ready(function(){
  
	//hide message_body after the first one
	//$(".table .message_body:gt(0)").hide();
    $(".table .message_body").hide();
	$(".collpase_all_message").hide();
	
	//toggle message_body
	$(".message_head").click(function(){
		$(this).next(".message_body").slideToggle(200)
		return false;
	});

    //collapse all messages
	$(".collpase_all_message").click(function(){
	   		$(this).hide()
		$(".show_all_message").show()
		$(".message_body").slideUp(200)
		return false;
	});

	//show all messages
	$(".show_all_message").click(function(){
		$(this).hide()
		$(".collpase_all_message").show()
		$(".message_body").slideDown()
		return false;
	});

});

</script>
<style type="text/css">

/* message display page */

.message_head {
	padding: 2px 5px;
	cursor: pointer;
	position: relative;
}

.message_head cite {
	font-size: 100%;
	font-weight: bold;
	font-style: normal;
}

</style>

<script language="javascript" src="./lib/DatePicker/WdatePicker.js"></script>

<div class="ui-state-default ui-corner-all" style="height: 45px;" >
<p><span class="ui-icon ui-icon-search" style="float: left; margin-right: .3em;"></span>
                    
<form name="form" class="form-inline" method="get" action="<?php site_url('lp_mysql/slowquery') ?>" >
  <input type="hidden" name="search" value="submit" />
  
  <select name="server_id" class="input-large" style="width:230px"  >
  <option value=""><?php echo $this->lang->line('host'); ?></option>
  <?php foreach ($server as $item):?>
  <option value="<?php echo $item['id'];?>" <?php if($setval['server_id']==$item['id']) echo "selected"; ?> ><?php echo $item['host'];?>:<?php echo $item['port'];?>(<?php echo $item['tags'];?>)</option>
   <?php endforeach;?>
  </select>
  

  
  <?php echo $this->lang->line('time'); ?>
  <input class="Wdate" style="width:130px;" type="text" name="stime" id="start_time>" value="<?php echo $setval['stime'] ?>" onFocus="WdatePicker({doubleCalendar:false,isShowClear:false,readOnly:false,dateFmt:'yyyy-MM-dd HH:mm'})"/> -
  <input class="Wdate" style="width:130px;" type="text" name="etime" id="end_time>" value="<?php echo $setval['etime'] ?>" onFocus="WdatePicker({doubleCalendar:false,isShowClear:false,readOnly:false,startDate:'1980-05-01',dateFmt:'yyyy-MM-dd HH:mm'})"/>
  
  <?php echo $this->lang->line('sort'); ?>
  <select name="order" class="input-small" style="width: 130px;">
  <option value="last_seen" <?php if($setval['order']=='last_seen') echo "selected"; ?> ><?php echo $this->lang->line('last_seen'); ?></option>
  <option value="ts_cnt" <?php if($setval['order']=='ts_cnt') echo "selected"; ?> ><?php echo $this->lang->line('ts_cnt'); ?></option>
  <option value="query_time_sum" <?php if($setval['order']=='query_time_sum') echo "selected"; ?> ><?php echo $this->lang->line('query_time'); ?>(<?php echo $this->lang->line('sum'); ?>)</option>
  <option value="query_time_min" <?php if($setval['order']=='query_time_min') echo "selected"; ?> ><?php echo $this->lang->line('query_time'); ?>(<?php echo $this->lang->line('min'); ?>)</option>
  <option value="query_time_max" <?php if($setval['order']=='query_time_max') echo "selected"; ?> ><?php echo $this->lang->line('query_time'); ?>(<?php echo $this->lang->line('max'); ?>)</option>
  <option value="lock_time_sum" <?php if($setval['order']=='lock_time_sum') echo "selected"; ?> ><?php echo $this->lang->line('lock_time'); ?>(<?php echo $this->lang->line('sum'); ?>)</option>

  </select>
  <select name="order_type" class="input-small" style="width:80px;">
  <option value="desc" <?php if($setval['order_type']=='desc') echo "selected"; ?> ><?php echo $this->lang->line('desc'); ?></option>
  <option value="asc" <?php if($setval['order_type']=='asc') echo "selected"; ?> ><?php echo $this->lang->line('asc'); ?></option>
  </select>
  
  <button type="submit" class="btn btn-success"><i class="icon-search"></i> <?php echo $this->lang->line('search'); ?></button>
  <a href="<?php echo site_url('lp_mysql/slowquery') ?>" class="btn btn-warning"><i class="icon-repeat"></i> <?php echo $this->lang->line('reset'); ?></a>

  <!--添加一个空的表单变量让URL中order_type=desc?noparam=0变成order_type=desc&noparam=0?，使order by生效  -->
  <input type="hidden" name="noparam" value="0" />
</form>                 
</div>

<div class="well">
    <table class="table table-hover table-condensed " style="font-size: 12px;">
      <thead>
        <tr>
		<th colspan="5"><center><?php echo $this->lang->line('sql'); ?></center></th>
		<th colspan="3"><center><?php echo $this->lang->line('query_time'); ?> </center></th>
        <th colspan="3"><center><?php echo $this->lang->line('lock_time'); ?> </center></th>
	   </tr>
        <tr>
        <th><?php echo $this->lang->line('checksum'); ?></th>
        <th><?php echo $this->lang->line('fringerprint'); ?> <span class="collapse_buttons" ><a href="#" class="show_all_message"><?php echo $this->lang->line('expand_all'); ?></a> <a href="#" class="collpase_all_message"><?php echo $this->lang->line('merge_all'); ?></a></span></th>
        <th><?php echo $this->lang->line('database'); ?></th>
        <th><?php echo $this->lang->line('user'); ?></th>
        <th><?php echo $this->lang->line('last_seen'); ?></th>
        <th><?php echo $this->lang->line('ts_cnt'); ?></th>
        <th><?php echo $this->lang->line('avg'); ?></th>
		<th><?php echo $this->lang->line('min'); ?></th>
        <th><?php echo $this->lang->line('max'); ?></th>
        <th><?php echo $this->lang->line('sum'); ?></th>
        <th><?php echo $this->lang->line('min'); ?></th>
		<th><?php echo $this->lang->line('max'); ?></th>
	   </tr>
      </thead>
      <tbody>
 
  <?php if(!empty($datalist)) {?>
 <?php foreach ($datalist  as $item):?>
    <tr>
        <td><a href="<?php echo site_url('lp_mysql/slowquery_detail/'.$item['checksum']) ?>" target="_blank"  title="<?php echo $this->lang->line('view_detail'); ?>"><?php  echo $item['checksum'] ?></a></td>
         <td>
         
         <div class="message_head"><span class="message_icon"><i class="icon-plus"></i></span><cite><?php echo substring($item['fingerprint'],0,35); ?>:</cite></div>
		<div class="message_body" style="width: 200px;">
			<pre><span style="color: blue;"><?php echo $item['fingerprint']; ?></span></pre>
		</div>
        <td><?php echo $item['db_max'] ?></td>
        <td><?php echo $item['user_max'] ?></td>
        <td><?php echo $item['last_seen'] ?></td>
        <td><?php echo $item['ts_cnt'] ?></td>
        <td><?php echo substring($item['Query_time_avg'],0,5) ?></td>
        <td><?php echo substring($item['Query_time_min'],0,5) ?></td>
        <td><?php echo substring($item['Query_time_max'],0,5) ?></td>
        <td><?php echo substring($item['Lock_time_sum'],0,6) ?></td>
        <td><?php echo substring($item['Lock_time_min'],0,7) ?></td>
        <td><?php echo substring($item['Lock_time_max'],0,7) ?></td>
	</tr>
 <?php endforeach;?>
<?php }else{  ?>
<tr>
<td colspan="10">
<font color="red"><?php echo $this->lang->line('no_record'); ?></font>
</td>
</tr>
<?php } ?>

</tbody>
    </table>
</div>

<div class="" style="margin-top: 8px;padding: 8px;">
<center><?php echo $this->pagination->create_links(); ?></center>
</div>
