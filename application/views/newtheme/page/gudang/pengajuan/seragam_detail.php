<div class="row">
    <div class="col-md-12 table-responsive">
      <table class="table table-bordered">
        <tr>
          <td colspan="11" align="center"><b>Kebutuhan <?php echo $k['kebutuhan']?></b></td>
        </tr>
        <!-- <tr>
          <td colspan="11" align="center"><b><?php echo $k['keterangan2']?></b></td>
        </tr> -->
        <tr>
          <td colspan="11">Tanggal : <?php echo date('d-m-Y',strtotime($k['tanggal']))?></td>
        </tr>
        <tr>
          <?php 
            $supplier=null;
            $supplier = $this->GlobalModel->GetDataRow('master_supplier',array('id' => $k['supplier_id']));
          ?>
          <td colspan="11">Supplier : <?php echo isset($supplier['nama']) ? $supplier['nama'] : '' ?></td>
        </tr>
        <tr>
          <td rowspan="2" style="vertical-align: middle;text-align: center;"><b>No</b></td>
          <td rowspan="2" style="vertical-align: middle;text-align: center;"><b>Nama PO</b></td>
          <td rowspan="2" style="vertical-align: middle;text-align: center;"><b>Jumlah PO</b></td>
          <td rowspan="2" style="vertical-align: middle;text-align: center;"><b>Rincian PO</b></td>
          <td colspan="2" style="vertical-align: middle;text-align: center;"><b>Jumlah PO</b></td>
          <td colspan="3" style="vertical-align: middle;text-align: center;"><b>Ajuan </b></td>
          <td rowspan="2" style="vertical-align: middle;text-align: center;"><b>Ket.Satuan</b></td>
          <td rowspan="2" style="vertical-align: middle;text-align: center;"><b>Ket</b></td>
        </tr>
        <tr>
          <td style="vertical-align: middle;text-align: center;font-weight: bold;">PCS</td>
          <td style="vertical-align: middle;text-align: center;font-weight: bold;">DZ</td>
          <td style="vertical-align: middle;text-align: center;font-weight: bold;">Kebutuhan</td>
          <td style="vertical-align: middle;text-align: center;font-weight: bold;">Stok</td>
          <td style="vertical-align: middle;text-align: center;font-weight: bold;">Ajuan</td>
        </tr>
        <?php $i=0;$pcs=0;$dz=0;$jmlpo=0;$n=1;?>
        <?php foreach($kd as $d){?>
          <tr>
            <td><?php echo $n++?></td>
            <td><?php echo $d['kode_po']?></td>
            <td><?php echo $d['jumlah_po']?> PO</td>
            <td><?php echo $d['rincian_po']?></td>
            <td><?php echo number_format($d['jml_pcs'],1)?></td>
            <td><?php echo number_format($d['jml_dz'],1)?></td>
            <td valign="middle" style="vertical-align: middle !important;text-align: center !important;"><?php echo ($d['jumlah_po']*$d['jml_pcs'])?></td>
            <?php if(0==$i){?>
            <td valign="middle" rowspan="<?php echo count($kd)?>" style="vertical-align: middle !important;text-align: center !important;"><?php echo $k['stok']?></td>
            <td valign="middle" rowspan="<?php echo count($kd)?>" style="vertical-align: middle !important;text-align: center !important;"><?php echo $k['jml_ajuan']?></td>
            <td valign="middle" rowspan="<?php echo count($kd)?>" style="vertical-align: middle !important;text-align: center !important;"><?php echo $k['keterangan2']?></td>
            <?php } ?>
            <!-- <td>lusinan <?php echo number_format($d['jml_dz'])?></td> -->
            <td><?php echo ($d['keterangan'])?></td>
          </tr>
          <?php $i++?>
          <?php 
            $pcs+=$d['jml_pcs'];
            $dz+=$d['jml_dz'];
            $jmlpo+=($d['jumlah_po']);
          ?>
        <?php } ?>
          <tr style="background-color: #ffe0fb">
            <td colspan="2"><b>Total</b></td>
            <td><b><?php echo $jmlpo?></b></td>
            <td></td>
            <td><b><?php echo $pcs?></b></td>
            <td><b><?php echo $dz?></b></td>
            <td align="center"><b><?php echo $k['ajuan_kebutuhan']?></b></td>
            <td><b><?php //echo $k['stok']?></b></td>
            <td><b><?php //echo $k['jml_ajuan']?></b></td>
            <td></td>
            <td></td>
          <tr>
            <td colspan="11" align="right"><b>Registered by Forboys Production System</b></td>
          </tr>
      </table>
    </div>
</div>
<form method="POST" action="<?php echo $acc?>" id="formAcc">
  <input type="hidden" name="id" value="<?php echo $k['id']?>">
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label>Jumlah Acc</label>
        <input type="text" name="jml_acc" value="<?php echo $k['jml_acc']?>" class="form-control">
      </div>
      <div class="form-group">
        <label>Acc Satuan</label>
        <input type="text" name="acc_satuan" value="<?php echo $k['acc_satuan']?>" class="form-control">
      </div>
      <div class="form-group">
        <label></label>
        <?php if($k['jml_acc'] == 0 && !isset($_GET['spv'])){ ?>
        <a href="#" class="btn btn-success full ttdDigital" data-toggle="modal" data-target="#detailModalTtd">Setujui</a>
        <?php } ?>
      </div>
    </div>
    <div class="col-md-3">
      
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <a href="<?php echo $cancel?>" class="btn btn-danger btn-sm no-print text-white">Cancel</a>
        <button class="btn btn-default btn-sm no-print" onclick="window.print()">Cetak</button>
        <a href="<?php echo $excel?>" class="btn btn-success btn-sm no-print text-white">Excel</a>
      </div>
    </div>
  </div>
</form>

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
            <div id="signature" style="width: 100%; height: 300px; border: 1px solid #000;margin-top:25px"></div>
            </div>
            <div class="modal-footer">
            
                <button id="clear_signature" class="btn btn-warning">Clear</button>
                <button id="save_signature" class="btn btn-primary">Save Signature</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo BASEURL?>jSignature/src/jSignature.js"></script>
<script>
	 $(document).ready(function() {
		$('#detailModalTtd').on('shown.bs.modal', function () {
			if (!$(this).data('jSignatureInitialized')) {
				$("#signature").jSignature();
				$(this).data('jSignatureInitialized', true);
			}
		});

		$('#clear_signature').click(function() {
           $("#signature").jSignature("reset");
       	});

		$('#save_signature').click(function() {
			var c= confirm('Apakah data sudah benar ?');
			if(c==true){
				var $btn = $(this);
				var originalText = $btn.html();
				$btn.html('<i class="fa fa-spinner fa-spin"></i> Menyimpan...').attr('disabled', true);

				var data = $("#signature").jSignature("getData", "image");
				var imgData = Array.isArray(data) ? data.join(",") : data;
				var form = $("#formAcc")[0];
				var formData = new FormData(form);
				formData.append('image_data', imgData);

				$.ajax({
					url: "<?php echo $acc ?>",
					type: "POST",
					data: formData,
					contentType: false,
					processData: false,
					success: function(response) {
						if (response.indexOf('successfully') !== -1 || response.indexOf('Berhasil') !== -1) {
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
						} else {
							$btn.html(originalText).attr('disabled', false);
							Swal({
								type: 'error',
								title: 'Gagal',
								text: response
							});
						}
					},
					error: function(xhr, status, error) {
						$btn.html(originalText).attr('disabled', false);
						Swal({
							type: 'error',
							title: 'Error',
							text: 'Gagal menyimpan tanda tangan: ' + error
						});
						console.log(xhr.responseText);
					}
				});
			}else{
				return false;
			}
		});
	 });
</script>