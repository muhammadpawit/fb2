<!-- Start Page content -->
<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">

                <div class="card-box">
                    <h4 class="header-title m-t-0 m-b-20">Operational</h4>
                    <hr>
                   <form action="<?php echo BASEURL.'master/namapoTambahOnCreate' ?>" method="POST">
                        <div class="form-group">
                        	<label>ID Operational</label>
                        	<input type="text" class="form-control" name="valueOper" value="<?php echo $oper['val_operational'] ?>" required>
                        	<input type="hidden" name="id_operational" value="<?php echo $oper['id_operational'] ?>">
                        </div>
                       
                        <button type="submit" class="btn btn-primary">SUBMIT</button>
                   </form>

                </div>

            </div>

        </div>
        <!-- end row -->

    </div> <!-- container -->

</div> <!-- content -->
