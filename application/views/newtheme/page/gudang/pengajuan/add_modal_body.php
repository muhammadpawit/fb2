<style type="text/css">
    #addModal .modal-content {
        border-radius: 0;
    }

    #addModal .modal-header {
        background: linear-gradient(135deg, #17a2b8, #117a8b);
        color: white;
        padding: 1.5rem;
    }

    #addModal .modal-header .close {
        color: white;
        opacity: 0.8;
    }

    #addForm .table thead th {
        background-color: #f8f9fa;
        color: #2c3e50;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 0.5px;
        padding: 12px;
        border-bottom: 2px solid #17a2b8;
    }

    #addForm .form-control {
        border-radius: 6px;
        border: 1px solid #dcdde1;
        padding: 6px 10px;
        font-size: 13px;
    }

    .summary-card-add {
        background-color: #f8f9fa;
        border-radius: 10px;
        padding: 20px;
        border-left: 5px solid #17a2b8;
    }
</style>

<div class="p-4" style="position: relative;">
    <!-- Loader Overlay -->
    <div id="saveLoaderAdd" style="display: none; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255,255,255,0.8); z-index: 9999; align-items: center; justify-content: center; flex-direction: column;">
        <div class="text-center">
            <i class="fa fa-spinner fa-spin fa-4x text-info mb-3"></i>
            <h4 class="font-weight-bold" style="color: #2c3e50;">Menyimpan Pengajuan...</h4>
            <p class="text-muted">Sedang memproses data baru, mohon tunggu.</p>
        </div>
    </div>

    <form id="addForm" method="post" action="<?php echo $action ?>" onsubmit="showAddLoader()">
        <div class="row mb-4">
            <div class="col-md-3">
                <label class="font-weight-bold">TANGGAL PENGAJUAN</label>
                <input type="text" name="tanggal" class="form-control datepicker-modal" value="<?php echo date('Y-m-d') ?>" readonly style="background-color: #fff; cursor: pointer;" required>
            </div>
            <div class="col-md-3">
                <label class="font-weight-bold">DIVISI / CABANG</label>
                <select name="kategoriPengajuan" class="form-control select2-add" required style="width: 100%;">
                    <option value="">Pilih Divisi</option>
                    <?php foreach ($katpeng as $id => $val): ?>
                        <option value="<?php echo $id ?>"><?php echo $val ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6 text-right">
                <p class="text-muted mb-0">Pastikan semua data item sudah benar sebelum menyimpan.</p>
            </div>
        </div>

        <div class="table-responsive" style="min-height: 400px;">
            <table class="table">
                <thead>
                    <tr class="text-center">
                        <th width="40">No.</th>
                        <th>Item Pengajuan</th>
                        <th width="120">Jumlah</th>
                        <th width="120">Satuan</th>
                        <th width="160">Harga Satuan (Rp)</th>
                        <th width="150">Pembayaran</th>
                        <th>Nama Supplier</th>
                        <th>Keterangan</th>
                        <th width="50">
                            <button type="button" class="btn btn-info btn-sm rounded-circle" onclick="addTableRow()"><i class="fa fa-plus"></i></button>
                        </th>
                    </tr>
                </thead>
                <tbody id="addItemBody">
                    <!-- Baris pertama otomatis -->
                </tbody>
            </table>
        </div>

        <div class="row mt-4 align-items-end">
            <div class="col-md-3">
                <div class="summary-card-add">
                    <div class="summary-title text-muted small">ESTIMASI TOTAL CASH</div>
                    <div class="h4 font-weight-bold text-success mb-0" id="addTotalCash">Rp 0</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="summary-card-add" style="border-left-color: #f39c12;">
                    <div class="summary-title text-muted small">ESTIMASI TOTAL TRANSFER</div>
                    <div class="h4 font-weight-bold" style="color: #f39c12;" id="addTotalTF">Rp 0</div>
                </div>
            </div>
            <div class="col-md-6 text-right pb-2">
                <button type="button" class="btn btn-secondary px-4 mr-2" data-dismiss="modal">BATAL</button>
                <button type="submit" class="btn btn-info px-5 font-weight-bold shadow-sm"><i class="fa fa-check-circle mr-2"></i> SIMPAN PENGAJUAN BARU</button>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
    var addIdx = 0;

    function addTableRow() {
        var html = '<tr>' +
            '<td class="text-center pt-3">' + (addIdx + 1) + '</td>' +
            '<td><select class="form-control select2-add item-select" name="products[' + addIdx + '][product_id]" required style="width:100%"><option value="">Pilih Barang</option><?php foreach ($products as $p) { ?><option value="<?php echo $p['product_id'] ?>" data-nama="<?php echo htmlspecialchars($p['nama']) ?>" data-price="<?php echo $p['price'] ?>"><?php echo $p['nama'] ?></option><?php } ?></select><input type="hidden" class="item-name" name="products[' + addIdx + '][nama_item]" value=""></td>' +
            '<td><input type="number" step="0.01" class="form-control text-center add-calc" name="products[' + addIdx + '][jumlah]" required></td>' +
            '<td><input type="text" class="form-control text-center" name="products[' + addIdx + '][satuan]" value="-"></td>' +
            '<td><input type="number" class="form-control text-right add-calc" name="products[' + addIdx + '][harga]" value="0"></td>' +
            '<td><select name="products[' + addIdx + '][pembayaran]" class="form-control add-pay" required><option value="1">CASH</option><option value="2">TRANSFER</option></select></td>' +
            '<td><select class="form-control select2-add supplier-select" name="products[' + addIdx + '][supplier_id]" style="width:100%"><option value="">Pilih Supplier</option><?php foreach ($supplier as $s) { ?><option value="<?php echo $s['id'] ?>"><?php echo $s['nama'] ?></option><?php } ?></select><input type="hidden" class="supplier-name" name="products[' + addIdx + '][supplier]" value=""></td>' +
            '<td><input type="text" class="form-control" name="products[' + addIdx + '][keterangan]" value="-"></td>' +
            '<td class="text-center"><button type="button" class="btn btn-danger btn-sm rounded-circle" onclick="$(this).closest(\'tr\').remove(); updateAddTotals();"><i class="fa fa-trash"></i></button></td>' +
            '</tr>';

        $('#addItemBody').append(html);
        $('.select2-add').select2({
            dropdownParent: $('#addModal')
        });
        addIdx++;
    }

    $(document).off('change', '.item-select').on('change', '.item-select', function() {
        var price = $(this).find(':selected').data('price');
        var nama = $(this).find(':selected').data('nama');
        $(this).closest('tr').find('input[name*="[harga]"]').val(price);
        if ($(this).val() == '') nama = '';
        $(this).closest('tr').find('.item-name').val(nama);
        updateAddTotals();
    });

    $(document).off('input', '.add-calc').on('input', '.add-calc', function() {
        updateAddTotals();
    });

    $(document).off('change', '.add-pay').on('change', '.add-pay', function() {
        updateAddTotals();
    });

    $(document).off('change', '.supplier-select').on('change', '.supplier-select', function() {
        var name = $(this).find('option:selected').text();
        if ($(this).val() == '') name = '';
        $(this).closest('td').find('.supplier-name').val(name);
    });

    function updateAddTotals() {
        var cash = 0;
        var tf = 0;
        $('#addItemBody tr').each(function() {
            var qty = parseFloat($(this).find('input[name*="[jumlah]"]').val()) || 0;
            var price = parseFloat($(this).find('input[name*="[harga]"]').val()) || 0;
            var type = $(this).find('select[name*="[pembayaran]"]').val();

            if (type == "1") cash += (qty * price);
            else if (type == "2") tf += (qty * price);
        });

        $('#addTotalCash').text('Rp ' + cash.toLocaleString());
        $('#addTotalTF').text('Rp ' + tf.toLocaleString());
    }

    function showAddLoader() {
        $("#saveLoaderAdd").css('display', 'flex');
        $("#addForm button[type='submit']").attr('disabled', true);
    }

    $(document).ready(function() {
        $('.datepicker-modal').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });
        addTableRow(); // Tambah baris pertama otomatis
    });
</script>