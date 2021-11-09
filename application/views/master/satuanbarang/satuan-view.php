<!-- Start Page content -->
<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card-box table-responsive">
                    <h4 class="m-t-0 header-title">Satuan Barang</h4>
                   <div class="row">
                       <div class="col-12 mb-2 text-right">
                           <a href="<?php echo BASEURL.'masterdata/satuanbarangTambah' ?>" class="btn btn-primary">Tambah</a>
                       </div>
                   </div>
                   <p class="text-muted font-14 m-b-30">
                    <?php if ($this->session->flashdata('msg')) { ?>
                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                           <?php echo $this->session->flashdata('msg'); ?> 
                    </div>
                       <?php } ?>
                    </p>

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
                                    <a href="<?php echo BASEURL.'master/satuanbarangEdit/'.$sat['id_satuan_barang'] ?>" class="btn btn-custom"> EDIT</a>
                                    <a href="<?php echo BASEURL.'master/satuanDelete/'.$sat['id_satuan_barang'] ?>" class="btn btn-danger"> DELETE</a>
                                </th>
                            </tr>
                                <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div> <!-- end row -->

    </div>
</div>