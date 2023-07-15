<?php
 $namafile='Laporan_Bangke'.time();
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
		<th colspan="4" align="center"><h3>Laporan PO Bangke & Rijek</h3></th>
	</tr>
</table>
<br>
        <table border="1" style="width: 100%;border-collapse: collapse;">
			<thead>
				<tr>
					<th>No</th>
					<th>Kode PO</th>
					<th>Jumlah Bangke (pcs)</th>
					<th>Jumlah Rijek (pcs)</th>
				</tr>
			</thead>
			<tbody>
				<?php $total=0;$rijek=0;?>
				<?php foreach($prods as $p){?>
					<tr>
						<td><?php echo $p['no']?></td>
						<td><?php echo $p['kode_po']?></td>
						<td><?php echo $p['bangke']?></td>
						<td><?php echo $p['rijek']?></td>
					</tr>
				<?php $total+=($p['bangke']);?>
				<?php $rijek+=($p['rijek']);?>
				<?php } ?>
				<tr>
					<td colspan="2"><b>Total</b></td>
					<td><b><?php echo $total ?></b></td>
					<td><b><?php echo $rijek ?></b></td>
				</tr>
			</tbody>
		</table>