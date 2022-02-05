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
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="row">
			<caption><a href="<?php echo $tambah?>" class="btn btn-info btn-sm text-white">Tambah</a></caption>
			<table class="table table-bordered nosearch">
				<thead>
					<th>Nama</th>
					<th>Jumlah PO Kirim</th>
					<th>Jumlah Dz Kirim</th>
					<th>Jumlah Pcs Kirim</th>
					<th>Jumlah PO Setor</th>
					<th>Jumlah Dz Setor</th>
					<th>Jumlah Pcs Setor</th>
					<th>Tampil</th>
					<th></th>
				</thead>
				<tbody>
					<?php foreach($products as $p){?>
						<tr>
							<td><?php echo $p['nama']?></td>
							<td><?php echo $p['kirim_po']?></td>
							<td><?php echo $p['kirim_dz']?></td>
							<td><?php echo $p['kirim_pcs']?></td>
							<td><?php echo $p['setor_po']?></td>
							<td><?php echo $p['setor_dz']?></td>
							<td><?php echo $p['setor_pcs']?></td>
							<td>
								<?php if($p['tampil']==1){?>
									<a href="<?php echo $url?>/hide/<?php echo $p['id']?>" class="btn btn-success btn-sm"><i class="fa fa-check"></i></a>
								<?php }else{ ?>
									<a href="<?php echo $url?>/tampil/<?php echo $p['id']?>" class="btn btn-danger btn-sm"><i class="fa fa-window-close"></i></a>
								<?php } ?>
							</td>
							<td>
								<a href="<?php echo $url?>/hapus/<?php echo $p['id']?>" class="btn btn-danger btn-sm">Hapus</a>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="col-md-6">
		<div class="row">
			
		</div>
	</div>
</div>