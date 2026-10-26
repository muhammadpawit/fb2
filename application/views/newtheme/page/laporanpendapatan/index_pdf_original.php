<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pendapatan Finishing</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h3 {
            margin: 0;
            padding: 0;
            font-size: 16px;
        }
        .header p {
            margin: 5px 0 0 0;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 5px;
            vertical-align: middle;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .row-subtotal {
            background-color: #e6e6e6;
            font-weight: bold;
        }
        .row-subtotal td {
            border-top: 2px solid #000;
        }
        .footer-total {
            background-color: #d9d9d9;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h3>HITUNGAN PENDAPATAN FINISHING</h3>
        <p>Periode: <?php echo date('d-m-Y', strtotime($tanggal1)); ?> s.d <?php echo date('d-m-Y', strtotime($tanggal2)); ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th>NO</th>
                <th>PERIODE</th>
                <th>JENIS</th>
                <th>PENDAPATAN LUSINAN</th>
                <th>PERKALIAN</th>
                <th>HASIL</th>
                <th>PENGELUARAN</th>
                <th>NOMINAL</th>
                <th>SALDO</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            $grand_total_dz = 0;
            $grand_total_hasil = 0;
            $grand_total_nominal = 0;
            $grand_total_saldo = 0;
            
            foreach($weeks as $week){ 
                $rows = $week['pendapatan'];
                $rowCount = count($rows);
                
                $pengeluaran = array();
                $pengeluaran[] = array('label' => $week['nama_tabung_gas'], 'nominal' => $week['tabung_gas']);
                $pengeluaran[] = array('label' => 'Anak Harian', 'nominal' => $week['anak_harian']);
                $pengeluaran[] = array('label' => 'Anak Borongan', 'nominal' => $week['anak_borongan']);
                
                $totalRows = max($rowCount, count($pengeluaran));
                
                $week_total_dz = 0;
                $week_total_hasil = 0;
                $week_total_nominal = 0;
                
                foreach($pengeluaran as $pe){
                    $week_total_nominal += $pe['nominal'];
                }
                
                for($i = 0; $i < $totalRows; $i++){
            ?>
            <tr>
                <td class="text-center"><?php echo ($i < $rowCount) ? $no++ : ''; ?></td>
                
                <?php if($i == 0){ ?>
                <td rowspan="<?php echo $totalRows; ?>" class="text-center">
                    <?php echo $week['label']; ?>
                </td>
                <?php } ?>
                
                <td><?php echo ($i < $rowCount) ? $rows[$i]['jenis_po'] : ''; ?></td>
                
                <td class="text-right"><?php 
                    if($i < $rowCount){ 
                        echo number_format($rows[$i]['total_dz'], 2);
                        $week_total_dz += $rows[$i]['total_dz'];
                    } 
                ?></td>
                
                <td class="text-right"><?php 
                    if($i < $rowCount && $rows[$i]['nominal_perkalian'] > 0){ 
                        echo number_format($rows[$i]['nominal_perkalian']);
                    } 
                ?></td>
                
                <td class="text-right"><?php 
                    if($i < $rowCount){ 
                        echo number_format($rows[$i]['total_pendapatan']);
                        $week_total_hasil += $rows[$i]['total_pendapatan'];
                    } 
                ?></td>
                
                <td><?php echo ($i < count($pengeluaran)) ? $pengeluaran[$i]['label'] : ''; ?></td>
                
                <td class="text-right"><?php echo ($i < count($pengeluaran) && $pengeluaran[$i]['nominal'] > 0) ? number_format($pengeluaran[$i]['nominal']) : ''; ?></td>
                
                <td></td>
            </tr>
            <?php } ?>
            
            <tr class="row-subtotal">
                <td></td>
                <td></td>
                <td></td>
                <td class="text-right"><?php echo number_format($week_total_dz, 2); ?></td>
                <td></td>
                <td class="text-right"><?php echo number_format($week_total_hasil); ?></td>
                <td></td>
                <td class="text-right"><?php echo number_format($week_total_nominal); ?></td>
                <?php $saldo = $week_total_hasil - $week_total_nominal; ?>
                <td class="text-right" style="color: <?php echo $saldo < 0 ? '#c62828' : '#000000'; ?>;"><?php 
                    echo number_format($saldo);
                    $grand_total_dz += $week_total_dz;
                    $grand_total_hasil += $week_total_hasil;
                    $grand_total_nominal += $week_total_nominal;
                    $grand_total_saldo += $saldo;
                ?></td>
            </tr>
            <?php } ?>
        </tbody>
        <tfoot>
            <tr class="footer-total">
                <td colspan="3" class="text-right">GRAND TOTAL</td>
                <td class="text-right"><?php echo number_format($grand_total_dz, 2); ?></td>
                <td></td>
                <td class="text-right"><?php echo number_format($grand_total_hasil); ?></td>
                <td></td>
                <td class="text-right"><?php echo number_format($grand_total_nominal); ?></td>
                <td class="text-right" style="color: <?php echo $grand_total_saldo < 0 ? '#c62828' : '#000000'; ?>;"><?php echo number_format($grand_total_saldo); ?></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
