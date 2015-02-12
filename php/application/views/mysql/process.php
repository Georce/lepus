
<div class="header">
            <h1 class="page-title"><?php echo $this->lang->line('_Process Monitor'); ?></h1>
</div>
        
<ul class="breadcrumb">
            <li><a href=""><?php echo $this->lang->line('home'); ?></a> <span class="divider">/</span></li>
            <li class="active"><?php echo $this->lang->line('_MySQL Monitor'); ?></li><span class="divider">/</span></li>
            <li class="active"><?php echo $this->lang->line('_Process Monitor'); ?></li>
            <span class="right"><?php echo $this->lang->line('the_latest_acquisition_time'); ?>:<?php if(!empty($datalist)){ echo $datalist[0]['create_time'];} else {echo $this->lang->line('the_monitoring_process_is_not_started');} ?></span>
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

<script src="lib/bootstrap/js/bootstrap-switch.js"></script>
<link href="lib/bootstrap/css/bootstrap-switch.css" rel="stylesheet"/>

<div class="ui-state-default ui-corner-all" style="height: 45px;" >
<p><span class="ui-icon ui-icon-search" style="float: left; margin-right: .3em;"></span>
                    
<form name="form" class="form-inline" method="get" action="<?php site_url('monitor/replication') ?>" >
  <input type="hidden" name="search" value="submit" />
  
  <select name="application_id" class="input-small" style="width: 120px;">
  <option value=""><?php echo $this->lang->line('application'); ?></option>
  <?php foreach ($application  as $item):?>
  <option value="<?php echo $item['id'];?>" <?php if($setval['application_id']==$item['id']) echo "selected"; ?> ><?php echo $item['display_name'] ?></option>
   <?php endforeach;?>
  </select>
  
  <select name="server_id" class="input-small"  style="width: 120px;" >
  <option value=""><?php echo $this->lang->line('host'); ?></option>
  <?php foreach ($server as $item):?>
  <option value="<?php echo $item['id'];?>" <?php if($setval['server_id']==$item['id']) echo "selected"; ?> ><?php echo $item['host'];?>:<?php echo $item['port'];?></option>
   <?php endforeach;?>
  </select>

  <select name="sleep" class="input-small" style="width: 120px;">
  <option value="0" <?php if($setval['sleep']=='0') echo "selected"; ?> ><?php echo $this->lang->line('running'); ?></option>
  <option value="1" <?php if($setval['sleep']=='1') echo "selected"; ?> ><?php echo $this->lang->line('sleep'); ?></option>
  </select>
 
  <button type="submit" class="btn btn-success"><i class="icon-search"></i> <?php echo $this->lang->line('search'); ?></button>
  <a href="<?php echo site_url('lp_mysql/process') ?>" class="btn btn-warning"><i class="icon-repeat"></i> <?php echo $this->lang->line('reset'); ?></a>
  &nbsp;
  <label class="checkbox"><div id="toggle-state-switch-button" class="btn btn-info"><i class="icon-refresh"></i> <?php echo $this->lang->line('auto_refresh'); ?></div>
    <div id="toggle-state-switch" class="make-switch" data-on="success" data-off="danger" data-on-label="ON" data-text-label="">
    <input type="checkbox" name="reflesh" id="reflesh" value="" checked="checked" >
    </div>
  </label>

</form>                 
</div>

<div class="well">
    <table class="table table-hover table-condensed ">
      <thead>
        <tr style="font-size: 12px;">
        <th><?php echo $this->lang->line('id'); ?></th>
        <th><?php echo $this->lang->line('user'); ?></th>
        <th><?php echo $this->lang->line('machine'); ?></th>
        <th><?php echo $this->lang->line('db'); ?></th>
        <th><?php echo $this->lang->line('command'); ?></th>
        <th><?php echo $this->lang->line('time'); ?></th>
        <th><?php echo $this->lang->line('status'); ?></th>
        <th ><?php echo $this->lang->line('query'); ?> <span class="collapse_buttons" ><a href="#" class="show_all_message"><?php echo $this->lang->line('expand_all'); ?></a> <a href="#" class="collpase_all_message"><?php echo $this->lang->line('merge_all'); ?></a></span></th>         
        <th><?php echo $this->lang->line('end'); ?></th>
	    </tr>
      </thead>
      <tbody>
<?php if(!empty($datalist)) {?>
 <?php foreach ($datalist  as $item):?>
    <tr style="font-size: 12px;">
        <td><?php echo $item['pid'] ?></td>
        <td><?php echo $item['user'] ?></td>
        <td><?php echo substring($item['host'],0,30) ?></td>
        <td><?php echo $item['db'] ?></td>
        <td><?php echo $item['command'] ?></td>
        <td><?php echo $item['time'] ?>&nbsp;</td>
        <td><?php echo $item['status'] ?>&nbsp;</td>
        <td>
		<div class="message_head"><span class="message_icon"><i class="icon-plus"></i></span><cite><?php echo substring($item['info'],0,25); ?>:</cite></div>
		<div class="message_body" style="width: 210px;">
			<pre><span style="color: blue;"><?php echo $item['info']; ?></span></pre>
		</div>
        </td>
        <td>
        <?php if($option_kill_process==1){ ?>
            <div class="<?php echo $item['pid'] ?>"><a href="javascript::(0)" ondblclick="kill_process(<?php echo $item['server_id'] ?>,<?php echo $item['pid'] ?>)" class="btn-danger btn-mini  btn"><?php echo $this->lang->line('end'); ?></a></div>
        <?php }else{ ?>
        <button class='btn btn-mini btn-info disabled' type='button'><?php echo $this->lang->line('disable'); ?></button>
        <?php } ?>
        </td>
	</tr>

 <?php endforeach;?>
<?php }else{  ?>
<tr>
<td colspan="11">
<font color="red"><?php echo $this->lang->line('no_record'); ?></font>
</td>
</tr>
<?php } ?>	    
      </tbody>
    </table>
</div>


 <script type="text/javascript">
  
  $('#toggle-state-switch').bootstrapSwitch('toggleState');
  $('#toggle-state-switch').bootstrapSwitch('setState', true); // true || false
    
    function reflesh(){
        //var check_status=$("#reflesh").attr("checked");
        //alert(check_status);
        var arrays = new Array();   //创建一个数组对象
        var items = document.getElementsByName("reflesh");  //获取name为check的一组元素(checkbox)
        for(i=0; i < items.length; i++){  //循环这组数据
	       if(items[i].checked){      //判断是否选中
		    arrays.push(items[i].value);  //把符合条件的 添加到数组中. push()是javascript数组中的方法.
	       }
        }
        //alert( "选中的个数为："+arrays.length  );
        check_count=arrays.length;

        if (check_count==1){ //判断选择框是否选中
                document.location.reload();    
        }
	}
	setInterval("reflesh()",10*1000);//每10秒钟刷新一次 
    </script>
    
    
<script type="text/javascript">
function kill_process(server_id,pid){
    if(server_id=='' || pid==''){
        alert("进程异常，请重试！");
    }
    else{
        $.ajax({   
		  type:"GET",   
			  url:"<?php echo site_url('lp_mysql/ajax_kill_process') ?>",
			  data:{
				  server_id: server_id, pid: pid
				  },   
			  beforeSend:function(){
				  	$("."+pid).html("<button class='btn btn-mini btn-info' type='button'>正在结束</button>");
				  },                
			  success:function(data){
				//alert(data);
				switch(data)
				{
					case 'empty':
						alert("进程号或服务器号丢失,请重试");
						break
					case 'success':
						//alert('info');
                        $("."+pid).html("<button class='btn btn-mini btn-success disabled' type='button'>In Killed</button>");
                        setInterval("reflesh_mtop()",5*1000);
						return true;
						break
					default:
						alert ('发生未知异常，请联系管理员');
				}
				return false;			
			}               
         });   
		return false;

    }

}


function reflesh_mtop(){
    document.location.reload();    
}

</script>
