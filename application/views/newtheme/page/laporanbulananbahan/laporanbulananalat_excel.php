<?php
$namafile='Laporan_Bulanan_Alat_'.time();
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=".$namafile.".xls");
?>
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
		        			<td><?php echo number_format($p['total'])?></td>
		        			<td><?php echo $p['ket']?></td>
		        		</tr>
		        		<?php
			        		$total+=($p['total']);
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