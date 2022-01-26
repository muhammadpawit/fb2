<form method="post" action="<?php echo $editsave?>">
	<input type="hidden" name="id" value="<?php echo $detail['id_produksi_po']?>">
	<div class="row">
	<div class="col-md-6">
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>Kode Artikel</th>
					<th>:</th>
					<th><input type="text" name="kode_artikel" value="<?php echo $detail['kode_artikel']?>" class="form-control"></th>
				</tr>				
				<tr>
					<th>Kode PO</th>
					<th>:</th>
					<th>
						<input type="text" name="kode_po" value="<?php echo $detail['kode_po']?>" class="form-control">		
					</th>
				</tr>
				<tr>
					<th>Nama Hpp PO</th>
					<th>:</th>
					<th>
						<input type="text" name="nama_hpp" value="<?php echo $detail['nama_hpp']?>" class="form-control">
					</th>
				</tr>
				<tr>
					<th>Jenis PO</th>
					<th>:</th>
					<th>
						<select name="jenis_po" class="form-control select2bs4" data-live-search="true">
							<?php foreach($jenis as $j){?>
							<option value="<?php echo $j['nama_jenis_kaos']?>" <?php echo $j['nama_jenis_kaos']==$detail['jenis_po']?'selected':'';?>><?php echo $j['nama_jenis_kaos']?></option>
							<?php } ?>
						</select>
						
					</th>
				</tr>
				<tr>
					<th>HPP (Rp)</th>
					<th>:</th>
					<th>
						<?php //echo number_format($detail['harga_satuan'])?>
						<input type="text" name="harga_satuan" value="<?php echo $detail['harga_satuan']?>" class="form-control">			
					</th>
				</tr>
			</thead>
		</table>
		<table class="table table-bordered">
			<thead>
				<tr align="center">
					<th>Gambar Depan</th>
					<th>Gambar Belakang</th>
				</tr>
				<tr>
					<th>
						<img src="<?php echo BASEURL.$detail['gambar_po'] ?>" style="width: 100%;"  >
					</th>
					<th>
						<img src="<?php echo BASEURL.$detail['gambar_po2'] ?>" style="width: 100%;"  >
					</th>
				</tr>
			</thead>
		</table>
	</div>
	<div class="col-md-6">
		
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<a href="<?php echo $batal?>" class="btn btn-danger btn-sm">Kembali</a>
		<button class="btn btn-info btn-sm">Simpan</button>
	</div>
</div>
</form>