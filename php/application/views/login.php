<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo $this->lang->line('login'); ?>-<?php echo $this->lang->line('lepus'); ?> <?php echo $this->lang->line('database_monitor_system'); ?></title>
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <base href="<?php echo base_url().'application/views/static/'; ?>" />
    <link rel="stylesheet" type="text/css" href="lib/bootstrap/css/bootstrap.css">
    <link href="lib/bootstrap/css/prettify.css"  rel="stylesheet">
    
    <link href="lib/font-awesome/css/font-awesome.css"  rel="stylesheet">
    <link href="stylesheets/theme.css" rel="stylesheet" type="text/css">
    <link href="stylesheets/style.css" rel="stylesheet" type="text/css">
    <script src="lib/jquery-1.7.2.min.js" type="text/javascript"></script>
    <script src="lib/bootstrap/js/bootstrap.js"></script>

    <style type="text/css">
        #line-chart {
            height:300px;
            width:800px;
            margin: 0px auto;
            margin-top: 1em;
        }
        .brand { font-family: georgia, serif; }
        .brand .first {
            color: #ccc;
            font-style: italic;
        }
        .brand .second {
            color: #fff;
            font-weight: bold;
        }
    </style>

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="../assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
  </head>

  <!--[if lt IE 7 ]> <body class="ie ie6"> <![endif]-->
  <!--[if IE 7 ]> <body class="ie ie7 "> <![endif]-->
  <!--[if IE 8 ]> <body class="ie ie8 "> <![endif]-->
  <!--[if IE 9 ]> <body class="ie ie9 "> <![endif]-->
  <!--[if (gt IE 9)|!(IE)]><!--> 
  <body class=""> 
  <!--<![endif]-->
    
    <div class="navbar">
        <div class="navbar-inner">
                <ul class="nav pull-right">
                    
                </ul>
                <span style="float:left;"><img src="./images/logo.png"/></span><a class="brand" href="<?php echo site_url('index')?>">&nbsp;<span class="first"><?php echo $this->lang->line('lepus'); ?></span> <span class="second"><?php echo $this->lang->line('database_monitor_system'); ?></span></a>
        </div>
    </div>
    

    
<div class="row-fluid">
    <div class="dialog">
    <?php if ($error_code!==0) { ?>
	<div class="alert alert-error">
    <button type="button" class="close" data-dismiss="alert">×</button>
	<?php echo validation_errors(); ?>
	<?php if ($error_code=='user_check_fail') { ?>
			<p><?php echo $this->lang->line('auth_fail'); ?></p>
	<?php } ?>
	</div>
    <?php } ?>
        <div class="block">
            <p class="block-heading"><?php echo $this->lang->line('login'); ?></p>
            <div class="block-body">
                <form class="form-horizontal" method='post' action="<?php echo site_url('login')?>">
                <input type='hidden'  name='login' value='doing' />
                <input type='hidden'  name='return_url' value='<?php  echo $return_url ?>' />
                    <label><?php echo $this->lang->line('system_language'); ?></label>
                    <select name="language" id="language" class="input-large">
                    
                    <option value="zh-hans" <?php echo set_selected($this->input->cookie('lang_current'),"zh-hans") ?> >简体中文</option>
                    <option value="english" <?php echo set_selected($this->input->cookie('lang_current'),"english") ?> >English</option>
                    <!--<option value="zh-hant" <?php echo set_selected($this->input->cookie('lang_current'),"zh-hant") ?> >繁體中文</option>-->
                    </select>
                    <hr/>
                    <label><?php echo $this->lang->line('username'); ?></label>
                    <input type="text" id="username" name="username" value="<?php echo set_value('username'); ?>" class="span12">
                    <label><?php echo $this->lang->line('password'); ?></label>
                    <input type="password" id="" name="password" value="<?php echo set_value('password'); ?>" class="span12">
                    <p></p>
                    <button type="submit" class="btn btn-primary pull-right"><?php echo $this->lang->line('login'); ?></button>
                    <label class="remember-me"><input type="checkbox"> <?php echo $this->lang->line('remember_password'); ?></label>
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>
        <p class="pull-right" style=""><a href="http://www.lepus.cc" target="blank"><?php echo $this->lang->line('get_support'); ?></a></p>
        <p>&nbsp;<?php echo $this->lang->line('version'); ?>:<?php echo $lepus_status['lepus_version']; ?></p>
    </div>
</div>
  
  </body>
</html>


    
<script language="javascript">
  $(document).ready(function(){
	 $('#language').change(function(){
            current_language = $('#language').val();
            if(current_language !=''){
                url="<?php echo site_url('language/switchover/') ?>"+'/'+current_language;
                window.location.href=url;
            }
            else{
                return false;
            }
            
	 })
   });
</script>
