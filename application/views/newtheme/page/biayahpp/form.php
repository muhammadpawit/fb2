<form action="<?php echo $action ?>" method="POST">
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<label for="">Nama Biaya</label>
				<input type="text" name="nama_biaya" class="form-control" required>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group">
				<label for="">Nominal Biaya</label>
				<input type="number" name="nominal" class="form-control" required>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group">
				<label for="">PO</label>
				<select name="idpo[]" class="form-select select2bs4" multiple>
					<option value="">Pilih</option>
					<?php foreach($po as $p){ ?>
						<option value="<?php echo $p['id_produksi_po']?>"><?php echo $p['kode_po']?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<button class="btn btn-success full">Simpan</button>
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<a href="<?php echo $batal ?>" class="btn btn-danger full">Batal</a>
			</div>
		</div>
	</div>
</form>