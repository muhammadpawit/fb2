
    <form action="<?php echo $action ?>" method="POST">
    <input type="hidden" value="<?php echo $details['id']?>" name="id">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="">Dari DZ</label>
                <input type="text" class="form-control" name="dz1" value="<?php echo $details['dz1']?>" required autocomplete="off">
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="">Sampai DZ</label>
                <input type="text" class="form-control" name="dz2" value="<?php echo $details['dz2']?>" required autocomplete="off">
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="">Harga Lama</label>
                <input type="text" class="form-control" name="harga_lama" value="<?php echo $details['harga_lama']?>" required autocomplete="off" readonly>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="">Harga Baru</label>
                <input type="text" class="form-control" name="harga" value="<?php echo $details['harga']?>" required autocomplete="off">
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="">Keterangan</label>
                <input type="text" class="form-control" name="keterangan" value="<?php echo $details['keterangan']?>" required>
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