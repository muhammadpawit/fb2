<style type="text/css">
    #editModal .modal-content {
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }
    #editModal .modal-header {
        background: linear-gradient(135deg, #3498db, #2c3e50);
        color: white;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
        padding: 1.5rem;
    }
    #editModal .modal-header .close {
        color: white;
        opacity: 0.8;
    }
    #editForm .table {
        border: none;
    }
    #editForm .table thead th {
        background-color: #f8f9fa;
        color: #2c3e50;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 0.5px;
        padding: 12px;
        border-bottom: 2px solid #3498db;
    }
    #editForm .form-control {
        border-radius: 6px;
        border: 1px solid #dcdde1;
        padding: 6px 10px;
        font-size: 13px;
        transition: all 0.2s;
    }
    #editForm .form-control:focus {
        border-color: #3498db;
        box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
    }
    .summary-card {
        background-color: #f8f9fa;
        border-radius: 10px;
        padding: 20px;
        border-left: 5px solid #3498db;
    }
    .summary-title {
        font-size: 14px;
        font-weight: bold;
        color: #2c3e50;
        margin-bottom: 10px;
    }
    .total-amount {
        font-size: 20px;
        font-weight: 800;
        color: #2ecc71;
    }
    .btn-save {
        background: linear-gradient(135deg, #2ecc71, #27ae60);
        border: none;
        padding: 10px 25px;
        font-weight: bold;
        border-radius: 30px;
    }
    .btn-add-row {
        background: #3498db;
        color: white;
        border-radius: 50px;
        width: 35px;
        height: 35px;
        padding: 0;
        line-height: 35px;
    }
</style>

<div class="p-3" style="position: relative;">
    <!-- Loader Overlay -->
    <div id="saveLoader" style="display: none; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255,255,255,0.8); z-index: 9999; align-items: center; justify-content: center; flex-direction: column; border-radius: 12px;">
        <div class="text-center">
            <i class="fa fa-spinner fa-spin fa-4x text-primary mb-3"></i>
            <h4 class="font-weight-bold" style="color: #2c3e50;">Menyimpan Perubahan...</h4>
            <p class="text-muted">Data sedang diproses, mohon tidak menutup jendela ini.</p>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-8">
            <h4 class="font-weight-bold mb-1" style="color: #2c3e50;">
                FORM AJUAN HARIAN FORBOYS - 
                <span class="text-primary"><?php 
                    if ($parent['kategori'] == 1) { echo "SABLON"; } 
                    else if($parent['kategori'] == 2) { echo "BORDIR"; } 
                    else if($parent['kategori'] == 3) { echo "KONVEKSI"; }
                    else if($parent['kategori'] == 4) { echo "SUKABUMI"; }
                ?></span>
            </h4>
            <p class="text-muted small">Periode: <?php $hari=date('l',strtotime($parent['tanggal'])); echo hari($hari); ?>, <input type="text" name="tanggal" form="editForm" class="d-inline-block form-control w-auto datepicker-modal" readonly style="background-color: #fff; cursor: pointer;" value="<?php echo date('Y-m-d',strtotime($parent['tanggal'])) ?>"></p>
        </div>
        <div class="col-md-4 text-right">
            <?php if($parent['status']==0){?>
                 <span class="badge badge-warning p-2"><i class="fa fa-clock"></i> Diajukan (Belum Disetujui)</span>
            <?php } else { ?>
                 <span class="badge badge-success p-2"><i class="fa fa-check"></i> Disetujui</span>
            <?php } ?>
        </div>
    </div>

    <form id="editForm" method="post" action="<?php echo $edit?>">
        <input type="hidden" name="id" value="<?php echo $parent['id']?>">
        <input type="hidden" name="statusajuan" value="<?php echo $parent['status']?>">
        <?php if(isset($editacc)){?>
        <input type="hidden" name="editacc" value="<?php echo $parent['id']?>">
        <?php } ?>

        <div class="row mb-3">
            <div class="col-md-4">
                <table class="table table-bordered">
                    <tr>
                        <td class="bg-light"><b>Hari</b></td>
                        <td class="bg-light"><b>Tanggal</b></td>
                    </tr>
                    <tr>
                        <td><?php $hari=date('l',strtotime($parent['tanggal'])); echo hari($hari); ?></td>
                        <td><input type="text" name="tanggal" class="form-control datepicker-modal" value="<?php echo date('Y-m-d',strtotime($parent['tanggal'])) ?>" readonly style="background-color: #fff; cursor: pointer;"></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="table-responsive" style="min-height: 300px;">
            <table class="table">
                <thead>
                    <tr class="text-center">
                        <th width="50">Status</th>
                        <th width="40">No.</th>
                        <th>Item Pengajuan</th>
                        <th width="110">Jumlah</th>
                        <th width="100">Satuan</th>
                        <th width="150">Harga (Rp)</th>
                        <th width="140">Pembayaran</th>
                        <th width="180">Supplier</th>
                        <th>Keterangan</th>
                        <th width="50">
                            <button type="button" class="btn btn-add-row" onclick="addRow()"><i class="fa fa-plus"></i></button>
                        </th>
                    </tr>
                </thead>
                <tbody id="itemBody">
                    <?php $i=0; $no=1; $totalCash=0; $totalTF=0; ?>
                    <?php foreach ($item as $tem): ?>
                        <tr class="item-row">
                            <td class="text-center">
                                <input type="hidden" name="products[<?php echo $i?>][hapus]" class="hapus-input" value="0">
                                <button type="button" class="btn btn-sm btn-outline-danger btn-trash" onclick="toggleHapus(this)"><i class="fa fa-trash"></i></button>
                            </td>
                            <td class="text-center pt-3"><?php echo $no++; ?></td>
                            <td>
                                <input type="text" name="products[<?php echo $i?>][nama_item]" value="<?php echo $tem['nama_item'] ?>" class="form-control font-weight-bold" placeholder="Nama Barang">
                                <input type="hidden" name="products[<?php echo $i?>][id]" value="<?php echo $tem['id'] ?>">
                            </td>
                            <td><input type="number" step="0.01" name="products[<?php echo $i?>][jumlah]" value="<?php echo $tem['jumlah'] ?>" class="form-control text-center calc" data-row="<?php echo $i?>"></td>
                            <td><input type="text" name="products[<?php echo $i?>][satuan]" value="<?php echo $tem['satuan'] ?>" class="form-control text-center"></td>
                            <td><input type="number" name="products[<?php echo $i?>][harga]" value="<?php echo $tem['harga'] ?>" class="form-control text-right calc" data-row="<?php echo $i?>"></td>
                            <td>
                                <select name="products[<?php echo $i?>][pembayaran]" class="form-control pembayaran" required>
                                    <option value="1" <?php echo $tem['pembayaran']==1?'selected':'';?>>CASH</option>
                                    <option value="2" <?php echo $tem['pembayaran']==2?'selected':'';?>>TRANSFER</option>
                                </select>
                            </td>
                            <td><input type="text" name="products[<?php echo $i?>][supplier]" class="form-control" value="<?php echo $tem['supplier']; ?>" placeholder="Supplier"></td>
                            <td><textarea name="products[<?php echo $i?>][keterangan]" class="form-control" rows="1" placeholder="Catatan..."><?php echo $tem['keterangan']; ?></textarea></td>
                            <td class="text-center">
                                <?php if(!empty($tem['komentar'])): ?>
                                    <button type="button" class="btn btn-sm btn-outline-info" title="<?php echo $tem['komentar']; ?>"><i class="fa fa-comment"></i></button>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php 
                            if ($tem['pembayaran'] == 2) { $totalTF += $tem['jumlah'] * $tem['harga']; } 
                            else { $totalCash += $tem['jumlah'] * $tem['harga']; }
                            $i++;
                        ?>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>

        <div class="row mt-4 align-items-end">
            <div class="col-md-3">
                <div class="summary-card">
                    <div class="summary-title text-muted">TOTAL CASH</div>
                    <div class="total-amount text-success" id="totalCashText">Rp <?php echo number_format($totalCash) ?></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="summary-card" style="border-left-color: #f1c40f;">
                    <div class="summary-title text-muted">TOTAL TRANSFER</div>
                    <div class="total-amount" style="color: #f39c12;" id="totalTFText">Rp <?php echo number_format($totalTF) ?></div>
                </div>
            </div>
            <div class="col-md-6 text-right pb-2">
                <button type="button" class="btn btn-secondary px-4 mr-2" data-dismiss="modal">BATAL</button>
                <button type="button" onclick="submitEdit()" class="btn btn-save text-white px-5"><i class="fa fa-save mr-2"></i> SIMPAN SEMUA PERUBAHAN</button>
            </div>
        </div>
    </form>
</div>

<style type="text/css">
    .row-deleted {
        background-color: #f8d7da !important;
        opacity: 0.6;
    }
    .row-deleted input, .row-deleted select, .row-deleted textarea {
        pointer-events: none;
        background-color: #e9ecef !important;
    }
</style>

<script type="text/javascript">
    var rowIdx = <?php echo $i ?>;

    function toggleHapus(btn) {
        var row = $(btn).closest('tr');
        var input = row.find('.hapus-input');
        
        if (input.val() == "0") {
            input.val("1");
            row.addClass('row-deleted');
            $(btn).html('<i class="fa fa-undo"></i>');
            $(btn).removeClass('btn-outline-danger').addClass('btn-outline-secondary');
        } else {
            input.val("0");
            row.removeClass('row-deleted');
            $(btn).html('<i class="fa fa-trash"></i>');
            $(btn).removeClass('btn-outline-secondary').addClass('btn-outline-danger');
        }
        calculateTotals();
    }

    function addRow() {
        var html = '<tr class="item-row">' +
            '<td class="text-center"><input type="hidden" name="products['+rowIdx+'][hapus]" class="hapus-input" value="0"><button type="button" class="btn btn-sm btn-outline-danger" onclick="$(this).closest(\'tr\').remove(); calculateTotals();"><i class="fa fa-trash"></i></button></td>' +
            '<td class="text-center">-</td>' +
            '<td><select class="form-control select2-modal brg-modal" name="products['+rowIdx+'][nama_item]" required style="width:100%"><option value="">Pilih Barang</option><?php foreach ($products as $p) { ?><option value="<?php echo $p['nama'] ?>" data-price="<?php echo $p['price'] ?>"><?php echo $p['nama'] ?></option><?php } ?></select></td>' +
            '<td><input type="number" step="0.01" class="form-control text-center calc" name="products['+rowIdx+'][jumlah]" required></td>' +
            '<td><input type="text" class="form-control text-center" name="products['+rowIdx+'][satuan]" value="-"></td>' +
            '<td><input type="number" class="form-control text-right calc" name="products['+rowIdx+'][harga]" value="0"></td>' +
            '<td><select name="products['+rowIdx+'][pembayaran]" class="form-control pembayaran" required><option value="1">CASH</option><option value="2">TRANSFER</option></select></td>' +
            '<td><input type="text" class="form-control" name="products['+rowIdx+'][supplier]" value="-"></td>' +
            '<td><input type="text" class="form-control" name="products['+rowIdx+'][keterangan]" value="-"></td>' +
            '<td></td>' +
            '</tr>';
        
        $('#itemBody').append(html);
        $('.select2-modal').select2({
            dropdownParent: $('#editModal')
        });
        rowIdx++;
    }

    $(document).on('change', '.brg-modal', function() {
        var price = $(this).find(':selected').data('price');
        $(this).closest('tr').find('input[name*="[harga]"]').val(price);
        calculateTotals();
    });

    $(document).on('input', '.calc', function() {
        calculateTotals();
    });

    $(document).on('change', '.pembayaran', function() {
        calculateTotals();
    });

    function calculateTotals() {
        var cash = 0;
        var tf = 0;
        $('#itemBody tr.item-row').each(function() {
            var row = $(this);
            var hapus = row.find('.hapus-input').val();
            if (hapus == "1") return;

            var qty = parseFloat(row.find('input[name*="[jumlah]"]').val()) || 0;
            var price = parseFloat(row.find('input[name*="[harga]"]').val()) || 0;
            var type = row.find('select[name*="[pembayaran]"]').val();

            if (type == "1") {
                cash += (qty * price);
            } else if (type == "2") {
                tf += (qty * price);
            }
        });

        $('#totalCashText').text('Rp ' + cash.toLocaleString());
        $('#totalTFText').text('Rp ' + tf.toLocaleString());
    }

    function submitEdit() {
        var valid = true;
        $('.pembayaran').each(function() {
            if ($(this).val() == "") {
                valid = false;
                alert("Tipe pembayaran harus diisi");
                return false;
            }
        });

        if (valid) {
            $("#saveLoader").css('display', 'flex');
            $(".btn-save").attr('disabled', true);
            $("#editForm").submit();
        }
    }

    $(document).ready(function() {
        $('.datepicker-modal').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });
    });
</script>
