<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<label>Periode</label>
			<h4><?php echo date('d F Y',strtotime($gaji['tanggal1'])).' s.d '.date('d F Y',strtotime($gaji['tanggal2'])) ?></h4>
		</div>
	</div>
</div>
<div class="row">
	<?php $bonus=0;$grand=0?>
	<?php foreach($karyawans as $k){?>
	<div class="col-md-4">
		<div class="table-responsive">
			<table class="table table-bordered">
				<thead>
					<tr>
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
					<tr>
						<td>Senin</td>
						<td align="right"><?php echo $k['senin']?></td>
						<td align="right"><?php //echo $k['bonus']?></td>
						<td align="right"><?php //echo $k['um']?></td>
						<td align="right"><?php echo $k['ksenin']?></td>
					</tr>
					<tr>
						<td>Selasa</td>
						<td align="right"><?php echo $k['selasa']?></td>
						<td align="right"><?php //echo $k['bonus']?></td>
						<td align="right"><?php //echo $k['um']?></td>
						<td align="right"><?php echo $k['kselasa']?></td>
					</tr>
					<tr>
						<td>Rabu</td>
						<td align="right"><?php echo $k['rabu']?></td>
						<td align="right"><?php //echo $k['bonus']?></td>
						<td align="right"><?php //echo $k['um']?></td>
						<td align="right"><?php echo $k['krabu']?></td>
					</tr>
					<tr>
						<td>Kamis</td>
						<td align="right"><?php echo $k['kamis']?></td>
						<td align="right"><?php //echo $k['bonus']?></td>
						<td align="right"><?php //echo $k['um']?></td>
						<td align="right"><?php echo $k['kkamis']?></td>
					</tr>
					<tr>
						<td>Jumat</td>
						<td align="right"><?php echo $k['jumat']?></td>
						<td align="right"><?php //echo $k['bonus']?></td>
						<td align="right"><?php //echo $k['um']?></td>
						<td align="right"><?php echo $k['kjumat']?></td>
					</tr>
					<tr>
						<td>Sabtu</td>
						<td align="right"><?php echo $k['sabtu']?></td>
						<td align="right"><?php //echo $k['bonus']?></td>
						<td align="right"><?php //echo $k['um']?></td>
						<td align="right"><?php echo $k['ksabtu']?></td>
					</tr>
					<tr>
						<td>Minggu</td>
						<td align="right"><?php echo $k['minggu']?></td>
						<td align="right"><?php //echo $k['bonus']?></td>
						<td align="right"><?php //echo $k['um']?></td>
						<td align="right"><?php echo $k['kminggu']?></td>
					</tr>
					<tr>
						<td>Total</td>
						<td align="right"><?php //echo $k['um']?></td>
						<td align="right"><?php echo $k['bonus']?></td>
						<td align="right"><?php echo $k['kbonus']?></td>
						<td></td>
					</tr>
					
					<tr>
						<td><b>Total Gaji</b></td>
						<td colspan="4" align="center"><label><?php echo number_format($k['senin']+$k['selasa']+$k['rabu']+$k['kamis']+$k['jumat']+$k['sabtu']+$k['minggu']+$k['bonus']+$k['um']) ?></label></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<?php 
		$bonus+=($k['bonus']);
		$grand+=($k['senin']+$k['selasa']+$k['rabu']+$k['kamis']+$k['jumat']+$k['sabtu']+$k['minggu']+$k['bonus']+$k['um']);
	?>
	<?php } ?>
</div>
<div class="row">
	<div class="col-md-12">
		<table>
			<tr>
				<td>
					<caption>Bonus Target Mandor</caption>
					<table class="table table-striped table-bordered">
						<tr>
							<td>Bonus</td>
							<td>30%</td>
						</tr>
						<tr>
							<td><?php echo $bonus?></td>
							<td><?php echo round($bonus*0.3)?></td>
						</tr>
					</table>
				</td>
				<td>
					
					<table class="table table-striped table-bordered">
						<tr>
							<td>Total Gaji</td>
							<td><?php echo $grand?></td>
						</tr>
						<tr>
							<td>Bonus Target Mandor</td>
							<td><?php echo round($bonus*0.3)?></td>
						</tr>
						<tr>
							<td>Total</td>
							<td><?php echo (round($bonus*0.3)+$grand)?></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<a href="<?php echo $kembali?>" class="btn btn-danger btn-sm text-white">Kembali</a>
		<button class="btn btn-info btn-sm" onclick="excel()">Excel</button>
	</div>
</div>
<script type="text/javascript">
	function excel(){
		url ='?&excel=1';
		location = url;
	}
</script>