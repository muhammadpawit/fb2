<div class="row">
	<div class="col-md-2">
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
	<div class="col-md-2">
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
			<label>CMT</label>
			<select name="cmt" id="cmt" class="form-control select2bs4" data-live-search="true">
				<option value="*">Semua</option>
				<?php foreach($datacmt as $t){?>
					<option value="<?php echo $t['id_cmt'] ?>" <?php echo $t['id_cmt']==$cmt?'selected':'';?>><?php echo $t['cmt_name'] ?></option>
				}
				<?php } ?>
			</select>
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label>Aksi</label><br>
			<button onclick="filterbulancmt()" class="btn btn-info btn-sm">Filter</button>
			<a href="<?php echo $excel?>" class="btn btn-info btn-sm text-white">Excel</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<label>Rekap <?php echo $cmtnya?> Bulan : <?php echo $bln ?> <?php echo $tahun ?></label>
	</div>
</div>
<div class="row">
	<?php foreach($products as $pds){?>
	<div class="col-md-12">
		<caption><?php echo $pds['nama']?></caption>
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
				<?php foreach($pds['prods'] as $p){?>
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
						<td align="center"><?php echo $p['kirimpcs']?></td>
						<td align="center"><?php echo $p['jmlsetor']?></td>
						<td align="center"><?php echo number_format($p['setordz'],2)?></td>
						<td align="center"><?php echo $p['setorpcs']?></td>
						<td></td>
					</tr>
				<?php } ?>
			</tbody>
			<tfoot>
				<tr>
					<td align="center"><b>Total</b></td>
					<td align="center"><b><?php echo $jml1 ?></b></td>
					<td align="center"><b><?php echo number_format($kirimdz,2)?></b></td>
					<td align="center"><b><?php echo $kirimpcs?></b></td>
					<td align="center"><b><?php echo $jml2?></b></td>
					<td align="center"><b><?php echo number_format($setordz,2)?></b></td>
					<td align="center"><b><?php echo $setorpcs?></b></td>
					<td></td>
				</tr>
			</tfoot>
		</table>
	</div>
	<?php } ?>
</div>