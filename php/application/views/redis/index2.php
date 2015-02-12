<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="header">
            
            <h1 class="page-title"><?php echo $this->lang->line('_Redis'); ?> <?php echo $this->lang->line('_Overview'); ?></h1>
</div>
        
<ul class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><?php echo $this->lang->line('home'); ?></a> <span class="divider">/</span></li>
            <li class="active"><?php echo $this->lang->line('_Redis Monitor'); ?></li><span class="divider">/</span></li>
            <li class="active"><?php echo $this->lang->line('_Overview'); ?></li>
            
</ul>

<div class="container-fluid">
 <div class="row-fluid">
 

    <table class="table  table-striped  table-bordered table-condensed"  >
	<tr class="info">
        <th><center>Redis <?php echo $this->lang->line('status'); ?></center></th>
        <th><center>Redis <?php echo $this->lang->line('version'); ?></center></th>
	</tr>
    <tr style="font-size: 13px;" class="">
       <td><div id="redis_servers_health" style="margin-top:5px; margin-left:0px; width:500px; height:350px;"></div></td>
       <td><div id="redis_versions" style="margin-top:5px; margin-left:0px; width:500px; height:350px;"></div></td>
	</tr>
   
  <tr class="info">
        <th><center>Redis Connected Clients Top10</center></th>
        <th><center>Redis Used Memory Top10</center></th>
	</tr>
    <tr style="font-size: 13px;" class="">
       <td><div id="redis_connected_clients_ranking" style="margin-top:5px; margin-left:0px; width:500px; height:350px;"></div></td>
       <td><div id="redis_used_memory_ranking" style="margin-top:5px; margin-left:0px; width:500px; height:350px;"></div></td>
	</tr>
   </table>

      
 

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

//########################## Redis_Health ##################################
$(document).ready(function(){
  var data = [
    ["<?php echo $this->lang->line('up'); ?>(<?php echo $redis_statistics['redis_servers_up']; ?>)", <?php echo $redis_statistics['redis_servers_up']; ?>],["<?php echo $this->lang->line('down'); ?>(<?php echo $redis_statistics['redis_servers_down']; ?>)", <?php echo $redis_statistics['redis_servers_down'];?> ]
  ];
  var plot1 = jQuery.jqplot ('redis_servers_health', [data], 
    { 
      title: {  
        text: "",  //        设置当前图的标题  
        show: false,//设置当前标题是否显示 
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

//########################## version ##################################
$(document).ready(function(){
  var data = [
  <?php if(!empty($redis_versions)) { foreach($redis_versions as $item){ ?>
    ["<?php echo $item['versions']?>(<?php echo $item['num']?>)", <?php echo $item['num']?> ],
  <?php }}else{ ?>
    ["no version data", 0 ]
  <?php } ?>
  ];
  var plot1 = jQuery.jqplot ('redis_versions', [data], 
    { 
      seriesDefaults: {
        // Make this a pie chart.
        renderer: jQuery.jqplot.PieRenderer, 
        rendererOptions: {
          // Put data labels on the pie slices.
          // By default, labels show the percentage of the slice.
          showDataLabels: true
        }
      }, 
      legend: { show:true, location: 'e' }
    }
  );
});


//########################## Redis_connected_clients_ranking ##################################
$(document).ready(function(){
  var data = [
  <?php if(!empty($redis_connected_clients_ranking)) { foreach($redis_connected_clients_ranking as $item){ ?>
    ["<?php echo $item['host'].':'.$item['port'] ?>", <?php echo $item['value']?> ],
  <?php }}else{ ?>
    ["no data", 0 ]
  <?php } ?>
  ];
  var plot1 = $.jqplot('redis_connected_clients_ranking', [data], {
    //title: 'chart title',
    series:[{renderer:$.jqplot.BarRenderer}],
    axesDefaults: {
        tickRenderer: $.jqplot.CanvasAxisTickRenderer ,
        tickOptions: {
          angle: -50,
          fontSize: '10px',
          fontFamily:'微软雅黑',
        }
    },
    axes: {
      xaxis: {
        renderer: $.jqplot.CategoryAxisRenderer
      },
      yaxis: {
             min: 0,           //y轴最小值
      }
    }
  });
});


//########################## redis_used_memory_ranking ##################################
$(document).ready(function(){
  var data = [
  <?php if(!empty($redis_used_memory_ranking)) { foreach($redis_used_memory_ranking as $item){ ?>
    ["<?php echo $item['host'].':'.$item['port'] ?>", <?php echo $item['value']?> ],
  <?php }}else{ ?>
    ["no data", 0 ]
  <?php } ?>
  ];
  var plot1 = $.jqplot('redis_used_memory_ranking', [data], {
    //title: 'chart title',
    series:[{renderer:$.jqplot.BarRenderer}],
    axesDefaults: {
        tickRenderer: $.jqplot.CanvasAxisTickRenderer ,
        tickOptions: {
          angle: -50,
          fontSize: '10px',
          fontFamily:'微软雅黑',
        }
    },
    axes: {
      xaxis: {
        renderer: $.jqplot.CategoryAxisRenderer
      },
      yaxis: {
             min: 0,           //y轴最小值
      }
    }
  });
});


	
</script>