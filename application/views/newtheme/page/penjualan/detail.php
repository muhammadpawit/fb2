<section class="invoice">
    <div class="row">
        <div class="col-xs-12">
            <h2 class="page-header"> <i class="fa fa-globe"></i> Forboys Production <small class="pull-right">Tanggal: <?php echo date('d/m/Y',strtotime($prods['tanggal'])) ?></small> </h2>
        </div>
    </div>
    <div class="row invoice-info">
        <div class="col-sm-4 invoice-col"> From <address> Jl.Z No.1 Kampung Baru,<br>Sukabumi Selatan<br>
				Kebon Jeruk,Jakarta Barat, Indonesia<br>
				HP : 081380401330 </address>
        </div>
        <div class="col-sm-4 invoice-col"> To <address> <strong><?php echo $prods['nama']?></strong><br> <?php echo $prods['alamat']?><br> Phone: <?php echo $prods['no_hp']?><br> Email: <?php echo $prods['email']?> </address>
        </div>
        <div class="col-sm-4 invoice-col"> <b>Invoice #<?php echo $prods['no_order']?></b><br><b>Marketplace :</b><br> <?php echo $prods['marketplace']?><br><b>No.Resi :</b><br> <?php echo $prods['no_resi']?></div>
    </div>
    <div class="row">
        <div class="col-xs-12 table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Qty</th>
                        <th>PO</th>
                        <th>Serian Warna #</th>
                        <th>Size #</th>
                        <th>Harga (Rp)</th>
                        <th>Discount (Rp)</th>
                        <th>Subtotal (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($products as $p){ ?>
                    <tr>
                        <td><?php echo $p['quantity']?></td>
                        <td><?php echo $p['kode_po']?></td>
                        <td><?php echo $p['serian']?></td>
                        <td><?php echo $p['size']?></td>
                        <td><?php echo number_format($p['harga'])?></td>
                        <td><?php echo number_format($p['discount'])?></td>
                        <td><?php echo number_format($p['jumlah'])?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6">
            <!-- <p class="lead">Payment Methods:</p> <img src="../../dist/img/credit/visa.png" alt="Visa"> <img src="../../dist/img/credit/mastercard.png" alt="Mastercard"> <img src="../../dist/img/credit/american-express.png" alt="American Express"> <img src="../../dist/img/credit/paypal2.png" alt="Paypal">
            <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;"> Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem plugg dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra. </p> -->
        </div>
        <div class="col-xs-6">
            <p class="lead"></p>
            <div class="table-responsive">
                <table class="table">
                    <tbody>
                        <tr>
                            <th style="width:50%">Subtotal:</th>
                            <td><?php echo number_format($prods['total_harga'])?></td>
                        </tr>
                        <tr>
                            <th>DIscount (Rp)</th>
                            <td><?php echo number_format($prods['total_discount'])?></td>
                        </tr>
                        <tr>
                            <th>Biaya Pengiriman:</th>
                            <td><?php echo number_format($prods['biaya_pengiriman'])?></td>
                        </tr>
                        <tr>
                            <th>Total:</th>
                            <td><?php echo number_format($prods['total'])?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row no-print">
        <div class="col-xs-12"> <a href="javascript:void(0)" onclick="window.print()" class="btn btn-default"><i class="fa fa-print"></i> Print</a> <button type="button" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit Payment </button> <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;"> <i class="fa fa-download"></i> Generate PDF </button> </div>
    </div>
</section>