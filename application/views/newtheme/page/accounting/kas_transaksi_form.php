<div class="row">
  <div class="col-md-6">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><?php echo $title ?></h3>
      </div>
      <form action="<?php echo $action ?>" method="post">
        <div class="card-body">
          <div class="form-group">
            <label>Tanggal</label>
            <input type="date" name="tanggal" class="form-control" value="<?php echo date('Y-m-d') ?>" required>
          </div>
          <div class="form-group">
            <label>No. Transaksi</label>
            <input type="text" name="no_transaksi" class="form-control" value="TR-<?php echo date('YmdHis') ?>" required>
          </div>
          <div class="form-group">
            <label>Akun Kas/Bank</label>
            <select name="id_akun_kas" class="form-control select2" required>
              <option value="">Pilih Akun Kas/Bank</option>
              <?php foreach($kas as $k): ?>
                <option value="<?php echo $k['id'] ?>"><?php echo $k['kode_akun'] ?> - <?php echo $k['nama_akun'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label>Tipe Transaksi</label>
            <select name="tipe" class="form-control" required>
              <option value="MASUK">Uang Masuk</option>
              <option value="KELUAR">Uang Keluar</option>
            </select>
          </div>
          <div class="form-group">
            <label>Total Nominal</label>
            <input type="number" step="0.01" name="total" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Keterangan</label>
            <textarea name="keterangan" class="form-control" rows="3"></textarea>
          </div>
        </div>
        <div class="card-footer text-right">
          <button type="submit" class="btn btn-success">Simpan Transaksi</button>
          <a href="<?php echo $batal ?>" class="btn btn-danger">Batal</a>
        </div>
      </form>
    </div>
  </div>
</div>
