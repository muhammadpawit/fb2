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
		<div class="form-group">
			<label>Tanggal Awal</label>
			<input type="date" name="tanggal1" id="tanggal1" class="form-control">
		</div>
	</div>
	<div class="col-md-3">
		<div class="form-group">
			<label>Tanggal Akhir</label>
			<input type="date" name="tanggal2" id="tanggal2" class="form-control">
		</div>
	</div>
	<div class="col-md-3">
		<div class="form-group">
			<label>CMT</label>
			<select name="cmt" class="form-control select2bs4" id="cmt" data-live-search="true">
				<option value="*">Semua</option>
				<?php foreach($cmt as $c){?>
					<option value="<?php echo $c['id_cmt']?>"><?php echo $c['cmt_name']?></option>
				<?php } ?>
			</select>
		</div>
	</div>
	<div class="col-md-3">
		<div class="form-group">
			<label>Action</label><br>
			<button class="btn btn-info btn-sm">filter</button>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<table class="table table-bordered" id="datatabless">
			<thead>
				<tr>
					<th>No</th>
					<th>Nama cmt</th>
					<th>Jumlah PO</th>
					<th>Jumlah PCS</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php if(isset($products)){?>
					<?php foreach($products as $p){?>
						<tr>
							<td><?php echo $p['no']?></td>
							<td><?php echo $p['nama']?></td>
							<td><?php echo $p['jumlah']?></td>
							<td><?php echo $p['pcs']?></td>
							<td>
								<a href="<?php echo $p['rincian']?>" class="btn btn-info btn-sm text-white">rincian</a>
								<a href="<?php echo $p['excel']?>" class="btn btn-info btn-sm text-white">excel</a>
							</td>
						</tr>
					<?php } ?>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>