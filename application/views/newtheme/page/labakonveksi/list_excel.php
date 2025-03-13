<?php
$namafile='Laporan_Pendapatan_Bordir_'.time();
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=".$namafile.".xls");
?>
<style type="text/css">
	@import url('https://fonts.googleapis.com/css2?family=Baskervville:ital@1&display=swap');
  .registered {
    font-family: 'Baskervville', serif;
  }
</style>
<h3>Pendapatan Bordir</h3>
<div class="row">
	<div class="col-md-12">
		<table border="1" style="width: 100%;border-collapse: collapse;">
			<thead>
				<tr>
					<th class="tg-0lax">No</th>
				    <th class="tg-0lax">Periode</th>
				    <th class="tg-0lax">Pendapatan</th>
				    <th class="tg-0lax">Pengeluaran</th>
				    <th class="tg-0lax">Saldo</th>
				    <th class="tg-0lax">Keterangan</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="tg-0lax">1</td>
				    <td rowspan="4">Bordir<br></td>
				    <td align="center" class="tg-0lax"><?php echo round($podalam)?></td>
				    <td class="tg-0lax"></td>
				    <td class="tg-0lax"></td>
				    <td class="tg-0lax">PO Dalam</td>
				</tr>
				<tr>
					<td class="tg-0lax">2</td>
				    <td align="center" class="tg-0lax"><?php echo round($poluar)?></td>
				    <td class="tg-0lax"></td>
				    <td class="tg-0lax"></td>
				    <td class="tg-0lax">PO Luar</td>
				</tr>
				<tr>
					<td class="tg-0lax">3</td>
				    <td class="tg-0lax"></td>
				    <td align="center" class="tg-0lax"><?php echo round($keluar)?></td>
				    <td class="tg-0lax"></td>
				    <td class="tg-0lax">Pengeluaran alur kas bordir</td>
				</tr>
				<tr>
					<td class="tg-0lax">4</td>
				    <td class="tg-0lax"></td>
				    <td class="tg-0lax"></td>
				    <td class="tg-0lax"></td>
				    <td class="tg-0lax">Laba Pendapatan Bordir</td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
				<td class="tg-0lax" colspan="2" align="center"><h5>Total (Rp)</h5></td>
			    <td class="tg-0lax"></td>
			    <td class="tg-0lax"></td>
			    <td class="tg-0lax" align="center" style="background-color:#dbdb02;"><h5><?php echo round(($podalam+$poluar)-$keluar)?></h5></td>
			    <td class="tg-0lax"></td>
			    
				</tr>
			    <tr>
			        <td colspan="6" align="right"><i class="registered">Registered by Forboys Production System <?php echo date('d-m-Y Y H:i:s'); ?></i></td>
			     </tr>
			</tfoot>
		</table>
	</div>
</div>