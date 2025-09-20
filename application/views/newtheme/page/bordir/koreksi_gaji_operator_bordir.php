<form method="post" action="<?php echo $action ?>">
	<input type="hidden" name="tanggal_awal" value="<?php echo $tanggal_awal ?>"> 
	<input type="hidden" name="tanggal_akhir" value="<?php echo $tanggal_akhir ?>"> 
	<div class="row">
		<div class="col-md-12">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Tanggal</th>
						<th>Operator</th>
						<th>Mesin</th>
						<th>Jumlah Naik</th>
						<th>Stich</th>
						<th>Total Stich</th>
						<th>X</th>
						<th>Hasil X</th>
						<th>Kepala Mesin</th>
						<th>Perkalian</th>
						<th>Persentase Mesin</th>
						<th>Pendapatan Operator (Rp)</th>
						<th>Total</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					
					$i=0;
					
						$total_stich = 0;
						$jumlah_naik = 0;
						$jumlah_stich = 0;
						$jumlah_total_stich = 0;
						$jumlah_perkalian = 0;
						$jumlah_total = 0;
						$jumlah_x = 0;
						$jumlah_hasil_x = 0;
						$jumlah_gaji = 0;
					?>
					<?php foreach($d as $e){?>
						<?php 
							$pemilik = $this->GlobalModel->QueryManualRow("SELECT b.* FROM master_po_luar a left join pemilik_poluar b on a.idpemilik = b.id WHERE a.id = '".$e['idpo']."' ");	
							$mesin=$this->GlobalModel->getDataRow('master_mesin',array('jenis'=>$e['jenis'],'nomer_mesin'=>$e['mesin_bordir']));
							$total_stich =($e['jumlah_naik_mesin'] * $e['stich']);
							$gaji = ($total_stich *  $pemilik['hasil_x'] * $mesin['persenan'] );
						?>
						<input type="hidden" name="prods[<?php echo $i?>][id]" value="<?php echo $e['id_kelola_mesin_bordir'] ?>">
						<input type="hidden" name="prods[<?php echo $i?>][jenis]" value="<?php echo $e['jenis'] ?>">
						<input type="hidden" name="pemilik" value="<?php echo $pemilik['id'] ?>">
						<?php if(!empty($idpo)){ ?>
							<input type="hidden" name="idpo" value="<?php echo $idpo ?>">
						<?php } ?>
						<tr>
							<td>
								<input type="text" name="prods[<?php echo $i?>][created_date]" class="form-control datepicker" value="<?php echo $e['created_date']?>" size="7">
							</td>
							<td>
								<select class="selectpicker select2bs4" name="prods[<?php echo $i?>][nama_operator]" data-live-search="TRUE" style="width:100%" required>
                                    <?php foreach ($operator as $key => $op): ?>
                                        <option value="<?php echo $op['id_master_karyawan_bordir'] ?>" <?php echo ($op['id_master_karyawan_bordir']==$e['nama_operator'])?'selected':'' ?>><?php echo $op['nama_karyawan_bordir'] ?></option>
                                    <?php endforeach ?>
                                </select>
							</td>
							<td>
								<input type="text" name="prods[<?php echo $i?>][mesin_bordir]" value="<?php echo $e['mesin_bordir']?>" class="form-control" size="4">
							</td>
							<td>
								<input type="text" name="prods[<?php echo $i?>][jumlah_naik_mesin]" value="<?php echo $e['jumlah_naik_mesin']?>" class="form-control" size="9" readonly>
							</td>
							<td>
								<input type="text" name="prods[<?php echo $i?>][stich]" value="<?php echo $e['stich']?>" class="form-control"  readonly>
							</td>
							<td>
								<input type="hidden" name="prods[<?php echo $i?>][total_stich]" value="<?php echo $total_stich ?>">
								<?php echo $total_stich ?>
							</td>
							<td><?php echo $pemilik['hasil_x']?></td>
							<td>
								<?php echo $total_stich * $pemilik['hasil_x']?>
							</td>
							<td align="center"><?php echo $e['kepala']?></td>
							<td>
								<input type="text" size="8" name="prods[<?php echo $i?>][perkalian_tarif]" value="<?php echo $e['perkalian_tarif']?>" class="form-control"  readonly>
							</td>
							<td>
								<?php echo $mesin['persenan'] ?>
							</td>
							<td>
								<input type="hidden" size="8" name="prods[<?php echo $i?>][gaji]" value="<?php echo $gaji ?>">
								<?php echo $gaji ?>
							</td>
							<td>
								<input type="hidden" size="8" name="prods[<?php echo $i?>][total_tarif]" value="<?php echo $e['total_tarif'] ?>">
								<?php echo ($e['total_tarif'])?>
							</td>
						</tr>
						<?php $i++;?>
					<?php } ?>
					<tr>
						<td><button class="btn btn-success full">Simpan</button></td>
						<td><a href="<?php echo $batal?>" class="btn btn-danger full">Batal</a></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</form>
<div class="row">
   <div class="col-md-4">
				<table class="table table-bordered">
					<tr>
						<td colspan="3">
							Keterangan
						</td>
					</tr>
					<tr>
						<td>X</td>
						<td>:</td>
						<td>variabel perhitungan pendapatan operator</td>
					</tr>
					<tr>
						<td>Hasil X</td>
						<td>:</td>
						<td>Didapat dari Total Stich * X</td>
					</tr>
					<tr>
						<td>Pendapatan Operator (Rp)</td>
						<td>:</td>
						<td>
							Total Stich * X * Persentase Mesin
						</td>
					</tr>
				</table>
   </div>
</div>