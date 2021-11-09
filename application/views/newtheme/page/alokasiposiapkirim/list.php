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
	<div class="col-md-3">
		<label>Tanggal Awal</label>
		<input type="text" name="tanggal1" class="form-control" value="<?php echo $tanggal1?>">
	</div>
	<div class="col-md-3">
		<label>Tanggal Akhir</label>
		<input type="text" name="tanggal2" class="form-control" value="<?php echo $tanggal2?>">
	</div>
	<div class="col-md-3">
		<label>Nama CMT</label>
		<select name="cmt" class="form-control select2bs4" data-live-search="true">
			<option value="*">Semua</option>
			<?php foreach($cmt as $c){?>
				<option value="<?php echo $c['id_cmt']?>" <?php echo $c['id_cmt']==$idcmt?'selected':'';?> ><?php echo strtolower($c['cmt_name'])?></option>
			<?php } ?>
		</select>
	</div>
	<div class="col-md-3">
		<label>Action</label><br>
		<button class="btn btn-info btn-sm" onclick="filterwithcmt()">Filter</button>
		<button class="btn btn-info btn-sm" onclick="excel()">excel</button>
		<a class="btn btn-info btn-sm text-white" href="<?php echo $tambah?>">Tambah</a>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<table class="table table-bordered nosearch">
			<thead>
				<tr>
					<th>No</th>
					<th>Tanggal</th>
					<th>CMT</th>
					<th>Jumlah PO</th>
					<th>Keterangan</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($products as $p){?>
					<tr>
						<td><?php echo $p['no']?></td>
						<td><?php echo $p['tanggal']?></td>
						<td><?php echo $p['nama']?></td>
						<td><?php echo $p['jumlah']?></td>
						<td>
							<?php foreach($p['keterangan'] as $k){?>
								<?php echo $k['kode_po']?>,
							<?php } ?>
								
						</td>
						<td> <a href="<?php echo $p['edit']?>" class="btn btn-warning btn-sm text-white">Edit</a> </td>
					</tr>
				<?php } ?>	
			</tbody>
		</table>
	</div>
</div>
<script type="text/javascript">
	function excel(){
		var url='?&excel=1';
		location =url;
	}
</script>