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

			<a href="<?php echo $tambah?>" class="btn btn-info btn-sm text-white">Input Slip Gaji</a>

			<button class="btn btn-info btn-sm" onclick="filtertglonly_excel()">Excel</button>

		</div>

	</div>

</div>
<div class="row">
	<div class="col-md-12">
		<table class="table table-bordered" id="datatable">
			<thead>
				<tr>
					<th>No</th>
					<th>Tanggal</th>
					<th>Nama Karyawan</th>
					<th>Saving Gaji Kontrak</th>
					<th>Total</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($gaji as $g){?>
					<tr>
						<td><?php echo $g['no']?></td>
						<td><?php echo $g['tanggal']?></td>
						<td><?php echo $g['nama']?></td>
						<td><?php echo number_format($g['gantungan_gaji'])?></td>
						<td><?php echo number_format($g['total'])?></td>
						<td>
							<a href="<?php echo $g['slip']?>" class="btn btn-info btn-sm text-white">Slip</a>
							<?php if($akseshapus==1){?>
								<a href="<?php echo $hapus.$g['id']?>" class="btn btn-danger btn-sm text-white">Hapus</a>
							<?php } ?>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>