<div class="row">
	<div class="col-md-4">
		<div class="form-group">
			<!-- <label>Tanggal Awal</label>
			<input type="text" name="tanggal1" id="tanggal1" class="form-control datepicker" value="<?php echo $tanggal1?>"> -->
			<label>Bulan</label>
			<select name="bulan" id="bulan" class="form-control select2bs4" data-live-search="true">
				<?php foreach(bulan() as $b=>$val){?>
					<option value="<?php echo $b ?>" <?php echo $b==$bulan?'selected':'';?>><?php echo $val ?></option>
				}
				<?php } ?>
			</select>
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<!-- <label>Tanggal Akhir</label>
			<input type="text" name="tanggal2" id="tanggal2" class="form-control datepicker" value="<?php echo $tanggal2?>"> -->
			<label>Tahun</label>
			<select name="tahun" id="tahun" class="form-control select2bs4" data-live-search="true">
				<?php foreach(tahun() as $t){?>
					<option value="<?php echo $t['tahun'] ?>" <?php echo $t['tahun']==$tahun?'selected':'';?>><?php echo $t['tahun'] ?></option>
				}
				<?php } ?>
			</select>
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label>Aksi</label><br>
			<button onclick="filterbulan()" class="btn btn-info btn-sm">Filter</button>
			<a href="<?php echo $excel?>" class="btn btn-info btn-sm text-white">Excel</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<table class="table table-bordered table-hover nosearch">
			<thead>
				<tr>
					<th>Hari</th>
					<th>Tanggal</th>
					<th>Jml PO</th>
					<th>Nama PO</th>
					<th>Nilai PO (Rp)</th>
				</tr>
			</thead>
			<tbody>
				<?php $jml=0; $nilai=0;?>
				<?php foreach($products as $p){?>
					<tr>
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
						<td><?php echo number_format($p['nilai'])?></td>
					</tr>
				<?php
					$jml+=($p['jml']);
					$nilai+=($p['nilai']);
				?>
				<?php } ?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="2"><b>Total</b></td>
					<td><?php echo $jml?></td>
					<td></td>
					<td><?php echo number_format($nilai)?></td>
				</tr>
			</tfoot>
		</table>
	</div>
</div>