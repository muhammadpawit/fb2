<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pendapatan Mesin Bordir</title>
    <style type="text/css">
        @page {
            margin: 1cm;
        }
        body {
            font-family: sans-serif;
            font-size: 9px;
            margin: 0;
            padding: 0;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #000;
            padding: 3px;
        }
        th {
            background-color: yellow;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .no-border {
            border: none;
        }
        h3 {
            margin: 2px 0;
            text-decoration: underline;
            font-size: 14px;
        }
        p {
            margin: 2px 0;
        }
        .registered {
            font-style: italic;
            margin-top: 5px;
            font-size: 8px;
        }
    </style>
</head>
<body>
    <div class="text-center">
        <h3>Laporan Pendapatan Mesin Harian Bordir</h3>
        <h3><?php echo formatTanggalIndo($tanggal2) ?></h3>
        <p>Periode <?php echo formatTanggalIndo($tanggal1) ?> - <?php echo formatTanggalIndo($tanggal2) ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No.Mesin</th>
                <th>Shift</th>
                <th>Stich</th>
                <th>0.15</th>
                <th>0.18</th>
                <?php foreach ($luar as $l) { ?>
                    <th><?php echo $l['perkalian'] . ' ' . $l['nama'] ?></th>
                <?php } ?>
                <th>Jml Per Mesin (Rp)</th>
                <th>Pendapatan Per Mesin (Rp)</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $grand_total = 0;
            $total_jumlah_per_mesin = 0;
            $pendapatan_total_per_mesin = [];

            $total_stich = 0;
            $total_0_15 = 0;
            $total_0_18 = 0;
            $total_jumlah_luar = array_fill(0, count($luar), 0);

            $special_rates = [
                4 => 900,
            ];

            foreach ($products as $p) {
                $jumlah_permesin = $p['0.18'];
                $row_dynamic_values = [];

                foreach ($luar as $index => $b) {
                    $key = $b['idpemilik'] . '_' . $b['perkalian'];
                    $dataItem = isset($p['dynamic'][$key]) ? $p['dynamic'][$key] : ['total' => 0, 'qty' => 0];

                    if (isset($special_rates[$b['idpemilik']])) {
                        $nilaiData = $dataItem['qty'] * $special_rates[$b['idpemilik']];
                    } else {
                        $nilaiData = $dataItem['total'];
                    }

                    $jumlah_permesin += $nilaiData;
                    $total_jumlah_luar[$index] += $nilaiData;
                    $row_dynamic_values[] = $nilaiData;
                }

                if (!isset($pendapatan_total_per_mesin[$p['nomesin']])) {
                    $pendapatan_total_per_mesin[$p['nomesin']] = 0;
                }
                $pendapatan_total_per_mesin[$p['nomesin']] += $jumlah_permesin;

                $total_stich += $p['stich'];
                $total_0_15 += $p['0.15'];
                $total_0_18 += $p['0.18'];
                $total_jumlah_per_mesin += $jumlah_permesin;
                ?>
                <tr>
                    <td>Mesin <?php echo $p['nomesin'] ?></td>
                    <td><?php echo $p['shift'] ?></td>
                    <td class="text-right"><?php echo number_format($p['stich']) ?></td>
                    <td class="text-right"><?php echo number_format($p['0.15']); ?></td>
                    <td class="text-right"><?php echo number_format($p['0.18']) ?></td>

                    <?php foreach ($row_dynamic_values as $val) { ?>
                        <td class="text-right"><?php echo number_format($val); ?></td>
                    <?php } ?>

                    <td class="text-right"><?php echo number_format($jumlah_permesin); ?></td>

                    <td class="text-right">
                        <?php
                        if ($p['shift'] == 'MALAM') {
                            echo number_format($pendapatan_total_per_mesin[$p['nomesin']]);
                            $grand_total += $pendapatan_total_per_mesin[$p['nomesin']];
                        } else {
                            echo '';
                        }
                        ?>
                    </td>
                    <td></td>
                </tr>
            <?php } ?>

            <tr style="background-color: #eee; font-weight: bold;">
                <td colspan="2">Total</td>
                <td class="text-right"><?php echo number_format($total_stich); ?></td>
                <td class="text-right"><?php echo number_format($total_0_15); ?></td>
                <td class="text-right"><?php echo number_format($total_0_18); ?></td>
                <?php
                foreach ($total_jumlah_luar as $total_luar) {
                    echo '<td class="text-right">' . number_format($total_luar) . '</td>';
                }
                ?>
                <td class="text-right"><?php echo number_format($total_jumlah_per_mesin); ?></td>
                <td class="text-right"><?php echo number_format($grand_total); ?></td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <div style="margin-top: 10px;">
        <strong>Catatan :</strong><br>
        1. PO Dalam 0,18: PO Forboys, Kiddreams dll. | 2. PO Luar 0,25: PO Homie Noya<br>
        3. PO Luar 0,18: PO Yaldi (Dacap, Mak Nek, Daib) | 4. PO Luar 0,19: PO Yaldi (Nasywa)
    </div>

    <div class="registered text-right">
        Registered by Forboys Production System <?php echo date('d-m-Y H:i:s'); ?>
    </div>
</body>
</html>
