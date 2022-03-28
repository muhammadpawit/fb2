<div class="row">
	<div class="col-md-12">
		<table class="table table-bordered yessearch">
			<thead>
				<tr>
					<th>No</th>
					<th>Kode PO</th>
					<th>Jumlah Bangke (pcs)</th>
					<th>Jumlah Rijek (pcs)</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($prods as $p){?>
					<tr>
						<td><?php echo $p['no']?></td>
						<td><?php echo $p['kode_po']?></td>
						<td><?php echo $p['bangke']?></td>
						<td><?php echo $p['rijek']?></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>