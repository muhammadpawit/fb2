<div class="row no-print">
	<div class="col-md-4">
		<div class="form-group">
			<label>Tanggal Awal</label>
			<input type="text" name="tanggal1" id="tanggal1" class="form-control" value="<?php echo $tanggal1?>">
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label>Tanggal Akhir</label>
			<input type="text" name="tanggal2" id="tanggal2" class="form-control" value="<?php echo $tanggal2?>">
		</div>
	</div>
	<div class="col-md-4">
		<label>Aksi</label><br>
		<button class="btn btn-info btn-sm text-white" onclick="filter()">Filter</button>
	</div>
</div>
<!-- Potongan -->
<div class="row">
	<div class="col-md-12">
		<div class="table-responsive">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th colspan="39">Potongan</th>
					</tr>
					<tr>
						<th rowspan="3" style="text-align: center;vertical-align: middle;">No</th>
						<th rowspan="3" style="text-align: center;vertical-align: middle;">CMT</th>
						<th colspan="34" style="text-align: center;">Rincian PO</th>
						<th rowspan="3" style="text-align: center;vertical-align: middle;">Jumlah PO</th>
						<th rowspan="3" style="text-align: center;vertical-align: middle;">Jumlah Pcs</th>
					</tr>
					<tr style="text-align: center;">
						<th colspan="8">Oblong ( KD dan FB )</th>
						<th colspan="4">Oblong ( P & 3/4 )</th>
						<th rowspan="3" style="vertical-align: middle;text-align: center;">HGK</th>
						<th rowspan="3" style="vertical-align: middle;text-align: center;">Pcs</th>
						<th rowspan="3" style="vertical-align: middle;text-align: center;">Joger</th>
						<th rowspan="3" style="vertical-align: middle;text-align: center;">Pcs</th>
						<th rowspan="3" style="vertical-align: middle;text-align: center;">KDS 4-5</th>
						<th rowspan="3" style="vertical-align: middle;text-align: center;">Pcs</th>
						<th rowspan="3" style="vertical-align: middle;text-align: center;">KDS 0-6</th>
						<th rowspan="3" style="vertical-align: middle;text-align: center;">Pcs</th>
						<th rowspan="3" style="vertical-align: middle;text-align: center;">KDS 1-12</th>
						<th rowspan="3" style="vertical-align: middle;text-align: center;">Pcs</th>
						<th rowspan="3" style="vertical-align: middle;text-align: center;">KDS 4-6</th>
						<th rowspan="3" style="vertical-align: middle;text-align: center;">Pcs</th>
						<th rowspan="3" style="vertical-align: middle;text-align: center;">KDS 3-15</th>
						<th rowspan="3" style="vertical-align: middle;text-align: center;">Pcs</th>
						<th rowspan="3" style="vertical-align: middle;text-align: center;">St Wan</th>
						<th rowspan="3" style="vertical-align: middle;text-align: center;">Pcs</th>
						<th rowspan="3" style="vertical-align: middle;text-align: center;">KDW</th>
						<th rowspan="3" style="vertical-align: middle;text-align: center;">Pcs</th>
						<th rowspan="3" style="vertical-align: middle;text-align: center;">FBS</th>
						<th rowspan="3" style="vertical-align: middle;text-align: center;">Pcs</th>
						<th rowspan="3" style="vertical-align: middle;text-align: center;">FBW</th>
						<th rowspan="3" style="vertical-align: middle;text-align: center;">Pcs</th>
					</tr>
					<tr style="text-align: center;">
						<th>Biasa</th>
						<th>Pcs</th>
						<th>KDT</th>
						<th>Pcs</th>
						<th>HGO</th>
						<th>Pcs</th>
						<th>FBO</th>
						<th>Pcs</th>
						<th>Biasa</th>
						<th>Pcs</th>
						<th>Reglan</th>
						<th>Pcs</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($potongan as $pt){?>
					<tr>
						<td><?php echo $pt['no']?></td>
						<td><?php echo $pt['cmt']?></td>
						<td><?php echo $pt['biasa']?></td>
						<td><?php echo $pt['biasapcs']?></td>
						<td><?php echo $pt['kdt']?></td>
						<td><?php echo $pt['kdtpcs']?></td>
						<td><?php echo $pt['hgo']?></td>
						<td><?php echo $pt['hgopcs']?></td>
						<td><?php echo $pt['fbo']?></td>
						<td><?php echo $pt['fbopcs']?></td>
						<td><?php echo $pt['biasa34']?></td>
						<td><?php echo $pt['biasa34pcs']?></td>
						<td><?php echo $pt['reglan']?></td>
						<td><?php echo $pt['reglanpcs']?></td>
						<td><?php echo $pt['hgk']?></td>
						<td><?php echo $pt['hgkpcs']?></td>
						<td><?php echo $pt['joger']?></td>
						<td><?php echo $pt['jogerpcs']?></td>
						<td><?php echo $pt['kds415']?></td>
						<td><?php echo $pt['kds415pcs']?></td>
						<td><?php echo $pt['kds06']?></td>
						<td><?php echo $pt['kds06pcs']?></td>
						<td><?php echo $pt['kds112']?></td>
						<td><?php echo $pt['kds112pcs']?></td>
						<td><?php echo $pt['kds46']?></td>
						<td><?php echo $pt['kds46pcs']?></td>
						<td><?php echo $pt['kds1315']?></td>
						<td><?php echo $pt['kds1315pcs']?></td>
						<td><?php echo $pt['stwan']?></td>
						<td><?php echo $pt['stwanpcs']?></td>
						<td><?php echo $pt['kdw']?></td>
						<td><?php echo $pt['kdwpcs']?></td>
						<td><?php echo $pt['fbs']?></td>
						<td><?php echo $pt['fbspcs']?></td>
						<td><?php echo $pt['fbw']?></td>
						<td><?php echo $pt['fbwpcs']?></td>
						<td><?php echo $pt['jmlglobal']?></td>
						<td><?php echo $pt['jmlglobalpcs']?></td>
					</tr>
					<tr>
						<td></td>
						<td><b>Jumlah</b></td>
						<td><?php echo $pt['biasa']?></td>
						<td><?php echo $pt['biasapcs']?></td>
						<td><?php echo $pt['kdt']?></td>
						<td><?php echo $pt['kdtpcs']?></td>
						<td><?php echo $pt['hgo']?></td>
						<td><?php echo $pt['hgopcs']?></td>
						<td><?php echo $pt['fbo']?></td>
						<td><?php echo $pt['fbopcs']?></td>
						<td><?php echo $pt['biasa34']?></td>
						<td><?php echo $pt['biasa34pcs']?></td>
						<td><?php echo $pt['reglan']?></td>
						<td><?php echo $pt['reglanpcs']?></td>
						<td><?php echo $pt['hgk']?></td>
						<td><?php echo $pt['hgkpcs']?></td>
						<td><?php echo $pt['joger']?></td>
						<td><?php echo $pt['jogerpcs']?></td>
						<td><?php echo $pt['kds415']?></td>
						<td><?php echo $pt['kds415pcs']?></td>
						<td><?php echo $pt['kds06']?></td>
						<td><?php echo $pt['kds06pcs']?></td>
						<td><?php echo $pt['kds112']?></td>
						<td><?php echo $pt['kds112pcs']?></td>
						<td><?php echo $pt['kds46']?></td>
						<td><?php echo $pt['kds46pcs']?></td>
						<td><?php echo $pt['kds1315']?></td>
						<td><?php echo $pt['kds1315pcs']?></td>
						<td><?php echo $pt['stwan']?></td>
						<td><?php echo $pt['stwanpcs']?></td>
						<td><?php echo $pt['kdw']?></td>
						<td><?php echo $pt['kdwpcs']?></td>
						<td><?php echo $pt['fbs']?></td>
						<td><?php echo $pt['fbspcs']?></td>
						<td><?php echo $pt['fbw']?></td>
						<td><?php echo $pt['fbwpcs']?></td>
						<td><?php echo $pt['jmlglobal']?></td>
						<td><?php echo $pt['jmlglobalpcs']?></td>
					</tr>
					<tr>
						<td></td>
						<td><b>Kirim</b></td>
						<td><?php echo $pt['biasa']?></td>
						<td><?php echo $pt['biasapcs']?></td>
						<td><?php echo $pt['kdt']?></td>
						<td><?php echo $pt['kdtpcs']?></td>
						<td><?php echo $pt['hgo']?></td>
						<td><?php echo $pt['hgopcs']?></td>
						<td><?php echo $pt['fbo']?></td>
						<td><?php echo $pt['fbopcs']?></td>
						<td><?php echo $pt['biasa34']?></td>
						<td><?php echo $pt['biasa34pcs']?></td>
						<td><?php echo $pt['reglan']?></td>
						<td><?php echo $pt['reglanpcs']?></td>
						<td><?php echo $pt['hgk']?></td>
						<td><?php echo $pt['hgkpcs']?></td>
						<td><?php echo $pt['joger']?></td>
						<td><?php echo $pt['jogerpcs']?></td>
						<td><?php echo $pt['kds415']?></td>
						<td><?php echo $pt['kds415pcs']?></td>
						<td><?php echo $pt['kds06']?></td>
						<td><?php echo $pt['kds06pcs']?></td>
						<td><?php echo $pt['kds112']?></td>
						<td><?php echo $pt['kds112pcs']?></td>
						<td><?php echo $pt['kds46']?></td>
						<td><?php echo $pt['kds46pcs']?></td>
						<td><?php echo $pt['kds1315']?></td>
						<td><?php echo $pt['kds1315pcs']?></td>
						<td><?php echo $pt['stwan']?></td>
						<td><?php echo $pt['stwanpcs']?></td>
						<td><?php echo $pt['kdw']?></td>
						<td><?php echo $pt['kdwpcs']?></td>
						<td><?php echo $pt['fbs']?></td>
						<td><?php echo $pt['fbspcs']?></td>
						<td><?php echo $pt['fbw']?></td>
						<td><?php echo $pt['fbwpcs']?></td>
						<td><?php echo $pt['jmlglobal']?></td>
						<td><?php echo $pt['jmlglobalpcs']?></td>
					</tr>
					<tr>
						<td></td>
						<td><b>Stok Akhir</b></td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
					</tr>
					<?php  } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<!-- end potongan -->

<!-- Pengecekan -->
<div class="row">
	<div class="col-md-12">
		<div class="table-responsive">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th colspan="39">Qc Potongan</th>
					</tr>
					<tr>
						<th rowspan="3" style="text-align: center;vertical-align: middle;">No</th>
						<th rowspan="3" style="text-align: center;vertical-align: middle;">CMT</th>
						<th colspan="34" style="text-align: center;">Rincian PO</th>
						<th rowspan="3" style="text-align: center;vertical-align: middle;">Jumlah PO</th>
						<th rowspan="3" style="text-align: center;vertical-align: middle;">Jumlah Pcs</th>
					</tr>
					<tr style="text-align: center;">
						<th colspan="8">Oblong ( KD dan FB )</th>
						<th colspan="4">Oblong ( P & 3/4 )</th>
						<th rowspan="3" style="vertical-align: middle;text-align: center;">HGK</th>
						<th rowspan="3" style="vertical-align: middle;text-align: center;">Pcs</th>
						<th rowspan="3" style="vertical-align: middle;text-align: center;">Joger</th>
						<th rowspan="3" style="vertical-align: middle;text-align: center;">Pcs</th>
						<th rowspan="3" style="vertical-align: middle;text-align: center;">KDS 4-5</th>
						<th rowspan="3" style="vertical-align: middle;text-align: center;">Pcs</th>
						<th rowspan="3" style="vertical-align: middle;text-align: center;">KDS 0-6</th>
						<th rowspan="3" style="vertical-align: middle;text-align: center;">Pcs</th>
						<th rowspan="3" style="vertical-align: middle;text-align: center;">KDS 1-12</th>
						<th rowspan="3" style="vertical-align: middle;text-align: center;">Pcs</th>
						<th rowspan="3" style="vertical-align: middle;text-align: center;">KDS 4-6</th>
						<th rowspan="3" style="vertical-align: middle;text-align: center;">Pcs</th>
						<th rowspan="3" style="vertical-align: middle;text-align: center;">KDS 3-15</th>
						<th rowspan="3" style="vertical-align: middle;text-align: center;">Pcs</th>
						<th rowspan="3" style="vertical-align: middle;text-align: center;">St Wan</th>
						<th rowspan="3" style="vertical-align: middle;text-align: center;">Pcs</th>
						<th rowspan="3" style="vertical-align: middle;text-align: center;">KDW</th>
						<th rowspan="3" style="vertical-align: middle;text-align: center;">Pcs</th>
						<th rowspan="3" style="vertical-align: middle;text-align: center;">FBS</th>
						<th rowspan="3" style="vertical-align: middle;text-align: center;">Pcs</th>
						<th rowspan="3" style="vertical-align: middle;text-align: center;">FBW</th>
						<th rowspan="3" style="vertical-align: middle;text-align: center;">Pcs</th>
					</tr>
					<tr style="text-align: center;">
						<th>Biasa</th>
						<th>Pcs</th>
						<th>KDT</th>
						<th>Pcs</th>
						<th>HGO</th>
						<th>Pcs</th>
						<th>FBO</th>
						<th>Pcs</th>
						<th>Biasa</th>
						<th>Pcs</th>
						<th>Reglan</th>
						<th>Pcs</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($pengecekan as $pt){?>
					<tr>
						<td>1</td>
						<td><b>Jumlah</b></td>
						<td><?php echo $pt['biasa']?></td>
						<td><?php echo $pt['biasapcs']?></td>
						<td><?php echo $pt['kdt']?></td>
						<td><?php echo $pt['kdtpcs']?></td>
						<td><?php echo $pt['hgo']?></td>
						<td><?php echo $pt['hgopcs']?></td>
						<td><?php echo $pt['fbo']?></td>
						<td><?php echo $pt['fbopcs']?></td>
						<td><?php echo $pt['biasa34']?></td>
						<td><?php echo $pt['biasa34pcs']?></td>
						<td><?php echo $pt['reglan']?></td>
						<td><?php echo $pt['reglanpcs']?></td>
						<td><?php echo $pt['hgk']?></td>
						<td><?php echo $pt['hgkpcs']?></td>
						<td><?php echo $pt['joger']?></td>
						<td><?php echo $pt['jogerpcs']?></td>
						<td><?php echo $pt['kds415']?></td>
						<td><?php echo $pt['kds415pcs']?></td>
						<td><?php echo $pt['kds06']?></td>
						<td><?php echo $pt['kds06pcs']?></td>
						<td><?php echo $pt['kds112']?></td>
						<td><?php echo $pt['kds112pcs']?></td>
						<td><?php echo $pt['kds46']?></td>
						<td><?php echo $pt['kds46pcs']?></td>
						<td><?php echo $pt['kds1315']?></td>
						<td><?php echo $pt['kds1315pcs']?></td>
						<td><?php echo $pt['stwan']?></td>
						<td><?php echo $pt['stwanpcs']?></td>
						<td><?php echo $pt['kdw']?></td>
						<td><?php echo $pt['kdwpcs']?></td>
						<td><?php echo $pt['fbs']?></td>
						<td><?php echo $pt['fbspcs']?></td>
						<td><?php echo $pt['fbw']?></td>
						<td><?php echo $pt['fbwpcs']?></td>
						<td><?php echo $pt['jmlglobal']?></td>
						<td><?php echo $pt['jmlglobalpcs']?></td>
					</tr>
					<tr>
						<td></td>
						<td><b>Kirim</b></td>
						<td><?php echo $pt['biasa']?></td>
						<td><?php echo $pt['biasapcs']?></td>
						<td><?php echo $pt['kdt']?></td>
						<td><?php echo $pt['kdtpcs']?></td>
						<td><?php echo $pt['hgo']?></td>
						<td><?php echo $pt['hgopcs']?></td>
						<td><?php echo $pt['fbo']?></td>
						<td><?php echo $pt['fbopcs']?></td>
						<td><?php echo $pt['biasa34']?></td>
						<td><?php echo $pt['biasa34pcs']?></td>
						<td><?php echo $pt['reglan']?></td>
						<td><?php echo $pt['reglanpcs']?></td>
						<td><?php echo $pt['hgk']?></td>
						<td><?php echo $pt['hgkpcs']?></td>
						<td><?php echo $pt['joger']?></td>
						<td><?php echo $pt['jogerpcs']?></td>
						<td><?php echo $pt['kds415']?></td>
						<td><?php echo $pt['kds415pcs']?></td>
						<td><?php echo $pt['kds06']?></td>
						<td><?php echo $pt['kds06pcs']?></td>
						<td><?php echo $pt['kds112']?></td>
						<td><?php echo $pt['kds112pcs']?></td>
						<td><?php echo $pt['kds46']?></td>
						<td><?php echo $pt['kds46pcs']?></td>
						<td><?php echo $pt['kds1315']?></td>
						<td><?php echo $pt['kds1315pcs']?></td>
						<td><?php echo $pt['stwan']?></td>
						<td><?php echo $pt['stwanpcs']?></td>
						<td><?php echo $pt['kdw']?></td>
						<td><?php echo $pt['kdwpcs']?></td>
						<td><?php echo $pt['fbs']?></td>
						<td><?php echo $pt['fbspcs']?></td>
						<td><?php echo $pt['fbw']?></td>
						<td><?php echo $pt['fbwpcs']?></td>
						<td><?php echo $pt['jmlglobal']?></td>
						<td><?php echo $pt['jmlglobalpcs']?></td>
					</tr>
					<tr>
						<td></td>
						<td><b>Stok Akhir</b></td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
					</tr>
					<?php  } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<!-- Pengecekan -->

<!-- Sablon -->
<div class="row">
	<div class="col-md-12">
		<div class="table-responsive">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th colspan="39">Sablon</th>
					</tr>
					<tr>
						<th rowspan="3" style="text-align: center;vertical-align: middle;">No</th>
						<th rowspan="3" style="text-align: center;vertical-align: middle;">CMT</th>
						<th colspan="34" style="text-align: center;">Rincian PO</th>
						<th rowspan="3" style="text-align: center;vertical-align: middle;">Jumlah PO</th>
						<th rowspan="3" style="text-align: center;vertical-align: middle;">Jumlah Pcs</th>
					</tr>
					<tr style="text-align: center;">
						<th colspan="8">Oblong ( KD dan FB )</th>
						<th colspan="4">Oblong ( P & 3/4 )</th>
						<th rowspan="3" style="vertical-align: middle;text-align: center;">HGK</th>
						<th rowspan="3" style="vertical-align: middle;text-align: center;">Pcs</th>
						<th rowspan="3" style="vertical-align: middle;text-align: center;">Joger</th>
						<th rowspan="3" style="vertical-align: middle;text-align: center;">Pcs</th>
						<th rowspan="3" style="vertical-align: middle;text-align: center;">KDS 4-5</th>
						<th rowspan="3" style="vertical-align: middle;text-align: center;">Pcs</th>
						<th rowspan="3" style="vertical-align: middle;text-align: center;">KDS 0-6</th>
						<th rowspan="3" style="vertical-align: middle;text-align: center;">Pcs</th>
						<th rowspan="3" style="vertical-align: middle;text-align: center;">KDS 1-12</th>
						<th rowspan="3" style="vertical-align: middle;text-align: center;">Pcs</th>
						<th rowspan="3" style="vertical-align: middle;text-align: center;">KDS 4-6</th>
						<th rowspan="3" style="vertical-align: middle;text-align: center;">Pcs</th>
						<th rowspan="3" style="vertical-align: middle;text-align: center;">KDS 3-15</th>
						<th rowspan="3" style="vertical-align: middle;text-align: center;">Pcs</th>
						<th rowspan="3" style="vertical-align: middle;text-align: center;">St Wan</th>
						<th rowspan="3" style="vertical-align: middle;text-align: center;">Pcs</th>
						<th rowspan="3" style="vertical-align: middle;text-align: center;">KDW</th>
						<th rowspan="3" style="vertical-align: middle;text-align: center;">Pcs</th>
						<th rowspan="3" style="vertical-align: middle;text-align: center;">FBS</th>
						<th rowspan="3" style="vertical-align: middle;text-align: center;">Pcs</th>
						<th rowspan="3" style="vertical-align: middle;text-align: center;">FBW</th>
						<th rowspan="3" style="vertical-align: middle;text-align: center;">Pcs</th>
					</tr>
					<tr style="text-align: center;">
						<th>Biasa</th>
						<th>Pcs</th>
						<th>KDT</th>
						<th>Pcs</th>
						<th>HGO</th>
						<th>Pcs</th>
						<th>FBO</th>
						<th>Pcs</th>
						<th>Biasa</th>
						<th>Pcs</th>
						<th>Reglan</th>
						<th>Pcs</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($sablon as $pt){?>
					<tr>
						<td><?php echo $pt['no']?></td>
						<td><b><?php echo $pt['cmt']?></b></td>
						<td><?php echo $pt['biasa']?></td>
						<td><?php echo $pt['biasapcs']?></td>
						<td><?php echo $pt['kdt']?></td>
						<td><?php echo $pt['kdtpcs']?></td>
						<td><?php echo $pt['hgo']?></td>
						<td><?php echo $pt['hgopcs']?></td>
						<td><?php echo $pt['fbo']?></td>
						<td><?php echo $pt['fbopcs']?></td>
						<td><?php echo $pt['biasa34']?></td>
						<td><?php echo $pt['biasa34pcs']?></td>
						<td><?php echo $pt['reglan']?></td>
						<td><?php echo $pt['reglanpcs']?></td>
						<td><?php echo $pt['hgk']?></td>
						<td><?php echo $pt['hgkpcs']?></td>
						<td><?php echo $pt['joger']?></td>
						<td><?php echo $pt['jogerpcs']?></td>
						<td><?php echo $pt['kds415']?></td>
						<td><?php echo $pt['kds415pcs']?></td>
						<td><?php echo $pt['kds06']?></td>
						<td><?php echo $pt['kds06pcs']?></td>
						<td><?php echo $pt['kds112']?></td>
						<td><?php echo $pt['kds112pcs']?></td>
						<td><?php echo $pt['kds46']?></td>
						<td><?php echo $pt['kds46pcs']?></td>
						<td><?php echo $pt['kds1315']?></td>
						<td><?php echo $pt['kds1315pcs']?></td>
						<td><?php echo $pt['stwan']?></td>
						<td><?php echo $pt['stwanpcs']?></td>
						<td><?php echo $pt['kdw']?></td>
						<td><?php echo $pt['kdwpcs']?></td>
						<td><?php echo $pt['fbs']?></td>
						<td><?php echo $pt['fbspcs']?></td>
						<td><?php echo $pt['fbw']?></td>
						<td><?php echo $pt['fbwpcs']?></td>
						<td><?php echo $pt['jmlglobal']?></td>
						<td><?php echo $pt['jmlglobalpcs']?></td>
					</tr>
					<tr>
						<td></td>
						<td>kirim</td>
						<td><?php echo $pt['biasa']?></td>
						<td><?php echo $pt['biasapcs']?></td>
						<td><?php echo $pt['kdt']?></td>
						<td><?php echo $pt['kdtpcs']?></td>
						<td><?php echo $pt['hgo']?></td>
						<td><?php echo $pt['hgopcs']?></td>
						<td><?php echo $pt['fbo']?></td>
						<td><?php echo $pt['fbopcs']?></td>
						<td><?php echo $pt['biasa34']?></td>
						<td><?php echo $pt['biasa34pcs']?></td>
						<td><?php echo $pt['reglan']?></td>
						<td><?php echo $pt['reglanpcs']?></td>
						<td><?php echo $pt['hgk']?></td>
						<td><?php echo $pt['hgkpcs']?></td>
						<td><?php echo $pt['joger']?></td>
						<td><?php echo $pt['jogerpcs']?></td>
						<td><?php echo $pt['kds415']?></td>
						<td><?php echo $pt['kds415pcs']?></td>
						<td><?php echo $pt['kds06']?></td>
						<td><?php echo $pt['kds06pcs']?></td>
						<td><?php echo $pt['kds112']?></td>
						<td><?php echo $pt['kds112pcs']?></td>
						<td><?php echo $pt['kds46']?></td>
						<td><?php echo $pt['kds46pcs']?></td>
						<td><?php echo $pt['kds1315']?></td>
						<td><?php echo $pt['kds1315pcs']?></td>
						<td><?php echo $pt['stwan']?></td>
						<td><?php echo $pt['stwanpcs']?></td>
						<td><?php echo $pt['kdw']?></td>
						<td><?php echo $pt['kdwpcs']?></td>
						<td><?php echo $pt['fbs']?></td>
						<td><?php echo $pt['fbspcs']?></td>
						<td><?php echo $pt['fbw']?></td>
						<td><?php echo $pt['fbwpcs']?></td>
						<td><?php echo $pt['jmlglobal']?></td>
						<td><?php echo $pt['jmlglobalpcs']?></td>
					</tr>
					<tr>
						<td></td>
						<td>setor</td>
						<td><?php echo $pt['sbiasa']?></td>
						<td><?php echo $pt['sbiasapcs']?></td>
						<td><?php echo $pt['skdt']?></td>
						<td><?php echo $pt['skdtpcs']?></td>
						<td><?php echo $pt['shgo']?></td>
						<td><?php echo $pt['shgopcs']?></td>
						<td><?php echo $pt['sfbo']?></td>
						<td><?php echo $pt['sfbopcs']?></td>
						<td><?php echo $pt['sbiasa34']?></td>
						<td><?php echo $pt['sbiasa34pcs']?></td>
						<td><?php echo $pt['sreglan']?></td>
						<td><?php echo $pt['sreglanpcs']?></td>
						<td><?php echo $pt['shgk']?></td>
						<td><?php echo $pt['shgkpcs']?></td>
						<td><?php echo $pt['sjoger']?></td>
						<td><?php echo $pt['sjogerpcs']?></td>
						<td><?php echo $pt['skds415']?></td>
						<td><?php echo $pt['skds415pcs']?></td>
						<td><?php echo $pt['skds06']?></td>
						<td><?php echo $pt['skds06pcs']?></td>
						<td><?php echo $pt['skds112']?></td>
						<td><?php echo $pt['skds112pcs']?></td>
						<td><?php echo $pt['skds46']?></td>
						<td><?php echo $pt['skds46pcs']?></td>
						<td><?php echo $pt['skds1315']?></td>
						<td><?php echo $pt['skds1315pcs']?></td>
						<td><?php echo $pt['sstwan']?></td>
						<td><?php echo $pt['sstwanpcs']?></td>
						<td><?php echo $pt['skdw']?></td>
						<td><?php echo $pt['skdwpcs']?></td>
						<td><?php echo $pt['sfbs']?></td>
						<td><?php echo $pt['sfbspcs']?></td>
						<td><?php echo $pt['sfbw']?></td>
						<td><?php echo $pt['sfbwpcs']?></td>
						<td><?php echo $pt['sjmlglobal']?></td>
						<td><?php echo $pt['sjmlglobalpcs']?></td>
					</tr>
					<?php  } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<!-- end sablon -->
<script type="text/javascript">
	function filter(){
		var url='?';
		var tanggal1 =$("#tanggal1").val();
		var tanggal2 =$("#tanggal2").val();
		 if(tanggal1){
	      url+='&tanggal1='+tanggal1;
	    }

	    if(tanggal2){
	      url+='&tanggal2='+tanggal2;
	    }

	    location = url;
	}
</script>