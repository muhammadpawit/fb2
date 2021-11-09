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
                    <h4 class="m-t-0 header-title">ALOKASI PO</h4>
                    <hr>
                   <div class="row">
                    <div class="col-12">
                        <a href="<?php echo BASEURL.'alokasi/tambahalokasi' ?>" class="btn btn-info" style="float: right;">TAMBAH</a>     
                        
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
                            <th>NAMA PO</th>
                            <th>SIZE PO</th>
                            <th>ACTION</th>
                        </tr>
                        </thead>
                        <tbody>
                                <?php foreach ($alokasi as $key => $sat): ?>
                            <tr>
                                <td><?php echo $sat['nama_jenis_po'] ?></td>
                                <td><?php echo $sat['nama_size'] ?></td>
                                <td>
                                    <a href="<?php echo BASEURL.'alokasi/editAlokasi/'.$sat['id_alokasi'] ?>" class="btn btn-info"><i class="fa fa-edit"></i></a>
                                    <a href="<?php echo BASEURL.'alokasi/insertAlokasiItem/'.$sat['id_alokasi'] ?>" class="btn btn-secondary"><i class="mdi mdi-clipboard-check"></i></a>
                                    <a href="<?php echo BASEURL.'alokasi/kalkulasiAlokasi/'.$sat['id_alokasi'] ?>" class="btn btn-warning"><i class="mdi mdi-console"></i></a>
                                    <a href="<?php echo BASEURL.'alokasi/deleteAlokasi/'.$sat['id_alokasi'] ?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                     
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
