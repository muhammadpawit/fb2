<!DOCTYPE html>
<html>
<head>
	<title><?php echo $title ?></title>
	<style>
		body { font-family: sans-serif; font-size: 12px; }
		table { width: 100%; border-collapse: collapse; margin-top: 20px; }
		th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
		th { background-color: #f2f2f2; }
		.text-center { text-align: center; }
		h2 { text-align: center; }
	</style>
</head>
<body>
	<h2><?php echo $title ?></h2>
	<p>Periode: <?php echo formatTanggalIndo($tanggal1) ?> s/d <?php echo formatTanggalIndo($tanggal2) ?></p>

	<table>
		<thead>
			<tr>
				<th>No</th>
				<th>No.SJ</th>
				<th>Tanggal</th>
				<th>Nama CMT</th>
				<th>Quantity</th>
				<th>PO</th>
				<th>Status</th>
			</tr>
		</thead>
		<tbody>
			<?php $no=1; $total_qty = 0; ?>
			<?php foreach($products as $p){?>
				<?php foreach($p['dets'] as $d){?>
					<?php 
						if(isset($sablon)){
							$po = $this->GlobalModel->getDataRow('produksi_po',array('id_produksi_po'=>$d['idpo']));
						} else if(isset($sablonluar)){
							$po = $this->GlobalModel->QueryManualRow("SELECT nama as kode_po FROM master_po_luar WHERE id='".$d['kode_po']."' ");
						} else {
							$po = $this->GlobalModel->getDataRow('produksi_po',array('id_produksi_po'=>$d['kode_po']));
						} 
						$total_qty += $d['jumlah_pcs'];
					?>
				<tr>
					<td class="text-center"><?php echo $no++ ?></td>
					<td><?php echo $p['nosj'] ?></td>
					<td><?php echo $p['tanggal'] ?></td>
					<td><?php echo $p['namacmt'] ?></td>
					<td class="text-center"><?php echo $d['jumlah_pcs'] ?></td>
					<td><?php echo isset($po['kode_po'])?$po['kode_po']:'' ?></td>
					<td><?php echo $p['status'] ?></td>
				</tr>
				<?php } ?>
			<?php } ?>
		</tbody>
		<tfoot>
			<tr>
				<th colspan="4" style="text-align: right;">Total Quantity</th>
				<th class="text-center"><?php echo $total_qty ?></th>
				<th colspan="2"></th>
			</tr>
		</tfoot>
	</table>
	<br><br>
	<table style="width: 100%; border: none; margin-top: 30px;">
		<tr>
			<td style="border: none; width: 33%; text-align: center; padding-bottom: 5px;">
				Dibuat Oleh,<br><br><br><br><br>
				(..........)<br>
				Admin
			</td>
			<td style="border: none; width: 33%; text-align: center; padding-bottom: 5px;">
				Mengetahui,<br><br><br><br><br>
				(..........)<br>
				SPV
			</td>
			<td style="border: none; width: 33%; text-align: center; padding-bottom: 5px;">
				Disetujui Oleh,<br><br><br><br><br>
				(..........)<br>
				Manager
			</td>
		</tr>
	</table>
</body>
</html>
