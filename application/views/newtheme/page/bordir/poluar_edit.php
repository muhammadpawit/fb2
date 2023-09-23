<div class="row">
    <div class="col-md-12">
        <form method="post" action="<?php echo $action?>">
         <input type="hidden" name="id" value="<?php echo $prods['id']?>">
          <div class="form-group">
            <label>Nama PO</label>
            <input type="text" name="nama" class="form-control" required="required" value="<?php echo $prods['nama']?>">
          </div>
          <div class="form-group">
            <label>Pemilik PO</label>
            <select name="pemilik" class="form-control select2bs4" required="required">
              <option value="">Pilih</option>
              <?php foreach($pemilik as $p){?>
                <option value="<?php echo $p['id']?>" <?php echo $p['id']==$prods['idpemilik'] ?'selected':''; ?>><?php echo $p['nama']?></option>
              <?php } ?>
            </select>
          </div>
          <button type="submit" class="btn btn-info">Simpan</button>
          <a href="<?php echo $batal ?>" class="btn btn-danger text-white" data-dismiss="modal">Batal</a>
        </form>
    </div>
</div>