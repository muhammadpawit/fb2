<form action="<?php echo $action ?>" method="POST">
<?php if(isset($prods)){ ?>
<input type="hidden" name="id" value="<?php echo $prods['id']?>">
<?php } ?>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="">Nama Serian Warna</label>
            <input type="text" name="nama" class="form-control" value="<?php echo isset($prods) ? $prods['nama']:'' ?>" autocomplete="off">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <button class="btn full btn-sm btn-success">Simpan</button>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <a href="<?php echo $batal ?>" class="btn full btn-sm btn-danger">Batal</a>
        </div>
    </div>
</div>
</form>