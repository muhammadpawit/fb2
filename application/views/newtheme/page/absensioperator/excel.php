<?php
$namafile='Laporan Absensi Operator Bordir '.time();
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=".$namafile.".xls");
?>
<style type="text/css">
	@import url('https://fonts.googleapis.com/css2?family=Baskervville:ital@1&display=swap');
  .registered {
    font-family: 'Baskervville', serif;
  }
</style>
<table>
	<tr>
		<td colspan="6"><h1>Laporan Absensi Operator Bordir Forboys Production</h1></td>
	</tr>
</table>
<div class="row">
	<div class="col-md-12">
		<table border="1" style="width: 100%;border-collapse: collapse;">
			<thead>
				<tr>
					<th>No</th>
					<th>Tanggal</th>
					<th>Nama</th>
					<th>Shift</th>
					<th>Kehadiran</th>
					<th>Keterangan</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($prods as $p){?>
					<tr>
						<td><?php echo $p['no']?></td>
						<td><?php echo date('d-m-Y',strtotime($p['tanggal']))?></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<?php foreach($p['dets'] as $pd){?>
						<tr>
							<td colspan="2"></td>
							<td><?php echo strtoupper($pd['nama'])?></td>
							<td><?php echo $pd['shift']?></td>
							<td><?php echo !empty($pd['kehadiran_operator'])?$pd['kehadiran_operator']:'TIDAK HADIR'?></td>
							<td></td>
						</tr>
					<?php } ?>
				<?php } ?>
					<tr>
			          <td colspan="6" align="right"><i class="registered">Registered by Forboys Production System <?php echo date('d-m-Y H:i:s'); ?></i></td>
			        </tr>
			</tbody>
		</table>
	</div>
</div>