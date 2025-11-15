<form method="post" action="<?php echo $action?>">
  <div class="row">
    <div class="col-md-12">
      <input type="hidden" name="id" value="<?php echo $products['id']?>">
              <div class="form-group">
                  <label>Nama PO</label>
                  <select name="nama_po" class="form-control select2bs4" style="width: 100%;" required>
                    <option value="">Pilih</option>
                    <?php foreach(table('master_jenis_po') as $p){?>
                      <option value="<?php echo $p['nama_jenis_po']?>" <?php echo $p['nama_jenis_po'] == $products['nama_po'] ? 'selected' : '' ?>><?php echo $p['nama_jenis_po'] ?></option>
                    <?php } ?>
                  </select>
              </div>
              
              <div class="form-group">
                  <label>Size </label>
                  <select name="size" class="form-control select2bs4" style="width: 100%;" required>
                    <option value="">Pilih</option>
                    <?php foreach(table('mastersize_potongan') as $p){?>
                      <option value="<?php echo $p['size']?>" <?php echo $p['size'] == $products['size'] ? 'selected' : '' ?>><?php echo $p['size'] ?></option>
                    <?php } ?>
                  </select>
              </div>

              <div class="form-group">
                  <label>Harga </label>
                  <input type="number" name="hargahpp" class="form-control" value="<?php echo $products['hargahpp']?>">
              </div>

              
              <div class="form-group">
                <button type="submit" class="btn btn-sm btn-success">Simpan</button>
                <a href="<?php echo $cancel?>" class="btn btn-danger btn-sm text-white">Batal</a>
              </div>
    </div>
  </div>
</form>