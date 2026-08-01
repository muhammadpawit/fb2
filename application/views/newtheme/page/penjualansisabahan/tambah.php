<form action="<?php echo $action ?>" method="POST">
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Tanggal</label>
            <input type="text" class="form-control datepicker" name="tanggal" value="<?php echo date('Y-m-d')?>" required>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label>Keterangan</label>
            <textarea name="keterangan" class="form-control" rows="3"></textarea>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label>Daftar Barang yang Dijual</label>
            <table class="table table-bordered" id="itembarang">
                <thead>
                    <tr>
                        <th>Nama Barang / Item</th>
                        <th>Qty</th>
                        <th>Harga per Barang (Rp)</th>
                        <th>Total (Rp)</th>
                        <th width="50">
                            <button type="button" class="btn btn-success btn-sm" onclick="tambahItem()"><i class="fa fa-plus"></i></button>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <input type="text" class="form-control" name="products[0][nama_barang]" required placeholder="Masukkan Nama Barang / Item">
                        </td>
                        <td>
                            <input type="number" step="0.01" class="form-control qty" name="products[0][qty]" oninput="hitungTotal(this)" required value="0">
                        </td>
                        <td>
                            <input type="number" step="0.01" class="form-control harga" name="products[0][harga]" oninput="hitungTotal(this)" required value="0">
                        </td>
                        <td>
                            <input type="text" class="form-control total" readonly value="0">
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm remove"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-right">Grand Total (Rp)</th>
                        <th colspan="2"><input type="text" id="grand_total" class="form-control" readonly value="0"></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <a href="<?php echo $batal ?>" class="btn btn-danger btn-sm btn-block">Batal</a>
    </div>
    <div class="col-md-6">
        <button type="submit" class="btn btn-info btn-sm btn-block">Simpan</button>
    </div>
</div>
</form>

<script>
var i = 1;
function tambahItem() {
    var html = '<tr>';
    html += '<td><input type="text" class="form-control" name="products['+i+'][nama_barang]" required placeholder="Masukkan Nama Barang / Item"></td>';
    html += '<td><input type="number" step="0.01" class="form-control qty" name="products['+i+'][qty]" oninput="hitungTotal(this)" required value="0"></td>';
    html += '<td><input type="number" step="0.01" class="form-control harga" name="products['+i+'][harga]" oninput="hitungTotal(this)" required value="0"></td>';
    html += '<td><input type="text" class="form-control total" readonly value="0"></td>';
    html += '<td><button type="button" class="btn btn-danger btn-sm remove"><i class="fa fa-trash"></i></button></td>';
    html += '</tr>';
    $('#itembarang tbody').append(html);
    
    // Initialize select2 for the new element
    
    i++;
}

function hitungTotal(elem) {
    var tr = $(elem).closest('tr');
    var qty = parseFloat(tr.find('.qty').val()) || 0;
    var harga = parseFloat(tr.find('.harga').val()) || 0;
    var total = qty * harga;
    tr.find('.total').val(total.toLocaleString('id-ID'));
    hitungGrandTotal();
}

function hitungGrandTotal() {
    var grandTotal = 0;
    $('#itembarang tbody tr').each(function() {
        var qty = parseFloat($(this).find('.qty').val()) || 0;
        var harga = parseFloat($(this).find('.harga').val()) || 0;
        grandTotal += (qty * harga);
    });
    $('#grand_total').val(grandTotal.toLocaleString('id-ID'));
}

$(document).on('click', '.remove', function() {
    $(this).closest('tr').remove();
    hitungGrandTotal();
});
</script>
