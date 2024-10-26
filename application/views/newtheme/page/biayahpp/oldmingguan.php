<div class="row no-print">
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
			<button class="btn btn-info btn-sm" onclick="cetak()">Print</button>
			<a href="<?php echo $excel?>" class="btn btn-info btn-sm">Excel</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12 text-center">
		<h3>Laporan Produksi Kaos/Kemeja</h3><br>
		<p>Update per-tanggal <?php echo date('d-F-Y',strtotime($tanggal1)); ?> s.d <?php echo date('d-F-Y',strtotime($tanggal2)); ?></p>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
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
	<div class="col-md-9">
		<div class="form-group table-responsive">
			<caption>Sablon</caption>
			<table class="table table-bordered">
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
		              <td><?php echo $p['stokawalkaosdz']>0?number_format($p['stokawalkaosdz']):'';?></td>
		              <td><?php echo ($p['stokawalkemejajml'])?></td>
		              <td><?php echo $p['stokawalkemejadz']>0?number_format($p['stokawalkemejadz']):'';?></td> -->
		              <td><?php echo ($p['kirimkaosjml'])?></td>
		              <td><?php echo $p['kirimkaosdz']>0?number_format($p['kirimkaosdz'],2):'';?></td>
		              <!-- <td><?php echo ($p['kirimkemejajml'])?></td>
		              <td><?php echo $p['kirimkemejadz']>0?number_format($p['kirimkemejadz']):'';?></td> -->
		              <td><?php echo ($p['setorkaosjml'])?></td>
		              <td><?php echo $p['setorkaosdz']>0?number_format($p['setorkaosdz'],2):'';?></td>
		              <!-- <td><?php echo ($p['setorkemejajml'])?></td>
		              <td><?php echo $p['setorkemejadz']>0?number_format($p['setorkemejadz']):'';?></td> -->
		              <td><?php echo ($p['stokakhirkaosjml'])?></td>
		              <td><?php echo $p['stokakhirkaosdz']>0?number_format($p['stokakhirkaosdz'],2):'';?></td>
		              <!-- <td><?php echo ($p['stokakhirkemejajml'])?></td>
		              <td><?php echo $p['stokakhirkemejadz']>0?number_format($p['stokakhirkemejadz']):'';?></td> -->
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
		          	<td><?php echo number_format($skirimjml,2)?></td>
		          	<td><?php echo number_format($skirimdz,2)?></td>
		          	<td><?php echo number_format($ssetorjml,2)?></td>
		          	<td><?php echo number_format($ssetordz,2)?></td>
		          	<td><?php echo number_format($sstokjml,2)?></td>
		          	<td><?php echo number_format($sstokdz,2)?></td>
		          </tr>
		        </tbody>
		    </table>
			<br>
			<caption>CMT KAOS</caption>
			<table class="table table-bordered">
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
		            <th>DZ</th>-->
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
		              <td><?php echo ($p['kirimkaosjml'])?></td>
		              <td><?php echo $p['kirimkaosdz']>0?number_format($p['kirimkaosdz']):'';?></td>
		              <!-- <td><?php echo ($p['kirimkemejajml'])?></td>
		              <td><?php echo $p['kirimkemejadz']>0?number_format($p['kirimkemejadz']):'';?></td> -->
		              <td><?php echo ($p['setorkaosjml'])?></td>
		              <td><?php echo $p['setorkaosdz']>0?number_format($p['setorkaosdz']):'';?></td>
		              <!-- <td><?php echo ($p['setorkemejajml'])?></td>
		              <td><?php echo $p['setorkemejadz']>0?number_format($p['setorkemejadz']):'';?></td> -->
		              <td><?php echo ($p['stokakhirkaosjml'])?></td>
		              <td><?php echo $p['stokakhirkaosdz']>0?($p['stokakhirkaosdz']):'';?></td>
		              <!-- <td><?php echo ($p['stokakhirkemejajml'])?></td>
		              <td><?php echo $p['stokakhirkemejadz']>0?number_format($p['stokakhirkemejadz']):'';?></td> -->
		            </tr>
		            <?php 
		        		// $stokawalkaosjml+=($p['stokawalkaosjml']);
		        		// $stokawalkaosdz+=($p['stokawalkaosdz']);
		        		// $stokawalkemejajml+=($p['stokawalkemejajml']);
		        		// $stokawalkemejadz+=($p['stokawalkemejadz']);
		        		$kirimkaosjml+=($p['kirimkaosjml']);
		        		$kirimkaosdz+=($p['kirimkaosdz']);
		        		$kirimkemejajml+=($p['kirimkemejajml']);
		        		$kirimkemejadz+=($p['kirimkemejadz']);
		        		$setorkaosjml+=($p['setorkaosjml']);
		        		$setorkaosdz+=($p['setorkaosdz']);
		        		$setorkemejajml+=($p['setorkemejajml']);
		        		$setorkemejadz+=($p['setorkemejadz']);
		        		//$stokakhirkaosjml+=($p['stokakhirkaosjml']);
		        		// $stokakhirkaosdz+=($p['stokakhirkaosdz']);
		        		$stokakhirkaosdz+=0;
		        		$stokakhirkemejajml+=($p['stokakhirkemejajml']);
		        		$stokakhirkemejadz+=($p['stokakhirkemejadz']);
		        	 ?>
		          <?php }?>
		          <tr>
		          	<td colspan="2"><b>Total</b></td>
		          	<!-- <td><?php echo number_format($stokawalkemejajml,2)?></td>
		          	<td><?php echo number_format($stokawalkemejadz,2)?></td> -->
		          	<td><?php echo number_format($kirimkaosjml,2)?></td>
		          	<td><?php echo number_format($kirimkaosdz,2)?></td>
		          	<!-- <td><?php echo number_format($kirimkemejajml,2)?></td>
		          	<td><?php echo number_format($kirimkemejadz,2)?></td> -->
		          	<td><?php echo number_format($setorkaosjml,2)?></td>
		          	<td><?php echo number_format($setorkaosdz,2)?></td>
		          	<!-- <td><?php echo number_format($setorkemejajml,2)?></td>
		          	<td><?php echo number_format($setorkemejadz,2)?></td> -->
		          	<td><?php echo number_format($stokakhirkaosjml,2)?></td>
		          	<td><?php echo number_format($stokakhirkaosdz,2)?></td>
		          	<!-- <td><?php echo number_format($stokakhirkemejajml,2)?></td>
		          	<td><?php echo number_format($stokakhirkemejadz,2)?></td> -->
		          </tr>
		        </tbody>
		    </table>
		    <br>
		    <caption>CMT KEMEJA</caption>
		    <table class="table table-bordered">
		        <thead style="text-align: center;">
		          <tr>
		            <th rowspan="2">No</th>
		            <th rowspan="2">Nama CMT</th>
		            <!-- <th colspan="2">Stok Awal Kaos</th> -->
		            <!-- <th colspan="2">Stok Awal Kemeja</th> -->
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
		            <th>DZ</th>
		            <th>JML</th>
		            <th>DZ</th>-->
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
		              <td><?php echo ($p['kirimkemejajml'])?></td>
		              <td><?php echo $p['kirimkemejadz']>0?number_format($p['kirimkemejadz']):'';?></td>
		              <!-- <td><?php echo ($p['setorkaosjml'])?></td>
		              <td><?php echo $p['setorkaosdz']>0?number_format($p['setorkaosdz']):'';?></td> -->
		              <td><?php echo ($p['setorkemejajml'])?></td>
		              <td><?php echo $p['setorkemejadz']>0?number_format($p['setorkemejadz']):'';?></td>
		              <!-- <td><?php echo ($p['stokakhirkaosjml'])?></td>
		              <td><?php echo $p['stokakhirkaosdz']>0?number_format($p['stokakhirkaosdz']):'';?></td> -->
		              <td><?php echo ($p['stokakhirkemejajml'])?></td>
		              <td><?php echo $p['stokakhirkemejadz']>0?number_format($p['stokakhirkemejadz']):'';?></td>
		            </tr>
		            <?php 
		        		// $stokawalkaosjml+=($p['stokawalkaosjml']);
		        		// $stokawalkaosdz+=($p['stokawalkaosdz']);
		        		// $stokawalkemejajml+=($p['stokawalkemejajml']);
		        		// $stokawalkemejadz+=($p['stokawalkemejadz']);
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
		          	<td><?php echo number_format($kirimkemejajml,2)?></td>
		          	<td><?php echo number_format($kirimkemejadz,2)?></td>
		          	<td><?php echo number_format($setorkemejajml,2)?></td>
		          	<td><?php echo number_format($setorkemejadz,2)?></td>
		          	<td><?php echo number_format($stokakhirkemejajml,2)?></td>
		          	<td><?php echo number_format($stokakhirkemejadz,2)?></td>
		          </tr>
		        </tbody>
		    </table>
		</div>
	</div>
</div>