<?php
$total_trf=0;
$total_kasmasuk=0;
$total_kasmasuk_bordir=0;
$total_kasmasuk_sablon=0;

$total_trf_konveksi=0;
$total_cash_konveksi=0;
$total_sisa_konveksi=0;

$total_trf_bordir=0;
$total_cash_bordir=0;
$total_sisa_bordir=0;


$total_trf_sablon=0;
$total_cash_sablon=0;
$total_sisa_sablon=0;
$total_pinjaman=0;

$no=1;
?>
<style type="text/css">
  @import url('https://fonts.googleapis.com/css2?family=Baskervville:ital@1&display=swap');
  .registered {
    font-family: 'Baskervville', serif;
  }
  table {
    font-size: 11px;
  }
  th, td {
    padding: 3px;
  }
</style>
<table width="100%">
  <tr>
    <td align="center"><h2>Laporan Gabungan Transfer dan Kas</h2></td>
  </tr>
</table>
<br>
<table border="1" style="width: 100%;border-collapse: collapse;">
  <thead>
    <tr style="text-align: center!important;" valign="top">
      <th rowspan="2" style="vertical-align : middle;text-align:center;">No</th>
      <th rowspan="2" style="vertical-align : middle;text-align:center;">Tanggal</th>
      <th rowspan="2" style="vertical-align : middle;text-align:center;">Trf</th>
      <th rowspan="2" style="vertical-align : middle;text-align:center;">Kas Diterima</th>
      <th rowspan="2" style="vertical-align : middle;text-align:center;">Pinjaman</th>
      <th colspan="3">Kas Konveksi</th>
      <th colspan="3">Kas Bordir</th>
      <th colspan="3">Kas Sablon</th>
      <th rowspan="2" style="vertical-align : middle;text-align:center;">Ket</th>
    </tr>
    <tr>
      <th class="tg-0lax">TRF</th>
      <th class="tg-0lax">Masuk</th>
      <th class="tg-0lax">Sisa</th>
      <th class="tg-0lax">TRF</th>
      <th class="tg-0lax">Masuk</th>
      <th class="tg-0lax">Sisa</th>
      <th class="tg-0lax">TRF</th>
      <th class="tg-0lax">Masuk</th>
      <th class="tg-0lax">Sisa</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($products as $p){?>
      <?php $hari= date('l',strtotime($p['tanggal']))?>
    <tr>
      <td><?php echo $no++; ?></td>
      <td><?php echo hari($hari).', '.date('d-m-Y',strtotime($p['tanggal']))?></td>
      <td></td>
      <td align="right"><?php echo !empty($p['kasmasuk']) ? number_format($p['kasmasuk']) : 0?></td>
      <td align="right"><?php echo !empty($p['pinjaman']) ? number_format($p['pinjaman']) : 0?></td>
      <td></td>
      <td align="right"><?php echo !empty($p['masukkonveksi']) ? number_format($p['masukkonveksi']):0?></td>
      <td align="right"><?php echo !empty($p['sisa_konveksi']) ? number_format($p['sisa_konveksi']):0?></td>
      <td></td>
      <td align="right"><?php echo !empty($p['masukbordir']) ? number_format($p['masukbordir']) : 0 ?></td>
      <td align="right"><?php echo !empty($p['sisa_bordir']) ? number_format($p['sisa_bordir']) : 0 ?></td>
      <td></td>
      <td align="right"><?php echo !empty($p['masuksablon']) ? number_format($p['masuksablon']) : 0 ?></td>
      <td align="right"><?php echo !empty($p['sisa_sablon']) ? number_format($p['sisa_sablon']) : 0 ?></td>
      <td><?php echo $p['keterangan']?></td>
    </tr>
    <?php
      $total_kasmasuk+=(!empty($p['kasmasuk'])?$p['kasmasuk']:0);
      $total_cash_konveksi+=(!empty($p['masukkonveksi'])?$p['masukkonveksi']:0);
      $total_sisa_konveksi+=(!empty($p['sisa_konveksi'])?$p['sisa_konveksi']:0);

      $total_kasmasuk_bordir+=(!empty($p['masukbordir'])?$p['masukbordir']:0);
      $total_cash_bordir+=(!empty($p['masukbordir'])?$p['masukbordir']:0);
      $total_sisa_bordir+=(!empty($p['sisa_bordir'])?$p['sisa_bordir']:0);

      $total_kasmasuk_sablon+=(!empty($p['masuksablon'])?$p['masuksablon']:0);
      $total_cash_sablon+=(!empty($p['masuksablon'])?$p['masuksablon']:0);
      $total_sisa_sablon+=(!empty($p['sisa_sablon'])?$p['sisa_sablon']:0);
      $total_pinjaman+=(!empty($p['pinjaman'])?$p['pinjaman']:0);
    ?>
    <?php if($p['konveksi']){?>
      <?php foreach($p['konveksi'] as $k){?>
        <?php $total_trf+=($k['nominal']); ?>
        <tr>
          <td></td>
          <td></td>
          <td align="right"><?php echo number_format($k['nominal'])?></td>
          <td></td>
          <td></td>
          <td align="right">
            <?php if($k['bagian']==1){?>
              <?php echo number_format($k['nominal'])?>
              <?php $total_trf_konveksi+=($k['nominal']);?>
            <?php } ?>
          </td>
          <td></td>
          <td></td>
          <td align="right">
            <?php if($k['bagian']==2){?>
              <?php echo number_format($k['nominal'])?>
              <?php $total_trf_bordir+=($k['nominal']);?>
            <?php } ?>
          </td>
          <td></td>
          <td></td>
          <td align="right">
            <?php if($k['bagian']==3){?>
              <?php echo number_format($k['nominal'])?>
              <?php $total_trf_sablon+=($k['nominal']);?>
            <?php } ?>
          </td>
          <td></td>
          <td></td>
          <td><?php echo strtolower($k['keterangan'])?></td>
        </tr>
      <?php } ?>
    <?php } ?>
  <?php } ?>
  </tbody>
  <tfoot>
        <tr>
          <td colspan="2" align="center"><b>Total</b></td>
          <td align="right"><b><?php echo number_format($total_trf,0) ?></b></td>
          <td align="right"><b><?php echo number_format($total_kasmasuk,0) ?></b></td>
          <td align="right"><b><?php echo number_format($total_pinjaman,0) ?></b></td>
          <td align="right"><b><?php echo number_format($total_trf_konveksi,0) ?></b></td>
          <td align="right"><b><?php echo number_format($total_cash_konveksi,0) ?></b></td>
          <td align="right"><b><?php echo number_format($total_sisa_konveksi,0) ?></b></td>
          <td align="right"><b><?php echo number_format($total_trf_bordir,0) ?></b></td>
          <td align="right"><b><?php echo number_format($total_cash_bordir,0) ?></b></td>
          <td align="right"><b><?php echo number_format($total_sisa_bordir,0) ?></b></td>
          <td align="right"><b><?php echo number_format($total_trf_sablon,0) ?></b></td>
          <td align="right"><b><?php echo number_format($total_cash_sablon,0) ?></b></td>
          <td align="right"><b><?php echo number_format($total_sisa_sablon,0) ?></b></td>
          <td></td>
        </tr>
        <tr>
            <td colspan="2" align="center"><b>Total Keseluruhan</b></td>
            <td colspan="2" align="center"><b><?php echo number_format($total_trf+$total_kasmasuk,0) ?></b></td>
            <td align="center"><b><?php echo number_format($total_pinjaman,0) ?></b></td>
            <td colspan="2" align="center"><b><?php echo number_format($total_trf_konveksi+$total_cash_konveksi,0) ?></b></td>
            <td align="center"><b><?php echo number_format($total_sisa_konveksi)?></b></td>
            <td colspan="2" align="center"><b><?php echo number_format($total_trf_bordir+$total_cash_bordir,0) ?></b></td>
            <td align="center"><b><?php echo number_format($total_sisa_bordir)?></b></td>
            <td colspan="2" align="center"><b><?php echo number_format($total_trf_sablon+$total_cash_sablon,0) ?></b></td>
            <td align="center"><b><?php echo number_format($total_sisa_sablon)?></b></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" align="center"><b>Grand Total</b></td>
            <td colspan="2" align="center"><b><?php echo number_format($total_trf+$total_kasmasuk,0) ?></b></td>
            <td colspan="4" align="center"><b><?php echo number_format( ($total_trf_konveksi+$total_cash_konveksi) + ($total_trf_bordir+$total_cash_bordir) + ($total_trf_sablon+$total_cash_sablon) ,0) ?></b></td>
            <td colspan="7"></td>
        </tr>
      </tfoot>
</table>
<br>
<table width="100%">
  <tr>
    <td width="70%"></td>
    <td width="30%">
      <table border="1" style="width: 100%;border-collapse: collapse;">
        <tr>
            <th>Menyetujui</th>
            <th>Dibuat oleh:</th>
        </tr>
        <tr align="center">
            <td><b>SPV</b></td>
            <td><b>ADM Keuangan</b></td>
        </tr>
        <tr>
            <td height="100" align="center">
                <br><br><br><br><br>
                ( )
            </td>
             <td height="100" align="center">
                <br><br><br><br><br>
                (  )
            </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td colspan="2" align="right"><i class="registered">Registered by Forboys Production System <?php echo date('d-m-Y H:i:s'); ?></i></td>
  </tr>
</table>
