<!-- DataTables -->
<link href="<?php echo PLUGINS ?>datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo PLUGINS ?>datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<!-- Responsive datatable examples -->
<link href="<?php echo PLUGINS ?>datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />    
<div class="content">
    <div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Setoran CMT</h4>
                        <div class="sub-header">
                        	<span class="pull-right"><a href="<?php echo $tambah?>" class="btn btn-primary">Tambah</a></span>
                        </div>
                        <div style="clear: both;margin: 5px">&nbsp;</div>
                       	<div class="table-responsive">
                            <table class="table mb-0" id="datatable">
                            	<thead>
                            		<tr>
                            			<th>#</th>
                            			<th>Nama CMT</th>
                            			<th>PO</th>
                            			<th></th>
                            		</tr>
                            	</thead>
                            	<tbody>
                            		<tr>
                            			<td></td>
                            			<td></td>
                            			<td></td>
                            			<td></td>
                            		</tr>
                            	</tbody>
                            </table>
                       	</div>
                	</div>
                </div> <!-- end card -->
            </div>
		</div>
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

        $('#datatable').DataTable();
      
    } );
</script>