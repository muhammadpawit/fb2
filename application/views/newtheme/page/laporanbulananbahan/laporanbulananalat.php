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
                              <label>Bagian</label>
                              <select name="jenis" class="form-control select2bs4" data-live-search="true">
                                <option value="*">Semua</option>
                                <?php  
                                	$jenis=null;
                                	if(isset($_REQUEST['jenis'])){
                                		$jenis=$_REQUEST['jenis'];
                                	}
                                ?>
                                   <option value="1" <?php echo $jenis==1?'selected':''?>>Konveksi</option>
	                                <option value="2"  <?php echo $jenis==2?'selected':''?>>Bordir</option>
                              </select>
                            </div>		
	</div>				
	<div class="col-md-3">
		<div class="form-group">
			<label>Bulan</label>
			<select name="bulan" class="form-control">
				<option value="*">Semua</option>
				<option value="1" <?php echo ($bulan==1)?'selected':''?>>Januari</option>
				<option value="2" <?php echo ($bulan==2)?'selected':''?>>Februari</option>
				<option value="3" <?php echo ($bulan==3)?'selected':''?>>Maret</option>
				<option value="4" <?php echo ($bulan==4)?'selected':''?>>April</option>
				<option value="5" <?php echo ($bulan==5)?'selected':''?>>Mei</option>
				<option value="6" <?php echo ($bulan==6)?'selected':''?>>Juni</option>
				<option value="7" <?php echo ($bulan==7)?'selected':''?>>Juli</option>
				<option value="8" <?php echo ($bulan==8)?'selected':''?>>Agustus</option>
				<option value="9" <?php echo ($bulan==9)?'selected':''?>>September</option>
				<option value="10" <?php echo ($bulan==10)?'selected':''?>>Oktober</option>
				<option value="11" <?php echo ($bulan==11)?'selected':''?>>November</option>
				<option value="12" <?php echo ($bulan==12)?'selected':''?>>Desember</option>
			</select>
		</div>
	</div>			
	<div class="col-md-2">
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
		            <th colspan="2">Stok Awal </th>
		            <th colspan="2">Masuk</th>
		            <th colspan="2">Keluar</th>
		            <th colspan="2">Akhir</th>
		            <th rowspan="2">Total</th>
		            <th rowspan="2">Ket</th>
		          </tr>
		          <tr>
		            <th>Pcs</th>
		            <th>Harga</th>
		            <th>Pcs</th>
		            <th>Harga</th>
		            <th>Pcs</th>
		            <th>Harga</th>
		            <th>Pcs</th>
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
		        			<td><?php echo number_format($p['stokawal'])?></td>
		        			<td><?php echo number_format($p['stokawalharga'])?></td>
		        			<td><?php echo number_format($p['stokmasuk'])?></td>
		        			<td><?php echo number_format($p['stokmasukharga'])?></td>
		        			<td><?php echo number_format($p['stokkeluarroll'])?></td>
		        			<td><?php echo number_format($p['stokkeluarharga'])?></td>
		        			<td><?php echo number_format($p['stokakhirroll'])?></td>
		        			<td><?php echo number_format($p['stokakhirharga'])?></td>
		        			<td><?php echo number_format(($p['stokakhirroll']*$p['stokakhirharga']))?></td>
		        			<td><?php echo $p['ket']?></td>
		        		</tr>
		        		<?php
			        		$total+=($p['stokakhirroll']*$p['stokakhirharga']);
			        	?>
		        	<?php } ?>
		        </tbody>
		        <tfoot>
		        	<tr style="background-color: #f0dd0a !important;font-size: 15px;">
		        		<td colspan="4" align="center"><b>Jumlah</b></td>
		        		<td><?php echo number_format($stokawalroll)?></td>
		        		<td></td>
		        		<td><?php echo number_format($stokmasukroll)?></td>
		        		<td></td>
		        		<td><?php echo number_format($stokkeluarroll)?></td>
		        		<td></td>
		        		<td><?php echo number_format($stokakhirroll)?></td>
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

    var supplier = $('select[name=\'jenis\']').val();

    if (supplier != '*') {
      url += '&jenis=' + encodeURIComponent(supplier);
    }

    var bulan = $('select[name=\'bulan\']').val();

    if (bulan != '*') {
      url += '&bulan=' + encodeURIComponent(bulan);
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

    var supplier = $('select[name=\'jenis\']').val();

    if (supplier != '*') {
      url += '&jenis=' + encodeURIComponent(supplier);
    }

    var bulan = $('select[name=\'bulan\']').val();

    if (bulan != '*') {
      url += '&bulan=' + encodeURIComponent(bulan);
    }

    
    location =url;
  }

</script>