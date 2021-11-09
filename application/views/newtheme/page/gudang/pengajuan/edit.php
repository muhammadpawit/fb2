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
                   <form action="<?php echo BASEURL.'pengajuan/harianeditAct' ?>" method="POST">
                            
                        <div class="row">
                            <div class="form-group col-2">
                                <label>Kode Transfer</label>
                                <input type="text" class="form-control" name="kodeTf" value="<?php echo $parent['kode_pengajuan']; ?>" readonly>
                            </div>
                            <div class="form-group col-3" >
                                <label>Tanggal</label>
                                <input type="date" class="form-control" name="tanggal" placeholder="Tanggal" value="<?php echo $parent['create_date'] ?>" required>
                            </div>
                            <div class="form-group col-2">
                                <label>Kategori</label>
                                <select class="form-control" name="kategoriPengajuan">
                                    <?php foreach (ketegoriPengajuan() as $key => $value): ?>
                                        <option <?php if ($key == $parent['kategori_pengajuan']) {
                                            echo "selected='selected'";
                                        } ?> value="<?php echo $key ?>"><?php echo $value ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class=" form-group col-3">
                                <label>Kas Masuk</label>
                                <input type="number" class="form-control" name="kasMasuk" placeholder="Kas Masuk" value="<?php echo $parent['kas_masuk'] ?>" required>
                            </div>
                            <div class="form-group col-3" >
                                <label>Transfer</label>
                                <input type="number" class="form-control" name="transfer" placeholder="Transfer" value="<?php echo $parent['transfer'] ?>" required>
                            </div>
                            <div class="form-group col-3" >
                                <label>Status Keuangan</label>
                                <select class="form-control" name="status_keu" required="">
                                    <option <?php if (0 == $parent['status_keu']) {
                                            echo "selected='selected'";
                                        } ?> value="0">Belum Di Bayar</option>
                                    <option <?php if (1 == $parent['status_keu']) {
                                            echo "selected='selected'";
                                        } ?> value="1">Sudah Di Bayar</option>
                                </select>
                            </div>
                            
                            <table class="table table-bordered" id="item_table">
                                <tr>
                                    <th>Nama Item</th>
                                    <th>Jumlah</th>
                                    <th>Satuan</th>
                                    <th>Harga</th>
                                    <th>Pembayaran</th>
                                    <th>Supplier</th>
                                    <th>Keterangtan</th>
                                    <th><button type="button" name="add" class="btn btn-success btn-sm add"><i class="fa fa-plus"></i></button></th>
                                </tr>
                                <?php foreach ($item as $key => $tem): ?>
                                    <tr>
                                        <input type="hidden" name="idPengajuan[]" value="<?php echo $tem['id_pengajuan_harian'] ?>">
                                        <td><input type="text" class="form-control" name="nama[]" value="<?php echo $tem['nama_item_ajuan'] ?>" required></td>
                                        <td><input type="text" class="form-control" name="jumlah[]" value="<?php echo $tem['jumlah_item'] ?>"></td>
                                        <td><input type="text" class="form-control" name="satuan[]" value="<?php echo $tem['satuan_item'] ?>"></td>
                                        <td><input type="number" class="form-control" name="harga[]" value="<?php echo $tem['harga_satuan'] ?>" required></td>';
                                        <td>
                                            <select class="form-control" name="pembayaran[]" required>
                                                <option <?php if ($tem['pembayaran'] == "TRANSFER") {
                                                    echo "selected='selected'";
                                                } ?> value="1">TRANSFER</option>
                                                <option <?php if ($tem['pembayaran'] == "CASH") {
                                                    echo "selected='selected'";
                                                } ?> value="2">CASH</option>
                                            </td>
                                        <td><input type="text" class="form-control" name="supplier[]" value="<?php echo $tem['supplier'] ?>" required></td>
                                        <td><input type="text" class="form-control" name="keterangan[]" value="<?php echo $tem['keterangan'] ?>" required></td>
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
    html += '<td><input type="text" class="form-control" name="jumlah[]" ></td>';
    html += '<td><input type="text" class="form-control" name="satuan[]"></td>';
    html += '<td><input type="number" class="form-control" name="harga[]" required></td>';
    html += '<td><select class="form-control" name="pembayaran" required><option value="1">TRANSFER</option><option value="2">CASH</option></td>';
    html += '<td><input type="text" class="form-control" name="supplier[]" required></td>';
    html += '<td><input type="text" class="form-control" name="keterangan[]" required></td>';
    html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button></td></tr>';
    $('#item_table').append(html);
 });

$(document).on('click', '.remove', function(){
    $(this).closest('tr').remove();
});
    
});
 </script>