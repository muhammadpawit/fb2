<!DOCTYPE html>
<html>
<head>
	<title>Laporan Monitoring Kirim Gudang</title>
	<style type="text/css">
		body {
			font-family: sans-serif;
			font-size: 10px;
		}
		table {
			width: 100%;
			border-collapse: collapse;
			margin-bottom: 20px;
		}
		th, td {
			border: 1px solid #000;
			padding: 5px;
			text-align: center;
		}
		th {
			background-color: #f2f2f2;
		}
		.title {
			text-align: center;
			margin-bottom: 20px;
		}
		.header-info {
			background-color: #3D6AA2;
			color: white;
			padding: 10px;
			text-align: center;
			margin-bottom: 10px;
			font-weight: bold;
		}
		.section-title {
			background-color: #3D6AA2;
			color: white;
			padding: 5px;
			text-align: center;
			margin-bottom: 5px;
			font-weight: bold;
		}
	</style>
</head>
<body>
	<div class="title">
		<h3>Laporan Monitoring Kirim Gudang</h3>
	</div>

	<div class="header-info">Update <?php echo date('d F Y')?> (<?php echo date('d-m-Y', strtotime($tanggal1)) ?> s/d <?php echo date('d-m-Y', strtotime($tanggal2)) ?>)</div>

	<table>
		<thead>
			<tr>
				<th>No</th>
				<th>Nama</th>
				<th>Jml PO</th>
				<th>Dz</th>
				<th>Pcs</th>
				<th>Total</th>
			</tr>
		</thead>
		<tbody>
			<?php $nom=1;$adjpo=0;$adjdz=0;$adjpcs=0;$adjtotal=0;?>
			<?php foreach($adjustment as $r){?>
				<tr>
					<td><?php echo $nom++?></td>
					<td><?php echo $r['nama']?></td>
					<td><?php echo number_format($r['po'])?></td>
					<td><?php echo number_format($r['dz'],2)?></td>
					<td><?php echo number_format($r['pcs'])?></td>
					<td><?php echo number_format($r['total'])?></td>
				</tr>
				<?php
					$adjpo+=($r['po']);
					$adjdz+=($r['dz']);
					$adjpcs+=($r['pcs']);
					$adjtotal+=($r['total']);
				?>
			<?php } ?>

			<?php $po=0;$dz=0;$pcs=0;$total=0; ?>
			<?php foreach($rekap as $r){?>
				<?php if($r['po'] > 0){ ?>
					<tr>
						<td><?php echo $nom++?></td>
						<td><?php echo $r['type']?></td>
						<td><?php echo number_format($r['po'])?></td>
						<td><?php echo number_format($r['dz'],2)?></td>
						<td><?php echo number_format($r['pcs'])?></td>
						<td><?php echo number_format($r['total'])?></td>
					</tr>
				<?php } ?>
				<?php
					$po+=($r['po']);
					$dz+=($r['dz']);
					$pcs+=($r['pcs']);
					$total+=($r['total']);
				?>
			<?php } ?>
			<tr style="font-weight: bold; background-color: #eee;">
				<td colspan="2">Total</td>
				<td><?php echo number_format($adjpo+$po)?></td>
				<td><?php echo number_format($adjdz+$dz,2)?></td>
				<td><?php echo number_format($adjpcs+$pcs)?></td>
				<td><?php echo number_format($adjtotal+$total)?></td>
			</tr>
		</tbody>
	</table>

	<div class="section-title">Kemeja</div>
	<table>
		<thead>
			<tr>
				<th>No</th>
				<th>Nama</th>
				<th>Jml PO</th>
				<th>Dz</th>
				<th>Pcs</th>
				<th>Total</th>
				<th>HPP (Dz)</th>
				<th>HPP (Pcs)</th>
			</tr>
		</thead>
		<tbody>
			<?php $po=0;$dz=0;$pcs=0;$total=0;$pcs1=0;$pcs2=0;$nokemeja=1; ?>
			<?php foreach($rekapkemeja as $r){?>
				<?php if($r['po'] > 0){ ?>
					<tr>
						<td><?php echo $nokemeja++ ?></td>
						<td><?php echo $r['type']?></td>
						<td><?php echo number_format($r['po'])?></td>
						<td><?php echo number_format($r['dz'],2)?></td>
						<td><?php echo number_format($r['pcs'])?></td>
						<td><?php echo number_format($r['total'])?></td>
						<td><?php echo number_format($r['hppdz'],2)?></td>
						<td><?php echo number_format($r['hpppcs'])?></td>
					</tr>
				<?php } ?>
				<?php
					$po+=($r['po']);
					$dz+=($r['dz']);
					$pcs+=($r['pcs']);
					$total+=($r['total']);
					$pcs1+=($r['hppdz']);
					$pcs2+=($r['hpppcs']);
				?>
			<?php } ?>
			<tr style="font-weight: bold; background-color: #eee;">
				<td colspan="2">Total</td>
				<td><?php echo number_format($po)?></td>
				<td><?php echo number_format($dz,2)?></td>
				<td><?php echo number_format($pcs)?></td>
				<td><?php echo number_format($total)?></td>
				<td><?php echo number_format($pcs1,2)?></td>
				<td><?php echo number_format($pcs2)?></td>
			</tr>
		</tbody>
	</table>

	<div class="section-title">Celana</div>
	<table>
		<thead>
			<tr>
				<th>No</th>
				<th>Nama</th>
				<th>Jml PO</th>
				<th>Dz</th>
				<th>Pcs</th>
				<th>Total</th>
				<th>HPP (Dz)</th>
				<th>HPP (Pcs)</th>
			</tr>
		</thead>
		<tbody>
			<?php $po=0;$dz=0;$pcs=0;$total=0;$pcs1=0;$pcs2=0;$nocelana=1; ?>
			<?php foreach($rekapcelana as $r){?>
				<?php if($r['po'] > 0){ ?>
					<tr>
						<td><?php echo $nocelana++?></td>
						<td><?php echo $r['type']?></td>
						<td><?php echo number_format($r['po'])?></td>
						<td><?php echo number_format($r['dz'],2)?></td>
						<td><?php echo number_format($r['pcs'])?></td>
						<td><?php echo number_format($r['total'])?></td>
						<td><?php echo number_format($r['hppdz'],2)?></td>
						<td><?php echo number_format($r['hpppcs'])?></td>
					</tr>
				<?php } ?>
				<?php
					$po+=($r['po']);
					$dz+=($r['dz']);
					$pcs+=($r['pcs']);
					$total+=($r['total']);
					$pcs1+=($r['hppdz']);
					$pcs2+=($r['hpppcs']);
				?>
			<?php } ?>
			<tr style="font-weight: bold; background-color: #eee;">
				<td colspan="2">Total</td>
				<td><?php echo number_format($po)?></td>
				<td><?php echo number_format($dz,2)?></td>
				<td><?php echo number_format($pcs)?></td>
				<td><?php echo number_format($total)?></td>
				<td><?php echo number_format($pcs1,2)?></td>
				<td><?php echo number_format($pcs2)?></td>
			</tr>
		</tbody>
	</table>

	<div class="section-title">Kaos</div>
	<table>
		<thead>
			<tr>
				<th>No</th>
				<th>Nama</th>
				<th>Jml PO</th>
				<th>Dz</th>
				<th>Pcs</th>
				<th>Total</th>
				<th>HPP (Dz)</th>
				<th>HPP (Pcs)</th>
			</tr>
		</thead>
		<tbody>
			<?php $po=0;$dz=0;$pcs=0;$total=0;$pcs1=0;$pcs2=0;$nokaos=1; ?>
			<?php foreach($rekapkaos as $r){?>
				<?php if($r['po'] > 0){ ?>
					<tr>
						<td><?php echo $nokaos++ ?></td>
						<td><?php echo $r['type']?></td>
						<td><?php echo number_format($r['po'])?></td>
						<td><?php echo number_format($r['dz'],2)?></td>
						<td><?php echo number_format($r['pcs'])?></td>
						<td><?php echo number_format($r['total'])?></td>
						<td><?php echo number_format($r['hppdz'],2)?></td>
						<td><?php echo number_format($r['hpppcs'])?></td>
					</tr>
				<?php } ?>
				<?php
					$po+=($r['po']);
					$dz+=($r['dz']);
					$pcs+=($r['pcs']);
					$total+=($r['total']);
					$pcs1+=($r['hppdz']);
					$pcs2+=($r['hpppcs']);
				?>
			<?php } ?>
			<tr style="font-weight: bold; background-color: #eee;">
				<td colspan="2">Total</td>
				<td><?php echo number_format($po)?></td>
				<td><?php echo number_format($dz,2)?></td>
				<td><?php echo number_format($pcs)?></td>
				<td><?php echo number_format($total)?></td>
				<td><?php echo number_format($pcs1,2)?></td>
				<td><?php echo number_format($pcs2)?></td>
			</tr>
		</tbody>
	</table>
</body>
</html>
