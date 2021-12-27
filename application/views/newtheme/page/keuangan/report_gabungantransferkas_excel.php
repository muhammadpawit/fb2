<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Laporan_Kas_Transfer.xls");
?>

<table border="1" style="width: 100%;border-collapse: collapse;">
<thead>
        <tr style="text-align: center!important;" valign="top">
          <th rowspan="2" style="vertical-align : middle;text-align:center;">#</th>
          <th rowspan="2" style="vertical-align : middle;text-align:center;">Tanggal</th>
          <th rowspan="2" style="vertical-align : middle;text-align:center;">Trf</th>
          <th rowspan="2" style="vertical-align : middle;text-align:center;">Kas Diterima</th>
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
          <td>#</td>
          <td><?php echo hari($hari).', '.date('d-m-Y',strtotime($p['tanggal']))?></td>
          <td></td>
          <td><?php echo ($p['kasmasuk'])?></td>
          <td></td>
          <td><?php echo ($p['masukkonveksi'])?></td>
          <td><?php echo ($p['masukkonveksi']-$p['keluarkonveksi'])?></td>
          <td></td>
          <td><?php echo ($p['masukbordir'])?></td>
          <td><?php echo ($p['masukbordir']-$p['keluarbordir'])?></td>
          <td></td>
          <td><?php echo ($p['masuksablon'])?></td>
          <td><?php echo ($p['masuksablon']-$p['keluarsablon'])?></td>
          <td><?php echo $p['keterangan']?></td>
        </tr>
        <?php if($p['konveksi']){?>
          <?php foreach($p['konveksi'] as $k){?>
            <tr>
              <td></td>
              <td></td>
              <td><?php echo ($k['nominal'])?></td>
              <td></td>
              <td>
                <?php if($k['bagian']==1){?>
                  <?php echo ($k['nominal'])?>
                <?php } ?>
              </td>
              <td></td>
              <td></td>
              <td>
                <?php if($k['bagian']==2){?>
                  <?php echo ($k['nominal'])?>
                <?php } ?>
              </td>
              <td></td>
              <td></td>
              <td>
                <?php if($k['bagian']==3){?>
                  <?php echo ($k['nominal'])?>
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
    </table>