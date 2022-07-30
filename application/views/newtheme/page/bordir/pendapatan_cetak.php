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
</style>
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
<table border="1" style="border-collapse: collapse;width: 100%;">
              <thead>
                <tr style="background-color: yellow;font-size: 16.5px;font-weight: bold;">
                  <!-- <th>Tanggal</th> -->
                  <th>No.Mesin</th>
                  <th>Shift</th>
                  <th>Stich</th>
                  <th>0.15</th>
                  <th>0.18</th>
                  <th>0.2</th>
                  <th>0.3</th>
                  <!-- <th>0.18 YN</th> -->
                  <th>Jml Per Mesin (Rp)</th>
                  <th>Pendapatan Per Mesin (Rp)</th>
                  <th>Keterangan</th>
                </tr>
              </thead>
              <tbody>
                <?php $rowspan=0;?>
                <?php $j=0;?>
                <?php if($products){?>
                  <?php foreach($products as $p){?>
                    <tr>
                      <!-- <td><?php echo $p['tanggal']?></td> -->
                      <td align="center">Mesin <?php echo $p['nomesin']?></td>
                      <td align="center"><?php echo $p['shift']?></td>
                      <td align="center"><?php echo ($p['stich'])?></td>
                      <td align="center"><?php echo ($p['0.15']); ?></td>
                      <td align="center"><?php echo ($p['0.18'])?></td>
                      <td align="right">
                        <?php if($tanggal2<='2022-07-18'){?>
                        <?php echo number_format($p['0.2']); ?>
                        <?php } ?>    
                      </td>
                      <td align="right">
                        <?php if($tanggal2>'2022-07-18'){?>
                          <?php echo number_format($p['0.2']); ?>
                        <?php } ?>    
                      </td>
                      <!-- <td>0</td> -->
                      <td align="center"><?php echo ($p['pendapatan'])?></td>
                      <td align="center">
                        <?php //echo $p['nomesin']==current($mesin)?number_format($p['jumlah']):''; ?>
                        <?php if($j%2==1){?>
                        <?php echo ($p['jumlah']); ?>
                        <?php } ?>
                      </td>
                      <td><?php //echo ?></td>
                    </tr>
                    <?php $j++;?>
                  <?php }?>
                    <tr style="background-color: yellow;font-size: 16.5px;font-weight: bold;">
                      <td align="center" colspan="2"><b>Total</b></td>
                      <td align="center"><?php echo round($t)?></td>
                      <td align="center"><?php echo round($g015)?></td>
                      <td align="center"><?php echo round($g018)?></td>
                      <td align="right">
                        <?php if($tanggal2<='2022-07-18'){?>
                          <?php echo number_format($g02)?>
                        <?php } ?>    
                      </td>
                      <td align="right">
                        <?php if($tanggal2>'2022-07-18'){?>
                          <?php echo number_format($g02)?>
                        <?php } ?>        
                      </td>
                      <!-- <td></td> -->
                      <td align="center"><?php echo round($gpendapatan)?></td>
                      <td align="center"><?php echo round($gpendapatan)?></td>
                      <td></td>
                    </tr>
                <?php }?>
                <tr>
                  <td colspan="9" align="right">
                    <i class="registered">Registered by Forboys Production System <?php echo date('d-m-Y H:i:s'); ?></i>
                  </td>
                </tr>
              </tbody>
            </table>