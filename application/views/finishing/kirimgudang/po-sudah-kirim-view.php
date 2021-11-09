<!-- DataTables -->
<link href="<?php echo PLUGINS ?>datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo PLUGINS ?>datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<!-- Responsive datatable examples -->
<link href="<?php echo PLUGINS ?>datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />    
 <!-- Toastr css -->
<link href="<?php echo PLUGINS ?>jquery-toastr/jquery.toast.min.css" rel="stylesheet" />
<!-- Start Page content -->
<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card-box table-responsive">
                    <h4 class="m-t-0 header-title">PO YANG SUDAH DI KIRIM GUDANG</h4>

                    <table id="datatable" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>NAMA PO</th>
                            <th>KODE PO</th>
                            <th>PROGRES</th>
                            <th>CREATED</th>
                            <th>ACTION</th>
                        </tr>
                        </thead>
                        <tbody>
                                <?php foreach ($kirim as $key => $sat): ?>
                            <tr>
                                <td><?php echo $sat['nama_po'] ?></td>
                                <td><?php echo $sat['kode_po'] ?></td>
                                <td>
                                    <button type="button" class="btn btn-info waves-effect waves-light btn-sm" id="toastr-one"><?php echo $sat['nama_progress'] ?></button>
                                </td>
                                <td><?php echo $sat['created_date'] ?></td>
                                <td>
                                    <a href="<?php echo BASEURL.'konveksi/produksipoedit/'.$sat['kode_po'] ?>" class="btn btn-custom"> <i class="icon-rocket"></i> SEND</a>
                                   
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

<!-- Toastr js -->
<script src="<?php echo PLUGINS ?>jquery-toastr/jquery.toast.min.js" type="text/javascript"></script>
<script src="<?php echo ASSETS ?>pages/jquery.toastr.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function() {

        // Default Datatable
        $('#datatable').DataTable();
        $("#toastr-one").click(function () {
            var headingText = $(this).text();
            $.toast({
                heading: headingText,
                text: 'CEPET DI PROSES DUNDD JANGAN LAMS LAMS, THANK YOU BRE!!<br><hr class=mb-2><strong>Click detail nya biar ingin tau aja atau tau banget YAPS :*</strong>',
                position: 'top-right',
                loaderBg: '#3b98b5',
                icon: 'info',
                hideAfter: 4000,
                stack: 1
            });
        });
      
    } );

</script>
