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
                    <h4 class="m-t-0 header-title">Pengecekak Potongan Akhir</h4>
                    <p>Pengecekan akhir potongan kaos kirim CMT Jahit</p>
                   <div class="row">
                       <div class="col-12 mb-2 text-right">
                           <!-- <a href="<?php //echo BASEURL.'kelolapo/formpengecekanpotongan' ?>" class="btn btn-primary">Tambah</a> -->
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
                            <th>Tanggal</th>
                            <th>Nama PO</th>
                            <th>Kode PO</th>
                            <th>Qty(Dz)</th>
                            <th>Qty(Pcs)</th>
                            <th>Progress</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                                <?php foreach ($kelola as $key => $sat): ?>
                            <tr>
                                <td><?php echo $sat['created_date'] ?></td>
                                <td><?php echo $sat['nama_po'] ?></td>
                                <td><?php echo $sat['kode_po'] ?></td>
                                <td><?php echo $sat['hasil_lusinan_potongan'] ?></td>
                                <td><?php echo $sat['hasil_pieces_potongan'] ?></td>
                                <td><?php echo $sat['progress_lokasi'] ?></td>
                                <td class="right">
                                    <?php foreach ($sat['action'] as $action) { ?>
                                        <a href="<?php echo $action['href']; ?>" class="badge badge-info waves-light waves-effect"><?php echo $action['text']; ?></a><br>
                                    <?php } ?>
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
