<!-- <div class="row">
  <div class="col-md-3">
    <div class="small-box bg-info">
      <div class="inner">
      <h3><?php echo number_format($gpendapatan)?></h3>
      <p>Tanggal <?php echo date('d F',strtotime($tanggal1)) ?> - <?php echo date('d F Y',strtotime($tanggal2)) ?></p>
      </div>
      <div class="icon">
      <i class="ion ion-bag"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
</div> -->
<center>
  <h3 style="text-decoration: underline;"><?php echo $judullap ?></h3>
</center>
<?php echo $periode ?>
<table border="1" style="border-collapse: collapse;" cellpadding="10">
              <thead>
                <tr style="background-color:yellow" align="center">
                  <!-- <th>Tanggal</th> -->
                  <th>No.Mesin</th>
                  <th>Shift</th>
                  <th>Stich</th>
                  <th>0.15</th>
                  <th>0.18</th>
                  <th>0.2</th>
                  <!-- <th>0.18 YN</th> -->
                  <th>Jml Per Mesin (Rp)</th>
                  <th>Pendapatan Per Mesin (Rp)</th>
                  <th>Keterangan</th>
                </tr>
              </thead>
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
                    <tr align="center">
                      <!-- <td><?php echo $p['tanggal']?></td> -->
                      <td>Mesin <?php echo $p['nomesin']?></td>
                      <td><?php echo $p['shift']?></td>
                      <td align="center"><?php echo number_format($p['stich'])?></td>
                      <td align="center"><?php echo number_format($p['0.15']); ?></td>
                      <td align="center"><?php echo number_format($p['0.18'])?></td>
                      <td align="center"><?php echo number_format($p['0.2']); ?></td>
                      <!-- <td>0</td> -->
                      <td align="center"><?php echo number_format($p['pendapatan'])?></td>
                      <td align="center">
                        <?php //echo $p['nomesin']==current($mesin)?number_format($p['jumlah']):''; ?>
                        <?php if($j%2==1){?>
                        <?php echo number_format($p['jumlah']); ?>.
                        <?php } ?>
                      </td>
                      <td><?php //echo ?></td>
                    </tr>
                    <?php $j++;?>
                  <?php }?>
                    <tr style="font-size: 16.5px;font-weight: bold;">
                      <td colspan="2" align="center"><b>Total</b></td>
                      <td align="center"><?php echo number_format($t)?></td>
                      <td align="center"><?php echo number_format($g015)?></td>
                      <td align="center"><?php echo number_format($g018)?></td>
                      <td align="center"><?php echo number_format($g02)?></td>
                      <!-- <td></td> -->
                      <td align="center"><?php echo number_format($gpendapatan)?></td>
                      <td align="center"><?php echo number_format($gpendapatan)?></td>
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