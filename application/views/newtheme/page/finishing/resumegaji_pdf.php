<!DOCTYPE html>
<html>
<head>
    <title>Resume Gaji Finishing</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #333; margin: 0; padding: 0; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-uppercase { text-transform: uppercase; }
        .font-bold { font-weight: bold; }
        table.data-table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        table.data-table th, table.data-table td { border: 1px solid #ccc; padding: 5px; }
        table.data-table th { background-color: #f2f2f2; }
        .header { margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .section-title { font-size: 13px; font-weight: bold; margin-bottom: 10px; border-left: 4px solid #3c8dbc; padding-left: 8px; background: #f8f9fa; padding-top: 5px; padding-bottom: 5px; }
        .bg-light { background-color: #f9f9f9; }
        .bg-yellow { background-color: #ffffcc; }
        .bg-blue { background-color: #e6f7ff; }
        .footer-text { font-style: italic; font-size: 9px; margin-top: 20px; text-align: right; }
        .layout-table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        .layout-table td { vertical-align: top; padding: 0 5px; border: none; }
        .layout-table td:first-child { padding-left: 0; }
        .layout-table td:last-child { padding-right: 0; }
        .grand-total-table { width: 60%; margin-top: 20px; margin-left: auto; border-collapse: collapse; }
        .grand-total-table td { padding: 8px; border: 1px solid #ccc; }
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
    <table class="layout-table">
        <tr>
            <?php foreach($chunk as $k){ ?>
            <td style="width: 33.33%;">
                <table class="data-table">
                    <thead>
                        <tr><th colspan="2" style="background-color: #e9ecef;"><?php echo strtoupper($k['nama'])?></th></tr>
                    </thead>
                    <tbody>
                        <tr><td>Senin</td><td class="text-right"><?php echo empty($k['senin']) ? '' : number_format($k['senin'])?></td></tr>
                        <tr><td>Selasa</td><td class="text-right"><?php echo empty($k['selasa']) ? '' : number_format($k['selasa'])?></td></tr>
                        <tr><td>Rabu</td><td class="text-right"><?php echo empty($k['rabu']) ? '' : number_format($k['rabu'])?></td></tr>
                        <tr><td>Kamis</td><td class="text-right"><?php echo empty($k['kamis']) ? '' : number_format($k['kamis'])?></td></tr>
                        <tr><td>Jumat</td><td class="text-right"><?php echo empty($k['jumat']) ? '' : number_format($k['jumat'])?></td></tr>
                        <tr><td>Sabtu</td><td class="text-right"><?php echo empty($k['sabtu']) ? '' : number_format($k['sabtu'])?></td></tr>
                        <tr><td>Minggu</td><td class="text-right"><?php echo empty($k['minggu']) ? '' : number_format($k['minggu'])?></td></tr>
                        <tr><td>Lembur</td><td class="text-right"><?php echo empty($k['lembur']) ? '' : number_format($k['lembur'])?></td></tr>
                        <tr><td>Insentif</td><td class="text-right"><?php echo empty($k['insentif']) ? '' : number_format($k['insentif'])?></td></tr>
                        <tr class="bg-light font-bold">
                            <td>TOTAL</td>
                            <td class="text-right"><?php $sub = ($k['senin']??0)+($k['selasa']??0)+($k['rabu']??0)+($k['kamis']??0)+($k['jumat']??0)+($k['sabtu']??0)+($k['minggu']??0)+($k['lembur']??0)+($k['insentif']??0); echo empty($sub) ? '' : number_format($sub); ?></td>
                        </tr>
                        <tr class="bg-blue font-bold">
                            <td>PEMBULATAN</td>
                            <td class="text-right"><?php $pemb = pembulatmurni($sub); echo empty($pemb) ? '' : number_format($pemb); ?></td>
                        </tr>
                    </tbody>
                </table>
                <?php $total_harian += $pemb; ?>
            </td>
            <?php } ?>
            <?php 
            // Fill empty columns if chunk size is less than 3
            $empty_cols = 3 - count($chunk);
            for($i=0; $i<$empty_cols; $i++) {
                echo '<td style="width: 33.33%;"></td>';
            }
            ?>
        </tr>
    </table>
    <?php } ?>

    <table class="data-table" style="width: 40%;">
        <tr class="bg-yellow font-bold">
            <td>TOTAL GAJI HARIAN</td>
            <td class="text-right">Rp <?php echo number_format($total_harian)?></td>
        </tr>
    </table>

    <div style="page-break-before: always;"></div>

    <div class="section-title" style="margin-top: 20px;">B. SUMMARY GAJI BORONGAN & LAINNYA</div>
    <table class="layout-table">
<?php 
$valid_mesin = []; foreach($boronganmesin as $p){ $tot = pembulatangaji($p['total'] ?? 0); if($tot > 0) $valid_mesin[] = ['nama' => $p['nama'], 'total' => $tot]; }
$valid_laundry = []; if(!empty($cucian)){ foreach($cucian as $p){ $tot = pembulatangaji($p['total'] ?? 0); if($tot > 0) $valid_laundry[] = ['nama' => $p['nama'], 'total' => $tot]; } }
$valid_bb = []; foreach($bb as $p){ $tot = pembulatangaji($p['total'] ?? 0); if($tot > 0) $valid_bb[] = ['nama' => $p['nama'], 'total' => $tot]; }
$valid_pk = []; foreach($pk as $p){ $tot = pembulatangaji($p['total'] ?? 0); if($tot > 0) $valid_pk[] = ['nama' => $p['nama'], 'total' => $tot]; }

$max_rows = max(count($valid_mesin), count($valid_laundry), count($valid_bb), count($valid_pk));

$borongan_blocks = [];

if (pembulatangaji($gajim) > 0) {
    ob_start(); ?>
                <table class="data-table">
                    <thead><tr><th>BORONGAN MESIN</th><th class="text-right">Rp</th></tr></thead>
                    <tbody>
                        <?php for($i=0; $i<$max_rows; $i++){ ?>
                            <?php if(isset($valid_mesin[$i])){ ?>
                            <tr><td><?php echo $valid_mesin[$i]['nama']?></td><td class="text-right"><?php echo number_format($valid_mesin[$i]['total'])?></td></tr>
                            <?php } else { ?>
                            <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
                            <?php } ?>
                        <?php } ?>
                        <tr class="bg-light font-bold"><td>SUBTOTAL</td><td class="text-right"><?php echo number_format(pembulatangaji($gajim))?></td></tr>
                    </tbody>
                </table>
<?php 
    $borongan_blocks[] = ob_get_clean();
}

if (pembulatangaji($cucians) > 0) {
    ob_start(); ?>
                <table class="data-table">
                    <thead><tr><th>LAUNDRY</th><th class="text-right">Rp</th></tr></thead>
                    <tbody>
                        <?php for($i=0; $i<$max_rows; $i++){ ?>
                            <?php if(isset($valid_laundry[$i])){ ?>
                            <tr><td><?php echo $valid_laundry[$i]['nama']?></td><td class="text-right"><?php echo number_format($valid_laundry[$i]['total'])?></td></tr>
                            <?php } else { ?>
                            <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
                            <?php } ?>
                        <?php } ?>
                        <tr class="bg-light font-bold"><td>SUBTOTAL</td><td class="text-right"><?php echo number_format(pembulatangaji($cucians))?></td></tr>
                    </tbody>
                </table>
<?php 
    $borongan_blocks[] = ob_get_clean();
}

if (pembulatangaji($bbs) > 0) {
    ob_start(); ?>
                <table class="data-table">
                    <thead><tr><th>BUANG BENANG</th><th class="text-right">Rp</th></tr></thead>
                    <tbody>
                        <?php for($i=0; $i<$max_rows; $i++){ ?>
                            <?php if(isset($valid_bb[$i])){ ?>
                            <tr><td><?php echo $valid_bb[$i]['nama']?></td><td class="text-right"><?php echo number_format($valid_bb[$i]['total'])?></td></tr>
                            <?php } else { ?>
                            <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
                            <?php } ?>
                        <?php } ?>
                        <tr class="bg-light font-bold"><td>SUBTOTAL</td><td class="text-right"><?php echo number_format(pembulatangaji($bbs))?></td></tr>
                    </tbody>
                </table>
<?php 
    $borongan_blocks[] = ob_get_clean();
}

if (pembulatangaji($pkg) > 0) {
    ob_start(); ?>
                <table class="data-table">
                    <thead><tr><th>PACKING & GOSOK</th><th class="text-right">Rp</th></tr></thead>
                    <tbody>
                        <?php for($i=0; $i<$max_rows; $i++){ ?>
                            <?php if(isset($valid_pk[$i])){ ?>
                            <tr><td><?php echo $valid_pk[$i]['nama']?></td><td class="text-right"><?php echo number_format($valid_pk[$i]['total'])?></td></tr>
                            <?php } else { ?>
                            <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
                            <?php } ?>
                        <?php } ?>
                        <tr class="bg-light font-bold"><td>SUBTOTAL</td><td class="text-right"><?php echo number_format(pembulatangaji($pkg))?></td></tr>
                    </tbody>
                </table>
<?php 
    $borongan_blocks[] = ob_get_clean();
}

$chunks = array_chunk($borongan_blocks, 2);
foreach($chunks as $chunk) {
    echo '<tr>';
    foreach($chunk as $block) {
        echo '<td style="width: 50%;">' . $block . '</td>';
    }
    if (count($chunk) == 1) {
        echo '<td style="width: 50%;"></td>';
    }
    echo '</tr>';
}
?>
    </table>

    <table style="width: 100%; border: none; margin-top: 20px;">
        <tr>
            <td style="width: 40%; border: none;"></td>
            <td style="width: 60%; border: none; padding: 0;">
                <table class="grand-total-table" style="width: 100%; margin-top: 0; border-collapse: collapse;">
                    <tr class="bg-yellow font-bold">
                        <td style="width: 60%; padding: 8px; border: 1px solid #ccc;">TOTAL GAJI BORONGAN (TABEL B)</td>
                        <td class="text-right" style="width: 40%; padding: 8px; border: 1px solid #ccc;">Rp <?php $t2 = (pembulatangaji($gajim)+pembulatangaji($cucians)+pembulatangaji($bbs)+pembulatangaji($pkg)); echo number_format($t2)?></td>
                    </tr>
                    <tr style="background-color: #2c3e50; color: #fff; font-size: 14px; font-weight: bold;">
                        <td style="padding: 8px; border: 1px solid #ccc;">GRAND TOTAL GAJI (A + B)</td>
                        <td class="text-right" style="padding: 8px; border: 1px solid #ccc;">Rp <?php echo number_format($total_harian + $t2)?></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-right" style="padding: 10px 0 0 0; border: none; font-style: italic; font-size: 9px; color: #555;">
                            Registered by Forboys Production System <?php echo date('d-m-Y H:i:s'); ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
