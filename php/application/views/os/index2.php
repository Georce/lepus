<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="header">
            
            <h1 class="page-title"><?php echo $this->lang->line('_OS Monitor'); ?> <?php echo $this->lang->line('_Overview'); ?></h1>
</div>
        
<ul class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><?php echo $this->lang->line('home'); ?></a> <span class="divider">/</span></li>
            <li class="active"><?php echo $this->lang->line('_OS Monitor'); ?></li><span class="divider">/</span></li>
            <li class="active"><?php echo $this->lang->line('_Overview'); ?></li>
            
</ul>

<div class="container-fluid">
 <div class="row-fluid">
 

  <table class="table table-bordered table-condensed"  >

  <tr>
        <th><center>OS Health <span class="viewall"><a href="">View All</a><span></center></th>
        <th><center>OS Last Alarm <span class="viewall"><a href="">View All</a><span></center></th>
  </tr>
    <tr style="font-size: 12px;" >
       <td>
       <table class="table    table-bordered table-condensed"  >
  
    <tr  class="info">
        <td>ip</td>
        <td>application</td>
        <td>load_1</td>
        <td>load_5</td>
        <td>load_15</td>
        <td>process</td>
        <td>chart</td>
  </tr>
    <?php if(!empty($last_alarmlist)) { foreach($last_alarmlist as $item){ ?>
    <tr>
    <td><?php echo $item['ip']; ?></td>
    <td><?php echo $item['application']; ?></td>
    <td><?php echo $item['load_1']; ?></td>
    <td><?php echo $item['load_5']; ?></td>
    <td><?php echo $item['load_15']; ?></td>
    <td><?php echo $item['process']; ?></td>
    <td><a href="<?php echo site_url('lp_os/cpu_chart/'.$item['ip']) ?>"><img src="./images/chart.gif"/></a></a></td>
    </tr>
 <?php }}else{  ?>
<tr>
<td colspan="7">
<font color="red"><?php echo $this->lang->line('no_record'); ?></font>
</td>
</tr>
<?php } ?>  
    </table>
       </td>
       
       <td>
       <table class="table  table-bordered table-condensed"  >
  
  
  <tr  class="info">
        <td>ip</td>
        <td>application</td>
        <td>cpu_user</td>
        <td>cpu_system</td>
        <td>cpu_idle</td>
        <td>chart</td>
  </tr>
    <?php if(!empty($os_disk_io_top10)) { foreach($os_disk_io_top10 as $item){ ?>
    <tr style="font-size: 12px;">
    <td><?php echo $item['ip']; ?></td>
    <td><?php echo $item['application']; ?></td>
    <td><?php echo $item['fdisk']; ?></td>
    <td><?php echo $item['disk_io_writes']; ?></td>
    <td><?php echo $item['disk_io_reads']; ?></td>
    <td><a href="<?php echo site_url('lp_os/cpu_chart/'.$item['ip']) ?>"><img src="./images/chart.gif"/></a></a></td>
    </tr>
 <?php }}else{  ?>
<tr>
<td colspan="6">
<font color="red"><?php echo $this->lang->line('no_record'); ?></font>
</td>
</tr>
<?php } ?>  
    </table>
       </td>   
  </tr>

  
  <tr >
        <th><center>OS CPU Load Top 5 <span class="viewall"><a href="">View All</a><span></center></th>
        <th><center>OS CPU Usage Top 5 <span class="viewall"><a href="">View All</a><span></center></th>
  </tr>
    <tr style="font-size: 12px;" >
       <td>
       <table class="table  table-bordered table-condensed"  >
  
    <tr  class="info">
        <td>ip</td>
        <td>application</td>
        <td>load_1</td>
        <td>load_5</td>
        <td>load_15</td>
        <td>process</td>
        <td>chart</td>
  </tr>
    <?php if(!empty($os_disk_usage_top10)) { foreach($os_disk_usage_top10 as $item){ ?>
    <tr>
    <td><?php echo $item['ip']; ?></td>
    <td><?php echo $item['mounted']; ?></td>
    <td><?php echo format_kbytes($item['total_size']); ?></td>
    <td><?php echo format_kbytes($item['used_size']); ?></td>
    <td><?php echo format_kbytes($item['avail_size']); ?></td>
    <td><?php echo ($item['used_rate']); ?></td>
    <td><a href="<?php echo site_url('lp_os/cpu_chart/'.$item['ip']) ?>"><img src="./images/chart.gif"/></a></a></td>
    </tr>
 <?php }}else{  ?>
<tr>
<td colspan="7">
<font color="red"><?php echo $this->lang->line('no_record'); ?></font>
</td>
</tr>
<?php } ?>  
    </table>
       </td>
       
       <td>
       <table class="table   table-bordered table-condensed"  >
  
    <tr class="info">
        <td>ip</td>
        <td>application</td>
        <td>cpu_user</td>
        <td>cpu_system</td>
        <td>cpu_idle</td>
        <td>chart</td>
  </tr>
    <?php if(!empty($os_disk_io_top10)) { foreach($os_disk_io_top10 as $item){ ?>
    <tr>
    <td><?php echo $item['ip']; ?></td>
    <td><?php echo $item['application']; ?></td>
    <td><?php echo $item['fdisk']; ?></td>
    <td><?php echo $item['disk_io_writes']; ?></td>
    <td><?php echo $item['disk_io_reads']; ?></td>
    <td><a href="<?php echo site_url('lp_os/cpu_chart/'.$item['ip']) ?>"><img src="./images/chart.gif"/></a></a></td>
    </tr>
 <?php }}else{  ?>
<tr>
<td colspan="6">
<font color="red"><?php echo $this->lang->line('no_record'); ?></font>
</td>
</tr>
<?php } ?>  
    </table>
       </td>   
  </tr>


  <tr class="info">
        <th><center>OS Disk Usage Top 5 <span class="viewall"><a href="">View All</a><span></center></th>
        <th><center>OS Memory Usage Top 5 <span class="viewall"><a href="">View All</a><span></center></th>
	</tr>
    <tr style="font-size: 12px;" >
       <td>
       <table class="table  table-bordered table-condensed"  >
  
    <tr class="info">
        <td>ip</td>
        <td>mounted</td>
        <td>total_size</td>
        <td>used_size</td>
        <td>avail_size</td>
        <td>used_rate</td>
        <td>chart</td>
	</tr>
    <?php if(!empty($os_disk_usage_top10)) { foreach($os_disk_usage_top10 as $item){ ?>
    <tr>
    <td><?php echo $item['ip']; ?></td>
    <td><?php echo $item['mounted']; ?></td>
    <td><?php echo format_kbytes($item['total_size']); ?></td>
    <td><?php echo format_kbytes($item['used_size']); ?></td>
    <td><?php echo format_kbytes($item['avail_size']); ?></td>
    <td><?php echo ($item['used_rate']); ?></td>
    <td><a href="<?php echo site_url('lp_os/cpu_chart/'.$item['ip']) ?>"><img src="./images/chart.gif"/></a></a></td>
    </tr>
 <?php }}else{  ?>
<tr>
<td colspan="7">
<font color="red"><?php echo $this->lang->line('no_record'); ?></font>
</td>
</tr>
<?php } ?>  
    </table>
       </td>
       
       <td>
       <table class="table  table-bordered table-condensed"  >
  
    <tr class="info">
        <td>ip</td>
        <td>application</td>
        <td>mem_total</td>
        <td>mem_free</td>
        <td>usage_rate</td>
        <td>chart</td>
	</tr>
    <?php if(!empty($os_disk_io_top10)) { foreach($os_disk_io_top10 as $item){ ?>
    <tr>
    <td><?php echo $item['ip']; ?></td>
    <td><?php echo $item['application']; ?></td>
    <td><?php echo $item['fdisk']; ?></td>
    <td><?php echo $item['disk_io_writes']; ?></td>
    <td><?php echo $item['disk_io_reads']; ?></td>
    <td><a href="<?php echo site_url('lp_os/cpu_chart/'.$item['ip']) ?>"><img src="./images/chart.gif"/></a></a></td>
    </tr>
 <?php }}else{  ?>
<tr>
<td colspan="6">
<font color="red"><?php echo $this->lang->line('no_record'); ?></font>
</td>
</tr>
<?php } ?>  
    </table>
       </td>  
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
//########################## os_cpu_load_top10 ##################################
$(document).ready(function(){
  var data = [
  <?php if(!empty($os_cpu_load_top10)) { foreach($os_cpu_load_top10 as $item){ ?>
    ["<?php echo $item['ip']; ?>", <?php echo $item['value']?> ],
  <?php }}else{ ?>
    ["no data", 0 ]
  <?php } ?>
  ];
  var plot1 = $.jqplot('os_cpu_load_top10', [data], {
    //title: 'chart title',
    series:[{renderer:$.jqplot.BarRenderer}],
    axesDefaults: {
        tickRenderer: $.jqplot.CanvasAxisTickRenderer ,
        tickOptions: {
          angle: -45,
          fontSize: '12px',
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
    },
    grid: {
        drawGridLines: true,
        drawBorder: false,
        shadow: false,
        borderColor: '#000000',     // 设置图表的(最外侧)边框的颜色
        borderWidth: 1           //设置图表的（最外侧）边框宽度  
    },
    highlighter: { show: false }
  });
});

//########################## os_cpu_usage_top10 ##################################
$(document).ready(function(){
  var data = [
  <?php if(!empty($os_cpu_usage_top10)) { foreach($os_cpu_usage_top10 as $item){ ?>
    ["<?php echo $item['ip']; ?>", <?php echo $item['value']?> ],
  <?php }}else{ ?>
    ["no data", 0 ]
  <?php } ?>
  ];
  var plot1 = $.jqplot('os_cpu_usage_top10', [data], {
    //title: 'chart title',
    series:[{renderer:$.jqplot.BarRenderer}],
    axesDefaults: {
        tickRenderer: $.jqplot.CanvasAxisTickRenderer ,
        tickOptions: {
          angle: -45,
          fontSize: '12px',
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
    },
    grid: {
        drawGridLines: true,
        drawBorder: false,
        shadow: false,
        borderColor: '#000000',     // 设置图表的(最外侧)边框的颜色
        borderWidth: 1           //设置图表的（最外侧）边框宽度  
    },
    highlighter: { show: false }
  });
});

</script>