<link href="<?php echo PLUGINS ?>bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" />
<!-- Start Page content -->
<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">

                <div class="card-box">
                    <h4 class="header-title m-t-0 m-b-20">Tambah Menu</h4>
                    <hr>
                   <form action="<?php echo BASEURL.'menu/tambahAct' ?>" method="POST">
                        <div class="form-group">
                        	<label>Nama Menu</label>
                        	<input type="text" class="form-control" name="namaMenu" required>
                        </div>
                        <div class="form-group">
                            <label>Nama Url</label>
                            <input type="text" class="form-control" name="namaUrl">
                        </div>
                        <div class="form-group">
                            <label>Icon</label>
                            <input type="text" class="form-control" name="icon" required>
                        </div>
                       <!--  <div class="form-group">
                        	<label>Child Menu</label>
                        	<select class="form-control selectpicker" data-live-search="true" data-title="Pilih Parent" name="child[]" multiple>
                        		<?php //foreach ($menuChild as $key => $mn): ?>
                        			<option value="<?php// echo $mn['id_master_menu'] ?>"><?php //echo $mn['nama_menu'] ?></option>
                        		<?php //endforeach ?>
                        	</select>
                        </div> -->
                        <button type="submit" class="btn btn-primary">SUBMIT</button>
                   </form>

                </div>

            </div>

        </div>
        <!-- end row -->

    </div> <!-- container -->

</div> <!-- content -->
 <script src="<?php echo PLUGINS ?>bootstrap-select/js/bootstrap-select.js" type="text/javascript"></script>