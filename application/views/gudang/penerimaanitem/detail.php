<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Info Penerimaan</h4>
                        <p class="text-muted font-14 m-b-30">
                            <?php if ($this->session->flashdata('msg')) { ?>

                            <div class="alert alert-danger alert-dismissible fade show" role="alert">

                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">

                                    <span aria-hidden="true">×</span>

                                </button>
                                   <?php echo $this->session->flashdata('msg'); ?> 

                            </div>

                               <?php } ?>

                        </p>
                        <div class="sub-header">
                            <span class="pull-right"><a href="<?php echo BASEURL.'gudang/penerimaanitem'?>" class="btn btn-danger">Kembali</a> </span>
                        </div>
                        <div style="clear: both;margin: 5px">&nbsp;</div>
                        <div class="form-group">
                            <label>No.Surat Jalan : <?php echo $results['nosj']?></label>
                        </div>
                        <div class="form-group">
                            <label>Keterangan : <?php echo $results['keterangan']?></label>
                        </div>
                        <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead>
                                        <tr>
                                            <th>Nama Barang</th>
                                            <th>Satuan Ukuran</th>
                                            <th>Jumlah</th>
                                            <th>Harga Satuan</th>
                                            <th>Total</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($products as $p){?>
                                            <tr>
                                                <td><?php echo $p['nama']?></td>
                                                <td><?php echo $p['ukuran']?> <?php echo $p['satuanukuran']?></td>
                                                <td><?php echo $p['jumlah']?> <?php echo $p['satuanJml']?></td>
                                                <td><?php echo number_format($p['harga'],2)?></td>
                                                <td>
                                                	<?php if($results['jenis']==1){?>
                                                		<?php echo number_format($p['ukuran']*$p['harga'],2)?>
                                                	<?php }else{ ?>
                                                		<?php echo number_format($p['jumlah']*$p['harga'],2)?>
                                                	<?php } ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                        </div>
                    </div>
                </div> <!-- end card -->
            </div>
        </div>
    </div>
</div>