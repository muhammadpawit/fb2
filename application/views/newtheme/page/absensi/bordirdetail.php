<div class="row">
	<div class="col-md-12">
		<div class="text-center">
			<h3>Laporan Absensi harian karyawan bordir rumah</h3>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<table class="table no-border">
			<tr>
				<td>Hari</td>
				<td>:&nbsp;<?php echo strtolower($products['hari'])?></td>
			</tr>
			<tr>
				<td>Tanggal</td>
				<td>:&nbsp;<?php echo strtolower(date('d-m-Y',strtotime($products['tanggal'])))?></td>
			</tr>
			<tr>
				<td>Shift</td>
				<td>:&nbsp;<?php echo strtolower($products['shift'])?></td>
			</tr>
		</table>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="pull-right text-right">
			Mandor : <?php echo strtolower($products['mandor'])?>
		</div>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>No</th>
					<th>Nama Karywan</th>
					<th>Absen</th>
					<th>Target</th>
					<th>Keterangan</th>
					<th>Stich</th>
					<th>Bonus</th>
					<th>Mesin</th>
				</tr>
			</thead>
			<tbody>
				<?php $no=1;?>
				<?php foreach($details as $d){?>
					<?php 
						$k=$this->GlobalModel->getDataRow('master_karyawan_bordir',array('id_master_karyawan_bordir'=>$d['idkaryawan']));
					?>
					<tr>
						<td><?php echo $no++?></td>
						<td><?php echo strtolower($k['nama_karyawan_bordir'])?></td>
						<td><i class="fa fa-check-circle" style="font-size:20px;color:green"></i></td>
						<td>
							<?php if($d['target']==1){?>
								<i class="fa fa-check-circle" style="font-size:20px;color:green"></i>
							<?php }else{?>
								<i class="fa fa-window-close" style="font-size:20px;color:red"></i>
							<?php } ?>
						</td>
						<td><?php echo strtolower($d['keterangan'])?></td>
						<td><?php echo ($d['stich'])?></td>
						<td><?php echo ($d['bonus'])?></td>
						<td><?php echo ($d['mesin'])?></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>