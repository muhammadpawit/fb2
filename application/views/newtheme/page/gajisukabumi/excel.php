<?php
$namafile='Gaji_Sukabumi_'.time();
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=".$namafile.".xls");
?>
<style type="text/css">
    @import url('https://fonts.googleapis.com/css2?family=Baskervville:ital@1&display=swap');
  .registered {
    font-family: 'Baskervville', serif;
  }
</style>
<table border="1" style="width: 100%;border-collapse: collapse;">
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<h3 class="text-center">Rincian Gaji Karyawan Sukabumi</h3>
				<table border="1" style="width: 100%;border-collapse: collapse;">
					<thead>
						<tr>
							<th>Nama</th>
							<th>Bagian</th>
							<th>Jml Hari Kerja</th>
							<th>Upah / Hari</th>
							<th>Jumlah (Rp)</th>
							<th>Keterangan</th>
						</tr>
					</thead>
					<tbody id="bod">
						<?php foreach($detail as $d){?>
							<tr>
								<td><?php echo strtolower($d['nama'])?></td>
								<td><?php echo strtolower($d['bagian'])?></td>
								<td><?php echo strtolower($d['jml_hari_kerja'])?></td>
								<td><?php echo ($d['upah'])?></td>
								<td><?php echo ($d['total'])?></td>
								<td><?php echo strtolower($d['keterangan'])?></td>
							</tr>
						<?php } ?>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="4" align="center"><b>Total</b></td>
							<td><b><?php echo ($p['total'])?></b></td>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<h3 class="text-center">Anggaran Operasional</h3>
				<table border="1" style="width: 100%;border-collapse: collapse;">
					<thead>
						<tr>
							<th>Keperluan</th>
							<th>JML BRG</th>
							<th>Harga</th>
							<th>Jumlah (Rp)</th>
							<th>Keterangan</th>
						</tr>
					</thead>
					<tbody id="bod">
						<?php foreach($sd as $d){?>
							<tr>
								<td><?php echo strtolower($d['keperluan'])?></td>
								<td><?php echo strtolower($d['jml'])?></td>
								<td><?php echo ($d['harga'])?></td>
								<td><?php echo ($d['total'])?></td>
								<td><?php echo strtolower($d['keterangan'])?></td>
							</tr>
						<?php } ?>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="3" align="center"><b>Total</b></td>
							<td><b><?php echo ($a['total'])?></b></td>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<h3 class="text-center">Rekap</h3>
				<table border="1" style="width: 100%;border-collapse: collapse;">
					<thead>
						<tr>
							<th>Nama CMT</th>
							<th>Atas Nama</th>
							<th>No.Rek</th>
							<th>Jml.Transferan (Rp)</th>
						</tr>
					</thead>
					<tbody >
						<tr>
							<td>Kasbon & Gaji Anak Harian</td>
							<td>TONI ANDRIAN</td>
							<td>4408-01-001034-50-7</td>
							<td><?php echo ($p['total'])?></td>
						</tr>
						<tr>
							<td>Anggaran Operasional</td>
							<td></td>
							<td></td>
							<td><?php echo ($a['total'])?></td>
						</tr>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="3" align="center"><b>Total</b></td>
							<td><b><?php echo ($p['total']+$a['total'])?></b></td>
						</tr>
												
					</tfoot>
				</table>
			</div>
		</div>
	</div>
	<br>
	<table style="width: 100%;border-collapse: collapse;">
		<tr>
                           <td colspan="6" align="right"><i class="registered">Registered by Forboys Production System <?php echo date('d-m-Y H:i:s'); ?></i></td>
                        </tr>
	</table>