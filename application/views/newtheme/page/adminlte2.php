<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Forbys Production System</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo NEWTHEME?>bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo NEWTHEME?>bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo NEWTHEME?>bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo NEWTHEME?>dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo NEWTHEME?>dist/css/skins/_all-skins.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="<?php echo NEWTHEME?>bower_components/morris.js/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="<?php echo NEWTHEME?>bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="<?php echo NEWTHEME?>bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo NEWTHEME?>bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?php echo NEWTHEME?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="index2.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>F</b>B</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Forboys</b>Production</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo NEWTHEME?>dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo callSessUser('nama_user') ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php echo NEWTHEME?>dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

                <p>
                  <?php echo callSessUser('nama_user') ?>
                  <small></small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat"><?php echo date('d F Y') ?></a>
                </div>
                <div class="pull-right">
                  <a href="<?php echo BASEURL.'login/signout' ?>" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo NEWTHEME?>dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo callSessUser('nama_user') ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <?php foreach(MenuParentForUSer() as $mp){?>
            <?php if(!empty(MenuSub1($mp['id']))){?>
              <li class="treeview">
                <a href="<?php echo $mp['url']?>">
                  <i class="fa fa-share"></i> <span><?php echo $mp['nama']?></span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                    <ul class="treeview-menu">
                      <!-- <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li> -->
                      <?php foreach( MenuSub1($mp['id']) as $sub1 ){?>
                        <?php if(!empty(MenuSub2($sub1['id']))){?>
                        <li class="treeview">
                          <a href="#"><i class="fa fa-circle-o"></i> <?php echo $sub1['nama']?>
                            <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                          </a>
                          <ul class="treeview-menu">
                            <!-- <li><a href="#"><i class="fa fa-circle-o"></i> Level Two</a></li> -->
                            <?php foreach( MenuSub2($sub1['id']) as $sub2 ){?>
                              <?php if( !empty(MenuSub3($sub2['id']) ) ) {?>
                                <li class="treeview">
                                  <a href="<?php echo BASEURL.$sub2['url'] ?>"><i class="fa fa-circle-o"></i> <?php echo $sub2['nama'] ?>
                                    <span class="pull-right-container">
                                      <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                  </a>
                                  <ul class="treeview-menu">
                                    <?php foreach(MenuSub3($sub2['id']) as $sub3 ){?>
                                    <li><a href="<?php echo BASEURL.$sub3['url'] ?>"><i class="fa fa-circle-o"></i> <?php echo $sub3['nama']?></a></li>
                                    <?php }?>
                                  </ul>
                                </li>
                              <?php }else { ?>
                                <li><a href="<?php echo BASEURL.$sub2['url'] ?>"><i class="fa fa-circle-o"></i> <?php echo $sub2['nama'] ?></a></li>
                              <?php  }?>
                            <?php } ?>
                          </ul>
                        </li>
                      <?php  }else{ ?>
                        <li><a href="<?php echo BASEURL.$sub1['url'] ?>"><i class="fa fa-circle-o"></i><?php echo $sub1['nama'] ?></a></li>
                      <?php  } ?>
                      <?php  } ?>
                    </ul>
                
              </li>
              <?php }else{ ?>
              <li class="nav-item">
                <a href="<?php echo BASEURL.$mp['url'] ?>" class="nav-link">
                    <i class="nav-icon <?php echo $mp['icon']?>"></i>
                  <p><?php echo $mp['nama']?> </p>
                </a>
              </li>
              <?php } ?>
        <?php } ?>
        <li><a href="<?php echo BASEURL.'login/signout' ?>"><i class="fa fa-sign-out"></i> <span>Log Out</span></a></li>
        
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- <section class="content-header">
      <h1>
         
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section> -->

    <!-- Main content -->
    <section class="content">

      <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">
              <?php 
                      if(isset($title)){
                        echo $title;
                      }else{
                        
                      }
                    ?>
            </h3>
        </div>

        <div class="box-body">
          <?php if(isset($page)){?>
                      <?php //$this->load->view('newtheme/page/script');?>
                      <?php $this->load->view($page);?>
                    <?php } ?>
        </div>

      </div>
                   
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.4.18
    </div>
    <strong>Copyright &copy; 2014-2019 <a href="https://adminlte.io">AdminLTE</a>.</strong> All rights
    reserved.
  </footer>

  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="<?php echo NEWTHEME?>bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo NEWTHEME?>bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo NEWTHEME?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="<?php echo NEWTHEME?>bower_components/raphael/raphael.min.js"></script>
<script src="<?php echo NEWTHEME?>bower_components/morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo NEWTHEME?>bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="<?php echo NEWTHEME?>plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo NEWTHEME?>plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?php echo NEWTHEME?>bower_components/moment/min/moment.min.js"></script>
<script src="<?php echo NEWTHEME?>bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="<?php echo NEWTHEME?>bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo NEWTHEME?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="<?php echo NEWTHEME?>bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo NEWTHEME?>bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo NEWTHEME?>dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo NEWTHEME?>dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo NEWTHEME?>dist/js/demo.js"></script>
</body>
</html>
