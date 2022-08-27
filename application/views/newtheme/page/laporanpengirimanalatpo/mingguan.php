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
			<button class="btn btn-info btn-sm" onclick="excelwithtgl()">Excel</button>
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