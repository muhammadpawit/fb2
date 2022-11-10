<div class="row">
	<div class="col-md-12">
		<table class="table table-bordered table-hover">
			<thead>
				<tr align="center" valign="top">
				    <th rowspan="2">Bulan</th>
				    <th colspan="4">Pendapatan</th>
				    <th rowspan="2">Keterangan</th>
				</tr>
				<tr align="center">
				    <th>Kemeja</th>
				    <th>Kaos</th>
				    <th>Celana</th>
				    <th>Total</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$kemeja=0;
					$kaos=0;
					$celana=0;
					$total=0;
				?>
				<?php foreach($prods as $p){?>
					<tr>
						<td><?php echo $p['bulan']?></td>
						<td align="right"><?php echo number_format($p['kemeja'])?></td>
						<td align="right"><?php echo number_format($p['kaos'])?></td>
						<td align="right"><?php echo number_format($p['celana'])?></td>
						<td align="right"><?php echo number_format(($p['kemeja']+$p['kaos']+$p['celana']))?></td>
						<td><?php echo $p['keterangan']?></td>
					</tr>
				<?php
					$kemeja+=($p['kemeja']);
					$kaos+=($p['kaos']);
					$celana+=($p['celana']);
					$total+=($p['kemeja']+$p['kaos']+$p['celana']);
				?>
				<?php } ?>
			</tbody>
			<tfoot>
				<tr>
					<td><b>Total</b></td>
					<td align="right"><b><?php echo number_format($kemeja)?></b></td>
					<td align="right"><b><?php echo number_format($kaos)?></b></td>
					<td align="right"><b><?php echo number_format($celana)?></b></td>
					<td align="right"><b><?php echo number_format($total)?></b></td>
					<td></td>
				</tr>
			</tfoot>
		</table>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div id="grafikpendapatan"></div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<button onclick="excelwithtgl()" class="btn btn-success">Excel</button>
	</div>
</div>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>  
<!-- optional -->  
<script src="https://code.highcharts.com/modules/offline-exporting.js"></script>  
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script type="text/javascript">
	var colors = ['#32a852', '#3269a8', '#cfc930'];
Highcharts.chart('grafikpendapatan', {
  
    chart: {
        type: 'column'
    },
    title: {
        text: 'Pendapatan Kirim Gudang'
    },
    subtitle: {
        text: ''
    },
    xAxis: {
        categories: <?php echo $bulan?>,
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: ''
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f} </b></td></tr>',
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
      	{
       		name:'Kemeja',
         	data: [<?php echo $kem?>]
     	},
     	{
       		name:'Kaos',
         	data: [<?php echo $kao?>]
     	},
     	{
       		name:'Celana',
         	data: [<?php echo $cel?>]
     	},
    ]
});
</script>