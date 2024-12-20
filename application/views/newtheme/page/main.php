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
              <img src="<?php echo BASEURL?><?php echo foto(callSessUser('id_user')) ?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo callSessUser('nama_user') ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php echo BASEURL?><?php echo foto(callSessUser('id_user')) ?>" class="img-circle" alt="User Image">

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
      <div class="user-panel" style="height: 4vw;">
        <div class="pull-left image">
          <img src="<?php echo BASEURL?><?php echo foto(callSessUser('id_user')) ?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo callSessUser('nama_user') ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
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
        $(".table").addClass("table-striped");
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
      var perpage=100;
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
        
        document.getElementById('clock').innerHTML = time;
        document.getElementById('jam').innerHTML = time;
        
        setTimeout(updateClock, 1000); // Pembaruan setiap 1 detik
    }
</script>
<?php //$this->load->view('newtheme/page/script');?>
</body>
</html>
