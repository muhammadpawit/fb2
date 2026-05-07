<!DOCTYPE html>
<html>
<head>
	<title>Laporan Gaji Operator Bordir</title>
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
		.badge-shift { background-color: #e9ecef; padding: 2px 5px; border-radius: 3px; font-weight: bold; }
	</style>
</head>
<body>
	<div class="text-center" style="margin-bottom: 20px;">
		<div class="title">Laporan Gaji Operator Bordir <?php echo $gaji['tempat']==1?'Rumah':'Cipadu'?></div>
		<div class="subtitle">Periode: <?php echo date('d F Y',strtotime($gaji['tanggal1'])).' s.d '.date('d F Y',strtotime($gaji['tanggal2'])) ?></div>
	</div>

	<?php 
	$allgaji=0; 
	$chunked_karyawans = array_chunk($karyawans, 2);
	?>

	<?php foreach($chunked_karyawans as $pair){ ?>
	<table width="100%" border="0" style="margin-bottom: 0;">
		<tr>
			<?php foreach($pair as $k){ ?>
			<td width="50%" valign="top" style="padding: 0 5px;">
				<div class="employee-card">
					<table class="table">
						<thead>
							<tr class="header-blue">
								<th colspan="5" align="left" style="font-size: 11px;">
									<?php echo strtoupper($k['nama'])?> 
									<span style="float: right; font-weight: normal; font-size: 9px;">SHIFT: <?php echo isset($k['shift']) ? $k['shift'] : '-' ?></span>
								</th>
							</tr>
							<tr class="header-grey">
								<th width="20%">Hari</th>
								<th width="20%">Gaji</th>
								<th width="15%">Bonus</th>
								<th width="15%">Um</th>
								<th width="30%">Ket</th>
							</tr>
						</thead>
						<tbody>
							<?php $totalgaji=0;$totalbonus=0;$totalum=0;$potongan=0;?>
							<?php foreach($k['details'] as $kd){?>
							<?php
								$tgl2 = date('Y-m-d', strtotime($k['tgl2'] . ' +1 day'));
								$sql="SELECT SUM(nominal) as total FROM potongan_operator WHERE hapus=0 AND idkaryawan='".$k['idkaryawan']."' and DATE(tanggal) BETWEEN '".$k['tgl1']."' AND '".$tgl2."' ";
								$potongan=$this->GlobalModel->QueryManualRow($sql);

								$my_potongan = $this->GlobalModel->QueryManual("
									SELECT jp.nama, SUM(po.nominal) as total, GROUP_CONCAT(po.keterangan SEPARATOR ', ') as keterangan 
									FROM potongan_operator po
									JOIN jenis_potongan jp ON jp.id = po.jenis_potongan
									WHERE po.hapus=0 AND po.idkaryawan='".$k['idkaryawan']."' AND DATE(po.tanggal) BETWEEN '".$k['tgl1']."' AND '".$tgl2."'
									GROUP BY po.jenis_potongan
								");
							?>
							<tr>
								<td><?php echo $kd['hari']?></td>
								<td align="right"><?php echo number_format((float)$kd['gaji'])?></td>
								<td align="right"><?php echo number_format((float)$kd['bonus'])?></td>
								<td align="right"><?php echo number_format((float)$kd['um'])?></td>
								<td style="font-size: 8px;"><?php echo $kd['keterangan']?></td>
							</tr>
							<?php 
								$totalgaji+=($kd['gaji']);
								$totalbonus+=($kd['bonus']);
								$totalum+=($kd['um']);
							?>
							<?php } ?>
							<?php foreach($my_potongan as $mp){ ?>
							<tr style="color: #e74c3c;">
								<td style="font-weight: bold;">Pot. <?php echo $mp['nama'] ?></td>
								<td align="right" style="font-weight: bold;"><?php echo number_format((float)$mp['total']) ?></td>
								<td colspan="3" style="font-size: 8px; font-style: italic;"><?php echo $mp['keterangan'] ?></td>
							</tr>
							<?php } ?>
							<tr class="header-grey" style="background-color: #ebf5fb;">
								<td><b>Gaji Diterima</b></td>
								<td colspan="4" align="center" style="font-size: 11px; color: #2980b9;">
									<b>Rp <?php echo number_format((float)($totalgaji+$totalbonus+$totalum-$potongan['total'])) ?></b>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<?php $allgaji+=(($totalgaji+$totalbonus+$totalum-$potongan['total'])); ?>
			</td>
			<?php } ?>
			<?php if(count($pair) == 1) echo '<td width="50%"></td>'; ?>
		</tr>
	</table>
	<?php } ?>

	<div style="page-break-inside: avoid; margin-top: 20px;">
		<table width="100%" border="0">
			<tr>
				<td width="55%" valign="top">
					<table class="table">
						<tr class="header-blue">
							<th colspan="3" align="left">REKAP UANG MAKAN MANDOR (Rp)</th>
						</tr>
						<tr class="header-grey">
							<td>Nama</td>
							<td>Uang Makan</td>
							<td>Keterangan</td>
						</tr>
						<tr>
							<td>Mandor Pagi</td>
							<td align="right"><?php echo number_format((float)$umsiang)?></td>
							<td><?php echo $this->ReportModel->getMandor($id,1)?></td>
						</tr>
						<tr>
							<td>Mandor Malam</td>
							<td align="right"><?php echo number_format((float)$ummalam)?></td>
							<td><?php echo $this->ReportModel->getMandor($id,2)?></td>
						</tr>
						<tr class="grand-total-row">
							<td>TOTAL UM MANDOR</td>
							<td align="right"><b><?php echo number_format((float)($umsiang+$ummalam))?></b></td>
							<td></td>
						</tr>
					</table>
				</td>
				<td width="5%"></td>
				<td width="40%" valign="top">
					<table class="table">
						<tr class="header-grey">
							<td>Total Gaji Operator</td>
							<td align="right"><b><?php echo number_format((float)$allgaji)?></b></td>
						</tr>
						<tr>
							<td>Total UM Mandor</td>
							<td align="right"><?php echo number_format((float)($umsiang+$ummalam))?></td>
						</tr>
						<tr class="grand-total-row" style="background-color: #27ae60;">
							<td><b>GRAND TOTAL</b></td>
							<td align="right" style="font-size: 12px;"><b>Rp <?php echo number_format((float)($allgaji+ ($umsiang+$ummalam)))?></b></td>
						</tr>
					</table>
					
					<table class="table">
						<tr class="header-grey"><td style="font-size: 9px;">CATATAN:</td></tr>
						<tr>
							<td style="font-size: 8px; color: #7f8c8d;">
								- Operator sudah menggunakan sistem borongan<br>
								- Periode gaji dihitung dari hari Sabtu s.d Jum'at<br>
								- Potongan Warteg otomatis ditarik dari hari Sabtu berikutnya (jika filter berakhir di hari Jumat)
							</td>
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
				<b>R A S U M</b>
			</td>
			<td width="33%">
				Disusun Oleh,<br><br><br><br>
				<div style="border-bottom: 1px solid #000; width: 80%; margin: 0 auto;"></div>
				<b>A S M I A</b>
			</td>
		</tr>
	</table>

	<div style="position: fixed; bottom: -20px; left: 0; right: 0; font-size: 8px; color: #bdc3c7; text-align: center;">
		Laporan ini digenerate secara otomatis oleh Forboys Production System pada <?php echo date('d/m/Y H:i:s'); ?>
	</div>
</body>
</html>
