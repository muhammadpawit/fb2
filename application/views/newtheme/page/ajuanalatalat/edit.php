<form method="post" action="<?php echo $action ?>">
	<input type="hidden" name="id" value="<?php echo $prods['id'] ?>">
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
		<div class="col-md-4">
			<label>Stok</label><br>
			<?php echo $prods['stok'] ?>
		</div>
		<div class="col-md-4">
			<label>Ajuan</label><br>
			<?php echo $prods['ajuan'] ?>
		</div>
		<div class="col-md-4">
			<label>Kebutuhan</label><br>
			<input type="text" name="kebutuhan" value="<?php echo $prods['kebutuhan'] ?>" class="form-control" required>
		</div>
		<div class="col-md-4">
			<label>Keterangan</label><br>
			<input type="text" name="keterangan" value="<?php echo $prods['keterangan'] ?>" class="form-control">
		</div>
		<div class="col-md-4">
			<label>Tanggal Ajuan</label><br>
			<input type="text" name="tanggal" value="<?php echo $prods['tanggal'] ?>" class="form-control datepicker" autocomplete="off">
		</div>
	</div>
</form>