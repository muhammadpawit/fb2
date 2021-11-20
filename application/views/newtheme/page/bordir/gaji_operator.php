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
			<?php $i=0?>
			<?php foreach($harian as $h){?>
			<div class="col-md-12">
				<div class="table-responsive">
				<table class="table table-bordered">
					<thead>
						<tr>
							<td><input type="checkbox" name="products[<?php echo $i?>][idkaryawan]" value="<?php echo strtolower($h['id_master_karyawan_bordir'])?>" checked>
								<input type="hidden" name="products[<?php echo $i?>][nama_karyawan_bordir]" value="<?php echo strtolower($h['nama_karyawan_bordir'])?>"></td>
							<th>Nama</th>
							<th colspan="5"><?php echo strtolower($h['nama_karyawan_bordir'])?> (Operator)</th>
						</tr>
						<tr>
							<th></th>
							<th>Hari</th>
							<th>Gaji</th>
							<th>Bonus</th>
							<th>Uang Makan</th>
							<th>Potongan</th>
							<th>Keterangan</th>
						</tr>
						<?php $bc=1;$bns=0;$har=0;$pot=0;$pinjaman=0;?>
						<?php foreach($h['details'] as $d){?>
							<?php 
								$hari=date('l',strtotime($d['tanggal']));
								$shift=$this->GlobalModel->getDataRow('absensi_bordir',array('id'=>$d['idabsensi'],'hapus'=>0));
								$s=$this->GlobalModel->QueryManualRow("SELECT count(*) as total FROM absensi_bordir_detail WHERE hapus=0 AND idkaryawan='".$d['idkaryawan']."' AND DATE(tanggal) ='".$d['tanggal']."' ");
								$jm=$this->GlobalModel->QueryManual("SELECT abd.mesin,ab.shift FROM absensi_bordir_detail abd JOIN absensi_bordir ab ON(ab.id=abd.idabsensi) WHERE abd.hapus=0 AND idkaryawan='".$d['idkaryawan']."' AND DATE(abd.tanggal) ='".$d['tanggal']."' ");
								$bon=$this->GlobalModel->QueryManualRow("SELECT SUM(bonus) as bonus FROM absensi_bordir_detail WHERE hapus=0 AND idkaryawan='".$d['idkaryawan']."' AND DATE(tanggal) ='".$d['tanggal']."' ");
								//$ejm=$jm;
								$cjm=count($jm);
								$uangmakan=$this->ReportModel->uangmakanbordir($d['idkaryawan'],$d['tanggal']);
								$pot=$this->M_potonganoperator->getSumPotongan($d['idkaryawan'],$d['tanggal'],1);
								$pinjaman=$this->M_potonganoperator->getSumPotongan($d['idkaryawan'],$d['tanggal'],2);
							?>
							<tr>
								<td><input type="checkbox" name="products[<?php echo $i?>][det][<?php echo $har?>][hari]" value="<?php echo hari($hari)?>" checked></td>
								<td><?php echo hari($hari)?> <?php echo date('d-m-Y',strtotime($d['tanggal']))?></td>
								<td>
									<input type="hidden" class="form-control" name="products[<?php echo $i?>][gaji<?php echo strtolower(hari($hari))?>]" value="<?php echo (hari($hari)=="Minggu"?$h['karyawan_gaji_weekday']*2*$cjm:$h['karyawan_gaji_weekday']/12*$d['jamkerja']*$s['total'])?>">
									<input type="text" class="form-control" name="products[<?php echo $i?>][det][<?php echo $har?>][gaji]" value="<?php echo (hari($hari)=="Minggu"?$h['karyawan_gaji_weekday']*2*$cjm:$h['karyawan_gaji_weekday']/12*$d['jamkerja']*$s['total'])?>">
								</td>
								<td>
									<input type="hidden" class="form-control" name="products[<?php echo $i?>][bonus<?php echo strtolower(hari($hari))?>]" value="<?php echo !empty($bon)?$bon['bonus']:0;?>">
									<input type="text" class="form-control" name="products[<?php echo $i?>][det][<?php echo $har?>][bonus]" value="<?php echo !empty($bon)?$bon['bonus']:0;?>">
								</td>
								<td>
									<input type="hidden" class="form-control" name="products[<?php echo $i?>][um<?php echo strtolower(hari($hari))?>]" value="<?php echo $uangmakan?>">

									<input type="text" class="form-control" name="products[<?php echo $i?>][det][<?php echo $har?>][um]" value="<?php echo $uangmakan?>">
								</td>
								<td>
									<!-- <label for="">Absensi</label>
									<input type="text" class="form-control" name="products[<?php echo $i?>][det][<?php echo $har?>][pot]" value="<?php echo $pot==null?0:$pot?>" readonly>
									<label for="">Pinjaman</label>
									<input type="text" class="form-control" name="products[<?php echo $i?>][det][<?php echo $har?>][pinjaman]" value="<?php echo $pinjaman==null?0:$pinjaman?>" readonly> -->
								</td>
								<td>
									<input type="hidden" name="products[<?php echo $i?>][k<?php echo strtolower(hari($hari))?>]" value="Mesin <?php foreach($jm as $j){?><?php echo $j['mesin'] ?> <?php echo $j['shift'] ?>,<?php } ?>">
									<input type="text" name="products[<?php echo $i?>][det][<?php echo $har?>][keterangan]" value="Mesin <?php foreach($jm as $j){?><?php echo $j['mesin'] ?> <?php echo $j['shift'] ?>,<?php } ?>">

									<input type="hidden" name="products[<?php echo $i?>][det][<?php echo $har?>][shift]" value="<?php echo $shift['shift']=="Pagi"?1:2;?>">

									<input type="hidden" name="products[<?php echo $i?>][det][<?php echo $har?>][mandor]" value="<?php echo $shift['mandor']?>">
									<?php echo $shift['mandor']?>
								</td>
							</tr>

						<?php $har++; }?>
						<!-- <tr>
							<td colspan="2" align="center"><b>Total</b></td>
							<td></td>
							<td align="right"><input style="text-align: left;" type="number" name="products[<?php echo $i?>][lemburs]" value="<?php echo $h['bonus']?>" class="form-control"></td>
							<td>
								<input style="text-align: left;" type="number" name="products[<?php echo $i?>][um]" value="<?php echo $h['um']?>" class="form-control">
								<input type="hidden" name="products[<?php echo $i?>][kum]" value="-">
							</td>
						</tr>
						<tr>
							<tr>
								<td colspan="2" align="center"><b>Total Gaji</b></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
						</tr> -->
					</thead>
				</table>
				</div>
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