<div class="row">
	<div class="col-md-12">
		<div id="container" style="width:100%; height:400px;"></div>
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

Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    title: {
       text: '<?php echo $title?>'
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
        labels: {
        formatter: function() {
          if (this.value >= 1E6) {
            return this.value + ' Jt';
          }
          return '' + this.value / 1000;
        }
      }	,
        title: {
            text: 'Rupiah (Rp)'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f} Rp</b></td></tr>',
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

      {
       name:'Pendapatan',
        data: [<?php echo implode(",", $jml) ?>]
     },
    ]
});

  

  $('#upload').modal({backdrop: 'static', keyboard: false}) ;
  $('#upload').modal('show');

</script>