<div class="row">
  <div class="col-md-6">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><?php echo $title ?></h3>
      </div>
      <form action="<?php echo $action ?>" method="post">
        <?php if(isset($trx)): ?>
          <input type="hidden" name="id" value="<?php echo $trx['id'] ?>">
        <?php endif; ?>
        <div class="card-body">
          <div class="form-group">
            <label>Tanggal</label>
            <input type="date" name="tanggal" class="form-control" value="<?php echo isset($trx) ? $trx['tanggal'] : date('Y-m-d') ?>" required>
          </div>
          <div class="form-group">
            <label>No. Transaksi</label>
            <input type="text" name="no_transaksi" class="form-control" value="<?php echo isset($trx) ? $trx['no_transaksi'] : 'TR-'.date('YmdHis') ?>" required readonly>
          </div>
          <div class="form-group">
            <label>Akun Kas/Bank</label>
            <select name="id_akun_kas" class="form-control select2" required>
              <option value="">Pilih Akun Kas/Bank</option>
              <?php foreach($kas as $k): ?>
                <option value="<?php echo $k['id'] ?>" <?php echo isset($trx) && $trx['id_akun_kas'] == $k['id'] ? 'selected' : '' ?>><?php echo $k['kode_akun'] ?> - <?php echo $k['nama_akun'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label>Lawan Transaksi (Dari/Ke Akun Apa)</label>
            <select name="id_akun_lawan" class="form-control select2" required>
              <option value="">Pilih Lawan Transaksi</option>
              <?php foreach($akun_lawan as $k): ?>
                <option value="<?php echo $k['id'] ?>" <?php echo isset($trx) && $trx['id_akun_lawan'] == $k['id'] ? 'selected' : '' ?>><?php echo $k['kode_akun'] ?> - <?php echo $k['nama_akun'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label>Tipe Transaksi</label>
            <select name="tipe" class="form-control" required>
              <option value="MASUK" <?php echo isset($trx) && $trx['tipe'] == 'MASUK' ? 'selected' : '' ?>>Uang Masuk</option>
              <option value="KELUAR" <?php echo isset($trx) && $trx['tipe'] == 'KELUAR' ? 'selected' : '' ?>>Uang Keluar</option>
            </select>
          </div>
          <div class="form-group">
            <label>Total Nominal</label>
            <input type="number" step="0.01" name="total" class="form-control" value="<?php echo isset($trx) ? $trx['total'] : '' ?>" required>
          </div>
          <div class="form-group">
            <label>Keterangan</label>
            <textarea name="keterangan" class="form-control" rows="3"><?php echo isset($trx) ? $trx['keterangan'] : '' ?></textarea>
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
