<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="header">
    <div class="stats">
    <p class="stat"><span class="number"><?php echo $os_statistics['os_snmp_up']+$os_statistics['os_snmp_down']?></span>OS</p>
    <p class="stat"><span class="number"><?php echo $mongodb_statistics['mongodb_servers_up']+$mongodb_statistics['mongodb_servers_down']?></span>MongoDB</p>
    <p class="stat"><span class="number"><?php echo $mysql_statistics['mysql_servers_up']+$mysql_statistics['mysql_servers_down']?></span>MySQL</p>
    </div>
<h1 class="page-title"><?php echo $this->lang->line('dashboard'); ?></h1>
</div>
        
<ul class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><?php echo $this->lang->line('home'); ?></a> <span class="divider">/</span></li>
            <li class="active"><?php echo $this->lang->line('dashboard'); ?></li><span class="divider">/</span></li>
            <span class="right"><?php echo $this->lang->line('lepus_version'); ?>:<?php echo $lepus_status['lepus_version']['value']; ?>&nbsp;&nbsp; <?php echo $this->lang->line('lepus_status'); ?>:<?php if($lepus_status['lepus_running']['value']==1){ ?><span class="label label-success"><?php echo $this->lang->line('lepus_running'); ?></span><?php }else{?><span class="label label-important"><?php echo $this->lang->line('lepus_not_run'); ?></span><?php } ?>&nbsp;&nbsp; <?php echo $this->lang->line('last_check_time'); ?>:<?php echo $lepus_status['lepus_running']['update_time']; ?></span>
</ul>

 
 
 


<div class="container-fluid">
 <div class="row-fluid">
 
  <div id="mysql_servers_health" style="margin-top:5px; margin-right:10px; width:320px; height:240px; float:left;"></div>

  <div id="mongodb_servers_health" style="margin-top:5px; margin-right:10px; width:320px; height:240px;float:left;"></div>
  <div id="os_snmp_health" style="margin-top:5px; margin-right:10px; width:320px; height:240px;float:left;"></div>
  
  <div style="clear:both;"></div>
    <div class="block">
    <a href="#last-stats" class="block-heading" data-toggle="collapse"><?php echo $this->lang->line('last_alarm'); ?></a>
    <div id="last-stats" class="block-body collapse in">
    <table class="table table-hover table-condensed" style="font-size: 12px;">
      <thead>
        <th><?php echo $this->lang->line('host'); ?></th>
        <th><?php echo $this->lang->line('application'); ?></th>
        <th><?php echo $this->lang->line('db_type'); ?></th>
        <th><?php echo $this->lang->line('level'); ?></th>
        <th><?php echo $this->lang->line('message'); ?></th>
        <th><?php echo $this->lang->line('value'); ?></th>
        <th><?php echo $this->lang->line('monitor_time'); ?></th>
        <th><?php echo $this->lang->line('send_mail'); ?></th>
        <th><?php echo $this->lang->line('send_success'); ?></th>
      </thead>
      <tbody>
<?php if(!empty($last_alarmlist)) {?>
 <?php foreach ($last_alarmlist  as $item):?>
    <tr class="warning">
		<td><?php echo $item['host'].":".$item['port'] ?></td>
        <td><?php echo $item['application'] ?></td>
        <td><?php echo $item['db_type'] ?></td>
        <td><?php if($item['level']=='critical'){ ?> <span class="label label-important"><?php echo $this->lang->line('critical'); ?></span> <?php }else if($item['level']=='warning'){  ?><span class="label label-warning"><?php echo $this->lang->line('warning'); ?></span> <?php }else{?> <span class="label label-success"><?php echo $this->lang->line('ok'); ?></span>  <?php } ?></td>
        <td><?php echo $item['message'] ?></td>
        <td><span class="label label-info"><?php echo $item['alarm_value']  ?></span></td>
        <td><?php echo $item['create_time'] ?></td>
        <td><?php echo check_mail($item['send_mail']) ?></td>
        <td><?php echo check_mail($item['send_mail_status']) ?></td>
 
	</tr>
 <?php endforeach;?>
<?php }else{  ?>
<tr>
<td colspan="12">
<font color="red"><?php echo $this->lang->line('no_record'); ?></font>
</td>
</tr>
<?php } ?>     
      </tbody>
    </table>
    </div>
    </div>
                    
    

      
 


 <!-- 饼状图 --> 
<script type="text/javascript" src="./lib/jqplot/jquery.jqplot.min.js"></script>
<script type="text/javascript" src="./lib/jqplot/plugins/jqplot.pieRenderer.min.js"></script>
<script type="text/javascript" src="./lib/jqplot/plugins/jqplot.donutRenderer.min.js"></script>
 <!-- 柱状图 -->
<script type="text/javascript" src="./lib/jqplot/plugins/jqplot.dateAxisRenderer.min.js"></script> 
<script type="text/javascript" src="./lib/jqplot/plugins/jqplot.canvasTextRenderer.min.js"></script>
<script type="text/javascript" src="./lib/jqplot/plugins/jqplot.canvasAxisTickRenderer.min.js"></script>
<script type="text/javascript" src="./lib/jqplot/plugins/jqplot.categoryAxisRenderer.min.js"></script>
<script type="text/javascript" src="./lib/jqplot/plugins/jqplot.barRenderer.min.js"></script>
<link href="./lib/jqplot/jquery.jqplot.min.css"  rel="stylesheet">


<script>
//########################## mysql_Health ##################################
$(document).ready(function(){
  var data = [
    ["<?php echo $this->lang->line('up'); ?>(<?php echo $mysql_statistics['mysql_servers_up']; ?>)", <?php echo $mysql_statistics['mysql_servers_up']; ?>],["<?php echo $this->lang->line('down'); ?>(<?php echo $mysql_statistics['mysql_servers_down']; ?>)", <?php echo $mysql_statistics['mysql_servers_down'];?> ]
  ];
  var plot1 = jQuery.jqplot ('mysql_servers_health', [data], 
    { 
      title: {  
        text: "MySQL <?php echo $this->lang->line('servers'); ?>(<?php echo $mysql_statistics['mysql_servers_up']+$mysql_statistics['mysql_servers_down']?>)",  //        设置当前图的标题  
        show: true,//设置当前标题是否显示 
        fontSize:'13px',    //刻度值的字体大小  
      },
      seriesDefaults: {
        // Make this a pie chart.
        renderer: jQuery.jqplot.PieRenderer, 
        rendererOptions: {
          diameter: undefined, // 设置饼的直径
            padding: 15,        // 饼距离其分类名称框或者图表边框的距离，变相该表饼的直径
            sliceMargin: 0,     // 饼的每个部分之间的距离
            fill:true,         // 设置饼的每部分被填充的状态
            shadow:true,       //为饼的每个部分的边框设置阴影，以突出其立体效果
            shadowOffset: 2,    //设置阴影区域偏移出饼的每部分边框的距离
            shadowDepth: 5,     // 设置阴影区域的深度
            shadowAlpha: 0.07,   // 设置阴影区域的透明度
          showDataLabels: true
        }
      },
      seriesColors: [ "#66CC33","#FF3333"],  // 默认显示的分类颜色 
      legend: { show:true, location: 'ne' }
    }
  );
});


//########################## mongodb_Health ##################################
$(document).ready(function(){
  var data = [
    ["<?php echo $this->lang->line('up'); ?>(<?php echo $mongodb_statistics['mongodb_servers_up']; ?>)", <?php echo $mongodb_statistics['mongodb_servers_up']; ?>],["<?php echo $this->lang->line('down'); ?>(<?php echo $mongodb_statistics['mongodb_servers_down']; ?>)", <?php echo $mongodb_statistics['mongodb_servers_down'];?> ]
  ];
  var plot1 = jQuery.jqplot ('mongodb_servers_health', [data], 
    { 
      title: {  
        text: "MongoDB <?php echo $this->lang->line('servers'); ?>(<?php echo $mongodb_statistics['mongodb_servers_up']+$mongodb_statistics['mongodb_servers_down']?>)",  //        设置当前图的标题  
        show: true,//设置当前标题是否显示 
        fontSize:'13px',    //刻度值的字体大小  
      },
      seriesDefaults: {
        // Make this a pie chart.
        renderer: jQuery.jqplot.PieRenderer, 
        rendererOptions: {
          diameter: undefined, // 设置饼的直径
            padding: 15,        // 饼距离其分类名称框或者图表边框的距离，变相该表饼的直径
            sliceMargin: 0,     // 饼的每个部分之间的距离
            fill:true,         // 设置饼的每部分被填充的状态
            shadow:true,       //为饼的每个部分的边框设置阴影，以突出其立体效果
            shadowOffset: 2,    //设置阴影区域偏移出饼的每部分边框的距离
            shadowDepth: 5,     // 设置阴影区域的深度
            shadowAlpha: 0.07,   // 设置阴影区域的透明度
          showDataLabels: true
        }
      },
      seriesColors: [ "#66CC33","#FF3333"],  // 默认显示的分类颜色 
      legend: { show:true, location: 'ne' }
    }
  );
});

//########################## os_snmp_Health ##################################
$(document).ready(function(){
  var data = [
    ["<?php echo $this->lang->line('up'); ?>(<?php echo $os_statistics['os_snmp_up']; ?>)", <?php echo $os_statistics['os_snmp_up']; ?>],["<?php echo $this->lang->line('down'); ?>(<?php echo $os_statistics['os_snmp_down']; ?>)", <?php echo $os_statistics['os_snmp_down'];?> ]
  ];
  var plot1 = jQuery.jqplot ('os_snmp_health', [data], 
    { 
      title: {  
        text: "OS SNMP <?php echo $this->lang->line('servers'); ?>(<?php echo $os_statistics['os_snmp_up']+$os_statistics['os_snmp_down']?>)",  //        设置当前图的标题  
        show: true,//设置当前标题是否显示 
        fontSize:'13px',    //刻度值的字体大小  
      },
      seriesDefaults: {
        // Make this a pie chart.
        renderer: jQuery.jqplot.PieRenderer, 
        rendererOptions: {
          diameter: undefined, // 设置饼的直径
            padding: 15,        // 饼距离其分类名称框或者图表边框的距离，变相该表饼的直径
            sliceMargin: 0,     // 饼的每个部分之间的距离
            fill:true,         // 设置饼的每部分被填充的状态
            shadow:true,       //为饼的每个部分的边框设置阴影，以突出其立体效果
            shadowOffset: 2,    //设置阴影区域偏移出饼的每部分边框的距离
            shadowDepth: 5,     // 设置阴影区域的深度
            shadowAlpha: 0.07,   // 设置阴影区域的透明度
          showDataLabels: true
        }
      },
      seriesColors: [ "#66CC33","#FF3333"],  // 默认显示的分类颜色 
      legend: { show:true, location: 'ne' }
    }
  );
});



</script>