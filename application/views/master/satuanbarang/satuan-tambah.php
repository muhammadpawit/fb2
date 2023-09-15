<!-- Start Page content -->
<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">

                <div class="card-box">
                    <h4 class="header-title m-t-0 m-b-20">Tambah Satuan Barang</h4>
                    <hr>
                   <form action="<?php echo BASEURL.'masterdata/satuanbarangOnCreate' ?>" method="POST">
                        <div class="form-group">
                        	<label>Nama Satuan</label>
                        	<input type="text" class="form-control" name="nama" required>
                        </div>
                        <div class="form-group">
                            <label>Kode Satuan</label>
                            <input type="text" class="form-control" name="kodeSatuan" required>
                        </div>
                        <button type="submit" class="btn btn-primary">SUBMIT</button>
                   </form>

                </div>

            </div>

        </div>
        <!-- end row -->

    </div> <!-- container -->

</div> <!-- content -->
