<form method="get" action="<?php echo BASEURL.'Keuangan/tagihanbahan' ?>">
<div class="row">
	<div class="col-md-4">
		<div class="form-group">
			<label>Filter Tahun:</label>
			<select name="tahun" class="form-control">
				<?php 
					$start_year = 2020;
					$curr_year = date('Y') + 1;
					for($i = $start_year; $i <= $curr_year; $i++){
						$selected = ($i == $tahun) ? 'selected' : '';
						echo "<option value='$i' $selected>$i</option>";
					}
				?>
			</select>
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label>&nbsp;</label><br>
			<button type="submit" class="btn btn-info">Filter</button>
		</div>
	</div>
</div>
</form>
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
						<th><?php echo strtolower($s['nama']); ?></th>
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
									// Tampilkan kosong jika total = 0 atau null
									echo ($sup['total'] ?? 0) > 0 
										? number_format($sup['total'], 0, ',', '.') 
										: '';
								?>
							</td>
						<?php endforeach; ?>
					</tr>
				<?php endforeach; ?>
			</tbody>

			<tfoot>
				<tr style="font-weight: bold; background-color: #f5f5f5;">
					<td align="right">Total</td>
					<?php 
					// Hitung total per supplier
					foreach($supplier as $s): 
						$totalSupplier = 0;
						foreach($prods as $p){
							foreach($p['supplier'] as $sup){
								if ($sup['id_supplier'] == $s['id']) {
									$totalSupplier += $sup['total'] ?? 0;
								}
							}
						}
					?>
						<td align="right">
							<?php echo $totalSupplier > 0 ? number_format($totalSupplier, 0, ',', '.') : ''; ?>
						</td>
					<?php endforeach; ?>
				</tr>

					<tr style="font-weight: bold; background-color: #f5f5f5;">
						<td align="right">Total Pembayaran</td>
						<?php 
						// Hitung total per supplier
						foreach($supplier as $s): 
							$totalSupplier = 0;
							foreach($prods as $p){
								foreach($p['supplier'] as $sup){
									if ($sup['id_supplier'] == $s['id']) {
										$totalSupplier += $sup['totaldibayar'] ?? 0;
									}
								}
							}
						?>
							<td align="right" style="color:#0c9132">
								<?php echo $totalSupplier > 0 ? number_format($totalSupplier, 0, ',', '.') : ''; ?>
							</td>
						<?php endforeach; ?>
					</tr>

					<tr style="font-weight: bold; background-color: #f5f5f5;">
						<td align="right">Sisa Tagihan Pembayaran</td>
						<?php 
						// Hitung total per supplier
						foreach($supplier as $s): 
							$totalSupplier = 0;
							foreach($prods as $p){
								foreach($p['supplier'] as $sup){
									if ($sup['id_supplier'] == $s['id']) {
										$totalSupplier += $sup['sisa'] ?? 0;
									}
								}
							}
						?>
							<td align="right">
								<?php if ($totalSupplier > 0): ?>
									<span style="color: red; font-weight: bold; font-size: 1.3em;">
										<?php echo number_format($totalSupplier, 0, ',', '.'); ?>
									</span>
								<?php endif; ?>
							</td>
						<?php endforeach; ?>
					</tr>
			</tfoot>
		</table>


	</div>
</div>