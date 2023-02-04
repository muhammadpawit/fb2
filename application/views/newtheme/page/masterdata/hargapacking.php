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
							<tr>
								<td><?php echo $p['nama']?></td>
								<td>
									<input type="hidden" value="<?php echo $p['id']?>" name="products[<?php echo $p['no']?>][id]">
									<input type="number" value="<?php echo $p['harga']?>" name="products[<?php echo $p['no']?>][harga]">&nbsp;<?php echo $p['sat']?>
								</td>
							</tr>
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