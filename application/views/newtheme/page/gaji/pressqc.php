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
			<a href="<?php echo $tambah?>" class="btn btn-info btn-sm text-white">Tambah</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<table class="table table-bordered nosearch">
			<thead>
				<tr>
					<th>No</th>
					<th>Periode</th>
					<th>Bagian</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($products as $p){?>
					<tr>
						<td><?php echo $p['no']?></td>
						<td><?php echo $p['periode']?></td>
						<td><?php echo $p['bagian']?></td>
						<td>
							<a href="<?php echo $p['detail']?>" class="btn btn-warning btn-sm text-white">Detail</a>&nbsp;
							<a href="<?php echo $p['excel']?>" class="btn btn-success btn-sm text-white">Excel</a>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>