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
  <!-- <link rel="stylesheet" href="<?php echo NEWTHEME?>bower_components/font-awesome/css/font-awesome.min.css"> -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo NEWTHEME?>bower_components/Ionicons/css/ionicons.min.css">

  <link rel="stylesheet" href="<?php echo NEWTHEME?>bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <link rel="stylesheet" href="<?php echo NEWTHEME?>bower_components/select2/dist/css/select2.min.css">
  
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo NEWTHEME?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
   <!-- Responsive datatable examples -->
  <link href="<?php echo PLUGINS ?>datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />  
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo NEWTHEME?>dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo NEWTHEME?>dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="<?php echo PLUGINS ?>sweet-alert/sweetalert2.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <style type="text/css">
    @import url('https://fonts.googleapis.com/css2?family=Baskervville:ital@1&display=swap');
    body{text-transform:capitalize !important;/*color:blue !important;*/}    
      .registered {
        font-family: 'Baskervville', serif;
      }

      .full {
        width: 100% !important;
      }

      select { width: 100% !important }

      @media print
      {    
          .no-print, .no-print *
          {
              display: none !important;
          }
      }

      .bold { font-weight:800 !important}
      .clearfix {clear:both;margin:2%}
      th, td {
      padding: 15px;
    }
  </style>

  <style>
    /* CSS untuk menu saat hover */
    .menuhover {
        display: none;
        position: absolute;
        background-color: #fff; /* Warna background */
        box-shadow: 0 2px 5px rgba(0,0,0,.2); /* Efek bayangan */
        z-index: 1; /* Atur lapisan z */
    }

    a:hover .menuhover {
        display: block; /* Menu muncul saat tombol dihover */
    }

    /* CSS untuk styling menu */
    .menuhover ul {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }

    .menuhover ul li {
        padding: 8px 12px;
    }

    .menuhover ul li a {
        text-decoration: none;
        color: #333; /* Warna teks */
    }

    .menuhover ul li a:hover {
        background-color: #f4f4f4; /* Warna background saat dihover */
    }
</style>
<style>
    /* Reset gaya default */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* Styling menu */
    .menu-container {
        position: relative;
        display: inline-block;
    }

    .menu {
        display: none;
        position: absolute;
        list-style-type: none;
        padding: 0;
        margin: 0;
        background-color: #f9f9f9; /* Warna background menu */
        border: 1px solid #ccc; /* Border menu */
        left: 100%; /* Letakkan menu ke samping */
        top: 0;
    }

    .menu li {
        padding: 10px;
    }

    .menu li a {
        text-decoration: none;
        color: #333; /* Warna teks menu */
    }

    /* Munculkan menu saat elemen dihover */
    .menu-container:hover .menu {
        display: block;
    }

    /* Efek hover pada menu item */
    .menu li:hover {
        background-color: #ddd; /* Warna background saat dihover */
    }

    .sidebar-menu i {
        width: 20px !important;
        text-align: center;
    }

    /* ===== CHAT SIDEBAR STYLES ===== */
    #chat-sidebar {
        position: fixed;
        right: 0;
        bottom: 0;
        width: 320px;
        height: 450px;
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 12px 0 0 0;
        box-shadow: -3px -3px 15px rgba(0,0,0,0.12);
        z-index: 1040;
        display: flex;
        flex-direction: column;
        transition: transform 0.3s ease;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    #chat-sidebar.collapsed {
        transform: translateY(calc(100% - 42px));
    }
    /* Header */
    #chat-header {
        background: linear-gradient(135deg, #3c8dbc, #2c6fa0);
        color: #fff;
        padding: 10px 15px;
        cursor: pointer;
        font-weight: 600;
        font-size: 14px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-radius: 12px 0 0 0;
        user-select: none;
    }
    #chat-header .badge-unread {
        background: #e74c3c;
        color: #fff;
        border-radius: 50%;
        padding: 2px 7px;
        font-size: 11px;
        margin-left: 6px;
        display: none;
    }
    /* User List */
    #chat-user-list {
        flex: 1;
        overflow-y: auto;
        padding: 0;
    }
    .chat-user-item {
        display: flex;
        align-items: center;
        padding: 10px 14px;
        border-bottom: 1px solid #f0f0f0;
        cursor: pointer;
        transition: background 0.2s;
    }
    .chat-user-item:hover {
        background: #f0f7ff;
    }
    .chat-user-item img {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        margin-right: 10px;
        object-fit: cover;
    }
    .chat-user-item .user-avatar-wrap {
        position: relative;
        margin-right: 10px;
    }
    .chat-user-item .user-avatar-wrap img {
        margin-right: 0;
    }
    .chat-user-item .online-dot {
        position: absolute;
        bottom: 1px;
        right: 1px;
        width: 10px;
        height: 10px;
        background: #28a745;
        border-radius: 50%;
        border: 2px solid #fff;
    }
    .chat-user-item .offline-dot {
        position: absolute;
        bottom: 1px;
        right: 1px;
        width: 10px;
        height: 10px;
        background: #aaa;
        border-radius: 50%;
        border: 2px solid #fff;
    }
    .chat-user-info {
        flex: 1;
        min-width: 0;
    }
    .chat-user-info .name {
        font-size: 13px;
        font-weight: 600;
        color: #333;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .chat-user-info .last-msg {
        font-size: 11px;
        color: #999;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        margin-top: 2px;
    }
    .chat-user-item .unread-badge {
        background: #e74c3c;
        color: #fff;
        border-radius: 50%;
        min-width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        font-weight: bold;
        margin-left: 8px;
    }
    /* Chat Conversation View */
    #chat-conversation {
        display: none;
        flex: 1;
        flex-direction: column;
        overflow: hidden;
    }
    #chat-conv-header {
        display: flex;
        align-items: center;
        padding: 8px 12px;
        background: #f8f9fa;
        border-bottom: 1px solid #eee;
    }
    #chat-conv-header .back-btn {
        cursor: pointer;
        margin-right: 10px;
        color: #3c8dbc;
        font-size: 16px;
    }
    #chat-conv-header img {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        margin-right: 8px;
        object-fit: cover;
    }
    #chat-conv-header .conv-name {
        font-size: 13px;
        font-weight: 600;
        color: #333;
        flex: 1;
    }
    #chat-conv-header .conv-status {
        font-size: 11px;
        color: #28a745;
    }
    /* Messages Area */
    #chat-messages {
        flex: 1;
        overflow-y: auto;
        padding: 10px 12px;
        background: #f5f7fa;
        display: flex;
        flex-direction: column;
        gap: 6px;
    }
    .chat-msg {
        max-width: 80%;
        padding: 8px 12px;
        border-radius: 14px;
        font-size: 12.5px;
        line-height: 1.4;
        word-wrap: break-word;
        position: relative;
    }
    .chat-msg.sent {
        align-self: flex-end;
        background: linear-gradient(135deg, #3c8dbc, #2980b9);
        color: #fff;
        border-bottom-right-radius: 4px;
    }
    .chat-msg.received {
        align-self: flex-start;
        background: #fff;
        color: #333;
        border: 1px solid #e8e8e8;
        border-bottom-left-radius: 4px;
    }
    .chat-msg .msg-time {
        font-size: 10px;
        opacity: 0.7;
        margin-top: 3px;
        display: block;
    }
    .chat-msg.sent .msg-time {
        text-align: right;
        color: rgba(255,255,255,0.8);
    }
    .chat-msg.received .msg-time {
        color: #aaa;
    }
    /* Chat Input */
    #chat-input-area {
        display: flex;
        padding: 8px;
        border-top: 1px solid #eee;
        background: #fff;
        align-items: center;
        gap: 6px;
    }
    #chat-input-area input {
        flex: 1;
        border: 1px solid #ddd;
        border-radius: 20px;
        padding: 7px 14px;
        font-size: 13px;
        outline: none;
        transition: border-color 0.2s;
    }
    #chat-input-area input:focus {
        border-color: #3c8dbc;
    }
    #chat-input-area button {
        background: #3c8dbc;
        color: #fff;
        border: none;
        border-radius: 50%;
        width: 34px;
        height: 34px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.2s;
    }
    #chat-input-area button:hover {
        background: #2c6fa0;
    }
    .chat-empty-state {
        text-align: center;
        padding: 30px 15px;
        color: #aaa;
        font-size: 12px;
    }
    .chat-date-divider {
        text-align: center;
        font-size: 10px;
        color: #aaa;
        margin: 8px 0;
        position: relative;
    }
    .chat-date-divider span {
        background: #f5f7fa;
        padding: 0 10px;
        position: relative;
        z-index: 1;
    }
    .chat-date-divider::before {
        content: '';
        position: absolute;
        left: 0;
        right: 0;
        top: 50%;
        height: 1px;
        background: #e0e0e0;
    }
</style>

</head>
<body class="hold-transition skin-blue sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="<?php echo NEWTHEME?>index2.html" class="logo">
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
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          
          <!-- User Account: style can be found in dropdown.less -->

        <li class="dropdown user user-menu">
            <a href="<?php echo BASEURL?>dash/jam">
              <span class="hidden-xs"><div id="clock"></div></span>
            </a>
            
          </li>
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo foto(callSessUser('id_user')) ?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo callSessUser('nama_user') ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php echo foto(callSessUser('id_user')) ?>" class="img-circle" alt="User Image">

                <p>
                  <?php echo callSessUser('nama_user') ?>
                  <small></small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?php echo BASEURL?>User/myprofile" class="btn btn-default btn-flat">My Profile</a>
                </div>
                <div class="pull-right">
                  <a href="<?php echo BASEURL.'login/signout' ?>" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>

  <!-- =============================================== -->

  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel" style="height: 8vh;">
        <div class="pull-left image">
          <img src="<?php echo foto(callSessUser('id_user')) ?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo callSessUser('nama_user') ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <!-- <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form> -->
      <!-- /.search form -->
      <ul class="sidebar-menu" data-widget="tree">
    <li class="header">MAIN NAVIGATION</li>

    <?php foreach(MenuParentForUSer() as $mp){ ?>
        <?php if(!empty(MenuSub1($mp['id']))){ ?>

        <!-- PARENT MENU -->
        <li class="treeview">
            <a href="<?php echo $mp['url'] ?>">
                <i class="fa-solid fa-share-nodes"></i>
                <span><?php echo $mp['nama'] ?></span>
                <span class="pull-right-container">
                    <i class="fa-solid fa-angle-left pull-right"></i>
                </span>
            </a>

            <ul class="treeview-menu">

                <?php foreach(MenuSub1($mp['id']) as $sub1){ ?>
                    <?php if(!empty(MenuSub2($sub1['id']))){ ?>

                    <!-- SUB 1 -->
                    <li class="treeview">
                        <a href="#">
                            <i class="fa-solid fa-circle-dot"></i>
                            <?php echo $sub1['nama'] ?>
                            <span class="pull-right-container">
                                <i class="fa-solid fa-angle-left pull-right"></i>
                            </span>
                        </a>

                        <ul class="treeview-menu">

                            <?php foreach(MenuSub2($sub1['id']) as $sub2){ ?>
                                <?php if(!empty(MenuSub3($sub2['id']))){ ?>

                                <!-- SUB 2 -->
                                <li class="treeview">
                                    <a href="<?php echo BASEURL.$sub2['url'] ?>">
                                        <i class="fa-solid fa-circle-dot"></i>
                                        <?php echo $sub2['nama'] ?>
                                        <span class="pull-right-container">
                                            <i class="fa-solid fa-angle-left pull-right"></i>
                                        </span>
                                    </a>

                                    <ul class="treeview-menu">

                                        <?php foreach(MenuSub3($sub2['id']) as $sub3){ ?>
                                        <!-- SUB 3 -->
                                        <li>
                                            <a href="<?php echo BASEURL.$sub3['url'] ?>">
                                                <i class="fa-solid fa-circle-dot"></i>
                                                <?php echo $sub3['nama'] ?>
                                            </a>
                                        </li>
                                        <?php } ?>

                                    </ul>
                                </li>

                                <?php } else { ?>

                                <!-- SUB 2 tanpa child -->
                                <li>
                                    <a href="<?php echo BASEURL.$sub2['url'] ?>">
                                        <i class="fa-solid fa-circle-dot"></i>
                                        <?php echo $sub2['nama'] ?>
                                    </a>
                                </li>

                                <?php } ?>
                            <?php } ?>

                        </ul>
                    </li>

                    <?php } else { ?>

                    <!-- SUB 1 tanpa child -->
                    <li>
                        <a href="<?php echo BASEURL.$sub1['url'] ?>">
                            <i class="fa-solid fa-circle-dot"></i>
                            <?php echo $sub1['nama'] ?>
                        </a>
                    </li>

                    <?php } ?>
                <?php } ?>

            </ul>
        </li>

        <?php } else { ?>

        <!-- MENU TANPA SUB -->
        <li class="nav-item">
            <a href="<?php echo BASEURL.$mp['url'] ?>" class="nav-link">
                
                <p><i class="fa-solid fa-circle-dot"></i><?php echo $mp['nama'] ?></p>
            </a>
        </li>

        <?php } ?>
    <?php } ?>

    <!-- LOGOUT -->
    <li>
        <a href="<?php echo BASEURL.'login/signout' ?>">
            <i class="fa-solid fa-right-from-bracket"></i>
            <span>Log Out</span>
        </a>
    </li>
</ul>

    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border no-print">
          <h5 class="box-title">
            <?php 
                      if(isset($title)){
                        echo $title;
                      }else{
                        
                      }
                    ?>
          </h5>

         <span class="pull-right text-danger">
              <?php echo status_oto() ?>
         </span>
        </div>
        <div class="box-body">
          <div class="content">
          <?php if(!empty($this->session->flashdata('msg'))){?>
              <div class="alert alert-success alert-dismissible">
                  <span><?php echo $this->session->flashdata('msg') ?></span>
              </div>
          <?php } ?>
          <?php if(!empty($this->session->flashdata('gagal'))){?>
              <div class="alert alert-danger alert-dismissible">
                  <span><?php echo $this->session->flashdata('gagal') ?></span>
              </div>
          <?php } ?>
            <?php if(isset($page)){?>
                 
                  <?php $this->load->view('newtheme/page/script');?>
                  <?php $this->load->view($page);?>
                    <?php } ?>
          </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer registered no-print">
          Registered by Forboys Production System <?php echo date('d-m-Y H:i:s'); ?>
        </div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer no-print">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.4.18
    </div>
    <strong>Copyright &copy; 2020-<?php echo date('Y') ?> <a href="<?php echo BASEURL ?>">Forboys Production System</a>.</strong> All rights
    reserved.
  </footer>

  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

        <div class="modal fade" id="alertfoto">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Peringatan</h4>
              </div>
              <div class="modal-body">
                <p>Harap ubah foto anda&hellip; <a href="<?php echo BASEURL?>User/myprofile" class="btn btn-info">Ok</a></p>
              </div>
              <div class="modal-footer">
                <a href="<?php echo BASEURL?>User/myprofile"></a>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>

        <div class="modal fade" id="alertpassword">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Peringatan</h4>
              </div>
              <div class="modal-body">
                <p>Harap ubah password anda&hellip; <a href="<?php echo BASEURL?>User/myprofile" class="btn btn-info">Ok</a></p>
              </div>
              <div class="modal-footer">
                <a href="<?php echo BASEURL?>User/myprofile"></a>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
<script>

  function cetak(){
    window.print();
  }
  function filterwithpo(){
    url='?';
    
    var filter_date_start = $('input[name=\'tanggal1\']').val();

    if (filter_date_start) {
      url += '&tanggal1=' + encodeURIComponent(filter_date_start);
    }

    var filter_date_end = $('input[name=\'tanggal2\']').val();

    if (filter_date_end) {
      url += '&tanggal2=' + encodeURIComponent(filter_date_end);
    }

    var filter_status = $('select[name=\'kode_po\']').val();

    if (filter_status != '*') {
      url += '&kode_po=' + encodeURIComponent(filter_status);
    }
    location =url;
  }

  function filterwithcmt(){
    url='?';
    
    var filter_date_start = $('input[name=\'tanggal1\']').val();

    if (filter_date_start) {
      url += '&tanggal1=' + encodeURIComponent(filter_date_start);
    }

    var filter_date_end = $('input[name=\'tanggal2\']').val();

    if (filter_date_end) {
      url += '&tanggal2=' + encodeURIComponent(filter_date_end);
    }

    var filter_status = $('select[name=\'cmt\']').val();

    if (filter_status != '*') {
      url += '&cmt=' + encodeURIComponent(filter_status);
    }

    var sj = $('select[name=\'sj\']').val();

    if (sj != '*') {
      url += '&sj=' + encodeURIComponent(sj);
    }
    location =url;
  }

  function filtertglonly(){
    var url='?';
    var tanggal1 =$("#tanggal1").val();
    var tanggal2 =$("#tanggal2").val();
    if(tanggal1){
      url+='&tanggal1='+tanggal1;
    }
    if(tanggal2){
      url+='&tanggal2='+tanggal2;
    }
    location =url;
  }

  function filtertglonly_excel(){
    var url='?&excel=1';
    var tanggal1 =$("#tanggal1").val();
    var tanggal2 =$("#tanggal2").val();
    if(tanggal1){
      url+='&tanggal1='+tanggal1;
    }
    if(tanggal2){
      url+='&tanggal2='+tanggal2;
    }
    location =url;
  }

  function filterbulan(){
    var url='?';
    var tanggal1 =$("#bulan").val();
    var tanggal2 =$("#tahun").val();
    if(tanggal1){
      url+='&bulan='+tanggal1;
    }
    if(tanggal2){
      url+='&tahun='+tanggal2;
    }
    location =url;
  }

  function filterbulancmt(){
    var url='?';
    var tanggal1 =$("#bulan").val();
    var tanggal2 =$("#tahun").val();
    var cmt =$("#cmt").val();
    if(tanggal1){
      url+='&bulan='+tanggal1;
    }
    if(tanggal2){
      url+='&tahun='+tanggal2;
    }
    if(cmt!='*'){
      url+='&cmt='+cmt;
    }
    location =url;
  }

  function excelwithtgl(){
    var url='?&excel=1';
    var tanggal1 =$("#tanggal1").val();
    var tanggal2 =$("#tanggal2").val();
    if(tanggal1){
      url+='&tanggal1='+tanggal1;
    }
    if(tanggal2){
      url+='&tanggal2='+tanggal2;
    }
    location =url;
  }


  $(function () {


    //Initialize Select2 Elements
    //$('.select2').select2();
    $('.select2bs4').select2();
    

    $("input[name=\'tanggal\']").attr('type', 'text');
        $("input[name=\'tanggal\']").attr('type', 'text');
        $("input[name=\'tanggal\']").addClass("datepicker");
        $("input[name=\'tanggal\']").attr("readonly",true);
        $("input[name=\'tgl\']").attr("readonly",true);
        $("input[name=\'tanggalMulai\']").attr('type', 'text');
        $("input[name=\'tanggalEnd\']").attr('type', 'text');
        $("input[name=\'tanggalMulai\']").addClass("datepicker");
        $("input[name=\'tanggalEnd\']").addClass("datepicker");
        $("input[name=\'tanggal1\']").attr('type', 'text');
        $("input[name=\'tanggal1\']").addClass("datepicker");
        $("input[name=\'tanggal2\']").attr('type', 'text');
        $("input[name=\'tanggal2\']").addClass("datepicker");
        $(".table").addClass("table-striped table-hover");
    //Date picker
    $.fn.datepicker.defaults.format = "yyyy-mm-dd";
    $('#datepicker').datepicker({
        
       autoclose: true
    });
    $('.datepicker').datepicker({
        
         autoclose: true,
    });

    $('.datelockback').datepicker({
         autoclose: true,
        startDate: new Date(),
    });


    

    
  })
</script>
<?php if( foto(callSessUser('id_user'))=='no_image.png'){?>
  <?php if(isset($pic)){ ?>

  <?php } else { ?>
<script type="text/javascript">
  $(document).ready(function () {
      $('#alertfoto').modal({backdrop: 'static', keyboard: false});
  });
</script>
<?php } ?>

<?php } ?>

<?php if( ubah_password(callSessUser('id_user')) == '0' || ubah_password(callSessUser('id_user')) == 0 ){?>

  <?php if(isset($pic)){ ?>

<?php } else { ?>
<script type="text/javascript">
  $(document).ready(function () {
      $('#alertpassword').modal({backdrop: 'static', keyboard: false});
  });
</script>
<?php } ?>

<?php } ?>

<script>
  $(document).ready(function () {
      var perpage=25;
      info =window.location.origin;
      

      
      //jQuery.noConflict();

   if(info=='http://localhost'){
    var uri=window.location.origin+'/fb2/Json/';
   }else{
    var uri=window.location.origin+'/Json/';
   }
   
   $(document).on('click', '.remove', function(){
		$(this).closest('tr').remove();
	});

    $('.autopo').select2({
      //theme: 'bootstrap4',
      placeholder: '--- Pilih ---',
        ajax: {
          url: uri+'search_po',
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
            return {
              results: data
            };
          },
          cache: true
        }
    });

    $('.autopoluar').select2({
      //theme: 'bootstrap4',
      placeholder: '--- Pilih ---',
        ajax: {
          url: uri+'search_po_luar',
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
            return {
              results: data
            };
          },
          cache: true
        }
    });


    $('.autopoiinputpotongan').select2({
      //theme: 'bootstrap4',
      placeholder: '--- Pilih ---',
        ajax: {
          url: uri+'search_po_for_input_potongan',
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
            return {
              results: data
            };
          },
          cache: true
        }
    });


    $('.autopobawahansablon').select2({
      //theme: 'bootstrap4',
      placeholder: '--- Pilih ---',
        ajax: {
          url: uri+'search_po_bawahansablon',
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
            return {
              results: data
            };
          },
          cache: true
        }
    });


    $('.autocmtbawahansablon').select2({
      //theme: 'bootstrap4',
      placeholder: '--- Pilih ---',
        ajax: {
          url: uri+'search_cmt_bawahansablon',
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
            return {
              results: data
            };
          },
          cache: true
        }
    });


    $('.autojobbawahansablon').select2({
      //theme: 'bootstrap4',
      placeholder: '--- Pilih ---',
        ajax: {
          url: uri+'search_job_bawahansablon',
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
            return {
              results: data
            };
          },
          cache: true
        }
    });

    $('.autooperator').select2({
      //theme: 'bootstrap4',
      placeholder: '--- Pilih ---',
        ajax: {
          url: uri+'search_operator',
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
            return {
              results: data
            };
          },
          cache: true
        }
    });


    $('.autojenispotongan').select2({
      //theme: 'bootstrap4',
      placeholder: '--- Pilih ---',
        ajax: {
          url: uri+'search_jenispotongan',
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
            return {
              results: data
            };
          },
          cache: true
        }
    });

    $('.sj').select2({
      //theme: 'bootstrap4',
      placeholder: '--- Pilih ---',
        ajax: {
          url: uri+'search_sj',
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
            return {
              results: data
            };
          },
          cache: true
        }
    });

    $('.sjsablon').select2({
      //theme: 'bootstrap4',
      placeholder: '--- Pilih ---',
        ajax: {
          url: uri+'search_sj_sablon',
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
            return {
              results: data
            };
          },
          cache: true
        }
    });

    $( ".byrcmt" ).change(function() {
      $('#sub1').empty();
      var cmts = $(this).val();
      $.get(uri+'pot_transport?&cmt='+cmts, 
        function(data){   
          //console.log(data);
          $('#sub1').append(data);
      });
    });

    $('.autopoid').select2({
      //theme: 'bootstrap4',
      placeholder: '--- Pilih ---',
        ajax: {
          url: uri+'autopoid',
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
            return {
              results: data
            };
          },
          cache: true
        }
    });

      $('.sidebar-menu').tree();
      
      $('#datatable').DataTable({
        'paging'      : true,
        'lengthChange': false,
        'searching'   : true,
        'ordering'    : false,
        'info'        : false,
        'autoWidth'   : false,
        pageLength: perpage,
        responsive: true
      });

      $('.yessearch').DataTable({
        'paging'      : true,
        'lengthChange': false,
        'searching'   : true,
        'ordering'    : false,
        'info'        : false,
        'autoWidth'   : false,
         pageLength: perpage,
        responsive: true
      });

      $('.nosearch').DataTable({
        'paging'      : true,
        'lengthChange': false,
        'searching'   : false,
        'ordering'    : false,
        'info'        : false,
        'autoWidth'   : false,
        pageLength: perpage,
        responsive: true
      });

      $('.default').DataTable({
        'paging'      : true,
        'lengthChange': true,
        'searching'   : true,
        'ordering'    : false,
        'info'        : false,
        'autoWidth'   : false,
        pageLength: perpage,
        responsive: true
      });

    updateClock();
    
    // ===== CHAT SYSTEM =====
    var currentChatUserId = null;
    var currentChatUserName = '';
    var currentChatUserFoto = '';
    var currentChatUserOnline = false;
    var chatLastMessageId = 0;
    var chatPollingInterval = null;
    var myUserId = <?php echo $this->session->userdata('id_user'); ?>;

    // Toggle sidebar
    $("#chat-header").click(function(e) {
        if ($(e.target).closest('.back-btn').length) return;
        $("#chat-sidebar").toggleClass("collapsed");
    });

    // Fetch user list
    function fetchChatUsers() {
        $.ajax({
            url: "<?php echo BASEURL ?>Dash/getChatUsers",
            type: "GET",
            dataType: "json",
            success: function(users) {
                var html = '';
                var totalUnread = 0;
                if (users.length > 0) {
                    users.forEach(function(user) {
                        totalUnread += parseInt(user.unread || 0);
                        var dotClass = parseInt(user.is_online) ? 'online-dot' : 'offline-dot';
                        var lastMsg = user.last_message ? user.last_message.substring(0, 30) : 'Mulai percakapan...';
                        var unreadHtml = parseInt(user.unread) > 0 ? '<div class="unread-badge">' + user.unread + '</div>' : '';
                        html += '<div class="chat-user-item" data-userid="' + user.id_user + '" data-username="' + user.nama_user + '" data-foto="' + user.foto_url + '" data-online="' + user.is_online + '">';
                        html += '  <div class="user-avatar-wrap"><img src="' + user.foto_url + '" alt=""><div class="' + dotClass + '"></div></div>';
                        html += '  <div class="chat-user-info"><div class="name">' + user.nama_user + '</div><div class="last-msg">' + lastMsg + '</div></div>';
                        html += '  ' + unreadHtml;
                        html += '</div>';
                    });
                } else {
                    html = '<div class="chat-empty-state"><i class="fa fa-comments" style="font-size:24px;margin-bottom:8px;display:block;"></i>Tidak ada user yang online</div>';
                }
                $("#chat-user-list").html(html);
                
                // Update header badge
                if (totalUnread > 0) {
                    $(".badge-unread").text(totalUnread).show();
                } else {
                    $(".badge-unread").hide();
                }
                $("#chat-online-count").text(users.filter(function(u){ return parseInt(u.is_online); }).length);
            }
        });
    }

    // Open conversation
    $(document).on('click', '.chat-user-item', function() {
        currentChatUserId = $(this).data('userid');
        currentChatUserName = $(this).data('username');
        currentChatUserFoto = $(this).data('foto');
        currentChatUserOnline = parseInt($(this).data('online'));
        chatLastMessageId = 0;

        // Update conversation header
        $("#conv-user-foto").attr('src', currentChatUserFoto);
        $("#conv-user-name").text(currentChatUserName);
        $("#conv-user-status").text(currentChatUserOnline ? 'Online' : 'Offline');
        $("#conv-user-status").css('color', currentChatUserOnline ? '#28a745' : '#aaa');

        // Switch views
        $("#chat-user-list").hide();
        $("#chat-conversation").css('display', 'flex');
        $("#chat-messages").html('<div class="chat-empty-state">Memuat pesan...</div>');

        // Load messages
        loadMessages(false);

        // Start polling for new messages
        if (chatPollingInterval) clearInterval(chatPollingInterval);
        chatPollingInterval = setInterval(function() {
            loadMessages(true);
        }, 3000);
    });

    // Back to user list
    $(document).on('click', '.back-btn', function(e) {
        e.stopPropagation();
        currentChatUserId = null;
        if (chatPollingInterval) clearInterval(chatPollingInterval);
        
        $("#chat-conversation").css('display', 'none');
        $("#chat-user-list").show();
        fetchChatUsers(); // Refresh user list
    });

    // Load messages
    var isLoadingMessages = false;
    function loadMessages(polling) {
        if (!currentChatUserId || isLoadingMessages) return;
        isLoadingMessages = true;
        
        var params = { user_id: currentChatUserId };
        if (polling && chatLastMessageId > 0) {
            params.last_id = chatLastMessageId;
        }

        $.ajax({
            url: "<?php echo BASEURL ?>Dash/getMessages",
            type: "GET",
            data: params,
            dataType: "json",
            success: function(messages) {
                if (!polling || chatLastMessageId === 0) {
                    // Full load
                    if (messages.length === 0) {
                        $("#chat-messages").html('<div class="chat-empty-state"><i class="fa fa-comment-o" style="font-size:24px;margin-bottom:8px;display:block;"></i>Belum ada pesan.<br>Mulai percakapan!</div>');
                        isLoadingMessages = false;
                        return;
                    }
                    var html = '';
                    messages.forEach(function(msg) {
                        html += renderMessage(msg);
                    });
                    $("#chat-messages").html(html);
                    chatLastMessageId = messages[messages.length - 1].id;
                } else {
                    // Append new messages only
                    if (messages.length > 0) {
                        // Remove empty state if present
                        $(".chat-empty-state", "#chat-messages").remove();
                        messages.forEach(function(msg) {
                            $("#chat-messages").append(renderMessage(msg));
                        });
                        chatLastMessageId = messages[messages.length - 1].id;
                    }
                }
                // Scroll to bottom
                var chatEl = document.getElementById('chat-messages');
                if (chatEl) chatEl.scrollTop = chatEl.scrollHeight;
                isLoadingMessages = false;
            },
            error: function() {
                isLoadingMessages = false;
            }
        });
    }

    // Render a single message bubble
    function renderMessage(msg) {
        var isSent = parseInt(msg.sender_id) === myUserId;
        var cls = isSent ? 'sent' : 'received';
        var time = formatChatTime(msg.created_at);
        return '<div class="chat-msg ' + cls + '">' + 
               msg.message + 
               '<span class="msg-time">' + time + '</span>' +
               '</div>';
    }

    // Format time
    function formatChatTime(datetime) {
        if (!datetime) return '';
        var d = new Date(datetime);
        var now = new Date();
        var hours = d.getHours().toString().padStart(2, '0');
        var mins = d.getMinutes().toString().padStart(2, '0');
        
        if (d.toDateString() === now.toDateString()) {
            return hours + ':' + mins;
        } else {
            var day = d.getDate().toString().padStart(2, '0');
            var month = (d.getMonth() + 1).toString().padStart(2, '0');
            return day + '/' + month + ' ' + hours + ':' + mins;
        }
    }

    // Send message
    $("#chat-send-btn").click(function() {
        sendChatMessage();
    });

    $("#chat-input").keypress(function(e) {
        if (e.which === 13) {
            sendChatMessage();
        }
    });

    function sendChatMessage() {
        var msg = $("#chat-input").val().trim();
        if (!msg || !currentChatUserId) return;

        $("#chat-input").val('');

        $.ajax({
            url: "<?php echo BASEURL ?>Dash/sendMessage",
            type: "POST",
            data: { receiver_id: currentChatUserId, message: msg },
            dataType: "json",
            success: function(res) {
                if (res.status === 'success') {
                    // Immediately load new messages
                    loadMessages(true);
                }
            }
        });
    }

    // Initial load
    fetchChatUsers();
    setInterval(function() {
        if (!currentChatUserId) {
            fetchChatUsers();
        }
    }, 15000);

  });

  function updateClock() {
        var now = new Date();
        var hours = now.getHours();
        var minutes = now.getMinutes();
        var seconds = now.getSeconds();
        
        // Format waktu agar selalu dua digit (mis. 09:05:01)
        hours = hours < 10 ? '0' + hours : hours;
        minutes = minutes < 10 ? '0' + minutes : minutes;
        seconds = seconds < 10 ? '0' + seconds : seconds;
        
        var time = hours + ':' + minutes + ':' + seconds;
        
        let clockEl = document.getElementById('clock');
        if(clockEl) clockEl.innerHTML = time;

        let jamEl = document.getElementById('jam');
        if(jamEl) jamEl.innerHTML = time;
        
        setTimeout(updateClock, 1000); // Pembaruan setiap 1 detik
    }
</script>

<!-- Chat Sidebar -->
<div id="chat-sidebar" class="collapsed">
    <div id="chat-header">
        <span><i class="fa fa-comments"></i> Chat <span class="badge-unread">0</span></span>
        <span style="font-size:12px;opacity:0.8;"><span id="chat-online-count">0</span> online <i class="fa fa-chevron-up"></i></span>
    </div>
    
    <!-- User List View -->
    <div id="chat-user-list">
        <div class="chat-empty-state">Memuat...</div>
    </div>

    <!-- Conversation View -->
    <div id="chat-conversation">
        <div id="chat-conv-header">
            <i class="fa fa-arrow-left back-btn"></i>
            <img id="conv-user-foto" src="" alt="">
            <span class="conv-name" id="conv-user-name"></span>
            <span class="conv-status" id="conv-user-status">Online</span>
        </div>
        <div id="chat-messages"></div>
        <div id="chat-input-area">
            <input type="text" id="chat-input" placeholder="Ketik pesan..." autocomplete="off">
            <button id="chat-send-btn"><i class="fa fa-paper-plane"></i></button>
        </div>
    </div>
</div>

<!-- Global Modal Cetak PDF -->
<div class="modal fade" id="modalPdfGlobal" tabindex="-1" role="dialog" aria-labelledby="modalPdfGlobalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 90%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="modalPdfGlobalLabel">Cetak PDF</h4>
            </div>
            <div class="modal-body" style="position: relative;">
                <!-- Loader Spinner -->
                <div id="pdfLoader" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 10;">
                    <div class="text-center">
                        <i class="fa fa-spinner fa-spin fa-3x fa-fw text-blue"></i>
                        <span class="sr-only">Loading...</span>
                        <p>Sedang memuat dokumen...</p>
                    </div>
                </div>
                <iframe id="pdfFrameGlobal" src="" style="width: 100%; height: 80vh; border: none; display: none;"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    function showPdfModal(url, title = "Cetak PDF") {
        const modal = $('#modalPdfGlobal');
        const frame = document.getElementById('pdfFrameGlobal');
        const loader = document.getElementById('pdfLoader');
        
        // Set title
        modal.find('.modal-title').text(title);
        
        // Show loader and hide frame
        loader.style.display = 'block';
        frame.style.display = 'none';
        
        // Set URL and show modal
        frame.src = url;
        modal.modal('show');
        
        // Hide loader when iframe finished loading
        frame.onload = function() {
            loader.style.display = 'none';
            frame.style.display = 'block';
        };
    }

    $(document).ready(function() {
        // Reset iframe src when modal is closed
        $('#modalPdfGlobal').on('hidden.bs.modal', function () {
            document.getElementById('pdfFrameGlobal').src = "";
            document.getElementById('pdfFrameGlobal').style.display = 'none';
            document.getElementById('pdfLoader').style.display = 'block';
        });
    });
</script>

<?php //$this->load->view('newtheme/page/script');?>
</body>
</html>
