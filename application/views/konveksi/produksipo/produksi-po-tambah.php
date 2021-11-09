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
                    <h4 class="header-title m-t-0 m-b-20">Tambah Produksi PO</h4>
                    <hr>
                   <form action="<?php echo $action ?>" method="POST">
                        <div class="form-group">
                            <label>Kode PO</label>
                            <input type="number" class="form-control kodePO" name="kodePO" value="" required>
                        </div>
                        <div class="form-group">
                        	<label>Nama PO</label>
                            <select class="form-control selectpicker" name="namaPO" data-title="Pilih Jenis PO">
                            <?php foreach ($JenisPo as $key => $jenis): ?>
                                <option value="<?php echo $jenis['nama_jenis_po'] ?>"><?php echo $jenis['nama_jenis_po'] ?></option>
                            <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Jenis PO</label>
                            <select class="form-control selectpicker" name="jenisPo" data-live-search="true" data-size="4" data-title="Pilih Jenis" required>
                                <?php foreach ($jenisKaos as $key => $jen): ?>
                                <option value="<?php echo $jen['nama_jenis_kaos'] ?>"><?php echo $jen['nama_jenis_kaos'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label>Tanggal Produksi</label>
                            <input type="date" class="form-control" name="tanggalProd" required>
                        </div>
                        <div class="form-group">
                            <label>Kategori Po</label>
                            <select class="form-control selectpicker kategoriPo" name="kategoriPo" title="select jenis po" required >
                                <option value="DALAM">DALAM</option>
                                <option value="LUAR">LUAR</option>
                            </select>
                        </div>
                        <div class="form-group pemilikPO hide">
                            <label>Pemilik PO</label>
                            <input type="text" class="form-control pemilikPO" name="pemilikPO" value="-" required>
                        </div>
                        <div class="form-group">
                            <label>Kode Artikel</label>
                            <input type="text" class="form-control artikel" name="artikel" value="" required >
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
                        <a href="<?php echo BASEURL.'konveksi/produksipo'?>" class="btn btn-danger">Batal</a>
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