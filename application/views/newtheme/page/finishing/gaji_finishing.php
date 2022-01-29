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
	<div class="col-md-4">
		<div class="form-group">
			<label>Tanggal Awal</label>
			<input type="text" name="tanggal1" id="tanggal1" value="<?php echo $tanggal1?>" class="form-control datepicker">
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label>Tanggal Akhir</label>
			<input type="date" name="tanggal2" id="tanggal2" value="<?php echo $tanggal2?>" class="form-control datepicker">
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label>Aksi</label><br>
			<!--<a class="btn btn-info btn-sm text-white" onclick="filter()">Filter</a>-->
			<a class="btn btn-info btn-sm text-white" onclick="proses()">Proses</a>
		</div>
	</div>
</div>
<div class="row">
			<?php $i=0?>
			<?php foreach($harian as $h){?>
			<div class="col-md-6">
				<table class="table table-bordered">
					<thead>
						<tr>
							<td><input type="checkbox" name="products[<?php echo $i?>][idkaryawan]" value="<?php echo strtolower($h['id'])?>" checked>
								<input type="hidden" name="products[<?php echo $i?>][nama]" value="<?php echo strtolower($h['nama'])?>"></td>
							<th>Nama</th>
							<th colspan="4"><?php echo strtolower($h['nama'])?> (<?php echo strtolower($h['bagian'])?>)</th>
						</tr>
						<tr>
							<td><input type="checkbox" name="products[<?php echo $i?>][senin]" value="Senin" checked></td>
							<td>Senin</td>
							<td align="right"><?php echo number_format($h['gaji'])?></td>
						</tr>
						<tr>
							<td><input type="checkbox" name="products[<?php echo $i?>][selasa]" value="Selasa" checked></td>
							<td>Selasa</td>
							<td align="right"><?php echo number_format($h['gaji'])?></td>
						</tr>
						<tr>
							<td><input type="checkbox" name="products[<?php echo $i?>][rabu]" value="Rabu" checked></td>
							<td>Rabu</td>
							<td align="right"><?php echo number_format($h['gaji'])?></td>
						</tr>
						<tr>
							<td><input type="checkbox" name="products[<?php echo $i?>][kamis]" value="Kamis" checked></td>
							<td>Kamis</td>
							<td align="right"><?php echo number_format($h['gaji'])?></td>
						</tr>
						<tr>
							<td><input type="checkbox" name="products[<?php echo $i?>][jumat]" value="Jumat" checked></td>
							<td>Jum'at</td>
							<td align="right"><?php echo number_format($h['gaji'])?></td>
						</tr>
						<tr>
							<td><input type="checkbox" name="products[<?php echo $i?>][sabtu]" value="Sabtu" checked></td>
							<td>Sabtu</td>
							<td align="right"><?php echo number_format($h['gaji'])?></td>
						</tr>
						<tr>
							<td><input type="checkbox" name="products[<?php echo $i?>][minggu]" value="Minggu"></td>
							<td>Minggu</td>
							<td align="right"><?php echo number_format($h['gaji'])?></td>
						</tr>
						<tr>
							<td><input type="checkbox" name="products[<?php echo $i?>][lembur]" value="lembur"></td>
							<td>Lembur (total)</td>
							<td align="right"><input style="text-align: right;" type="number" name="products[<?php echo $i?>][lemburs]" value="<?php echo $h['lembur']?>" class="form-control"></td>
						</tr>
						<tr>
							<td><input type="checkbox" name="products[<?php echo $i?>][insentif]" value="insentif"></td>
							<td>Insentif</td>
							<td align="right"><?php echo number_format($h['gaji'])?></td>
						</tr>
						<!--
						<tr>
							<td colspan="2"><b>Total</b></td>
							<td align="right"><?php echo number_format($h['gaji']*6)?></td>
						</tr>-->
					</thead>
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
		$("form").submit();
	}
</script>