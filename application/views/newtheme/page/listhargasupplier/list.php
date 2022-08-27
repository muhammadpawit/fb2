<div class="row">
	<div class="col-md-12">
		<table class="table table-bordered yessearch">
			<thead>
				<tr>
					<th>No</th>
					<th>Nama Item</th>
					<th>Tanggal</th>
					<th>Harga</th>
					<th>Supplier</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($prods as $p){?>
					<tr>
						<td><?php echo $p['no']?></td>
						<td><?php echo $p['namaitem']?></td>
						<td><?php echo $p['tanggal']?></td>
						<td><?php echo $p['harga']?></td>
						<td><?php echo $p['supplier']?></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>