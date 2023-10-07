<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<label>Periode</label>
			<h4><?php echo date('d F Y',strtotime($gaji['tanggal1'])).' s.d '.date('d F Y',strtotime($gaji['tanggal2'])) ?></h4>
		</div>
	</div>
</div>
<div class="row">
	<?php foreach($karyawans as $k){?>
	<div class="col-md-4">
		<div class="table-responsive">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Hari</th>
						<th>Nama : <?php echo $k['nama']?></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Senin</td>
						<td align="right"><?php echo $k['senin']?></td>
					</tr>
					<tr>
						<td>Selasa</td>
						<td align="right"><?php echo $k['selasa']?></td>
					</tr>
					<tr>
						<td>Rabu</td>
						<td align="right"><?php echo $k['rabu']?></td>
					</tr>
					<tr>
						<td>Kamis</td>
						<td align="right"><?php echo $k['kamis']?></td>
					</tr>
					<tr>
						<td>Jumat</td>
						<td align="right"><?php echo $k['jumat']?></td>
					</tr>
					<tr>
						<td>Sabtu</td>
						<td align="right"><?php echo $k['sabtu']?></td>
					</tr>
					<tr>
						<td>Minggu</td>
						<td align="right"><?php echo $k['minggu']?></td>
					</tr>
					<tr>
						<td>Lembur</td>
						<td align="right"><?php echo $k['lembur']?></td>
					</tr>
					<tr>
						<td>Insentif</td>
						<td align="right"><?php echo $k['insentif']?></td>
					</tr>
					<tr>
						<td>Pot.Claim</td>
						<td align="right"><?php echo $k['claim']?></td>
					</tr>
					<tr>
						<td>Pot.Pinjaman</td>
						<td align="right"><?php echo $k['pinjaman']?></td>
					</tr>
					<tr>
						<td><b>Total</b></td>
						<td align="right"><label><?php echo number_format($k['senin']+$k['selasa']+$k['rabu']+$k['kamis']+$k['jumat']+$k['sabtu']+$k['minggu']+$k['lembur']+$k['insentif']-$k['claim']-$k['pinjaman']) ?></label></td>
					</tr>
					<tr>
						<td><b>Saving</b></td>
						<td align="right"><label><?php echo number_format($k['saving']) ?></label></td>
					</tr>
					<tr>
						<td><b>Keluarkan Saving</b></td>
						<td align="right"><label><?php echo number_format($k['keluarkansaving']) ?></label></td>
					</tr>
					<tr>
						<td><b>Pembulatan</b></td>
						<td align="right"><label><?php echo number_format(pembulatangaji($k['senin']+$k['selasa']+$k['rabu']+$k['kamis']+$k['jumat']+$k['sabtu']+$k['minggu']+$k['lembur']+$k['insentif']-$k['claim']-$k['pinjaman']-$k['saving']+$k['keluarkansaving'])) ?></label></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<?php
		$total+=($k['senin']+$k['selasa']+$k['rabu']+$k['kamis']+$k['jumat']+$k['sabtu']+$k['minggu']+$k['lembur']+$k['insentif']-$k['claim']+$k['keluarkansaving']-$k['saving']);

	?>
	<?php } ?>
</div>
<div class="row">
	<div class="col-md-12">
		<h3>Total Keseluruhan Rp. <?php echo number_format(ceil($total))?></h3>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<h3>Total Pembulatan Rp. <?php echo number_format(pembulatangaji(ceil($total)))?></h3>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<a href="<?php echo $kembali?>" class="btn btn-danger btn-sm text-white">Kembali</a>
		<button class="btn btn-info btn-sm" onclick="excel()">Excel</button>
	</div>
</div>
<script type="text/javascript">
	function excel(){
		url ='?&excel=1';
		location = url;
	}
</script>