<div class="row">
    <div class="col-md-12">
        <form method="post" action="<?php echo $action?>" enctype="multipart/form-data">
            <div class="box">
                <div class="box-body">
                    <div class="form-group">
                        <label>Gambar</label>
                        <input type="file" name="image" class="form-control" <?php echo isset($p) ? '' : 'required'; ?>>
                        <?php if(isset($p) && !empty($p['image'])){?>
                            <br>
                            <img src="<?php echo BASEURL.'assets/images/carousel/'.$p['image']?>" style="width: 200px;">
                        <?php } ?>
                        <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar.</small>
                    </div>
                    <div class="form-group">
                        <label>Alt Text / Deskripsi Singkat</label>
                        <input type="text" name="alt_text" class="form-control" value="<?php echo isset($p)?$p['alt_text']:''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Urutan</label>
                        <input type="number" name="urutan" class="form-control" value="<?php echo isset($p)?$p['urutan']:'1'; ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control" required>
                            <option value="1" <?php echo isset($p) && $p['status']==1?'selected':''; ?>>Aktif</option>
                            <option value="0" <?php echo isset($p) && $p['status']==0?'selected':''; ?>>Tidak Aktif</option>
                        </select>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <a href="<?php echo $batal?>" class="btn btn-danger">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>
