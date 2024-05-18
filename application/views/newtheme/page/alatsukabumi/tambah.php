<form method="post" action="<?php echo $simpan ?>">
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<label>Tanggal</label>
				<input type="text" id="tgl" name="tanggal" class="form-control datepicker" value="<?php echo date('Y-m-d')?>">
			</div>
		</div>
	</div>
	<div class="row">
                <div class="col-12">
                    <table class="table table-bordered" id="addbahankeluars">
                      <tr>
                        <th>Nama Barang</th>
                        <th>Jumlah Kirim</th>
                        <th></th>
                        <th>Jumlah Terima</th>
                        <th>Keterangan</th>
                        <th><button type="button" name="add" class="btn btn-success btn-sm addbahankeluars"><i class="fa fa-plus"></i></button></th>
                      </tr>
                    </table>                  
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
$(document).ready(function(){
    var i=0;
    $(document).on('click', '.addbahankeluars', function(){
        var html = '';
        html += '<tr>';
        html += '<td style="display:none;"><input type="hidden" class="form-control id" name="products['+i+'][idpersediaan]" ><input type="hidden" class="form-control harga" name="products['+i+'][harga]" ></td>';
        html += '<td><select type="text" class="form-control barang select2bs4" name="products['+i+'][nama]" data-live-search="true" data-title="Pilih item" required><option value="">Pilih</option><?php foreach ($barang as $key => $item) { ?><option value="<?php echo $item['nama_item'] ?>" data-item="<?php echo $item['id_persediaan'] ?>"><?php echo $item['nama_item'] ?></option><?php } ?></select></td>';
        html += '<td><input type="number" class="form-control jumlah" name="products['+i+'][jumlah]" readonly ></td>';
        html += '<td><span class="stn"></span><input type="hidden" class="form-control satuanJml" name="products['+i+'][satuan]" ></td>';
        html += '<td><input type="number" class="form-control terima" name="products['+i+'][terima]" ></td>';
        // html += '<td><input type="text" class="form-control keterangan" name="products['+i+'][keterangan]"></td>';
        html += '<td><textarea name="products['+i+'][keterangan]" class="form-control keterangan"></textarea></td>';
        html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button></td></tr>';
        i++;
        $('#addbahankeluars').append(html);
         //$('.selectpicker').selectpicker('refresh');
        $('.barang').select2();
     });

    $(document).on('click', '.remove', function(){
        $(this).closest('tr').remove();
    });
    $(document).on('change', '.barang', function(e){
        var dataItem = $(this).find(':selected').data('item');
        var dai = $(this).closest('tr');
        var jumlahItem = $('#piecesPo').val();
        var tgl = $("#tgl").val();
        $.get( "<?php echo BASEURL.'Alatsukabumi/cari' ?>", { id: dataItem, tgl:tgl } )
          .done(function( data ) {
            var obj = JSON.parse(data);
            dai.find(".jumlah").val(obj.jumlah);
            dai.find(".satuanJml").val(obj.satuan);
            dai.find(".stn").html(obj.satuan);
            dai.find(".id").val(obj.id);
             dai.find(".keterangan").val(obj.keterangan);
            //dai.find(".harga").val(obj.harga_item);
            // dai.find(".jumlah").attr('max',obj.jumlah_item);
        });
    });
});
 </script> 