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
                        <div class="text-center">
                            <h4 class="m-0 d-print-none">AJUAN ALAT ALAT PO</h4>
                        </div>
                    </div>


                    <div class="row">
                        
                        <div class="col-10 offset-2">
                            <div class="mt-3 pull-right">
                            	<table>
                            		
                            	</table>
                            </div>
                        </div><!-- end col -->
                    </div>
                    <!-- end row -->


                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table mt-4" border="2">
                                    <thead>
                                    	<tr>
                                    		<th class="text-center" colspan="11">AJUAN ALAT ALAT PO</th>
                                    	</tr>
                                    <tr>
                                    	<th>#</th>
                                        <th>Nama Barang</th>
                                        <th>Nama Po</th>
                                        <th>Per PO</th>
                                        <th>Kebutuhan</th>
                                        <th>Stok</th>
                                        <th>Ajuan</th>
                                        <th>Keterangan</th>
                                        <th>Tanggal Ajuan</th>
                                        <th>Acc SPV</th>
                                        <th>Paraf</th>
	                                </tr>
	                                </thead>
                                    <tbody>
            	<?php $total = 0; ?>
            	<?php $no=1; foreach ($barang as $key => $item): ?>
            		<tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $item['nama_barang_pengajuan'] ?></td>
                        <td><?php echo $item['nama_po_pengajuan'] ?></td>
                       	<td><?php echo $item['jumlah_po_pengajuan'] ?></td>
                       	<td><?php echo $item['kebutuhan_po_pengajuan'] ?> <?php echo $item['satuan_jumlah_pengajuan'] ?></td>
                       	<td><?php echo $item['stok_item_pengajuan'] ?> <?php echo $item['satuan_jumlah_pengajuan'] ?></td>
                       	<td><?php echo $item['item_pengajuan'] ?> <?php echo $item['satuan_jumlah_pengajuan'] ?></td>
                       	<td><?php echo $item['keterangan_pengajuan'] ?></td>
                       	<td><?php echo $item['created_date'] ?></td>
                       	<td></td>
                       	<td></td>
                    </tr>
            	<?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4 text-center">
                            <div class="clearfix pt-4">
                                <h6 class="text-muted">Menyetujui:</h6>
                                <small class="text-center">
                                    SPV
                                </small>
                                <br>
                                <br>
                                <br>
								<small>(MUCHLAS)</small>                                
                            </div>
                        </div>

                       <div class="col-4 text-center">
                            <div class="clearfix pt-4">
                                <h6 class="text-muted">Di buat oleh:</h6>
                                <small class="text-center">
                                    ADMIN GUDANG
                                </small>
                                <br>
                                <br>
                                <br>
								<small>(LIA)</small>                                
                            </div>
                        </div>
                        <div class="col-4 text-center">
                            <div class="clearfix pt-4">
                                <h6 class="text-muted">Di cek Oleh:</h6>
                                <small class="text-center">
                                    ADMIN KEU
                                </small>
                                <br>
                                <br>
                                <br>
								<small>(LILA)</small> 
                            </div>
                        </div>
                        
                    </div>

                    <div class="hidden-print mt-4 mb-4">
                        <div class="text-center  row ">
                            <div class="col-12">
                                <a href="javascript:window.print()" class="btn btn-primary waves-effect waves-light"><i class="fa fa-print m-r-5"></i> Print</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <!-- end row -->

    </div> <!-- container -->

</div> <!-- content -->
