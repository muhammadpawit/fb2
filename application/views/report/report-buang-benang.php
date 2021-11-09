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
                    <form action="<?php echo BASEURL.'report/buangbenang' ?>" method="GET">
                        <div class="row mb-4">
                            <div class="col-4">
                                <label>Karyawan Benang</label>
                                <select class="form-control" name="karyawan">
                                    <?php foreach ($karyawan as $key => $op): ?>
                                        <option value="<?php echo $op['id_master_karyawan_benang'] ?>"><?php echo $op['nama_karyawan_benang'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="col-4">
                            <button class="btn btn-info mt-4">SUBMIT</button>
                            </div>
                        </div>
                    </form>
                    <table id="datatable-buttons" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Nama Po</th>
                            <th>Bagian Yang</th>
                            <th>Size</th>
                            <th>Qty</th>
                            <th>H</th>
                            <th>Keterangan</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($benang as $key => $bod): ?>
                       <tr>
                            <td><?php echo $bod['created_date'] ?></td>
                            <td><?php echo $bod['nama_po'].$bod['kode_po'] ?></td>
                            <td><?php echo $bod['bagian_buang_benang'] ?></td>
                            <td><?php echo $bod['size_buang_benang'] ?></td>
                            <td><?php echo $bod['qty_buang_benang'] ?></td>
                            <td><?php echo $bod['harga_buang_benan'] ?></td>
                            <td><?php echo $bod['keterangan_buang_benang'] ?></td>
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
