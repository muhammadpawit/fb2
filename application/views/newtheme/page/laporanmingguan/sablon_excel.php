<?php
$namafile='Laporan_Keuangan_Sablon'.time();
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=".$namafile.".xls");
?>
<h1>Laporan Keuangan Mingguan Sablon</h1>
<table border="1" style="width: 100%;border-collapse: collapse;">
			<thead>
			  <tr align="center">
			    <th rowspan="2">Periode</th>
			    <th colspan="2">Debet</th>
			    <th colspan="5">Kredit</th>
			    <th rowspan="2">Keterangan</th>
			  </tr>
			  <tr align="center">
			    <th >Transfer</th>
			    <th >Kas Masuk</th>
			    <th >Kasbon Bahan Baku</th>
			    <th >Inventaris</th>
			    <th >Operasional / Listrik</th>
			    <th >Gaji / Upah</th>
			    <th >Sisa Kas</th>
			  </tr>
			</thead>
			<tbody>
				<?php 

				$transfer=0;
				$kas=0;
				$bahanbaku=0;
				$inventaris=0;
				$ops=0;
				$gaji=0;
				$sisa=0;

				?>
			<?php foreach($results as $r){?>
				<?php 

				$transfer+=$r['transfer'];
				$kas+=$r['kas'];
				$ops+=$r['ops'];
				$gaji+=$r['gaji'];
				$sisa+=$r['sisa'];
				

				?>
			  <tr>
			    <td ><?php echo $r['hari']?>, <?php echo $r['tanggal']?></td>
			    <td ><?php echo ($r['transfer'])?></td>
			    <td ><?php echo ($r['kas'])?></td>
			    <td ><?php echo ($r['bahanbaku'])?></td>
			    <td ><?php echo ($r['inventaris'])?></td>
			    <td ><?php echo ($r['ops'])?></td>
			    <td ><?php echo ($r['gaji'])?></td>
			    <td ><?php echo ($r['sisa'])?></td>
			    <td ><?php echo $r['keterangan']?></td>
			  </tr>
			  <?php $at=$this->LaporanmingguanModel->alokasi_transfer($r['tanggal'],3); ?>
			  	<?php if(!empty($at)){?>
			  	<?php foreach($at as $a){?>
			  		<?php 

					$bahanbaku+=$a['pengalokasian']==12?$a['nominal']:0;
					$inventaris+=$a['pengalokasian']==13?$a['nominal']:0;
					$ops+=$a['pengalokasian']==14?$a['nominal']:0;
					$gaji+=$a['pengalokasian']==15?$a['nominal']:0;
				

					?>
				  <tr>
				  	<td colspan="3"><?php //echo $a['tanggal'];?></td>
				  	<td><?php echo $a['pengalokasian']==12?($a['nominal']):0;?></td>
				  	<td><?php echo $a['pengalokasian']==13?($a['nominal']):0;?></td>
				  	<td><?php echo $a['pengalokasian']==14?($a['nominal']):0;?></td>
				  	<td><?php echo $a['pengalokasian']==15?($a['nominal']):0;?></td>
				  	<td><?php echo $a['pengalokasian']==16?($a['nominal']):0;?></td>
				  	<td><?php echo $a['keterangan']?></td>
				  </tr>
				<?php } ?>
				<?php } ?>
			<?php } ?>
			<tr>
				<td align="center"><b>Total</b></td>
				<td align="center"><b><?php echo ($transfer)?></b></td>
				<td align="center"><b><?php echo ($kas)?></b></td>
				<td align="center"><b><?php echo ($bahanbaku)?></b></td>
				<td align="center"><b><?php echo ($inventaris)?></b></td>
				<td align="center"><b><?php echo ($ops)?></b></td>
				<td align="center"><b><?php echo ($gaji)?></b></td>
				<td align="center"><b><?php echo ($sisa)?></b></td>
				<td></td>
			</tr>
			</tbody>
			</table>