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
			    <td ><?php echo number_format($r['transfer'])?></td>
			    <td ><?php echo number_format($r['kas'])?></td>
			    <td ><?php echo number_format($r['bahanbaku'])?></td>
			    <td ><?php echo number_format($r['inventaris'])?></td>
			    <td ><?php echo number_format($r['ops'])?></td>
			    <td ><?php echo number_format($r['gaji'])?></td>
			    <td ><?php echo number_format($r['sisa'])?></td>
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
				  	<td><?php echo $a['pengalokasian']==12?number_format($a['nominal']):0;?></td>
				  	<td><?php echo $a['pengalokasian']==13?number_format($a['nominal']):0;?></td>
				  	<td><?php echo $a['pengalokasian']==14?number_format($a['nominal']):0;?></td>
				  	<td><?php echo $a['pengalokasian']==15?number_format($a['nominal']):0;?></td>
				  	<td><?php echo $a['pengalokasian']==16?number_format($a['nominal']):0;?></td>
				  	<td><?php echo $a['keterangan']?></td>
				  </tr>
				<?php } ?>
				<?php } ?>
			<?php } ?>
			<tr>
				<td align="center"><b>Total</b></td>
				<td align="center"><b><?php echo number_format($transfer)?></b></td>
				<td align="center"><b><?php echo number_format($kas)?></b></td>
				<td align="center"><b><?php echo number_format($bahanbaku)?></b></td>
				<td align="center"><b><?php echo number_format($inventaris)?></b></td>
				<td align="center"><b><?php echo number_format($ops)?></b></td>
				<td align="center"><b><?php echo number_format($gaji)?></b></td>
				<td align="center"><b><?php echo number_format($sisa)?></b></td>
				<td></td>
			</tr>
			</tbody>
			<tfoot>
				<tr>
					<td align="center"><b>Grand Total</b></td>
					<td align="center" colspan="2"><b><?php echo number_format($transfer+$kas)?></b></td>
					<td align="center"><b><?php echo number_format($bahanbaku+$inventaris+$ops+$gaji+$sisa)?></b></td>
				</tr>
			</tfoot>
			</table>
	</div>
</div>