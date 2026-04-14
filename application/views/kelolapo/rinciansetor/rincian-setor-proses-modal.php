<form action="<?php echo BASEURL . 'finishing/produksikaoscmtAct' ?>" method="post">
    <input type="hidden" name="idpo" value="<?php echo $idpo ?>">
    <input type="hidden" name="kode_po" value="<?php echo $kodepo ?>">
    <input type="hidden" name="id_kelolapo_kirim_setor" value="<?php echo $idklo ?>">
    <input type="hidden" name="progresName" value="<?php echo $poProd['id_proggresion_po'] ?>">
    <input type="hidden" name="id_master_cmt" value="<?php echo $poProd['id_master_cmt'] ?>">
    <input type="hidden" name="jumlahPotPcs" value="<?php echo $poProd['qty_tot_pcs'] ?>">
    
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label>Nama PO</label>
                <input type="text" class="form-control" value="<?php echo $kodepo ?>" readonly>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Nama CMT</label>
                <input type="text" class="form-control" value="<?php echo $poProd['nama_cmt'] ?>" readonly>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Tanggal Terima</label>
                <input type="date" name="tanggal_penerimaan" class="form-control" value="<?php echo date('Y-m-d') ?>">
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered" id="item_table_proses_regular">
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
                    <th><button type="button" class="btn btn-success btn-sm add-row-proses-regular"><i class="fa fa-plus"></i></button></th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <div class="text-right">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Submit Setoran</button>
    </div>
</form>

<script>
    $(document).ready(function() {
        $('.add-row-proses-regular').off('click').on('click', function() {
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
            html += '<td><button type="button" class="btn btn-danger btn-sm remove-row-proses-regular"><i class="fa fa-trash"></i></button></td></tr>';
            $('#item_table_proses_regular tbody').append(html);
        });

        $(document).on('click', '.remove-row-proses-regular', function() {
            $(this).closest('tr').remove();
        });
    });
</script>
