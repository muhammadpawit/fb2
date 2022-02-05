<form method="post" action="<?php echo $action ?>">
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label>Tanggal</label>
				<input type="text" name="products[0][tanggal]" class="form-control datepicker" value="<?php echo date('Y-m-d')?>">
			</div>
			<div class="form-group">
				<label>Jumlah PO Kirim</label>
				<input type="text" name="products[0][kirim_po]" class="form-control">
			</div>
			<div class="form-group">
				<label>Jumlah DZ Kirim</label>
				<input type="text" name="products[0][kirim_dz]" class="form-control">
			</div>
			<div class="form-group">
				<label>Jumlah PCS Kirim</label>
				<input type="text" name="products[0][kirim_pcs]" class="form-control">
			</div>
			<!-- <div class="form-group">
				<label>Total (Rp)</label>
				<input type="text" name="products[0][total]" class="form-control">
			</div> -->
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label>Nama PO / Keterangan</label>
				<input type="text" name="products[0][nama_po]" class="form-control">
			</div>
			<div class="form-group">
				<label>Jumlah PO Setor</label>
				<input type="text" name="products[0][setor_po]" class="form-control">
			</div>
			<div class="form-group">
				<label>Jumlah DZ Setor</label>
				<input type="text" name="products[0][setor_dz]" class="form-control">
			</div>
			<div class="form-group">
				<label>Jumlah PCS Setor</label>
				<input type="text" name="products[0][setor_pcs]" class="form-control">
			</div>
			<!-- <div class="form-group">
				<label>Total (Rp)</label>
				<input type="text" name="products[0][total]" class="form-control">
			</div> -->
		</div>	
	</div>
	<div class="row">
		<div class="col-md-6">
			<a href="<?php echo $url?>" class="btn btn-danger full">Batal</a>
		</div>	
		<div class="col-md-6">
			<button type="submit" class="btn btn-success full">Simpan</button>
		</div>
	</div>
	
</form>