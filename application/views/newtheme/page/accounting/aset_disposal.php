<div class="row">
  <div class="col-md-12 text-right">
    <!-- Link to add disposal if needed, for now just the list -->
  </div>
</div>
<br>
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Daftar Pelepasan / Penjualan Aset</h3>
      </div>
      <div class="card-body">
        <table class="table table-bordered table-hover datatable">
          <thead>
            <tr>
              <th>Kode</th>
              <th>Nama Aset</th>
              <th>Tgl Perolehan</th>
              <th>Harga Perolehan</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if(!empty($results)): ?>
              <?php foreach($results as $r): ?>
              <tr>
                <td><?php echo $r['kode_aset'] ?></td>
                <td><?php echo $r['nama_aset'] ?></td>
                <td><?php echo date('d/m/Y', strtotime($r['tgl_perolehan'])) ?></td>
                <td align="right"><?php echo number_format($r['harga_perolehan'], 2) ?></td>
                <td><span class="badge badge-warning"><?php echo $r['status'] ?></span></td>
                <td>
                  <a href="#" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> Detail</a>
                </td>
              </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="6" class="text-center">Belum ada data pelepasan aset.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
