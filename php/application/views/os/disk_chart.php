<div class="header">
            
            <h1 class="page-title"><?php echo $this->lang->line('host'); ?> <?php echo $this->lang->line('_Disk'); ?> <?php echo $this->lang->line('_Chart'); ?></h1>
</div>
        
<ul class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><?php echo $this->lang->line('home'); ?></a> <span class="divider">/</span></li>
            <li class="active"><?php echo $this->lang->line('_OS Monitor'); ?></li><span class="divider">/</span></li>
            <li class="active"><?php echo $this->lang->line('_Chart'); ?></li>
</ul>

<div class="container-fluid">
<div class="row-fluid">

<?php if(!empty($diskinfo)) {?>
<?php foreach ($diskinfo  as $disk):?>
<div id="disk_<?php echo $disk['id']; ?>" style="margin-top:5px; margin-left:10px; width:500px; height:300px; float: left;"></div>
<?php endforeach;?>
<?php } ?>
<div class="clear"></div>

<script type="text/javascript" src="./lib/jqplot/jquery.jqplot.min.js"></script>
<script type="text/javascript" src="./lib/jqplot/plugins/jqplot.pieRenderer.min.js"></script>
<script type="text/javascript" src="./lib/jqplot/plugins/jqplot.donutRenderer.min.js"></script>
<link href="./lib/jqplot/jquery.jqplot.min.css"  rel="stylesheet">


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
      seriesColors: [ "#4bb2c5", "#EAA228", "#579575", "#839557", "#958c12",   
        "#953579", "#4b5de4", "#d8b83f", "#ff5800", "#0085cc"],  // 默认显示的分类颜色    
      title: {  
        text: "<?php echo $cur_host; ?> disk <?php echo $disk['mounted'] ?> usage rate",   // 设置当前图的标题  
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