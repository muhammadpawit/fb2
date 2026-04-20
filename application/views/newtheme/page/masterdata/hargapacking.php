
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h4 class="modal-title">Tambah Harga <?php echo isset($halaman)?$halaman:'' ?> Baru</h4>
      </div>
      <div class="modal-body">
		<form method="post" action="<?php echo $simpanharga?>">
			<input type="hidden" name="page" value="<?php echo isset($halaman)?$halaman:''; ?>">
			<div class="form-group">
				<label>Jenis PO</label>
				<select name="id" class="form-control select2bs4" style="width:100%">
				<option value="">Pilih</option>
				<?php foreach($products as $c) { ?>
					<?php if( strtolower($c['harga']) == 0 ){?>
					<option value="<?php echo $c['id']?>"><?php echo $c['nama']?> </option>
					<?php } ?>
				<?php } ?>
				</select>
			</div>
			<div class="form-group">
				<label>Harga</label>
				<input type="number" name="harga" class="form-control" required="required">
			</div>
			<div class="form-group">
				 <button type="submit" class="btn btn-info">Simpan</button>
          		<a class="btn btn-danger text-white" data-dismiss="modal">Batal</a>
			</div>
		</form>
      </div>
      <div class="modal-footer">
        
      </div>
    </div>

  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <p class="text-muted font-14 m-b-30">
        <?php if ($this->session->flashdata('msg')) { ?>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
            <?php echo $this->session->flashdata('msg'); ?>
          </div>
        <?php } ?>
      </p>
  </div>
</div>
<div class="row">
  <div class="col-md-4">
    <div class="form-group">
        <span class=""><button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i>&nbsp;Tambah</button></span>
    </div>
  </div>
</div>
<form method="post" action="<?php echo $update?>">
	<input type="hidden" name="page" value="<?php echo isset($halaman)?$halaman:''; ?>">
	<div class="row">
		<div class="col-md-12">
			<div class="table-responsive">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>Jenis PO</th>
							<th>Harga / Biaya </th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($products as $p){?>
							<?php if($p['harga']>0){?>
								<tr>
									<td><?php echo $p['nama']?></td>
									<td>
										<input type="hidden" value="<?php echo $p['id']?>" name="products[<?php echo $p['no']?>][id]">
										<input type="number" value="<?php echo $p['harga']?>" name="products[<?php echo $p['no']?>][harga]">&nbsp;<?php echo $p['sat']?>
									</td>
								</tr>
							<?php } ?>
						<?php } ?>
					</tbody>
				</table>
			</div>	
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<button type="submit" class="btn btn-sm full btn-info">Simpan</button>
			</div>
		</div>
	</div>
</form>