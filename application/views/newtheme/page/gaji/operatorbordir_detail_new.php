<div class="row">
	<div class="col-md-12 text-center">
		<h3>Laporan Gaji Operator Bordir <?php echo $gaji['tempat']==1?'Rumah':'Cipadu'?></h3>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<label>Periode</label>
			<h4><?php echo date('d F Y',strtotime($gaji['tanggal1'])).' s.d '.date('d F Y',strtotime($gaji['tanggal2'])) ?></h4>
		</div>
	</div>
</div>
<div class="row">
	<?php $allgaji=0; ?>
	<?php foreach($karyawans as $k){?>
	<div class="col-md-6">
		<div class="table-responsive">
			<table class="table table-bordered">
				<thead>
					<tr style="background-color:yellow">
						<th>Nama</th>
						<th colspan="4"><?php echo $k['nama']?></th>
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
					<?php $totalgaji=0;$totalbonus=0;$totalum=0;$absensi=0;$pinjaman=0;$potongan=0;$claim=0;?>
					<?php foreach($k['details'] as $kd){?>
					<?php
						$sql="SELECT SUM(nominal) as total FROM potongan_operator WHERE hapus=0 AND idkaryawan='".$k['idkaryawan']."' and DATE(tanggal) BETWEEN '".$k['tgl1']."' AND '".$k['tgl2']."' ";
						$potongan=$this->GlobalModel->QueryManualRow($sql);

						$sabsensi=$this->GlobalModel->QueryManualRow("SELECT SUM(nominal) as total FROM potongan_operator WHERE hapus=0 AND idkaryawan='".$k['idkaryawan']."' and DATE(tanggal) BETWEEN '".$k['tgl1']."' AND '".$k['tgl2']."' AND jenis_potongan=1 ");

						if(!empty($sabsensi)){
							$absensi=$sabsensi['total'];
						}
						$sclaim=$this->GlobalModel->QueryManualRow("SELECT SUM(nominal) as total FROM potongan_operator WHERE hapus=0 AND idkaryawan='".$k['idkaryawan']."' and DATE(tanggal) BETWEEN '".$k['tgl1']."' AND '".$k['tgl2']."' AND jenis_potongan=3 ");
						if(!empty($sclaim)){
							$claim=$sclaim['total'];
						}
						$spinjaman=$this->GlobalModel->QueryManualRow("SELECT SUM(nominal) as total FROM potongan_operator WHERE hapus=0 AND idkaryawan='".$k['idkaryawan']."' and DATE(tanggal) BETWEEN '".$k['tgl1']."' AND '".$k['tgl2']."' AND jenis_potongan=2 ");
						if(!empty($spinjaman)){
							$pinjaman=$spinjaman['total'];
						}

					?>
					<tr>
						<td><?php echo $kd['hari']?></td>
						<td align="right"><?php echo $kd['gaji']?></td>
						<td align="right"><?php echo $kd['bonus']?></td>
						<td align="right"><?php echo $kd['um']?></td>
						<td align="right"><?php echo $kd['keterangan']?></td>
					</tr>
					<?php 
						$totalgaji+=($kd['gaji']);
						$totalbonus+=($kd['bonus']);
						$totalum+=($kd['um']);
					?>
					<?php }?>
					
					<tr>
						<td><b>Pot.Absensi</b></td>
						<td align="right"><b><?php echo $absensi?></b></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>

					<tr>
						<td><b>Pot.Claim</b></td>
						<td align="right"><b><?php echo $claim?></b></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>

					<tr>
						<td><b>Pot.Pinjaman</b></td>
						<td align="right"><b><?php echo $pinjaman?></b></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>

					
					<tr>
						<td><b>Total</b></td>
						<td align="right"><b><?php echo $totalgaji-$potongan['total']?></b></td>
						<td align="right"><b><?php echo $totalbonus?></b></td>
						<td align="right"><b><?php echo $totalum?></b></td>
						<td></td>
					</tr>
					
					<tr style="background-color:yellow">
						<td><b>Total Gaji</b></td>
						<td colspan="4"><label><?php echo pembulatangaji(($totalgaji+$totalbonus+$totalum-$potongan['total'])) ?></label></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<?php $allgaji+=pembulatangaji($totalgaji+$totalbonus+$totalum-$potongan['total']) ?>
	<?php } ?>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<table class="table table-bordered">
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
					<td>Mandor Siang</td>
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
				<tr>
					<td>Jumlah</td>
					<td><?php echo ($umsiang+$ummalam)?></td>
					<td><?php echo ($bonusmalam+$bonussiang)?></td>
					<td></td>
				</tr>
				<tr>
					<td>Pembayaran 30%</td>
					<td align="center" colspan="2"><?php echo ($bonussiang+$bonusmalam)*0.3?></td>
					<td></td>
				</tr>
				<tr>
					<td>Total Diterima (Rp)</td>
					<td align="center" colspan="2"><?php echo ($bonussiang+$bonusmalam)*0.3 + ($umsiang+$ummalam)?></td>
					<td>UM+30% (Bonus)</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<table class="table table-bordered">
				<tr>
					<td>Jumlah Gaji Operator Bordir <?php echo $gaji['tempat']==1?'Rumah':'Cipadu'?></td>
					<td><?php echo pembulatangaji($allgaji)?></td>
				</tr>
				<tr>
					<td>Bonus target mandor + u.m (Rp)</td>
					<td><?php echo ($bonussiang+$bonusmalam)*0.3 + ($umsiang+$ummalam)?></td>
				</tr>
				<tr>
					<td>Total Gaji Bordir <?php echo $gaji['tempat']==1?'Rumah':'Cipadu';?></td>
					<td><?php echo pembulatangaji($allgaji+ ($bonussiang+$bonusmalam)*0.3 + ($umsiang+$ummalam))?></td>
				</tr>
			</table>
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
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<div class="form-group">
			<a href="<?php echo $excel?>" class="btn btn-success btn-sm" style="width: 100%">Excel</a>
		</div>
	</div>
</div>