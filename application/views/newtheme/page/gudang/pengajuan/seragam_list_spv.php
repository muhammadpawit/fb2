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
    <form method="POST" action="<?php echo BASEURL?>Gudang/ajuanmingguanaccseragamall" id="setujuiAll">
    <table class="table table-bordered">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Tanggal</th>
                  <th>Kebutuhan</th>
                  <th>Satuan</th>
                  <th>Jumlah Ajuan</th>
                  <th>Jumlah ACC</th>
                  <th>Acc Satuan</th>
                  <th>Keterangan</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php $i=0;?>
                <?php if($products){?>
                  <?php foreach($products as $p){?>
                    <input type="hidden" name="prods[<?php echo $i ?>][id]" value="<?php echo $p['id']?>">
                    <input type="hidden" hidden name="prods[<?php echo $i ?>][tanggal]" value="<?php echo date('Y-m-d',strtotime($p['tanggal'])) ?>">
                    <tr>
                      <td><?php echo $n++?></td>
                      <td><?php echo $p['tanggal'] ?></td>
                      <td><?php echo strtolower($p['kebutuhan'])?></td>
                      <td><?php echo $p['satuan']?></td>
                      <td><?php echo $p['jml_ajuan']?></td>
                      <td><input type="number" name="prods[<?php echo $i ?>][jml_acc]" value="<?php echo $p['jml_acc']=='0' ? $p['jml_ajuan'] : $p['jml_acc']?>"></td>
                      <td><input type="text" name="prods[<?php echo $i ?>][acc_satuan]" value="<?php echo $p['jml_acc']=='0' ? $p['jml_ajuan'] : $p['jml_acc']?>"></td>
                      <td><input type="hidden" name="prods[<?php echo $i ?>][keterangan]" value="<?php echo $p['keterangan2']?>"><?php echo strtolower($p['keterangan2'])?></td>
                      <td>
                        <a href="<?php echo $p['detail']?>?&spv=true" class="btn btn-warning btn-xs text-white">Detail</a>
                        <a href="<?php echo $p['batal']?>?&spv=true" onclick="return confirm('Apakah yakin ajuan ini akan dibatalkan ?')" class="btn btn-danger btn-xs text-white">Hapus</a>
                      </td>
                    </tr>
                    <?php $i++; ?>
                  <?php }?>
                <?php }?>
                <tr>
                  <td colspan="5" align="right"><?php echo !empty($tgl_diacc ) ? 'diacc terkahir pada '.$tgl_diacc :''?></td>
                  <td colspan="2">
                    <input type="hidden" name="tanggal" value="<?php echo $tanggal1?>" hidden>
                  </td>
                  <td>
                  </td>
                </tr>
              </tbody>
            
            </table>
            </form>
  </div>
</div>

<div class="row">
  <div class="col-md-4 ">
    <label>Tanda Tangan SPV</label>
    <div id="signature" style="border: 1px solid #ccc; background-color: #f9f9f9; width: 100%; height: 200px;"></div>
    <div style="margin-top: 10px;">
        <button id="clear_signature" class="btn btn-warning btn-sm">Clear</button>
        <button id="save_signature_ttd" class="btn btn-primary btn-sm">Save TTD</button>
    </div>
  </div>
</div>
<script src="<?php echo BASEURL?>jSignature/src/jSignature.js"></script>
<script>
  
  $('#save_signature_ttd').click(function() {
			var c= confirm('Apakah data sudah benar ?');
			if(c==true){
				   
        var data = $("#signature").jSignature("getData", "image");
        var imgData = Array.isArray(data) ? data.join(",") : data;
        var form = $("#setujuiAll")[0]; 

        var formData = new FormData(form);
        formData.append('image_data', imgData);

        $.ajax({
            url: "<?= BASEURL ?>Gudang/ajuanmingguanaccseragamall",
            type: "POST",
            data: formData,
            contentType: false, 
            processData: false, 
            success: function(response) {
                if(response.indexOf('Failed') !== -1){
                    Swal({
                        type: 'error',
                        title: 'Gagal',
                        text: response
                    });
                }else{
                    Swal({
                        type: 'success',
                        title: 'Berhasil',
                        text: 'Signature saved successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                }
            },
            error: function(xhr) {
                Swal({
                    type: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan: ' + xhr.statusText
                });
            }
        });

			}else{
				return false;
			}
			
		});

  $(document).ready(function(){
    $("#signature").jSignature();
		$('#clear_signature').click(function() {
           $("#signature").jSignature("reset");
       	});
  });

  function filterwithbagian(){
    var url='?&spv=true';
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

    location =url;
  }
</script>