<form method="POST" action="<?php echo $action?>">
<input type="hidden" name="bagian" value="<?php echo $type ?>">
<div class="row">
    <div class="col-md-12">
            <table class="table table-bordered" id="itemajaun">
                <tr>
                    <th>Nama Barang</th>
                    <th>Kebutuhan</th>
                    <th>Stok</th>
                    <th>Ajuan</th>
                    <th>Satuan</th>
                    <th>Tanggal Ajuan</th>
                    <th>Supplier</th>
                    <th>Keterangan</th>
                    <th width="20">
                        <button type="button" name="add" class="btn btn-success btn-sm itemajaun" onclick="itemajaun()"><i class="fa fa-plus"></i></button>
                    </th>
                </tr>
            </table>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <button class="btn btn-primary full btn-sm">Simpan</button>
    </div>
    <div class="col-md-6">
        <a href="<?php echo $cancel ?>" class="btn btn-danger btn-sm full">Batal</a>
    </div>
</div>
</form>

<script type="text/javascript">
    var i=0;
    function itemajaun(){
        
        var html='';
        html+='<tr>';
        //html+='<td><input type="text" value="" class="form-control" name="products['+i+'][nama_item]" required></td>';
        html+='<td width="300"><select type="text" data-dropup-auto="false" data-size="5" class="form-control brg select2bs4" data-live-search="true" data-title="pilih item" name="products['+i+'][nama_item]" required><option value="">Pilih Barang / Item</option><?php foreach ($products as $key => $item) { ?><option value="<?php echo $item['nama'] ?>" data-item="<?php echo $item['product_id'] ?>"><?php echo strtolower($item['nama']) ?></option><?php } ?></select></td>';
        html += '<td><input type="hidden" size="10" class="form-control product_id" name="products['+i+'][product_id]"> <input type="text" size="10" class="form-control jumlah" name="products['+i+'][kebutuhan]" required></td>';
        html += '<td><input type="text" size="10" class="form-control stok" name="products['+i+'][stok]" required readonly></td>';
        html += '<td><input type="number" size="12" class="form-control ajuan" name="products['+i+'][ajuan]" value="0" readonly></td>';
        html += '<td><input type="text" size="10" class="form-control satuan" name="products['+i+'][satuan]"></td>';
        //html+='<td><span class="total-'+i+'"></span></td>';
        //html += '<td><select name="products['+i+'][pembayaran]" class="form-control" required><option value="-"></option><option value="1">Cash</option><option value="2">Transfer</option></select></td>';
        html += '<td><input type="text" value="<?php echo date('Y-m-d') ?>" class="form-control datepicker" readonly name="products['+i+'][tanggal]"></td>';
        html+='<td width="200"><select type="text" data-dropup-auto="false" data-size="5" class="form-control brg select2bs4" data-live-search="true" data-title="pilih item" name="products['+i+'][supplier_id]" required><option value="0">Pilih Supplier</option><?php foreach ($supplier as $key => $item) { ?><option value="<?php echo $item['id'] ?>"><?php echo strtolower($item['nama']) ?></option><?php } ?></select></td>';
        html+='<td><textarea class="form-control" name="products['+i+'][keterangan]"></textarea></td>';
        html+='<td><i class="fa fa-trash remove"></i></td>';
        html+='</tr>';
        $('#itemajaun').append(html);

        i++;
        //$(".brg").selectpicker('refresh');
        $.fn.datepicker.defaults.format = "yyyy-mm-dd";
        $('.datepicker').datepicker({
            autoclose: true,
        });

        $('.select2bs4').select2();
        $(document).on('change', '.brg', function(e){
            var dataItem = $(this).find(':selected').data('item');
            var dai = $(this).closest('tr');
            var jumlahItem = $('#piecesPo').val();
            var type = '<?php echo $type ?>';
            $.get( "<?php echo BASEURL.'Ajuanalatalat/cariproduct_stok' ?>", { id: dataItem } )
              .done(function( data ) {
                var obj = JSON.parse(data);
                console.log(obj);
                dai.find(".satuan").val(obj.satuan);
                dai.find(".stok").val(obj.quantity);
                dai.find(".product_id").val(obj.product_id);
            });
        });
    }

$(document).ready(function(){


    $(document).on('click', '.remove', function(){

        $(this).closest('tr').remove();

    });

    

});

 </script>