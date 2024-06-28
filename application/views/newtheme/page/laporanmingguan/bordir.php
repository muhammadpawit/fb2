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
					

				?>
			  <tr>
			    <td ><?php echo $r['hari']?>, <?php echo $r['tanggal']?></td>
			    <td ><?php echo number_format($r['transfer'])?></td>
			    <td ><?php echo number_format($r['kas'])?></td>
			    <td ><?php echo number_format($r['bahanbaku'])?></td>
			    <td ><?php echo number_format($r['ops'])?></td>
			    <td ><?php echo number_format($r['gaji'])?></td>
			    <td ><?php echo number_format($r['alokasitransfer'])?></td>
			    <td ><?php echo number_format($r['sisa'])?></td>
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
				  	<td><?php echo $a['pengalokasian']==1?number_format($a['nominal']):0;?></td>
				  	<td><?php echo $a['pengalokasian']==2?number_format($a['nominal']):0;?></td>
				  	<td><?php echo $a['pengalokasian']==3?number_format($a['nominal']):0;?></td>
				  	<td><?php echo $a['pengalokasian']==4?number_format($a['nominal']):0;?></td>
				  	<td><?php echo $a['pengalokasian']==5?number_format($a['nominal']):0;?></td>
				  	<td><?php echo $a['keterangan']?></td>
				  </tr>
				<?php } ?>
				<?php } ?>
			<?php } ?>
			<tr>
				<td><b>Total</b></td>
				<td align="center"><b><?php echo number_format($transfer) ?></b></td>
				<td align="center"><b><?php echo number_format($kas) ?></b></td>
				<td align="center"><b><?php echo number_format($bahanbaku) ?></b></td>
				<td align="center"><b><?php echo number_format($ops) ?></b></td>
				<td align="center"><b><?php echo number_format($gaji) ?></b></td>
				<td align="center"><b><?php echo number_format($alokasitransfer) ?></b></td>
				<td align="center"><b><?php echo number_format($sisa) ?></b></td>
				<td align="center"><b></b></td>
			</tr>
			</tbody>
			<tfoot>
			
			<tr>
				<td><b>Grand Total</b></td>
				<td colspan="2" align="center"><b><?php echo number_format($transfer+$kas) ?></b></td>
				<td align="center"><b><?php echo number_format($bahanbaku+$ops+$gaji+$alokasitransfer+$sisa) ?></b></td>
			</tr>
			</tfoot>
			</table>
	</div>
</div>