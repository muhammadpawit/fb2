<?php
$namafile='Laporan_Rekap_Barang_Supplier_'.time();
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=".$namafile.".xls");
?>
		<table border="1" style="width: 100%;border-collapse: collapse;">
			<tr>
				<td colspan="4" align="center"><h3>Rekap Barang Masuk Supplier</h3></td>
			</tr>
		</table>
		<table border="1" style="width: 100%;border-collapse: collapse;">
			<thead>
			  <tr align="center">
			  	<th>Nama Supplier</th>
			  	<th>Periode</th>
			  	<th>Jumlah (Rp)</th>
			  	<th>Keterangan</th>
			  </tr>
			</thead>
			<tbody>
			<?php foreach($prods as $k){?>
			  <tr>
			  	<td><?php echo strtoupper($k['nama'])?></td>
			    <td><?php echo $k['periode']?></td>
			    <td></td>
			    <td><?php echo $k['ket']?></td>
			  </tr>
			  <?php $total=0;?>
			  <?php foreach($k['rincian'] as $kr){?>
			  	<tr>
				  	<td></td>
				    <td>
				    	<?php echo date('d',strtotime($kr['tanggal_awal']))?> - <?php echo date('d F Y',strtotime($kr['tanggal_akhir']))?></td>
				    <td align="right"><?php echo ($kr['total'])?></td>
				    <td></td>
				</tr>
				<?php $total+=($kr['total']);?>
			  <?php } ?>
			  <tr>
					<td colspan="2" align="center"><b>Total</b></td>
					<td align="right"><b><?php echo ($total)?></b></td>
					<td></td>
				</tr>
			 <?php } ?>
			 <tr>
                <td colspan="4" align="right"><i class="registered">Registered by Forboys Production System <?php echo date('d-m-Y Y H:i:s'); ?></i></td>
              </tr>
			</tbody>
		</table>