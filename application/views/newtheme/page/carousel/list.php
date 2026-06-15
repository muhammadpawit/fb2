<div class="row">
  <div class="col-md-12">
    <?php if ($this->session->flashdata('msg')) { ?>
    <div class="alert alert-success alert-dismissible" role="alert">
      	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<?php echo $this->session->flashdata('msg'); ?> 
    </div>
    <?php } ?>
  </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group text-right">
            <a href="<?php echo $tambah?>" class="btn btn-primary btn-sm">Tambah Slide</a>
        </div>
        <div class="box">
            <div class="box-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Gambar</th>
                            <th>Alt Text (Deskripsi)</th>
                            <th>Urutan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach($products as $p){?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td>
                                <?php if(!empty($p['image'])){?>
                                <img src="<?php echo BASEURL.'assets/images/carousel/'.$p['image']?>" style="width: 150px;">
                                <?php } ?>
                            </td>
                            <td><?php echo $p['alt_text']?></td>
                            <td><?php echo $p['urutan']?></td>
                            <td>
                                <?php if($p['status']==1){?>
                                    <span class="label label-success">Aktif</span>
                                <?php }else{?>
                                    <span class="label label-danger">Tidak Aktif</span>
                                <?php }?>
                            </td>
                            <td>
                                <a href="<?php echo BASEURL.'Carousel/edit/'.$p['id']?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="<?php echo BASEURL.'Carousel/hapus/'.$p['id']?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
