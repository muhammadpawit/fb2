<form method="post" action="<?php echo $action?>">
<div class="row">
	<div class="col-md-8">
		<div class="form-group">
			<label>Tanggal</label>
			<input type="text" name="tanggal" class="form-control" value="<?php echo date('Y-m-d')?>" readonly>
		</div>
		<div class="form-group">
			<label>Nama Karyawan</label>
			<input type="text" name="nama" class="form-control">
			<input type="hidden" name="bagian" value="2" class="form-control">
		</div>
		<div class="form-group">
			<label>Jam Masuk <small>(AM pagi. PM Sore)</small></label>
			<input type="time" name="jam_masuk" class="form-control">
		</div>
		<div class="form-group">
			<label>Keterangan</label>
			<input type="text" name="keterangan" class="form-control">
		</div>
		<div class="form-group">
			<input type="submit" name="simpan" class="btn btn-success btn-sm" value="Simpan">
			<a href="<?php echo $cancel?>" class="btn btn-danger btn-sm text-white">Batal</a>
		</div>
	</div>
</div>
</form>