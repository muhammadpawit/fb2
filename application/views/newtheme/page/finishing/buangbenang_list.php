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
		<table class="table table-bordered" id="datatable">
						<thead>
							<tr>
								<th>Tanggal</th>

								<th>Nama Karyawan</th>
								<th>Nama PO</th>
								<th>Jml pcs</th>
								<th>Harga Per PCS</th>
								<th>Total</th>
								<th>Keterangan</th>
								<th>Penggajian</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($products as $p){?>
							<tr>
								<td><?php echo ($p['tanggal']) ?></td>
								<td><?php echo strtolower($p['idkaryawan']) ?></td>
								<td><?php echo ($p['nama_po']) ?></td>
								<td><?php echo $p['jumlah_pcs']?></td>
								<td><?php echo $p['harga'] ?></td>
								<td><?php echo ($p['total']) ?></td>
								<td><?php echo $p['keterangan'] ?></td>
								<td>
									<?php if($p['gaji']==1){?>
										<a href="<?php echo BASEURL ?>Finishing/yesgajibb/<?php echo $p['id'] ?>" class="btn btn-success btn-sm"> <i class="fa fa-check"></i> </a>
									<?php } ?>
									<?php if($p['gaji']==2){?>
										<a href="<?php echo BASEURL ?>Finishing/nogajibb/<?php echo $p['id'] ?>" class="btn btn-danger btn-sm"> <i class="fa fa-window-close"></i> </a>
									<?php } ?>
								</td>
								<td>
									<?php if(akseshapus()==1){?>
										<a href="<?php echo $p['hapus'] ?>" class="btn btn-danger btn-sm">Hapus</a>
									<?php } ?>
								</td>
							</tr>
							<?php }?>
						</tbody>
					</table>
	</div>
</div>