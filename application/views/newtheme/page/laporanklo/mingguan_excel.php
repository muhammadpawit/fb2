<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Laporan_KLO_".time().".xls");
?>
<style type="text/css">
	@import url('https://fonts.googleapis.com/css2?family=Baskervville:ital@1&display=swap');
  .registered {
    font-family: 'Baskervville', serif;
  }
</style>
<table>
	<tr>
		<td>
			<?php foreach($bupot as $b){?>

			<label>Potongan <?php echo $b['nama']?></label>
			<table border="1" style="width: 100%;border-collapse: collapse;">
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
							<td><?php echo $d['dz']?></td>
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
						<td><?php echo $kaosdz?></td>
						<td><?php echo $kaospcs?></td>
					</tr>
				</tfoot>
			</table>
		<?php } ?>
		</td>
		<td></td>
		<td></td>
		<td>
			<caption>Sablon</caption>
			<table border="1" style="width: 100%;border-collapse: collapse;">
		        <thead style="text-align: center;">
		          <tr>
		            <th rowspan="2">No</th>
		            <th rowspan="2">Nama CMT</th>
		            <!-- <th colspan="2">Stok Awal Kaos</th> -->
		            <!-- <th colspan="2">Stok Awal Kemeja</th> -->
		            <th colspan="2">Kirim Kaos</th>
		            <!-- <th colspan="2">Kirim Kemeja</th> -->
		            <th colspan="2">Setor Kaos</th>
		            <!-- <th colspan="2">Setor Kemeja</th> -->
		            <th colspan="2">Stok Akhir Kaos</th>
		            <!-- <th colspan="2">Stok Akhir Kemeja</th> -->
		          </tr>
		          <tr>
		            <!-- <th>JML</th>
		            <th>DZ</th>
		            <th>JML</th>
		            <th>DZ</th>
		            <th>JML</th>
		            <th>DZ</th>
		            <th>JML</th>
		            <th>DZ</th>
		            <th>JML</th>
		            <th>DZ</th> -->
		            <th>JML</th>
		            <th>DZ</th>
		            <th>JML</th>
		            <th>DZ</th>
		            <th>JML</th>
		            <th>DZ</th>
		          </tr>
		        </thead>
		        <tbody>
		        	<?php 
		        		$skirimjml=0;
		        		$skirimdz=0;
		        		$ssetorjml=0;
		        		$ssetordz=0;
		        		$sstokjml=0;
		        		$sstokdz=0;
		        	 ?>
		          <?php foreach($sablon as $p){?>
		            <tr>
		              <td><?php echo $p['no']?></td>
		              <td><?php echo $p['nama']?></td>
		              <!-- <td><?php echo ($p['stokawalkaosjml'])?></td>
		              <td><?php echo $p['stokawalkaosdz']>0?($p['stokawalkaosdz']):'';?></td>
		              <td><?php echo ($p['stokawalkemejajml'])?></td>
		              <td><?php echo $p['stokawalkemejadz']>0?($p['stokawalkemejadz']):'';?></td> -->
		              <td><?php echo ($p['kirimkaosjml'])?></td>
		              <td><?php echo $p['kirimkaosdz']>0?round($p['kirimkaosdz'],2):'';?></td>
		              <!-- <td><?php echo ($p['kirimkemejajml'])?></td>
		              <td><?php echo $p['kirimkemejadz']>0?($p['kirimkemejadz']):'';?></td> -->
		              <td><?php echo ($p['setorkaosjml'])?></td>
		              <td><?php echo $p['setorkaosdz']>0?round($p['setorkaosdz'],2):'';?></td>
		              <!-- <td><?php echo ($p['setorkemejajml'])?></td>
		              <td><?php echo $p['setorkemejadz']>0?($p['setorkemejadz']):'';?></td> -->
		              <td><?php echo ($p['stokakhirkaosjml'])?></td>
		              <td><?php echo $p['stokakhirkaosdz']>0?round($p['stokakhirkaosdz'],2):'';?></td>
		              <!-- <td><?php echo ($p['stokakhirkemejajml'])?></td>
		              <td><?php echo $p['stokakhirkemejadz']>0?($p['stokakhirkemejadz']):'';?></td> -->
		            </tr>
		            <?php 
		        		$skirimjml+=($p['kirimkaosjml']);
		        		$skirimdz+=($p['kirimkaosdz']);
		        		$ssetorjml+=($p['setorkaosjml']);
		        		$ssetordz+=($p['setorkaosdz']);
		        		$sstokjml+=($p['stokakhirkaosjml']);
		        		$sstokdz+=($p['stokakhirkaosdz']);
		        	 ?>
		          <?php }?>
		          <tr>
		          	<td colspan="2"><b>Total</b></td>
		          	<td><?php echo ($skirimjml)?></td>
		          	<td><?php echo round($skirimdz,2)?></td>
		          	<td><?php echo ($ssetorjml)?></td>
		          	<td><?php echo round($ssetordz,2)?></td>
		          	<td><?php echo ($sstokjml)?></td>
		          	<td><?php echo round($sstokdz,2)?></td>
		          </tr>
		        </tbody>
		    </table>
			<br>
			<caption>CMT KAOS</caption>
			<table border="1" style="width: 100%;border-collapse: collapse;">
		        <thead style="text-align: center;">
		          <tr>
		            <th rowspan="2">No</th>
		            <th rowspan="2">Nama CMT</th>
		            <th colspan="2">Stok Awal Kaos</th>
		            <!-- <th colspan="2">Stok Awal Kemeja</th> -->
		            <th colspan="2">Kirim Kaos</th>
		            <!-- <th colspan="2">Kirim Kemeja</th> -->
		            <th colspan="2">Setor Kaos</th>
		            <!-- <th colspan="2">Setor Kemeja</th> -->
		            <th colspan="2">Stok Akhir Kaos</th>
		            <!-- <th colspan="2">Stok Akhir Kemeja</th> -->
		          </tr>
		          <tr>
		            <!-- <th>JML</th>
		            <th>DZ</th>
		            <th>JML</th>
		            <th>DZ</th>
		            <th>JML</th>
		            <th>DZ</th>
		            <th>JML</th>
		            <th>DZ</th> -->
		            <th>JML</th>
		            <th>DZ</th>
		            <th>JML</th>
		            <th>DZ</th>
		            <th>JML</th>
		            <th>DZ</th>
		            <th>JML</th>
		            <th>DZ</th>
		          </tr>
		        </thead>
		        <tbody>
		        	<?php 
		        		$stokawalkaosjml=0;
		        		$stokawalkaosdz=0;
		        		$stokawalkemejajml=0;
		        		$stokawalkemejadz=0;
		        		$kirimkaosjml=0;
		        		$kirimkaosdz=0;
		        		$kirimkemejajml=0;
		        		$kirimkemejadz=0;
		        		$setorkaosjml=0;
		        		$setorkaosdz=0;
		        		$setorkemejajml=0;
		        		$setorkemejadz=0;
		        		$stokakhirkaosjml=0;
		        		$stokakhirkaosdz=0;
		        		$stokakhirkemejajml=0;
		        		$stokakhirkemejadz=0;
		        	 ?>		        	
		          <?php foreach($jahit as $p){?>
		            <tr>
		              <td><?php echo $p['no']?></td>
		              <td><?php echo $p['nama']?></td>
		              <td><?php echo ($p['stokawalkaosjml'])?></td>
		              <td><?php echo $p['stokawalkaosdz']>0?round($p['stokawalkaosdz'],2):'';?></td>
		              <!-- <td><?php echo ($p['stokawalkemejajml'])?></td>
		              <td><?php echo $p['stokawalkemejadz']>0?($p['stokawalkemejadz']):'';?></td> -->
		              <td><?php echo ($p['kirimkaosjml'])?></td>
		              <td><?php echo $p['kirimkaosdz']>0?round($p['kirimkaosdz'],2):'';?></td>
		              <!-- <td><?php echo ($p['kirimkemejajml'])?></td>
		              <td><?php echo $p['kirimkemejadz']>0?($p['kirimkemejadz']):'';?></td> -->
		              <td><?php echo ($p['setorkaosjml'])?></td>
		              <td><?php echo $p['setorkaosdz']>0?round($p['setorkaosdz'],2):'';?></td>
		              <!-- <td><?php echo ($p['setorkemejajml'])?></td>
		              <td><?php echo $p['setorkemejadz']>0?($p['setorkemejadz']):'';?></td> -->
		              <td><?php echo ($p['stokakhirkaosjml'])?></td>
		              <td><?php echo $p['stokakhirkaosdz']>0?round($p['stokakhirkaosdz'],2):'';?></td>
		              <!-- <td><?php echo ($p['stokakhirkemejajml'])?></td>
		              <td><?php echo $p['stokakhirkemejadz']>0?($p['stokakhirkemejadz']):'';?></td> -->
		            </tr>
		            <?php 
		        		$stokawalkaosjml+=($p['stokawalkaosjml']);
		        		$stokawalkaosdz+=($p['stokawalkaosdz']);
		        		$stokawalkemejajml+=($p['stokawalkemejajml']);
		        		$stokawalkemejadz+=($p['stokawalkemejadz']);
		        		$kirimkaosjml+=($p['kirimkaosjml']);
		        		$kirimkaosdz+=($p['kirimkaosdz']);
		        		$kirimkemejajml+=($p['kirimkemejajml']);
		        		$kirimkemejadz+=($p['kirimkemejadz']);
		        		$setorkaosjml+=($p['setorkaosjml']);
		        		$setorkaosdz+=($p['setorkaosdz']);
		        		$setorkemejajml+=($p['setorkemejajml']);
		        		$setorkemejadz+=($p['setorkemejadz']);
		        		$stokakhirkaosjml+=($p['stokakhirkaosjml']);
		        		$stokakhirkaosdz+=($p['stokakhirkaosdz']);
		        		$stokakhirkemejajml+=($p['stokakhirkemejajml']);
		        		$stokakhirkemejadz+=($p['stokakhirkemejadz']);
		        	 ?>
		          <?php }?>
		          <tr>
		          	<td colspan="2"><b>Total</b></td>
		          	<td><?php echo ($stokawalkaosjml)?></td>
		          	<td><?php echo round($stokawalkaosdz,2)?></td>
		          	<!-- <td><?php echo ($stokawalkemejajml)?></td>
		          	<td><?php echo ($stokawalkemejadz)?></td> -->
		          	<td><?php echo ($kirimkaosjml)?></td>
		          	<td><?php echo round($kirimkaosdz,2)?></td>
		          	<!-- <td><?php echo ($kirimkemejajml)?></td>
		          	<td><?php echo ($kirimkemejadz)?></td> -->
		          	<td><?php echo ($setorkaosjml)?></td>
		          	<td><?php echo round($setorkaosdz,2)?></td>
		          	<!-- <td><?php echo ($setorkemejajml)?></td>
		          	<td><?php echo ($setorkemejadz)?></td> -->
		          	<td><?php echo ($stokakhirkaosjml)?></td>
		          	<td><?php echo round($stokakhirkaosdz,2)?></td>
		          	<!-- <td><?php echo ($stokakhirkemejajml)?></td>
		          	<td><?php echo ($stokakhirkemejadz)?></td> -->
		          </tr>
		        </tbody>
		    </table>
		    <br>
		    <caption>CMT KEMEJA</caption>
		    <table border="1" style="width: 100%;border-collapse: collapse;">
		        <thead style="text-align: center;">
		          <tr>
		            <th rowspan="2">No</th>
		            <th rowspan="2">Nama CMT</th>
		            <!-- <th colspan="2">Stok Awal Kaos</th> -->
		            <th colspan="2">Stok Awal Kemeja</th>
		            <!-- <th colspan="2">Kirim Kaos</th> -->
		            <th colspan="2">Kirim Kemeja</th>
		            <!-- <th colspan="2">Setor Kaos</th> -->
		            <th colspan="2">Setor Kemeja</th>
		            <!-- <th colspan="2">Stok Akhir Kaos</th> -->
		            <th colspan="2">Stok Akhir Kemeja</th>
		          </tr>
		          <tr>
		            <!-- <th>JML</th>
		            <th>DZ</th>
		            <th>JML</th>
		            <th>DZ</th>
		            <th>JML</th>
		            <th>DZ</th>
		            <th>JML</th>
		            <th>DZ</th> -->
		            <th>JML</th>
		            <th>DZ</th>
		            <th>JML</th>
		            <th>DZ</th>
		            <th>JML</th>
		            <th>DZ</th>
		            <th>JML</th>
		            <th>DZ</th>
		          </tr>
		        </thead>
		        <tbody>
		        	<?php 
		        		$stokawalkaosjml=0;
		        		$stokawalkaosdz=0;
		        		$stokawalkemejajml=0;
		        		$stokawalkemejadz=0;
		        		$kirimkaosjml=0;
		        		$kirimkaosdz=0;
		        		$kirimkemejajml=0;
		        		$kirimkemejadz=0;
		        		$setorkaosjml=0;
		        		$setorkaosdz=0;
		        		$setorkemejajml=0;
		        		$setorkemejadz=0;
		        		$stokakhirkaosjml=0;
		        		$stokakhirkaosdz=0;
		        		$stokakhirkemejajml=0;
		        		$stokakhirkemejadz=0;
		        	 ?>		        	
		          <?php foreach($jahitk as $p){?>
		            <tr>
		              <td><?php echo $p['no']?></td>
		              <td><?php echo $p['nama']?></td>
		              <!-- <td><?php echo ($p['stokawalkaosjml'])?></td>
		              <td><?php echo $p['stokawalkaosdz']>0?($p['stokawalkaosdz']):'';?></td> -->
		              <td><?php echo ($p['stokawalkemejajml'])?></td>
		              <td><?php echo $p['stokawalkemejadz']>0?round($p['stokawalkemejadz'],2):'';?></td>
		              <!-- <td><?php echo ($p['kirimkaosjml'])?></td>
		              <td><?php echo $p['kirimkaosdz']>0?($p['kirimkaosdz']):'';?></td> -->
		              <td><?php echo ($p['kirimkemejajml'])?></td>
		              <td><?php echo $p['kirimkemejadz']>0?round($p['kirimkemejadz'],2):'';?></td>
		              <!-- <td><?php echo ($p['setorkaosjml'])?></td>
		              <td><?php echo $p['setorkaosdz']>0?($p['setorkaosdz']):'';?></td> -->
		              <td><?php echo ($p['setorkemejajml'])?></td>
		              <td><?php echo $p['setorkemejadz']>0?round($p['setorkemejadz'],2):'';?></td>
		              <!-- <td><?php echo ($p['stokakhirkaosjml'])?></td>
		              <td><?php echo $p['stokakhirkaosdz']>0?($p['stokakhirkaosdz']):'';?></td> -->
		              <td><?php echo ($p['stokakhirkemejajml'])?></td>
		              <td><?php echo $p['stokakhirkemejadz']>0?round($p['stokakhirkemejadz'],2):'';?></td>
		            </tr>
		            <?php 
		        		$stokawalkaosjml+=($p['stokawalkaosjml']);
		        		$stokawalkaosdz+=($p['stokawalkaosdz']);
		        		$stokawalkemejajml+=($p['stokawalkemejajml']);
		        		$stokawalkemejadz+=($p['stokawalkemejadz']);
		        		$kirimkaosjml+=($p['kirimkaosjml']);
		        		$kirimkaosdz+=($p['kirimkaosdz']);
		        		$kirimkemejajml+=($p['kirimkemejajml']);
		        		$kirimkemejadz+=($p['kirimkemejadz']);
		        		$setorkaosjml+=($p['setorkaosjml']);
		        		$setorkaosdz+=($p['setorkaosdz']);
		        		$setorkemejajml+=($p['setorkemejajml']);
		        		$setorkemejadz+=($p['setorkemejadz']);
		        		$stokakhirkaosjml+=($p['stokakhirkaosjml']);
		        		$stokakhirkaosdz+=($p['stokakhirkaosdz']);
		        		$stokakhirkemejajml+=($p['stokakhirkemejajml']);
		        		$stokakhirkemejadz+=($p['stokakhirkemejadz']);
		        	 ?>
		          <?php }?>
		          <tr>
		          	<td colspan="2"><b>Total</b></td>
		          	<!-- <td><?php echo ($stokawalkaosjml)?></td>
		          	<td><?php echo ($stokawalkaosdz)?></td> -->
		          	<td><?php echo ($stokawalkemejajml)?></td>
		          	<td><?php echo round($stokawalkemejadz,2)?></td>
		          	<!-- <td><?php echo ($kirimkaosjml)?></td>
		          	<td><?php echo ($kirimkaosdz)?></td> -->
		          	<td><?php echo ($kirimkemejajml)?></td>
		          	<td><?php echo round($kirimkemejadz,2)?></td>
		          	<!-- <td><?php echo ($setorkaosjml)?></td>
		          	<td><?php echo ($setorkaosdz)?></td> -->
		          	<td><?php echo ($setorkemejajml)?></td>
		          	<td><?php echo round($setorkemejadz,2)?></td>
		          	<!-- <td><?php echo ($stokakhirkaosjml)?></td>
		          	<td><?php echo ($stokakhirkaosdz)?></td> -->
		          	<td><?php echo ($stokakhirkemejajml)?></td>
		          	<td><?php echo round($stokakhirkemejadz,2)?></td>
		          </tr>
		        </tbody>
		        <tfoot>
					<tr>
			          <td colspan="10" align="right"><i class="registered">Registered by Forboys Production System <?php echo date('d-m-Y H:i:s'); ?></i></td>
			        </tr>
				</tfoot>
		    </table>
		</td>
	</tr>
</table>