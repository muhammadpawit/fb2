<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Uang_Makan_Security.xls");
?>


		<table border="5" style="width: 100%;border-collapse: collapse;border-color: blue">
			<thead>
				<tr>
					<th colspan="4" align="center"><h3>Hitungan Uang Makan Security <?php //echo $prods['tempat']==1?'Rumah & Finishing':'Cipadu'?></h3></th>
				</tr>
				<tr>
					<th colspan="4" align="left"><p>Periode <?php echo strtolower($periode)?></p></th>
				</tr>
				<tr>
					<th>No</th>
					<th>Nama</th>
					<th>Uang Makan</th>
					<th>Keterangan</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($details as $p){?>
					<tr>
						<td align="center"><?php echo $p['no']?></td>
						<td><?php echo $p['nama']?></td>
						<td><?php echo ($p['nominal'])?></td>
						<td><?php echo $p['keterangan']?></td>
					</tr>
				<?php } ?>
				<tr>
					<td colspan="2"><b>Total</b></td>
					<td><b><?php echo ($total)?></b></td>
					<td></td>
				</tr>
			</tbody>
		</table>