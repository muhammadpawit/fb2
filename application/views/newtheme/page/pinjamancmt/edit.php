<form method="post" action="<?php echo $action?>">
  <input type="hidden" name="id" value="<?php echo $p['id']?>">
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label>Tanggal</label>
        <input type="date" name="tanggal" class="form-control" required="required" value="<?php echo $p['tanggal']?>">
      </div>
      <div class="form-group">
        <label>Nama CMT</label>
        <select name="idcmt" class="form-control select2bs4" style="width: 100%;" required="required" data-live-search="true">
            <option value="">Pilih</option>
            <?php foreach($cmt as $c){?>
              <option value="<?php echo $c['id_cmt']?>" <?php echo $c['id_cmt']==$p['idcmt']?'selected':''?>><?php echo strtoupper($c['cmt_name'])?></option>
            <?php } ?>
        </select>
      </div>
      <div class="form-group">
        <label>Jumlah Pinjaman</label>
        <input type="number" name="totalpinjaman" class="form-control" required="required" value="<?php echo $p['totalpinjaman']?>" <?php echo $p['totalpotongan']>0?'readonly':''?>>
        <?php if($p['totalpotongan'] > 0){ ?>
          <small class="text-danger">* Jumlah pinjaman tidak dapat diubah karena sudah ada potongan (cicilan).</small>
        <?php } ?>
      </div>
      <div class="form-group">
        <label>Keterangan</label>
        <textarea class="form-control" required="required" name="keterangan"><?php echo $p['keterangan']?></textarea>
      </div>
      <button type="submit" class="btn btn-info">Simpan</button>
      <a href="<?php echo BASEURL.'Pinjamancmt'?>" class="btn btn-danger text-white">Batal</a>
    </div>
  </div>
</form>
