<html>
  <head>

  </head>
  <body>
    <div class="title">
        <center>
            <h3><?php echo $title ?><br>
            No. Faktur  : <?php echo $gudangfb[0]['nofaktur'] ?>
            </h3>
        </center>
    </div>
    <div class="subtitle">
        <table style="width: 50%;">
            <tr>
                <td>Kepada Yth</td>
                <td>:</td>
                <td><?php echo ucwords(strtolower('Gudang FORBOYS H Soleh'))?></td>
            </tr>
        </table>
    </div>
    <div class="body">
      <table border="1" style="border-collapse: collapse; width: 100%; border-color: #dee2e6 !important; font-size: 12pt !important;">
        <thead>
          <tr>
            <th rowspan="3">No</th>
            <th rowspan="3">Artikel / Nama PO</th>
            <th colspan="<?php echo count($sizes) * 2 ?>">Qty Per Size</th>
            <th rowspan="3">Harga</th>
            <th rowspan="3">Jumlah Qty</th>
            <th rowspan="3">Total</th>
            <th rowspan="3">Keterangan</th>
          </tr>
          <tr>
            <?php foreach($sizes as $key => $val) { ?>
              <td align="center" colspan="2"><strong><?php echo $val ?></strong></td>
            <?php } ?>
          </tr>
          <tr>
            <?php foreach($sizes as $size) { ?>
              <td align="center">Dz</td>
              <td align="center">Pcs</td>
            <?php } ?>
          </tr>
        </thead>
        <tbody>
          <?php $no = 1;$total=0; ?>
          <?php foreach($prods as $p) { ?>
            <tr>
              <td align="center"><?php echo $no; ?></td>
              <td><?php echo $p['artikel_po'].' / '.$p['po']; ?></td>
              
              <?php foreach($sizes as $size) { 
                  $lusinValue = '-'; // Default kosong untuk Dz
                  $pcsValue = '-';   // Default kosong untuk Pcs
                  foreach($p['details'] as $d) {
                      if($d['rincian_size'] == $size) { 
                          $lusinValue = $d['rincian_lusin']; // Nilai Dz
                          $pcsValue = $d['rincian_piece'];     // Nilai Pcs
                          break;
                      }
                  } 
              ?>
                <td align="center"><?php echo $lusinValue ; ?></td>
                <td align="center"><?php echo $pcsValue==0 ? '-':$pcsValue; ?></td>
              <?php } ?>
              
              <td align="right"><?php echo number_format($p['harga_satuan']) ?></td>
              <td align="center"><?php echo $p['jumlah_piece_diterima'] ?></td>
              <td align="right"><?php echo number_format($p['harga_satuan'] * $p['jumlah_piece_diterima']) ?></td>
              <td><?php echo $p['keterangan']?></td>
            </tr>
            <?php $no++; ?>
            <?php $total += $p['harga_satuan'] * $p['jumlah_piece_diterima']; ?>
          <?php } ?>
        </tbody>
        <tfoot>
          <tr>
            <td align="center" colspan="<?php echo (count($sizes) * 2)+4 ?>"><b>Grand Total </b></td>
            <td align="right"><strong><?php echo number_format($total) ?></strong></td>
            <td></td>
          </tr>
        </tfoot>
      </table>
      <div class="ttd">
        <table class="table table-bordered" border="0" style="border-collapse: collapse;">
          <tr>
            <td colspan="4">Jakarta, <?php echo format_tanggal($gudangfb[0]['tanggal_kirim']) ?> </td>
          </tr>
          <tr style="text-align: center;">
            <td width="100px"><b>PIC Gudang</b></td>
            <td width="100px"><b>Adm Finishing</b></td>
            <td width="100px"><b>Driver</b></td>
            <td width="100px"><b>Security</b></td>
          </tr>
          <tr>
            <td valign="bottom" align="center" style="height: 100px">(....................)</td>
            <td valign="bottom" align="center" style="height: 100px">(....................)</td>
            <td valign="bottom" align="center" style="height: 100px">(....................)</td>
            <td valign="bottom" align="center" style="height: 100px">(....................)</td>
          </tr>
        </table>
      </div>
    </div>



                                                
  </body>
</html>