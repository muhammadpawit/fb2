<div class="row">
	<div class="col-md-4">
		<div class="form-group">
			<label>Tanggal Awal</label>
			<input type="text" name="tanggal1" id="tanggal1" value="<?php echo $tanggal1 ?>" class="form-control">
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label>Tanggal Akhir</label>
			<input type="text" name="tanggal2" id="tanggal2" value="<?php echo $tanggal2 ?>" class="form-control">
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label>Aksi</label><br>
			<?php if (isset($spv)) { ?>
				<button class="btn btn-info btn-sm" onclick="filtertglonlyspv()">Filter</button>
			<?php } else { ?>
				<button class="btn btn-info btn-sm" onclick="filtertglonly()">Filter</button>
			<?php } ?>
			<button class="btn btn-info btn-sm" onclick="filtertglonly_excel()">Excel</button>
			<a href="<?php echo $tambah ?>" class="btn btn-info btn-sm text-white">Tambah</a>
		</div>
	</div>
</div>
<div class="row table-responsive">
	<div class="col-md-12">
		<form method="POST" action="<?php echo $acc ?>" id="setujuiAll">
			<input type="hidden" name="bagian" value="<?php echo $type ?>">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>NO</th>
						<th>SUPPLIER</th>
						<th>TANGGAL AJUAN</th>
						<th>NAMA BARANG</th>
						<th>SATUAN</th>
						<th>KEBUTUHAN</th>
						<th>STOK</th>
						<th>AJUAN</th>
						<th>KETERANGAN</th>
						<th>ACC SPV</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php $no = 1; ?>
					<?php foreach ($prods as $p) { ?>

						<tr>
							<td><?php echo $p['no'] ?></td>
							<td><?php echo $p['supplier_nama'] ?></td>
							<td><?php echo $p['tgl'] ?></td>
							<td><?php echo $p['nama'] ?></td>
							<td><?php echo $p['satuan'] ?></td>
							<td><?php echo $p['kebutuhan'] ?></td>
							<td><?php echo $p['stok'] ?></td>
							<td><?php echo $p['ajuan'] ?></td>
							<td><?php echo $p['keterangan'] ?></td>
							<td>
								<?php if (!empty($spv)) { ?>
									<input type="hidden" hidden name="tanggal" value="<?php echo date('Y-m-d', strtotime($p['tanggal'])) ?>">
									<input type="hidden" name="prods[<?php echo $p['no'] ?>][id]" value="<?php echo $p['id'] ?>">
									<input type="hidden" name="prods[<?php echo $p['no'] ?>][product_id]" value="<?php echo $p['product_id'] ?>">
									<input type="hidden" name="prods[<?php echo $p['no'] ?>][satuan]" value="<?php echo $p['satuan'] ?>">
									<input type="hidden" name="prods[<?php echo $p['no'] ?>][supplier]" value="<?php echo $p['supplier_id'] ?>">
									<input type="hidden" name="prods[<?php echo $p['no'] ?>][keterangan]" value="<?php echo $p['keterangan'] ?>">
									<input type="number" name="prods[<?php echo $p['no'] ?>][acc_ajuan]" value="<?php echo ($p['acc_ajuan'] == 0) ? $p['ajuan'] : $p['acc_ajuan'] ?>">
									<input type="hidden" name="prods[<?php echo $p['no'] ?>][pembayaran]" value="<?php echo $p['pembayaran'] ?>">
								<?php } else { ?>
									<?php echo $p['acc_ajuan'] ?>
								<?php } ?>
							</td>

							<td>
								<?php if (!empty($spv)) { ?>
									<?php if ($p['acc_ajuan'] == 0) { ?>
										<!-- <button type="submit" class="btn btn-success">Disetujui</button> -->
									<?php } ?>
									<a href="<?php echo BASEURL . 'Ajuanalatalat/Ajuanalatalat_edit/' . $p['id'] ?>?&spv=true" class="btn btn-sm btn-warning">Detail</a>
								<?php } else { ?>
									<?php //if(aksesedit()==1){ 
									?>
									<a href="<?php echo BASEURL . 'Ajuanalatalat/Ajuanalatalat_edit/' . $p['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
									<?php  //}
									?>
									<?php //if(akseshapus()==1){ 
									?>
									<a href="<?php echo BASEURL . 'Ajuanalatalat/Ajuanalatalat_hapus/' . $p['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah yakin akan menghapus data ini ? ') ">Hapus</a>
									<?php  //}
									?>
								<?php } ?>
							</td>
						</tr>

						<?php $no++; ?>
					<?php } ?>
					<tr>
						<td colspan="8" align="right"></td>
						<td>
							<input type="hidden" name="tanggal" value="<?php echo $tanggal1 ?>" hidden>
							<a href="#" class="btn btn-primary full text-white ttdDigital" data-toggle="modal" data-target="#detailModalTtd">Setujui</a>
						</td>
						<td>
						</td>
					</tr>
				</tbody>
			</table>
		</form>
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
				<div id="signature" style="width: 100%; height: 300px; border: 1px solid #000;margin-top:25px"></div>
			</div>
			<div class="modal-footer">

				<button id="clear_signature">Clear</button>
				<button id="save_signature">Save Signature</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<script src="<?php echo BASEURL ?>jSignature/src/jSignature.js"></script>
<script>
	$(document).ready(function() {
		$('#detailModalTtd').on('shown.bs.modal', function() {
			if (!$(this).data('jSignatureInitialized')) {
				$("#signature").jSignature();
				$(this).data('jSignatureInitialized', true);
			}
		});

		$('#clear_signature').click(function() {
			$("#signature").jSignature("reset");
		});

		$('#save_signature').click(function() {
			var c = confirm('Apakah data sudah benar ?');
			if (c == true) {
				var $btn = $(this);
				var originalText = $btn.html();
				$btn.html('<i class="fa fa-spinner fa-spin"></i> Menyimpan...').attr('disabled', true);

				var data = $("#signature").jSignature("getData", "image");
				var imgData = Array.isArray(data) ? data.join(",") : data;
				var form = $("#setujuiAll")[0];
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
			} else {
				return false;
			}
		});
	});
	<?php if (isset($spv)) { ?>

		function filtertglonlyspv() {
			var url = '?spv=true';
			var tanggal1 = $("#tanggal1").val();
			var tanggal2 = $("#tanggal2").val();
			if (tanggal1) {
				url += '&tanggal1=' + tanggal1;
			}
			if (tanggal2) {
				url += '&tanggal2=' + tanggal2;
			}
			location = url;
		}
	<?php } ?>
</script>