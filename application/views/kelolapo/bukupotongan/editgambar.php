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
    .bpd-gbr {
        --navy: #1e3a5f;
        --navy-lt: #eef3f9;
        --line: #dfe5ec;
        --muted: #6b7a90;
        font-size: 12px;
    }

    .bpd-gbr .row {
        margin-left: -6px;
        margin-right: -6px;
    }

    .bpd-gbr .row > [class*="col-"] {
        padding-left: 6px;
        padding-right: 6px;
    }

    .bpd-gbr-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 8px;
        padding-bottom: 8px;
        margin-bottom: 12px;
        border-bottom: 1px solid var(--line);
    }

    .bpd-gbr-bar h3 {
        margin: 0;
        font-size: 15px;
        font-weight: 700;
        color: var(--navy);
    }

    .bpd-gbr-bar h3 small {
        font-size: 12px;
        color: var(--muted);
        margin-left: 6px;
    }

    .bpd-gbr .btn {
        font-size: 11px;
        font-weight: 600;
    }

    .bpd-gbr .btn-navy {
        background: var(--navy);
        border-color: var(--navy);
        color: #fff !important;
    }

    .bpd-gbr .btn-navy:hover,
    .bpd-gbr .btn-navy:focus {
        background: #152b47;
        border-color: #152b47;
        color: #fff !important;
    }

    .bpd-gbr-panel {
        border: 1px solid var(--line);
        border-radius: 4px;
        margin-bottom: 14px;
        background: #fff;
    }

    .bpd-gbr-panel-h {
        background: var(--navy-lt);
        color: var(--navy);
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .4px;
        padding: 6px 12px;
        border-bottom: 1px solid var(--line);
    }

    .bpd-gbr-panel-b {
        padding: 12px;
    }

    .gbr-card {
        background: #fafbfd;
        border: 1px solid var(--line);
        border-radius: 4px;
        padding: 10px;
        margin-bottom: 10px;
        text-align: center;
    }

    .gbr-card-title {
        font-size: 11px;
        font-weight: 700;
        color: var(--navy);
        text-transform: uppercase;
        margin-bottom: 8px;
    }

    .gbr-preview-img {
        max-width: 100%;
        max-height: 180px;
        object-fit: contain;
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 4px;
        cursor: zoom-in;
        margin-bottom: 8px;
    }

    .gbr-badge-new {
        display: none;
        font-size: 9px;
        font-weight: 700;
        color: #1e3a5f;
        background: #e0e7ff;
        padding: 2px 6px;
        border-radius: 3px;
        margin-bottom: 6px;
    }
</style>

<!-- Modal Zoom Image -->
<div class="modal fade" id="modalZoomGbr" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="background:transparent;border:none;box-shadow:none;">
            <div class="text-right" style="padding-bottom:5px;">
                <button type="button" class="close" data-dismiss="modal" style="color:#fff;opacity:1;font-size:28px;">&times;</button>
            </div>
            <div class="text-center">
                <img id="imgZoomGbr" src="" style="max-width:100%;max-height:85vh;border-radius:6px;background:#fff;padding:6px;box-shadow:0 10px 30px rgba(0,0,0,0.5);">
            </div>
        </div>
    </div>
</div>

<div class="bpd-gbr">
    <?php if ($this->session->flashdata('msg')) { ?>
        <div class="alert alert-success alert-dismissible" style="padding:8px 30px 8px 12px;font-size:12px;margin-bottom:10px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <?php echo $this->session->flashdata('msg'); ?> 
        </div>
    <?php } ?>

    <form method="post" enctype="multipart/form-data" action="<?php echo $action ?>">
        <input type="hidden" name="kode_po" value="<?php echo $kode_po ?>">

        <!-- Toolbar -->
        <div class="bpd-gbr-bar">
            <h3>
                EDIT GAMBAR SAMPLE
                <small>PO: <?php echo strtoupper($kode_po) ?></small>
            </h3>
            <div>
                <a href="<?php echo $kembali ?>" class="btn btn-default btn-sm">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
                <button type="submit" class="btn btn-navy btn-sm">
                    <i class="fa fa-save"></i> Simpan Gambar
                </button>
            </div>
        </div>

        <div class="row">
            <!-- Panel Bahan Utama -->
            <div class="col-md-6">
                <div class="bpd-gbr-panel">
                    <div class="bpd-gbr-panel-h">
                        <i class="fa fa-cut mr-1"></i> Sample Bahan Utama
                    </div>
                    <div class="bpd-gbr-panel-b">
                        <div class="row">
                            <!-- Bahan Utama 1 -->
                            <div class="col-sm-6">
                                <div class="gbr-card">
                                    <div class="gbr-card-title">Bahan Utama 1</div>
                                    <span id="badgeU1" class="gbr-badge-new">File Baru Dipilih</span>
                                    <?php $hasU1 = is_valid_image_url($prods['sample_bahan_utama_img'] ?? ''); ?>
                                    <div style="height:140px;display:flex;align-items:center;justify-content:center;background:#fff;border:1px solid var(--line);border-radius:4px;margin-bottom:8px;overflow:hidden;">
                                        <div id="phU1" style="<?php echo $hasU1 ? 'display:none;' : '' ?>color:#94a3b8;font-size:11px;">
                                            <i class="fa fa-image fa-2x" style="display:block;margin-bottom:4px;opacity:0.5;"></i> Belum ada foto
                                        </div>
                                        <img id="imgU1" class="gbr-preview-img img-zoom-trigger" src="<?php echo $hasU1 ? $prods['sample_bahan_utama_img'] : '' ?>" style="<?php echo $hasU1 ? '' : 'display:none;' ?>" alt="Sample Bahan Utama 1" title="Klik untuk memperbesar">
                                    </div>
                                    <input type="hidden" name="gbrbahanold" value="<?php echo $prods['sample_bahan_utama_img'] ?>">
                                    <label style="font-size:10px;color:var(--muted);display:block;text-align:left;margin-bottom:3px;">Pilih Gambar Baru:</label>
                                    <input type="file" name="gbrbahan" class="form-control input-sm file-preview-act" accept="image/*" data-img="#imgU1" data-ph="#phU1" data-badge="#badgeU1">
                                </div>
                            </div>

                            <!-- Bahan Utama 2 -->
                            <div class="col-sm-6">
                                <div class="gbr-card">
                                    <div class="gbr-card-title">Bahan Utama 2</div>
                                    <span id="badgeU2" class="gbr-badge-new">File Baru Dipilih</span>
                                    <?php $hasU2 = is_valid_image_url($prods['sample_bahan_utama_img2'] ?? ''); ?>
                                    <div style="height:140px;display:flex;align-items:center;justify-content:center;background:#fff;border:1px solid var(--line);border-radius:4px;margin-bottom:8px;overflow:hidden;">
                                        <div id="phU2" style="<?php echo $hasU2 ? 'display:none;' : '' ?>color:#94a3b8;font-size:11px;">
                                            <i class="fa fa-image fa-2x" style="display:block;margin-bottom:4px;opacity:0.5;"></i> Belum ada foto
                                        </div>
                                        <img id="imgU2" class="gbr-preview-img img-zoom-trigger" src="<?php echo $hasU2 ? $prods['sample_bahan_utama_img2'] : '' ?>" style="<?php echo $hasU2 ? '' : 'display:none;' ?>" alt="Sample Bahan Utama 2" title="Klik untuk memperbesar">
                                    </div>
                                    <input type="hidden" name="gbrbahan2old" value="<?php echo $prods['sample_bahan_utama_img2'] ?>">
                                    <label style="font-size:10px;color:var(--muted);display:block;text-align:left;margin-bottom:3px;">Pilih Gambar Baru:</label>
                                    <input type="file" name="gbrbahan2" class="form-control input-sm file-preview-act" accept="image/*" data-img="#imgU2" data-ph="#phU2" data-badge="#badgeU2">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel Bahan Variasi -->
            <div class="col-md-6">
                <div class="bpd-gbr-panel">
                    <div class="bpd-gbr-panel-h">
                        <i class="fa fa-layer-group mr-1"></i> Sample Bahan Variasi
                    </div>
                    <div class="bpd-gbr-panel-b">
                        <div class="row">
                            <!-- Variasi 1 -->
                            <div class="col-sm-6">
                                <div class="gbr-card">
                                    <div class="gbr-card-title">Bahan Variasi 1</div>
                                    <span id="badgeV1" class="gbr-badge-new">File Baru Dipilih</span>
                                    <?php $hasV1 = is_valid_image_url($prods['sample_bahan_variasi_img'] ?? ''); ?>
                                    <div style="height:140px;display:flex;align-items:center;justify-content:center;background:#fff;border:1px solid var(--line);border-radius:4px;margin-bottom:8px;overflow:hidden;">
                                        <div id="phV1" style="<?php echo $hasV1 ? 'display:none;' : '' ?>color:#94a3b8;font-size:11px;">
                                            <i class="fa fa-image fa-2x" style="display:block;margin-bottom:4px;opacity:0.5;"></i> Belum ada foto
                                        </div>
                                        <img id="imgV1" class="gbr-preview-img img-zoom-trigger" src="<?php echo $hasV1 ? $prods['sample_bahan_variasi_img'] : '' ?>" style="<?php echo $hasV1 ? '' : 'display:none;' ?>" alt="Sample Bahan Variasi 1" title="Klik untuk memperbesar">
                                    </div>
                                    <input type="hidden" name="gbrbahanvar1old" value="<?php echo $prods['sample_bahan_variasi_img'] ?>">
                                    <label style="font-size:10px;color:var(--muted);display:block;text-align:left;margin-bottom:3px;">Pilih Gambar Baru:</label>
                                    <input type="file" name="gbrbahanvar1" class="form-control input-sm file-preview-act" accept="image/*" data-img="#imgV1" data-ph="#phV1" data-badge="#badgeV1">
                                </div>
                            </div>

                            <!-- Variasi 2 -->
                            <div class="col-sm-6">
                                <div class="gbr-card">
                                    <div class="gbr-card-title">Bahan Variasi 2</div>
                                    <span id="badgeV2" class="gbr-badge-new">File Baru Dipilih</span>
                                    <?php $hasV2 = is_valid_image_url($prods['sample_bahan_variasi_img2'] ?? ''); ?>
                                    <div style="height:140px;display:flex;align-items:center;justify-content:center;background:#fff;border:1px solid var(--line);border-radius:4px;margin-bottom:8px;overflow:hidden;">
                                        <div id="phV2" style="<?php echo $hasV2 ? 'display:none;' : '' ?>color:#94a3b8;font-size:11px;">
                                            <i class="fa fa-image fa-2x" style="display:block;margin-bottom:4px;opacity:0.5;"></i> Belum ada foto
                                        </div>
                                        <img id="imgV2" class="gbr-preview-img img-zoom-trigger" src="<?php echo $hasV2 ? $prods['sample_bahan_variasi_img2'] : '' ?>" style="<?php echo $hasV2 ? '' : 'display:none;' ?>" alt="Sample Bahan Variasi 2" title="Klik untuk memperbesar">
                                    </div>
                                    <input type="hidden" name="gbrbahanvar2old" value="<?php echo $prods['sample_bahan_variasi_img2'] ?>">
                                    <label style="font-size:10px;color:var(--muted);display:block;text-align:left;margin-bottom:3px;">Pilih Gambar Baru:</label>
                                    <input type="file" name="gbrbahanvar2" class="form-control input-sm file-preview-act" accept="image/*" data-img="#imgV2" data-ph="#phV2" data-badge="#badgeV2">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="bpd-gbr-bar" style="border-top:1px solid var(--line);border-bottom:none;padding-top:10px;margin-top:5px;">
            <div>
                <span class="text-muted" style="font-size:11px;">Pilih gambar JPG, PNG, atau JPEG baru untuk memperbarui sample foto.</span>
            </div>
            <div>
                <a href="<?php echo $kembali ?>" class="btn btn-default btn-sm">
                    <i class="fa fa-times"></i> Batal
                </a>
                <button type="submit" class="btn btn-navy btn-sm">
                    <i class="fa fa-save"></i> Simpan Gambar
                </button>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        // Real-time Preview Saat File Dipilih
        $('.file-preview-act').on('change', function() {
            var input = this;
            var targetImg = $(this).data('img');
            var targetPh = $(this).data('ph');
            var targetBadge = $(this).data('badge');
            if (input.files && input.files[0]) {
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
                reader.readAsDataURL(input.files[0]);
            }
        });

        // Zoom Modal Preview
        $(document).on('click', '.img-zoom-trigger', function() {
            var src = $(this).attr('src');
            if (src) {
                $('#imgZoomGbr').attr('src', src);
                $('#modalZoomGbr').modal('show');
            }
        });
    });
</script>