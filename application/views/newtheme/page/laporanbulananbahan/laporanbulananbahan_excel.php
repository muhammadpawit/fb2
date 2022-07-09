<?php
$namafile=$title.time();
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=".$namafile.".xls");
?>
<center>
  <h3 style="text-decoration: underline;"><?php echo $title ?></h3>
</center>
<div class="row">
	<div class="col-md-12">
		<div class="table-responsive">
			<caption>Periode : <?php echo date('d F Y',strtotime($tanggal1))?> - <?php echo date('d F Y',strtotime($tanggal2))?></caption>
			<table border="1" cellpadding="3" style="border-collapse: collapse;width: 100%" >
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
		            <th rowspan="2">Harga (Rp)</th>
		            <th rowspan="2">Total (Rp)</th>
		            <th rowspan="2">Ket</th>
		          </tr>
		          <tr>
		            <th>Roll</th>
		            <th>Yard</th>
		            <th>Roll</th>
		            <th>Yard</th>
		            <th>Roll</th>
		            <th>Yard</th>
		            <th>Roll</th>
		            <th>Yard</th>
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
		        		<tr align="center">
		        			<td><?php echo $p['no']?></td>
		        			<td align="left"><?php echo $p['nama']?></td>
		        			<td><?php echo $p['warna']?></td>
		        			<td><?php echo $p['kode']?></td>
		        			<td><?php echo number_format($p['stokawalroll'])?></td>
		        			<td><?php echo number_format($p['stokawalyard'],2)?></td>
		        			<!-- <td><?php echo round($p['stokawalharga'])?></td> -->
		        			<td><?php echo number_format($p['stokmasukroll'])?></td>
		        			<td><?php echo number_format($p['stokmasukyard'],2)?></td>
		        			<!-- <td><?php echo round($p['stokmasukharga'])?></td> -->
		        			<td><?php echo number_format($p['stokkeluarroll'])?></td>
		        			<td><?php echo number_format($p['stokkeluaryard'],2)?></td>
		        			<!-- <td><?php echo round($p['stokkeluarharga'])?></td> -->
		        			<td><?php echo number_format($p['stokakhirroll'])?></td>
		        			<td><?php echo number_format($p['stokakhiryard'],2)?></td>
		        			<td><?php echo round($p['stokakhirharga'])?></td>
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
		        	<tr align="center" style="backgnumber_format-color: #f0dd0a !important;font-size: 15px;">
		        		<td colspan="4" align="center"><b>Jumlah</b></td>
		        		<td><?php echo number_format($stokawalroll)?></td>
		        		<td><?php echo number_format($stokawalyard,2)?></td>
		        		<td><?php echo number_format($stokmasukroll)?></td>
		        		<td><?php echo number_format($stokmasukyard,2)?></td>
		        		<td><?php echo number_format($stokkeluarroll)?></td>
		        		<td><?php echo number_format($stokkeluaryard,2)?></td>
		        		<td><?php echo number_format($stokakhirroll)?></td>
		        		<td><?php echo number_format($stokakhiryard,2)?></td>
		        		<td></td>
		        		<td><?php echo number_format($total)?></td>
		        	</tr>
		        	<tr>
                  <td colspan="15" align="right">
                    <i class="registered">Registered by Forboys Production System <?php echo date('d-m-Y H:i:s'); ?></i>
                  </td>
                </tr>
		        </tfoot>
			</table>
		</div>
	</div>
</div>