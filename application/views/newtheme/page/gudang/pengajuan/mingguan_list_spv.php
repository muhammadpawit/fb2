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
      <input type="text" name="tanggal1" id="tanggal1" value="<?php echo $tanggal1?>" class="form-control">
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>Tanggal Akhir</label>
      <input type="text" name="tanggal2" id="tanggal2" value="<?php echo $tanggal2?>" class="form-control">
    </div>
  </div>
  <div class="col-md-3">
              <div class="form-group">
                <label>Bagian</label>
                <select name="jenis" class="form-control select2bs4" required="required">
                  <option value="">Pilih</option>
                  <option value="1" <?php echo $cat==1?'selected':''; ?>>Konveksi</option>
                  <option value="2" <?php echo $cat==2?'selected':''; ?>>Bordir</option>
                  <option value="3" <?php echo $cat==3?'selected':''; ?>>Sablon</option>
                </select>
              </div>
            </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>Aksi</label><br>
      <button class="btn btn-info btn-sm" onclick="filterwithbagian()">Filter</button>
      <button class="btn btn-info btn-sm" onclick="excelnya()">Excel</button>
      <a href="<?php echo $tambah?>" class="btn btn-info btn-sm text-white">Tambah</a>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12 table-responsive">
    <table class="table table-bordered">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Tanggal</th>
                  <th>Kebutuhan</th>
                  <th>Satuan</th>
                  <th>Jumlah Ajuan</th>
                  <th>Jumlah ACC</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php if($products){?>
                  <?php foreach($products as $p){?>
                    <form method="POST" action="<?php echo BASEURL?>Gudang/acc_ajuan_mingguan">
                    <input type="hidden" name="id" value="<?php echo $p['id']?>">
                    <input type="hidden" hidden name="tanggal" value="<?php echo $p['tanggal']?>">
                    <tr>
                      <td><?php echo $n++?></td>
                      <td><?php echo date('d-m-Y',strtotime($p['tanggal']))?></td>
                      <td><?php echo strtolower($p['kebutuhan'])?></td>
                      <td><?php echo $p['satuan']?></td>
                      <td><?php echo $p['jml_ajuan']?></td>
                      <td><input type="number" name="jml_acc" value="<?php echo $p['jml_acc']?>"></td>
                      <td>
                        
                        <!-- <input type="button" name="view" value="Acc" data-id="<?php echo $p["id"]; ?>" class="btn btn-xs btn-primary view_data"> -->
                        
                        <button class="btn btn-success btn-xs">Disetujui</button>

                        <a href="<?php echo $p['detail']?>?&spv=true" class="btn btn-warning btn-xs text-white">Detail</a>

                        <a href="<?php echo $p['batal']?>?&spv=true" onclick="return confirm('Apakah yakin ajuan ini akan dibatalkan ?')" class="btn btn-danger btn-xs text-white">Hapus</a>
                      </td>
                    </tr>
                    </form>
                  <?php }?>
                <?php }?>
                <!-- <tr>
                  <td colspan="4" align="right"><?php echo !empty($tgl_diacc ) ? 'diacc terkahir pada '.$tgl_diacc :'belum di klik persetujuan'?></td>
                  <td>
                    <form method="POST" action="<?php echo BASEURL?>Gudang/acc_ajuan_mingguan">
                    <input type="hidden" name="tanggal" value="<?php echo $tanggal1?>" hidden>
                    <button type="submit" class="btn btn-success btn-sm full">Disetujui</button>
                    </form>
                  </td>
                  <td>
                  <form method="POST" action="<?php echo BASEURL?>Gudang/acc_ajuan_mingguan_batal">
                    <input type="hidden" name="tanggal" value="<?php echo $tanggal1?>" hidden>
                    <button type="submit" class="btn btn-danger btn-sm full">Dibatalkan</button>
                    </form>
                  </td>
                </tr> -->
              </tbody>
            
            </table>
  </div>
</div>
<!-- <div class="row">
  <div class="col-md-6">
    <form method="POST" action="<?php echo BASEURL?>Gudang/setujualat_all">
        <div class="form-group">
          <label>Persetujuan</label>
          <input type="number" class="form-control">
        </div>
    </form>
  </div>
</div> -->
<div id="dataModal" class="modal fade">  
    <div class="modal-dialog">  
         <div class="modal-content">  
              <div class="modal-header">  
                   <h4 class="modal-title">Detail User</h4>  
              </div>  
              <div class="modal-body" id="detail_user">  
              </div>  
              <div class="modal-footer">  
                   <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
              </div>  
         </div>  
    </div>  
</div> 
<script type="text/javascript">
  
  $(document).ready(function(){
    $('.view_data').click(function(){
      var data_id = $(this).data("id");
      //alert(data_id);
      $.ajax({
        url: '<?php echo BASEURL?>Gudang/getjsonajuanmingguan',
        method: "POST",
        data: {data_id: data_id},
        success: function(data){
          $("#detail_user").html(data)
          $("#dataModal").modal('show')
        }
      })
    })
  })

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
    var url='<?php echo BASEURL?>Gudang/ajuanmingguan_excel_all?';
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