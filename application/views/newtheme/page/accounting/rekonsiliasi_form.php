<div class="row">
  <div class="col-md-6">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><?php echo $title ?></h3>
      </div>
      <form action="<?php echo $action ?>" method="post">
        <div class="card-body">
          <div class="form-group">
            <label>Tanggal Rekonsiliasi / Saldo Per Tanggal</label>
            <input type="date" name="tanggal" class="form-control" value="<?php echo date('Y-m-d') ?>" required>
            <small class="text-muted">Sistem akan menghitung saldo buku (Sistem) sampai dengan tanggal ini.</small>
          </div>
          <div class="form-group">
            <label>Akun Kas/Bank</label>
            <select name="id_akun_kas" class="form-control select2" required>
              <option value="">Pilih Akun Bank</option>
              <?php foreach($kas as $k): ?>
                <option value="<?php echo $k['id'] ?>"><?php echo $k['kode_akun'] ?> - <?php echo $k['nama_akun'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label>Saldo Akhir Rekening Koran (Rp)</label>
            <input type="number" step="0.01" name="saldo_bank" class="form-control" required placeholder="0.00">
            <small class="text-muted">Masukkan saldo akhir yang tertera pada mutasi/rekening koran bank Anda.</small>
          </div>
          <div class="form-group">
            <label>Catatan / Keterangan</label>
            <textarea name="keterangan" class="form-control" rows="3"></textarea>
          </div>
        </div>
        <div class="card-footer text-right">
          <button type="submit" class="btn btn-success">Hitung & Simpan Rekonsiliasi</button>
          <a href="<?php echo $batal ?>" class="btn btn-danger">Batal</a>
        </div>
      </form>
    </div>
  </div>
</div>
