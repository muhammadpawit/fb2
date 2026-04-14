<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Nama PO</label>
                    <input type="text" class="form-control" value="<?php echo $poProd['nama_po'].$poProd['kode_po'] ?>" readonly>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Nama CMT</label>
                    <input type="text" class="form-control" value="<?php echo $poProd['nama_cmt'] ?>" readonly>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Tanggal</label>
                    <input type="date" class="form-control" id="tanggal_susulan_regular" name="tanggal" value="<?php echo date('Y-m-d') ?>" required>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
    <form action="<?php echo $editaction ?>" method="post">
        <input type="hidden" name="idpo" value="<?php echo $poProd['idpo']?>">
        <input type="hidden" name="id_master_cmt" value="<?php echo $poProd['id_master_cmt']?>">
        <input type="hidden" name="tanggal" id="tanggal_hidden_susulan_regular" value="<?php echo date('Y-m-d') ?>">
        <input type="hidden" class="form-control" name="tgl" value="<?php echo $poProd['create_date'] ?>" >
        <div class="table-responsive">
            <table class="table table-bordered" id="item_table_susulan_regular">
                <thead>
                    <tr>
                        <th>SIZE</th>
                        <th>DZ</th>
                        <th>PCS</th>
                        <th>BKE</th>
                        <th>RJC</th>
                        <th>HLG</th>
                        <th>CLM</th>
                        <th>KET</th>
                        <th><button type="button" class="btn btn-success btn-sm add-row-susulan-regular"><i class="fa fa-plus"></i></button></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($setorcmtjahititem)): ?>
                        <?php foreach ($setorcmtjahititem as $key => $jahitItem): ?>
                        <tr>
                            <td><input type="hidden" name="idr[]" value="<?php echo $jahitItem['id_kelolapo_rincian_setor_cmt_finish'] ?>"><input type="text" class="form-control" name="rinciansize[]" value="<?php echo $jahitItem['rincian_size'] ?>" readonly></td>
                            <td><input type="number" step="any" class="form-control" name="rincianlusin[]" value="0" required></td>
                            <td><input type="number" class="form-control" name="rincianpiece[]" value="0" required></td>
                            <td><input type="number" class="form-control" name="banke[]" value="0" required></td>
                            <td><input type="number" class="form-control" name="barangCacad[]" value="0" required></td>
                            <td><input type="number" class="form-control" name="hilangBarang[]" value="0" required></td>
                            <td><input type="number" class="form-control" name="claimBarang[]" value="0" required></td>
                            <td><input type="text" class="form-control" name="keterangan[]" value="-"></td>
                            <td><button type="button" class="btn btn-danger btn-sm remove-row-susulan-regular"><i class="fa fa-trash"></i></button></td>
                        </tr>
                        <?php endforeach ?>
                    <?php endif ?>
                </tbody>
            </table>
        </div>
    
    <div class="text-right">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button class="btn btn-primary" type="submit">Simpan Susulan</button>
    </div>
</form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#tanggal_susulan_regular').on('change', function() {
            $('#tanggal_hidden_susulan_regular').val($(this).val());
        });

        $('.add-row-susulan-regular').off('click').on('click', function() {
            var html = '';
            html += '<tr>';
            html += '<td>';
            html += '<select class="form-control" name="rinciansize[]" required>';
            <?php foreach ($size as $key => $value): ?>
            html += '<option value="<?php echo $value['nama_size'] ?>"><?php echo $value['nama_size'] ?></option>';
            <?php endforeach ?>
            html += '</select>';
            html += '</td>';
            html += '<td><input type="number" step="any" class="form-control" name="rincianlusin[]" value="0" required></td>';
            html += '<td><input type="number" class="form-control" name="rincianpiece[]" value="0" required></td>';
            html += '<td><input type="number" class="form-control" name="banke[]" value="0" required></td>';
            html += '<td><input type="number" class="form-control" name="barangCacad[]" value="0" required></td>';
            html += '<td><input type="number" class="form-control" name="hilangBarang[]" value="0" required></td>';
            html += '<td><input type="number" class="form-control" name="claimBarang[]" value="0" required></td>';
            html += '<td><input type="text" class="form-control" name="keterangan[]" value="-"></td>';
            html += '<td><button type="button" class="btn btn-danger btn-sm remove-row-susulan-regular"><i class="fa fa-trash"></i></button></td></tr>';
            $('#item_table_susulan_regular tbody').append(html);
        });

        $(document).on('click', '.remove-row-susulan-regular', function() {
            $(this).closest('tr').remove();
        });
    });
</script>
