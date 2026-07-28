<div class="row">
	<div class="col-md-4">
		<div class="form-group">
			<label>Supplier</label>
			<select name="supplier" id="supplier" class="form-control select2">
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
<div class="row table-responsive">
	<div class="col-md-12">
		<table class="table table-bordered">
			<thead>
				<tr>
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
				<?php foreach ($prods as $p) { ?>
					<tr>
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
						<td colspan="9" class="text-center">Data tidak ditemukan</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
<script>
	function filter() {
		var url = '<?php echo $action ?>';
		var supplier = $("#supplier").val();
		if (supplier) {
			url += '?supplier=' + supplier;
		}
		location = url;
	}
</script>
