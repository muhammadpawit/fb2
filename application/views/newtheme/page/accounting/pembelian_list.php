<div class="row">
  <div class="col-md-12 text-right">
    <a href="<?php echo $tambah ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Tagihan</a>
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
              <th>No. Invoice</th>
              <th>Supplier</th>
              <th>Jatuh Tempo</th>
              <th>Total</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($results as $r): ?>
            <tr>
              <td><?php echo date('d/m/Y', strtotime($r['tanggal'])) ?></td>
              <td><?php echo $r['no_invoice'] ?></td>
              <td><?php echo $r['nama_supplier'] ?></td>
              <td><?php echo date('d/m/Y', strtotime($r['jatuh_tempo'])) ?></td>
              <td align="right"><?php echo number_format($r['total'], 2) ?></td>
              <td>
                <?php if($r['status'] == 1): ?>
                  <span class="badge badge-success">Paid</span>
                <?php else: ?>
                  <span class="badge badge-warning">Open</span>
                <?php endif; ?>
              </td>
              <td>
                <a href="<?php echo BASEURL.'Utangusaha/invoice_edit/'.$r['id'] ?>" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> Edit</a>
                <a href="<?php echo BASEURL.'Utangusaha/invoice_delete/'.$r['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"><i class="fa fa-trash"></i> Hapus</a>
                <?php if($r['status'] == 0): ?>
                  <!-- <a href="#" class="btn btn-info btn-sm">Bayar</a> -->
                <?php endif; ?>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
