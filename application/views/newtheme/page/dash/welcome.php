<style>
  .small-box-custom {
    background-color: #ffffff !important;
    border: 1px solid #cbd5e1 !important;
    border-top: 4px solid #3c8dbc !important;
    border-radius: 8px !important;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03) !important;
    color: #1e293b !important;
    overflow: hidden;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    margin-bottom: 20px;
  }
  .small-box-custom:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 15px -3px rgba(60, 141, 188, 0.15), 0 4px 6px -2px rgba(60, 141, 188, 0.05) !important;
  }
  .small-box-custom .inner {
    padding: 16px 16px 12px 16px !important;
  }
  .small-box-custom .inner h3 {
    color: #0f172a !important;
    font-size: 26px !important;
    font-weight: 700 !important;
    margin: 0 0 4px 0 !important;
    white-space: nowrap;
  }
  .small-box-custom .inner p {
    color: #475569 !important;
    font-size: 13px !important;
    font-weight: 500 !important;
    margin: 0 !important;
  }
  .small-box-custom .icon {
    color: rgba(60, 141, 188, 0.18) !important;
    top: 5px !important;
    right: 15px !important;
    font-size: 60px !important;
    transition: all 0.2s ease-in-out;
  }
  .small-box-custom:hover .icon {
    font-size: 65px !important;
    color: rgba(60, 141, 188, 0.35) !important;
  }
  .small-box-custom .small-box-footer {
    background-color: #f8fafc !important;
    color: #3c8dbc !important;
    border-top: 1px solid #e2e8f0 !important;
    font-weight: 600 !important;
    padding: 8px 0 !important;
    display: block;
    text-align: center;
    text-decoration: none !important;
    transition: background-color 0.2s ease, color 0.2s ease;
  }
  .small-box-custom .small-box-footer:hover {
    background-color: #3c8dbc !important;
    color: #ffffff !important;
  }
</style>

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
        <div class="col-md-3">
            <div class="small-box small-box-custom">
                <div class="inner">
                <h3><?php echo $countpendingpo ?> PO</h3>
                <p >Belum dikirim ke gudang,Produksi > 1 bulan</p>
                </div>
                <div class="icon">
                <i class="fa fa-clock-o"></i>
                </div>
                <a href="#" class="small-box-footer lihat-detail" data-id="<?php echo $countpendingpo ?>">
                    Lihat Klik Disini&nbsp;<i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box small-box-custom">
                <div class="inner">
                <h3><?php echo $countpacking ?> PO</h3>
                <p >Selesai Packing</p>
                </div>
                <div class="icon">
                <i class="fa fa-cubes"></i>
                </div>
                <a href="#" class="small-box-footer lihat-detail" data-id="packing">
                    Lihat Klik Disini&nbsp;<i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box small-box-custom">
                <div class="inner">
                <h3><?php echo $countpenerimaancmtmingguini ?> PO</h3>
                <p >Setoran CMT minggu ini</p>
                </div>
                <div class="icon">
                <i class="fa fa-truck"></i>
                </div>
                <a href="#" class="small-box-footer lihat-detail" data-id="setorcmt">
                    Lihat Klik Disini&nbsp;<i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <?php if($user['id_user'] == 11 || $user['id_user'] == 7 || $user['id_user'] == 35 ){ ?>
        <div class="col-md-3">
            <div class="small-box small-box-custom">
                <div class="inner">
                <h3><?php echo $ajuanharian ?></h3>
                <p >Pengajuan Harian Belum Disetujui</p>
                </div>
                <div class="icon">
                <i class="fa fa-hourglass-half"></i>
                </div>
                <a href="#" class="small-box-footer lihat-detail" data-id="ajuanharian">
                    Lihat Klik Disini&nbsp;<i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <?php } ?>
        <div class="col-md-3">
            <div class="small-box small-box-custom">
                <div class="inner">
                <h3><?php echo $formalat_menunggu; ?></h3>
                <p >Form Alat Menunggu Validasi</p>
                </div>
                <div class="icon">
                <i class="fa fa-wrench"></i>
                </div>
                <a href="<?php echo BASEURL.'Formpengambilanalat/konveksi?status=2' ?>" class="small-box-footer">
                    Lihat Klik Disini&nbsp;<i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box small-box-custom">
                <div class="inner">
                <h3><?php echo $ajuan_mingguan['kemeja']; ?></h3>
                <p >Ajuan Kirim Kemeja (Belum ACC)</p>
                </div>
                <div class="icon">
                <i class="fa fa-file-text"></i>
                </div>
                <a href="<?php echo BASEURL.'Gudang/ajuanmingguan_kemeja?spv=true' ?>" class="small-box-footer">
                    Lihat Klik Disini&nbsp;<i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box small-box-custom">
                <div class="inner">
                <h3><?php echo $ajuan_mingguan['kaos']; ?></h3>
                <p >Ajuan Kirim Kaos (Belum ACC)</p>
                </div>
                <div class="icon">
                <i class="fa fa-file-text"></i>
                </div>
                <a href="<?php echo BASEURL.'Gudang/ajuanmingguan?spv=true' ?>" class="small-box-footer">
                    Lihat Klik Disini&nbsp;<i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box small-box-custom">
                <div class="inner">
                <h3><?php echo $ajuan_mingguan['seragam']; ?></h3>
                <p >Ajuan PO Seragam (Belum ACC)</p>
                </div>
                <div class="icon">
                <i class="fa fa-file-text"></i>
                </div>
                <a href="<?php echo BASEURL.'Gudang/ajuanmingguanseragam' ?>" class="small-box-footer">
                    Lihat Klik Disini&nbsp;<i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box small-box-custom">
                <div class="inner">
                <h3><?php echo $ajuan_mingguan['celana']; ?></h3>
                <p >Ajuan Kirim Celana (Belum ACC)</p>
                </div>
                <div class="icon">
                <i class="fa fa-file-text"></i>
                </div>
                <a href="<?php echo BASEURL.'Gudang/ajuanmingguancelana' ?>" class="small-box-footer">
                    Lihat Klik Disini&nbsp;<i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
</div>
<hr>
<div class="row">

    <!-- Buang Benang -->
    <div class="col-md-3">
        <div class="small-box small-box-custom">
            <div class="inner">
                <h3><?php echo $buangBenang ?> PO</h3>
                <p>Buang Benang</p>
            </div>
            <div class="icon">
                <i class="fa fa-scissors"></i>
            </div>
            <a href="#" class="small-box-footer lihat-detail" data-id="buangbenang">
                Lihat Klik Disini &nbsp;<i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <!-- Cucian -->
    <div class="col-md-3">
        <div class="small-box small-box-custom">
            <div class="inner">
                <h3><?php echo $Cucian ?> PO</h3>
                <p>Cucian</p>
            </div>
            <div class="icon">
                <i class="fa fa-soap"></i>
            </div>
            <a href="#" class="small-box-footer lihat-detail" data-id="cucian">
                Lihat Klik Disini &nbsp;<i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <!-- Lubang Kancing -->
    <div class="col-md-2">
        <div class="small-box small-box-custom">
            <div class="inner">
                <h3><?php echo $lk ?> PO</h3>
                <p>Lubang Kancing</p>
            </div>
            <div class="icon">
                <i class="fa fa-grip-lines-vertical"></i>
            </div>
            <a href="#" class="small-box-footer lihat-detail" data-id="lubangkancing">
                Lihat Klik Disini &nbsp;<i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <!-- Pasang Kancing -->
    <div class="col-md-2">
        <div class="small-box small-box-custom">
            <div class="inner">
                <h3><?php echo $pk ?> PO</h3>
                <p>Pasang Kancing</p>
            </div>
            <div class="icon">
                <i class="fa fa-circle-dot"></i>
            </div>
            <a href="#" class="small-box-footer lihat-detail" data-id="pasangkancing">
                Lihat Klik Disini &nbsp;<i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <!-- Tress (Obras) -->
    <div class="col-md-2">
        <div class="small-box small-box-custom">
            <div class="inner">
                <h3><?php echo $tress ?> PO</h3>
                <p>Tress</p>
            </div>
            <div class="icon">
                <i class="fa fa-solid fa-yarn"></i>
            </div>
            <a href="#" class="small-box-footer lihat-detail" data-id="tress">
                Lihat Klik Disini &nbsp;<i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box small-box-custom">
            <div class="inner">
                <h3><?php echo $sablonKirim ?> PO</h3>
                <p>Pengiriman Sablon Minggu ini</p>
            </div>
            <div class="icon">
                <i class="fas fa-paper-plane"></i>
            </div>
            <a href="#" class="small-box-footer lihat-detail" data-id="sablonkirim">
                Detail <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

     <div class="col-lg-3 col-6">
        <div class="small-box small-box-custom">
            <div class="inner">
                <h3><?php echo $sablonSetor ?> PO</h3>
                <p>Setoran Sablon Minggu ini</p>
            </div>
            <div class="icon">
                <i class="fas fa-inbox"></i>
            </div>
            <a href="#" class="small-box-footer lihat-detail" data-id="sablonsetor">
                Detail <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box small-box-custom">
            <div class="inner">
                <h3><?php echo $countpoCmt ?> PO</h3>
                <p>PO Masih di CMT</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
            <a href="#" class="small-box-footer lihat-detail" data-id="pocmt">
                Detail <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

</div>

<hr>
<?php if(!empty($harian)){?>
    <?php if($user['id_user'] == 11 || $user['id_user'] == 7 || $user['id_user'] == 35 ){ ?>
    <div class="row">
    <div class="col-md-12">
        <div class="form-group">
        <div class="table-responsive">
            <label>Pengajuan Harian</label>
                <table class="table table-bordered">
                            <thead style="color:white; background-color:#337ab7">
                                <tr>

                                    <th>Ttd</th>
                                    <th>Hari, Tanggal</th>
                                    <th>Divisi / Cabang</th>
                                    <th><center>Cash (Rp)</center></th>
                                    <th><center>Transfer (Rp)</center></th>
                                    <th><center>Total (Rp)</center></th>
                                </tr>

                            </thead>

                            <tbody  style="color:black !important">

                                    <?php foreach ($harian as $key => $us): ?>

                                <tr>
                                <?php $hari= date('l',strtotime($us['tanggal']))?>
                                <td>
                                    <?php if($us['status']==0){?>
                                        <?php if($id_user==7 || $id_user==11){ ?>
                                            <a href="#" class="btn btn-primary btn-xs text-white ttdDigital" data-id="<?php echo $us['id']; ?>" data-toggle="modal" data-target="#detailModalTtd"><i class="fa fa-pencil"></i></a>
                                            <?php } ?>
                                        <?php }else{ ?>
                                        <span class="btn btn-xs btn-success"><i class="fa fa-check"></i></span>
                                        <?php } ?>
                                    </td>
                                    <td><?php echo hari($hari).', '. formatTanggalIndo($us['tanggal']) ?></td>

                                    <td>
                                    <?php 
                                    
                                    if ($us['kategori'] == 1) {
                                    echo "Sablon";
                                    }else if($us['kategori'] == 2) { 
                                        echo "Bordir"; 
                                    } else if($us['kategori'] == 3) {
                                        echo "Konveksi";
                                    }else if($us['kategori'] == 4) {
                                        echo "Sukabumi";
                                    }

                                    if(!empty($us['from_mingguan'])){
                                        echo ' Mingguan';
                                    }else{
                                        echo ' Harian';
                                    }
                                    ?>
                                    
                                </td>
                                <td align="right"><?php echo number_format($us['cash'])?></td>
                                <td align="right"><?php echo number_format($us['transfer'])?></td>
                                <td align="right"><?php echo number_format($us['cash']+$us['transfer'])?></td>
                                </tr>

                                    <?php endforeach ?>

                            </tbody>

                        </table>
                </div>
        </div>
    </div>
    </div>
<?php } ?>
<?php } ?>

<div class="row">
  <div class="col-md-6">
    <div id="container" style="width:100%; height:400px;"></div>
  </div>

<div class="col-md-6">
    <div id="grafik_alat" style="width:100%; height:400px;"></div>
  </div>


</div>
<div class="modal fade" id="detailModalTtd" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Persetujuan Digital</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="signatureModal">
            </div>
            <div class="modal-footer">
            
                <button id="clear_signature">Clear</button>
                <button id="save_signature">Save Signature</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document"><!-- pakai modal-xl biar luas -->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detail Data</h5>
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
    }else if(id=='ajuanharian'){
        $.ajax({
            url: "<?php echo BASEURL ?>Dash/ajuanharianjson",   
            type: "GET",
            dataType: "json",
            success: function(res) {
                if (res.length > 0) {
                    let html = `
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Total Ajuan Cash</th>
                                    <th>Total Ajuan Transfer</th>
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
                                <td>${row.cash}</td>
                                <td>${row.transfer}</td>
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
    }else if(id=='buangbenang'){
        $.ajax({
            url: "<?php echo BASEURL ?>Dash/buangbenang",   
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
                                <td>${row.kode_po}</td>
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
    }else if(id=='cucian'){
        $.ajax({
            url: "<?php echo BASEURL ?>Dash/cucian",   
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
                                <td>${row.kode_po}</td>
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
    }else if(id=='lubangkancing'){
        $.ajax({
            url: "<?php echo BASEURL ?>Dash/borongan/1",   
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
    }else if(id=='pasangkancing'){
        $.ajax({
            url: "<?php echo BASEURL ?>Dash/borongan/2",   
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
    }else if(id=='tress'){
        $.ajax({
            url: "<?php echo BASEURL ?>Dash/borongan/3",   
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
    }else if(id=='sablonkirim'){
        $.ajax({
            url: "<?php echo BASEURL ?>Dash/produksi/SABLON/KIRIM",   
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
                                <td>${row.kode_po}</td>
                                <td>${row.create_date}</td>
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
    }else if(id=='pocmt'){
        $.ajax({
            url: "<?php echo BASEURL ?>Dash/poCmtJson",   
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
                                    <th>Tanggal Kirim</th>
                                    <th>Proses</th>
                                    <th>Nama CMT</th>
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
                                <td>${row.proses}</td>
                                <td>${row.nama_cmt}</td>
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
    }else if(id=='sablonsetor'){
        $.ajax({
            url: "<?php echo BASEURL ?>Dash/produksi/SABLON/SETOR",   
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
                                <td>${row.kode_po}</td>
                                <td>${row.create_date}</td>
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

<style>
  canvas {
    margin: 10vh 5px !important;
    height: 250px !important;
  }

  #signature {
        width: 100%;
        height: 300px;
        border: 1px solid #000;
        background-color: #fff;
    }

    .modal-footer button {
        margin: 5px;
    }

    #clear_signature, #save_signature {
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 4px;
        cursor: pointer;
    }

    #clear_signature:hover, #save_signature:hover {
        background-color: #0056b3;
    }

    .modal-body {
        padding: 20px;
        overflow: hidden;
    }

    #signature {
        max-width: 100%;
        max-height: 100%;
    }

</style>
<script src="<?php echo BASEURL?>jSignature/src/jSignature.js"></script>
<script>
  $(document).ready(function() {

    // jSignature diinisialisasi di AJAX success callback dengan setTimeout

    // $("#signature-pad").jSignature();

      $('#clear_signature').click(function() {
           $("#signature-pad").jSignature("reset");
       });
       $('#save_signature').click(function() {
           var $sigdiv = window.currentSigPad || $("#detailModalTtd #signature-pad");
           if ($sigdiv.length == 0 || !$sigdiv.jSignature) {
               $sigdiv = $(".jSignature").last();
           }
           var data = $sigdiv.jSignature("getData", "image");
           var imgData = Array.isArray(data) ? data.join(",") : data;
           var idajuan = $("#idajuan").val();

           if (!imgData || imgData.length < 100) {
               var len = imgData ? imgData.length : 0;
               var info = (typeof $.fn.jSignature === 'undefined') ? ' (Lib Not Found)' : ' (Len: ' + len + ')';
               Swal({
                   type: 'warning',
                   title: 'Tanda tangan kosong',
                   text: 'Silakan tanda tangan terlebih dahulu pada panel yang disediakan.' + info
               });
               return false;
           }

           var $btn = $(this);
           var originalText = $btn.html();
           $btn.html('<i class="fa fa-spinner fa-spin"></i> Menyimpan...').attr('disabled', true);

           var formData = new FormData();
           formData.append('image_data', imgData);
           formData.append('id', idajuan);

           $.ajax({
               url: "<?= BASEURL ?>Gudang/ttdsave",
               type: "POST",
               data: formData,
               processData: false,
               contentType: false,
               success: function(response) {
                   if (response.indexOf('successfully') !== -1) {
                       Swal({
                           title: 'Berhasil',
                           text: response,
                           type: 'success',
                           showConfirmButton: false,
                           timer: 1500
                       });
                       // Gunakan setTimeout sebagai ganti Promise untuk kompatibilitas ke versi jadul
                       setTimeout(function() {
                           location.reload();
                       }, 1500);
                   } else {
                       $btn.html(originalText).attr('disabled', false);
                       Swal({
                           title: 'Gagal',
                           text: response,
                           type: 'error'
                        });
                   }
               },
               error: function(xhr) {
                   $btn.html(originalText).attr('disabled', false);
                   Swal({
                       title: 'Error',
                       text: 'Terjadi kesalahan: ' + xhr.statusText,
                       type: 'error'
                    });
               }
           });
        });
      
        $('.modals').on('click', function() {
          var id = $(this).data('id'); // Ambil ID dari atribut data-id
          $('#idajuan').val(id); // Masukkan ID ke input dalam modal

          // Anda bisa menambahkan logika AJAX di sini jika ingin mengambil data dari server
          // Contoh logika AJAX untuk mengambil data:
          $.ajax({
              url: '<?php echo BASEURL; ?>Gudang/getRealisasiDetail', // Sesuaikan URL untuk mengambil data
              method: 'GET',
              data: { id: id },
              success: function(response) {
                  // Asumsikan response berisi HTML atau data yang ingin Anda tampilkan di modal
                  $('#detailModal .modal-body').html(response);
              },
              error: function() {
                  $('#detailModal .modal-body').html('<p>Terjadi kesalahan, data tidak dapat ditampilkan.</p>');
              }
          });
        });

        $('.ttdDigital').on('click', function() {
          var id = $(this).data('id'); // Ambil ID dari atribut data-id
          $('#idajuan').val(id); // Masukkan ID ke input dalam modal

          // Anda bisa menambahkan logika AJAX di sini jika ingin mengambil data dari server
          // Contoh logika AJAX untuk mengambil data:
          $.ajax({
              url: '<?php echo BASEURL; ?>Gudang/getRealisasiDetailTtd', // Sesuaikan URL untuk mengambil data
              method: 'GET',
              data: { id: id },
              success: function(response) {
                  // Asumsikan response berisi HTML atau data yang ingin Anda tampilkan di modal
                  var $modal = $('#detailModalTtd');
                  $modal.find('#signatureModal').html(response);
                  
                  // Init jSignature setelah DOM di-render dan modal stabil
                  setTimeout(function(){
                      var $pad = $modal.find('#signature-pad');
                      if ($pad.length > 0) {
                          // Hancurkan instansi lama jika ada
                          try { $pad.jSignature('destroy'); } catch(e) {}
                          // Inisialisasi baru
                          $pad.jSignature(); window.currentSigPad = $pad;
                      }
                  }, 1000);
              },
              error: function() {
                  $('#detailModal .modal-body').html('<p>Terjadi kesalahan, data tidak dapat ditampilkan.</p>');
              }
          });
        });

        $('.nota').on('click', function() {
          var id = $(this).data('id'); // Ambil ID dari atribut data-id
          $('#idajuan').val(id); // Masukkan ID ke input dalam modal

          // Anda bisa menambahkan logika AJAX di sini jika ingin mengambil data dari server
          // Contoh logika AJAX untuk mengambil data:
          $.ajax({
              url: '<?php echo BASEURL; ?>Gudang/getiD', // Sesuaikan URL untuk mengambil data
              method: 'GET',
              data: { id: id },
              success: function(response) {
                  // Asumsikan response berisi HTML atau data yang ingin Anda tampilkan di modal
                  $('#idnota').val(response);
              },
              error: function() {
                  $('#detailModalNota .modal-body').html('<p>Terjadi kesalahan, data tidak dapat ditampilkan.</p>');
              }
          });
        });
});

</script>
<script type="text/javascript">
  
  function filter(){
    var url='?';
    var tanggal1=$("#tanggal1").val();
    var tanggal2=$("#tanggal2").val();
    var cat=$("#cat").val();

    if(tanggal1){
      url+='&tanggal1='+tanggal1;
    }

    if(tanggal2){
      url+='&tanggal2='+tanggal2;
    }

    if(cat!="*"){
        url+='&cat='+cat;
    }

    location=url;
  }

  function excel(){
    var url='?excel=1';
    var tanggal1=$("#tanggal1").val();
    var tanggal2=$("#tanggal2").val();
    var cat=$("#cat").val();
    if(tanggal1){
      url+='&tanggal1='+tanggal1;
    }

    if(tanggal2){
      url+='&tanggal2='+tanggal2;
    }

    if(cat!="*"){
        url+='&cat='+cat;
    }

    location=url;
  }
</script>    