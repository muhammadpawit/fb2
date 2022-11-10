<?php
$namafile='Bahan_Datang_'.time();
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=".$namafile.".xls");
?>

<div class="row">
	<div class="col-md-12">
		<h1 class="text-center">Rincian Pengambilan Bahan Keluar  <?php echo bulan()[date('n',strtotime($tanggal1))] .' '.date('Y',strtotime($tanggal1))?></h1>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<table border="1" style="width: 100%;border-collapse: collapse;">
				<thead>
					<tr>
						<th>No</th>
						<th>Tanggal</th>
						<th>Nama</th>
						<th>Jumlah (Roll)</th>
						<th colspan="2">Satuan</th>
						<!-- <th>Harga (Rp)</th>
						<th>Total (Rp)</th> -->
					</tr>
				</thead>
				<tbody>
					<?php foreach($prods as $p){?>
						<tr>
							<td><?php echo $p['no']?></td>
							<td><?php echo $p['tanggal']?></td>
							<td><?php echo $p['nama']?></td>
							<td><?php echo $p['roll']?></td>
							<td><?php echo $p['yardkg']?></td>
							<td><?php echo $p['satuan']?></td>
							<!-- <td><?php echo ($p['harga'])?></td>
							<td><?php echo ($p['total'])?></td> -->
						</tr>
					<?php } ?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="3" align="center"><b><center>Total</center></b></td>
						<td><b><?php echo ($roll)?></b></td>
						<td><b><?php echo ($yardkg)?></b></td>
						<!-- <td></td>
						<td><b><?php echo ($total)?></b></td> -->
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>

<br>
<table>
	<tr>
		<td colspan="3"></td>
		<td>
			<table border="1" style="width: 100%;border-collapse: collapse;">

                                        <tr>

                                            <th align="center">Menyetujui</th>

                                            <th  align="center" colspan="2">Di Buat oleh</th>

                                        </tr>

                                        <tr>

                                            <td align="center"><b>SPV</b></td>

                                            <td align="center" colspan="2"><b>ADM Bahan</b></td>

                                        </tr>

                                        <tr>

                                            <td height="100" align="center">

                                                <br>

                                                <br>

                                                <br>

                                                <br>

                                                <br>

                                                ( Muchlas)

                                            </td>

                                            <td height="100" align="center" colspan="2">

                                                <br>

                                                <br>

                                                <br>

                                                <br>

                                                <br>

                                                ( Dwi M )

                                            </td>

                                        </tr>

                                    </table>
		</td>
	</tr>
</table>
<table>
										<tr>
                                            <td colspan="6"></td>
                                        </tr>
                                        <tr>
                                          <td colspan="6" align="right"><i class="registered">Registered by Forboys Production System <?php echo date('d-m-Y H:i:s'); ?></i></td>
                                        </tr>
</table>