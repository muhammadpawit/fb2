<div class="row">
    <div class="col-md-12 table-responsive">
      <table class="table table-bordered">
        <tr>
          <td colspan="11" align="center"><b>Kebutuhan <?php echo $prods['nama']?></b></td>
        </tr>
        <!-- <tr>
          <td colspan="11" align="center"><b><?php //echo $k['keterangan2']?></b></td>
        </tr> -->
        <tr>
          <td colspan="11">Tanggal : <?php echo date('d-m-Y',strtotime($prods['tanggal']))?></td>
        </tr>
        <tr>
          <td rowspan="2" style="vertical-align: middle;text-align: center;"><b>No</b></td>
          <td rowspan="2" style="vertical-align: middle;text-align: center;"><b>Nama PO</b></td>
          <td rowspan="2" style="vertical-align: middle;text-align: center;"><b>Jumlah PO</b></td>
          <td rowspan="2" style="vertical-align: middle;text-align: center;"><b>Rincian PO</b></td>
          <td colspan="2" style="vertical-align: middle;text-align: center;"><b>Jumlah PO</b></td>
          <td colspan="3" style="vertical-align: middle;text-align: center;"><b>Ajuan </b></td>
          <td rowspan="2" style="vertical-align: middle;text-align: center;"><b>Ket.Satuan</b></td>
          <td rowspan="2" style="vertical-align: middle;text-align: center;"><b>Ket</b></td>
        </tr>
        <tr>
          <td style="vertical-align: middle;text-align: center;font-weight: bold;">PCS</td>
          <td style="vertical-align: middle;text-align: center;font-weight: bold;">DZ</td>
          <td style="vertical-align: middle;text-align: center;font-weight: bold;">Kebutuhan</td>
          <td style="vertical-align: middle;text-align: center;font-weight: bold;">Stok</td>
          <td style="vertical-align: middle;text-align: center;font-weight: bold;">Ajuan</td>
        </tr>
        <?php $i=0;$pcs=0;$dz=0;$jmlpo=0;?>
        <?php foreach($kd as $d){?>
          <tr>
            <td><?php echo $n++?></td>
            <td><?php echo $d['kode_po']?></td>
            <td><?php echo $d['jumlah_po']?> PO</td>
            <td><?php echo $d['rincian_po']?></td>
            <td><?php echo number_format($d['jml_pcs'],1)?></td>
            <td><?php echo number_format($d['jml_dz'],1)?></td>
            <td valign="middle" style="vertical-align: middle !important;text-align: center !important;"><?php echo ($d['jumlah_po']*$d['jml_pcs'])?></td>
            <?php if(0==$i){?>
            <td valign="middle" rowspan="<?php echo count($kd)?>" style="vertical-align: middle !important;text-align: center !important;"><?php echo $prods['stok']?></td>
            <td valign="middle" rowspan="<?php echo count($kd)?>" style="vertical-align: middle !important;text-align: center !important;"><?php echo $prods['ajuan']?></td>
            <td valign="middle" rowspan="<?php echo count($kd)?>" style="vertical-align: middle !important;text-align: center !important;"><?php //echo $prods['keterangan2']?></td>
            <?php } ?>
            <!-- <td>lusinan <?php echo number_format($d['jml_dz'])?></td> -->
            <td><?php echo ($d['keterangan'])?></td>
          </tr>
          <?php $i++?>
          <?php 
            $pcs+=$d['jml_pcs'];
            $dz+=$d['jml_dz'];
            $jmlpo+=($d['jumlah_po']);
          ?>
        <?php } ?>
          <tr style="background-color: #ffe0fb">
            <td colspan="2"><b>Total</b></td>
            <td><b><?php echo $jmlpo?></b></td>
            <td></td>
            <td><b><?php echo $pcs?></b></td>
            <td><b><?php echo $dz?></b></td>
            <td align="center"><b><?php echo $k['ajuan_kebutuhan']?></b></td>
            <td><b><?php //echo $k['stok']?></b></td>
            <td><b><?php //echo $k['jml_ajuan']?></b></td>
            <td></td>
            <td></td>
          <tr>
            <td colspan="11" align="right"><b>Registered by Forboys Production System</b></td>
          </tr>
      </table>
    </div>
</div>

<form method="post" action="<?php echo $action ?>">
	<input type="hidden" name="id" value="<?php echo $prods['id'] ?>">
	<input type="hidden" name="bagian" value="<?php echo $prods['bagian'] ?>">
	<input type="hidden" name="stok" value="<?php echo $prods['stok'] ?>">
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<label>Nama Barang</label><br>
				<!-- <select name="id_persediaan" class="form-control select2bs4" disabled readonly>
					<?php foreach($barang as $b){ ?>
						<option value="<?php echo $b['id_persediaan']?>"
							<?php echo $b['id_persediaan']==$prods['id_persediaan']?'selected':'';?>><?php echo $b['nama_item']?></option>
					<?php } ?>
				</select> -->
				<b><?php echo $prods['nama'] ?></b>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group">
				<label>Stok</label><br>
				<b><?php echo $prods['stok'] ?></b>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group">
				<label>Ajuan</label><br>
				<b><?php echo $prods['ajuan'] ?></b>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group">
				<label>Kebutuhan</label><br>
				<input type="text" name="kebutuhan" value="<?php echo $prods['kebutuhan'] ?>" class="form-control" required>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group">
				<label>Keterangan</label><br>
				<input type="text" name="keterangan" value="<?php echo $prods['keterangan'] ?>" class="form-control">
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group">
				<label>Tanggal Ajuan</label><br>
				<input type="text" name="tanggal" value="<?php echo $prods['tanggal'] ?>" class="form-control datepicker" autocomplete="off">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<button class="btn btn-success btn-sm full">Simpan</button>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<a href="<?php echo $cancel ?>" class="btn btn-danger btn-sm full">Batal</a>
			</div>
		</div>
	</div>
</form>
<h2>Laporan Mingguan Alat-alat Forboys Production</h2>
<div class="table-responsive">
			<table border="1" cellpadding="3" style="border-collapse: collapse;width: 100%" >
				<thead style="text-align: center;">
				  <tr style="text-align: center !important;">
		            <th rowspan="2">No</th>
		            <th rowspan="2">Nama</th>
		            <th rowspan="2">Warna</th>
		            <th rowspan="2">Kode</th>
		            <th colspan="4"><center>Stok</center></th>
		            <th rowspan="2">Satuan</th>
		            <th rowspan="2">Harga</th>
		            <th rowspan="2">Total</th>
		            <th rowspan="2">Ket</th>
		            <th rowspan="2">Barang Masuk Terakhir</th>
		          </tr>
		          <tr style="text-align: center !important;">
				  	<th>Awal </th>
		            <th>Masuk</th>
		            <th>Keluar</th>
		            <th>Stok</th>
		          </tr>
		        </thead>
		        <tbody>
		        	<?php
		        		$stokawalroll=0;
		        		$stokawalyard=0;
		        		$stokmasukroll=0;
		        		$stokmasukyard=0;
		        		$stokkeluarroll=0;
		        		$stokkeluaryard=0;
		        		$stokakhirroll=0;
		        		$stokakhiryard=0;
		        		$total=0;
		        	?>
		        	<?php foreach($prods_rincian as $p){?>
		        		<tr>
		        			<td><?php echo $p['no']?></td>
		        			<td><?php echo strtoupper($p['nama'])?></td>
		        			<td><?php echo $p['warna']?></td>
		        			<td><?php echo $p['kode']?></td>
		        			<td>
								<?php if(!empty($prods['awal'])){ ?>
									<?php echo ($prods['awal'])?>
								<?php } else { ?>
									<?php echo ($p['stokawal'])?>
								<?php } ?>
							</td>
		        			<td>
								<?php //echo ($p['stokmasuk'])?>
								<?php if(!empty($prods['masuk']) || $prods['masuk']!=null){ ?>
									<?php echo ($prods['masuk'])?>
								<?php } else { ?>
									<?php echo ($p['stokmasuk'])?>
								<?php } ?>
							</td>
		        			<td>
								<?php //echo ($p['stokkeluarroll'])?>
								<?php if(!empty($prods['keluar'])){ ?>
									<?php echo ($prods['keluar'])?>
								<?php } else { ?>
									<?php echo ($p['stokkeluarroll'])?>
								<?php } ?>
							</td>
		        			<td><?php echo ($p['stokakhirroll'])?></td>
		        			<td><?php echo $p['satuan']?></td>
		        			<td><?php echo ($p['stokakhirharga'])?></td>
		        			<td><?php echo (($p['stokakhirroll']*$p['stokakhirharga']))?></td>
		        			<td><?php echo $p['ket']?></td>
		        			<td><?php echo $p['masukterakhir']?></td>
		        		</tr>
		        		<?php
			        		$total+=(($p['stokakhirroll']*$p['stokakhirharga']));
			        	?>
		        	<?php } ?>
		        </tbody>
		        <tfoot>
		        	<tr style="background-color: #f0dd0a !important;font-size: 15px;">
		        		<td colspan="10" align="center"><b>Jumlah</b></td>
		        		<!-- <td><?php echo ($stokawalroll)?></td>
		        		<td></td>
		        		<td><?php echo ($stokmasukroll)?></td>
		        		<td></td>
		        		<td><?php echo ($stokkeluarroll)?></td>
		        		<td></td>
		        		<td><?php echo ($stokakhirroll)?></td>
		        		<td></td> -->
		        		<td><?php echo ($total)?></td>
		        		<td></td>
		        		<td></td>
		        	</tr>
		        </tfoot>
			</table>
<table>
</div>