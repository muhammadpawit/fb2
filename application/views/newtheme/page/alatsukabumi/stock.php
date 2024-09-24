<div class="row">
	<div class="col-md-4">
		<div class="form-group">
			<label>Tanggal Awal</label>
			<input type="text" name="tanggal1" id="tanggal1" value="<?php echo $tanggal1?>" class="form-control">
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label>Tanggal Akhir</label>
			<input type="text" name="tanggal2" id="tanggal2" value="<?php echo $tanggal2?>" class="form-control">
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label>Aksi</label><br>
			<button class="btn btn-info btn-sm" onclick="filtertglonly()">Filter</button>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<table class="table table-bordered yessearch">
			<thead>
				<tr>
					<th>No</th>
					<th>Nama Alat</th>
					<th>Awal</th>
					<th>Masuk</th>
					<th>Keluar</th>
					<th>Jumlah</th>
					<th>Satuan</th>
				</tr>
			</thead>
			<tbody>
				<?php $no=1;?>
				<?php foreach($prods as $p){?>
					<tr>
						<td><?php echo $no++ ?></td>
						<td><?php echo $p['nama']?></td>
						<td>0</td>
						<td><?php echo $p['masuk']?></td>
						<td><?php echo $p['keluar']?></td>
						<td><?php echo $p['jumlah']?></td>
						<td><?php echo $p['satuan']?></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>