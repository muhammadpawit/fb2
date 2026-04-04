<form action="<?php echo BASEURL . 'finishing/produksicelanacmtAct/0' ?>" method="POST">
    <input type="hidden" name="add" value="add">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Pilih CMT</label>
                        <select name="id_master_cmt" class="form-control select2modal" required style="width: 100%;">
                            <option value="">Mohon Dipilih</option>
                            <?php foreach($cmt as $p){ ?>
                                <option value="<?php echo $p['id_cmt']?>"><?php echo $p['cmt_name']?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Nama PO</label>
                        <select name="idpo" id="idpo_add" class="form-control select2modal" required style="width: 100%;">
                            <option value="">Mohon Dipilih</option>
                            <?php foreach($po as $p){ ?>
                                <option value="<?php echo $p['id_produksi_po']?>"><?php echo $p['kode_po']?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Referensi PO</label>
                        <select name="refpo" id="refpo_add" class="form-control select2modal" required style="width: 100%;">
                            <option value="">Mohon Dipilih</option>
                            <?php foreach($po as $p){ ?>
                                <option value="<?php echo $p['id_produksi_po']?>"><?php echo $p['kode_po']?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group text-center">
                <label>Rincian Penerimaan Setoran</label>
            </div>
            <div class="form-group">
                <div class="table-responsive">
                    <table class="table table-bordered" id="item_table_add">
                        <thead>
                            <tr>
                                <th width="150">SIZE</th>
                                <th>DZ</th>
                                <th>PCS</th>
                                <th>BKE</th>
                                <th>RJC</th>
                                <th>HLG</th>
                                <th>CLM</th>
                                <th>KET</th>
                                <th><button type="button" class="btn btn-success btn-sm add-row-add"><i class="fa fa-plus"></i></button></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="text-right">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>

<script>
    $(document).ready(function() {
        $('.select2modal').select2({
            dropdownParent: $('#modal-add')
        });

        $('.add-row-add').off('click').on('click', function() {
            var html = '';
            html += '<tr>';
            html += '<td>';
            html += '<select class="form-control" name="rinciansize[]" required>';
            <?php foreach ($size as $key => $value): ?>
            html += '<option value="<?php echo $value['nama_size'] ?>"><?php echo $value['nama_size'] ?></option>';
            <?php endforeach ?>
            html += '</select>';
            html += '</td>';
            html += '<td><input type="number" step="any" class="form-control" name="rincianlusin[]" required></td>';
            html += '<td><input type="number" class="form-control" name="rincianpiece[]" value="0"></td>';
            html += '<td><input type="number" class="form-control" name="banke[]" value="0"></td>';
            html += '<td><input type="number" class="form-control" name="barangCacad[]" value="0"></td>';
            html += '<td><input type="number" class="form-control" name="hilangBarang[]" value="0"></td>';
            html += '<td><input type="number" class="form-control" name="claimBarang[]" value="0"></td>';
            html += '<td><input type="text" class="form-control" name="keterangan[]"></td>';
            html += '<td><button type="button" class="btn btn-danger btn-sm remove-row-add"><i class="fa fa-trash"></i></button></td></tr>';
            $('#item_table_add tbody').append(html);
        });

        $(document).on('click', '.remove-row-add', function() {
            $(this).closest('tr').remove();
        });
    });
</script>
