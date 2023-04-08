<div class="row no-print">
	<?php $tam=0;?>
	<?php if($tam==1){?>
	<div class="col-md-3">
		<label>Bulan Awal</label>
		<select name="bulan1" class="form-control select2bs4" data-live-search="true">
			<option value="*">Semua</option>
			<?php foreach($bulan as $key=>$val){?>
				<option value="<?php echo $val?>"><?php echo $val?></option>
			<?php } ?>
			<!--<option value="1">Januari</option>
			<option value="2">Februari</option>
			<option value="3">Januari</option>
			<option value="4">April</option>
			<option value="5">Mei</option>
			<option value="6">Juni</option>
			<option value="7">Juli</option>
			<option value="8">Agustus</option>
			<option value="9">September</option>
			<option value="10">Oktober</option>
			<option value="11">November</option>
			<option value="12">Desember</option>-->
		</select>
	</div>
	<div class="col-md-3">
		<label>Bulan Akhir</label>
		<select name="bulan2" class="form-control select2bs4" data-live-search="true">
			<option value="*">Semua</option>
			<?php foreach($bulan as $key=>$val){?>
				<option value="<?php echo $val?>"><?php echo $val?></option>
			<?php } ?>
			<!--
			<option value="1">Januari</option>
			<option value="2">Februari</option>
			<option value="3">Januari</option>
			<option value="4">April</option>
			<option value="5">Mei</option>
			<option value="6">Juni</option>
			<option value="7">Juli</option>
			<option value="8">Agustus</option>
			<option value="9">September</option>
			<option value="10">Oktober</option>
			<option value="11">November</option>
			<option value="12">Desember</option>-->
		</select>
	</div>
	<?php } ?>
	<!--<div class="col-md-2">
		<label>Tahun</label>
		<select name="tahun" class="form-control select2bs4" data-live-search="true">
			<option value="*">Pilih</option>
			<?php for($i=2020;$i<=2030;$i++){?>
				<option value="<?php echo $i?>"><?php echo $i?></option>
			<?php } ?>
		</select>
	</div>-->
	<div class="col-md-3">
		<label>Nama CMT</label>
		<select name="cmt" class="form-control select2bs4" data-live-search="true">
			<option value="*">Semua</option>
			<?php foreach($cmt as $c){?>
				<option value="<?php echo $c['id_cmt']?>"><?php echo strtolower($c['cmt_name'])?></option>
			<?php } ?>
		</select>
	</div>
	<div class="col-md-3">
		<label>Aksi</label><br>
		<button class="btn btn-info btn-sm" onclick="filter()">Tampilkan</button>
		<a class="btn btn-info btn-sm text-white" href="<?php echo $excel?>">excel</a>
		<button class="btn btn-info btn-sm cetak">Print</button>
	</div>
</div>
<br>
<div class="row">
	<div class="col-md-12">
		<h4><?php echo strtolower($cmts['cmt_name'])?></h4>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="table-responsive">
		<table class="table table-bordered">
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
				<?php
					$kirimdz=0;
					$kirimpcs=0;
					$setorjmlpo=0;
					$setordz=0;
					$setorpcs=0;
				?>
				<?php if($products){?>
					<?php foreach($products as $p){?>
					<?php if($p['kirimpo'] > 0 ) { ?>
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
					<?php
						$kirimdz+=($p['kirimdz']);
						$kirimpcs+=($p['kirimpcs']);
						$setorjmlpo+=($p['setorjmlpo']);
						$setordz+=($p['setordz']);
						$setorpcs+=($p['setorpcs']);
					?>
					<?php } ?>
					<?php } ?>
					<tr>
						<td><b>Total</b></td>
						<td align="center"><b><?php echo $kirimpo?></b></td>
						<td align="center"><b><?php echo $kirimdz?></b></td>
						<td align="center"><b><?php echo $kirimpcs?></b></td>
						<td align="center"><b><?php echo $setorjmlpo?></b></td>
						<td align="center"><b><?php echo $setordz?></b></td>
						<td align="center"><b><?php echo $setorpcs?></b></td>
					</tr>
				<?php }else{ ?>
					<tr>
						<td colspan="8">Silahkan pilih nama cmt</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div id="grafikkirimsetor" style="width:100%; height:400px;"></div>
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

</script>