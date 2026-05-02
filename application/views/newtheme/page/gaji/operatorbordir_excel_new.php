<?php
$nam=$gaji['tempat']==1?'Rumah':'Cipadu'.time();
$namafile='Laporan Gaji Operator Bordir_'.$nam;
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=".$namafile.".xls");
?>
<style type="text/css">
  .besar {font-size: 14px;}
  .registered { font-style: italic; font-size: 10px; }
</style>

<table border="1" style="width: 100%;border-collapse: collapse;">
	<tr>
		<td colspan="10" align="center"><h3>Laporan Gaji Operator Bordir <?php echo $gaji['tempat']==1?'Rumah':'Cipadu'?></h3></td>
	</tr>
	<tr>
		<td colspan="10" align="center">Periode: <?php echo date('d F Y',strtotime($gaji['tanggal1'])).' s.d '.date('d F Y',strtotime($gaji['tanggal2'])) ?></td>
	</tr>
</table>

<br>

<table border="0" style="width: 100%; border-collapse: collapse;">
	<tr>
		<?php $h=0; ?>
		<?php foreach($karyawans as $k){ ?>
		<?php if(isset($k['shift']) && $k['shift']=='PAGI'){ ?>
		<td width="300" valign="top">
			<table border="1" style="width: 100%; border-collapse: collapse;">
				<thead>
					<tr style="background-color:#f2f2f2">
						<th colspan="3"><?php echo strtoupper($k['nama'])?> (PAGI)</th>
					</tr>
					<tr style="background-color:#f2f2f2">
						<th>Hari</th>
						<th>Gaji</th>
						<th>Keterangan</th>
					</tr>
				</thead>
				<tbody>
					<?php $totalgajia=0; $absensia=0; $pinjamana=0; $claima=0; ?>
					<?php foreach($k['details'] as $kd){ ?>
					<?php
						$potongan=$this->GlobalModel->QueryManualRow("SELECT SUM(nominal) as total FROM potongan_operator WHERE hapus=0 AND idkaryawan='".$k['idkaryawan']."' and DATE(tanggal) BETWEEN '".$k['tgl1']."' AND '".$k['tgl2']."' ");
						$sabsensi=$this->GlobalModel->QueryManualRow("SELECT SUM(nominal) as total FROM potongan_operator WHERE hapus=0 AND idkaryawan='".$k['idkaryawan']."' and DATE(tanggal) BETWEEN '".$k['tgl1']."' AND '".$k['tgl2']."' AND jenis_potongan=1 ");
						if(!empty($sabsensi)) $absensia=$sabsensi['total'];
						$sclaim=$this->GlobalModel->QueryManualRow("SELECT SUM(nominal) as total,keterangan FROM potongan_operator WHERE hapus=0 AND idkaryawan='".$k['idkaryawan']."' and DATE(tanggal) BETWEEN '".$k['tgl1']."' AND '".$k['tgl2']."' AND jenis_potongan=3 ");
						if(!empty($sclaim)) $claima=$sclaim['total'];
						$spinjaman=$this->GlobalModel->QueryManualRow("SELECT SUM(nominal) as total FROM potongan_operator WHERE hapus=0 AND idkaryawan='".$k['idkaryawan']."' and DATE(tanggal) BETWEEN '".$k['tgl1']."' AND '".$k['tgl2']."' AND jenis_potongan=2 ");
						if(!empty($spinjaman)) $pinjamana=$spinjaman['total'];
					?>						
					<tr>
						<td><?php echo $kd['hari']?></td>
						<td align="right"><?php echo $kd['gaji']?></td>
						<td><?php echo $kd['keterangan']?></td>
					</tr>
					<?php $totalgajia+=$kd['gaji']; ?>
					<?php } ?>
					<tr>
						<td>Pot.Absensi</td>
						<td align="right"><?php echo $absensia?></td>
						<td></td>
					</tr>
					<tr>
						<td>Pot.Claim</td>
						<td align="right"><?php echo $claima?></td>
						<td><?php echo !empty($claima)?$sclaim['keterangan']:'';?></td>
					</tr>
					<tr>
						<td>Pot.Pinjaman</td>
						<td align="right"><?php echo $pinjamana?></td>
						<td></td>
					</tr>
					<tr style="background-color:#f2f2f2; font-weight:bold;">
						<td>Gaji Diterima</td>
						<td align="right"><?php echo ($totalgajia-($absensia+$claima+$pinjamana)) ?></td>
						<td></td>
					</tr>
				</tbody>
			</table>
		</td>
		<td width="10"></td>
		<?php } ?>
		<?php } ?>
	</tr>
</table>

<br>

<table border="0" style="width: 100%; border-collapse: collapse;">
	<tr>
		<?php foreach($karyawans as $k){ ?>
		<?php if(isset($k['shift']) && $k['shift']=='MALAM'){ ?>
		<td width="300" valign="top">
			<table border="1" style="width: 100%; border-collapse: collapse;">
				<thead>
					<tr style="background-color:#f2f2f2">
						<th colspan="3"><?php echo strtoupper($k['nama'])?> (MALAM)</th>
					</tr>
					<tr style="background-color:#f2f2f2">
						<th>Hari</th>
						<th>Gaji</th>
						<th>Keterangan</th>
					</tr>
				</thead>
				<tbody>
					<?php $totalgajib=0; $absensib=0; $pinjamanb=0; $claimb=0; ?>
					<?php foreach($k['details'] as $kd){ ?>
					<?php
						$potongan=$this->GlobalModel->QueryManualRow("SELECT SUM(nominal) as total FROM potongan_operator WHERE hapus=0 AND idkaryawan='".$k['idkaryawan']."' and DATE(tanggal) BETWEEN '".$k['tgl1']."' AND '".$k['tgl2']."' ");
						$sabsensi=$this->GlobalModel->QueryManualRow("SELECT SUM(nominal) as total FROM potongan_operator WHERE hapus=0 AND idkaryawan='".$k['idkaryawan']."' and DATE(tanggal) BETWEEN '".$k['tgl1']."' AND '".$k['tgl2']."' AND jenis_potongan=1 ");
						if(!empty($sabsensi)) $absensib=$sabsensi['total'];
						$sclaim=$this->GlobalModel->QueryManualRow("SELECT SUM(nominal) as total,keterangan FROM potongan_operator WHERE hapus=0 AND idkaryawan='".$k['idkaryawan']."' and DATE(tanggal) BETWEEN '".$k['tgl1']."' AND '".$k['tgl2']."' AND jenis_potongan=3 ");
						if(!empty($sclaim)) $claimb=$sclaim['total'];
						$spinjaman=$this->GlobalModel->QueryManualRow("SELECT SUM(nominal) as total FROM potongan_operator WHERE hapus=0 AND idkaryawan='".$k['idkaryawan']."' and DATE(tanggal) BETWEEN '".$k['tgl1']."' AND '".$k['tgl2']."' AND jenis_potongan=2 ");
						if(!empty($spinjaman)) $pinjamanb=$spinjaman['total'];
					?>						
					<tr>
						<td><?php echo $kd['hari']?></td>
						<td align="right"><?php echo $kd['gaji']?></td>
						<td><?php echo $kd['keterangan']?></td>
					</tr>
					<?php $totalgajib+=$kd['gaji']; ?>
					<?php } ?>
					<tr>
						<td>Pot.Absensi</td>
						<td align="right"><?php echo $absensib?></td>
						<td></td>
					</tr>
					<tr>
						<td>Pot.Claim</td>
						<td align="right"><?php echo $claimb?></td>
						<td><?php echo !empty($claimb)?$sclaim['keterangan']:'';?></td>
					</tr>
					<tr>
						<td>Pot.Pinjaman</td>
						<td align="right"><?php echo $pinjamanb?></td>
						<td></td>
					</tr>
					<tr style="background-color:#f2f2f2; font-weight:bold;">
						<td>Gaji Diterima</td>
						<td align="right"><?php echo ($totalgajib-($absensib+$claimb+$pinjamanb)) ?></td>
						<td></td>
					</tr>
				</tbody>
			</table>
		</td>
		<td width="10"></td>
		<?php } ?>
		<?php } ?>
	</tr>
</table>

<br>

<?php 
$semuagaji = 0;
$pots_total = 0;
foreach($karyawans as $k){
    foreach($k['details'] as $kd){
        $semuagaji += $kd['gaji'];
    }
    $pots=$this->GlobalModel->QueryManualRow("SELECT SUM(nominal) as total FROM potongan_operator WHERE hapus=0 and DATE(tanggal) BETWEEN '".$k['tgl1']."' AND '".$k['tgl2']."' AND tempat='".$gaji['tempat']."'");
    if(!empty($pots)) $pots_total = $pots['total'];
}
$all_operator_net = $semuagaji - $pots_total;
$uang_makan_mandor = ($bonussiang+$bonusmalam)*0.3 + ($umsiang+$ummalam);
?>

<table border="0" style="width: 100%">
	<tr>
		<td width="400" valign="top">
			<table border="1" style="width: 100%; border-collapse: collapse;">
				<tr style="background-color: #f2f2f2">
					<th colspan="2">Uang Makan Mandor (Rp)</th>
				</tr>
				<tr>
					<td>Mandor Pagi (UM + Bonus 30%)</td>
					<td align="right"><?php echo $umsiang + ($bonussiang * 0.3) ?></td>
				</tr>
				<tr>
					<td>Mandor Malam (UM + Bonus 30%)</td>
					<td align="right"><?php echo $ummalam + ($bonusmalam * 0.3) ?></td>
				</tr>
				<tr style="background-color: #f2f2f2; font-weight:bold;">
					<td>Total Diterima Mandor</td>
					<td align="right"><?php echo $uang_makan_mandor ?></td>
				</tr>
			</table>
		</td>
		<td width="50"></td>
		<td width="400" valign="top">
			<table border="1" style="width: 100%; border-collapse: collapse;">
				<tr style="background-color: #f2f2f2">
					<th colspan="2">Ringkasan Total Gaji</th>
				</tr>
				<tr>
					<td>Total Gaji Operator</td>
					<td align="right"><?php echo $all_operator_net ?></td>
				</tr>
				<tr>
					<td>Total Uang Makan Mandor</td>
					<td align="right"><?php echo $uang_makan_mandor ?></td>
				</tr>
				<tr style="background-color: #f2f2f2; font-weight:bold;">
					<td>GRAND TOTAL GAJI BORDIR</td>
					<td align="right"><?php echo $all_operator_net + $uang_makan_mandor ?></td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<br>

<table border="0" style="width: 100%">
	<tr>
		<td colspan="5" valign="top">
			<b>Catatan :</b><br>
			1. Operator sudah sistem borongan<br>
			2. Gaji dihitung dari Sabtu ke Jum'at<br>
			3. Rumus: (Jumlah Bordir X Stich X Tarif) X Persentase (%)
		</td>
		<td colspan="5" align="right">
			<b>Jakarta, <?php echo date('d F Y', strtotime($gaji['tanggal2'])) ?></b><br><br>
			<table border="1" style="border-collapse: collapse; width: 300px;">
				<tr align="center">
					<th>Disetujui</th>
					<th>Mengetahui</th>
					<th>Disusun</th>
				</tr>
				<tr align="center">
					<td><br><br><br><br>( SPV )</td>
					<td><br><br><br><br>( Rasum )</td>
					<td><br><br><br><br>( Tria )</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<br>
<div align="right" class="registered">
	Registered by Forboys Production System <?php echo date('d-m-Y H:i:s'); ?>
</div>