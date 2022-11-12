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
			<label>Tanggal</label>
			<input type="text" name="tanggal1" id="tanggal1" value="<?php echo $tanggal1?>" class="form-control">
		</div>
	</div>
	<!-- <div class="col-md-4">
		<div class="form-group">
			<label>Tanggal Akhir</label>
			<input type="text" name="tanggal2" id="tanggal2" value="<?php echo $tanggal2?>" class="form-control">
		</div>
	</div> -->
	<div class="col-md-4">
		<div class="form-group">
			<label>Aksi</label><br>
			<button class="btn btn-info btn-sm" onclick="filtertglonly()">Filter</button>
			<button class="btn btn-info btn-sm" onclick="excelwithtgl()">Excel</button>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<h1 class="text-center">Rincian Pengambilan Bahan Keluar <?php echo bulan()[date('n',strtotime($tanggal1))] .' '.date('Y',strtotime($tanggal1))?></h1>
	</div>
</div>
<div class="row">
	<div class="col-md-7">
		<div class="form-group">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>No</th>
						<th>Tanggal</th>
						<th>Nama</th>
						<th align="center">Jumlah (Roll)</th>
						<th align="center" colspan="2">Satuan</th>
						<!-- <th>Harga (Rp)</th>
						<th>Total (Rp)</th> -->
					</tr>
				</thead>
				<tbody>
					<?php foreach($prods as $p){?>
						<tr>
							<td><?php echo $p['no']?></td>
							<td><?php echo $p['tanggal']?></td>
							<td><?php echo $p['nama']?></td>
							<td><?php echo $p['roll']?></td>
							<td><?php echo $p['yardkg']?></td>
							<td><?php echo $p['satuan']?></td>
							<!-- <td><?php echo number_format($p['harga'])?></td>
							<td><?php echo number_format($p['total'])?></td> -->
						</tr>
					<?php } ?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="3" align="center"><b>Total</b></td>
						<td><b><?php echo number_format($roll)?></b></td>
						<td><b><?php echo number_format($yardkg)?></b></td>
						<!-- <td></td>
						<td><b><?php echo number_format($total)?></b></td> -->
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
	<div class="col-md-5">
		<div class="form-group">
			<h3 class="text-center">Rekap Perbulan Bahan Keluar Kemeja</h3>
			<table class="table table-bordered">
				<thead>
					<tr align="center">
					    <!-- <td rowspan="2">No</td> -->
					    <td rowspan="2">Bulan</td>
					    <td colspan="2">Satuan</td>
					</tr>
					<tr align="center">
					    <td>Roll</td>
					    <td>Yard</td>
					</tr>
				</thead>
				<tbody>
					<?php $kmj=0;$kmj2=0; ?>
					<?php foreach($rkemeja as $k){?>
						<tr align="center">
							<td>
								<?php echo $k['bulan'] ?>
							</td>
							<td>
								<?php echo $k['roll']?>
							</td>
							<td>
								<?php echo $k['yard']?>
							</td>
						</tr>
						<?php $kmj+=($k['roll']);?>
						<?php $kmj2+=($k['yard']);?>
					<?php } ?>
				</tbody>
				<tfoot>
					<tr align="center">
						<td><b>Total</b></td>
						<td><b><?php echo $kmj ?></b></td>
						<td><b><?php echo $kmj2?></b></td>
					</tr>
				</tfoot>
			</table>
		</div>
		<div class="form-group">
			<div id="kemeja"></div>
		</div>
		<div class="form-group">
			<h3 class="text-center">Rekap Perbulan Bahan Keluar Spandek</h3>
			<table class="table table-bordered">
				<thead>
					<tr align="center">
					    <!-- <td rowspan="2">No</td> -->
					    <td rowspan="2">Bulan</td>
					    <td colspan="2">Satuan</td>
					</tr>
					<tr align="center">
					    <td>Roll</td>
					    <td>Kg</td>
					</tr>
				</thead>
				<tbody>
					<?php $kos=0;$kos2=0; ?>
					<?php foreach($rkaos as $k){?>
						<tr align="center">
							<td>
								<?php echo $k['bulan'] ?>
							</td>
							<td>
								<?php echo $k['roll']?>
							</td>
							<td>
								<?php echo $k['kg']?>
							</td>
						</tr>
						<?php $kos+=($k['roll']);?>
						<?php $kos2+=($k['kg']);?>
					<?php } ?>
				</tbody>
				<tfoot>
					<tr align="center">
						<td><b>Total</b></td>
						<td><b><?php echo $kos ?></b></td>
						<td><b><?php echo $kos2?></b></td>
					</tr>
				</tfoot>
			</table>
		</div>
		<div class="form-group">
			<div id="spandek"></div>
		</div>
		<div class="form-group">
			<h3 class="text-center">Rekap Perbulan Bahan Keluar Celana</h3>
			<table class="table table-bordered">
				<thead>
					<tr align="center">
					    <!-- <td rowspan="2">No</td> -->
					    <td rowspan="2">Bulan</td>
					    <td colspan="2">Satuan</td>
					</tr>
					<tr align="center">
					    <td>Roll</td>
					    <td>Yard</td>
					</tr>
				</thead>
				<tbody>
					<?php $cln=0; $cln2=0;?>
					<?php foreach($rcelana as $k){?>
						<tr align="center">
							<td>
								<?php echo $k['bulan'] ?>
							</td>
							<td>
								<?php echo $k['roll']?>
							</td>
							<td>
								<?php echo $k['yard']?>
							</td>
						</tr>
						<?php $cln+=($k['roll']);?>
						<?php $cln2+=($k['yard']);?>
					<?php } ?>
				</tbody>
				<tfoot>
					<tr align="center">
						<td><b>Total</b></td>
						<td><b><?php echo $cln ?></b></td>
						<td><b><?php echo $cln2?></b></td>
					</tr>
				</tfoot>
			</table>
		</div>
		<div class="form-group">
			<div id="celana"></div>
		</div>
	</div>
</div>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>  
<!-- optional -->  
<script src="https://code.highcharts.com/modules/offline-exporting.js"></script>  
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script type="text/javascript">
	var colors = ['#32a852', '#3269a8', '#cfc930'];
	Highcharts.chart('kemeja', {
	  
	    chart: {
	        type: 'column',
	        style: {
	            color: "blue"
	        }
	    },
	    title: {
	        text: 'Grafik Bahan Keluar Kemeja',
	        style: {
		            color: '#34c9eb',
		            //font: '11px Trebuchet MS, Verdana, sans-serif'
		        }
	    },
	    subtitle: {
	        text: 'Jumlah Roll ',
	        style: {
		            color: '#34c9eb',
		            //font: '11px Trebuchet MS, Verdana, sans-serif'
		        }
	    },
	    xAxis: {
	        categories: <?php echo $bulan?>,
	        crosshair: true,
	        labels: {
		        style: {
		            color: '#34c9eb',
		            //font: '11px Trebuchet MS, Verdana, sans-serif'
		        }
		      },
	    },
	    yAxis: {
	        min: 0,
	        title: {
	            text: '',
	        },
	         labels: {
		        style: {
		            color: '#34c9eb',
		            //font: '11px Trebuchet MS, Verdana, sans-serif'
		        }
		      },
	    },
	    tooltip: {
	        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
	        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
	            '<td style="padding:0"><b>{point.y:.1f} Roll</b></td></tr>',
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
	         	data: [<?php echo $kem?>],
	     	},
	    ]
	});

	Highcharts.chart('spandek', {
	  
	    chart: {
	        type: 'column',
	        style: {
	            color: "blue"
	        }
	    },
	    title: {
	        text: 'Grafik Bahan Keluar Spandek ',
	        style: {
		            color: '#34c9eb',
		            //font: '11px Trebuchet MS, Verdana, sans-serif'
		        }
	    },
	    subtitle: {
	        text: 'Jumlah Roll ',
	        style: {
		            color: '#34c9eb',
		            //font: '11px Trebuchet MS, Verdana, sans-serif'
		        }
	    },
	    xAxis: {
	        categories: <?php echo $bulan?>,
	        crosshair: true,
	        labels: {
		        style: {
		            color: '#34c9eb',
		            //font: '11px Trebuchet MS, Verdana, sans-serif'
		        }
		      },
	    },
	    yAxis: {
	        min: 0,
	        title: {
	            text: '',
	        },
	         labels: {
		        style: {
		            color: '#34c9eb',
		            //font: '11px Trebuchet MS, Verdana, sans-serif'
		        }
		      },
	    },
	    tooltip: {
	        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
	        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
	            '<td style="padding:0"><b>{point.y:.1f} Roll</b></td></tr>',
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
	       		name:'Spandek',
	         	data: [<?php echo $kao?>],
	     	},
	    ]
	});


	Highcharts.chart('celana', {
	  
	    chart: {
	        type: 'column',
	        style: {
	            color: "blue"
	        }
	    },
	    title: {
	        text: 'Grafik Bahan Keluar Celana',
	        style: {
		            color: '#34c9eb',
		            //font: '11px Trebuchet MS, Verdana, sans-serif'
		        }
	    },
	    subtitle: {
	        text: 'Jumlah Roll ',
	        style: {
		            color: '#34c9eb',
		            //font: '11px Trebuchet MS, Verdana, sans-serif'
		        }
	    },
	    xAxis: {
	        categories: <?php echo $bulan?>,
	        crosshair: true,
	        labels: {
		        style: {
		            color: '#34c9eb',
		            //font: '11px Trebuchet MS, Verdana, sans-serif'
		        }
		      },
	    },
	    yAxis: {
	        min: 0,
	        title: {
	            text: '',
	        },
	         labels: {
		        style: {
		            color: '#34c9eb',
		            //font: '11px Trebuchet MS, Verdana, sans-serif'
		        }
		      },
	    },
	    tooltip: {
	        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
	        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
	            '<td style="padding:0"><b>{point.y:.1f} Roll</b></td></tr>',
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
	       		name:'Celana',
	         	data: [<?php echo $cel?>],
	     	},
	    ]
	});


</script>