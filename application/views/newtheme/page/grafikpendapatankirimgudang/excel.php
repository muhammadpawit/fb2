<?php
$namafile='Grafik_Kirim_Gudang_Bulanan_'.time();
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=".$namafile.".xls");
?>

<div class="row">
	<div class="col-md-12">
		<h2 class="text-center">Grafik Lapporan Kirim Gudang Bulanan</h2>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<table border="1" style="width: 100%;border-collapse: collapse;">
			<thead>
				<tr align="center" valign="top">
				    <th rowspan="2">Bulan</th>
				    <th colspan="4">Pendapatan</th>
				    <th rowspan="2">Keterangan</th>
				</tr>
				<tr align="center">
				    <th>Kemeja</th>
				    <th>Kaos</th>
				    <th>Celana</th>
				    <th>Total</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$kemeja=0;
					$kaos=0;
					$celana=0;
					$total=0;
				?>
				<?php foreach($prods as $p){?>
					<tr>
						<td><?php echo $p['bulan']?></td>
						<td align="right"><?php echo ($p['kemeja'])?></td>
						<td align="right"><?php echo ($p['kaos'])?></td>
						<td align="right"><?php echo ($p['celana'])?></td>
						<td align="right"><?php echo (($p['kemeja']+$p['kaos']+$p['celana']))?></td>
						<td><?php echo $p['keterangan']?></td>
					</tr>
				<?php
					$kemeja+=($p['kemeja']);
					$kaos+=($p['kaos']);
					$celana+=($p['celana']);
					$total+=($p['kemeja']+$p['kaos']+$p['celana']);
				?>
				<?php } ?>
			</tbody>
			<tfoot>
				<tr>
					<td><b>Total</b></td>
					<td align="right"><b><?php echo ($kemeja)?></b></td>
					<td align="right"><b><?php echo ($kaos)?></b></td>
					<td align="right"><b><?php echo ($celana)?></b></td>
					<td align="right"><b><?php echo ($total)?></b></td>
					<td></td>
				</tr>
			</tfoot>
		</table>
	</div>
</div>

<table>
										<tr>
                                            <td colspan="6"></td>
                                        </tr>
                                        <tr>
                                          <td colspan="6" align="right"><i class="registered">Registered by Forboys Production System <?php echo date('d-m-Y H:i:s'); ?></i></td>
                                        </tr>
</table>