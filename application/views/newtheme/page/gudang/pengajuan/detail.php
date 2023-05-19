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

                            <h4 class="m-0" style="text-decoration: underline;">FORM AJUAN HARIAN FORBOYS<br>BAGIAN : <?php if ($parent['kategori'] == 1) {

                                   echo "SABLON";

                                } else if($parent['kategori'] == 2) { echo "BORDIR"; } else if($parent['kategori'] == 3) {echo "KONVEKSI";}?></h4>

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

                        <div class="col-md-4">

                            <div class="pull-left">

                                <table class="table nosearch" border="2" cellpadding="5">

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
                        <div class="form-group">
                        <input type="hidden" name="idpengajuan" value="<?php echo $parent['id']?>">
                        <input type="hidden" name="kategori" value="<?php echo $parent['kategori']?>">
                        </div>
                    <div class="row">

                        <div class="col-md-12">

                            <div class="table-responsive">

                                <table class="table nosearch" >

                                    <thead>

                                        <tr>

                                            <th>NO.</th>

                                            <th>NAMA AJUAN</th>

                                            <th>JUMLAH</th>

                                            <th>SATUAN</th>

                                            <th width="125">HARGA SATUAN (Rp)</th>

                                            <th width="125">JUMLAH PEMBAYARAN (Rp)</th>
                                            <th>TIPE PEMBAYARAN</th>

                                            <th>NAMA SUPPLIER</th>

                                            <th>KETERANGAN</th>

                                            <th width="200">SPV</th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                    <?php $i=0; $total = 0;$no=1;$totalCash=0;$totalTF=0; ?>

                                    <?php foreach ($item as $key => $tem): ?>
                                        <input type="hidden" name="products[<?php echo $i?>][id]" value="<?php echo $tem['id']?>">
                                        <tr>

                                            <td><?php echo $no++; ?></td>

                                            <td><?php echo $tem['nama_item'] ?></td>

                                            <td><?php echo $tem['jumlah'] ?></td>

                                            <td><?php echo $tem['satuan'] ?></td>

                                            <td width="125">Rp. <?php echo number_format($tem['harga']) ?></td>

                                            <?php if ($tem['pembayaran'] == 2){ 

                                                $totalTF+=$tem['jumlah'] * $tem['harga'];

                                            } else { 

                                                $totalCash+=$tem['jumlah'] * $tem['harga'];

                                            } ?>

                                            <td width="125">Rp. <?php echo number_format($tem['jumlah'] * $tem['harga']) ;?></td>
                                            <td><?php echo ($tem['pembayaran']==1)?'Cash':($tem['pembayaran']==2?'Transfer':'-'); ?></td>
                                            <td><?php echo $tem['supplier']; ?></td>

                                            <td><?php echo $tem['keterangan']; ?></td>
                                            <td><textarea name="products[<?php echo $i?>][komentar]" class="form-control"><?php echo $tem['komentar']?></textarea></td>
                                        </tr>
                                        <?php $i++?>
                                    <?php endforeach ?>
                                        <tr style="background-color: yellow" class="yaprint">
                                            <td colspan="2">Total</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                Rp. <?php echo number_format($parent['cash'] + $parent['transfer']) ;?>
                                            </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><button type="submit" class="btn btn-info btn-sm">Simpan</button></td>
                                        </tr>
                                    </tbody>

                                </table>

                            </div>

                        </div>

                    </div>
                    </form>
                    <div class="row">

                        <div class="col-6">

                            <div class="float-left">

                                <table width="200" class="text-center" border="2">

                                    <tr>

                                        <td>CASH</td>

                                        <td>Rp <?php echo number_format($parent['cash']) ?></td>

                                    </tr>

                                    <tr>

                                        <td>TRANSFER</td>

                                        <td>Rp <?php echo number_format($parent['transfer']) ?></td>

                                    </tr>

                                </table>

                            </div>

                            <div class="clearfix"></div>

                        </div>
                            
                        <div class="col-6">

                            <div class="clearfix pt-5">

                                <div class="float-right">

                                    <table width="400" border="2" class="text-center">

                                        <tr>

                                            <th>Menyetujui</th>

                                            <th>Di Buat oleh:</th>

                                        </tr>

                                        <tr>

                                            <td><b>SPV</b></td>

                                            <td><b>ADM Gudang</b></td>

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

                                                ( <?php echo strtoupper($adminkeu)?> )

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
                            <?php }else{?>
                                <!-- <a href="<?php echo BASEURL.'Dash';?>" class="btn btn-info waves-effect waves-light">Setujui</a> -->
                            <?php } ?>
                            <a href="<?php echo BASEURL.'Gudang/pengajuan';?>" class="btn btn-danger waves-effect waves-light">Kembali</a>

                        </div>

                    </div>

                </div>



            </div>



        </div>

        <!-- end row -->



    </div> <!-- container -->



</div> <!-- content -->