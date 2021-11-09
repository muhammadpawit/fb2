<div class="row">
	<div class="col-md-6">
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>Nama PO</th>
					<th>:</th>
					<th><?php echo $detail['kode_po']?></th>
				</tr>
				<tr>
					<th>Jenis PO</th>
					<th>:</th>
					<th><?php echo $detail['jenis_po']?></th>
				</tr>
				<tr>
					<th>HPP</th>
					<th>:</th>
					<th>Rp.<?php echo number_format($detail['harga_satuan'])?></th>
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
	</div>
</div>