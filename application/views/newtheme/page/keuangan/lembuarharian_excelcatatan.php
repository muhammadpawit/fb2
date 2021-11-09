<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Catatan_Lembur.xls");
?>
<h3>Catatan Lembur Karyawan Harian</h3>
			<table cellpadding="12" border="1" style="border-collapse: collapse;width: 100%">
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
							<td><?php echo $p['upah']?></td>
							<td><?php echo $p['total']?></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>