<?php
$namafile='Laporan_Expedisi_'.time();
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=".$namafile.".xls");
?>
<style type="text/css">
	@import url('https://fonts.googleapis.com/css2?family=Baskervville:ital@1&display=swap');
  .registered {
    font-family: 'Baskervville', serif;
  }
</style>
<h1>LAPORAN EXPEDISI TRANSPORT KIRIM PO & SETOR PO</h1>

			<table border="1" style="width: 100%;border-collapse: collapse;">
				<thead>
					<tr>
						<th>Tanggal</th>
						<th>Nama CMT</th>
						<th>Lokasi/Cabang</th>
						<th>Biaya Cas Transport</th>
						<th>Rincian</th>
						<th>Keterangan</th>
					</tr>
				</thead>
				<tbody>
					<?php $totalpd=0;?>
					<?php foreach($prods as $p){?>
							<tr>
								<td><?php echo $p['tanggal']?></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
						<?php foreach($p['pendapatan'] as $pd){?>
							<tr>
								<td></td>
								<td><?php echo $pd['namacmt']?></td>
								<td></td>
								<td><?php echo ($pd['nominal'])?></td>
								<td></td>
								<td><?php echo $pd['keterangan']?></td>
							</tr>
							<?php 
								$totalpd+=($pd['nominal']);
							?>
						<?php } ?>
					<?php } ?>
					<tr align="center" style="background-color:#ffa621;font-size:16px">
						<td colspan="3"><b>Total Pendapatan</b></td>
						<td><b><?php echo ($totalpd) ?></b></td>
						<td></td>
						<td></td>
					</tr>
				</tbody>
				<tbody>
					<?php $totalpt=0;?>
					<?php foreach($prods as $p){?>
							<tr>
								<td><?php echo $p['tanggal']?></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
						<?php foreach($p['pengeluaran'] as $pd){?>
							<tr>
								<td></td>
								<td><?php echo $pd['namacmt']?></td>
								<td></td>
								<td><?php echo ($pd['nominal'])?></td>
								<td></td>
								<td><?php echo $pd['keterangan']?></td>
							</tr>
							<?php 
								$totalpt+=($pd['nominal']);
							?>
						<?php } ?>
					<?php } ?>
					<tr align="center" style="background-color:#ffa621;font-size:16px">
						<td colspan="3"><b>Total Pengeluaran</b></td>
						<td><b><?php echo ($totalpt) ?></b></td>
						<td></td>
						<td></td>
					</tr>
				</tbody>
				<tfoot>
					<tr align="center" style="background-color:yellow;font-size:16px">
			          <td colspan="3"><b>Saldo</b></td>
			          <td><b><?php echo ($totalpt+$totalpd) ?></b></td>
			          <td></td>
			          <td></td>
			        </tr>
			        <tr>
			        	<td colspan="3"></td>
			        	<td colspan="3">
			        		<table>

                                        <tr>
                                            <th>Menyetujui</th>
                                            <th>Di Periksa oleh:</th>
                                            <th>Di Buat oleh:</th>

                                        </tr>

                                        <tr align="center">
                                            <td><b>SPV</b></td>
                                            <td><b>ADM Keuangan</b></td>
                                            <td><b></b></td>

                                        </tr>

                                        <tr>
                                            <td height="100" align="center">

                                                <br>

                                                <br>

                                                <br>

                                                <br>

                                                <br>

                                                ( Muchlas )

                                            </td>
                                             <td height="100" align="center">

                                                <br>

                                                <br>

                                                <br>

                                                <br>

                                                <br>

                                                ( Dinda )

                                            </td>
                                            <td height="100" align="center">
                                                <br>

                                                <br>

                                                <br>

                                                <br>

                                                <br>

                                                

                                            </td>

                                        </tr>
                                    </table>
			        	</td>
			        </tr>
					<tr>
			          <td colspan="6" align="right"><i class="registered">Registered by Forboys Production System <?php echo date('d-m-Y H:i:s'); ?></i></td>
			        </tr>
				</tfoot>
			</table>