<form action="<?php echo $action ?>" method="POST">
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Tanggal</label>
            <input type="text" class="form-control datepicker" name="tanggal" value="<?php echo date('Y-m-d')?>" placeholder="Tanggal" required>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Divisi / Cabang</label>
            <select class="form-control select2bs4" name="kategoriPengajuan" data-live-search="true" required>
                <option value="">Pilih</option>
                <?php foreach ($katpeng as $key => $value): ?>
                    <option value="<?php echo $key ?>"><?php echo $value ?></option>
                <?php endforeach ?>
            </select>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label>Keterangan</label>
            <textarea name="keterangan" class="form-control"></textarea>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <cation>Daftar Ajuan</caption>
            <table class="table table-bordered" id="itemajaun">
                <tr>
                    <th>Nama Item</th>
                    <th>Jumlah Barang</th>
                    <th>Satuan</th>
                    <th>Harga</th>
                    <th>Jenis Pemb.</th>
                    <th>Supplier</th>
                    <th>Keterangan</th>
                    <th>
                        <button type="button" name="add" class="btn btn-success btn-sm itemajaun" onclick="itemajaun()"><i class="fa fa-plus"></i></button>
                    </th>
                </tr>
            </table>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <a href="<?php echo $batal?>" class="btn btn-sm btn-danger" style="width: 100%">Batal</a>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <button type="submit" class="btn btn-info btn-sm" style="width: 100%">Simpan</button>
        </div>
    </div>
</div>
</form>
<script type="text/javascript">
    var i=0;
    function itemajaun(){
        
        var html='';
        html+='<tr>';
        //html+='<td><input type="text" value="" class="form-control" name="products['+i+'][nama_item]" required></td>';
        html+='<td><select type="text" data-dropup-auto="false" data-size="5" class="form-control brg select2bs4" data-live-search="true" data-title="pilih item" name="products['+i+'][nama_item]" required><option value="">Pilih Barang / Item</option><?php foreach ($products as $key => $item) { ?><option value="<?php echo $item['nama'] ?>" data-item="<?php echo $item['product_id'] ?>"><?php echo strtolower($item['nama']) ?></option><?php } ?></select></td>';
        html += '<td><input type="number" size="10" class="form-control jumlah" step=0.01 name="products['+i+'][jumlah]" onblur="updatetotal('+i+')" required></td>';
        html += '<td><input type="text" size="10" value="-" class="form-control" name="products['+i+'][satuan]"></td>';
        html += '<td><input type="number" size="12" class="form-control harga" name="products['+i+'][harga]" onblur="updatetotal('+i+')" value="0"></td>';
        //html+='<td><span class="total-'+i+'"></span></td>';
        html += '<td><select name="products['+i+'][pembayaran]" class="form-control" required><option value="-"></option><option value="1">Cash</option><option value="2">Transfer</option></select></td>';
        //html += '<td><input type="text" value="-" class="form-control" name="products['+i+'][supplier]"></td>';
        html+='<td><select type="text" data-dropup-auto="false" data-size="5" class="form-control brg" data-live-search="true" data-title="pilih item" name="products['+i+'][supplier]" required><option value="-">-</option><?php foreach (table('master_supplier') as $key => $item) { ?><option value="<?php echo $item['nama'] ?>"><?php echo $item['nama'] ?></option><?php } ?></select></td>';
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
                dai.find(".harga").val(obj.price);
            });
        });
    }

$(document).ready(function(){


    $(document).on('click', '.remove', function(){

        $(this).closest('tr').remove();

    });

    

});

 </script>