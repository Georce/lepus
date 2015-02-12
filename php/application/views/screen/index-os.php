<div class="container-fluid" style="padding:0px;">
 <div class="row-fluid">
 
 <div id="cpu" style="height:270px; width:32.8%;border:1px solid #ccc;padding:0px;margin-left:3px;margin-top:5px; float:left; background-color:#30536f"></div>
 <div id="net" style="height:270px; width:32.8%;border:1px solid #ccc;padding:0px;margin-left:3px;margin-top:5px; float:left; background-color:#30536f""></div>
 <div id="io" style="height:270px; width:32.8%;border:1px solid #ccc;padding:0px;margin-left:3px;margin-top:5px; float:left; background-color:#30536f""></div>
 <div id="db" style="height:270px; width:32.8%;border:1px solid #ccc;padding:0px;margin-left:3px;margin-top:5px; float:left; background-color:#30536f""></div>
 <div id="alarm" style="height:270px; width:66%;border:1px solid #ccc;padding:0px;margin-left:3px;margin-top:5px; float:left; background-color:#30536f;color:#FFF;">
     
      
<table class='table table-bordered table-condensed'>
  
    <tr >
        <td>host</td>
        <td>application</td>
        <td>db_type</td>
        <td>level</td>
        <td>item</td>
        <td>value</td>
        <td>Time</td>
  </tr>
 
    <?php if(!empty($last_alarmlist)) { foreach($last_alarmlist as $item){ ?>
    <tr Bgcolor=<?php if($item['level']=='ok') echo '#009900';if($item['level']=='warning') echo '#FF9900';if($item['level']=='critical') echo '#FF3333' ?> >
    <td><?php echo $item['host']; ?>:<?php echo $item['port']; ?></td>
    <td><?php echo $item['application']; ?></td>
    <td><?php echo $item['db_type']; ?></td>
    <td><?php echo $item['level']; ?></td>
    <td><?php echo $item['alarm_item']; ?></td>
    <td><?php echo $item['alarm_value']; ?></td>
    <td><?php echo $item['create_time']; ?></td>
    </tr>
 <?php }}  ?>

    </table>
 </div>


<script type="text/javascript">

</script>
      

<!--Step:1 Import echarts-plain.js or echarts-plain-map.js-->
<!--Step:1 引入echarts-plain.js或者 echarts-plain-map.js-->
<script src="lib/echarts/echarts-plain-original.js"></script>

<!-- cpu -->
<script type="text/javascript">

function echarts_load_cpu(){

    var myChart_cpu = echarts.init(document.getElementById('cpu'));
    
    var options_cpu = {
        
            backgroundColor: '#30536f',
        
        title : {
            text: 'CPU Top10',
            subtext: '',
            x: 'center',
            textStyle: {
                fontSize: 14, 
                fontWeight: 'bolder',
                color: '#FFFFFF'
            }
        },
        tooltip : {
            trigger: 'axis',
            color : ['#FFFFFF','#22bb22','#4b0082','#d2691e'],
        
        },
        legend: {
            data:['User','Sys'],
            x: 'left',
            textStyle: {
                fontSize: 8, 
                color: '#FFFFFF'
            }
        },
        grid: {
            x: '45px',
            x2: '20px',
            y: '40px',
            y2: '75px',
        },
        toolbox: {
            show : true,
            color : ['#FFFFFF','#FFFFFF','#FFFFFF','#FFFFFF'],
            feature : {
               
                magicType : {show: true, type: ['line', 'bar']},
                restore : {show: true},
                saveAsImage : {show: true}
            }
        },
        calculable : true,
        xAxis : [
            {
                type : 'category',
                data : [],
                name : '',
                axisLabel : {
                    rotate: '45',
                    textStyle: { 
                        color:'#FFFFFF',
                    }
                }
            }
        ],
        yAxis : [
            {
                type : 'value',
                splitArea : {show : true},
                min: '0',
                max: '100',
                axisLabel : {
                    formatter: '{value}%',
                    textStyle: { 
                        color:'#FFFFFF',
                    }
                }
            }
        ],
        series : [
            {
                name:'User',
                type:'bar',
                itemStyle: {
                    normal: {
                        color: '#f13a16',
                    },
                    
                },
                data:[]
            },
            
            
            {
                name:'Sys',
                type:'bar',
                itemStyle: {
                    normal: {
                        color: '#e6c71e',
                    },
                    
                },
                data:[]
            },
        ]
    };
 
    
    $.ajax({   
        type:"POST",   
        url:"<?php echo site_url('screen/ajax_get_cpu')?>",
        dataType: "json", //返回数据形式为json            
        success:function(result){
            if(result){
                options_cpu.xAxis[0].data = result.category;
                options_cpu.series[0].data=result.series.user;
                options_cpu.series[1].data=result.series.system;
                myChart_cpu.setOption(options_cpu);
            }
            
        },
        error: function (errorMsg) {
            $('#cpu').html("ajax load data error!");
        }
    });
}

echarts_load_cpu();
setInterval("echarts_load_cpu()",30*1000);


</script>


<!-- net -->
<script type="text/javascript">

function echarts_load_net(){

    var myChart_net = echarts.init(document.getElementById('net'));
    
    var options_net = {
        
            backgroundColor: '#30536f',
        
        title : {
            text: 'Network Top10',
            subtext: '',
            x: 'center',
            textStyle: {
                fontSize: 14, 
                fontWeight: 'bolder',
                color: '#FFFFFF'
            }
        },
        tooltip : {
            trigger: 'axis',
            color : ['#FFFFFF','#22bb22','#4b0082','#d2691e'],
        
        },
        legend: {
            data:['In','Out'],
            x: 'left',
            textStyle: {
                fontSize: 8, 
                color: '#FFFFFF'
            }
        },
        grid: {
            x: '45px',
            x2: '20px',
            y: '40px',
            y2: '75px',
        },
        toolbox: {
            show : true,
            color : ['#FFFFFF','#FFFFFF','#FFFFFF','#FFFFFF'],
            feature : {
               
                magicType : {show: true, type: ['line', 'bar']},
                restore : {show: true},
                saveAsImage : {show: true}
            }
        },
        calculable : true,
        xAxis : [
            {
                type : 'category',
                data : ['a','b'],
                name : '',
                axisLabel : {
                    rotate: '45',
                    textStyle: { 
                        color:'#FFFFFF',
                    }
                }
            }
        ],
        yAxis : [
            {
                type : 'value',
                splitArea : {show : true},
                axisLabel : {
                    formatter: '{value}M',
                    textStyle: { 
                        color:'#FFFFFF',
                    }
                }
            }
        ],
        series : [
            {
                name:'In',
                type:'bar',
                itemStyle: {
                    normal: {
                        color: '#FF6633',
                    },
                    
                },
                data:[1,2]
            },
            
            {
                name:'Out',
                type:'bar',
                itemStyle: {
                    normal: {
                        color: '#CCCC00',
                    },
                    
                },
                data:[3,4]
            },
           
        ]
    };
 

    $.ajax({   
        type:"POST",   
        url:"<?php echo site_url('screen/ajax_get_net')?>",
        dataType: "json", //返回数据形式为json            
        success:function(result){
            if(result){
                options_net.xAxis[0].data = result.category;
                options_net.series[0].data=result.series.in_mbs;
                options_net.series[1].data=result.series.out_mbs;
                myChart_net.setOption(options_net);
            }
            
        },
        error: function (errorMsg) {
            $('#net').html("ajax load data error!");
        }
    });

}

echarts_load_net();
setInterval("echarts_load_net()",30*1000);
 

</script>



<!-- io -->
<script type="text/javascript">

function echarts_load_io(){

    var myChart_io = echarts.init(document.getElementById('io'));
    
    var options_io = {
        
            backgroundColor: '#30536f',
        
        title : {
            text: 'Disk IO Top10',
            subtext: '',
            x: 'center',
            textStyle: {
                fontSize: 14, 
                fontWeight: 'bolder',
                color: '#FFFFFF'
            }
        },
        tooltip : {
            trigger: 'axis',
            color : ['#FFFFFF','#22bb22','#4b0082','#d2691e'],
        
        },
        legend: {
            data:['Writes','Reads'],
            x: 'left',
            textStyle: {
                fontSize: 8, 
                color: '#FFFFFF'
            }
        },
        grid: {
            x: '45px',
            x2: '20px',
            y: '40px',
            y2: '75px',
        },
        toolbox: {
            show : true,
            color : ['#FFFFFF','#FFFFFF','#FFFFFF','#FFFFFF'],
            feature : {
               
                magicType : {show: true, type: ['line', 'bar']},
                restore : {show: true},
                saveAsImage : {show: true}
            }
        },
        calculable : true,
        xAxis : [
            {
                type : 'category',
                data : ['a','b'],
                name : '',
                axisLabel : {
                    rotate: '45',
                    textStyle: { 
                        color:'#FFFFFF',
                    }
                }
            }
        ],
        yAxis : [
            {
                type : 'value',
                splitArea : {show : true},
                axisLabel : {
                    textStyle: { 
                        color:'#FFFFFF',
                    }
                }
            }
        ],
        series : [
            {
                name:'Writes',
                type:'bar',
                itemStyle: {
                    normal: {
                        color: '#FF6633',
                    },
                    
                },
                data:[1,2]
            },
            
            {
                name:'Reads',
                type:'bar',
                itemStyle: {
                    normal: {
                        color: '#CCCC00',
                    },
                    
                },
                data:[3,4]
            },
           
        ]
    };
 

    $.ajax({   
        type:"POST",   
        url:"<?php echo site_url('screen/ajax_get_diskio')?>",
        dataType: "json", //返回数据形式为json            
        success:function(result){
            if(result){
                options_io.xAxis[0].data = result.category;
                options_io.series[0].data=result.series.io_writes;
                options_io.series[1].data=result.series.io_reads;
                myChart_io.setOption(options_io);
            }
            
        },
        error: function (errorMsg) {
            $('#io').html("ajax load data error!");
        }
    });

}

echarts_load_io();
setInterval("echarts_load_io()",30*1000);
 

</script>



<!-- db -->
<script type="text/javascript">

function echarts_load_db(){

    var myChart_db = echarts.init(document.getElementById('db'));
    var options_db = {

    backgroundColor: '#30536f',
        
        title : {
            text: 'DB Active Process',
            subtext: '',
            x: 'left',
            textStyle: {
                fontSize: 14, 
                fontWeight: 'bolder',
                color: '#FFFFFF'
            }
        },
    
    legend: {
        data:['MySQL','Oracle','MongoDB','Redis'],
        x: 'right',
        textStyle: {
                fontSize: 8, 
                color: '#FFFFFF'
        }
    },
    grid: {
            x: '45px',
            x2: '20px',
            y: '40px',
            y2: '40px',
    },
    tooltip : {
            trigger: 'axis',
            color : ['#FFFFFF','#22bb22','#4b0082','#d2691e'],
        
    },
    calculable : true,
    xAxis : [
        {
            type : 'category',
            boundaryGap : false,
            data : ['18:06','18:07','18:08','18:09','18:10','18:11','18:12'],
            axisLabel : {
                    textStyle: { 
                        color:'#FFFFFF',
                    }
            }
        }
    ],
    yAxis : [
        {
            type : 'value',
            axisLabel : {
                    textStyle: { 
                        color:'#FFFFFF',
                    }
            }
        }
    ],
    series : [
        {
            name:'MySQL',
            type:'line',
            itemStyle: {
                    normal: {
                        color: '#00FF00',
                    },
                    
            },
            data:[100, 100, 100, 100, 100, 100, 100]
        },
        {
            name:'Oracle',
            type:'line',
            itemStyle: {
                    normal: {
                        color: '#FF3333',
                    },
                    
            },
            data:[30, 30, 30, 30, 30, 30, 30]
        },
        {
            name:'MongoDB',
            type:'line',
            itemStyle: {
                    normal: {
                        color: '#FFFF00',
                    },
                    
            },
            data:[15, 15, 15, 15, 15, 15, 15]
        },
        {
            name:'Redis',
            type:'line',
            itemStyle: {
                    normal: {
                        color: '#CC99FF',
                    },
                    
            },
            data:[5, 5, 5, 5, 5, 5, 5]
        }
    ]
    };


   $.ajax({   
        type:"POST",   
        url:"<?php echo site_url('screen/ajax_get_db_waits')?>",
        dataType: "json", //返回数据形式为json            
        success:function(result){
            if(result){
                options_db.xAxis[0].data = result.category;
                options_db.series[0].data=result.series.mysql_waits;
                options_db.series[1].data=result.series.oracle_waits;
                options_db.series[2].data=result.series.mongodb_waits;
                options_db.series[3].data=result.series.redis_waits;
                myChart_db.setOption(options_db);
            }
            
        },
        error: function (errorMsg) {
            $('#db').html("ajax load data error!");
        }
    });

}

echarts_load_db();
setInterval("echarts_load_db()",30*1000);
</script>


<!-- ajax load alarm-->
<script type="text/javascript">

function load_alarm(){
    $.ajax({   
        type:"POST",   
        url:"<?php echo site_url('screen/ajax_get_alarm')?>",
        //dataType: "json", //返回数据形式为json            
        success:function(result){
            if(result){
               $('#alarm').html(result);
            }
            
        },
        error: function (errorMsg) {
            $('#alarm_record').html("ajax load alarm data error!");
        }
    });
}

load_alarm();
setInterval("load_alarm()",30*1000);
</script>
