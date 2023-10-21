<form action="<?php echo $action ?>" method="POST">
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="">Tanggal Penjualan</label>
            <input type="text" value="<?php echo date('Y-m-d') ?>" name="tanggal" class="form-control datepicker" autocomplete="off" required>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label for="">Pilih Marketplace</label>
            <select name="marketplace_id" class="form-control select2bs4" required>
                <option value=""></option>
                <?php foreach($marketplace as $c){ ?>
                    <option value="<?php echo $c['id']?>"><?php echo $c['nama']?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label for="">Pilih Customer</label>
            <select name="customer_id" class="form-control select2bs4" required>
                <option value=""></option>
                <?php foreach($customer as $c){ ?>
                    <option value="<?php echo $c['id']?>"><?php echo $c['nama']?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label for="">Pilih Ekspedisi Pengiriman</label>
            <select name="ekspedisi_id" class="form-control select2bs4" required>
                <option value=""></option>
                <?php foreach($ekspedisi as $c){ ?>
                    <option value="<?php echo $c['id']?>"><?php echo $c['nama']?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label for="">Nomor Resi Pengiriman</label>
            <input type="text" name="no_resi" class="form-control" autocomplete="off" required>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label for="">Biaya Pengiriman Ekspedisi</label>
            <input type="text" name="biaya_pengiriman" class="form-control" autocomplete="off" required>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label>Rincian PO</label>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <table class="table table-bordered" id="listp">
                <thead>
                    <tr>
                        <th>Nama PO</th>
                        <th>Size</th>
                        <th>Harga</th>
                        <th>Quantity</th>
                        <th>Discount</th>
                        <th>Jumlah</th>
                        <th width="10">
                            <a href="javascript:void(0)" class="btn btn-sm btn-success" onclick="add()"><i class="fa fa-plus"></i></a>
                        </th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group"><button class="btn btn-sm btn-success full">Simpan</button></div>
    </div>
    <div class="col-md-6">
        <div class="form-group"><a class="btn btn-sm btn-danger full" href="<?php echo BASEURL.'Penjualan';?>">Batal</a></div>
    </div>
</div>
</form>
<script>
    var i=0;
    function add(){
        
        html ='';
        html +='<tr>';
        html +='<td><select class="select2bs4" name="products['+i+'][id_po]"><option value="">Pilih</option><?php foreach($po as $p){?><option value="<?php echo $p['id_produksi_po']?>"><?php echo $p['kode_po']?></option><?php }?></select></td>';
        html +='<td><input type="text" name="products['+i+'][size]" required></td>';
        html +='<td><input type="text" name="products['+i+'][harga]" onkeyUp="hitung('+i+')" required></td>';
        html +='<td><input type="text" name="products['+i+'][quantity]" onkeyUp="hitung('+i+')" required></td>';
        html +='<td><input type="text" name="products['+i+'][discount]" onkeyUp="hitung('+i+')" required></td>';
        html +='<td><input type="text" name="products['+i+'][jumlah]" required></td>';
        html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-xs remove"><span class="fa fa-trash"></span></button></td>';
        html +='<tr>';
        i++;
        $("#listp tbody").append(html);
        $('.select2bs4').select2();
        
    }

    function hitung(i) {
        // Ambil nilai harga, quantity, dan discount
        var harga = $('input[name="products[' + i + '][harga]"]').val();
        var quantity = $('input[name="products[' + i + '][quantity]"]').val();
        var discount = $('input[name="products[' + i + '][discount]"]').val();

        // Konversi nilai menjadi bilangan bulat
        harga = parseFloat(harga);
        quantity = parseFloat(quantity);
        discount = parseFloat(discount);

        // Hitung jumlah
        var jumlah = (harga * quantity) - discount;

        // Tampilkan hasil perhitungan di input "jumlah"
        $('input[name="products[' + i + '][jumlah]"]').val(jumlah);
    }


    $(document).on('click', '.remove', function(){
        $(this).closest('tr').remove();
    });
</script>