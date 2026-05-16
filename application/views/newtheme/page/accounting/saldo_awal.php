<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Pengaturan Saldo Awal</h3>
      </div>
      <form action="<?php echo $action ?>" method="post">
        <div class="card-body">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label>Periode Pembukuan</label>
                <input type="text" name="periode" class="form-control" value="<?php echo date('Y') ?>" placeholder="Contoh: 2024" required>
              </div>
            </div>
          </div>
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Kode Akun</th>
                <th>Nama Akun</th>
                <th>Tipe</th>
                <th>Debit</th>
                <th>Kredit</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($results as $r): ?>
              <tr>
                <td><?php echo $r['kode_akun'] ?></td>
                <td><?php echo $r['nama_akun'] ?></td>
                <td><?php echo $r['tipe'] ?></td>
                <td>
                  <input type="number" step="0.01" name="saldo[<?php echo $r['id'] ?>][debit]" class="form-control" value="<?php echo $r['debit'] ?? 0 ?>">
                </td>
                <td>
                  <input type="number" step="0.01" name="saldo[<?php echo $r['id'] ?>][kredit]" class="form-control" value="<?php echo $r['kredit'] ?? 0 ?>">
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <div class="card-footer text-right">
          <button type="submit" class="btn btn-primary">Simpan Saldo Awal</button>
        </div>
      </form>
    </div>
  </div>
</div>
