<!-- Start Page content -->
<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card-box table-responsive">
                    <h4 class="m-t-0 header-title">User</h4>
                   <div class="row">
                       <div class="col-12 mb-2 text-right">
                           <a href="<?php echo BASEURL.'user/tambah' ?>" class="btn btn-primary">Tambah</a>
                       </div>
                   </div>
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

                    <table id="datatable" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>NAMA USER</th>
                            <th>JABATAN</th>
                            <th>TANGGAL DIBUAT</th>
                            <th>STATUS</th>
                            <th>ACTION</th>
                        </tr>
                        </thead>
                        <tbody>
                                <?php foreach ($user as $us): ?>
                            <tr>
                                <td><?php echo $us['nama_user'] ?></td>
                                <td><?php echo $jabatan[$us['jabatan_user']] ?></td>
                                <td><?php echo $us['created_date'] ?></td>
                                <td><?php echo $us['status_user'] ?></td>
                                <td class="right"><?php foreach ($us['action'] as $action) { ?>
                           <a href="<?php echo $action['href']; ?>" class="badge badge-info waves-light waves-effect"><?php echo $action['text']; ?></a><br>
                          <?php } ?></td>
                            </tr>
                                <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div> <!-- end row -->

    </div>
</div>