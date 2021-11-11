<div class="col-md-12">
	<div class="form-group">
		<table class="table table-bordered yessearch">
			<thead>
				<tr>
					<th>No</th>
					<th>Nama PO</th>
					<th>Jumlah Potongan (Pcs)</th>
					<th>Jumlah Potongan (Dz)</th>
					<th>Ongkos Jahit/Lusin</th>
					<th>Jumlah (Rp)</th>
					<th>Jumlah Setor</th>
					<th>Jumlah Setoran/Lusin</th>
					<th>Kekurangan Setoran Po Rusak</th>
					<th>Status</th>
					<th>Potongan Kekurangan (Rp)</th>
					<th>Jumlah Bersih (Rp)</th>
					<th>Ket</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($prods as $p){?>
					<tr>
						<td><?php echo $p['no']?></td>
						<td><?php echo $p['kode_po']?></td>
						<td><?php echo $p['pot_pcs']?></td>
						<td><?php echo number_format($p['pot_dz'],2)?></td>
						<td><?php echo number_format($p['harga'])?></td>
						<td><?php echo number_format($p['jumlah'])?></td>
						<td><?php echo number_format($p['setoran_pcs'])?></td>
						<td><?php echo number_format($p['setoran_dz'],2)?></td>
						<td><?php echo number_format($p['kekuarangan'])?></td>
						<td>-</td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>