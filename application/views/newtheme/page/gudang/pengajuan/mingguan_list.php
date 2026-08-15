<div class="row">
  <div class="col-md-12">
    <?php if ($this->session->flashdata('msg')) { ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
    <?php echo $this->session->flashdata('msg'); ?> 
    </div>
    <?php } ?>
  </div>
</div>
<div class="row">
  <div class="col-md-3">
    <div class="form-group">
      <label>Tanggal Awal</label>
      <input type="text" name="tanggal1" id="tanggal1" value="<?php echo isset($tanggal1) ? $tanggal1 : '' ?>" class="form-control">
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>Tanggal Akhir</label>
      <input type="text" name="tanggal2" id="tanggal2" value="<?php echo isset($tanggal2) ? $tanggal2 : '' ?>" class="form-control">
    </div>
  </div>
  <div class="col-md-3">
              <div class="form-group">
                <label>Bagian</label>
                <select name="jenis" class="form-control select2bs4" required="required">
                  <option value="">Pilih</option>
                  <option value="1" <?php echo (isset($cat) && $cat==1)?'selected':''; ?>>Konveksi</option>
                  <option value="2" <?php echo (isset($cat) && $cat==2)?'selected':''; ?>>Bordir</option>
                  <option value="3" <?php echo (isset($cat) && $cat==3)?'selected':''; ?>>Sablon</option>
                </select>
              </div>
            </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>Aksi</label><br>
      <button class="btn btn-info btn-sm" onclick="filterwithbagian()">Filter</button>
      <button class="btn btn-info btn-sm" onclick="excelnya()">Excel</button>
      <?php if(isset($tambah) && !empty($tambah)){ ?>
        <a href="<?php echo $tambah?>" class="btn btn-info btn-sm text-white">Tambah</a>
      <?php } ?>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <table class="table table-bordered" id="datatable">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Tanggal</th>
                  <th>Kebutuhan</th>
                  <th>Satuan</th>
                  <th>Stok</th>
                  <th>Jumlah Ajuan</th>
                  <th>Jumlah ACC</th>
                  <th>Acc Satuan</th>
                  <th>Status ACC</th>
                  <th>Keterangan</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php if(isset($products) && $products){?>
                  <?php foreach($products as $p){?>
                    <tr>
                      <td><?php echo $n++?></td>
                      <td><?php echo $p['tanggal']?></td>
                      <td><?php echo strtolower($p['kebutuhan'])?></td>
                      <td><?php echo ($p['satuan'])?></td>
                      <td><?php echo $p['stok']?></td>
                      <td><?php echo $p['jml_ajuan']?></td>
                      <td>
                        <?php if($p['jml_acc'] > 0){ ?>
                          <span class="badge badge-success p-1"><?php echo $p['jml_acc']?></span>
                        <?php } else { ?>
                          <?php echo $p['jml_acc']?>
                        <?php } ?>
                      </td>
                      <td><?php echo $p['acc_satuan']?></td>
                      <td>
                        <?php if($p['jml_acc'] > 0){ ?>
                          <span class="badge badge-success"><i class="fa fa-check"></i> ACC</span>
                        <?php } else { ?>
                          <span class="badge badge-warning"><i class="fa fa-clock-o"></i> Belum ACC</span>
                        <?php } ?>
                      </td>
                      <td><?php echo strtolower($p['keterangan2'])?></td>
                      <td>
                        <a href="<?php echo $p['edit']?>" class="btn btn-info btn-xs text-white">edit</a>
                        <a href="<?php echo $p['detail']?>" class="btn btn-warning btn-xs text-white">Acc / detail</a>
                        <a href="<?php echo $p['excel']?>" class="btn btn-success btn-xs text-white">excel</a>
                        <a href="<?php echo $p['bataladmin']?>" onclick="return confirm('Apakah yakin ajuan ini akan dibatalkan ?')" class="btn btn-danger btn-xs text-white">Hapus</a>
                      </td>
                    </tr>
                  <?php }?>
                <?php }?>
              </tbody>
            </table>
  </div>
</div>
<script type="text/javascript">
  
  function filterwithbagian(){
    var url='?';
    var tanggal1 =$("#tanggal1").val();
    var tanggal2 =$("#tanggal2").val();
    if(tanggal1){
      url+='&tanggal1='+tanggal1;
    }
    if(tanggal2){
      url+='&tanggal2='+tanggal2;
    }

     var filter_status = $('select[name=\'jenis\']').val();

        if (filter_status != '*') {
            url += '&cat=' + encodeURIComponent(filter_status);
        }

      //console.log(filter_status);

    location =url;
  }

  function excelnya(){
    var url='<?php echo $urlexcel ?>?';
    var tanggal1 =$("#tanggal1").val();
    var tanggal2 =$("#tanggal2").val();
    if(tanggal1){
      url+='&tanggal1='+tanggal1;
    }
    if(tanggal2){
      url+='&tanggal2='+tanggal2;
    }

     var filter_status = $('select[name=\'jenis\']').val();

        if (filter_status != '*') {
            url += '&cat=' + encodeURIComponent(filter_status);
        }

      //console.log(filter_status);

    location =url;
  }
</script>