<div class="row">
  <div class="col-md-6">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><?php echo $title ?></h3>
      </div>
      <form action="<?php echo $action ?>" method="post">
        <input type="hidden" name="id" value="<?php echo isset($akun) ? $akun['id'] : '' ?>">
        <div class="card-body">
          <div class="form-group">
            <label>Kode Akun</label>
            <input type="text" name="kode_akun" class="form-control" value="<?php echo isset($akun) ? $akun['kode_akun'] : '' ?>" required>
          </div>
          <div class="form-group">
            <label>Nama Akun</label>
            <input type="text" name="nama_akun" class="form-control" value="<?php echo isset($akun) ? $akun['nama_akun'] : '' ?>" required>
          </div>
          <div class="form-group">
            <label>Akun Induk</label>
            <select name="id_induk" class="form-control select2">
              <option value="0">None (Root)</option>
              <?php foreach($akun_induk as $i): ?>
                <option value="<?php echo $i['id'] ?>" <?php echo (isset($akun) && $akun['id_induk'] == $i['id']) ? 'selected' : '' ?>><?php echo $i['kode_akun'] ?> - <?php echo $i['nama_akun'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label>Tipe Akun</label>
            <select name="tipe" class="form-control" required>
              <?php foreach(['ASET', 'KEWAJIBAN', 'EKUITAS', 'PENDAPATAN', 'BEBAN'] as $t): ?>
                <option value="<?php echo $t ?>" <?php echo (isset($akun) && $akun['tipe'] == $t) ? 'selected' : '' ?>><?php echo $t ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label>Saldo Normal</label>
            <select name="saldo_normal" class="form-control" required>
              <option value="DEBIT" <?php echo (isset($akun) && $akun['saldo_normal'] == 'DEBIT') ? 'selected' : '' ?>>DEBIT</option>
              <option value="KREDIT" <?php echo (isset($akun) && $akun['saldo_normal'] == 'KREDIT') ? 'selected' : '' ?>>KREDIT</option>
            </select>
          </div>
          <div class="form-group">
            <div class="custom-control custom-checkbox">
              <input class="custom-control-input" type="checkbox" id="is_header" name="is_header" <?php echo (isset($akun) && $akun['is_header'] == 1) ? 'checked' : '' ?>>
              <label for="is_header" class="custom-control-label">Header Account? (Can't have transactions)</label>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <button type="submit" class="btn btn-success">Simpan</button>
          <a href="<?php echo $batal ?>" class="btn btn-danger">Batal</a>
        </div>
      </form>
    </div>
  </div>
</div>
