<form method="post" action="<?php echo $action?>">
	<input type="hidden" name="idcmt" value="<?php echo $c['id_cmt']?>">
	<div class="row">
		<div class="col-md-6 col-12">
			<div class="form-group">
				<table class="table table-bordered">
					<thead>
						<!-- <tr>
							<th>Nama PO</th>
							<th>Harga Lama</th>
							<th>Harga Baru</th>
							<th>Keterangan</th>
							<th>
								<a onclick="add()" class="btn btn-info btn-sm text-white"><i class="fa fa-plus"></i></a>
							</th>
						</tr> -->
					</thead>
					<tbody id="list"></tbody>
					<tfoot>
						<tr>
							<td colspan="5" align="right"><a onclick="add()" class="btn btn-info btn-sm text-white"><i class="fa fa-plus"></i></a> <button>Simpan</button></td>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
		<div class="col-md-6 col-12">
			<table style="width: 100%;border:1px solid black" cellpadding="5">
            <thead>
                <tr style="background-color: #adffc5;width: 100%;border:1px solid black">
                    <td colspan="5" align="center">Daftar Harga <?php echo $c['cmt_name']?></td>
                </tr>
               	<tr>
                    <th>No</th>
                    <th>Nama PO</th>
                    <th>Harga Lama/Dz</th>
                    <th>Harga Baru/Dz</th>
                    <th>Ket</th>
                </tr>
            </thead>
            <tbody>
                <?php $number=1;?>
                <?php foreach(daftarharga_cmt($id) as $r){?>
                    <tr>
                        <td><?php echo $number++?></td>
                        <td><?php echo $r['namapo']?></td>
                        <td><?php echo number_format($r['hargalama'])?></td>
                        <td><?php echo number_format($r['hargabaru'])?></td>
                        <td><?php echo $r['keterangan']?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
		</div>
	</div>
</form>
<script type="text/javascript">
	var i=0;
	function add(){
		var html='';
			html+='<tr>';
			html+='<td colspan="5"><select name="products['+i+'][ongkos]" class="form-control ongkos" data-live-search="true"><option value="">Pilih</option><?php foreach($ongkos as $o){?><option value="<?php echo $o['nama_job']?>" data-item="<?php echo $o['id']?>"><?php echo $o['nama_job']?></option><?php } ?></select><input type="text" name="products['+i+'][namapo]" class="form-control nama" placeholder="Nama PO">harga lama<input type="number" name="products['+i+'][hargalama]" class="form-control hargalama" placeholder="Harga Lama">harga baru<input type="number" name="products['+i+'][hargabaru]" class="form-control harga" placeholder="Harga Baru">ket<input type="text" name="products['+i+'][keterangan]" class="form-control keterangan" placeholder="Keterangan"><i class="fa fa-trash remove"></i></td>';
			//html+='<td><input type="text" name="products['+i+'][hargalama]" class="form-control"></td>';
			//html+='<td><input type="text" name="products['+i+'][hargabaru]" class="form-control"></td>';
			//html+='<td><input type="text" name="products['+i+'][keterangan]" class="form-control"></td>';
			//html+='<td><i class="fa fa-trash remove"></i></td>';
			html+='</tr>';
			$('#list').append(html);
			i++;
			$(".ongkos").selectpicker('refresh');
			$(document).on('change', '.ongkos', function(e){
            var dataItem = $(this).find(':selected').data('item');
            var dai = $(this).closest('tr');
            $.get( "<?php echo BASEURL.'Masterdata/json_ongkos' ?>", { id: dataItem } )
              .done(function( data ) {
                var obj = JSON.parse(data);
                //console.log(obj);
                //dai.find(".nama").val(obj.nama_job);
                dai.find(".hargalama").val(0);
                dai.find(".harga").val(obj.harga);
                dai.find(".keterangan").val(obj.nama_job);
            });
        });
	}

	$(document).on('click', '.remove', function(){

        $(this).closest('tr').remove();

    });
</script>