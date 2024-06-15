 <?php
$nam=$gaji['tempat']==1?'Rumah':'Cipadu'.time();
$namafile='Laporan Gaji Operator Bordir_'.$nam;
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=".$namafile.".xls");
?>
<style type="text/css">
	@import url('https://fonts.googleapis.com/css2?family=Baskervville:ital@1&display=swap');
  .registered {
    font-family: 'Baskervville', serif;
  }

  .besar {font-size: 14px;}
</style>

<table border="1" style="width: 100%;border-collapse: collapse;">
	<tr>
		<td colspan="10"><h3>Laporan Gaji Operator Bordir <?php echo $gaji['tempat']==1?'Rumah':'Cipadu'?></h3></td>
	</tr>
</table>

<h4><label>Periode</label>&nbsp;<?php echo date('d',strtotime($gaji['tanggal1'])).' s.d '.date('d F Y',strtotime($gaji['tanggal2'])) ?></h4>
<table>
	<tr>
		<td colspan="10"></td>
		<td>
			<table class="table table-bordered">
							<tr>
								<!-- <td colspan="2">Catatan:</td> -->
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
			<?php 
				//if($j%2==0){
				if($k['shift']=='PAGI'){
			?>
			<td>
			<table border="1" style="width: 100%;border-collapse: collapse;">
				<thead>
					<tr style="background-color:yellow">
						<th>Nama Operator</th>
						<th colspan="2"><?php echo strtoupper($k['nama'])?></th>
					</tr>
					<!-- <tr style="background-color:yellow">
						<th>Shift</th>
						<th colspan="2"><?php echo $k['shift']?></th>
					</tr> -->
					<tr>
						<th>Hari</th>
						<th>Gaji</th>
						<!-- <th>Bonus</th>
						<th>Um</th> -->
						<th>Keterangan</th>
					</tr>
				</thead>
				<tbody>
					<?php $totalgajia=0;$totalbonusa=0;$totaluma=0;$absensia=0;$pinjamana=0;$potongan=0;$claima=0;?>
					<?php foreach($k['details'] as $kd){?>
					<?php
						$potongan=$this->GlobalModel->QueryManualRow("SELECT SUM(nominal) as total FROM potongan_operator WHERE hapus=0 AND idkaryawan='".$k['idkaryawan']."' and DATE(tanggal) BETWEEN '".$k['tgl1']."' AND '".$k['tgl2']."' ");

						$sabsensi=$this->GlobalModel->QueryManualRow("SELECT SUM(nominal) as total FROM potongan_operator WHERE hapus=0 AND idkaryawan='".$k['idkaryawan']."' and DATE(tanggal) BETWEEN '".$k['tgl1']."' AND '".$k['tgl2']."' AND jenis_potongan=1 ");

						if(!empty($sabsensi)){
							$absensia=$sabsensi['total'];
						}
						$sclaim=$this->GlobalModel->QueryManualRow("SELECT SUM(nominal) as total,keterangan FROM potongan_operator WHERE hapus=0 AND idkaryawan='".$k['idkaryawan']."' and DATE(tanggal) BETWEEN '".$k['tgl1']."' AND '".$k['tgl2']."' AND jenis_potongan=3 ");
						if(!empty($sclaim)){
							$claima=$sclaim['total'];
						}
						$spinjaman=$this->GlobalModel->QueryManualRow("SELECT SUM(nominal) as total FROM potongan_operator WHERE hapus=0 AND idkaryawan='".$k['idkaryawan']."' and DATE(tanggal) BETWEEN '".$k['tgl1']."' AND '".$k['tgl2']."' AND jenis_potongan=2 ");
						if(!empty($spinjaman)){
							$pinjamana=$spinjaman['total'];
						}


					?>						
					<tr>
						<td><?php echo $kd['hari']?></td>
						<td align="right"><?php echo $kd['gaji']?></td>
						<!-- <td align="right"><?php echo $kd['bonus']?></td>
						<td align="right"><?php echo $kd['um']?></td> -->
						<td align="right"><?php echo $kd['keterangan']?></td>
					</tr>
					<?php 
						$totalgajia+=($kd['gaji']);
						//$totalbonusa+=($kd['bonus']);
						//$totaluma+=($kd['um']);
					?>
					<?php }?>
					
					<tr>
						<td><b class="besar">Pot.Absensi</b></td>
						<td align="right"><b class="besar"><?php echo $absensia?></b></td>
						<!-- <td></td>
						<td></td> -->
						<td></td>
					</tr>

					<tr>
						<td><b class="besar">Pot.Claim</b></td>
						<td align="right"><b class="besar"><?php echo $claima?></b></td>
						<!-- <td></td>
						<td></td> -->
						<td align="right"><?php echo !empty($claima)?$sclaim['keterangan']:'';?></td>
					</tr>

					<tr>
						<td><b class="besar">Pot.Pinjaman</b></td>
						<td align="right"><b class="besar"><?php echo $pinjamana?></b></td>
						<!-- <td></td>
						<td></td> -->
						<td></td>
					</tr>


					<tr>
						<td><b class="besar">Total</b></td>
						<td align="right"><b class="besar"><?php echo $totalgajia-$potongan['total']?></b></td>
						<!-- <td align="right"><b class="besar"><?php echo $totalbonusa?></b></td>
						<td align="right"><b class="besar"><?php echo $totaluma?></b></td> -->
					</tr>
					
					<tr class="besar" style="background-color:yellow">
						<td><b class="besar">Gaji Diterima</b></td>
						<td colspan="2" align="center"><label><?php echo pembulatangaji(($totalgajia+$totalbonusa+$totaluma-$potongan['total'])) ?></label></td>
					</tr>
				</tbody>
			</table>
			</td>
			<?php $h++;?>
			<?php } ?>
			<?php $j++; ?>
	<?php } ?>
		</tr>
	</table><b class="besar"r>
		<br>
	<table>
		<tr>
			<?php $hr=0;?>
			<?php foreach($karyawans as $k){?>
			<?php 
				//if($jk%2==1){
				if($k['shift']=='MALAM'){
			?>
			<td>
			<table border="1" style="width: 100%;border-collapse: collapse;">
				<thead>
					<tr style="background-color:yellow">
						<th>Nama Operator</th>
						<th colspan="2"><?php echo strtoupper($k['nama'])?></th>
					</tr>
					<!-- <tr style="background-color:yellow">
						<th>Shift</th>
						<th colspan="2"><?php echo $k['shift']?></th> -->
					</tr>
					<tr>
						<th>Hari</th>
						<th>Gaji</th>
						<!-- <th>Bonus</th>
						<th>Um</th> -->
						<th>Keterangan</th>
					</tr>
				</thead>
				<tbody>
					<?php $totalgajib=0;$totalbonusb=0;$totalumb=0;$absensib=0;$pinjamanb=0;$claimb=0;$potongan=0;?>
					<?php foreach($k['details'] as $kd){?>
					<?php
						$potongan=$this->GlobalModel->QueryManualRow("SELECT SUM(nominal) as total FROM potongan_operator WHERE hapus=0 AND idkaryawan='".$k['idkaryawan']."' and DATE(tanggal) BETWEEN '".$k['tgl1']."' AND '".$k['tgl2']."' ");

						$sabsensi=$this->GlobalModel->QueryManualRow("SELECT SUM(nominal) as total FROM potongan_operator WHERE hapus=0 AND idkaryawan='".$k['idkaryawan']."' and DATE(tanggal) BETWEEN '".$k['tgl1']."' AND '".$k['tgl2']."' AND jenis_potongan=1 ");

						if(!empty($sabsensi)){
							$absensib=$sabsensi['total'];
						}

						$sclaim=$this->GlobalModel->QueryManualRow("SELECT SUM(nominal) as total,keterangan FROM potongan_operator WHERE hapus=0 AND idkaryawan='".$k['idkaryawan']."' and DATE(tanggal) BETWEEN '".$k['tgl1']."' AND '".$k['tgl2']."' AND jenis_potongan=3 ");
						if(!empty($sclaim)){
							$claimb=$sclaim['total'];
						}
						$spinjaman=$this->GlobalModel->QueryManualRow("SELECT SUM(nominal) as total FROM potongan_operator WHERE hapus=0 AND idkaryawan='".$k['idkaryawan']."' and DATE(tanggal) BETWEEN '".$k['tgl1']."' AND '".$k['tgl2']."' AND jenis_potongan=2 ");
						if(!empty($spinjaman)){
							$pinjamanb=$spinjaman['total'];
						}


					?>						
					<tr>
						<?php //if($hr==0){?>
						<td><?php echo $kd['hari'];?></td>
						<?php //} ?>
						<td align="right"><?php echo $kd['gaji']?></td>
						<!-- <td align="right"><?php echo $kd['bonus']?></td>
						<td align="right"><?php echo $kd['um']?></td> -->
						<td align="right"><?php echo $kd['keterangan']?></td>
					</tr>
					<?php 
						$totalgajib+=($kd['gaji']);
						//$totalbonusb+=($kd['bonus']);
						//$totalumb+=($kd['um']);
					?>
					<?php }?>
					

					<tr>
						<td><b class="besar">Pot.Absensi</b></td>
						<td align="right"><b class="besar"><?php echo $absensib?></b></td>
						<!-- <td></td>
						<td></td> -->
						<td></td>
					</tr>

					<tr>
						<td><b class="besar">Pot.Claim</b></td>
						<td align="right"><b class="besar"><?php echo $claimb?></b></td>
						<!-- <td></td>
						<td></td> -->
						<td align="right"><?php echo !empty($claimb)?$sclaim['keterangan']:'';?></td>
					</tr>

					<tr>
						<td><b class="besar">Pot.Pinjaman</b></td>
						<td align="right"><b class="besar"><?php echo $pinjamanb?></b></td>
						<!-- <td></td>
						<td></td> -->
						<td></td>
					</tr>


					<tr>
						<td class="besar"><b class="besar">Total</b></td>
						<td align="right"><b class="besar"><?php echo $totalgajib-$potongan['total']?></b></td>
						<!-- <td align="right"><b class="besar"><?php echo $totalbonusb?></b></td>
						<td align="right"><b class="besar"><?php echo $totalumb?></b></td> -->
					</tr>
					
					<tr  class="besar" style="background-color:yellow">
						<td><b class="besar">Gaji Diterima</b></td>
						<?php //if($hr==0){?>
						<td colspan="2" align="center"><label><?php echo pembulatangaji(($totalgajib+$totalbonusb+$totalumb-$potongan['total'])) ?></label></td>
					</tr>
				</tbody>
			</table>
			</td>
			<?php $hr++;?>
			<?php } ?>
			<?php $jk++; ?>
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
<?php $pots=0;?>
<?php $semua=0;$semuatotalbonus=0;$totalum=0;$absensi=0;$pinjaman=0;?>
<?php foreach($karyawans as $k){?>
	<?php 
		foreach($k['details'] as $kd){
			$semua+=($kd['gaji']);
			$totalbonus+=($kd['bonus']);
			$totalum+=($kd['um']);
			$pots=$this->GlobalModel->QueryManualRow("SELECT SUM(nominal) as total FROM potongan_operator WHERE hapus=0 and DATE(tanggal) BETWEEN '".$k['tgl1']."' AND '".$k['tgl2']."' AND tempat='".$gaji['tempat']."'");
		}
	?>
<?php } ?>
<?php $allgaji+=pembulatangaji($semua+$totalbonus+$totalum-$pots['total']) ?>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<table>
				<tr>
					<td colspan="5">
						<table border="1" style="border-collapse: collapse;width: 100%;" cellpadding="5">
							<tr>
								<th colspan="4">Bonus Target Mandor <?php echo $gaji['tempat']==1?'Rumah':'Cipadu'?> (Rp)</th>
							</tr>
							<tr>
								<td>Nama</td>
								<td>Um</td>
								<td>Bonus</td>
								<td>Keterangan</td>
							</tr>
							<tr>
								<td>Mandor Pagi</td>
								<td><?php echo $umsiang?></td>
								<td><?php echo $bonussiang?></td>
								<td></td>
							</tr>
							<tr>
								<td>Mandor Malam</td>
								<td><?php echo $ummalam?></td>
								<td><?php echo $bonusmalam?></td>
								<td></td>
							</tr>
							<tr style="background-color: yellow">
								<td>Jumlah</td>
								<td><?php echo ($umsiang+$ummalam)?></td>
								<td><?php echo ($bonusmalam+$bonussiang)?></td>
								<td></td>
							</tr>
							<tr style="background-color: pink">
								<td>Pembayaran 30%</td>
								<td align="center" colspan="2"><?php echo ($bonussiang+$bonusmalam)*0.3?></td>
								<td></td>
							</tr>
							<tr  class="besar" style="background-color: lightblue">
								<td>Total Diterima (Rp)</td>
								<td align="center" colspan="2"><?php echo ($bonussiang+$bonusmalam)*0.3 + ($umsiang+$ummalam)?></td>
								<td>UM+30% (Bonus)</td>
							</tr>
						</table>
					</td>
					<td colspan="5">
						<table border="1" style="border-collapse: collapse;width: 100%;" cellpadding="5">
							<tr style="background-color: yellow;">
								<td>Jumlah Gaji Operator Bordir <?php echo $gaji['tempat']==1?'Rumah':'Cipadu'?></td>
								<td><?php echo pembulatangaji($allgaji)?></td>
							</tr>
							<tr>
								<td>Bonus target mandor + u.m (Rp)</td>
								<td><?php echo ($bonussiang+$bonusmalam)*0.3 + ($umsiang+$ummalam)?></td>
							</tr>
							<tr  class="besar" style="background-color: yellow;">
								<td>
									<b class="besar">
										Total Gaji Bordir <?php echo $gaji['tempat']==1?'Rumah':'Cipadu';?>
									</b>
								</td>
								<td>
									<b class="besar">
										<?php echo pembulatangaji($allgaji+ ($bonussiang+$bonusmalam)*0.3 + ($umsiang+$ummalam))?>
									</b>
								</td>
							</tr>
						</table><b class="besar"r>
						
					</td>
				</tr>
			</table>
			<b class="besar"r><b class="besar"r>
			<table>
				<tr>
					<td colspan="4" align="left" valign="top">
						<b class="besar">Catatan :</b><br>
						<b class="besar">
							1.Operator sudah sistem borongan<br>
							2.Gaji dihitung dari Sabtu ke Jum'at<br>
							3.Rumus perhitungan gaji borongan operator bordir<br>
							<b>Rumus : Jumlah yang di bordir X Stich X Tarif X Jumlah persentase (%)</b>
						</b>
<!-- <table class="tg" border="4" style="border-collapse: collapse;">
<thead>
  <tr>
    <td class="tg-lboi" valign="bottom">
    	<table border="0" style="border-bottom: 1px solid black"><tr><td>Lama Kerja</td></tr></table>
    </td>
    <td class="tg-9wq8" rowspan="2" valign="middle"><span style="border-top: 1px solid black">X Upah / hari</span></td>
  </tr>
  <tr>
    <td class="tg-0pky">Jumlah jam kerja</td>
  </tr>
</thead>
</table> -->
						</b>
					</td>
					<td colspan="3"></td>
					<td>
						<b class="besar">Jakarta, <?php echo date('d F Y',strtotime($gaji['tanggal2']))?></b>
					<table border="1" style="border-collapse: collapse;width: 100%;" cellpadding="5">

                                        <tr>
                                            <th>Disetujui</th>
                                            <th>Mengetahui</th>
                                            <th>Disusun</th>
                                        </tr>

                                        <tr align="center">
                                            <td><b class="besar">SPV</b></td>
                                            <td><b class="besar">Mandor</b></td>
                                            <td><b class="besar">Adm Prod Bordir</b></td>

                                        </tr>

                                        <tr>
                                            <td height="100" align="center" rowspan="6">

                                                <b class="besar"r>

                                                <b class="besar"r>

                                                <b class="besar"r>

                                                <b class="besar"r>

                                                <b class="besar"r>

                                                (............)

                                            </td>
                                            <td height="100" align="center" rowspan="6">

                                                <b class="besar"r>

                                                <b class="besar"r>

                                                <b class="besar"r>

                                                <b class="besar"r>

                                                <b class="besar"r>  

                                                (&nbsp;&nbsp;&nbsp;Rasum&nbsp;&nbsp;&nbsp;)                                          

                                            </td>
                                            <td height="100" align="center" rowspan="6">

                                                <b class="besar"r>

                                                <b class="besar"r>

                                                <b class="besar"r>

                                                <b class="besar"r>

                                                <b class="besar"r>                                            
                                                ( Tria )
                                            </td>
                                        </tr>

                                    </table>
					</td>
				</tr>
				<tr>
		          <td colspan="8" align="right"><i class="registered">Registered by Forboys Production System <?php echo date('d-m-Y H:i:s'); ?></i></td>
		        </tr>
			</table>
		</div>
	</div>
</div>