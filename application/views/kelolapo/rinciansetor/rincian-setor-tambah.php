<div class="row">
    <div class="col-md-3">
        <div class="form-group text-center">
            <label>Rincian Potong</label>
        </div>
        <div class="form-group">
            <label>Nama PO</label>
            <select class="form-control selectpicker" id="poSelect" name="namaPo" title="Select Nama PO" data-live-search="true" required>
                <option selected="selected" value="<?php echo $poProd['kode_po'] ?>"><?php echo $poProd['nama_po'].$poProd['kode_po'] ?></option>
            </select>
        </div>
        <div class="form-group">
            <label>Tanggal</label>
            <input type="date" class="form-control" name="tanggal" value="<?php echo $poProd['created_date'] ?>" required readonly>
        </div>
        <div class="form-group">
            <label>Tim Potong</label>
            <input type="text" class="form-control timPotong" name="timPotong" value="<?php echo $poProd['tim_potong_potongan'] ?>" required readonly>
        </div>
        <div class="form-group">
            <label>Jumlah Potong (Dz)</label>
            <input type="number" step="0.01" class="form-control jumlahPotDz" name="jumlahPotDz" value="<?php echo $poProd['hasil_lusinan_potongan'] ?>" required readonly>
        </div>
        <div class="form-group">
            <label>Jumlah Potong (Pcs)</label>
            <input type="number" step="0.01" class="form-control jumlahPotPcs" name="jumlahPotPcs" value="<?php echo $poProd['hasil_lusinan_potongan'] * 12 ?>" required readonly>
        </div>
        <div class="form-group">
            <label>Jml Warna</label>
            <input type="number" class="form-control jmlWarna" name="jmlWarna" value="<?php echo $poProd['jumlah_gambar_utama'] ?>" required readonly>
        </div>
    </div>
    <div class="col-md-9">
        <div class="form-group text-center">
            <label>Rincian Penerimaan Setoran</label>
        </div>
        <div class="form-group">
            <table class="table table-bordered" id="item_table3">
                    <tr>
                        <th width="200">SIZE</th>
                        <th>DZ(Lusin)</th>
                        <th>PIECES</th>
                        <th>BANGKE</th>
                        <th>REJECT</th>
                        <th>HILANG</th>
                        <th>CLAIM</th>
                        <th>KETERANGAN</th>
                        <th><button type="button" name="add" class="btn btn-success btn-sm add3"><i class="fa fa-plus"></i></button></th>
                    </tr>
                    <?php if (!empty($setorcmtjahititem)): ?>
                        <?php // pre($setorcmtjahititem) ?>
                        <?php foreach ($setorcmtjahititem as $key => $jahitItem): ?>
                        <tr>
                            <td><input type="text" class="form-control" name="rinciansize[]" value="<?php echo $jahitItem['rincian_size'] ?>" required ></td>
                            <td><input type="text" class="form-control" name="rincianlusin[]" value="<?php echo $jahitItem['rincian_lusin'] ?>" required ></td>
                            <td><input type="number" class="form-control" name="rincianpiece[]" value="<?php echo $jahitItem['rincian_piece'] ?>" required  ></td>
                            <td><input type="number" name="banke[]" class="form-control" value="<?php echo $jahitItem['rincian_bangke'] ?>" required></td>
                            <td><input type="number" class="form-control" name="barangCacad[]" value="<?php echo $jahitItem['rincian_reject'] ?>" required></td>
                            <td><input type="number" class="form-control" name="hilangBarang[]" value="<?php echo $jahitItem['rincian_hilang'] ?>" required></td>
                            <td><input type="number" class="form-control" name="claimBarang[]" value="<?php echo $jahitItem['rincian_claim'] ?>" required></td>
                            <td><input type="text" class="form-control" name="keterangan[]" value="<?php echo $jahitItem['rincian_keterangan'] ?>" ></td>
                            <td></td>
                        </tr>
                        <?php endforeach ?>
                    <?php endif ?>
            </table>
        </div>
        <div class="form-group">
            <?php if (empty($setorcmtjahititem)){ ?>
                <button class="btn btn-info" type="submit">submit</button>
            <?php }else{ ?>
                <a href="<?php echo BASEURL ?>Finishing/rinciansetorkaoscmt" class="btn btn-danger">Kembali</a>
            <?php } ?>

        </div>
    </div>
</div>
<link href="<?php echo PLUGINS ?>bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" />
<script src="<?php echo PLUGINS ?>bootstrap-select/js/bootstrap-select.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
$(document).on('click', '.add', function(){
    var html = '';
    html += '<tr>';
    html += '<td><input type="text" class="form-control" name="bagianAtas[]" required readonly></td>';
    html += '<td><input type="text" class="form-control" name="warnaAtas[]" required readonly></td>';
    html += '<td><input type="number" class="form-control" name="jmlAtas[]"  ></td>';
    html += '<td><input type="text" class="form-control" name="keteranganAts[]"  readonly></td>';
    html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button></td></tr>';
    $('#item_table').append(html);
 });

$(document).on('click', '.add3', function(){
    var html = '';
    html += '<tr>';
    html += '<td>';
    html += '<select class="form-control selectpicker" name="rinciansize[]" data-live-search="true" data-size="3" required>';
    <?php foreach ($size as $key => $value): ?>
    html += '<option value="<?php echo $value['nama_size'] ?>"><?php echo $value['nama_size'] ?></option>';
    <?php endforeach ?>
    html += '</select>';
    html += '</td>';
    html += '<td><input type="number" class="form-control" name="rincianlusin[]" required ></td>';
    html += '<td><input type="number" class="form-control" name="rincianpiece[]"  ></td>';
    html += '<td><input type="number" name="banke[]" class="form-control" ></td>';
    html += '<td><input type="number" class="form-control" name="barangCacad[]"></td>';
    html += '<td><input type="number" class="form-control" name="hilangBarang[]" required></td>';
    html += '<td><input type="number" class="form-control" name="claimBarang[]" required></td>';
    html += '<td><input type="text" class="form-control" name="keterangan[]"  ></td>';
    html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button></td></tr>';
    $('#item_table3').append(html);
    $('.selectpicker').selectpicker('refresh');
 });

$(document).on('change', '#poSelect', function(){

    var dataid = $(this).children("option:selected").data('id');

    $.post( "<?php echo BASEURL.'kelolapo/seaechDataId' ?>", { idData: dataid } ).done(function( data ) {

        var obj = JSON.parse(data);
        $('.timPotong').val(obj.tim_potong_potongan);
        $('.jmlWarna').val(obj.jumlah_gambar_utama);
        $('.jumlahPotDz').val(obj.hasil_lusinan_potongan);
        $('.jumlahPotPcs').val(obj.hasil_lusinan_potongan * 12);
      });;
    });

$(document).on('click', '.remove', function(){
    $(this).closest('tr').remove();
});
    
});
 </script>