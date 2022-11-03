<form class="form-group" method="post" action="<?php echo $action?>">
              <div class="row">
                <div class="col-6">
                  <div class="form-group">
                    <label>Tanggal</label>
                    <input type="text" name="tanggal" class="form-control" value="<?php echo date('Y-m-d')?>">
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label>Bagian</label>
                    <select name="bagian" class="form-control select2bs4" data-live-search="true">
                      <option value="-">Pilih</option>
                      <?php foreach($bagian as $p){?>
                        <option value="<?php echo $p['id']?>"><?php echo $p['nama']?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label>Pengambil</label>
                    <textarea class="form-control" name="pengambil" required placeholder="nama pengambil"></textarea>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label>Gudang</label>
                    <textarea class="form-control" name="gudang" required>Pusat</textarea>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                    <table class="table table-bordered" id="addbahankeluars">
                      <tr>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                        <th>Keterangan</th>
                        <th><button type="button" name="add" class="btn btn-success btn-sm addbahankeluars"><i class="fa fa-plus"></i></button></th>
                      </tr>
                    </table>                  
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                    <div class="form-group">
                      <button type="submit" class="btn btn-success text-white">Simpan</button>
                      <a href="<?php echo $cancel?>" class="btn btn-danger text-white">Batal</a>
                    </div>
                </div>
              </div>
            </form>

<script type="text/javascript">
$(document).ready(function(){
    var i=0;
    $(document).on('click', '.addbahankeluars', function(){
        var html = '';
        html += '<tr>';
        html += '<td style="display:none;"><input type="hidden" class="form-control id" name="products['+i+'][idpersediaan]" ><input type="hidden" class="form-control harga" name="products['+i+'][harga]" ></td>';
        html += '<td><select type="text" class="form-control barang select2bs4" name="products['+i+'][nama]" data-live-search="true" data-title="Pilih item" required><option value="">Pilih</option><?php foreach ($barang as $key => $item) { ?><option value="<?php echo $item['nama_item'] ?>" data-item="<?php echo $item['id_persediaan'] ?>"><?php echo $item['nama_item'] ?></option><?php } ?></select></td>';
        html += '<td><input type="number" class="form-control jumlah" name="products['+i+'][jumlah]" ></td>';
        html += '<td><select class="form-control satuanJml" name="products['+i+'][satuan]" readonly><?php foreach ($satuan as $key => $satt): ?><option value="<?php echo $satt['kode_satuan_barang'] ?>"><?php echo $satt['kode_satuan_barang'] ?></option><?php endforeach ?></select></td>';
        html += '<td><input type="text" class="form-control" name="products['+i+'][keterangan]"></td>';
        html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button></td></tr>';
        i++;
        $('#addbahankeluars').append(html);
         //$('.selectpicker').selectpicker('refresh');
        $('.barang').select2();
        //$('.barang').select2({
          //theme: 'bootstrap4'
        //});
     });

    $(document).on('click', '.remove', function(){
        $(this).closest('tr').remove();
    });
    $(document).on('change', '.barang', function(e){
        var dataItem = $(this).find(':selected').data('item');
        var dai = $(this).closest('tr');
        var jumlahItem = $('#piecesPo').val();
        $.get( "<?php echo BASEURL.'gudang/itemkeluarSearchId' ?>", { id: dataItem } )
          .done(function( data ) {
            var obj = JSON.parse(data);
            console.log(obj);
            dai.find(".jumlah").val(obj.jumlah_item);
            dai.find(".satuanJml").val(obj.satuan_jumlah_item);
            dai.find(".id").val(obj.id_persediaan);
            dai.find(".harga").val(obj.harga_item);
            // dai.find(".jumlah").attr('max',obj.jumlah_item);
        });
    });
});
 </script>      