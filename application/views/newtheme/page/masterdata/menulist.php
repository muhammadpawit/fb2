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
	<div class="col-md-12 text-right">
		<a href="<?php echo $tambah?>" class="btn btn-info btn-sm text-white">Tambah</a>
	</div>
</div><br>
<div class="row">
	<div class="col-md-12">
		<table class="table table-bordered table-striped" id="datatable">
			<thead>
				<tr>
					<th>No</th>
					<th>Nama Menu</th>
					<th>Url</th>
					<th>Lokasi</th>
					<th>Urutan</th>
					<th>Icon</th>
					<th class="text-center">Aksi</th>
				</tr>
			</thead>
			<tbody>
				<?php $no=1; foreach($menus as $m){?>
					<tr>
						<td><?php echo $no++ ?></td>
						<td><?php echo $m['nama']?></td>
						<td><?php echo $m['url']?></td>
						<td><?php echo $m['lokasi'] ?></td>
						<td><?php echo $m['urutan'] ?></td>
						<td><i class="<?php echo $m['icon'] ?>"></i></td>
						<td class="text-center">
							<a href="<?php echo $m['edit']?>" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i> Edit</a>
							<a href="<?php echo $m['delete']?>" class="btn btn-danger btn-xs" onclick="return confirm('Apakah anda yakin ingin menghapus menu ini?')"><i class="fa fa-trash"></i> Hapus</a>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>