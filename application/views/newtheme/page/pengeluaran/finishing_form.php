<form method="post" action="<?php echo $action?>">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Tanggal</label>
                <input type="date" name="tanggal" value="<?php echo isset($p['tanggal']) ? $p['tanggal'] : date('Y-m-d') ?>" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Keterangan</label>
                <input type="text" name="keterangan" value="<?php echo isset($p['keterangan']) ? $p['keterangan'] : '' ?>" class="form-control" required placeholder="Contoh: Tabung Gas">
            </div>
            <div class="form-group">
                <label>Nominal (Rp)</label>
                <input type="number" name="nominal" value="<?php echo isset($p['nominal']) ? $p['nominal'] : '' ?>" class="form-control" required>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <button type="submit" class="btn btn-info full">Simpan</button>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <a href="<?php echo BASEURL?>Pengeluaran/finishing" class="btn btn-danger full">Batal</a>
            </div>
        </div>
    </div>
</form>
