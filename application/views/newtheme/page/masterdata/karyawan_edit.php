<form method="post" action="<?php echo $action?>">
<div class="table-responsive">
            <input type="hidden" name="id" value="<?php echo $products['id']?>">
          <div class="form-group">
            <label>Tanggal Masuk</label>
            <input type="text" name="tglmasuk" class="form-control datepicker" value="<?php echo $products['tglmasuk']?>" required="required">
          </div>
          <div class="form-group">
            <label>Nomor Induk Karyawan</label>
            <input type="text" name="nik" value="<?php echo $products['nik']?>" class="form-control" required="required">
          </div>
          <div class="form-group">
            <label>Nama Karyawan</label>
            <input type="text" name="nama" value="<?php echo $products['nama']?>" class="form-control" required="required">
          </div>
          <div class="form-group">
            <label>Jenis Kelamin</label>
            <select name="jk" class="form-control select2bs4" required="required" data-live-search="true">
              <option value="">Pilih</option>
              <option value="PRIA" <?php echo $products['jk']=="PRIA"?'selected':'';?>>Pria</option>
              <option value="WANITA" <?php echo $products['jk']=="WANITA"?'selected':'';?> >Wanita</option>
            </select>
          </div>
          <div class="form-group">
            <label>Divisi </label>
            <select name="divisi" class="form-control select2bs4" required="required" data-live-search="true">
              <option value="">Pilih</option>
              <?php foreach($divisi as $j){?>
              <option value="<?php echo $j['id']?>" <?php echo $products['divisi']==$j['id']?'selected':'';?>><?php echo $j['nama']?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label>Jabatan </label>
            <select name="jabatan" class="form-control select2bs4" required="required" data-live-search="true">
              <option value="">Pilih</option>
              <?php foreach($jabatan as $j){?>
              <option value="<?php echo $j['id']?>" <?php echo $products['jabatan']==$j['id']?'selected':'';?>><?php $jab=strtolower(ucwords($j['nama'])); echo ucwords($jab)?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label>Gaji Pokok</label>
            <input type="number" name="gajipokok" class="form-control" value="<?php echo $products['gajipokok']?>" required="required">
          </div>
          <div class="form-group">
            <label>Status</label>
            <select name="status_resign" class="form-control select2bs4" id="tglkeluars" data-live-search="true">
              <option value="1" <?php echo $products['status_resign']==1?'selected':'';?>>Aktif</option>
              <option value="2" <?php echo $products['status_resign']==2?'selected':'';?>>Non-aktif / Resign</option>
            </select>
          </div>
          <?php if($products['status_resign']==2){?>
          <div class="form-group" id="tglkeluar">
          <?php }else{ ?>
          <div class="form-group" id="tglkeluar" style="display: none">
          <?php } ?>
            <label>Tanggal Keluar</label>
            <input type="date" name="tglkeluar" value="<?php echo $products['tglkeluar']?>" class="form-control">
          </div>
          <button type="submit" class="btn btn-info">Simpan</button>
          <a class="btn btn-danger text-white" href="<?php echo $batal?>">Batal</a>
</div>        
</form>
<script type="text/javascript">
  $('#tglkeluars').change(function(){
    var v=$(this).val();
    if(v==1){
      $("#tglkeluar").hide();
    }else{
      $("#tglkeluar").show();
    }
})
</script>  