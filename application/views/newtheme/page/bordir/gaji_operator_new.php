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
    <?php if ($this->session->flashdata('msgt')) { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
     	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
        	<span aria-hidden="true">×</span>
        </button>
		<?php echo $this->session->flashdata('msgt'); ?> 
    </div>
    <?php } ?>
  </div>
</div>
<form method="post" action="<?php echo $action?>">
<div class="row no-print">
	<div class="col-md-3">
		<div class="form-group">
			<label>Tanggal Awal</label>
			<input type="text" name="tanggal1" id="tanggal1" value="<?php echo $tanggal1?>" class="form-control datepicker">
		</div>
	</div>
	<div class="col-md-3">
		<div class="form-group">
			<label>Tanggal Akhir</label>
			<input type="text" name="tanggal2" id="tanggal2" value="<?php echo $tanggal2?>" class="form-control datepicker">
		</div>
	</div>
	<div class="col-md-3">
			<div class="form-group">
				<label>Tempat</label>
				<select name="tempat" class="form-control select2bs4" required="required" data-live-search="true">
					<option value="*">Pilih</option>
					<option value="1" <?php echo $tempat==1?'selected':'';?>>Rumah</option>
					<option value="2" <?php echo $tempat==2?'selected':'';?>>Cipadu</option>
				</select>
			</div
			>
	</div>
	<div class="col-md-3">
		<div class="form-group">
			<label>Aksi</label><br>
			<!--<a class="btn btn-info btn-sm text-white" onclick="filter()">Filter</a>-->
			<a class="btn btn-info btn-sm text-white" onclick="kalkulasi()">Kalkulasi</a>
			<?php if(isset($_GET['kalkulasi'])){?>
			<a class="btn btn-success btn-sm text-white" onclick="proses()">Proses</a>
			<?php } ?>
			<a href="<?php echo $batal?>" class="btn btn-danger btn-sm text-white">Batal</a>
		</div>
	</div>
</div>
<div class="row">
	<?php $i=0;?>
	<?php foreach($prods as $p){?>
	<div class="col-md-12">
		<table class="table table-bordered">
			<thead>
				<tr>
					<th><?php echo strtolower($p['nama'])?></th>
					<th>Hari</th>
					<th>Gaji</th>
					<th>Shift</th>
					<th>Mandor</th>
					<!-- <th>Bonus</th>
					<th>Uang Makan</th> -->
					<th>Potongan</th>
					<th>Keterangan</th>
					<th>
						Shift
						<select name="products[<?php echo $i?>][shift]" required>
							<option value="">Pilih</option>
							<option value="1">Pagi</option>
							<option value="2">Malam</option>
						</select>
					</th>
				</tr>
			</thead>
			<tbody>
				<?php $har=0;?>
				<input type="hidden" name="products[<?php echo $i?>][idkaryawan]" value="<?php echo strtolower($p['id'])?>" checked>
				<input type="hidden" name="products[<?php echo $i?>][nama_karyawan_bordir]" value="<?php echo strtolower($p['nama'])?>">
				<?php foreach($p['hari'] as $h){?>
					<input type="hidden" name="products[<?php echo $i?>][det][<?php echo $har?>][hari]" value="<?php echo $h['hari']?>" checked>
					<input type="hidden" name="products[<?php echo $i?>][det][<?php echo $har?>][gaji]" value="<?php echo $h['nominal']?>">
					<input type="hidden" name="products[<?php echo $i?>][det][<?php echo $har?>][bonus]" value="0">
					<input type="hidden" name="products[<?php echo $i?>][det][<?php echo $har?>][um]" value="0">
					<input type="hidden" name="products[<?php echo $i?>][det][<?php echo $har?>][mandor]" value="<?php echo $h['mandor'] ?>">
					<input type="hidden" name="products[<?php echo $i?>][det][<?php echo $har?>][shift]" value="<?php echo $h['shift'] ?>">
					<tr>
						<td><?php echo date('d-m-Y',strtotime($h['tanggal']))?></td>
						<td><?php echo $h['hari'] ?></td>
						<td><?php echo $h['nominal'] ?></td>
						<td><?php echo $h['shift'] ?></td>
						<td><?php echo $h['mandor'] ?></td>
						<!-- <td>0</td>
						<td>0</td> -->
						<td><?php echo $h['potongan'] ?></td>
						<td>
							<input type="text" name="products[<?php echo $i?>][det][<?php echo $har?>][keterangan]" class="form-control" value="-">
						</td>
						<td></td>
					</tr>
				<?php $har++; ?>
				<?php } ?>
			</tbody>
		</table>
	</div>
	<?php $i++?>
	<?php } ?>
</div>
</form>
<script type="text/javascript">
	function proses(){
		var tanggal1 =$("#tanggal1").val();
		var tanggal2 =$("#tanggal2").val();
		if(tanggal1===""){
			alert("Tanggal awal harus diisi");
			$("#tanggal1").focus();
			return false;
		}
		if(tanggal2===""){
			alert("Tanggal akhir harus diisi");
			$("#tanggal2").focus();
			return false;
		}
		//console.log(tanggal1);
		c=confirm("Pastikan semua Shift dipilih pada setiap operator");
		if(c==false){
			return false;
		}
		$("form").submit();
	}

	function kalkulasi(){
		var url='?&kalkulasi=1';
		var tanggal1 =$('input[name=\'tanggal1\']').val();
		var tanggal2 =$('input[name=\'tanggal2\']').val();
		var tempat =$('select[name=\'tempat\']').val();
		if(tempat=="*"){
			alert("Tempat harus dipilih. Rumah / Cipadu");
			return false;
		}
		if(tanggal1!=""){
			url+='&tanggal1='+tanggal1;
		}
		if(tanggal2!=""){
			url+='&tanggal2='+tanggal2;
		}
		if(tempat!="*"){
			url+='&tempat='+tempat;
		}
		location=url;
	}
</script>