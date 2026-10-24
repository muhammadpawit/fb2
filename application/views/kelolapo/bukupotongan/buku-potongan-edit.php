<?php
if (!function_exists('is_valid_image_url')) {
    function is_valid_image_url($url) {
        if (empty($url)) return false;
        $url = trim($url);
        if (substr($url, -1) === '/') return false;
        $path = parse_url($url, PHP_URL_PATH);
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        return in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
    }
}
?>
<style type="text/css">
    .bpd-edit {
        --navy: #1e3a5f;
        --navy-lt: #eef3f9;
        --line: #dfe5ec;
        --muted: #6b7a90;
        font-size: 12px;
    }

    .bpd-edit .row {
        margin-left: -6px;
        margin-right: -6px;
    }

    .bpd-edit .row > [class*="col-"] {
        padding-left: 6px;
        padding-right: 6px;
    }

    /* Toolbar */
    .bpd-edit-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 8px;
        padding-bottom: 8px;
        margin-bottom: 12px;
        border-bottom: 1px solid var(--line);
    }

    .bpd-edit-bar h3 {
        margin: 0;
        font-size: 15px;
        font-weight: 700;
        color: var(--navy);
    }

    .bpd-edit-bar h3 small {
        font-size: 12px;
        color: var(--muted);
        margin-left: 6px;
    }

    .bpd-edit .btn {
        font-size: 11px;
        font-weight: 600;
    }

    .bpd-edit .btn-navy {
        background: var(--navy);
        border-color: var(--navy);
        color: #fff !important;
    }

    .bpd-edit .btn-navy:hover,
    .bpd-edit .btn-navy:focus {
        background: #152b47;
        border-color: #152b47;
        color: #fff !important;
    }

    /* Panels */
    .bpd-edit-panel {
        border: 1px solid var(--line);
        border-radius: 4px;
        margin-bottom: 14px;
        background: #fff;
    }

    .bpd-edit-panel-h {
        background: var(--navy-lt);
        color: var(--navy);
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .4px;
        padding: 6px 12px;
        border-bottom: 1px solid var(--line);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .bpd-edit-panel-b {
        padding: 12px;
    }

    /* Form Fields */
    .bpd-edit label {
        font-size: 11px;
        font-weight: 600;
        color: #334155;
        margin-bottom: 4px;
    }

    .bpd-edit .form-control {
        height: 30px;
        font-size: 12px;
        padding: 4px 8px;
        border-color: #cbd5e1;
        border-radius: 4px;
    }

    .bpd-edit .form-control:focus {
        border-color: var(--navy);
        box-shadow: 0 0 0 2px rgba(30, 58, 95, 0.15);
    }

    /* Tables */
    .bpd-edit-table {
        margin: 0;
        width: 100%;
    }

    .bpd-edit-table > thead > tr > th,
    .bpd-edit-table > tr > th {
        background: var(--navy);
        color: #fff !important;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        border-bottom: none;
        padding: 6px 8px;
        vertical-align: middle;
        text-align: center;
    }

    .bpd-edit-table > tbody > tr > td,
    .bpd-edit-table > tr > td {
        padding: 5px 8px;
        font-size: 12px;
        vertical-align: middle;
        border-bottom: 1px solid #f0f3f7;
    }

    .bpd-edit-table .form-control {
        height: 28px;
        font-size: 11px;
        padding: 2px 6px;
    }

    /* Sample Cards */
    .sample-upload-card {
        background: #fafbfd;
        border: 1px solid var(--line);
        border-radius: 4px;
        padding: 8px;
        margin-bottom: 10px;
        text-align: center;
        position: relative;
    }

    .sample-upload-title {
        font-size: 11px;
        font-weight: 700;
        color: var(--navy);
        text-transform: uppercase;
        margin-bottom: 6px;
    }

    .sample-box-inner {
        height: 120px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 4px;
        margin-bottom: 6px;
        overflow: hidden;
    }

    .sample-placeholder {
        padding: 10px 4px;
        color: #94a3b8;
        font-size: 11px;
        text-align: center;
    }

    .sample-placeholder i {
        display: block;
        margin-bottom: 4px;
        opacity: 0.6;
    }

    .sample-img-display {
        width: 100%;
        height: 100%;
        max-height: 120px;
        object-fit: contain;
        background: #fff;
        cursor: zoom-in;
    }

    .sample-upload-btn-lbl {
        display: block;
        background: var(--navy);
        color: #fff !important;
        font-size: 11px;
        font-weight: 600;
        padding: 5px 8px;
        border-radius: 3px;
        cursor: pointer;
        margin-bottom: 3px;
        transition: background 0.2s;
    }

    .sample-upload-btn-lbl:hover {
        background: #152b47;
    }

    .sample-file-name {
        font-size: 10px;
        color: var(--muted);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .sample-badge-status {
        display: none;
        position: absolute;
        top: 6px;
        right: 6px;
        font-size: 9px;
        font-weight: 700;
        padding: 2px 6px;
        border-radius: 10px;
        background: #27ae60;
        color: #fff;
        text-transform: uppercase;
    }

    .sample-badge-saved {
        position: absolute;
        top: 6px;
        left: 6px;
        font-size: 9px;
        font-weight: 700;
        padding: 2px 6px;
        border-radius: 10px;
        background: #3b82f6;
        color: #fff;
        text-transform: uppercase;
    }
</style>

<!-- Modal Zoom Preview -->
<div class="modal fade" id="modalZoomEdit" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="background:transparent;border:none;box-shadow:none;">
            <div class="text-right" style="padding-bottom:5px;">
                <button type="button" class="close" data-dismiss="modal" style="color:#fff;opacity:1;font-size:28px;">&times;</button>
            </div>
            <div class="text-center">
                <img id="imgZoomEdit" src="" style="max-width:100%;max-height:85vh;border-radius:6px;background:#fff;padding:6px;box-shadow:0 10px 30px rgba(0,0,0,0.5);">
            </div>
        </div>
    </div>
</div>

<div class="bpd-edit">
    <form action="<?php echo $action ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="idpotongan" value="<?php echo $potongan['id_potongan'] ?>">

        <!-- Top Toolbar -->
        <div class="bpd-edit-bar">
            <h3>
                EDIT BUKU POTONGAN
                <small>PO: <?php echo $poProd['nama_po'] ?> - <?php echo $poProd['kode_po'] ?></small>
            </h3>
            <div>
                <a href="<?php echo BASEURL . 'Kelolapo/bukupotongan' ?>" class="btn btn-default btn-sm">
                    <i class="fa fa-arrow-left"></i> Batal
                </a>
                <button type="submit" class="btn btn-navy btn-sm">
                    <i class="fa fa-save"></i> Simpan Perubahan
                </button>
            </div>
        </div>

        <!-- PANEL I: INFORMASI UTAMA & POTONGAN BAHAN UTAMA -->
        <div class="bpd-edit-panel">
            <div class="bpd-edit-panel-h">
                <span><i class="fa fa-cut mr-1"></i> I. Rincian &amp; Pemakaian Bahan Utama</span>
            </div>
            <div class="bpd-edit-panel-b">
                <div class="row">
                    <!-- Form Fields Kolom Kiri: col-md-7 -->
                    <div class="col-md-7">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group" style="margin-bottom:10px;">
                                    <label>Tanggal <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="tanggal" value="<?php echo $potongan['created_date'] ?>" required>
                                </div>
                                <div class="form-group" style="margin-bottom:10px;">
                                    <label>Nama PO</label>
                                    <input type="hidden" name="kode_po" value="<?php echo $poProd['kode_po'] ?>">
                                    <input type="text" name="namaPo" value="<?php echo $poProd['nama_po'] ?>-<?php echo $poProd['kode_po'] ?>" class="form-control" readonly style="background:#f1f5f9;font-weight:600;">
                                </div>
                                <div class="form-group" style="margin-bottom:10px;">
                                    <label>Tim Potong <span class="text-danger">*</span></label>
                                    <select name="timPotong" class="form-control" required>
                                        <option value="">Pilih Tim Potong</option>
                                        <?php foreach ($timpotong as $tp) { ?>
                                            <option value="<?php echo $tp['id'] ?>" <?php echo $tim['id'] == $tp['id'] ? 'selected' : ''; ?>><?php echo $tp['nama'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group" style="margin-bottom:10px;">
                                    <label>Size Potongan <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="sizeBahan" value="<?php echo $potongan['size_potongan'] ?>" required>
                                </div>
                                <div class="form-group" style="margin-bottom:10px;">
                                    <label>Jumlah Size / Gambar <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="jumlahGambar" value="<?php echo $potongan['jumlah_gambar_utama'] ?>" required>
                                </div>
                                <div class="form-group" style="margin-bottom:10px;">
                                    <label>Panjang Gelaran (cm) <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" class="form-control" name="panjangGelaran" value="<?php echo $potongan['panjang_gelaran_potongan_utama'] ?>" required>
                                </div>
                                <div class="form-group" style="margin-bottom:10px;">
                                    <label>Pemakaian Bahan (yard) <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="pemakaianBahan" value="<?php echo $potongan['pemakaian_bahan_utama'] ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Upload & Pratinjau Foto Sample Bahan Utama: col-md-5 -->
                    <div class="col-md-5">
                        <div class="row">
                            <!-- Sample Bahan Utama 1 -->
                            <div class="col-xs-6">
                                <div class="sample-upload-card">
                                    <div class="sample-upload-title"><i class="fa fa-camera mr-1"></i> Sample Utama 1</div>
                                    <?php $hasU1 = is_valid_image_url($potongan['sample_bahan_utama_img'] ?? ''); ?>
                                    <?php if ($hasU1): ?>
                                        <span class="sample-badge-saved">Foto Ada</span>
                                    <?php endif; ?>
                                    <span id="badgeU1" class="sample-badge-status">Pratinjau Baru</span>
                                    
                                    <div class="sample-box-inner">
                                        <div id="phU1" class="sample-placeholder" style="<?php echo $hasU1 ? 'display:none;' : '' ?>">
                                            <i class="fa fa-image fa-2x"></i>
                                            <div>Belum ada foto</div>
                                        </div>
                                        <img id="imgPrevU1" class="sample-img-display img-zoom-trigger" 
                                             src="<?php echo $hasU1 ? $potongan['sample_bahan_utama_img'] : '' ?>" 
                                             style="<?php echo $hasU1 ? '' : 'display:none;' ?>"
                                             alt="Sample Utama 1" title="Klik untuk memperbesar">
                                    </div>
                                    
                                    <label class="sample-upload-btn-lbl">
                                        <i class="fa fa-upload mr-1"></i> Pilih File Foto
                                        <input type="file" name="sempleBhnImg" class="file-preview-act" accept="image/*" 
                                               data-img="#imgPrevU1" data-ph="#phU1" data-badge="#badgeU1" data-fname="#fnameU1" style="display:none;">
                                    </label>
                                    <div class="sample-file-name" id="fnameU1">Format: JPG, PNG, GIF</div>
                                </div>
                            </div>

                            <!-- Sample Bahan Utama 2 -->
                            <div class="col-xs-6">
                                <div class="sample-upload-card">
                                    <div class="sample-upload-title"><i class="fa fa-camera mr-1"></i> Sample Utama 2</div>
                                    <?php $hasU2 = is_valid_image_url($potongan['sample_bahan_utama_img2'] ?? ''); ?>
                                    <?php if ($hasU2): ?>
                                        <span class="sample-badge-saved">Foto Ada</span>
                                    <?php endif; ?>
                                    <span id="badgeU2" class="sample-badge-status">Pratinjau Baru</span>
                                    
                                    <div class="sample-box-inner">
                                        <div id="phU2" class="sample-placeholder" style="<?php echo $hasU2 ? 'display:none;' : '' ?>">
                                            <i class="fa fa-image fa-2x"></i>
                                            <div>Belum ada foto</div>
                                        </div>
                                        <img id="imgPrevU2" class="sample-img-display img-zoom-trigger" 
                                             src="<?php echo $hasU2 ? $potongan['sample_bahan_utama_img2'] : '' ?>" 
                                             style="<?php echo $hasU2 ? '' : 'display:none;' ?>"
                                             alt="Sample Utama 2" title="Klik untuk memperbesar">
                                    </div>
                                    
                                    <label class="sample-upload-btn-lbl">
                                        <i class="fa fa-upload mr-1"></i> Pilih File Foto
                                        <input type="file" name="sempleBhnImg2" class="file-preview-act" accept="image/*" 
                                               data-img="#imgPrevU2" data-ph="#phU2" data-badge="#badgeU2" data-fname="#fnameU2" style="display:none;">
                                    </label>
                                    <div class="sample-file-name" id="fnameU2">Format: JPG, PNG, GIF</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabel Pemakaian Bahan Utama -->
                <div style="margin-top:10px; border:1px solid var(--line); border-radius:4px; overflow:hidden;">
                    <table class="table table-hover bpd-edit-table" id="item_table">
                        <thead>
                            <tr>
                                <th>Bidang Bahan</th>
                                <th>Warna</th>
                                <th>Kode Bahan</th>
                                <th>Berat Bahan</th>
                                <th>Sisa Bahan</th>
                                <th style="width:160px;">Pemakaian Bahan (Kg) <span class="text-danger">*</span></th>
                                <th style="width:140px;">Banyak Lapis <span class="text-danger">*</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($utama)): ?>
                                <?php foreach ($utama as $bahan) { ?>
                                    <tr>
                                        <td>
                                            <input type="hidden" name="bidangBahan[]" value="<?php echo $bahan['bidang_bahan_potongan'] ?>">
                                            <?php echo $bahan['bidang_bahan_potongan'] ?>
                                        </td>
                                        <td>
                                            <input type="hidden" name="warna[]" value="<?php echo $bahan['warna_potongan'] ?>">
                                            <strong><?php echo $bahan['warna_potongan'] ?></strong>
                                        </td>
                                        <td class="text-center">
                                            <input type="hidden" name="kodeBahan[]" value="<?php echo $bahan['kode_bahan_potongan'] ?>">
                                            <?php echo $bahan['kode_bahan_potongan'] ?>
                                        </td>
                                        <td class="text-right">
                                            <input type="hidden" name="beratBahan[]" value="<?php echo $bahan['berat_bahan_potongan'] ?>">
                                            <?php echo $bahan['berat_bahan_potongan'] ?>
                                        </td>
                                        <td class="text-right">
                                            <input type="hidden" name="sisaBahan[]" value="<?php echo $bahan['sisa_bahan_potongan'] ?>">
                                            <?php echo $bahan['sisa_bahan_potongan'] ?>
                                        </td>
                                        <td>
                                            <input type="text" name="pemakaianBahankg[]" value="<?php echo $bahan['pemakaian_bahan_potongan'] ?>" class="form-control text-right" required>
                                        </td>
                                        <td>
                                            <input type="text" name="banyakLapis[]" value="<?php echo $bahan['banyak_lapis_potongan'] ?>" class="form-control text-center font-weight-bold" required>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center text-muted" style="padding:15px;">Tidak ada rincian bahan utama.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- PANEL II: PEMAKAIAN BAHAN CELANA / VARIASI -->
        <div class="bpd-edit-panel">
            <div class="bpd-edit-panel-h">
                <span><i class="fa fa-layer-group mr-1"></i> II. Pemakaian Bahan Celana / Variasi</span>
            </div>
            <div class="bpd-edit-panel-b">
                <div class="row">
                    <!-- Form Fields Kolom Kiri: col-md-7 -->
                    <div class="col-md-7">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group" style="margin-bottom:10px;">
                                    <label>Panjang Gelar Variasi</label>
                                    <input type="text" class="form-control" name="panjangGelaranVariasi" value="<?php echo $potongan['panjang_gelaran_variasi'] ?>">
                                </div>
                                <div class="form-group" style="margin-bottom:10px;">
                                    <label>Pemakaian Gelaran Variasi</label>
                                    <input type="number" class="form-control" step="0.01" name="pemakaianGelaranVariasi" value="<?php echo $potongan['jumlah_pemakaian_bahan_variasi'] ?>">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="alert alert-info" style="font-size:11px;padding:10px;border-radius:4px;margin-top:15px;">
                                    <i class="fa fa-info-circle mr-1"></i> <strong>Petunjuk Foto Sample:</strong><br>
                                    Pilih file foto baru untuk memperbarui sample bahan. Jika tidak ingin mengubah foto yang sudah ada, biarkan kolom upload kosong.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Upload & Pratinjau Foto Sample Variasi: col-md-5 -->
                    <div class="col-md-5">
                        <div class="row">
                            <!-- Sample Variasi 1 -->
                            <div class="col-xs-6">
                                <div class="sample-upload-card">
                                    <div class="sample-upload-title"><i class="fa fa-camera mr-1"></i> Sample Variasi 1</div>
                                    <?php $hasV1 = is_valid_image_url($potongan['sample_bahan_variasi_img'] ?? ''); ?>
                                    <?php if ($hasV1): ?>
                                        <span class="sample-badge-saved">Foto Ada</span>
                                    <?php endif; ?>
                                    <span id="badgeV1" class="sample-badge-status">Pratinjau Baru</span>
                                    
                                    <div class="sample-box-inner">
                                        <div id="phV1" class="sample-placeholder" style="<?php echo $hasV1 ? 'display:none;' : '' ?>">
                                            <i class="fa fa-image fa-2x"></i>
                                            <div>Belum ada foto</div>
                                        </div>
                                        <img id="imgPrevV1" class="sample-img-display img-zoom-trigger" 
                                             src="<?php echo $hasV1 ? $potongan['sample_bahan_variasi_img'] : '' ?>" 
                                             style="<?php echo $hasV1 ? '' : 'display:none;' ?>"
                                             alt="Sample Variasi 1" title="Klik untuk memperbesar">
                                    </div>
                                    
                                    <label class="sample-upload-btn-lbl">
                                        <i class="fa fa-upload mr-1"></i> Pilih File Foto
                                        <input type="file" name="sempleBhnImgVar" class="file-preview-act" accept="image/*" 
                                               data-img="#imgPrevV1" data-ph="#phV1" data-badge="#badgeV1" data-fname="#fnameV1" style="display:none;">
                                    </label>
                                    <div class="sample-file-name" id="fnameV1">Format: JPG, PNG, GIF</div>
                                </div>
                            </div>

                            <!-- Sample Variasi 2 -->
                            <div class="col-xs-6">
                                <div class="sample-upload-card">
                                    <div class="sample-upload-title"><i class="fa fa-camera mr-1"></i> Sample Variasi 2</div>
                                    <?php $hasV2 = is_valid_image_url($potongan['sample_bahan_variasi_img2'] ?? ''); ?>
                                    <?php if ($hasV2): ?>
                                        <span class="sample-badge-saved">Foto Ada</span>
                                    <?php endif; ?>
                                    <span id="badgeV2" class="sample-badge-status">Pratinjau Baru</span>
                                    
                                    <div class="sample-box-inner">
                                        <div id="phV2" class="sample-placeholder" style="<?php echo $hasV2 ? 'display:none;' : '' ?>">
                                            <i class="fa fa-image fa-2x"></i>
                                            <div>Belum ada foto</div>
                                        </div>
                                        <img id="imgPrevV2" class="sample-img-display img-zoom-trigger" 
                                             src="<?php echo $hasV2 ? $potongan['sample_bahan_variasi_img2'] : '' ?>" 
                                             style="<?php echo $hasV2 ? '' : 'display:none;' ?>"
                                             alt="Sample Variasi 2" title="Klik untuk memperbesar">
                                    </div>
                                    
                                    <label class="sample-upload-btn-lbl">
                                        <i class="fa fa-upload mr-1"></i> Pilih File Foto
                                        <input type="file" name="sempleBhnImgVardua" class="file-preview-act" accept="image/*" 
                                               data-img="#imgPrevV2" data-ph="#phV2" data-badge="#badgeV2" data-fname="#fnameV2" style="display:none;">
                                    </label>
                                    <div class="sample-file-name" id="fnameV2">Format: JPG, PNG, GIF</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabel Pemakaian Bahan Variasi -->
                <div style="margin-top:10px; border:1px solid var(--line); border-radius:4px; overflow:hidden;">
                    <table class="table table-hover bpd-edit-table" id="item_tabl2e">
                        <thead>
                            <tr>
                                <th>Bidang Bahan</th>
                                <th>Warna</th>
                                <th>Kode Bahan</th>
                                <th>Berat Bahan</th>
                                <th>Sisa Bahan</th>
                                <th style="width:160px;">Pemakaian Bahan (Kg)</th>
                                <th style="width:140px;">Banyak Lapis <span class="text-danger">*</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($variasi)): ?>
                                <?php foreach ($variasi as $bahan) { ?>
                                    <tr>
                                        <td>
                                            <input type="hidden" name="bidangBahanVar[]" value="<?php echo $bahan['bidang_bahan_potongan'] ?>">
                                            <?php echo $bahan['bidang_bahan_potongan'] ?>
                                        </td>
                                        <td>
                                            <input type="hidden" name="warnaVar[]" value="<?php echo $bahan['warna_potongan'] ?>">
                                            <strong><?php echo $bahan['warna_potongan'] ?></strong>
                                        </td>
                                        <td class="text-center">
                                            <input type="hidden" name="kodeBahanVar[]" value="<?php echo $bahan['kode_bahan_potongan'] ?>">
                                            <?php echo $bahan['kode_bahan_potongan'] ?>
                                        </td>
                                        <td class="text-right">
                                            <input type="hidden" name="beratBahanVar[]" value="<?php echo $bahan['berat_bahan_potongan'] ?>">
                                            <?php echo $bahan['berat_bahan_potongan'] ?>
                                        </td>
                                        <td class="text-right">
                                            <input type="hidden" name="sisaBahanVar[]" value="<?php echo $bahan['sisa_bahan_potongan'] ?>">
                                            <?php echo $bahan['sisa_bahan_potongan'] ?>
                                        </td>
                                        <td>
                                            <input type="text" name="pemakaianBahankgVar[]" value="<?php echo $bahan['pemakaian_bahan_potongan'] ?>" class="form-control text-right">
                                        </td>
                                        <td>
                                            <input type="text" name="banyakLapisVar[]" value="<?php echo $bahan['banyak_lapis_potongan'] ?>" class="form-control text-center font-weight-bold" required>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center text-muted" style="padding:15px;">Tidak ada rincian bahan variasi.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Action Footer -->
        <div class="bpd-edit-bar" style="border-top:1px solid var(--line);border-bottom:none;padding-top:10px;margin-top:5px;">
            <div>
                <span class="text-muted" style="font-size:11px;">Perubahan data pemakaian bahan akan otomatis memperbarui histori buku potongan PO ini.</span>
            </div>
            <div>
                <a href="<?php echo BASEURL . 'Kelolapo/bukupotongan' ?>" class="btn btn-default btn-sm">
                    <i class="fa fa-times"></i> Batal
                </a>
                <button type="submit" class="btn btn-navy btn-sm">
                    <i class="fa fa-save"></i> Update Buku Potongan
                </button>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        // Real-time Preview saat memilih file gambar baru
        $('.file-preview-act').on('change', function() {
            var input = this;
            var targetImg = $(this).data('img');
            var targetPh = $(this).data('ph');
            var targetBadge = $(this).data('badge');
            var targetFname = $(this).data('fname');
            if (input.files && input.files[0]) {
                var file = input.files[0];
                if (targetFname) {
                    $(targetFname).text(file.name).css('color', '#1e3a5f').css('font-weight', '600');
                }
                var reader = new FileReader();
                reader.onload = function(e) {
                    if (targetPh) {
                        $(targetPh).hide();
                    }
                    $(targetImg).attr('src', e.target.result).show();
                    if (targetBadge) {
                        $(targetBadge).fadeIn(200);
                    }
                };
                reader.readAsDataURL(file);
            }
        });

        // Zoom modal preview
        $(document).on('click', '.img-zoom-trigger', function() {
            var src = $(this).attr('src');
            if (src && src.length > 5) {
                $('#imgZoomEdit').attr('src', src);
                $('#modalZoomEdit').modal('show');
            }
        });
    });
</script>