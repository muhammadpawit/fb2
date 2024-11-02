<?php
 $namafile='Laporan_Rincian_Setor_Kaos'.time();
 header("Content-type: application/vnd-ms-excel");
 header("Content-Disposition: attachment; filename=".$namafile.".xls");
?>
<style type="text/css">
    @import url('https://fonts.googleapis.com/css2?family=Baskervville:ital@1&display=swap');
  .registered {
    font-family: 'Baskervville', serif;
  }
</style>
<table style="width: 100%;">
	<tr>
		<th colspan="14" align="center"><h3>Rincian Setor Kaos CMT</h3></th>
	</tr>
</table>
<br>
<table border="1" style="width: 100%;border-collapse: collapse;">
			<thead style="background-color: #b8cce4 !important">
				<tr style="background-color: #b8cce4 !important;font-size:2vw;">
					<th>No</th>
					<th>Tanggal Setor</th>
					<th>Nama PO</th>
					<th>Jumlah Potong</th>
					<th>Tanggal Kirim Ke CMT</th>
					<th>Jumlah Kirim (Ke CMT)</th>
					<th>Jumlah Setor (PCS)</th>
					<th>Jumlah Bagus (PCS)</th>
					<th>Rincian (SIZE)</th>
					<th>Bangke (PCS)</th>
					<th>BS</th>
					<th>Cabang</th>
					<th>Nama CMT</th>
					<th>Keterangan</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($prods as $p){?>
					<tr>
						<td><?php echo $p['no']?></td>
						<td><?php echo $p['tanggal']?></td>
						<td><?php echo $p['kode_po']?></td>
						<td><?php echo $p['potong']?></td>
						<td><?php echo $p['tgl_kirim']?></td>
						<td><?php echo $p['pcs_kirim']?></td>
						<td><?php echo $p['pcs_setor']?></td>
						<td><?php echo $p['pcs_bagus']?></td>
						<td>
							<?php foreach($p['size'] as $s){?>
								<?php echo $s['rincian_size']?> : <?php echo $s['rincian_lusin']?> DZ <?php echo $s['rincian_piece']>0?$s['rincian_piece'].' pcs':'';?><br>
							<?php } ?>
						</td>
						<td><?php echo $p['bangke']?></td>
						<td><?php echo $p['bs']?></td>
						<td><?php echo $p['cabang']?></td>
						<td><?php echo $p['cmt']?></td>
						<td>
						<?php foreach($p['size'] as $s){?>
								<?php echo $s['rincian_keterangan']?> <br>
							<?php } ?>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
		<br><br>
		<table style="width: 100%;">
			<tr>
				<th colspan="10" align="center"></th>
				<th>
					Di Cek Oleh,
					<br><br><br><br>
					(Mia)
				</th>
				<th></th>
				<th></th>
				<th>
					Dibuat Oleh,
					<br><br><br><br>
					(Kandar)
				</th>
			</tr>
			<!-- <tr>
				<th colspan="10" align="center"></th>
				<th><br><br><br>Dinda</th>
				<th></th>
				<th></th>
				<th><br><br><br>Dewi</th>
			</tr> -->
		</table>
		<br>
		<table style="width: 100%;">
	        <tr>
	            <td colspan="14" align="right"><i class="registered">Registered by Forboys Production System <?php echo date('d-m-Y H:i:s'); ?></i></td>
	        </tr>
	    </table>       