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
                    <form action="<?php echo BASEURL.'report/bordir' ?>" method="GET">
                        <div class="row mb-4">
                            <div class="col-2">
                                    <label>Nomer Mesin</label>
                                <select class="form-control" name="mesin">
                                    <?php foreach ($mesin as $key => $mes): ?>
                                        <option value="<?php echo $mes['nomer_mesin'] ?>"><?php echo $mes['nomer_mesin'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="col-4">
                                <label>Karyawan Bordir</label>
                                <select class="form-control" name="operator">
                                    <?php foreach ($operator as $key => $op): ?>
                                        <option value="<?php echo $op['id_master_karyawan_bordir'] ?>"><?php echo $op['nama_karyawan_bordir'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="col-4">
                            <button class="btn btn-info mt-4">SUBMIT</button>
                            </div>
                        </div>
                    </form>

                    <form action="<?php echo BASEURL.'report/bordir' ?>" method="GET">
                        <div class="row mb-4">
                            <div class="col-2">
                                    <label>Tanggal Mulai</label>
                                <input type="date" class="form-control" name="tanggalMulai">
                            </div>
                            <div class="col-4">
                                <label>Tanggal Akhir</label>
                                <input type="date" class="form-control" name="tanggalEnd">
                            </div>
                            <div class="col-4">
                            <button class="btn btn-info mt-4">SUBMIT</button>
                            </div>
                        </div>
                    </form>

                    <table id="datatable-buttons" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Nama Po</th>
                            <th>Tanggal Masuk</th>
                            <th>Yang Di Bordir</th>
                            <th>Size</th>
                            <th>Stich</th>
                            <th>Qty</th>
                            <th>Total Stich</th>
                            <th>Tarif</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($bordir as $key => $bod): ?>
                        <tr>
                            <td><?php echo $bod['nama_po'].$bod['kode_po'] ?></td>
                            <td><?php echo $bod['created_date'] ?></td>
                            <td><?php echo $bod['bagian_bordir'] ?></td>
                            <td><?php echo $bod['size'] ?></td>
                            <td><?php echo $bod['stich'] ?></td>
                            <td><?php echo $bod['jumlah_naik_mesin'] ?></td>
                            <td><?php echo number_format($bod['total_stich']) ?></td>
                            <td><?php echo number_format($bod['total_tarif']) ?></td>
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

<!-- Buttons examples -->
<script src="<?php echo PLUGINS ?>datatables/dataTables.buttons.min.js"></script>
<script src="<?php echo PLUGINS ?>datatables/buttons.bootstrap4.min.js"></script>
<script src="<?php echo PLUGINS ?>datatables/jszip.min.js"></script>
<script src="<?php echo PLUGINS ?>datatables/pdfmake.min.js"></script>
<script src="<?php echo PLUGINS ?>datatables/vfs_fonts.js"></script>
<script src="<?php echo PLUGINS ?>datatables/buttons.html5.min.js"></script>
<script src="<?php echo PLUGINS ?>datatables/buttons.print.min.js"></script>

<!-- Responsive examples -->
<script src="<?php echo PLUGINS ?>datatables/dataTables.responsive.min.js"></script>
<script src="<?php echo PLUGINS ?>datatables/responsive.bootstrap4.min.js"></script>
<script type="text/javascript">
        $(document).ready(function() {

            //Buttons examples
            var table = $('#datatable-buttons').DataTable({
                lengthChange: false,
                buttons: ['copy', 'excel', 'pdf']
            });
            table.buttons().container()
                    .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
        } );

    </script>
