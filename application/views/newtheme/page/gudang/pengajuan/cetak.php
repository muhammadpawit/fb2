<style type="text/css">

    .table tr,.table td, .table tr th {

        border: 1px solid black;

    }

    

</style>

<!-- Start Page content -->

<div class="content">

    <div class="container-fluid">



        <div class="row">

            <div class="col-md-12">

                <div class="card-box">

                    <div class="clearfix">

                        <div class="text-center">

                            <h4 class="m-0">FORM AJUAN <?php echo $mingguan ?> FORBOYS<br>BAGIAN : <?php if ($parent['kategori'] == 1) {

                                   echo "SABLON";

                                } else if($parent['kategori'] == 2) { echo "BORDIR"; } else if($parent['kategori'] == 3) {echo "KONVEKSI";} else if($parent['kategori'] == 4) {echo "CABANG SUKABUMI";}?></h4>

                        </div>

                    </div>


                    <?php if($parent['status']==0){?>
                        <div class="alert alert-danger alert-dismissible">
                            <!-- <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> -->
                            <h4><i class="icon fa fa-ban"></i> Warning!</h4>
                                Pengajuan ini belum disetujui
                        </div>
                       <!--  <div class="alert alert-danger">
                            <h1>Pengajuan ini belum disetujui</h1>
                        </div> -->
                    <?php } ?>


                    <div class="row">

                        <div class="col-md-5">

                            <div class="pull-left">

                                <table class="table" width="200" border="2" cellpadding="5">

                                    <tr>

                                        <td><b>Hari</b></td>

                                        <td><b>TANGGAL</b></td>

                                    </tr>

                                    <tr>

                                        <td><b><?php $hari=date('l',strtotime($parent['tanggal'])); echo hari($hari); ?></b></td>

                                        <td><b><?php echo date('d/m/Y',strtotime($parent['tanggal'])) ?></b></td>

                                    </tr>

                                </table>

                            </div>



                        </div><!-- end col -->

                        

                    </div>

                    <!-- end row -->


                    <form method="post" action="<?php echo $action?>">
                    <div class="row">

                        <div class="col-md-12">

                            <div class="table-responsive">

                                <table class="table" >

                                    <thead>

                                        <tr>

                                            <th>NO.</th>

                                            <th>NAMA AJUAN</th>
                                            
                                            <th>WARNA</th>

                                            <th>JUMLAH</th>

                                            <th>SATUAN</th>
                                            <?php if( $parent['kategori']<4){ ?>
                                            <th width="125">HARGA SATUAN (Rp)</th>

                                            <th width="125">JUMLAH PEMBAYARAN (Rp)</th>

                                            <th>TIPE PEMBAYARAN</th>

                                            <th>NAMA SUPPLIER</th>
                                            <?php } ?>
                                            <th>KETERANGAN</th>
                                            <?php if($parent['status']!=1){?>
                                            <th width="200">SPV</th>
                                            <?php }?>
                                        </tr>

                                    </thead>

                                    <tbody>

                                    <?php $i=0; $total = 0;$no=1;$totalCash=0;$totalTF=0; $warna=null; ?>

                                    <?php foreach ($item_cash as $key => $tem): ?>
                                        <?php
                                            if(isset($tem['nama_item'])){
                                                $warna = $this->GlobalModel->QueryManualRow("
                                                SELECT * FROM product where nama LIKE '".$tem['nama_item']."'
                                                "); 
                                            }    
                                        ?>
                                        <input type="hidden" name="products[<?php echo $i?>][id]" value="<?php echo $tem['id']?>">
                                        <tr>

                                            <td align="center"><?php echo $no++; ?></td>

                                            <td><?php echo htmlspecialchars($tem['nama_item']) ?></td>

                                            <td><?php echo !empty($warna) ? htmlspecialchars($warna['warna_item']):'' ?></td>

                                            <td align="center"><?php echo $tem['jumlah'] ?></td>

                                            <td><?php echo htmlspecialchars($tem['satuan']) ?></td>
                                            <?php if( $parent['kategori']<4){ ?>
                                            <td width="125" align="center"><?php echo number_format($tem['harga']) ?></td>

                                            <?php if ($tem['pembayaran'] == 2){ 

                                                $totalTF+=$tem['jumlah'] * $tem['harga'];

                                            } else { 

                                                $totalCash+=$tem['jumlah'] * $tem['harga'];

                                            } ?>

                                            <td width="125"><?php echo number_format($tem['jumlah'] * $tem['harga']) ;?></td>

                                            <td><?php echo ($tem['pembayaran']==1)?'Cash':'Transfer'; ?></td>

                                            <td><?php echo htmlspecialchars($tem['supplier']); ?></td>
                                            <?php } ?>
                                            <td><?php echo htmlspecialchars($tem['keterangan']); ?></td>
                                            <?php if($parent['status']!=1){?>
                                            <td><span class="no-print"><?php echo htmlspecialchars($tem['komentar'])?></span></td>
                                            <?php } ?>
                                        </tr>
                                        <?php $i++?>
                                    <?php endforeach ?>
                                        <?php if( $parent['kategori']<4){ ?>
                                        <tr style="background-color: yellow" class="yaprint">
                                            <td colspan="3">Total Cash (Rp)</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                <?php //echo number_format($parent['cash'] + $parent['transfer']) ;?>
                                                 <?php echo number_format($parent['cash']) ;?>
                                            </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <?php if($parent['status']!=1){?>
                                            <td></td>
                                            <?php } ?>
                                        </tr>
                                        <?php } ?>
                                    </tbody>

                                </table>

                                <table class="table" >

                                    <thead>

                                        <tr>

                                            <th>NO.</th>

                                            <th>NAMA AJUAN</th>

                                            <th>WARNA</th>

                                            <th>JUMLAH</th>

                                            <th>SATUAN</th>
                                            <?php if( $parent['kategori']<4){ ?>
                                            <th width="125">HARGA SATUAN (Rp)</th>

                                            <th width="125">JUMLAH PEMBAYARAN (Rp)</th>

                                            <th>TIPE PEMBAYARAN</th>

                                            <th>NAMA SUPPLIER</th>
                                            <?php } ?>
                                            <th>KETERANGAN</th>
                                            <?php if($parent['status']!=1){?>
                                            <th width="200">REVISI SPV</th>
                                            <?php }?>
                                        </tr>

                                    </thead>

                                    <tbody>

                                    <?php $i=0; $total = 0;$no=1;$totalCash=0;$totalTF=0; ?>

                                    <?php foreach ($item_tf as $key => $tem): ?>
                                        <?php 
                                            if(isset($tem['nama_item'])){
                                                $warna = $this->GlobalModel->QueryManualRow("
                                                SELECT * FROM product where nama LIKE '".$tem['nama_item']."'
                                                "); 
                                            }        
                                        ?>
                                        <input type="hidden" name="products[<?php echo $i?>][id]" value="<?php echo $tem['id']?>">
                                        <tr>

                                            <td align="center"><?php echo $no++; ?></td>

                                            <td><?php echo htmlspecialchars($tem['nama_item']) ?></td>

                                            <td><?php echo !empty($warna) ? htmlspecialchars($warna['warna_item']):'' ?></td>

                                            <td align="center"><?php echo $tem['jumlah'] ?></td>

                                            <td><?php echo htmlspecialchars($tem['satuan']) ?></td>

                                            <?php if( $parent['kategori']<4){ ?>
                                            
                                            <td width="125" align="center"><?php echo number_format($tem['harga']) ?></td>

                                            <?php if ($tem['pembayaran'] == 2){ 

                                                $totalTF+=$tem['jumlah'] * $tem['harga'];

                                            } else { 

                                                $totalCash+=$tem['jumlah'] * $tem['harga'];

                                            } ?>

                                            <td width="125"><?php echo number_format($tem['jumlah'] * $tem['harga']) ;?></td>

                                            <td><?php echo ($tem['pembayaran']==1)?'Cash':'Transfer'; ?></td>

                                            <td><?php echo htmlspecialchars($tem['supplier']); ?></td>
                                            <?php } ?>

                                            <td><?php echo htmlspecialchars($tem['keterangan']); ?></td>
                                            <?php if($parent['status']!=1){?>
                                            <td><span class="no-print"><?php echo htmlspecialchars($tem['komentar'])?></span></td>
                                            <?php } ?>
                                        </tr>
                                        <?php $i++?>
                                    <?php endforeach ?>
                                        <?php if( $parent['kategori']<4){ ?>
                                        <tr style="background-color: yellow" class="yaprint">
                                            <td colspan="3">Total Transfer (Rp)</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                <?php //echo number_format($parent['cash'] + $parent['transfer']) ;?>
                                                 <?php echo number_format($parent['transfer']) ;?>
                                            </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <?php if($parent['status']!=1){?>
                                            <td></td>
                                            <?php } ?>
                                        </tr>
                                        <?php } ?>
                                    </tbody>

                                </table>

                            </div>

                        </div>

                    </div>
                    </form>
                    <div class="row">

                        <div class="col-md-4">

                            <div class="float-left">
                                <?php if( $parent['kategori']<4){ ?>               
                                <table class="table" width="200" class="text-center" border="2">

                                    <tr>

                                        <td>CASH</td>

                                        <td>Rp <?php echo number_format($parent['cash']) ?></td>

                                    </tr>

                                    <tr>

                                        <td>TRANSFER</td>

                                        <td>Rp <?php echo number_format($parent['transfer']) ?></td>

                                    </tr>

                                     <tr>

                                        <td>Total </td>

                                        <td>Rp <?php echo number_format($parent['cash']+$parent['transfer']) ?></td>

                                    </tr>


                                </table>
                                <?php } ?>

                            </div>

                            <div class="clearfix"></div>

                        </div>

                        <div class="col-md-8">

                            <div class="clearfix pt-5">

                                <div class="float-right">

                                    <table class="table" width="400" border="2" class="text-center"  style="text-align: center !important;">

                                        <tr>

                                            <th><center>Di Setujui oleh:</center></th>

                                            <th><center>Di Periksa oleh:</center></th>

                                            <th><center>Di Buat oleh:</center></th>

                                        </tr>

                                        <tr>

                                            <td><b>SPV</b></td>
                                            <td><b>ADM Keuangan</b></td>
                                            <td>
                                                <b>
                                                ADM 
                                                <?php 

                                                    if($parent['kategori']==4){
                                                        echo "Cab.Sukabumi";
                                                    }else{
                                                        echo "Gudang";
                                                    }

                                                ?>
                                                </b>
                                            </td>

                                        </tr>

                                        <tr>

                                            <td>
                                                 <?php if(!empty($parent['paraf'])){ 
                                                     if (strpos($parent['paraf'], 'data:image') === 0) {
                                                         $src = $parent['paraf'];
                                                     } else if (strpos($parent['paraf'], 'image/') === 0) {
                                                         $src = 'data:'.$parent['paraf'];
                                                     } else {
                                                         $src = (strlen($parent['paraf']) > 100) ? 'data:image/png;base64,'.$parent['paraf'] : BASEURL.'uploads/signatures/'.$parent['paraf'];
                                                     }
                                                 ?>
                                                    <img src="<?php echo $src ?>" height="100" width="200">
                                                <?php } ?>
                                            </td>

                                            <td>

                                            <img src="<?php echo BASEURL ?>uploads/signatures/ttdAdminkeu-removebg-previewbaru.png" height="100" width="200">

                                            </td>

                                            <td>

                                            <img src="<?php echo BASEURL ?>uploads/signatures/ttdAdminGd-removebg-preview.png" height="100" width="200">

                                            </td>

                                        </tr>

                                    </table>

                                </div>

                            </div>

                        </div>

                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <table class="table table-bordered">
                                <tr>
                                    <th colspan="4">Diterima :</th>
                                </tr>
                                <tr>
                                    <th>Cash (Rp)</th>
                                    <th>Transfer (Rp)</th>
                                    <th>Total (Rp)</th>
                                    <th>Paraf Bu Haji</th>
                                </tr>
                                <tr>
                                    <td><?php echo $parent['diterima_cash']?></td>
                                    <td><?php echo $parent['diterima_tf']?></td>
                                    <td><?php echo $parent['diterima_cash']+$parent['diterima_tf']?></td>
                                    <td>
                                     <?php if(!empty($parent['ttdBuHj'])){
                                         if (strpos($parent['ttdBuHj'], 'data:image') === 0) {
                                             $src_buhj = $parent['ttdBuHj'];
                                         } else if (strpos($parent['ttdBuHj'], 'image/') === 0) {
                                             $src_buhj = 'data:'.$parent['ttdBuHj'];
                                         } else {
                                             $src_buhj = (strlen($parent['ttdBuHj']) > 100) ? 'data:image/png;base64,'.$parent['ttdBuHj'] : BASEURL.'uploads/signatures/'.$parent['ttdBuHj'];
                                         }
                                     ?>
                                        <img src="<?php echo $src_buhj?>" height="130">
                                    <?php } else { ?>
                                        <div id="signature"></div>
                                    <button id="clear_signature">Clear</button>
                                    <button id="save_signature">Save Signature</button>
                                    <?php } ?>
                                    </td>
                                </tr>
                            </table>

                            <table class="table table-bordered">
                                <tr>
                                    <th colspan="3">Resume :</th>
                                </tr>
                                <tr>
                                    <th>Saldo Cash (Rp)</th>
                                    <th>Keterangan</th>
                                    <th>Paraf SPV</th>
                                </tr>
                                <tr>
                                    <td><?php echo $parent['cash']-$parent['diterima_cash']?></td>
                                    <td>Sisa Ajuan</td>
                                    <td></td>
                                </tr>
                            </table>

                            <!-- <img src="" style="width:100%"> -->
                             
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10">
                            <?php if(!empty($parent['dokumenNota'])){ ?>
                                <iframe src="<?php echo BASEURL?>uploads/nota/<?php echo $parent['dokumenNota']?>" frameborder="0" height="500" style="width:100%"></iframe>
                            <?php }else{ ?>
                                <div class="alert alert-danger"> Dokumen nota belum diupload</div>
                            <?php } ?>
                        </div>
                    </div>


                    <div class="hidden-print mt-4 mb-4 no-print">

                        <div class="text-right">
                            <?php if($parent['status']==1){?>
                            <a href="javascript:window.print()" class="btn btn-primary waves-effect waves-light"><i class="fa fa-print m-r-5"></i> Print</a>
                            <a onclick="showPengajuanPdfModal()" class="btn btn-success waves-effect waves-light text-white"><i class="fa fa-file-pdf-o m-r-5"></i> PDF</a>
                            <?php }?>

                            <?php if($parent['kategori']==4){ ?>
                                <a href="<?php echo BASEURL.'Gudang/pengajuan?&list_skb&cat=4';?>" class="btn btn-danger waves-effect waves-light">Kembali</a>
                            <?php }else{ ?>
                                    <a href="<?php echo BASEURL.'Gudang/pengajuan';?>" class="btn btn-danger waves-effect waves-light">Kembali</a>
                            <?php } ?>
                        </div>

                    </div>

                </div>



            </div>



        </div>

        <!-- end row -->



    </div> <!-- container -->



</div> <!-- content -->

<!-- Modal PDF Preview -->
<div class="modal fade" id="pdfPreviewModal" tabindex="-1" role="dialog" aria-labelledby="pdfPreviewModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="width: 98%; max-width: 98%; height: 95vh; margin: 1vh auto;">
        <div class="modal-content" style="height: 95vh;">
            <div class="modal-header">
                <h5 class="modal-title" id="pdfPreviewModalLabel"><i class="fa fa-file-pdf-o"></i> Preview PDF - Pengajuan <?php echo $mingguan ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding: 0; height: calc(95vh - 120px);">
                <div id="pdfLoading" style="display:flex; justify-content:center; align-items:center; height:100%;">
                    <div style="text-align:center;">
                        <i class="fa fa-spinner fa-spin fa-3x"></i>
                        <p style="margin-top:10px;">Memuat PDF...</p>
                    </div>
                </div>
                <iframe id="pdfIframe" style="width: 100%; height: 100%; border: none; display:none;"></iframe>
            </div>
            <div class="modal-footer">
                <a id="pdfDownloadLink" href="#" target="_blank" class="btn btn-success"><i class="fa fa-download"></i> Download PDF</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<style>
    
  canvas {
    margin: 10vh 5px !important;
    height: 250px !important;
  }

  #signature {
        width: 100%;
        height: 300px;
        border: 1px solid #000;
        background-color: #fff;
    }

</style>
<script src="<?php echo BASEURL?>jSignature/src/jSignature.js"></script>
<script type="text/javascript">

$(document).ready(function() {
    $("#signature-pad").jSignature();
});

$('#clear_signature').click(function() {
           $("#signature-pad").jSignature("reset");
       });


        $('#save_signature').click(function() {
           var $sigdiv = $("#signature-pad");
           var data = $sigdiv.jSignature("getData", "image");
           var imgData = Array.isArray(data) ? data.join(",") : data;
           var idajuan = '<?php echo $parent['id']?>';

           if (!imgData || imgData.length < 100) {
               Swal({
                   type: 'warning',
                   title: 'Tanda tangan kosong',
                   text: 'Silakan tanda tangan terlebih dahulu pada panel yang disediakan.'
               });
               return false;
           }

           var formData = new FormData();
           formData.append('image_data', imgData);
           formData.append('id', idajuan);

           $.ajax({
               url: "<?= BASEURL ?>Gudang/ttdsaveBuhj",
               type: "POST",
               data: formData,
               processData: false,
               contentType: false,
               success: function(response) {
                   if (response.indexOf('successfully') !== -1) {
                       Swal({
                           type: 'success',
                           title: 'Berhasil',
                           text: response,
                           showConfirmButton: false,
                           timer: 1500
                       }).then(function() {
                           location.reload();
                       });
                   } else {
                       Swal({
                           type: 'error',
                           title: 'Gagal',
                           text: response
                       });
                   }
               },
               error: function(xhr) {
                   Swal({
                       type: 'error',
                       title: 'Error',
                       text: 'Terjadi kesalahan: ' + xhr.statusText
                   });
               }
           });
        });


    function showPengajuanPdfModal(){
        var pdfUrl = '<?php echo BASEURL; ?>Gudang/pengajuancetak/<?php echo $parent['id']; ?>?pdf=true';
        console.log(pdfUrl);
        $('#pdfLoading').show();
        $('#pdfIframe').hide();
        $('#pdfIframe').attr('src', pdfUrl);
        $('#pdfDownloadLink').attr('href', pdfUrl);
        $('#pdfPreviewModal').modal('show');
        $('#pdfIframe').on('load', function(){
            $('#pdfLoading').hide();
            $('#pdfIframe').show();
        });
    }

    // Hapus iframe src saat modal ditutup agar tidak memakan resource
    $('#pdfPreviewModal').on('hidden.bs.modal', function () {
        $('#pdfIframe').attr('src', '');
    });

    jQuery(document).bind("keyup keydown", function(e){
        if(e.ctrlKey && e.keyCode == 80){
            alert('Mohon gunakan tombol print');
            return false;
        }
    });
</script>