<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo $this->lang->line('lepus'); ?> <?php echo $this->lang->line('database_monitor_system'); ?></title>
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <base href="<?php echo base_url().'application/views/static/'; ?>" />
    <link rel="stylesheet" type="text/css" href="lib/bootstrap/css/bootstrap.css">
    <link href="lib/bootstrap/css/jquery-ui-1.10.0.custom.css" rel="stylesheet" />
    <link href="lib/bootstrap/css/prettify.css"  rel="stylesheet">
    
    <link href="lib/font-awesome/css/font-awesome.css"  rel="stylesheet">
    <link href="stylesheets/theme.css" rel="stylesheet" type="text/css">
    <link href="stylesheets/style.css" rel="stylesheet" type="text/css">
    <link href="stylesheets/lepus.css" rel="stylesheet" type="text/css">
    
    <script src="lib/jquery-1.7.2.min.js" type="text/javascript"></script>
    <script src="lib/bootstrap/js/jquery-ui-1.10.0.custom.min.js"></script>

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
    
    <div class="navbar" <?php if($this->input->cookie('lang_current')=='zh-hans') echo  "style='font-family: 微软雅黑;'" ?>>
        <div class="navbar-inner">
                <ul class="nav pull-right">
					<?php 
						$model = $this->uri->segment(1);
					?>
                    <li <?php if($model=='index'){ echo "class='active'";} ?> ><a href="<?php echo site_url('index/index'); ?>" class="hidden-phone visible-tablet visible-desktop" role="button"><?php echo $this->lang->line('dashboard'); ?></a></li>
                    <li <?php if($model=='screen'){ echo "class='active'";} ?>><a href="<?php echo site_url('screen/index'); ?>" class="hidden-phone visible-tablet visible-desktop" role="button"><?php echo $this->lang->line('screen'); ?></a></li>
                    <li <?php if($model=='lp_mysql'){ echo "class='active'";} ?>><a href="<?php echo site_url('lp_mysql/index'); ?>" class="hidden-phone visible-tablet visible-desktop" role="button">MySQL</a></li>
                    <li <?php if($model=='lp_oracle'){ echo "class='active'";} ?>><a href="<?php echo site_url('lp_oracle/index'); ?>" class="hidden-phone visible-tablet visible-desktop" role="button">Oracle</a></li>
                    <li <?php if($model=='lp_mongodb'){ echo "class='active'";} ?>><a href="<?php echo site_url('lp_mongodb/index'); ?>" class="hidden-phone visible-tablet visible-desktop" role="button">MongoDB</a></li>
                    <li <?php if($model=='lp_redis'){ echo "class='active'";} ?>><a href="<?php echo site_url('lp_redis/index'); ?>" class="hidden-phone visible-tablet visible-desktop" role="button">Redis</a></li>
                    <li <?php if($model=='lp_os'){ echo "class='active'";} ?>><a href="<?php echo site_url('lp_os/index'); ?>" class="hidden-phone visible-tablet visible-desktop" role="button">OS</a></li>
                    <li <?php if($model=='alarm'){ echo "class='active'";} ?>><a href="<?php echo site_url('alarm/index'); ?>" class="hidden-phone visible-tablet visible-desktop" role="button"><?php echo $this->lang->line('alarm'); ?></a></li>
                    <li <?php if($model=='settings'){ echo "class='active'";} ?>><a href="<?php echo site_url('settings/index'); ?>" class="hidden-phone visible-tablet visible-desktop" role="button"><?php echo $this->lang->line('settings'); ?></a></li>
                    

                    
                    <li id="fat-menu" class="dropdown">
                        <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="icon-th-large"></i><?php echo $this->lang->line('language'); ?>
                            <i class="icon-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a tabindex="-1" href="<?php echo site_url('language/switchover/english').'?return_url='.current_url(); ?>">English</a></li>
                            <li class="divider"></li>
                            <li><a tabindex="-1" href="<?php echo site_url('language/switchover/zh-hans').'?return_url='.current_url(); ?>">简体中文</a></li>
                            <li class="divider"></li>
                            <!--<li><a tabindex="-1" href="<?php echo site_url('language/switchover/zh-hant').'?return_url='.current_url(); ?>">繁體中文</a></li>
                            <li class="divider"></li>-->
                            
                        </ul>
                    </li>
                    <li id="fat-menu" class="dropdown">
                        <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="icon-user"></i> <?php echo $this->session->userdata('username') ?>
                            <i class="icon-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a tabindex="-1" href="<?php echo site_url('profile/index'); ?>"><?php echo $this->lang->line('profile'); ?></a></li>
                            <li class="divider"></li>
                            <li><a tabindex="-1" href="<?php echo site_url('login/logout')?>"><?php echo $this->lang->line('logout'); ?></a></li>
                        </ul>
                    </li>
                    
                </ul>
                <span style="float:left;"><img src="./images/logo.png"/></span><a class="brand" href="<?php echo site_url('index')?>">&nbsp;<span class="first"></span> <span class="second"><?php echo $this->lang->line('lepus'); ?></span></a>
        </div>
    </div>
    

    <?php $this->load->model("user_model");?>
    <?php $menus = $this->user_model->get_user_menus(); //print_r($menus);?>
    <div class="sidebar-nav" <?php if($this->input->cookie('lang_current')=='zh-hans') echo  "style='font-family: 微软雅黑;'" ?> >
        <a href="<?php echo site_url('index')?>" class="nav-header" ><i class="icon-comment"></i><?php echo $this->lang->line('dashboard'); ?></a>
        <?php if (isset($menus)):?>
          	<?php foreach($menus as $menu):?>
            <a href="#<?php echo $menu['parent_url'];?>" class="nav-header collapsed" data-toggle="collapse"><i class="<?php echo $menu['parent_icon'];?>"></i><?php echo $this->lang->line('_'.$menu['parent_title']); ?><i class="icon-chevron-up" ></i></a>
            <ul id="<?php echo $menu['parent_url'];?>" class="nav nav-list collapse <?php if(is_active_menu($this->user_model->get_user_current_action(),$menu['parent_action'])) echo "in"; ?> ">
              <?php foreach($menu as $sub_menu):?>
              <?php if(is_array($sub_menu)):?>
              <li <?php if(is_active_menu($this->user_model->get_user_current_action(),$sub_menu['action'])) echo "class=active"; ?> ><a href="<?php echo site_url($sub_menu['url']) ?>"><i class="<?php echo $sub_menu['icon'];?>"></i><?php echo $this->lang->line('_'.$sub_menu['title']); ?></a></li>
              <?php endif;?>
     	      <?php endforeach;?>
            </ul>
            <?php endforeach;?>
       	<?php endif;?>
        
        <!--<a href="http://www.ruzuojun.com" target="_blank" class="nav-header" ><i class="icon-question-sign"></i><?php echo $this->lang->line('help'); ?></a>-->

        
    </div>
    

    
<div class="content">
       <?php echo $content_for_layout ; ?>



                    
                    <footer>
                        <hr>

                        <!-- Purchase a site license to remove this link from the footer: http://www.portnine.com/bootstrap-themes -->
                        <p class="pull-right">Power by <a href="http://www.lepus.cc" target="_blank">Lepus</a></p>

                        <p>&copy; 2014 <a href="http://www.lepus.cc" target="_blank">Lepus</a>(天兔数据库监控系统)</p>
                    </footer>
                    
            </div>
        </div>
    </div>
    


    <script src="lib/bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript">
        $("[rel=tooltip]").tooltip();
        $(function() {
            $('.demo-cancel-click').click(function(){return false;});
        });
    </script>
    
  </body>
</html>


