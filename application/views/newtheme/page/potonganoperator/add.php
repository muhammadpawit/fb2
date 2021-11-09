<form method="POST" action="<?php echo $action?>">
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<label>Tanggal</label>
				<input type="text" name="tanggal" class="form-control datepicker" required>
			</div>
			<div class="form-group">
				<label>Nama Operator</label>
				<select name="operator" class="form-control autooperator" required></select>
			</div>
			<div class="form-group">
				<label>Jenis Potongan</label>
				<select name="jenis_potongan" class="form-control autojenispotongan" required></select>
			</div>
			<div class="form-group">
				<label>Nominal</label>
				<input type="number" name="nominal" class="form-control" required>
			</div>
			<div class="form-group">
				<label>Keterangan</label>
				<textarea name="keterangan" class="form-control" rows="5"></textarea>
			</div>
		</div>
		<div class="col-md-6">
			<button class="btn btn-success btn-sm full">Simpan</button>
		</div>
		<div class="col-md-6">
			<a href="<?php echo $cancel?>" class="btn btn-danger btn-sm full text-white">Batal</a>
		</div>
	</div>
</form>