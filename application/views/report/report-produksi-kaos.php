<style type="text/css">
    table tr th,table tr td,table tr,table thead tr th,table thead tr {
        border: 1px solid black;
    }
</style>
<!-- DataTables -->


<!-- Start Page content -->
<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card-box table-responsive">
                    <h4 class="m-t-0 header-title">REPORT PRODUKSI KAOS</h4>
                   <p class="text-muted font-14 m-b-30">
                    <?php if ($this->session->flashdata('msg')) { ?>
                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                           <?php echo $this->session->flashdata('msg'); ?> 
                    </div>
                       <?php } ?>
                    </p>
                    <form action="<?php echo BASEURL.'report/reportproduksikaos' ?>" method="GET">
                        <div class="row mb-4">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Tanggal Mulai</label>
                                    <input type="date" class="form-control" name="tanggalMulai">
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Akhir</label>
                                    <input type="date" class="form-control" name="tanggalAkhir">
                                </div>
                            </div>
                            <div class="col-4">
                            <button class="btn btn-info mt-4">SUBMIT</button>
                            </div>
                        </div>
                    </form>
                    <table id="" class="table ">
                        <thead>
                        <tr>
                            <th rowspan="2">MODEL KAOS</th>
                            <th colspan="7">UKURAN</th>
                            <th rowspan="2">TOTAL</th>
                        </tr>
                        <tr>
                            <th>0</th>
                            <th>1/3</th>
                            <th>4/6</th>
                            <th>7/9</th>
                            <th>10/12</th>
                            <th>13/15</th>
                            <th>16/18</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($jenisKaos as $key => $jenis): ?>
                            <?php $atasanCount=0;$atasanCount2=0; ?>
                            <?php $nol=0;$satutiga=0;$empatenam=0;$tujuhsembilan=0;$sepuluhduabelas=0;$tigabelaslimabelas=0;$enambelasdelapanbelas=0;$totalPiecePo=0; ?>
                            <tr>
                                <td>
                                    <?php echo $jenis['nama_jenis_kaos']; ?>
                                </td>
                                    <?php foreach ($produk as $key => $prod): ?>
                                        <?php if ($prod['jenis_po'] == $jenis['nama_jenis_kaos']): ?>
                                            <?php if ($prod['rincian_size'] == "0"): ?>
                                                <?php 
                                                $nol += ($prod['rincian_lusin'] * 12) + $prod['rincian_piece']; 
                                                ?>
                                                <?php $totalPiecePo += ($prod['rincian_lusin'] * 12) + $prod['rincian_piece']; ?>
                                            <?php endif ?>
                                        <?php endif ?>
                                    <?php endforeach ?>
                                <td>
                                    <?php echo $nol; ?>
                                </td>
                                <?php foreach ($produk as $key => $prod): ?>
                                        <?php if ($prod['jenis_po'] == $jenis['nama_jenis_kaos']): ?>
                                            <?php if ($prod['rincian_size'] == "1/3"): ?>
                                                <?php @$satutiga += ($prod['rincian_lusin'] * 12) + $prod['rincian_piece']; ?>
                                                <?php $totalPiecePo += ($prod['rincian_lusin'] * 12) + $prod['rincian_piece']; ?>
                                            <?php endif ?>
                                        <?php endif ?>
                                    <?php endforeach ?>
                                <td>
                                    <?php echo $satutiga; ?>
                                </td>
                                 <?php foreach ($produk as $key => $prod): ?>
                                        <?php if ($prod['jenis_po'] == $jenis['nama_jenis_kaos']): ?>
                                            <?php if ($prod['rincian_size'] == "4/6"): ?>
                                                <?php @$empatenam += ($prod['rincian_lusin'] * 12) + $prod['rincian_piece']; ?>
                                                <?php $totalPiecePo += ($prod['rincian_lusin'] * 12) + $prod['rincian_piece']; ?>
                                            <?php endif ?>
                                        <?php endif ?>
                                    <?php endforeach ?>
                                <td>
                                    <?php echo $empatenam; ?>
                                </td>
                                <?php foreach ($produk as $key => $prod): ?>
                                        <?php if ($prod['jenis_po'] == $jenis['nama_jenis_kaos']): ?>
                                            <?php if ($prod['rincian_size'] == "7/9"): ?>
                                                <?php @$tujuhsembilan += ($prod['rincian_lusin'] * 12) + $prod['rincian_piece']; ?>
                                                <?php $totalPiecePo += ($prod['rincian_lusin'] * 12) + $prod['rincian_piece']; ?>
                                            <?php endif ?>
                                        <?php endif ?>
                                    <?php endforeach ?>
                                <td>
                                    <?php echo $tujuhsembilan; ?>
                                </td>

                                <?php foreach ($produk as $key => $prod): ?>
                                        <?php if ($prod['jenis_po'] == $jenis['nama_jenis_kaos']): ?>
                                            <?php if ($prod['rincian_size'] == "10/12"): ?>
                                                <?php @$sepuluhduabelas += ($prod['rincian_lusin'] * 12) + $prod['rincian_piece']; ?>
                                                <?php $totalPiecePo += ($prod['rincian_lusin'] * 12) + $prod['rincian_piece']; ?>
                                            <?php endif ?>
                                        <?php endif ?>
                                    <?php endforeach ?>
                                <td>
                                    <?php echo $sepuluhduabelas; ?>
                                </td>

                                <?php foreach ($produk as $key => $prod): ?>
                                        <?php if ($prod['jenis_po'] == $jenis['nama_jenis_kaos']): ?>
                                            <?php if ($prod['rincian_size'] == "13/15"): ?>
                                                <?php @$tigabelaslimabelas += ($prod['rincian_lusin'] * 12) + $prod['rincian_piece']; ?>
                                                <?php $totalPiecePo += ($prod['rincian_lusin'] * 12) + $prod['rincian_piece']; ?>
                                            <?php endif ?>
                                        <?php endif ?>
                                    <?php endforeach ?>
                                <td>
                                    <?php echo $tigabelaslimabelas; ?>
                                </td>
                                <?php foreach ($produk as $key => $prod): ?>
                                        <?php if ($prod['jenis_po'] == $jenis['nama_jenis_kaos']): ?>
                                            <?php if ($prod['rincian_size'] == "16/18"): ?>
                                                <?php @$enambelasdelapanbelas += ($prod['rincian_lusin'] * 12) + $prod['rincian_piece']; ?>
                                                <?php 
                                                $totalPiecePo += ($prod['rincian_lusin'] * 12) + $prod['rincian_piece']; 
                                                $atasanCount2 += ($prod['rincian_lusin'] * 12) + $prod['rincian_piece'];
                                                ?>
                                            <?php endif ?>
                                        <?php endif ?>
                                    <?php endforeach ?>
                                <td>
                                    <?php echo $enambelasdelapanbelas; ?>
                                </td>
                                <td><?php echo $totalPiecePo ?></td>
                            </tr>
                        <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div> <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card-box table-responsive">
                    <h4 class="m-t-0 header-title">REPORT PRODUKSI KAOS</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card-box">
                                <h4 class="header-title">Pie Chart</h4>
                                <div class="google-chart text-center">
                                    <div class="chart mt-4" id="pie-chart"></div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
 <!-- Google Charts js -->
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<!-- Init -->
<script type="text/javascript" src="assets/pages/jquery.google-charts.init.js"></script>

<script type="text/javascript">
! function($) {
    "use strict";
     var atasan = $('#DataTables').find('td:eq(8)').html();
        var setelanOb = $('#DataTables').find('td:eq(17)').html();
        var wangki = $('#DataTables').find('td:eq(26)').html();
        var setelan = $('#DataTables').find('td:eq(35)').html();
        var oblong = $('#DataTables').find('td:eq(44)').html();
        var hugo = $('#DataTables').find('td:eq(53)').html();
    var GoogleChart = function() {
        this.$body = $("body")
    };

    GoogleChart.prototype.createPieChart = function(selector, data, colors, is3D, issliced) {
        var options = {
            fontName: 'Roboto',
            fontSize: 13,
            height: 300,
            chartArea: {
                left: 50,
                width: '90%',
                height: '90%'
            },
            colors: colors
        };

        if(is3D) {
            options['is3D'] = true;
        }

        if(issliced) {
            options['is3D'] = true;
            options['pieSliceText'] = 'label';
            options['slices'] = {
                2: {offset: 0.15},
                5: {offset: 0.1}
            };
        }

        var google_chart_data = google.visualization.arrayToDataTable(data);
        var pie_chart = new google.visualization.PieChart(selector);
        pie_chart.draw(google_chart_data, options);
        return pie_chart;
    },

    
    GoogleChart.prototype.init = function () {
        var $this = this;

        //creating pie chart
        var pie_data = [
            ['JENIS', 'JUMLAH'],
            <?php foreach ($piece as $key => $pie): ?>
            ['<?php echo $key ?> - <?php echo number_format($pie) ?>',<?php echo $pie ?>],
            <?php endforeach ?>
        ];
        $this.createPieChart($('#pie-chart')[0], pie_data, ['#2d7bf4','#4eb7eb','#02c0ce', '#e3eaef', '#32c861'], false, false);


    },
    //init GoogleChart
    $.GoogleChart = new GoogleChart, $.GoogleChart.Constructor = GoogleChart
}(window.jQuery),

//initializing GoogleChart
function($) {
    "use strict";
    //loading visualization lib - don't forget to include this
    google.load("visualization", "1", {packages:["corechart"]});
    //after finished load, calling init method
    google.setOnLoadCallback(function() {$.GoogleChart.init();});
}(window.jQuery);

</script>