<form method="post" action="<?php echo $action ?>">
	<input type="hidden" name="kode_po" value="<?php echo $kode_po?>">
	<div class="row">
		<div class="col-md-12">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Jumlah Naik</th>
						<th>Stich</th>
						<th>Total Stich</th>
						<th>Perkalian</th>
						<th>Total</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($d as $e){?>
						<input type="hidden" name="">
						<tr>
							<td><?php echo $e['jumlah_naik_mesin']?></td>
							<td><?php echo $e['stich']?></td>
							<td><?php echo $e['total_stich']?></td>
							<td><?php echo $e['perkalian_tarif']?></td>
							<td><?php echo $e['total_tarif']?></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</form>