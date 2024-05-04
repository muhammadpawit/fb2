      <?php if(isset($ubahharga)){ ?>
        <div class="row">
          <form method="post" action="<?php echo $request_harga ?>">
            <input type="hidden" name="idrequest" value="<?php echo !empty($cek)?$cek['id']:0; ?>">
          <div class="col-md-12">
              <div class="form-group">
                <input type="hidden" name="id" value="<?php echo $results['id']?>">
                <strong>Terima Dari <?php echo GetName('master_supplier',$results['supplier'])?></strong><br>
              </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <table class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Nama Barang</th>
                  <?php if(!empty($cek)){ ?>
                    <?php if($cek['status']==0){ ?>
                  <?php } ?>
                  <th>Harga</th>
                  <?php } ?>

                  <?php if(!empty($cek)){ ?>
                    <?php if($cek['status']==0){ ?>
                  <th>Harga Perubahan</th>
                  <?php } ?>
                  <?php } ?>
                </tr>
                </thead>
                <tbody>
                <?php $total=0;?>
                <?php foreach($products as $p){?>
                  <tr>
                    <td><?php echo $p['nama']?></td>
                    <td><?php echo number_format($p['harga'],2)?></td>
                    <td>
                      <input type="hidden" name="prods[<?php echo $total ?>][id]" value="<?php echo $p['id'] ?>">
                      <?php if(!empty($cek)){ ?>
                          <?php if($cek['status']==0){ ?>
                              <input type="text" name="prods[<?php echo $total ?>][harga]" required>
                          <?php } ?>
                      <?php } ?>
                    </td>
                  </tr>
                    <?php $total++ ?>
                    <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label>Penjelasan Kenapa Mengalami Perubahan Harga</label>
              <?php //pre($cek) ?>
              <?php if(!empty($cek)){ ?>
                <div class="alert">
                  <?php echo $cek['oleh'] ?> Berkata : <i><b><?php echo $cek['alesan'] ?></b></i>
                </div>
              <?php } else { ?>
              <textarea class="form-control" name="alesan" required></textarea>
              <?php } ?>
            </div>
          </div>
          <div class="col-md-12">
            <?php if(empty($cek)){ ?>

              <button class="btn btn-success full">Request</button>

            <?php }else{ ?>

                <?php if(callSessUser('id_user')==10 || callSessUser('id_user')==11 && $cek['status']==0){ ?>
                  <button class="btn btn-success full" id="acc">Acc</button>
                <?php }elseif($cek['status']==1){ ?>
                  <div class="alert alert-success">
                    Sudah di ACC 
                  </div>
                <?php }else{ ?>
                    <i><b>Menunggu ACC SPV ...</b></i>
                <?php } ?>

            <?php } ?>
          </div>
          </form>
        </div>

      <?php }else{ ?>


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
            <div class="form-group">
              <label for="">Lampiran</label>
              <?php if(!empty($results['lampiran'])){ ?>

                <div class="image img-responsive">
                <img src="<?php echo BASEURL?><?php echo $results['lampiran']?>" class="img-thumbnail">
                </div>

              <?php }else{ ?>
                <div class="alert alert-danger no-print">
                  Tidak Ada Lampiran
                </div>
                <form action="<?php echo $action ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $results['id'] ?>">
                    <div class="row">
                      <div class="col-md-12">
                          <div class="form-group">
                              <label for="">Upload Foto Surat Jalan / Dokumen Pendukung Lainnya</label>
                              <input type="file" name="lampiran" class="form-control" accept=".jpg,.jpeg,.png">
                          </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <button class="btn btn-primary full" type="submit">Upload Lampiran</buton>
                        </div>
                      </div>
                    </div>
                </form>
              <?php } ?>
            </div>
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

      <?php } ?>