<html>
	<head></head>
	<body>
		<div class="title">
			<center>
				<h3>
					Rekap Kasbon 
				</h3>
			</center>
		</div>
		<div class="body">
			<table border="1" style="border-collapse: collapse;width: 100%">
				<thead>
					<tr align="center">
						<th rowspan="2">No.</th>
						<th rowspan="2">Nama</th>
						<th rowspan="2">Bagian</th>
						<!-- <th rowspan="2">Tanggal Masuk</th> -->
						<th rowspan="2">Gaji/Bulan</th>
						<th colspan="<?php echo !empty($tgl)?count($tgl):1?>">Kasbon Mingguan (Rp)</th>
						<th rowspan="2">Sisa Pinjaman</th>
						<th rowspan="2">Pinjaman baru</th>
						<th rowspan="2">Sisa Gaji</th>
						<th rowspan="2">Keterangan</th>
					</tr>
					<tr align="center">
						<?php if(!empty($tgl)){?>
							<?php foreach($tgl as $t){?>
								<th><?php echo date('d/m/Y',strtotime($t['tanggal'])) ?></th>
							<?php } ?>
						<?php }else{ ?>
						<?php } ?>
						
					</tr>
				</thead>
				<tbody>
				<?php foreach($kar as $k){?>
					<?php $kasbon=0; ?>
					<tr>
						<td><?php echo $k['no']?></td>
						<td><?php echo ucwords(strtolower($k['nama']))?></td>
						<td><?php echo $k['bagian']?></td>
						<!-- <td><?php echo $k['tgl']?><br><small>(<?php echo $k['lama']?>)</small></td> -->
						<td align="right"><?php echo !empty($k['gaji']) ? format_angka($k['gaji']) : 0 ?></td>
						<?php if(!empty($tgl)){?>
							<?php foreach($tgl as $t){?>
								<td align="right"><?php echo format_angka($this->KasbonModel->getkasbon($k['id'],$t['tanggal'])); ?></td>
								<?php $kasbon+=($this->KasbonModel->getkasbon($k['id'],$t['tanggal'])); ?>
							<?php } ?>
						<?php }else{ ?>
							<td align="center">-</td>
						<?php } ?>
						<td align="right"><?php echo !empty($k['sisapinjaman']) ? format_angka($k['sisapinjaman']): 0 ?></td> <!-- sisa pinjaman -->
						<td align="right"><?php echo format_angka($k['pinjaman'])?></td> <!-- pinjaman baru -->
						<td align="right"><?php echo format_angka($k['gaji']-$kasbon)?></td>
						<td>ket</td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
			<div class="ttd">
				<table>
					<tr>
						<td colspan="4">Jakarta, <?php echo format_tanggal(date('Y-m-d')) ?> </td>
					</tr>
					<tr align="center">
						<td colspan="2">Mengetahui,<br> Supervisor</td>
						<td colspan="2">Dibuat oleh,<br>Admin Keuangan</td>
					</tr>
					<tr align="center">
						<td colspan="2">
							<br><br><br><br><br><br>
							(__________________)
						</td>
						<td colspan="2">
							<?php if(!empty($ttd)){ ?>
								<img src="<?php echo BASEURL ?>/uploads/ttd/<?php echo $ttd ?>" height="100" alt="">
								( <b style="padding:0px 25pt 0px 25pt;font-weight:0 !important">Mia</b> )
							<?php }else { ?>
							<br><br><br><br><br><br>
							(__________________)
							<?php } ?>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<div class="registered">
			<i>Registered by Forboys Production System <?php echo format_tanggal_jam(date('d-m-Y H:i:s')); ?></i>
		</div>
	</body>
</html>