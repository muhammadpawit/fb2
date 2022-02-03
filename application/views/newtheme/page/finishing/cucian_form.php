<form method="post" action="<?php echo $action?>">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Tanggal Masuk Cucian</label>
                                    <input type="text" name="creted_date" class="form-control datepicker" required="required">
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Keluar Cucian</label>
                                    <input type="text" name="tglkeluar" class="form-control datepicker" required="required">
                                </div>
                                <div class="form-group">
                                    <label>Nama Karyawan</label>
                                    <select name="idkaryawanharian" class="form-control select2bs4" data-live-search="true">
                                        <option value="">Pilih</option>
                                        <?php foreach($karyawan as $k){?>
                                            <option value="<?php echo $k['id']?>"><?php echo $k['nama']?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label>Masuk Gajian</label>
                                <select name="jenis" class="form-control">
                                    <option value="1">Ya</option>
                                    <option value="2">Tidak</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <table class="table table-bordered" id="item_table">
                                    <tr>
                                        <th>Nama PO</th>
                                        <th>Jumlah PCS</th>
                                        <th>Harga/PCS</th>
                                        <!--<th>Harga Per Titik</th>
                                        <th>Jumlah RP</th>-->
                                        <th>Keterangan</th>
                                        <th><button type="button" name="add" class="btn btn-success btn-sm addborongan"><i class="fa fa-plus"></i></button></th>
                                    </tr>
                                </table>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-info">Simpan</button>
                            </div>
                        </div>
                    </form>
<script type="text/javascript">
$(document).ready(function(){
	var i=0;
    $(document).on('click', '.addborongan', function(){
        var html = '';
        html += '<tr>';
        html += '<td><select type="text" class="form-control selectpicker kodepo" name="products['+i+'][kode_po]" data-size="4" data-live-search="true" data-title="Pilih item" required><?php foreach ($kodepo as $key => $po) { ?><option value="<?php echo $po['kode_po'] ?>" data-item="<?php echo $po['kode_po'] ?>"><?php echo $po['nama_po'].' '.$po['kode_po'] ?></option><?php } ?></select></td>';
        html += '<td><input type="text" class="form-control jumlahPc" name="products['+i+'][jumlah_pcs]"  required ></td>';
        html += '<td><input type="number" class="form-control harga" name="products['+i+'][harga]" required ></td>';
        //html += '<td><input type="number" class="form-control jumlah" name="pricePerTitik[]" required ></td>';
        //html += '<td><input type="number" class="form-control jumlahRp" name="jumlahRp[]" required ></td>';
        html += '<td><input type="text" class="form-control keterangan" name="products['+i+'][keterangan]" value="-" required ></td>';
        html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button></td></tr>';
        i++;
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