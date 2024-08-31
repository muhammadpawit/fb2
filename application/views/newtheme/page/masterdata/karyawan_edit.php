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
          <div class="form-group">
            <label>Bank</label>
              <select name="bank" class="form-control select2bs4" style="width:100%" required="required">
                <option value="">Pilih</option>
                <option value="bca" <?php echo $products['bank']=='bca'?'selected':'';?>>Bank Central Asia (BCA)</option>
                <option value="bri" <?php echo $products['bank']=='bri'?'selected':'';?>>Bank Rakyat Indonesia (BRI)</option>
                <option value="bni" <?php echo $products['bank']=='bni'?'selected':'';?>>Bank Negara Indonesia (BNI)</option>
                <option value="mandiri" <?php echo $products['bank']=='mandiri'?'selected':'';?>>Bank Mandiri</option>
                <option value="btn" <?php echo $products['bank']=='btn'?'selected':'';?>>Bank Tabungan Negara (BTN)</option>
                <option value="cimb" <?php echo $products['bank']=='cimb'?'selected':'';?>>CIMB Niaga</option>
                <option value="danamon" <?php echo $products['bank']=='danamon'?'selected':'';?>>Bank Danamon</option>
                <option value="panin" <?php echo $products['bank']=='panin'?'selected':'';?>>Panin Bank</option>
                <option value="permata" <?php echo $products['bank']=='permata'?'selected':'';?>>Bank Permata</option>
                <option value="ocbc" <?php echo $products['bank']=='ocbc'?'selected':'';?>>OCBC NISP</option>
                <option value="bukopin" <?php echo $products['bank']=='bukopin'?'selected':'';?>>Bank Bukopin</option>
                <option value="maybank" <?php echo $products['bank']=='maybank'?'selected':'';?>>Maybank Indonesia</option>
                <option value="mega" <?php echo $products['bank']=='mega'?'selected':'';?>>Bank Mega</option>
                <option value="sinarmas" <?php echo $products['bank']=='sinarmas'?'selected':'';?>>Bank Sinarmas</option>
                <option value="bjb" <?php echo $products['bank']=='bjb'?'selected':'';?>>Bank BJB</option>
                <option value="jatim" <?php echo $products['bank']=='jatim'?'selected':'';?>>Bank Jatim</option>
                <option value="jateng" <?php echo $products['bank']=='jateng'?'selected':'';?>>Bank Jateng</option>
                <option value="muamalat" <?php echo $products['bank']=='muamalat'?'selected':'';?>>Bank Muamalat</option>
                <option value="syariahmandiri" <?php echo $products['bank']=='syariahmandiri'?'selected':'';?>>Bank Syariah Mandiri</option>
                <option value="bri_syariah" <?php echo $products['bank']=='bri_syariah'?'selected':'';?>>BRI Syariah</option>
            </select>
          </div>
          <div class="form-group">
            <label>Atas Nama</label>
            <input type="text" name="atas_nama" value="<?php echo $products['atas_nama']?>" class="form-control" required="required">
          </div>
          <div class="form-group">
            <label>No.Rek</label>
            <input type="text" name="no_rek" class="form-control" value="<?php echo $products['no_rek']?>" required="required">
          </div>
          <?php if($products['status_resign']==2){?>
          <div class="form-group" id="tglkeluar">
          <?php }else{ ?>
          <div class="form-group" id="tglkeluar" style="display: none">
          <?php } ?>
            <label>Tanggal Keluar / Tanggal resign</label>
            <input type="text" name="tglkeluar" value="<?php echo $products['tglkeluar']?>" class="form-control datepicker">
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