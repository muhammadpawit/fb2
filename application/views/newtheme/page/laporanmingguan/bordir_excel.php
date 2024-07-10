<?php
$namafile='Laporan_Keuangan_Bordir'.time();
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=".$namafile.".xls");
?>
<h1>Laporan Keuangan Mingguan Bordir</h1>
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
			    <th >Pembelian Bahan Baku</th>
			    <th >Operasional / Listrik</th>
			    <th >Gaji / Upah</th>
			    <th >Transfer</th>
			    <th >Sisa Kas</th>
			  </tr>
			</thead>
			<tbody>
			<?php 

				$transfer=0;
				$kas=0;
				$bahanbaku=0;
				$ops=0;
				$gaji=0;
				$alokasitransfer=0;
				$sisa=0;

			?>
			<?php foreach($results as $r){?>
				<?php 

					$transfer+=($r['transfer']);
					$kas+=($r['kas']);
					$bahanbaku+=($r['bahanbaku']);
					$ops+=($r['ops']);
					$gaji+=($r['gaji']);
					$alokasitransfer+=($r['alokasitransfer']);
					$sisa+=($r['sisa']);
					

				?>
			  <tr>
			    <td ><?php echo $r['hari']?>, <?php echo $r['tanggal']?></td>
			    <td ><?php echo ($r['transfer'])?></td>
			    <td ><?php echo ($r['kas'])?></td>
			    <td ><?php echo ($r['bahanbaku'])?></td>
			    <td ><?php echo ($r['ops'])?></td>
			    <td ><?php echo ($r['gaji'])?></td>
			    <td ><?php echo ($r['alokasitransfer'])?></td>
			    <td ><?php echo ($r['sisa'])?></td>
			    <td ><?php echo $r['keterangan']?></td>
			  </tr>
			  	<?php $at=$this->LaporanmingguanModel->alokasi_transfer($r['tanggal'],2); ?>
			  	<?php if(!empty($at)){?>
			  	<?php foreach($at as $a){?>
			  		<?php

					$bahanbaku+=($a['pengalokasian']==1)?$a['nominal']:0;;
					$ops+=($a['pengalokasian']==2)?$a['nominal']:0;;
					$gaji+=($a['pengalokasian']==3)?$a['nominal']:0;;
					$alokasitransfer+=($a['pengalokasian']==4)?$a['nominal']:0;
					$sisa+=($a['pengalokasian']==5)?$a['nominal']:0;

					?>
				  <tr>
				  	<td colspan="3"><?php //echo $a['tanggal'];?></td>
				  	<td><?php echo $a['pengalokasian']==1?($a['nominal']):0;?></td>
				  	<td><?php echo $a['pengalokasian']==2?($a['nominal']):0;?></td>
				  	<td><?php echo $a['pengalokasian']==3?($a['nominal']):0;?></td>
				  	<td><?php echo $a['pengalokasian']==4?($a['nominal']):0;?></td>
				  	<td><?php echo $a['pengalokasian']==5?($a['nominal']):0;?></td>
				  	<td><?php echo $a['keterangan']?></td>
				  </tr>
				<?php } ?>
				<?php } ?>
			<?php } ?>
			<tr>
				<td><b>Total</b></td>
				<td align="center"><b><?php echo ($transfer) ?></b></td>
				<td align="center"><b><?php echo ($kas) ?></b></td>
				<td align="center"><b><?php echo ($bahanbaku) ?></b></td>
				<td align="center"><b><?php echo ($ops) ?></b></td>
				<td align="center"><b><?php echo ($gaji) ?></b></td>
				<td align="center"><b><?php echo ($alokasitransfer) ?></b></td>
				<td align="center"><b><?php echo ($sisa) ?></b></td>
				<td align="center"><b></b></td>
			</tr>
			</tbody>
			</table>