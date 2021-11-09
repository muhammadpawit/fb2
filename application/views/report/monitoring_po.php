<!-- DataTables -->
<link href="<?php echo PLUGINS ?>datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo PLUGINS ?>datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<!-- Responsive datatable examples -->
<link href="<?php echo PLUGINS ?>datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />    
<style type="text/css">
  .table tr,.table th,.table tr td,.table tr th{
      border: 1px solid black;
  }
</style>
<!-- Start Page content -->
<div class="content">
    <div class="container-fluid">

        <div class="row hidden-print" >
            <div class="col-12">
                <div class="card-box table-responsive">
                    <h4 class="m-t-0 header-title">Item Masuk</h4>
                   <p class="text-muted font-14 m-b-30">
                    <?php if ($this->session->flashdata('msg')) { ?>
                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                           <?php echo $this->session->flashdata('msg'); ?> 
                    </div>
                       <?php } ?>
                    </p>
                    <form action="<?php echo BASEURL.'report/laporanalokasicmt' ?>" method="GET" class="mb-3">
                        <div class="row mb-4">
                        	<div class="col-4">
                        		<div class="form-group">
	                                <label>Jenis PO</label>
	                                <select class="form-control" name="cmtKat">
                                      <option></option>
                                      <option value="JAHIT">JAHIT</option>
                                      <option value="BORDIR">BORDIR</option>
	                                    <option value="SABLON">SABLON</option>
	                                </select>
	                            </div>
	                            
                        	</div>
                          	<div class="col-6">
                          		<div class="form-group">
	                            	<label>Tanggal Mulai</label>
	                            	<input type="date" class="form-control" name="tanggalMulai">
	                            </div>
	                            <div class="form-group">
	                            	<label>Tanggal Akhir</label>
	                            	<input type="date" class="form-control" name="tanggalAkhir">
	                            </div>
                          	</div>
                        </div>
                            <button style="float: right;" class="btn  btn-info mt-4">SUBMIT</button>
                    </form>

                </div>
            </div>
        </div> <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card-box table-responsive">
                  <h2 class="text-center">LAPORAN KAOS</h2>
              <h4 class="text-center"><?php echo (isset($tanggal['tanggalMulai'])?date('d F Y ',strtotime($tanggal['tanggalMulai'])):'') ?> - <?php echo (isset($tanggal['tanggalAkhir'])?date('d F Y ',strtotime($tanggal['tanggalAkhir'])):'') ?></h4>
                    <?php $no = 1; ?>

                    <div class="row" style="page-break-after: always;">
                      <div class="col-12">
                    <h4 class="text-center">KIRIM CMT <?php echo (isset($tanggal['cmtKat'])?$tanggal['cmtKat']:'') ?></h4>
                      <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th align="center" style="text-align: center !important;" colspan="<?php echo $cpo?>">Jenis PO</th>  
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>CMT</td>
                            <?php foreach($jenisPo as $p){?>
                            <td><?php echo $p['nama_jenis_po']?></td>
                            <?php } ?>
                          </tr>
                          <?php foreach($cmt as $c){?>
                            <tr>
                              <td><?php echo $c['cmt_name']?></td>
                              <?php foreach($jenisPo as $p){?>
                              <?php 
                                  //$po=$this->GlobalModel->queryManualRow("SELECT count(*) as jml,sum(kca.qty) as qty  FROM kirimcmt kc JOIN kirimcmt_detailatas kca ON(kca.idkirim=kc.id) LEFT JOIN kelolapo_pengecekan_potongan_atas kppa ON(kppa.id_kelolapo_pengecekan_potongan=kca.idpengecekan) JOIN produksi_po po ON(po.kode_po=kppa.kode_po) WHERE po.nama_po='".$p['nama_jenis_po']."' AND kc.idcmt='".$c['idcmt']."' ");
                                  
                              ?>
                              <td>

                              <?php
                              $jml=array();
                              $kpp=$this->GlobalModel->queryManualRow("SELECT count(*) as jml FROM produksi_po join kirimcmt_po ON(kirimcmt_po.kode_po=produksi_po.kode_po)  LEFT JOIN kirimcmt ON (kirimcmt.id=kirimcmt_po.idkirim) WHERE nama_po='".$p['nama_jenis_po']."' AND kirimcmt.idcmt='".$c['idcmt']."' AND kirimcmt.status=0 ");
                                echo ($kpp['jml']>0)?$kpp['jml']:'';
                                  /*
                                  foreach($c['kpo'] as $kp){
                                    $kpo[]=$this->GlobalModel->queryManual("SELECT * FROM produksi_po WHERE kode_po='".$kp['kode_po']."' and nama_po='".$p['nama_jenis_po']."' ");
                                  }*/

                                  
                                  /*
                                  foreach($kode_p as $key=>$value){
                                    $sql="SELECT * FROM produksi_po WHERE nama_po='".$p['nama_jenis_po']."' AND kode_po='".$value."' ";
                                      $d=$this->GlobalModel->queryManualRow("SELECT * FROM produksi_po WHERE nama_po='".$p['nama_jenis_po']."' AND kode_po='".$value."' ");
                                    if($d['nama_po']==$p['nama_jenis_po']){
                                      $z=$this->GlobalModel->queryManualRow("SELECT COUNT(*) FROM produksi_po WHERE nama_po='".$d['nama_po']."' ");
                                      print_r($z);
                                    }
                                  }
                                  */
                              ?>
                              </td>
                              <?php } ?>
                            </tr>
                          <?php } ?>
                          <tr>
                            <td>Total PCS</td>
                            <?php foreach($jenisPo as $p){?>
                              <?php 
                                  $po=$this->GlobalModel->queryManualRow("SELECT count(*) as jml,sum(kca.qty) as qty  FROM kirimcmt kc JOIN kirimcmt_detailatas kca ON(kca.idkirim=kc.id) LEFT JOIN kelolapo_pengecekan_potongan_atas kppa ON(kppa.id_kelolapo_pengecekan_potongan=kca.idpengecekan) JOIN produksi_po po ON(po.kode_po=kppa.kode_po) WHERE po.nama_po='".$p['nama_jenis_po']."' AND kc.status=0");
                              ?>
                              <td><?php echo ($po['qty']>0)?$po['qty']:''?></td>
                              <?php } ?>
                          </tr>
                          <tr>
                            <td>Total Keseluruhan (pcs)</td>
                              <?php 
                                  $po=$this->GlobalModel->queryManualRow("SELECT count(*) as jml,sum(kca.qty) as qty  FROM kirimcmt kc JOIN kirimcmt_detailatas kca ON(kca.idkirim=kc.id) LEFT JOIN kelolapo_pengecekan_potongan_atas kppa ON(kppa.id_kelolapo_pengecekan_potongan=kca.idpengecekan) JOIN produksi_po po ON(po.kode_po=kppa.kode_po) WHERE kc.status=0 ");
                              ?>
                              <td align="center" colspan="<?php echo $cpo?>"><?php echo ($po['qty']>0)?$po['qty']:''?></td>
                          </tr>
                        </tbody>
                      </table>
                      </div>
                    </div>

                    <div class="hidden-print mt-4 mb-4">
                        <div class="text-right">
                            <a href="javascript:window.print()" class="btn btn-primary waves-effect waves-light"><i class="fa fa-print m-r-5"></i> Print</a>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end row -->

    </div>
</div>
        <!-- Required datatable js -->
<script src="<?php echo PLUGINS ?>datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo PLUGINS ?>datatables/dataTables.bootstrap4.min.js"></script>

<!-- Buttons examples -->
<script src="<?php echo PLUGINS ?>datatables/dataTables.buttons.min.js"></script>
<script src="<?php echo PLUGINS ?>datatables/buttons.bootstrap4.min.js"></script>
<script src="<?php echo PLUGINS ?>datatables/jszip.min.js"></script>
<script src="<?php echo PLUGINS ?>datatables/pdfmake.min.js"></script>
<script src="<?php echo PLUGINS ?>datatables/vfs_fonts.js"></script>
<script src="<?php echo PLUGINS ?>datatables/buttons.html5.min.js"></script>
<script src="<?php echo PLUGINS ?>datatables/buttons.print.min.js"></script>

<!-- Responsive examples -->
<script src="<?php echo PLUGINS ?>datatables/dataTables.responsive.min.js"></script>
<script src="<?php echo PLUGINS ?>datatables/responsive.bootstrap4.min.js"></script>
<script type="text/javascript">
        $(document).ready(function() {

            //Buttons examples
            var table = $('#datatable-buttons').DataTable({
                lengthChange: false,
                buttons: ['copy', 'excel', 'pdf']
            });
            table.buttons().container()
                    .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
        } );

    </script>
