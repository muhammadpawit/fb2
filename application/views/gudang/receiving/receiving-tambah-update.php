
<link href="<?php echo PLUGINS ?>bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" />
<style type="text/css">
   div.dropdown-menu.open{
      max-height: 200px !important;
      overflow: hidden;
    }
    ul.dropdown-menu.inner{
      max-height: 200px !important;
      overflow-y: auto;
    }
</style>
<!-- Start Page content -->
<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">

                <div class="card-box">
                    <div class="row">
                        <div class="col-6">
                            <h4 class="header-title m-t-0 m-b-20">Item Tambah Update</h4>
                        </div>
                        <div class="col-md-12">
                            <div class="alert alert-danger" role="alert">
                                PERHATIKAN FORM ADD ITEM NYA <strong>PADA PENGACUAN DATA NYA</strong> JANGAN ASAL SUBMIT !!!!!!!
                            </div>
                        </div>
                        
                    </div>
                    <hr>
                   <form action="<?php echo BASEURL.'gudang/itemmasukupdateMasukOnCreate' ?>" method="POST">
                            
                        <div class="row">
                            <div class="form-group col-2">
                                <label>No Faktur</label>
                                <input type="text" class="form-control" name="kodeTF" value="<?php echo generateReferenceNumber(); ?>" readonly>
                            </div>
                            <div class="form-group col-3">
                                <label>Nama Supplier</label>
                                <input type="text" class="form-control" name="namaSupplier"  required>
                            </div>
                            <div class="form-group col-3">
                                <label>Contact Supplier </label>
                                <input type="text" class="form-control"  name="contact_supp">
                            </div>
                            
                            
                            <table class="table table-bordered" id="item_table">
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Warna</th>
                                    <th>Ukuran</th>
                                    <th>Satuan</th>
                                    <th>Jumlah</th>
                                    <th>Satuan</th>
                                    <th>Harga Satuan</th>
                                    <th><button type="button" name="add" class="btn btn-success btn-sm add" ><i class="fa fa-plus"></i></button></th>
                                </tr>
                            </table>
                            <hr>
                            <table class="table table-bordered" id="item_table2">
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Warna</th>
                                    <th>Ukuran</th>
                                    <th>Satuan</th>
                                    <th>Jumlah</th>
                                    <th>Satuan</th>
                                    <th>Harga Satuan</th>
                                    <th><button type="button" name="add" class="btn btn-success btn-sm add2" ><i class="fa fa-plus"></i></button></th>
                                </tr>
                            </table>
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
        html += '<td style="display:none;"><input type="hidden" class="form-control id" name="id[]" ></td>';
        html += '<td><select type="text" data-dropup-auto="false" data-size="5" class="form-control selectpicker" data-live-search="true" data-title="pilih item" name="nama[]" required><?php foreach ($barang as $key => $item) { ?><option value="<?php echo $item['nama_item'] ?>" data-item="<?php echo $item['id_persediaan'] ?>"><?php echo $item['nama_item'] ?></option><?php } ?></select></td>';
        html += '<td><input type="text" class="form-control warna" name="warna[]" ></td>';
        html += '<td><input type="number" class="form-control ukuran" name="ukuran[]" step=0.01 required></td>';
        html += '<td><select class="form-control satuanUkran" name="satuanUkran[]"><?php foreach ($satuan as $key => $satt): ?><option value="<?php echo $satt['kode_satuan_barang'] ?>"><?php echo $satt['kode_satuan_barang'] ?></option><?php endforeach ?></select></td>';
        html += '<td><input type="number" class="form-control jumlah" step=0.01 name="jumlah[]" ></td>';
        html += '<td><select class="form-control satuanJml" name="satuanJml[]"><?php foreach ($satuan as $key => $satt): ?><option value="<?php echo $satt['kode_satuan_barang'] ?>"><?php echo $satt['kode_satuan_barang'] ?></option><?php endforeach ?></select></td>';
        html += '<td><input type="number" class="form-control harga" name="harga[]" required></td>';
        html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button></td></tr>';
        $('#item_table').append(html);
        $('.selectpicker').selectpicker({
   size: '5'
});
        $('.selectpicker').selectpicker('refresh');
     });
    $(document).on('click', '.add2', function(){
        var html2 = '';
            html2 += '<tr>';
            html2 += '<td style="display:none;"><input type="hidden" class="form-control id" name="id[]" ></td>';
            html2 += '<td><input type="text" class="form-control" name="nama[]"></td>';
            html2 += '<td><input type="text"  class="form-control warna" name="warna[]" ></td>';
            html2 += '<td><input type="number" class="form-control ukuran" name="ukuran[]" step=0.01 required></td>';
            html2 += '<td><select class="form-control satuanUkran" name="satuanUkran[]"><?php foreach ($satuan as $key => $satt): ?><option value="<?php echo $satt['kode_satuan_barang'] ?>"><?php echo $satt['kode_satuan_barang'] ?></option><?php endforeach ?></select></td>';
            html2 += '<td><input type="number" class="form-control jumlah" step=0.01 name="jumlah[]" ></td>';
            html2 += '<td><select class="form-control satuanJml" name="satuanJml[]"><?php foreach ($satuan as $key => $satt): ?><option value="<?php echo $satt['kode_satuan_barang'] ?>"><?php echo $satt['kode_satuan_barang'] ?></option><?php endforeach ?></select></td>';
            html2 += '<td><input type="number" class="form-control harga" name="harga[]" required></td>';
            html2 += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button></td></tr>';
            $('#item_table2').append(html2);
    });

    $(document).on('click', '.remove', function(){
        $(this).closest('tr').remove();
    });
    $(document).on('change', '.selectpicker', function(e){
        var dataItem = $(this).find(':selected').data('item');
        var dai = $(this).closest('tr');
        var jumlahItem = $('#piecesPo').val();
        $.get( "<?php echo BASEURL.'gudang/itemkeluarSearchId' ?>", { id: dataItem } )
          .done(function( data ) {
            var obj = JSON.parse(data);
            console.log(obj);
            dai.find(".warna").val(obj.warna_item);
            dai.find(".ukuran").val(obj.ukuran_item);
            dai.find(".satuanUkran").val(obj.satuan_ukuran_item);
            dai.find(".jumlah").val(obj.jumlah_item);
            dai.find(".satuanJml").val(obj.satuan_jumlah_item);
            dai.find(".id").val(obj.id_persediaan);
            dai.find(".harga").val(obj.harga_item)
        });
    });
});
 </script>