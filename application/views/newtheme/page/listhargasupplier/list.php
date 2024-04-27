<div class="row">
	<div class="col-md-12">
		<table class="table table-bordered yessearch">
			<thead>
				<tr>
					<th>No</th>
					<th>Nama Supplier / Toko </th>
					<th>Nama Item</th>
					<th>Jumlah</th>
					<th>Satuan</th>
					<th>Harga Lama</th>
					<th>Harga Harga Baru</th>
					<th>Kenaikan</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($prods as $p){?>
					<tr>
						<td><?php echo $p['no']?></td>
						<td><?php echo $p['supplier']?></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
						<?php foreach($p['item'] as $i){ ?>
							<tr>
								<td></td>
								<td></td>
								<td><?php echo $i['nama']?></td>
								<td>1</td>
								<td><?php echo $i['satuan']?></td>
								<td><?php echo $i['harga_lama']?></td>
								<td><?php echo $i['harga_beli']?></td>
								<td></td>
							</tr>
						<?php } ?>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>