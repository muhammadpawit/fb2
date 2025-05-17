<form action="<?php echo BASEURL.'bordir/addharianmesinsave' ?>" method="POST">
<input type="hidden" name="jenis" value="<?php echo $jenis?>">
<div class="row">
                            <div class="form-group col-md-12">
                                <label>TANGGAL</label>
                                <input type="date" class="form-control" name="tanggal" required>
                            </div>
                            <div class="form-group col-md-12">
                                <label>Nama PO</label>
                                <select name="namaPo" class="form-control select2bs4" data-live-search="TRUE">
                                    <option value=""></option>
                                    <?php foreach($po as $p){?>
                                        <option value="<?php echo $p['id']?>"><?php echo $p['nama']?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label>SHIFT</label>
                                <select class="form-control select2bs4 shift" name="shift" title="pilih shift" data-live-search="TRUE">
                                    <option value="PAGI" data-shift="PAGI">PAGI</option>
                                    <option value="MALAM" data-shift="MALAM">MALAM</option>
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label>ABSENSI</label>
                                <select class="form-control select2bs4 shift" name="kehadiran" id="kehadiran" title="pilih kehadiran" data-live-search="TRUE" required>
                                    <option value="HADIR" data-shift="HADIR" data-jam="12">HADIR</option>
                                    <option value="IZIN" data-shift="IZIN" data-jam="12">IZIN</option>
                                    <option value="1/2HARI" data-shift="1/2HARI" data-jam="6">1/2HARI</option>
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label>JAM KERJA</label>
                                <input type="number" class="form-control selectpicker shift" name="jamkehadiran" id="jamkerja" required>
                            </div>
                            <div class="form-group col-md-12">
                                <label>Nama OPERATOR</label>
                                <select class="form-control select2bs4" data-live-search="TRUE" name="namaOperator" required>
                                    <?php foreach ($operator as $key => $op): ?>
                                        <option value="<?php echo $op['id_master_karyawan_bordir'] ?>"><?php echo $op['nama_karyawan_bordir'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label>Nama Mandor</label>
                                <input type="text" name="mandor" class="form-control" required>
                            </div>
                            <div class="form-group col-md-12">
                                <label>JAGA MESIN</label>
                                <select class="form-control select2bs4" name="mesin" required>
                                    <?php foreach ($mesin as $key => $me): ?>
                                    <option value="<?php echo $me['nomer_mesin'] ?>"><?php echo $me['nomer_mesin'] ?> (<?php echo $me['nama_mesin'] ?>)</option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label>GAMBAR</label>
                                <input type="text" class="form-control" name="gambar" required>
                            </div>
                            <div class="form-group col-md-12">
                                <label>JUMLAH BAGIAN YANG DI BORDIR</label>
                                <input type="number" class="form-control" name="jumlahbagian" placeholder="JUMLAH YANG DI BORDIR" value="" required="">
                            </div>
                            <div class="form-group col-md-12">
                                <label>JUMLAH SIZE</label>
                                <input type="text" class="form-control" name="jumlah_size" placeholder="JUMLAH YANG DI BORDIR" value="" required="">
                            </div>
                            
</div>
<div class="row">
            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="jmlNaik">JML NAIK</label>
                    <input type="number" class="form-control" name="jmlNaik" step="0.01" required>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="jmlTurun">JML TURUN</label>
                    <input type="number" class="form-control" id="jmlTurun" name="jmlTurun" step="0.01" required>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="size">SIZE</label>
                    <input type="text" class="form-control" name="size" required>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="stich">STICH</label>
                    <input type="number" class="form-control" id="stich" name="stich" required>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="from-group">
                    <label for="totalStich">TOTAL STICH</label>
                    <input type="number" class="form-control" id="totalStich" name="totalStich" step="0.01" required>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="from-group">
                    <label for="perkalianTarif">Target Perkalian Tagihan</label>
                    <input type="hidden" class="form-control" id="perkalianTarget" name="perkalianTarget">
                    <input type="number" class="form-control" id="perkalianTarif" name="perkalianTarif" value="0.18" readonly>
                </div>
            </div>
        </div>

<hr>

<div class="row mb-3">
  <div class="col-md-6 mb-3">
    <div class="form-group">
        <label for="spon">SPON</label>
        <input type="number" class="form-control" name="spon" required>
    </div>
  </div>
  <div class="col-md-6 mb-3">
    <div class="form-group">
        <label for="apl">APL</label>
        <input type="number" class="form-control" name="apl" required>
    </div>
  </div>
  <div class="col-md-6 mb-3">
    <div class="form-group">
        <label for="yangdibordir">POSISI BORDIR</label>
        <input type="text" class="form-control" name="yangdibordir" step="0.01" required>
    </div>
  </div>
  <div class="col-md-6 mb-3">
    <div class="form-group">
        <label for="tarif">TAGIHAN</label>
        <input type="text" class="form-control" id="tarif" name="tarif" required>
    </div>
  </div>
  <div class="col-md-6 mb-3">
    <div class="form-group">
        <label for="target">TARGET MESIN</label>
        <input type="text" class="form-control" id="target" name="target" required>
    </div>
  </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <button type="submit" class="btn btn-info full">Simpan</button>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <a href="<?php echo $kembali?>" class="btn btn-danger text-white full">Batal</a>
        </div>
    </div>
</div>
</form>
<script type="text/javascript">
$(document).ready(function(){

$( "#perkalianTarif" ).keyup(function() {
    var total = $('#totalStich').val();
    var perkali = $('#perkalianTarif').val();
    var tarif = total * perkali;
    var hasil=tarif.toFixed(2);
    $('#tarif').val(Math.round(hasil));
});
$("#perkalianTarget").keyup(function () {
    var total = $('#totalStich').val();
    var perkali = $(this).val();
    var tarif = total * perkali;
    $('#target').val(tarif);
});
$( "#stich" ).keyup(function() {
    var jmlTurun = $('#jmlTurun').val();
    var perkali = $(this).val();
    var tarif = jmlTurun * perkali;
    $('#totalStich').val(tarif);
});
$(document).on('click', '.add', function(){
    var html = '';
    html += '<tr>';
    html += '<td><input type="number" class="form-control" name="jmlNaik" required></td>';
    html += '<td><input type="number" class="form-control" name="jmlTurun"  required></td>';
    html += '<td><input type="text" class="form-control" name="size" ></td>';
    html += '<td><input type="number" class="form-control" name="stich" required></td>';
    html += '<td><input type="number" class="form-control" name="totalStich" required></td>';
    html += '<td><input type="number" class="form-control" name="perkalianTarif" required></td>';
    html += '<td><input type="number" class="form-control" name="perkalianTarget" required></td>';

    html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button></td></tr>';
    var html2 = '';
    html2 += '<tr>';
    html2 += '<td><input type="number" class="form-control" name="spon" ></td>';
    html2 += '<td><input type="number" class="form-control" name="apl" required></td>';
    html2 += '<td><input type="text" class="form-control" name="yangdibordir" required></td>';
    html2 += '<td><input type="text" class="form-control" name="kendala"></td>';
    html2 += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button></td></tr>';
    
    $('#item_table').append(html);
    $('#item_table2').append(html2);
 });
    
$('#kehadiran').change(function () {
    var jam = $(this).children("option:selected").data('jam');
    $('#jamkerja').val(jam);
});    
$(document).on('click', '.remove', function(){
    $(this).closest('tr').remove();
});
    
});
 </script>