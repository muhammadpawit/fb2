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
                  <th>Acc Satuan</th>
                  <th>Keterangan</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php $i=0; $n=1; ?>
                <?php if($products){?>
                  <form id="setujuiAll" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="tanggal" value="<?php echo $tanggal1?>" hidden>
                    <?php foreach($products as $p){?>
                    <input type="hidden" name="prods[<?php echo $i ?>][id]" value="<?php echo $p['id']?>">
                    <input type="hidden" name="prods[<?php echo $i ?>][tanggal]" value="<?php echo $p['tanggal']?>">
                    <tr>
                      <td><?php echo $n++?></td>
                      <td><?php echo date('d-m-Y',strtotime($p['tanggal']))?></td>
                      <td><?php echo strtolower($p['kebutuhan'])?></td>
                      <td><?php echo $p['satuan']?></td>
                      <td><?php echo $p['jml_ajuan']?></td>
                      <td><input type="number" name="prods[<?php echo $i ?>][jml_acc]" value="<?php echo $p['jml_acc']=='0' ? $p['jml_ajuan'] : $p['jml_acc']?>"></td>
                      <td><input type="text" name="prods[<?php echo $i ?>][acc_satuan]" value="<?php echo empty($p['acc_satuan']) ? $p['jml_ajuan'] : $p['acc_satuan']?>"></td>
                      <td><?php echo strtolower($p['keterangan2'])?></td>
                      <td>
                        <a href="<?php echo $p['detail']?>?&spv=true" class="btn btn-warning btn-xs text-white">Detail</a>
                        <a href="<?php echo $p['batal']?>?&spv=true" onclick="return confirm('Apakah yakin ajuan ini akan dibatalkan ?')" class="btn btn-danger btn-xs text-white">Hapus</a>
                      </td>
                    </tr>
                    <?php $i++; ?>
                  <?php }?>
                  </form>
                <?php }?>
                <tr>
                  <td colspan="5" align="right"><?php echo !empty($tgl_diacc ) ? 'diacc terkahir pada '.$tgl_diacc :''?></td>
                  <td colspan="4"></td>
                </tr>
              </tbody>
            
            </table>
  </div>
  </div>
</div>

<?php if(!empty($products)){ ?>
<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Persetujuan Digital</h5>
            </div>
            <div class="card-body">
                <div id="signatures" style="width: 100%; height: 200px; border: 1px solid #000; margin-bottom: 15px;"></div>
                <button class="btn btn-warning" id="clear_signature">Bersihkan Tanda Tangan</button>
                <button class="btn btn-success" id="save_signature">Simpan & Setujui</button>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<script src="<?php echo BASEURL?>jSignature/src/jSignature.js"></script>
<script>
	 $(document).ready(function() {
		$("#signatures").jSignature();

		$('#clear_signature').click(function() {
           $("#signatures").jSignature("reset");
       	});

		$('#save_signature').click(function() {
			var c= confirm('Apakah data sudah benar ?');
			if(c==true){
        var data = $("#signatures").jSignature("getData", "image");
        var imgData = Array.isArray(data) ? data.join(",") : data;
        var form = $("#setujuiAll")[0]; // Mengambil elemen form

        var formData = new FormData(form);
        formData.append('image_data', imgData);

        $.ajax({
            url: "<?= BASEURL ?>Ajuankemejabaru/setujui",
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
                        timer: 1000
                    });
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
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
    var url='<?php echo BASEURL?>Ajuankemejabaru/excel_all?';
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