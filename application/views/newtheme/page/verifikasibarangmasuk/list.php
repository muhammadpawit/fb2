<?php if (empty($sel_supplier)) { ?>
	<div class="alert alert-warning">
		<b>Perhatian:</b> Silakan pilih filter Supplier terlebih dahulu jika Anda ingin menyimpan/verifikasi barang masuk ke Gudang.
	</div>
<?php } ?>
<div class="row">
	<div class="col-md-4">
		<div class="form-group">
			<label>Supplier</label>
			<select name="filter_supplier" id="supplier" class="form-control select2bs4" data-live-search="true">
				<option value="">Semua Supplier</option>
				<?php foreach ($supplier as $s) { ?>
					<option value="<?php echo $s['id'] ?>" <?php echo $sel_supplier == $s['id'] ? 'selected' : '' ?>><?php echo $s['nama'] ?></option>
				<?php } ?>
			</select>
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label>Aksi</label><br>
			<button class="btn btn-info btn-sm" onclick="filter()">Filter</button>
		</div>
	</div>
</div>

<form action="<?php echo BASEURL ?>Verifikasibarangmasuk/simpan" method="POST" id="formSimpan">
	<input type="hidden" name="supplier" value="<?php echo $sel_supplier ?>">
	<input type="hidden" name="jenis" value="<?php echo $kategori ?>">
	
	<div class="row">
		<div class="col-md-3">
			<div class="form-group">
				<label>Tanggal Terima</label>
				<input type="text" name="tanggal" value="<?php echo date('Y-m-d') ?>" class="form-control datepicker" required>
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label>No. Surat Jalan / Nota</label>
				<input type="text" name="nosj" id="nosj" class="form-control" placeholder="Kosongkan untuk generate otomatis">
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label>Tipe Pembayaran</label>
				<select name="tipepembayaran" id="tipepembayaran" class="form-control select2bs4" data-live-search="true">
					<option value="Cash">Cash</option>
					<option value="Transfer">Transfer</option>
					<option value="Tempo">Tempo</option>
				</select>
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label>Karyawan Validasi</label>
				<select name="id_karaywan" id="id_karaywan" class="form-control select2bs4" data-live-search="true" required>
					<option value="">Pilih Karyawan</option>
					<?php foreach ($karyawan as $k) { ?>
						<option value="<?php echo $k['id'] ?>"><?php echo $k['nama'] ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
	</div>

<div class="row table-responsive">
	<div class="col-md-12">
		<table class="table table-bordered">
			<thead>
				<tr>
					<th class="text-center"><input type="checkbox" id="checkAll" checked></th>
					<th>NO</th>
					<th>TANGGAL AJUAN</th>
					<th>SUPPLIER</th>
					<th>NAMA BARANG</th>
					<th>JUMLAH</th>
					<th>SATUAN</th>
					<th>HARGA</th>
					<th>PEMBAYARAN</th>
					<th>KETERANGAN</th>
				</tr>
			</thead>
			<tbody>
				<?php $no = 1; ?>
				<?php foreach ($prods as $i => $p) { ?>
					<tr>
						<td class="text-center">
							<input type="checkbox" class="cek-terima" checked>
							<input type="hidden" class="id_pengajuan_detail" name="products[<?php echo $i ?>][id_pengajuan_detail]" value="<?php echo $p['id'] ?>">
							<input type="hidden" name="products[<?php echo $i ?>][id_persediaan]" value="<?php echo $p['id_persediaan'] ?>">
							<input type="hidden" name="products[<?php echo $i ?>][nama]" value="<?php echo htmlspecialchars($p['nama_item']) ?>">
							<input type="hidden" name="products[<?php echo $i ?>][ukuran]" value="<?php echo $p['jumlah'] ?>">
							<input type="hidden" name="products[<?php echo $i ?>][satuanukuran]" value="<?php echo htmlspecialchars($p['satuan']) ?>">
							<input type="hidden" name="products[<?php echo $i ?>][jumlah]" value="<?php echo $p['jumlah'] ?>">
							<input type="hidden" name="products[<?php echo $i ?>][satuanJml]" value="<?php echo htmlspecialchars($p['satuan']) ?>">
							<input type="hidden" name="products[<?php echo $i ?>][harga]" value="<?php echo $p['harga'] ?>">
							<input type="hidden" name="products[<?php echo $i ?>][keterangan]" value="<?php echo htmlspecialchars($p['keterangan']) ?>">
						</td>
						<td><?php echo $no++ ?></td>
						<td><?php echo date('d-m-Y', strtotime($p['tanggal'])) ?></td>
						<td><?php echo $p['supplier'] ?></td>
						<td><?php echo $p['nama_item'] ?></td>
						<td><?php echo $p['jumlah'] ?></td>
						<td><?php echo $p['satuan'] ?></td>
						<td><?php echo number_format($p['harga']) ?></td>
						<td><?php echo $p['pembayaran'] == 2 ? 'Transfer' : 'Cash' ?></td>
						<td><?php echo $p['keterangan'] ?></td>
					</tr>
				<?php } ?>
				<?php if (empty($prods)) { ?>
					<tr>
						<td colspan="10" class="text-center">Data tidak ditemukan</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>

<?php if (!empty($sel_supplier) && !empty($prods)) { ?>
	<div class="row mt-3">
		<div class="col-md-12 text-right">
			<button type="button" class="btn btn-primary" onclick="simpan()">Simpan Verifikasi</button>
		</div>
	</div>
<?php } ?>
</form>

<script>
	$("#checkAll").click(function () {
		$('input:checkbox.cek-terima').not(this).prop('checked', this.checked);
		updateDisabledInputs();
	});

	$(".cek-terima").change(function() {
		updateDisabledInputs();
	});

	function updateDisabledInputs() {
		$('.cek-terima').each(function() {
			if ($(this).is(':checked')) {
				$(this).closest('td').find('input[type="hidden"]').prop('disabled', false);
			} else {
				$(this).closest('td').find('input[type="hidden"]').prop('disabled', true);
			}
		});
	}

	function simpan() {
		var id_karaywan = $("#id_karaywan").val();
		if (!id_karaywan) {
			alert("Karyawan validasi wajib dipilih!");
			return false;
		}

		if ($('.id_pengajuan_detail:not(:disabled)').length < 1) {
			alert("Pilih minimal satu barang untuk diverifikasi.");
			return false;
		}

		if (confirm("Apakah Anda yakin ingin menyimpan dan memverifikasi barang-barang ini ke stok Gudang?")) {
			var nama_karyawan = $("#id_karaywan option:selected").text();
			// Set employee name for all selected rows before submitting
			$('.cek-terima:checked').each(function() {
				$(this).closest('td').append('<input type="hidden" name="products['+ $(this).closest('tr').index() +'][id_karaywan]" value="'+id_karaywan+'">');
				$(this).closest('td').append('<input type="hidden" name="products['+ $(this).closest('tr').index() +'][nama_karyawan]" value="'+nama_karyawan+'">');
			});
			$("#formSimpan").submit();
		}
	}

	function filter() {
		var url = '<?php echo $action ?>';
		var supplier = $("#supplier").val();
		if (supplier) {
			url += '?supplier=' + supplier;
		}
		location = url;
	}
</script>