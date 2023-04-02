<div class="row">
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
			<button class="btn btn-info btn-sm" onclick="excelwithtgl()">Excel</button>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<table class="table table-bordered">
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
			    <td ><?php echo number_format($r['transfer'])?></td>
			    <td ><?php echo number_format($r['giro'])?></td>
			    <td ><?php echo number_format($r['kasmasuk'])?></td>
			    <td ><?php echo number_format($r['kaskeluar'])?></td>
			    <td ><?php echo number_format($r['sisakas'])?></td>
			    <td ><?php echo number_format($r['sukabumi'])?></td>
			    <td ><?php echo number_format($r['serang'])?></td>
			    <td ><?php echo number_format($r['jawa'])?></td>
			    <td ><?php echo number_format($r['ajuan'])?></td>
			    <td ><?php echo number_format($r['girokredit'])?></td>
			    <td ><?php echo $r['keterangan']?></td>
			  </tr>
			  <?php $at=$this->LaporanmingguanModel->alokasi_transfer($r['tanggal'],1); ?>
			  	<?php if(!empty($at)){?>
			  	<?php foreach($at as $a){?>
				  <tr>
				  	<td colspan="4"><?php //echo $a['tanggal'];?></td>
				  	<td><?php echo $a['pengalokasian']==6?number_format($a['nominal']):0;?></td>
				  	<td><?php echo $a['pengalokasian']==7?number_format($a['nominal']):0;?></td>
				  	<td><?php echo $a['pengalokasian']==8?number_format($a['nominal']):0;?></td>
				  	<td><?php echo $a['pengalokasian']==9?number_format($a['nominal']):0;?></td>
				  	<td><?php echo $a['pengalokasian']==10?number_format($a['nominal']):0;?></td>
				  	<td><?php echo $a['pengalokasian']==11?number_format($a['nominal']):0;?></td>
				  	<td><?php echo $a['pengalokasian']==20?number_format($a['nominal']):0;?></td>
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
				<td><b><?php echo number_format($transfer) ?></b></td>
				<td><b><?php echo number_format($giro) ?></b></td>
				<td><b><?php echo number_format($kas) ?></b></td>
				<td><b><?php echo number_format($keluar) ?></b></td>
				<td><b><?php echo number_format($sisa) ?></b></td>
				<td><b><?php echo number_format($skb) ?></b></td>
				<td><b><?php echo number_format($serang) ?></b></td>
				<td><b><?php echo number_format($jawa) ?></b></td>
				<td><b><?php echo number_format($ajuan) ?></b></td>
				<td><b><?php echo number_format($girokredit) ?></b></td>
			</tr>
			<tr>
				<td colspan="4" align="center"><b><?php echo number_format($transfer+$giro+$kas)?></b></td>
				<td colspan="7" align="center"><b><?php echo number_format($keluar+$sisa+$skb+$serang+$jawa+$ajuan+$girokredit)?></b></td>
			</tr>
			</tbody>
			</table>
	</div>
</div>