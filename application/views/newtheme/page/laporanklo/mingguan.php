<div class="row no-print">
	<div class="col-md-2">
		<div class="form-group">
			<label>Tanggal Awal Potongan</label>
			<input type="text" name="tanggal1" id="tanggal1_pot" value="<?php echo $tanggal1_bupot?>" class="form-control">
		</div>
	</div>
	<div class="col-md-2">
		<div class="form-group">
			<label>Tanggal Akhir Potongan</label>
			<input type="text" name="tanggal2" id="tanggal2_pot" value="<?php echo $tanggal2_bupot?>" class="form-control">
		</div>
	</div>
	<div class="col-md-2">
		<div class="form-group">
			<label>Tanggal Awal CMT</label>
			<input type="text" name="tanggal1" id="tanggal1" value="<?php echo $tanggal1?>" class="form-control">
		</div>
	</div>
	<div class="col-md-2">
		<div class="form-group">
			<label>Tanggal Akhir CMT</label>
			<input type="text" name="tanggal2" id="tanggal2" value="<?php echo $tanggal2?>" class="form-control">
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label>Aksi</label><br>
			<button class="btn btn-info btn-sm" onclick="filtertglonly_pot()">Filter</button>
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
			<caption>Periode : <?php echo $tanggal1_bupot ?> s.d <?php echo $tanggal2_bupot ?> </caption>
			<?php foreach($bupot as $b){?> <br>

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
					<th colspan="2">Stok Awal</th>
		            <th colspan="2">Kirim Kaos</th>
		            <th colspan="2">Setor Kaos</th>
		            <th colspan="2">Stok Akhir Kaos</th>
		          </tr>
		          <tr>
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
		        		$skirimjml=0;
		        		$skirimdz=0;
		        		$ssetorjml=0;
		        		$ssetordz=0;
		        		$sstokjml=0;
		        		$sstokdz=0;
						$stokawaldz=0;
						$all_stokawaljml=0;
						$all_stokawaldz=0;
		        	 ?>
		          <?php foreach($sablon as $p){?>
		            <tr>
		              <td><?php echo $p['no']?></td>
		              <td><?php echo $p['nama']?></td>
					  <td><?php echo $p['stokawal']?></td> 
					  <td><?php echo $p['stokawal_dz']?></td> 
					  <td><?php echo $p['kirimjml']?></td>
		              <td><?php echo number_format($p['kirimdz'],2)?></td>
		              <td><?php echo $p['setorjml']?></td>
		              <td><?php echo number_format($p['setordz'],2)?></td>
		              <td><?php echo ( ($p['stokawal']+$p['kirimjml']) - $p['setorjml'] )?></td>
		              <td><?php echo number_format( ($p['stokawal_dz']+$p['kirimdz']) - $p['setordz'],2) ?></td>
		            </tr>
		            <?php 
						$all_stokawaljml+=($p['stokawal']);
						$all_stokawaldz+=($p['stokawal_dz']);
		        		$skirimjml+=($p['kirimjml']);
		        		$skirimdz+=($p['kirimdz']);
		        		$ssetorjml+=($p['setorjml']);
		        		$ssetordz+=($p['setordz']);
		        		$sstokjml+=(($p['stokawal']+$p['kirimjml']) - $p['setorjml'] );
		        		$sstokdz+=($p['stokawal_dz']+$p['kirimdz']) - $p['setordz'];
		        	 ?>
		          <?php }?>
		          <tr style="font-weight: bold;">
		          	<td colspan="2"><b>Total</b></td>
					<td><?php echo number_format($all_stokawaljml,2)?></td>
					<td><?php echo number_format($all_stokawaldz,2)?></td>
		          	<td><?php echo number_format($skirimjml,2)?></td>
		          	<td><?php echo number_format($skirimdz,2)?></td>
		          	<td><?php echo number_format($ssetorjml,2)?></td>
		          	<td><?php echo number_format($ssetordz,2)?></td>
		          	<td><?php echo number_format(($sstokjml),2)?></td>
		          	<td><?php echo number_format(($sstokdz),2)?></td>
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
		            <th colspan="3">Kirim Kaos</th>
		            <th colspan="3">Kirim PO<br> Jeans</th>
		            <th colspan="3">Setor PO<br> Jeans</th>
		            <th colspan="3">Setor Kaos</th>
		            <th colspan="3">Stok Akhir Kaos</th>
		          </tr>
		          <tr>
		            <th>JML</th>
		            <th>DZ</th>
		            <th>PCS</th>
		            <th>JML</th>
		            <th>DZ</th>
		            <th>PCS</th>
		            <th>JML</th>
		            <th>DZ</th>
		            <th>PCS</th>
		            <th>JML</th>
		            <th>DZ</th>
		            <th>PCS</th>
		            <th>JML</th>
		            <th>DZ</th>
		            <th>PCS</th>
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
		        		$kirimkaospcs=0;
		        		$kirimjeansjml=0;
		        		$kirimjeansdz=0;
		        		$kirimjeanspcs=0;
		        		$setorjeansjml=0;
		        		$setorjeansdz=0;
		        		$setorjeanspcs=0;
		        		$kirimkemejajml=0;
		        		$kirimkemejadz=0;
		        		$setorkaosjml=0;
		        		$setorkaosdz=0;
		        		$setorkaospcs=0;
		        		$setorkemejajml=0;
		        		$setorkemejadz=0;
		        		$stokakhirkaosjml=0;
		        		$stokakhirkaosdz=0;
						$stokakhirkaospcs=0;
		        		$stokakhirkemejajml=0;
		        		$stokakhirkemejadz=0;
		        	 ?>		        	
		          <?php foreach($jahit as $p){?>
		            <tr>
		              <td><?php echo $p['no']?></td>
		              <td><?php echo $p['nama']?></td>
		              <td><?php echo ($p['kirimkaosjml']>0)?number_format($p['kirimkaosjml']):'';?></td>
		              <td><?php echo $p['kirimkaosdz']>0?number_format($p['kirimkaosdz']):'';?></td>
		              <td><?php echo $p['kirimkaospcs']>0?number_format($p['kirimkaospcs']):'';?></td>
		              <td><?php echo ($p['kirimjeansjml']>0)?number_format($p['kirimjeansjml']):'';?></td>
		              <td><?php echo $p['kirimjeansdz']>0?number_format($p['kirimjeansdz']):'';?></td>
		              <td><?php echo $p['kirimjeanspcs']>0?number_format($p['kirimjeanspcs']):'';?></td>
		              <td><?php echo ($p['setorjeansjml']>0)?number_format($p['kirimjeansjml']):'';?></td>
		              <td><?php echo $p['setorjeansdz']>0?number_format($p['kirimjeansdz']):'';?></td>
		              <td><?php echo $p['setorjeanspcs']>0?number_format($p['setorjeanspcs']):'';?></td>
		              <td><?php echo ($p['setorkaosjml'])?></td>
		              <td><?php echo $p['setorkaosdz']>0?number_format($p['setorkaosdz']):'';?></td>
		              <td><?php echo $p['setorkaospcs']>0?number_format($p['setorkaospcs']):'';?></td>
		              <td><?php echo ($p['stokakhirkaosjml'])?></td>
		              <td><?php echo $p['stokakhirkaosdz']>0?number_format($p['stokakhirkaosdz'],2):'';?></td>
		              <td><?php echo $p['stokakhirkaospcs'] ?></td>
		            </tr>
		            <?php 
		        		$kirimkaosjml+=($p['kirimkaosjml']);
		        		$kirimkaosdz+=($p['kirimkaosdz']);
		        		$kirimkaospcs+=($p['kirimkaospcs']);
		        		$kirimjeansjml+=($p['kirimjeansjml']);
		        		$kirimjeansdz+=($p['kirimjeansdz']);
		        		$kirimjeanspcs=($p['kirimjeanspcs']);
		        		$setorjeansjml+=($p['setorjeansjml']);
		        		$setorjeansdz+=($p['setorjeansdz']);
		        		$setorjeanspcs=($p['setorjeanspcs']);
		        		$setorkaosjml+=($p['setorkaosjml']);
		        		$setorkaosdz+=($p['setorkaosdz']);
		        		$setorkaospcs+=($p['setorkaospcs']);
						$stokakhirkaosjml+=($p['stokakhirkaosjml']);
		        		$stokakhirkaosdz+=($p['stokakhirkaosdz']);
						$stokakhirkaospcs+=($p['stokakhirkaospcs']);
		        	 ?>
		          <?php }?>
		          <tr>
		          	<td colspan="2"><b>Total</b></td>
		          	<td><?php echo number_format($kirimkaosjml,2)?></td>
		          	<td><?php echo number_format($kirimkaosdz,2)?></td>
		          	<td><?php echo number_format($kirimkaospcs,2)?></td>
		          	<td><?php echo number_format($kirimjeansjml,2)?></td>
		          	<td><?php echo number_format($kirimjeansdz,2)?></td>
		          	<td><?php echo number_format($kirimjeanspcs,2)?></td>
		          	<td><?php echo number_format($setorjeansjml,2)?></td>
		          	<td><?php echo number_format($setorjeansdz,2)?></td>
		          	<td><?php echo number_format($setorjeanspcs,2)?></td>
		          	<td><?php echo number_format($setorkaosjml,2)?></td>
		          	<td><?php echo number_format($setorkaosdz,2)?></td>
		          	<td><?php echo number_format($setorkaospcs,2)?></td>
		          	<td><?php echo number_format($stokakhirkaosjml,2)?></td>
		          	<td><?php echo number_format($stokakhirkaosdz,2)?></td>
		          	<td><?php echo number_format($stokakhirkaospcs,2)?></td>
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
		            <th colspan="2">Kirim Kemeja</th>
		            <th colspan="2">Setor Kemeja</th>
		            <th colspan="2">Stok Akhir Kemeja</th>
		          </tr>
		          <tr>
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
		              <td><?php echo ($p['setorkemejajml'])?></td>
		              <td><?php echo $p['setorkemejadz']>0?number_format($p['setorkemejadz']):'';?></td>
		              <td><?php echo ($p['stokakhirkemejajml'])?></td>
		              <td><?php echo $p['stokakhirkemejadz']>0?number_format($p['stokakhirkemejadz']):'';?></td>
		            </tr>
		            <?php 
		        		$kirimkemejajml+=($p['kirimkemejajml']);
		        		$kirimkemejadz+=($p['kirimkemejadz']);
		        		$setorkemejajml+=($p['setorkemejajml']);
		        		$setorkemejadz+=($p['setorkemejadz']);
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
<script>
	function filtertglonly_pot(){
		var url='?';
		var tanggal1 =$("#tanggal1").val();
		var tanggal2 =$("#tanggal2").val();
		if(tanggal1){
		url+='&tanggal1='+tanggal1;
		}
		if(tanggal2){
		url+='&tanggal2='+tanggal2;
		}

		var tanggal1_pot =$("#tanggal1_pot").val();
		var tanggal2_pot =$("#tanggal2_pot").val();
		if(tanggal1_pot){
		url+='&tanggal1_pot='+tanggal1_pot;
		}
		if(tanggal2_pot){
		url+='&tanggal2_pot='+tanggal2_pot;
		}

		location =url;
	}
</script>