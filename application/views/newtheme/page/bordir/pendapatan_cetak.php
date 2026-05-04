<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Laporan_Pendapatan_Bordir.xls");
?>
<style type="text/css">
  @import url('https://fonts.googleapis.com/css2?family=Baskervville:ital@1&display=swap');
  .registered {
    font-family: 'Baskervville', serif;
  }

  h3 {
    text-decoration: underline;
  }
  .tg-0pky{background-color: #19a83f;font-size: 16.5px;font-weight: bold;}
  .bgyellow{background-color: yellow !important;font-size: 16.5px;font-weight: bold;}
</style>
<table style="border-collapse: collapse;width: 100%">
  <tr>
    <td align="center" colspan="9"><h3>Laporan Pendapatan Mesin Harian Bordir</h3></td>
  </tr>
  <tr>
    <td align="center" colspan="9"><h3><?php echo formatTanggalIndo($tanggal2) ?></h3></td>
  </tr>
  <tr>
    <td colspan="9"></td>
  </tr>
  <tr>
    <td colspan="9">Periode <?php echo formatTanggalIndo($tanggal1)?> - <?php echo formatTanggalIndo($tanggal2)?></td>
  </tr>
</table>
<table border="1" style="border-collapse: collapse;width: 100%;">
<thead>
        <tr style="background-color:yellow">
          <th>No.Mesin</th>
          <th>Shift</th>
          <th>Stich</th>
          <th>0.15</th>
          <th>0.18</th>
          <?php foreach($luar as $l){ ?>
            <th><?php echo $l['perkalian'] .' '.$l['nama']?></th>
          <?php } ?>
          <th>Jml Per Mesin (Rp)</th>
          <th>Pendapatan Per Mesin (Rp)</th>
          <th>Keterangan</th>
        </tr>
      </thead>
      <tbody>
        <?php 
        $total_per_mesin = [];
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

        foreach($products as $p){ 
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
            <td>Mesin <?php echo $p['nomesin']?></td>
            <td><?php echo $p['shift']?></td>
            <td align="right"><?php echo number_format($p['stich'])?></td>
            <td align="right"><?php echo number_format($p['0.15']); ?></td>
            <td align="right"><?php echo number_format($p['0.18'])?></td>

            <?php foreach($row_dynamic_values as $val) { ?>
              <td align="right"><?php echo number_format($val); ?></td>
            <?php } ?>

            <td align="right"><?php echo number_format($jumlah_permesin); ?></td>

            <td align="right">
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

        <tr>
          <td colspan="2"><b>Total</b></td>
          <td align="right"><b><?php echo number_format($total_stich); ?></b></td>
          <td align="right"><b><?php echo number_format($total_0_15); ?></b></td>
          <td align="right"><b><?php echo number_format($total_0_18); ?></b></td>
          <?php 
          foreach($total_jumlah_luar as $total_luar) {
              echo '<td align="right"><b>' . number_format($total_luar) . '</b></td>';
          }
          ?>
          <td align="right"><b><?php echo number_format($total_jumlah_per_mesin); ?></b></td>
          <td align="right"><b><?php echo number_format($grand_total); ?></b></td>
          <td></td>
        </tr>
        <tr>
            <td colspan="10">&nbsp;</td>
        </tr>
                <tr>
                  <td colspan="2"><b>Catatan :</b></td>
                  <td colspan="8">
                    1. PO Dalam 0,18 adalah PO Forboys, Kiddreams dll.
                  </td>
                </tr>
                <tr>
                  <td colspan="2"></td>
                  <td colspan="8">
                    2. PO Luar 0,25 adalah PO Homie Noya
                  </td>
                </tr>
                <tr>
                  <td colspan="2"></td>
                  <td colspan="8">
                    3. PO Luar 0,18 adalah PO Yaldi ( Dacap, Mak Nek, Daib)
                  </td>
                </tr>
                <tr>
                  <td colspan="2"></td>
                  <td colspan="8">
                    4. PO Luar 0,19 adalah PO Yaldi ( Nasywa )
                  </td>
                </tr>
                <tr>
                  <td colspan="10" align="right">
                    <i class="registered">Registered by Forboys Production System <?php echo date('d-m-Y H:i:s'); ?></i>
                  </td>
                </tr>
      </tbody>
            </table>