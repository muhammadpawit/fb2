<div class="row">
  <div class="col-md-12">
    <?php if ($this->session->flashdata('msg')) { ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
     	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
        	<span aria-hidden="true">×</span>
        </button>
		<?php echo $this->session->flashdata('msg'); ?> 
    </div>
    <?php } ?>
  </div>
</div>
<div class="row">
	<div class="col-md-4">
		<div class="form-group">
			<label>Tanggal Awal</label>
			<input type="date" name="tanggal1" id="tanggal1" value="<?php echo $tanggal1?>" class="form-control">
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label>Tanggal Akhir</label>
			<input type="date" name="tanggal2" id="tanggal2" value="<?php echo $tanggal2?>" class="form-control">
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label>Aksi</label><br>
			<button class="btn btn-info btn-sm" onclick="filtertglonly()">Filter</button>
			<button class="btn btn-info btn-sm" onclick="excelcatatan()">Excel Catatan</button>
			<button class="btn btn-info btn-sm" onclick="excel()">Excel Total</button>
			<a href="<?php echo $tambah?>" class="btn btn-info btn-sm text-white">Tambah</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="table-responsive">
			<table class="table table-bordered nosearch">
				<thead>
					<tr>
						<th>No</th>
						<th>Tanggal</th>
						<th>Bagian</th>
						<th>Nama</th>
						<th>Mulai</th>
						<th>Selesai</th>
						<th>Jumlah Jam Lembur</th>
						<th>Upah Lembur/jam</th>
						<th>Total</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($products as $p){?>
						<tr>
							<td><?php echo $p['no']?></td>
							<td><?php echo $p['tanggal']?></td>
							<td><?php echo $p['bagian']?></td>
							<td><?php echo $p['nama']?></td>
							<td><?php echo $p['mulai']?></td>
							<td><?php echo $p['selesai']?></td>
							<td><?php echo $p['jam']?></td>
							<td><?php echo number_format($p['upah'])?></td>
							<td><?php echo number_format($p['total'])?></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script type="text/javascript">
	function excel(){
		url='?excel=1';
    
	    var filter_date_start = $('input[name=\'tanggal1\']').val();

	    if (filter_date_start) {
	      url += '&tanggal1=' + encodeURIComponent(filter_date_start);
	    }

	    var filter_date_end = $('input[name=\'tanggal2\']').val();

	    if (filter_date_end) {
	      url += '&tanggal2=' + encodeURIComponent(filter_date_end);
	    }
		location =url;
	}

	function excelcatatan(){
		url='?excelcatatan=1';
    
	    var filter_date_start = $('input[name=\'tanggal1\']').val();

	    if (filter_date_start) {
	      url += '&tanggal1=' + encodeURIComponent(filter_date_start);
	    }

	    var filter_date_end = $('input[name=\'tanggal2\']').val();

	    if (filter_date_end) {
	      url += '&tanggal2=' + encodeURIComponent(filter_date_end);
	    }
		location =url;
	}
</script>