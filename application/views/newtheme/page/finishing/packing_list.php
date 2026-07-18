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
								<th>Nama PO</th>
								<th>Nama Karyawan</th>
								<th>Jml dz</th>
								<th>Harga dz</th>
								<th>Total</th>
								<th>Keterangan</th>
								<th>Penggajian</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($products as $p){?>
							<tr>
								<td><?php echo formatTanggalIndo($p['creted_date'])?></td>
								<td><?php echo strtoupper($p['nama_po']) ?></td>
								<td><?php echo strtoupper($p['nama_karyawan']) ?></td>
								<td><?php echo $p['jumlah_dz']?></td>
								<td><?php echo $p['harga_dz'] ?></td>
								<td><?php echo number_format($p['jumlah_pendapatan']) ?></td>
								<td><?php echo $p['keterangan'] ?></td>
								<td>
									<?php 
									$is_kandar = (stripos($p['nama_karyawan'], 'kandar') !== false);
									$link_no = $is_kandar ? '#' : BASEURL.'Finishing/gajipackingno/'.$p['id'];
									$link_yes = $is_kandar ? '#' : BASEURL.'Finishing/gajipackingyes/'.$p['id'];
									$disabled_class = $is_kandar ? 'disabled' : '';
									?>
									<?php if($p['gaji']==1){?>
										<a href="<?php echo $link_no ?>" class="btn btn-success btn-xs <?php echo $disabled_class; ?>" <?php echo $is_kandar ? 'onclick="return false;"' : ''; ?>> <i class="fa fa-check"></i> </a>
									<?php } ?>
									<?php if($p['gaji']==2){?>
										<a href="<?php echo $link_yes ?>" class="btn btn-danger btn-xs <?php echo $disabled_class; ?>" <?php echo $is_kandar ? 'onclick="return false;"' : ''; ?>> <i class="fa fa-window-close"></i> </a>
									<?php } ?>
								</td>
								<td>
									<?php if(akseshapus()==1){?>
										<a href="<?php echo BASEURL ?>Finishing/packingdel/<?php echo $p['id'] ?>" class="btn btn-danger btn-xs" onclick="return confirm('Apakah yakin akan menghapus data ini ?')"><i class="fa fa-trash"></i></a>
									<?php } ?>
								</td>
							</tr>
							<?php }?>
						</tbody>
					</table>
	</div>
</div>