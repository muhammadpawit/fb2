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

                            <h4 class="m-0">FORM PENGAJUAN HARIAN <?php if ($parent['kategori'] == 1) {

                                   echo "SABLON";

                                } else if($parent['kategori'] == 2) { echo "BORDIR"; } else if($parent['kategori'] == 3) {echo "KONVEKSI";}?> FORBOYS</h4>

                        </div>

                    </div>


                    <?php if($parent['status']==0){?>
                        <div style="z-index: 999;position: absolute;top:2%;right: 1%" class="alert alert-danger">
                            <h1>Pengajuan ini belum disetujui</h1>
                        </div>
                    <?php } ?>

                    <form method="post" action="<?php echo $edit?>">
                        <input type="hidden" name="id" value="<?php echo $parent['id']?>">
                    <div class="row">

                        <div class="col-6">

                            <div class="pull-left mt-3">

                                <table width="200" border="2" cellpadding="5">

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



                    <div class="row">

                        <div class="col-md-12">

                            <div class="table-responsive">

                                <table class="table mt-4" >

                                    <thead>

                                        <tr>

                                            <th>NO.</th>

                                            <th>DAFTAR ITEM AJUAN OPS</th>

                                            <th width="100">JUMLAH <br>BARANG</th>

                                            <th>SATUAN</th>

                                            <th width="135">HARGA SATUAN</th>

                                            <th width="125">TOTAL</th>

                                            <th>PEMBAYARAN</th>

                                            <th>SUPPLIER</th>

                                            <th>KET.</th>

                                            <th>KOMENTAR</th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                    <?php $i=0;$total = 0;$no=1;$totalCash=0;$totalTF=0; ?>

                                    <?php foreach ($item as $key => $tem): ?>

                                        <tr>

                                            <td><?php echo $no++; ?></td>

                                            <td><?php echo $tem['nama_item'] ?></td>
                                            <input type="hidden" name="products[<?php echo $i?>][id]" value="<?php echo $tem['id'] ?>" class="form-control">
                                            <td><input type="text" name="products[<?php echo $i?>][jumlah]" value="<?php echo $tem['jumlah'] ?>" class="form-control"></td>

                                            <td><?php echo $tem['satuan'] ?></td>

                                            <td width="135"><input type="text" name="products[<?php echo $i?>][harga]" class="form-control" value="<?php echo $tem['harga'] ?>"></td>

                                            <?php if ($tem['pembayaran'] == 2){ 

                                                $totalTF+=$tem['jumlah'] * $tem['harga'];

                                            } else { 

                                                $totalCash+=$tem['jumlah'] * $tem['harga'];

                                            } ?>

                                            <td width="125"><?php echo number_format($tem['jumlah'] * $tem['harga']) ;?></td>

                                            <td>
                                                <select name="products[<?php echo $i?>][pembayaran]" class="form-control pembayaran" required>
                                                    <option value="">Pilih</option>
                                                    <option value="1" <?php echo $tem['pembayaran']==1?'selected':'';?>>Cash</option>
                                                    <option value="2" <?php echo $tem['pembayaran']==2?'selected':'';?>>Transfer</option>
                                                </select>
                                            </td>

                                            <td><?php echo $tem['supplier']; ?></td>

                                            <td><?php echo $tem['keterangan']; ?></td>
                                            <td><?php echo $tem['komentar']; ?></td>

                                        </tr>
                                        <?php $i++?>
                                    <?php endforeach ?>
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

                                        <td>Rp <?php echo number_format($totalCash) ?></td>

                                    </tr>

                                    <tr>

                                        <td>TRANSFER</td>

                                        <td>Rp <?php echo number_format($totalTF) ?></td>

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

                                            <td><b>ADM KEU</b></td>

                                        </tr>

                                        <tr>

                                            <td>

                                                <br>

                                                <br>

                                                <br>

                                                <br>

                                                <br>

                                                ( Muchlas Muchtar)

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
                            <?php if($parent['status']==0){?>
                            <button onclick="save()" class="btn btn-info waves-effect waves-light"><i class="fa fa-print m-r-5"></i> Simpan</button>
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
    function save(){
        var pembayaran=$(".pembayaran").val();
        if(pembayaran==''){
            alert("Pembayaran harus diisi");
            return false
        }

        $("form").submit();
    }
</script>