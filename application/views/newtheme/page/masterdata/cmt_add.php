<form method="post" action="<?php echo $action?>">
  <div class="row">
    <div class="col-md-6">
                <div class="form-group">
                  <label>Nama CMT</label>
                  <input type="text" name="cmt_name" class="form-control" required>
                </div>
                <div class="form-group">
                  <label>No.Telephone</label>
                  <input type="text" name="telephone" class="form-control">
                </div>
                <div class="form-group">
                  <label>Jenis Pekerjaan</label>
                  <select name="cmt_job_desk" class="form-control select2bs4" required="required">
                    <option value=""></option>
                    <?php if(!isset($cmtcucian)){ ?>
                    <option value="JAHIT">JAHIT</option>
                    <option value="SABLON">SABLON</option>
                    <?php }else{ ?>
                      <option value="CUCIAN" selected>CUCIAN / LAUNDRY</option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group">
                  <label>Lokasi</label>
                  <select name="lokasi" class="form-control select2bs4" required="required" data-live-search="true">
                    <option value="">Pilih</option>
                    <?php foreach($lokasi as $l){?>
                      <option value="<?php echo $l['id']?>"><?php echo $l['lokasi']?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Jenis PO</label>
                  <select name="jenis_po" class="form-control select2bs4">
                    <option value="">Pilih</option>
                    <option value="1">Kaos</option>
                    <option value="2">Kemeja</option>
                    <option value="3">Kaos dan kemeja</option>
                    <option value="4">Celana</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>E-mail</label>
                  <input type="text" name="email" value="-" class="form-control">
                </div>
                <div class="form-group">
                  <label>Alamat</label>
                  <textarea name="alamat" class="form-control" rows="3"></textarea>
                </div>
                <div class="form-group">
                  <label>Keterangan</label>
                  <textarea name="keterangan" class="form-control" rows="5"></textarea>
                </div>
              </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <table class="table table-bordered" style="display: none;">
              <thead>
                <tr>
                  <th>Nama Pekerjaan</th>
                  <th>Harga</th>
                  <th align="right" class="text-right" style="text-align: right !important;"><a class="btn btn-info btn-xs text-white" onclick="addjob()"><i class="fa fa-plus"></i>&nbsp;Tambah</a></th>
                </tr>
              </thead>
              <tbody id="pekerjaancmt">
                
              </tbody>
            </table>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="text-right">
          <input type="submit" name="save" class="btn btn-info btn-sm text-white" value="Simpan">
          <a href="<?php echo $batal?>" class="btn btn-danger btn-sm text-white">Batal</a>
      </div>
    </div>
  </div>
</form>
<script type="text/javascript">
  var i=0;
  function addjob(){
    var html='';
    html+='<tr>';
    html+='<td><input type="text" name="products['+i+'][cmt_job_jenis]" class="form-control" required/></td>';
    html+='<td><input type="number" name="products['+i+'][cmt_job_price]" class="form-control" required/></td>';
    html+='<td><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button></td>';
    html+='</tr>';
    $("#pekerjaancmt").append(html);
    i++
  }

  $(document).on('click', '.remove', function(){

      $(this).closest('tr').remove();

  });
</script> 