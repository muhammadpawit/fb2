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
                    <h4 class="m-t-0 header-title">Produksi PO</h4>
                   <div class="row">
                       <div class="col-12 mb-2 text-right">
                           <a href="<?php echo BASEURL.'finishing/boronganmesin' ?>" class="btn btn-primary">Tambah</a>
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
                    <form method="GET" action="<?php echo BASEURL.'finishing/viewboronganmesin' ?>">
                    	<div class="form-group">
                    		<label>Tanggal Mulai</label>
                    		<input type="date" class="form-control" required name="tanggalMulai">
                    	</div>
                    	<div class="form-group">
                    		<label>Tanggal Mulai</label>
                    		<input type="date" class="form-control" required name="tanggalAkhir">
                    	</div>
                    	<button class="btn btn-info" type="submit">SUBMIT</button>
                    </form>
                    	<br>
                    <table id="datatable-buttons" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>NAMA PO</th>
                            <th>JUMLAH PCS</th>
                            <th>JUMLAH TITIK</th>
                            <th>HARGA PERTITIK</th>
                            <th>JUMLAH RP</th>
                            <th>KAT</th>
                            <th>KET</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $key => $dat): ?>
		                        <tr>
		                            <td><?php echo $dat['nama_po'] ?></td>
		                            <td><?php echo $dat['jumlah_pcs'] ?></td>
		                            <td><?php echo $dat['jumlah_titik'] ?></td>
		                            <td><?php echo $dat['harga_titik'] ?></td>
		                            <td><?php echo number_format($dat['jumlah_pendapatan'],0,',','.') ?></td>
		                            <td><?php echo $dat['keterangan'] ?></td>
		                            <td><?php echo $dat['creted_date'] ?></td>
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

