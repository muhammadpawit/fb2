<link href="<?php echo PLUGINS ?>bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" />
<style type="text/css">
    .hide {
        display: none;
    }
</style>
<!-- Start Page content -->
<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">

                <div class="card-box">
                    <h4 class="header-title m-t-0 m-b-20">Edit Produksi PO</h4>
                    <!--
                         [id_produksi_po] => 1
                            [kode_po] => FBO001
                            [nama_po] => FBO
                            [jenis_po] => SETELAN
                            [gambar_po] => 
                            [operaitonal_price] => 0
                            [harga_satuan] => 0
                            [kode_artikel] => 13
                            [created_date] => 2020-11-04
                            [updated_date] => 0000-00-00
                            [jumlah_pcs_po] => 0
                            [kategori_po] => DALAM
                            [gambar_po2] => 
                            [jumlah_bagian_bordir] => 0
                            [jumlah_size] => 0
                            [id_proggresion_po] => 1
                            [progress_lokasi] => 
                            [status] => 0
                    -->
                   <form action="<?php echo BASEURL.'konveksi/editproduksipoOnCreate' ?>" method="POST">
                        <div class="form-group">
                            <label>Kode PO</label>
                            <input type="text" class="form-control kodePO" name="kodePO" 
                            value="<?php echo $prod['kode_po']?>" readonly>
                        </div>
                        <div class="form-group">
                        	<label>Nama PO</label>
                            <input type="text" name="namaPO" value="<?php echo $prod['nama_po']?>" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label>Jenis PO</label>
                            <input type="text" class="form-control" name="jenisPO" value="<?php echo $prod['jenis_po']?>" readonly>
                        </div>
                        
                        <div class="form-group">
                            <label>Tanggal Produksi</label>
                            <input type="date" class="form-control" name="tanggalProd" value="<?php echo $prod['created_date']?>" required>
                        </div>
                        <div class="form-group">
                            <label>Kategori Po</label>
                            <select class="form-control selectpicker kategoriPo" name="kategoriPo" title="select jenis po" required >
                                <option value="DALAM" <?php echo ($prod['kategori_po']=='DALAM')?'selected':'';?>>DALAM</option>
                                <option value="LUAR" <?php echo ($prod['kategori_po']=='LUAR')?'selected':'';?>>LUAR</option>
                            </select>
                        </div>
                        <div class="form-group pemilikPO hide">
                            <label>Pemilik PO</label>
                            <input type="text" class="form-control pemilikPO" name="pemilikPO" value="-" readonly>
                        </div>
                        <div class="form-group">
                            <label>Kode Artikel</label>
                            <input type="text" class="form-control artikel" name="artikel" value="<?php echo $prod['kode_artikel']?>" readonly >
                        </div>
                        <dir></dir>
                        <!--
                        <div class="form-group">
                            <label>Progress</label>
                            <select class="form-control" name="progress">
                                <?php foreach ($progress as $key => $prog): ?>
                                <option value="<?php echo $prog['id_proggresion_po'] ?>"><?php echo $prog['nama_progress'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>-->
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
    $(document).on('change', '.kategoriPo', function(){
        var select = $(this).find(':selected').val();
        if (select = 'LUAR') {
            $('.pemilikPO').removeClass('hide');
        } else {
            $('.pemilikPO').addClass('hide');
        }
    });
    $(document).on('change', '.selectpicker', function(){
        var select = $(this).children("option:selected"). val();
        var kodePO = $('.kodePO').val();
        $.get( "<?php echo BASEURL.'konveksi/jenisPoKodeArtikel' ?>", { id: select } )
          .done(function( data ) {
            var obj = JSON.parse(data);
            console.log(obj);
            $(".artikel").val(obj.artikel_jenis_po);
            
        });
    });
});
</script>