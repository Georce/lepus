<html lang="en">
<head>
<meta charset="utf-8">
<title>Mysql_AWR_Report</title>

<base href="<?php echo base_url().'application/views/static/'; ?>" />
<script src="lib/jquery-1.7.2.min.js" type="text/javascript"></script>
<script type="text/javascript" src="./lib/jqplot/jquery.jqplot.min.js"></script>
<script type="text/javascript" src="./lib/jqplot/plugins/jqplot.canvasTextRenderer.min.js"></script>
<script type="text/javascript" src="./lib/jqplot/plugins/jqplot.canvasAxisLabelRenderer.min.js"></script>
<script type="text/javascript" src="./lib/jqplot/plugins/jqplot.dateAxisRenderer.min.js"></script>
<script type="text/javascript" src="./lib/jqplot/plugins/jqplot.highlighter.min.js"></script>
<script type="text/javascript" src="./lib/jqplot/plugins/jqplot.cursor.min.js"></script>
<link href="./lib/jqplot/jquery.jqplot.min.css"  rel="stylesheet">
<style type="text/css">
/* roScripts
Table Design by Mihalcea Romeo
www.roscripts.com
----------------------------------------------- */
table { border-collapse:collapse;
		background:#EFF4FB;
		border-left:1px solid #686868;
		border-right:1px solid #686868;
		font:0.8em/145% "Trebuchet MS",helvetica,arial,verdana;
		color: #333;}
td, th {padding:1px;}
caption {padding: 0 0 .5em 0;
		text-align: left;
		font-size: 1.4em;
		font-weight: bold;
		text-transform: uppercase;
		color: #333;
		background: transparent;}
/* =links----------------------------------------------- */
table a {color:#950000;	text-decoration:none;}
table a:link {}
table a:visited {font-weight:normal;color:#666;text-decoration: line-through;}
table a:hover {	border-bottom: 1px dashed #bbb;}
/* =head =foot----------------------------------------------- */
thead th, tfoot th, tfoot td {background:#333 ;color:#fff}
tfoot td {		text-align:right}
/* =body----------------------------------------------- */
tbody th, tbody td {border-bottom: dotted 1px #333;}
tbody th {white-space: nowrap;}
tbody th a {color:#333;}
.odd {}
tbody tr:hover {background:#fafafa}
a {color:#950000;	text-decoration:none;}
</style></head><body>
<h1 >
MySQL Online AWR Report
</h1>
<hr />
<a href="<?php echo site_url('lp_mysql/awrreport_create'); ?>#t_server">Server |</a> 
<a href="<?php echo site_url('lp_mysql/awrreport_create'); ?>#t_resource">Resource |</a> 
<a href="<?php echo site_url('lp_mysql/awrreport_create'); ?>#t_threads">Threads |</a>
<a href="<?php echo site_url('lp_mysql/awrreport_create'); ?>#t_aborted">Aborted |</a>
<a href="<?php echo site_url('lp_mysql/awrreport_create'); ?>#t_queries">Queries |</a> 
<a href="<?php echo site_url('lp_mysql/awrreport_create'); ?>#t_cpu">Cpu |</a>
<a href="<?php echo site_url('lp_mysql/awrreport_create'); ?>#t_slowsql">SlowSQL |</a>   
<hr />
<p id="t_server"><h3>Server</h3> </p>
<p>
<table border="1"  width="600">
<tr>
<th>tags</th>
<th>host</th>
<th>port</th>
<th>role</th>
<th>version</th>
<th>uptime</th>
</tr>
<tr>
<td align="right"><?php echo $mysql_info['tags']; ?> </td>
<td align="right"><?php echo $mysql_info['host']; ?> </td>
<td align="right"><?php echo $mysql_info['port']; ?> </td>
<td align="right"><?php echo $mysql_info['role']; ?> </td>
<td align="right"><?php echo $mysql_info['version']; ?> </td>
<td align="right"><?php echo check_uptime($mysql_info['uptime']); ?> </td>
</tr>
</table>
</p>

<hr />

<p id="t_resource"><h3>Resource</h3>   </p>
<div id="connections_usage" style="margin-top:15px; margin-left:20px; width:350px; height:250px; float:left;"></div>
<div id="files_usage" style="margin-top:15px; margin-left:20px; width:350px; height:250px; float:left;"></div>
<div id="tables_usage" style="margin-top:15px; margin-left:20px; width:350px; height:250px; float:left;"></div>
<div style="clear:both;"></div>
<hr />

<p id="t_threads"><h3>Threads</h3>   </p>
<div id="threads_running" style="margin-top:15px; margin-left:20px; width:350px; height:250px; float:left;"></div>
<div id="threads" style="margin-top:15px; margin-left:20px; width:350px; height:250px; float:left;"></div>
<div id="connections" style="margin-top:15px; margin-left:20px; width:350px; height:250px; float:left;"></div>
<div style="clear:both;"></div>
<hr />

<p id="t_aborted"><h3>Aborted</h3>   </p>
<div id="aborted_clients" style="margin-top:15px; margin-left:20px; width:350px; height:250px; float:left;"></div>
<div id="aborted_connects" style="margin-top:15px; margin-left:20px; width:350px; height:250px; float:left;"></div>
<div style="clear:both;"></div>
<hr />

<p id="t_queries"><h3>Queries</h3>   </p>
<div id="dml" style="margin-top:15px; margin-left:20px; width:350px; height:250px; float:left;"></div>
<div id="queries" style="margin-top:15px; margin-left:20px; width:350px; height:250px; float:left;"></div>
<div id="transaction" style="margin-top:15px; margin-left:20px; width:350px; height:250px; float:left;"></div>
<div style="clear:both;"></div>
<hr />

<p id="t_cpu"><h3>Host CPU</h3> </p>
<div id="cpu_load" style="margin-top:5px; margin-left:10px; width:350px; height:220px; float:left;"></div>
<div id="cpu_utilization" style="margin-top:5px; margin-left:10px; width:350px; height:220px;float:left;"></div>
<div id="process" style="margin-top:5px; margin-left:10px; width:350px; height:220px;float:left; "></div>
<div style="clear:both;"></div>
<hr />

<p><h3>Top10 SlowQuery SQL</h3> </p>
<table border="1" width="1200" style="font-size: 12px;">
        <tr>
         <td>checksum</td>
        <td>fringerprint </td>
        <td>database</td>
        <td>user</td>
        <td>last_seen</td>
        <td>ts_cnt</td>
        <td>query_time_sum</td>
		<td>query_time_min</td>
        <td>query_time_max</td>
        <td>lock_time_sum</td>
        <td>lock_time_min</td>
		<td>lock_time_max</td>
	   </tr>
      <tbody>
 
  <?php if(!empty($top10_slowQuery)) {?>
 <?php foreach ($top10_slowQuery  as $item):?>
    <tr>
        <td><a href="<?php echo site_url("mysql/awrreport_create#".$item['checksum']) ?>"   title="<?php echo $this->lang->line('view_detail'); ?>"><?php  echo $item['checksum'] ?></a></td>
        <td> <?php echo substring($item['fingerprint'],0,35); ?> </td>
        <td><?php echo $item['db_max'] ?></td>
        <td><?php echo $item['user_max'] ?></td>
        <td><?php echo $item['last_seen'] ?></td>
        <td><?php echo $item['ts_cnt'] ?></td>
        <td><?php echo $item['Query_time_sum'] ?></td>
        <td><?php echo $item['Query_time_min'] ?></td>
        <td><?php echo $item['Query_time_max'] ?></td>
        <td><?php echo $item['Lock_time_sum'] ?></td>
        <td><?php echo $item['Lock_time_min'] ?></td>
        <td><?php echo $item['Lock_time_max'] ?></td>
	</tr>
 <?php endforeach;?>
<?php } ?>
</tbody>
    </table>
<hr />

<p id="t_slowsql"><h3>Top10 SlowQuery SQL Detail</h3> </p>
 
  <?php if(!empty($top10_slowQuery)) {?>
 <?php foreach ($top10_slowQuery  as $record):?>
 <a name="<?php echo $record['checksum']; ?>"></a>
 <p>
    <table  border="1" width="1200" style="font-size: 12px;">
    <tr>
        <th>database</th>
        <td colspan="2"><?php echo $record['db_max']; ?></td>
        <th>user</th>	
        <td colspan="3"><?php echo $record['user_max']; ?></td>
	</tr>
    <tr>
        <th ><?php echo $this->lang->line('checksum'); ?></th>
        <td colspan="2"><?php echo $record['checksum']; ?></td>
        <th><?php echo $this->lang->line('ts_cnt'); ?></th>	
        <td colspan="3"><?php echo $record['ts_cnt']; ?></td>
	</tr>
    <tr>
        <th><?php echo $this->lang->line('first_seen'); ?></th>
        <td colspan="2"><?php echo $record['first_seen']; ?></td>
        <th><?php echo $this->lang->line('last_seen'); ?></th>
        <td colspan="3"><?php echo $record['last_seen']; ?></td>
	</tr>
    <tr>
        <th><?php echo $this->lang->line('fingerprint'); ?></th>
        <td colspan="6"><?php echo $record['fingerprint']; ?></td>	
	</tr>
    <tr>
        <th><?php echo $this->lang->line('sample'); ?></th>
        <td colspan="6"><?php echo $record['sample']; ?></td>
	</tr>
    <tr>
        <th rowspan="2"><?php echo $this->lang->line('query_time'); ?></th>
        <th>Query_time_sum</th>
        <th>Query_time_min</th>
        <th>Query_time_max</th>
        <th>Query_time_pct_95</th>
        <th>Query_time_stddev</th>
        <th>Query_time_median</th>
	</tr>
    <tr>
        <td><?php echo $record['Query_time_sum']; ?></td>
        <td><?php echo $record['Query_time_min']; ?></td>
        <td><?php echo $record['Query_time_max']; ?></td>
        <td><?php echo $record['Query_time_pct_95']; ?></td>
        <td><?php echo $record['Query_time_stddev']; ?></td>
        <td><?php echo $record['Query_time_median']; ?></td>
	</tr>
    <tr>
        <th rowspan="2"><?php echo $this->lang->line('lock_time'); ?></th>
        <th>Lock_time_sum</th>
        <th>Lock_time_min</th>
        <th>Lock_time_max</th>
        <th>Lock_time_pct_95</th>
        <th>Lock_time_stddev</th>
        <th>Lock_time_median</th>
	</tr>
    <tr>
        <td><?php echo $record['Lock_time_sum']; ?></td>
        <td><?php echo $record['Lock_time_min']; ?></td>
        <td><?php echo $record['Lock_time_max']; ?></td>
        <td><?php echo $record['Lock_time_pct_95']; ?></td>
        <td><?php echo $record['Lock_time_stddev']; ?></td>
        <td><?php echo $record['Lock_time_median']; ?></td>
	</tr>
    <tr>
        <th rowspan="2"><?php echo $this->lang->line('rows_sent'); ?></th>
        <th>Rows_sent_sum</th>
        <th>Rows_sent_min</th>
        <th>Rows_sent_max</th>
        <th>Rows_sent_pct_95</th>
        <th>Rows_sent_stddev</th>
        <th>Rows_sent_median</th>
	</tr>
    <tr>
        <td><?php echo $record['Rows_sent_sum']; ?></td>
        <td><?php echo $record['Rows_sent_min']; ?></td>
        <td><?php echo $record['Rows_sent_max']; ?></td>
        <td><?php echo $record['Rows_sent_pct_95']; ?></td>
        <td><?php echo $record['Rows_sent_stddev']; ?></td>
        <td><?php echo $record['Rows_sent_median']; ?></td>
	</tr>
    <tr>
        <th rowspan="2"><?php echo $this->lang->line('rows_examined'); ?></th>
        <th>Rows_examined_sum</th>
        <th>Rows_examined_min</th>
        <th>Rows_examined_max</th>
        <th>Rows_examined_pct_95</th>
        <th>Rows_examined_stddev</th>
        <th>Rows_examined_median</th>
	</tr>
    <tr>
        <td><?php echo $record['Rows_examined_sum']; ?></td>
        <td><?php echo $record['Rows_examined_min']; ?></td>
        <td><?php echo $record['Rows_examined_max']; ?></td>
        <td><?php echo $record['Rows_examined_pct_95']; ?></td>
        <td><?php echo $record['Rows_examined_stddev']; ?></td>
        <td><?php echo $record['Rows_examined_median']; ?></td>
	</tr>
	 
</table>
</p>
 <?php endforeach;?>
<?php } ?>

	




<script>

//==========================connections usage=========================================//
$(document).ready(function(){  
  var data1=[
    <?php if(!empty($mysql_chart_reslut)) { foreach($mysql_chart_reslut as $item){ ?>
    ["<?php echo $item['time']?>", <?php echo $item['max_connections']?> ],
    <?php }}else{ ?>
    []    
    <?php } ?>
  ];
  var data2=[
    <?php if(!empty($mysql_chart_reslut)) { foreach($mysql_chart_reslut as $item){ ?>
    ["<?php echo $item['time']?>", <?php echo $item['threads_connected']?> ],
    <?php }}else{ ?>
    []    
    <?php } ?>
  ];
  var plot1 = $.jqplot('connections_usage', [data1,data2], {
    axes:{
        xaxis:{
            renderer:$.jqplot.DateAxisRenderer,
            pad:1.1,
            tickOptions: {  
                    mark: 'cross',    // 设置横（纵）坐标刻度在坐标轴上显示方式，分为坐标轴内，外，穿过坐标轴显示  
                                // 值也分为：'outside', 'inside' 和 'cross',  
                    showMark: false,     //设置是否显示刻度  
                    showGridLine: true, // 是否在图表区域显示刻度值方向的网格线  
                    markSize:0,        // 每个刻度线顶点距刻度线在坐标轴上点距离（像素为单位）  
                                //如果mark值为 'cross', 那么每个刻度线都有上顶点和下顶点，刻度线与坐标轴  
                                //在刻度线中间交叉，那么这时这个距离×2,  
                    show: true,         // 是否显示刻度线，与刻度线同方向的网格线，以及坐标轴上的刻度值  
                    showLabel: true,    // 是否显示刻度线以及坐标轴上的刻度值  
                    formatString: '',   // 梃置坐标轴上刻度值显示格式，eg:'%b %#d, %Y'表示格式"月 日，年"，"AUG 30,2008"  
                    fontSize:'',    //刻度值的字体大小  
                    fontFamily:'Tahoma', //刻度值上字体  
                    angle:40,           //刻度值与坐标轴夹角，角度为坐标轴正向顺时针方向  
                    fontWeight:'normal', //字体的粗细  
                    fontStretch:0,//刻度值在所在方向（坐标轴外）上的伸展(拉伸)度,

            }
        }, 
        yaxis:{
            min:0,
        } 
    },
    
    title: {  
        text: "Connection Pool Usage<br/><?php echo $begin_time.' - '.$end_time; ?>",   // 设置当前图的标题  
        show: true,//设置当前标题是否显示 
        fontSize:'13px',    //刻度值的字体大小  
    },  
    seriesDefaults: {
              show: true,     // 设置是否渲染整个图表区域（即显示图表中内容）  
              xaxis: 'xaxis', // either 'xaxis' or 'x2axis'.  
              yaxis: 'yaxis', // either 'yaxis' or 'y2axis'.  
              label: '',      // 用于显示在分类名称框中的分类名称  
              color: '',      // 分类在图标中表示（折现，柱状图等）的颜色  
              lineWidth: 1.5, // 分类图（特别是折线图）宽度  
              shadow: true,   // 各图在图表中是否显示阴影区域   
              showLine: true,     //是否显示图表中的折线（折线图中的折线）  
              showMarker: false,   // 是否强调显示图中的数据节点  
              fill: false,        // 是否填充图表中折线下面的区域（填充颜色同折线颜色）以及legend 
              rendererOptions: {
                 smooth: true,
              },
              
    },
    series:[//如果有多个分类需要显示，这在此处设置各个分类的相关配置属性  
           //eg.设置各个分类在分类名称框中的分类名称  
            {label: 'max'},{label: 'use'}
           //配置参数设置同seriesDefaults  
    ],  
    legend: {  
        show: true, //设置是否出现分类名称框（即所有分类的名称出现在图的某个位置） 
        label:'', 
        location: 'ne',     // 分类名称框出现位置, nw, n, ne, e, se, s, sw, w.  
        xoffset: 2,        // 分类名称框距图表区域上边框的距离（单位px）  
        yoffset: 2,        // 分类名称框距图表区域左边框的距离(单位px)  
        background:'',        //分类名称框距图表区域背景色  
        textColor:''          //分类名称框距图表区域内字体颜色  
    },    
    seriesColors: [ "orange", "red"],  // 默认显示的分类颜色 
    highlighter: {
            show: true, 
            showLabel: true, 
            tooltipAxes: '',
            sizeAdjust: 1.5 , 
            tooltipLocation : 'ne',
    },
    cursor:{
            show: true, 
            zoom: true
    },
      
  });
});

//==========================files usage=========================================//
$(document).ready(function(){  
  var data1=[
    <?php if(!empty($mysql_chart_reslut)) { foreach($mysql_chart_reslut as $item){ ?>
    ["<?php echo $item['time']?>", <?php echo $item['open_files_limit']?> ],
    <?php }}else{ ?>
    []    
    <?php } ?>
  ];
  var data2=[
    <?php if(!empty($mysql_chart_reslut)) { foreach($mysql_chart_reslut as $item){ ?>
    ["<?php echo $item['time']?>", <?php echo $item['open_files']?> ],
    <?php }}else{ ?>
    []    
    <?php } ?>
  ];
  var plot1 = $.jqplot('files_usage', [data1,data2], {
    axes:{
        xaxis:{
            renderer:$.jqplot.DateAxisRenderer,
            pad:1.1,
            tickOptions: {  
                    mark: 'cross',    // 设置横（纵）坐标刻度在坐标轴上显示方式，分为坐标轴内，外，穿过坐标轴显示  
                                // 值也分为：'outside', 'inside' 和 'cross',  
                    showMark: false,     //设置是否显示刻度  
                    showGridLine: true, // 是否在图表区域显示刻度值方向的网格线  
                    markSize:0,        // 每个刻度线顶点距刻度线在坐标轴上点距离（像素为单位）  
                                //如果mark值为 'cross', 那么每个刻度线都有上顶点和下顶点，刻度线与坐标轴  
                                //在刻度线中间交叉，那么这时这个距离×2,  
                    show: true,         // 是否显示刻度线，与刻度线同方向的网格线，以及坐标轴上的刻度值  
                    showLabel: true,    // 是否显示刻度线以及坐标轴上的刻度值  
                    formatString: '',   // 梃置坐标轴上刻度值显示格式，eg:'%b %#d, %Y'表示格式"月 日，年"，"AUG 30,2008"  
                    fontSize:'',    //刻度值的字体大小  
                    fontFamily:'Tahoma', //刻度值上字体  
                    angle:40,           //刻度值与坐标轴夹角，角度为坐标轴正向顺时针方向  
                    fontWeight:'normal', //字体的粗细  
                    fontStretch:0,//刻度值在所在方向（坐标轴外）上的伸展(拉伸)度,

            }
        },
        yaxis:{
            min:0,
        }   
    },
    
    title: {  
        text: "File Limit Usage<br/><?php echo $begin_time.' - '.$end_time; ?>",   // 设置当前图的标题  
        show: true,//设置当前标题是否显示 
        fontSize:'13px',    //刻度值的字体大小  
    },  
    seriesDefaults: {
              show: true,     // 设置是否渲染整个图表区域（即显示图表中内容）  
              xaxis: 'xaxis', // either 'xaxis' or 'x2axis'.  
              yaxis: 'yaxis', // either 'yaxis' or 'y2axis'.  
              label: '',      // 用于显示在分类名称框中的分类名称  
              color: '',      // 分类在图标中表示（折现，柱状图等）的颜色  
              lineWidth: 1.5, // 分类图（特别是折线图）宽度  
              shadow: true,   // 各图在图表中是否显示阴影区域   
              showLine: true,     //是否显示图表中的折线（折线图中的折线）  
              showMarker: false,   // 是否强调显示图中的数据节点  
              fill: false,        // 是否填充图表中折线下面的区域（填充颜色同折线颜色）以及legend 
              rendererOptions: {
                 smooth: true,
              },
              
    },
    series:[//如果有多个分类需要显示，这在此处设置各个分类的相关配置属性  
           //eg.设置各个分类在分类名称框中的分类名称  
            {label: 'max'},{label: 'use'}
           //配置参数设置同seriesDefaults  
    ],  
    legend: {  
        show: true, //设置是否出现分类名称框（即所有分类的名称出现在图的某个位置） 
        label:'', 
        location: 'ne',     // 分类名称框出现位置, nw, n, ne, e, se, s, sw, w.  
        xoffset: 2,        // 分类名称框距图表区域上边框的距离（单位px）  
        yoffset: 2,        // 分类名称框距图表区域左边框的距离(单位px)  
        background:'',        //分类名称框距图表区域背景色  
        textColor:''          //分类名称框距图表区域内字体颜色  
    },    
    seriesColors: [ "orange", "red"],  // 默认显示的分类颜色 
    highlighter: {
            show: true, 
            showLabel: true, 
            tooltipAxes: '',
            sizeAdjust: 1.5 , 
            tooltipLocation : 'ne',
    },
    cursor:{
            show: true, 
            zoom: true
    },
      
  });
});

//==========================tables_usage=========================================//
$(document).ready(function(){  
  var data1=[
    <?php if(!empty($mysql_chart_reslut)) { foreach($mysql_chart_reslut as $item){ ?>
    ["<?php echo $item['time']?>", <?php echo $item['table_open_cache']?> ],
    <?php }}else{ ?>
    []    
    <?php } ?>
  ];
  var data2=[
    <?php if(!empty($mysql_chart_reslut)) { foreach($mysql_chart_reslut as $item){ ?>
    ["<?php echo $item['time']?>", <?php echo $item['open_tables']?> ],
    <?php }}else{ ?>
    []    
    <?php } ?>
  ];
  var plot1 = $.jqplot('tables_usage', [data1,data2], {
    axes:{
        xaxis:{
            renderer:$.jqplot.DateAxisRenderer,
            pad:1.1,
            tickOptions: {  
                    mark: 'cross',    // 设置横（纵）坐标刻度在坐标轴上显示方式，分为坐标轴内，外，穿过坐标轴显示  
                                // 值也分为：'outside', 'inside' 和 'cross',  
                    showMark: false,     //设置是否显示刻度  
                    showGridLine: true, // 是否在图表区域显示刻度值方向的网格线  
                    markSize:0,        // 每个刻度线顶点距刻度线在坐标轴上点距离（像素为单位）  
                                //如果mark值为 'cross', 那么每个刻度线都有上顶点和下顶点，刻度线与坐标轴  
                                //在刻度线中间交叉，那么这时这个距离×2,  
                    show: true,         // 是否显示刻度线，与刻度线同方向的网格线，以及坐标轴上的刻度值  
                    showLabel: true,    // 是否显示刻度线以及坐标轴上的刻度值  
                    formatString: '',   // 梃置坐标轴上刻度值显示格式，eg:'%b %#d, %Y'表示格式"月 日，年"，"AUG 30,2008"  
                    fontSize:'',    //刻度值的字体大小  
                    fontFamily:'Tahoma', //刻度值上字体  
                    angle:40,           //刻度值与坐标轴夹角，角度为坐标轴正向顺时针方向  
                    fontWeight:'normal', //字体的粗细  
                    fontStretch:0,//刻度值在所在方向（坐标轴外）上的伸展(拉伸)度,

            }
        },
        yaxis:{
            min:0,
        }   
    },
    
    title: {  
        text: "Table Cache Usage <br/><?php echo $begin_time.' - '.$end_time; ?>",   // 设置当前图的标题  
        show: true,//设置当前标题是否显示 
        fontSize:'13px',    //刻度值的字体大小  
    },  
    seriesDefaults: {
              show: true,     // 设置是否渲染整个图表区域（即显示图表中内容）  
              xaxis: 'xaxis', // either 'xaxis' or 'x2axis'.  
              yaxis: 'yaxis', // either 'yaxis' or 'y2axis'.  
              label: '',      // 用于显示在分类名称框中的分类名称  
              color: '',      // 分类在图标中表示（折现，柱状图等）的颜色  
              lineWidth: 1.5, // 分类图（特别是折线图）宽度  
              shadow: true,   // 各图在图表中是否显示阴影区域   
              showLine: true,     //是否显示图表中的折线（折线图中的折线）  
              showMarker: false,   // 是否强调显示图中的数据节点  
              fill: false,        // 是否填充图表中折线下面的区域（填充颜色同折线颜色）以及legend 
              rendererOptions: {
                 smooth: true,
              },
              
    },
    series:[//如果有多个分类需要显示，这在此处设置各个分类的相关配置属性  
           //eg.设置各个分类在分类名称框中的分类名称  
            {label: 'max'},{label: 'use'}
           //配置参数设置同seriesDefaults  
    ],  
    legend: {  
        show: true, //设置是否出现分类名称框（即所有分类的名称出现在图的某个位置） 
        label:'', 
        location: 'ne',     // 分类名称框出现位置, nw, n, ne, e, se, s, sw, w.  
        xoffset: 2,        // 分类名称框距图表区域上边框的距离（单位px）  
        yoffset: 2,        // 分类名称框距图表区域左边框的距离(单位px)  
        background:'',        //分类名称框距图表区域背景色  
        textColor:''          //分类名称框距图表区域内字体颜色  
    },    
    seriesColors: [ "orange", "red"],  // 默认显示的分类颜色 
    highlighter: {
            show: true, 
            showLabel: true, 
            tooltipAxes: '',
            sizeAdjust: 1.5 , 
            tooltipLocation : 'ne',
    },
    cursor:{
            show: true, 
            zoom: true
    },
      
  });
});



//==========================threads_running=========================================//
$(document).ready(function(){  
  var data1=[
    <?php if(!empty($mysql_chart_reslut)) { foreach($mysql_chart_reslut as $item){ ?>
    ["<?php echo $item['time']?>", <?php echo $item['threads_running']?> ],
    <?php }}else{ ?>
    []    
    <?php } ?>
  ];
  var plot1 = $.jqplot('threads_running', [data1], {
    axes:{
        xaxis:{
            renderer:$.jqplot.DateAxisRenderer,
            pad:1.1,
            tickOptions: {  
                    mark: 'cross',    // 设置横（纵）坐标刻度在坐标轴上显示方式，分为坐标轴内，外，穿过坐标轴显示  
                                // 值也分为：'outside', 'inside' 和 'cross',  
                    showMark: false,     //设置是否显示刻度  
                    showGridLine: true, // 是否在图表区域显示刻度值方向的网格线  
                    markSize:0,        // 每个刻度线顶点距刻度线在坐标轴上点距离（像素为单位）  
                                //如果mark值为 'cross', 那么每个刻度线都有上顶点和下顶点，刻度线与坐标轴  
                                //在刻度线中间交叉，那么这时这个距离×2,  
                    show: true,         // 是否显示刻度线，与刻度线同方向的网格线，以及坐标轴上的刻度值  
                    showLabel: true,    // 是否显示刻度线以及坐标轴上的刻度值  
                    formatString: '',   // 梃置坐标轴上刻度值显示格式，eg:'%b %#d, %Y'表示格式"月 日，年"，"AUG 30,2008"  
                    fontSize:'',    //刻度值的字体大小  
                    fontFamily:'Tahoma', //刻度值上字体  
                    angle:40,           //刻度值与坐标轴夹角，角度为坐标轴正向顺时针方向  
                    fontWeight:'normal', //字体的粗细  
                    fontStretch:0,//刻度值在所在方向（坐标轴外）上的伸展(拉伸)度,

            }
        },  
    },
    
    title: {  
        text: "Threads Running<br/><?php echo $begin_time.' - '.$end_time; ?>",   // 设置当前图的标题  
        show: true,//设置当前标题是否显示 
        fontSize:'13px',    //刻度值的字体大小  
    },  
    seriesDefaults: {
              show: true,     // 设置是否渲染整个图表区域（即显示图表中内容）  
              xaxis: 'xaxis', // either 'xaxis' or 'x2axis'.  
              yaxis: 'yaxis', // either 'yaxis' or 'y2axis'.  
              label: '',      // 用于显示在分类名称框中的分类名称  
              color: '',      // 分类在图标中表示（折现，柱状图等）的颜色  
              lineWidth: 1.5, // 分类图（特别是折线图）宽度  
              shadow: true,   // 各图在图表中是否显示阴影区域   
              showLine: true,     //是否显示图表中的折线（折线图中的折线）  
              showMarker: false,   // 是否强调显示图中的数据节点  
              fill: false,        // 是否填充图表中折线下面的区域（填充颜色同折线颜色）以及legend 
              rendererOptions: {
                 smooth: true,
              },
              
    },
    series:[//如果有多个分类需要显示，这在此处设置各个分类的相关配置属性  
           //eg.设置各个分类在分类名称框中的分类名称  
            {label: 'threads_running'}
           //配置参数设置同seriesDefaults  
    ],  
    legend: {  
        show: true, //设置是否出现分类名称框（即所有分类的名称出现在图的某个位置） 
        label:'', 
        location: 'ne',     // 分类名称框出现位置, nw, n, ne, e, se, s, sw, w.  
        xoffset: 2,        // 分类名称框距图表区域上边框的距离（单位px）  
        yoffset: 2,        // 分类名称框距图表区域左边框的距离(单位px)  
        background:'',        //分类名称框距图表区域背景色  
        textColor:''          //分类名称框距图表区域内字体颜色  
    },    
    seriesColors: [ "#ff5800", "#EAA228", "#4bb2c5", "#839557", "#958c12",   
        "#953579", "#4b5de4", "#d8b83f", "#ff5800", "#0085cc"],  // 默认显示的分类颜色 
    highlighter: {
            show: true, 
            showLabel: true, 
            tooltipAxes: '',
            sizeAdjust: 1.5 , 
            tooltipLocation : 'ne',
    },
    cursor:{
            show: true, 
            zoom: true
    },
      
  });
});

//=========================threads=========================================//
$(document).ready(function(){  
  var data1=[
    <?php if(!empty($mysql_chart_reslut)) { foreach($mysql_chart_reslut as $item){ ?>
    ["<?php echo $item['time']?>", <?php echo $item['threads_connected']?> ],
    <?php }}else{ ?>
    []    
    <?php } ?>
  ];
  var data2=[
    <?php if(!empty($mysql_chart_reslut)) { foreach($mysql_chart_reslut as $item){ ?>
    ["<?php echo $item['time']?>", <?php echo $item['threads_created']?> ],
    <?php }}else{ ?>
    []    
    <?php } ?>
  ];
  var data3=[
    <?php if(!empty($mysql_chart_reslut)) { foreach($mysql_chart_reslut as $item){ ?>
    ["<?php echo $item['time']?>", <?php echo $item['threads_cached']?> ],
    <?php }}else{ ?>
    []    
    <?php } ?>
  ];
  var plot1 = $.jqplot('threads', [data1,data2,data3], {
    axes:{
        xaxis:{
            renderer:$.jqplot.DateAxisRenderer,
            pad:1.1,
            tickOptions: {  
                    mark: 'cross',    // 设置横（纵）坐标刻度在坐标轴上显示方式，分为坐标轴内，外，穿过坐标轴显示  
                                // 值也分为：'outside', 'inside' 和 'cross',  
                    showMark: false,     //设置是否显示刻度  
                    showGridLine: true, // 是否在图表区域显示刻度值方向的网格线  
                    markSize:0,        // 每个刻度线顶点距刻度线在坐标轴上点距离（像素为单位）  
                                //如果mark值为 'cross', 那么每个刻度线都有上顶点和下顶点，刻度线与坐标轴  
                                //在刻度线中间交叉，那么这时这个距离×2,  
                    show: true,         // 是否显示刻度线，与刻度线同方向的网格线，以及坐标轴上的刻度值  
                    showLabel: true,    // 是否显示刻度线以及坐标轴上的刻度值  
                    formatString: '',   // 梃置坐标轴上刻度值显示格式，eg:'%b %#d, %Y'表示格式"月 日，年"，"AUG 30,2008"  
                    fontSize:'',    //刻度值的字体大小  
                    fontFamily:'Tahoma', //刻度值上字体  
                    angle:40,           //刻度值与坐标轴夹角，角度为坐标轴正向顺时针方向  
                    fontWeight:'normal', //字体的粗细  
                    fontStretch:0,//刻度值在所在方向（坐标轴外）上的伸展(拉伸)度,

            }
        },  
    },
    
    title: {  
        text: "Threads <br/><?php echo $begin_time.' - '.$end_time; ?>",   // 设置当前图的标题  
        show: true,//设置当前标题是否显示 
        fontSize:'13px',    //刻度值的字体大小  
    },  
    seriesDefaults: {
              show: true,     // 设置是否渲染整个图表区域（即显示图表中内容）  
              xaxis: 'xaxis', // either 'xaxis' or 'x2axis'.  
              yaxis: 'yaxis', // either 'yaxis' or 'y2axis'.  
              label: '',      // 用于显示在分类名称框中的分类名称  
              color: '',      // 分类在图标中表示（折现，柱状图等）的颜色  
              lineWidth: 1.5, // 分类图（特别是折线图）宽度  
              shadow: true,   // 各图在图表中是否显示阴影区域   
              showLine: true,     //是否显示图表中的折线（折线图中的折线）  
              showMarker: false,   // 是否强调显示图中的数据节点  
              fill: false,        // 是否填充图表中折线下面的区域（填充颜色同折线颜色）以及legend 
              rendererOptions: {
                 smooth: true,
              },
              
    },
    series:[//如果有多个分类需要显示，这在此处设置各个分类的相关配置属性  
           //eg.设置各个分类在分类名称框中的分类名称  
            {label: 'connected'},{label: 'created'},{label: 'cached'}
           //配置参数设置同seriesDefaults  
    ],  
    legend: {  
        show: true, //设置是否出现分类名称框（即所有分类的名称出现在图的某个位置） 
        label:'', 
        location: 'ne',     // 分类名称框出现位置, nw, n, ne, e, se, s, sw, w.  
        xoffset: 2,        // 分类名称框距图表区域上边框的距离（单位px）  
        yoffset: 2,        // 分类名称框距图表区域左边框的距离(单位px)  
        background:'',        //分类名称框距图表区域背景色  
        textColor:''          //分类名称框距图表区域内字体颜色  
    },    
    seriesColors: [ "#ff5800", "#EAA228", "#4bb2c5", "#839557", "#958c12",   
        "#953579", "#4b5de4", "#d8b83f", "#ff5800", "#0085cc"],  // 默认显示的分类颜色 
    highlighter: {
            show: true, 
            showLabel: true, 
            tooltipAxes: '',
            sizeAdjust: 1.5 , 
            tooltipLocation : 'ne',
    },
    cursor:{
            show: true, 
            zoom: true
    },
      
  });
});

//==========================connections=========================================//
$(document).ready(function(){  
  var data1=[
    <?php if(!empty($mysql_chart_reslut)) { foreach($mysql_chart_reslut as $item){ ?>
    ["<?php echo $item['time']?>", <?php echo $item['connections_persecond']?> ],
    <?php }}else{ ?>
    []    
    <?php } ?>
  ];
  var plot1 = $.jqplot('connections', [data1], {
    axes:{
        xaxis:{
            renderer:$.jqplot.DateAxisRenderer,
            pad:1.1,
            tickOptions: {  
                    mark: 'cross',    // 设置横（纵）坐标刻度在坐标轴上显示方式，分为坐标轴内，外，穿过坐标轴显示  
                                // 值也分为：'outside', 'inside' 和 'cross',  
                    showMark: false,     //设置是否显示刻度  
                    showGridLine: true, // 是否在图表区域显示刻度值方向的网格线  
                    markSize:0,        // 每个刻度线顶点距刻度线在坐标轴上点距离（像素为单位）  
                                //如果mark值为 'cross', 那么每个刻度线都有上顶点和下顶点，刻度线与坐标轴  
                                //在刻度线中间交叉，那么这时这个距离×2,  
                    show: true,         // 是否显示刻度线，与刻度线同方向的网格线，以及坐标轴上的刻度值  
                    showLabel: true,    // 是否显示刻度线以及坐标轴上的刻度值  
                    formatString: '',   // 梃置坐标轴上刻度值显示格式，eg:'%b %#d, %Y'表示格式"月 日，年"，"AUG 30,2008"  
                    fontSize:'',    //刻度值的字体大小  
                    fontFamily:'Tahoma', //刻度值上字体  
                    angle:40,           //刻度值与坐标轴夹角，角度为坐标轴正向顺时针方向  
                    fontWeight:'normal', //字体的粗细  
                    fontStretch:0,//刻度值在所在方向（坐标轴外）上的伸展(拉伸)度,

            }
        },  
    },
    
    title: {  
        text: "Connections Persecond<br/><?php echo $begin_time.' - '.$end_time; ?>",   // 设置当前图的标题  
        show: true,//设置当前标题是否显示 
        fontSize:'13px',    //刻度值的字体大小  
    },  
    seriesDefaults: {
              show: true,     // 设置是否渲染整个图表区域（即显示图表中内容）  
              xaxis: 'xaxis', // either 'xaxis' or 'x2axis'.  
              yaxis: 'yaxis', // either 'yaxis' or 'y2axis'.  
              label: '',      // 用于显示在分类名称框中的分类名称  
              color: '',      // 分类在图标中表示（折现，柱状图等）的颜色  
              lineWidth: 1.5, // 分类图（特别是折线图）宽度  
              shadow: true,   // 各图在图表中是否显示阴影区域   
              showLine: true,     //是否显示图表中的折线（折线图中的折线）  
              showMarker: false,   // 是否强调显示图中的数据节点  
              fill: false,        // 是否填充图表中折线下面的区域（填充颜色同折线颜色）以及legend 
              rendererOptions: {
                 smooth: true,
              },
              
    },
    series:[//如果有多个分类需要显示，这在此处设置各个分类的相关配置属性  
           //eg.设置各个分类在分类名称框中的分类名称  
            {label: 'connections'}
           //配置参数设置同seriesDefaults  
    ],  
    legend: {  
        show: true, //设置是否出现分类名称框（即所有分类的名称出现在图的某个位置） 
        label:'', 
        location: 'ne',     // 分类名称框出现位置, nw, n, ne, e, se, s, sw, w.  
        xoffset: 2,        // 分类名称框距图表区域上边框的距离（单位px）  
        yoffset: 2,        // 分类名称框距图表区域左边框的距离(单位px)  
        background:'',        //分类名称框距图表区域背景色  
        textColor:''          //分类名称框距图表区域内字体颜色  
    },    
    seriesColors: [ "#ff5800", "#EAA228", "#4bb2c5", "#839557", "#958c12",   
        "#953579", "#4b5de4", "#d8b83f", "#ff5800", "#0085cc"],  // 默认显示的分类颜色 
    highlighter: {
            show: true, 
            showLabel: true, 
            tooltipAxes: '',
            sizeAdjust: 1.5 , 
            tooltipLocation : 'ne',
    },
    cursor:{
            show: true, 
            zoom: true
    },
      
  });
});

//==========================aborted_clients=========================================//
$(document).ready(function(){  
  var data1=[
    <?php if(!empty($mysql_chart_reslut)) { foreach($mysql_chart_reslut as $item){ ?>
    ["<?php echo $item['time']?>", <?php echo $item['aborted_clients']?> ],
    <?php }}else{ ?>
    []    
    <?php } ?>
  ];
  var plot1 = $.jqplot('aborted_clients', [data1], {
    axes:{
        xaxis:{
            renderer:$.jqplot.DateAxisRenderer,
            pad:1.1,
            tickOptions: {  
                    mark: 'cross',    // 设置横（纵）坐标刻度在坐标轴上显示方式，分为坐标轴内，外，穿过坐标轴显示  
                                // 值也分为：'outside', 'inside' 和 'cross',  
                    showMark: false,     //设置是否显示刻度  
                    showGridLine: true, // 是否在图表区域显示刻度值方向的网格线  
                    markSize:0,        // 每个刻度线顶点距刻度线在坐标轴上点距离（像素为单位）  
                                //如果mark值为 'cross', 那么每个刻度线都有上顶点和下顶点，刻度线与坐标轴  
                                //在刻度线中间交叉，那么这时这个距离×2,  
                    show: true,         // 是否显示刻度线，与刻度线同方向的网格线，以及坐标轴上的刻度值  
                    showLabel: true,    // 是否显示刻度线以及坐标轴上的刻度值  
                    formatString: '',   // 梃置坐标轴上刻度值显示格式，eg:'%b %#d, %Y'表示格式"月 日，年"，"AUG 30,2008"  
                    fontSize:'',    //刻度值的字体大小  
                    fontFamily:'Tahoma', //刻度值上字体  
                    angle:40,           //刻度值与坐标轴夹角，角度为坐标轴正向顺时针方向  
                    fontWeight:'normal', //字体的粗细  
                    fontStretch:0,//刻度值在所在方向（坐标轴外）上的伸展(拉伸)度,

            }
        },  
    },
    
    title: {  
        text: "Aborted Clients<br/><?php echo $begin_time.' - '.$end_time; ?>",   // 设置当前图的标题  
        show: true,//设置当前标题是否显示 
        fontSize:'13px',    //刻度值的字体大小  
    },  
    seriesDefaults: {
              show: true,     // 设置是否渲染整个图表区域（即显示图表中内容）  
              xaxis: 'xaxis', // either 'xaxis' or 'x2axis'.  
              yaxis: 'yaxis', // either 'yaxis' or 'y2axis'.  
              label: '',      // 用于显示在分类名称框中的分类名称  
              color: '',      // 分类在图标中表示（折现，柱状图等）的颜色  
              lineWidth: 1.5, // 分类图（特别是折线图）宽度  
              shadow: true,   // 各图在图表中是否显示阴影区域   
              showLine: true,     //是否显示图表中的折线（折线图中的折线）  
              showMarker: false,   // 是否强调显示图中的数据节点  
              fill: false,        // 是否填充图表中折线下面的区域（填充颜色同折线颜色）以及legend 
              rendererOptions: {
                 smooth: true,
              },
              
    },
    series:[//如果有多个分类需要显示，这在此处设置各个分类的相关配置属性  
           //eg.设置各个分类在分类名称框中的分类名称  
            {label: 'aborted_clients'}
           //配置参数设置同seriesDefaults  
    ],
    legend: {  
        show: true, //设置是否出现分类名称框（即所有分类的名称出现在图的某个位置） 
        label:'', 
        location: 'ne',     // 分类名称框出现位置, nw, n, ne, e, se, s, sw, w.  
        xoffset: 2,        // 分类名称框距图表区域上边框的距离（单位px）  
        yoffset: 2,        // 分类名称框距图表区域左边框的距离(单位px)  
        background:'',        //分类名称框距图表区域背景色  
        textColor:''          //分类名称框距图表区域内字体颜色  
    },    
    seriesColors: [ "#ff5800", "#EAA228", "#4bb2c5", "#839557", "#958c12",   
        "#953579", "#4b5de4", "#d8b83f", "#ff5800", "#0085cc"],  // 默认显示的分类颜色 
    highlighter: {
            show: true, 
            showLabel: true, 
            tooltipAxes: '',
            sizeAdjust: 1.5 , 
            tooltipLocation : 'ne',
    },
    cursor:{
            show: true, 
            zoom: true
    },
      
  });
});

//==========================aborted_connects=========================================//
$(document).ready(function(){  
  var data1=[
    <?php if(!empty($mysql_chart_reslut)) { foreach($mysql_chart_reslut as $item){ ?>
    ["<?php echo $item['time']?>", <?php echo $item['aborted_connects']?> ],
    <?php }}else{ ?>
    []    
    <?php } ?>
  ];
  var plot1 = $.jqplot('aborted_connects', [data1], {
    axes:{
        xaxis:{
            renderer:$.jqplot.DateAxisRenderer,
            pad:1.1,
            tickOptions: {  
                    mark: 'cross',    // 设置横（纵）坐标刻度在坐标轴上显示方式，分为坐标轴内，外，穿过坐标轴显示  
                                // 值也分为：'outside', 'inside' 和 'cross',  
                    showMark: false,     //设置是否显示刻度  
                    showGridLine: true, // 是否在图表区域显示刻度值方向的网格线  
                    markSize:0,        // 每个刻度线顶点距刻度线在坐标轴上点距离（像素为单位）  
                                //如果mark值为 'cross', 那么每个刻度线都有上顶点和下顶点，刻度线与坐标轴  
                                //在刻度线中间交叉，那么这时这个距离×2,  
                    show: true,         // 是否显示刻度线，与刻度线同方向的网格线，以及坐标轴上的刻度值  
                    showLabel: true,    // 是否显示刻度线以及坐标轴上的刻度值  
                    formatString: '',   // 梃置坐标轴上刻度值显示格式，eg:'%b %#d, %Y'表示格式"月 日，年"，"AUG 30,2008"  
                    fontSize:'',    //刻度值的字体大小  
                    fontFamily:'Tahoma', //刻度值上字体  
                    angle:40,           //刻度值与坐标轴夹角，角度为坐标轴正向顺时针方向  
                    fontWeight:'normal', //字体的粗细  
                    fontStretch:0,//刻度值在所在方向（坐标轴外）上的伸展(拉伸)度,

            }
        },  
    },
    
    title: {  
        text: "Aborted Connects<br/><?php echo $begin_time.' - '.$end_time; ?>",   // 设置当前图的标题  
        show: true,//设置当前标题是否显示 
        fontSize:'13px',    //刻度值的字体大小  
    },  
    seriesDefaults: {
              show: true,     // 设置是否渲染整个图表区域（即显示图表中内容）  
              xaxis: 'xaxis', // either 'xaxis' or 'x2axis'.  
              yaxis: 'yaxis', // either 'yaxis' or 'y2axis'.  
              label: '',      // 用于显示在分类名称框中的分类名称  
              color: '',      // 分类在图标中表示（折现，柱状图等）的颜色  
              lineWidth: 1.5, // 分类图（特别是折线图）宽度  
              shadow: true,   // 各图在图表中是否显示阴影区域   
              showLine: true,     //是否显示图表中的折线（折线图中的折线）  
              showMarker: false,   // 是否强调显示图中的数据节点  
              fill: false,        // 是否填充图表中折线下面的区域（填充颜色同折线颜色）以及legend 
              rendererOptions: {
                 smooth: true,
              },
              
    },
    series:[//如果有多个分类需要显示，这在此处设置各个分类的相关配置属性  
           //eg.设置各个分类在分类名称框中的分类名称  
            {label: 'aborted_connects'}
           //配置参数设置同seriesDefaults  
    ],  
    legend: {  
        show: true, //设置是否出现分类名称框（即所有分类的名称出现在图的某个位置） 
        label:'', 
        location: 'ne',     // 分类名称框出现位置, nw, n, ne, e, se, s, sw, w.  
        xoffset: 2,        // 分类名称框距图表区域上边框的距离（单位px）  
        yoffset: 2,        // 分类名称框距图表区域左边框的距离(单位px)  
        background:'',        //分类名称框距图表区域背景色  
        textColor:''          //分类名称框距图表区域内字体颜色  
    },    
    seriesColors: [ "#ff5800", "#EAA228", "#4bb2c5", "#839557", "#958c12",   
        "#953579", "#4b5de4", "#d8b83f", "#ff5800", "#0085cc"],  // 默认显示的分类颜色 
    highlighter: {
            show: true, 
            showLabel: true, 
            tooltipAxes: '',
            sizeAdjust: 1.5 , 
            tooltipLocation : 'ne',
    },
    cursor:{
            show: true, 
            zoom: true
    },
      
  });
});

//=========================dml=========================================//
$(document).ready(function(){  
  var data1=[
    <?php if(!empty($mysql_chart_reslut)) { foreach($mysql_chart_reslut as $item){ ?>
    ["<?php echo $item['time']?>", <?php echo $item['com_select_persecond']?> ],
    <?php }}else{ ?>
    []    
    <?php } ?>
  ];
  var data2=[
    <?php if(!empty($mysql_chart_reslut)) { foreach($mysql_chart_reslut as $item){ ?>
    ["<?php echo $item['time']?>", <?php echo $item['com_insert_persecond']?> ],
    <?php }}else{ ?>
    []    
    <?php } ?>
  ];
   var data3=[
    <?php if(!empty($mysql_chart_reslut)) { foreach($mysql_chart_reslut as $item){ ?>
    ["<?php echo $item['time']?>", <?php echo $item['com_update_persecond']?> ],
    <?php }}else{ ?>
    []    
    <?php } ?>
  ];
   var data4=[
    <?php if(!empty($mysql_chart_reslut)) { foreach($mysql_chart_reslut as $item){ ?>
    ["<?php echo $item['time']?>", <?php echo $item['com_delete_persecond']?> ],
    <?php }}else{ ?>
    []    
    <?php } ?>
  ];
  var plot1 = $.jqplot('dml', [data1,data2,data3,data4], {
    axes:{xaxis:{renderer:$.jqplot.DateAxisRenderer}},
    seriesDefaults: {
              show: true,     // 设置是否渲染整个图表区域（即显示图表中内容）  
              xaxis: 'xaxis', // either 'xaxis' or 'x2axis'.  
              yaxis: 'yaxis', // either 'yaxis' or 'y2axis'.  
              label: '',      // 用于显示在分类名称框中的分类名称  
              color: '',      // 分类在图标中表示（折现，柱状图等）的颜色  
              lineWidth: 1.5, // 分类图（特别是折线图）宽度  
              shadow: true,   // 各图在图表中是否显示阴影区域   
              showLine: true,     //是否显示图表中的折线（折线图中的折线）  
              showMarker: false,   // 是否强调显示图中的数据节点  
              fill: false,        // 是否填充图表中折线下面的区域（填充颜色同折线颜色）以及legend 
              rendererOptions: {
                 smooth: true,
              }
    },
    title: {  
        text: "DML Persecond<br/> <?php echo $begin_time.' - '.$end_time; ?>",   // 设置当前图的标题  
        show: true,//设置当前标题是否显示 
        fontSize:'13px',    //刻度值的字体大小  
    },
    series:[//如果有多个分类需要显示，这在此处设置各个分类的相关配置属性  
           //eg.设置各个分类在分类名称框中的分类名称  
            {label: 'select'},{label: 'insert'},{label: 'update'},{label: 'delete'}
           //配置参数设置同seriesDefaults  
    ],  
    legend: {  
        show: true, //设置是否出现分类名称框（即所有分类的名称出现在图的某个位置） 
        label:'', 
        location: 'ne',     // 分类名称框出现位置, nw, n, ne, e, se, s, sw, w.  
        xoffset: 2,        // 分类名称框距图表区域上边框的距离（单位px）  
        yoffset: 2,        // 分类名称框距图表区域左边框的距离(单位px)  
        background:'',        //分类名称框距图表区域背景色  
        textColor:''          //分类名称框距图表区域内字体颜色  
    },    
    seriesColors: [ "#ff5800", "#EAA228", "#4bb2c5", "#839557", "#958c12",   
        "#953579", "#4b5de4", "#d8b83f", "#ff5800", "#0085cc"],  // 默认显示的分类颜色
    highlighter: {
            show: true, 
            showLabel: true, 
            tooltipAxes: '',
            sizeAdjust: 1.5 , 
            tooltipLocation : 'ne',
    },
    cursor:{
            show: true, 
            zoom: true
    }  
    
  });
});

//=========================queries=========================================//
$(document).ready(function(){  
  var data1=[
    <?php if(!empty($mysql_chart_reslut)) { foreach($mysql_chart_reslut as $item){ ?>
    ["<?php echo $item['time']?>", <?php echo $item['queries_persecond']?> ],
    <?php }}else{ ?>
    []    
    <?php } ?>
  ];
  var data2=[
    <?php if(!empty($mysql_chart_reslut)) { foreach($mysql_chart_reslut as $item){ ?>
    ["<?php echo $item['time']?>", <?php echo $item['questions_persecond']?> ],
    <?php }}else{ ?>
    []    
    <?php } ?>
  ];
  var plot1 = $.jqplot('queries', [data1,data2], {
    axes:{xaxis:{renderer:$.jqplot.DateAxisRenderer}},
    seriesDefaults: {
              show: true,     // 设置是否渲染整个图表区域（即显示图表中内容）  
              xaxis: 'xaxis', // either 'xaxis' or 'x2axis'.  
              yaxis: 'yaxis', // either 'yaxis' or 'y2axis'.  
              label: '',      // 用于显示在分类名称框中的分类名称  
              color: '',      // 分类在图标中表示（折现，柱状图等）的颜色  
              lineWidth: 1.5, // 分类图（特别是折线图）宽度  
              shadow: true,   // 各图在图表中是否显示阴影区域   
              showLine: true,     //是否显示图表中的折线（折线图中的折线）  
              showMarker: false,   // 是否强调显示图中的数据节点  
              fill: false,        // 是否填充图表中折线下面的区域（填充颜色同折线颜色）以及legend 
              rendererOptions: {
                 smooth: true,
              }
    },
    title: {  
        text: "Queries Persecond<br/> <?php echo $begin_time.' - '.$end_time; ?>",   // 设置当前图的标题  
        show: true,//设置当前标题是否显示 
        fontSize:'13px',    //刻度值的字体大小  
    },
    series:[//如果有多个分类需要显示，这在此处设置各个分类的相关配置属性  
           //eg.设置各个分类在分类名称框中的分类名称  
           {label: 'queries'},{label: 'questions'}
           //配置参数设置同seriesDefaults  
    ],  
    legend: {  
        show: true, //设置是否出现分类名称框（即所有分类的名称出现在图的某个位置） 
        label:'', 
        location: 'ne',     // 分类名称框出现位置, nw, n, ne, e, se, s, sw, w.  
        xoffset: 2,        // 分类名称框距图表区域上边框的距离（单位px）  
        yoffset: 2,        // 分类名称框距图表区域左边框的距离(单位px)  
        background:'',        //分类名称框距图表区域背景色  
        textColor:''          //分类名称框距图表区域内字体颜色  
    },    
    seriesColors: [ "#ff5800", "#EAA228", "#4bb2c5", "#839557", "#958c12",   
        "#953579", "#4b5de4", "#d8b83f", "#ff5800", "#0085cc"],  // 默认显示的分类颜色
    highlighter: {
            show: true, 
            showLabel: true, 
            tooltipAxes: '',
            sizeAdjust: 1.5 , 
            tooltipLocation : 'ne',
    },
    cursor:{
            show: true, 
            zoom: true
    }  
    
  });
});


//=========================transaction=========================================//
$(document).ready(function(){  
  var data1=[
    <?php if(!empty($mysql_chart_reslut)) { foreach($mysql_chart_reslut as $item){ ?>
    ["<?php echo $item['time']?>", <?php echo $item['com_commit_persecond']?> ],
    <?php }}else{ ?>
    []    
    <?php } ?>
  ];
  var data2=[
    <?php if(!empty($mysql_chart_reslut)) { foreach($mysql_chart_reslut as $item){ ?>
    ["<?php echo $item['time']?>", <?php echo $item['com_rollback_persecond']?> ],
    <?php }}else{ ?>
    []    
    <?php } ?>
  ];
  var plot1 = $.jqplot('transaction', [data1,data2], {
    axes:{xaxis:{renderer:$.jqplot.DateAxisRenderer}},
    seriesDefaults: {
              show: true,     // 设置是否渲染整个图表区域（即显示图表中内容）  
              xaxis: 'xaxis', // either 'xaxis' or 'x2axis'.  
              yaxis: 'yaxis', // either 'yaxis' or 'y2axis'.  
              label: '',      // 用于显示在分类名称框中的分类名称  
              color: '',      // 分类在图标中表示（折现，柱状图等）的颜色  
              lineWidth: 1.5, // 分类图（特别是折线图）宽度  
              shadow: true,   // 各图在图表中是否显示阴影区域   
              showLine: true,     //是否显示图表中的折线（折线图中的折线）  
              showMarker: false,   // 是否强调显示图中的数据节点  
              fill: false,        // 是否填充图表中折线下面的区域（填充颜色同折线颜色）以及legend 
              rendererOptions: {
                 smooth: true,
              }
    },
    title: {  
        text: "Transaction Persecond<br/> <?php echo $begin_time.' - '.$end_time; ?>",   // 设置当前图的标题  
        show: true,//设置当前标题是否显示 
        fontSize:'13px',    //刻度值的字体大小  
    },
    series:[//如果有多个分类需要显示，这在此处设置各个分类的相关配置属性  
           //eg.设置各个分类在分类名称框中的分类名称  
           {label: 'commit'},{label: 'rollback'}
           //配置参数设置同seriesDefaults  
    ],  
    legend: {  
        show: true, //设置是否出现分类名称框（即所有分类的名称出现在图的某个位置） 
        label:'', 
        location: 'ne',     // 分类名称框出现位置, nw, n, ne, e, se, s, sw, w.  
        xoffset: 2,        // 分类名称框距图表区域上边框的距离（单位px）  
        yoffset: 2,        // 分类名称框距图表区域左边框的距离(单位px)  
        background:'',        //分类名称框距图表区域背景色  
        textColor:''          //分类名称框距图表区域内字体颜色  
    },    
    seriesColors: [ "#ff5800", "#EAA228", "#4bb2c5", "#839557", "#958c12",   
        "#953579", "#4b5de4", "#d8b83f", "#ff5800", "#0085cc"],  // 默认显示的分类颜色
    highlighter: {
            show: true, 
            showLabel: true, 
            tooltipAxes: '',
            sizeAdjust: 1.5 , 
            tooltipLocation : 'ne',
    },
    cursor:{
            show: true, 
            zoom: true
    }  
    
  });
});



//==========================CPU Chart=========================================//
$(document).ready(function(){  
  var data1=[
    <?php if(!empty($os_chart_reslut)) { foreach($os_chart_reslut as $item){ ?>
    ["<?php echo $item['time']?>", <?php echo $item['load_1']?> ],
    <?php }}else{ ?>
    []    
    <?php } ?>
  ];
  var data2=[
    <?php if(!empty($os_chart_reslut)) { foreach($os_chart_reslut as $item){ ?>
    ["<?php echo $item['time']?>", <?php echo $item['load_5']?> ],
    <?php }}else{ ?>
    []    
    <?php } ?>
  ];
  var data3=[
    <?php if(!empty($os_chart_reslut)) { foreach($os_chart_reslut as $item){ ?>
    ["<?php echo $item['time']?>", <?php echo $item['load_15']?> ],
    <?php }}else{ ?>
    []    
    <?php } ?>
  ];
  var plot1 = $.jqplot('cpu_load', [data1,data2,data3], {
    axes:{xaxis:{renderer:$.jqplot.DateAxisRenderer}},
    seriesDefaults: {
              show: true,     // 设置是否渲染整个图表区域（即显示图表中内容）  
              xaxis: 'xaxis', // either 'xaxis' or 'x2axis'.  
              yaxis: 'yaxis', // either 'yaxis' or 'y2axis'.  
              label: '',      // 用于显示在分类名称框中的分类名称  
              color: '',      // 分类在图标中表示（折现，柱状图等）的颜色  
              lineWidth: 1.5, // 分类图（特别是折线图）宽度  
              shadow: true,   // 各图在图表中是否显示阴影区域   
              showLine: true,     //是否显示图表中的折线（折线图中的折线）  
              showMarker: false,   // 是否强调显示图中的数据节点  
              fill: false,        // 是否填充图表中折线下面的区域（填充颜色同折线颜色）以及legend 
              rendererOptions: {
                 smooth: true,
              }
    },
    title: {  
        text: "Host Load<br/> <?php echo $begin_time.' - '.$end_time; ?>",   // 设置当前图的标题  
        show: true,//设置当前标题是否显示 
        fontSize:'13px',    //刻度值的字体大小  
    },
    series:[//如果有多个分类需要显示，这在此处设置各个分类的相关配置属性  
           //eg.设置各个分类在分类名称框中的分类名称  
            {label: 'load 1'},{label: 'load 5'},{label: 'load 15'}
           //配置参数设置同seriesDefaults  
    ],  
    legend: {  
        show: true, //设置是否出现分类名称框（即所有分类的名称出现在图的某个位置） 
        label:'', 
        location: 'ne',     // 分类名称框出现位置, nw, n, ne, e, se, s, sw, w.  
        xoffset: 5,        // 分类名称框距图表区域上边框的距离（单位px）  
        yoffset: 5,        // 分类名称框距图表区域左边框的距离(单位px)  
        background:'',        //分类名称框距图表区域背景色  
        textColor:''          //分类名称框距图表区域内字体颜色  
    },    
    seriesColors: [ "#ff5800", "#EAA228", "#4bb2c5", "#839557", "#958c12",   
        "#953579", "#4b5de4", "#d8b83f", "#ff5800", "#0085cc"],  // 默认显示的分类颜色
    highlighter: {
            show: true, 
            showLabel: true, 
            tooltipAxes: '',
            sizeAdjust: 1.5 , 
            tooltipLocation : 'ne',
    },
    cursor:{
            show: true, 
            zoom: true
    }  
    
  });
});

$(document).ready(function(){
  var data1=[
    <?php if(!empty($os_chart_reslut)) { foreach($os_chart_reslut as $item){ ?>
    ["<?php echo $item['time']?>", <?php echo $item['cpu_user_time']?> ],
    <?php }}else{ ?>
    []    
    <?php } ?>
  ];
  var data2=[
    <?php if(!empty($os_chart_reslut)) { foreach($os_chart_reslut as $item){ ?>
    ["<?php echo $item['time']?>", <?php echo $item['cpu_system_time']?> ],
    <?php }}else{ ?>
    []    
    <?php } ?>
  ];
  var data3=[
    <?php if(!empty($os_chart_reslut)) { foreach($os_chart_reslut as $item){ ?>
    ["<?php echo $item['time']?>", <?php echo $item['cpu_idle_time']?> ],
    <?php }}else{ ?>
    []    
    <?php } ?>
  ];
  var plot1 = $.jqplot('cpu_utilization', [data1,data2,data3], {
    axes:{xaxis:{renderer:$.jqplot.DateAxisRenderer}},
    seriesDefaults: {
              show: true,     // 设置是否渲染整个图表区域（即显示图表中内容）  
              xaxis: 'xaxis', // either 'xaxis' or 'x2axis'.  
              yaxis: 'yaxis', // either 'yaxis' or 'y2axis'.  
              label: '',      // 用于显示在分类名称框中的分类名称  
              color: '',      // 分类在图标中表示（折现，柱状图等）的颜色  
              lineWidth: 1.5, // 分类图（特别是折线图）宽度  
              shadow: true,   // 各图在图表中是否显示阴影区域   
              showLine: true,     //是否显示图表中的折线（折线图中的折线）  
              showMarker: false,   // 是否强调显示图中的数据节点  
              fill: false,        // 是否填充图表中折线下面的区域（填充颜色同折线颜色）以及legend 
              rendererOptions: {
                 smooth: true,
              }
    },
    title: {  
        text: "Cpu Usage<br/> <?php echo $begin_time.' - '.$end_time; ?>",   // 设置当前图的标题  
        show: true,//设置当前标题是否显示 
        fontSize:'13px',    //刻度值的字体大小  
    },
    series:[//如果有多个分类需要显示，这在此处设置各个分类的相关配置属性  
           //eg.设置各个分类在分类名称框中的分类名称  
            {label: 'cpu user time'},{label: 'cpu system time'},{label: 'cpu idle time'}
           //配置参数设置同seriesDefaults  
    ],  
    legend: {  
        show: true, //设置是否出现分类名称框（即所有分类的名称出现在图的某个位置） 
        label:'', 
        location: 'ne',     // 分类名称框出现位置, nw, n, ne, e, se, s, sw, w.  
        xoffset: 5,        // 分类名称框距图表区域上边框的距离（单位px）  
        yoffset: 5,        // 分类名称框距图表区域左边框的距离(单位px)  
        background:'',        //分类名称框距图表区域背景色  
        textColor:''          //分类名称框距图表区域内字体颜色  
    },    
    seriesColors: [ "#ff5800", "#EAA228", "#4bb2c5", "#839557", "#958c12",   
        "#953579", "#4b5de4", "#d8b83f", "#ff5800", "#0085cc"],  // 默认显示的分类颜色
    highlighter: {
            show: true, 
            showLabel: true, 
            tooltipAxes: '',
            sizeAdjust: 1.5 , 
            tooltipLocation : 'ne',
    },
    cursor:{
            show: true, 
            zoom: true
    }  
    
  });
});

$(document).ready(function(){
   var data1=[
    <?php if(!empty($os_chart_reslut)) { foreach($os_chart_reslut as $item){ ?>
    ["<?php echo $item['time']?>", <?php echo $item['process']?> ],
    <?php }}else{ ?>
    []    
    <?php } ?>
  ];
  var plot1 = $.jqplot('process', [data1], {
    axes:{xaxis:{renderer:$.jqplot.DateAxisRenderer}},
    seriesDefaults: {
              show: true,     // 设置是否渲染整个图表区域（即显示图表中内容）  
              xaxis: 'xaxis', // either 'xaxis' or 'x2axis'.  
              yaxis: 'yaxis', // either 'yaxis' or 'y2axis'.  
              label: '',      // 用于显示在分类名称框中的分类名称  
              color: '',      // 分类在图标中表示（折现，柱状图等）的颜色  
              lineWidth: 1.5, // 分类图（特别是折线图）宽度  
              shadow: true,   // 各图在图表中是否显示阴影区域   
              showLine: true,     //是否显示图表中的折线（折线图中的折线）  
              showMarker: false,   // 是否强调显示图中的数据节点  
              fill: false,        // 是否填充图表中折线下面的区域（填充颜色同折线颜色）以及legend 
              rendererOptions: {
                 smooth: true,
              }
    },
    title: {  
        text: "Cpu Process<br/> <?php echo $begin_time.' - '.$end_time; ?>",   // 设置当前图的标题  
        show: true,//设置当前标题是否显示 
        fontSize:'13px',    //刻度值的字体大小  
    },
    series:[//如果有多个分类需要显示，这在此处设置各个分类的相关配置属性  
           //eg.设置各个分类在分类名称框中的分类名称  
            {label: 'cpu process'}
           //配置参数设置同seriesDefaults  
    ],  
    legend: {  
        show: true, //设置是否出现分类名称框（即所有分类的名称出现在图的某个位置） 
        label:'', 
        location: 'ne',     // 分类名称框出现位置, nw, n, ne, e, se, s, sw, w.  
        xoffset: 5,        // 分类名称框距图表区域上边框的距离（单位px）  
        yoffset: 5,        // 分类名称框距图表区域左边框的距离(单位px)  
        background:'',        //分类名称框距图表区域背景色  
        textColor:''          //分类名称框距图表区域内字体颜色  
    },    
    seriesColors: [ "#ff5800", "#EAA228", "#4bb2c5", "#839557", "#958c12",   
        "#953579", "#4b5de4", "#d8b83f", "#ff5800", "#0085cc"],  // 默认显示的分类颜色
    highlighter: {
            show: true, 
            showLabel: true, 
            tooltipAxes: '',
            sizeAdjust: 1.5 , 
            tooltipLocation : 'ne',
    },
    cursor:{
            show: true, 
            zoom: true
    }  
    
  });
});

//===================================================================//

</script>