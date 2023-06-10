<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h4 class="modal-title">Tambah Transaksi Baru</h4>
      </div>
      <div class="modal-body">
        <form method="post" action="<?php echo $action?>">
          <div class="form-group">
            <label>Tanggal</label>
            <input type="date" name="tanggal" value="<?php echo date('Y-m-d') ?>" class="form-control" required="required">
          </div>
          <div class="form-group">
            <label>Type</label>
            <select name="type" class="form-control" required>
                <option value=""></option>
                <option value="1">Claim</option>
                <option value="2">Kasbon</option>
            </select>
          </div>
          <div class="form-group">
            <label>Nama CMT</label>
            <select name="idcmt" class="form-control" required>
                <option value=""></option>
                <?php foreach($cm as $c){?>
                <option value="<?php echo $c['id_cmt']?>"><?php echo $c['cmt_name']?></option>
                <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label>Nominal</label>
            <input type="number" name="nominal" autocomplete="off" class="form-control" required="required">
          </div>
          <div class="form-group">
            <label>Keterangan</label>
            <textarea class="form-control" required="required" name="keterangan"></textarea>
          </div>
          <button type="submit" class="btn btn-info">Simpan</button>
          <a class="btn btn-danger text-white" data-dismiss="modal">Batal</a>
        </form>
      </div>
      <div class="modal-footer">
        
      </div>
    </div>

  </div>
</div> 

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
			<input type="text" name="tanggal2" id="tanggal2" autocomplete="off" value="<?php echo $tanggal2?>" class="form-control">
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label>Aksi</label><br>
			<button class="btn btn-info btn-sm" onclick="filtertglonly()">Filter</button>
			<span class=""><button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Tambah</button></span>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
    <table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tanggal</th>
            <th>IDCMT</th>
            <th>Kode PO</th>
            <th>Harga</th>
            <th>Quantity</th>
            <th>Satuan</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($prods as $data): ?>
        <tr>
            <td><?php echo $data['id']; ?></td>
            <td><?php echo $data['tanggal']; ?></td>
            <td><?php echo $data['idcmt']; ?></td>
            <td><?php echo $data['kode_po']; ?></td>
            <td><?php echo $data['harga']; ?></td>
            <td><?php echo $data['quantity']; ?></td>
            <td><?php echo $data['satuan']; ?></td>
            <td><?php echo $data['keterangan']; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
	</div>
</div>