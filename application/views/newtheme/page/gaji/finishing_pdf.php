<!DOCTYPE html>
<html>
<head>
	<title><?php echo isset($title) ? $title : 'Laporan Gaji' ?></title>
	<style>
		body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 10px; color: #333; line-height: 1.4; }
		.text-center { text-align: center; }
		.text-right { text-align: right; }
		.table { width: 100%; border-collapse: collapse; margin-bottom: 10px; table-layout: fixed; }
		.table th, .table td { border: 1px solid #dee2e6; padding: 4px 6px; word-wrap: break-word; }
		.header-blue { background-color: #3498db; color: white; font-weight: bold; }
		.header-grey { background-color: #f8f9fa; font-weight: bold; color: #495057; }
		.title { font-size: 16px; font-weight: bold; margin-bottom: 2px; color: #2c3e50; text-transform: uppercase; letter-spacing: 1px; }
		.subtitle { font-size: 11px; margin-bottom: 15px; color: #7f8c8d; border-bottom: 2px solid #3498db; padding-bottom: 5px; display: inline-block; }
		.grand-total-row { background-color: #2c3e50; color: white; font-weight: bold; }
		.footer-table td { border: none; }
		.signature-section { margin-top: 30px; }
		.employee-card { page-break-inside: avoid; margin-bottom: 15px; }
	</style>
</head>
<body>
	<div class="text-center" style="margin-bottom: 20px;">
		<div class="title"><?php echo isset($title) ? $title : 'Laporan Gaji' ?></div>
		<div class="subtitle">Periode: <?php echo isset($gaji['tanggal1']) ? formatTanggalIndo($gaji['tanggal1']).' s.d '.formatTanggalIndo($gaji['tanggal2']) : '-' ?></div>
	</div>

	<?php 
	$total_pembulatan_seluruh = 0;
	$karyawans_data = isset($karyawans) ? $karyawans : [];
	$chunked_karyawans = array_chunk($karyawans_data, 3);
	?>

	<?php foreach($chunked_karyawans as $pair){ ?>
	<table width="100%" border="0" style="margin-bottom: 0;">
		<tr>
			<?php foreach($pair as $k){ ?>
			<td width="33.33%" valign="top" style="padding: 0 5px;">
				<div class="employee-card">
					<table class="table">
						<thead>
							<tr class="header-blue">
								<th colspan="2" align="left" style="font-size: 10px;">
									<?php echo strtoupper(isset($k['nama']) ? $k['nama'] : '-')?> 
								</th>
							</tr>
						</thead>
						<tbody>
							<tr><td>Senin</td><td align="right"><?php echo number_format((float)$k['senin'])?></td></tr>
							<tr><td>Selasa</td><td align="right"><?php echo number_format((float)$k['selasa'])?></td></tr>
							<tr><td>Rabu</td><td align="right"><?php echo number_format((float)$k['rabu'])?></td></tr>
							<tr><td>Kamis</td><td align="right"><?php echo number_format((float)$k['kamis'])?></td></tr>
							<tr><td>Jumat</td><td align="right"><?php echo number_format((float)$k['jumat'])?></td></tr>
							<tr><td>Sabtu</td><td align="right"><?php echo number_format((float)$k['sabtu'])?></td></tr>
							<tr><td>Minggu</td><td align="right"><?php echo number_format((float)$k['minggu'])?></td></tr>
							<tr><td>Lembur</td><td align="right"><?php echo number_format((float)$k['lembur'])?></td></tr>
							<tr><td>Insentif</td><td align="right"><?php echo number_format((float)$k['insentif'])?></td></tr>
							<tr style="color: #e74c3c;"><td>Pot. Claim</td><td align="right"><?php echo number_format((float)$k['claim'])?></td></tr>
							<tr style="color: #e74c3c;"><td>Pot. Pinjaman</td><td align="right"><?php echo number_format((float)$k['pinjaman'])?></td></tr>
							<tr class="header-grey">
								<td><b>Total</b></td>
								<td align="right"><b><?php 
									$subtotal = (float)$k['senin']+(float)$k['selasa']+(float)$k['rabu']+(float)$k['kamis']+(float)$k['jumat']+(float)$k['sabtu']+(float)$k['minggu']+(float)$k['lembur']+(float)$k['insentif']-(float)$k['claim']-(float)$k['pinjaman'];
									echo number_format($subtotal);
								?></b></td>
							</tr>
							<?php if(isset($k['saving']) && $k['saving'] > 0){ ?>
							<tr><td>Saving</td><td align="right"><?php echo number_format((float)$k['saving'])?></td></tr>
							<tr><td>Keluarkan Saving</td><td align="right"><?php echo number_format((float)$k['keluarkansaving'])?></td></tr>
							<?php } ?>
							<tr class="grand-total-row">
								<td><b>Pembulatan</b></td>
								<td align="right"><b><?php 
									$grand = $subtotal;
									if(isset($k['saving'])){
										$grand = $grand - (float)$k['saving'] + (float)$k['keluarkansaving'];
									}
									
									if(function_exists('pembulatangaji')){
										$pembulatan = pembulatangaji($grand);
									} else {
										$pembulatan = round($grand / 100) * 100;
									}
									
									echo number_format($pembulatan);
									$total_pembulatan_seluruh += $pembulatan;
								?></b></td>
							</tr>
						</tbody>
					</table>
				</div>
			</td>
			<?php } ?>
			<?php 
				$count = count($pair);
				if($count < 3){
					for($i=0; $i < (3-$count); $i++){
						echo '<td width="33.33%"></td>';
					}
				}
			?>
		</tr>
	</table>
	<?php } ?>

	<div style="page-break-inside: avoid; margin-top: 20px;">
		<table width="100%" border="0">
			<tr>
				<td width="60%" valign="top">
					<p><b>Catatan:</b><br>
					- Gaji dihitung berdasarkan jam kerja (GH/12 * Jam Kerja)<br>
					- Laporan ini sah sebagai bukti pembayaran gaji periode tersebut.</p>
				</td>
				<td width="40%" valign="top">
					<table class="table">
						<tr class="grand-total-row" style="background-color: #27ae60;">
							<td style="font-size: 11px;"><b>TOTAL PEMBULATAN</b></td>
							<td align="right" style="font-size: 12px;"><b>Rp <?php echo number_format($total_pembulatan_seluruh)?></b></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>

	<table width="100%" border="0" class="text-center signature-section" style="page-break-inside: avoid;">
		<tr>
			<td width="33%">
				Disetujui,<br><br><br><br>
				<div style="border-bottom: 1px solid #000; width: 80%; margin: 0 auto;"></div>
				<b>S P V</b>
			</td>
			<td width="33%">
				Mengetahui,<br><br><br><br>
				<div style="border-bottom: 1px solid #000; width: 80%; margin: 0 auto;"></div>
				<b>Owner</b>
			</td>
			<td width="33%">
				Disusun Oleh,<br><br><br><br>
				<div style="border-bottom: 1px solid #000; width: 80%; margin: 0 auto;"></div>
				<b>Administrasi</b>
			</td>
		</tr>
	</table>

	<div style="position: fixed; bottom: -20px; left: 0; right: 0; font-size: 8px; color: #bdc3c7; text-align: center;">
		Laporan ini digenerate secara otomatis oleh Forboys Production System pada <?php echo formatTanggalIndo(date('Y-m-d')).' '.date('H:i:s'); ?>
	</div>
</body>
</html>
