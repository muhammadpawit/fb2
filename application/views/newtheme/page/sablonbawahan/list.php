<div class="row">
  <div class="col-md-12">
    <?php if ($this->session->flashdata('msg')) { ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
     	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
        	<span aria-hidden="true">×</span>
        </button>
		<?php echo $this->session->flashdata('msg'); ?> 
    </div>
    <?php } ?>
  </div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">			
			<a href="<?php echo $tambah?>" class="btn btn-info btn-sm text-white">Tambah</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<table class="table table-striped table-bordered sablonbawahan">
			<thead>
				<tr>
					<th>No</th>
					<th>Nama PO</th>
					<th>Nama CMT</th>
					<th>Pekerjaan</th>
					<th>Harga</th>
					<th>Keterangan</th>
					<th></th>
				</tr>
			</thead>
		</table>
	</div>
</div>
<script type="text/javascript">
    $(document).ready(function () {

        $('.sablonbawahan').DataTable( {
            "ordering": false,
            "searching":true,
            "lengthChange": false,
            "ajax":'<?php echo BASEURL?>Json/bawahansablon',
        });

    });
</script>