<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Kirim_Setor_CMT_".strtoupper($cmts['cmt_name']).".xls");
?>
<style type="text/css">
	h4 { text-transform: capitalize }
	table { border-collapse: collapse;width: 100% }
</style>
<h4>Kirim Setor CMT : <?php echo strtoupper($cmts['cmt_name'])?></h4>
<table border="2" cellpadding="10">
			<thead class="thead-light">
				<tr>
					<th rowspan="2" style="vertical-align: middle;text-align: center;">Bulan</th>
					<th colspan="3" style="vertical-align: middle;text-align: center;">Kirim CMT</th>
					<th colspan="3" style="vertical-align: middle;text-align: center;">Setor CMT</th>
					<th rowspan="2" style="vertical-align: middle;text-align: center;">Keterangan</th>
				</tr>
				<tr>
					<th style="vertical-align: middle;text-align: center;">JML PO</th>
					<th style="vertical-align: middle;text-align: center;">Dz</th>
					<th style="vertical-align: middle;text-align: center;">Pcs</th>
					<th style="vertical-align: middle;text-align: center;">JML PO</th>
					<th style="vertical-align: middle;text-align: center;">Dz</th>
					<th style="vertical-align: middle;text-align: center;">Pcs</th>
				</tr>
			</thead>
			<tbody>
				<?php if($products){?>
					<?php foreach($products as $p){?>
					<tr style="text-align: center;">
						<td><?php echo $p['bulan']?></td>
						<td><?php echo $p['kirimpo']?></td>
						<td><?php echo $p['kirimdz']?></td>
						<td><?php echo $p['kirimpcs']?></td>
						<td><?php echo $p['setorjmlpo']?></td>
						<td><?php echo $p['setordz']?></td>
						<td><?php echo $p['setorpcs']?></td>
						<td></td>
					</tr>
					<?php } ?>
				<?php }else{ ?>
					<tr>
						<td colspan="8">Silahkan pilih nama cmt</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
		<div class="row">
	<div class="col-md-12">
		<div id="grafikkirimsetor" style="width:100%; height:400px;"></div>
	</div>
</div>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script type="text/javascript">
	Highcharts.chart('grafikkirimsetor', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Grafik Kirim Setor'
    },
    subtitle: {
        text: 'www.forboysproduction.com'
    },
    xAxis: {
        categories:<?php echo $bulans?>,
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

    {
       name:'Kirim',
       data: [<?php echo $kp?>]
    },
    {
       name:'Setor',
       data: [<?php echo $sp?>]
    },
         ]
  });
	
</script>