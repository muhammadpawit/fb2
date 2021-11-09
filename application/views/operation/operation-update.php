<!-- Start Page content -->
<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">

                <div class="card-box">
                    <h4 class="header-title m-t-0 m-b-20">Operation Update</h4>
                    <hr>
                   <form action="<?php echo BASEURL.'operational/updateAct' ?>" method="POST">
                        <div class="form-group">
                            <label>Value Operation</label>
                            <input type="text" class="form-control" name="valueOper" value="<?php echo $oper['val_operational'] ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary">SUBMIT</button>
                   </form>

                </div>

            </div>

        </div>
        <!-- end row -->

    </div> <!-- container -->

</div> <!-- content -->
