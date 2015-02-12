<div class="header">
    <h1 class="page-title"><?php echo $this->lang->line('_MySQL'); ?> <?php echo $this->lang->line('_AWR Report'); ?> </h1>
</div>
        
<ul class="breadcrumb">
    <li><a href="<?php echo site_url(); ?>"><?php echo $this->lang->line('home'); ?></a> <span class="divider">/</span></li>
    <li class="active"><?php echo $this->lang->line('_MySQL Monitor'); ?></li><span class="divider">/</span></li>
    <li class="active"><?php echo $this->lang->line('_AWR Report'); ?></li>
</ul>

<div class="container-fluid">
<div class="row-fluid">


<script language="javascript" src="./lib/DatePicker/WdatePicker.js"></script>
                
<form name="form" onsubmit="return check_submit()" class="form-horizontal" target="_blank" method="post" action="<?php echo site_url('lp_mysql/awrreport_create') ?>" >

<div class="well">
   
   <div class="control-group">
    <label class="control-label" for="">*<?php echo $this->lang->line('host'); ?></label>
    <div class="controls">
      <select name="server_id" id="server_id" class="input-large"  >
        <option value="0"><?php echo $this->lang->line('host'); ?></option>
        <?php foreach ($server as $item):?>
        <option value="<?php echo $item['id'];?>" ><?php echo $item['host'];?>:<?php echo $item['port'];?>(<?php echo $item['tags'];?>)</option>
        <?php endforeach;?>
        </select>
        <span class="help-inline"></span>
    </div>
   </div>
   
   <div class="control-group">
    <label class="control-label" for="">*<?php echo $this->lang->line('begin_time'); ?></label>
    <div class="controls">
      <input class="Wdate" style="width:200px;" type="text" name="begin_time" id="begin_time>" value="<?php echo $setval['begin_time'] ?>" onFocus="WdatePicker({doubleCalendar:false,isShowClear:false,readOnly:false,dateFmt:'yyyy-MM-dd HH:mm'})"/> 
      <span class="help-inline"></span>
    </div>
   </div>
   
   <div class="control-group">
    <label class="control-label" for="">*<?php echo $this->lang->line('end_time'); ?></label>
    <div class="controls">
      <input class="Wdate" style="width:200px;" type="text" name="end_time" id="end_time>" value="<?php echo $setval['end_time'] ?>" onFocus="WdatePicker({doubleCalendar:false,isShowClear:false,readOnly:false,startDate:'1980-05-01',dateFmt:'yyyy-MM-dd HH:mm'})"/>
      <span class="help-inline"></span>
    </div>
   </div>

    <div class="control-group">
    <label class="control-label" for=""></label>
    <div class="controls">
      <button type="submit" id="submit" class="btn btn-success"><i class="icon-search"></i> <?php echo $this->lang->line('create_report'); ?></button>
    </div>
   </div>

   </div>
   
</div>


</form>

<script type="text/javascript">
function check_submit(){
    if($('#server_id').val()==0){
        alert('Please select host server');
        return false;
    }   
}
</script>