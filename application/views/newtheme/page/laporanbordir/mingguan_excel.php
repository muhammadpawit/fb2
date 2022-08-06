<?php
$namafile='Laporan_Bulanan_Bordir_'.time();
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=".$namafile.".xls");
?>
<style type="text/css">
  @import url('https://fonts.googleapis.com/css2?family=Baskervville:ital@1&display=swap');
  .registered {
    font-family: 'Baskervville', serif;
  }
</style>
<style type="text/css">
    @import url('https://fonts.googleapis.com/css2?family=Baskervville:ital@1&display=swap');
  .registered {
    font-family: 'Baskervville', serif;
  }
</style>
			<table border="1" style="width: 100%;border-collapse: collapse;">
				<thead>
					<tr>
						<th colspan="2">Pendapatan</th>
						<th>Rp</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td colspan="2">Pendapatan PO Dalam</td>
						<!-- <td>:</td> -->
						<td align="right"><?php echo $totalpendapatan?></td>
					</tr>
					<!-- <tr>
						<td>Pendapatan PO 0.15</td>
						<td>:</td>
						<td align="right"><?php echo $p15?></td>
					</tr> -->
					<tr>
						<td colspan="2">Pendapatan PO Luar / PO Homie</td>
						<!-- <td>:</td> -->
						<td align="right"><?php echo $totalpoluar?></td>
					</tr>
					<!--<tr>
						<td colspan="2">Pendapatan PO Yuna</td>
						<td align="right"></td>
					</tr>-->
				</tbody>
				<tfoot>
					<tr>
						<td colspan="2"><b>Total Pendapatan</b></td>
						<td align="right"><b><?php echo ($totalpen)?></b></td>
					</tr>
				</tfoot>
			</table>

			<table border="1" style="width: 100%;border-collapse: collapse;">
				<thead>
					<tr>
						<th colspan="2">Pengeluaran</th>
						<th>Rp</th>
					</tr>
				</thead>
				<tbody>
					<?php $totalpengeluaran=0; ?>
					<?php foreach($pengeluarans as $p){?>
						<?php foreach($p['detail'] as $pd){?>
							<tr>
								<td colspan="2" width="155"><?php echo $pd['keterangan']?></td>
								<!-- <td>:</td> -->
								<td align="right"><?php echo ($pd['total'])?></td>
							</tr>
							<?php $totalpengeluaran+=($pd['total']); ?>
						<?php } ?>
					<?php } ?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="2"><b>Total Pengeluaran</b></td>
						<td align="right"><b><?php echo ($totalpengeluaran)?></b></td>
					</tr>
					<tr>
						<td colspan="2"></td>
						<td></td>
					</tr>
					<tr>
						<td colspan="2"><b>Laba Produksi</b></td>
						<td align="right"><b><?php echo ($totalpen-$totalpengeluaran)?></b></td>
					</tr>
					<tr>
                        <td colspan="3" align="right"><i class="registered">Registered by Forboys Production System <?php echo date('d-m-Y H:i:s'); ?></i></td>
                    </tr>
				</tfoot>
			</table>