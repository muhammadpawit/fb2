<style>
    .resumegaji-wrapper {
        font-family: 'Source Sans Pro', sans-serif;
        background: #ecf0f5;
        padding: 15px;
    }
    .header-card {
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        border-top: 4px solid #3c8dbc;
        margin-bottom: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .filter-section {
        background: #fff;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .payroll-card {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.08);
        margin-bottom: 25px;
        overflow: hidden;
        border: 1px solid #e1e4e8;
        transition: transform 0.2s;
    }
    .payroll-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.12);
    }
    .payroll-card-header {
        background: #f8f9fa;
        padding: 12px 15px;
        border-bottom: 1px solid #eee;
        font-weight: 700;
        color: #2c3e50;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .payroll-card-body {
        padding: 0;
    }
    .payroll-table {
        width: 100%;
        margin-bottom: 0;
    }
    .payroll-table td {
        padding: 8px 15px !important;
        font-size: 13px;
        border-top: 1px solid #f4f4f4 !important;
    }
    .payroll-table tr:first-child td { border-top: none !important; }
    .text-amount { text-align: right; font-weight: 600; }
    .row-highlight { background: #f9f9f9; font-weight: 700; }
    .row-total { background: #3c8dbc; color: #fff; font-weight: 800; }
    .row-total td { border: none !important; }
    
    .summary-table-container {
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        margin-bottom: 30px;
    }
    .table-custom {
        border-collapse: separate;
        border-spacing: 0;
    }
    .table-custom th {
        background: #f4f6f9;
        color: #333;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 0.5px;
        padding: 12px 15px !important;
        border: 1px solid #dee2e6 !important;
    }
    .table-custom td {
        padding: 10px 15px !important;
        vertical-align: middle !important;
        border: 1px solid #dee2e6 !important;
    }
    .badge-total {
        background: #28a745;
        color: white;
        padding: 5px 12px;
        border-radius: 20px;
        font-weight: 700;
    }
    .section-title {
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 15px;
        color: #333;
        border-left: 4px solid #3c8dbc;
        padding-left: 10px;
    }
    .alert-info-custom {
        background: #d1ecf1;
        color: #0c5460;
        border: none;
        border-left: 4px solid #17a2b8;
        font-weight: 600;
        margin-bottom: 10px;
    }
    
    @media print {
        .no-print { display: none !important; }
        .resumegaji-wrapper { background: #fff; padding: 0; }
        .payroll-card { box-shadow: none; border: 1px solid #ccc; break-inside: avoid; }
        .tab-content > .tab-pane { display: block !important; opacity: 1 !important; margin-bottom: 30px; }
    }
</style>

<div class="resumegaji-wrapper">
    <div class="row no-print">
        <div class="col-md-12">
            <?php if ($this->session->flashdata('msg')) { ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <?php echo $this->session->flashdata('msg'); ?> 
            </div>
            <?php } ?>
        </div>
    </div>

    <div class="header-card text-center">
        <h2 style="margin: 0; font-weight: 800; color: #2c3e50; text-transform: uppercase; letter-spacing: 1px;"><?php echo $title ?></h2>
        <p style="margin: 10px 0 0; color: #777; font-weight: 600;">
            <i class="fa fa-calendar mr-2"></i> PERIODE: <?php echo date('d-m-Y',strtotime($tanggal1)) ?> s.d <?php echo date('d-m-Y',strtotime($tanggal2)) ?>
        </p>
    </div>

    <div class="filter-section no-print">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Tanggal Awal</label>
                    <input type="date" name="tanggal1" id="tanggal1" value="<?php echo $tanggal1?>" class="form-control">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Tanggal Akhir</label>
                    <input type="date" name="tanggal2" id="tanggal2" value="<?php echo $tanggal2?>" class="form-control">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>&nbsp;</label><br>
                    <button id="btn-filter" class="btn btn-primary btn-block" onclick="showReloaderAndFilter()"><i class="fa fa-filter"></i> TAMPILKAN DATA</button>
                </div>
            </div>
        </div>
    </div>

    <?php 
    $total=0;
    foreach($fharian as $k){
        $total+=round(pembulatmurni($k['senin']+$k['selasa']+$k['rabu']+$k['kamis']+$k['jumat']+$k['sabtu']+$k['minggu']+$k['lembur']+$k['insentif']));
    }
    $t2=(pembulatangaji($gajim)+pembulatangaji($cucians)+pembulatangaji($bbs)+pembulatangaji($pkg));
    ?>

    <!-- GRAND TOTAL -->
    <div class="row">
        <div class="col-md-12">
            <div class="summary-table-container" style="background: #3c8dbc; color: white; margin-bottom: 20px;">
                <div style="display:flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 18px; font-weight: 600;">GRAND TOTAL GAJI FINISHING</span>
                    <span style="font-size: 24px; font-weight: 900;">Rp <?php echo number_format($total+$t2)?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- TABS NAV (AdminLTE/Bootstrap 3) -->
    <div class="nav-tabs-custom" style="margin-top: 20px;">
        <ul class="nav nav-tabs no-print">
            <?php if($total > 0){ ?>
            <li class="active"><a href="#harian" data-toggle="tab"><i class="fa fa-user-circle"></i> Gaji Harian</a></li>
            <?php } ?>
            <li class="<?php echo ($total > 0) ? '' : 'active'; ?>"><a href="#borongan" data-toggle="tab"><i class="fa fa-cog"></i> Gaji Borongan</a></li>
            <li><a href="#detail" data-toggle="tab"><i class="fa fa-list"></i> Detail Pekerjaan</a></li>
        </ul>

        <div class="tab-content">
            <?php if($total > 0){ ?>
            <!-- TAB HARIAN -->
            <div class="active tab-pane" id="harian">
                <div class="section-title">RINCIAN GAJI HARIAN</div>
                <div class="row" style="margin-bottom: 20px;">
                    <div class="col-md-12">
                        <div class="summary-table-container" style="background: #343a40; color: white; padding: 15px;">
                            <div style="display:flex; justify-content: space-between; align-items: center;">
                                <span style="font-size: 16px; font-weight: 600;"><i class="fa fa-calculator mr-2"></i> TOTAL GAJI HARIAN (TABEL 1)</span>
                                <span style="font-size: 20px; font-weight: 800;">Rp <?php echo number_format($total)?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
        <?php foreach($fharian as $k){?>
        <div class="col-md-4">
            <div class="payroll-card">
                <div class="payroll-card-header">
                    <span><i class="fa fa-user-circle"></i> <?php echo strtoupper($k['nama'])?></span>
                    <span class="badge badge-primary">HARIAN</span>
                </div>
                <div class="payroll-card-body">
                    <table class="payroll-table">
                        <tbody>
                            <tr><td>Senin</td><td class="text-amount"><?php echo empty($k['senin']) ? '' : number_format($k['senin'])?></td></tr>
                            <tr><td>Selasa</td><td class="text-amount"><?php echo empty($k['selasa']) ? '' : number_format($k['selasa'])?></td></tr>
                            <tr><td>Rabu</td><td class="text-amount"><?php echo empty($k['rabu']) ? '' : number_format($k['rabu'])?></td></tr>
                            <tr><td>Kamis</td><td class="text-amount"><?php echo empty($k['kamis']) ? '' : number_format($k['kamis'])?></td></tr>
                            <tr><td>Jumat</td><td class="text-amount"><?php echo empty($k['jumat']) ? '' : number_format($k['jumat'])?></td></tr>
                            <tr><td>Sabtu</td><td class="text-amount"><?php echo empty($k['sabtu']) ? '' : number_format($k['sabtu'])?></td></tr>
                            <tr><td>Minggu</td><td class="text-amount"><?php echo empty($k['minggu']) ? '' : number_format($k['minggu'])?></td></tr>
                            <tr><td>Lembur</td><td class="text-amount"><?php echo empty($k['lembur']) ? '' : number_format($k['lembur'])?></td></tr>
                            <tr><td>Insentif</td><td class="text-amount"><?php echo empty($k['insentif']) ? '' : number_format($k['insentif'])?></td></tr>
                            <tr class="row-highlight">
                                <td><b>TOTAL</b></td>
                                <td class="text-amount"><?php $sub = ($k['senin']??0)+($k['selasa']??0)+($k['rabu']??0)+($k['kamis']??0)+($k['jumat']??0)+($k['sabtu']??0)+($k['minggu']??0)+($k['lembur']??0)+($k['insentif']??0); echo empty($sub) ? '' : number_format($sub); ?></td>
                            </tr>
                            <tr class="row-total">
                                <td><b>PEMBULATAN</b></td>
                                <td class="text-amount"><?php $pemb = pembulatmurni($sub); echo empty($pemb) ? '' : number_format($pemb); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
    </div> <!-- END TAB HARIAN -->
    <?php } ?>

    <!-- TAB BORONGAN -->
    <div class="<?php echo ($total > 0) ? '' : 'active '; ?>tab-pane" id="borongan">
        <div class="section-title">SUMMARY GAJI BORONGAN & LAINNYA</div>
        <div class="row" style="margin-bottom: 20px;">
            <div class="col-md-12">
                <div class="summary-table-container" style="background: #343a40; color: white; padding: 15px;">
                    <div style="display:flex; justify-content: space-between; align-items: center;">
                        <span style="font-size: 16px; font-weight: 600;"><i class="fa fa-calculator mr-2"></i> TOTAL GAJI BORONGAN & LAINNYA (TABEL 2)</span>
                        <span style="font-size: 20px; font-weight: 800;">Rp <?php echo number_format($t2)?></span>
                    </div>
                </div>
            </div>
        </div>

    <div class="row">
        <!-- Menyamakan Tinggi Baris -->
        <?php 
        $valid_mesin = []; foreach($boronganmesin as $p){ $tot = pembulatangaji($p['total'] ?? 0); if($tot > 0) $valid_mesin[] = ['nama' => $p['nama'], 'total' => $tot]; }
        $valid_laundry = []; if(!empty($cucian)){ foreach($cucian as $p){ $tot = pembulatangaji($p['total'] ?? 0); if($tot > 0) $valid_laundry[] = ['nama' => $p['nama'], 'total' => $tot]; } }
        $valid_bb = []; foreach($bb as $p){ $tot = pembulatangaji($p['total'] ?? 0); if($tot > 0) $valid_bb[] = ['nama' => $p['nama'], 'total' => $tot]; }
        $valid_pk = []; foreach($pk as $p){ $tot = pembulatangaji($p['total'] ?? 0); if($tot > 0) $valid_pk[] = ['nama' => $p['nama'], 'total' => $tot]; }

        $max_rows = max(count($valid_mesin), count($valid_laundry), count($valid_bb), count($valid_pk));
        ?>

        <!-- Borongan Mesin -->
        <?php if(pembulatangaji($gajim) > 0){ ?>
        <div class="col-md-3">
            <div class="payroll-card" style="border-top: 3px solid #ffc107;">
                <div class="payroll-card-header" style="background: #fffbe6;">
                    <span><i class="fa fa-cog"></i> BORONGAN MESIN</span>
                </div>
                <div class="payroll-card-body">
                    <table class="payroll-table">
                        <thead class="bg-light">
                            <tr><th>Nama</th><th class="text-amount">Total</th></tr>
                        </thead>
                        <tbody>
                            <?php for($i=0; $i<$max_rows; $i++){ ?>
                                <?php if(isset($valid_mesin[$i])){ ?>
                                <tr>
                                    <td><?php echo $valid_mesin[$i]['nama']?></td>
                                    <td class="text-amount"><?php echo number_format($valid_mesin[$i]['total'])?></td>
                                </tr>
                                <?php } else { ?>
                                <tr><td>&nbsp;</td><td class="text-amount">&nbsp;</td></tr>
                                <?php } ?>
                            <?php } ?>
                            <tr class="row-highlight">
                                <td><b>SUBTOTAL</b></td>
                                <td class="text-amount"><b><?php echo number_format(pembulatangaji($gajim))?></b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php } ?>

        <!-- Laundry -->
        <?php if(pembulatangaji($cucians) > 0){ ?>
        <div class="col-md-3">
            <div class="payroll-card" style="border-top: 3px solid #17a2b8;">
                <div class="payroll-card-header" style="background: #e6f7ff;">
                    <span><i class="fa fa-tint"></i> LAUNDRY / CUCI</span>
                </div>
                <div class="payroll-card-body">
                    <table class="payroll-table">
                        <thead class="bg-light">
                            <tr><th>Nama</th><th class="text-amount">Total</th></tr>
                        </thead>
                        <tbody>
                            <?php for($i=0; $i<$max_rows; $i++){ ?>
                                <?php if(isset($valid_laundry[$i])){ ?>
                                <tr>
                                    <td><?php echo $valid_laundry[$i]['nama']?></td>
                                    <td class="text-amount"><?php echo number_format($valid_laundry[$i]['total'])?></td>
                                </tr>
                                <?php } else { ?>
                                <tr><td>&nbsp;</td><td class="text-amount">&nbsp;</td></tr>
                                <?php } ?>
                            <?php } ?>
                            <tr class="row-highlight">
                                <td><b>SUBTOTAL</b></td>
                                <td class="text-amount"><b><?php echo number_format(pembulatangaji($cucians))?></b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php } ?>

        <!-- Buang Benang -->
        <?php if(pembulatangaji($bbs) > 0){ ?>
        <div class="col-md-3">
            <div class="payroll-card" style="border-top: 3px solid #6c757d;">
                <div class="payroll-card-header" style="background: #f8f9fa;">
                    <span><i class="fa fa-scissors"></i> BUANG BENANG</span>
                </div>
                <div class="payroll-card-body">
                    <table class="payroll-table">
                        <thead class="bg-light">
                            <tr><th>Nama</th><th class="text-amount">Total</th></tr>
                        </thead>
                        <tbody>
                            <?php for($i=0; $i<$max_rows; $i++){ ?>
                                <?php if(isset($valid_bb[$i])){ ?>
                                <tr>
                                    <td><?php echo $valid_bb[$i]['nama']?></td>
                                    <td class="text-amount"><?php echo number_format($valid_bb[$i]['total'])?></td>
                                </tr>
                                <?php } else { ?>
                                <tr><td>&nbsp;</td><td class="text-amount">&nbsp;</td></tr>
                                <?php } ?>
                            <?php } ?>
                            <tr class="row-highlight">
                                <td><b>SUBTOTAL</b></td>
                                <td class="text-amount"><b><?php echo number_format(pembulatangaji($bbs))?></b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php } ?>

        <!-- Packing -->
        <?php if(pembulatangaji($pkg) > 0){ ?>
        <div class="col-md-3">
            <div class="payroll-card" style="border-top: 3px solid #007bff;">
                <div class="payroll-card-header" style="background: #e7f3ff;">
                    <span><i class="fa fa-archive"></i> PACKING & GOSOK</span>
                </div>
                <div class="payroll-card-body">
                    <table class="payroll-table">
                        <thead class="bg-light">
                            <tr><th>Nama</th><th class="text-amount">Total</th></tr>
                        </thead>
                        <tbody>
                            <?php for($i=0; $i<$max_rows; $i++){ ?>
                                <?php if(isset($valid_pk[$i])){ ?>
                                <tr>
                                    <td><?php echo $valid_pk[$i]['nama']?></td>
                                    <td class="text-amount"><?php echo number_format($valid_pk[$i]['total'])?></td>
                                </tr>
                                <?php } else { ?>
                                <tr><td>&nbsp;</td><td class="text-amount">&nbsp;</td></tr>
                                <?php } ?>
                            <?php } ?>
                            <tr class="row-highlight">
                                <td><b>SUBTOTAL</b></td>
                                <td class="text-amount"><b><?php echo number_format(pembulatangaji($pkg))?></b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>

    </div> <!-- END TAB BORONGAN -->

    <!-- TAB DETAIL -->
    <div class="tab-pane" id="detail">
        <div class="section-title">RINCIAN DETAIL PEKERJAAN</div>
        <div class="row">
        <div class="col-md-6">
            <?php foreach($kancing as $p){?>
                <?php if(!empty($p['lobangkancing']) || !empty($p['pasangkancing']) || !empty($p['tress'])){ ?>
                <div class="alert alert-info-custom">
                    <i class="fa fa-info-circle mr-2"></i> <?php echo strtoupper($p['nama'])?> (LOBANG, PASANG KANCING, TRESS)
                </div>
                
                <?php if(!empty($p['lobangkancing'])){?>
                <div class="summary-table-container" style="padding: 10px; margin-bottom: 15px;">
                    <table class="table table-bordered table-striped table-sm" style="font-size: 12px;">
                        <thead class="bg-warning">
                            <tr>
                                <th>No</th><th>PO</th><th>Pcs</th><th>Titik</th><th>Harga</th><th>Total Rp</th><th>Ket</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $lk=0; foreach($p['lobangkancing'] as $d){?>
                            <tr>
                                <td><?php echo $no++?></td>
                                <td><?php echo $d['nama_po']?></td>
                                <td><?php echo $d['jumlah_pcs']?></td>
                                <td><?php echo $d['jumlah_titik']?></td>
                                <td><?php echo number_format($d['harga_titik'])?></td>
                                <td align="right"><?php echo number_format(($d['jumlah_pendapatan'] ?? 0)*($d['perkalian'] ?? 1))?></td>
                                <td><?php echo $d['kategori']?></td>
                            </tr>
                            <?php $lk+=(($d['jumlah_pendapatan'] ?? 0)*($d['perkalian'] ?? 1)); } ?>
                            <tr class="bg-light font-weight-bold">
                                <td colspan="5">SUBTOTAL</td>
                                <td align="right"><?php echo number_format($lk)?></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <?php } ?>

                <?php if(!empty($p['pasangkancing'])){?>
                <div class="summary-table-container" style="padding: 10px; margin-bottom: 15px;">
                    <table class="table table-bordered table-striped table-sm" style="font-size: 12px;">
                        <thead class="bg-warning">
                            <tr>
                                <th>No</th><th>PO</th><th>Pcs</th><th>Titik</th><th>Harga</th><th>Total Rp</th><th>Ket</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $pk_sub=0; foreach($p['pasangkancing'] as $d){?>
                            <tr>
                                <td><?php echo $no2++?></td>
                                <td><?php echo $d['nama_po']?></td>
                                <td><?php echo $d['jumlah_pcs']?></td>
                                <td><?php echo $d['jumlah_titik']?></td>
                                <td><?php echo number_format($d['harga_titik'])?></td>
                                <td align="right"><?php echo number_format($d['jumlah_pendapatan'] ?? 0)?></td>
                                <td><?php echo $d['kategori']?></td>
                            </tr>
                            <?php $pk_sub+=($d['jumlah_pendapatan'] ?? 0); } ?>
                            <tr class="bg-light font-weight-bold">
                                <td colspan="5">SUBTOTAL</td>
                                <td align="right"><?php echo number_format($pk_sub)?></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <?php } ?>

                <?php if(!empty($p['tress'])){?>
                <div class="summary-table-container" style="padding: 10px; margin-bottom: 25px;">
                    <table class="table table-bordered table-striped table-sm" style="font-size: 12px;">
                        <thead class="bg-warning">
                            <tr>
                                <th>No</th><th>PO</th><th>Pcs</th><th>Titik</th><th>Harga</th><th>Total Rp</th><th>Ket</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $tr=0; foreach($p['tress'] as $d){?>
                            <tr>
                                <td><?php echo $no3++?></td>
                                <td><?php echo $d['nama_po']?></td>
                                <td><?php echo $d['jumlah_pcs']?></td>
                                <td><?php echo $d['jumlah_titik']?></td>
                                <td><?php echo number_format($d['harga_titik'])?></td>
                                <td align="right"><?php echo number_format($d['jumlah_pendapatan'] ?? 0)?></td>
                                <td><?php echo $d['kategori']?></td>
                            </tr>
                            <?php $tr+=($d['jumlah_pendapatan'] ?? 0); } ?>
                            <tr class="bg-light font-weight-bold">
                                <td colspan="5">SUBTOTAL</td>
                                <td align="right"><?php echo number_format($tr)?></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <?php } ?>
                <?php } // endif empty ?>
            <?php } ?>
        </div>

        <div class="col-md-6">
            <?php foreach($cu as $p){?>
                <?php if(!empty($p['details'])){ ?>
                <div class="alert alert-info-custom">
                    <i class="fa fa-tint mr-2"></i> <?php echo strtoupper($p['nama'])?> (CUCIAN / LAUNDRY)
                </div>
                <div class="summary-table-container" style="padding: 10px; margin-bottom: 25px;">
                    <table class="table table-bordered table-striped table-sm" style="font-size: 12px;">
                        <thead class="bg-info text-white">
                            <tr><th>No</th><th>PO</th><th>Pcs</th><th>Harga</th><th>Total Rp</th><th>Ket</th></tr>
                        </thead>
                        <tbody>
                            <?php $lk_cu=0; $noc=1; foreach($p['details'] as $d){?>
                            <tr>
                                <td><?php echo $noc++?></td>
                                <td><?php echo $d['kode_po']?></td>
                                <td><?php echo $d['jumlah_pcs']?></td>
                                <td><?php echo number_format($d['harga'])?></td>
                                <td align="right"><?php echo number_format($d['total'] ?? 0)?></td>
                                <td><?php echo $d['keterangan']?></td>
                            </tr>
                            <?php $lk_cu+=($d['total'] ?? 0); } ?>
                            <tr class="bg-light font-weight-bold">
                                <td colspan="4">SUBTOTAL</td>
                                <td align="right"><?php echo number_format($lk_cu)?></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <?php } ?>
            <?php } ?>

            <?php foreach($buangb as $b){?>
                <?php if(!empty($b['details'])){ ?>
                <div class="alert alert-info-custom" style="border-left-color: #6c757d;">
                    <i class="fa fa-scissors mr-2"></i> <?php echo strtoupper($b['nama'])?> (BUANG BENANG)
                </div>
                <div class="summary-table-container" style="padding: 10px; margin-bottom: 25px;">
                    <table class="table table-bordered table-striped table-sm" style="font-size: 12px;">
                        <thead class="bg-secondary text-white">
                            <tr><th>No</th><th>PO</th><th>Pcs</th><th>Harga</th><th>Total Rp</th><th>Ket</th></tr>
                        </thead>
                        <tbody>
                            <?php $bbj=1;$lkb=0; foreach($b['details'] as $d){?>
                            <tr>
                                <td><?php echo $bbj++?></td>
                                <td><?php echo $d['kode_po']?></td>
                                <td><?php echo $d['jumlah_pcs']?></td>
                                <td><?php echo number_format($d['harga'])?></td>
                                <td align="right"><?php echo number_format($d['total'] ?? 0)?></td>
                                <td><?php echo $d['keterangan']?></td>
                            </tr>
                            <?php $lkb+=($d['total'] ?? 0); } ?>
                            <tr class="bg-light font-weight-bold">
                                <td colspan="4">SUBTOTAL</td>
                                <td align="right"><?php echo number_format($lkb)?></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <?php } ?>
            <?php } ?>

            <?php foreach($pck as $b){?>
                <?php if(!empty($b['details'])){ ?>
                <div class="alert alert-info-custom" style="border-left-color: #007bff;">
                    <i class="fa fa-archive mr-2"></i> <?php echo strtoupper($b['nama'])?> (PACKING & GOSOK)
                </div>
                <div class="summary-table-container" style="padding: 10px; margin-bottom: 25px;">
                    <table class="table table-bordered table-striped table-sm" style="font-size: 12px;">
                        <thead class="bg-primary text-white">
                            <tr><th>No</th><th>PO</th><th>Pcs</th><th>Dz</th><th>Harga/Dz</th><th>Total Rp</th><th>Ket</th></tr>
                        </thead>
                        <tbody>
                            <?php $pk_cnt=1;$lkp=0; foreach($b['details'] as $d){?>
                            <tr>
                                <td><?php echo $pk_cnt++?></td>
                                <td><?php echo $d['nama_po']?></td>
                                <td><?php echo number_format(($d['jumlah_dz'] ?? 0)*12,0)?></td>
                                <td><?php echo $d['jumlah_dz'] ?? 0?></td>
                                <td><?php echo number_format($d['harga_dz'] ?? 0)?></td>
                                <td align="right"><?php echo number_format($d['jumlah_pendapatan'] ?? 0)?></td>
                                <td><?php echo $d['keterangan']?></td>
                            </tr>
                            <?php $lkp+=($d['jumlah_pendapatan'] ?? 0); } ?>
                            <tr class="bg-light font-weight-bold">
                                <td colspan="5">SUBTOTAL</td>
                                <td align="right"><?php echo number_format($lkp)?></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
    </div> <!-- END TAB DETAIL -->
    </div> <!-- END TAB CONTENT -->
    </div> <!-- END NAV-TABS-CUSTOM -->

    <div class="row no-print" style="margin-top: 20px; margin-bottom: 50px;">
        <div class="col-md-12 text-center">
            <button onclick="window.print()" class="btn btn-lg btn-default" style="min-width: 150px; border-radius: 4px; border: 1px solid #ddd;">
                <i class="fa fa-print mr-2"></i> PRINT BROWSER
            </button>
            <button onclick="pdf()" class="btn btn-lg btn-danger" style="min-width: 150px; border-radius: 4px; margin-left: 10px;">
                <i class="fa fa-file-pdf-o mr-2"></i> DOWNLOAD PDF
            </button>
            <button onclick="excel()" class="btn btn-lg btn-success" style="min-width: 150px; border-radius: 4px; margin-left: 10px;">
                <i class="fa fa-file-excel-o mr-2"></i> EXPORT EXCEL
            </button>
        </div>
    </div>
</div>

<script type="text/javascript">
	function excel(){
		var url='?&excel=1';
        var tanggal1 =$("#tanggal1").val();
        var tanggal2 =$("#tanggal2").val();
        if(tanggal1){ url+='&tanggal1='+tanggal1; }
        if(tanggal2){ url+='&tanggal2='+tanggal2; }
		location =url;
	}

    function pdf(){
		var url='?&pdf=1';
        var tanggal1 =$("#tanggal1").val();
        var tanggal2 =$("#tanggal2").val();
        if(tanggal1){ url+='&tanggal1='+tanggal1; }
        if(tanggal2){ url+='&tanggal2='+tanggal2; }
		window.open(url, '_blank');
	}

    function showReloaderAndFilter() {
        var btn = document.getElementById('btn-filter');
        btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> MEMUAT DATA...';
        btn.setAttribute('disabled', 'disabled');

        // Ganti isi area tab dengan animasi spinner besar
        var tabContent = document.getElementById('resumeTabContent');
        if(tabContent) {
            tabContent.innerHTML = '<div class="text-center" style="padding: 80px 20px;"><i class="fa fa-spinner fa-spin fa-5x text-primary" style="color: #3c8dbc;"></i><h3 style="margin-top:20px; color:#555;">Sedang merekap gaji...</h3><p class="text-muted">Mohon tunggu sebentar, ini mungkin memakan waktu beberapa saat.</p></div>';
        }

        filtertglonly();
    }
</script>
