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
			<a href="<?php echo $excel?>" class="btn btn-info btn-sm text-white">Excel</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover ">
				<thead>
					<tr>
						<th>No</th>
						<th>Nama Barang</th>
						<?php foreach($products as $p){?>
							<th><?php echo $p['nama']?></th>
						<?php } ?>
					</tr>
				</thead>
				<tbody>
					<?php $no=1;?>
					<?php foreach($alat as $p){?>
						<tr>
							<td><?php echo $no++;?></td>
							<td><?php echo $p['nama']?></td>
							<?php foreach($p['po'] as $o){?>
								<td>
									<table>
										<tr>
											<td><?php echo $this->ReportModel->sum_jumlah_bahan_used_po($p['nama'],$o['nama_jenis_po'],$tanggal1,$tanggal2)['yard']; ?> yard</td>
											<td><?php echo $this->ReportModel->sum_jumlah_bahan_used_po($p['nama'],$o['nama_jenis_po'],$tanggal1,$tanggal2)['roll']; ?> roll</td>
										</tr>
									</table>
								</td>
							<?php } ?>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>