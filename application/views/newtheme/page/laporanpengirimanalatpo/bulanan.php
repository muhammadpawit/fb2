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
			<label>Bulan</label>
			<select name="bulan" id="bulan" class="form-control select2bs4">
				<option value="*">Semua</option>
				<?php foreach(bulan() as $b=>$val){?>
					<option value="<?php echo $b?>" <?php echo $b==$bulan?'selected':'';?>><?php echo $val?></option>
				<?php } ?>
			</select>
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label>Tahun</label>
			<select name="tahun" id="tahun" class="form-control select2bs4">
				<option value="*">Semua</option>
				<?php for($i=2021;$i<=2045;$i++){?>
					<option value="<?php echo $i?>" <?php echo $i==$tahun?'selected':'';?>><?php echo $i?></option>
				<?php } ?>
			</select>
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label>Aksi</label><br>
			<button class="btn btn-info btn-sm" onclick="filterbulan()">Filter</button>
			<button class="btn btn-info btn-sm" onclick="excelwithbulan()">Excel</button>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<?php if(isset($tanggal1)){ ?>
			<caption>Periode : <?php echo date('d',strtotime($tanggal1)) ?> - <?php echo date(' d F Y',strtotime($tanggal2)) ?></caption>
			<span style="float: right"><b>Update Terakhir : <?php echo $update ?></b></span>
		<?php } ?>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>No</th>
					<th>Nama</th>
					<th>Alamat</th>
					<th>Nama PO</th>
					<th>Jumlah PO</th>
				</tr>
			</thead>
			<tbody>
				<?php $no=1;$totalpo=0; ?>
				<?php foreach($results as $r){?>
					<tr>
						<td><?php echo $no ?></td>
						<td><?php echo $r['nama'] ?></td>
						<td><?php echo $r['alamat'] ?></td>
						<td>
							<?php 
								$str =str_replace(",", ", ", $r['po']);
								echo wordwrap($str,140,"<br>\n");
							?>	
						</td>
						<td align="center"><?php echo $r['jumlah'] ?></td>
					</tr>
					<?php 
						$totalpo+=($r['jumlah']);
					?>
					<?php $no++; ?>
				<?php } ?>
				<tr>
					<td colspan="4" align="center"><b>Total PO</b></td>
					<td align="center"><b><?php echo $totalpo ?></b></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<script type="text/javascript">
	function excelwithbulan(){
	    var url='?';
	    var tanggal1 =$("#bulan").val();
	    var tanggal2 =$("#tahun").val();
	    if(tanggal1){
	      url+='&bulan='+tanggal1;
	    }
	    if(tanggal2){
	      url+='&tahun='+tanggal2;
	    }
	    location =url;
	  }
</script>