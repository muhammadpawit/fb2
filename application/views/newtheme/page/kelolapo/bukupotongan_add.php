<div class="row">
  <div class="col-md-12">
    <?php if ($this->session->flashdata('msg')) { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        <?php echo $this->session->flashdata('msg'); ?> 
    </div>
    <?php } ?>
  </div>
</div>

<form action="<?php echo $action ?>" method="POST" enctype="multipart/form-data">
<div class="row">
    <div class="col-md-12">
        <h3 class="text-center">POTONGAN BAHAN UTAMA</h3>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <table class="table">
                                <tr>
                                    <td><label>Tanggal</label></td>
                                    <td><input type="text" class="form-control" name="tanggal" value="<?php echo $tgl?>" required></td>
                                </tr>
                                <tr>
                                    <td><label>Nama PO</label></td>
                                    <td>
                                        <select class="form-control autopoiinputpotongan" name="namaPo" id="poSelect" required>
                                            <option value="">Pilih</option>
                                            
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label>Referensi PO</label></td>
                                    <td>
                                        <select class="form-control autopo" name="refPO">
                                            <option value="">Pilih</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label>Tim Potong</label></td>
                                    <td>
                                       <select name="timPotong" class="form-control select2bs4" data-live-search="true" required="required">
                                            <option value="">Pilih Tim Potong</option>
                                            <?php foreach($timpotong as $tp){ ?>
                                                <option value="<?php echo $tp['id']?>"><?php echo $tp['nama']?></option>
                                            <?php }?>
                                       </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label>Gambar Sample Bahan Utama 1</label></td>
                                    <td>
                                       <input type="file" class="form-control" name="sempleBhnImg"> 
                                    </td>
                                </tr>
                                 <tr>
                                    <td><label>Gambar Sample Bahan Utama 2</label></td>
                                    <td>
                                       <input type="file" class="form-control" name="sempleBhnImg2"> 
                                    </td>
                                </tr>
                                <tr>
                                    <td><label>Panjang Gelaran (cm)</label></td>
                                    <td>
                                        <input type="number" step="0.01" class="form-control" name="panjangGelaran">
                                    </td>
                                </tr>
                                <tr>
                                    <td><label>Pemakaian Bahan (yard)</label></td>
                                    <td>
                                        <input type="text" class="form-control" name="pemakaianBahan" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label>Jumlah Size </label></td>
                                    <td>
                                        <input type="number" max="12" class="form-control" name="jumlahGambar" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label>Size </label></td>
                                    <td>
                                        <!-- <input type="text" class="form-control" name="sizeBahan" required> -->
                                         <select name="sizeBahan" class="form-control select2bs4" data-live-search="true" required="required">
                                            <option value="">Pilih Size</option>
                                            <?php foreach($mastersize as $tp){ ?>
                                                <option value="<?php echo $tp['size']?>"><?php echo $tp['size']?></option>
                                            <?php }?>
                                       </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </table>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered">
                                <thead>
                                    <tr>

                                    <th>BIDANG BAHAN</th>

                                    <th>WARNA</th>

                                    <th>KODE BAHAN</th>

                                    <th>BERAT BHN (Kg)</th>

                                    <th>SISA BHN (Kg)</th>

                                    <th>PEMAKAIAN BHN (Yard)</th>

                                    <th>BANYAK LAPIS Dz</th>

                                    <th><!-- <button type="button" name="add" class="btn btn-success btn-sm add"><i class="fa fa-plus"> </i></button>--></th>

                                </tr>
                                </thead>
                                <tbody id="listbahanutama">
                                    
                                </tbody>

                            </table>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <h3 class="text-center">POTONGAN BAHAN VARIASI</h3>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <table class="table">
                                <tr>
                                    <td><label>Panjang Gelar Variasi (cm)</label></td>
                                    <td>
                                        <input type="text" class="form-control" name="panjangGelaranVariasi" >
                                    </td>
                                </tr>
                                <tr>
                                    <td><label>Pemakaian Gelaran Variasi (yard)</label></td>
                                    <td>
                                        <input type="number" class="form-control" step="0.01" name="pemakaianGelaranVariasi" >
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>Sample Bahan Image Variasi 1</label>
                                    </td>
                                    <td>
                                        <input type="file" class="form-control" name="sempleBhnImgVar" >
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>Sample Bahan Image Variasi 2</label>
                                    </td>
                                    <td>
                                        <input type="file" class="form-control" name="sempleBhnImgVardua" >
                                    </td>
                                </tr>
                            </table>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered" id="listbahan">

                                <tr>

                                    <th>BIDANG BAHAN</th>

                                    <th>WARNA</th>

                                    <th>KODE BAHAN</th>

                                    <th>BERAT BHN (Kg)</th>

                                    <th>SISA BHN (Kg)</th>

                                    <th>PEMAKAIAN BHN (Yard)</th>

                                    <th>BANYAK LAPIS Dz</th>

                                    <th><button type="button" name="add" class="btn btn-success btn-sm add2"><i class="fa fa-plus"></i></button></th>

                                </tr>

                            </table>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
         <a href="<?php echo BASEURL.'kelolapo/bukupotongan';?>" class="btn btn-danger full">Batal</a>
        
    </div>
    <div class="col-md-6">
         
        <button type="submit" class="btn btn-primary full">Simpan</button>
    </div>
</div>
</form>
<script type="text/javascript">

$(document).ready(function(){

$(document).on('change', '#poSelect', function(){
    $('#listbahanutama').empty();
    $('#listbahan tr').detach();
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
        html+='<tr><td colspan="8" style="color:red !important">Tidak Ada Data untuk PO '+explode[1]+'</td></tr>';
        $("#listbahanutama").append(html); 
       }else{
        $("#listbahanutama").append(json); 
       }
    });
   $('#listbahan').empty();
    $.post( "<?php echo BASEURL.'Kelolapo/searchPObahan' ?>",{kodepo: explode[1] }).done(function( json ) {
       console.log(json);
       if(json==''){
        var html='';
        html+='<tr><td colspan="8" style="color:red !important">Tidak Ada Data untuk PO '+explode[1]+'</td></tr>';
        $("#listbahan").append(html); 
       }else{
        $("#listbahan").append(json); 
       }
    });

});



$(document).on('click', '.remove', function(){

    $(this).closest('tr').remove();

});

    

});

 </script>