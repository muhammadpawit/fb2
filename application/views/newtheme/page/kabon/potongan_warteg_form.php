<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><?php echo $title; ?></h3>
      </div>
      <form action="<?php echo $action; ?>" method="post">
        <div class="card-body">
          <?php if(isset($potongan)){ ?>
            <input type="hidden" name="id" value="<?php echo $potongan['id']; ?>">
          <?php } ?>
          <div class="form-group">
            <label>Karyawan</label>
            <select name="id_karyawan" class="form-control select2bs4" required>
              <option value="">-- Pilih Karyawan --</option>
              <?php foreach($karyawan as $k){ ?>
                <option value="<?php echo $k['id']; ?>" <?php echo isset($potongan) && $potongan['id_karyawan'] == $k['id'] ? 'selected' : ''; ?>><?php echo $k['nama']; ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label>Tanggal</label>
            <input type="date" name="tanggal" class="form-control" value="<?php echo isset($potongan) ? $potongan['tanggal'] : date('Y-m-d'); ?>" required>
          </div>
          <div class="form-group">
            <label>Nominal</label>
            <input type="number" name="nominal" class="form-control" value="<?php echo isset($potongan) ? $potongan['nominal'] : ''; ?>" required>
          </div>
          <div class="form-group">
            <label>Keterangan</label>
            <textarea name="keterangan" class="form-control"><?php echo isset($potongan) ? $potongan['keterangan'] : ''; ?></textarea>
          </div>
        </div>
        <div class="card-footer text-right">
          <button type="submit" class="btn btn-primary">Simpan</button>
          <a href="<?php echo BASEURL.'Kabon/potongan_warteg';?>" class="btn btn-secondary">Kembali</a>
        </div>
      </form>
    </div>
  </div>
</div>
