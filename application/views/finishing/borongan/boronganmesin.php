
<link href="<?php echo PLUGINS ?>bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" />
<style type="text/css">
   
</style>
<!-- Start Page content -->
<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">

                <div class="card-box">
                    <?php if ($this->session->flashdata('msg')) { ?>
                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                           <?php echo $this->session->flashdata('msg'); ?> 
                    </div>
                       <?php } ?>
                    <div class="row">
                        <div class="col-6">
                            <h4 class="header-title m-t-0 m-b-20">Borongan Finishing</h4>
                        </div>
                    </div>
                    <hr>
                   <form action="<?php echo BASEURL.'finishing/boronganmesinInsert' ?>" method="POST">
                            
                    <div class="form-control">
                        <label>Tanggal</label>
                        <input type="date" name="tanggalMulai" required class="form-control">
                    </div>
                    <div class="form-control">
                        <label>Kategori</label>
                        <select class="form-control" name="kategoriBorongan">
                            <option value="LOBANG KANCING">LOBANG KANCING</option>
                            <option value="TRESS">TRESS</option>
                            <option value="PASANG KANCING">PASANG KANCING</option>
                            <option value="CUCIAN">CUCIAN</option>
                            <option value="PACKING">PACKING</option>
                        </select>
                    </div>
                    <table class="table table-bordered" id="item_table">
                        <tr>
                            <th>Nama PO</th>
                            <th>Jumlah PC</th>
                            <th>Jumlah Titik</th>
                            <th>Harga Per Titik</th>
                            <th>Jumlah RP</th>
                            <th>Keterangan</th>
                            <th><button type="button" name="add" class="btn btn-success btn-sm add"><i class="fa fa-plus"></i></button></th>
                        </tr>
                    </table>

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
        html += '<td><select type="text" class="form-control selectpicker kodepo" name="kodepo[]" data-size="4" data-live-search="true" data-title="Pilih item" required><?php foreach ($kodepo as $key => $po) { ?><option value="<?php echo $po['kode_po'] ?>" data-item="<?php echo $po['kode_po'] ?>"><?php echo $po['nama_po'].' '.$po['kode_po'] ?></option><?php } ?></select></td>';
        html += '<td><input type="text" class="form-control jumlahPc" name="jumlahpcs[]"  required ></td>';
        html += '<td><input type="number" class="form-control jumlahtitik"  name="jumlahtitik[]" required ></td>';
        html += '<td><input type="number" class="form-control jumlah" name="pricePerTitik[]" required ></td>';
        html += '<td><input type="number" class="form-control jumlahRp" name="jumlahRp[]" required ></td>';
        html += '<td><input type="text" class="form-control keterangan" name="keterangan[]" required ></td>';
        html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button></td></tr>';
        $('#item_table').append(html);
        $('.selectpicker').selectpicker('refresh');
     });

    $(document).on('click', '.remove', function(){
        $(this).closest('tr').remove();
    });
    $(document).on('change', '.selectpicker', function(e){
        var dataItem = $(this).find(':selected').data('item');
        var dai = $(this).closest('tr');
        var jumlahItem = $('#piecesPo').val();
        $.get( "<?php echo BASEURL.'finishing/kirimgudangsendRincinan' ?>", { kodepo: dataItem } )
          .done(function( data ) {
            var obj = JSON.parse(data);
            console.log(obj);
            dai.find(".jumlahPc").val(obj.jumlah_pcs_po);
        });
    });
});
 </script>