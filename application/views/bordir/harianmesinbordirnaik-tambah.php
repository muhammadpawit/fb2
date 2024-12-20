<link href="<?php echo PLUGINS ?>bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" />
<!-- Start Page content -->
<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">

                <div class="card-box">
                    <div class="row">
                        <div class="col-6">
                            <?php //pre($project); ?>
                            <h4 class="header-title m-t-0 m-b-20">.INPUT HARIAN MESIN BORDIR</h4>
                            <h4>Nama PO : <?php echo $project['nama_po'].' '.$project['kode_po'] ?></h4>
                        </div>
                        <div class="col-6 text-right">
                            <a href="<?php echo BASEURL.'bordir/mesinbordirdetail/'.$project['kode_po'] ?>" target="_blank" class="btn btn-info">Detail Bordir</a>
                        </div>
                    </div>
                    <hr>
                   <form action="<?php echo BASEURL.'bordir/mesinbordirinputAct' ?>" method="POST">
                            
                        <div class="row">
                            <div class="form-group col-2">
                                <label>SHIFT</label>
                                <select class="form-control selectpicker shift" name="shift" title="pilih shift" data-live-search="TRUE">
                                    <option value="PAGI" data-shift="PAGI">PAGI</option>
                                    <option value="MALAM" data-shift="MALAM">MALAM</option>
                                </select>
                            </div>
                            <div class="form-group col-2">
                                <label>KEHADIRAN</label>
                                <select class="form-control selectpicker shift" name="kehadiran" id="kehadiran" title="pilih kehadiran" data-live-search="TRUE" required>
                                    <option value="HADIR" data-shift="HADIR" data-jam="12">HADIR</option>
                                    <option value="IZIN" data-shift="IZIN" data-jam="12">IZIN</option>
                                    <option value="1/2HARI" data-shift="1/2HARI" data-jam="6">1/2HARI</option>
                                </select>
                            </div>
                            <div class="form-group col-2">
                                <label>JAM</label>
                                <input type="number" class="form-control selectpicker shift" name="jamkehadiran" id="jamkerja" required>
                            </div>
                            <div class="form-group col-2">
                                <label>Nama OPERATOR</label>
                                <select class="form-control selectpicker select2bs4" name="namaOperator" data-live-search="TRUE" required>
                                    <?php foreach ($operator as $key => $op): ?>
                                        <option value="<?php echo $op['id_master_karyawan_bordir'] ?>"><?php echo $op['nama_karyawan_bordir'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group col-3">
                                <label>MESIN</label>
                                <select class="form-control" name="mesin" required>
                                    <?php foreach ($mesin as $key => $me): ?>
                                    <option value="<?php echo $me['nomer_mesin'] ?>"><?php echo $me['nomer_mesin'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group col-3">
                                <label>GAMBAR</label>
                                <input type="text" class="form-control" name="gambar" required>
                            </div>
                            <div class="form-group col-3">
                                <label>JUMLAH YANG DI BORDIR</label>
                                <input type="number" class="form-control" name="jumlahbagian" placeholder="JUMLAH YANG DI BORDIR" value="<?php echo $project['jumlah_bagian_bordir'] ?>" required="">
                            </div>
                            <div class="form-group col-3">
                                <label>JUMLAH SIZE</label>
                                <input type="number" class="form-control" name="jumlah_size" placeholder="JUMLAH YANG DI BORDIR" value="<?php echo $project['jumlah_size'] ?>" required="">
                            </div>
                            <div class="form-group col-3">
                                <label>TANGGAL</label>
                                <input type="date" class="form-control" name="tanggal" required>
                            </div>
                                <input type="hidden"  name="namaPo" value="<?php echo $project['kode_po'] ?>">
                            <div class="col-12">
                                <table class="table table-bordered" id="item_table">
                                    <tr>
                                        <th>JML NAIK</th>
                                        <th>JML TURUN</th>
                                        <th>SIZE</th>
                                        <th>STICH</th>
                                        <th>TOTAL STICH</th>
                                        <th>X Target</th>
                                        <th>X Tarif</th>
                                    </tr>
                                    <tr>
                                        <td><input type="number" class="form-control" name="jmlNaik" step=0.01 required></td>
                                        <td><input type="number" class="form-control" id="jmlTurun" name="jmlTurun" step=0.01 required></td>
                                        <td><input type="text" class="form-control" name="size" required></td>
                                        <td><input type="number" class="form-control" id="stich" name="stich" required></td>
                                        <td><input type="number" class="form-control" id="totalStich" name="totalStich" step=0.01 required></td>
                                        <td><input type="number" class="form-control" id="perkalianTarget" name="perkalianTarget" step=0.01 required></td>
                                        <td><input type="number" class="form-control" id="perkalianTarif" name="perkalianTarif" step=0.01 required></td>
                                    </tr>
                                </table>
                               
                                <table class="table-bordered table" id="item_table2">
                                    <tr>
                                        <th>SPON</th>
                                        <th>APL</th>
                                        <th>YANG DIBORDIR</th>
                                        <th>TARIF</th>
                                        <th>TARGET</th>
                                    </tr>
                                    <tr>
                                        <td><input type="number" class="form-control" name="spon" required></td>
                                        <td><input type="number" class="form-control" name="apl" required></td>
                                        <td><input type="text" class="form-control" name="yangdibordir" step=0.01 required></td>
                                        <td><input type="text" class="form-control" id="tarif" name="tarif" required></td>
                                        <td><input type="text" class="form-control" id="target" name="target" required></td>
                                    </tr>
                                </table>
                            </div>
                            <hr>
                        </div>
                        <button type="submit" class="btn btn-primary">SUBMIT</button>
                   </form>

                </div>

            </div>

        </div>
        <!-- end row -->

    </div> <!-- container -->

</div> <!-- content -->
<script src="<?php echo PLUGINS ?>bootstrap-select/js/bootstrap-select.js" type="text/javascript"></script>
 <script type="text/javascript">
$(document).ready(function(){
$( "#perkalianTarif" ).keyup(function() {
    var total = $('#totalStich').val();
    var perkali = $('#perkalianTarif').val();
    var tarif = total * perkali;
    $('#tarif').val(tarif);
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
    html += '<td><input type="number" class="form-control" name="jmlNaik" step=0.01 required></td>';
    html += '<td><input type="number" class="form-control" name="jmlTurun" step=0.01 required></td>';
    html += '<td><input type="text" class="form-control" name="size" ></td>';
    html += '<td><input type="number" class="form-control" name="stich" required></td>';
    html += '<td><input type="number" class="form-control" name="totalStich" step=0.01 required></td>';
    html += '<td><input type="number" class="form-control" name="perkalianTarif" step=0.01 required></td>';
    html += '<td><input type="number" class="form-control" name="perkalianTarget" step=0.01 required></td>';

    html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button></td></tr>';
    var html2 = '';
    html2 += '<tr>';
    html2 += '<td><input type="number" class="form-control" name="spon" ></td>';
    html2 += '<td><input type="number" class="form-control" name="apl" required></td>';
    html2 += '<td><input type="text" class="form-control" name="yangdibordir" step=0.01 required></td>';
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