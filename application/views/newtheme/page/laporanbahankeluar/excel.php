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
<div class="col-md-5">
		<div class="form-group">
			<h3 class="text-center">Rekap Perbulan Bahan Keluar Kemeja</h3>
			<table border="1" style="width: 100%;border-collapse: collapse;">
				<thead>
					<tr align="center">
					    <!-- <td rowspan="2">No</td> -->
					    <td rowspan="2">Bulan</td>
					    <td colspan="2">Satuan</td>
					</tr>
					<tr align="center">
					    <td>Roll</td>
					    <td>Yard</td>
					</tr>
				</thead>
				<tbody>
					<?php $kmj=0;$kmj2=0; ?>
					<?php foreach($rkemeja as $k){?>
						<tr align="center">
							<td>
								<?php echo $k['bulan'] ?>
							</td>
							<td>
								<?php echo $k['roll']?>
							</td>
							<td>
								<?php echo $k['yard']?>
							</td>
						</tr>
						<?php $kmj+=($k['roll']);?>
						<?php $kmj2+=($k['yard']);?>
					<?php } ?>
				</tbody>
				<tfoot>
					<tr align="center">
						<td><b>Total</b></td>
						<td><b><?php echo $kmj ?></b></td>
						<td><b><?php echo $kmj2?></b></td>
					</tr>
				</tfoot>
			</table>
		</div>
		<div class="form-group">
			<h3 class="text-center">Rekap Perbulan Bahan Keluar Spandek</h3>
			<table border="1" style="width: 100%;border-collapse: collapse;">
				<thead>
					<tr align="center">
					    <!-- <td rowspan="2">No</td> -->
					    <td rowspan="2">Bulan</td>
					    <td colspan="2">Satuan</td>
					</tr>
					<tr align="center">
					    <td>Roll</td>
					    <td>Kg</td>
					</tr>
				</thead>
				<tbody>
					<?php $kos=0;$kos2=0; ?>
					<?php foreach($rkaos as $k){?>
						<tr align="center">
							<td>
								<?php echo $k['bulan'] ?>
							</td>
							<td>
								<?php echo $k['roll']?>
							</td>
							<td>
								<?php echo $k['kg']?>
							</td>
						</tr>
						<?php $kos+=($k['roll']);?>
						<?php $kos2+=($k['kg']);?>
					<?php } ?>
				</tbody>
				<tfoot>
					<tr align="center">
						<td><b>Total</b></td>
						<td><b><?php echo $kos ?></b></td>
						<td><b><?php echo $kos2?></b></td>
					</tr>
				</tfoot>
			</table>
		</div>
		<div class="form-group">
			<h3 class="text-center">Rekap Perbulan Bahan Keluar Celana</h3>
			<table border="1" style="width: 100%;border-collapse: collapse;">
				<thead>
					<tr align="center">
					    <!-- <td rowspan="2">No</td> -->
					    <td rowspan="2">Bulan</td>
					    <td colspan="2">Satuan</td>
					</tr>
					<tr align="center">
					    <td>Roll</td>
					    <td>Yard</td>
					</tr>
				</thead>
				<tbody>
					<?php $cln=0; $cln2=0;?>
					<?php foreach($rcelana as $k){?>
						<tr align="center">
							<td>
								<?php echo $k['bulan'] ?>
							</td>
							<td>
								<?php echo $k['roll']?>
							</td>
							<td>
								<?php echo $k['yard']?>
							</td>
						</tr>
						<?php $cln+=($k['roll']);?>
						<?php $cln2+=($k['yard']);?>
					<?php } ?>
				</tbody>
				<tfoot>
					<tr align="center">
						<td><b>Total</b></td>
						<td><b><?php echo $cln ?></b></td>
						<td><b><?php echo $cln2?></b></td>
					</tr>
				</tfoot>
			</table>
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

                                                ( IFAH )

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