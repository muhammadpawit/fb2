<?php if(!isset($design)){ ?>
<form method="post" action="<?php echo $editsave?>">
	<input type="hidden" name="id" value="<?php echo $detail['id_produksi_po']?>">
	<div class="row">
	<div class="col-md-12">
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>Kode Artikel</th>
					<th>:</th>
					<th><input type="text" name="kode_artikel" value="<?php echo $detail['kode_artikel']?>" class="form-control"></th>
				</tr>	
				<tr>
					<th>Nama PO</th>
					<th>:</th>
					<td>
						<select class="form-control selectpicker select2bs4" name="namaPO" data-title="Pilih Jenis PO" data-live-search="true">
                            <?php foreach ($namapo as $key => $nama): ?>
                                <option value="<?php echo $nama['nama_jenis_po'] ?>" <?php echo (strtolower($nama['nama_jenis_po'])==strtolower($detail['nama_po']))?'selected':''; ?>><?php echo $nama['nama_jenis_po'] ?></option>
                            <?php endforeach ?>
                        </select>
					</td>
				</tr>			
				<tr>
					<th>Kode PO</th>
					<th>:</th>
					<th>
						<input type="text" name="kode_po" value="<?php echo $detail['kode_po']?>" class="form-control">		
					</th>
				</tr>
				<tr>
					<th>Serian PO</th>
					<th>:</th>
					<th>
						<input type="text" name="serian" value="<?php echo $detail['serian']?>" class="form-control">		
					</th>
				</tr>
				<tr>
					<th>Nama Hpp PO</th>
					<th>:</th>
					<th>
						<input type="text" name="nama_hpp" value="<?php echo $detail['nama_hpp']?>" class="form-control">
					</th>
				</tr>
				<tr>
					<th>Jenis PO</th>
					<th>:</th>
					<th>
						<select name="jenis_po" class="form-control select2bs4" data-live-search="true">
							<?php foreach($jenis as $j){?>
							<option value="<?php echo $j['nama_jenis_kaos']?>" <?php echo $j['nama_jenis_kaos']==$detail['jenis_po']?'selected':'';?>><?php echo $j['nama_jenis_kaos']?></option>
							<?php } ?>
						</select>
						
					</th>
				</tr>
				<tr>
					<th>HPP (Rp)</th>
					<th>:</th>
					<th>
						<?php //echo number_format($detail['harga_satuan'])?>
						<input type="text" name="harga_satuan" value="<?php echo $detail['harga_satuan']?>" class="form-control" readonly>			
					</th>
				</tr>
				<tr>
					<th>Kode PO Sistem Lama</th>
					<th>:</th>
					<td>
						<select class="form-control selectpicker select2bs4" name="idpolama" data-title="Pilih PO" data-live-search="true">
                            <?php foreach ($polama as $key => $nama): ?>
                                <option value="<?php echo $nama['id_produksi_po'] ?>" <?php echo (strtolower($nama['id_produksi_po'])==strtolower($detail['idpolama']))?'selected':''; ?>><?php echo $nama['kode_po'] ?></option>
                            <?php endforeach ?>
                        </select>
					</td>
				</tr>
			</thead>
		</table>
	</div>
	<div class="col-md-6">
		
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<a href="<?php echo $batal?>" class="btn btn-danger btn-sm">Kembali</a>
		<button class="btn btn-info btn-sm">Simpan</button>
	</div>
</div>
</form>
<?php }else {?>
	<div class="row">
		<div class="col-md-12">
			<table class="table table-bordered">
			<thead>
				<tr align="center">
					<th colspan="2">Gambar Depan</th>
					<th colspan="2">Gambar Belakang</th>
				</tr>
				<tr>
					<th colspan="2" align="center">
						<img src="<?php echo BASEURL.$detail['gambar_po'] ?>" class="image img-responsive" style="height:350px;">
                                        <form action="<?php echo BASEURL.'Kelolapo/submitImageHppsat' ?>" enctype="multipart/form-data" method="POST">
                                                    <input type="file" name="gambarPO1" class="form-control">

                                                    <input type="hidden" name="kode_po" value="<?php echo $detail['kode_po'] ?>">

                                              	<br>

                                                    <button type="submit" class="btn btn-warning"> SUBMIT</button>


                                        </form>
					</th>
					<th colspan="2" align="center">
						<img src="<?php echo BASEURL.$detail['gambar_po2'] ?>" class="image img-responsive" style="height: 350px;">
                                         <form action="<?php echo BASEURL.'Kelolapo/submitImageHppdua' ?>" enctype="multipart/form-data" method="POST">
                                                    <input type="file" name="gambarPO2" class="form-control">

                                                    <input type="hidden" name="kode_po" value="<?php echo $detail['kode_po'] ?>">

                                              	<br>

                                                    <button type="submit" class="btn btn-warning"> SUBMIT</button>


                                        </form>
					</th>
				</tr>
				
			</thead>
		</table>
		</div>
	</div>
<form method="post" action="<?php echo $editsave ?>">
	<div class="row">
		<div class="col-md-12">
			<table class="table table-bordered">
				<thead>
					<tr>
								<th>Bagian</th>
								<th>Spesifikasi</th>
								<th width="15"><a onclick="addspek()" class="btn btn-info"><i class="fa fa-plus"></i></a></th>
							</tr>
				</thead>
							<tbody id="speklist">
								<?php $i=0;?>
								 <?php if(!empty($spek)){ ?>
                                       <?php foreach($spek as $s){ ?>
                                       	<tr>
                                       		<td><input type="text" class="form-control" name="kolom[<?php echo $i ?>][kolom]" value="<?php echo $s['kolom']?>"></td>
                                       		<td><input type="text" class="form-control" name="kolom[<?php echo $i ?>][isi]" value="<?php echo $s['isi']?>"></td>
                                       		<td><i class="fa fa-trash remove"></i></td>
                                       	</tr>
                                       <?php } ?>
                                 <?php } ?>
							</tbody>
						</table>
		</div>
		<div class="col-md-12">
			<a href="<?php echo $batal?>" class="btn btn-danger btn-sm">Kembali</a>
			<button class="btn btn-info btn-sm">Simpan</button>
		</div>
	</div>
	<input type="hidden" name="id" value="<?php echo $detail['id_produksi_po']?>">
</form>

<script type="text/javascript">
	var i='<?php echo count($spek) ?>';

	function addspek(){
		var html ='<tr>';

		html +='<td><input name="kolom['+i+'][kolom]" class="form-control"></td>';
		html +='<td><input name="kolom['+i+'][isi]" class="form-control"></td>';
		html+='<td><i class="fa fa-trash remove"></i></td>';
		i++;
		$("#speklist").append(html);

		html +='</tr>';
	}

	$(document).on('click', '.remove', function(){

    $(this).closest('tr').remove();

});
</script>
<?php } ?>