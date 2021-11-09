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
                    <h4 class="m-t-0 header-title">URL MENU</h4>
                   <div class="row">
                       <div class="col-12 mb-2 text-right">
                           <a href="<?php echo BASEURL.'menu/tambah' ?>" class="btn btn-primary">Tambah</a>
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
                            <th>NAMA MENU</th>
                            <th>URL</th>
                            <th>ICON</th>
                            <th>ID PARENT</th>
                            <th>ID CHILD</th>
                            <th>ACTION</th>
                        </tr>
                        </thead>
                        <tbody>
                                <?php foreach ($menu as $key => $men): ?>
                            <tr>
                                <td><?php echo $men['nama_menu'] ?></td>
                                <td><?php echo $men['url_menu'] ?></td>
                                <td><?php echo $men['icon_menu'] ?></td>
                                <td><?php echo $men['parent_menu'] ?></td>
                                <td><?php echo $men['child_menu'] ?></td>
                                <th>
                                    <a href="<?php echo BASEURL.'menu/edit/'.$men['id_master_menu'] ?>" class="btn btn-custom"> Tambahkan Child</a>
                                    <a href="<?php echo BASEURL.'menu/delete/'.$men['id_master_menu'] ?>" class="btn btn-danger"> DELETE</a>
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

            //Buttons examples
            var table = $('#datatable-buttons').DataTable({
                lengthChange: false,
                buttons: ['copy', 'excel', 'pdf']
            });

            // Key Tables

            $('#key-table').DataTable({
                keys: true
            });

            // Responsive Datatable
            $('#responsive-datatable').DataTable();

            // Multi Selection Datatable
            $('#selection-datatable').DataTable({
                select: {
                    style: 'multi'
                }
            });

            table.buttons().container()
                    .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
        } );

    </script>
