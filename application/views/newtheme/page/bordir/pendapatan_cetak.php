<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Laporan_Pendapatan_Bordir.xls");
?>
<table style="border-collapse: collapse;width: 100%">
  <tr>
    <td align="center" colspan="9"><h3>Laporan Pendapatan Mesin Harian Bordir</h3></td>
  </tr>
  <tr>
    <td colspan="9"></td>
  </tr>
  <tr>
    <td colspan="9">Periode <?php echo date('d F Y',strtotime($tanggal1))?> - <?php echo date('d F Y',strtotime($tanggal2))?></td>
  </tr>
</table>
<?php foreach($products as $p){?>
                    <?php 
                      $mesin[]=$p['nomesin'];
                      $d[]=$p['0.2'];
                    ?>
                  <?php } ?>
<table border="1" style="border-collapse: collapse;width: 100%">
              <thead>
                <tr>
                  <!-- <th>Tanggal</th> -->
                  <th>No.Mesin</th>
                  <th>Shift</th>
                  <th>Stich</th>
                  <th>0.18</th>
                  <th>0.2</th>
                  <!-- <th>0.18 YN</th> -->
                  <th>Pendapatan</th>
                  <th>Jumlah</th>
                  <th>Keterangan</th>
                </tr>
              </thead>
              <tbody>
                <?php $rowspan=0;?>
                <?php if($products){?>
                  <?php foreach($products as $p){?>
                    <tr>
                      <!-- <td><?php echo $p['tanggal']?></td> -->
                      <td>Mesin <?php echo $p['nomesin']?></td>
                      <td><?php echo $p['shift']?></td>
                      <td><?php echo ($p['stich'])?></td>
                      <td><?php echo ($p['0.18'])?></td>
                      <!-- <td><?php echo $p['nomesin']==next($mesin)?'':$p['0.2']==next($d)?($p['0.2']):''; ?></td> -->
                      <td><?php echo ($p['0.2']); ?></td>
                      <!-- <td>0</td> -->
                      <td><?php echo ($p['pendapatan'])?></td>
                      <td align="center" <?php echo $p['nomesin']==current($mesin)?'rowspan="2"':''; ?>><?php echo $p['nomesin']==current($mesin)?($p['jumlah']):''; ?></td>
                      <td><?php //echo ?></td>
                    </tr>
                  <?php }?>
                    <tr>
                      <td colspan="2"><b>Total</b></td>
                      <td><?php echo round($t)?></td>
                      <td><?php echo round($g018)?></td>
                      <td><?php echo round($g02)?></td>
                      <!-- <td></td> -->
                      <td><?php echo round($gpendapatan)?></td>
                      <td><?php echo round($gpendapatan)?></td>
                      <td></td>
                    </tr>
                <?php }?>
              </tbody>
            </table>