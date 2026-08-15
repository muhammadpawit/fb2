<style>
    /* Dashboard Modern Custom Styling */
    .dash-nav-pills {
        background: #f1f5f9;
        padding: 5px;
        border-radius: 12px;
        display: inline-flex;
        gap: 6px;
        border: 1px solid #e2e8f0;
        margin-bottom: 20px;
    }

    .dash-nav-pills > li > a {
        border-radius: 8px !important;
        font-weight: 700;
        font-size: 14px;
        color: #64748b !important;
        padding: 9px 20px !important;
        border: none !important;
        transition: all 0.2s ease;
    }

    .dash-nav-pills > li.active > a,
    .dash-nav-pills > li.active > a:focus,
    .dash-nav-pills > li.active > a:hover {
        background-color: #3c8dbc !important;
        color: #ffffff !important;
        box-shadow: 0 2px 4px rgba(60, 141, 188, 0.25) !important;
    }

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

    .dash-box-title i {
        color: #3c8dbc;
        font-size: 16px;
    }

    .dash-box-subtitle {
        font-size: 12px;
        color: #64748b;
        font-weight: 500;
    }

    .dash-box-body {
        padding: 20px;
    }

    /* Table Styling */
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
        padding: 11px 14px !important;
        font-size: 13px !important;
        color: #1e293b !important;
        vertical-align: middle !important;
        border-bottom: 1px solid #f1f5f9 !important;
    }

    .dash-table tbody tr:hover {
        background-color: #f8fafc !important;
    }

    .dash-table tr.total-row {
        background-color: #eff6ff !important;
        font-weight: 700;
        color: #1e40af !important;
    }

    .dash-table tr.total-row td {
        border-top: 2px solid #bfdbfe !important;
        border-bottom: 2px solid #bfdbfe !important;
        color: #1e40af !important;
    }

    .menu-link {
        color: #3c8dbc;
        font-weight: 600;
        text-decoration: none !important;
    }

    .menu-link:hover {
        color: #1d4ed8;
    }

    .login-ticker-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 10px 16px;
    }
</style>

<!-- Tab Navigation -->
<ul class="nav nav-pills dash-nav-pills" role="tablist">
    <li role="presentation" class="active">
        <a href="#tab-tabel" aria-controls="tab-tabel" role="tab" data-toggle="tab">
            <i class="fa fa-table"></i> Data & Tabel Rekap
        </a>
    </li>
    <li role="presentation">
        <a href="#tab-grafik" aria-controls="tab-grafik" role="tab" data-toggle="tab">
            <i class="fa fa-bar-chart"></i> Visualisasi Grafik
        </a>
    </li>
</ul>

<div class="tab-content">
    <!-- TAB 1: DATA & TABEL REKAP -->
    <div role="tabpanel" class="tab-pane active" id="tab-tabel">

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

        <?php if (callSessUser('id_user') == '10' OR callSessUser('id_user') == '11' OR callSessUser('id_user') == '17') { ?>

            <!-- Potongan Section -->
            <div class="row">
                <div class="col-md-6">
                    <div class="dash-box">
                        <div class="dash-box-header">
                            <div>
                                <h3 class="dash-box-title">
                                    <i class="fa fa-scissors"></i> Update Potongan Mingguan
                                </h3>
                                <span class="dash-box-subtitle"><?php echo $tanggalm1 ?> - <?php echo $tanggalm2 ?></span>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table dash-table">
                                <thead>
                                    <tr class="text-center">
                                        <th width="50">No</th>
                                        <th>Nama</th>
                                        <th class="text-right">Jml PO</th>
                                        <th class="text-right">Dz</th>
                                        <th class="text-right">Pcs</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $cpo = 0; $dz = 0; $pcs = 0; ?>
                                    <?php foreach ($rekappotm as $r) { ?>
                                        <tr>
                                            <td><?php echo $r['no'] ?></td>
                                            <td><strong><?php echo $r['type'] ?></strong></td>
                                            <td align="right"><?php echo number_format($r['po']) ?></td>
                                            <td align="right"><?php echo number_format($r['dz']) ?></td>
                                            <td align="right"><?php echo number_format($r['pcs']) ?></td>
                                        </tr>
                                        <?php
                                            $cpo += ($r['po']);
                                            $dz += ($r['dz']);
                                            $pcs += ($r['pcs']);
                                        ?>
                                    <?php } ?>
                                    <tr class="total-row">
                                        <td colspan="2">Total Potongan</td>
                                        <td align="right"><?php echo number_format($cpo) ?></td>
                                        <td align="right"><?php echo number_format($dz) ?></td>
                                        <td align="right"><?php echo number_format($pcs) ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="dash-box">
                        <div class="dash-box-header">
                            <div>
                                <h3 class="dash-box-title">
                                    <i class="fa fa-pie-chart"></i> Rekap Potongan PO Keseluruhan (2023 - 2024)
                                </h3>
                                <span class="dash-box-subtitle">Per <?php echo date('d F Y') ?></span>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table dash-table">
                                <thead>
                                    <tr class="text-center">
                                        <th width="50">No</th>
                                        <th>Nama</th>
                                        <th class="text-right">Jml PO</th>
                                        <th class="text-right">Dz</th>
                                        <th class="text-right">Pcs</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $cpo = 0; $dz = 0; $pcs = 0; ?>
                                    <?php foreach ($rekappot as $r) { ?>
                                        <tr>
                                            <td><?php echo $r['no'] ?></td>
                                            <td>
                                                <div class="menu-container">
                                                    <a href="javascript:void(0)" class="menu-link"><?php echo $r['type'] ?> <i class="fa fa-angle-right"></i> </a>
                                                    <ul class="menu">
                                                        <li><a href="<?php echo BASEURL ?>report/potongan">Harian</a></li>
                                                        <li><a href="#">Mingguan</a></li>
                                                        <li><a href="<?php echo BASEURL ?>Grafikpotongan">Bulanan</a></li>
                                                    </ul>
                                                </div>
                                            </td>
                                            <td align="right"><?php echo number_format($r['po']) ?></td>
                                            <td align="right"><?php echo number_format($r['dz'], 2) ?></td>
                                            <td align="right"><?php echo number_format($r['pcs']) ?></td>
                                        </tr>
                                        <?php
                                            $cpo += ($r['po']);
                                            $dz += ($r['dz']);
                                            $pcs += ($r['pcs']);
                                        ?>
                                    <?php } ?>
                                    <tr class="total-row">
                                        <td colspan="2">Total Potongan</td>
                                        <td align="right"><?php echo number_format($cpo) ?></td>
                                        <td align="right"><?php echo number_format($dz, 2) ?></td>
                                        <td align="right"><?php echo number_format($pcs) ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kirim Gudang Section -->
            <div class="row">
                <div class="col-md-6">
                    <div class="dash-box">
                        <div class="dash-box-header">
                            <div>
                                <h3 class="dash-box-title">
                                    <i class="fa fa-truck"></i> Update PO Kirim Gudang Mingguan
                                </h3>
                                <span class="dash-box-subtitle"><?php echo $tanggalm1 ?> - <?php echo $tanggalm2 ?></span>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table dash-table">
                                <thead>
                                    <tr class="text-center">
                                        <th width="50">No</th>
                                        <th>Nama</th>
                                        <th class="text-right">Jml PO</th>
                                        <th class="text-right">Dz</th>
                                        <th class="text-right">Pcs</th>
                                        <th class="text-right">Total (Rp)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $cpo = 0; $dz = 0; $pcs = 0; $total = 0; ?>
                                    <?php foreach ($rekapkgmingguan as $r) { ?>
                                        <tr>
                                            <td><?php echo $r['no'] ?></td>
                                            <td><strong><?php echo $r['type'] ?></strong></td>
                                            <td align="right"><?php echo number_format($r['po']) ?></td>
                                            <td align="right"><?php echo number_format($r['dz'], 2) ?></td>
                                            <td align="right"><?php echo number_format($r['pcs']) ?></td>
                                            <td align="right" style="font-weight:600;"><?php echo number_format($r['total']) ?></td>
                                        </tr>
                                        <?php
                                            $cpo += ($r['po']);
                                            $dz += ($r['dz']);
                                            $pcs += ($r['pcs']);
                                            $total += ($r['total']);
                                        ?>
                                    <?php } ?>
                                    <tr class="total-row">
                                        <td colspan="2">Nilai Total (Rp)</td>
                                        <td align="right"><?php echo number_format($cpo) ?></td>
                                        <td align="right"><?php echo number_format($dz, 2) ?></td>
                                        <td align="right"><?php echo number_format($pcs) ?></td>
                                        <td align="right"><?php echo number_format($total) ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="dash-box">
                        <div class="dash-box-header">
                            <div>
                                <h3 class="dash-box-title">
                                    <i class="fa fa-database"></i> Rekap PO Kirim Gudang Keseluruhan (2023-2024)
                                </h3>
                                <span class="dash-box-subtitle">Per <?php echo date('d F Y') ?></span>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table dash-table">
                                <thead>
                                    <tr class="text-center">
                                        <th width="50">No</th>
                                        <th>Nama</th>
                                        <th class="text-right">Jml PO</th>
                                        <th class="text-right">Dz</th>
                                        <th class="text-right">Pcs</th>
                                        <th class="text-right">Total (Rp)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $cpo = 0; $dz = 0; $pcs = 0; $total = 0; ?>
                                    <?php foreach ($rekapkg as $r) { ?>
                                        <tr>
                                            <td><?php echo $r['no'] ?></td>
                                            <td>
                                                <div class="menu-container">
                                                    <a href="javascript:void(0)" class="menu-link"><?php echo $r['type'] ?> <i class="fa fa-angle-right"></i> </a>
                                                    <ul class="menu">
                                                        <li><a href="<?php echo BASEURL ?>Rinciankirimgudang#finishing">Harian</a></li>
                                                        <li><a href="<?php echo BASEURL ?>laporankirimgudangharian">Mingguan</a></li>
                                                        <li><a href="<?php echo BASEURL ?>laporankirimgudangbulanan">Bulanan</a></li>
                                                    </ul>
                                                </div>
                                            </td>
                                            <td align="right"><?php echo number_format($r['po']) ?></td>
                                            <td align="right"><?php echo number_format($r['dz'], 2) ?></td>
                                            <td align="right"><?php echo number_format($r['pcs']) ?></td>
                                            <td align="right" style="font-weight:600;"><?php echo number_format($r['total']) ?></td>
                                        </tr>
                                        <?php
                                            $cpo += ($r['po']);
                                            $dz += ($r['dz']);
                                            $pcs += ($r['pcs']);
                                            $total += ($r['total']);
                                        ?>
                                    <?php } ?>
                                    <tr class="total-row">
                                        <td colspan="2">Nilai Total (Rp)</td>
                                        <td align="right"><?php echo number_format($cpo) ?></td>
                                        <td align="right"><?php echo number_format($dz, 2) ?></td>
                                        <td align="right"><?php echo number_format($pcs) ?></td>
                                        <td align="right"><?php echo number_format($total) ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        <?php } ?>

        <!-- Potongan Produksi Global Table -->
        <div class="row">
            <div class="col-md-12">
                <div class="dash-box">
                    <div class="dash-box-header">
                        <h3 class="dash-box-title">
                            <i class="fa fa-globe"></i> Potongan Produksi Global
                        </h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table dash-table">
                            <thead>
                                <tr>
                                    <th>Jenis</th>
                                    <th class="text-right">Jumlah PO</th>
                                    <th class="text-right">Dz</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $tpa = 0; $tpt = 0; ?>
                                <?php foreach ($pdzes as $pd) { ?>
                                    <tr>
                                        <td>
                                            <span style="display:inline-block; height:12px; width:12px; border-radius:3px; background-color:<?php echo $pd['color'] ?>; margin-right:6px; vertical-align:middle;"></span>
                                            <strong><?php echo $pd['namapo'] ?></strong>
                                        </td>
                                        <td align="right"><?php echo $pd['jmlpo'] ?></td>
                                        <td align="right"><?php echo number_format($pd['dz'], 2) ?></td>
                                    </tr>
                                    <?php $tpa += ($pd['dz']); ?>
                                    <?php $tpt += ($pd['jmlpo']); ?>
                                <?php } ?>
                                <tr class="total-row">
                                    <td>Total Global</td>
                                    <td align="right"><?php echo number_format($tpt, 2) ?></td>
                                    <td align="right"><?php echo number_format($tpa, 2) ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- TAB 2: VISUALISASI GRAFIK -->
    <div role="tabpanel" class="tab-pane" id="tab-grafik">
        <div class="row">
            <div class="col-md-12">
                <div class="dash-box">
                    <div class="dash-box-header">
                        <h3 class="dash-box-title">
                            <i class="fa fa-bar-chart"></i> Grafik Potongan Per Bulan
                        </h3>
                    </div>
                    <div class="dash-box-body">
                        <div id="potongan" style="width:100%; height:380px;"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="dash-box">
                    <div class="dash-box-header">
                        <h3 class="dash-box-title">
                            <i class="fa fa-area-chart"></i> Grafik Potongan Detail Perbulan
                        </h3>
                    </div>
                    <div class="dash-box-body">
                        <div id="container" style="width:100%; height:380px;"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="dash-box">
                    <div class="dash-box-header">
                        <h3 class="dash-box-title">
                            <i class="fa fa-line-chart"></i> Grafik Kirim Gudang
                        </h3>
                    </div>
                    <div class="dash-box-body">
                        <div id="kirimgudang" style="width:100%; height:380px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- User Login Ticker -->
<div class="row" style="margin-bottom: 20px;">
    <div class="col-md-12">
        <div class="login-ticker-box">
            <strong style="color: #334155; min-width: 90px; font-size:13px;"><i class="fa fa-user-circle"></i> User Login:</strong>
            <div style="overflow: hidden; width:100%;">
                <marquee scrollamount="4">
                    <?php $ln = 1; ?>
                    <?php foreach ($log as $l) { ?>
                        <span style="font-size:13px; color:#475569; font-weight:600; margin-right:20px;">
                            <span class="badge" style="background:#e2e8f0; color:#334155; font-size:11px; margin-right:4px;"><?php echo $ln++ ?></span>
                            <?php echo $l['nama'] ?>
                        </span>
                    <?php } ?>
                </marquee>
            </div>
        </div>
    </div>
</div>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script type="text/javascript">
   $(document).ready(function() {
        $('#tableseacrhfalse').dataTable( {
          "lengthChange": false,
          "searching":false,
        });

        // Event listener saat tab grafik dibuka agar Highcharts reflow otomatis
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            var target = $(e.target).attr("href");
            if (target === "#tab-grafik") {
                setTimeout(function() {
                    if (typeof Highcharts !== 'undefined' && Highcharts.charts) {
                        Highcharts.charts.forEach(function(chart) {
                            if (chart) {
                                chart.reflow();
                            }
                        });
                    }
                }, 100);
            }
        });
    });

var colors = ['#32a852', '#3269a8', '#cfc930'];
Highcharts.chart('potongan', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Grafik Potongan Per Bulan'
    },
    subtitle: {
        text: '<a href="<?php echo BASEURL ?>Monitoring">klik disini untuk melihat per-minggu</a>'
    },
    xAxis: {
        categories: <?php echo $bulan ?>,
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Potongan (dz)'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f} dz</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    colors: colors,
    series: [
        <?php foreach ($pdze as $p) { ?>
        {
            name: '<?php echo $p['namapo'] ?>',
            data: [<?php echo implode(",", $p['lusin']) ?>]
        },
        <?php } ?>
    ]
});

Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Grafik Potongan Detail Perbulan'
    },
    subtitle: {
        text: 'www.forboysproduction.com'
    },
    xAxis: {
        categories: <?php echo $bulan ?>,
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Potongan (dz)'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f} dz</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [
        <?php foreach ($po as $p) { ?>
        {
            name: '<?php echo $p['namapo'] ?>',
            data: [<?php echo implode(",", $p['lusin']) ?>]
        },
        <?php } ?>
    ]
});

Highcharts.chart('kirimgudang', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Grafik Kirim Gudang'
    },
    subtitle: {
        text: 'www.forboysproduction.com'
    },
    xAxis: {
        categories: <?php echo $bulan ?>,
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Kirim (dz)'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f} dz</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [
        <?php foreach ($getPOKirimGudang as $p) { ?>
        {
            name: '<?php echo $p['namapo'] ?>',
            data: [<?php echo implode(",", $p['lusin']) ?>]
        },
        <?php } ?>
    ]
});

$('#upload').modal({backdrop: 'static', keyboard: false});
$('#upload').modal('show');
</script>