<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pembayaran Sablon</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
        }
        .info {
            margin-bottom: 15px;
        }
        .info table {
            width: 100%;
        }
        .info td {
            padding: 2px;
        }
        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        table.data th, table.data td {
            border: 1px solid #ccc;
            padding: 6px;
        }
        table.data th {
            background-color: #f2f2f2;
            text-align: center;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .total-row {
            font-weight: bold;
            background-color: #f9f9f9;
        }
        .grand-total {
            background-color: #eee !important;
            font-weight: bold;
            font-size: 12px;
        }
        .footer {
            margin-top: 30px;
        }
        .footer table {
            width: 100%;
        }
        .footer td {
            text-align: center;
            width: 33%;
        }
        .signature-box {
            height: 60px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN PEMBAYARAN SABLON</h1>
        <p>Forboys Production System</p>
    </div>

    <div class="info">
        <table>
            <tr>
                <td width="15%">Nama CMT</td>
                <td width="2%">:</td>
                <td><strong><?php echo $cm['cmt_name']; ?></strong></td>
                <td width="15%">Periode</td>
                <td width="2%">:</td>
                <td><?php echo date('d M Y', strtotime($tanggal1)) . ' - ' . date('d M Y', strtotime($tanggal2)); ?></td>
            </tr>
        </table>
    </div>

    <h3 style="font-size: 12px; border-bottom: 1px solid #000; padding-bottom: 3px;">I. PENDAPATAN</h3>
    <table class="data">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Nama PO</th>
                <th width="10%">DZ</th>
                <th width="10%">PCS</th>
                <th width="15%">Harga</th>
                <th width="20%">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php $dz=0;$pcs=0;$total_pendapatan=0; $n=1; ?>
            <?php foreach($pendapatan as $p){ ?>
            <tr>
                <td class="text-center"><?php echo $n++; ?></td>
                <td><?php echo $p['namapo']; ?></td>
                <td class="text-right"><?php echo number_format($p['dz'], 2); ?></td>
                <td class="text-right"><?php echo number_format($p['pcs']); ?></td>
                <td class="text-right"><?php echo number_format($p['harga']); ?></td>
                <td class="text-right"><?php echo number_format($p['total']); ?></td>
            </tr>
            <?php 
                $dz += $p['dz'];
                $pcs += $p['pcs'];
                $total_pendapatan += $p['total'];
            ?>
            <?php } ?>
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="2" class="text-center">TOTAL PENDAPATAN</td>
                <td class="text-right"><?php echo number_format($dz, 2); ?></td>
                <td class="text-right"><?php echo number_format($pcs); ?></td>
                <td></td>
                <td class="text-right"><?php echo number_format($total_pendapatan); ?></td>
            </tr>
        </tfoot>
    </table>

    <h3 style="font-size: 12px; border-bottom: 1px solid #000; padding-bottom: 3px;">II. PENGELUARAN</h3>
    <table class="data">
        <thead>
            <tr>
                <th>No</th>
                <th>Cat & Afdruk</th>
                <th>Upah Harian</th>
                <th>Upah Borongan</th>
                <th>Lain-lain</th>
                <th>Listrik</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php $pengeluarantotal=0;$n=1;$total_tukang_borongan=0; ?>
            <?php foreach($pengeluaran as $p){ ?>
            <tr>
                <td class="text-center"><?php echo $n++; ?></td>
                <td class="text-right"><?php echo number_format($p['belanjacat']); ?></td>
                <td class="text-right"><?php echo number_format($p['upahtukang_harian']); ?></td>
                <td class="text-right"><?php echo number_format($p['upahtukang_borongan']); ?></td>
                <td class="text-right"><?php echo number_format($p['biayalain']); ?></td>
                <td class="text-right"><?php echo number_format($p['tokenlistrik']); ?></td>
                <td class="text-right"><?php echo number_format($p['total']); ?></td>
            </tr>
            <?php 
                $pengeluarantotal += $p['total']; 
                $total_tukang_borongan += ($p['upahtukang_harian'] + $p['upahtukang_borongan']);
            ?>
            <?php } ?>
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="6" class="text-center">TOTAL PENGELUARAN</td>
                <td class="text-right"><?php echo number_format($pengeluarantotal); ?></td>
            </tr>
        </tfoot>
    </table>

    <?php $tjml = 0; foreach($rekap as $r){ $tjml += $r['jumlah']; } ?>

    <h3 style="font-size: 12px; border-bottom: 1px solid #000; padding-bottom: 3px;">III. POTONGAN KLAIM / KASBON</h3>
    <table class="data">
        <thead>
            <tr>
                <th width="20%">Tanggal</th>
                <th width="15%">Type</th>
                <th>Keterangan</th>
                <th width="20%">Sisa Klaim</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($claim)){ ?>
            <tr>
                <td colspan="4" class="text-center">Tidak ada potongan klaim</td>
            </tr>
            <?php } else { ?>
                <?php foreach($claim as $c){ ?>
                <tr>
                    <td class="text-center"><?php echo $c['tanggal']; ?></td>
                    <td class="text-center"><?php echo $c['type']; ?></td>
                    <td><?php echo $c['keterangan']; ?></td>
                    <td class="text-right"><?php echo number_format($c['sisa']); ?></td>
                </tr>
                <?php } ?>
            <?php } ?>
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="3" class="text-center">TOTAL POTONGAN KLAIM</td>
                <td class="text-right"><?php echo number_format($totalclaim); ?></td>
            </tr>
        </tfoot>
    </table>

    <h3 style="font-size: 12px; border-bottom: 1px solid #000; padding-bottom: 3px;">IV. RINGKASAN PEMBAYARAN</h3>
    <table class="data">
        <tr>
            <td width="70%">Total Upah Tukang (Harian & Borongan)</td>
            <td width="5%" class="text-center">:</td>
            <td class="text-right"><?php echo number_format($total_tukang_borongan); ?></td>
        </tr>
        <tr>
            <td>Total Komisi Sablon</td>
            <td class="text-center">:</td>
            <td class="text-right"><?php echo number_format($tjml); ?></td>
        </tr>
        <tr>
            <td>Potongan Klaim / Kasbon</td>
            <td class="text-center">:</td>
            <td class="text-right" style="color: red;">- <?php echo number_format($totalclaim); ?></td>
        </tr>
        <tr class="grand-total">
            <td>TOTAL YANG DITERIMA</td>
            <td class="text-center">:</td>
            <td class="text-right">Rp <?php echo number_format($tjml + $total_tukang_borongan - $totalclaim); ?></td>
        </tr>
    </table>

    <div class="footer">
        <table>
            <tr>
                <td>
                    Menyetujui,<br>
                    <strong>Supervisor</strong>
                    <div class="signature-box"></div>
                    ( ................................. )
                </td>
                <td></td>
                <td>
                    Jakarta, <?php echo date('d M Y'); ?><br>
                    <strong>ADM Keuangan</strong>
                    <div class="signature-box"></div>
                    ( Mia )
                </td>
            </tr>
        </table>
    </div>

    <div style="margin-top: 20px; font-style: italic; font-size: 9px; text-align: right;">
        Registered by Forboys Production System <?php echo date('d-m-Y H:i:s'); ?>
    </div>
</body>
</html>
