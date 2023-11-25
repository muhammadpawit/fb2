<div class="row">
  <div class="col-md-12">
    <div class="form-group">
      <a href="<?php echo $action ?>" class="btn btn-sm btn-primary">Tambah</a>
    </div>
  </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <table class="table table-bordered table-hover yessearch">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Nama Customer</th>
                        <th>No. WA / HP</th>
                        <th>Jumlah (Rp)</th>
                        <th>Total Discount (Rp)</th>
                        <th>Biaya Pengiriman (Rp)</th>
                        <th>Total (Rp)</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($prods as $c){ ?>
                        <tr>
                            <td><?php echo $c['no']?></td>
                            <td><?php echo $c['tanggal']?></td>
                            <td><?php echo $c['namacustomer']?></td>
                            <td><?php echo $c['no_hp']?></td>
                            <td><?php echo number_format($c['total_harga'])?></td>
                            <td><?php echo number_format($c['total_discount'])?></td>
                            <td><?php echo number_format($c['biaya_pengiriman'])?></td>
                            <td><?php echo number_format($c['total'])?></td>
                            <td>
                              <a href="<?php echo $c['detail']?>" class="btn btn-xs btn-info">Detail</a>

                              <a href="<?php echo $c['hapus']?>" class="btn btn-xs btn-danger" onclick="return confirm('Apakah yakin?')">Hapus</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>