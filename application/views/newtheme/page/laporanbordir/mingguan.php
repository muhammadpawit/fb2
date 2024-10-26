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
			<button class="btn btn-info btn-sm" onclick="excelwithtgl()">Excel</button>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12 text-center">
		<h3>Laporan Laba - Rugi Bordir Forboys</h3><br>
		<p>Update per-tanggal <?php echo date('d-F-Y',strtotime($tanggal1)); ?> s.d <?php echo date('d-F-Y',strtotime($tanggal2)); ?></p>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
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
						<td colspan="2">Pendapatan PO Dalam</td>
						<!-- <td>:</td> -->
						<td align="right"><?php echo number_format($totalpendapatan)?></td>
					</tr>
					<!-- <tr>
						<td>Pendapatan PO 0.15</td>
						<td>:</td>
						<td align="right"><?php echo $p15?></td>
					</tr> -->
					<tr>
						<td colspan="2">Pendapatan PO Luar / PO Homie</td>
						<!-- <td>:</td> -->
						<td align="right"><?php echo number_format($totalpoluar)?></td>
					</tr>
					<!--<tr>
						<td colspan="2">Pendapatan PO Yuna</td>
						<td align="right"></td>
					</tr>-->
				</tbody>
				<tfoot>
					<tr>
						<td colspan="2"><b>Total Pendapatan</b></td>
						<td align="right"><b><?php echo number_format($totalpen)?></b></td>
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
					<tr>
						<td colspan="2">Belanja Bordir </td>
						<td align="right">Rp. <?php echo number_format($belanjabordir) ?></td>
					</tr>
					<tr>
						<td colspan="2">Gaji Karyawan Bordir (Bulanan & Borongan) </td>
						<td align="right">Rp. <?php echo $gajibordir > 0 ? number_format($gajibordir):0 ?></td>
					</tr>
					<tr>
						<td colspan="2">Operasional (BBM,Service,Fotokopi) </td>
						<td align="right">Rp. <?php echo $operasional > 0 ? number_format($operasional):0 ?></td>
					</tr>
					<tr>
						<td colspan="2">Service (Mesin Bordir) </td>
						<td align="right">Rp. <?php echo $service > 0 ? number_format($service):0 ?></td>
					</tr>
					<?php $totalpengeluaran=($belanjabordir+$gajibordir+$operasional+$service); ?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="2"><b>Total Pengeluaran</b></td>
						<td align="right"><b><?php echo number_format($totalpengeluaran)?></b></td>
					</tr>
					<tr>
						<td colspan="2"></td>
						<td></td>
					</tr>
					<tr>
						<td colspan="2"><b>Laba Produksi</b></td>
						<td align="right"><b><?php echo number_format($totalpen-$totalpengeluaran)?></b></td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>