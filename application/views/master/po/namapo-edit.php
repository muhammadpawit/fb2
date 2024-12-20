<form method="post" action="<?php echo BASEURL?>Masterdata/simpaneditnama">
	<input type="hidden" name="id_jenis_po" value="<?php echo $p['id_jenis_po']?>">
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<label>Nama</label>
				<input type="text" name="nama_jenis_po" value="<?php echo $p['nama_jenis_po']?>" class="form-control">
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group">
				<label>Type jenis</label>
				<select name="idjenis" class="form-control">
					<option value="1" <?php echo $p['idjenis']==1?'selected':''; ?>>Kemeja</option>
					<option value="2" <?php echo $p['idjenis']==2?'selected':''; ?>>Kaos</option>
					<option value="3" <?php echo $p['idjenis']==3?'selected':''; ?>>Celana</option>
				</select>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group">
				<label>Tampilkan Di Laporan Monitoring ?</label>
				<select name="tampil" class="form-control">
					<option value="1" <?php echo $p['id_jenis_po']==1?'selected':''; ?>>Ya</option>
					<option value="2" <?php echo $p['id_jenis_po']==2?'selected':''; ?>>Tidak</option>
				</select>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group">
				<label>PO Online ?</label>
				<select name="online" class="form-control">
					<option value="ya" <?php echo $p['online']=='ya'?'selected':''; ?>>Ya</option>
					<option value="tidak" <?php echo $p['online']=='tidak'?'selected':''; ?>>Tidak</option>
				</select>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<input type="submit" name="simpan" class="btn btn-success btn-full full" value="Simpan">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<a href="<?php echo BASEURL?>Masterdata/namapo" class="btn btn-danger btn-full full">Batal</a>
			</div>
		</div>
	</div>
</form>