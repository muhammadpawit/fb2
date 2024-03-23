<form method="POST" action="<?php echo $action?>">
<input type="hidden" name="bagian" value="<?php echo $type ?>">
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="">Tanggal</label>
            <input type="text" size="10" class="form-control datepicker" name="utama[0][tanggal]" required readonly>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="">Nama Barang</label>
            <select type="text" data-dropup-auto="false" data-size="5" class="form-control barang select2bs4" data-live-search="true" data-title="pilih item" name="utama[0][nama_item]" required><option value="">Pilih Barang / Item</option><?php foreach ($products as $key => $item) { ?><option value="<?php echo $item['nama'] ?>" data-item="<?php echo $item['product_id'] ?>"><?php echo strtolower($item['nama']) ?></option><?php } ?></select>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label for="">Kebutuhan Barang</label>
            <input type="text" size="10" class="form-control kebutuhan" name="utama[0][kebutuhan]" required>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="">Stok Barang</label>
            <input type="text" size="10" class="form-control stok" id="stok" name="utama[0][stok]" required readonly>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="">Satuan Barang</label>
            <input type="text" size="10" class="form-control" id="satuan" name="utama[0][satuan]" required readonly>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="">Supplier</label>
            <select type="text" data-dropup-auto="false" data-size="5" class="form-control select2bs4" data-live-search="true" data-title="pilih item" name="utama[0][supplier_id]" required><option value="0">Pilih Supplier</option><?php foreach ($supplier as $key => $item) { ?><option value="<?php echo $item['id'] ?>"><?php echo strtolower($item['nama']) ?></option><?php } ?></select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="">Keterangan</label>
            <textarea class="form-control" name="utama[0][keterangan]"></textarea>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="">Pembayaran</label>
            <select name="utama[0][pembayaran]" class="form-control" required><option value="-"></option><option value="1">Cash</option><option value="2">Transfer</option></select>
        </div>
    </div>
</div>
<div class="row">
            <div class="col-md-12">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Nama PO</th>
                    <th>Jumlah PO</th>
                    <th>Rincian PO</th>
                    <th>Jml Pcs</th>
                    <th>Jml Dz</th>
                    <th>Keterangan</th>
                    <th align="right"><a onclick="tambah()" class="btn btn-info btn-sm text-white"><i class="fa fa-plus"></i></a></th>
                  </tr>
                </thead>
                <tbody id="listajuan">
                  
                </tbody>
              </table>
              <div class="form-group">
                <!-- <button type="submit" class="btn btn-info">Simpan</button> -->
              </div>
            </div>
</div>
<div class="row" hidden>
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
                    <th>Pemb</th>
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
        html += '<td><select name="products['+i+'][pembayaran]" class="form-control" required><option value="-"></option><option value="1">Cash</option><option value="2">Transfer</option></select></td>';
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
                // dai.find(".satuan").val(obj.satuan);
                // dai.find(".stok").val(obj.quantity);
                // dai.find(".product_id").val(obj.product_id);
                $("#satuan").val(obj.satuan);
                $("#stok").val(obj.quantity);
                dai.find(".product_id").val(obj.product_id);
            });
        });
    }

$(document).ready(function(){


    $(document).on('click', '.remove', function(){

        $(this).closest('tr').remove();

    });

    

});


var i=0;
  function tambah() {
    var html='<tr>';
        html+='<td><input type="text" name="products['+i+'][kode_po]" class="form-control" required="required" value="-"></td>';
        html+='<td><input type="text" name="products['+i+'][jumlah_po]" class="form-control" required="required" value="0"></td>';
        html+='<td><textarea cols="50" rows="5" name="products['+i+'][rincian_po]" class="form-control" required="required"></textarea></td>';
        html+='<td><input type="text" name="products['+i+'][jml_pcs]" class="form-control" required="required" value="0"></td>';
        html+='<td><input type="text" name="products['+i+'][jml_dz]" class="form-control" required="required" value="0"></td>';
        html+='<td><textarea cols="50" rows="5" name="products['+i+'][keterangan]" class="form-control" required="required"></textarea></td>';
        html+='<td><i class="fa fa-trash remove"></i></td>';
        html+='</tr>';
        $("#listajuan").append(html);
        //$(".select2bs4").select2();
        i++;
  }

  $(document).on('click', '.remove', function(){

        $(this).closest('tr').remove();

    });

    $(document).on('change', '.barang', function(e){
            var dataItem = $(this).find(':selected').data('item');
            //alert(dataItem);
            var type = '1';
            $.get( "<?php echo BASEURL.'Ajuanalatalat/cariproduct_stok' ?>", { id: dataItem } )
              .done(function( data ) {
                var obj = JSON.parse(data);
                console.log(obj);
                $("#stok").val(obj.quantity);
                $("#satuan").val(obj.satuan);
                $("#stok").attr("readonly",true);
            });
        });


 </script>