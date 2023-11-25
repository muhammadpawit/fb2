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
<div class="row table-responsive">
	<div class="col-md-8">
		<table class="" border="1" style="border-collapse: collapse;width:100%;">
			<thead>
				<tr style="background-color: #cdfacf;">
					<th rowspan="2">NO</th>
					<th rowspan="2">Hari/Tanggal</th>
					<th rowspan="2">PO Dikirim</th>
					<th rowspan="2">Jenis PO</th>
					<th colspan="3">Jumlah</th>
					<th rowspan="2">Nilai PO (Rp)</th>
					<th rowspan="2">Keterangan</th>
				</tr>
				<tr style="background-color: #cdfacf;">
					<th>PO</th>
					<th>DZ</th>
					<th>PCS</th>
				</tr>
			</thead>
			<tbody>
				<?php $jml=0; $nilai=0;$dz=0;$gdz=0;$gnilai=0;$pcs=0;$tpcs=0;?>
				<?php foreach($products as $p){?>
					<tr>
							<td><?php echo $p['no']?></td>
							<td>
								<?php

									//if(0==$p['no']){
										echo $p['hari'].'/'.$p['tanggal'];
									//}

								?>
								
							</td>
							<td><?php echo $p['jml'] ?></td>
							<td></td>
							<td></td>
							<td><?php echo $p['dz'] > 0 ? number_format($p['dz'],2):''?></td>
							<td><?php echo $p['dz'] > 0 ? number_format($p['dz']*12):''?></td>
							<td><?php echo $p['dz'] > 0 ? number_format($p['nilai']):''?></td>
							<td><?php echo $p['dz'] > 0 ? $p['keterangan']: ''?></td>
					</tr>
					<?php foreach($p['dets'] as $d){ ?>
						
						<?php if($d['jml'] > 0){ ?>
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
								<td><?php echo $d['nama']?></td>
								<td><?php echo $d['jml']?></td>
								<td><?php echo number_format($d['dz'],2)?></td>
								<td><?php echo number_format($d['dz']*12)?></td>
								<td><?php echo number_format($d['nilai'])?></td>
								<td><?php echo $d['keterangan']?></td>
							</tr>
						<?php } ?>

						<?php
							$jml+=($d['jml']);
							$nilai+=($d['nilai']);
							$dz+=($d['dz']);
							$pcs+=($d['dz']*12);
						?>
					<?php } ?>
					<?php 
						$gdz+=($p['dz']); 
						$gnilai+=($p['nilai']);
						
					?>
				<?php } ?>
			</tbody>
			<tfoot>
				<tr style="background-color: #cdfacf;font-weight:700">
					<td colspan="2" align="center"><b>Total</b></td>
					<td><?php echo $jml?></td>
					<td></td>
					<td><?php echo $jml?></td>
					<td><?php echo number_format($dz+$gdz,2)?></td>
					<td><?php echo number_format(($dz*12)+($gdz*12))?></td>
					<td><?php echo number_format($nilai+$gnilai)?></td>
					<td></td>
				</tr>
				<tr>
					<td colspan="3"><b>Di update terakhir</b></td>
					<td colspan="5">
						<?php if(!empty($log)){ ?>
							<b>Tanggal : <?php echo date('d-m-Y',strtotime($log['created_date'])) ?></b>
						<?php } ?>
					</td>
				</tr>
			</tfoot>
		</table>
	</div>
	<div class="col-md-4">
		<hr>
		<table class="table table-bordered table-hover">
			<thead style="background-color: #cdfacf">
				<tr>
					<th>Resume</th>
					<th>PO</th>
					<th>JML</th>
					<th>DZ</th>
					<th>PCS</th>
				</tr>
			</thead>
			<tbody>
				<?php $jmlkaos=0;$jmlkemeja=0;$jmldzk=0;$jmldzkmj=0;$jmlpcsk=0;$jmlpcskmj=0;?>
				<?php foreach($resume as $r){?>
					<?php if($r['id']==1){?>
					<tr>
						<td></td>
						<td><?php echo $r['nama']?></td>
						<td><?php echo $r['jml']?></td>
						<td><?php echo number_format($r['dz'],2)?></td>
						<td><?php echo number_format($r['dz']*12)?></td>
						<?php 
							$jmlkaos+=$r['jml'];
							$jmldzk+=($r['dz']);
							$jmlpcsk+=($r['dz']*12);
						?>
					</tr>
					<?php } ?>
				<?php }?>
				<tr style="background-color: #cdfacf">
					<td colspan="2"><b>Jumlah Kemeja</b></td>
					<td><b><?php echo $jmlkaos?></b></td>
					<td><b><?php echo number_format($jmldzk,2)?></b></td>
					<td><b><?php echo number_format($jmlpcsk)?></b></td>
				</tr>
				<?php foreach($resume as $r){?>
					<?php if($r['id']==2){?>
					<tr>
						<td></td>
						<td><?php echo $r['nama']?></td>
						<td><?php echo $r['jml']?></td>
						<td><?php echo number_format($r['dz'],2)?></td>
						<td><?php echo number_format($r['dz']*12)?></td>
						<?php 
							$jmlkemeja+=$r['jml'];
							$jmldzkmj+=($r['dz']);
							$jmlpcskmj+=($r['dz']*12);
						?>
					</tr>
					<?php } ?>
				<?php }?>
					<tr style="background-color: #cdfacf">
						<td colspan="2"><b>Jumlah Kaos</b></td>
						<td><b><?php echo $jmlkemeja?></b></td>
						<td><b><?php echo number_format($jmldzkmj,2)?></b></td>
						<td><b><?php echo number_format($jmlpcskmj)?></b></td>
					</tr>
				<?php $celana=0;$jmlc=0;$jmlcpcs=0;?>
				<?php foreach($resume as $r){?>
					<?php if($r['id']==3){?>
					<tr>
						<td></td>
						<td><?php echo $r['nama']?></td>
						<td><?php echo $r['jml']?></td>
						<td><?php echo number_format($r['dz'],2)?></td>
						<td><?php echo number_format($r['dz']*12)?></td>
						<?php 
							$celana+=$r['jml'];
							$jmlc+=($r['dz']);
							$jmlcpcs+=($r['dz']*12);
						?>
					</tr>
					<?php } ?>
				<?php }?>
					<tr style="background-color: #cdfacf">
						<td colspan="2"><b>Jumlah Celana</b></td>
						<td><b><?php echo $celana?></b></td>
						<td><b><?php echo number_format($jmlc,2)?></b></td>
						<td><b><?php echo number_format($jmlcpcs)?></b></td>
					</tr>
					<tr style="background-color: #cdfacf">
						<td colspan="2"><b>Total</b></td>
						<td><b><?php echo round($jmlkemeja+$jmlkaos+$celana)?></b></td>
						<td><b><?php echo number_format(($jmldzk+$jmldzkmj+$jmlc),2)?></b></td>
						<td><b><?php echo number_format(($jmldzk+$jmldzkmj+$jmlc)*12)?></b></td>
					</tr>
			</tbody>
		</table>
	</div>
</div>