<div class="row">
	<div class="col-md-12">
		<table class="table table-bordered yessearch">
			<thead>
				<tr>
					<th>No</th>
					<th>Nama Alat</th>
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
						<td><?php echo $p['jumlah']?></td>
						<td><?php echo $p['satuan']?></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>