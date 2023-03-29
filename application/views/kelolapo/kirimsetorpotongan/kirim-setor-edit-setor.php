<div class="row">
    <form method="post" action="<?php echo $action ?>">
        <input type="hidden" name="kode_po" value="<?php echo $po['kode_po']?>">
        <input type="hidden" name="idpo" value="<?php echo $po['id_produksi_po']?>">
        <input type="hidden" name="progress" value="SETOR">
        <input type="hidden" name="kategori" value="<?php echo $kategori ?>">
        <input type="hidden" name="notasetor" value="<?php echo $klo['kode_nota_cmt']?>">
        <div class="col-md-12">
            <div class="form-group">
                <label>Jumlah Setoran Sebelumnya (Pcs)</label>
                <input type="text" name="setoran" class="form-control" value="<?php echo $klo['qty_tot_pcs']?>" readonly>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>Jumlah Setoran Perbaikan (Pcs)</label>
                <input type="text" name="pcs" class="form-control" autocomplete="off" required>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>Alasan Perbaikan</label>
                <textarea name="alasan" class="form-control" rows="5" required></textarea>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label></label>
                <button class="btn btn-success btn-sm full">Simpan</button>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label></label>
                <a href="<?php echo $batal ?>" class="btn btn-danger btn-sm full">Batal</a>
            </div>
        </div>
    </form>
</div>