<?php
$namafile=$title.'_'.time();
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=".$namafile.".xls");
?>
<h2><?php echo $title?> Forboys  Production</h2>					
					<table border="1" style="width: 100%;border-collapse: collapse;">
						<thead>
							<tr>
								<th>#</th>
								<th>Tanggal</th>
								<th>Nama</th>
								<th>Nama PO</th>
								<th>Jml pcs</th>
								<th>Harga Per PCS</th>
								<th>Total</th>
								<th>Keterangan</th>
							</tr>
						</thead>
						<tbody>
							<?php $total=0;?>
							<?php foreach($products as $p){?>
							<tr>
								<td><?php echo $p['no']?></td>
								<td><?php echo ($p['tanggal']) ?></td>
								<td><?php echo strtolower($p['idkaryawan']) ?></td>
								<td><?php echo ($p['nama_po']) ?></td>
								<td><?php echo $p['jumlah_pcs']?></td>
								<td><?php echo $p['harga'] ?></td>
								<td><?php echo ($p['total']) ?></td>
								<td><?php echo $p['keterangan'] ?></td>
							</tr>
							<?php $total+=($p['total']);?>
							<?php }?>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="6"><b>Total</b></td>
								<td><b><?php echo $total?></b></td>
								<td></td>
							</tr>
						</tfoot>
					</table>