<form method="post" action="<?php echo $simpan?>">
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<label>Kode PO</label>
				<input type="text" class="form-control" name="kode_po" value="<?php echo $k['kode_po']?>" readonly>
			</div>
			<div class="form-group">
				<label>No Faktur</label>
				<input type="text" class="form-control" name="nofaktur" value="<?php echo $k['nofaktur']?>" autocomplete="off">
			</div>
			<div class="form-group">
				<label>Tanggal Kirim</label>
				<input type="text" class="form-control datepicker" name="tanggal_kirim" value="<?php echo $k['tanggal_kirim']?>" readonly>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<button class="btn btn-success btn-sm full">Simpan</button>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<a href="<?php echo $cancel?>" class="btn btn-danger btn-sm full">Cancel</a>
			</div>
		</div>
	</div>
</form>