<form method="post" action="<?php echo $action?>">    
<div class="row">
    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Tanggal</label>
                                    <input type="text" name="creted_date" value="<?php echo date('Y-m-d')?>" class="form-control datepicker">
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
                            <div class="col-md-4"></div>
                            <div class="col-md-12">
                                <table class="table table-bordered" id="item_table">
                                    <tr>
                                        <th>Nama PO</th>
                                        <th>Jumlah PCS</th>
                                        <th>Harga/PCS</th>
                                        <!--<th>Harga Per Titik</th>
                                        <th>Jumlah RP</th>-->
                                        <th>Keterangan</th>
                                        <th width="20"><button type="button" name="add" class="btn btn-success btn-sm addborongan"><i class="fa fa-plus"></i></button></th>
                                    </tr>
                                </table>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-info btn-sm">Simpan</button>
                                <a href="<?php echo BASEURL?>Finishing/buangbenang" class="btn btn-danger btn-sm text-white">Batal</a>
                            </div>
                        </div>
    </div>
</div>
</form>
<script type="text/javascript">
$(document).ready(function(){
	var i=0;
    $(document).on('click', '.addborongan', function(){
        var html = '';
        html += '<tr>';
        html += '<td width="300"><select type="text" class="form-control select2bs4 kodepo" name="products['+i+'][kode_po]" data-size="4" data-live-search="true" data-title="Pilih item" required><option value="">Pilih PO</option><?php foreach ($kodepo as $key => $po) { ?><option value="<?php echo $po['kode_po'] ?>" data-item="<?php echo $po['kode_po'] ?>"><?php echo $po['nama_po'].' '.$po['kode_po'] ?></option><?php } ?></select></td>';
        html += '<td><input type="text" class="form-control jumlahPc" name="products['+i+'][jumlah_pcs]"  required ></td>';
        html += '<td><input type="number" class="form-control harga" name="products['+i+'][harga]" required ></td>';
        //html += '<td><input type="number" class="form-control jumlah" name="pricePerTitik[]" required ></td>';
        //html += '<td><input type="number" class="form-control jumlahRp" name="jumlahRp[]" required ></td>';
        html += '<td><input type="text" class="form-control keterangan" name="products['+i+'][keterangan]" value="-" required ></td>';
        html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button></td></tr>';
        i++;
        $('#item_table').append(html);
        //$('.select2bs4').selectpicker('refresh');
        $('.select2bs4').select2();
     });

    $(document).on('click', '.remove', function(){
        $(this).closest('tr').remove();
    });
    $(document).on('change', '.select2bs4', function(e){
        var dataItem = $(this).find(':selected').data('item');
        var dai = $(this).closest('tr');
        var jumlahItem = $('#piecesPo').val();
        $.get( "<?php echo BASEURL.'finishing/biaya_finishing' ?>", { kodepo: dataItem } )
          .done(function( data ) {
            var obj = JSON.parse(data);
            //alert(data);
            if(obj.biaya==0){
                alert("Biaya belum di setting. Silahkan hubungi SPV !");dai.remove();return false;
            }
            dai.find(".jumlahPc").val(obj.jumlah_pcs_po);
            dai.find(".harga").val(obj.biaya);
        });
    });
});
 </script>	