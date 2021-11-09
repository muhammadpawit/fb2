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
                            <h4 class="header-title m-t-0 m-b-20">ITEM MASUK(EDIT)</h4>
                        </div>
                        
                    </div>
                    <hr>
                   <form action="<?php echo BASEURL.'gudang/itemkeluareditOnCreate' ?>" method="POST">
                            
                        <div class="row">
                            <div class="form-group col-2">
                                <label>No Faktur</label>
                                <input type="text" class="form-control" name="noFaktur" value="<?php echo $barang[0]['faktur_no']; ?>" readonly>
                            </div>
                            <div class="form-group col-4">
                                <label>Nama Penerima</label>
                                <input type="text" class="form-control" name="namaPenerima" value="<?php echo $barang[0]['nama_penerima']; ?>" required>
                            </div>
                            <div class="form-group col-4">
                                <label>Tujuan </label>
                                <input type="text" class="form-control" value="<?php echo $barang[0]['tujuan_item']; ?>" name="tujuanItem">
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
                                    <th>Item Perlusin</th>
                                    <th><button type="button" name="add" class="btn btn-success btn-sm add"><i class="fa fa-plus"></i></button></th>
                                </tr>
                                    <?php foreach ($barang as $key => $item): ?>
                                <tr>
                                    <td>
                                        <input type="hidden" value="<?php echo $item['id_item_keluar'] ?>" name="id[]">
                                        <input type="text" class="form-control" name="nama[]" value="<?php echo $item['nama_item_keluar'] ?>" required>
                                    </td>
                                    <td><input type="text" value="<?php echo $item['warna_item_keluar'] ?>" class="form-control" name="warna[]" ></td>
                                    <td><input type="number" class="form-control" name="ukuran[]" value="<?php echo $item['ukuran_item_keluar'] ?>" step=0.01 required></td>
                                    <td>
                                        <select class="form-control" name="satuanUkran[]">
                                            <option value="<?php echo $item['satuan_item_keluar'] ?>">CM</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" name="jumlah[]" value="<?php echo $item['jumlah_item_keluar'] ?>" step=0.01 required>
                                    </td>
                                    <td>
                                        <select class="form-control" name="satuanJml[]">
                                            <option value="<?php echo $item['satuan_jumlah_keluar'] ?>">PCS</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" name="harga[]" value="<?php echo $item['harga_item'] ?>" required>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control itemPerlusin" name="itemPerlusin[]" value="<?php echo $item['jumlah_item_perlusin'] ?>" required>
                                    </td>
                                    <td><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button></td>
                                </tr>
                                    <?php endforeach ?>

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
    html += '<td><input type="color" value="ffcc00" class="form-control" name="warna[]" ></td>';
    html += '<td><input type="number" class="form-control" name="ukuran[]" step=0.01 required></td>';
    html += '<td><select class="form-control" name="satuanUkran[]"><option>CM</option></select></td>';
    html += '<td><input type="number" class="form-control" name="jumlah[]" step=0.01 required></td>';
    html += '<td><select class="form-control" name="satuanJml[]"><option>PCS</option></select></td>';
    html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button></td></tr>';
    $('#item_table').append(html);
 });

$(document).on('click', '.remove', function(){
    $(this).closest('tr').remove();
});
    
});
 </script>