<!-- Start Page content -->
<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">

                <div class="card-box">
                   <form action="<?php echo BASEURL.'masterdata/namapoTambahOnCreate' ?>" method="POST">
                        <div class="form-group">
                        	<label>Kode PO</label>
                        	<input type="text" class="form-control" name="nama_jenis_po" required>
                        </div>
                        <div class="form-group">
                            <label>Jenis</label>
                            <select name="idjenis" class="form-control" required="required">
                                <option value="1">Pilih</option>
                                <option value="1">Kemeja</option>
                                <option value="2">Kaos</option>
                                <option value="3">Celana</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Kode Artikel</label>
                            <input type="text" value="0" class="form-control" name="artikel_jenis_po" required>
                        </div>
                        <button type="submit" class="btn btn-info btn-sm text-white">Simpan</button>
                   </form>

                </div>

            </div>

        </div>
        <!-- end row -->

    </div> <!-- container -->

</div> <!-- content -->
