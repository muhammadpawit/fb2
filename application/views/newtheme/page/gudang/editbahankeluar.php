<form method="post" action="<?php echo $action?>">
	<input type="hidden" name="id" value="<?php echo $details['id_item_keluar']?>">
	<div class="row">
		<div class="col-md-6">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Nama Bahan</th>
						<th>:</th>
						<th><?php echo $details['nama_item_keluar']?></th>
					</tr>
					<tr>
						<th>Untuk Bahan</th>
						<th>:</th>
						<th><?php echo $details['bahan_kategori']?></th>
					</tr>
					<tr>
						<th>Kode PO</th>
						<th>:</th>
						<th>
							<select name="kode_po" class="form-control select2bs4" data-live-search="true">
								<?php foreach($po as $p){?>
									<option value="<?php echo $p['kode_po']?>" <?php echo $p['kode_po']==$details['kode_po']?'selected':''; ?>> <?php echo $p['kode_po']?></option>
								<?php } ?>
							</select>
						</th>
					</tr>
					<tr>
						<th></th>
						<th></th>
						<th>
							<button type="submit" class="btn btn-info btn-sm text-white">Simpan</button>
							<a href="<?php echo $batal?>" class="btn btn-danger btn-sm text-white">Batal</a>
						</th>
					</tr>
				</thead>
			</table>	
		</div>
	</div>
</form>