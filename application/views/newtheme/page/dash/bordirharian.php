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
<table class="table table-bordered">
              <thead>
                <tr style="background-color:yellow">
                  <!-- <th>Tanggal</th> -->
                  <th>No.Mesin</th>
                  <th>Shift</th>
                  <th>Stich</th>
                  <th>0.15</th>
                  <th>0.18</th>
                  <?php foreach($luar as $l){?>
                    <th><?php echo $l['perkalian']?></th>
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
                      <td>Mesin <?php echo $p['nomesin']?></td>
                      <td><?php echo $p['shift']?></td>
                      <td align="right"><?php echo number_format($p['stich'])?></td>
                      <td align="right"><?php echo number_format($p['0.15']); ?></td>
                      <td align="right"><?php echo number_format($p['0.18'])?></td>
                      <?php foreach($luar as $b){?>
                      <td align="right">
                        <?php //if($b['perkalian']==$p['dets'][$b['perkalian']]){?>
                          <?php echo number_format($p['dets'][$b['perkalian']]);//echo json_encode($p['dets']) ?> 
                        <?php //} ?>
                      </td>
                    <?php } ?>
                      <td align="right"><?php echo number_format($p['pendapatan'])?></td>
                      <td align="right">
                        <?php //echo $p['nomesin']==current($mesin)?number_format($p['jumlah']):''; ?>
                        <?php if($j%2==1){?>
                        <?php echo number_format($p['jumlah']); ?>.
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
                      <td align="center" colspan="<?php echo count($luar)?>">
                          <?php echo number_format($g02)?> 
                      </td>
                      <!-- <td></td> -->
                      <td align="right"><?php echo number_format($gpendapatan)?></td>
                      <td align="right"><?php echo number_format($gpendapatan)?></td>
                      <td></td>
                    </tr>
                <?php }?>
              </tbody>
            </table>
<div class="row">
  <div class="col-md-12 text-center">
    <h3>Laporan Pendapatan dan Pengeluaran Bordir Forboys</h3><br>
    <p>Update per-tanggal <?php echo date('d-F-Y',strtotime($tanggal1)); ?> s.d <?php echo date('d-F-Y',strtotime($tanggal2)); ?></p>
  </div>
</div>
<div class="row">
  <div class="col-md-8">
    <div class="form-group">
      <table class="table table-striped table-bordered">
        <thead>
          <tr>
            <th colspan="2">Pendapatan</th>
            <th>Rp</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td colspan="2">Pendapatan PO Dalam</td>
            <!-- <td>:</td> -->
            <td align="right"><?php echo number_format($totalpendapatan)?></td>
          </tr>
          <!-- <tr>
            <td>Pendapatan PO 0.15</td>
            <td>:</td>
            <td align="right"><?php echo $p15?></td>
          </tr> -->
          <tr>
            <td colspan="2">Pendapatan PO Luar / PO Homie</td>
            <!-- <td>:</td> -->
            <td align="right"><?php echo number_format($totalpoluar)?></td>
          </tr>
          <!--<tr>
            <td colspan="2">Pendapatan PO Yuna</td>
            <td align="right"></td>
          </tr>-->
        </tbody>
        <tfoot>
          <tr>
            <td colspan="2"><b>Total Pendapatan</b></td>
            <td align="right"><b><?php echo number_format($totalpen)?></b></td>
          </tr>
        </tfoot>
      </table>
    </div>

    <div class="form-group">
      <table class="table table-striped table-bordered">
        <thead>
          <tr>
            <th colspan="2">Pengeluaran</th>
            <th>Rp</th>
          </tr>
        </thead>
        <tbody>
          <?php $totalpengeluaran=0; ?>
          <?php foreach($pengeluarans as $pd){?>
              <tr>
                <td colspan="2" width="155"><?php echo $pd['keterangan']?></td>
                <!-- <td>:</td> -->
                <td align="right"><?php echo number_format($pd['total'])?></td>
              </tr>
              <?php $totalpengeluaran+=($pd['total']); ?>
          <?php } ?>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="2"><b>Total Pengeluaran</b></td>
            <td align="right"><b><?php echo number_format($totalpengeluaran)?></b></td>
          </tr>
          <tr>
            <td colspan="2"></td>
            <td></td>
          </tr>
          <tr>
            <td colspan="2"><b>Laba Produksi</b></td>
            <td align="right"><b><?php echo number_format($totalpen-$totalpengeluaran)?></b></td>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
</div>            
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