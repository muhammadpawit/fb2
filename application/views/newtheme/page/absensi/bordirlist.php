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
			<input type="text" name="tanggal1" class="form-control" value="<?php echo $tanggal1?>">
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label>Tanggal Akhir</label>
			<input type="text" name="tanggal2" class="form-control" value="<?php echo $tanggal2?>">
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label>Aksi</label><br>
			<button class="btn btn-info btn-sm text-white" onclick="filter()">Filter</button>
			<a href="<?php echo $tambah?>" class="btn btn-info btn-sm text-white">Tambah</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<table class="table table-bordered yessearch">
			<thead>
				<tr>
					<th>No</th>
					<th>Hari/Tanggal</th>
					<th>Nama Operator</th>
					<th>Shift</th>
					<th>Mesin</th>
					<th>Mandor</th>
					<th>Target</th>
					<th>Tempat</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php if($products){?>
					<?php foreach($products as $p){?>
						<?php foreach($p['rincian'] as $r){?>
							<?php

								$k=$this->GlobalModel->getDatarow('master_karyawan_bordir',array('id_master_karyawan_bordir'=>$r['idkaryawan']));
							?>
						<tr>
							<td><?php echo $p['no']?></td>
							<td><?php echo $p['hari'].','.$p['tanggal']?></td>
							<td><?php echo $k['nama_karyawan_bordir']?></td>
							<td><?php echo $p['shift']?></td>
							<td><?php echo $r['mesin']?></td>
							<td><?php echo $p['mandor']?></td>
							<td>
								<?php if($r['target']==1){?>
									<i class="fa fa-check-circle" style="font-size:20px;color:green"></i>
								<?php }else{?>
									<i class="fa fa-window-close" style="font-size:20px;color:red"></i>
								<?php } ?>
							</td>
							<td><?php echo $p['tempat']?></td>
							<td>
								<a href="<?php echo $p['detail']?>" class="btn btn-warning btn-sm text-white">lihat</a>
								<?php if(akseshapus()==1){?>
									<a href="<?php echo BASEURL.'Bordir/absensikaryawanhapus/'.$r['id'];?>" class="btn btn-danger btn-sm text-white">Hapus</a>
								<?php } ?>
							</td>
						</tr>
						<?php } ?>
					<?php } ?>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
<script type="text/javascript">
	function filter(){
		url='?';
		
		var filter_date_start = $('input[name=\'tanggal1\']').val();

		if (filter_date_start) {
			url += '&tanggal1=' + encodeURIComponent(filter_date_start);
		}

	  var filter_date_end = $('input[name=\'tanggal2\']').val();

		if (filter_date_end) {
			url += '&tanggal2=' + encodeURIComponent(filter_date_end);
		}

	  	/*
	  	var filter_status = $('select[name=\'namaPo\']').val();
		if (filter_status != '*') {
			url += '&namaPo=' + encodeURIComponent(filter_status);
		}
		*/
		location =url;
		
	}
</script>