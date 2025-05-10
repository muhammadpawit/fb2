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
    <div class="col-md-12">
        <div class="form-group text-right">
        <a href="<?php echo BASEURL.'masterdata/satuanbarangTambah' ?>" class="btn btn-primary">Tambah</a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
                    <table id="datatable" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>NAMA SATUAN</th>
                            <th>KODE SATUAN BARANG</th>
                            <th>TANGGAL DIBUAT</th>
                            <th>ACTION</th>
                        </tr>
                        </thead>
                        <tbody>
                                <?php foreach ($satuan as $key => $sat): ?>
                            <tr>
                                <td><?php echo $sat['nama_satuan_barang'] ?></td>
                                <td><?php echo $sat['kode_satuan_barang'] ?></td>
                                <td><?php echo $sat['created_date'] ?></td>
                                <th>
                                    <a href="<?php echo BASEURL.'masterdata/satuanbarangEdit/'.$sat['id_satuan_barang'] ?>" class="btn btn-warning btn-xs"> Edit</a>
                                    <a href="<?php echo BASEURL.'masterdata/satuanDelete/'.$sat['id_satuan_barang'] ?>" class="btn btn-danger btn-xs" onclick="return confirm('Apakah yakin akan menghapus data ini?')">Hapus</a>
                                </th>
                            </tr>
                                <?php endforeach ?>
                        </tbody>
                    </table>
    </div>
</div>