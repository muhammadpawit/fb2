
  <div class="row">
      <div class="col-md-3">
          <div class="form-group">
              <label>Tanggal Awal</label>
              <input type="text" name="tanggal1" id="tanggal1" value="<?php echo $tanggal1?>" class="form-control">
          </div>
      </div>
      <div class="col-md-3">
          <div class="form-group">
              <label>Tanggal Akhir</label>
              <input type="text" name="tanggal2" id="tanggal2" value="<?php echo $tanggal2?>" class="form-control">
          </div>
      </div>
      <div class="col-md-3">
          <div class="form-group">
              <label>No.Mesin</label>
              <select name="nomesin" class="form-control select2bs4" id="nomesin">
                <option value="*">Semua</option>
                <?php for($i=1;$i<=10;$i++){?>
                  <option value="<?php echo $i?>" <?php echo $nomesin==$i?'selected':'';?>>Mesin <?php echo $i?></option>
                <?php } ?>
              </select>
          </div>
      </div>
      <div class="col-md-3">
          <div class="form-group">
              <label>Action</label><br>
              <button class="btn btn-info" onclick="filter()">Filter</button>
              <button class="btn btn-info" onclick="excel()">Excel</button>
          </div>
      </div>
  </div>
<table class="table table-bordered table-striped">
              <thead>
                <tr style="background-color:yellow">
                  <!-- <th>Tanggal</th> -->
                  <th>No.Mesin</th>
                  <th>Shift</th>
                  <th>Stich</th>
                  <th>0.15</th>
                  <th>0.18</th>
                  <?php foreach($luar as $l){?>
                    <th><?php echo $l['perkalian'] .' '.$l['nama']?></th>
                  <?php } ?>
                  <!--
                  <th>0.2</th>
                  <th>0.3</th>
                  <th>0.18 YN</th> -->
                  <th>Jml Per Mesin (Rp)</th>
                  <th>Pendapatan Per Mesin (Rp)</th>
                  <th>Keterangan</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $rowspan=0;
                $total_g02 = 0; // Initialize total variable
                $permesin=[];
                ?>
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
                      <td>Mesin <?php echo $p['nomesin']?></td>
                      <td><?php echo $p['shift']?></td>
                      <td align="right"><?php echo number_format($p['stich'])?></td>
                      <td align="right"><?php echo number_format($p['0.15']); ?></td>
                      <td align="right"><?php echo number_format($p['0.18'])?></td>
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
                              $total_g02 += $nilaiData;
                            } else {
                               // echo "Tidak ada data yang ditemukan.";
                            }
                          //echo !empty($hasil) ? $hasil->data : 0;//echo json_encode($p['dets']) ?> 
                        <?php //} ?>
                      </td>
                      <?php } ?>
                      <?php $permesin[]=$p['pendapatan'];?>
                        <td align="right"><?php echo number_format($p['pendapatan'])?></td>
                        <td align="right">
                          <?php //echo $p['nomesin']==current($mesin)?number_format($p['jumlah']):''; ?>
                          <?php if($j%2==1){?>
                          <?php echo number_format($p['jumlah']); ?>
                          <?php } ?>
                        </td>
                        <td><?php //echo ?></td>
                      </tr>
                      <?php $j++;?> 
                    <?php }?>
                    <tr>
                      <td colspan="2"><b>Total</b></td>
                      <td align="right"><?php echo number_format($t)?></td>
                      <td align="right"><?php echo number_format($g015)?></td>
                      <td align="right"><?php echo number_format($g018)?></td>
                      <!-- <td align="center" colspan="<?php echo count($luar)?>">
                          <?php //echo number_format($g02)?> 
                      </td> -->
                      <?php foreach($luar as $b){?>
                      <td align="right">
                          <?php 
                            $hasil = json_encode($this->ReportModel->total02_arrayD(null,null,$p['tanggal1'],$p['tanggal2'],$b['idpemilik']));
                            // $data = json_decode($hasil);
                            echo number_format($hasil);
                            ?>
                          <?php 
                            // if (isset($data->data)) {
                            //   $nilaiData = $data->data;
                            //   echo number_format($nilaiData); // Ini akan mencetak "321753.61278533936"
                            //   // echo $nilaiData;
                            // } else {
                            //    // echo "Tidak ada data yang ditemukan.";
                            // }
                          //echo !empty($hasil) ? $hasil->data : 0;//echo json_encode($p['dets']) ?> 
                      </td>
                    <?php } ?>
                      <!-- <td></td> -->
                      <td align="right">
                        <?php 
                          foreach ($permesin as $key => $value) {
                            $decimal = $value - floor($value); // Mendapatkan nilai desimal
                            if ($decimal >= 0.5) {
                              echo '1..'.  $permesin[$key] = ceil($value);
                            } else {
                              echo '2..'.  $permesin[$key] = intval($value);
                            }
                          }
                          // json_encode($permesin);
                          echo number_format($gpendapatan)
                        ?>
                      </td>
                      <td align="right"><?php echo number_format($gpendapatan)?></td>
                      <td></td>
                    </tr>
                <?php }?>
              </tbody>
            </table>
<script type="text/javascript">
  function filter(){
    var url='?';
    var tanggal1=$("#tanggal1").val();
    var tanggal2=$("#tanggal2").val();
    var nomesin=$("#nomesin").val();

    if(tanggal1){
      url+='&tanggal1='+tanggal1;
    }

    if(tanggal2){
      url+='&tanggal2='+tanggal2;
    }

    if(nomesin!="*"){
      url+='&nomesin='+nomesin;
    }

    location=url;
  }

   function excel(){
    var url='?cetak=1';
    var tanggal1=$("#tanggal1").val();
    var tanggal2=$("#tanggal2").val();
    var nomesin=$("#nomesin").val();

    if(tanggal1){
      url+='&tanggal1='+tanggal1;
    }

    if(tanggal2){
      url+='&tanggal2='+tanggal2;
    }

    if(nomesin!="*"){
      url+='&nomesin='+nomesin;
    }

    location=url;
  }
</script>