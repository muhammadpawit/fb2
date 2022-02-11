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
	<div class="col-md-12">
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>No</th>
					<th>Nama</th>
					<th>Bagian</th>
					<th>Tgl Masuk</th>
					<th>Gaji/Bulan (Rp)</th>
					<th>Kasbon Minguan (Rp)</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($prods as $p){?>
					<tr>
						<td><?php echo $p['no']?></td>
						<td><?php echo $p['nama']?></td>
						<td><?php echo $p['bagian']?></td>
						<td><?php echo $p['tglmasuk']?></td>
						<td><?php echo number_format($p['gaji'])?></td>
						<td>
							<?php 
								// looping date
								$begin = new DateTime($tanggal1);
								$end   = new DateTime($tanggal2);

								for($i = $begin; $i <= $end; $i->modify('+1 day')){
									if($i->format("l")=="Saturday"){
										echo $i->format("l Y-m-d")."<br>";	
									}
								}
							?>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>