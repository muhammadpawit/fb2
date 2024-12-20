<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label>Bulan</label>
			<select name="bulan" id="bulan" class="form-control select2bs4" data-live-search="true">
				<?php foreach(bulan() as $b=>$val){?>
					<option value="<?php echo $b ?>" <?php echo $b==$bulan?'selected':'';?>><?php echo $val ?></option>
				}
				<?php } ?>
			</select>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label>Tahun</label>
			<select name="tahun" id="tahun" class="form-control select2bs4" data-live-search="true">
				<?php foreach(tahun() as $t){?>
					<option value="<?php echo $t['tahun'] ?>" <?php echo $t['tahun']==$tahun?'selected':'';?>><?php echo $t['tahun'] ?></option>
				}
				<?php } ?>
			</select>
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label>Tanggal Awal</label>
			<input type="text" name="tanggal1" id="tanggal1" value="<?php echo $tanggal1?>" class="form-control" autocomplete="off">
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label>Tanggal Akhir</label>
			<input type="text" name="tanggal2" id="tanggal2" value="<?php echo $tanggal2?>" class="form-control" autocomplete="off">
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label>CMT</label>
			<select name="cmt" id="cmt" class="form-control select2bs4" data-live-search="true">
				<option value="*">Pilih</option>
				<?php foreach(cmt() as $t){?>
					<option value="<?php echo $t['id_cmt'] ?>" <?php echo $t['id_cmt']==$cmt?'selected':'';?>><?php echo $t['cmt_name'] ?></option>
				}
				<?php } ?>
			</select>
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label>Aksi</label><br>
			<button onclick="filterbulancmttgl()" class="btn btn-info btn-sm">Filter</button>
			<a href="<?php echo $excel?>" class="btn btn-info btn-sm text-white">Excel</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<?php if(!empty($tanggal1)){ ?>
			<label>Rekap <?php echo $cmtnya?> Tanggal : <?php echo date('d F Y',strtotime($tanggal1)) ?> s.d <?php echo date('d F Y',strtotime($tanggal2)) ?></label>
		<?php }else{ ?>
				<label>Rekap <?php echo $cmtnya?> Bulan : <?php echo $bln ?> <?php echo $tahun ?></label>
		<?php } ?>
	</div>
</div>
<!-- <div class="row">
	<div class="col-md-6">
		<caption>CMT KEMEJA</caption>
		    <table class="table table-bordered">
		        <thead style="text-align: center;">
		          <tr>
		            <th rowspan="2">No</th>
		            <th rowspan="2">Nama CMT</th>
		            <th colspan="2">Stok Awal Kaos</th>
		            <th colspan="2">Stok Awal Kemeja</th>
		            <th colspan="2">Kirim Kaos</th>
		            <th colspan="2">Kirim Kemeja</th>
		            <th colspan="2">Setor Kaos</th>
		            <th colspan="2">Setor Kemeja</th>
		            <th colspan="2">Stok Akhir Kaos</th>
		            <th colspan="2">Stok Akhir Kemeja</th>
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
		              <td><?php echo ($p['stokawalkaosjml'])?></td>
		              <td><?php echo $p['stokawalkaosdz']>0?number_format($p['stokawalkaosdz']):'';?></td>
		              <td><?php echo ($p['stokawalkemejajml'])?></td>
		              <td><?php echo $p['stokawalkemejadz']>0?number_format($p['stokawalkemejadz']):'';?></td>
		              <td><?php echo ($p['kirimkaosjml'])?></td>
		              <td><?php echo $p['kirimkaosdz']>0?number_format($p['kirimkaosdz']):'';?></td>
		              <td><?php echo ($p['kirimkemejajml'])?></td>
		              <td><?php echo $p['kirimkemejadz']>0?number_format($p['kirimkemejadz']):'';?></td>
		              <td><?php echo ($p['setorkaosjml'])?></td>
		              <td><?php echo $p['setorkaosdz']>0?number_format($p['setorkaosdz']):'';?></td>
		              <td><?php echo ($p['setorkemejajml'])?></td>
		              <td><?php echo $p['setorkemejadz']>0?number_format($p['setorkemejadz']):'';?></td>
		              <td><?php echo ($p['stokakhirkaosjml'])?></td>
		              <td><?php echo $p['stokakhirkaosdz']>0?number_format($p['stokakhirkaosdz']):'';?></td>
		              <td><?php echo ($p['stokakhirkemejajml'])?></td>
		              <td><?php echo $p['stokakhirkemejadz']>0?number_format($p['stokakhirkemejadz']):'';?></td>
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
		          	<td><?php echo number_format($stokawalkaosjml,2)?></td>
		          	<td><?php echo number_format($stokawalkaosdz,2)?></td>
		          	<td><?php echo number_format($stokawalkemejajml,2)?></td>
		          	<td><?php echo number_format($stokawalkemejadz,2)?></td>
		          	<td><?php echo number_format($kirimkaosjml,2)?></td>
		          	<td><?php echo number_format($kirimkaosdz,2)?></td>
		          	<td><?php echo number_format($kirimkemejajml,2)?></td>
		          	<td><?php echo number_format($kirimkemejadz,2)?></td>
		          	<td><?php echo number_format($setorkaosjml,2)?></td>
		          	<td><?php echo number_format($setorkaosdz,2)?></td>
		          	<td><?php echo number_format($setorkemejajml,2)?></td>
		          	<td><?php echo number_format($setorkemejadz,2)?></td>
		          	<td><?php echo number_format($stokakhirkaosjml,2)?></td>
		          	<td><?php echo number_format($stokakhirkaosdz,2)?></td>
		          	<td><?php echo number_format($stokakhirkemejajml,2)?></td>
		          	<td><?php echo number_format($stokakhirkemejadz,2)?></td>
		          </tr>
		        </tbody>
		    </table>
	</div>
</div> -->
<div class="row">
	<div class="col-md-12">
		<table class="table table-bordered table-hover">
			<thead class="thead-light">
				<tr>
					<th rowspan="2" style="vertical-align: middle;text-align: center;">Nama PO</th>
					<th colspan="3" style="vertical-align: middle;text-align: center;background-color: #1db4f5 !important">Rekap Kirim CMT</th>
					<th colspan="3" style="vertical-align: middle;text-align: center;background-color:#f5a91d !important">Rekap Setor CMT</th>
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
				<?php $jml1=0;$jml2=0;$kirimdz=0;$kirimpcs=0;$setordz=0;$setorpcs=0;?>
				<?php foreach($products as $p){?>
					<?php if($p['jmlkirim']>0 || $p['jmlsetor'] > 0){ ?>
					<?php 
						$jml1+=($p['jmlkirim']);
						$jml2+=($p['jmlsetor']);
						$kirimdz+=($p['kirimdz']);
						$kirimpcs+=($p['kirimpcs']);
						$setordz+=($p['setordz']);
						$setorpcs+=($p['setorpcs']);
						?>
					<tr>
						<td><?php echo $p['nama']?></td>
						<td align="center"><?php echo $p['jmlkirim']?></td>
						<td align="center"><?php echo number_format($p['kirimdz'],2)?></td>
						<td align="center"><?php echo number_format($p['kirimpcs'])?></td>
						<td align="center"><?php echo $p['jmlsetor']?></td>
						<td align="center"><?php echo number_format($p['setordz'],2)?></td>
						<td align="center"><?php echo number_format($p['setorpcs'])?></td>
						<td></td>
					</tr>
				<?php } ?>
				<?php } ?>
			</tbody>
			<tfoot>
				<tr>
					<td align="center"><b>Total</b></td>
					<td align="center"><b><?php echo $jml1 ?></b></td>
					<td align="center"><b><?php echo number_format($kirimdz,2)?></b></td>
					<td align="center"><b><?php echo number_format($kirimpcs)?></b></td>
					<td align="center"><b><?php echo $jml2?></b></td>
					<td align="center"><b><?php echo number_format($setordz,2)?></b></td>
					<td align="center"><b><?php echo number_format($setorpcs)?></b></td>
					<td></td>
				</tr>
				<tr>
					<td colspan="2"><b>Di update terakhir</b></td>
					<td colspan="6">
						<?php if(!empty($log)){ ?>
							<b>Tanggal : <?php echo date('d F Y',strtotime($log['created_date'])) ?></b>
						<?php } ?>
					</td>
				</tr>
			</tfoot>
		</table>
	</div>
</div>
<script type="text/javascript">
	function filterbulancmttgl(){
	    var url='?';
	    var tanggal1 =$("#tanggal1").val();
	    var tanggal2 =$("#tanggal2").val();
	    var bulan =$("#bulan").val();
	    var tahun =$("#tahun").val();
	    var cmt =$("#cmt").val();
	    if(cmt=="*"){
	    	url+='&cmt=all';
	    }
	    if(tanggal1){
	      url+='&tanggal1='+tanggal1;
	    }
	    if(tanggal2){
	      url+='&tanggal2='+tanggal2;
	    }
	    if(bulan){
	      url+='&bulan='+bulan;
	    }
	    if(tahun){
	      url+='&tahun='+tahun;
	    }
	    if(cmt!='*'){
	      url+='&cmt='+cmt;
	    }
	    location =url;
	  }
</script>