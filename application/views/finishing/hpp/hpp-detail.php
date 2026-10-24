<style type="text/css">
    .hppx {
        --navy: #1e3a5f;
        --navy-lt: #eef3f9;
        --line: #dfe5ec;
        --muted: #6b7a90;
        font-size: 12px;
    }

    .hppx .row {
        margin-left: -6px;
        margin-right: -6px;
    }

    .hppx .row>[class*="col-"] {
        padding-left: 6px;
        padding-right: 6px;
    }

    /* Toolbar */
    .hppx-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 8px;
        padding-bottom: 8px;
        margin-bottom: 10px;
        border-bottom: 1px solid var(--line);
    }

    .hppx-bar h3 {
        margin: 0;
        font-size: 15px;
        font-weight: 700;
        color: var(--navy);
    }

    .hppx-bar h3 small {
        font-size: 12px;
        color: var(--muted);
        margin-left: 6px;
    }

    .hppx-bar .btn {
        font-size: 11px;
        font-weight: 600;
    }

    .hppx .btn-navy {
        background: var(--navy);
        border-color: var(--navy);
        color: #fff;
    }

    .hppx .btn-navy:hover,
    .hppx .btn-navy:focus {
        background: #152b47;
        border-color: #152b47;
        color: #fff;
    }

    /* Panel */
    .hppx-panel {
        border: 1px solid var(--line);
        border-radius: 4px;
        margin-bottom: 10px;
        background: #fff;
    }

    .hppx-panel-h {
        background: var(--navy-lt);
        color: var(--navy);
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .4px;
        padding: 5px 10px;
        border-bottom: 1px solid var(--line);
    }

    .hppx-panel-b {
        padding: 8px 10px;
    }

    /* Info table */
    .hppx-info {
        width: 100%;
        margin: 0;
    }

    .hppx-info td {
        padding: 4px 10px !important;
        border-top: none !important;
        border-bottom: 1px solid #f0f3f7;
        vertical-align: middle !important;
    }

    .hppx-info tr:last-child td {
        border-bottom: none;
    }

    .hppx-info td.k {
        width: 14%;
        color: var(--muted);
        white-space: nowrap;
    }

    .hppx-info td.v {
        width: 36%;
        font-weight: 600;
    }

    /* Cost table */
    .hppx-cost {
        margin: 0;
    }

    .hppx-cost>thead>tr>th {
        background: var(--navy);
        color: #fff !important;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        border-bottom: none;
        padding: 6px 8px;
    }

    .hppx-cost>tbody>tr>td,
    .hppx-cost>tfoot>tr>td {
        padding: 4px 8px;
        font-size: 12px;
        vertical-align: middle;
    }

    .hppx-cost .sec td {
        background: #f5f8fb;
        color: var(--navy);
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .4px;
    }

    .hppx-cost .num {
        text-align: right;
        white-space: nowrap;
    }

    .hppx-cost .ctr {
        text-align: center;
    }

    .hppx-cost .no {
        width: 36px;
        text-align: center;
    }

    .hppx-cost td.no {
        color: var(--muted);
    }

    .hppx-cost .amt {
        font-weight: 600;
    }

    .hppx-cost .note {
        color: var(--muted);
        font-size: 11px;
    }

    .hppx-cost tfoot td {
        font-weight: 700;
    }

    .hppx-cost tfoot .t-sub td {
        background: #f5f8fb;
        border-top: 2px solid var(--navy);
    }

    .hppx-cost tfoot .t-grand td {
        background: var(--navy);
        color: #fff;
        font-size: 13px;
    }

    .hppx-cost tfoot .t-pcs td {
        background: #152b47;
        color: #fff;
        font-size: 13px;
    }

    /* Sidebar */
    .hppx-side {
        position: sticky;
        top: 10px;
    }

    .hppx-img {
        text-align: center;
        position: relative;
        background: #fafbfd;
        min-height: 120px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 6px;
    }

    .hppx-img img {
        max-width: 100%;
        max-height: 220px;
        cursor: zoom-in;
    }

    .hppx-img .edit {
        position: absolute;
        top: 6px;
        right: 6px;
    }

    .hppx-spec {
        max-height: 180px;
        overflow-y: auto;
        margin: 0;
    }

    .hppx-spec td {
        padding: 3px 10px !important;
        border-top: none !important;
        border-bottom: 1px solid #f0f3f7;
        font-size: 11px;
    }

    .hppx-spec td:first-child {
        color: var(--muted);
    }

    .hppx-spec td:last-child {
        font-weight: 600;
        text-align: right;
    }

    .hppx-sum-row {
        display: flex;
        justify-content: space-between;
        padding: 4px 0;
        border-bottom: 1px dashed var(--line);
    }

    .hppx-sum-row span {
        color: var(--muted);
    }

    .hppx-sum-row b {
        font-weight: 700;
    }

    .hppx-pcs {
        text-align: center;
        background: var(--navy);
        color: #fff;
        border-radius: 4px;
        padding: 8px;
        margin-top: 8px;
    }

    .hppx-pcs small {
        display: block;
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: .5px;
        opacity: .8;
    }

    .hppx-pcs strong {
        font-size: 20px;
    }

    .hppx-opr label {
        font-size: 11px;
        color: var(--muted);
        font-weight: 600;
        margin: 8px 0 3px;
    }

    .hppx-opr .form-control {
        height: 28px;
        font-size: 12px;
        font-weight: 600;
        text-align: right;
    }

    .hppx-opr .btn {
        height: 28px;
        font-size: 11px;
    }

    /* Footer */
    .hppx-sign {
        text-align: center;
        font-size: 11px;
        color: var(--muted);
        padding-top: 4px;
    }

    .hppx-sign .sp {
        height: 50px;
    }

    .hppx-sign b {
        color: #333;
        text-decoration: underline;
    }

    /* Loader & modal */
    .loader-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, .8);
        z-index: 10000;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        font-weight: 600;
        color: #1e3a5f;
    }

    .spinner-hpp {
        width: 34px;
        height: 34px;
        border: 3px solid #dfe5ec;
        border-top-color: #1e3a5f;
        border-radius: 50%;
        animation: hppxSpin .8s linear infinite;
        margin-bottom: 10px;
    }

    @keyframes hppxSpin {
        to {
            transform: rotate(360deg);
        }
    }

    .modal-fullscreen {
        width: 100% !important;
        max-width: 100% !important;
        height: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    .modal-fullscreen .modal-content {
        height: 100% !important;
        border-radius: 0 !important;
        border: none !important;
        display: flex !important;
        flex-direction: column !important;
    }

    .modal-fullscreen .modal-body {
        flex: 1 !important;
        padding: 0 !important;
        overflow: hidden !important;
        height: auto !important;
    }

    .print-only {
        display: none;
    }

    @media print {
        .no-print {
            display: none !important;
        }

        .print-only {
            display: block !important;
        }

        .hppx .col-md-9 {
            width: 100%;
        }

        .hppx-cost thead th,
        .hppx-cost .sec td,
        .hppx-cost tfoot td {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
    }
</style>

<div class="loader-overlay" id="loadingHPP">
    <div class="spinner-hpp"></div>
    MEMPROSES...
</div>

<!-- Modal Ganti Gambar -->
<div class="modal fade" id="modalGantiGambar" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="font-size:14px;font-weight:700;">Ganti Gambar PO</h4>
            </div>
            <form action="<?php echo BASEURL . 'finishing/submitImageHppsat' ?>" enctype="multipart/form-data" method="POST" class="hpp-upload-form">
                <div class="modal-body">
                    <input type="file" name="gambarPO1" class="form-control" accept="image/*" required>
                    <input type="hidden" name="kode_po" value="<?php echo $po['kode_po'] ?>">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Lihat Gambar -->
<div class="modal fade" id="modalLihatGambar" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body text-center" style="padding:6px;">
                <img id="imgPreviewFull" src="" style="max-width:100%;">
            </div>
        </div>
    </div>
</div>

<div class="hppx">
    <!-- Toolbar -->
    <div class="hppx-bar no-print">
        <h3>HPP <?php echo $jenis ?> <small><?php echo $po['nama_hpp'] ?></small></h3>
        <div>
            <a href="<?php echo $back ?>" class="btn btn-default btn-sm"><i class="fa fa-arrow-left"></i> Kembali</a>
            <button type="button" onclick="simpanHargaSatuan()" class="btn btn-default btn-sm"><i class="fa fa-save"></i> Simpan Harga</button>
            <button type="button" onclick="cetakHPP()" class="btn btn-navy btn-sm"><i class="fa fa-print"></i> Cetak HPP</button>
        </div>
    </div>

    <div class="print-only text-center" style="font-weight:700;font-size:15px;margin-bottom:8px;">HPP <?php echo $jenis ?> &mdash; <?php echo $po['nama_hpp'] ?></div>

    <div class="row">
        <!-- ================= LEFT: INFO + COST TABLE ================= -->
        <div class="col-md-9">
            <div class="hppx-panel">
                <div class="hppx-panel-h">Informasi PO</div>
                <table class="table hppx-info">
                    <tr>
                        <td class="k">PO</td>
                        <td class="v"><?php echo $po['nama_hpp'] ?></td>
                        <td class="k">Jenis</td>
                        <td class="v"><?php echo $po['jenis_po'] ?? '-' ?></td>
                    </tr>
                    <tr>
                        <td class="k">Size</td>
                        <td class="v"><?php echo $pot['size_potongan'] ?? '-' ?></td>
                        <td class="k">Jumlah PO</td>
                        <td class="v"><?php echo isset($pot['hasil_pieces_potongan']) ? $pot['hasil_pieces_potongan'] : 0 ?> PCS / <?php echo isset($pot['hasil_lusinan_potongan']) ? $pot['hasil_lusinan_potongan'] : 0 ?> DZ</td>
                    </tr>
                    <tr>
                        <td class="k">Bahan</td>
                        <td class="v"><?php echo $namabahan['nama_item_keluar'] ?? '-' ?></td>
                        <td class="k">Tim Potong</td>
                        <td class="v"><?php echo strtoupper($timpotong ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td class="k">CMT Jahit</td>
                        <td class="v" colspan="3"><?php echo strtoupper($namacmt ?? '-') ?></td>
                    </tr>
                </table>
            </div>

            <div class="hppx-panel">
                <table class="table table-hover hppx-cost">
                    <thead>
                        <tr>
                            <th class="no">No</th>
                            <th>Perincian Biaya</th>
                            <th class="ctr" style="width:110px;">Keterangan</th>
                            <th class="num" style="width:170px;">Harga</th>
                            <th class="num" style="width:130px;">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 0;
                        $total = 0;
                        $totalAlat = 0;
                        ?>
                        <tr class="sec">
                            <td colspan="5">Bahan &amp; Potong</td>
                        </tr>
                        <?php if (isset($bahan)): ?>
                            <?php foreach ($bahan as $key => $bahanAja): ?>
                                <?php if ($bahanAja['bahan_kategori'] == "UTAMA") {
                                    $sub = (float)($bahanAja['harga_item'] ?? 0) * (float)($bukupotongan['jumlah_pemakaian_bahan_utama'] ?? 0);
                                    $totalAlat += $sub; ?>
                                    <tr>
                                        <td class="no"><?php echo ++$no ?></td>
                                        <td>BAHAN UTAMA</td>
                                        <td class="ctr"><?php echo $bukupotongan['jumlah_pemakaian_bahan_utama'] ?></td>
                                        <td class="num"><?php echo number_format((float)($bahanAja['harga_item'] ?? 0)) ?></td>
                                        <td class="num amt"><?php echo number_format($sub) ?></td>
                                    </tr>
                                <?php } else if ($bahanAja['bahan_kategori'] == "CELANA") {
                                    $sub = (float)($bahanAja['harga_item'] ?? 0) * (float)($bukupotongan['jumlah_pemakaian_bahan_variasi'] ?? 0);
                                    $totalAlat += $sub; ?>
                                    <tr>
                                        <td class="no"><?php echo ++$no ?></td>
                                        <td>BAHAN CELANA</td>
                                        <td class="ctr"><?php echo $bukupotongan['jumlah_pemakaian_bahan_variasi'] ?></td>
                                        <td class="num"><?php echo number_format((float)($bahanAja['harga_item'] ?? 0)) ?></td>
                                        <td class="num amt"><?php echo number_format($sub) ?></td>
                                    </tr>
                                <?php } else if ($bahanAja['bahan_kategori'] == "KAINKANTONG") {
                                    $sub = (float)($bahanKantong['harga_item'] ?? 0) * (float)($bahanKantong['ukuran_item_keluar'] ?? 0);
                                    $totalAlat += $sub; ?>
                                    <tr>
                                        <td class="no"><?php echo ++$no ?></td>
                                        <td><?php echo str_replace("KAINKANTONG", "KAIN - KANTONG", $bahanKantong['bahan_kategori']) ?></td>
                                        <td class="ctr"><?php echo $bahanKantong['ukuran_item_keluar'] ?></td>
                                        <td class="num"><?php echo number_format((float)($bahanKantong['harga_item'] ?? 0)) ?></td>
                                        <td class="num amt"><?php echo number_format($sub) ?></td>
                                    </tr>
                                <?php } ?>
                            <?php endforeach ?>
                            <?php if (!empty($variasi)) {
                                $sub = (float)($variasi['harga_item'] ?? 0) * (float)($variasi['ukuran_item_keluar'] ?? 0);
                                $totalAlat += $sub; ?>
                                <tr>
                                    <td class="no"><?php echo ++$no ?></td>
                                    <td>BAHAN <?php echo $variasi['bahan_kategori'] ?></td>
                                    <td class="ctr"><?php echo $variasi['ukuran_item_keluar'] ?></td>
                                    <td class="num"><?php echo number_format((float)($variasi['harga_item'] ?? 0)) ?></td>
                                    <td class="num amt"><?php echo number_format($sub) ?></td>
                                </tr>
                            <?php } ?>
                        <?php endif ?>
                        <?php if (isset($master_harga_potongan)):
                            $sub = (float)($master_harga_potongan['harga_potongan'] ?? 0) * 12;
                            $totalAlat += $sub; ?>
                            <tr>
                                <td class="no"><?php echo ++$no ?></td>
                                <td>ONGKOS POTONG</td>
                                <td class="ctr">12</td>
                                <td class="num"><?php echo number_format((float)($master_harga_potongan['harga_potongan'] ?? 0)) ?></td>
                                <td class="num amt"><?php echo number_format($sub) ?></td>
                            </tr>
                        <?php endif ?>

                        <?php if (!empty($cmt)): ?>
                            <tr class="sec">
                                <td colspan="5">CMT</td>
                            </tr>
                        <?php endif; ?>
                        <?php $bordirHitung = 0; ?>
                        <?php foreach ($cmt as $key => $cmtt): ?>
                            <?php
                            $label = '';
                            if ($cmtt['kategori_cmt'] == 'JAHIT') {
                                $label = strtoupper($cmtt['nama_cmt']);
                            } else if ($cmtt['kategori_cmt'] == 'BORDIR') {
                                $label = ($produk['nama_po'] == "PFK") ? 'LUAR' : 'DALAM';
                            } else if ($cmtt['kategori_cmt'] == 'SABLON') {
                                $label = $cmtt['id_master_cmt'] > 0 ? strtoupper($cmtt['nama_cmt']) : '';
                            }

                            if ($cmtt['kategori_cmt'] == "BORDIR") {
                                foreach ($bordirer as $hasilBordir) {
                                    $bordirHitung += ($hasilBordir['total_stich'] * (isset($hasilBordir['perkalian_tarif']) && $hasilBordir['perkalian_tarif'] > 0 ? $hasilBordir['perkalian_tarif'] : 0.18));
                                }
                                $sub = !empty($bukupotongan['hasil_lusinan_potongan']) ? (float)$bordirHitung / (float)$bukupotongan['hasil_lusinan_potongan'] : 0;
                            } else if ($cmtt['kategori_cmt'] == "SABLON") {
                                $sub = (float)($cmtt['cmt_job_price'] ?? 0) + (float)($bawahansablon ?? 0);
                            } else {
                                $sub = (float)($cmtt['cmt_job_price'] ?? 0);
                            }
                            $totalAlat += $sub;
                            ?>
                            <tr>
                                <td class="no"><?php echo ++$no ?></td>
                                <td><?php echo $cmtt['kategori_cmt'] ?><?php echo $label !== '' ? ' : ' . $label : '' ?></td>
                                <td class="ctr"></td>
                                <td class="num"></td>
                                <td class="num amt"><?php echo number_format($sub) ?></td>
                            </tr>
                        <?php endforeach ?>

                        <?php if (!empty($perincian)): ?>
                            <tr class="sec">
                                <td colspan="5">Aksesoris &amp; Bahan Pembantu</td>
                            </tr>
                        <?php endif; ?>
                        <?php $rinciItem = 0; ?>
                        <?php foreach ($perincian as $key => $rinci): ?>
                            <?php
                            $nama = strtoupper($rinci['nama_item_keluar'] ?? '');
                            $explodeBordir = explode(' ', $rinci['nama_item_keluar']);
                            $hi = (float)($rinci['harga_item'] ?? 0);
                            $qty = (float)($rinci['jumlah_item_perlusin'] ?? 0);
                            $lusin = !empty($pot['hasil_lusinan_potongan']) ? $pot['hasil_lusinan_potongan'] : 1;
                            if ($nama == "KARET 555A" || $nama == "SIMULASI KARET 555A") {
                                $sub = ($hi / 48) * $qty;
                                $hargaTxt = '<span class="note">(' . $rinci['harga_item'] . ' Roll) (' . round($hi / 48, 1) . ' Pcs)</span>';
                            } elseif ($nama == "KARET 11A") {
                                $sub = ($hi / 72) * $qty;
                                $hargaTxt = '<span class="note">(' . $rinci['harga_item'] . ' Roll) (' . round($hi / 72, 1) . ' Pcs)</span>';
                            } elseif ($nama == "PITA" || $nama == "SIMULASI PITA") {
                                $sub = 2000;
                                $hargaTxt = '<span class="note">(' . $rinci['harga_item'] . ' Roll) (' . round(((float)($rinci['jumlah_item_keluar'] ?? 0) * $hi) / $lusin) . ' Pcs)</span>';
                            } elseif ($nama == "LABEL 108") {
                                $sub = $hi * $qty;
                                $hargaTxt = number_format($hi);
                            } elseif (strtolower($explodeBordir[1] ?? '') == "bordir" || strtolower($rinci['nama_item_keluar'] ?? '') == "simulasi size bordir" || strtolower($rinci['nama_item_keluar'] ?? '') == "size bordir") {
                                $sub = 1000;
                                $hargaTxt = '<span class="note">(' . $rinci['harga_item'] . ' Roll) (' . round((float)($rinci['jumlah_item_keluar'] ?? 0) * $hi / $lusin) . ' Pcs)</span>';
                            } else {
                                $sub = $qty * $hi;
                                $hargaTxt = number_format($hi);
                            }
                            $total += $sub;
                            $rinciItem += (float)($rinci['jumlah_item_keluar'] ?? 0) * $hi;
                            ?>
                            <tr>
                                <td class="no"><?php echo ++$no ?></td>
                                <td><?php echo $rinci['nama_item_keluar'] ?></td>
                                <td class="ctr"><?php echo $rinci['jumlah_item_perlusin'] ?></td>
                                <td class="num"><?php echo $hargaTxt ?></td>
                                <td class="num amt"><?php echo number_format($sub) ?></td>
                            </tr>
                        <?php endforeach ?>

                        <tr class="sec">
                            <td colspan="5">Finishing &amp; Biaya Lain</td>
                        </tr>
                        <?php foreach ($boronganmesin as $key => $mesin): ?>
                            <?php
                            $hargapertitik = $mesin['harga_titik'] ?? 0;
                            $np = strtolower($produk['nama_po'] ?? '');
                            if ($np == "kfb" || $np == "kkf" || $np == "skf" || $np == "ksf") {
                                $hargapertitik = 30;
                            }
                            $titik = ((float)($mesin['jumlah_titik'] ?? 0)) * 12;
                            $sub = $titik * (float)$hargapertitik;
                            $total += $sub;
                            ?>
                            <tr>
                                <td class="no"><?php echo ++$no ?></td>
                                <td><?php echo strtoupper($mesin['kategori']) ?></td>
                                <td class="ctr"><?php echo $titik ?></td>
                                <td class="num"><?php echo $hargapertitik ?></td>
                                <td class="num amt"><?php echo number_format($sub) ?></td>
                            </tr>
                        <?php endforeach ?>
                        <?php foreach ($buangbenang as $key => $mesin):
                            $sub = (float)($mesin['harga'] ?? 0) * 12;
                            $total += $sub; ?>
                            <tr>
                                <td class="no"><?php echo ++$no ?></td>
                                <td>BUANG BENANG</td>
                                <td class="ctr"></td>
                                <td class="num"><?php echo $mesin['harga'] ?? 0 ?></td>
                                <td class="num amt"><?php echo number_format($sub) ?></td>
                            </tr>
                        <?php endforeach ?>
                        <?php foreach ($packing as $key => $mesin): ?>
                            <?php
                            $hargaPackingMaster = (!empty($cucianhpp['harga_packing']) && (float)$cucianhpp['harga_packing'] > 0) ? (float)$cucianhpp['harga_packing'] : 12000;
                            $harga_dz = (!empty($mesin['harga_dz']) && (float)$mesin['harga_dz'] > 0) ? (float)$mesin['harga_dz'] : $hargaPackingMaster;
                            ?>
                            <?php if (!isset($cucianhpp['idjenis']) || $cucianhpp['idjenis'] != 2):
                                $total += $harga_dz; ?>
                                <tr>
                                    <td class="no"><?php echo ++$no ?></td>
                                    <td><?php echo strtoupper((empty($mesin['keterangan']) || trim($mesin['keterangan']) == '-') ? "Packing" : $mesin['keterangan']) ?></td>
                                    <td class="ctr"></td>
                                    <td class="num"><?php echo number_format($harga_dz / 12, 0) ?></td>
                                    <td class="num amt"><?php echo number_format($harga_dz) ?></td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach ?>
                        <?php foreach ($cucian as $key => $mesin):
                            $harga = (float)($cucianhpp['cucianhpp'] ?? 0);
                            $total += $harga * 12; ?>
                            <tr>
                                <td class="no"><?php echo ++$no ?></td>
                                <td>CUCIAN</td>
                                <td class="ctr"></td>
                                <td class="num"><?php echo number_format($harga) ?></td>
                                <td class="num amt"><?php echo number_format($harga * 12) ?></td>
                            </tr>
                        <?php endforeach ?>
                        <?php if (is_array($biayalain)) {
                            foreach ($biayalain as $b) {
                                $total += (float)($b['biaya'] ?? 0); ?>
                                <tr>
                                    <td class="no"><?php echo ++$no ?></td>
                                    <td><?php echo $b['namabiaya'] ?></td>
                                    <td class="ctr"></td>
                                    <td class="num"><?php echo number_format((float)($b['biaya'] ?? 0)) ?></td>
                                    <td class="num amt"><?php echo number_format((float)($b['biaya'] ?? 0)) ?></td>
                                </tr>
                        <?php }
                        } ?>
                        <?php if (is_array($biayaperpo)) {
                            foreach ($biayaperpo as $b) {
                                $total += (float)($b['nominal'] ?? 0); ?>
                                <tr>
                                    <td class="no"><?php echo ++$no ?></td>
                                    <td><?php echo $b['nama_biaya'] ?></td>
                                    <td class="ctr">12</td>
                                    <td class="num"><?php echo number_format((float)($b['nominal'] ?? 0)) ?></td>
                                    <td class="num amt"><?php echo number_format((float)($b['nominal'] ?? 0)) ?></td>
                                </tr>
                        <?php }
                        } ?>
                    </tbody>
                    <?php
                    $totalHPP = $total + $totalAlat;
                    $opr = isset($po['operaitonal_price']) ? $po['operaitonal_price'] : 0;
                    if ($opr == 0 && isset($masterharga['hargahpp']) && $masterharga['hargahpp'] > 0) {
                        $opr = $masterharga['hargahpp'] - $totalHPP;
                    }
                    $grand = $totalHPP + (float)$opr;
                    ?>
                    <tfoot>
                        <tr class="t-sub">
                            <td colspan="4" class="num">TOTAL BIAYA PRODUKSI</td>
                            <td class="num"><?php echo number_format((float)$totalHPP) ?></td>
                        </tr>
                        <tr>
                            <td colspan="4" class="num">BIAYA OPERASIONAL</td>
                            <td class="num" id="oprText"><?php echo number_format((float)$opr) ?></td>
                        </tr>
                        <tr class="t-grand">
                            <td colspan="4" class="num">GRAND TOTAL HPP (LUSIN)</td>
                            <td class="num" id="grandTotal">Rp <?php echo number_format((float)$grand) ?></td>
                        </tr>
                        <tr class="t-pcs">
                            <td colspan="4" class="num">HARGA PER PCS</td>
                            <td class="num" id="hargaPCS">Rp <?php echo number_format((float)$grand / 12) ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- ================= RIGHT: SIDEBAR ================= -->
        <div class="col-md-3">
            <div class="hppx-side">
                <div class="hppx-panel">
                    <div class="hppx-panel-h">Gambar PO</div>
                    <div class="hppx-img">
                        <?php if (!empty($po['gambar_po'])) { ?>
                            <button type="button" class="btn btn-xs btn-navy edit no-print" data-toggle="modal" data-target="#modalGantiGambar" title="Ganti Gambar"><i class="fa fa-pencil"></i></button>
                            <img id="imgPO" src="<?php echo (strpos($po['gambar_po'], 'data:image') === 0) ? $po['gambar_po'] : BASEURL . $po['gambar_po'] ?>" alt="Gambar PO">
                        <?php } else { ?>
                            <form action="<?php echo BASEURL . 'finishing/submitImageHppsat' ?>" enctype="multipart/form-data" method="POST" class="no-print hpp-upload-form" style="width:100%;">
                                <input type="file" name="gambarPO1" class="form-control input-sm" accept="image/*" required>
                                <input type="hidden" name="kode_po" value="<?php echo $po['kode_po'] ?>">
                                <button type="submit" class="btn btn-xs btn-navy btn-block" style="margin-top:4px;">UPLOAD GAMBAR</button>
                            </form>
                        <?php } ?>
                    </div>
                </div>

                <div class="hppx-panel">
                    <div class="hppx-panel-h">Spesifikasi PO</div>
                    <div class="hppx-spec">
                        <?php if (!empty($spek)) { ?>
                            <table class="table" style="margin:0;">
                                <?php foreach ($spek as $s) { ?>
                                    <tr>
                                        <td><?php echo $s['kolom'] ?></td>
                                        <td><?php echo $s['isi'] ?></td>
                                    </tr>
                                <?php } ?>
                            </table>
                        <?php } else { ?>
                            <div class="text-muted text-center" style="padding:10px;font-size:11px;">Tidak ada spesifikasi</div>
                        <?php } ?>
                    </div>
                </div>

                <div class="hppx-panel no-print">
                    <div class="hppx-panel-h">Ringkasan</div>
                    <div class="hppx-panel-b">
                        <div class="hppx-sum-row"><span>Biaya Produksi</span><b><?php echo number_format((float)$totalHPP) ?></b></div>
                        <div class="hppx-sum-row"><span>Grand Total / Dz</span><b id="sumGrand"><?php echo number_format((float)$grand) ?></b></div>

                        <form action="<?php echo BASEURL . 'finishing/submitOperational' ?>" method="post" class="hpp-upload-form hppx-opr">
                            <label for="valOperation">Biaya Operasional</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="valOperation" id="valOperation" value="<?php echo $opr ?? 0 ?>">
                                <input type="hidden" value="<?php echo $po['kode_po'] ?>" name="kode_po">
                                <span class="input-group-btn">
                                    <button class="btn btn-navy" type="submit" name="button">UPDATE</button>
                                </span>
                            </div>
                        </form>

                        <div class="hppx-pcs">
                            <small>Harga per Pcs</small>
                            <strong id="sumPcs">Rp <?php echo number_format((float)$grand / 12) ?></strong>
                        </div>
                    </div>
                </div>

                <div class="hppx-panel">
                    <div class="hppx-sign">
                        <div>TANGGAL : <?php echo strtoupper(formatTanggalIndo(date('Y-m-d'))) ?></div>
                        <div>PARAF / ACC PIMPINAN</div>
                        <div class="sp"></div>
                        <b>( H.RICKO WENDRA )</b>
                        <div style="height:6px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Cetak -->
    <div class="modal fade" id="modalCetak" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background:#1e3a5f;color:#fff;padding:8px 14px;">
                    <button type="button" class="close" data-dismiss="modal" style="color:#fff;opacity:.8;">&times;</button>
                    <a href="<?php echo $pdf ?>" target="_blank" class="btn btn-xs btn-default pull-right" style="margin-right:12px;"><i class="fa fa-download"></i> Download PDF</a>
                    <h4 class="modal-title" style="font-size:13px;font-weight:700;">CETAK LAPORAN HPP</h4>
                </div>
                <div class="modal-body text-center" style="padding:0;">
                    <div id="pilihanCetak" style="display:none;"></div>
                    <div id="previewPDF" style="display:none;width:100%;height:100%;">
                        <iframe src="" id="pdfFrame" style="width:100%;height:100%;border:none;"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form action="<?php echo BASEURL . 'finishing/hppproduksidetailAct' ?>" method="POST" id="submit" style="display:none;">
        <input type="hidden" name="hargasatuan" value="<?php echo ($grand / 12) ?>">
        <input type="hidden" name="kodepo" value="<?php echo $po['kode_po'] ?>">
    </form>
</div>

<script type="text/javascript">
    var HPP_TOTAL_PRODUKSI = <?php echo json_encode(round((float)$totalHPP, 2)) ?>;

    function hppFmt(n) {
        return new Intl.NumberFormat('en-US', {
            maximumFractionDigits: 0
        }).format(Math.round(n));
    }

    function hppRecalc() {
        var opr = parseFloat($('#valOperation').val()) || 0;
        var grand = HPP_TOTAL_PRODUKSI + opr;
        var pcs = grand / 12;
        $('#oprText').text(hppFmt(opr));
        $('#grandTotal').text('Rp ' + hppFmt(grand));
        $('#hargaPCS').text('Rp ' + hppFmt(pcs));
        $('#sumGrand').text(hppFmt(grand));
        $('#sumPcs').text('Rp ' + hppFmt(pcs));
        $('#submit input[name="hargasatuan"]').val(pcs);
    }

    $(document).ready(function() {
        $('#valOperation').on('input', hppRecalc);

        $(window).bind('keydown', function(event) {
            if ((event.ctrlKey || event.metaKey) && (event.key === 'p' || event.key === 'P' || event.keyCode === 80)) {
                event.preventDefault();
                cetakHPP();
                return false;
            }
        });

        $('#imgPO').on('click', function() {
            $('#imgPreviewFull').attr('src', $(this).attr('src'));
            $('#modalLihatGambar').modal('show');
        });
    });

    function simpanHargaSatuan() {
        var form = $('#submit');
        $('#loadingHPP').css('display', 'flex');
        $.post(form.attr('action'), form.serialize())
            .done(function() {
                if (typeof Swal !== 'undefined') {
                    Swal({
                        title: 'Tersimpan',
                        text: 'Harga satuan berhasil disimpan.',
                        type: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            })
            .fail(function() {
                alert('Gagal menyimpan harga satuan.');
            })
            .always(function() {
                $('#loadingHPP').hide();
            });
    }

    function cetakHPP() {
        var form = $('#submit');
        $.post(form.attr('action'), form.serialize());
        $('#pilihanCetak').hide();
        $('#previewPDF').show();
        $('#modalCetak .modal-dialog').addClass('modal-fullscreen');
        $('#pdfFrame').attr('src', '<?php echo $pdf ?>');
        $('#modalCetak').modal('show');
    }

    function showPDF() {
        cetakHPP();
    }

    function hidePDF() {
        $('#modalCetak').modal('hide');
    }

    $('.hpp-upload-form').on('submit', function() {
        $('#loadingHPP').css('display', 'flex');
    });
</script>