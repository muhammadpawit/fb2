<div class="row">
	<div class="col-md-12">
		<table class="table table-bordered default">
			<thead>
				<tr>
					<th>No</th>
					<th>Nama Supplier / Toko </th>
					<th>Telephone / HP </th>
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
						<td><?php echo $p['telephone']?></td>
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
								<td></td>
								<td><?php echo $i['nama']?></td>
								<td>1</td>
								<td><?php echo $i['satuan']?></td>
								<td><?php echo $i['harga_lama']?></td>
								<td><?php echo $i['harga_beli']?></td>
								<td><?php echo ($i['harga_beli']-$i['harga_lama']) ?></td>
							</tr>
						<?php } ?>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>