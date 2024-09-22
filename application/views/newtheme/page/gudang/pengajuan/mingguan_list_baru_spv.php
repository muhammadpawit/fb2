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
      <label>Aksi</label><br>
      <a href="#" class="btn btn-primary full text-white ttdDigital" data-toggle="modal" data-target="#detailModalTtd">Setujui</a>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12 table-responsive">
    <table class="table table-bordered">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Barang</th>
                  <th>Jumlah Lapisan</th>
                  <th>Jumlah Dz </th>
                  <th>Jumlah Per Baju </th>
                  <th>Jumlah Per Cons</th>
                  <th>Rincian</th>
                  <th>Kebutuhan</th>
                  <th>Stok</th>
                  <th>Ajuan</th>
                  <th>Rincian</th>
                </tr>
              </thead>
              <tbody>
                <?php $n=1;?>
                <form id="setujuiAll" method="POST" enctype="multipart/form-data">
                  <?php if($products){?>
                    <?php foreach($products as $p){?>
                      <input type="hidden" name="prods[<?php echo $n ?>][id]" value="<?php echo $p['id']?>">
                      <input type="hidden" name="prods[<?php echo $n ?>][product_id]" value="<?php echo $p['nama_barang']?>">
                      <input type="hidden" name="prods[<?php echo $n ?>][keterangan2]" value="<?php echo $p['rincian'].' '.$p['rincian_ajuan']?>">
                      <input type="hidden" name="prods[<?php echo $n ?>][jml_acc]" value="<?php echo $p['ajuan']?>">
                      <tr>
                        <td><?php echo $n?></td>
                        <td><?php echo strtolower($p['nama_produk'])?></td>
                        <td><?php echo strtolower($p['jumlah_lapisan'])?></td>
                        <td><?php echo ($p['jumlah_dz'])?></td>
                        <td><?php echo $p['jumlah_per_baju']?></td>
                        <td><?php echo $p['jumlah_per_cons']?></td>
                        <td><?php echo $p['rincian']?></td>
                        <td><?php echo strtolower($p['kebutuhan'])?></td>
                        <td><?php echo strtolower($p['stok'])?></td>
                        <td><?php echo strtolower($p['ajuan'])?></td>
                        <td><?php echo strtolower($p['rincian_ajuan'])?></td>
                      </tr>
                      <?php $n++;?>
                    <?php }?>
                  <?php }?>
                </form>
              </tbody>
            </table>
  </div>
</div>
<div class="modal fade" id="detailModalTtd" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Persetujuan Digital</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="signatureModal">
            <div id="signatures" style="width: 100%; height: 300px; border: 1px solid #000;margin-top:25px"></div>
            </div>
            <div class="modal-footer">
            
                <button class="btn btn-primary" id="clear_signature">Clear</button>
                <button class="btn btn-primary" id="save_signature">Save Signature</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo BASEURL?>jSignature/src/jSignature.js"></script>
<script>
	 $(document).ready(function() {
		// $("#signatures").jSignature();
		$('#detailModalTtd').on('shown.bs.modal', function () {
			$("#signature").jSignature(); // Inisialisasi jSignature setelah modal ditampilkan
			$("#signatures").jSignature();
		});

		$('#clear_signature').click(function() {
           $("#signatures").jSignature("reset");
       	});

		$('#save_signature').click(function() {
			var c= confirm('Apakah data sudah benar ?');
			if(c==true){
				   
        var datapair = $("#signatures").jSignature("getData", "image");
        var imgData = datapair[1];
        // var idajuan = $("#idajuan").val();
        var form = $("#setujuiAll")[0]; // Mengambil elemen form

        // Membuat FormData dari form yang ada
        var formData = new FormData(form);

        // Menambahkan data tambahan ke FormData
        formData.append('image_data', imgData);
        // formData.append('id', idajuan);

        $.ajax({
            url: "<?= BASEURL ?>Ajuankemejabaru/setujui",
            type: "POST",
            data: formData,
            contentType: false, // Jangan set tipe konten secara otomatis
            processData: false, // Jangan proses data, biarkan FormData yang menangani
            success: function(response) {
                // alert('Signature saved successfully!');
                // Bisa reload atau tindakan lain sesuai kebutuhan
                console.log(response);
                // window.location.href = "<?= BASEURL ?>Gudang/pengajuancetak/" + response;
            }
        });

			}else{
				return false;
			}
			
			
		});
	 });
</script>