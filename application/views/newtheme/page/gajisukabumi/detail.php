	<div class="row no-print">
		<div class="col-md-2">
			<div class="form-group">
				<label>Tanggal / Periode </label>
				<input type="text" name="tanggal" value="<?php echo date('d-m-Y',strtotime($p['tanggal']))?>" class="form-control" required="required" readonly>
			</div>
		</div>
		<div class="col-md-10">
			<div class="form-group">
				<label>Keterangan</label>
				<input type="text" name="keterangan" class="form-control" value="<?php echo $p['keterangan']?>" readonly>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<h3 class="text-center">Rincian Gaji Karyawan Sukabumi</h3>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>Nama</th>
							<th>Bagian</th>
							<th>Jml Hari Kerja</th>
							<th>Upah / Hari</th>
							<th>Jumlah (Rp)</th>
							<th>Keterangan</th>
						</tr>
					</thead>
					<tbody id="bod">
						<?php foreach($detail as $d){?>
							<tr>
								<td><?php echo strtolower($d['nama'])?></td>
								<td><?php echo strtolower($d['bagian'])?></td>
								<td><?php echo strtolower($d['jml_hari_kerja'])?></td>
								<td><?php echo number_format($d['upah'])?></td>
								<td><?php echo number_format($d['total'])?></td>
								<td><?php echo strtolower($d['keterangan'])?></td>
							</tr>
						<?php } ?>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="4" align="center"><b>Total</b></td>
							<td><b><?php echo number_format($p['total'])?></b></td>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<h3 class="text-center">Anggaran Operasional</h3>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>Keperluan</th>
							<th>JML BRG</th>
							<th>Harga</th>
							<th>Jumlah (Rp)</th>
							<th>Keterangan</th>
						</tr>
					</thead>
					<tbody id="bod">
						<?php foreach($sd as $d){?>
							<tr>
								<td><?php echo strtolower($d['keperluan'])?></td>
								<td><?php echo strtolower($d['jml'])?></td>
								<td><?php echo number_format($d['harga'])?></td>
								<td><?php echo number_format($d['total'])?></td>
								<td><?php echo strtolower($d['keterangan'])?></td>
							</tr>
						<?php } ?>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="3" align="center"><b>Total</b></td>
							<td><b><?php echo number_format($a['total'])?></b></td>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<h3 class="text-center">Rekap</h3>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>Nama CMT</th>
							<th>Atas Nama</th>
							<th>No.Rek</th>
							<th>Jml.Transferan (Rp)</th>
						</tr>
					</thead>
					<tbody >
						<tr>
							<td>Kasbon & Gaji Anak Harian</td>
							<td>TONI ANDRIAN</td>
							<td>4408-01-001034-50-7</td>
							<td><?php echo number_format($p['total'])?></td>
						</tr>
						<tr>
							<td>Anggaran Operasional</td>
							<td></td>
							<td></td>
							<td><?php echo number_format($a['total'])?></td>
						</tr>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="3" align="center"><b>Total</b></td>
							<td><b><?php echo number_format($p['total']+$a['total'])?></b></td>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
	<div class="row no-print">
		<div class="col-md-6">
			<div class="form-group"><button class="btn btn-success btn-full full" onclick="cetak()">Cetak</button></div>
		</div>
		<div class="col-md-6">
			<div class="form-group"><a href="<?php echo $batal?>" class="btn btn-danger full">Kembali</a></div>
		</div>
	</div>