<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Resume_Gaji_Finishing_Periode_".date('d F Y',strtotime($tanggal1)).' s.d '.date('d F Y',strtotime($tanggal2)).".xls");
?>
<div class="row">
	<div class="col-md-12 text-center">
		<h4>Rincian Gaji Karyawan Finishing Forboys</h4>
	</div>
</div>
<div class="row">
	<div class="form-group">
		<h3>Periode : <?php echo date('d-m-Y',strtotime($tanggal1)) ?> s.d <?php echo date('d-m-Y',strtotime($tanggal2)) ?></h3>
	</div>
</div>
<div class="row">
	<?php $total=0;?>
	<table>
		<tr>
	<?php foreach($fharian as $k){?>
		<td>
	<div class="col-md-4">
		<div class="table-responsive">
			<table border="1" style="border-collapse: collapse;width: 100%;" cellpadding="12">
				<thead>
					<tr>
						<th>Hari</th>
						<th>Nama : <?php echo $k['nama']?></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Senin</td>
						<td align="right"><?php echo $k['senin']?></td>
					</tr>
					<tr>
						<td>Selasa</td>
						<td align="right"><?php echo $k['selasa']?></td>
					</tr>
					<tr>
						<td>Rabu</td>
						<td align="right"><?php echo $k['rabu']?></td>
					</tr>
					<tr>
						<td>Kamis</td>
						<td align="right"><?php echo $k['kamis']?></td>
					</tr>
					<tr>
						<td>Jumat</td>
						<td align="right"><?php echo $k['jumat']?></td>
					</tr>
					<tr>
						<td>Sabtu</td>
						<td align="right"><?php echo $k['sabtu']?></td>
					</tr>
					<tr>
						<td>Minggu</td>
						<td align="right"><?php echo $k['minggu']?></td>
					</tr>
					<tr>
						<td>Lembur</td>
						<td align="right"><?php echo $k['lembur']?></td>
					</tr>
					<tr>
						<td>Insentif</td>
						<td align="right"><?php echo $k['insentif']?></td>
					</tr>
					<tr>
						<td><b>Total</b></td>
						<td align="right"><label><?php echo ($k['senin']+$k['selasa']+$k['rabu']+$k['kamis']+$k['jumat']+$k['sabtu']+$k['minggu']+$k['lembur']+$k['insentif']) ?></label></td>
					</tr>
					<tr>
						<td><b>Pembulatan</b></td>
						<td align="right"><label><?php echo (pembulatangaji($k['senin']+$k['selasa']+$k['rabu']+$k['kamis']+$k['jumat']+$k['sabtu']+$k['minggu']+$k['lembur']+$k['insentif'])) ?></label></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	</td>
	<?php
		$total+=($k['senin']+$k['selasa']+$k['rabu']+$k['kamis']+$k['jumat']+$k['sabtu']+$k['minggu']+$k['lembur']+$k['insentif']);

	?>
	<?php } ?>
</tr>
</table>
</div>
<br>
<div class="row">
	<div class="col-md-6">
		<table border="1" style="border-collapse: collapse;width: 100%;background-color: orange" cellpadding="12">
			<tr>
				<td><b>Jumlah Table 1</b></td>
				<td></td>
				<td><b><?php echo ($total)?></b></td>
			</tr>
		</table>
	</div>
</div>
<br>
<div class="row">
	<div class="col-md-12">
		<div class="table-responsive">
			<table border="1" style="border-collapse: collapse;width: 100%;" cellpadding="12">
				<thead>
					<?php 
						$col=3;
						if($bm==1){
							$col=4;
						}
					?>
					<tr>
						<th colspan="<?php echo $col?>" style="background-color: orange">Borongan Mesin (Lobang kancing, Pasang kancing, Tress )</th>
						<th colspan="<?php echo count($cucian)?>" style="background-color: #94dfff">Laundry</th>
						<th style="background-color: #d1d1d1">Buang Benang</th>
						<th colspan="2" style="background-color: #7bb2e3">Packing, Gosok</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Nama</td>
						<?php foreach($boronganmesin as $p){?>
						<td><?php echo $p['nama']?></td>
						<?php } ?>
						<?php if($bm==1){?>
							<!-- <td></td>
							<td></td> -->
						<?php } ?>
						<?php if(!empty($cucian)){?>
							<?php foreach($cucian as $p){?>
							<td><?php echo $p['nama']?></td>
							<?php } ?>
						<?php }else{ ?>
							<td></td>
						<?php } ?>
						<?php foreach($bb as $p){?>
						<td><?php echo $p['nama']?></td>
						<?php } ?>
						<?php foreach($pk as $p){?>
						<td><?php echo $p['nama']?></td>
						<?php } ?>
					</tr>
					<tr>
						<td>Gaji</td>
						<?php foreach($boronganmesin as $p){?>
						<td><?php echo ($p['total'])?></td>
						<?php } ?>
						<?php if($bm==1){?>
							<!-- <td></td>
							<td></td> -->
						<?php } ?>
						<?php if(!empty($cucian)){?>
						<?php foreach($cucian as $p){?>
						<td><?php echo ($p['total'])?></td>
						<?php } ?>
						<?php }else{ ?>
							<td></td>
						<?php } ?>

						<?php foreach($bb as $p){?>
						<td><?php echo ($p['total'])?></td>
						<?php } ?>
						<?php foreach($pk as $p){?>
						<td><?php echo ($p['total'])?></td>
						<?php } ?>
					</tr>
					<tr>
						<td>Keterangan</td>
						<?php foreach($boronganmesin as $p){?>
						<td><?php echo ($p['keterangan'])?></td>
						<?php } ?>
						<?php if($bm==1){?>
							<!-- <td></td>
							<td></td> -->
						<?php } ?>
						<?php if(!empty($cucian)){?>
						<?php foreach($cucian as $p){?>
						<td><?php echo ($p['keterangan'])?></td>
						<?php } ?>
						<?php }else{ ?>
							<!-- <td></td> -->
						<?php } ?>

						<?php foreach($bb as $p){?>
						<td><?php echo ($p['keterangan'])?></td>
						<?php } ?>
						<?php foreach($pk as $p){?>
						<td><?php echo ($p['keterangan'])?></td>
						<?php } ?>
					</tr>
					<?php 
							$colb=2;
							if($bm==1){
								$colb=3;
							}
						?>
					<tr>
						<td>G.Total</td>
						<td colspan="<?php echo $colb?>"><?php echo ($gajim)?></td>
						<td colspan="<?php echo count($cucian)?>"><?php echo ($cucians)?></td>
						<td><?php echo ($bbs)?></td>
						<td><?php echo ($pkg)?></td>
					</tr>
					<tr>
						<td>Pembulatan</td>
						<td colspan="<?php echo $colb?>"><?php echo (pembulatangaji($gajim))?></td>
						<td colspan="<?php echo count($cucian)?>"><?php echo (pembulatangaji($cucians))?></td>
						<td><?php echo (pembulatangaji($bbs))?></td>
						<td><?php echo (pembulatangaji($pkg))?></td>
					</tr>
					<tr style="background-color: yellow">
						<td>Total</td>
						<td colspan="5" align="center"><b><?php $t2=0; echo $t2=(pembulatangaji($gajim)+pembulatangaji($cucians)+pembulatangaji($bbs)+pembulatangaji($pkg))?></b></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
<br>
<div class="row">
	<div class="col-md-6">
		<table border="1" style="border-collapse: collapse;width: 100%;background-color: orange" cellpadding="12">
			<tr>
				<td><b>Jumlah Table 2</b></td>
				<td></td>
				<td><b><?php echo ($t2)?></b></td>
			</tr>
		</table>
	</div>
</div>
<br>
<div class="row">
	<div class="col-md-6">
		<table border="1" style="border-collapse: collapse;width: 100%;background-color: orange" cellpadding="12">
			<tr>
				<td><b>Total Gaji Bagian Finishing</b></td>
				<td></td>
				<td><b><?php echo ($total+$t2)?></b></td>
			</tr>
		</table>
	</div>
</div>
<br>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<?php foreach($kancing as $p){?>
				<div class="alert alert-info">
					<?php echo $p['nama']?> (Lobang Kancing, Pasang Kancing, Tress )
				</div>
			<?php if(!empty($p['lobangkancing'])){?>
			<table border="1" style="border-collapse: collapse;width: 100%;" cellpadding="12">
				<thead>
					<tr>
						<th>No</th>
						<th>Nama PO</th>
						<th>Jumlah PCS</th>
						<th>Jumlah Titik</th>
						<th>Harga Per Titik</th>
						<th>Jumlah Rp</th>
						<th>Ket</th>
					</tr>
				</thead>
				<tbody>
					<?php $lk=0?>
						<?php foreach($p['lobangkancing'] as $d){?>
						<tr>
							<td><?php echo $no++?></td>
							<td><?php echo $d['nama_po']?></td>
							<td><?php echo $d['jumlah_pcs']?></td>
							<td><?php echo $d['jumlah_titik']?></td>
							<td><?php echo $d['harga_titik']?></td>
							<td><?php echo ($d['jumlah_pendapatan']*$d['perkalian'])?></td>
							<td><?php echo $d['kategori']?></td>
						</tr>
						<?php $lk+=($d['jumlah_pendapatan']*$d['perkalian'])?>
						<?php } ?>
						<tr style="background-color: yellow">
							<td colspan="5"><b>Total</b></td>
							<td><b><?php echo ($lk)?></b></td>
							<td></td>
						</tr>
				</tbody>
			</table>
			<?php } ?>
			<br>
			<?php if(!empty($p['pasangkancing'])){?>
			<table border="1" style="border-collapse: collapse;width: 100%;" cellpadding="12">
				<thead>
					<tr>
						<th>No</th>
						<th>Nama PO</th>
						<th>Jumlah PCS</th>
						<th>Jumlah Titik</th>
						<th>Harga Per Titik</th>
						<th>Jumlah Rp</th>
						<th>Ket</th>
					</tr>
				</thead>
				<tbody>
					<?php $pk=0?>
						<?php foreach($p['pasangkancing'] as $d){?>
						<tr>
							<td><?php echo $no2++?></td>
							<td><?php echo $d['nama_po']?></td>
							<td><?php echo $d['jumlah_pcs']?></td>
							<td><?php echo $d['jumlah_titik']?></td>
							<td><?php echo $d['harga_titik']?></td>
							<td><?php echo ($d['jumlah_pendapatan'])?></td>
							<td><?php echo $d['kategori']?></td>
						</tr>
						<?php $pk+=($d['jumlah_pendapatan'])?>
						<?php } ?>
						<tr style="background-color: yellow">
							<td colspan="5"><b>Total</b></td>
							<td><b><?php echo ($pk)?></b></td>
							<td></td>
						</tr>
				</tbody>
			</table>
			<?php } ?>
			<br>
			<?php if(!empty($p['tress'])){?>
			<table border="1" style="border-collapse: collapse;width: 100%;" cellpadding="12">
				<thead>
					<tr>
						<th>No</th>
						<th>Nama PO</th>
						<th>Jumlah PCS</th>
						<th>Jumlah Titik</th>
						<th>Harga Per Titik</th>
						<th>Jumlah Rp</th>
						<th>Ket</th>
					</tr>
				</thead>
				<tbody>
					<?php $tr=0?>
						<?php foreach($p['tress'] as $d){?>
						<tr>
							<td><?php echo $no3++?></td>
							<td><?php echo $d['nama_po']?></td>
							<td><?php echo $d['jumlah_pcs']?></td>
							<td><?php echo $d['jumlah_titik']?></td>
							<td><?php echo $d['harga_titik']?></td>
							<td><?php echo ($d['jumlah_pendapatan'])?></td>
							<td><?php echo $d['kategori']?></td>
						</tr>
						<?php $tr+=($d['jumlah_pendapatan'])?>
						<?php } ?>
						<tr style="background-color: yellow">
							<td colspan="5"><b>Total</b></td>
							<td><b><?php echo ($tr)?></b></td>
							<td></td>
						</tr>
				</tbody>
			</table>
			<?php } ?>
		<?php } ?>
		</div>
	</div>
	<br>
	<div class="col-md-6">
		<div class="form-group">
			<?php foreach($cu as $p){?>
				<div class="alert alert-info">
					<?php echo $p['nama']?> (Cucian / Laundry )
				</div>
			<?php if(!empty($p['details'])){?>
			<table border="1" style="border-collapse: collapse;width: 100%;" cellpadding="12">
				<thead>
					<tr>
						<th>No</th>
						<th>Nama PO</th>
						<th>Jumlah PCS</th>
						<th>Harga</th>
						<th>Jumlah Rp</th>
						<th>Ket</th>
					</tr>
				</thead>
				<tbody>
					<?php $lk=0?>
						<?php foreach($p['details'] as $d){?>
						<tr>
							<td><?php echo $no++?></td>
							<td><?php echo $d['kode_po']?></td>
							<td><?php echo $d['jumlah_pcs']?></td>
							<td><?php echo $d['harga']?></td>
							<td><?php echo ($d['total'])?></td>
							<td><?php echo $d['keterangan']?></td>
						</tr>
						<?php $lk+=($d['total'])?>
						<?php } ?>
						<tr style="background-color: yellow">
							<td colspan="4"><b>Total</b></td>
							<td><b><?php echo ($lk)?></b></td>
							<td></td>
						</tr>
				</tbody>
			</table>
			<?php } ?>
		<?php } ?>
		<br>
		<?php foreach($buangb as $b){?>
				<div class="alert alert-info">
					<?php echo $b['nama']?>
				</div>
			<?php if(!empty($b['details'])){?>
			<table border="1" style="border-collapse: collapse;width: 100%;" cellpadding="12">
				<thead>
					<tr>
						<th>No</th>
						<th>Nama PO</th>
						<th>Jumlah PCS</th>
						<th>Harga</th>
						<th>Jumlah Rp</th>
						<th>Ket</th>
					</tr>
				</thead>
				<tbody>
					<?php $bbj=1;$lkb=0;?>
						<?php foreach($b['details'] as $d){?>
						<tr>
							<td><?php echo $bbj++?></td>
							<td><?php echo $d['kode_po']?></td>
							<td><?php echo $d['jumlah_pcs']?></td>
							<td><?php echo $d['harga']?></td>
							<td><?php echo ($d['total'])?></td>
							<td><?php echo $d['keterangan']?></td>
						</tr>
						<?php $lkb+=($d['total'])?>
						<?php } ?>
						<tr style="background-color: yellow">
							<td colspan="4"><b>Total</b></td>
							<td><b><?php echo ($lkb)?></b></td>
							<td></td>
						</tr>
				</tbody>
			</table>
			<?php } ?>
		<?php } ?>
		<br>
		<?php foreach($pck as $b){?>
				<div class="alert alert-info">
					<?php echo $b['nama']?> (Packing)
				</div>
			<?php if(!empty($b['details'])){?>
			<table border="1" style="border-collapse: collapse;width: 100%;" cellpadding="12">
				<thead>
					<tr>
						<th>No</th>
						<th>Nama PO</th>
						<th>Jumlah Pcs</th>
						<th>Jumlah Dz</th>
						<th>Harga Per Dz</th>
						<th>Jumlah Rp</th>
						<th>Ket</th>
					</tr>
				</thead>
				<tbody>
					<?php $pk=1;$lkp=0;?>
						<?php foreach($b['details'] as $d){?>
						<tr>
							<td><?php echo $pk++?></td>
							<td><?php echo $d['nama_po']?></td>
							<td><?php echo $d['jumlah_dz']?></td>
							<td><?php echo ($d['jumlah_dz']*12)?></td>
							<td><?php echo ($d['harga_dz'])?></td>
							<td><?php echo ($d['jumlah_pendapatan'])?></td>
							<td><?php echo $d['keterangan']?></td>
						</tr>
						<?php $lkp+=($d['jumlah_pendapatan'])?>
						<?php } ?>
						<tr style="background-color: yellow">
							<td colspan="5"><b>Total</b></td>
							<td><b><?php echo ($lkp)?></b></td>
							<td></td>
						</tr>
				</tbody>
			</table>
			<?php } ?>
		<?php } ?>
		</div>
	</div>
</div>