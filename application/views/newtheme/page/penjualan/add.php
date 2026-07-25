<style>
    #listp th,
    #listp td {
        border-color: #333 !important;
        vertical-align: middle;
    }
    #listp th {
        text-align: center;
        white-space: nowrap;
    }
    #listp input.form-control-sm {
        min-width: 90px;
        text-align: right;
    }
</style>
<form action="<?php echo $action ?>" method="POST" id="form-penjualan">
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
                        <th style="width: 50px;">No</th>
                        <th style="width: 25%;">Nama PO</th>
                        <th>serian/size</th>
                        <th>stok po(Kodi)</th>
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
                <tfoot>
                    <tr>
                        <th colspan="7" class="text-right">Subtotal</th>
                        <th><input type="text" id="subtotal_penjualan" class="form-control form-control-sm text-right" value="0" readonly></th>
                        <th></th>
                    </tr>
                    <tr>
                        <th colspan="7" class="text-right">Biaya Pengiriman</th>
                        <th><input type="text" id="biaya_pengiriman_display" class="form-control form-control-sm text-right" value="0" readonly></th>
                        <th></th>
                    </tr>
                    <tr>
                        <th colspan="7" class="text-right">Grand Total</th>
                        <th><input type="text" id="grand_total_penjualan" class="form-control form-control-sm text-right" value="0" readonly></th>
                        <th></th>
                    </tr>
                </tfoot>
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
    var groupNo=1;

    function numberOnly(value) {
        return parseFloat(String(value || '0').replace(/[^0-9.-]/g, '')) || 0;
    }

    function add(){
        
        html ='';
        html +='<tr class="select-row">';
        html +='<td></td>';
        html +='<td colspan="7"><select class="select2bs4 selectpo" style="width:100%"><option value="">Pilih Nama PO / Serian</option><?php foreach($po as $p){?><option value="<?php echo $p['id_master_po_online']?>-<?php echo $p['id_serian']?>"><?php echo $p['kode_po']?> <?php echo isset($p['serian']) ? $p['serian'] : ''?></option><?php }?></select></td>';
        html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-xs remove-group"><span class="fa fa-trash"></span></button></td>';
        html +='</tr>';
        $("#listp tbody").append(html);
        $('.select2bs4').select2();
        
    }

    function hitung(i) {
        var harga = numberOnly($('input[name="products[' + i + '][harga]"]').val());
        var quantityInput = $('input[name="products[' + i + '][quantity]"]');
        var quantity = numberOnly(quantityInput.val());
        var discount = numberOnly($('input[name="products[' + i + '][discount]"]').val());
        var stok = numberOnly(quantityInput.data('stok'));
        if(stok > 0 && quantity > stok) {
            alert('Quantity tidak boleh melebihi stok');
            quantity = stok;
            quantityInput.val(stok);
        }
        var jumlah = (harga * quantity) - discount;
        $('input[name="products[' + i + '][jumlah]"]').val(jumlah);
        updateGrandTotal();
    }

    function updateGrandTotal() {
        var subtotal = 0;
        $('input[name$="[jumlah]"]').each(function(){
            subtotal += numberOnly($(this).val());
        });

        var biayaPengiriman = numberOnly($('input[name="biaya_pengiriman"]').val());
        $('#subtotal_penjualan').val(subtotal.toLocaleString('id-ID'));
        $('#biaya_pengiriman_display').val(biayaPengiriman.toLocaleString('id-ID'));
        $('#grand_total_penjualan').val((subtotal + biayaPengiriman).toLocaleString('id-ID'));
    }

    $(document).on("change", ".selectpo", function() {
        var selectedValue = $(this).val();
        if(!selectedValue) return;

        var parts = selectedValue.split("-");
        var id_master = parts[0];
        var id_serian = parts[1];
        var dai = $(this).closest('tr');
        var url = "<?php echo BASEURL?>Masterpoonline/getPoSizes?id_master_po_online=" + id_master + "&id_serian=" + id_serian;

        $.ajax({
            type: "GET",
            url: url,
            success: function(data) {
                var obj = JSON.parse(data || '[]');
                if(obj.length < 1) {
                    alert('Stok PO tidak tersedia');
                    return;
                }

                var currentGroup = groupNo++;
                var groupClass = 'sale-group-' + currentGroup;
                var rowspan = obj.length;
                var groupHtml = '';

                obj.forEach(function(item, index) {
                    var row = i++;
                    var namaPo = item.kode_po + (item.serian ? ' ' + item.serian : '');

                    groupHtml += '<tr class="'+groupClass+'">';
                    if(index === 0) {
                        groupHtml += '<td rowspan="'+rowspan+'" class="text-center align-middle">'+currentGroup+'</td>';
                        groupHtml += '<td rowspan="'+rowspan+'" class="text-center align-middle">'+namaPo+'</td>';
                    }
                    groupHtml += '<td class="text-center">';
                    groupHtml += '<input type="hidden" name="products['+row+'][id_po]" value="'+item.id+'">';
                    groupHtml += '<input type="hidden" name="products['+row+'][size]" value="'+(item.id_size || '')+'">';
                    groupHtml += (item.id_size ? item.id_size : '');
                    groupHtml += '</td>';
                    groupHtml += '<td class="text-center">'+item.pcs+'</td>';
                    groupHtml += '<td><input type="number" name="products['+row+'][harga]" class="form-control form-control-sm harga" value="'+item.harga+'" onkeyup="hitung('+row+')" required></td>';
                    groupHtml += '<td><input type="number" name="products['+row+'][quantity]" class="form-control form-control-sm" autocomplete="off" data-stok="'+item.pcs+'" max="'+item.pcs+'" onkeyup="hitung('+row+')" required></td>';
                    groupHtml += '<td><input type="number" name="products['+row+'][discount]" class="form-control form-control-sm" autocomplete="off" onkeyup="hitung('+row+')" value="0" required></td>';
                    groupHtml += '<td><input type="number" name="products['+row+'][jumlah]" class="form-control form-control-sm" readonly required></td>';
                    if(index === 0) {
                        groupHtml += '<td rowspan="'+rowspan+'" class="text-center align-middle"><button type="button" class="btn btn-danger btn-xs remove-group" data-group="'+groupClass+'"><span class="fa fa-trash"></span></button></td>';
                    }
                    groupHtml += '</tr>';
                });

                dai.replaceWith(groupHtml);
            },
        });
    });

    $(document).on('click', '.remove', function(){
        $(this).closest('tr').remove();
    });

    $(document).on('click', '.remove-group', function(){
        var group = $(this).data('group');
        if(group) {
            $('.'+group).remove();
        } else {
            $(this).closest('tr').remove();
        }
        updateGrandTotal();
    });

    $('#form-penjualan').on('submit', function(e){
        if($('input[name$="[id_po]"]').length < 1) {
            alert('Rincian PO harus diisi');
            e.preventDefault();
            return false;
        }
    });

    $(document).on('keyup change', 'input[name="biaya_pengiriman"], input[name$="[harga]"], input[name$="[quantity]"], input[name$="[discount]"]', function(){
        updateGrandTotal();
    });
</script>
