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
        <a href="<?php echo BASEURL.'Masterdata/sizeAdd' ?>" class="btn btn-primary">Tambah</a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
                    <table class="table table-bordered yessearch">
                        <thead>
                        <tr>
                            <th>NAMA </th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                                <?php foreach ($satuan as $key => $sat): ?>
                            <tr>
                                <td><?php echo $sat['nama_size'] ?></td>
                                <td>
                                    <a href="<?php echo BASEURL.'Masterdata/sizeOnDelete/'.$sat['id_master_size']?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah yakin akan menghapus data ini ? ')">Hapus</a>
                                </td>
                               
                            </tr>
                                <?php endforeach ?>
                        </tbody>
                    </table>
    </div>
</div>