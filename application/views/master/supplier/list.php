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
            <a href="<?php echo $tambah?>" class="btn btn-info btn-sm text-white">Tambah</a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
                            <table class="table table-bordered yessearch">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Kategori</th>
                                        <th>Nama Supplier</th>
                                        <th>Telephone</th>
                                        <th>PIC</th>
                                        <th>Alamat</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if($hasil){?>
                                    <?php foreach($hasil as $h){?>
                                    <tr>
                                        <td><?php echo $n++?></td>
                                        <td>
                                            <?php 

                                                if($h['kategori']==1){
                                                    echo 'Konveksi';
                                                }else if($h['kategori']==2){
                                                    echo 'Bordir';
                                                }else if($h['kategori']==3){
                                                    echo 'Sablon';
                                                }else if($h['kategori']==4){
                                                    echo 'Bahan';
                                                }else{
                                                    echo 'Belum Disetting';
                                                }
                                            
                                            ?>
                                        </td>
                                        <td><?php echo $h['nama']?></td>
                                        <td><?php echo $h['telephone']?></td>
                                        <td><?php echo $h['pic']?></td>
                                        <td><?php echo $h['alamat']?></td>
                                        <td>
                                            <a href="<?php echo $h['edit']?>" class="btn btn-xs btn-warning text-white">Edit</a>
                                            <a href="<?php echo $h['hapus']?>" class="btn btn-xs btn-danger text-white">Hapus</a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                    <?php } ?>
                                </tbody>
                            </table>
    </div>
</div>