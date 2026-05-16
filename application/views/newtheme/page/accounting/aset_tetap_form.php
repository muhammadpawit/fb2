<div class="row">
  <div class="col-md-8">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><?php echo $title ?></h3>
      </div>
      <form action="<?php echo $action ?>" method="post">
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Nama Aset</label>
                <input type="text" name="nama_aset" class="form-control" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Kode Aset</label>
                <input type="text" name="kode_aset" class="form-control" value="AST-<?php echo date('YmdHis') ?>">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label>Tgl Perolehan</label>
                <input type="date" name="tgl_perolehan" class="form-control" required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Harga Perolehan</label>
                <input type="number" step="0.01" name="harga_perolehan" class="form-control" required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Nilai Residu</label>
                <input type="number" step="0.01" name="residu" class="form-control" value="0">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Masa Manfaat (Bulan)</label>
                <input type="number" name="masa_manfaat" class="form-control" placeholder="Contoh: 48" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Metode Penyusutan</label>
                <select name="metode" class="form-control">
                  <option value="STRAIGHT_LINE">Garis Lurus (Straight Line)</option>
                  <option value="DOUBLE_DECLINING">Saldo Menurun Ganda</option>
                </select>
              </div>
            </div>
          </div>
          <hr>
          <div class="form-group">
            <label>Akun Aset</label>
            <select name="id_akun_aset" class="form-control select2" required>
              <option value="">Pilih Akun Aset</option>
              <?php foreach($akun_aset as $a): ?>
                <option value="<?php echo $a['id'] ?>"><?php echo $a['kode_akun'] ?> - <?php echo $a['nama_akun'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label>Akun Akumulasi Penyusutan</label>
            <select name="id_akun_akum_susut" class="form-control select2" required>
              <option value="">Pilih Akun Akumulasi</option>
              <?php foreach($akun_aset as $a): ?>
                <option value="<?php echo $a['id'] ?>"><?php echo $a['kode_akun'] ?> - <?php echo $a['nama_akun'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label>Akun Beban Penyusutan</label>
            <select name="id_akun_beban_susut" class="form-control select2" required>
              <option value="">Pilih Akun Beban</option>
              <?php foreach($akun_beban as $a): ?>
                <option value="<?php echo $a['id'] ?>"><?php echo $a['kode_akun'] ?> - <?php echo $a['nama_akun'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="card-footer text-right">
          <button type="submit" class="btn btn-success">Simpan Aset</button>
          <a href="<?php echo $batal ?>" class="btn btn-danger">Batal</a>
        </div>
      </form>
    </div>
  </div>
</div>
