<div class="row">
	<div class="col-md-12">
		<table class="table table-bordered table-hover">
			<thead align="center" valign="top">
				<tr>
					<th rowspan="2">Bulan</th>
					<th colspan="<?php echo count($supplier); ?>">Supplier</th>
				</tr>
				<tr>
					<?php foreach($supplier as $s): ?>
						<th><?php echo $s['nama']; ?></th>
					<?php endforeach; ?>
				</tr>
			</thead>
			<tbody>
				<?php foreach($prods as $p): ?>
					<tr>
						<td><b><?php echo $p['bulan']; ?></b></td>
						<?php foreach($p['supplier'] as $sup): ?>
							<td align="right">
								<?php 
									// Jika nanti kamu punya nilai total/tagihan, tampilkan di sini
									echo number_format($sup['total'], 0, ',', '.') ?? '-';
								?>
							</td>
						<?php endforeach; ?>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>

	</div>
</div>