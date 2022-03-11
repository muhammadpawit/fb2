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
			<?php foreach($results as $r){?>
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
			<?php } ?>
			</tbody>
			</table>
	</div>
</div>