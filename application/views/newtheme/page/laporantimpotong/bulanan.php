<div class="row no-print">
	<div class="col-md-4">
		<div class="form-group">
			<label>Bulan</label>
			<select name="bulan" id="bulan" class="form-control select2bs4">
				<option value="*">Mohon Dipilih</option>
				<?php foreach(bulan() as $b=>$val){?>
					<option value="<?php echo $b?>" <?php echo $bulan==$b?'selected':''; ?>><?php echo $val?></option>
				<?php } ?>
			</select>
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label>Tahun</label>
			<select name="tahun" id="tahun" class="form-control select2bs4">
				<option value="*">Mohon Dipilih</option>
				<?php for($i=2021;$i<2045;$i++){?>
					<option value="<?php echo $i?>" <?php echo $tahun==$i?'selected':''; ?>><?php echo $i?></option>
				<?php } ?>
			</select>
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label>Aksi</label><br>
			<button class="btn btn-info btn-sm" onclick="filterbulan()">Filter</button>
			<button class="btn btn-info btn-sm" onclick="cetak()">Print</button>
			<!-- <a href="<?php echo $excel?>" class="btn btn-info btn-sm">Excel</a> -->
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-4"></div>
	<div class="çol-md-4">
		<div class="text-center form-group">
			<?php if(isset($bulan)){ ?>
				<center>
					<h3>Laporan Potongan Bulan <?php echo (bulan()[$bulan]) ?> <?php echo $tahun ?></h3>
				</center>
			<?php } ?>
		</div>
	</div>
	<div class="col-md-4"></div>
</div>

<div class="row">
	<div class="col-md-3"></div>
	<div class="çol-md-6">
		<div class="text-center form-group">
			<?php if(empty($bupot)){ ?>
				<center>
					<h3 class="text-danger">Tidak ada data laporan Potongan di Bulan <?php echo (bulan()[$bulan]) ?> <?php echo $tahun ?></h3>
				</center>
			<?php } ?>
		</div>
	</div>
	<div class="col-md-3"></div>
</div>

<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<?php foreach($bupot as $b){?>

			<label>Potongan <?php echo $b['nama']?></label>
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th>No</th>
						<th>Nama</th>
						<th>JML PO</th>
						<th>JML (Dz)</th>
						<th>JML (Pcs)</th>
					</tr>
				</thead>
				<tbody>
					<?php $nem=1;?>
					<?php $jmlks=0;$kaosdz=0;$kaospcs=0;?>
					<?php foreach($b['dets'] as $d){?>
						<tr>
							<td><?php echo $nem++?></td>
							<td><?php echo $d['nama']?></td>
							<td><?php echo $d['jml']?></td>
							<td><?php echo number_format($d['dz'],2)?></td>
							<td><?php echo $d['pcs']?></td>
						</tr>
						<?php 
							$jmlks+=($d['jml']);
							$kaosdz+=($d['dz']);
							$kaospcs+=($d['pcs']);
						?>
					<?php } ?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="2"><b>Total</b></td>
						<td><?php echo $jmlks?></td>
						<td><?php echo number_format($kaosdz,2)?></td>
						<td><?php echo $kaospcs?></td>
					</tr>
				</tfoot>
			</table>
		<?php } ?>
		</div>
	</div>
	
	<div class="col-md-6">
		<?php foreach($bupot as $b){?>
		<div class="form-group">
			<div id="<?php echo $b['nama']?>"></div>
		</div>
		<?php } ?>
	</div>
</div>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<?php $namanya=[];$dznya=[]; ?>
<?php foreach($bupot as $b){?>
<?php foreach($b['dets'] as $d){?>
	<?php
		$namanya[]=$d['nama'];
		$dznya[]=array('tot'=>!empty($d['dz'])?$d['dz']:0);
	?>
<?php } ?>
<script type="text/javascript">
	Highcharts.chart('<?php echo $b['nama']?>', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Grafik Potongan <?php echo $b['nama']?>'
    },
    subtitle: {
        text: 'www.forboysproduction.com'
    },
    xAxis: {
        categories:<?php echo json_encode($namanya) ?>,
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Jumlah (dz)'
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
       name:'PO',
       data: [<?php echo implode(",", array_column($dznya, 'tot')); ?>]
    },
         ]
  });


	function excel(){
		url='?&excel=1';

	  var cmt = $('select[name=\'cmt\']').val();

		if (cmt != '*') {
			url += '&cmt=' + encodeURIComponent(cmt);
		}
		location =url;
		
	}
</script>
<?php } ?>
<script type="text/javascript">
	
$(document).ready(function(){
  $(".cetak").click(function(){
    window.print();
  });
});
</script>
<?php //pre($dznya)?>