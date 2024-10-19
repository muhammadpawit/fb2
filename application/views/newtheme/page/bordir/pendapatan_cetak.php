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
    <td align="center" colspan="9"><h3><?php echo date('d F Y',strtotime($tanggal2)) ?></h3></td>
  </tr>
  <tr>
    <td colspan="9"></td>
  </tr>
  <tr>
    <td colspan="9">Periode <?php echo date('d F Y',strtotime($tanggal1))?> - <?php echo date('d F Y',strtotime($tanggal2))?></td>
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
        // $total_permesin = 0;
        $total_per_mesin = [];
        $total_pendapatan = 0;

        // Step 1: Hitung total per mesin untuk setiap shift pagi dan malam
        foreach ($products as $p) {
          if (!isset($total_per_mesin[$p['nomesin']])) {
              $total_per_mesin[$p['nomesin']] = 0;
          }

          // Tambahkan pendapatan shift ke total mesin
          $total_per_mesin[$p['nomesin']] += $p['pendapatan'];
      }
      
      $j = 0;

        ?>

        <?php foreach($products as $p){ ?>
          <tr>
            <td>Mesin <?php echo $p['nomesin']?></td>
            <td><?php echo $p['shift']?></td>
            <td align="right"><?php echo number_format($p['stich'])?></td>
            <td align="right"><?php echo number_format($p['0.15']); ?></td>
            <td align="right"><?php echo number_format($p['0.18'])?></td>

            <?php 
            $jumlah_permesin = $p['0.18']; // Mulai dengan nilai dari 0.18 saja
            foreach($luar as $b) {
              // Ambil nilai kolom dinamis
              $hasil = json_encode($this->ReportModel->total02_array($p['nomesin'], $p['shift'], $p['tanggal1'], $p['tanggal2'], $b['idpemilik']));
              $data = json_decode($hasil);

              $nilaiData = isset($data->data) ? $data->data : 0;
              $jumlah_permesin += $nilaiData; // Tambahkan nilai dinamis ke jumlah per mesin
              ?>
              <td align="right"><?php echo number_format($nilaiData); ?></td>
            <?php } ?>

            <!-- Tampilkan jumlah per mesin -->
            <td align="right"><?php echo number_format($jumlah_permesin); ?></td>

            <!-- Pendapatan Per Mesin -->
            <td align="right">
            <?php 
                    // Step 3: Hanya tampilkan total pendapatan per mesin di shift malam
                    if ($p['shift'] == 'MALAM' && isset($total_per_mesin[$p['nomesin']])) {
                        echo number_format($total_per_mesin[$p['nomesin']]);
                        $grand_total += $total_per_mesin[$p['nomesin']]; // Tambahkan ke grand total
                    } else {
                        echo 0;
                    }
            ?>
            </td>
            <td><?php // Keterangan ?></td>
          </tr>
        <?php } ?>

        <!-- Tampilkan total -->
        <tr>
          <td colspan="7"><b>Total</b></td>
          <td align="right"><b><?php echo number_format($total_permesin); ?></b></td>
          <td align="right"><b><?php echo number_format($grand_total); ?></b></td>
          <td></td>
        </tr>
        <tr>
                  <td colspan="2"></td>
                  <td colspan="8">
                   
                  </td>
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