<link href="<?php echo PLUGINS ?>bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" />



<!-- Start Page content -->

<div class="content">

    <div class="container-fluid">



        <div class="row">

            <div class="col-md-12">



                <div class="card-box">

                    <h4 class="header-title m-t-0 m-b-20">Tambah Baru</h4>

                    <div class="alert alert-dark alert-dismissible bg-dark text-white border-0 fade show" role="alert">

                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">

                            <span aria-hidden="true">×</span>

                        </button>

                        Kalau ga ada value nya isi kolom nya dengan strip, Terima Kasih!

                    </div>

                    <hr>

                   <form action="<?php echo $action ?>" method="POST" enctype="multipart/form-data">

                   	<div class="row">

                        <div class="col-12">

                            <h3 class="text-center">POTONGAN UTAMA</h3>

                            <hr>

                        </div>
                        <div class="form-group col-sm-12 col-lg-12">
                            <table class="table">
                                <tr>
                                    <td><label>Tanggal</label></td>
                                    <td><input type="date" class="form-control" name="tanggal" value="<?php echo $tgl?>" required></td>
                                </tr>
                                <tr>
                                    <td><label>Nama PO</label></td>
                                    <td>
                                        <select class="form-control selectpicker" name="namaPo" title="Select Nama PO" id="poSelect" data-live-search="true" data-size="5" required>

                                            <?php foreach ($poProd as $key => $po): ?>

                                            <option value="<?php echo $po['nama_po'] ?>-<?php echo $po['kode_po'] ?>"><?php echo $po['nama_po'] ?> <?php echo $po['kode_po'] ?></option>

                                            <?php endforeach ?>

                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label>Tim Potong</label></td>
                                    <td>
                                       <!--  <input type="text" class="form-control" name="timPotong" required> -->
                                       <select name="timPotong" class="form-control" data-live-search="true">
                                            <option value="">Pilih</option>
                                            <?php foreach($timpotong as $tp){ ?>
                                                <option value="<?php echo $tp['id']?>"><?php echo $tp['nama']?></option>
                                            <?php }?>
                                       </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label>Gambar Sample Bahan Utama</label></td>
                                    <td>
                                       <input type="file" class="form-control" name="sempleBhnImg" required> 
                                    </td>
                                </tr>
                                <tr>
                                    <td><label>Panjang Gelaran</label></td>
                                    <td>
                                        <input type="number" step="0.01" class="form-control" name="panjangGelaran" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label>Pemakaian Bahan</label></td>
                                    <td>
                                        <input type="text" class="form-control" name="pemakaianBahan" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label>Jumlah Gambar </label></td>
                                    <td>
                                        <input type="number" max="12" class="form-control" name="jumlahGambar" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label>Size </label></td>
                                    <td>
                                        <input type="text" class="form-control" name="sizeBahan" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>

                        <div class="table-responsive">

                            <table class="table table-bordered">
                                <thead>
                                    <tr>

                                    <th>BIDANG BAHAN</th>

                                    <th>WARNA</th>

                                    <th>KODE BAHAN</th>

                                    <th>BERAT BHN</th>

                                    <th>SISA BHN</th>

                                    <th>PEMAKAIAN BHN</th>

                                    <th>BANYAK LAPIS</th>

                                    <th><!-- <button type="button" name="add" class="btn btn-success btn-sm add"><i class="fa fa-plus"> </i></button>--></th>

                                </tr>
                                </thead>
                                <tbody id="item_table">
                                    
                                </tbody>

                            </table>

                        </div>

                        

                   	</div>



                    <div class="row">

                        <div class="col-sm-12">

                            <hr>

                            <h3 class="text-center">POTONGAN VARIASI</h3>

                            <hr>

                        </div>

                        <div class="form-group col-lg-12 col-sm-12">
                            <table class="table">
                                <tr>
                                    <td><label>Panjang Gelar Variasi</label></td>
                                    <td>
                                        <input type="text" class="form-control" name="panjangGelaranVariasi" >
                                    </td>
                                </tr>
                                <tr>
                                    <td><label>Pemakaian Gelaran Variasi</label></td>
                                    <td>
                                        <input type="number" class="form-control" step="0.01" name="pemakaianGelaranVariasi" >
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>Sample Bahan Image Variasi</label>
                                    </td>
                                    <td>
                                        <input type="file" class="form-control" name="sempleBhnImgVar" >
                                    </td>
                                </tr>
                            </table>
                            

                            

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



                        <a href="<?php echo BASEURL.'kelolapo/bukupotongan';?>" class="btn btn-danger">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>



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

$(document).on('change', '#poSelect', function(){
    $('#item_table').empty();
    var poid = $(this).children("option:selected").val();
    var explode = poid.split("-");
    console.log(explode[1]);
    var i=0;
    $('#item_table').empty();
    var poid = $(this).children("option:selected").val();
    $.post( "<?php echo BASEURL.'Kelolapo/searchPO' ?>",{kodepo: explode[1] }).done(function( json ) {
       console.log(json);
       if(json==''){
        var html='';
        html+='<tr><td colspan="8" style="color:red !important">Bahan keluar belum diinput untuk PO '+explode[1]+'</td></tr>';
        $("#item_table").append(html); 
       }else{
        $("#item_table").append(json); 
       }
       
    });

});

$(document).on('click', '.add', function(){

    var html = '';

    html += '<tr>';

    html += '<td><input type="text" class="form-control" name="bidangBahan[]" required></td>';

    html += '<td><input type="text" class="form-control" name="warna[]" required></td>';

    html += '<td><input type="text" class="form-control" name="kodeBahan[]"  ></td>';

    html += '<td><input type="text" class="form-control" name="beratBahan[]"  ></td>';

    html += '<td><input type="text" class="form-control" name="sisaBahan[]"  ></td>';

    html += '<td><input type="number" class="form-control" name="pemakaianBahankg[]" step=0.01  ></td>';

    html += '<td><input type="text" class="form-control" name="banyakLapis[]"   ></td>';

    html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button></td></tr>';

    $('#item_table').append(html);

 });



$(document).on('click', '.add2', function(){

    var html = '';

    html += '<tr>';

    html += '<td><input type="text" class="form-control" name="bidangBahanVar[]" required></td>';

    html += '<td><input type="text" class="form-control" name="warnaVar[]" required></td>';

    html += '<td><input type="text" class="form-control" name="kodeBahanVar[]"  ></td>';

    html += '<td><input type="text" class="form-control" name="beratBahanVar[]"  ></td>';

    html += '<td><input type="text" class="form-control" name="sisaBahanVar[]"  ></td>';

    html += '<td><input type="number" class="form-control" name="pemakaianBahankgVar[]" step=0.01  ></td>';

    html += '<td><input type="text" class="form-control" name="banyakLapisVar[]"   ></td>';

    html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button></td></tr>';

    $('#item_tabl2e').append(html);

 });



$(document).on('click', '.remove', function(){

    $(this).closest('tr').remove();

});

    

});

 </script>