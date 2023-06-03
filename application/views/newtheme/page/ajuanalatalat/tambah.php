<form method="POST" action="<?php echo $action?>">
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
                    <th>Keterangan</th>
                    <th width="20">
                        <button type="button" name="add" class="btn btn-success btn-sm itemajaun" onclick="itemajaun()"><i class="fa fa-plus"></i></button>
                    </th>
                </tr>
            </table>
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
        html += '<td><input type="text" size="10" class="form-control jumlah" name="products['+i+'][kebutuhan]" required></td>';
        html += '<td><input type="text" size="10" class="form-control stok" name="products['+i+'][stok]" required></td>';
        html += '<td><input type="number" size="12" class="form-control harga" name="products['+i+'][harga]" value="0"></td>';
        html += '<td><input type="text" size="10" class="form-control satuan" name="products['+i+'][satuan]"></td>';
        //html+='<td><span class="total-'+i+'"></span></td>';
        //html += '<td><select name="products['+i+'][pembayaran]" class="form-control" required><option value="-"></option><option value="1">Cash</option><option value="2">Transfer</option></select></td>';
        //html += '<td><input type="text" value="-" class="form-control" name="products['+i+'][supplier]"></td>';
        html+='<td><select type="text" data-dropup-auto="false" data-size="5" class="form-control select2bs4 brg" data-live-search="true" data-title="pilih item" name="products['+i+'][supplier]" required><option value="-">-</option><?php foreach (table('master_supplier') as $key => $item) { ?><option value="<?php echo $item['nama'] ?>"><?php echo $item['nama'] ?></option><?php } ?></select></td>';
        html+='<td><textarea class="form-control" name="products['+i+'][keterangan]"></textarea></td>';
        html+='<td><i class="fa fa-trash remove"></i></td>';
        html+='</tr>';
        $('#itemajaun').append(html);

        i++;
        //$(".brg").selectpicker('refresh');
        $('.select2bs4').select2();
        $(document).on('change', '.brg', function(e){
            var dataItem = $(this).find(':selected').data('item');
            var dai = $(this).closest('tr');
            var jumlahItem = $('#piecesPo').val();
            $.get( "<?php echo BASEURL.'gudang/cariproduct' ?>", { id: dataItem } )
              .done(function( data ) {
                var obj = JSON.parse(data);
                console.log(obj);
                dai.find(".satuan").val(obj.satuan);
            });
        });
    }

$(document).ready(function(){


    $(document).on('click', '.remove', function(){

        $(this).closest('tr').remove();

    });

    

});

 </script>