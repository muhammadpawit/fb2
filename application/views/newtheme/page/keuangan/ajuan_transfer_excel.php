<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Ajuan_transfer_".time().".xls");
?>		
		<table>
			<tr>
				<td colspan="11" align="center"><h1>Ajuan Transfer</h1></td>
			</tr>
		</table>
		<br>
		<table border="1" style="width: 100%;border-collapse: collapse;">
			<thead>
				<tr>
					<th>No</th>
					<th>Tanggal</th>
					<th>Pembayaran</th>
					<th>Metode</th>
					<th>Atas Nama</th>
					<th>No.Rekening</th>
					<th>Tgl Nota/Barang</th>
					<th>Jumlah (Rp)</th>
					<th>Tgl Bayar</th>
					<th>Status</th>
					<th>Keterangan</th>
				</tr>
			</thead>
			<tbody>
				<?php $total=0;?>
				<?php foreach($products as $p){?>
					<tr>
						<td><?php echo $p['no']?></td>
						<td><?php echo $p['tanggal']?></td>
						<td><?php echo $p['pembayaran']?></td>
						<td><?php echo $p['metode']?></td>
						<td><?php echo $p['a_nama']?></td>
						<td><?php echo $p['no_rek']?></td>
						<td><?php echo $p['tgl_nota']?></td>
						<td><?php echo $p['nominal']?></td>
						<td><?php echo $p['tglbayar']?></td>
						<td><?php echo $p['status_pemb']?></td>
						<td><?php echo $p['keterangan']?></td>
					</tr>
					<?php $total+=($p['nominal']);?>
				<?php } ?>
					<tr>
						<td colspan="7" align="center"><b>Total</b></td>
						<td><b><?php echo $total?></b></td>
					</tr>
			</tbody>
		</table>
		<br>
		<table>
			<tr>
				<td colspan="9"></td>
				<td>
					<table border="1" style="width: 100%;border-collapse: collapse;">

                                        <tr>
                                            <th>Menyetujui</th>
                                            <th>Dibuat oleh:</th>

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

                                                ( Dinda )

                                            </td>

                                        </tr>

                                    </table>
				</td>
			</tr>
			<tr>
          	<td colspan="10"></td>
	        </tr>
	        <tr>
	          <td colspan="10" align="right"><b>Registered by Forboys Production System</b></td>
	        </tr>
		</table>
		