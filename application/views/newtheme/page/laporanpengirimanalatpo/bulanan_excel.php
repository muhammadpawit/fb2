<?php
$namafile='Laporan_Rekap_Pengiriman_Alat_PO_'.time();
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=".$namafile.".xls");
?>
<style type="text/css">
  @import url('https://fonts.googleapis.com/css2?family=Baskervville:ital@1&display=swap');
  .registered {
    font-family: 'Baskervville', serif;
  }
</style>
<table border="1" style="width: 100%;border-collapse: collapse;">
			<tr>
				<td colspan="5" align="center"><b><h3>Laporan Rekap Pengiriman Alat-alat PO</h3></b></td>
			</tr>
		</table>
		<?php if(isset($tanggal1)){ ?>
			<caption>Periode : <?php echo date('d',strtotime($tanggal1)) ?> - <?php echo date(' d F Y',strtotime($tanggal2)) ?></caption>
			<span style="float: right"><b>Update Terakhir : <?php echo $update ?></b></span>
		<?php } ?>
		<table border="1" style="width: 100%;border-collapse: collapse;">
			<thead>
				<tr>
					<th>No</th>
					<th>Nama</th>
					<th>Alamat</th>
					<th>Nama PO</th>
					<th>Jumlah PO</th>
				</tr>
			</thead>
			<tbody>
				<?php $no=1;$totalpo=0; ?>
				<?php foreach($results as $r){?>
					<tr>
						<td><?php echo $no ?></td>
						<td><?php echo $r['nama'] ?></td>
						<td><?php echo $r['alamat'] ?></td>
						<td>
							<?php 
								$str =str_replace(",", ", ", $r['po']);
								echo wordwrap($str,140,"<br>\n");
							?>	
						</td>
						<td align="center"><?php echo $r['jumlah'] ?></td>
					</tr>
					<?php 
						$totalpo+=($r['jumlah']);
					?>
					<?php $no++; ?>
				<?php } ?>
				<tr>
					<td colspan="4" align="center"><b>Total PO</b></td>
					<td align="center"><b><?php echo $totalpo ?></b></td>
				</tr>
				<tr>
					<td colspan="5"></td>
				</tr>
				<tr>
					<td colspan="5" align="right"><i class="registered">Registered by Forboys Production System <?php echo date('d-m-Y H:i:s'); ?></i></td>
				</tr>
			</tbody>
		</table>