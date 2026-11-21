<div class="row">
    <div class="col-md-6">
        <form action="<?php echo $action; ?>" method="POST">
            <div class="form-group">
                <label>Pilih User <span class="text-danger">*</span></label>
                <select name="id_user" class="form-control select2" required style="width: 100%;">
                    <option value="">-- Pilih User --</option>
                    <?php foreach ($users as $user): ?>
                        <option value="<?php echo $user['id_user']; ?>" <?php echo (isset($p['id_user']) && $p['id_user'] == $user['id_user']) ? 'selected' : ''; ?>>
                            <?php echo $user['nama_user']; ?> (<?php echo !empty($user['nama_jabatan']) ? $user['nama_jabatan'] : 'User'; ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Tipe Persetujuan <span class="text-danger">*</span></label>
                <select name="tipe" class="form-control" required>
                    <option value="kirimgudang" <?php echo (isset($p['tipe']) && $p['tipe'] == 'kirimgudang') ? 'selected' : ''; ?>>Finishing - Kirim Gudang</option>
                </select>
            </div>

            <div class="form-group">
                <label>Status Menerima Notifikasi</label>
                <select name="aktif" class="form-control">
                    <option value="1" <?php echo (!isset($p['aktif']) || $p['aktif'] == 1) ? 'selected' : ''; ?>>Aktif (Menerima Notifikasi)</option>
                    <option value="0" <?php echo (isset($p['aktif']) && $p['aktif'] == 0) ? 'selected' : ''; ?>>Non-Aktif (Tidak Menerima)</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
            <a href="<?php echo $cancel; ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Batal</a>
        </form>
    </div>
</div>
