<?php
$all=0;
$allbonus=0;
if(callSessUser('nama_user')=="Pawits"){

}else{
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Gaji_Operator_Bordir.xls");	
}

?>
	<h5>Gaji Operator Bordir Rumah</h5>
	<label>Periode</label>
			<h5><?php echo date('d F Y',strtotime($gaji['tanggal1'])).' s.d '.date('d F Y',strtotime($gaji['tanggal2'])) ?></h5>
	<table>
		<tr>
			<?php foreach($karyawans as $k){?>
			<td>
			<table border="1" style="width: 100%;border-collapse: collapse;">
				<thead>
					<tr>
						<th>Hari</th>
						<th>Nama : <?php echo $k['nama']?></th>
						<th>Keterangan</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Senin</td>
						<td align="right"><?php echo $k['senin']?></td>
						<td align="right"><?php echo $k['ksenin']?></td>
					</tr>
					<tr>
						<td>Selasa</td>
						<td align="right"><?php echo $k['selasa']?></td>
						<td align="right"><?php echo $k['kselasa']?></td>
					</tr>
					<tr>
						<td>Rabu</td>
						<td align="right"><?php echo $k['rabu']?></td>
						<td align="right"><?php echo $k['krabu']?></td>
					</tr>
					<tr>
						<td>Kamis</td>
						<td align="right"><?php echo $k['kamis']?></td>
						<td align="right"><?php echo $k['kkamis']?></td>
					</tr>
					<tr>
						<td>Jumat</td>
						<td align="right"><?php echo $k['jumat']?></td>
						<td align="right"><?php echo $k['kjumat']?></td>
					</tr>
					<tr>
						<td>Sabtu</td>
						<td align="right"><?php echo $k['sabtu']?></td>
						<td align="right"><?php echo $k['ksabtu']?></td>
					</tr>
					<tr>
						<td>Minggu</td>
						<td align="right"><?php echo $k['minggu']?></td>
						<td align="right"><?php echo $k['kminggu']?></td>
					</tr>
					<tr>
						<td>Bonus</td>
						<td align="right"><?php echo $k['bonus']?></td>
						<td align="right"><?php echo $k['kbonus']?></td>
					</tr>
					<tr>
						<td>Uang Makan</td>
						<td align="right"><?php echo $k['um']?></td>
						<td align="right"><?php echo $k['kum']?></td>
					</tr>
					<tr>
						<td><b>Total</b></td>
						<td align="right"><label><?php echo ($k['senin']+$k['selasa']+$k['rabu']+$k['kamis']+$k['jumat']+$k['sabtu']+$k['minggu']+$k['bonus']+$k['um']) ?></label></td>
					</tr>
				</tbody>
			</table><br>
		</td>
		<td></td>
		<?php 
			$all+=($k['senin']+$k['selasa']+$k['rabu']+$k['kamis']+$k['jumat']+$k['sabtu']+$k['minggu']+$k['bonus']+$k['um']);
			$allbonus+=($k['bonus']);
		?>
	<?php } ?>
		</tr>
	</table>

<h3></h3>
	<table border="1" style="width: 100%;border-collapse: collapse;">
		<tr>
			<td>Total Gaji</td>
			<td>:</td>
			<td><?php echo $all?></td>
		</tr>
		<tr>
			<td>Total Target Mandor + UM</td>
			<td>:</td>
			<td><?php echo ($allbonus*0.3)?></td>
		</tr>
		<tr>
			<td>Total </td>
			<td>:</td>
			<td><?php echo (($allbonus*0.3)+$all)?></td>
		</tr>
	</table>