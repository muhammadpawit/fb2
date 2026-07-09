<div class="row">
  <div class="col-md-12 text-right">
    <a href="<?php echo $tambah ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Pembayaran</a>
  </div>
</div>
<br>
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <th>Tanggal</th>
              <th>No. Bayar</th>
              <th>Supplier</th>
              <th>Total Bayar</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($results as $r): ?>
            <tr>
              <td><?php echo date('d/m/Y', strtotime($r['tanggal'])) ?></td>
              <td><?php echo $r['no_bayar'] ?></td>
              <td><?php echo $r['nama_supplier'] ?></td>
              <td align="right"><?php echo number_format($r['total_bayar'], 2) ?></td>
              <td class="text-center">
                <a href="<?php echo BASEURL ?>Utangusaha/invoice_payment_delete/<?php echo $r['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus pembayaran ini? Jurnal terkait juga akan dihapus.')"><i class="fa fa-trash"></i></a>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
