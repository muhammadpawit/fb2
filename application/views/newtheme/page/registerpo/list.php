<div class="row">
	<div class="col-md-6">
		<label>Jenis PO</label>
		<select name="jenis" class="form-control select2bs4" data-live-search="true">
			<option value="*">Semua</option>
			<?php foreach($jenispo as $j){?>
				<option value="<?php echo $j['nama_jenis_po']?>" <?php echo $j['nama_jenis_po']==$jenis?'selected':'';?>><?php echo $j['nama_jenis_po']?></option>
			<?php } ?>
		</select>
	</div>
	<div class="col-md-6">
		<label>Aksi</label><br>
		<button onclick="filter()" class="btn btn-info btn-sm">Filter</button>
		<button onclick="excel()" class="btn btn-info btn-sm">Excel</button>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<table class="table table-bordered" id="datatable">
			<thead class="thead-light">
				<tr>
					<th>No</th>
					<th>Nama PO</th>
					<th>Size</th>
					<th>Nama CMT</th>
					<th>Lokasi CMT</th>
					<th>Tanggal Pengiriman</th>
					<th>Tanggal Setoran</th>
					<th>Tanggal Kirim Gudang</th>
					<th>Keterangan</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($products as $p){?>
					<tr>
						<td><?php echo $p['no']?></td>
						<td><?php echo $p['kode_po']?></td>
						<td><?php echo $p['size']?></td>
						<td><?php echo $p['cmt']?></td>
						<td><?php echo $p['lokasi']?></td>
						<td><?php echo $p['tglkirim']?></td>
						<td><?php echo $p['tglsetor']?></td>
						<td><?php echo $p['tglkirimgudang']?></td>
						<td><?php echo $p['keterangan']?></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
<script type="text/javascript">
	function filter(){
		url='?';
		
	  var filter_status = $('select[name=\'jenis\']').val();

		if (filter_status != '*') {
			url += '&jenis=' + encodeURIComponent(filter_status);
		}
		location =url;
		
	}

	function excel(){
		url='?&excel=1&';
		
	  var filter_status = $('select[name=\'jenis\']').val();

		if (filter_status != '*') {
			url += '&jenis=' + encodeURIComponent(filter_status);
		}
		location =url;
		
	}
</script>