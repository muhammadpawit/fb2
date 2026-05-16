<div class="row">
  <div class="col-md-12 text-right">
    <a href="<?php echo $tambah ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Faktur</a>
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
              <th>No. Faktur</th>
              <th>Customer</th>
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
              <td><?php echo $r['no_faktur'] ?></td>
              <td><?php echo $r['nama_customer'] ?></td>
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
                <a href="#" class="btn btn-info btn-sm">Terima</a>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
