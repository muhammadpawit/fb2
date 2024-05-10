 <form action="<?php echo BASEURL.'gudang/itemkeluarOnPrint' ?>" method="POST">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Tanggal</label>
                <input type="text" name="tanggal" class="form-control datepicker" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>No Faktur</label>
                <input type="text" class="form-control" name="noFaktur" value="<?php echo generateReferenceNumber(); ?>" readonly>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="form-group">
                <label>Tujuan </label>
                <input type="text" class="form-control"  name="tujuanItem">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Nama Penerima</label>
                <input type="text" class="form-control" name="namaPenerima"  required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Nama PO </label>
                <select class="form-control autopoid" title="Pilih PO" name="namaPo" id="po" data-size="5" data-live-search="true">
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Proggress</label>
                <select class="form-control select2bs4" name="proggress" title="Pilih PO" >
                    <option value="">Pilih</option>
                    <?php foreach ($proggres as $key => $prog): ?>
                        <option value="<?php echo $prog['id_proggresion_po'] ?>"><?php echo $prog['nama_progress'] ?></option>   
                    <?php endforeach ?>
                </select>
            </div>
        </div>
        
    </div>
    <div class="row">
        
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <table class="table table-bordered" id="addalat">
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Warna</th>
                                    <th>Ukuran</th>
                                    <th>Satuan</th>
                                    <th>Jumlah</th>
                                    <th>Satuan</th>
                                    <th>Harga Satuan</th>
                                    <th>Item Perlusin</th>
                                    <th><button type="button" name="add" class="btn btn-success btn-sm addalat"><i class="fa fa-plus"></i></button></th>
                                </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <a href="<?php echo $kembali?>" class="btn btn-danger text-white" style="width:100%;">Batal</a>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <button type="submit" class="btn btn-info text-white" style="width:100%;">Simpan</button>
            </div>
        </div>
    </div>
 </form>
 <script type="text/javascript">
    $( "#po" ).change(function() {
        $('#sub3').empty();
      val = $(this).val();
      //alert(val);
      $.get("<?php echo BASEURL.'Gudang/cekalatkeluar' ?>?&kode_po="+val, 
        function(data){   
        console.log(data);
        if(data=="ok"){
            //alert("Item Keluar dengan PO "+val+" sudah pernah diinput ");
            //location.reload();
        }
      });
    });
$(document).ready(function(){
    $(document).on('click', '.addalat', function(){
        var html = '';
        html += '<tr>';
        html += '<td style="display:none;"><input type="hidden" class="form-control id" name="id[]" ></td>';
        html += '<td><select type="text" class="form-control selectpicker" name="nama[]" data-live-search="true" data-title="Pilih item" required><option value="">Pilih</option><?php foreach ($barang as $key => $item) { ?><option value="<?php echo $item['nama_item'] ?>" data-item="<?php echo $item['id_persediaan'] ?>"><?php echo strtolower($item['nama_item']) ?></option><?php } ?></select></td>';
        html += '<td><input type="hidden" class="form-control id_persediaan" name="id_persediaan[]"><input type="text" class="form-control warna" name="warna[]"></td>';
        html += '<td><input type="text" class="form-control ukuran" name="ukuran[]"  required></td>';
        html += '<td><input class="form-control satuanUkran" name="satuanUkran[]" readonly></td>';
        html += '<td><input type="text" class="form-control jumlah"  name="jumlah[]" ></td>';
        html += '<td><input class="form-control satuanJml" name="satuanJml[]" readonly></td>';
        html += '<td><input type="number" class="form-control harga" name="harga[]" required></td>';
        html += '<td><input type="text" class="form-control itemPerlusin" name="itemPerlusin[]" required></td>';
        html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button></td></tr>';
        $('#addalat').append(html);
        //$('.selectpicker').selectpicker('refresh');
        $('.selectpicker').select2();
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
            dai.find(".id_persediaan").val(obj.id_persediaan);
            dai.find(".warna").val(obj.warna_item);
            dai.find(".ukuran").val(obj.ukuran_item);
            dai.find(".satuanUkran").val(obj.satuan_ukuran_item);
            dai.find(".jumlah").val(obj.quantity);
            dai.find(".satuanJml").val(obj.satuan_jumlah_item);
            dai.find(".id").val(obj.id_persediaan);
            // dai.find(".jumlah").attr('max',obj.jumlah_item);
            dai.find(".jumlah").attr('max',obj.quantity);
            dai.find(".harga").val(obj.harga_item);
        });
    });
});
 </script>