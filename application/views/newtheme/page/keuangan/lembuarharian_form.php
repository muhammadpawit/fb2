<div class="row">
  <div class="col-md-12">
    <?php if ($this->session->flashdata('msg')) { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
     	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
        	<span aria-hidden="true">×</span>
        </button>
		<?php echo $this->session->flashdata('msg'); ?> 
    </div>
    <?php } ?>
  </div>
</div>
<form method="post" action="<?php echo $action?>">
<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<label>Tanggal</label>
			<input type="text" name="tanggal" class="form-control datepicker">
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>Nama</th>
					<th>Mulai</th>
					<th>Selesai</th>
					<th>Jml Jam Lembur</th>
					<th>Upah / jam</th>
					<th>Keterangan</th>
					<th style="text-align: right;"><a onclick="tambahin()" class="btn btn-info btn-sm text-white"><i class="fa fa-plus"></i></a></th>
				</tr>
			</thead>
			<tbody id="kar">
				
			</tbody>
		</table>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<button class="btn btn-info btn-sm text-white">Simpan</button>
		<a href="<?php echo $batal?>" class="btn btn-sm btn-info btn-danger text-white">Kembali</a>
	</div>
</div>
</form>
<script type="text/javascript">
	var i=0;
	function tambahin(){
		var h="<tr>";
		h +='<td><select name="products['+i+'][idkaryawan]" class="selectpicker form-control" data-live-search="true"><option value="">Pilih</option><?php foreach($karyawan as $k){?><option value="<?php echo $k['id']?>"><?php echo strtolower($k['nama'])?></option><?php } ?></select></td>';
		h +='<td><input type="text" name="products['+i+'][mulai]" class="form-control" value="20:00"></td>';
		h +='<td><input type="text" name="products['+i+'][selesai]" class="form-control"></td>';
		h +='<td><input type="text" name="products['+i+'][jml_jam]" class="form-control"></td>';
		h +='<td><input type="text" name="products['+i+'][upah]" class="form-control"></td>';
		h +='<td><input type="text" name="products['+i+'][keterangan]" class="form-control"></td>';
		h += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button></td></tr>';
		h+="</tr>";
		$("#kar").append(h);
		i++;
		$('.selectpicker').selectpicker('refresh');
	}
</script>