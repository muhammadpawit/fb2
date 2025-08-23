
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
    <!-- <div class="alert" style="background-color:#085B8C !important;color: white">
           PO yang belum dikirim ke gudang yang proses produksinya lebih dari 1 bulan
           <a href="<?php //echo BASEURL?>Dash/pendingpo">Lihat</a>
       </div> -->
        <div class="col-md-3">
            <div class="small-box bg-aqua" style="background-color:#3c8dbc !important;color: white">
                <div class="inner">
                <h3><?php echo $countpendingpo ?> PO</h3>
                <p >Belum dikirim ke gudang,Produksi > 1 bulan</p>
                </div>
                <div class="icon">
                <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer lihat-detail" data-id="<?php echo $countpendingpo ?>">
                    Lihat Klik Disini&nbsp;<i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box" style="background-color:#f39c12 !important;color: white">
                <div class="inner">
                <h3><?php echo $countpacking ?> PO</h3>
                <p >Selesai Packing</p>
                </div>
                <div class="icon">
                <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer lihat-detail" data-id="packing">
                    Lihat Klik Disini&nbsp;<i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box" style="background-color:#00a65a !important;color: white">
                <div class="inner">
                <h3><?php echo $countpenerimaancmtmingguini ?> PO</h3>
                <p >Penerimaan setoran dari CMT minggu ini</p>
                </div>
                <div class="icon">
                <i class="ion ion-person-add"></i>
                </div>
                <a href="#" class="small-box-footer lihat-detail" data-id="setorcmt">
                    Lihat Klik Disini&nbsp;<i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    <!-- <div class="col-md-12">
       <div class="alert" style="background-color:#DCA100 !important;color: white">
           PO selesai packing
           <a href="<?php echo BASEURL?>Dash/pendingpo">Lihat</a>
       </div>
    </div> -->
</div>
<div class="row">
  
<div class="col-md-12">
    <div id="grafik_alat" style="width:100%; height:400px;"></div>
  </div>

<div class="col-md-12">
    <div id="container" style="width:100%; height:400px;"></div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document"><!-- pakai modal-xl biar luas -->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detail PO</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="detailContent">
        <!-- Isi tabel dari AJAX -->
      </div>
    </div>
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

    Highcharts.chart('grafik_alat', {
    chart: {
        type: 'bar'
    },
    title: {
        text: 'Grafik Jumlah Alat Keluar Periode <?php echo formatTanggalIndo($tanggal1) . " - " . formatTanggalIndo($tanggal2); ?>'
    },
    xAxis: {
        categories: <?php echo json_encode($alat); ?>,
        labels: {
            style: {
                fontSize: '12px'
            }
        },
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Jumlah Keluar '
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y}</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        bar: { // karena chart: 'bar'
            pointPadding: 0.2,
            borderWidth: 0,
            dataLabels: {
                enabled: true,
                // format: '{point.y}', // angka langsung
                formatter: function () {
                    let satuan = <?php echo json_encode($satuan_alat); ?>;
                    return this.y + ' ' + satuan[this.point.index];
                },
                style: {
                    fontSize: '11px',
                    fontWeight: 'bold'
                }
            }
        }
    },
    series: [{
        name: 'Jumlah',
        data: <?php echo json_encode($jumlah_alat, JSON_NUMERIC_CHECK); ?>
    }]
});


$(document).on("click", ".lihat-detail", function(e) {
    e.preventDefault();

    $("#detailContent").html("Loading...");
    $("#detailModal").modal("show");

    let id = $(this).attr("data-id");

    if(id=='packing'){
        $.ajax({
            url: "<?php echo BASEURL ?>Dash/packingjson",   
            type: "GET",
            dataType: "json",
            success: function(res) {
                if (res.length > 0) {
                    let html = `
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode PO</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                    `;
                    let no=1;
                    res.forEach(row => {
                        html += `
                            <tr>
                                <td>${no}</td>
                                <td>${row.nama_po}</td>
                                <td>${row.creted_date}</td>
                            </tr>
                        `;
                        no++;
                    });

                    html += `</tbody></table>`;
                    $("#detailContent").html(html);
                } else {
                    $("#detailContent").html("<em>Tidak ada data</em>");
                }
            },
            error: function(xhr) {
                $("#detailContent").html("<span class='text-danger'>Gagal memuat data.</span>");
            }
        });
    }else if(id=='setorcmt'){
        $.ajax({
            url: "<?php echo BASEURL ?>Dash/setorjson",   
            type: "GET",
            dataType: "json",
            success: function(res) {
                if (res.length > 0) {
                    let html = `
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode PO</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                    `;
                    let no=1;
                    res.forEach(row => {
                        html += `
                            <tr>
                                <td>${no}</td>
                                <td>${row.nama_po}</td>
                                <td>${row.tanggal}</td>
                            </tr>
                        `;
                        no++;
                    });

                    html += `</tbody></table>`;
                    $("#detailContent").html(html);
                } else {
                    $("#detailContent").html("<em>Tidak ada data</em>");
                }
            },
            error: function(xhr) {
                $("#detailContent").html("<span class='text-danger'>Gagal memuat data.</span>");
            }
        });
    }else{
        $.ajax({
            url: "<?php echo BASEURL ?>Dash/pendingpojson",   
            type: "GET",
            dataType: "json",
            success: function(res) {
                if (res.length > 0) {
                    let html = `
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode PO</th>
                                    <th>Tanggal</th>
                                    <th>Posisi</th>
                                </tr>
                            </thead>
                            <tbody>
                    `;
                    let no=1;
                    res.forEach(row => {
                        html += `
                            <tr>
                                <td>${no}</td>
                                <td>${row.kode_po}</td>
                                <td>${row.created_date}</td>
                                <td>${row.posisi}</td>
                            </tr>
                        `;
                        no++;
                    });

                    html += `</tbody></table>`;
                    $("#detailContent").html(html);
                } else {
                    $("#detailContent").html("<em>Tidak ada data</em>");
                }
            },
            error: function(xhr) {
                $("#detailContent").html("<span class='text-danger'>Gagal memuat data.</span>");
            }
        });
    }

});

</script>