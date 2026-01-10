<?php
header("Content-Type: application/vnd-ms-excel");
header(
    "Content-Disposition: attachment; filename=Laporan_Pembayaran_Tim_Potong_" .
    date('d_F_Y', strtotime($prods['tanggal'])) . '_' . time() . ".xls"
);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px 8px;
        }
        th {
            background: #f2f2f2;
            text-align: center;
        }
        .text-center { text-align: center; }
        .text-right  { text-align: right; }
        .no-border td { border: none; }
        .title {
            font-size: 14px;
            font-weight: bold;
            text-align: center;
            padding: 10px 0;
        }
        .signature td {
            height: 90px;
            vertical-align: bottom;
            text-align: center;
        }
        .registered {
            font-style: italic;
            font-size: 11px;
        }
    </style>
</head>
<body>

<table>
    <tr>
        <td colspan="10" class="title">
            Laporan Pembayaran Hasil Kerja Tim Potong<br>
            <?= htmlspecialchars($timnya['nama']) ?>
        </td>
    </tr>
    <tr>
        <th>No</th>
        <th>Tanggal</th>
        <th>Nama PO</th>
        <th>Jenis</th>
        <th>Size</th>
        <th>JML PO (Dz)</th>
        <th>JML PO (Pcs)</th>
        <th>Harga / Pcs</th>
        <th>Total Pendapatan</th>
        <th>Keterangan</th>
    </tr>

    <?php $no = 1; ?>
    <?php foreach ($products as $p): ?>
        <?php if ($p['total'] > 0): ?>
            <tr>
                <td class="text-center"><?= $no++ ?></td>
                <td class="text-center"><?= date('Y-m-d', strtotime($p['tanggal'])) ?></td>
                <td><?= htmlspecialchars($p['kode_po']) ?></td>
                <td><?= htmlspecialchars($p['jenis']) ?></td>
                <td class="text-center">'<?= $p['size'] ?></td>
                <td class="text-right">'<?= number_format($p['lusin'], 2) ?></td>
                <td class="text-right"><?= number_format($p['pcs']) ?></td>
                <td class="text-right"><?= number_format($p['harga'], 2) ?></td>
                <td class="text-right"><?= number_format($p['total'], 2) ?></td>
                <td></td>
            </tr>
        <?php endif; ?>
    <?php endforeach; ?>

    <tr>
        <td colspan="8" class="text-right"><b>Subtotal</b></td>
        <td class="text-right"><b><?= number_format($totals, 2) ?></b></td>
        <td></td>
    </tr>
    <tr>
        <td colspan="8" class="text-right"><b>Saving 5%</b></td>
        <td class="text-right"><b><?= number_format($savings, 2) ?></b></td>
        <td></td>
    </tr>
    <tr>
        <td colspan="8" class="text-right"><b>Total Claim</b></td>
        <td class="text-right"><b><?= number_format($claim, 2) ?></b></td>
        <td></td>
    </tr>
    <tr>
        <td colspan="8" class="text-right"><b>Total Diterima</b></td>
        <td class="text-right"><b><?= number_format($nominals, 2) ?></b></td>
        <td></td>
    </tr>
</table>

<br><br>

<table class="no-border">
    <tr>
        <td colspan="6"></td>
        <td colspan="4" class="text-right">
            Jakarta, <?= date('d F Y', strtotime($prods['tanggal'])) ?>
        </td>
    </tr>
</table>

<br>

<table>
    <tr>
        <th>Menyetujui</th>
        <th>Dibuat Oleh</th>
    </tr>
    <tr class="signature">
        <td>
            ( _________________ )<br>
            <b>SPV</b>
        </td>
        <td>
            ( Mia )<br>
            <b>ADM Keuangan</b>
        </td>
    </tr>
</table>

<br>

<table class="no-border">
    <tr>
        <td class="text-right registered">
            Registered by Forboys Production System<br>
            <?= date('d-m-Y H:i:s') ?>
        </td>
    </tr>
</table>

</body>
</html>
