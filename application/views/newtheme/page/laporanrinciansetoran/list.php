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
	<div class="col-md-2">
		<div class="form-group">
			<label>Tanggal Awal</label>
			<input type="text" name="tanggal1" id="tanggal1" value="<?php echo $tanggal1?>" class="form-control">
		</div>
	</div>
	<div class="col-md-2">
		<div class="form-group">
			<label>Tanggal Akhir</label>
			<input type="text" name="tanggal2" id="tanggal2" value="<?php echo $tanggal2?>" class="form-control">
		</div>
	</div>
	<div class="col-md-3">
		<div class="form-group">
			<label>Nama PO</label>
			<input type="text" name="idpo" id="idpo" class="form-control autopoid">
		</div>
	</div>
	<div class="col-md-3">
		<div class="form-group">
			<label>CMT </label>
			<select name="cmt" class="form-control select2bs4" data-live-search="true">
		      <option value="*">Semua</option>
		      <?php foreach($cmt as $c){?>
		        <option value="<?php echo $c['cmt_name']?>"><?php echo $c['cmt_name']?></option>
		      <?php } ?>
		    </select>
		</div>
	</div>
	<div class="col-md-2">
		<div class="form-group">
			<label>Aksi</label><br>
			<button class="btn btn-info btn-sm" onclick="filterwithcmts()">Filter</button>
			<button class="btn btn-info btn-sm" onclick="filterwithcmtexcel()">Excel</button>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>No</th>
					<th>Tanggal Setor</th>
					<th>Nama PO</th>
					<th>Jumlah Potong</th>
					<th>Tanggal Kirim Ke CMT</th>
					<th>Jumlah Kirim (Ke CMT)</th>
					<th>Jumlah Setor (PCS)</th>
					<th>Jumlah Bagus (PCS)</th>
					<th>Rincian (SIZE)</th>
					<th>Bangke (PCS)</th>
					<th>BS</th>
					<th>Cabang</th>
					<th>Nama CMT</th>
					<th>Keterangan</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($prods as $p){?>
					<tr>
						<td><?php echo $p['no']?></td>
						<td><?php echo $p['tanggal']?></td>
						<td><?php echo $p['kode_po']?></td>
						<td><?php echo $p['potong']?></td>
						<td><?php echo $p['tgl_kirim']?></td>
						<td><?php echo $p['pcs_kirim']?></td>
						<td><?php echo $p['pcs_setor']?></td>
						<td><?php echo $p['pcs_bagus']?></td>
						<td>
							<?php foreach($p['size'] as $s){?>
								<?php echo $s['rincian_size']?> : <?php echo $s['rincian_lusin']?> DZ <?php echo $s['rincian_piece']>0?$s['rincian_piece'].' pcs':'';?><br>
							<?php } ?>
						</td>
						<td><?php echo $p['bangke']?></td>
						<td><?php echo $p['bs']?></td>
						<td><?php echo $p['cabang']?></td>
						<td><?php echo $p['cmt']?></td>
						<td><?php echo $p['keterangan']?></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>

<script type="text/javascript">
	function filterwithcmts(){
	    url='?';
	    
	    var filter_date_start = $('input[name=\'tanggal1\']').val();

	    if (filter_date_start) {
	      url += '&tanggal1=' + encodeURIComponent(filter_date_start);
	    }

	    var filter_date_end = $('input[name=\'tanggal2\']').val();

	    if (filter_date_end) {
	      url += '&tanggal2=' + encodeURIComponent(filter_date_end);
	    }

	    var filter_status = $('select[name=\'cmt\']').val();

	    if (filter_status != '*') {
	      url += '&cmt=' + encodeURIComponent(filter_status);
	    }

		var idpo =  $().val();
		if(idpo!=''){
			url +='&idpo='+idpo;
		}

	    location =url;
	  }

	  function filterwithcmtexcel(){
	    url='?&excel=1&cmt=<?php echo $cm ?>';
	    
	    var filter_date_start = $('input[name=\'tanggal1\']').val();

	    if (filter_date_start) {
	      url += '&tanggal1=' + encodeURIComponent(filter_date_start);
	    }

	    var filter_date_end = $('input[name=\'tanggal2\']').val();

	    if (filter_date_end) {
	      url += '&tanggal2=' + encodeURIComponent(filter_date_end);
	    }

	    var filter_status = $('select[name=\'cmt\']').val();

	    if (filter_status != '*') {
	      url += '&cmt=' + encodeURIComponent(filter_status);
	    }

	    
	    location =url;
	  }
</script>