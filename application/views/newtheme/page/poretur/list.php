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
            <th>ID</th>
            <th>Jumlah</th>
            <th>ID PO</th>
            <th>Kode PO</th>
            <th>Keterangan</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($prods as $row): ?>
            <tr>
                <td><?php echo $row['no']; ?></td>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['jumlah']; ?></td>
                <td><?php echo $row['idpo']; ?></td>
                <td><?php echo $row['kode_po']; ?></td>
                <td><?php echo $row['keterangan']; ?></td>
                <td>
                    <a href="<?php echo $row['detail']; ?>">detail</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

	</div>
</div>