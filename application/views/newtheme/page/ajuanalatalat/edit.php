<form method="post" action="<?php echo $action ?>">
	<input type="hidden" name="id" value="<?php echo $prods['id'] ?>">
	<input type="hidden" name="bagian" value="<?php echo $prods['bagian'] ?>">
	<input type="hidden" name="stok" value="<?php echo $prods['stok'] ?>">
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<label>Nama Barang</label>
				<select name="id_persediaan" class="form-control select2bs4" disabled readonly>
					<?php foreach($barang as $b){ ?>
						<option value="<?php echo $b['id_persediaan']?>"
							<?php echo $b['id_persediaan']==$prods['id_persediaan']?'selected':'';?>><?php echo $b['nama_item']?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group">
				<label>Stok</label><br>
				<b><?php echo $prods['stok'] ?></b>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group">
				<label>Ajuan</label><br>
				<b><?php echo $prods['ajuan'] ?></b>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group">
				<label>Kebutuhan</label><br>
				<input type="text" name="kebutuhan" value="<?php echo $prods['kebutuhan'] ?>" class="form-control" required>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group">
				<label>Keterangan</label><br>
				<input type="text" name="keterangan" value="<?php echo $prods['keterangan'] ?>" class="form-control">
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group">
				<label>Tanggal Ajuan</label><br>
				<input type="text" name="tanggal" value="<?php echo $prods['tanggal'] ?>" class="form-control datepicker" autocomplete="off">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<button class="btn btn-success btn-sm full">Simpan</button>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<a href="<?php echo $cancel ?>" class="btn btn-danger btn-sm full">Batal</a>
			</div>
		</div>
	</div>
</form>