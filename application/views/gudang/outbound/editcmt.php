<?php //pre($post); ?>
<!-- Start Page content -->
 <div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div class="card-box">

                    <div class="row">
                        <div class="col-4">
                            <img src="<?php echo ASSETS ?>images/logosuratjalan.png" alt="" width="500">
                        </div>
                        <div class="col-4 text-center">
                            <h4 class="m-0 d-print-none">SURAT JALAN (ITEM KELUAR)</h4>
                        </div>
                        <div class="col-4 ">
                            <div class="mt-3 pull-right">
                            	<table style="font-size: 23pt;">
                            		<tr class="text-center">
                            			<td colspan="2"><strong>Jakarta</strong>, <?php echo date('d-m-Y') ?></td>
                            		</tr>
                            		<tr  class="text-center">
                            			<td colspan="2">Kepada Yth</td>
                            		</tr>
                            		<tr>
                            			<td>Tuan/Toko</td>
                            			<td>: <?php echo $barang[0]['nama_penerima']; ?></td>
                            		</tr>
                            		<tr>
                            			<td>Tujuan</td>
                            			<td>: <?php echo $barang[0]['tujuan_item']; ?></td>
                            		</tr>
                                    <tr>
                                        <td>NAMA PO</td>
                                        <td>: <?php echo $project['nama_po'].$project['kode_po']; ?></td>
                                    </tr>
                            	</table>
                            </div>
                            <form method="post" action="<?php echo $action?>" class="no-print">
                                <div class="form-group">
                                    <label>Nama CMT Baru</label>
                                    <select name="nama_penerima" class="form-control select2bs4" data-live-search="true">
                                        <option value="*">Pilih</option>
                                        <?php foreach($cmt as $c){?>
                                            <option value="<?php echo strtoupper($c['cmt_name'])?>"><?php echo strtoupper($c['cmt_name'])?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Tujuan</label>
                                    <input type="text" name="tujuan_item" class="form-control" value="-">
                                    <input type="hidden" name="kode_po" class="form-control" value="<?php echo $project['id_produksi_po']; ?>">
                                </div>
                                <div>
                                    <label></label><br>
                                    <button type="submit" class="btn btn-sm btn-info">Update</button>
                                </div>
                            </form>
                        </div><!-- end col -->
                    </div>
                    <!-- end row -->

                    <div class="row mt-3">
                        <div class="col-6">
                            <h6>Billing Address</h6>

                            <address class="line-h-24">
                               JL.Z NO 1, Kel. Sukabumi Selatan, Kec Kebon Jeruk Kampung Baru, Jakarta Barat
                            </address>
                            <h3><strong>Faktur No. </strong><?php echo $barang[0]['faktur_no'] ?></h3>
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
                                        <th>Item Perlusin</th>
                                        <th class="text-right">Total</th>
                                    </tr></thead>
                                    <tbody>
                                    	<?php $total = 0; ?>
                            	<?php $no=1; foreach ($barang as $key => $item): ?>
                            		<tr>
                                        <td><?php echo $no++; ?></td>
                                        <td>
                                            <b><?php echo $item['nama_item_keluar'] ?></b> 
                                        </td>
                                        <td><?php echo $item['jumlah_item_keluar'] ?> <?php echo $item['satuan_jumlah_keluar'] ?></td>
                                        <td><?php echo number_format($item['harga_item']) ?></td>
                                        <td><?php echo ($item['jumlah_item_perlusin']) ?></td>
                                        <?php 
                                        $total += $item['jumlah_item_keluar'] * $item['harga_item'];
                                         ?>
                                        <td class="text-right"><?php echo number_format($item['jumlah_item_keluar'] * $item['harga_item']) ?></td>
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

                    <div class="hidden-print mt-4 mb-4 no-print">
                        <div class="text-right  row ">
                            <div class="col-6">
                                <a href="javascript:window.print()" class="btn btn-primary waves-effect waves-light"><i class="fa fa-print m-r-5"></i> Print</a>
                           
                            </div>
                                <div class="col-6 text-left">
                            </div>
                            
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <!-- end row -->

    </div> <!-- container -->

</div> <!-- content -->
