<?php
$nam=$gaji['tempat']==1?'Rumah':'Cipadu'.time();
$namafile='Laporan Gaji Operator Bordir_'.$nam;
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=".$namafile.".xls");
?>


<table border="1" style="width: 100%;border-collapse: collapse;">
	<tr>
		<td colspan="10"><h3>Rekap Gaji Operator Bordir <?php echo $gaji['tempat']==1?'Rumah':'Cipadu'?></h3></td>
	</tr>
</table>

<h4><label>Periode</label>&nbsp;<?php echo date('d',strtotime($gaji['tanggal1'])).' s.d '.date('d F Y',strtotime($gaji['tanggal2'])) ?></h4>
<table>
	<tr>
		<td colspan="10"></td>
		<td>
			<table class="table table-bordered">
							<tr>
								<td colspan="2">Catatan:</td>
							</tr>
							<tr>
								<td>Mandor Pagi</td>
								<td><?php echo json_encode($this->ReportModel->getMandor($gaji['id'],1))?></td>
							</tr>
							<tr>
								<td>Mandor Malam</td>
								<td><?php echo ($this->ReportModel->getMandor($gaji['id'],2))?></td>
							</tr>
						</table>
		</td>
	</tr>
</table>
<div class="row">
	<?php $totalgaji=0;$totalbonus=0;$totalum=0;$absensi=0;$pinjaman=0;?>
	<?php $allgaji=0;$j=1;$jk=1; ?>
	<table>
		<tr>
			<?php $h=0;?>
			<?php foreach($karyawans as $k){?>
			<?php if($j%2==0){?>
			<td>
			<table border="1" style="width: 100%;border-collapse: collapse;">
				<thead>
					<tr style="background-color:yellow">
						<th>Nama Operator</th>
						<th colspan="4"><?php echo ucfirst($k['nama'])?></th>
					</tr>
					<tr>
						<th>Hari</th>
						<th>Gaji</th>
						<th>Bonus</th>
						<th>Um</th>
						<th>Keterangan</th>
					</tr>
				</thead>
				<tbody>
					<?php $totalgajia=0;$totalbonusa=0;$totaluma=0;$absensia=0;$pinjamana=0;?>
					<?php foreach($k['details'] as $kd){?>
					<tr>
						<td><?php echo $kd['hari']?></td>
						<td align="right"><?php echo $kd['gaji']?></td>
						<td align="right"><?php echo $kd['bonus']?></td>
						<td align="right"><?php echo $kd['um']?></td>
						<td align="right"><?php echo $kd['keterangan']?></td>
					</tr>
					<?php 
						$totalgajia+=($kd['gaji']);
						$totalbonusa+=($kd['bonus']);
						$totaluma+=($kd['um']);
						$absensia+=($kd['pot_absensi']);
						$pinjamana+=($kd['pot_pinjaman']);
					?>
					<?php }?>
					
					<tr>
						<td><b>Pot.Absensi</b></td>
						<td align="right"><b><?php echo $absensia?></b></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>

					<tr>
						<td><b>Pot.Pinjaman</b></td>
						<td align="right"><b><?php echo $pinjamana?></b></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>


					<tr>
						<td><b>Total</b></td>
						<td align="right"><b><?php echo $totalgajia-$absensia-$pinjamana?></b></td>
						<td align="right"><b><?php echo $totalbonusa?></b></td>
						<td align="right"><b><?php echo $totaluma?></b></td>
					</tr>
					
					<tr style="background-color:yellow">
						<td><b>Gaji Diterima</b></td>
						<td colspan="4" align="center"><label><?php echo ($totalgajia+$totalbonusa+$totaluma-$absensia-$pinjamana) ?></label></td>
					</tr>
				</tbody>
			</table>
			</td>
			<?php $h++;?>
			<?php } ?>
			<?php $j++; ?>
	<?php //$allgaji+=($totalgaji+$totalbonus+$totalum) ?>
	<?php } ?>
		</tr>
	</table><br>
	<table>
		<tr>
			<?php $hr=0;?>
			<?php foreach($karyawans as $k){?>
			<?php if($jk%2==1){?>
			<td>
			<table border="1" style="width: 100%;border-collapse: collapse;">
				<thead>
					<tr style="background-color:yellow">
						<th>Nama Operator</th>
						<?php //if($hr==0){?>
						<th colspan="4"><?php echo ucfirst($k['nama'])?></th>
						<?php //}else{ ?>
							<!-- <th colspan="3"><?php echo ucfirst($k['nama'])?></th> -->
						<?php //} ?>
					</tr>
					<tr>
						<?php //if($hr==0){?>
						<th>Hari</th>
						<?php //} ?>
						<th>Gaji</th>
						<th>Bonus</th>
						<th>Um</th>
						<th>Keterangan</th>
					</tr>
				</thead>
				<tbody>
					<?php $totalgajib=0;$totalbonusb=0;$totalumb=0;$absensib=0;$pinjamanb=0;?>
					<?php foreach($k['details'] as $kd){?>
					<tr>
						<?php //if($hr==0){?>
						<td><?php echo $kd['hari'];?></td>
						<?php //} ?>
						<td align="right"><?php echo $kd['gaji']?></td>
						<td align="right"><?php echo $kd['bonus']?></td>
						<td align="right"><?php echo $kd['um']?></td>
						<td align="right"><?php echo $kd['keterangan']?></td>
					</tr>
					<?php 
						$totalgajib+=($kd['gaji']);
						$totalbonusb+=($kd['bonus']);
						$totalumb+=($kd['um']);
						$absensib+=($kd['pot_absensi']);
						$pinjamanb+=($kd['pot_pinjaman']);
					?>
					<?php }?>
					<tr>
						<td><b>Pot.Absensi</b></td>
						<td align="right"><b><?php echo $absensib?></b></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>

					<tr>
						<td><b>Pot.Pinjaman</b></td>
						<td align="right"><b><?php echo $pinjamanb?></b></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td><b>Total</b></td>
						<td align="right"><b><?php echo $totalgajib-$absensib-$pinjamanb?></b></td>
						<td align="right"><b><?php echo $totalbonusb?></b></td>
						<td align="right"><b><?php echo $totalumb?></b></td>
					</tr>
					
					<tr style="background-color:yellow">
						<td><b>Gaji Diterima</b></td>
						<?php //if($hr==0){?>
						<td colspan="4" align="center"><label><?php echo ($totalgajib+$totalbonusb+$totalumb-$absensib-$pinjamanb) ?></label></td>
						<?php //}else{ ?>
							<!-- <td colspan="3" align="center"><label><?php echo ($totalgajia+$totalbonusa+$totaluma) ?></label></td> -->
						<?php //} ?>
					</tr>
				</tbody>
			</table>
			</td>
			<?php $hr++;?>
			<?php } ?>
			<?php $jk++; ?>
	<?php //$allgaji+=($totalgaji+$totalbonus+$totalum) ?>
	<?php } ?>
		</tr>
	</table>
</div>
<table>
	<tr>
		<td></td>
	</tr>
	<tr>
		<td></td>
	</tr>
</table>
<?php foreach($karyawans as $k){?>
	<?php 
		foreach($k['details'] as $kd){
			$totalgaji+=($kd['gaji']);
			$totalbonus+=($kd['bonus']);
			$totalum+=($kd['um']);
			$absensi+=($kd['pot_absensi']);
			$pinjaman+=($kd['pot_pinjaman']);
		}
	?>
<?php } ?>
<?php $allgaji+=($totalgaji+$totalbonus+$totalum-$absensi-$pinjaman) ?>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<table>
				<tr>
					<td colspan="5">
						<table border="1" style="width: 100%;border-collapse: collapse;">
							<tr>
								<th colspan="3">Bonus Target Mandor <?php echo $gaji['tempat']==1?'Rumah':'Cipadu'?> (Rp)</th>
							</tr>
							<tr>
								<td>Nama</td>
								<td>Um</td>
								<td>Bonus</td>
							</tr>
							<tr>
								<td>Mandor Siang</td>
								<td><?php echo $umsiang?></td>
								<td><?php echo $bonussiang?></td>
							</tr>
							<tr>
								<td>Mandor Malam</td>
								<td><?php echo $ummalam?></td>
								<td><?php echo $bonusmalam?></td>
							</tr>
							<tr>
								<td>30%</td>
								<td></td>
								<td><?php echo (($bonussiang+$bonusmalam)*0.3)?></td>
							</tr>
							<tr>
								<td>Total</td>
								<td align="center" colspan="2"><?php echo (($bonussiang+$bonusmalam)*0.3)+$umsiang+$ummalam?></td>
							</tr>
						</table>
					</td>
					<td colspan="5">
						<table border="1" style="width: 100%;border-collapse: collapse;">
							<tr>
								<td>Jumlah Gaji Operator Bordir</td>
								<td><?php echo $allgaji?></td>
							</tr>
							<tr>
								<td>Bonus target mandor + u.m (Rp)</td>
								<td><?php echo (($bonussiang+$bonusmalam)*0.3)+$umsiang+$ummalam?></td>
							</tr>
							<tr>
								<td>Total Gaji Operator Bordir <?php echo $gaji['tempat']==1?'Rumah':'Cipadu';?></td>
								<td><?php echo $allgaji+((($bonussiang+$bonusmalam)*0.3)+$umsiang+$ummalam)?></td>
							</tr>
						</table><br>
						
					</td>
				</tr>
			</table>
			<br><br>
			<table>
				<tr>
					<td colspan="4">
						<b>Catatan :</b><br>
						<b>
							Ketentuan Bonus Target Mandor <br>
							1.Pembayaran 30% dibayar kalau ada UM+Bonus<br>
							2.Kalau tidak ada bonus, hanya dihitung um saja
						</b>
					</td>
					<td colspan="3"></td>
					<td>
						<b>Jakarta, <?php echo date('d F Y',strtotime($gaji['tanggal2']))?></b>
					<table border="1" style="border-collapse: collapse;width: 100%;" cellpadding="5">

                                        <tr>
                                            <th>Disetujui</th>
                                            <th>Mengetahui</th>
                                            <th>Disusun</th>
                                        </tr>

                                        <tr align="center">
                                            <td><b>SPV</b></td>
                                            <td><b>Mandor</b></td>
                                            <td><b>Adm Prod Bordir</b></td>

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
                                            <td height="100" align="center">

                                                <br>

                                                <br>

                                                <br>

                                                <br>

                                                <br>  

                                                (&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)                                          

                                            </td>
                                            <td height="100" align="center">

                                                <br>

                                                <br>

                                                <br>

                                                <br>

                                                <br>                                            
                                                ( Tiara )
                                            </td>
                                        </tr>

                                    </table>
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>