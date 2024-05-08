
    <form action="<?php echo $action ?>" method="POST">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="">Nama Model</label>
                <input type="text" class="form-control" name="nama_model" required>
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