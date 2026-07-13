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
            <input type="hidden" name="id_cmt" id="hidden_id_cmt">
            <select id="select_id_cmt" class="form-control select2bs4" disabled required>
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
            <input type="number" class="form-control" name="harga" value="" min="1" required>
        </div>
    </div>
    
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label>Rincian PO (Dari Finishing)</label>
            <div id="rincian_po_finishing"></div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label>Rincian PO Online</label>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <table class="table table-bordered" id="listp">
                <thead>
                    <tr>
                        <th width="35%">Serian Warna</th>
                        <th width="30%">Size</th>
                        <th width="30%">Qty (Pcs)</th>
                        <th width="5%">
                            <a href="javascript:void(0)" class="btn btn-sm btn-success" onclick="add_empty()"><i class="fa fa-plus"></i></a>
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
    function add_empty(){
        add_size('');
    }

    function add_size(size_val){
        html ='';
        html +='<tr>';
        html +='<td><select class="select2bs4" name="products['+i+'][id_serian]" style="width:100%"><option value="">Pilih</option><?php foreach($serian as $p){?><option value="<?php echo $p['id']?>"><?php echo $p['nama']?></option><?php }?></select></td>';
        
        if (size_val !== '') {
            html +='<td><input type="text" class="form-control" value="'+size_val+'" readonly>';
            html +='<input type="hidden" name="products['+i+'][id_size_from]" value="'+size_val+'">';
            html +='<input type="hidden" name="products['+i+'][id_size_to]" value="'+size_val+'"></td>';
        } else {
            html +='<td><select class="select2bs4" name="products['+i+'][id_size_from]" style="width:100%"><option value="">Pilih</option><?php for($x=1; $x<=12;$x++){?><option value="<?php echo $x?>"><?php echo $x?></option><?php }?></select>';
            html +='<input type="hidden" name="products['+i+'][id_size_to]" class="size_to_sync"></td>';
        }

        html +='<td><input type="number" class="form-control" name="products['+i+'][pcs]" value="0" min="0"></td>';
        html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-xs remove"><span class="fa fa-trash"></span></button></td>';
        html +='</tr>';
        i++;
        $("#listp tbody").append(html);
        $('.select2bs4').select2();
        
        // Sync id_size_to if id_size_from changes (for manual add)
        $('select[name="products['+(i-1)+'][id_size_from]"]').on('change', function(){
            $(this).siblings('.size_to_sync').val($(this).val());
        });
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

    $(document).ready(function(){
        $('select[name="id_po"]').on('change', function(){
            var id_po = $(this).val();
            if(id_po != ''){
                $('#rincian_po_finishing').html('Loading...');
                $.ajax({
                    url: '<?php echo BASEURL?>Finishing/detail_setoran_modal/'+id_po,
                    type: 'GET',
                    success: function(data){
                        $('#rincian_po_finishing').html(data);
                    },
                    error: function(){
                        $('#rincian_po_finishing').html('Gagal mengambil data');
                    }
                });
                $.ajax({
                    url: '<?php echo BASEURL?>Finishing/detail_setoran_json/'+id_po,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data){
                        $("#listp tbody").empty();
                        
                        // Set CMT and make it readonly
                        if(data.id_cmt){
                            $('#select_id_cmt').val(data.id_cmt).trigger('change');
                            $('#hidden_id_cmt').val(data.id_cmt);
                        } else {
                            $('#select_id_cmt').val('').trigger('change');
                            $('#hidden_id_cmt').val('');
                        }

                        if(data.items && data.items.length > 0){
                            data.items.forEach(function(item){
                                var size_str = item.rincian_size;
                                var parts = size_str.split('-');
                                if(parts.length == 2){
                                    var start = parseInt(parts[0].trim());
                                    var end = parseInt(parts[1].trim());
                                    if(!isNaN(start) && !isNaN(end)){
                                        for(var s = start; s <= end; s++){
                                            add_size(s);
                                        }
                                    }
                                } else {
                                    var s = parseInt(size_str.trim());
                                    if(!isNaN(s)){
                                        add_size(s);
                                    } else if (size_str.trim() != '') {
                                        add_size(size_str.trim());
                                    }
                                }
                            });
                        }
                    }
                });
            }else{
                $('#rincian_po_finishing').html('');
                $("#listp tbody").empty();
                $('#select_id_cmt').val('').trigger('change');
                $('#hidden_id_cmt').val('');
            }
        });
    });
</script>