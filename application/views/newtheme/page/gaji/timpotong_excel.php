<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Laporan_Pembayaran_Tim_Potong_".date('d F Y',strtotime($prods['tanggal'])).time().".xls");
?>
<style>
body {
font-family: Arial, Helvetica, sans-serif;
font-size: 12px;
}
table {
border-collapse: collapse;
width: 100%;
}
th, td {
border: 1px solid #000;
padding: 6px 8px;
}
th {
background: #f2f2f2;
text-align: center;
}
.text-center { text-align: center; }
.text-right { text-align: right; }
.no-border td { border: none; }
.title {
font-size: 14px;
font-weight: bold;
text-align: center;
padding: 10px 0;
}
.signature td {
height: 90px;
vertical-align: bottom;
text-align: center;
}
.registered {
font-style: italic;
font-size: 11px;
}
</style>		
		<table border="1" style="border-collapse: collapse;width: 100%;" cellpadding="12">
			<thead>
				<tr>
					<th colspan="10" align="center"><h4>Laporan Pembayaran Hasil Kerja Tim Potong <?php echo $timnya['nama']?></h4></th>
				</tr>
				<tr>
					<th>No</th>
					<th>Tanggal</th>
					<th>Nama PO</th>
					<th>Jenis</th>
					<th>Size</th>
					<th>JML PO (Dz)</th>
					<th>JML PO (Pcs)</th>
					<th>Harga/Pcs</th>
					<th>Total Pendapatan</th>
					<th>Keterangan</th>
				</tr>
			</thead>
			<tbody>
				<?php $no = 1; ?>
				<?php foreach ($products as $p): ?>
				<?php if ($p['total'] > 0): ?>
				<tr>
				<td class="text-center"><?= $no++ ?></td>
				<td class="text-center"><?= date('Y-m-d', strtotime($p['tanggal'])) ?></td>
				<td><?= htmlspecialchars($p['kode_po']) ?></td>
				<td><?= htmlspecialchars($p['jenis']) ?></td>
				<td class="text-center">'<?= $p['size'] ?></td>
				<td class="text-right">'<?= number_format($p['lusin'], 2) ?></td>
				<td class="text-right"><?= number_format($p['pcs']) ?></td>
				<td class="text-right"><?= number_format($p['harga'], 2) ?></td>
				<td class="text-right"><?= number_format($p['total'], 2) ?></td>
				<td></td>
				</tr>
				<?php endif; ?>
				<?php endforeach; ?>
				<tr>
					<td colspan="8" class="text-right"><b>Subtotal</b></td>
					<td class="text-right"><b><?= number_format($totals, 2) ?></b></td>
					<td></td>
					</tr>
					<tr>
					<td colspan="8" class="text-right"><b>Saving 5%</b></td>
					<td class="text-right"><b><?= number_format($savings, 2) ?></b></td>
					<td></td>
					</tr>
					<tr>
					<td colspan="8" class="text-right"><b>Total Claim</b></td>
					<td class="text-right"><b><?= number_format($claim, 2) ?></b></td>
					<td></td>
					</tr>
					<tr>
					<td colspan="8" class="text-right"><b>Total Diterima</b></td>
					<td class="text-right"><b><?= number_format($nominals, 2) ?></b></td>
					<td></td>
				</tr>
			</tbody>
		</table>
		<br>
		<table>
			<tr>
				<td colspan="8"></td>
				<td align="right" valign="top">
					<b>Jakarta, <?php echo date('d F Y',strtotime($prods['tanggal']))?></b>
					<table border="1" style="border-collapse: collapse;width: 100%;" cellpadding="5">

                                        <tr>
                                            <th>Menyetujui</th>
                                            <th>Di Buat oleh:</th>

                                        </tr>

                                        <tr align="center">
                                            <td><b>SPV</b></td>
                                            <td><b>ADM Keuangan</b></td>

                                        </tr>

                                        <tr>
                                            <td height="100" align="center">

                                                <br>

                                                <br>

                                                <br>

                                                <br>

                                                <br>

                                                ( _________________ )

                                            </td>
                                             <td height="100" align="center">

                                                <br>

                                                <br>

                                                <br>

                                                <br>

                                                <br>

                                                ( Mia )

                                            </td>
                                        </tr>

                                    </table>
				</td>
			</tr>
			<tr>
			          <td colspan="9" align="right"><i class="registered">Registered by Forboys Production System <?php echo date('d-m-Y Y H:i:s'); ?></i></td>
			        </tr>
		</table>
									