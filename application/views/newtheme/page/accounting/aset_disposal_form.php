<div class="row">
  <div class="col-md-6">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Detail Aset</h3>
      </div>
      <div class="card-body">
        <table class="table table-bordered">
          <tr>
            <th>Nama Aset</th>
            <td><?php echo $aset['nama_aset'] ?></td>
          </tr>
          <tr>
            <th>Kode Aset</th>
            <td><?php echo $aset['kode_aset'] ?></td>
          </tr>
          <tr>
            <th>Tgl Perolehan</th>
            <td><?php echo date('d/m/Y', strtotime($aset['tgl_perolehan'])) ?></td>
          </tr>
          <tr>
            <th>Harga Perolehan</th>
            <td><?php echo number_format($aset['harga_perolehan'], 2) ?></td>
          </tr>
        </table>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Form Pelepasan</h3>
      </div>
      <div class="card-body">
        <form action="<?php echo $action ?>" method="post">
          <input type="hidden" name="id" value="<?php echo $aset['id'] ?>">
          <div class="form-group">
            <label>Alasan / Status Pelepasan</label>
            <select name="status" class="form-control" required>
              <option value="DIJUAL">Dijual</option>
              <option value="DIHAPUS">Dihapus / Rusak</option>
            </select>
          </div>
          <div class="form-group">
            <label>Keterangan</label>
            <textarea name="keterangan" class="form-control" rows="3"></textarea>
          </div>
          <div class="text-right">
            <a href="<?php echo $batal ?>" class="btn btn-default">Batal</a>
            <button type="submit" class="btn btn-danger">Simpan Pelepasan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
