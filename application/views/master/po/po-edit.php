<!-- Start Page content -->
<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">

                <div class="card-box">
                    <h4 class="header-title m-t-0 m-b-20">Edit PO</h4>
                    <hr>
                   <form action="<?php echo BASEURL.'master/namapoEditOnCreate/'.$po['id_nama_po'] ?>" method="POST">
                        <div class="form-group">
                        	<label>Kode PO</label>
                        	<input type="text" class="form-control" name="kodePO" value="<?php echo $po['kode_po'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Nama Lengkap PO</label>
                            <input type="text" class="form-control" name="namaLengkapPO" value="<?php echo $po['nama_lengkap_po'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Kode Artikel</label>
                            <input type="text" class="form-control" name="kodeArtikel" value="<?php echo $po['kode_artikel'] ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary">SUBMIT</button>
                   </form>

                </div>

            </div>

        </div>
        <!-- end row -->

    </div> <!-- container -->

</div> <!-- content -->
