<!DOCTYPE html>
<html>
<head>
    <title>Laporan Buku Tambahan Utang</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        h3 { margin: 0; padding: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 5px; }
        th { background-color: #f2f2f2; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h3>Buku Tambahan Utang</h3>
        <p>Tanggal Cetak: <?php echo date('d/m/Y H:i'); ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Vendor</th>
                <th>Total Hutang (Rp)</th>
                <th>Total Terbayar (Rp)</th>
                <th>Sisa Hutang (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1; 
            $grand_hutang = 0;
            $grand_bayar = 0;
            $grand_sisa = 0;
            foreach($results as $r): 
                $sisa = $r['total_hutang'] - $r['total_bayar'];
                $grand_hutang += $r['total_hutang'];
                $grand_bayar += $r['total_bayar'];
                $grand_sisa += $sisa;
            ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $r['nama_supplier']; ?></td>
                <td class="text-right"><?php echo number_format($r['total_hutang'], 2); ?></td>
                <td class="text-right"><?php echo number_format($r['total_bayar'], 2); ?></td>
                <td class="text-right"><?php echo number_format($sisa, 2); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2" class="text-right">TOTAL KESELURUHAN</th>
                <th class="text-right"><?php echo number_format($grand_hutang, 2); ?></th>
                <th class="text-right"><?php echo number_format($grand_bayar, 2); ?></th>
                <th class="text-right"><?php echo number_format($grand_sisa, 2); ?></th>
            </tr>
        </tfoot>
    </table>
</body>
</html>
