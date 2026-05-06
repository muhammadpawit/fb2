<!DOCTYPE html>
<html>
<head>
	<title>Laporan Gaji Operator Bordir</title>
	<style>
		body { font-family: sans-serif; font-size: 11px; color: #333; }
		.text-center { text-align: center; }
		.text-right { text-align: right; }
		.table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
		.table th, .table td { border: 1px solid #444; padding: 6px; }
		.header-blue { background-color: #3498db; color: white; }
		.header-grey { background-color: #f8f9fa; font-weight: bold; }
		.title { font-size: 18px; font-weight: bold; margin-bottom: 5px; color: #2c3e50; }
		.subtitle { font-size: 13px; margin-bottom: 20px; color: #7f8c8d; }
		.grand-total-row { background-color: #3498db; color: white; font-weight: bold; font-size: 12px; }
		.footer-table td { border: none; }
		.signature-box { border: 1px solid #444; padding: 10px; height: 80px; vertical-align: bottom; }
	</style>
</head>
<body>
	<div class="text-center">
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
			<td width="50%" valign="top" style="padding: 5px;">
				<table class="table">
					<thead>
						<tr class="header-blue">
							<th colspan="5" align="left"><?php echo strtoupper($k['nama'])?> (<?php echo isset($k['shift']) ? $k['shift'] : '-' ?>)</th>
						</tr>
						<tr class="header-grey">
							<th>Hari</th>
							<th>Gaji</th>
							<th>Bonus</th>
							<th>Um</th>
							<th>Ket</th>
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
							<td><?php echo $kd['keterangan']?></td>
						</tr>
						<?php 
							$totalgaji+=($kd['gaji']);
							$totalbonus+=($kd['bonus']);
							$totalum+=($kd['um']);
						?>
						<?php } ?>
						<?php foreach($my_potongan as $mp){ ?>
						<tr>
							<td>Pot. <?php echo $mp['nama'] ?></td>
							<td align="right"><?php echo number_format((float)$mp['total']) ?></td>
							<td colspan="3" style="font-size: 8px;"><?php echo $mp['keterangan'] ?></td>
						</tr>
						<?php } ?>
						<tr class="header-grey">
							<td>Total Gaji</td>
							<td colspan="4" align="center"><b><?php echo number_format((float)($totalgaji+$totalbonus+$totalum-$potongan['total'])) ?></b></td>
						</tr>
					</tbody>
				</table>
				<?php $allgaji+=(($totalgaji+$totalbonus+$totalum-$potongan['total'])); ?>
			</td>
			<?php } ?>
			<?php if(count($pair) == 1) echo '<td width="50%"></td>'; ?>
		</tr>
	</table>
	<?php } ?>

	<br>

	<table width="100%" border="0" style="page-break-inside: avoid;">
		<tr>
			<td width="55%" valign="top">
				<table class="table">
					<tr class="header-blue">
						<th colspan="3" align="left">Uang Makan Mandor <?php echo $gaji['tempat']==1?'Rumah':'Cipadu'?> (Rp)</th>
					</tr>
					<tr class="header-grey">
						<td>Nama</td>
						<td>Uang Makan</td>
						<td>Keterangan</td>
					</tr>
					<tr>
						<td>Mandor Pagi</td>
						<td align="right"><?php echo number_format((float)$umsiang)?></td>
						<td></td>
					</tr>
					<tr>
						<td>Mandor Malam</td>
						<td align="right"><?php echo number_format((float)$ummalam)?></td>
						<td></td>
					</tr>
					<tr class="header-grey">
						<td>Jumlah</td>
						<td align="right"><?php echo number_format((float)($umsiang+$ummalam))?></td>
						<td></td>
					</tr>
					<tr class="grand-total-row">
						<td>Total Diterima (Rp)</td>
						<td align="center"><b><?php echo number_format((float)($umsiang+$ummalam))?></b></td>
						<td>UM Mandor</td>
					</tr>
				</table>
			</td>
			<td width="5%"></td>
			<td width="40%" valign="top">
				<table class="table">
					<tr class="header-grey">
						<td>Jumlah Gaji Operator</td>
						<td align="right"><b><?php echo number_format((float)$allgaji)?></b></td>
					</tr>
					<tr>
						<td>Uang Makan Mandor</td>
						<td align="right"><?php echo number_format((float)($umsiang+$ummalam))?></td>
					</tr>
					<tr class="grand-total-row">
						<td><b>TOTAL GAJI BORDIR</b></td>
						<td align="right"><b><?php echo number_format((float)($allgaji+ ($umsiang+$ummalam)))?></b></td>
					</tr>
				</table>
				
				<table class="table">
					<tr class="header-grey"><td>Catatan:</td></tr>
					<tr>
						<td style="font-size: 9px;">
							1. Mandor Pagi: <?php echo $this->ReportModel->getMandor($id,1)?><br>
							2. Mandor Malam: <?php echo $this->ReportModel->getMandor($id,2)?><br>
							3. Operator sudah sistem borongan<br>
							4. Gaji dihitung dari Sabtu ke Jum'at
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

	<br>
	<table width="100%" border="0" class="text-center" style="page-break-inside: avoid;">
		<tr>
			<td width="33%">
				Disetujui<br><br><br><br>
				<b>( SPV )</b>
			</td>
			<td width="33%">
				Mengetahui<br><br><br><br>
				<b>( Rasum )</b>
			</td>
			<td width="33%">
				Disusun<br><br><br><br>
				<b>( Asmia )</b>
			</td>
		</tr>
	</table>

	<div style="position: fixed; bottom: 0; right: 0; font-size: 8px; color: #95a5a6;">
		Registered by Forboys Production System <?php echo date('d-m-Y H:i:s'); ?>
	</div>
</body>
</html>
