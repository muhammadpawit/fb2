<?php
//header("Content-type: application/vnd-ms-excel");
//header("Content-Disposition: attachment; filename=ALokasisiapkirim.xls");
?>
<h3>Alokasi PO CMT</h3>
<table border="1" style="border-collapse: collapse;width: 100%" cellpadding="10">
			<thead>
				<tr>
					<th>No</th>
					<th>Tanggal</th>
					<th>CMT</th>
					<th>Jumlah PO</th>
					<th>Keterangan</th>
				</tr>
			</thead>
			<tbody>
				<?php $jml=0;?>
				<?php foreach($products as $p){?>
					<tr>
						<td><?php echo $p['no']?></td>
						<td><?php echo $p['tanggal']?></td>
						<td><?php echo strtoupper($p['nama'])?></td>
						<td align="center"><?php echo $p['jumlah']?></td>
						<td>
							<?php foreach($p['keterangan'] as $k){?>
								<?php echo $k['kode_po']?>,
							<?php } ?>
								
						</td>
					</tr>
					<?php 
						$jml+=$p['jumlah'];
					?>
				<?php } ?>	
				<?php for($i=1;$i<=3;$i++){?>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<?php } ?>
				<tr>
					<td colspan="3" align="center"><b>Total</b></td>
					<td align="center"><b><?php echo $jml?></b></td>
					<td></td>
				</tr>
			</tbody>
		</table>