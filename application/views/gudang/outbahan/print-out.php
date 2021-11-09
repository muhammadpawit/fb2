<?php //pre($post); ?>
<!-- Start Page content -->
 <div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div class="card-box">
                    <div class="clearfix">
                        <div class="pull-left mb-3">
                            <img src="assets/images/logo.png" alt="" height="28">
                        </div>
                        <div class="pull-right">
                            <h4 class="m-0 d-print-none">SURAT JALAN</h4>
                        </div>
                    </div>


                   

                    <div class="row mt-3">
                        <div class="col-6">
                            <h6>Billing Address</h6>

                            <address class="line-h-24">
                               JL.Z NO 1, Kel. Sukabumi Selatan, Kec Kebon Jeruk Kampung Baru, Jakarta Barat
                            </address>
                            <h3><strong>Faktur No. </strong><?php echo $post['noFaktur'] ?></h3>
                        </div>

                       
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table mt-4">
                                    <thead>
                                    <tr><th>#</th>
                                        <th>Nama Barang</th>
                                        <th>Jumlah / Satuan</th>
                                        <th>Harga Pcs</th>
                                        <th>Bahan U/</th>
                                        <th class="text-right">Total</th>
                                    </tr></thead>
                                    <tbody>
                                    	<?php $total = 0; ?>
                            	<?php $no=1; foreach ($post['nama'] as $key => $item): ?>
                            		<tr>
                                        <td><?php echo $no++; ?></td>
                                        <td>
                                            <b><?php echo $item ?></b> 
                                        </td>
                                        <td><?php echo $post['jumlah'][$key] ?> <?php echo $post['satuanJml'][$key] ?></td>
                                        <td><?php echo number_format($post['harga'][$key]) ?></td>
                                        <td> <b><?php echo $post['bahanUntuk'][$key] ?></b> </td>
                                        <?php 
                                        $total += $post['jumlah'][$key] * $post['harga'][$key];
                                         ?>
                                        <td class="text-right"><?php echo number_format($post['jumlah'][$key] * $post['harga'][$key]) ?></td>
                                    </tr>
                            	<?php endforeach ?>
                                    
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="clearfix pt-5">
                                <h6 class="text-muted">Notes:</h6>

                                <small>
                                    All accounts are to be paid within 7 days from receipt of
                                    invoice. To be paid by cheque or credit card or direct payment
                                    online. If account is not paid within 7 days the credits details
                                    supplied as confirmation of work undertaken will be charged the
                                    agreed quoted fee noted above.
                                </small>
                            </div>

                        </div>
                        <div class="col-6">
                            <div class="float-right">
                                <p><b>Jumlah:</b> Rp. <?php echo number_format($total) ?></p>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>

                    <div class="hidden-print mt-4 mb-4">
                        <div class="text-right  row ">
                            <div class="col-6">
                                <a href="javascript:window.print()" class="btn btn-primary waves-effect waves-light"><i class="fa fa-print m-r-5"></i> Print</a>
                           
                            </div>
                                <div class="col-6 text-left">

             <form action="<?php echo BASEURL.'gudang/outbahanOnCreate' ?>" method="post">
                    <input type="hidden" name="proggress" value="<?php echo $post['proggress'] ?>">
                    <input type="hidden" value="<?php echo $post['noFaktur'] ?>" name="noFaktur">
                    <input type="hidden" value="<?php echo $post['tujuanItem'] ?>" name="tujuanItem">
                    <input type="hidden" value="<?php echo $post['namaPo'] ?>" name="namaPo">
                <?php  foreach ($post['nama'] as $key => $item): ?>
                    <input type="hidden" value="<?php echo $post['id'][$key] ?>" name="id[]">
                    <input type="hidden" value="<?php echo $item ?>" name="nama[]">
                    <input type="hidden" value="<?php echo $post['warna'][$key] ?>" name="warna[]">
                    <input type="hidden" value="<?php echo $post['ukuran'][$key] ?>" name="ukuran[]">
                    <input type="hidden" value="<?php echo $post['satuanUkran'][$key] ?>" name="satuanUkran[]">   
                    <input type="hidden" value="<?php echo $post['jumlah'][$key] ?>" name="jumlah[]"> 
                    <input type="hidden" value="<?php echo $post['satuanJml'][$key] ?>" name="satuanJml[]">
                    <input type="hidden" value="<?php echo $post['harga'][$key] ?>" name="harga[]">
                    <input type="hidden" value="<?php echo $post['bahanUntuk'][$key] ?>" name="bahanUntuk[]">
                <?php endforeach ?>
                <button type="submit" class="btn btn-info waves-effect waves-light">Simpan</button>
            </form>
                            </div>
                            
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <!-- end row -->

    </div> <!-- container -->

</div> <!-- content -->
