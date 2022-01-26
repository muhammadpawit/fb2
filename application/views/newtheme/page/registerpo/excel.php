<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Register_Data_PO_".$jenis.".xls");
?>
<table border="1" style="border-collapse: collapse;width: 100%;" cellpadding="10">
			<thead>
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
						<td>'<?php echo $p['size']?></td>
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