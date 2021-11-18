<form action="<?php echo BASEURL.'gudang/outbahanOnPrint' ?>" method="post">
    <div class="row">
        <div class="form-group col-3">
                                <label>No Faktur</label>
                                <input type="text" class="form-control" name="noFaktur" value="<?php echo generateReferenceNumber(); ?>" readonly>
                            </div>
                            <div class="form-group col-3">
                                <label>Pembuatan </label>
                                <input type="text" class="form-control"  name="tujuanItem">
                            </div>
                            <div class="form-group col-3">
                                <label>Nama PO </label>
                                <select class="form-control autopo" title="Pilih PO" name="namaPo" id="namapo" data-size="5"  data-live-search="true" required>
                                </select>
                            </div>
                            <div class="form-group col-3">
                                <label>Proggress</label>
                                <select class="form-control select2bs4" name="proggress" title="Pilih PO" required>
                                    <?php foreach ($proggres as $key => $prog): ?>
                                        <option value="<?php echo $prog['id_proggresion_po'] ?>"><?php echo $prog['nama_progress'] ?></option>   
                                    <?php endforeach ?>
                                </select>
                            </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered" id="addbahankeluar">
                <tr>
                    <th>Nama Barang</th>
                    <th>Warna</th>
                    <th>Ukuran</th>
                    <th>Satuan</th>
                    <th>Jumlah</th>
                    <th>Satuan</th>
                    <th>Harga Satuan</th>
                    <th>BAHAN U/</th>
                    <th><button type="button" name="add" class="btn btn-success btn-sm addbahankeluar"><i class="fa fa-plus"></i></button></th>
                </tr>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <button type="submit" class="btn btn-info btn-sm">Simpan</button>
            <a href="<?php echo BASEURL.'Gudang/pengeluaranbahan';?>" class="btn btn-sm btn-danger text-white">Kembali</a>
        </div>
    </div>
</form>
<script type="text/javascript">
$(document).ready(function(){
    $(document).on('click', '.addbahankeluar', function(){
        var html = '';
        html += '<tr>';
        html += '<td style="display:none;"><input type="hidden" class="form-control id" name="id[]" ></td>';
        html += '<td><select type="text" class="form-control selectpicker" name="nama[]" data-live-search="true" data-title="Pilih item" required><?php foreach ($barang as $key => $item) { ?><option value="<?php echo $item['nama_item'] ?>" data-item="<?php echo $item['id_persediaan'] ?>"><?php echo $item['nama_item'] ?></option><?php } ?></select></td>';
        html += '<td><input type="text" class="form-control warna" name="warna[]" ></td>';
        html += '<td><input type="number" class="form-control ukuran" name="ukuran[]" min="0" step=0.01 required></td>';
        html += '<td><select class="form-control satuanUkran" name="satuanUkran[]" readonly><?php foreach ($satuan as $key => $satt): ?><option value="<?php echo $satt['kode_satuan_barang'] ?>"><?php echo $satt['kode_satuan_barang'] ?></option><?php endforeach ?></select></td>';
        html += '<td><input type="number" class="form-control jumlah" step=0.01 name="jumlah[]" ></td>';
        html += '<td><select class="form-control satuanJml" name="satuanJml[]" readonly><?php foreach ($satuan as $key => $satt): ?><option value="<?php echo $satt['kode_satuan_barang'] ?>"><?php echo $satt['kode_satuan_barang'] ?></option><?php endforeach ?></select></td>';
        html += '<td><input type="number" class="form-control harga" name="harga[]" required></td>';
        html += '<td><select class="form-control bahanUntuk" name="bahanUntuk[]"><option value="UTAMA">UTAMA</option><option value="CELANA">CELANA</option><option value="KAINKANTONG">KAINKANTONG</option><option value="VARIASI">VARIASI</option></select></td>';
        html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button></td></tr>';
        $('#addbahankeluar').append(html);
        $('.selectpicker').selectpicker('refresh');
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
            dai.find(".jumlah").attr('max',obj.jumlah_item);
            dai.find(".harga").val(obj.harga_item)
        });
    });
});
</script>
<?php if($lockdouble==1){?>
<script>
$(document).on('change', '#namapo', function(e){
        var dataItem = $(this).val();
        //console.log(dataItem);
        $.get( "<?php echo BASEURL.'gudang/itemkeluarpo' ?>", { kode_po: dataItem } )
          .done(function( data ) {
            if(data=="OK"){

            }else{
                //alert("Kode PO "+ dataItem +" sudah pernah diinput");
                //location.reload();
            }
        });
    });
 </script>
<?php } ?>