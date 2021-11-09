<form method="post" action="<?php echo $action ?>">
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<label>Tanggal</label>
				<input type="text" name="tanggal" class="form-control" placeholder="Tanggal" required>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group">
				<label>Rincian</label>
				<table class="table table-bordered" id="addbahankeluars">
					<tr>
						<th>Nama / Keterangan</th>
						<th>Jumlah</th>
						<th>
							<a class="btn btn-success btn-sm" onclick="addpk()"><i class="fa fa-plus"></i></a>
						</th>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<div class="row">
                <div class="col-12">
                    <div class="form-group">
                      <button type="submit" class="btn btn-success text-white">Simpan</button>
                      <a href="<?php echo $cancel?>" class="btn btn-danger text-white">Batal</a>
                    </div>
                </div>
              </div>
</form>
<script type="text/javascript">
	var i=0;
	function addpk(){
		var html='';
		html += '<tr>';
		html += '<td><input type="text" class="form-control" name="products['+i+'][keterangan]" ></td>';
		html += '<td><input type="number" class="form-control" name="products['+i+'][total]" ></td>';
		html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button></td></tr>';
		html += '</tr>';
		$('#addbahankeluars').append(html);
		i++;
		
	}

	$(document).on('click', '.remove', function(){
        $(this).closest('tr').remove();
    });
</script>