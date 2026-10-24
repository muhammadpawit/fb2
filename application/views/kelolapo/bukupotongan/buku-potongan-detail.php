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
    .bpd {
        --navy: #1e3a5f;
        --navy-lt: #eef3f9;
        --line: #dfe5ec;
        --muted: #6b7a90;
        font-size: 12px;
    }

    .bpd .row {
        margin-left: -6px;
        margin-right: -6px;
    }

    .bpd .row > [class*="col-"] {
        padding-left: 6px;
        padding-right: 6px;
    }

    /* Toolbar */
    .bpd-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 8px;
        padding-bottom: 8px;
        margin-bottom: 10px;
        border-bottom: 1px solid var(--line);
    }

    .bpd-bar h3 {
        margin: 0;
        font-size: 15px;
        font-weight: 700;
        color: var(--navy);
    }

    .bpd-bar h3 small {
        font-size: 12px;
        color: var(--muted);
        margin-left: 6px;
    }

    .bpd-bar .btn {
        font-size: 11px;
        font-weight: 600;
    }

    .bpd .btn-navy {
        background: var(--navy);
        border-color: var(--navy);
        color: #fff !important;
    }

    .bpd .btn-navy:hover,
    .bpd .btn-navy:focus {
        background: #152b47;
        border-color: #152b47;
        color: #fff !important;
    }

    /* Panels */
    .bpd-panel {
        border: 1px solid var(--line);
        border-radius: 4px;
        margin-bottom: 12px;
        background: #fff;
    }

    .bpd-panel-h {
        background: var(--navy-lt);
        color: var(--navy);
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .4px;
        padding: 6px 10px;
        border-bottom: 1px solid var(--line);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .bpd-panel-b {
        padding: 8px 10px;
    }

    /* Info Table */
    .bpd-info {
        width: 100%;
        margin: 0;
    }

    .bpd-info td {
        padding: 5px 10px !important;
        border-top: none !important;
        border-bottom: 1px solid #f0f3f7;
        vertical-align: middle !important;
    }

    .bpd-info tr:last-child td {
        border-bottom: none;
    }

    .bpd-info td.k {
        width: 14%;
        color: var(--muted);
        white-space: nowrap;
        font-size: 11px;
    }

    .bpd-info td.v {
        width: 36%;
        font-weight: 600;
        color: #1b2533;
    }

    /* Detail Tables */
    .bpd-table {
        margin: 0;
        width: 100%;
    }

    .bpd-table > thead > tr > th {
        background: var(--navy);
        color: #fff !important;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        border-bottom: none;
        padding: 6px 8px;
        vertical-align: middle;
    }

    .bpd-table > tbody > tr > td,
    .bpd-table > tfoot > tr > td {
        padding: 5px 8px;
        font-size: 12px;
        vertical-align: middle;
        border-bottom: 1px solid #f0f3f7;
    }

    .bpd-table .num {
        text-align: right;
        font-variant-numeric: tabular-nums;
    }

    .bpd-table .ctr {
        text-align: center;
    }

    .bpd-table .no {
        width: 36px;
        text-align: center;
        color: var(--muted);
    }

    .bpd-table tfoot td {
        font-weight: 700;
    }

    .bpd-table tfoot .t-sub td {
        background: #f5f8fb;
        border-top: 2px solid var(--navy);
        color: #1b2533;
    }

    .bpd-table .btn-del {
        padding: 2px 6px;
        font-size: 10px;
        line-height: 1;
        border-radius: 3px;
    }

    /* Sample Image Cards */
    .bpd-sample-box {
        background: #fafbfd;
        border: 1px solid var(--line);
        border-radius: 4px;
        padding: 8px;
        margin-bottom: 10px;
        text-align: center;
    }

    .bpd-sample-title {
        font-size: 11px;
        font-weight: 700;
        color: var(--navy);
        text-transform: uppercase;
        margin-bottom: 6px;
        letter-spacing: .3px;
    }

    .bpd-sample-imgs {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .bpd-sample-imgs img {
        width: 100%;
        max-height: 160px;
        object-fit: contain;
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 4px;
        cursor: zoom-in;
        transition: transform 0.15s ease;
    }

    .bpd-sample-imgs img:hover {
        transform: scale(1.02);
    }

    .bpd-meta-stat {
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 4px;
        padding: 6px 10px;
        margin-top: 6px;
        font-size: 11px;
        display: flex;
        justify-content: space-between;
    }

    .bpd-meta-stat span {
        color: var(--muted);
    }

    .bpd-meta-stat strong {
        color: var(--navy);
        font-weight: 700;
    }

    /* Print View */
    .print-only {
        display: none;
    }

    @media print {
        .no-print,
        .hidden-print {
            display: none !important;
        }

        .print-only {
            display: block !important;
        }

        .bpd-bar {
            display: none !important;
        }

        .bpd-panel {
            border: 1px solid #000 !important;
            margin-bottom: 8px !important;
        }

        .bpd-table > thead > tr > th {
            background: #e6ecf2 !important;
            color: #000 !important;
            border: 1px solid #000 !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .bpd-table > tbody > tr > td,
        .bpd-table > tfoot > tr > td {
            border: 1px solid #ccc !important;
            color: #000 !important;
        }

        .bpd-table tfoot .t-sub td {
            background: #eee !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
    }
</style>

<!-- Modal Preview Gambar Lightbox -->
<div class="modal fade" id="modalLihatGambarPotongan" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="background:transparent;border:none;box-shadow:none;">
            <div class="text-right" style="padding-bottom:5px;">
                <button type="button" class="close" data-dismiss="modal" style="color:#fff;opacity:1;font-size:28px;">&times;</button>
            </div>
            <div class="text-center">
                <img id="imgPreviewPotongan" src="" style="max-width:100%;max-height:85vh;border-radius:6px;background:#fff;padding:6px;box-shadow:0 10px 30px rgba(0,0,0,0.5);">
            </div>
        </div>
    </div>
</div>

<div class="bpd">
    <!-- Toolbar -->
    <div class="bpd-bar no-print">
        <h3>
            BUKU POTONGAN
            <small>PO: <?php echo $potonganHead['nama_po'] ?> <?php echo $potonganHead['kode_po'] ?></small>
        </h3>
        <div>
            <a href="<?php echo $kembali; ?>" class="btn btn-default btn-sm">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
            <?php if (!empty($pdf)): ?>
                <a href="<?php echo $pdf; ?>" target="_blank" class="btn btn-default btn-sm">
                    <i class="fa fa-file-pdf-o"></i> Download PDF
                </a>
            <?php endif; ?>
            <button onclick="window.print()" class="btn btn-navy btn-sm">
                <i class="fa fa-print"></i> Cetak / Print
            </button>
        </div>
    </div>

    <!-- Print Title Header -->
    <div class="print-only text-center" style="margin-bottom: 12px;">
        <h4 style="margin:0;font-weight:700;text-transform:uppercase;">SURAT JALAN BUKU POTONGAN</h4>
        <div style="font-size:12px;color:#555;">PO: <?php echo $potonganHead['nama_po'] ?> <?php echo $potonganHead['kode_po'] ?> | Tanggal: <?php echo date('d-m-Y', strtotime($potonganHead['created_date'])) ?></div>
    </div>

    <!-- Info PO Panel -->
    <div class="bpd-panel">
        <div class="bpd-panel-h">
            <span><i class="fa fa-info-circle mr-1"></i> Informasi Buku Potongan</span>
            <span class="text-muted" style="font-size: 10px; font-weight: normal;">ID PO: <?php echo $potonganHead['id_produksi_po'] ?? '-' ?></span>
        </div>
        <table class="table bpd-info">
            <tr>
                <td class="k">Tanggal</td>
                <td class="v"><?php echo date('d-m-Y', strtotime($potonganHead['created_date'])) ?></td>
                <td class="k">Tim Potong</td>
                <td class="v"><?php echo $tim['nama'] ?? '-' ?></td>
            </tr>
            <tr>
                <td class="k">Nama PO</td>
                <td class="v"><strong style="color:var(--navy);"><?php echo $potonganHead['nama_po'] ?> <?php echo $potonganHead['kode_po'] ?></strong></td>
                <td class="k">Jumlah Gambar</td>
                <td class="v"><?php echo $potonganHead['jumlah_gambar_utama'] ?? '0' ?></td>
            </tr>
            <tr>
                <td class="k">Size Potongan</td>
                <td class="v"><?php echo $potonganHead['size_potongan'] ?? '-' ?></td>
                <td class="k">Status</td>
                <td class="v"><span class="label label-primary" style="font-size:10px;">SELESAI POTONG</span></td>
            </tr>
        </table>
    </div>

    <!-- SECTION I: POTONGAN BAHAN UTAMA -->
    <div class="bpd-panel">
        <div class="bpd-panel-h">
            <span><i class="fa fa-cut mr-1"></i> I. Potongan Bahan Utama</span>
        </div>
        <div class="bpd-panel-b">
            <div class="row">
                <!-- Left: Sample Images & Specs -->
                <div class="col-md-3">
                    <div class="bpd-sample-box">
                        <div class="bpd-sample-title">Sample Bahan Utama</div>
                        <div class="bpd-sample-imgs">
                            <?php 
                                $hasU1 = is_valid_image_url($potonganHead['sample_bahan_utama_img'] ?? '');
                                $hasU2 = is_valid_image_url($potonganHead['sample_bahan_utama_img2'] ?? '');
                            ?>
                            <?php if ($hasU1): ?>
                                <img src="<?php echo $potonganHead['sample_bahan_utama_img'] ?>" class="img-zoomable" alt="Sample Bahan Utama 1" title="Klik untuk memperbesar">
                            <?php endif; ?>
                            <?php if ($hasU2): ?>
                                <img src="<?php echo $potonganHead['sample_bahan_utama_img2'] ?>" class="img-zoomable" alt="Sample Bahan Utama 2" title="Klik untuk memperbesar">
                            <?php endif; ?>
                            <?php if (!$hasU1 && !$hasU2): ?>
                                <div style="color:var(--muted);padding:20px 0;font-size:11px;">
                                    <i class="fa fa-image" style="font-size:24px;display:block;margin-bottom:4px;opacity:0.4;"></i>
                                    Tidak ada sample foto
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="bpd-meta-stat" style="margin-top:8px;">
                            <span>Panjang Gelaran</span>
                            <strong><?php echo $potonganHead['panjang_gelaran_potongan_utama'] ?? '-' ?></strong>
                        </div>
                        <div class="bpd-meta-stat">
                            <span>Pemakaian Bahan</span>
                            <strong><?php echo $potonganHead['jumlah_pemakaian_bahan_utama'] ?? '-' ?></strong>
                        </div>
                    </div>
                </div>

                <!-- Right: Table Detail Bahan Utama -->
                <div class="col-md-9">
                    <table class="table table-hover bpd-table">
                        <thead>
                            <tr>
                                <th class="no" style="width:36px;">No</th>
                                <th>Bidang Bahan</th>
                                <th>Warna</th>
                                <th class="ctr">Kode Bahan</th>
                                <th class="num">Berat Bahan</th>
                                <th class="num">Sisa Bahan (Kg)</th>
                                <th class="num">Pemakaian Bahan</th>
                                <th class="ctr">Banyaknya Lapis</th>
                                <th class="ctr hidden-print" style="width:50px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $noU = 0;
                            $jumPb = 0;
                            $jumBl = 0;
                            ?>
                            <?php if (!empty($potonganUtama)): ?>
                                <?php foreach ($potonganUtama as $key => $utama): ?>
                                    <tr>
                                        <td class="no"><?php echo ++$noU; ?></td>
                                        <td><?php echo $utama['bidang_bahan_potongan']; ?></td>
                                        <td><strong><?php echo $utama['warna_potongan']; ?></strong></td>
                                        <td class="ctr"><?php echo $utama['kode_bahan_potongan']; ?></td>
                                        <td class="num"><?php echo $utama['berat_bahan_potongan']; ?></td>
                                        <td class="num"><?php echo $utama['sisa_bahan_potongan']; ?></td>
                                        <td class="num font-weight-bold"><?php echo $utama['pemakaian_bahan_potongan']; ?></td>
                                        <td class="ctr font-weight-bold"><?php echo $utama['banyak_lapis_potongan']; ?></td>
                                        <td class="ctr hidden-print">
                                            <a href="<?php echo BASEURL ?>Kelolapo/hapusdetailutama/<?php echo $utama['id_potongan_utama'] ?>/<?php echo $potonganHead['kode_po'] ?>"
                                               onclick="return confirm('Apakah Anda yakin ingin menghapus data potongan utama ini?');"
                                               class="btn btn-xs btn-danger btn-del text-white"
                                               title="Hapus baris ini">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php $jumPb += (float)$utama['pemakaian_bahan_potongan']; ?>
                                    <?php $jumBl += (float)$utama['banyak_lapis_potongan']; ?>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9" class="text-center text-muted" style="padding:15px;">Belum ada rincian data potongan bahan utama.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                        <tfoot>
                            <?php
                            if ($potonganHead['nama_po'] == "HGK") {
                                $totalLusinUtama = ($jumBl * $potonganHead['jumlah_gambar_utama']) / 12;
                            } elseif ($potonganHead['nama_po'] == "HGS") {
                                $totalLusinUtama = number_format((($jumBl * $potonganHead['jumlah_gambar_utama']) / 12), 2);
                            } elseif ($potonganHead['nama_po'] == "KDT" or $potonganHead['nama_po'] == "OTF") {
                                $totalLusinUtama = ($jumBl * $potonganHead['jumlah_gambar_utama']) / 12;
                            } elseif ($potonganHead['nama_po'] == "SKW") {
                                $totalLusinUtama = ($jumBl * $potonganHead['jumlah_gambar_utama']) / 12;
                            } else {
                                $totalLusinUtama = ($jumBl * 12) / 12;
                            }
                            ?>
                            <tr class="t-sub">
                                <td colspan="6" class="text-right" style="letter-spacing:.3px;">TOTAL BAHAN UTAMA</td>
                                <td class="num font-weight-bold" style="color:var(--navy);"><?php echo $jumPb; ?></td>
                                <td class="ctr font-weight-bold" style="color:var(--navy);"><?php echo $totalLusinUtama; ?> DZ</td>
                                <td class="hidden-print"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- SECTION II: POTONGAN BAHAN VARIASI -->
    <div class="bpd-panel">
        <div class="bpd-panel-h">
            <span><i class="fa fa-layer-group mr-1"></i> II. Potongan Bahan Variasi</span>
        </div>
        <div class="bpd-panel-b">
            <div class="row">
                <!-- Left: Sample Images & Specs -->
                <div class="col-md-3">
                    <div class="bpd-sample-box">
                        <div class="bpd-sample-title">Sample Bahan Variasi</div>
                        <div class="bpd-sample-imgs">
                            <?php 
                                $hasV1 = is_valid_image_url($potonganHead['sample_bahan_variasi_img'] ?? '');
                                $hasV2 = is_valid_image_url($potonganHead['sample_bahan_variasi_img2'] ?? '');
                            ?>
                            <?php if ($hasV1): ?>
                                <img src="<?php echo $potonganHead['sample_bahan_variasi_img'] ?>" class="img-zoomable" alt="Sample Bahan Variasi 1" title="Klik untuk memperbesar">
                            <?php endif; ?>
                            <?php if ($hasV2): ?>
                                <img src="<?php echo $potonganHead['sample_bahan_variasi_img2'] ?>" class="img-zoomable" alt="Sample Bahan Variasi 2" title="Klik untuk memperbesar">
                            <?php endif; ?>
                            <?php if (!$hasV1 && !$hasV2): ?>
                                <div style="color:var(--muted);padding:20px 0;font-size:11px;">
                                    <i class="fa fa-image" style="font-size:24px;display:block;margin-bottom:4px;opacity:0.4;"></i>
                                    Tidak ada sample variasi
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="bpd-meta-stat" style="margin-top:8px;">
                            <span>Panjang Gelaran Variasi</span>
                            <strong><?php echo $potonganHead['panjang_gelaran_variasi'] ?? '-' ?></strong>
                        </div>
                        <div class="bpd-meta-stat">
                            <span>Pemakaian Bahan Variasi</span>
                            <strong><?php echo $potonganHead['jumlah_pemakaian_bahan_variasi'] ?? '-' ?></strong>
                        </div>
                    </div>
                </div>

                <!-- Right: Table Detail Bahan Variasi -->
                <div class="col-md-9">
                    <table class="table table-hover bpd-table">
                        <thead>
                            <tr>
                                <th class="no" style="width:36px;">No</th>
                                <th>Bidang Bahan</th>
                                <th>Warna</th>
                                <th class="ctr">Kode Bahan</th>
                                <th class="num">Berat Bahan</th>
                                <th class="num">Sisa Bahan</th>
                                <th class="num">Pemakaian Bahan</th>
                                <th class="ctr">Banyaknya Lapis</th>
                                <th class="ctr hidden-print" style="width:50px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $noV = 0;
                            $jumPbv = 0;
                            $jumBlv = 0;
                            ?>
                            <?php if (!empty($potonganVariasi)): ?>
                                <?php foreach ($potonganVariasi as $key => $variasi): ?>
                                    <tr>
                                        <td class="no"><?php echo ++$noV; ?></td>
                                        <td><?php echo $variasi['bidang_bahan_potongan']; ?></td>
                                        <td><strong><?php echo $variasi['warna_potongan']; ?></strong></td>
                                        <td class="ctr"><?php echo $variasi['kode_bahan_potongan']; ?></td>
                                        <td class="num"><?php echo $variasi['berat_bahan_potongan']; ?></td>
                                        <td class="num"><?php echo $variasi['sisa_bahan_potongan']; ?></td>
                                        <td class="num font-weight-bold"><?php echo $variasi['pemakaian_bahan_potongan']; ?></td>
                                        <td class="ctr font-weight-bold"><?php echo $variasi['banyak_lapis_potongan']; ?></td>
                                        <td class="ctr hidden-print">
                                            <a href="<?php echo BASEURL ?>Kelolapo/hapusdetailvariasi/<?php echo $variasi['id_potongan_utama'] ?>/<?php echo $potonganHead['kode_po'] ?>"
                                               onclick="return confirm('Apakah Anda yakin ingin menghapus data potongan variasi ini?');"
                                               class="btn btn-xs btn-danger btn-del text-white"
                                               title="Hapus baris ini">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php $jumPbv += (float)$variasi['pemakaian_bahan_potongan']; ?>
                                    <?php $jumBlv += (float)$variasi['banyak_lapis_potongan']; ?>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9" class="text-center text-muted" style="padding:15px;">Belum ada rincian data potongan variasi.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                        <tfoot>
                            <?php
                            if ($potonganHead['nama_po'] == "HGK") {
                                $totalLusinVariasi = ($jumBl * $potonganHead['jumlah_gambar_utama']) / 12;
                            } elseif ($potonganHead['nama_po'] == "HGS") {
                                $totalLusinVariasi = number_format((($jumBl * $potonganHead['jumlah_gambar_utama']) / 12), 2);
                            } elseif ($potonganHead['nama_po'] == "KDT" or $potonganHead['nama_po'] == "OTF") {
                                $totalLusinVariasi = ($jumBl * $potonganHead['jumlah_gambar_utama']) / 12;
                            } elseif ($potonganHead['nama_po'] == "SKW") {
                                $totalLusinVariasi = ($jumBl * $potonganHead['jumlah_gambar_utama']) / 12;
                            } else {
                                $totalLusinVariasi = ($jumBl * 12) / 12;
                            }
                            ?>
                            <tr class="t-sub">
                                <td colspan="6" class="text-right" style="letter-spacing:.3px;">TOTAL BAHAN VARIASI</td>
                                <td class="num font-weight-bold" style="color:var(--navy);"><?php echo $jumPbv; ?></td>
                                <td class="ctr font-weight-bold" style="color:var(--navy);"><?php echo $totalLusinVariasi; ?> DZ</td>
                                <td class="hidden-print"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Actions Toolbar -->
    <div class="bpd-bar no-print" style="border-top:1px solid var(--line);border-bottom:none;padding-top:10px;margin-top:10px;">
        <div>
            <span class="text-muted" style="font-size:11px;">Registered by Forboys Production System</span>
        </div>
        <div>
            <a href="<?php echo $kembali; ?>" class="btn btn-default btn-sm">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
            <button onclick="window.print()" class="btn btn-navy btn-sm">
                <i class="fa fa-print"></i> Cetak / Print
            </button>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        // Lightbox modal zoom saat sample gambar diklik
        $('.img-zoomable').on('click', function() {
            var src = $(this).attr('src');
            $('#imgPreviewPotongan').attr('src', src);
            $('#modalLihatGambarPotongan').modal('show');
        });
    });
</script>