<?php if (!empty($setorcmtjahit)): ?>
<form id="form-edit-setoran" action="<?php echo BASEURL . 'Finishing/edit_setoran_celana_save' ?>" method="post">
    <input type="hidden" name="id_kelolapo_rincian_setor_cmt" value="<?php echo $setorcmtjahit['id_kelolapo_rincian_setor_cmt'] ?>">
    <input type="hidden" name="idpo" value="<?php echo $setorcmtjahit['idpo'] ?>">
    <input type="hidden" name="refpo" value="<?php echo $setorcmtjahit['refpo'] ?>">
    <input type="hidden" name="idcmt" value="<?php echo $setorcmtjahit['idcmt'] ?>">
    
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Nama PO</label>
                <input type="text" class="form-control" value="<?php echo $setorcmtjahit['kode_po'] ?>" readonly>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Nama CMT</label>
                <input type="text" class="form-control" value="<?php echo $setorcmtjahit['nama_cmt'] ?>" readonly>
            </div>
        </div>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>SIZE</th>
                <th>DZ(Lusin)</th>
                <th>PIECES</th>
                <th>BANGKE</th>
                <th>REJECT</th>
                <th>HILANG</th>
                <th>CLAIM</th>
                <th>KETERANGAN</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($items)): ?>
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td>
                            <input type="hidden" name="id_finish[]" value="<?php echo $item['id_kelolapo_rincian_setor_cmt_finish'] ?>">
                            <input type="text" name="rincian_size[]" class="form-control" value="<?php echo $item['rincian_size'] ?>" readonly>
                        </td>
                        <td><input type="number" step="any" name="rincian_lusin[]" class="form-control" value="<?php echo $item['rincian_lusin'] ?>"></td>
                        <td><input type="number" name="rincian_piece[]" class="form-control" value="<?php echo $item['rincian_piece'] ?>"></td>
                        <td><input type="number" name="rincian_bangke[]" class="form-control" value="<?php echo $item['rincian_bangke'] ?>"></td>
                        <td><input type="number" name="rincian_reject[]" class="form-control" value="<?php echo $item['rincian_reject'] ?>"></td>
                        <td><input type="number" name="rincian_hilang[]" class="form-control" value="<?php echo $item['rincian_hilang'] ?>"></td>
                        <td><input type="number" name="rincian_claim[]" class="form-control" value="<?php echo $item['rincian_claim'] ?>"></td>
                        <td><input type="text" name="rincian_keterangan[]" class="form-control" value="<?php echo $item['rincian_keterangan'] ?>"></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    <div class="text-right">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </div>
</form>
<?php else: ?>
    <p class="text-center">Data tidak ditemukan.</p>
<?php endif; ?>
