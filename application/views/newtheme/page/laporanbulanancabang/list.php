<div class="row no-print">
	<div class="col-md-3">
		<label>Tanggal Awal</label>
		<input type="text" name="tanggal1" class="form-control" id="tanggal1" autocomplete="off" value="<?php echo $tanggal1?>" >
	</div>
	<div class="col-md-3">
		<label>Tanggal Akhir</label>
		<input type="text" name="tanggal2" class="form-control" id="tanggal2" autocomplete="off" value="<?php echo $tanggal2?>" >
	</div>
	<div class="col-md-3">
		<label>Aksi</label><br>
		<button class="btn btn-sm btn-info" onclick="filtertglonly_all()">Filter</button>
		<a class="btn btn-info btn-sm text-white" href="<?php echo $excel?>">excel</a>
		<button class="btn btn-info btn-sm cetak">Print</button>
	</div>
</div>
<br>
<div class="row">
	<div class="col-md-12">
		<h4></h4>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="table-responsive">
		<table class="" border="1" style="border-collapse: collapse;width:100%">
			<thead class="thead-light">
				<tr>
					<th rowspan="2" style="vertical-align: middle;text-align: center;">Nama CMT</th>
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
				<?php $cmt=[];$totalsetor=0;$totalkirimdz=0;$totalkirimpcs=0;$totalsetordz=0;$totalsetorpcs=0;$jmlkirim=0;$jmlsetor=0;?>
				<?php if($products){?>
					<?php foreach($products as $p){?>
					<tr>
						<td align="left"><?php echo $p['bulan']?></td>
						<td align="center"><?php echo number_format($p['kirimpo'])?></td>
						<td align="center"><?php echo number_format($p['kirimdz'],2)?></td>
						<td align="center"><?php echo number_format($p['kirimpcs'])?></td>
						<td align="center"><?php echo number_format($p['setorjmlpo'])?></td>
						<td align="center"><?php echo number_format($p['setordz'],2)?></td>
						<td align="center"><?php echo number_format($p['setorpcs'])?></td>
						<td></td>
					</tr>
						
						<?php $totalsetor+=$p['setorjmlpo'];?>
						<?php $totalkirimdz+=$p['kirimdz'];?>
						<?php $totalkirimpcs+=$p['kirimpcs'];?>
						<?php $totalsetordz+=$p['setordz'];?>
						<?php $totalsetorpcs+=$p['setorpcs'];?>
						<?php 

							
							$cmt[]=array(
								'cmt' => $p['bulan'],
								'jml' => $p['kirimpo'],
								'kirimdz'=>($p['kirimpcs']),
								'setordz'=>($p['setorpcs']),
							);

						?>
					<?php } ?>
					<tr>
						<td><b>Total</b></td>
						<td align="center"><b><?php echo $kirimpo?></b></td>
                        <td align="center"><b><?php echo number_format($totalkirimdz,2)?></b></td>
                        <td align="center"><b><?php echo number_format($totalkirimpcs,0)?></b></td>
                        <td align="center"><b><?php echo $totalsetor?></b></td>
                        <td align="center"><b><?php echo number_format($totalsetordz,2)?></b></td>
                        <td align="center"><b><?php echo number_format($totalsetorpcs,0)?></b></td>
						<td></td>
					</tr>
				<?php }else{ ?>
					<tr>
						<td colspan="8">Silahkan pilih nama cmt</td>
					</tr>
				<?php } ?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="6">
						<?php 
							$namacmt=null;
							$pokirim=[];
							$posetor=[];
							$pcskirim=[];
							$pcssetor=[];
							foreach($cmt as $t){
								$namacmt[]	=$t['cmt'];
								$pokirim[]	=($t['kirimdz']/12);
								$posetor[]	=($t['setordz']/12);
								$pcskirim[]	=($t['kirimdz']);
								$pcssetor[]	=($t['setordz']);

							}
							$enama = json_encode($namacmt);
							$pokirim = implode(",", $pokirim);
							$posetor = implode(",", $posetor);
							$pcskirim = implode(",", $pcskirim);
							$pcssetor = implode(",", $pcssetor);
						?>
					</td>
				</tr>
			</tfoot>
		</table>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div id="grafikkirimsetor" style="width:100%; height:400px;"></div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div id="grafikkirimsetor_pcs" style="width:100%; height:400px;"></div>
	</div>
</div>
<script src="https://code.highcharts.com/highcharts.js"></script>

<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script type="text/javascript">
	Highcharts.chart('grafikkirimsetor', {
		    chart: {
		        type: 'column'
		    },
		    colors: ['#043753','#047765'],
		    title: {
		        text: 'Grafik Kirim Setor (dz)'
		    },
		    subtitle: {
		        text: 'www.forboysproduction.com'
		    },
		    xAxis: {
		        categories:<?php echo $enama?>,
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
			       data: [<?php echo $pokirim?>]
			    },
			    {
			       name:'Setor',
			       data: [<?php echo $posetor?>]
			    },
	         ]
  	});

  	Highcharts.chart('grafikkirimsetor_pcs', {
		    chart: {
		        type: 'column'
		    },
		    colors: ['#065753','#049553'],
		    title: {
		        text: 'Grafik Kirim Setor (Pcs)'
		    },
		    subtitle: {
		        text: 'www.forboysproduction.com'
		    },
		    xAxis: {
		        categories:<?php echo $enama?>,
		        crosshair: true
		    },
		    yAxis: {
		        min: 0,
		        title: {
		            text: 'Kirim (pcs)'
		        }
		    },
		    tooltip: {
		        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
		        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
		            '<td style="padding:0"><b>{point.y:.1f} pcs</b></td></tr>',
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
			       data: [<?php echo $pcskirim?>]
			    },
			    {
			       name:'Setor',
			       data: [<?php echo $pcssetor?>]
			    },
	         ]
  	});

	function filter(){
		url='?';
		/*
		var bulan1 = $('select[name=\'bulan1\']').val();

		if (bulan1 != '*') {
			url += '&bulan1=' + encodeURIComponent(bulan1);
		}

		var bulan2 = $('select[name=\'bulan2\']').val();

		if (bulan2 != '*') {
			url += '&bulan2=' + encodeURIComponent(bulan2);
		}

		
	  	var tahun = $('select[name=\'tahun\']').val();

		if (tahun != '*') {
			url += '&tahun=' + encodeURIComponent(tahun);
		}

		*/

	  var cmt = $('select[name=\'cmt\']').val();

		if (cmt != '*') {
			url += '&cmt=' + encodeURIComponent(cmt);
		}
		location =url;
		
	}

	function excel(){
		url='?&excel=1';

	  var cmt = $('select[name=\'cmt\']').val();

		if (cmt != '*') {
			url += '&cmt=' + encodeURIComponent(cmt);
		}
		location =url;
		
	}

$(document).ready(function(){
  $(".cetak").click(function(){
    window.print();
  });
});

function filtertglonly_all(){
    var url='?&cmt=true';
    var tanggal1 =$("#tanggal1").val();
    var tanggal2 =$("#tanggal2").val();
    if(tanggal1){
      url+='&tanggal1='+tanggal1;
    }
    if(tanggal2){
      url+='&tanggal2='+tanggal2;
    }
    location =url;
  }

</script>