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

                            <h4 class="m-0">FORM AJUAN HARIAN FORBOYS<br>BAGIAN : <?php if ($parent['kategori'] == 1) {

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

                                            <th width="125">HARGA SATUAN (Rp)</th>

                                            <th width="125">JUMLAH PEMBAYARAN (Rp)</th>

                                            <th>TIPE PEMBAYARAN</th>

                                            <th>NAMA SUPPLIER</th>

                                            <th>KETERANGAN</th>
                                            <?php if($parent['status']!=1){?>
                                            <th width="200">SPV</th>
                                            <?php }?>
                                        </tr>

                                    </thead>

                                    <tbody>

                                    <?php $i=0; $total = 0;$no=1;$totalCash=0;$totalTF=0; ?>

                                    <?php foreach ($item_cash as $key => $tem): ?>
                                        <?php $warna = $this->GlobalModel->QueryManualRow("
                                        SELECT * FROM product where nama LIKE '".!empty($item['nama_item']) ? $item['nama_item'] : null."'
                                        "); ?>
                                        <input type="hidden" name="products[<?php echo $i?>][id]" value="<?php echo $tem['id']?>">
                                        <tr>

                                            <td align="center"><?php echo $no++; ?></td>

                                            <td><?php echo $tem['nama_item'] ?></td>

                                            <td><?php echo !empty($warna) ? $warna['warna_item']:'' ?></td>

                                            <td align="center"><?php echo $tem['jumlah'] ?></td>

                                            <td><?php echo $tem['satuan'] ?></td>

                                            <td width="125" align="center"><?php echo number_format($tem['harga']) ?></td>

                                            <?php if ($tem['pembayaran'] == 2){ 

                                                $totalTF+=$tem['jumlah'] * $tem['harga'];

                                            } else { 

                                                $totalCash+=$tem['jumlah'] * $tem['harga'];

                                            } ?>

                                            <td width="125"><?php echo number_format($tem['jumlah'] * $tem['harga']) ;?></td>

                                            <td><?php echo ($tem['pembayaran']==1)?'Cash':'Transfer'; ?></td>

                                            <td><?php echo $tem['supplier']; ?></td>

                                            <td><?php echo $tem['keterangan']; ?></td>
                                            <?php if($parent['status']!=1){?>
                                            <td><span class="no-print"><?php echo $tem['komentar']?></span></td>
                                            <?php } ?>
                                        </tr>
                                        <?php $i++?>
                                    <?php endforeach ?>
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

                                            <th width="125">HARGA SATUAN (Rp)</th>

                                            <th width="125">JUMLAH PEMBAYARAN (Rp)</th>

                                            <th>TIPE PEMBAYARAN</th>

                                            <th>NAMA SUPPLIER</th>

                                            <th>KETERANGAN</th>
                                            <?php if($parent['status']!=1){?>
                                            <th width="200">REVISI SPV</th>
                                            <?php }?>
                                        </tr>

                                    </thead>

                                    <tbody>

                                    <?php $i=0; $total = 0;$no=1;$totalCash=0;$totalTF=0; ?>

                                    <?php foreach ($item_tf as $key => $tem): ?>
                                        <?php $warna = $this->GlobalModel->QueryManualRow("
                                        SELECT * FROM product where nama LIKE '".!empty($item['nama_item']) ? $item['nama_item'] : null."'
                                        "); ?>
                                        <input type="hidden" name="products[<?php echo $i?>][id]" value="<?php echo $tem['id']?>">
                                        <tr>

                                            <td align="center"><?php echo $no++; ?></td>

                                            <td><?php echo $tem['nama_item'] ?></td>

                                            <td><?php echo !empty($warna) ? $warna['warna_item']:'' ?></td>

                                            <td align="center"><?php echo $tem['jumlah'] ?></td>

                                            <td><?php echo $tem['satuan'] ?></td>

                                            <td width="125" align="center"><?php echo number_format($tem['harga']) ?></td>

                                            <?php if ($tem['pembayaran'] == 2){ 

                                                $totalTF+=$tem['jumlah'] * $tem['harga'];

                                            } else { 

                                                $totalCash+=$tem['jumlah'] * $tem['harga'];

                                            } ?>

                                            <td width="125"><?php echo number_format($tem['jumlah'] * $tem['harga']) ;?></td>

                                            <td><?php echo ($tem['pembayaran']==1)?'Cash':'Transfer'; ?></td>

                                            <td><?php echo $tem['supplier']; ?></td>

                                            <td><?php echo $tem['keterangan']; ?></td>
                                            <?php if($parent['status']!=1){?>
                                            <td><span class="no-print"><?php echo $tem['komentar']?></span></td>
                                            <?php } ?>
                                        </tr>
                                        <?php $i++?>
                                    <?php endforeach ?>
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
                                    </tbody>

                                </table>

                            </div>

                        </div>

                    </div>
                    </form>
                    <div class="row">

                        <div class="col-md-4">

                            <div class="float-left">

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

                                                <br>

                                                <br>

                                                <br>

                                                <br>

                                                <br>

                                                ( Muchlas)

                                            </td>

                                            <td>

                                                <br>

                                                <br>

                                                <br>

                                                <br>

                                                <br>

                                                ( Dinda )

                                            </td>

                                            <td>

                                                <br>

                                                <br>

                                                <br>

                                                <br>

                                                <br>

                                                <?php 

                                                    if($parent['kategori']==4){
                                                        echo "(Asmiya)";
                                                    }else{
                                                        echo "(Ifah)";
                                                    }

                                                ?>

                                            </td>

                                        </tr>

                                    </table>

                                </div>

                            </div>

                        </div>

                    </div>



                    <div class="hidden-print mt-4 mb-4 no-print">

                        <div class="text-right">
                            <?php if($parent['status']==1){?>
                            <a href="javascript:window.print()" class="btn btn-primary waves-effect waves-light"><i class="fa fa-print m-r-5"></i> Print</a>
                            <a onclick="excel()" class="btn btn-success waves-effect waves-light text-white"><i class="fa fa-file-excel m-r-5"></i> Excel</a>
                            <?php }?>
                            <a href="<?php echo BASEURL.'Gudang/pengajuan';?>" class="btn btn-danger waves-effect waves-light">Kembali</a>

                        </div>

                    </div>

                </div>



            </div>



        </div>

        <!-- end row -->



    </div> <!-- container -->



</div> <!-- content -->
<script type="text/javascript">
    function excel(){
        location ='?excel=true';
    }

    jQuery(document).bind("keyup keydown", function(e){
        if(e.ctrlKey && e.keyCode == 80){
            alert('Mohon gunakan tombol print');
            return false;
        }
    });
</script>