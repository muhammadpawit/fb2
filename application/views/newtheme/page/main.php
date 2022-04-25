<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Forbys Production System</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?php echo NEWTHEME?>plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo NEWTHEME?>dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!--Google font Roboto -->
  <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
   <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo NEWTHEME?>plugins/select2/css/select2.min.css">
  <link href="<?php echo PLUGINS ?>bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="<?php echo NEWTHEME?>plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- DataTables -->
  <link href="<?php echo PLUGINS ?>datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo PLUGINS ?>datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
  <!-- Responsive datatable examples -->
  <link href="<?php echo PLUGINS ?>datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />  
  <!-- datepicker -->
  <link rel="stylesheet" href="<?php echo PLUGINS?>bootstrap-datepicker/css/bootstrap-datepicker.min.css">
  <!-- jQuery -->
<script src="<?php echo NEWTHEME?>plugins/jquery/jquery.min.js"></script>
<!-- datepicker -->
<script src="<?php echo PLUGINS?>bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo NEWTHEME?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo NEWTHEME?>dist/js/adminlte.min.js"></script>
<!-- Select2 -->
<script src="<?php echo NEWTHEME?>plugins/select2/js/select2.full.min.js"></script>
<!-- Required datatable js -->
<script src="<?php echo PLUGINS ?>datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo PLUGINS ?>datatables/dataTables.bootstrap4.min.js"></script>
<!-- Responsive examples -->
<script src="<?php echo PLUGINS ?>datatables/dataTables.responsive.min.js"></script>
<script src="<?php echo PLUGINS ?>datatables/responsive.bootstrap4.min.js"></script>

<style type="text/css">
  
  body{text-transform:capitalize !important;font-size: 12px;font-family: 'Roboto';-webkit-print-color-adjust: exact !important;}
  
  @import url('https://fonts.googleapis.com/css2?family=Baskervville:ital@1&display=swap');
  .registered {
    font-family: 'Baskervville', serif;
  }
  table{font-family: 'Roboto';font-size: 13px !important;width: 100% !important;margin-top: 15px !important;text-transform:capitalize !important;}
  
  .full{width: 100% !important;}
  .print{ display:none !important}
  @media print
  {    
    body{text-transform:capitalize;}
    .print{ display:block !important}
    .no-print, .no-print *
    {
        display: none !important;
    }
  .yaprint tr{background-color: yellow !important}
  }

  table th td {text-transform:capitalize !important;}
  .table{text-transform:capitalize !important;}

</style>

<!-- PushAlert -->
        <script type="text/javascript">
                (function(d, t) {
                        var g = d.createElement(t),
                        s = d.getElementsByTagName(t)[0];
                        g.src = "https://cdn.pushalert.co/integrate_a704c8bf56f63c0de758b5513d2d18a0.js";
                        s.parentNode.insertBefore(g, s);
                }(document, "script"));
        </script>
        <!-- End PushAlert -->
</head>
<body class="hold-transition sidebar-mini sidebar-collapse">  
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button"><i
            class="fas fa-th-large"></i></a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: #183a40 !important">
    <!-- Brand Logo -->
    <a href="<?php echo BASEURL.'dash'?>" class="brand-link">
      <!--<img src="<?php echo BASEURL?>assets/images/logofb.jpeg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">-->
      <span class="brand-text font-weight-light" style="font-size: 17px !important">Forboys Production System</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <!-- <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image"> -->
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo callSessUser('nama_user') ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <?php foreach(MenuParentForUSer() as $mp){?>
            <?php if(!empty(MenuSub1($mp['id']))){?>
              <li class="nav-item has-treeview ">
                <a href="<?php echo $mp['url']?>" class="nav-link "> <!--active-->
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                    <?php echo $mp['nama']?>
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <?php foreach( MenuSub1($mp['id']) as $sub1 ){?>
                  <?php if(!empty(MenuSub2($sub1['id']))){?>
                  <ul class="nav nav-treeview">
                      <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-circle"></i>
                          <p>
                            <?php echo $sub1['nama']?>
                            <i class="right fas fa-angle-left"></i>
                          </p>
                        </a>
                        <?php foreach( MenuSub2($sub1['id']) as $sub2 ){?>
                        <?php if( !empty(MenuSub3($sub2['id']) ) ) {?>
                        <ul class="nav nav-treeview">
                          <li class="nav-item">
                            <a href="<?php echo BASEURL.$sub2['url'] ?>" class="nav-link">
                              <i class="nav-icon <?php echo $sub2['icon'] ?>"></i>
                              <p><?php echo $sub2['nama'] ?><i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                              <?php foreach(MenuSub3($sub2['id']) as $sub3 ){?>
                              <li class="nav-item">
                                <a href="<?php echo BASEURL.$sub3['url'] ?>" class="nav-link">
                                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="<?php echo $sub3['icon']?>"></i>
                                  <p><?php echo $sub3['nama']?></p>
                                </a>
                              </li>
                            <?php } ?>
                            </ul>
                          </li>
                        </ul>
                        <?php }else{?>
                        <ul class="nav nav-treeview">
                          <li class="nav-item">
                            <a href="<?php echo BASEURL.$sub2['url'] ?>" class="nav-link">
                              <i class="<?php echo $sub2['icon']?>"></i>
                              <p><?php echo $sub2['nama']?></p>
                            </a>
                          </li>
                        </ul>
                        <?php } ?>

                        <?php } ?>
                      </li>
                  </ul>
                  <?php }else{?>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="<?php echo BASEURL.$sub1['url'] ?>" class="nav-link">
                          <i class="nav-icon fas fa-circle"></i>
                          <?php if($sub1['id']==111){?>
                            <p><?php echo $sub1['nama']?> <span class="right badge bg-success" style="text-align: right;font-size: 12px;"><?php echo ajuanpending()?></span></p>
                          <?php }else{?>
                            <p><?php echo $sub1['nama']?> <span class="badge" style="text-align: right;"></span></p>
                          <?php } ?>
                        </a>
                      </li>
                    </ul>
                  <?php }?>
                <?php } ?>
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
          <li class="nav-item">
            <a href="https://beta.forboysproduction.com/" target="_blank" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
                Produksi 2020-2021
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo BASEURL.'login/signout' ?>" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
                Logout
              </p>
            </a>
          </li>


          <?php $menulama=0;?>
          <?php if($menulama==1){?>
          <li class="nav-item">
            <a href="<?php echo BASEURL.'dash' ?>" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo BASEURL.'dash/alurproduksi' ?>" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Alur Sistem Produksi </p>
            </a>
          </li>
          <li class="nav-item has-treeview "> <!-- menu-open -->
            <a href="#" class="nav-link "> <!--active-->
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Master Data
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
             <?php if(callSessUser('nama_user')=='Muchlas' OR callSessUser('nama_user')=='Pawit' OR callSessUser('nama_user')=='administrator'){?>
            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-circle"></i>
                  <p>
                    CMT
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?php echo BASEURL.'Masterdata/cmtsablon' ?>" class="nav-link">
                      <i class="nav-icon fas fa-circle"></i>
                      <p>Sablon</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo BASEURL.'Masterdata/cmt' ?>" class="nav-link">
                      <i class="nav-icon fas fa-circle"></i>
                      <p>Jahit <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="<?php echo BASEURL.'Masterdata/lokasicmt' ?>" class="nav-link">
                          <!--<i class="far fa-circle nav-icon"></i>-->
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                          <p>Tambah Lokasi CMT </p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="<?php echo BASEURL.'Masterdata/cmt' ?>" class="nav-link">
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                          <p>All </p>
                        </a>
                      </li>
                      <?php foreach(lokasi() as $l){?>
                        <li class="nav-item">
                        <a href="<?php echo BASEURL.'Masterdata/cmt?lokasi='.$l['id'] ?>" class="nav-link">
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                          <p><?php echo strtolower($l['lokasi'])?> </p>
                        </a>
                      </li>
                      <?php } ?>
                      <!--
                      <li class="nav-item">
                        <a href="<?php echo BASEURL.'Masterdata/cmt?lokasi=1' ?>" class="nav-link">
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                          <p>Serang </p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="<?php echo BASEURL.'Masterdata/cmt?lokasi=2' ?>" class="nav-link">
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                          <p>Jawa </p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="<?php echo BASEURL.'Masterdata/cmt?lokasi=3' ?>" class="nav-link">
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                          <p>Sukabumi </p>
                        </a>
                      </li>-->
                    </ul>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="nav-icon fas fa-circle"></i>
                      <p>Ongkos <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                      <a href="<?php echo BASEURL.'Masterdata/hargajob/1' ?>" class="nav-link">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                        <p>Jahit</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo BASEURL.'Masterdata/hargajob/2' ?>" class="nav-link">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                        <p>Sablon</p>
                      </a>
                    </li>
                    </ul>
                   </li>
                </ul>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-circle"></i>
                  <p>
                    Penggajian
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?php echo BASEURL.'Finishing/karyawan' ?>" class="nav-link">
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                      <p>Harian & Borongan</p>
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
            <?php  } ?>
            <ul class="nav nav-treeview">
              <?php if(callSessUser('nama_user')=='Muchlas' OR callSessUser('nama_user')=='Pawit' OR callSessUser('nama_user')=='administrator'){?>
              <li class="nav-item">
                <a href="<?php echo BASEURL.'masterdata/divisi' ?>" class="nav-link">
                  <i class="nav-icon fas fa-circle"></i>
                  <p>Divisi</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo BASEURL.'masterdata/jabatan' ?>" class="nav-link">
                  <i class="nav-icon fas fa-circle"></i>
                  <p>Jabatan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo BASEURL.'masterdata/karyawan' ?>" class="nav-link">
                  <i class="nav-icon fas fa-circle"></i>
                  <p>Karyawan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo BASEURL.'masterdata/user' ?>" class="nav-link">
                  <i class="nav-icon fas fa-circle"></i>
                  <p>Otorisasi User</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo BASEURL.'masterdata/timpotong' ?>" class="nav-link">
                  <i class="nav-icon fas fa-circle"></i>
                  <p>Tim Potong</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo BASEURL.'masterdata/hargapotongan' ?>" class="nav-link">
                  <i class="nav-icon fas fa-circle"></i>
                  <p>Harga Potongan</p>
                </a>
              </li>
              <?php } ?>
              <li class="nav-item">
                <a href="<?php echo BASEURL.'Kelolapo/produksipo' ?>" class="nav-link">
                    <i class="nav-icon fas fa-circle"></i>
                    <p>Kode PO</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo BASEURL.'masterdata/persediaan' ?>" class="nav-link">
                  <i class="nav-icon fas fa-circle"></i>
                  <p>Persediaan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo BASEURL.'masterdata/satuanbarang' ?>" class="nav-link">
                  <i class="nav-icon fas fa-circle"></i>
                  <p>Satuan Barang</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo BASEURL.'masterdata/supplier' ?>" class="nav-link">
                  <i class="nav-icon fas fa-circle"></i>
                  <p>Supplier</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo BASEURL.'masterdata/karyawanbordir' ?>" class="nav-link">
                  <i class="nav-icon fas fa-circle"></i>
                  <p>Operator Bordir</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview "> <!-- menu-open -->
            <a href="#" class="nav-link "> <!--active-->
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Konveksi
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-circle"></i>
                  <p>
                    Gudang
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?php echo BASEURL.'Gudang/absensigudang' ?>" class="nav-link">
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                      <p>Absensi Gudang</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo BASEURL.'Gudang/pengajuan' ?>" class="nav-link">
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                      <p>Ajuan Harian</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo BASEURL.'Gudang/ajuanmingguan' ?>" class="nav-link">
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                      <p>Ajuan Mingguan</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo BASEURL.'Gudang/barangkeluar/1' ?>" class="nav-link">
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                      <p>Barang Keluar Bordir</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo BASEURL.'Gudang/barangkeluar/2' ?>" class="nav-link">
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                      <p>Barang Keluar Konveksi</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo BASEURL.'Gudang/barangkeluar/3' ?>" class="nav-link">
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                      <p>Bahan Keluar Harian</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo BASEURL.'Gudang/penerimaanitem/1' ?>" class="nav-link">
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                      <p>Item Konveksi</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo BASEURL.'Gudang/penerimaanitem/2' ?>" class="nav-link">
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                      <p>Item Bordir</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo BASEURL.'Gudang/Pengeluaranalat' ?>" class="nav-link">
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                      <p>Pengeluaran Alat</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo BASEURL.'Gudang/pengeluaranbahan' ?>" class="nav-link">
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                      <p>Pemakaian Bahan</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo BASEURL.'Gudang/persediaanstok' ?>" class="nav-link">
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                      <p>Stok Barang</p>
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-circle"></i>
                  <p>
                    Keuangan
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?php echo BASEURL.'Gudang/pengajuan' ?>" class="nav-link">
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                      <p>Ajuan Harian</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo BASEURL.'Keuangan/bank' ?>" class="nav-link">
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                      <p>Kas Operasional</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo BASEURL.'Keuangan/transferan' ?>" class="nav-link">
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                      <p>Transferan</p>
                    </a>
                  </li>
                  <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                      <i class="nav-icon fas fa-circle"></i>
                      <p>
                        Report
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="<?php echo BASEURL.'Report/operasionalkas' ?>" class="nav-link">
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                          <p>Kas Operasional  </p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="<?php echo BASEURL.'Report/transferkas' ?>" class="nav-link">
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                          <p>Transferan & Kas  </p>
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                      <i class="nav-icon fas fa-circle"></i>
                      <p>
                        Pembayaran CMT
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="<?php echo BASEURL.'Pembayaran/cmtjahit' ?>" class="nav-link">
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                          <p>Jahit  </p>
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class="nav-item has-treeview">
                    <a href="<?php echo BASEURL.'Keuangan/gajikaryawan' ?>" class="nav-link">
                      <i class="nav-icon fas fa-circle"></i>
                      <p>
                        Gaji Karyawan
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="<?php echo BASEURL.'Gaji/finishing' ?>" class="nav-link">
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                          <p>Resume Gaji Finishing </p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="<?php echo BASEURL.'Gaji/operatorbordir' ?>" class="nav-link">
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                          <p>Resume Gaji Operator Bordir </p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="<?php echo BASEURL.'Pembayaran/timpotong' ?>" class="nav-link">
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                          <p>Pembayaran tim potong </p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="<?php echo BASEURL.'Keuangan/kasbonkaryawan' ?>" class="nav-link">
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                          <p>Kasbon karyawan </p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="<?php echo BASEURL.'Keuangan/pinjamankaryawan' ?>" class="nav-link">
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                          <p>Pinjaman karyawan </p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="<?php echo BASEURL.'Keuangan/uangmakansecurity' ?>" class="nav-link">
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                          <p>Uang makan security</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="<?php echo BASEURL.'Keuangan/lemburkaryawan' ?>" class="nav-link">
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                          <p>Lembur karyawan </p>
                        </a>
                      </li>
                    </ul>
                  </li>
                </ul>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-circle"></i>
                  <p>
                    Kelola PO
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?php echo BASEURL.'Registerpo' ?>" class="nav-link">
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                      <p>Register Data PO</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo BASEURL.'Kelolapo/bukupotongan' ?>" class="nav-link">
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                      <p>Buku Potongan</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo BASEURL.'Kelolapo/kirimsetorcmt' ?>" class="nav-link">
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                      <p>Kirim & Setor CMT</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo BASEURL.'Kelolapo/pengecekanpotongan' ?>" class="nav-link">
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                      <p>Pengecekan Potongan</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo BASEURL.'alokasiposiapkirim' ?>" class="nav-link">
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                      <p>Alokasi PO Siap Kirim</p>
                    </a>
                  </li>
                  <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                      <i class="nav-icon fas fa-circle"></i>
                      <p>
                        Pengiriman
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="<?php echo BASEURL.'Kelolapo/pengirimansablon' ?>" class="nav-link">
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                          <p>Sablon </p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="<?php echo BASEURL.'Kelolapo/pengirimanbordir' ?>" class="nav-link">
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                          <p>Bordir</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="<?php echo BASEURL.'Kelolapo/pengirimancmt' ?>" class="nav-link">
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                          <p>Jahit </p>
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                      <i class="nav-icon fas fa-circle"></i>
                      <p>
                        Laporan
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="<?php echo BASEURL.'Stockpo/rekap' ?>" class="nav-link">
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                          <p>Grafik Rekap Kirim SETOR</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="<?php echo BASEURL.'reportkaosmingguan' ?>" class="nav-link">
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                          <p>Produksi Kaos Mingguan</p>
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo BASEURL.'Setorancmt' ?>" class="nav-link">
                      <i class="nav-icon fas fa-circle"></i>
                      <p>Setoran CMT</p>
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-circle"></i>
                  <p>
                    Finishing
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?php echo BASEURL.'Finishing/karyawan' ?>" class="nav-link">
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                      <p>Karyawan</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo BASEURL.'Finishing/gajifinishing' ?>" class="nav-link">
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                      <p>Gaji Finishing</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo BASEURL.'finishing/viewboronganmesin' ?>" class="nav-link">
                      <i class="nav-icon fas fa-circle"></i>
                      <p>Borongan Finishing</p>
                      <i class="right fas fa-angle-left"></i>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="<?php echo BASEURL.'Finishing/borongan/1' ?>" class="nav-link">
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                          <p>Lobang Kancing </p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="<?php echo BASEURL.'Finishing/borongan/2' ?>" class="nav-link">
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                          <p>Pasang Kancing </p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="<?php echo BASEURL.'Finishing/borongan/3' ?>" class="nav-link">
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                          <p>Tress </p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="<?php echo BASEURL.'Finishing/buangbenang' ?>" class="nav-link">
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                          <p>buang benang</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="<?php echo BASEURL.'Finishing/cucian' ?>" class="nav-link">
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                          <p>Cucian</p>
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo BASEURL.'Finishing/hppproduksi' ?>" class="nav-link">
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                      <p>HPP Kaos</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo BASEURL.'Finishing/rinciansetorkaoscmt' ?>" class="nav-link">
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                      <p>Rincian Setor Kaos</p>
                    </a>
                  </li>
                  <li class="nav-item has-treeview">
                    <a href="" class="nav-link">
                      <i class="nav-icon fas fa-circle"></i>
                      <p>
                        Pengiriman
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="<?php echo BASEURL.'Finishing/pengirimangudang' ?>" class="nav-link">
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                          <p>Surat Jalan </p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="<?php echo BASEURL.'Notakirim' ?>" class="nav-link">
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                          <p>Cetak Nota Pengiriman </p>
                        </a>
                      </li>
                    </ul>
                  </li>
                </ul>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview "> <!-- menu-open -->
            <a href="#" class="nav-link "> <!--active-->
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Bordir
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo BASEURL.'Bordir/absensikaryawan' ?>" class="nav-link">
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                  <p>Absensi Karyawan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo BASEURL.'Bordir/buangbenang' ?>" class="nav-link">
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                  <p>Buang Benang</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo BASEURL.'Bordir/gajioperator' ?>" class="nav-link">
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                  <p>Gaji Operator</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo BASEURL.'Bordir/gajibuangbenang' ?>" class="nav-link">
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                  <p>Gaji Buang Benang</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo BASEURL.'Keuangan/kasbonkaryawan' ?>" class="nav-link">
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                  <p>Kasbon Karyawan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo BASEURL.'Bordir/targetmesin' ?>" class="nav-link">
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                  <p>Target Mesin</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo BASEURL.'Bordir/pendapatanbordir' ?>" class="nav-link">
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                  <p>Pendapatan Bordir</p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-circle"></i>
                  <p>
                    PO Dalam
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?php echo BASEURL.'Bordir/inputharianmesinpodalam' ?>" class="nav-link">
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                      <p>Input Harian Mesin</p>
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-circle"></i>
                  <p>
                    PO Luar
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?php echo BASEURL.'Bordir/pemilikpoluar' ?>" class="nav-link">
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                      <p>Pemilik PO Luar</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo BASEURL.'Bordir/poluar' ?>" class="nav-link">
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                      <p>Input PO Luar</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo BASEURL.'Bordir/inputharianmesinpoluar' ?>" class="nav-link">
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                      <p>Input Harian Mesin</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo BASEURL.'Bordir/tagihanpoluar' ?>" class="nav-link">
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                      <p>Tagihan PO Luar</p>
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview "> <!-- menu-open -->
            <a href="#" class="nav-link "> <!--active-->
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Sablon
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <!-- <li class="nav-item">
                <a href="<?php echo BASEURL.'Sablon/kirimpo' ?>" class="nav-link">
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                  <p>Kirim PO</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo BASEURL.'Sablon/setorpo' ?>" class="nav-link">
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                  <p>Setor PO</p>
                </a>
              </li> -->
              <li class="nav-item">
                <a href="<?php echo BASEURL.'Sablon/claimpo' ?>" class="nav-link">
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                  <p>Claim PO</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo BASEURL.'Sablon/pengeluaran' ?>" class="nav-link">
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                  <p>Pengeluaran Sablon</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview "> <!-- menu-open -->
            <a href="#" class="nav-link "> <!--active-->
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Report
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo BASEURL.'Stockpo' ?>" class="nav-link">
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                  <p>Stok PO CMT</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo BASEURL.'report/potongan' ?>" class="nav-link">
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                  <p>Laporan Potongan</p>
                </a>
              </li>
              <!--
              <li class="nav-item">
                <a target="_blank" href="<?php echo BASEURL.'report/buangbenang' ?>" class="nav-link">
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                  <p>Report Buang Benang</p>
                </a>
              </li>
              <li class="nav-item">
                <a target="_blank" href="<?php echo BASEURL.'report/bordir' ?>" class="nav-link">
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                  <p>Report Bordir</p>
                </a>
              </li>
              <li class="nav-item">
                <a target="_blank" href="<?php echo BASEURL.'report/laporanproduksikaos' ?>" class="nav-link">
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                  <p>Laporan Prod. Kaos</p>
                </a>
              </li>
              -->
            </ul>
          </li>
          <?php if(callSessUser('nama_user')=='Muchlas' OR callSessUser('nama_user')=='Pawit' OR callSessUser('nama_user')=='administrator'){?>
          <li class="nav-item has-treeview "> <!-- menu-open -->
            <a href="#" class="nav-link "> <!--active-->
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Persetujuan
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo BASEURL.'dash' ?>" class="nav-link">
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                  <p>Pengajuan Harian</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo BASEURL.'Dash/kasbonkaryawan' ?>" class="nav-link">
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                  <p>Kasbon Karyawan</p>
                </a>
              </li>
            </ul>
          </li>
          <?php } ?>
          <li class="nav-item">
            <a href="<?php echo BASEURL.'login/signout' ?>" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
                Logout
              </p>
            </a>
          </li>
          <?php } ?>
          <li class="nav-item">
              <p class="text-center">
                <!--<img src="<?php echo BASEURL?>assets/images/fb.png" class="brand-image img-rounded elevation-3" style="height:100px;background-color:#183a40s">-->
              </p>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <!-- <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Starter Page</li> -->
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
            <!-- Main content -->
            <section class="content">
              <div class="card card-info">
                <div class="card-header">
                  <h3 class="card-title no-print">
                    <?php 
                      if(isset($title)){
                        echo $title;
                      }else{
                        
                      }
                    ?>
                  </h3>
                  <div class="card-tools">
                  </div>
                </div>
                <div class="card-body">
                	
                    <?php if(isset($page)){?>
                    	<?php $this->load->view($page);?>
                  	<?php } ?>  
                  
                </div>                
              </div>
            </section>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer no-print">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      <?php echo date('d F Y')?>&nbsp;<span class="clock"></span>
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2020-<?php echo date('Y')?> <a href="<?php echo BASEURL?>">Forboys Production</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->
<!--<link rel="stylesheet" href="<?php echo BASEURL?>assets/ui/jquery-ui.css">
<script src="<?php echo BASEURL?>assets/ui/jquery-ui.js"></script>-->
<link rel="stylesheet" href="<?php echo BASEURL ?>assets/js/jquery-ui.css">
<script src="<?php echo BASEURL ?>assets/js/jquery-ui.js"></script>
<script src="<?php echo PLUGINS ?>bootstrap-select/js/bootstrap-select.js" type="text/javascript"></script>
<script src="<?php echo BASEURL ?>myjs/autocomplete.js" type="text/javascript"></script>
<script type="text/javascript">
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
</script>

<script type="text/javascript">
  $(function () {
      //$('.select2bs4').select2({
        //  theme: 'bootstrap4'
      //});
      $(".select2bs4").selectpicker('refresh');
  });
</script>
<script type="text/javascript">

  
    function komplitpo(){
     // Single Select
     $("input[name='kode_po']").autocomplete({
      source: function( request, response ) {
       // Fetch data
       $.ajax({
        url: "<?php echo BASEURL.'Json/search_po_autocomplete' ?>",
        type: 'GET',
        dataType: "json",
        data: {
         search: request.term
        },
        success: function( data ) {
         response( data );
        }
       });
      },
      select: function (event, ui) {
         // Set selection
         $("input[name='kode_po']").val(ui.item.label);
      },
      focus: function(event, ui){
         $( "#autocomplete" ).val( ui.item.label );
         $( "#selectuser_id" ).val( ui.item.value );
         return false;
       },
     });
    }

$(document).ready(function(){
      
    $( "table" ).addClass( "table-hover" );
    $( "thead" ).addClass( "thead-light" );
    // $("input").attr("autocomplete","on");

    $(document).on('change', '.kategoriPo', function(){
        var select = $(this).find(':selected').val();
        if (select = 'LUAR') {
            $('.pemilikPO').removeClass('hide');
        } else {
            $('.pemilikPO').addClass('hide');
        }
    });
    $(document).on('change', '.selectpicker', function(){
        var select = $(this).children("option:selected"). val();
        var kodePO = $('.kodePO').val();
        $.get( "<?php echo BASEURL.'konveksi/jenisPoKodeArtikel' ?>", { id: select } )
          .done(function( data ) {
            var obj = JSON.parse(data);
            console.log(obj);
            $(".artikel").val(obj.artikel_jenis_po);
            
        });
    });
});
</script>


<script type="text/javascript">

$(document).ready(function(){

$(document).on('change', '#poSelect', function(){
    $('#item_table').empty();
    var poid = $(this).children("option:selected").val();
    var explode = poid.split("-");
    console.log(explode[1]);
    var i=0;
    $('#item_table').empty();
    var poid = $(this).children("option:selected").val();
    $.post( "<?php echo BASEURL.'Kelolapo/searchPO' ?>",{kodepo: explode[1] }).done(function( json ) {
       console.log(json);
       if(json==''){
        var html='';
        html+='<tr><td colspan="8" style="color:red !important">Bahan keluar belum diinput untuk PO '+explode[1]+'</td></tr>';
        $("#item_table").append(html); 
       }else{
        $("#item_table").append(json); 
       }
       
    });

});

$(document).on('click', '.add', function(){

    var html = '';

    html += '<tr>';

    html += '<td><input type="text" class="form-control" name="bidangBahan[]" required></td>';

    html += '<td><input type="text" class="form-control" name="warna[]" required></td>';

    html += '<td><input type="text" class="form-control" name="kodeBahan[]"  ></td>';

    html += '<td><input type="text" class="form-control" name="beratBahan[]"  ></td>';

    html += '<td><input type="text" class="form-control" name="sisaBahan[]"  ></td>';

    html += '<td><input type="number" class="form-control" name="pemakaianBahankg[]" step=0.01  ></td>';

    html += '<td><input type="text" class="form-control" name="banyakLapis[]"   ></td>';

    html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button></td></tr>';

    $('#item_table').append(html);

 });



$(document).on('click', '.add2', function(){

    var html = '';

    html += '<tr>';

    html += '<td><input type="text" class="form-control" name="bidangBahanVar[]" required></td>';

    html += '<td><input type="text" class="form-control" name="warnaVar[]" required></td>';

    html += '<td><input type="text" class="form-control" name="kodeBahanVar[]"  ></td>';

    html += '<td><input type="text" class="form-control" name="beratBahanVar[]"  ></td>';

    html += '<td><input type="text" class="form-control" name="sisaBahanVar[]"  ></td>';

    html += '<td><input type="number" class="form-control" name="pemakaianBahankgVar[]" step=0.01  ></td>';

    html += '<td><input type="text" class="form-control" name="banyakLapisVar[]"   ></td>';

    html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button></td></tr>';

    $('#item_tabl2e').append(html);

 });



$(document).on('click', '.remove', function(){

    $(this).closest('tr').remove();

});

    

});
 </script>
<script type="text/javascript">
    $(document).ready(function() {
        $("input[name=\'tanggal\']").attr('type', 'text');
        $("input[name=\'tanggal\']").attr('type', 'text');
        $("input[name=\'tanggal\']").addClass("datepicker");
        $("input[name=\'tanggalMulai\']").attr('type', 'text');
        $("input[name=\'tanggalEnd\']").attr('type', 'text');
        $("input[name=\'tanggalMulai\']").addClass("datepicker");
        $("input[name=\'tanggalEnd\']").addClass("datepicker");
        $("input[name=\'tanggal1\']").attr('type', 'text');
        $("input[name=\'tanggal1\']").addClass("datepicker");
        $("input[name=\'tanggal2\']").attr('type', 'text');
        $("input[name=\'tanggal2\']").addClass("datepicker");
        
        $( ".datepicker" ).datepicker({ 
          dateFormat: 'yy-mm-dd',
          maxDate:+1,
          yearRange: '2019:2030',
        });
        // Default Datatable
        $('#datatable').dataTable( {
          "lengthChange": false,
          responsive: true
        });

        $('.nosearch').dataTable( {
          "lengthChange": false,
          "searching":false,
          "ordering": false,
          responsive: true
        });

        $('.yessearch').dataTable( {
          "lengthChange": false,
          "searching":true,
          "ordering": false,
          responsive: true
        });


        $('#tablenotif').DataTable({
          "ordering": true,
          "paging":   false,
          "searching":false,
          responsive: true
        });
      
    } );

</script>
<script type="text/javascript">

$(document).ready(function(){

$(document).on('click', '.addcek', function(){

    var html = '';

    html += '<tr>';

    html += '<td><input type="text" class="form-control" name="bagianAtas[]" required></td>';

    html += '<td><input type="text" class="form-control" name="warnaAtas[]" required></td>';

    html += '<td><input type="number" class="form-control" name="jmlAtas[]"  ></td>';

    html += '<td><input type="text" class="form-control" name="keteranganAts[]"  ></td>';

    html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button></td></tr>';

    $('#item_table').append(html);

    $('.selectpicker').selectpicker('refresh');

 });



$(document).on('click', '.addcek2', function(){

    var html = '';

    html += '<tr>';

    html += '<td><input type="text" class="form-control" name="bagianBwh[]" required></td>';

     html += '<td><input type="text" class="form-control" name="warnaBwh[]" required></td>';

    html += '<td><input type="number" class="form-control" name="jmlBwh[]"  ></td>';

    html += '<td><input type="text" class="form-control" name="keteranganBwh[]"  ></td>';

    html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button></td></tr>';

    $('#item_tabl2e').append(html);

    $('.selectpicker').selectpicker('refresh');

 });



$(document).on('change', '#poSelect', function(){



    var dataid = $(this).children("option:selected").data('id');



    $.post( "<?php echo BASEURL.'kelolapo/seaechDataId' ?>", { idData: dataid } ).done(function( data ) {



        var obj = JSON.parse(data);

        $('.timPotong').val(obj.tim_potong_potongan);

        $('.jmlWarna').val(obj.jumlah_gambar_utama);

        $('.jumlahPotDz').val(obj.hasil_lusinan_potongan);

        $('.jumlahPotPcs').val(obj.hasil_lusinan_potongan * 12);

      });;

    });



$(document).on('click', '.remove', function(){

    $(this).closest('tr').remove();

});

    

});

 </script>

 <script type="text/javascript">
  function simpan(){
    const jeniscmt=$("#cmtKat").val();
    const cmtName=$("#cmtName").val();
    const cmtJob=$("#cmtJob").val();
    const poSelect=$("#poSelect").val();
    
      if(jeniscmt==''){
        alert("Jenis CMT harus dipilih");
        return false;
      }
      if(cmtName==''){
        alert("Nama CMT harus dipilih");
        return false;
      }
      if(cmtJob==''){
        alert("Pekerjaan CMT harus dipilih");
        return false;
      }
      if(poSelect==''){
        alert("PO harus dipilih");
        return false;
      }
    const c=confirm("Apakah yakin akan menyimpan?");
    if(c==true){
      $("form").submit();
    }else{
      return false;
    }
    
  }
  function cancel(){
    const url='<?php echo BASEURL?>';
    window.location.replace(url);
  }
$(document).ready(function(){

$(document).on('click', '.remove', function(){
    $(this).closest('tr').remove();
});


  $(document).on('change', '#cmtKat', function(){

    var jobCmt = $(this).children("option:selected").val();

    $.post( "<?php echo BASEURL.'kelolapo/searchCmt' ?>", { jobCmt: jobCmt } ).done(function( html ) {

        $('#cmtName').html(html);
    
  });;
});

$(document).on('change', '#cmtName', function(){

    var jobCmt = $(this).children("option:selected").val();
    $.post( "<?php echo BASEURL.'kelolapo/searchCmtJob' ?>",{jobCmt: jobCmt }).done(function( html ) {
      console.log(html);
            $('#cmtJob').html(html);
      });
});

$(document).on('change', '#poSelect', function(){
  /*
    $('#item_table').empty();
    var poid = $(this).children("option:selected").val();
    $.post( "<?php echo BASEURL.'Produksi/searchPO' ?>",{POid: poid }).done(function( html ) {
      console.log(html);
            $('#item_table').append(html);
    });

    $.post( "<?php echo BASEURL.'Produksi/searchPObahan' ?>",{POid: poid }).done(function( rincian ) {
      console.log(rincian);
            $('#rincianbahan').html(rincian);
    });
  */
});


});


</script>
<script>
      function clock() {
      let date = new Date();
      let hrs = date.getHours();
      let mins = date.getMinutes();
      let secs = date.getSeconds();
      let period = "WIB";
    
      if (hrs == 0) hrs = 12;
      if (hrs > 12) {
        hrs = hrs - 12;
        period = "WIB";
      }
    
      hrs = hrs < 10 ? `0${hrs}` : hrs;
      mins = mins < 10 ? `0${mins}` : mins;
      secs = secs < 10 ? `0${secs}` : secs;
    
      let time = `${hrs}:${mins}:${secs} ${period}`;
      setInterval(clock, 1000);
      document.querySelector(".clock").innerText = time;

    }

    function number_format_js(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
    
    //clock();

  </script>

<script type="text/javascript">
    
$(document).ready(function(){  
   info =window.location.origin;
   if(info=='http://localhost'){
    var uri=window.location.origin+'/fb2/Json/';
   }else{
    var uri=window.location.origin+'/Json/';
   }
   
   $('.select2').select2();

    $('.autopo').select2({
      theme: 'bootstrap4',
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
      theme: 'bootstrap4',
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
      theme: 'bootstrap4',
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
      theme: 'bootstrap4',
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
      theme: 'bootstrap4',
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
      theme: 'bootstrap4',
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
      theme: 'bootstrap4',
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
      theme: 'bootstrap4',
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
      theme: 'bootstrap4',
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

    $( ".byrcmt" ).change(function() {
      $('#sub1').empty();
      var cmts = $(this).val();
      $.get(uri+'pot_transport?&cmt='+cmts, 
        function(data){   
          console.log(data);
          $('#sub1').append(data);
      });

    });

    $('.autopoid').select2({
      theme: 'bootstrap4',
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



});


  </script>
</body>