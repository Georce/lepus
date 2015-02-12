<div class="header">
            
            <h1 class="page-title">慢查询分析</h1>
</div>
        
<ul class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>">主页</a> <span class="divider">/</span></li>
            <li class="active">查询分析</li><span class="divider">/</span></li>
            <li class="active">慢查询分析</li>
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



<div class="ui-state-default ui-corner-all" style="height: 45px;" >
<p><span class="ui-icon ui-icon-search" style="float: left; margin-right: .3em;"></span>
                    
<form name="form" class="form-inline" method="get" action="<?php site_url('monitor/replication') ?>" >
  <input type="hidden" name="search" value="submit" />
  主机
  <select name="server_id" class="input-small" style="" >
  <?php foreach ($server as $item):?>
  <option value="<?php echo $item['id'];?>" <?php if($setval['server_id']==$item['id']) echo "selected"; ?> ><?php echo $item['host'];?>:<?php echo $item['port'];?></option>
   <?php endforeach;?>
  </select>
  最后执行时间
  <input class="Wdate" style="width:150px;" type="text" name="stime" id="start_time>" value="<?php echo $setval['stime'] ?>" onFocus="WdatePicker({doubleCalendar:false,isShowClear:false,readOnly:false,dateFmt:'yyyy-MM-dd HH:mm'})"/>
  <input class="Wdate" style="width:150px;" type="text" name="etime" id="end_time>" value="<?php echo $setval['etime'] ?>" onFocus="WdatePicker({doubleCalendar:false,isShowClear:false,readOnly:false,startDate:'1980-05-01',dateFmt:'yyyy-MM-dd HH:mm'})"/>
  
  排序
  <select name="order" class="input-small" style="width: 110px;">
  <option value="last_seen" <?php if($setval['order']=='last_seen') echo "selected"; ?> >last_seen</option>
  <option value="ts_cnt" <?php if($setval['order']=='ts_cnt') echo "selected"; ?> >ts_cnt</option>
  <option value="query_time_sum" <?php if($setval['order']=='query_time_sum') echo "selected"; ?> >query_time_sum</option>
  <option value="query_time_min" <?php if($setval['order']=='query_time_min') echo "selected"; ?> >query_time_min</option>
  <option value="query_time_max" <?php if($setval['order']=='query_time_max') echo "selected"; ?> >query_time_max</option>

  </select>
  <select name="order_type" class="input-small" style="width: 110px;">
  <option value="desc" <?php if($setval['order_type']=='desc') echo "selected"; ?> >降序</option>
  <option value="asc" <?php if($setval['order_type']=='asc') echo "selected"; ?> >升序</option>
  </select>
  
  <button type="submit" class="btn btn-success">检索</button>
  <a href="<?php echo site_url('monitor/replication') ?>" class="btn btn-warning">重置</a>

</form>                 
</div>

<div class="well">
    <table class="table table-hover table-condensed " style="font-size: 12px;">
      <thead>
        <tr>
		<th colspan="4"><center>SQL</center></th>
		<th colspan="3"><center>Query</center></th>
        <th colspan="3"><center>Lock</center></th>
        <th style="width: 26px;"></th>
	   </tr>
        <tr>
        <th>checksum</th>
        <th>fringerprint <span class="collapse_buttons" ><a href="#" class="show_all_message">展开所有</a> <a href="#" class="collpase_all_message">合并所有</a></span></th>
        <th>last_seen</th>
        <th>ts_cnt</th>
        <th>time_sum</th>
		<th>time_min</th>
        <th>time_max</th>
        <th>time_sum</th>
        <th>time_min</th>
		<th>time_max</th>
        <th style="width: 26px;"></th>
	   </tr>
      </thead>
      <tbody>
 
  <?php if(!empty($datalist)) {?>
 <?php foreach ($datalist  as $item):?>
    <tr>
        <td><a href="<?php echo site_url('slowquery/detail/'.$item['checksum'].'/'.$setval['server_id']) ?>" target="_blank"  title="点击进入详情"><?php  echo $item['checksum'] ?></a></td>
         <td>
         <div class="message_head"><span class="message_icon"><i class="icon-plus"></i></span><cite><?php echo substring($item['fingerprint'],0,40); ?>:</cite></div>
		<div class="message_body" style="width: 250px;">
			<pre><span style="color: blue;"><?php echo $item['fingerprint']; ?></span></pre>
		</div>
        
        <td><?php echo $item['last_seen'] ?></td>
        <td><?php echo $item['ts_cnt'] ?></td>
        <td><?php echo $item['Query_time_sum'] ?></td>
        <td><?php echo $item['Query_time_min'] ?></td>
        <td><?php echo $item['Query_time_max'] ?></td>
        <td><?php echo $item['Lock_time_sum'] ?></td>
        <td><?php echo $item['Lock_time_min'] ?></td>
        <td><?php echo $item['Lock_time_max'] ?></td>
        <td>
              <a href="<?php echo site_url('slowquery/index/'.$item['checksum']) ?>"><i class="icon-pencil"></i></a>
        </td>
	</tr>
 <?php endforeach;?>
<?php }else{  ?>
<tr>
<td colspan="10">
<font color="red">对不起,没有查询到相关数据！ 1.请确认是否添加主机信息; 2.请确认主机是否部署慢查询采集脚本并开启慢查询。</font>
</td>
</tr>
<?php } ?>

</tbody>
    </table>
</div>


