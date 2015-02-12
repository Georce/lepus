<div class="header">
            
            <h1 class="page-title"><?php echo $this->lang->line('_MySQL'); ?> <?php echo $this->lang->line('_Slowquery Analysis'); ?></h1>
</div>
        
<ul class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><?php echo $this->lang->line('home'); ?></a> <span class="divider">/</span></li>
            <li class="active"><?php echo $this->lang->line('_MySQL Monitor'); ?></li><span class="divider">/</span></li>
            <li class="active"><?php echo $this->lang->line('_Slowquery Analysis'); ?></li>
</ul>

<div class="container-fluid">
<div class="row-fluid">
 
<div class="btn-toolbar">
    <!--<a class="btn btn-primary " href="<?php echo site_url('lp_mysql/slowquery_detail/'.$record['checksum'].'/'.$setval['server_id'].'/prev') ?>"><i class="icon-arrow-left"></i> <?php echo $this->lang->line('prev'); ?></a>
    <a class="btn btn-primary " href="<?php echo site_url('lp_mysql/slowquery_detail/'.$record['checksum'].'/'.$setval['server_id'].'/next') ?>"><i class="icon-arrow-right"></i> <?php echo $this->lang->line('next'); ?></a>-->
    <a class="btn btn " href="<?php echo site_url('lp_mysql/slowquery') ?>"><i class="icon-list"></i> <?php echo $this->lang->line('return'); ?><?php echo $this->lang->line('list'); ?></a>
    <button id="close" class="btn btn-danger"><i class="icon-off"></i> <?php echo $this->lang->line('close'); ?></button>
  <div class="btn-group"></div>
</div>

<div class="well">
<table class="table  table-bordered table-condensed" style="font-size: 12px;table-layout:fixed;" >
    <tr>
        <th style="width: 120px;"><?php echo $this->lang->line('database'); ?></th>
        <td colspan="2"><?php echo $record['db_max']; ?></td>
        <th><?php echo $this->lang->line('user'); ?></th>	
        <td colspan="3"><?php echo $record['user_max']; ?></td>
	</tr>
    <tr>
        <th style="width: 120px;"><?php echo $this->lang->line('checksum'); ?></th>
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
        <td colspan="6" style="word-wrap:break-word;" ><?php echo $record['fingerprint']; ?></td>	
	</tr>
    <tr>
        <th><?php echo $this->lang->line('sample'); ?></th>
        <td colspan="6" style="word-wrap:break-word;" ><?php echo $record['sample']; ?></td>
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
</div>


 <script type="text/javascript">
    $('#close').click(function(){
        window.opener=null;
        window.open('','_self');
        window.close();
    })
 </script>
