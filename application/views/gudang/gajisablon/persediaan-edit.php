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
                            <h4 class="header-title m-t-0 m-b-20">Persediaan Edit</h4>
                        </div>
                        <div class="col-6 text-right">
                            <button class="btnDuplicate btn btn-warning">Duplicate</button>
                        </div>
                    </div>
                    <hr>
                   <form action="<?php echo BASEURL.'gudang/persediaanEditOnUpdate' ?>" method="POST">
                                  
                        <div class="row">
                            <div class="form-group col-2">
                                <label>Kode Transfer</label>
                                <input type="text" class="form-control" name="kodeTf" value="<?php echo $persediaan['kode_transfer']  ?>" readonly>
                            </div>
                            <div class="form-group col-4">
                                <label>Nama Supplier</label>
                                <input type="text" class="form-control" value="<?php echo $persediaan['nama_supplier']  ?>" name="nama_supplier" required>
                            </div>
                            <div class="form-group col-4">
                                <label>Contact Supplier</label>
                                <input type="text" class="form-control" name="contact_supp" value="<?php echo $persediaan['contact_supplier']  ?>">
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
                                <tr>
                                    <td>
                                        <input type="hidden" value="<?php echo $persediaan['id_persediaan'] ?>" name="id[]">
                                        <input type="text" class="form-control" value="<?php echo $persediaan['nama_item'] ?>" name="nama[]" required >
                                    </td>
                                    <td>
                                        <input type="text" value="<?php echo $persediaan['warna_item'] ?>" class="form-control" name="warna[]" >
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" value="<?php echo $persediaan['ukuran_item'] ?>" step=0.01 name="ukuran[]" required>
                                    </td>

                                    <td><select class="form-control satuanUkran" name="satuanUkran[]"><?php foreach ($satuan as $key => $satt): ?><option <?php if ($satt['kode_satuan_barang'] == $persediaan['satuan_ukuran_item']) {
                                        echo "selected='selected'";
                                    } ?> value="<?php echo $satt['kode_satuan_barang'] ?>"><?php echo $satt['kode_satuan_barang'] ?></option><?php endforeach ?></select></td>
                                    <td>
                                        <input type="number" class="form-control" value="<?php echo $persediaan['jumlah_item'] ?>" step=0.01 name="jumlah[]" required>
                                    </td>
                                    <td><select class="form-control satuanJml" name="satuanJml[]"><?php foreach ($satuan as $key => $satt): ?><option <?php if ($satt['kode_satuan_barang'] == $persediaan['satuan_jumlah_item']) {
                                        echo "selected='selected'";
                                    } ?> value="<?php echo $satt['kode_satuan_barang'] ?>"><?php echo $satt['kode_satuan_barang'] ?></option><?php endforeach ?></select></td>
                                    <td>
                                        <input type="text" class="form-control" value="<?php echo $persediaan['harga_item'] ?>" name="hargaItem[]" required>
                                    </td>
                                    <td>
                                        <button type="button" name="btnRemove" class="btn btn-danger btn-sm remove" data-idrev="<?php echo $persediaan['id_persediaan'] ?>">
                                            <span class="fa fa-trash"></span>
                                        </button>
                                    </td>
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
    html += '<td><input type="text" value="ffcc00" class="form-control" name="warna[]" ></td>';
    html += '<td><input type="number" class="form-control" name="ukuran[]" step=0.01 required></td>';
    html += '<td><select class="form-control" name="satuanUkran[]"><option>CM</option></select></td>';
    html += '<td><input type="number" class="form-control" name="jumlah[]" step=0.01 required></td>';
    html += '<td><select class="form-control" name="satuanJml[]"><option>PCS</option></select></td>';
    html += '<td><input type="number" class="form-control" step=0.01 name="=hargaItem[]" required></td>';
    html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button></td></tr>';
    $('#item_table').append(html);
 });

$(document).on('click', '.remove', function(){
    $(this).closest('tr').remove();
    var idref = $(this).data('idrev');

    $.post( "<?php echo BASEURL.'gudang/deleteItemPerSatu' ?>", { id: idref }).done(function( data ) { 
    });
});
    
});
 </script>