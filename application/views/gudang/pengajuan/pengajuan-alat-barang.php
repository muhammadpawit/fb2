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
		                            	<?php $no=1; foreach ($post['id'] as $key => $item): ?>
		                            		<tr>
		                                        <td><?php echo $no++; ?></td>
		                                        <td><?php echo $post['namaBarang'][$key] ?></td>
		                                        <td><?php echo $post['namaPO'][$key] ?></td>
		                                       	<td><?php echo $post['perPo'][$key] ?></td>
		                                       	<td><?php echo $post['kebutuhan'][$key] ?> <?php echo $post['satuanJml'][$key] ?></td>
		                                       	<td><?php echo $post['stok'][$key] ?> <?php echo $post['satuanJml'][$key] ?></td>
		                                       	<td><?php echo $post['ajuan'][$key] ?> <?php echo $post['satuanJml'][$key] ?></td>
		                                       	<td><?php echo $post['keterangan'][$key] ?></td>
		                                       	<td><?php echo date('Y-m-d') ?></td>
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
                        <div class="text-right  row ">
                            <div class="col-6">
                                <a href="javascript:window.print()" class="btn btn-primary waves-effect waves-light"><i class="fa fa-print m-r-5"></i> Print</a>
                           
                            </div>
                                <div class="col-6 text-left">

             <form action="<?php echo BASEURL.'pengajuan/pengajuanitemOnCreate' ?>" method="post">
             	<input type="hidden" value="<?php echo generateReferenceNumber(); ?>" name="kodeTF">
                <?php  foreach ($post['id'] as $key => $item): ?>
                    <input type="hidden" value="<?php echo $item ?>" name="id[]">
                    <input type="hidden" value="<?php echo $post['namaBarang'][$key] ?>" name="namaBarang[]">
                    <input type="hidden" value="<?php echo $post['namaPO'][$key] ?>" name="namaPo[]">
                    <input type="hidden" value="<?php echo $post['perPo'][$key] ?>" name="perPo[]">
                    <input type="hidden" value="<?php echo $post['kebutuhan'][$key] ?>" name="kebutuhan[]">   
                    <input type="hidden" value="<?php echo $post['stok'][$key] ?>" name="stok[]"> 
                    <input type="hidden" value="<?php echo $post['satuanJml'][$key] ?>" name="satuanJml[]">
                    <input type="hidden" value="<?php echo $post['ajuan'][$key] ?>" name="ajuan[]">
                    <input type="hidden" value="<?php echo $post['keterangan'][$key] ?>" name="keterangan[]">
                    <input type="hidden" value="<?php echo date('Y-m-d') ?>" name="date[]">
                <?php endforeach ?>
                <button type="submit" class="btn btn-info waves-effect waves-light">Submit</button>
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
