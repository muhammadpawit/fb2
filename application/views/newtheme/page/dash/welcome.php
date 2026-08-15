<style>
    /* Modern Dashboard Custom Styles */
    .dash-section-title {
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
        margin-top: 10px;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 10px;
        letter-spacing: -0.2px;
    }

    .dash-section-title i {
        font-size: 18px;
    }

    .dash-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        margin-bottom: 20px;
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .dash-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 20px -5px rgba(0, 0, 0, 0.08), 0 4px 6px -2px rgba(0, 0, 0, 0.03);
        border-color: #cbd5e1;
    }

    .dash-card-header-bar {
        height: 4px;
        width: 100%;
        background: linear-gradient(90deg, #3c8dbc, #38bdf8);
    }

    .dash-card-body {
        padding: 18px 18px 14px 18px;
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
    }

    .dash-card-info h3 {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 4px 0;
        line-height: 1.2;
    }

    .dash-card-info p {
        font-size: 13px;
        font-weight: 500;
        color: #64748b;
        margin: 0;
        line-height: 1.4;
    }

    .dash-card-icon {
        width: 46px;
        height: 46px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
        background-color: #e0f2fe;
        color: #0284c7;
        transition: all 0.25s ease;
    }

    .dash-card-footer {
        padding: 10px 18px;
        background: #f8fafc;
        border-top: 1px solid #f1f5f9;
        font-size: 12px;
        font-weight: 600;
        color: #3c8dbc;
        display: flex;
        align-items: center;
        justify-content: space-between;
        text-decoration: none !important;
        transition: background-color 0.2s ease, color 0.2s ease;
    }

    .dash-card-footer i {
        transition: transform 0.2s ease;
    }

    .dash-card-footer:hover {
        background: #3c8dbc;
        color: #ffffff;
    }

    .dash-card-footer:hover i {
        transform: translateX(4px);
    }

    /* Container Box for Tables & Charts */
    .dash-box {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
        margin-bottom: 24px;
        overflow: hidden;
    }

    .dash-box-header {
        padding: 14px 20px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .dash-box-title {
        font-size: 15px;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .dash-box-body {
        padding: 20px;
    }

    /* Custom Table Styling */
    .dash-table {
        margin: 0;
        width: 100%;
    }

    .dash-table thead th {
        background-color: #f1f5f9 !important;
        color: #334155 !important;
        font-size: 12px !important;
        font-weight: 700 !important;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #e2e8f0 !important;
        padding: 12px 14px !important;
    }

    .dash-table tbody td {
        padding: 12px 14px !important;
        font-size: 13px !important;
        color: #1e293b !important;
        vertical-align: middle !important;
        border-bottom: 1px solid #f1f5f9 !important;
    }

    .dash-table tbody tr:hover {
        background-color: #f8fafc !important;
    }
</style>

<?php if (!empty($request)) { ?>
    <div class="dash-box" style="border-left: 4px solid #ef4444;">
        <div class="dash-box-header" style="background-color: #fef2f2;">
            <h3 class="dash-box-title" style="color: #991b1b;">
                <i class="fa fa-shield"></i> Form Request Otorisasi User
            </h3>
        </div>
        <div class="table-responsive">
            <table class="table dash-table nosearch">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>Tanggal</th>
                        <th>Nama</th>
                        <th>Keterangan</th>
                        <th width="100">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($request as $req) { ?>
                        <tr>
                            <td><?php echo $req['no'] ?></td>
                            <td><?php echo $req['tanggal'] ?></td>
                            <td><strong><?php echo $req['nama'] ?></strong></td>
                            <td><?php echo $req['keterangan'] ?></td>
                            <td>
                                <?php if (callSessUser('id_user') == '10' or callSessUser('id_user') == '11') { ?>
                                    <a href="<?php echo $req['setujui'] ?>" class="btn btn-success btn-xs text-white" style="border-radius: 6px; font-weight:600;"><i class="fa fa-check"></i> Proses</a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
<?php } ?>

<?php 
$has_pending_approval = (
    (($user['id_user'] == 11 || $user['id_user'] == 7 || $user['id_user'] == 35) && $ajuanharian > 0) ||
    $formalat_menunggu > 0 ||
    $ajuan_mingguan['kemeja'] > 0 ||
    $ajuan_mingguan['kaos'] > 0 ||
    $ajuan_mingguan['seragam'] > 0 ||
    $ajuan_mingguan['celana'] > 0 ||
    $ajuan_mingguan['bordir'] > 0 ||
    $ajuan_mingguan['konveksi'] > 0
);
?>

<?php if ($has_pending_approval) { ?>
    <div class="dash-section-title">
        <i class="fa fa-exclamation-circle" style="color: #d97706;"></i>
        <span>Pengajuan & Validasi Belum Disetujui</span>
    </div>
    <div class="row">
        <?php if (($user['id_user'] == 11 || $user['id_user'] == 7 || $user['id_user'] == 35) && $ajuanharian > 0) { ?>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="dash-card warning-card">
                    <div class="dash-card-header-bar"></div>
                    <div class="dash-card-body">
                        <div class="dash-card-info">
                            <h3><?php echo $ajuanharian ?></h3>
                            <p>Pengajuan Harian Belum Disetujui</p>
                        </div>
                        <div class="dash-card-icon">
                            <i class="fa fa-hourglass-half"></i>
                        </div>
                    </div>
                    <a href="#" class="dash-card-footer lihat-detail" data-id="ajuanharian">
                        <span>Lihat Detail</span>
                        <i class="fa fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        <?php } ?>
        
        <?php if ($formalat_menunggu > 0) { ?>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="dash-card warning-card">
                    <div class="dash-card-header-bar"></div>
                    <div class="dash-card-body">
                        <div class="dash-card-info">
                            <h3><?php echo $formalat_menunggu; ?></h3>
                            <p>Form Alat Menunggu Validasi</p>
                        </div>
                        <div class="dash-card-icon">
                            <i class="fa fa-wrench"></i>
                        </div>
                    </div>
                    <a href="<?php echo BASEURL . 'Formpengambilanalat/konveksi?status=2' ?>" class="dash-card-footer">
                        <span>Lihat Detail</span>
                        <i class="fa fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        <?php } ?>

        <?php if ($ajuan_mingguan['kemeja'] > 0) { ?>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="dash-card warning-card">
                    <div class="dash-card-header-bar"></div>
                    <div class="dash-card-body">
                        <div class="dash-card-info">
                            <h3><?php echo $ajuan_mingguan['kemeja']; ?></h3>
                            <p>Ajuan Kirim Kemeja (Belum ACC)</p>
                        </div>
                        <div class="dash-card-icon">
                            <i class="fa fa-file-text"></i>
                        </div>
                    </div>
                    <a href="<?php echo BASEURL . 'Gudang/ajuanmingguan_kemeja?spv=true' ?>" class="dash-card-footer">
                        <span>Lihat Detail</span>
                        <i class="fa fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        <?php } ?>

        <?php if ($ajuan_mingguan['kaos'] > 0) { ?>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="dash-card warning-card">
                    <div class="dash-card-header-bar"></div>
                    <div class="dash-card-body">
                        <div class="dash-card-info">
                            <h3><?php echo $ajuan_mingguan['kaos']; ?></h3>
                            <p>Ajuan Kirim Kaos (Belum ACC)</p>
                        </div>
                        <div class="dash-card-icon">
                            <i class="fa fa-file-text"></i>
                        </div>
                    </div>
                    <a href="<?php echo BASEURL . 'Gudang/ajuanmingguan?spv=true' ?>" class="dash-card-footer">
                        <span>Lihat Detail</span>
                        <i class="fa fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        <?php } ?>

        <?php if ($ajuan_mingguan['seragam'] > 0) { ?>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="dash-card warning-card">
                    <div class="dash-card-header-bar"></div>
                    <div class="dash-card-body">
                        <div class="dash-card-info">
                            <h3><?php echo $ajuan_mingguan['seragam']; ?></h3>
                            <p>Ajuan PO Seragam (Belum ACC)</p>
                        </div>
                        <div class="dash-card-icon">
                            <i class="fa fa-file-text"></i>
                        </div>
                    </div>
                    <a href="<?php echo BASEURL . 'Gudang/ajuanmingguanseragam?spv=true' ?>" class="dash-card-footer">
                        <span>Lihat Detail</span>
                        <i class="fa fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        <?php } ?>

        <?php if ($ajuan_mingguan['celana'] > 0) { ?>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="dash-card warning-card">
                    <div class="dash-card-header-bar"></div>
                    <div class="dash-card-body">
                        <div class="dash-card-info">
                            <h3><?php echo $ajuan_mingguan['celana']; ?></h3>
                            <p>Ajuan Kirim Celana (Belum ACC)</p>
                        </div>
                        <div class="dash-card-icon">
                            <i class="fa fa-file-text"></i>
                        </div>
                    </div>
                    <a href="<?php echo BASEURL . 'Gudang/ajuanmingguan_celana?spv=true' ?>" class="dash-card-footer">
                        <span>Lihat Detail</span>
                        <i class="fa fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        <?php } ?>

        <?php if ($ajuan_mingguan['bordir'] > 0) { ?>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="dash-card warning-card">
                    <div class="dash-card-header-bar"></div>
                    <div class="dash-card-body">
                        <div class="dash-card-info">
                            <h3><?php echo $ajuan_mingguan['bordir']; ?></h3>
                            <p>Ajuan Alat Bordir (Belum ACC)</p>
                        </div>
                        <div class="dash-card-icon">
                            <i class="fa fa-file-text"></i>
                        </div>
                    </div>
                    <a href="<?php echo BASEURL . 'Ajuanalatalat/1?spv=true' ?>" class="dash-card-footer">
                        <span>Lihat Detail</span>
                        <i class="fa fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        <?php } ?>

        <?php if ($ajuan_mingguan['konveksi'] > 0) { ?>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="dash-card warning-card">
                    <div class="dash-card-header-bar"></div>
                    <div class="dash-card-body">
                        <div class="dash-card-info">
                            <h3><?php echo $ajuan_mingguan['konveksi']; ?></h3>
                            <p>Ajuan Alat Konveksi (Belum ACC)</p>
                        </div>
                        <div class="dash-card-icon">
                            <i class="fa fa-file-text"></i>
                        </div>
                    </div>
                    <a href="<?php echo BASEURL . 'Ajuanalatalat/2?spv=true' ?>" class="dash-card-footer">
                        <span>Lihat Detail</span>
                        <i class="fa fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        <?php } ?>
    </div>
<?php } ?>

<div class="dash-section-title">
    <i class="fa fa-tachometer" style="color: #0284c7;"></i>
    <span>Monitoring Produksi & Status PO</span>
</div>
<div class="row">
    <div class="col-lg-3 col-md-4 col-sm-6">
        <div class="dash-card danger-card">
            <div class="dash-card-header-bar"></div>
            <div class="dash-card-body">
                <div class="dash-card-info">
                    <h3><?php echo $countpendingpo ?> <span style="font-size:13px; font-weight:600; color:#94a3b8;">PO</span></h3>
                    <p>Belum dikirim ke gudang (>1 bln)</p>
                </div>
                <div class="dash-card-icon">
                    <i class="fa fa-history"></i>
                </div>
            </div>
            <a href="#" class="dash-card-footer lihat-detail" data-id="<?php echo $countpendingpo ?>">
                <span>Lihat Detail</span>
                <i class="fa fa-arrow-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-md-4 col-sm-6">
        <div class="dash-card success-card">
            <div class="dash-card-header-bar"></div>
            <div class="dash-card-body">
                <div class="dash-card-info">
                    <h3><?php echo $countpacking ?> <span style="font-size:13px; font-weight:600; color:#94a3b8;">PO</span></h3>
                    <p>Selesai Packing</p>
                </div>
                <div class="dash-card-icon">
                    <i class="fa fa-cubes"></i>
                </div>
            </div>
            <a href="#" class="dash-card-footer lihat-detail" data-id="packing">
                <span>Lihat Detail</span>
                <i class="fa fa-arrow-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-md-4 col-sm-6">
        <div class="dash-card info-card">
            <div class="dash-card-header-bar"></div>
            <div class="dash-card-body">
                <div class="dash-card-info">
                    <h3><?php echo $countpenerimaancmtmingguini ?> <span style="font-size:13px; font-weight:600; color:#94a3b8;">PO</span></h3>
                    <p>Setoran CMT Minggu Ini</p>
                </div>
                <div class="dash-card-icon">
                    <i class="fa fa-truck"></i>
                </div>
            </div>
            <a href="#" class="dash-card-footer lihat-detail" data-id="setorcmt">
                <span>Lihat Detail</span>
                <i class="fa fa-arrow-right"></i>
            </a>
        </div>
    </div>

    <!-- Buang Benang -->
    <div class="col-lg-3 col-md-4 col-sm-6">
        <div class="dash-card purple-card">
            <div class="dash-card-header-bar"></div>
            <div class="dash-card-body">
                <div class="dash-card-info">
                    <h3><?php echo $buangBenang ?> <span style="font-size:13px; font-weight:600; color:#94a3b8;">PO</span></h3>
                    <p>Buang Benang</p>
                </div>
                <div class="dash-card-icon">
                    <i class="fa fa-scissors"></i>
                </div>
            </div>
            <a href="#" class="dash-card-footer lihat-detail" data-id="buangbenang">
                <span>Lihat Detail</span>
                <i class="fa fa-arrow-right"></i>
            </a>
        </div>
    </div>

    <!-- Cucian -->
    <div class="col-lg-3 col-md-4 col-sm-6">
        <div class="dash-card teal-card">
            <div class="dash-card-header-bar"></div>
            <div class="dash-card-body">
                <div class="dash-card-info">
                    <h3><?php echo $Cucian ?> <span style="font-size:13px; font-weight:600; color:#94a3b8;">PO</span></h3>
                    <p>Cucian</p>
                </div>
                <div class="dash-card-icon">
                    <i class="fa fa-tint"></i>
                </div>
            </div>
            <a href="#" class="dash-card-footer lihat-detail" data-id="cucian">
                <span>Lihat Detail</span>
                <i class="fa fa-arrow-right"></i>
            </a>
        </div>
    </div>

    <!-- Lubang Kancing -->
    <div class="col-lg-3 col-md-4 col-sm-6">
        <div class="dash-card info-card">
            <div class="dash-card-header-bar"></div>
            <div class="dash-card-body">
                <div class="dash-card-info">
                    <h3><?php echo $lk ?> <span style="font-size:13px; font-weight:600; color:#94a3b8;">PO</span></h3>
                    <p>Lubang Kancing</p>
                </div>
                <div class="dash-card-icon">
                    <i class="fa fa-ellipsis-v"></i>
                </div>
            </div>
            <a href="#" class="dash-card-footer lihat-detail" data-id="lubangkancing">
                <span>Lihat Detail</span>
                <i class="fa fa-arrow-right"></i>
            </a>
        </div>
    </div>

    <!-- Pasang Kancing -->
    <div class="col-lg-3 col-md-4 col-sm-6">
        <div class="dash-card info-card">
            <div class="dash-card-header-bar"></div>
            <div class="dash-card-body">
                <div class="dash-card-info">
                    <h3><?php echo $pk ?> <span style="font-size:13px; font-weight:600; color:#94a3b8;">PO</span></h3>
                    <p>Pasang Kancing</p>
                </div>
                <div class="dash-card-icon">
                    <i class="fa fa-bullseye"></i>
                </div>
            </div>
            <a href="#" class="dash-card-footer lihat-detail" data-id="pasangkancing">
                <span>Lihat Detail</span>
                <i class="fa fa-arrow-right"></i>
            </a>
        </div>
    </div>

    <!-- Tress -->
    <div class="col-lg-3 col-md-4 col-sm-6">
        <div class="dash-card purple-card">
            <div class="dash-card-header-bar"></div>
            <div class="dash-card-body">
                <div class="dash-card-info">
                    <h3><?php echo $tress ?> <span style="font-size:13px; font-weight:600; color:#94a3b8;">PO</span></h3>
                    <p>Tress</p>
                </div>
                <div class="dash-card-icon">
                    <i class="fa fa-bookmark"></i>
                </div>
            </div>
            <a href="#" class="dash-card-footer lihat-detail" data-id="tress">
                <span>Lihat Detail</span>
                <i class="fa fa-arrow-right"></i>
            </a>
        </div>
    </div>

    <!-- Sablon Kirim -->
    <div class="col-lg-3 col-md-4 col-sm-6">
        <div class="dash-card info-card">
            <div class="dash-card-header-bar"></div>
            <div class="dash-card-body">
                <div class="dash-card-info">
                    <h3><?php echo $sablonKirim ?> <span style="font-size:13px; font-weight:600; color:#94a3b8;">PO</span></h3>
                    <p>Pengiriman Sablon Minggu Ini</p>
                </div>
                <div class="dash-card-icon">
                    <i class="fa fa-paper-plane"></i>
                </div>
            </div>
            <a href="#" class="dash-card-footer lihat-detail" data-id="sablonkirim">
                <span>Lihat Detail</span>
                <i class="fa fa-arrow-right"></i>
            </a>
        </div>
    </div>

    <!-- Sablon Setor -->
    <div class="col-lg-3 col-md-4 col-sm-6">
        <div class="dash-card success-card">
            <div class="dash-card-header-bar"></div>
            <div class="dash-card-body">
                <div class="dash-card-info">
                    <h3><?php echo $sablonSetor ?> <span style="font-size:13px; font-weight:600; color:#94a3b8;">PO</span></h3>
                    <p>Setoran Sablon Minggu Ini</p>
                </div>
                <div class="dash-card-icon">
                    <i class="fa fa-inbox"></i>
                </div>
            </div>
            <a href="#" class="dash-card-footer lihat-detail" data-id="sablonsetor">
                <span>Lihat Detail</span>
                <i class="fa fa-arrow-right"></i>
            </a>
        </div>
    </div>

    <!-- PO Masih di CMT -->
    <div class="col-lg-3 col-md-4 col-sm-6">
        <div class="dash-card warning-card">
            <div class="dash-card-header-bar"></div>
            <div class="dash-card-body">
                <div class="dash-card-info">
                    <h3><?php echo $countpoCmt ?> <span style="font-size:13px; font-weight:600; color:#94a3b8;">PO</span></h3>
                    <p>PO Masih di CMT</p>
                </div>
                <div class="dash-card-icon">
                    <i class="fa fa-users"></i>
                </div>
            </div>
            <a href="#" class="dash-card-footer lihat-detail" data-id="pocmt">
                <span>Lihat Detail</span>
                <i class="fa fa-arrow-right"></i>
            </a>
        </div>
    </div>
</div>

<?php if (!empty($harian)) { ?>
    <?php if ($user['id_user'] == 11 || $user['id_user'] == 7 || $user['id_user'] == 35) { ?>
        <div class="dash-box" style="margin-top: 10px;">
            <div class="dash-box-header">
                <h3 class="dash-box-title">
                    <i class="fa fa-money" style="color:#10b981;"></i> Data Pengajuan Harian
                </h3>
            </div>
            <div class="dash-box-body" style="padding: 0;">
                <div class="table-responsive">
                    <table class="table dash-table">
                        <thead>
                            <tr>
                                <th width="60" class="text-center">Ttd</th>
                                <th>Hari, Tanggal</th>
                                <th>Divisi / Cabang</th>
                                <th class="text-right">Cash (Rp)</th>
                                <th class="text-right">Transfer (Rp)</th>
                                <th class="text-right">Total (Rp)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($harian as $key => $us): ?>
                                <tr>
                                    <?php $hari = date('l', strtotime($us['tanggal'])) ?>
                                    <td class="text-center">
                                        <?php if ($us['status'] == 0) { ?>
                                            <?php if ($id_user == 7 || $id_user == 11) { ?>
                                                <a href="#" class="btn btn-primary btn-xs text-white ttdDigital" data-id="<?php echo $us['id']; ?>" data-toggle="modal" data-target="#detailModalTtd" style="border-radius:4px;"><i class="fa fa-pencil"></i></a>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <span class="label label-success" style="padding:4px 8px; border-radius:12px;"><i class="fa fa-check"></i> ACC</span>
                                        <?php } ?>
                                    </td>
                                    <td><strong><?php echo hari($hari) . ', ' . formatTanggalIndo($us['tanggal']) ?></strong></td>
                                    <td>
                                        <?php
                                        if ($us['kategori'] == 1) {
                                            echo "<span class='label label-primary' style='background-color:#3b82f6;'>Sablon</span>";
                                        } else if ($us['kategori'] == 2) {
                                            echo "<span class='label label-primary' style='background-color:#8b5cf6;'>Bordir</span>";
                                        } else if ($us['kategori'] == 3) {
                                            echo "<span class='label label-primary' style='background-color:#0d9488;'>Konveksi</span>";
                                        } else if ($us['kategori'] == 4) {
                                            echo "<span class='label label-primary' style='background-color:#f97316;'>Sukabumi</span>";
                                        }

                                        if (!empty($us['from_mingguan'])) {
                                            echo ' <small class="text-muted">(Mingguan)</small>';
                                        } else {
                                            echo ' <small class="text-muted">(Harian)</small>';
                                        }
                                        ?>
                                    </td>
                                    <td align="right" style="font-family: monospace; font-size:13px; font-weight:600;"><?php echo number_format($us['cash']) ?></td>
                                    <td align="right" style="font-family: monospace; font-size:13px; font-weight:600;"><?php echo number_format($us['transfer']) ?></td>
                                    <td align="right" style="font-family: monospace; font-size:13px; font-weight:700; color:#059669;"><?php echo number_format($us['cash'] + $us['transfer']) ?></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php } ?>
<?php } ?>

<div class="row">
    <div class="col-md-6">
        <div class="dash-box">
            <div class="dash-box-header">
                <h3 class="dash-box-title">
                    <i class="fa fa-bar-chart" style="color:#3b82f6;"></i> Grafik Produksi Potongan Perbulan
                </h3>
            </div>
            <div class="dash-box-body">
                <div id="container" style="width:100%; height:380px;"></div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="dash-box">
            <div class="dash-box-header">
                <h3 class="dash-box-title">
                    <i class="fa fa-align-left" style="color:#8b5cf6;"></i> Grafik Alat Keluar
                </h3>
            </div>
            <div class="dash-box-body">
                <div id="grafik_alat" style="width:100%; height:380px;"></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detailModalTtd" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Persetujuan Digital</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="signatureModal">
            </div>
            <div class="modal-footer">
                <button id="clear_signature">Clear</button>
                <button id="save_signature">Save Signature</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="detailContent">
                <!-- Isi tabel dari AJAX -->
            </div>
        </div>
    </div>
</div>


<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script>
    Highcharts.chart('container', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Grafik Produksi Potongan Perbulan'
        },
        subtitle: {
            text: 'www.forboysproduction.com'
        },
        xAxis: {
            categories: <?php echo $bulan ?>,
            crosshair: true,
            labels: {
                style: {
                    fontSize: '12px', // ukuran teks di bawah chart
                    fontWeight: 'bold' // opsional
                }
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Potongan (dz)'
            }
        },
        tooltip: {
            headerFormat: '<span>{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f} dz</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0,
                dataLabels: {
                    enabled: true, // aktifkan label di atas batang
                    format: '{y:.1f} dz', // format label
                    style: {
                        fontSize: '11px',
                        fontWeight: 'bold'
                    }
                }
            }
        },
        legend: {
            itemStyle: {
                fontSize: '11px',
                fontWeight: 'bold'
            }
        },
        series: [

            <?php foreach ($po as $p) { ?> {
                    name: '<?php echo $p['namapo'] ?>',
                    data: [<?php echo implode(",", $p['lusin']) ?>]
                },
            <?php } ?>
        ]
    });

    Highcharts.chart('grafik_alat', {
        chart: {
            type: 'bar'
        },
        title: {
            text: 'Grafik Jumlah Alat Keluar Periode <?php echo formatTanggalIndo($tanggal1) . " - " . formatTanggalIndo($tanggal2); ?>'
        },
        xAxis: {
            categories: <?php echo json_encode($alat); ?>,
            labels: {
                style: {
                    fontSize: '12px'
                }
            },
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Jumlah Keluar '
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y}</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            bar: { // karena chart: 'bar'
                pointPadding: 0.2,
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    // format: '{point.y}', // angka langsung
                    formatter: function() {
                        let satuan = <?php echo json_encode($satuan_alat); ?>;
                        return this.y + ' ' + satuan[this.point.index];
                    },
                    style: {
                        fontSize: '11px',
                        fontWeight: 'bold'
                    }
                }
            }
        },
        series: [{
            name: 'Jumlah',
            data: <?php echo json_encode($jumlah_alat, JSON_NUMERIC_CHECK); ?>
        }]
    });


    $(document).on("click", ".lihat-detail", function(e) {
        e.preventDefault();

        $("#detailContent").html("Loading...");
        $("#detailModal").modal("show");

        let id = $(this).attr("data-id");

        if (id == 'packing') {
            $.ajax({
                url: "<?php echo BASEURL ?>Dash/packingjson",
                type: "GET",
                dataType: "json",
                success: function(res) {
                    if (res.length > 0) {
                        let html = `
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode PO</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                    `;
                        let no = 1;
                        res.forEach(row => {
                            html += `
                            <tr>
                                <td>${no}</td>
                                <td>${row.nama_po}</td>
                                <td>${row.creted_date}</td>
                            </tr>
                        `;
                            no++;
                        });

                        html += `</tbody></table>`;
                        $("#detailContent").html(html);
                    } else {
                        $("#detailContent").html("<em>Tidak ada data</em>");
                    }
                },
                error: function(xhr) {
                    $("#detailContent").html("<span class='text-danger'>Gagal memuat data.</span>");
                }
            });
        } else if (id == 'setorcmt') {
            $.ajax({
                url: "<?php echo BASEURL ?>Dash/setorjson",
                type: "GET",
                dataType: "json",
                success: function(res) {
                    if (res.length > 0) {
                        let html = `
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode PO</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                    `;
                        let no = 1;
                        res.forEach(row => {
                            html += `
                            <tr>
                                <td>${no}</td>
                                <td>${row.nama_po}</td>
                                <td>${row.tanggal}</td>
                            </tr>
                        `;
                            no++;
                        });

                        html += `</tbody></table>`;
                        $("#detailContent").html(html);
                    } else {
                        $("#detailContent").html("<em>Tidak ada data</em>");
                    }
                },
                error: function(xhr) {
                    $("#detailContent").html("<span class='text-danger'>Gagal memuat data.</span>");
                }
            });
        } else if (id == 'ajuanharian') {
            $.ajax({
                url: "<?php echo BASEURL ?>Dash/ajuanharianjson",
                type: "GET",
                dataType: "json",
                success: function(res) {
                    if (res.length > 0) {
                        let html = `
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Total Ajuan Cash</th>
                                    <th>Total Ajuan Transfer</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                    `;
                        let no = 1;
                        res.forEach(row => {
                            html += `
                            <tr>
                                <td>${no}</td>
                                <td>${row.cash}</td>
                                <td>${row.transfer}</td>
                                <td>${row.tanggal}</td>
                            </tr>
                        `;
                            no++;
                        });

                        html += `</tbody></table>`;
                        $("#detailContent").html(html);
                    } else {
                        $("#detailContent").html("<em>Tidak ada data</em>");
                    }
                },
                error: function(xhr) {
                    $("#detailContent").html("<span class='text-danger'>Gagal memuat data.</span>");
                }
            });
        } else if (id == 'buangbenang') {
            $.ajax({
                url: "<?php echo BASEURL ?>Dash/buangbenang",
                type: "GET",
                dataType: "json",
                success: function(res) {
                    if (res.length > 0) {
                        let html = `
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode PO</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                    `;
                        let no = 1;
                        res.forEach(row => {
                            html += `
                            <tr>
                                <td>${no}</td>
                                <td>${row.kode_po}</td>
                                <td>${row.tanggal}</td>
                            </tr>
                        `;
                            no++;
                        });

                        html += `</tbody></table>`;
                        $("#detailContent").html(html);
                    } else {
                        $("#detailContent").html("<em>Tidak ada data</em>");
                    }
                },
                error: function(xhr) {
                    $("#detailContent").html("<span class='text-danger'>Gagal memuat data.</span>");
                }
            });
        } else if (id == 'cucian') {
            $.ajax({
                url: "<?php echo BASEURL ?>Dash/cucian",
                type: "GET",
                dataType: "json",
                success: function(res) {
                    if (res.length > 0) {
                        let html = `
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode PO</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                    `;
                        let no = 1;
                        res.forEach(row => {
                            html += `
                            <tr>
                                <td>${no}</td>
                                <td>${row.kode_po}</td>
                                <td>${row.tanggal}</td>
                            </tr>
                        `;
                            no++;
                        });

                        html += `</tbody></table>`;
                        $("#detailContent").html(html);
                    } else {
                        $("#detailContent").html("<em>Tidak ada data</em>");
                    }
                },
                error: function(xhr) {
                    $("#detailContent").html("<span class='text-danger'>Gagal memuat data.</span>");
                }
            });
        } else if (id == 'lubangkancing') {
            $.ajax({
                url: "<?php echo BASEURL ?>Dash/borongan/1",
                type: "GET",
                dataType: "json",
                success: function(res) {
                    if (res.length > 0) {
                        let html = `
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode PO</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                    `;
                        let no = 1;
                        res.forEach(row => {
                            html += `
                            <tr>
                                <td>${no}</td>
                                <td>${row.nama_po}</td>
                                <td>${row.creted_date}</td>
                            </tr>
                        `;
                            no++;
                        });

                        html += `</tbody></table>`;
                        $("#detailContent").html(html);
                    } else {
                        $("#detailContent").html("<em>Tidak ada data</em>");
                    }
                },
                error: function(xhr) {
                    $("#detailContent").html("<span class='text-danger'>Gagal memuat data.</span>");
                }
            });
        } else if (id == 'pasangkancing') {
            $.ajax({
                url: "<?php echo BASEURL ?>Dash/borongan/2",
                type: "GET",
                dataType: "json",
                success: function(res) {
                    if (res.length > 0) {
                        let html = `
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode PO</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                    `;
                        let no = 1;
                        res.forEach(row => {
                            html += `
                            <tr>
                                <td>${no}</td>
                                <td>${row.nama_po}</td>
                                <td>${row.creted_date}</td>
                            </tr>
                        `;
                            no++;
                        });

                        html += `</tbody></table>`;
                        $("#detailContent").html(html);
                    } else {
                        $("#detailContent").html("<em>Tidak ada data</em>");
                    }
                },
                error: function(xhr) {
                    $("#detailContent").html("<span class='text-danger'>Gagal memuat data.</span>");
                }
            });
        } else if (id == 'tress') {
            $.ajax({
                url: "<?php echo BASEURL ?>Dash/borongan/3",
                type: "GET",
                dataType: "json",
                success: function(res) {
                    if (res.length > 0) {
                        let html = `
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode PO</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                    `;
                        let no = 1;
                        res.forEach(row => {
                            html += `
                            <tr>
                                <td>${no}</td>
                                <td>${row.nama_po}</td>
                                <td>${row.creted_date}</td>
                            </tr>
                        `;
                            no++;
                        });

                        html += `</tbody></table>`;
                        $("#detailContent").html(html);
                    } else {
                        $("#detailContent").html("<em>Tidak ada data</em>");
                    }
                },
                error: function(xhr) {
                    $("#detailContent").html("<span class='text-danger'>Gagal memuat data.</span>");
                }
            });
        } else if (id == 'sablonkirim') {
            $.ajax({
                url: "<?php echo BASEURL ?>Dash/produksi/SABLON/KIRIM",
                type: "GET",
                dataType: "json",
                success: function(res) {
                    if (res.length > 0) {
                        let html = `
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode PO</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                    `;
                        let no = 1;
                        res.forEach(row => {
                            html += `
                            <tr>
                                <td>${no}</td>
                                <td>${row.kode_po}</td>
                                <td>${row.create_date}</td>
                            </tr>
                        `;
                            no++;
                        });

                        html += `</tbody></table>`;
                        $("#detailContent").html(html);
                    } else {
                        $("#detailContent").html("<em>Tidak ada data</em>");
                    }
                },
                error: function(xhr) {
                    $("#detailContent").html("<span class='text-danger'>Gagal memuat data.</span>");
                }
            });
        } else if (id == 'pocmt') {
            $.ajax({
                url: "<?php echo BASEURL ?>Dash/poCmtJson",
                type: "GET",
                dataType: "json",
                success: function(res) {
                    if (res.length > 0) {
                        let html = `
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode PO</th>
                                    <th>Tanggal Kirim</th>
                                    <th>Proses</th>
                                    <th>Nama CMT</th>
                                </tr>
                            </thead>
                            <tbody>
                    `;
                        let no = 1;
                        res.forEach(row => {
                            html += `
                            <tr>
                                <td>${no}</td>
                                <td>${row.nama_po}</td>
                                <td>${row.creted_date}</td>
                                <td>${row.proses}</td>
                                <td>${row.nama_cmt}</td>
                            </tr>
                        `;
                            no++;
                        });

                        html += `</tbody></table>`;
                        $("#detailContent").html(html);
                    } else {
                        $("#detailContent").html("<em>Tidak ada data</em>");
                    }
                },
                error: function(xhr) {
                    $("#detailContent").html("<span class='text-danger'>Gagal memuat data.</span>");
                }
            });
        } else if (id == 'sablonsetor') {
            $.ajax({
                url: "<?php echo BASEURL ?>Dash/produksi/SABLON/SETOR",
                type: "GET",
                dataType: "json",
                success: function(res) {
                    if (res.length > 0) {
                        let html = `
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode PO</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                    `;
                        let no = 1;
                        res.forEach(row => {
                            html += `
                            <tr>
                                <td>${no}</td>
                                <td>${row.kode_po}</td>
                                <td>${row.create_date}</td>
                            </tr>
                        `;
                            no++;
                        });

                        html += `</tbody></table>`;
                        $("#detailContent").html(html);
                    } else {
                        $("#detailContent").html("<em>Tidak ada data</em>");
                    }
                },
                error: function(xhr) {
                    $("#detailContent").html("<span class='text-danger'>Gagal memuat data.</span>");
                }
            });
        } else {
            $.ajax({
                url: "<?php echo BASEURL ?>Dash/pendingpojson",
                type: "GET",
                dataType: "json",
                success: function(res) {
                    if (res.length > 0) {
                        let html = `
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode PO</th>
                                    <th>Tanggal</th>
                                    <th>Posisi</th>
                                </tr>
                            </thead>
                            <tbody>
                    `;
                        let no = 1;
                        res.forEach(row => {
                            html += `
                            <tr>
                                <td>${no}</td>
                                <td>${row.kode_po}</td>
                                <td>${row.created_date}</td>
                                <td>${row.posisi}</td>
                            </tr>
                        `;
                            no++;
                        });

                        html += `</tbody></table>`;
                        $("#detailContent").html(html);
                    } else {
                        $("#detailContent").html("<em>Tidak ada data</em>");
                    }
                },
                error: function(xhr) {
                    $("#detailContent").html("<span class='text-danger'>Gagal memuat data.</span>");
                }
            });
        }

    });
</script>

<style>
    canvas {
        margin: 10vh 5px !important;
        height: 250px !important;
    }

    #signature {
        width: 100%;
        height: 300px;
        border: 1px solid #000;
        background-color: #fff;
    }

    .modal-footer button {
        margin: 5px;
    }

    #clear_signature,
    #save_signature {
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 4px;
        cursor: pointer;
    }

    #clear_signature:hover,
    #save_signature:hover {
        background-color: #0056b3;
    }

    .modal-body {
        padding: 20px;
        overflow: hidden;
    }

    #signature {
        max-width: 100%;
        max-height: 100%;
    }
</style>
<script src="<?php echo BASEURL ?>jSignature/src/jSignature.js"></script>
<script>
    $(document).ready(function() {

        // jSignature diinisialisasi di AJAX success callback dengan setTimeout

        // $("#signature-pad").jSignature();

        $('#clear_signature').click(function() {
            $("#signature-pad").jSignature("reset");
        });
        $('#save_signature').click(function() {
            var $sigdiv = window.currentSigPad || $("#detailModalTtd #signature-pad");
            if ($sigdiv.length == 0 || !$sigdiv.jSignature) {
                $sigdiv = $(".jSignature").last();
            }
            var data = $sigdiv.jSignature("getData", "image");
            var imgData = Array.isArray(data) ? data.join(",") : data;
            var idajuan = $("#idajuan").val();

            if (!imgData || imgData.length < 100) {
                var len = imgData ? imgData.length : 0;
                var info = (typeof $.fn.jSignature === 'undefined') ? ' (Lib Not Found)' : ' (Len: ' + len + ')';
                Swal({
                    type: 'warning',
                    title: 'Tanda tangan kosong',
                    text: 'Silakan tanda tangan terlebih dahulu pada panel yang disediakan.' + info
                });
                return false;
            }

            var $btn = $(this);
            var originalText = $btn.html();
            $btn.html('<i class="fa fa-spinner fa-spin"></i> Menyimpan...').attr('disabled', true);

            var formData = new FormData();
            formData.append('image_data', imgData);
            formData.append('id', idajuan);

            $.ajax({
                url: "<?= BASEURL ?>Gudang/ttdsave",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.indexOf('successfully') !== -1) {
                        Swal({
                            title: 'Berhasil',
                            text: response,
                            type: 'success',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        // Gunakan setTimeout sebagai ganti Promise untuk kompatibilitas ke versi jadul
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    } else {
                        $btn.html(originalText).attr('disabled', false);
                        Swal({
                            title: 'Gagal',
                            text: response,
                            type: 'error'
                        });
                    }
                },
                error: function(xhr) {
                    $btn.html(originalText).attr('disabled', false);
                    Swal({
                        title: 'Error',
                        text: 'Terjadi kesalahan: ' + xhr.statusText,
                        type: 'error'
                    });
                }
            });
        });

        $('.modals').on('click', function() {
            var id = $(this).data('id'); // Ambil ID dari atribut data-id
            $('#idajuan').val(id); // Masukkan ID ke input dalam modal

            // Anda bisa menambahkan logika AJAX di sini jika ingin mengambil data dari server
            // Contoh logika AJAX untuk mengambil data:
            $.ajax({
                url: '<?php echo BASEURL; ?>Gudang/getRealisasiDetail', // Sesuaikan URL untuk mengambil data
                method: 'GET',
                data: {
                    id: id
                },
                success: function(response) {
                    // Asumsikan response berisi HTML atau data yang ingin Anda tampilkan di modal
                    $('#detailModal .modal-body').html(response);
                },
                error: function() {
                    $('#detailModal .modal-body').html('<p>Terjadi kesalahan, data tidak dapat ditampilkan.</p>');
                }
            });
        });

        $('.ttdDigital').on('click', function() {
            var id = $(this).data('id'); // Ambil ID dari atribut data-id
            $('#idajuan').val(id); // Masukkan ID ke input dalam modal

            // Anda bisa menambahkan logika AJAX di sini jika ingin mengambil data dari server
            // Contoh logika AJAX untuk mengambil data:
            $.ajax({
                url: '<?php echo BASEURL; ?>Gudang/getRealisasiDetailTtd', // Sesuaikan URL untuk mengambil data
                method: 'GET',
                data: {
                    id: id
                },
                success: function(response) {
                    // Asumsikan response berisi HTML atau data yang ingin Anda tampilkan di modal
                    var $modal = $('#detailModalTtd');
                    $modal.find('#signatureModal').html(response);

                    // Init jSignature setelah DOM di-render dan modal stabil
                    setTimeout(function() {
                        var $pad = $modal.find('#signature-pad');
                        if ($pad.length > 0) {
                            // Hancurkan instansi lama jika ada
                            try {
                                $pad.jSignature('destroy');
                            } catch (e) {}
                            // Inisialisasi baru
                            $pad.jSignature();
                            window.currentSigPad = $pad;
                        }
                    }, 1000);
                },
                error: function() {
                    $('#detailModal .modal-body').html('<p>Terjadi kesalahan, data tidak dapat ditampilkan.</p>');
                }
            });
        });

        $('.nota').on('click', function() {
            var id = $(this).data('id'); // Ambil ID dari atribut data-id
            $('#idajuan').val(id); // Masukkan ID ke input dalam modal

            // Anda bisa menambahkan logika AJAX di sini jika ingin mengambil data dari server
            // Contoh logika AJAX untuk mengambil data:
            $.ajax({
                url: '<?php echo BASEURL; ?>Gudang/getiD', // Sesuaikan URL untuk mengambil data
                method: 'GET',
                data: {
                    id: id
                },
                success: function(response) {
                    // Asumsikan response berisi HTML atau data yang ingin Anda tampilkan di modal
                    $('#idnota').val(response);
                },
                error: function() {
                    $('#detailModalNota .modal-body').html('<p>Terjadi kesalahan, data tidak dapat ditampilkan.</p>');
                }
            });
        });
    });
</script>
<script type="text/javascript">
    function filter() {
        var url = '?';
        var tanggal1 = $("#tanggal1").val();
        var tanggal2 = $("#tanggal2").val();
        var cat = $("#cat").val();

        if (tanggal1) {
            url += '&tanggal1=' + tanggal1;
        }

        if (tanggal2) {
            url += '&tanggal2=' + tanggal2;
        }

        if (cat != "*") {
            url += '&cat=' + cat;
        }

        location = url;
    }

    function excel() {
        var url = '?excel=1';
        var tanggal1 = $("#tanggal1").val();
        var tanggal2 = $("#tanggal2").val();
        var cat = $("#cat").val();
        if (tanggal1) {
            url += '&tanggal1=' + tanggal1;
        }

        if (tanggal2) {
            url += '&tanggal2=' + tanggal2;
        }

        if (cat != "*") {
            url += '&cat=' + cat;
        }

        location = url;
    }
</script>