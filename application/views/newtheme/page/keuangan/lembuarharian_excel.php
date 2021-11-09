<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Total_Lembur.xls");
?>
<h3>Total Lembur Karyawan Harian</h3>		
		<table cellpadding="12" border="1" style="border-collapse: collapse;width: 100%">
				<thead>
					<tr>
						<th>No</th>
						<th>Bagian</th>
						<th>Nama</th>
						<th>Jumlah Jam Lembur</th>
						<th>Upah Lembur/jam</th>
						<th>Total</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($products as $p){?>
						<tr>
							<td><?php echo $p['no']?></td>
							<td><?php echo $p['bagian']?></td>
							<td><?php echo $p['nama']?></td>
							<td><?php echo $p['jam']?></td>
							<td><?php echo $p['upah']?></td>
							<td><?php echo $p['total']?></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>