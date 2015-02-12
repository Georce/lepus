<div class="header">
            
            <h1 class="page-title"><?php echo $this->lang->line('_Resource Monitor'); ?> <?php echo $this->lang->line('chart'); ?></h1>
</div>
        
<ul class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><?php echo $this->lang->line('home'); ?></a> <span class="divider">/</span></li>
            <li class="active"><?php echo $this->lang->line('_MySQL Monitor'); ?></li><span class="divider">/</span></li>
            <li class="active"><?php echo $this->lang->line('_Resource Monitor'); ?></li>
</ul>

<div class="container-fluid">
<div class="row-fluid">
           
<hr/>
<div id="connections" style="margin-top:5px; margin-left:0px; width:500px; height:300px;float: left;"></div>
<div id="files" style="margin-top:5px; margin-left:0px; width:500px; height:300px;float: left;"></div>
<div id="tables" style="margin-top:5px; margin-left:0px; width:500px; height:300px;float: left;"></div>


<script src="lib/jquery-1.7.2.min.js" type="text/javascript"></script>
<script type="text/javascript" src="./lib/jqplot/jquery.jqplot.min.js"></script>
<script type="text/javascript" src="./lib/jqplot/plugins/jqplot.pieRenderer.min.js"></script>
<script type="text/javascript" src="./lib/jqplot/plugins/jqplot.donutRenderer.min.js"></script>
<link href="./lib/jqplot/jquery.jqplot.min.css"  rel="stylesheet">


<script type="text/javascript">

$(document).ready(function(){
  var data = [
  ["connections_used (<?php echo $connections_used; ?>)", <?php echo $connections_used; ?>],
  ["connections_unused (<?php echo $connections_unused; ?>)", <?php echo $connections_unused;?> ]
  ];
  var plot1 = jQuery.jqplot ('connections', [data], 
    { 
      title: {  
        text: "<?php echo $cur_server; ?> Connections Usage <?php echo $this->lang->line('chart'); ?>",  //        设置当前图的标题  
        show: true,//设置当前标题是否显示 
        fontSize:'13px',    //刻度值的字体大小  
      },
      seriesDefaults: {
        // Make this a pie chart.
        renderer: jQuery.jqplot.PieRenderer, 
        rendererOptions: {
          // Put data labels on the pie slices.
          // By default, labels show the percentage of the slice.
          showDataLabels: true
        }
      },
      
      seriesColors: [ "#6699FF","#FF9933"],  // 默认显示的分类颜色 
      legend: { show:true, location: 'e' }
    }
  );
});

$(document).ready(function(){
  var data = [
  ["open_files_used (<?php echo $open_files_used; ?>)", <?php echo $open_files_used; ?>],
  ["open_files_unused (<?php echo $open_files_unused; ?>)", <?php echo $open_files_unused;?> ]
  ];
  var plot1 = jQuery.jqplot ('files', [data], 
    { 
      title: {  
        text: "<?php echo $cur_server; ?> Open Files Usage <?php echo $this->lang->line('chart'); ?>",  //        设置当前图的标题  
        show: true,//设置当前标题是否显示 
        fontSize:'13px',    //刻度值的字体大小  
      },
      seriesDefaults: {
        // Make this a pie chart.
        renderer: jQuery.jqplot.PieRenderer, 
        rendererOptions: {
          // Put data labels on the pie slices.
          // By default, labels show the percentage of the slice.
          showDataLabels: true
        }
      },
      seriesColors: [ "#6699FF","#FF9933"], // 默认显示的分类颜色 
      legend: { show:true, location: 'e' }
    }
  );
});

$(document).ready(function(){
  var data = [
  ["open_tables_used (<?php echo $open_tables_used; ?>)", <?php echo $open_tables_used; ?>],
  ["open_tables_unused (<?php echo $open_tables_unused; ?>)", <?php echo $open_tables_unused;?> ]
  ];
  var plot1 = jQuery.jqplot ('tables', [data], 
    { 
      title: {  
        text: "<?php echo $cur_server; ?>  Tables Cache Usage <?php echo $this->lang->line('chart'); ?>",  //        设置当前图的标题  
        show: true,//设置当前标题是否显示 
        fontSize:'13px',    //刻度值的字体大小  
      },
      seriesDefaults: {
        // Make this a pie chart.
        renderer: jQuery.jqplot.PieRenderer, 
        rendererOptions: {
          // Put data labels on the pie slices.
          // By default, labels show the percentage of the slice.
          showDataLabels: true
        }
      },
      seriesColors: [ "#6699FF","#FF9933"],  // 默认显示的分类颜色 
      legend: { show:true, location: 'e' }
    }
  );
});

</script>