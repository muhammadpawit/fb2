<link href="<?php echo PLUGINS ?>bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" />

<!-- Start Page content -->
<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">

                <div class="card-box">
                    <h4 class="header-title m-t-0 m-b-20">Tambah PO</h4>
                    <hr>
                   <form action="<?php echo BASEURL.'alokasi/editAlokasiAct/'.$alokasi['id_alokasi'] ?>" method="POST">
                        <div class="form-group">
                        	<label>Nama PO</label>
                        	<select class="selectpicker form-control" name="namaPo" required data-size="5" data-live-search="true" data-title="Pilin Nama Po" required>
                        		<?php foreach ($namaPo as $key => $po): ?>
                        			<option <?php if ($po['nama_jenis_po'] == $alokasi['nama_jenis_po']) {
                                        echo "selected='selected'";
                                    } ?> value="<?php echo $po['nama_jenis_po'] ?>"><?php echo $po['nama_jenis_po'] ?></option>
                        		<?php endforeach ?>
                        	</select>
                        </div>
                        <div class="form-group">
                            <label>Size PO</label>
                            <select class="selectpicker form-control" name="size" data-size="5" data-live-search="true" data-title="Pilin Size" required>
                        	<?php foreach ($size as $key => $sz): ?>
                        		<option <?php if ($sz['id_master_size'] == $alokasi['id_master_size']) {
                                        echo "selected='selected'";
                                    } ?> value="<?php echo $sz['id_master_size'] ?>"><?php echo $sz['nama_size'] ?></option>
                        	<?php endforeach ?>	
                        	</select>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">SUBMIT</button>
                   </form>

                </div>

            </div>

        </div>
        <!-- end row -->

    </div> <!-- container -->

</div> <!-- content -->
 <script src="<?php echo PLUGINS ?>bootstrap-select/js/bootstrap-select.js" type="text/javascript"></script>
