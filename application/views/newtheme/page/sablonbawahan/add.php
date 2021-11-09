<form method="post" action="<?php echo $action?>">
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<label>Kode PO</label>
				<select name="po" class="form-control autopobawahansablon"></select>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group">
				<label>Nama CMT</label>
				<select name="cmt" class="form-control autocmtbawahansablon"></select>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group">
				<label>Pekerjaan</label>
				<select name="job" class="form-control autojobbawahansablon"></select>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group">
				<label>Keterangan</label>
				<input type="text" name="keterangan" class="form-control">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<button type="submit" class="btn btn-success full">Simpan</button>
		</div>
		<div class="col-md-6">
			<a href="<?php echo $kembali?>" class="btn btn-danger text-white full">Batal</a>
		</div>
	</div>
</form>