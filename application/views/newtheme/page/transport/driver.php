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
			<a href="<?php echo $tambah?>" class="btn btn-info btn-sm text-white">Tambah</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<table class="table table-bordered nosearch">
				<thead>
					<tr>
						<th>No</th>
						<th>Tanggal</th>
						<th>CMT</th>
						<th>Nominal</th>
						<th>Keterangan</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php $no=1;?>
					<?php foreach($products as $p){?>
						<tr>
							<td><?php echo $no++;?></td>
							<td><?php echo date('d-m-Y',strtotime($p['tanggal']))?></td>
							<td><?php echo $p['namacmt']?></td>
							<td><?php echo number_format($p['nominal'])?></td>
							<td><?php echo $p['keterangan']?></td>
							<td>
								<a href="<?php echo $url?>hapus_driver/<?php echo $p['id']?>" classbtn="btn btn-danger"><i class="fa fa-trash"></i></a>
							</td>
						</tr>
					<?php }?>
				</tbody>				
			</table>
		</div>
	</div>
</div>