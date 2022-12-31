<div class="row">
	<div class="col-md-12">
		<div class="table-responsive">
			<b>Update Terakhir : <?php echo hari(date('l',strtotime($update))) ?> , <?php echo date('d F Y',strtotime($update))?></b>
			<br>
			<b>
				&bull; <?php echo isset($trans)?$trans['keterangan']:'';?>
			</b>
			<hr>
			<h5>Bahan Kaos</h5>
			<table class="table table-bordered table-striped">
				<thead style="text-align: center;">
		          <tr>
		            <th rowspan="2">No</th>
		            <th rowspan="2">Nama</th>
		            <th rowspan="2">Warna</th>
		            <th rowspan="2">Kode</th>
		            <th colspan="3">Stok Masuk</th>
		            <th colspan="3">Stok Keluar</th>
		            <th colspan="3">Stok Akhir</th>
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
		        	<?php foreach($kaos as $p){?>
		        		<tr>
		        			<td><?php echo $p['no']?></td>
		        			<td><?php echo $p['nama']?></td>
		        			<td><?php echo $p['warna']?></td>
		        			<td><?php echo $p['kode']?></td>
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
			<h5>Bahan Celana</h5>
			<table class="table table-bordered table-striped">
				<thead style="text-align: center;">
		          <tr>
		            <th rowspan="2">No</th>
		            <th rowspan="2">Nama</th>
		            <th rowspan="2">Warna</th>
		            <th rowspan="2">Kode</th>
		            <th colspan="3">Stok Masuk</th>
		            <th colspan="3">Stok Keluar</th>
		            <th colspan="3">Stok Akhir</th>
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
		        	<?php foreach($celana as $p){?>
		        		<tr>
		        			<td><?php echo $p['no']?></td>
		        			<td><?php echo $p['nama']?></td>
		        			<td><?php echo $p['warna']?></td>
		        			<td><?php echo $p['kode']?></td>
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
			<h5>Bahan Kemeja</h5>
			<table class="table table-bordered table-striped">
				<thead style="text-align: center;">
		          <tr>
		            <th rowspan="2">No</th>
		            <th rowspan="2">Nama</th>
		            <th rowspan="2">Warna</th>
		            <th rowspan="2">Kode</th>
		            <th colspan="3">Stok Masuk</th>
		            <th colspan="3">Stok Keluar</th>
		            <th colspan="3">Stok Akhir</th>
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
		        	<?php foreach($kemeja as $p){?>
		        		<tr>
		        			<td><?php echo $p['no']?></td>
		        			<td><?php echo $p['nama']?></td>
		        			<td><?php echo $p['warna']?></td>
		        			<td><?php echo $p['kode']?></td>
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


    location =url;
  }

</script>