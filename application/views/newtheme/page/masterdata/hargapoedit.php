<form method="post" action="<?php echo $action?>">
  <div class="row">
    <div class="col-md-12">
      <input type="hidden" name="id_potongan" value="<?php echo $products['id_potongan']?>">
      <input type="hidden" name="idpo" value="<?php echo $products['idpo']?>">
              <div class="form-group">
                  <label>Nama PO</label>
                  <input type="text" name="nama_job" class="form-control" value="<?php echo $products['kode_po']?>" readonly disabled>
              </div>
              
              <div class="form-group">
                  <label>Size </label>
                  <input type="text" name="size_potongan" class="form-control" value="<?php echo $products['size_potongan']?>" readonly disabled>
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