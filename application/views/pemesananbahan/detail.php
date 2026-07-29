<div class="row">
  <div class="col-xs-12">
    <h2 class="page-header">
      <i class="fa fa-globe"></i> Bukti Pemesanan Bahan
      <small class="pull-right">Tanggal: <?php echo date('d F Y',strtotime($results['tanggal']))?></small>
    </h2>
  </div>
</div>

<div class="row invoice-info">
  <div class="col-sm-4 invoice-col">
    To
    <address>
      <strong><?php echo $results['nama_supplier']?></strong><br>
    </address>
  </div>
  <div class="col-sm-4 invoice-col">
    From
    <address>
      <strong>Forboys Production</strong><br>
      Jl.Z No.1 Kampung Baru, Kec.Sukabumi Selatan<br>
      Jakarta Barat, Indonesia<br>
      Email: Info@Forboysproduction.Com<br>
    </address>
  </div>
  <div class="col-sm-4 invoice-col">
    <b>Nota Pesanan / PO: <?php echo $results['nosj']?></b><br>
    <br>
    <b>Order ID:</b> <?php echo $results['id']?><br>
  </div>
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
</div>

<div class="row">
  <div class="col-xs-6">
      <div class="form-group">
        <label for="">Lampiran</label>
        <?php if(!empty($results['lampiran'])){ ?>
          <div class="image img-responsive">
          <img src="/<?php echo $results['lampiran']?>" class="img-thumbnail">
          </div>
        <?php }else{ ?>
          <div class="alert alert-danger no-print">
            Tidak Ada Lampiran
          </div>
        <?php } ?>
      </div>
  </div>
  <div class="col-xs-6">
    <div class="table-responsive">
      <table class="table">
        <tr>
          <th style="width:50%">Subtotal:</th>
          <td><b>Rp. <?php echo number_format($total,2)?></b></td>
        </tr>
        <tr>
          <th>Total:</th>
          <td><b>Rp. <?php echo number_format($total,2)?></b></td>
        </tr>
      </table>
    </div>
  </div>
</div>
<div class="row no-print">
  <div class="col-xs-12">
    <button onclick="cetak()" type="button" class="btn btn-success pull-right"><i class="fa fa-print"></i> Print
    </button>
    <a href="<?php echo BASEURL.'Pemesananbahan'?>" type="button" class="btn btn-danger pull-right" style="margin-right: 5px;">
       Kembali
    </a>
  </div>
</div>