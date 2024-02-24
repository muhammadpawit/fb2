<?php //if(!empty($request) & callSessUser('id_user')=='10' OR callSessUser('id_user')=='11'){?>
<?php if(!empty($request)){?>
<div class="row">
    <div class="col-md-12">
       <div class="alert" style="background-color: #3D6AA2 !important;color: white">
           Form Request Otorisasi User
       </div>
        <table class="table table-bordered nosearch">
            <?php foreach($request as $req){?>
            <tr>
                <td><?php echo $req['no']?></td>    
                <td><?php echo $req['tanggal']?></td>    
                <td><?php echo $req['nama']?></td>
                <td><?php echo $req['keterangan']?></td>
                <td>
                    <?php if(callSessUser('id_user')=='10' OR callSessUser('id_user')=='11'){?>
                    <a href="<?php echo $req['setujui']?>" class="btn btn-success btn-xs text-white">Proses</a>
                    <?php }?>
                </td>    
            </tr>
            <?php } ?>
        </table>
    </div>
</div>
<?php } ?>
<?php if(callSessUser('id_user')=='10' OR callSessUser('id_user')=='11' OR callSessUser('id_user')=='17'){?>

<!-- Potongan -->
<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <div class="alert" style="background-color: #379294 !important;color: white">Update Potongan Mingguan<br><?php echo $tanggalm1?> - <?php echo $tanggalm2?></div>
          <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
                    <tr style="text-align: center;vertical-align: bottom;">
                        <th>No</th>
                        <th>Nama</th>
                        <th>Jml PO</th>
                        <th>Dz</th>
                        <th>Pcs</th>
                    </tr>
                </thead>
            <tbody>
                <?php $cpo=0;$dz=0;$pcs=0;$total=0;$pcs1=0;$pcs2=0; ?>
                <?php foreach($rekappotm as $r){?>
                <tr>
                    <td><?php echo $r['no']?></td>
                    <td><?php echo $r['type']?></td>
                    <td><?php echo number_format($r['po'])?></td>
                    <td><?php echo number_format($r['dz'])?></td>
                    <td><?php echo number_format($r['pcs'])?></td>
                </tr>
                <?php
                    $cpo+=($r['po']);
                    $dz+=($r['dz']);
                    $pcs+=($r['pcs']);
                ?>
                <?php } ?>
                <tr style="background-color: yellow;">
                    <td colspan="2"><b>Total Potongan</b></td>
                    <td><b><?php echo number_format($cpo)?></b></td>
                    <td><b><?php echo number_format($dz)?></b></td>
                    <td><b><?php echo number_format($pcs)?></b></td>
                </tr>
            </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <div class="alert" style="background-color: #379294 !important;color: white">Rekap Potongan PO Keseluruhan 2023 - 2024 <br>Per <?php echo date('d F Y')?></div>
          <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
                    <tr style="text-align: center;vertical-align: bottom;">
                        <th>No</th>
                        <th>Nama</th>
                        <th>Jml PO</th>
                        <th>Dz</th>
                        <th>Pcs</th>
                    </tr>
                </thead>
            <tbody>
                <?php $cpo=0;$dz=0;$pcs=0;$total=0;$pcs1=0;$pcs2=0; ?>
                <?php foreach($rekappot as $r){?>
                <tr>
                    <td><?php echo $r['no']?></td>
                    <td>
                        <div class="menu-container">
                            <a href="javascript:void(0)" class="menu-link"><?php echo $r['type']?></a>
                            <ul class="menu">
                                <li><a href="<?php echo BASEURL?>report/potongan">Harian</a></li>
                                <li><a href="#">Mingguan</a></li>
                                <li><a href="<?php echo BASEURL?>Grafikpotongan">Bulanan</a></li>
                            </ul>
                        </div>
                    </td>
                    <td><?php echo number_format($r['po'])?></td>
                    <td><?php echo number_format($r['dz'],2)?></td>
                    <td><?php echo number_format($r['pcs'])?></td>
                </tr>
                <?php
                    $cpo+=($r['po']);
                    $dz+=($r['dz']);
                    $pcs+=($r['pcs']);
                ?>
                <?php } ?>
                <tr style="background-color: yellow;">
                    <td colspan="2"><b>Total Potongan</b></td>
                    <td><b><?php echo number_format($cpo)?></b></td>
                    <td><b><?php echo number_format($dz,2)?></b></td>
                    <td><b><?php echo number_format($pcs)?></b></td>
                </tr>
                <tr>
                    <td colspan="5"><b>Note : PO Potong Kaos Pertama Tanggal (9 Juni 2023) </b></td>
                </tr>
            </tbody>
        </table>
        </div>
    </div>
  </div>
</div>

<!-- Kirim Gudang -->
<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <div class="alert" style="background-color: #3D6AA2 !important;color: white">Update PO Kirim Gudang Mingguan<br><?php echo $tanggalm1?> - <?php echo $tanggalm2?></div>
          <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
                    <tr style="text-align: center;vertical-align: bottom;">
                        <th>No</th>
                        <th>Nama</th>
                        <th>Jml PO</th>
                        <th>Dz</th>
                        <th>Pcs</th>
                        <th>Jumlah Nilai (Rp)</th>
                    </tr>
                </thead>
            <tbody>
                <?php $cpo=0;$dz=0;$pcs=0;$total=0;$pcs1=0;$pcs2=0; ?>
                <?php foreach($rekapkgmingguan as $r){?>
                <tr>
                    <td><?php echo $r['no']?></td>
                    <td><?php echo $r['type']?></td>
                    <td><?php echo number_format($r['po'])?></td>
                    <td><?php echo number_format($r['dz'],2)?></td>
                    <td><?php echo number_format($r['pcs'])?></td>
                    <td><?php echo number_format($r['total'])?></td>
                </tr>
                <?php
                    $cpo+=($r['po']);
                    $dz+=($r['dz']);
                    $pcs+=($r['pcs']);
                    $total+=($r['total']);
                ?>
                <?php } ?>
                <tr style="background-color: yellow;">
                    <td colspan="2"><b>Nilai Total (Rp)</b></td>
                    <td><b><?php echo number_format($cpo)?></b></td>
                    <td><b><?php echo number_format($dz,2)?></b></td>
                    <td><b><?php echo number_format($pcs)?></b></td>
                    <td><b><?php echo number_format($total)?></b></td>
                </tr>
            </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <div class="alert" style="background-color: #3D6AA2 !important;color: white">Rekap PO Kirim Gudang Keseluruhan 2023-2024<br>Per <?php echo date('d F Y')?></div>
          <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
                    <tr style="text-align: center;vertical-align: bottom;">
                        <th>No</th>
                        <th>Nama</th>
                        <th>Jml PO</th>
                        <th>Dz</th>
                        <th>Pcs</th>
                        <th>Jumlah Nilai (Rp)</th>
                    </tr>
                </thead>
            <tbody>
                <?php $cpo=0;$dz=0;$pcs=0;$total=0;$pcs1=0;$pcs2=0; ?>
                <?php foreach($rekapkg as $r){?>
                <tr>
                    <td><?php echo $r['no']?></td>
                    <td>
                        <div class="menu-container">
                            <a href="javascript:void(0)" class="menu-link"><?php echo $r['type']?></a>
                            <ul class="menu">
                                <li><a href="<?php echo BASEURL?>Rinciankirimgudang#finishing">Harian</a></li>
                                <li><a href="<?php echo BASEURL?>laporankirimgudangharian">Mingguan</a></li>
                                <li><a href="<?php echo BASEURL?>laporankirimgudangbulanan">Bulanan</a></li>
                            </ul>
                        </div>
                        <?php //echo $r['type']?>
                    </td>
                    <td><?php echo number_format($r['po'])?></td>
                    <td><?php echo number_format($r['dz'],2)?></td>
                    <td><?php echo number_format($r['pcs'])?></td>
                    <td><?php echo number_format($r['total'])?></td>
                </tr>
                <?php
                    $cpo+=($r['po']);
                    $dz+=($r['dz']);
                    $pcs+=($r['pcs']);
                    $total+=($r['total']);
                ?>
                <?php } ?>
                <tr style="background-color: yellow;">
                    <td colspan="2"><b>Nilai Total (Rp)</b></td>
                    <td><b><?php echo number_format($cpo)?></b></td>
                    <td><b><?php echo number_format($dz,2)?></b></td>
                    <td><b><?php echo number_format($pcs)?></b></td>
                    <td><b><?php echo number_format($total)?></b></td>
                </tr>
                <tr>
                    <td colspan="6"><b>Note : PO Kirim Gudang Pertama (26 Juni - 1 Juli 2023) </b></td>
                    
                </tr>
            </tbody>
        </table>
        </div>
    </div>
  </div>
</div>


<?php } ?>
<hr>
<div class="row">
  <div class="col-md-6">
    <caption><b>Potongan Produksi Global</b></caption>
    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th align="center">Jenis</th>
          <th>Jumlah PO
          <th>Dz</th>
        </tr>
      </thead>
      <tbody>
        <?php $tpa=0;$tpt=0;?>
        <?php foreach($pdzes as $pd){?>
          <tr>
            <td> <span style="display:inline-block;height: 10px;width: 10px;background-color: <?php echo $pd['color']?>"></span> <?php echo $pd['namapo']?></td>
            <td><?php echo $pd['jmlpo']?></td>
            <td><?php echo number_format($pd['dz'],2)?></td>
          </tr>
          <?php $tpa+=($pd['dz']);?>
          <?php $tpt+=($pd['jmlpo']);?>
        <?php } ?>
        <tr style="background-color: yellow;font-weight:700">
          <td align="center"><b>Total</b></td>
          <td><?php echo number_format($tpt,2)?></td>
          <td><?php echo number_format($tpa,2)?></td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <!-- <td><i>*Data inputan trakhir <b><?php echo date('d F Y',strtotime($updated)) ?></b></i></td> -->
        </tr>
      </tfoot>
    </table>
  </div>
  <div class="col-md-6">
    <div id="potongan" style="width:100%; height:400px;"></div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div id="container" style="width:100%; height:400px;"></div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div id="kirimgudang" style="width:100%; height:400px;"></div>
  </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <h6>User login :</h6>
            <?php $ln=1?>
                <marquee>
                <?php foreach($log as $l){?>
                <?php echo $ln++?>.<?php echo $l['nama']?>&nbsp;&nbsp;&nbsp;
                <?php } ?>
                </marquee>
        </div>
    </div>
</div>
<script src="https://code.highcharts.com/highcharts.js"></script>

<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script type="text/javascript">
   $(document).ready(function() {
        $('#tableseacrhfalse').dataTable( {
          "lengthChange": false,
          "searching":false,
        });      
    });
var colors = ['#32a852', '#3269a8', '#cfc930'];
Highcharts.chart('potongan', {
  
    chart: {
        type: 'column'
    },
    title: {
        text: 'Grafik Potongan Per Bulan'
    },
    subtitle: {
        text: '<a href="<?php echo base_url()?>Monitoring">klik disini untuk melihat per-minggu</a>'
    },
    xAxis: {
        categories: <?php echo $bulan?>,
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Potongan (dz)'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f} dz</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    colors:colors,
    series: [

    <?php foreach($pdze as $p){?>
      {
       name:'<?php echo $p['namapo']?>',
         data: [<?php echo implode(",", $p['lusin']) ?>]
     },
     <?php } ?>
    ]
});

Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Grafik Potongan Detail Perbulan'
    },
    subtitle: {
        text: 'www.forboysproduction.com'
    },
    xAxis: {
        categories: <?php echo $bulan?>,
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Potongan (dz)'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f} dz</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [

    <?php foreach($po as $p){?>
      {
       name:'<?php echo $p['namapo']?>',
        data: [<?php echo implode(",", $p['lusin']) ?>]
     },
     <?php } ?>
    ]
});

  Highcharts.chart('kirimgudang', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Grafik Kirim Gudang'
    },
    subtitle: {
        text: 'www.forboysproduction.com'
    },
    xAxis: {
        categories: <?php echo $bulan?>,
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Kirim (dz)'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f} dz</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [

    <?php foreach($getPOKirimGudang as $p){?>
      {
       name:'<?php echo $p['namapo']?>',
         data: [<?php echo implode(",", $p['lusin']) ?>]
     },
     <?php } ?>
    ]
  });

  $('#upload').modal({backdrop: 'static', keyboard: false}) ;
  $('#upload').modal('show');

</script>