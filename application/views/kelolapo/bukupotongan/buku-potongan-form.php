<link href="<?php echo PLUGINS ?>bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" />

<!-- Start Page content -->
<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">

                <div class="card-box">
                    <h4 class="header-title m-t-0 m-b-20">Tambah Buku Potongan</h4>
                    <div class="alert alert-dark alert-dismissible bg-dark text-white border-0 fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        Kalau ga ada value nya isi kolom nya dengan strip, Terima Kasih!
                    </div>
                    <hr>
                   <form action="<?php echo BASEURL.'konveksi/bukupotonganTambahOnCreate' ?>" method="POST" enctype="multipart/form-data">
                   	<div class="row">
                        <div class="col-12">
                            <h3 class="text-center">POTONGAN UTAMA</h3>
                            <hr>
                        </div>
                   		<div class="form-group col-sm-12 col-lg-12">
                        	<label>Nama PO</label>
                            <select class="form-control selectpicker" name="namaPo" title="Select Nama PO" required>
                                <option selected="" value="<?php echo $poProd['nama_po'] ?>-<?php echo $poProd['kode_po'] ?>"><?php echo $poProd['nama_po'] ?> <?php echo $poProd['kode_po'] ?></option>
                            </select>
                        </div>
                        <div class="form-group col-sm-12 col-lg-12">
                        	<label>Tanggal</label>
                        	<input type="date" class="form-control" name="tanggal" required>
                        </div>
                        <div class="form-group col-sm-12 col-lg-12">
                        	<label>Tim Potong</label>
                        	<input type="text" class="form-control" name="timPotong" required>
                        </div>
                        <div class="form-group col-sm-12 col-lg-12">
                        	<label>Sample Bahan Image utama</label>
                        	<input type="file" class="form-control" name="sempleBhnImg" required>
                        </div>
                       
                        <div class="form-group col-sm-12 col-lg-12">
                        	<label>Panjang Gelaran</label>
                        	<input type="number" step="0.01" class="form-control" name="panjangGelaran" required>
                        </div>
                        <div class="form-group col-sm-12 col-lg-12">
                        	<label>Pemakaian Bahan</label>
                        	<input type="text" class="form-control" name="pemakaianBahan" required>
                        </div>
                        <div class="form-group col-sm-12 col-lg-3">
                            <label>Jumlah Gambar </label>
                            <input type="number" class="form-control" name="jumlahGambar" required>
                        </div>
                        <div class="form-group col-sm-12 col-lg-3">
                            <label>Size </label>
                            <input type="text" class="form-control" name="sizeBahan" required>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="item_table">
                                <tr>
                                    <th>BIDANG BAHAN</th>
                                    <th>WARNA</th>
                                    <th>KODE BAHAN</th>
                                    <th>BERAT BHN</th>
                                    <th>SISA BHN</th>
                                    <th>PEMAKAIAN BHN</th>
                                    <th>BANYAK LAPIS</th>
                                    <th><button type="button" name="add" class="btn btn-success btn-sm add"><i class="fa fa-plus"></i></button></th>
                                </tr>
                            </table>
                        </div>
                        
                   	</div>

                    <div class="row">
                        <div class="col-sm-12">
                            <hr>
                            <h3 class="text-center">POTONGAN VARIASI</h3>
                            <hr>
                        </div>
                        <div class="form-group col-lg-4 col-sm-12">
                            <label>Panjang Gelar Variasi</label>
                            <input type="text" class="form-control" name="panjangGelaranVariasi" >
                        </div>
                        <div class="form-group col-lg-4 col-sm-12">
                            <label>Pemakaian Gelaran Variasi</label>
                            <input type="number" class="form-control" step="0.01" name="pemakaianGelaranVariasi" >
                        </div>
                         <div class="form-group col-sm-12 col-lg-12">
                            <label>Sample Bahan Image Variasi</label>
                            <input type="file" class="form-control" name="sempleBhnImgVar" >
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="item_tabl2e">
                                <tr>
                                    <th>BIDANG BAHAN</th>
                                    <th>WARNA</th>
                                    <th>KODE BAHAN</th>
                                    <th>BERAT BHN</th>
                                    <th>SISA BHN</th>
                                    <th>PEMAKAIAN BHN</th>
                                    <th>BANYAK LAPIS</th>
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
    html += '<td><input type="text" class="form-control" name="bidangBahan[]" required></td>';
    html += '<td><input type="text" class="form-control warna" name="warna[]" required></td>';

    html += '<td><select type="text" class="form-control selectpicker" data-size="4" name="kodeBahan[]" data-live-search="true" data-title="Pilih item" required><?php foreach ($bahan as $key => $item) { ?><option value="<?php echo $item['nama_item_keluar'] ?>" data-item="<?php echo $item['id_item_keluar'] ?>"><?php echo $item['nama_item_keluar'] ?></option><?php } ?></select></td>';

    html += '<td><input type="text" class="form-control beratBahan" name="beratBahan[]"  ></td>';
    html += '<td><input type="text" class="form-control" name="sisaBahan[]"  ></td>';
    html += '<td><input type="number" class="form-control" name="pemakaianBahankg[]" step=0.01  ></td>';
    html += '<td><input type="text" class="form-control" name="banyakLapis[]"   ></td>';
    html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button></td></tr>';
    $('#item_table').append(html);
    $('.selectpicker').selectpicker('refresh');
 });

$(document).on('click', '.add2', function(){
    var html = '';
    html += '<tr>';
    html += '<td><input type="text" class="form-control" name="bidangBahanVar[]" required></td>';
    html += '<td><input type="text" class="form-control" name="warnaVar[]" required></td>';
    
    html += '<td><select type="text" class="form-control selectpicker kodeBahanVar" data-size="2" name="kodeBahanVar[]" data-live-search="true" data-title="Pilih item" required><?php foreach ($bahan as $key => $item) { ?><option value="<?php echo $item['nama_item_keluar'] ?>" data-item="<?php echo $item['id_item_keluar'] ?>"><?php echo $item['nama_item_keluar'] ?></option><?php } ?></select></td>';
    html += '<td><input type="text" class="form-control" name="beratBahanVar[]"  ></td>';
    html += '<td><input type="text" class="form-control" name="sisaBahanVar[]"  ></td>';
    html += '<td><input type="number" class="form-control" name="pemakaianBahankgVar[]" step=0.01  ></td>';
    html += '<td><input type="text" class="form-control" name="banyakLapisVar[]"   ></td>';
    html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button></td></tr>';
    $('#item_tabl2e').append(html);
    $('.selectpicker').selectpicker('refresh');
 });

$(document).on('click', '.remove', function(){
    $(this).closest('tr').remove();
});

$(document).on('change', '.selectpicker', function(e){
    var dataItem = $(this).find(':selected').data('item');
    var dai = $(this).closest('tr');
    var jumlahItem = $('#piecesPo').val();
    $.get( "<?php echo BASEURL.'konveksi/searchItemBahanPo' ?>", { id: dataItem } )
      .done(function( data ) {
        var obj = JSON.parse(data);
        console.log(obj);
        dai.find(".beratBahan").val(obj.ukuran_item_keluar);
        dai.find(".warna").val(obj.warna_item_keluar);
    });
});    
$(document).on('change', '.kodeBahanVar', function(e){
    var dataItem = $(this).find(':selected').data('item');
    var dai = $(this).closest('tr');
    var jumlahItem = $('#piecesPo').val();
    $.get( "<?php echo BASEURL.'konveksi/searchItemBahanPo' ?>", { id: dataItem } )
      .done(function( data ) {
        var obj = JSON.parse(data);
        console.log(obj);
        dai.find(".beratBahanVar").val(obj.ukuran_item_keluar);
        dai.find(".warnaVar").val(obj.warna_item_keluar);
    });
});
});
 </script>