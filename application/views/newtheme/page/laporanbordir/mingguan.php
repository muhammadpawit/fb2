<div class="row no-print">
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
			<button class="btn btn-info btn-sm" onclick="cetak()">Print</button>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12 text-center">
		<h3>Laporan Pendapatan dan Pengeluaran Bordir Forboys</h3><br>
		<p>Update per-tanggal <?php echo date('d-F-Y',strtotime($tanggal1)); ?> s.d <?php echo date('d-F-Y',strtotime($tanggal2)); ?></p>
	</div>
</div>
<div class="row">
	<div class="col-md-8">
		<div class="form-group">
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th colspan="2">Pendapatan</th>
						<th>Rp</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Pendapatan PO Dalam</td>
						<td>:</td>
						<td align="right"><?php echo $totalpendapatan?></td>
					</tr>
					<tr>
						<td>Pendapatan PO 0.15</td>
						<td>:</td>
						<td align="right"><?php echo $p15?></td>
					</tr>
					<tr>
						<td>Pendapatan PO Luar</td>
						<td>:</td>
						<td align="right"><?php echo $totalpoluar?></td>
					</tr>
					<tr>
						<td>Pendapatan PO Yuna</td>
						<td>:</td>
						<td align="right"></td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="2"><b>Total Pendapatan</b></td>
						<td align="right"><?php echo number_format($totalpen)?></td>
					</tr>
				</tfoot>
			</table>
		</div>

		<div class="form-group">
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th colspan="2">Pengeluaran</th>
						<th>Rp</th>
					</tr>
				</thead>
				<tbody>
					<?php $totalpengeluaran=0; ?>
					<?php foreach($pengeluarans as $p){?>
						<?php foreach($p['detail'] as $pd){?>
							<tr>
								<td colspan="2"><?php echo $pd['keterangan']?></td>
								<td align="right"><?php echo number_format($pd['total'])?></td>
							</tr>
							<?php $totalpengeluaran+=($pd['total']); ?>
						<?php } ?>
					<?php } ?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="2"><b>Total Pengeluaran</b></td>
						<td align="right"><?php echo number_format($totalpengeluaran)?></td>
					</tr>
					<tr>
						<td colspan="2"></td>
						<td></td>
					</tr>
					<tr>
						<td colspan="2"><b>Laba Produksi</b></td>
						<td align="right"><?php echo number_format($totalpen-$totalpengeluaran)?></td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>