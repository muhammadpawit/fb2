<div class="row">
	<div class="col-md-12">
		<table class="table table-bordered table-hover">
			<thead align="center" valign="top">
				<tr>
				    <th class="tg-0pky" rowspan="3">Bulan</th>
				    <th class="tg-0pky" colspan="6">Potongan</th>
				    <th class="tg-0pky" colspan="2" rowspan="2">Total</th>
				    <th class="tg-0lax" rowspan="3">Keterangan</th>
				  </tr>
				  <tr>
				    <th class="tg-0pky" colspan="2">Kaos</th>
				    <th class="tg-0pky" colspan="2">Kemeja</th>
				    <th class="tg-0pky" colspan="2">Celana</th>
				  </tr>
				  <tr>
				    <th class="tg-0pky">JML</th>
				    <th class="tg-0pky">DZ</th>
				    <th class="tg-0pky">JML</th>
				    <th class="tg-0pky">DZ</th>
				    <th class="tg-0pky">JML</th>
				    <th class="tg-0pky">DZ</th>
				    <th class="tg-0pky">JML</th>
				    <th class="tg-0lax">DZ</th>
				  </tr>
			</thead>
			<tbody>
				<?php
					$jmlkemeja=0;
					$jmlkaos=0;
					$jmlcelana=0;
					$jmltotal=0;
					$kemeja=0;
					$kaos=0;
					$celana=0;
					$total=0;
				?>
				<?php foreach($prods as $p){?>
					<tr>
						<td><?php echo $p['bulan']?></td>
						<td align="right"><?php echo number_format($p['jmlkaos'])?></td>
						<td align="right"><?php echo number_format($p['kaos'],2)?></td>
						<td align="right"><?php echo number_format($p['jmlkemeja'])?></td>
						<td align="right"><?php echo number_format($p['kemeja'],2)?></td>
						<td align="right"><?php echo number_format($p['jmlcelana'])?></td>
						<td align="right"><?php echo number_format($p['celana'],2)?></td>
						<td align="right"><?php echo number_format(($p['jmlkemeja']+$p['jmlkaos']+$p['jmlcelana']))?></td>
						<td align="right"><?php echo number_format(($p['kemeja']+$p['kaos']+$p['celana']),2)?></td>
						<td><?php echo $p['keterangan']?></td>
					</tr>
				<?php
					$jmlkemeja+=($p['jmlkemeja']);
					$jmlkaos+=($p['jmlkaos']);
					$jmlcelana+=($p['jmlcelana']);
					$jmltotal+=($p['jmlkemeja']+$p['jmlkaos']+$p['jmlcelana']);

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
					<td align="right"><b><?php echo number_format($jmlkaos)?></b></td>
					<td align="right"><b><?php echo number_format($kaos,2)?></b></td>
					<td align="right"><b><?php echo number_format($jmlkemeja)?></b></td>
					<td align="right"><b><?php echo number_format($kemeja,2)?></b></td>
					<td align="right"><b><?php echo number_format($jmlcelana)?></b></td>
					<td align="right"><b><?php echo number_format($celana,2)?></b></td>
					<td align="right"><b><?php echo number_format($jmltotal)?></b></td>
					<td align="right"><b><?php echo number_format($total,2)?></b></td>
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
        text: 'Grafik Potongan'
    },
    subtitle: {
        text: 'Jumlah Potongan (Dz)'
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
            '<td style="padding:0"><b>{point.y:.1f} Dz</b></td></tr>',
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