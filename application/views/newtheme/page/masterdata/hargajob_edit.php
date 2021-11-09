<form method="post" action="<?php echo $action?>">
  <div class="row">
    <div class="col-md-12">
      <input type="hidden" name="id" value="<?php echo $products['id']?>">
              <div class="form-group">
                  <label>Nama Pekerjaan</label>
                  <input type="text" name="nama_job" class="form-control" value="<?php echo $products['nama_job']?>">
              </div>
              <div class="form-group">
                <label>Jenis</label>
                <select name="jenis" class="form-control select2bs4">
                    <option value="1" <?php echo $products['jenis']==1?'selected':''; ?>>Jahit</option>
                    <option value="2" <?php echo $products['jenis']==2?'selected':''; ?>>Sablon</option>
                </select>
              </div>
              <div class="form-group">
                  <label>Harga</label>
                  <input type="number" name="harga" class="form-control" value="<?php echo $products['harga']?>">
              </div>
              <div class="form-group">
                <label>Keterangan</label>
                <textarea name="keterangan" class="form-control"><?php echo $products['keterangan']?></textarea>
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-sm btn-success">Simpan</button>
                <a href="<?php echo $cancel?>" class="btn btn-danger btn-sm text-white">Batal</a>
              </div>
    </div>
  </div>
</form>