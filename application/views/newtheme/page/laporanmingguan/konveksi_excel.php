<?php
$namafile='Laporan_Keuangan_Konveksi'.time();
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=".$namafile.".xls");
?>
<h1>Laporan Keuangan Mingguan Konveksi</h1>
<table border="1" style="width: 100%;border-collapse: collapse;">
			<thead>
			  <tr align="center">
			    <th rowspan="2">Periode</th>
			    <th colspan="3">Debet</th>
			    <th colspan="7">Kredit</th>
			    <th rowspan="2">Keterangan</th>
			  </tr>
			  <tr align="center">
			    <th >Transfer</th>
			    <th >Giro</th>
			    <th >Kas Masuk</th>
			    <th >Kas Keluar</th>
			    <th >Sisa Kas</th>
			    <th >Sukabumi</th>
			    <th >Serang</th>
			    <th >Jawa</th>
			    <th >Ajuan Belanja</th>
			    <th>Giro</th>
			  </tr>
			</thead>
			<tbody>
			<?php $transfer=0;$giro=0;$kas=0;?>
			<?php $masuk=0;$keluar=0;$sisa=0;$skb=0;$serang=0;$jawa=0;$ajuan=0;$girokredit=0;?>
			<?php foreach($results as $r){?>
				<?php $transfer+=($r['transfer']);?>
				<?php $giro+=($r['giro']);?>
				<?php $kas+=($r['kasmasuk']);?>
				<?php $keluar+=($r['kaskeluar']);?>
				<?php $sisa+=($r['sisakas']);?>
				<?php $skb+=($r['sukabumi']);?>
				<?php $serang+=($r['serang']);?>
				<?php $jawa+=($r['jawa']);?>
				<?php $ajuan+=($r['ajuan']);?>
				<?php $girokredit+=($r['girokredit']);?>

			  <tr>
			    <td ><?php echo $r['hari']?>, <?php echo $r['tanggal']?></td>
			    <td ><?php echo ($r['transfer'])?></td>
			    <td ><?php echo ($r['giro'])?></td>
			    <td ><?php echo ($r['kasmasuk'])?></td>
			    <td ><?php echo ($r['kaskeluar'])?></td>
			    <td ><?php echo ($r['sisakas'])?></td>
			    <td ><?php echo ($r['sukabumi'])?></td>
			    <td ><?php echo ($r['serang'])?></td>
			    <td ><?php echo ($r['jawa'])?></td>
			    <td ><?php echo ($r['ajuan'])?></td>
			    <td ><?php echo ($r['girokredit'])?></td>
			    <td ><?php echo $r['keterangan']?></td>
			  </tr>
			  <?php $at=$this->LaporanmingguanModel->alokasi_transfer($r['tanggal'],1); ?>
			  	<?php if(!empty($at)){?>
			  	<?php foreach($at as $a){?>
				  <tr>
				  	<td colspan="4"></td>
				  	<td><?php echo $a['pengalokasian']==6?($a['nominal']):0;?></td>
				  	<td><?php echo $a['pengalokasian']==7?($a['nominal']):0;?></td>
				  	<td><?php echo $a['pengalokasian']==8?($a['nominal']):0;?></td>
				  	<td><?php echo $a['pengalokasian']==9?($a['nominal']):0;?></td>
				  	<td><?php echo $a['pengalokasian']==10?($a['nominal']):0;?></td>
				  	<td><?php echo $a['pengalokasian']==11?($a['nominal']):0;?></td>
				  	<td><?php echo $a['pengalokasian']==20?($a['nominal']):0;?></td>
				  	<td><?php echo $a['keterangan']?></td>
				  </tr>
				<?php } ?>
				<?php } ?>
			  <?php $c=$this->LaporanmingguanModel->alokasi_cash(date('Y-m-d',strtotime($r['tanggal'])),1); ?>
			  	<?php if(!empty($c)){?>
			  		<?php foreach($c as $d){?>
				  <tr>
				  	<td><?php echo $d['tanggal'];?></td>
				  </tr>
				<?php } ?>
				<?php } ?>
			<?php } ?>
			<tr>
				<td><b>Total</b></td>
				<td><b><?php echo ($transfer) ?></b></td>
				<td><b><?php echo ($giro) ?></b></td>
				<td><b><?php echo ($kas) ?></b></td>
				<td><b><?php echo ($keluar) ?></b></td>
				<td><b><?php echo ($sisa) ?></b></td>
				<td><b><?php echo ($skb) ?></b></td>
				<td><b><?php echo ($serang) ?></b></td>
				<td><b><?php echo ($jawa) ?></b></td>
				<td><b><?php echo ($ajuan) ?></b></td>
				<td><b><?php echo ($girokredit) ?></b></td>
			</tr>
			<tr>
				<td colspan="4" align="center"><b><?php echo ($transfer+$giro+$kas)?></b></td>
				<td colspan="7" align="center"><b><?php echo ($keluar+$sisa+$skb+$serang+$jawa+$ajuan+$girokredit)?></b></td>
			</tr>
			</tbody>
			</table>