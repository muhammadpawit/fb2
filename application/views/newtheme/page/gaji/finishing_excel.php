<?php
$filename=$title.time();
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=".$filename.".xls");
?>
<h3><?php echo $title ?></h3>
<div class="row">
	<table style="border-collapse: collapse;width: 100%;float: left; margin-right: 20px;margin-bottom: 5px" cellpadding="3">
		<tr>
			<?php foreach($karyawans as $k){?>
				<td>
	<table border="1" style="border-collapse: collapse;width: 100%;float: left; margin-right: 20px;margin-bottom: 5px" cellpadding="3">
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
						<td><b>Total</b></td>
						<td align="right"><label><?php echo ($k['senin']+$k['selasa']+$k['rabu']+$k['kamis']+$k['jumat']+$k['sabtu']+$k['minggu']+$k['lembur']+$k['insentif']) ?></label></td>
					</tr>
					<tr>
						<td><b>Pembulatan</b></td>
						<td align="right"><label><?php echo pembulatangaji($k['senin']+$k['selasa']+$k['rabu']+$k['kamis']+$k['jumat']+$k['sabtu']+$k['minggu']+$k['lembur']+$k['insentif']) ?></label></td>
					</tr>
				</tbody>
			</table><br>
		</td>
		<td>&nbsp;</td>
		<?php
		$total+=($k['senin']+$k['selasa']+$k['rabu']+$k['kamis']+$k['jumat']+$k['sabtu']+$k['minggu']+$k['lembur']+$k['insentif']);

	?>
	<?php } ?>
		</tr>
	</table>
	<h3>Total Keseluruhan Rp. <?php echo (ceil($total))?></h3>
	<h3>Total Pembulatan Rp. <?php echo (pembulatangaji(ceil($total)))?></h3>
</div>