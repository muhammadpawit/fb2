<form method="post" action="<?php echo $action ?>">
	<input type="hidden" name="id" value="<?php echo $prods['id'] ?>">
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<label>Nama Barang</label>
				<select name="id_persediaan" class="form-control select2bs4" disabled readonly>
					<?php foreach($barang as $b){ ?>
						<option value="<?php echo $b['id_persediaan']?>"
							<?php echo $b['id_persediaan']==$prods['id_persediaan']?'selected':'';?>><?php echo $b['nama_item']?></option>
					<?php } ?>
				</select>
			</div>
		</div>
	</div>
</form>