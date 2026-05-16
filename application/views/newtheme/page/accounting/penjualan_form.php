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
                <label>Customer</label>
                <select name="id_customer" class="form-control select2" required>
                  <option value="">Pilih Customer</option>
                  <?php foreach($customer as $s): ?>
                    <option value="<?php echo $s['id'] ?>"><?php echo $s['nama'] ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>No. Faktur</label>
                <input type="text" name="no_faktur" class="form-control" value="INV-<?php echo date('YmdHis') ?>" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Tanggal Faktur</label>
                <input type="date" name="tanggal" class="form-control" value="<?php echo date('Y-m-d') ?>" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Jatuh Tempo</label>
                <input type="date" name="jatuh_tempo" class="form-control" value="<?php echo date('Y-m-d', strtotime('+30 days')) ?>">
              </div>
            </div>
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
          <button type="submit" class="btn btn-success">Simpan Faktur</button>
          <a href="<?php echo $batal ?>" class="btn btn-danger">Batal</a>
        </div>
      </form>
    </div>
  </div>
</div>
