<form method="post" action="<?php echo $simpan?>">
<div class="row">
	<div class="col-md-3">
		<div class="form-group">
			<label>Nama Supplier</label>
		</div>
	</div>
	<div class="col-md-9">
		<div class="form-group">
			<select name="supplier" class="form-control select2bs4" required>
				<option value="">Pilih</option>
				<?php foreach($sup as $s){?>
					<option value="<?php echo $s['id']?>"><?php echo $s['nama']?></option>
				<?php } ?>
			</select>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<div class="form-group">
			<label>Periode</label>
		</div>
	</div>
	<div class="col-md-9">
		<div class="form-group">
			<textarea name="periode" class="form-control" style="width:100%"></textarea>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<div class="form-group">
			<label>Keterangan</label>
		</div>
	</div>
	<div class="col-md-9">
		<div class="form-group">
			<textarea name="keterangan" class="form-control" style="width:100%"></textarea>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<label>Periode</label>
	</div>
	<div class="col-md-9">
		<div class="form-group">
			<table class="table table-bordered">
				<?php for($i=1;$i<=4;$i++){?>
				<tr>
					<td colspan="2">Minggu ke <?php echo $i?></td>
				</tr>
				<tr>
					<td>
						<input type="text" name="prods[<?php echo $i?>][tanggal_awal]" class="form-control datepicker" placeholder="tanggal awal">
					</td>
					<td>
						<input type="text" name="prods[<?php echo $i?>][tanggal_akhir]" class="form-control datepicker" placeholder="tanggal akhir">
					</td>
				</tr>
				<?php } ?>
				<!-- <tr>
					<td colspan="2">Minggu ke 2</td>
				</tr>
				<tr>
					<td>
						<input type="text" name="prods[2][tanggal_awal]" class="form-control datepicker" placeholder="tanggal awal">
					</td>
					<td>
						<input type="text" name="prods[3][tanggal_awal]" class="form-control datepicker" placeholder="tanggal akhir">
					</td>
				</tr>
				<tr>
					<td colspan="2">Minggu ke 3</td>
				</tr>
				<tr>
					<td>
						<input type="text" name="prods[4][tanggal_awal]" class="form-control datepicker" placeholder="tanggal awal">
					</td>
					<td>
						<input type="text" name="prods[5][tanggal_awal]" class="form-control datepicker" placeholder="tanggal akhir">
					</td>
				</tr>
				<tr>
					<td colspan="2">Minggu ke 4</td>
				</tr>
				<tr>
					<td>
						<input type="text" name="prods[6][tanggal_awal]" class="form-control datepicker" placeholder="tanggal awal">
					</td>
					<td>
						<input type="text" name="prods[7][tanggal_awal]" class="form-control datepicker" placeholder="tanggal akhir">
					</td>
				</tr> -->
				<tr>
					<td><button type="submit" class="btn btn-success full">Simpan</button></td>
				</tr>
			</table>
		</div>
	</div>
</div>
</form>