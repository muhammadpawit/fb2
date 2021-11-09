<link href="<?php echo PLUGINS ?>bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" />

<!-- Start Page content -->
<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">

                <div class="card-box">
                    <h4 class="header-title m-t-0 m-b-20">Tambah Pengecekan Potongan</h4>
                    <div class="alert alert-dark alert-dismissible bg-dark text-white border-0 fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        Kalau ga ada value nya isi kolom nya dengan strip, Terima Kasih!
                    </div>
                    <hr>
                   <form action="<?php echo BASEURL.'kelolapo/formpengecekanpotonganOnAct' ?>" method="POST" enctype="multipart/form-data">
                   	<div class="row">
                        <div class="col-12">
                            <h3 class="text-center">POTONGAN ATASAN</h3>
                            <hr>
                        </div>
                   		<div class="form-group col-sm-12 col-lg-3">
                        	<label>Nama PO</label>
                            <select class="form-control selectpicker" id="poSelect" name="namaPo" title="Select Nama PO" data-live-search="true">
                                <?php foreach ($poProd as $key => $po): ?>
                                <option data-id="<?php echo $po['kode_po'] ?>" value="<?php echo $po['kode_po'] ?>"><?php echo $po['nama_po'] ?> <?php echo $po['kode_po'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group col-sm-12 col-lg-3">
                        	<label>Tanggal</label>
                        	<input type="date" class="form-control" name="tanggal" required>
                        </div>
                        <div class="form-group col-sm-12 col-lg-3">
                        	<label>Tim Potong</label>
                        	<input type="text" class="form-control timPotong" name="timPotong" required>
                        </div>
                        
                        <div class="form-group col-sm-12 col-lg-3">
                        	<label>Jumlah Potong (Dz)</label>
                        	<input type="number" step="0.01" class="form-control jumlahPotDz" name="jumlahPotDz" required>
                        </div>
                        <div class="form-group col-sm-12 col-lg-3">
                            <label>Jumlah Potong (Pcs)</label>
                            <input type="number" step="0.01" class="form-control jumlahPotPcs" name="jumlahPotPcs" required>
                        </div>
                        <div class="form-group col-sm-12 col-lg-3">
                        	<label>Jml Warna</label>
                        	<input type="number" class="form-control jmlWarna" name="jmlWarna" required>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-bordered" id="item_table">
                                <tr>
                                    <th>BAGIAN</th>
                                    <th>WARNA</th>
                                    <th>JML</th>
                                    <th>KETERANGAN</th>
                                    <th><button type="button" name="add" class="btn btn-success btn-sm add"><i class="fa fa-plus"></i></button></th>
                                </tr>
                            </table>
                        </div>
                        
                   	</div>

                    <div class="row">
                        <div class="col-sm-12">
                            <hr>
                            <h3 class="text-center">POTONGAN BAWAHAN</h3>
                            <hr>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-bordered" id="item_tabl2e">
                                <tr>
                                    <th>BAGIAN</th>
                                    <th>WARNA</th>
                                    <th>JML</th>
                                    <th>KETERANGAN</th>
                                    <th><button type="button" name="add" class="btn btn-success btn-sm add2"><i class="fa fa-plus"></i></button></th>
                                </tr>
                            </table>
                        </div>
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
$(document).on('click', '.add', function(){
    var html = '';
    html += '<tr>';
    html += '<td><input type="text" class="form-control" name="bagianAtas[]" required></td>';
    html += '<td><input type="text" class="form-control" name="warnaAtas[]" required></td>';
    html += '<td><input type="number" class="form-control" name="jmlAtas[]"  required></td>';
    html += '<td><input type="text" class="form-control" name="keteranganAts[]"  ></td>';
    html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button></td></tr>';
    $('#item_table').append(html);
 });

$(document).on('click', '.add2', function(){
    var html = '';
    html += '<tr>';
    html += '<td><input type="text" class="form-control" name="bagianBwh[]" required></td>';
    html += '<td><input type="text" class="form-control" name="warnaBwh[]" required></td>';
    html += '<td><input type="number" class="form-control" name="jmlBwh[]"  required></td>';
    html += '<td><input type="text" class="form-control" name="keteranganBwh[]"  ></td>';
    html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button></td></tr>';
    $('#item_tabl2e').append(html);
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