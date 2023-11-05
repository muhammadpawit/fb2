<form action="<?php echo $action ?>" method="POST">
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="">Pilih PO</label>
            <select name="id_po" class="form-control select2bs4" required>
                <option value="">Pilih</option>
                <?php foreach($po as $c){ ?>
                    <option value="<?php echo $c['id_produksi_po']?>"><?php echo $c['kode_po']?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label for="">Pilih CMT</label>
            <select name="id_cmt" class="form-control select2bs4" required>
                <option value="">Pilih</option>
                <?php foreach($cmt as $c){ ?>
                    <option value="<?php echo $c['id_cmt']?>"><?php echo $c['cmt_name']?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <!-- <div class="col-md-12">
        <div class="form-group">
            <label for="">Pilih Serian Warna</label>
            <select name="id_serian" class="form-control select2bs4" required>
                <option value="">Pilih</option>
                <?php foreach($serian as $c){ ?>
                    <option value="<?php echo $c['id']?>"><?php echo $c['nama']?></option>
                <?php } ?>
            </select>
        </div>
    </div> -->

    <div class="col-md-12">
        <div class="form-group">
            <label>Harga</label>
            <input type="number" class="form-control" name="harga" value="0">
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
                        <th width="35%">Serian Warna</th>
                        <th width="35%">Size Dari</th>
                        <th width="35%">Size Sampai</th>
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
        <div class="form-group"><a class="btn btn-sm btn-danger full" href="<?php echo BASEURL.'Masterpoonline';?>">Batal</a></div>
    </div>
</div>
</form>
<script>
    var i=0;
    function add(){
        
        html ='';
        html +='<tr>';
        html +='<td><select class="select2bs4" name="products['+i+'][id_serian]" style="width:100%"><option value="">Pilih</option><?php foreach($serian as $p){?><option value="<?php echo $p['id']?>"><?php echo $p['nama']?></option><?php }?></select></td>';
        html +='<td><select class="select2bs4" name="products['+i+'][id_size_from]" style="width:100%"><option value="">Pilih</option><?php for($i=1; $i<=12;$i++){?><option value="<?php echo $i?>" <?php echo $i==1?'selected':''; ?>><?php echo $i?></option><?php }?></select></td>';
        html +='<td><select class="select2bs4" name="products['+i+'][id_size_to]" style="width:100%"><option value="">Pilih</option><?php for($i=1; $i<=12;$i++){?><option value="<?php echo $i?>" <?php echo $i==12?'selected':''; ?>><?php echo $i?></option><?php }?></select></td>';
        // html +='<td><input type="text" name="products['+i+'][pcs]" required></td>';
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