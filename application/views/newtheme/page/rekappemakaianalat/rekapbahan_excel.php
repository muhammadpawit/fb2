<?php
$namafile='Rekap_Pemakaian_Alat-Alat-'.time();
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=".$namafile.".xls");
?>

<table border="1" style="width: 100%;border-collapse: collapse;">
				<thead>
					<tr>
						<th>No</th>
						<th>Nama Barang</th>
						<?php foreach($products as $p){?>
							<th><?php echo $p['nama']?></th>
						<?php } ?>
					</tr>
				</thead>
				<tbody>
					<?php $no=1;?>
					<?php foreach($alat as $p){?>
						<tr>
							<td><?php echo $no++;?></td>
							<td><?php echo $p['nama']?></td>
							<?php foreach($p['po'] as $o){?>
								<td>
									<table>
										<tr>
											<td><?php echo $this->ReportModel->sum_jumlah_bahan_used_po($p['nama'],$o['nama_jenis_po'],$tanggal1,$tanggal2)['yard']; ?> yard</td>
											<td><?php echo $this->ReportModel->sum_jumlah_bahan_used_po($p['nama'],$o['nama_jenis_po'],$tanggal1,$tanggal2)['roll']; ?> roll</td>
										</tr>
									</table>
								</td>
							<?php } ?>
						</tr>
					<?php } ?>
				</tbody>
			</table>