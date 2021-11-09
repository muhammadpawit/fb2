<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<label>Daftar Harga Ongkos HPP</label>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Nama PO</th>
						<th>Jenis Ongkos</th>
						<th>Ongkos</th>
						<th>Keterangan</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($prods as $p){?>
						<tr>
							<td><?php echo $p['namapo']?></td>
							<td><?php echo $p['namabiaya']?></td>
							<td><?php echo $p['biaya']?></td>
							<td><?php echo $p['keterangan']?></td>
							<td><?php echo $p['hapus']?></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<form method="post" action="<?php echo $action?>">
	<input type="hidden" name="idcmt" value="<?php echo $idcmt?>">
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<label>Nama PO</label>
				<select name="namapo" class="form-control select2bs4" data-live-search="true">
					<?php foreach($jenispo as $j){?>
						<option value="<?php echo $j['nama_jenis_po']?>"><?php echo $j['nama_jenis_po']?></option>
					<?php } ?>
				</select>
			</div>
			<div class="form-group">
				<label>Nama Biaya</label>
				<select name="namabiaya" class="form-control select2bs4" data-live-search="true">
					<?php foreach($biaya as $j){?>
						<option value="<?php echo $j['nama']?>"><?php echo $j['nama']?></option>
					<?php } ?>
				</select>
			</div>
			<div class="form-group">
				<label>Biaya / Ongkos</label>
				<input type="text" name="biaya" class="full">
			</div>
			<div class="form-group">
				<label>Keterangan</label>
				<input type="text" name="keterangan" class="full">
			</div>
		</div>
	</div>	
	<div class="row">
		<div class="col-md-6">
			<button type="submit" class="btn btn-success btn-sm full">Simpan</button>
		</div>
		<div class="col-md-6">
			<a href="<?php echo $batal?>" class="btn btn-danger btn-sm full text-white">Batal</a>
		</div>
	</div>
</form>