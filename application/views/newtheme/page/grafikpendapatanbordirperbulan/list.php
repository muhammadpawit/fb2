<div class="row">
  <div class="col-md-12">
    <?php if ($this->session->flashdata('msg')) { ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
     	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
        	<span aria-hidden="true">×</span>
        </button>
		<?php echo $this->session->flashdata('msg'); ?> 
    </div>
    <?php } ?>
  </div>
</div>
<div class="row">
	<div class="col-md-4">
		<div class="form-group">
			<label>Tanggal Awal</label>
			<input type="text" name="tanggal1" id="tanggal1" value="<?php echo $tanggal1?>" class="form-control">
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label>Tanggal Akhir</label>
			<input type="text" name="tanggal2" id="tanggal2" value="<?php echo $tanggal2?>" class="form-control">
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label>Aksi</label><br>
			<button class="btn btn-info btn-sm" onclick="filtertglonly()">Filter</button>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div id="container" style="width:100%; height:400px;"></div>
	</div>
</div>
<script src="https://code.highcharts.com/highcharts.js"></script>
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