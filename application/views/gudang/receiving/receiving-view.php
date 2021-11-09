<!-- DataTables -->
<link href="<?php echo PLUGINS ?>datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo PLUGINS ?>datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<!-- Responsive datatable examples -->
<link href="<?php echo PLUGINS ?>datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />    

<!-- Start Page content -->
<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card-box table-responsive">
                    <h4 class="m-t-0 header-title">Item Masuk</h4>
                   <div class="row">
                       <div class="col-12 mb-2 text-right">
                           <a href="<?php echo BASEURL.'gudang/itemmasuktambah' ?>" class="btn btn-primary">Tambah</a>
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
                            <th>KODE TF</th>
                            <th>NAMA SUPPLIER</th>
                           <!--  <th>NAMA BARANG</th>
                            <th>WARNA</th>
                            <th>UKURAN</th>
                            <th>JUMLAH</th> -->
                            <th>TANGGAL</th>
                            <th>ACTION</th>
                        </tr>
                        </thead>
                        <tbody>
                                <?php foreach ($item as $key => $sat): ?>
                            <tr>
                                <td><?php echo $sat['kode_transfer'] ?></td>
                                <td><?php echo $sat['nama_supplier'] ?></td>
                                <!-- <td><?php// echo $sat['nama_item_masuk'] ?></td> -->
                                <!-- <td><button style="background-color: <?php// echo $sat['warna_item_masuk'] ?>" class="btn"></button> <?php// echo $sat['warna_item_masuk'] ?></td>
                                <td><?php// echo $sat['ukuran_item_masuk'] ?>
                                    <?php// echo $sat['satuan_item_masuk'] ?>
                                </td>
                                <td><?php// echo $sat['jumlah_item_masuk'] ?> <?php// echo $sat['satuan_jumlah_item'] ?></td> -->
                                <td><?php echo $sat['created_date'] ?></td>
                                <td>
                                    <a href="<?php echo BASEURL.'gudang/itemmasukedit/'.$sat['kode_transfer'] ?>" class="btn btn-custom"> EDIT</a>
                                </td>
                            </tr>
                                <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div> <!-- end row -->

    </div>
</div>
        <!-- Required datatable js -->
<script src="<?php echo PLUGINS ?>datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo PLUGINS ?>datatables/dataTables.bootstrap4.min.js"></script>
<!-- Responsive examples -->
<script src="<?php echo PLUGINS ?>datatables/dataTables.responsive.min.js"></script>
<script src="<?php echo PLUGINS ?>datatables/responsive.bootstrap4.min.js"></script>
<script type="text/javascript">
        $(document).ready(function() {

            // Default Datatable
            $('#datatable').DataTable();

          
        } );

    </script>
