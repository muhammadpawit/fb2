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
		<table class="table table-bordered" id="datatable">
			<thead>
				<tr>
					<th>No</th>
					<th>Nama Menu</th>
					<th>Url</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($menus as $m){?>
					<tr>
						<td><?php echo $m['id']?></td>
						<td><?php echo $m['nama']?></td>
						<td><?php echo $m['url']?></td>
						<td>
							<a href="<?php echo $m['edit']?>" class="badge bg-green">Edit</a>
							<a href="<?php echo $m['delete']?>" class="badge bg-red">Hapus</a>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>