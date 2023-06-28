<div class="row">
    <div class="col-md-12">
    	<?php if ($this->session->flashdata('msgt')) { ?>
	    <div class="alert alert-danger alert-dismissible fade show" role="alert">
	     	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
	        	<span aria-hidden="true">×</span>
	        </button>
			<?php echo $this->session->flashdata('msgt'); ?> 
	    </div>
	    <?php } ?>
    </div>
</div>
<form method="post" action="<?php echo $action?>">
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label>Tanggal</label>
				<input type="text" name="tanggal" class="form-control" value="<?php echo date('Y-m-d')?>" required>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label>CMT</label>
				<select name="cmt" class="form-control select2bs4" data-live-search="true" required>
					<option value="">Pilih</option>
					<?php foreach($cmt as $c){?>
						<option value="<?php echo $c['id_cmt'] ?>"><?php echo strtolower($c['cmt_name']);?></option>
					<?php } ?>
				</select>
				<input type="hidden" name="keterangan" class="form-control">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="table-responsive">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>Kode PO</th>
							<th>Keterangan</th>
							<th style="text-align: right !important;"><a onclick="adds()" class="btn btn-sm btn-info text-white"><i class="fa fa-plus"></i></a></th>
						</tr>
					</thead>
					<tbody id="list">

					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<button type="submit" class="btn btn-info btn-sm text-white">Simpan</button>
			<a href="<?php echo $cancel?>" class="btn btn-danger btn-sm text-white">Batal</a>
		</div>
	</div>
</form>
<script type="text/javascript">
	var i=0;
	function adds(){
		var html = '';
        html += '<tr>';
        html += '<td><select type="text" class="form-control selectpicker kodepo" name="products['+i+'][kode_po]" data-size="4" data-live-search="true" data-title="Pilih item" required><option value="">Pilih</option><?php foreach ($kodepo as $key => $po) { ?><option value="<?php echo $po['kode_po'] ?>" data-item="<?php echo $po['kode_po'] ?>"><?php echo $po['nama_po'].' '.$po['kode_po'] ?></option><?php } ?></select></td>';
		//html+="<td><input type='text' name='products["+i+"][keterangan]' class='form-control' value='-'></td>";
		html += '<td><select class="form-control selectpicker" name="products['+i+'][keterangan]"><?php foreach ($ket as $k): ?><option value="<?php echo $k['id'] ?>"><?php echo $k['nama'] ?></option><?php endforeach ?></select></td>';
		html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button></td></tr>';
        html+="</tr>";
       	i++;
        $('#list').append(html);
        $('.selectpicker').select2();
	}

	$(document).on('click', '.remove', function(){
	    $(this).closest('tr').remove();
	});
</script>