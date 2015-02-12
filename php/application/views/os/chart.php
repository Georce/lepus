<div class="header">
            
            <h1 class="page-title"><?php echo $this->lang->line('host'); ?> <?php echo $this->lang->line('_Chart'); ?></h1>
</div>
        
<ul class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><?php echo $this->lang->line('home'); ?></a> <span class="divider">/</span></li>
            <li class="active"><?php echo $this->lang->line('_OS Monitor'); ?></li><span class="divider">/</span></li>
            <li class="active"><?php echo $this->lang->line('_Chart'); ?></li>
            
</ul>

<div class="container-fluid">
<div class="row-fluid">

<div class="btn-toolbar">
                <div class="btn-group">
                   <a class="btn btn-default <?php if($begin_time=='30') echo 'active'; ?>" href="<?php echo site_url('lp_os/chart/'.$cur_host.'/30/min') ?>"><i class="fui-calendar-16"></i>&nbsp;30 <?php echo $this->lang->line('date_minutes'); ?></a>
                  <a class="btn btn-default <?php if($begin_time=='60') echo 'active'; ?>" href="<?php echo site_url('lp_os/chart/'.$cur_host.'/60/hour') ?>"><i class="fui-calendar-16"></i>&nbsp;1 <?php echo $this->lang->line('date_hours'); ?></a>
                  <a class="btn btn-default <?php if($begin_time=='180') echo 'active'; ?>" href="<?php echo site_url('lp_os/chart/'.$cur_host.'/180/hour') ?>"><i class="fui-calendar-16"></i>&nbsp;3 <?php echo $this->lang->line('date_hours'); ?></a>
                  <a class="btn btn-default <?php if($begin_time=='360') echo 'active'; ?>" href="<?php echo site_url('lp_os/chart/'.$cur_host.'/360/hour') ?>"><i class="fui-calendar-16"></i>&nbsp;6 <?php echo $this->lang->line('date_hours'); ?></a>
                  <a class="btn btn-default <?php if($begin_time=='720') echo 'active'; ?>" href="<?php echo site_url('lp_os/chart/'.$cur_host.'/720/hour') ?>"><i class="fui-calendar-16"></i>&nbsp;12 <?php echo $this->lang->line('date_hours'); ?></a>
                  <a class="btn btn-default <?php if($begin_time=='1440') echo 'active'; ?>" href="<?php echo site_url('lp_os/chart/'.$cur_host.'/1440/day') ?>"><i class="fui-calendar-16"></i>&nbsp;1 <?php echo $this->lang->line('date_days'); ?></a>
                  <a class="btn btn-default <?php if($begin_time=='4320') echo 'active'; ?>" href="<?php echo site_url('lp_os/chart/'.$cur_host.'/4320/day') ?>"><i class="fui-calendar-16"></i>&nbsp;3 <?php echo $this->lang->line('date_days'); ?></a>
                  <a class="btn btn-default <?php if($begin_time=='10080') echo 'active'; ?>" href="<?php echo site_url('lp_os/chart/'.$cur_host.'/10080/day') ?>"><i class="fui-calendar-16"></i>&nbsp;1 <?php echo $this->lang->line('date_weeks'); ?></a>
                </div>
</div> <!-- /toolbar -->             
<hr/>
<div id="cpu" style="margin-top:5px; margin-left:10px; width:32%; height:240px; float: left;"></div>
<div id="disk_memory" style="margin-top:5px; margin-left:10px; width:32%; height:240px; float: left;"></div>
<div id="disk_swap" style="margin-top:5px; margin-left:10px; width:32%; height:240px;float: left;"></div>
<?php if(!empty($diskinfo)) {?>
<?php foreach ($diskinfo  as $disk):?>
<div id="disk_<?php echo $disk['id']; ?>" style="margin-top:5px; margin-left:10px; width:32%; height:240px; float: left;"></div>
<?php endforeach;?>
<?php } ?>
<div style="clear:both;"></div>
<div id="cpu_load" style="margin-top:5px; margin-left:10px; width:96%; height:300px;"></div>
<div id="cpu_utilization" style="margin-top:5px; margin-left:10px; width:96%; height:300px;"></div>
<div id="process" style="margin-top:5px; margin-left:10px; width:96%; height:300px; "></div>
<div id="network" style="margin-top:5px; margin-left:10px; width:96%; height:300px; "></div>
<div id="diskio" style="margin-top:5px; margin-left:10px; width:96%; height:300px; "></div>


<script type="text/javascript" src="./lib/jqplot/jquery.jqplot.min.js"></script>
<script type="text/javascript" src="./lib/jqplot/plugins/jqplot.canvasTextRenderer.min.js"></script>
<script type="text/javascript" src="./lib/jqplot/plugins/jqplot.canvasAxisLabelRenderer.min.js"></script>
<script type="text/javascript" src="./lib/jqplot/plugins/jqplot.dateAxisRenderer.min.js"></script>
<script type="text/javascript" src="./lib/jqplot/plugins/jqplot.highlighter.min.js"></script>
<script type="text/javascript" src="./lib/jqplot/plugins/jqplot.cursor.min.js"></script>
<script type="text/javascript" src="./lib/jqplot/plugins/jqplot.pieRenderer.min.js"></script>
<script type="text/javascript" src="./lib/jqplot/plugins/jqplot.donutRenderer.min.js"></script>
<link href="./lib/jqplot/jquery.jqplot.min.css"  rel="stylesheet">

<script>

$(document).ready(function(){
  var data1=[
    <?php if(!empty($chart_reslut)) { foreach($chart_reslut as $item){ ?>
    ["<?php echo $item['time']?>", <?php echo $item['load_1']?> ],
    <?php }}else{ ?>
    []    
    <?php } ?>
  ];
  var data2=[
    <?php if(!empty($chart_reslut)) { foreach($chart_reslut as $item){ ?>
    ["<?php echo $item['time']?>", <?php echo $item['load_5']?> ],
    <?php }}else{ ?>
    []    
    <?php } ?>
  ];
  var data3=[
    <?php if(!empty($chart_reslut)) { foreach($chart_reslut as $item){ ?>
    ["<?php echo $item['time']?>", <?php echo $item['load_15']?> ],
    <?php }}else{ ?>
    []    
    <?php } ?>
  ];
  var plot1 = $.jqplot('cpu_load', [data1,data2,data3], {
    seriesDefaults: {
              show: true,     // 设置是否渲染整个图表区域（即显示图表中内容）  
              xaxis: 'xaxis', // either 'xaxis' or 'x2axis'.  
              yaxis: 'yaxis', // either 'yaxis' or 'y2axis'.  
              label: '',      // 用于显示在分类名称框中的分类名称  
              color: '',      // 分类在图标中表示（折现，柱状图等）的颜色  
              lineWidth: 1.5, // 分类图（特别是折线图）宽度  
              shadow: true,   // 各图在图表中是否显示阴影区域  
              shadowAngle: 45,    // 参考grid中相同参数  
              shadowOffset: 1.25, // 参考grid中相同参数  
              shadowDepth: 3,     // 参考grid中相同参数  
              shadowAlpha: 0.1,   // 参考grid中相同参数  
              showLine: true,     //是否显示图表中的折线（折线图中的折线）  
              showMarker: false,   // 是否强调显示图中的数据节点  
              fill: false,        // 是否填充图表中折线下面的区域（填充颜色同折线颜色）以及legend 
              rendererOptions: {
                 smooth: true,
              }
    },
    series:[//如果有多个分类需要显示，这在此处设置各个分类的相关配置属性  
           //eg.设置各个分类在分类名称框中的分类名称  
            {label: 'load 1'},{label: 'load 5'},{label: 'load 15'}
           //配置参数设置同seriesDefaults  
    ],  
    legend: {  
        show: true, //设置是否出现分类名称框（即所有分类的名称出现在图的某个位置） 
        label:'123', 
        location: 'ne',     // 分类名称框出现位置, nw, n, ne, e, se, s, sw, w.  
        xoffset: 12,        // 分类名称框距图表区域上边框的距离（单位px）  
        yoffset: 12,        // 分类名称框距图表区域左边框的距离(单位px)  
        background:'',        //分类名称框距图表区域背景色  
        textColor:''          //分类名称框距图表区域内字体颜色  
    },  
    seriesColors: [ "#ff5800", "#EAA228", "#4bb2c5", "#839557", "#958c12",   
        "#953579", "#4b5de4", "#d8b83f", "#ff5800", "#0085cc"],  // 默认显示的分类颜色  
    title:{
         text:"<?php echo $cur_host; ?> <?php echo $this->lang->line('load'); ?> <?php echo $this->lang->line('chart'); ?>",
         show:true,
         fontSize:'13px',
         textColor:'#666',
    },
    
    axes:{
        xaxis:{
            renderer:$.jqplot.DateAxisRenderer,
            tickOptions:{formatString:"<?php echo $chart_option['formatString']; ?>"},
            tickInterval:"",
            label: "",
        },
        yaxis: {  
                renderer: $.jqplot.LogAxisRenderer,
                tickOptions:{ suffix: '' } 
        } 
    },
    highlighter: {
            show: true, 
            showLabel: true, 
            tooltipAxes: '',
            sizeAdjust: 7.5 , tooltipLocation : 'ne'
    },
    cursor:{
            show: true, 
            zoom: true
    }
   
  });
});


$(document).ready(function(){
  var data1=[
    <?php if(!empty($chart_reslut)) { foreach($chart_reslut as $item){ ?>
    ["<?php echo $item['time']?>", <?php echo $item['cpu_user_time']?> ],
    <?php }}else{ ?>
    []    
    <?php } ?>
  ];
  var data2=[
    <?php if(!empty($chart_reslut)) { foreach($chart_reslut as $item){ ?>
    ["<?php echo $item['time']?>", <?php echo $item['cpu_system_time']?> ],
    <?php }}else{ ?>
    []    
    <?php } ?>
  ];
  var data3=[
    <?php if(!empty($chart_reslut)) { foreach($chart_reslut as $item){ ?>
    ["<?php echo $item['time']?>", <?php echo $item['cpu_idle_time']?> ],
    <?php }}else{ ?>
    []    
    <?php } ?>
  ];
  var plot1 = $.jqplot('cpu_utilization', [data1,data2,data3], {
    seriesDefaults: {
              show: true,     // 设置是否渲染整个图表区域（即显示图表中内容）  
              xaxis: 'xaxis', // either 'xaxis' or 'x2axis'.  
              yaxis: 'yaxis', // either 'yaxis' or 'y2axis'.  
              label: '',      // 用于显示在分类名称框中的分类名称  
              color: '',      // 分类在图标中表示（折现，柱状图等）的颜色  
              lineWidth: 1.5, // 分类图（特别是折线图）宽度  
              shadow: true,   // 各图在图表中是否显示阴影区域  
              shadowAngle: 45,    // 参考grid中相同参数  
              shadowOffset: 1.25, // 参考grid中相同参数  
              shadowDepth: 3,     // 参考grid中相同参数  
              shadowAlpha: 0.1,   // 参考grid中相同参数  
              showLine: true,     //是否显示图表中的折线（折线图中的折线）  
              showMarker: false,   // 是否强调显示图中的数据节点  
              fill: false,        // 是否填充图表中折线下面的区域（填充颜色同折线颜色）以及legend 
              rendererOptions: {
                 smooth: true,
              }
    },
    series:[//如果有多个分类需要显示，这在此处设置各个分类的相关配置属性  
           //eg.设置各个分类在分类名称框中的分类名称  
            {label: '<?php echo $this->lang->line('user'); ?>'},{label: '<?php echo $this->lang->line('system'); ?>'},{label: '<?php echo $this->lang->line('idle'); ?>'}
           //配置参数设置同seriesDefaults  
    ],  
    legend: {  
        show: true, //设置是否出现分类名称框（即所有分类的名称出现在图的某个位置） 
        label:'123', 
        location: 'ne',     // 分类名称框出现位置, nw, n, ne, e, se, s, sw, w.  
        xoffset: 12,        // 分类名称框距图表区域上边框的距离（单位px）  
        yoffset: 12,        // 分类名称框距图表区域左边框的距离(单位px)  
        background:'',        //分类名称框距图表区域背景色  
        textColor:''          //分类名称框距图表区域内字体颜色  
    },  
    seriesColors: [ "#ff5800", "#EAA228", "#00CC00", "#839557", "#958c12",   
        "#953579", "#4b5de4", "#d8b83f", "#ff5800", "#0085cc"],  // 默认显示的分类颜色  
    title:{
         text:"<?php echo $cur_host; ?> <?php echo $this->lang->line('cpu'); ?> <?php echo $this->lang->line('chart'); ?>",
         show:true,
         fontSize:'13px',
         textColor:'#666',
    },
    
    axes:{
        xaxis:{
            renderer:$.jqplot.DateAxisRenderer,
            tickOptions:{formatString:"<?php echo $chart_option['formatString']; ?>"},
            tickInterval:"",
            label: "",
        },
        yaxis: {  
                renderer: $.jqplot.LogAxisRenderer,
                tickOptions:{ suffix: '' } 
        } 
    },
    highlighter: {
            show: true, 
            showLabel: true, 
            tooltipAxes: '',
            sizeAdjust: 7.5 , tooltipLocation : 'ne'
    },
    cursor:{
            show: true, 
            zoom: true
    }
   
  });
});


$(document).ready(function(){
  var data1=[
    <?php if(!empty($chart_reslut)) { foreach($chart_reslut as $item){ ?>
    ["<?php echo $item['time']?>", <?php echo $item['process']?> ],
    <?php }}else{ ?>
    []    
    <?php } ?>
  ];
  var plot1 = $.jqplot('process', [data1], {
    seriesDefaults: {
          rendererOptions: {
              smooth: true
          }
    },
    seriesColors: [ "#4bb2c5", "#EAA228", "#579575", "#839557", "#958c12",   
        "#953579", "#4b5de4", "#d8b83f", "#ff5800", "#0085cc"],  // 默认显示的分类颜色
    title:{
         text:"<?php echo $cur_host; ?> <?php echo $this->lang->line('process'); ?> <?php echo $this->lang->line('chart'); ?>",
         show:true,
         fontSize:'13px',
         textColor:'#666',
    },
    axes:{
        xaxis:{
            renderer:$.jqplot.DateAxisRenderer,
            tickOptions:{formatString:"<?php echo $chart_option['formatString']; ?>"},
            tickInterval:"",
            label: "",
        },
        yaxis: {  
                renderer: $.jqplot.LogAxisRenderer,
                tickOptions:{ suffix: '' } 
        } 
    },
    highlighter: {
            show: true, 
            showLabel: true, 
            tooltipAxes: '',
            sizeAdjust: 7.5 , tooltipLocation : 'ne'
    },
    cursor:{
            show: true, 
            zoom: true
    },
    series:[{showMarker:false, lineWidth:2, markerOptions:{style:'filledCircle'}}]
  });
});


$(document).ready(function(){
  var data1=[
    <?php if(!empty($chart_reslut)) { foreach($chart_reslut as $item){ ?>
    ["<?php echo $item['time']?>", <?php echo number_format($item['net_in_bytes_total']/1024)?> ],
    <?php }}else{ ?>
    []    
    <?php } ?>
  ];
  var data2=[
    <?php if(!empty($chart_reslut)) { foreach($chart_reslut as $item){ ?>
    ["<?php echo $item['time']?>", <?php echo number_format($item['net_out_bytes_total']/1024) ?> ],
    <?php }}else{ ?>
    []    
    <?php } ?>
  ];
  var plot1 = $.jqplot('network', [data1,data2], {
    seriesDefaults: {
              show: true,     // 设置是否渲染整个图表区域（即显示图表中内容）  
              xaxis: 'xaxis', // either 'xaxis' or 'x2axis'.  
              yaxis: 'yaxis', // either 'yaxis' or 'y2axis'.  
              label: '',      // 用于显示在分类名称框中的分类名称  
              color: '',      // 分类在图标中表示（折现，柱状图等）的颜色  
              lineWidth: 1.5, // 分类图（特别是折线图）宽度  
              shadow: true,   // 各图在图表中是否显示阴影区域  
              shadowAngle: 45,    // 参考grid中相同参数  
              shadowOffset: 1.25, // 参考grid中相同参数  
              shadowDepth: 3,     // 参考grid中相同参数  
              shadowAlpha: 0.1,   // 参考grid中相同参数  
              showLine: true,     //是否显示图表中的折线（折线图中的折线）  
              showMarker: false,   // 是否强调显示图中的数据节点  
              fill: false,        // 是否填充图表中折线下面的区域（填充颜色同折线颜色）以及legend 
              rendererOptions: {
                 smooth: true,
              }
    },
    series:[//如果有多个分类需要显示，这在此处设置各个分类的相关配置属性  
           //eg.设置各个分类在分类名称框中的分类名称  
            {label: '<?php echo $this->lang->line('in'); ?> <?php echo $this->lang->line('flow'); ?> '},{label: '<?php echo $this->lang->line('out'); ?> <?php echo $this->lang->line('flow'); ?>'}
           //配置参数设置同seriesDefaults  
    ],  
    legend: {  
        show: true, //设置是否出现分类名称框（即所有分类的名称出现在图的某个位置） 
        label:'123', 
        location: 'ne',     // 分类名称框出现位置, nw, n, ne, e, se, s, sw, w.  
        xoffset: 12,        // 分类名称框距图表区域上边框的距离（单位px）  
        yoffset: 12,        // 分类名称框距图表区域左边框的距离(单位px)  
        background:'',        //分类名称框距图表区域背景色  
        textColor:''          //分类名称框距图表区域内字体颜色  
    },  
    seriesColors: [ "#6699FF", "#FF9933", "#579575", "#839557", "#958c12",   
        "#953579", "#4b5de4", "#d8b83f", "#ff5800", "#0085cc"],  // 默认显示的分类颜色   
    title:{
         text:"<?php echo $cur_host; ?> <?php echo $this->lang->line('network'); ?> <?php echo $this->lang->line('flow'); ?> <?php echo $this->lang->line('chart'); ?>",
         show:true,
         fontSize:'13px',
         textColor:'#666',
    },
    
    axes:{
        xaxis:{
            renderer:$.jqplot.DateAxisRenderer,
            tickOptions:{formatString:"<?php echo $chart_option['formatString']; ?>"},
            tickInterval:"",
            label: "",
        },
        yaxis: {  
                renderer: $.jqplot.LogAxisRenderer,
                tickOptions:{ suffix: 'kb' } 
        } 
    },
    highlighter: {
            show: true, 
            showLabel: true, 
            tooltipAxes: '',
            sizeAdjust: 7.5 , tooltipLocation : 'ne'
    },
    cursor:{
            show: true, 
            zoom: true
    }
   
  });
});


$(document).ready(function(){
  var data1=[
    <?php if(!empty($chart_reslut)) { foreach($chart_reslut as $item){ ?>
    ["<?php echo $item['time']?>", <?php echo number_format($item['disk_io_reads_total'])?> ],
    <?php }}else{ ?>
    []    
    <?php } ?>
  ];
  var data2=[
    <?php if(!empty($chart_reslut)) { foreach($chart_reslut as $item){ ?>
    ["<?php echo $item['time']?>", <?php echo number_format($item['disk_io_writes_total']) ?> ],
    <?php }}else{ ?>
    []    
    <?php } ?>
  ];
  var plot1 = $.jqplot('diskio', [data1,data2], {
    seriesDefaults: {
              show: true,     // 设置是否渲染整个图表区域（即显示图表中内容）  
              xaxis: 'xaxis', // either 'xaxis' or 'x2axis'.  
              yaxis: 'yaxis', // either 'yaxis' or 'y2axis'.  
              label: '',      // 用于显示在分类名称框中的分类名称  
              color: '',      // 分类在图标中表示（折现，柱状图等）的颜色  
              lineWidth: 1.5, // 分类图（特别是折线图）宽度  
              shadow: true,   // 各图在图表中是否显示阴影区域  
              shadowAngle: 45,    // 参考grid中相同参数  
              shadowOffset: 1.25, // 参考grid中相同参数  
              shadowDepth: 3,     // 参考grid中相同参数  
              shadowAlpha: 0.1,   // 参考grid中相同参数  
              showLine: true,     //是否显示图表中的折线（折线图中的折线）  
              showMarker: false,   // 是否强调显示图中的数据节点  
              fill: false,        // 是否填充图表中折线下面的区域（填充颜色同折线颜色）以及legend 
              rendererOptions: {
                 smooth: true,
              }
    },
    series:[//如果有多个分类需要显示，这在此处设置各个分类的相关配置属性  
           //eg.设置各个分类在分类名称框中的分类名称  
            {label: '<?php echo $this->lang->line('read'); ?> <?php echo $this->lang->line('io'); ?>'},{label: '<?php echo $this->lang->line('write'); ?> <?php echo $this->lang->line('io'); ?>'}
           //配置参数设置同seriesDefaults  
    ],  
    legend: {  
        show: true, //设置是否出现分类名称框（即所有分类的名称出现在图的某个位置） 
        label:'123', 
        location: 'ne',     // 分类名称框出现位置, nw, n, ne, e, se, s, sw, w.  
        xoffset: 12,        // 分类名称框距图表区域上边框的距离（单位px）  
        yoffset: 12,        // 分类名称框距图表区域左边框的距离(单位px)  
        background:'',        //分类名称框距图表区域背景色  
        textColor:''          //分类名称框距图表区域内字体颜色  
    },  
    seriesColors: [ "#6699FF", "#FF9933", "#579575", "#839557", "#958c12",   
        "#953579", "#4b5de4", "#d8b83f", "#ff5800", "#0085cc"],  // 默认显示的分类颜色   
    title:{
         text:"<?php echo $cur_host; ?> <?php echo $this->lang->line('disk_io'); ?> <?php echo $this->lang->line('chart'); ?>",
         show:true,
         fontSize:'13px',
         textColor:'#666',
    },
    
    axes:{
        xaxis:{
            renderer:$.jqplot.DateAxisRenderer,
            tickOptions:{formatString:"<?php echo $chart_option['formatString']; ?>"},
            tickInterval:"",
            label: "",
        },
        yaxis: {  
                renderer: $.jqplot.LogAxisRenderer,
                tickOptions:{ suffix: '' } 
        } 
    },
    highlighter: {
            show: true, 
            showLabel: true, 
            tooltipAxes: '',
            sizeAdjust: 7.5 , tooltipLocation : 'ne'
    },
    cursor:{
            show: true, 
            zoom: true
    }
   
  });
});



</script>




<script>

$(document).ready(function(){
  var data = [
    ["<?php echo $this->lang->line('used'); ?>(<?php echo (100-$last_record['cpu_idle_time']) ?>%)",<?php echo (100-$last_record['cpu_idle_time']) ?>],
    ["<?php echo $this->lang->line('idle'); ?>(<?php echo $last_record['cpu_idle_time'] ?>%)",<?php echo $last_record['cpu_idle_time'] ?>]
  ];
  var plot1 = jQuery.jqplot ('cpu', [data], 
    { 
      seriesColors: [ "#6699FF", "#FF9933", "#579575", "#839557", "#958c12",   
        "#953579", "#4b5de4", "#d8b83f", "#ff5800", "#0085cc"],  // 默认显示的分类颜色，    
      title: {  
        text: "<?php echo $cur_host; ?> <?php echo $this->lang->line('cpu'); ?> <?php echo $this->lang->line('usage_rate'); ?> <?php echo $this->lang->line('chart'); ?>",   // 设置当前图的标题  
        show: true,//设置当前标题是否显示
        fontSize:'13px',
        textColor:'#666',  
      },  
      seriesDefaults: {
        // Make this a pie chart.
        renderer: jQuery.jqplot.PieRenderer, 
        rendererOptions: {
          showDataLabels: true,
          diameter: undefined, // 设置饼的直径  
          padding: 5,        // 饼距离其分类名称框或者图表边框的距离，变相该表饼的直径  
          sliceMargin:0,     // 饼的每个部分之间的距离  
          fill:true,         // 设置饼的每部分被填充的状态  
          shadow:true,       //为饼的每个部分的边框设置阴影，以突出其立体效果  
          shadowOffset: 2,    //设置阴影区域偏移出饼的每部分边框的距离  
          shadowDepth: 5,     // 设置阴影区域的深度  
          shadowAlpha: 0.07   // 设置阴影区域的透明度  
        }
      }, 
      legend: { show:true, location: 'e' }
    }
  );
});


$(document).ready(function(){
  var data = [
    ["mem_used(<?php echo check_memory($last_record['mem_used'])?>)",<?php echo $last_record['mem_used'] ?>],
    ["mem_free(<?php echo check_memory($last_record['mem_free'])?>)",<?php echo $last_record['mem_free'] ?>],
    ["mem_shared(<?php echo check_memory($last_record['mem_shared'])?>)",<?php echo $last_record['mem_shared'] ?>],
    ["mem_buffered(<?php echo check_memory($last_record['mem_buffered'])?>)",<?php echo $last_record['mem_buffered'] ?>],
    ["mem_cached(<?php echo check_memory($last_record['mem_cached'])?>)",<?php echo $last_record['mem_cached'] ?>]
  ];
  var plot1 = jQuery.jqplot ('disk_memory', [data], 
    { 
      seriesColors: [ "#6699FF", "#FF9933", "#579575", "#839557", "#958c12",   
        "#953579", "#4b5de4", "#d8b83f", "#ff5800", "#0085cc"],  // 默认显示的分类颜色，    
      title: {  
        text: "<?php echo $cur_host; ?> <?php echo $this->lang->line('memory'); ?> <?php echo $this->lang->line('usage_rate'); ?> <?php echo $this->lang->line('chart'); ?>",   // 设置当前图的标题  
        show: true,//设置当前标题是否显示
        fontSize:'13px',
        textColor:'#666',  
      },  
      seriesDefaults: {
        // Make this a pie chart.
        renderer: jQuery.jqplot.PieRenderer, 
        rendererOptions: {
          showDataLabels: true,
          diameter: undefined, // 设置饼的直径  
          padding: 5,        // 饼距离其分类名称框或者图表边框的距离，变相该表饼的直径  
          sliceMargin:0,     // 饼的每个部分之间的距离  
          fill:true,         // 设置饼的每部分被填充的状态  
          shadow:true,       //为饼的每个部分的边框设置阴影，以突出其立体效果  
          shadowOffset: 2,    //设置阴影区域偏移出饼的每部分边框的距离  
          shadowDepth: 5,     // 设置阴影区域的深度  
          shadowAlpha: 0.07   // 设置阴影区域的透明度  
        }
      }, 
      legend: { show:true, location: 'e' }
    }
  );
});

$(document).ready(function(){
  var data = [
    ["<?php echo $this->lang->line('used'); ?>(<?php echo check_memory($last_record['swap_total']-$last_record['swap_avail'])?>)",<?php echo $last_record['swap_total']-$last_record['swap_avail'] ?>],
    ["<?php echo $this->lang->line('avail'); ?>(<?php echo check_memory($last_record['swap_avail'])?>)",<?php echo $last_record['swap_avail'] ?>]
  ];
  var plot1 = jQuery.jqplot ('disk_swap', [data], 
    { 
      seriesColors: [ "#6699FF", "#FF9933", "#579575", "#839557", "#958c12",   
        "#953579", "#4b5de4", "#d8b83f", "#ff5800", "#0085cc"],  // 默认显示的分类颜色，    
      title: {  
        text: "<?php echo $cur_host; ?> <?php echo $this->lang->line('swap'); ?> <?php echo $this->lang->line('usage_rate'); ?> <?php echo $this->lang->line('chart'); ?>",   // 设置当前图的标题  
        show: true,//设置当前标题是否显示
        fontSize:'13px',
        textColor:'#666',  
      },  
      seriesDefaults: {
        // Make this a pie chart.
        renderer: jQuery.jqplot.PieRenderer, 
        rendererOptions: {
          showDataLabels: true,
          diameter: undefined, // 设置饼的直径  
          padding: 5,        // 饼距离其分类名称框或者图表边框的距离，变相该表饼的直径  
          sliceMargin:0,     // 饼的每个部分之间的距离  
          fill:true,         // 设置饼的每部分被填充的状态  
          shadow:true,       //为饼的每个部分的边框设置阴影，以突出其立体效果  
          shadowOffset: 2,    //设置阴影区域偏移出饼的每部分边框的距离  
          shadowDepth: 5,     // 设置阴影区域的深度  
          shadowAlpha: 0.07   // 设置阴影区域的透明度  
        }
      }, 
      legend: { show:true, location: 'e' }
    }
  );
});


</script>


<?php if(!empty($diskinfo)) {?>
<?php foreach ($diskinfo  as $disk):?>
<script>
$(document).ready(function(){
  var data = [
    ["used(<?php echo format_kbytes($disk['used_size']); ?>)",  <?php echo $disk['used_size'] ?>],
    ["avail(<?php echo format_kbytes($disk['avail_size']); ?>)",<?php echo $disk['avail_size'] ?>],
  ];
  var plot1 = jQuery.jqplot ("disk_<?php echo $disk['id']; ?>", [data], 
    { 
      seriesColors: [ "#6699FF", "#FF9933", "#579575", "#839557", "#958c12",   
        "#953579", "#4b5de4", "#d8b83f", "#ff5800", "#0085cc"],  // 默认显示的分类颜色    
      title: {  
        text: "<?php echo $cur_host; ?> <?php echo $this->lang->line('disk'); ?> <?php echo $disk['mounted'] ?> <?php echo $this->lang->line('usage_rate'); ?> <?php echo $this->lang->line('chart'); ?> ",   // 设置当前图的标题  
        show: true,//设置当前标题是否显示
        fontSize:'13px',
        textColor:'#666',  
      },  
      seriesDefaults: {
        // Make this a pie chart.
        renderer: jQuery.jqplot.PieRenderer, 
        rendererOptions: {
          showDataLabels: true,
          diameter: undefined, // 设置饼的直径  
          padding: 5,        // 饼距离其分类名称框或者图表边框的距离，变相该表饼的直径  
          sliceMargin:5,     // 饼的每个部分之间的距离  
          fill:true,         // 设置饼的每部分被填充的状态  
          shadow:true,       //为饼的每个部分的边框设置阴影，以突出其立体效果  
          shadowOffset: 2,    //设置阴影区域偏移出饼的每部分边框的距离  
          shadowDepth: 5,     // 设置阴影区域的深度  
          shadowAlpha: 0.07   // 设置阴影区域的透明度  
        }
      }, 
      legend: { show:true, location: 'e' }
    }
  );
});

</script>
<?php endforeach;?>
<?php } ?>