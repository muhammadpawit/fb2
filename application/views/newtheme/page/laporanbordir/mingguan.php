<style type="text/css">
    body {
        background-color: #f4f7f6;
    }
    .report-card {
        background: #ffffff;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.03);
        border: none;
        margin-bottom: 30px;
        transition: transform 0.3s ease;
    }
    .report-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        margin-bottom: 0;
    }
    .report-table thead th {
        background-color: #ffffff;
        color: #8898aa;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 12px;
        padding: 20px 15px;
        border-bottom: 1px solid #e9ecef;
        letter-spacing: 1px;
    }
    .report-table tbody td {
        padding: 18px 15px;
        border-bottom: 1px solid #f6f9fc;
        font-size: 15px;
        color: #32325d;
    }
    .report-table tfoot td {
        padding: 20px 15px;
        background-color: #f8f9fe;
        font-weight: 700;
        font-size: 16px;
        color: #32325d;
    }
    .text-amount {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        font-weight: 600;
    }
    .label-pendapatan { color: #2dce89; }
    .label-pengeluaran { color: #f5365c; }
    .label-laba { color: #5e72e4; }
    
    .btn-smooth {
        border-radius: 10px;
        padding: 10px 20px;
        font-weight: 600;
        transition: all 0.2s;
        border: none;
    }
    .btn-smooth:hover {
        transform: translateY(-2px);
        box-shadow: 0 7px 14px rgba(50,50,93,.1), 0 3px 6px rgba(0,0,0,.08);
    }
    
    .summary-box {
        background: linear-gradient(87deg, #2dce89 0, #2dcecc 100%);
        border-radius: 15px;
        padding: 30px;
        color: #ffffff;
        box-shadow: 0 15px 35px rgba(50,50,93,.1), 0 5px 15px rgba(0,0,0,.07);
    }
    .summary-box .label {
        font-size: 14px;
        text-transform: uppercase;
        opacity: 0.9;
        letter-spacing: 2px;
        font-weight: 700;
    }
    .summary-box .value {
        font-size: 32px;
        font-weight: 800;
        margin-top: 5px;
    }
</style>

<div class="row no-print mb-5">
    <div class="col-md-12">
        <div class="report-card p-4">
            <div class="row align-items-end">
                <div class="col-md-4">
                    <label class="font-weight-bold small text-muted text-uppercase mb-2 d-block">Periode Mulai</label>
                    <input type="date" name="tanggal1" id="tanggal1" value="<?php echo $tanggal1?>" class="form-control form-control-alternative">
                </div>
                <div class="col-md-4">
                    <label class="font-weight-bold small text-muted text-uppercase mb-2 d-block">Periode Selesai</label>
                    <input type="date" name="tanggal2" id="tanggal2" value="<?php echo $tanggal2?>" class="form-control form-control-alternative">
                </div>
                <div class="col-md-4 text-right">
                    <button class="btn btn-smooth btn-primary" onclick="filtertglonly()"><i class="fa fa-sync-alt mr-2"></i> Update Data</button>
                    <button class="btn btn-smooth btn-secondary ml-2" onclick="cetak()"><i class="fa fa-print"></i></button>
                    <button class="btn btn-smooth btn-success ml-2" onclick="excelwithtgl()"><i class="fa fa-file-excel"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-5">
    <div class="col-md-12 text-center">
        <h1 class="display-4 font-weight-bold mb-2" style="color: #32325d;">Laporan Laba - Rugi Bordir</h1>
        <p class="text-muted lead">Analisis Keuangan Periode <?php echo date('d M Y',strtotime($tanggal1)); ?> — <?php echo date('d M Y',strtotime($tanggal2)); ?></p>
    </div>
</div>

<div class="row">
    <div class="col-md-10 offset-md-1">
        <div class="row">
            <div class="col-md-6">
                <!-- Tabel Pendapatan -->
                <div class="report-card overflow-hidden">
                    <table class="report-table">
                        <thead>
                            <tr>
                                <th class="label-pendapatan">Kategori Pendapatan</th>
                                <th class="text-right">Nominal (Rp)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Pendapatan PO Dalam</td>
                                <td align="right" class="text-amount"><?php echo number_format($totalpendapatan)?></td>
                            </tr>
                            <tr>
                                <td>Pendapatan PO Luar</td>
                                <td align="right" class="text-amount"><?php echo number_format($totalpoluar)?></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td>TOTAL PENDAPATAN</td>
                                <td align="right" class="text-amount"><?php echo number_format($pend)?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="col-md-6">
                <!-- Tabel Pengeluaran -->
                <div class="report-card overflow-hidden">
                    <table class="report-table">
                        <thead>
                            <tr>
                                <th class="label-pengeluaran">Kategori Pengeluaran</th>
                                <th class="text-right">Nominal (Rp)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Belanja Bordir</td>
                                <td align="right" class="text-amount"><?php echo number_format($belanjabordir) ?></td>
                            </tr>
                            <tr>
                                <td>Gaji Operator Bordir</td>
                                <td align="right" class="text-amount"><?php echo number_format(isset($gajioperator) ? $gajioperator : (isset($gajibordir) ? $gajibordir : 0)) ?></td>
                            </tr>
                            <tr>
                                <td>Gaji Bulanan Bordir</td>
                                <td align="right" class="text-amount"><?php echo number_format(isset($gajibulanan) ? $gajibulanan : 0) ?></td>
                            </tr>
                            <tr>
                                <td>Kasbon Karyawan Bordir</td>
                                <td align="right" class="text-amount"><?php echo number_format(isset($kasbon) ? $kasbon : 0) ?></td>
                            </tr>
                            <tr>
                                <td>Operasional</td>
                                <td align="right" class="text-amount"><?php echo number_format($operasional) ?></td>
                            </tr>
                            <tr>
                                <td>Service Mesin</td>
                                <td align="right" class="text-amount"><?php echo number_format($service) ?></td>
                            </tr>
                            <tr>
                                <td>Potongan Warteg</td>
                                <td align="right" class="text-amount"><?php echo number_format(isset($potonganwarteg) ? $potonganwarteg : 0) ?></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <?php $totalpengeluaran = ($belanjabordir + (isset($gajioperator) ? $gajioperator : (isset($gajibordir) ? $gajibordir : 0)) + (isset($gajibulanan) ? $gajibulanan : 0) + (isset($kasbon) ? $kasbon : 0) + $operasional + $service + (isset($potonganwarteg) ? $potonganwarteg : 0)); ?>
                            <tr>
                                <td>TOTAL PENGELUARAN</td>
                                <td align="right" class="text-amount"><?php echo number_format($totalpengeluaran)?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <!-- Summary -->
        <div class="summary-box mt-4 d-flex justify-content-between align-items-center">
            <div>
                <div class="label">Total Laba Bersih</div>
                <div class="value">Rp <?php echo number_format($pend - $totalpengeluaran)?></div>
            </div>
            <div class="text-right">
                <i class="fa fa-chart-line fa-4x opacity-2"></i>
            </div>
        </div>
        <p class="text-center text-muted small mt-4"><i>Generated by Forboys Production System at <?php echo date('d/m/Y H:i'); ?></i></p>
    </div>
</div>