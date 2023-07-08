<div class="row">
	<div class="col-md-4">
		<div class="form-group">
			<label>Tanggal Awal</label>
			<input type="text" name="tanggal1" id="tanggal1" class="form-control datepicker" value="<?php echo $tanggal1?>">
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label>Tanggal Akhir</label>
			<input type="text" name="tanggal2" id="tanggal2" class="form-control datepicker" value="<?php echo $tanggal2?>">
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label>Aksi</label><br>
			<button onclick="filtertglonly()" class="btn btn-info btn-sm">Filter</button>
			<a href="<?php echo $excel?>" class="btn btn-info btn-sm text-white">Excel</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-8">
		<table class="table table-bordered table-hover">
			<thead>
				<tr style="background-color: #d1869e;">
					<th>No</th>
					<th>Hari</th>
					<th>Tanggal</th>
					<th>Jml PO</th>
					<th>Nama PO</th>
					<th>Jml Dz</th>
					<th>Nilai PO (Rp)</th>
					<th>Keterangan</th>
				</tr>
			</thead>
			<tbody>
				<?php $jml=0; $nilai=0;$dz=0;?>
				<?php foreach($products as $p){?>
					<tr>
							<td><?php echo $p['no']?></td>
							<td>
								<?php

									//if(0==$p['no']){
										echo $p['hari'];
									//}

								?>
								
							</td>
							<td><?php echo $p['tanggal']?></td>
							<td><?php echo $p['jml']?></td>
							<td><?php echo $p['nama']?></td>
							<td><?php //echo number_format($p['dz'],2)?></td>
							<td><?php //echo number_format($p['nilai'])?></td>
							<td><?php echo $p['keterangan']?></td>
					</tr>
					<?php foreach($p['dets'] as $d){ ?>
						<tr>
							<td></td>
							<td>
								<?php

									//if(0==$p['no']){
										//echo $p['hari'];
									//}

								?>
								
							</td>
							<td></td>
							<td><?php echo $d['jml']?></td>
							<td><?php echo $d['nama']?></td>
							<td><?php echo number_format($d['dz'],2)?></td>
							<td><?php echo number_format($d['nilai'])?></td>
							<td><?php echo $d['keterangan']?></td>
						</tr>

						<?php
							$jml+=($d['jml']);
							$nilai+=($d['nilai']);
							$dz+=($d['dz']);
						?>
					<?php } ?>
				
				<?php } ?>
			</tbody>
			<tfoot>
				<tr style="background-color: yellow;font-weight:700">
					<td colspan="3" align="center"><b>Total</b></td>
					<td><?php echo $jml?></td>
					<td></td>
					<td><?php echo number_format($dz,2)?></td>
					<td><?php echo number_format($nilai)?></td>
					<td></td>
				</tr>
				<tr>
					<td colspan="2"><b>Di update terakhir</b></td>
					<td colspan="5">
						<?php if(!empty($log)){ ?>
							<b>Tanggal : <?php echo date('d F Y',strtotime($log['created_date'])) ?></b>
						<?php } ?>
					</td>
				</tr>
			</tfoot>
		</table>
	</div>
	<div class="col-md-4">
		<hr>
		<table class="table table-bordered table-hover">
			<thead style="background-color: yellow">
				<tr>
					<th>Resume</th>
					<th>PO</th>
					<th>JML</th>
					<th>DZ</th>
				</tr>
			</thead>
			<tbody>
				<?php $jmlkaos=0;$jmlkemeja=0;$jmldzk=0;$jmldzkmj=0;?>
				<?php foreach($resume as $r){?>
					<?php if($r['id']==1){?>
					<tr>
						<td></td>
						<td><?php echo $r['nama']?></td>
						<td><?php echo $r['jml']?></td>
						<td><?php echo number_format($r['dz'],2)?></td>
						<?php 
							$jmlkaos+=$r['jml'];
							$jmldzk+=($r['dz']);
						?>
					</tr>
					<?php } ?>
				<?php }?>
				<tr style="background-color: yellow">
					<td colspan="2"><b>Jumlah Kemeja</b></td>
					<td><b><?php echo $jmlkaos?></b></td>
					<td><b><?php echo number_format($jmldzk,2)?></b></td>
				</tr>
				<?php foreach($resume as $r){?>
					<?php if($r['id']==2){?>
					<tr>
						<td></td>
						<td><?php echo $r['nama']?></td>
						<td><?php echo $r['jml']?></td>
						<td><?php echo number_format($r['dz'],2)?></td>
						<?php 
							$jmlkemeja+=$r['jml'];
							$jmldzkmj+=($r['dz']);
						?>
					</tr>
					<?php } ?>
				<?php }?>
					<tr style="background-color: yellow">
						<td colspan="2"><b>Jumlah Kaos</b></td>
						<td><b><?php echo $jmlkemeja?></b></td>
						<td><b><?php echo number_format($jmldzkmj,2)?></b></td>
					</tr>
				<?php $celana=0;$jmlc=0;?>
				<?php foreach($resume as $r){?>
					<?php if($r['id']==3){?>
					<tr>
						<td></td>
						<td><?php echo $r['nama']?></td>
						<td><?php echo $r['jml']?></td>
						<td><?php echo number_format($r['dz'],2)?></td>
						<?php 
							$celana+=$r['jml'];
							$jmlc+=($r['dz']);
						?>
					</tr>
					<?php } ?>
				<?php }?>
					<tr style="background-color: yellow">
						<td colspan="2"><b>Jumlah Celana</b></td>
						<td><b><?php echo $celana?></b></td>
						<td><b><?php echo number_format($jmlc,2)?></b></td>
					</tr>
					<tr style="background-color: yellow">
						<td colspan="2"><b>Total</b></td>
						<td><b><?php echo round($jmlkemeja+$jmlkaos+$celana)?></b></td>
						<td><b><?php echo number_format(($jmldzk+$jmldzkmj+$jmlc),2)?></b></td>
					</tr>
			</tbody>
		</table>
	</div>
</div>