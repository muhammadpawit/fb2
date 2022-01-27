<form method="post" action="<?php echo $action?>">
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<label>Tanggal</label>
				<input type="text" name="products[0][tanggal]" class="form-control datepicker" value="<?php echo date('Y-m-d'); ?>">
			</div>
			<div class="form-group">
				<label>Driver</label>
				<input type="text" name="products[0][namadriver]" class="form-control">
			</div>
			<div class="form-group">
				<label>Nominal</label>
				<input type="text" name="products[0][nominal]" class="form-control">
			</div>
			<div class="form-group">
				<label>Keterangan</label>
				<textarea name="products[0][keterangan]" class="form-control" rows="5"></textarea>
			</div>
		</div>
		<div class="col-md-6">
			<a href="<?php echo $url?>" class="btn btn-danger full">Batal</a>
		</div>
		<div class="col-md-6">
			<button type="submit" class="btn btn-success full">Simpan</button>
		</div>
	</div>
</form>