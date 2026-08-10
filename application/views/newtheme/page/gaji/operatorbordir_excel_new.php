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
					<?php $totalgajia=0; $potongan=0; ?>
					<?php foreach($k['details'] as $kd){ ?>
					<?php
						$potongan=$this->GlobalModel->QueryManualRow("SELECT SUM(nominal) as total FROM potongan_operator WHERE hapus=0 AND idkaryawan='".$k['idkaryawan']."' and DATE(tanggal) BETWEEN '".$k['tgl1']."' AND DATE_ADD('".$k['tgl2']."', INTERVAL 1 DAY) ");
						$my_potongan = $this->GlobalModel->QueryManual("
							SELECT jp.nama, SUM(po.nominal) as total, GROUP_CONCAT(po.keterangan SEPARATOR ', ') as keterangan 
							FROM potongan_operator po
							JOIN jenis_potongan jp ON jp.id = po.jenis_potongan
							WHERE po.hapus=0 AND po.idkaryawan='".$k['idkaryawan']."' AND DATE(po.tanggal) BETWEEN '".$k['tgl1']."' AND DATE_ADD('".$k['tgl2']."', INTERVAL 1 DAY)
							GROUP BY po.jenis_potongan
						");
					?>						
					<tr>
						<td><?php echo $kd['hari']?></td>
						<td align="right"><?php echo $kd['gaji']?></td>
						<td><?php echo $kd['keterangan']?></td>
					</tr>
					<?php $totalgajia+=$kd['gaji']; ?>
					<?php } ?>
					<?php foreach($my_potongan as $mp){ ?>
					<tr>
						<td>Pot. <?php echo $mp['nama'] ?></td>
						<td align="right"><?php echo $mp['total'] ?></td>
						<td><?php echo $mp['keterangan'] ?></td>
					</tr>
					<?php } ?>
					<?php $admin_tf = isset($k['biaya_admin_transfer']) ? (float)$k['biaya_admin_transfer'] : 0; ?>
					<?php if($admin_tf > 0){ ?>
					<tr>
						<td>Biaya Admin Transfer</td>
						<td align="right"><?php echo $admin_tf ?></td>
						<td></td>
					</tr>
					<?php } ?>
					<tr style="background-color:#f2f2f2; font-weight:bold;">
						<td>Gaji Diterima</td>
						<td align="right"><?php echo ($totalgajia - (isset($potongan['total'])?$potongan['total']:0) - $admin_tf) ?></td>
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
					<?php $totalgajib=0; $potongan=0; ?>
					<?php foreach($k['details'] as $kd){ ?>
					<?php
						$potongan=$this->GlobalModel->QueryManualRow("SELECT SUM(nominal) as total FROM potongan_operator WHERE hapus=0 AND idkaryawan='".$k['idkaryawan']."' and DATE(tanggal) BETWEEN '".$k['tgl1']."' AND DATE_ADD('".$k['tgl2']."', INTERVAL 1 DAY) ");
						$my_potongan = $this->GlobalModel->QueryManual("
							SELECT jp.nama, SUM(po.nominal) as total, GROUP_CONCAT(po.keterangan SEPARATOR ', ') as keterangan 
							FROM potongan_operator po
							JOIN jenis_potongan jp ON jp.id = po.jenis_potongan
							WHERE po.hapus=0 AND po.idkaryawan='".$k['idkaryawan']."' AND DATE(po.tanggal) BETWEEN '".$k['tgl1']."' AND DATE_ADD('".$k['tgl2']."', INTERVAL 1 DAY)
							GROUP BY po.jenis_potongan
						");
					?>						
					<tr>
						<td><?php echo $kd['hari']?></td>
						<td align="right"><?php echo $kd['gaji']?></td>
						<td><?php echo $kd['keterangan']?></td>
					</tr>
					<?php $totalgajib+=$kd['gaji']; ?>
					<?php } ?>
					<?php foreach($my_potongan as $mp){ ?>
					<tr>
						<td>Pot. <?php echo $mp['nama'] ?></td>
						<td align="right"><?php echo $mp['total'] ?></td>
						<td><?php echo $mp['keterangan'] ?></td>
					</tr>
					<?php } ?>
					<?php $admin_tf = isset($k['biaya_admin_transfer']) ? (float)$k['biaya_admin_transfer'] : 0; ?>
					<?php if($admin_tf > 0){ ?>
					<tr>
						<td>Biaya Admin Transfer</td>
						<td align="right"><?php echo $admin_tf ?></td>
						<td></td>
					</tr>
					<?php } ?>
					<tr style="background-color:#f2f2f2; font-weight:bold;">
						<td>Gaji Diterima</td>
						<td align="right"><?php echo ($totalgajib - (isset($potongan['total'])?$potongan['total']:0) - $admin_tf) ?></td>
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
$admin_tf_total = 0;
foreach($karyawans as $k){
    foreach($k['details'] as $kd){
        $semuagaji += $kd['gaji'];
    }
    $tgl2 = date('Y-m-d', strtotime($k['tgl2'] . ' +1 day'));
    $pots=$this->GlobalModel->QueryManualRow("SELECT SUM(nominal) as total FROM potongan_operator WHERE hapus=0 and DATE(tanggal) BETWEEN '".$k['tgl1']."' AND '".$tgl2."' AND tempat='".$gaji['tempat']."' AND idkaryawan='".$k['idkaryawan']."'");
    if(!empty($pots)) $pots_total += $pots['total'];
    $admin_tf_total += isset($k['biaya_admin_transfer']) ? (float)$k['biaya_admin_transfer'] : 0;
}
$all_operator_net = $semuagaji - $pots_total - $admin_tf_total;
$uang_makan_mandor = ($umsiang+$ummalam);
?>

<table border="0" style="width: 100%">
	<tr>
		<td width="400" valign="top">
			<table border="1" style="width: 100%; border-collapse: collapse;">
				<tr style="background-color: #f2f2f2">
					<th colspan="2">Uang Makan Mandor (Rp)</th>
				</tr>
				<tr>
					<td>Mandor Pagi</td>
					<td align="right"><?php echo $umsiang ?></td>
				</tr>
				<tr>
					<td>Mandor Malam</td>
					<td align="right"><?php echo $ummalam ?></td>
				</tr>
				<tr style="background-color: #f2f2f2; font-weight:bold;">
					<td>Total Uang Makan Mandor</td>
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
					<td><br><br><br><br>( Asmia )</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<br>
<div align="right" class="registered">
	Registered by Forboys Production System <?php echo date('d-m-Y H:i:s'); ?>
</div>