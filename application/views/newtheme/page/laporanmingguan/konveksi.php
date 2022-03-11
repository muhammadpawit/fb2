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
			    <th colspan="3">Debet</th>
			    <th colspan="6">Kredit</th>
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
			  </tr>
			</thead>
			<tbody>
			<?php foreach($results as $r){?>
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
			    <td ><?php echo $r['keterangan']?></td>
			  </tr>
			<?php } ?>
			</tbody>
			</table>
	</div>
</div>