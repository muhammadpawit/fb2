<!-- Start Page content -->
<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">

                <div class="card-box">
                    <h4 class="header-title m-t-0 m-b-20">Edit Jenis Po</h4>
                    <hr>
                   <form action="<?php echo BASEURL.'master/jenispoOnChange/'.$jenis['id_jenis_po'] ?>" method="POST">
                        <div class="form-group">
                        	<label>Kode</label>
                        	<input type="text" class="form-control" name="kode" value="<?php echo $jenis['kode_jenis_po'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Nama Jenis PO</label>
                            <input type="text" class="form-control" name="namajenis" value="<?php echo $jenis['nama_jenis_po'] ?>" required>
                        </div>
                        <div class="form-group">
                        	<label>Status </label>
                        	<select class="form-control" name="status" required>
                        		<option value="1"<?php if ($jenis['status'] == 1) { echo 'selected="selected"';} ?>>Active</option>
                        		<option value="0"  <?php if ($jenis['status'] == 0) { echo 'selected="selected"';} ?>>Non Active</option>
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
