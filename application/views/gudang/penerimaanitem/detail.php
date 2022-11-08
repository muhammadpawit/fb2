      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-globe"></i> Bukti Penerimaan Item Masuk
            <small class="pull-right">Tanggal: <?php echo date('d F Y',strtotime($results['tanggal']))?></small>
          </h2>
        </div>
        <!-- /.col -->
      </div>

      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
          From
          <address>
            <strong><?php echo GetName('master_supplier',$results['supplier'])?></strong><br>
            <!-- 795 Folsom Ave, Suite 600<br>
            San Francisco, CA 94107<br>
            Phone: (804) 123-5432<br>
            Email: info@almasaeedstudio.com -->
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          To
          <address>
            <strong>Forboys Production</strong><br>
            Jl.Z No.1 Kampung Baru, Kec.Sukabumi Selatan<br>
            Jakarta Barat, Indonesia<br>
            Email: Info@Forboysproduction.Com<br>
            Phone: -
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          <b>Nomor Surat  <?php echo $results['nosj']?></b><br>
          <br>
          <b>Order ID:</b> <?php echo $results['id']?><br>
          <!-- <b>Payment Due:</b> 2/22/2014<br>
          <b>Account:</b> 968-34567 -->
        </div>
        <!-- /.col -->
      </div>

      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped">
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
            <?php $total=0;?>
            <?php foreach($products as $p){?>
              <tr>
                <td><?php echo $p['nama']?></td>
                <td><?php echo $p['ukuran']?> <?php echo $p['satuanukuran']?></td>
                <td><?php echo $p['jumlah']?> <?php echo $p['satuanJml']?></td>
                <td><?php echo number_format($p['harga'],2)?></td>
                <td>
                <?php if($results['jenis']==1){?>
                  <?php echo number_format($p['ukuran']*$p['harga'],2)?>
                  <?php $total+=($p['ukuran']*$p['harga']);?>
                  <?php }else{ ?>
                  <?php echo number_format($p['jumlah']*$p['harga'],2)?>
                  <?php $total+=($p['jumlah']*$p['harga']);?>
                  <?php } ?>
                </td>
              </tr>
                <?php } ?>
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>

      <div class="row">
        <!-- accepted payments column -->
        <div class="col-xs-6">
          
        </div>
        <!-- /.col -->
        <div class="col-xs-6">
          

          <div class="table-responsive">
            <table class="table">
              <tr>
                <th style="width:50%">Subtotal:</th>
                <td><b>Rp. <?php echo number_format($total,2)?></b></td>
              </tr>
              <tr>
                <!-- <th>Tax (9.3%)</th>
                <td>$10.34</td> -->
              </tr>
              <tr>
                <!-- <th>Shipping:</th>
                <td>$5.80</td> -->
              </tr>
              <tr>
                <th>Total:</th>
                <td><b>Rp. <?php echo number_format($total,2)?></b></td>
              </tr>
            </table>
          </div>
        </div>
        <!-- /.col -->
      </div>

      <div class="row no-print">
        <div class="col-xs-12">
          <!-- <a onclick="cetak()" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a> -->
          <button onclick="cetak()" type="button" class="btn btn-success pull-right"><i class="fa fa-print"></i> Print
          </button>
          <a href="<?php echo BASEURL.'gudang/penerimaanitem'?>" type="button" class="btn btn-danger pull-right" style="margin-right: 5px;">
             Kembali
          </a>
        </div>
      </div>