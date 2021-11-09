<style type="text/css">
   
</style>
<!-- Start Page content -->
<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">

                <div class="card-box">
                    <div class="row">
                        <div class="col-6">
                            <h4 class="header-title m-t-0 m-b-20">Item Masuk</h4>
                        </div>
                    </div>
                    <hr>
                   <form action="<?php echo BASEURL.'gudang/itemmasukOnCreate' ?>" method="POST">
                            
                        <div class="row">
                            <div class="form-group col-2">
                                <label>Kode Transfer</label>
                                <input type="text" class="form-control" name="kodeTf" value="<?php echo generateReferenceNumber(); ?>" readonly>
                            </div>
                            <div class="form-group col-4">
                                <label>Nama Supplier</label>
                                <input type="text" class="form-control" name="nama_supplier" required>
                            </div>
                            <div class="form-group col-4">
                                <label>Contact Supplier</label>
                                <input type="text" class="form-control" name="contact_supp">
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
                                    <th><button type="button" name="add" class="btn btn-success btn-sm add"><i class="fa fa-plus"></i></button></th>
                                </tr>
                            </table>
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
 <script src="<?php echo ASSETS ?>js/jscolor.js"></script>
 <script type="text/javascript">
$(document).ready(function(){
$(document).on('click', '.add', function(){
    var html = '';
    html += '<tr>';
    html += '<td><input type="text" class="form-control" name="nama[]" required></td>';
    html += '<td><input type="text" class="form-control" name="warna[]" ></td>';
    html += '<td><input type="number" class="form-control" name="ukuran[]" step=0.01 required></td>';
    html += '<td><select class="form-control" name="satuanUkran[]"><?php foreach ($satuan as $key => $satt): ?><option value="<?php echo $satt['kode_satuan_barang'] ?>"><?php echo $satt['kode_satuan_barang'] ?></option><?php endforeach ?></select></td>';
    // html += '<td><input class="form-control" name="satuanUkran[]" required></td>';
    html += '<td><input type="number" class="form-control" name="jumlah[]" step=0.01 required></td>';
    html += '<td><select class="form-control" name="satuanJml[]"><?php foreach ($satuan as $key => $satt): ?><option value="<?php echo $satt['kode_satuan_barang'] ?>"><?php echo $satt['kode_satuan_barang'] ?></option><?php endforeach ?></select></td>';
    // html += '<td><input class="form-control" name="satuanJml[]" required></td>';
    html += '<td><input type="number" class="form-control" name="hargaItem[]" required></td>';
    html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button></td></tr>';
    $('#item_table').append(html);
 });

$(document).on('click', '.remove', function(){
    $(this).closest('tr').remove();
});
    
});
 </script>