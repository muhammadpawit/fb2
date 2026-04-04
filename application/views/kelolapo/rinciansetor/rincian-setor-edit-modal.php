<?php if (!empty($setorcmtjahit)): ?>
<form action="<?php echo $editaction ?>" method="post">
    <input type="hidden" name="id_kelolapo_kirim_setor" value="<?php echo $poProd['id_kelolapo_kirim_setor'] ?>">
    <input type="hidden" name="kode_po" value="<?php echo $poProd['idpo'] ?>">
    <input type="hidden" name="progresName" value="<?php echo $poProd['id_proggresion_po'] ?>">
    
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Nama PO</label>
                <input type="text" class="form-control" value="<?php echo $poProd['kode_po'] ?>" readonly>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Tanggal Terima</label>
                <input type="date" name="tanggal_terima" class="form-control" value="<?php echo date('Y-m-d', strtotime($poProd['create_date'])) ?>">
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>SIZE</th>
                    <th>DZ</th>
                    <th>PCS</th>
                    <th>BKE</th>
                    <th>RJC</th>
                    <th>HLG</th>
                    <th>CLM</th>
                    <th>KET</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($setorcmtjahititem as $key => $item): ?>
                <tr>
                    <td>
                        <input type="text" class="form-control" name="rinciansize[]" value="<?php echo $item['rincian_size'] ?>" readonly>
                    </td>
                    <td><input type="number" step="any" class="form-control" name="rincianlusin[]" value="<?php echo $item['rincian_lusin'] ?>"></td>
                    <td><input type="number" class="form-control" name="rincianpiece[]" value="<?php echo $item['rincian_piece'] ?>"></td>
                    <td><input type="number" class="form-control" name="banke[]" value="<?php echo $item['rincian_bangke'] ?>"></td>
                    <td><input type="number" class="form-control" name="barangCacad[]" value="<?php echo $item['rincian_reject'] ?>"></td>
                    <td><input type="number" class="form-control" name="hilangBarang[]" value="<?php echo $item['rincian_hilang'] ?>"></td>
                    <td><input type="number" class="form-control" name="claimBarang[]" value="<?php echo $item['rincian_claim'] ?>"></td>
                    <td><input type="text" class="form-control" name="keterangan[]" value="<?php echo $item['rincian_keterangan'] ?>"></td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>

    <div class="text-right">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </div>
</form>
<?php else: ?>
    <p class="text-center">Data tidak ditemukan.</p>
<?php endif ?>
