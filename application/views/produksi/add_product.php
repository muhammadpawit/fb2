<!-- DataTables -->
<link href="<?php echo PLUGINS ?>datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo PLUGINS ?>datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<!-- Responsive datatable examples -->
<link href="<?php echo PLUGINS ?>datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />    
<div class="content">
    <div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="card-box table-responsive">
					<h4 class="m-t-0 header-title">Tambah Produk</h4>
					<div class="row">
                       <div class="col-12 mb-2 text-right">
                           <a onclick="cancel()" class="btn btn-danger">Cancel</a>
                           <a onclick="simpan()" class="btn btn-primary">Simpan</a>
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
                   <table class="table">
                   	
                   </table>
				</div>
			</div>
		</div>
	</div>
	
</div>

<script type="text/javascript">
  function simpan(){
    const c=confirm("Apakah yakin akan menyimpan?");
    if(c==true){
      alert("Working !");
    }else{
      return false;
    }
    
  }
  function cancel(){
    const url='<?php echo $url?>';
    window.location.replace(url);
  }
</script>

<!-- Required datatable js -->
<script src="<?php echo PLUGINS ?>datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo PLUGINS ?>datatables/dataTables.bootstrap4.min.js"></script>
<!-- Responsive examples -->
<script src="<?php echo PLUGINS ?>datatables/dataTables.responsive.min.js"></script>
<script src="<?php echo PLUGINS ?>datatables/responsive.bootstrap4.min.js"></script>
<script type="text/javascript">