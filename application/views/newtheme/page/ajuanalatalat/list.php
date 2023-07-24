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
			<button class="btn btn-info btn-sm" onclick="filtertglonly_excel()">Excel</button>
			<a href="<?php echo $tambah?>" class="btn btn-info btn-sm text-white">Tambah</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<table class="table table-bordered yessearch">
			<thead>
				<tr>
					<th>NO</th>
					<th>NAMA BARANG</th>
					<th>KEBUTUHAN</th>
					<th>STOK</th>
					<th>AJUAN</th>
					<th>SATUAN</th>
					<th>TANGGAL AJUAN</th>
					<th>KETERANGAN</th>
					<th>ACC SPV</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>
				<?php $no=1;?>
				<?php foreach($prods as $p){ ?>
					
					<?php //if(!empty($spv)) { ?>
					<tr>
						<td><?php echo $p['no'] ?></td>
						<td><?php echo $p['nama'] ?></td>
						<td><?php echo $p['kebutuhan'] ?></td>
						<td><?php echo $p['stok'] ?></td>
						<td><?php echo $p['ajuan'] ?></td>
						<td><?php echo $p['satuan'] ?></td>
						<td><?php echo $p['tanggal'] ?></td>
						<td><?php echo $p['keterangan'] ?></td>
						<td>
						<form method="POST" action="<?php echo $acc ?>">
						<?php if(!empty($spv)) { ?>
							<input type="number" name="prods[<?php echo $p['id'] ?>][acc_ajuan]" class="form-control">
						<?php }else{ ?>

						<?php } ?>
						</td>
						
						<td>
							<?php if(!empty($spv)) { ?>
								<button type="submit" class="btn btn-success">Persetujuan</button>
								</form>
								<br><br>
								<a href="<?php echo BASEURL.'Ajuanalatalat/Ajuanalatalat_hapus/'.$p['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah yakin akan menghapus data ini ? ') ">Pembatalan</a>
							<?php }else{ ?>
							<?php //if(aksesedit()==1){ ?>
								<a href="<?php echo BASEURL.'Ajuanalatalat/Ajuanalatalat_edit/'.$p['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
							<?php  //}?>
							<?php //if(akseshapus()==1){ ?>
								<a href="<?php echo BASEURL.'Ajuanalatalat/Ajuanalatalat_hapus/'.$p['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah yakin akan menghapus data ini ? ') ">Hapus</a>
							<?php  //}?>
							<?php } ?>
						</td>
					</tr>
					
					<?php //} ?>
					<?php $no++; ?>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>