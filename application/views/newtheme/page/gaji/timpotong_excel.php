<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Laporan_Pembayaran_Tim_Potong_".date('d F Y',strtotime($prods['tanggal'])).time().".xls");
?>
<style type="text/css">
	@import url('https://fonts.googleapis.com/css2?family=Baskervville:ital@1&display=swap');
  .registered {
    font-family: 'Baskervville', serif;
  }
</style>		
		<table border="1" style="border-collapse: collapse;width: 100%;" cellpadding="12">
			<thead>
				<tr>
					<th colspan="8" align="center"><h4>Laporan Pembayaran Hasil Kerja Tim Potong <?php echo $timnya['nama']?></h4></th>
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
				<?php $no=1;?>
				<?php foreach($products as $p){?>
					<?php if($p['total'] > 0){ ?>
					<tr>
						<td><?php echo $no++?></td>
						<td><?php echo $p['tanggal']?></td>
						<td><?php echo $p['kode_po']?></td>
						<td><?php echo $p['jenis']?></td>
						<td><?php echo $p['size']?></td>
						<td><?php echo number_format($p['lusin'],2)?></td>
						<td><?php echo $p['pcs']?></td>
						<td><?php echo $p['harga']?></td>
						<td><?php echo $p['total']?></td>
						<td></td>
					</tr>
					<?php } ?>
				<?php } ?>
				<tr>
					<td colspan="6"><b></b></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td colspan="6"><b>Subtotal</b></td>
					<td><b><?php echo $totals?></b></td>
					<td></td>
				</tr>
				<tr>
					<td colspan="6"><b>Saving 5%</b></td>
					<td><b><?php echo $savings?></b></td>
					<td></td>
				</tr>
				<tr>
					<td colspan="6"><b>Total Claim</b></td>
					<td><b><?php echo ($claim)?></b></td>
					<td></td>
				</tr>
				<tr>
					<td colspan="6"><b>Total yang diterima</b></td>
					<td><b><?php echo $nominals?></b></td>
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

                                                ( Muchlas Muchtar)

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
									