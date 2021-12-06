<?php
$namafile='kartustok_'.time();
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=".$namafile.".xls");
?>
<table border="1" style="width: 100%;border-collapse: collapse;">
				<thead>
					<tr>
						<th>No</th>
						<th>Tanggal</th>
						<th>Nama</th>
						<th>Masuk <?php echo $p['satuan_ukuran_item']?></th>
						<th>Keluar <?php echo $p['satuan_ukuran_item']?></th>
						<th>Saldo <?php echo $p['satuan_ukuran_item']?></th>
						<th>Masuk <?php echo $p['satuan_jumlah_item']?></th>
						<th>Keluar <?php echo $p['satuan_jumlah_item']?></th>
						<th>Saldo <?php echo $p['satuan_jumlah_item']?></th>
						<th>Keterangan</th>
					</tr>
				</thead>
				<tbody>
					<?php $no=1;$totalmasuk=0;$totalkeluar=0;?>
					<?php foreach($kartustok as $k){?>
						<tr>
							<td><?php echo $no++?></td>
							<td><?php echo date('d-m-Y',strtotime($k['tanggal']))?></td>
							<td><?php echo $k['nama']?></td>
							<td><?php echo $k['saldomasuk_uk'].' '.$p['satuan_ukuran_item']?></td>
							<td><?php echo $k['saldokeluar_uk'].' '.$p['satuan_ukuran_item']?></td>
							<td><?php echo $k['sisa_uk'].' '.$p['satuan_ukuran_item']?></td>
							<td><?php echo $k['saldomasuk_qty'].' '.$p['satuan_jumlah_item']?></td>
							<td><?php echo $k['saldokeluar_qty'].' '.$p['satuan_jumlah_item']?></td>
							<td><?php echo $k['sisa_qty'].' '.$p['satuan_jumlah_item']?></td>
							<td><?php echo $k['keterangan']?></td>
						</tr>
					<?php
						$totalmasuk+=($k['saldomasuk_qty']);
						$totalkeluar+=($k['saldokeluar_qty']);
					?>
					<?php } ?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="6" align="center" valign="top"><b>Total</b></td>
						<td align="center"><?php echo $totalmasuk?></td>
						<td align="center"><?php echo $totalkeluar?></td>
						<td align="center"><?php echo ($totalmasuk-$totalkeluar)?></td>
					</tr>
				</tfoot>
			</table>