
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
<div class="row">
    <div class="col-md-12">
       <div class="alert" style="background-color:#085B8C !important;color: white">
           PO yang belum dikirim ke gudang yang proses produksinya lebih dari 1 bulan
           <a href="<?php echo BASEURL?>Dash/pendingpo">Lihat</a>
       </div>
        
    </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div id="container" style="width:100%; height:400px;"></div>
  </div>
</div>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script>
    Highcharts.chart('container', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Grafik Produksi Potongan Perbulan'
        },
        subtitle: {
            text: 'www.forboysproduction.com'
        },
        xAxis: {
            categories: <?php echo $bulan?>,
            crosshair: true,
            labels: {
                style: {
                    fontSize: '12px', // ukuran teks di bawah chart
                    fontWeight: 'bold' // opsional
                }
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Potongan (dz)'
            }
        },
        tooltip: {
            headerFormat: '<span>{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f} dz</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0,
                dataLabels: {
                    enabled: true, // aktifkan label di atas batang
                    format: '{y:.1f} dz', // format label
                    style: {
                    fontSize: '11px',
                    fontWeight: 'bold'
                }
                }
            }
        },
        legend: {
            itemStyle: {
                fontSize: '11px',
                fontWeight: 'bold'
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
</script>