<div class="row">
  <div class="col-md-12">
    <?php if ($this->session->flashdata('msg')) { ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
     	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
        	<span aria-hidden="true">×</span>
        </button>
		<?php echo $this->session->flashdata('msg'); ?> 
    </div>
    <?php } ?>
  </div>
</div>
<div class="row">
	<div class="col-md-4">
		<div class="form-group">
			<label>Tanggal Awal</label>
			<input type="text" name="tanggal1" id="tanggal1" value="<?php echo $tanggal1?>" class="form-control">
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label>Tanggal Akhir</label>
			<input type="text" name="tanggal2" id="tanggal2" value="<?php echo $tanggal2?>" class="form-control">
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label>Aksi</label><br>
			<button class="btn btn-info btn-sm" onclick="filtertglonly()">Filter</button>
			<a  onclick="excelwithtgl()" class="btn btn-info btn-sm text-white">Excel</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th>No</th>
					<th>Tanggal</th>
					<th>Nama</th>
					<th>Shift</th>
					<th>Kehadiran</th>
					<th>Keterangan</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($prods as $p){?>
					<tr>
						<td><?php echo $p['no']?></td>
						<td><?php echo $p['tanggal']?></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<?php foreach($p['dets'] as $pd){?>
						<tr>
							<td colspan="2"></td>
							<td><?php echo strtoupper($pd['nama'])?></td>
							<td><?php echo $pd['shift']?></td>
							<td><?php echo !empty($pd['kehadiran_operator'])?$pd['kehadiran_operator']:'TIDAK HADIR'?></td>
							<td></td>
						</tr>
					<?php } ?>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>