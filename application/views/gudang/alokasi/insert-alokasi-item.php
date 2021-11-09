<link href="<?php echo PLUGINS ?>bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" />

<!-- Start Page content -->
<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">

                <div class="card-box">
                    <h4 class="header-title m-t-0 m-b-20">Tambah PO</h4>
                    <hr>
                   <form action="<?php echo BASEURL.'alokasi/insertAlokasiItemAct' ?>" method="POST">
                        <input type="hidden" name="idalokasi" value="<?php echo $po['id_alokasi'] ?>">
                        <div class="form-group">
                        	<label>Nama PO</label>
                        	<select class="form-control" name="namaPo" required>
                        			<option value="<?php echo $po['nama_jenis_po'] ?>"><?php echo $po['nama_jenis_po'] ?></option>
                        	</select>
                        </div>
                        <div class="form-group">
                            <label>Size PO</label>
                            <select class="form-control" name="size" required>
                        		<option value="<?php echo $po['id_master_size'] ?>"><?php echo $po['nama_size'] ?></option>
                        	</select>
                        </div>
                        <table class="table table-bordered" id="item_table">
                            <tr>
                                <th>Nama Barang</th>
                                <th>Satuan</th>
                                <th>Jumlah</th>
                                <th><button type="button" name="add" class="btn btn-success btn-sm add" ><i class="fa fa-plus"></i></button></th>
                            </tr>
                        </table>
                        <button type="submit" class="btn btn-primary">SUBMIT</button>
                   </form>
                </div>


                </div>
               

            </div>

        </div>
        <!-- end row -->

    </div> <!-- container -->

</div> <!-- content -->
 <script src="<?php echo PLUGINS ?>bootstrap-select/js/bootstrap-select.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
    $(document).on('click', '.add', function(){
        var html = '';
        html += '<tr>';
        html += '<td style="display:none;"><input type="hidden" class="form-control idPersediaan" name="idPersediaan[]" ></td>';
        html += '<td><select type="text" data-dropup-auto="false" data-size="5" class="form-control selectpicker" data-live-search="true" data-title="pilih item" name="nama[]" required><?php foreach ($barang as $key => $item) { ?><option value="<?php echo $item['nama_item'] ?>" data-item="<?php echo $item['id_persediaan'] ?>"><?php echo $item['nama_item'] ?></option><?php } ?></select></td>';
        
        html += '<td><input type="number" class="form-control jumlah" step=0.01 name="jumlah[]" ></td>';
        html += '<td><select class="form-control satuanJml" name="satuanJml[]"><?php foreach ($satuan as $key => $satt): ?><option value="<?php echo $satt['kode_satuan_barang'] ?>"><?php echo $satt['kode_satuan_barang'] ?></option><?php endforeach ?></select></td>';
        html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button></td></tr>';
        $('#item_table').append(html);
        $('.selectpicker').selectpicker('refresh');
     });


    $(document).on('click', '.remove', function(){
        $(this).closest('tr').remove();
    });
    $(document).on('change', '.selectpicker', function(e){
        var dataItem = $(this).find(':selected').data('item');
        var dai = $(this).closest('tr');
        var jumlahItem = $('#piecesPo').val();
        $.get( "<?php echo BASEURL.'gudang/itemkeluarSearchId' ?>", { id: dataItem } )
          .done(function( data ) {
            var obj = JSON.parse(data);
            console.log(obj);
            dai.find(".satuanJml").val(obj.satuan_jumlah_item);
            dai.find(".idPersediaan").val(obj.id_persediaan);
        });
    });
});
</script>