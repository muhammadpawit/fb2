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
	<div class="col-md-3">
		<div class="form-group">
			<label>Tanggal Awal</label>
			<input type="text" name="tanggal1" id="tanggal1" value="<?php echo $tanggal1?>" class="form-control">
		</div>
	</div>
	<div class="col-md-3">
		<div class="form-group">
			<label>Tanggal Akhir</label>
			<input type="text" name="tanggal2" id="tanggal2" value="<?php echo $tanggal2?>" class="form-control">
		</div>
	</div>
	<div class="col-md-3">
						<div class="form-group">
                              <label>Supplier</label>
                              <select name="supplier" class="form-control select2bs4" data-live-search="true">
                                <option value="0">Pilih</option>
                                <?php foreach($supplier as $st){?>
                                  <option value="<?php echo $st['id'] ?>"><?php echo $st['nama']?></option>
                                <?php } ?>
                              </select>
                            </div>		
	</div>							
	<div class="col-md-3">
						<div class="form-group">
                              <label>Kategori</label>
                              <select name="kategori" class="form-control select2bs4" data-live-search="true">
									<option value="">Pilih</option>
									<?php foreach($kat as $k){ ?>
										<option value="<?php echo $k['id']?>" <?php echo $kategori==$k['id']?'selected':''?>><?php echo $k['nama']?></option>
									<?php } ?>
                              </select>
                            </div>		
	</div>	
	<div class="col-md-3">
			<div class="form-group">
				<label>Tipe </label>
				<select name="tipe" class="form-control">
					<option value=""></option>
					<option value="1" <?php echo $tipe==1 ? 'selected':'' ?>>Bahan Utuh</option>
					<option value="2" <?php echo $tipe==2 ? 'selected':'' ?>>Bahan Sisa</option>
				</select>
			</div>
	</div>				
	<div class="col-md-3">
			<div class="form-group">
				<label>Status </label>
				<select name="status" class="form-control">
					<option value=""></option>
					<option value="terpakai" <?php echo $status=='terpakai' ? 'selected':'' ?>>Terpakai</option>
					<option value="tidak terpakai" <?php echo $status=='tidak terpakai' ? 'selected':'' ?>>Tidak Terpakai</option>
				</select>
			</div>
	</div>		
	<div class="col-md-3">
		<div class="form-group">
			<label>Aksi</label><br>
			<button class="btn btn-info btn-sm" onclick="filters()">Filter</button>
			<button class="btn btn-info btn-sm" onclick="excels()">Excel</button>
			<!-- <a href="<?php echo $tambah?>" class="btn btn-info btn-sm text-white">Tambah</a> -->
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="table-responsive">
			<caption>Periode : <?php echo date('d F Y',strtotime($tanggal1))?> - <?php echo date('d F Y',strtotime($tanggal2))?></caption>
			<table class="table table-bordered table-striped">
				<thead style="text-align: center;">
		          <tr>
		            <th rowspan="2">No</th>
		            <th rowspan="2">Nama</th>
		            <th rowspan="2">Warna</th>
		            <th rowspan="2">Kode</th>
		            <th colspan="3">Stok Awal </th>
		            <th colspan="3">Masuk</th>
		            <th colspan="3">Keluar</th>
		            <th colspan="3">Akhir</th>
		            <th rowspan="2">Total</th>
		            <th rowspan="2">Ket</th>
		          </tr>
		          <tr>
		            <th>Roll</th>
		            <th>Yard</th>
		            <th>Harga</th>
		            <th>Roll</th>
		            <th>Yard</th>
		            <th>Harga</th>
		            <th>Roll</th>
		            <th>Yard</th>
		            <th>Harga</th>
		            <th>Roll</th>
		            <th>Yard</th>
		            <th>Harga</th>
		          </tr>
		        </thead>
		        <tbody>
		        	<?php
		        		$stokawalroll=0;
		        		$stokawalyard=0;
		        		$stokmasukroll=0;
		        		$stokmasukyard=0;
		        		$stokkeluarroll=0;
		        		$stokkeluaryard=0;
		        		$stokakhirroll=0;
		        		$stokakhiryard=0;
		        		$total=0;
		        	?>
		        	<?php foreach($prods as $p){?>
		        		<tr>
		        			<td><?php echo $p['no']?></td>
		        			<td><?php echo $p['nama']?></td>
		        			<td><?php echo $p['warna']?></td>
		        			<td><?php echo $p['kode']?></td>
		        			<td><?php echo number_format($p['stokawalroll'])?></td>
		        			<td><?php echo number_format($p['stokawalyard'],2)?></td>
		        			<td><?php echo number_format($p['stokawalharga'])?></td>
		        			<td><?php echo number_format($p['stokmasukroll'])?></td>
		        			<td><?php echo number_format($p['stokmasukyard'],2)?></td>
		        			<td><?php echo number_format($p['stokmasukharga'])?></td>
		        			<td><?php echo number_format($p['stokkeluarroll'])?></td>
		        			<td><?php echo number_format($p['stokkeluaryard'],2)?></td>
		        			<td><?php echo number_format($p['stokkeluarharga'])?></td>
		        			<td><?php echo number_format($p['stokakhirroll'])?></td>
		        			<td><?php echo number_format($p['stokakhiryard'],2)?></td>
		        			<td><?php echo number_format($p['stokakhirharga'])?></td>
		        			<td><?php echo number_format($p['total'])?></td>
		        			<td><?php echo $p['ket']?></td>
		        		</tr>
		        		<?php
			        		$stokawalroll+=($p['stokawalroll']);
			        		$stokawalyard+=($p['stokawalyard']);
			        		$stokmasukroll+=($p['stokmasukroll']);
		        			$stokmasukyard+=($p['stokmasukyard']);
			        		$stokkeluarroll+=($p['stokkeluarroll']);
			        		$stokkeluaryard+=($p['stokkeluaryard']);
			        		$stokakhirroll+=($p['stokakhirroll']);
			        		$stokakhiryard+=($p['stokakhiryard']);
			        		$total+=($p['total']);
			        	?>
		        	<?php } ?>
		        </tbody>
		        <tfoot>
		        	<tr style="background-color: #f0dd0a !important;font-size: 15px;">
		        		<td colspan="4" align="center"><b>Jumlah</b></td>
		        		<td><?php echo number_format($stokawalroll)?></td>
		        		<td><?php echo number_format($stokawalyard,2)?></td>
		        		<td></td>
		        		<td><?php echo number_format($stokmasukroll)?></td>
		        		<td><?php echo number_format($stokmasukyard,2)?></td>
		        		<td></td>
		        		<td><?php echo number_format($stokkeluarroll)?></td>
		        		<td><?php echo number_format($stokkeluaryard,2)?></td>
		        		<td></td>
		        		<td><?php echo number_format($stokakhirroll)?></td>
		        		<td><?php echo number_format($stokakhiryard,2)?></td>
		        		<td></td>
		        		<td><?php echo number_format($total)?></td>
		        		<td></td>
		        	</tr>
		        </tfoot>
			</table>
		</div>
	</div>
</div>
<script type="text/javascript">
	function filters(){
    url='?';
    
    var filter_date_start = $('input[name=\'tanggal1\']').val();

    if (filter_date_start) {
      url += '&tanggal1=' + encodeURIComponent(filter_date_start);
    }

    var filter_date_end = $('input[name=\'tanggal2\']').val();

    if (filter_date_end) {
      url += '&tanggal2=' + encodeURIComponent(filter_date_end);
    }

    var supplier = $('select[name=\'supplier\']').val();

    if (supplier != '*') {
      url += '&supplier=' + encodeURIComponent(supplier);
    }

    var kategori = $('select[name=\'kategori\']').val();

    if (kategori != '*') {
      url += '&kategori=' + encodeURIComponent(kategori);
    }

	var tipe = $('select[name=\'tipe\']').val();

    if (tipe != '*') {
      url += '&tipe=' + encodeURIComponent(tipe);
    }


	var status = $('select[name=\'status\']').val();

    if (status != '*') {
      url += '&status=' + encodeURIComponent(status);
    }

    location =url;
  }

  function excels(){
    url='?&excel=1';
    
    var filter_date_start = $('input[name=\'tanggal1\']').val();

    if (filter_date_start) {
      url += '&tanggal1=' + encodeURIComponent(filter_date_start);
    }

    var filter_date_end = $('input[name=\'tanggal2\']').val();

    if (filter_date_end) {
      url += '&tanggal2=' + encodeURIComponent(filter_date_end);
    }

    var filter_status = $('select[name=\'cmt\']').val();

    var supplier = $('select[name=\'supplier\']').val();

    if (supplier != '*') {
      url += '&supplier=' + encodeURIComponent(supplier);
    }

    var kategori = $('select[name=\'kategori\']').val();

    if (kategori != '*') {
      url += '&kategori=' + encodeURIComponent(kategori);
    }


	var tipe = $('select[name=\'tipe\']').val();

    if (tipe != '*') {
      url += '&tipe=' + encodeURIComponent(tipe);
    }


	var status = $('select[name=\'status\']').val();

    if (status != '*') {
      url += '&status=' + encodeURIComponent(status);
    }


    location =url;
  }

</script>