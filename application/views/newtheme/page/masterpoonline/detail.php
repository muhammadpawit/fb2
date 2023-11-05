<form action="<?php echo $action ?>" method="POST">
<input type="hidden" name="id" value="<?php echo $prods['id']?>">
<section class="invoice">
    <div class="row">
        <div class="col-xs-12">
            <!-- <h2 class="page-header"> <i class="fa fa-globe"></i> Forboys Production <small class="pull-right">Tanggal: <?php echo date('d/m/Y',strtotime($prods['tanggal'])) ?></small> </h2> -->
        </div>
    </div>
    <div class="row invoice-info">
        <div class="col-sm-4 invoice-col"> From <address> Penerimaan PO Online<br>
				<?php echo $prods['kode_po']?><br>
				Dari : <?php echo $prods['namacmt']?> </address>
        </div>
        <!-- <div class="col-sm-4 invoice-col"> From <address> Jl.Z No.1 Kampung Baru,<br>Sukabumi Selatan<br>
				Kebon Jeruk,Jakarta Barat, Indonesia<br>
				HP : 081380401330 </address>
        </div>
        <div class="col-sm-4 invoice-col"> To <address> <strong><?php echo $prods['nama']?></strong><br> <?php echo $prods['alamat']?><br> Phone: <?php echo $prods['no_hp']?><br> Email: <?php echo $prods['email']?> </address>
        </div>
        <div class="col-sm-4 invoice-col"> <b>Invoice #<?php echo $prods['no_order']?></b><br><b>Marketplace :</b><br> <?php echo $prods['marketplace']?><br><b>No.Resi :</b><br> <?php echo $prods['no_resi']?></div> -->
    </div>
    <div class="row">
        <div class="col-xs-12 table-responsive">
            <table class="table table-borderless table-hover">
                <thead>
                    <tr>
                        <th style="width: 60%;">PO</th>
                        <th style="width: 20%;">Harga (Rp)</th>
                        <th style="width: 10%;">QTY</th>
                        <th style="width: 10%;">Size</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i=0;?>
                    <?php foreach($products as $p){ ?>
                        <?php $serian = $this->GlobalModel->getDataRow('master_po_online_serian',array('id'=>$p['id_serian'])); ?>
                    <tr>
                        <td><?php echo $prods['kode_po']?> <?php echo $serian['nama']?> Size <?php echo $p['id_size']?></td>
                        <td><?php echo number_format($prods['harga']) ?></td>
                        <td>
                            <input type="hidden" name="prods[<?php echo $i?>][id]" value="<?php echo $p['id'] ?>">
                            <input type="number" name="prods[<?php echo $i?>][pcs]" value="<?php echo $p['pcs']?>">
                        </td>
                        <td><?php echo $p['id_size']?></td>
                    </tr>
                    <?php $i++?>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row no-print">
        <div class="col-md-4"> 
            <a href="<?php echo $batal ?>" class="btn btn-danger"><i class="fa fa-print"></i> Batal</a> 
            <button type="submit" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit </button> 
            <!-- <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;"> <i class="fa fa-download"></i> Generate PDF </button> -->
         </div>
    </div>
</section>
</form>