
    <form action="<?php echo $action ?>" method="POST">
        <input type="hidden" name="id_mesin" value="<?php echo $p['id_mesin'] ?>">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="">Persentase Mesin</label>
                <input type="text" class="form-control" name="persenan" value="<?php echo $p['persenan'] ?>" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <button class="btn btn-success btn-sm full">Simpan</button>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <a href="<?php echo $cancel ?>" class="btn btn-danger btn-sm full">Batal</a>
            </div>
        </div>
    </div>      
    <form>