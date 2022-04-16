<form method="post" action="<?php echo $action ?>">
	<input type="hidden" name="kode_po" value="<?php echo $kode_po?>">
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
						<th>Perkalian</th>
						<th>Total</th>
					</tr>
				</thead>
				<tbody>
					<?php $i=0;?>
					<?php foreach($d as $e){?>
						<input type="hidden" name="prods[<?php echo $i?>][id]" value="<?php echo $e['id_kelola_mesin_bordir'] ?>">
						<tr>
							<td>
								<input type="text" name="prods[<?php echo $i?>][created_date]" class="form-control datepicker" value="<?php echo $e['created_date']?>" size="7">
							</td>
							<td>
								<select class="selectpicker select2bs4" name="prods[<?php echo $i?>][nama_operator]" data-live-search="TRUE" required>
                                    <?php foreach ($operator as $key => $op): ?>
                                        <option value="<?php echo $op['id_master_karyawan_bordir'] ?>" <?php echo ($op['id_master_karyawan_bordir']==$e['nama_operator'])?'selected':'' ?>><?php echo $op['nama_karyawan_bordir'] ?></option>
                                    <?php endforeach ?>
                                </select>
							</td>
							<td>
								<input type="text" name="prods[<?php echo $i?>][mesin_bordir]" value="<?php echo $e['mesin_bordir']?>" class="form-control" size="4">
							</td>
							<td>
								<input type="text" name="prods[<?php echo $i?>][jumlah_naik_mesin]" value="<?php echo $e['jumlah_naik_mesin']?>" class="form-control" size="9">
							</td>
							<td>
								<input type="text" name="prods[<?php echo $i?>][stich]" value="<?php echo $e['stich']?>">
							</td>
							<td><?php echo $e['total_stich']?></td>
							<td>
								<input type="text" size="8" name="prods[<?php echo $i?>][perkalian_tarif]" value="<?php echo $e['perkalian_tarif']?>">
							</td>
							<td><?php echo $e['total_tarif']?></td>
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