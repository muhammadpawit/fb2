<form method="post" action="<?php echo $action?>">
    <input type="hidden" name="kategoriBorongan" value="PACKING">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal</label>
                                    <input type="text" name="creted_date" value="<?php echo date('Y-m-d') ?>" class="form-control datepicker" required readonly>
                                </div>
                                <!-- <div class="form-group">
                                    <label>Kategori</label><br>
                                    <select class="form-control select2bs4" name="kategoriBorongan" data-live-search="true">
                                        <option value="PACKING" selected="selected">PACKING</option>
                                    </select>
                                </div> -->
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Karyawan</label><br>
                                    <select name="idkaryawanharian" class="form-control select2bs4" data-live-search="true" required>
                                        <option value="">Pilih</option>
                                        <?php foreach($karyawan as $k){?>
                                            <option value="<?php echo $k['id']?>"><?php echo $k['nama']?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Masuk Gajian</label><br>
                                    <select name="masuk_gajian" id="masuk_gajian" class="form-control select2bs4" required>
                                        <option value="Ya" selected>Ya</option>
                                        <option value="Tidak">Tidak</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <table class="table table-bordered" id="item_table">
                                    <tr>
                                        <th>Nama PO</th>
                                        <th>Dz Potongan</th>
                                        <th>Jumlah DZ</th>
                                        <!-- <th>Jumlah Titik</th> -->
                                        <th>Harga Per DZ</th>
                                        <!--<th>Jumlah RP</th>-->
                                        <th>Keterangan</th>
                                        <th width="20"><button type="button" name="add" class="btn btn-success btn-sm addborongan"><i class="fa fa-plus"></i></button></th>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <a href="<?php echo BASEURL?>Finishing/packing" class="btn btn-danger full">Batal</a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-info full">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </form>
<script type="text/javascript">
$(document).ready(function(){
    $(document).on('change', 'select[name="idkaryawanharian"]', function(){
        var nama_karyawan = $(this).find('option:selected').text().toLowerCase();
        
        $('#hidden_masuk_gajian').remove(); // bersihkan hidden input jika ada

        if(nama_karyawan.includes('kandar')){
            $('#masuk_gajian').val('Tidak').trigger('change');
            $('#masuk_gajian').prop('disabled', true);
            
            // Tambahkan hidden input agar value 'Tidak' tetap dikirim karena select disabled tidak mengirim value
            $('<input>').attr({
                type: 'hidden',
                id: 'hidden_masuk_gajian',
                name: 'masuk_gajian',
                value: 'Tidak'
            }).insertAfter('#masuk_gajian');
        } else {
            $('#masuk_gajian').prop('disabled', false);
        }
    });

    $(document).on('click', '.addborongan', function(){
        var html = '';
        html += '<tr>';
        html += '<td width="300"><select type="text" class="form-control selectpicker kodepo" name="kodepo[]" data-size="4" data-live-search="true" data-title="Pilih item" required><option value="">Pilih PO</option><?php foreach ($kodepo as $key => $po) { ?><option value="<?php echo $po['id_produksi_po'] ?>" data-item="<?php echo $po['kode_po'] ?>"><?php echo $po['nama_po'].' '.$po['kode_po'] ?></option><?php } ?></select></td>';
        html += '<td><input type="text" class="form-control dz_potongan" readonly></td>';
        html += '<td><input type="text" class="form-control jumlahPc" name="jumlahpcs[]"  required ></td>';
        //html += '<td><input type="number" class="form-control jumlahtitik"  name="jumlahtitik[]" required ></td>';
        html += '<td><input type="number" class="form-control jumlah" name="pricePerTitik[]" required ></td>';
        //html += '<td><input type="number" class="form-control jumlahRp" name="jumlahRp[]" required ></td>';
        html += '<td><input type="text" class="form-control keterangan" name="keterangan[]" required ></td>';
        html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button></td></tr>';
        $('#item_table').append(html);
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
        $.get( "<?php echo BASEURL.'finishing/kirimgudangsendRincinan' ?>", { kodepo: dataItem } )
          .done(function( data ) {
            var obj = JSON.parse(data);
            console.log(obj);
            dai.find(".jumlahPc").val(Math.round(obj.jumlah_pcs_po/12));
            dai.find(".dz_potongan").val((obj.potongan_pcs/12).toFixed(2));
        });
    });
    $(document).on('change', '.selectpicker', function(e){
        var dataItem = $(this).find(':selected').data('item');
        var dai = $(this).closest('tr');
        var jumlahItem = $('#piecesPo').val();
        $.get( "<?php echo BASEURL.'Masterdata/price_packing_json' ?>", { kodepo: dataItem } )
          .done(function( data ) {
            var obj = JSON.parse(data);
            console.log(obj);
            if(obj.harga_packing==0){
                alert("Biaya Finishing Belum di setting. Hubungi SPV ");
                dai.remove();
            }
            dai.find(".jumlah").val(Math.round(obj.harga_packing));
        });
    });
});
 </script>	