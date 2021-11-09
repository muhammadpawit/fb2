      <!-- Default box -->
      <form method="post" action="<?php echo $action?>">
      <div class="card card-info">
        <div class="card-header">
          <h3 class="card-title">Edit Data cmt</h3>

          <div class="card-tools">
            <!-- <span class="pull-right"><a href="" class="btn btn-sm btn-primary">Tambah</a></span> -->
          </div>
        </div>
        <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Nama CMT</label>
                   <input type="hidden" name="id_cmt" class="form-control" value="<?php echo $cmt['id_cmt']?>" required>
                  <input type="text" name="cmt_name" class="form-control" value="<?php echo $cmt['cmt_name']?>" required>
                </div>
                <div class="form-group">
                  <label>No.Telephone</label>
                  <input type="text" name="telephone" value="<?php echo $cmt['telephone']?>" class="form-control">
                </div>
                <div class="form-group">
                  <label>Jenis Pekerjaan</label>
                  <select name="cmt_job_desk" class="form-control select2bs4" required="required">
                    <option value=""></option>
                    <option value="JAHIT" <?php echo $cmt['cmt_job_desk']=='JAHIT'?'selected':'';?>>Jahit</option>
                    <option value="SABLON" <?php echo $cmt['cmt_job_desk']=='SABLON'?'selected':'';?>>Sablon</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Lokasi</label>
                  <select name="lokasi" class="form-control select2bs4" required="required" data-live-search="true">
                    <option value="">Pilih</option>
                    <?php foreach($lokasi as $l){?>
                      <option value="<?php echo $l['id']?>" <?php echo $cmt['lokasi']==$l['id']?'selected':'';?>><?php echo $l['lokasi']?></option>
                    <?php } ?>
                  </select>
                  <!--
                  <label>Lokasi</label>
                  <select name="lokasi" class="form-control select2bs4">
                    <option value="">Pilih</option>
                    <option value="4" <?php echo $cmt['lokasi']==4?'selected':'';?>>Pusat</option>
                    <option value="1" <?php echo $cmt['lokasi']==1?'selected':'';?>>Serang</option>
                    <option value="2" <?php echo $cmt['lokasi']==2?'selected':'';?>>Jawa</option>
                    <option value="3" <?php echo $cmt['lokasi']==3?'selected':'';?>>Sukabumi</option>
                  </select>-->
                </div>
                <div class="form-group">
                  <label>Bank</label>
                  <input type="text" name="bank" class="form-control" value="<?php echo $cmt['bank']?>">
                </div>
                <div class="form-group">
                  <label>Atas Nama</label>
                  <input type="text" name="an" class="form-control" value="<?php echo $cmt['an']?>">
                </div>
                <div class="form-group">
                  <label>Nomor Rekening</label>
                  <input type="text" name="norek" class="form-control" value="<?php echo $cmt['norek']?>">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Jenis PO</label>
                  <select name="jenis_po" class="form-control select2bs4">
                    <option value="">Pilih</option>
                    <option value="1" <?php echo $cmt['jenis_po']==1?'selected':'';?>>Kaos</option>
                    <option value="2" <?php echo $cmt['jenis_po']==2?'selected':'';?>>Kemeja</option>
                    <option value="3" <?php echo $cmt['jenis_po']==3?'selected':'';?>>Kaos dan kemeja</option>
                    <option value="4" <?php echo $cmt['jenis_po']==4?'selected':'';?>>Celana</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>E-mail</label>
                  <input type="text" name="email" value="<?php echo $cmt['email']?>" class="form-control">
                </div>
                <div class="form-group">
                  <label>Alamat</label>
                  <textarea name="alamat" class="form-control" rows="5"><?php echo $cmt['alamat']?></textarea>
                </div>
                <div class="form-group">
                  <label>Keterangan</label>
                  <textarea name="keterangan" class="form-control" rows="5"><?php echo $cmt['keterangan']?></textarea>
                </div>
              </div>
            </div>
            <table class="table table-bordered" style="display: none;">
              <thead>
                <tr>
                  <th>Nama Pekerjaan</th>
                  <th>Harga</th>
                  <th align="right" class="text-right" style="text-align: right !important;"><a class="btn btn-info btn-xs text-white" onclick="addjob()"><i class="fa fa-plus"></i>&nbsp;Tambah</a></th>
                </tr>
              </thead>
              <tbody id="pekerjaancmt">
                  <?php if(isset($jobcmt)){?>
                    <?php $ij=0;?>
                    <?php foreach($jobcmt as $j){?>
                      <tr>
                        <td><input type="text" name="prd[<?php echo $ij?>][cmt_job_jenis]" value="<?php echo $j['cmt_job_jenis']?>" class="form-control"></td>
                        <td><input type="number" name="prd[<?php echo $ij?>][cmt_job_price]" value="<?php echo $j['cmt_job_price']?>" class="form-control"></td>
                        <td><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button></td>
                      </tr>
                      <?php $ij++?>
                    <?php }?>
                  <?php } ?>
              </tbody>
            </table>
        </div>
        <!-- /.card-body -->
        <div class="card-footer text-right">
          <input type="submit" name="save" class="btn btn-info text-white" value="Simpan">
        </div>
        <!-- /.card-footer-->
      </div>
    </form>
      <!-- /.card -->
<script type="text/javascript">
  var jc='<?php echo $ij?>';
  function addjob(){
    var html='';
    html+='<tr>';
    html+='<td><input type="text" name="prd['+jc+'][cmt_job_jenis]" class="form-control" required/></td>';
    html+='<td><input type="number" name="prd['+jc+'][cmt_job_price]" class="form-control" required/></td>';
    html+='<td><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button></td>';
    html+='</tr>';
    jc++;
    $("#pekerjaancmt").append(html);
  }

  $(document).on('click', '.remove', function(){

      $(this).closest('tr').remove();

  });
</script> 