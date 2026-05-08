<!DOCTYPE html>
<html>
<head>
    <title>Resume Gaji Finishing</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #333; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-uppercase { text-transform: uppercase; }
        .font-bold { font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ccc; padding: 6px; }
        th { background-color: #f2f2f2; }
        .header { margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .section-title { font-size: 13px; font-weight: bold; margin-bottom: 10px; border-left: 4px solid #3c8dbc; padding-left: 8px; background: #f8f9fa; padding-top: 5px; padding-bottom: 5px; }
        .bg-light { background-color: #f9f9f9; }
        .bg-yellow { background-color: #ffffcc; }
        .bg-blue { background-color: #e6f7ff; }
        .footer-text { font-style: italic; font-size: 9px; margin-top: 20px; text-align: right; }
        .payroll-card { border: 1px solid #eee; margin-bottom: 15px; }
        .row { width: 100%; clear: both; }
        .col-4 { width: 33.33%; float: left; padding: 2px; box-sizing: border-box; }
        .clearfix::after { content: ""; clear: both; display: table; }
    </style>
</head>
<body>
    <div class="header text-center">
        <h2 style="margin:0;">RINCIAN GAJI KARYAWAN FINISHING</h2>
        <p style="margin:5px 0;">Periode: <?php echo date('d-m-Y',strtotime($tanggal1)) ?> s.d <?php echo date('d-m-Y',strtotime($tanggal2)) ?></p>
    </div>

    <div class="section-title">A. RINCIAN GAJI HARIAN</div>
    
    <?php 
    $total_harian = 0;
    $chunks = array_chunk($fharian, 3);
    foreach($chunks as $chunk){
    ?>
    <div class="row clearfix">
        <?php foreach($chunk as $k){ ?>
        <div class="col-4">
            <table>
                <thead>
                    <tr><th colspan="2"><?php echo strtoupper($k['nama'])?></th></tr>
                </thead>
                <tbody>
                    <tr><td>Senin</td><td class="text-right"><?php echo number_format($k['senin'] ?? 0)?></td></tr>
                    <tr><td>Selasa</td><td class="text-right"><?php echo number_format($k['selasa'] ?? 0)?></td></tr>
                    <tr><td>Rabu</td><td class="text-right"><?php echo number_format($k['rabu'] ?? 0)?></td></tr>
                    <tr><td>Kamis</td><td class="text-right"><?php echo number_format($k['kamis'] ?? 0)?></td></tr>
                    <tr><td>Jumat</td><td class="text-right"><?php echo number_format($k['jumat'] ?? 0)?></td></tr>
                    <tr><td>Sabtu</td><td class="text-right"><?php echo number_format($k['sabtu'] ?? 0)?></td></tr>
                    <tr><td>Minggu</td><td class="text-right"><?php echo number_format($k['minggu'] ?? 0)?></td></tr>
                    <tr><td>Lembur</td><td class="text-right"><?php echo number_format($k['lembur'] ?? 0)?></td></tr>
                    <tr><td>Insentif</td><td class="text-right"><?php echo number_format($k['insentif'] ?? 0)?></td></tr>
                    <tr class="bg-light font-bold">
                        <td>TOTAL</td>
                        <td class="text-right"><?php $sub = ($k['senin']??0)+($k['selasa']??0)+($k['rabu']??0)+($k['kamis']??0)+($k['jumat']??0)+($k['sabtu']??0)+($k['minggu']??0)+($k['lembur']??0)+($k['insentif']??0); echo number_format($sub); ?></td>
                    </tr>
                    <tr class="bg-blue font-bold">
                        <td>PEMBULATAN</td>
                        <td class="text-right"><?php $pemb = pembulatangaji($sub); echo number_format($pemb); ?></td>
                    </tr>
                </tbody>
            </table>
            <?php $total_harian += $pemb; ?>
        </div>
        <?php } ?>
    </div>
    <?php } ?>

    <table style="width: 50%; margin-top: 10px;">
        <tr class="bg-yellow font-bold">
            <td>TOTAL GAJI HARIAN</td>
            <td class="text-right">Rp <?php echo number_format($total_harian)?></td>
        </tr>
    </table>

    <div class="section-title">B. SUMMARY GAJI BORONGAN & LAINNYA</div>
    <div class="row clearfix">
        <div class="col-4" style="width: 25%;">
            <table>
                <thead><tr><th>BORONGAN MESIN</th><th class="text-right">Rp</th></tr></thead>
                <tbody>
                    <?php foreach($boronganmesin as $p){?>
                    <tr><td><?php echo $p['nama']?></td><td class="text-right"><?php echo number_format(pembulatangaji($p['total'] ?? 0))?></td></tr>
                    <?php } ?>
                    <tr class="bg-light font-bold"><td>SUBTOTAL</td><td class="text-right"><?php echo number_format(pembulatangaji($gajim))?></td></tr>
                </tbody>
            </table>
        </div>
        <div class="col-4" style="width: 25%;">
            <table>
                <thead><tr><th>LAUNDRY</th><th class="text-right">Rp</th></tr></thead>
                <tbody>
                    <?php if(!empty($cucian)){ foreach($cucian as $p){?>
                    <tr><td><?php echo $p['nama']?></td><td class="text-right"><?php echo number_format(pembulatangaji($p['total'] ?? 0))?></td></tr>
                    <?php } } else { ?> <tr><td colspan="2" class="text-center">-</td></tr> <?php } ?>
                    <tr class="bg-light font-bold"><td>SUBTOTAL</td><td class="text-right"><?php echo number_format(pembulatangaji($cucians))?></td></tr>
                </tbody>
            </table>
        </div>
        <div class="col-4" style="width: 25%;">
            <table>
                <thead><tr><th>BUANG BENANG</th><th class="text-right">Rp</th></tr></thead>
                <tbody>
                    <?php foreach($bb as $p){?>
                    <tr><td><?php echo $p['nama']?></td><td class="text-right"><?php echo number_format(pembulatangaji($p['total'] ?? 0))?></td></tr>
                    <?php } ?>
                    <tr class="bg-light font-bold"><td>SUBTOTAL</td><td class="text-right"><?php echo number_format(pembulatangaji($bbs))?></td></tr>
                </tbody>
            </table>
        </div>
        <div class="col-4" style="width: 25%;">
            <table>
                <thead><tr><th>PACKING & GOSOK</th><th class="text-right">Rp</th></tr></thead>
                <tbody>
                    <?php foreach($pk as $p){?>
                    <tr><td><?php echo $p['nama']?></td><td class="text-right"><?php echo number_format(pembulatangaji($p['total'] ?? 0))?></td></tr>
                    <?php } ?>
                    <tr class="bg-light font-bold"><td>SUBTOTAL</td><td class="text-right"><?php echo number_format(pembulatangaji($pkg))?></td></tr>
                </tbody>
            </table>
        </div>
    </div>

    <table style="width: 50%;">
        <tr class="bg-yellow font-bold">
            <td>TOTAL GAJI BORONGAN (TABEL 2)</td>
            <td class="text-right">Rp <?php $t2 = (pembulatangaji($gajim)+pembulatangaji($cucians)+pembulatangaji($bbs)+pembulatangaji($pkg)); echo number_format($t2)?></td>
        </tr>
        <tr style="background-color: #333; color: #fff; font-size: 14px;">
            <td>GRAND TOTAL GAJI</td>
            <td class="text-right">Rp <?php echo number_format($total_harian + $t2)?></td>
        </tr>
    </table>

    <p class="footer-text">Registered by Forboys Production System <?php echo date('d-m-Y H:i:s'); ?></p>
</body>
</html>
