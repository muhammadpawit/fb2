<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<select name="kode_po" class="select2bs4 autopoid"></select>
		</div>
	</div>
	<div class="col-md-2">
		<div class="form-group">
			<button onclick="filterwithpo()" class="btn btn-primary full">Filter</button>
		</div>
	</div>
</div>
<?php if(isset($results)){?>
<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<label>Rincian Setoran</label>
			<table class="table table-bordered">
				<thead>
					<th>No</th>
					<th>Hari / Tanggal</th>
					<th>Kode PO</th>
					<th>Rincian</th>
				</thead>
				<tbody>
					<?php $nom=1;?>
					<?php foreach($results['setoran'] as $s){?>
						<tr>
							<td><?php echo $nom++; ?></td>
							<td><?php echo $s['tgl']?></td>
							<td><?php echo $s['kode_po']?></td>
							<td>
								<?php foreach($s['detail'] as $ds){ ?>
									<table class="table table-bordered">
										<tr>
											<td width="100"><?php echo $ds['rincian_size']?></td>
											<td width="100"><?php echo $ds['rincian_lusin']?> Dz</td>
										</tr>
									</table>
								<?php } ?>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<label>History Kirim Gudang</label>
			<table class="table table-bordered">
				<thead>
					<th>No</th>
					<th>Hari / Tanggal</th>
					<th>Kode PO</th>
					<th>Rincian</th>
				</thead>
				<tbody>
					<?php $no=1;?>
					<?php foreach($results['kirimgudang'] as $s){?>
						<tr>
							<td><?php echo $no++ ?></td>
							<td><?php echo $s['tgl']?></td>
							<td><?php echo $s['kode_po']?></td>
							<td>
								<?php foreach($s['detail'] as $ds){ ?>
									<table class="table table-bordered">
										<tr>
											<td width="100"><?php echo $ds['rincian_size']?></td>
											<td width="100"><?php echo $ds['rincian_lusin']?> Dz</td>
										</tr>
									</table>
								<?php } ?>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<label>Stok</label>
			<table class="table table-bordered">
				<thead>
					<th>Rincian Size</th>
					<th>Stok</th>
				</thead>
				<tbody>
					<?php foreach($results['stok'] as $key=>$val){?>
						<tr>
							<td><?php echo $key ?></td>
							<td><b><?php echo ($val==0)?'<i class="text-danger">Habis</i>':$val.' Dz' ?></b></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<?php } ?>