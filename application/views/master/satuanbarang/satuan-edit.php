<!-- Start Page content -->
<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">

                <div class="card-box">
                    <h4 class="header-title m-t-0 m-b-20">Edit Satuan Barang</h4>
                    <hr>
                   <form action="<?php echo BASEURL.'master/satuanbarangOnChange/'.$satuan['id_satuan_barang'] ?>" method="POST">
                        <div class="form-group">
                        	<label>Nama Satuan</label>
                        	<input type="text" class="form-control" name="nama" value="<?php echo $satuan['nama_satuan_barang'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Kode Satuan</label>
                            <input type="text" class="form-control" name="kodeSatuan" value="<?php echo $satuan['kode_satuan_barang'] ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary">SUBMIT</button>
                   </form>

                </div>

            </div>

        </div>
        <!-- end row -->

    </div> <!-- container -->

</div> <!-- content -->
