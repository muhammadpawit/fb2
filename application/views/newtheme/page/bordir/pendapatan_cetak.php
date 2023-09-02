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
<?php foreach($products as $p){?>
                    <?php 
                      $mesin[]=$p['nomesin'];
                      $d[]=$p['0.2'];
                    ?>
                  <?php } ?>
<table border="1" style="border-collapse: collapse;width: 100%;">
              <thead>
                <tr>
                <th class="tg-0pky" rowspan="2">NO MESIN</th>
                <th class="tg-0pky" rowspan="2">SHIFT</th>
                <th class="tg-0pky" rowspan="2">TOTAL STICH</th>
                <th class="tg-0pky" rowspan="2">PENDAPATAN MESIN (0,15)</th>
                <?php $col=count($luar) ?>
                
                <th class="bgyellow" colspan="<?php echo count($luar)+3 ?>">PENDAPATAN BORDIR </th>
                <th class="tg-0pky" rowspan="2">KETERANGAN</th>
              </tr>
              <tr style="background-color: yellow !important;font-size: 16.5px;font-weight: bold;">
                <th class="bgyellow">PO DALAM (0,18)</th>
                <?php foreach($luar as $l){?>
                  <th class="bgyellow">PO LUAR <?php echo $l['perkalian'] .' '.$l['nama']?></th>
                  <?php } ?>
                <!-- <th class="bgyellow">PO LUAR (0,25)</th>
                <th class="bgyellow">PO LUAR (0,18)</th> -->
                <th class="bgyellow">PER SHIF (Rp)</th>
                <th class="bgyellow">PER MESIN</th>
              </tr>
              <tbody>
                <?php $rowspan=0;?>
                <?php foreach($products as $p){?>
                    <?php 
                      $mesin[]=$p['nomesin'];
                      $d[]=$p['0.2'];
                    ?>
                  <?php } ?>
                <?php if($products){?>
                  <?php $j=0;?>
                  <?php foreach($products as $p){?>
                    <tr>
                      <!-- <td><?php echo $p['tanggal']?></td> -->
                      <td align="center">Mesin <?php echo $p['nomesin']?></td>
                      <td align="center"><?php echo $p['shift']?></td>
                      <td align="center"><?php echo round($p['stich'])?></td>
                      <td align="center"><?php echo round($p['0.15']); ?></td>
                      <td align="center"><?php echo round($p['0.18'])?></td>
                      <?php foreach($luar as $b){?>
                        <td align="right">
                        <?php //if($b['perkalian']==$p['dets'][$b['perkalian']]){?>
                          <?php 
                            $hasil = json_encode($this->ReportModel->total02_array($p['nomesin'],$p['shift'],$p['tanggal1'],$p['tanggal2'],$b['idpemilik']));
                            $data = json_decode($hasil);
                            ?>
                          <?php 
                            if (isset($data->data)) {
                              $nilaiData = $data->data;
                              echo number_format($nilaiData); // Ini akan mencetak "321753.61278533936"
                            } else {
                               // echo "Tidak ada data yang ditemukan.";
                            }
                          //echo !empty($hasil) ? $hasil->data : 0;//echo json_encode($p['dets']) ?> 
                        <?php //} ?>
                      </td>
                    <?php } ?>
                      <td align="center"><?php echo round($p['pendapatan'])?></td>
                      <td align="center">
                        <?php //echo $p['nomesin']==current($mesin)?number_format($p['jumlah']):''; ?>
                        <?php if($j%2==1){?>
                        <?php echo round($p['jumlah']); ?>
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
                      <td align="center" colspan="<?php echo count($luar)?>">
                          <?php echo round($g02)?> 
                      </td>
                      <!-- <td></td> -->
                      <td align="center"><?php echo round($gpendapatan)?></td>
                      <td align="center"><?php echo round($gpendapatan)?></td>
                      <td></td>
                    </tr>
                <?php }?>
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