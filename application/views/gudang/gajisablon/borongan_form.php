<form action="<?php echo $action ?>" method="POST">
<div class="row">
    <div class="col-md-2">
        <div class="form-group">
            <label for="">Tanggal</label>
            <input type="text" name="tanggal" class="form-control datepicker" value="<?php echo date('Y-m-d')?>">
        </div>
    </div>
    <div class="col-md-5">
        <div class="form-group">
            <label for="">Pilih CMT</label>
            <select name="idcmt" class="select2bs4" required>
						<option value="">Pilih CMT</option>
						<?php foreach($cmt as $k){ ?>
							<option value="<?php echo $k['id_cmt']?>" data-item="<?php echo $k['id_cmt']?>"><?php echo $k['cmt_name']?></option>
						<?php } ?>
			</select>
        </div>
    </div>
	<div class="col-md-5">
        <div class="form-group">
            <label for="">Pilih Karyawan</label>
            <select name="id_karyawan_harian" class="select2bs4 kar" required>
						<option value="">Pilih Karyawan</option>
						<?php foreach($kar as $k){ ?>
							<option value="<?php echo $k['id']?>" data-item="<?php echo $k['id']?>"><?php echo $k['nama']?></option>
						<?php } ?>
			</select>
        </div>
    </div>
    <div class="col-md-12">
        <table class="table table-bordered" id="item_table3">
            <tr>
                <th>Kode PO</th>
                <th>Gambar</th>
                <th>Model</th>
                <th>Lusin</th>
                <th>Putaran</th>
                <th>Harga</th>
                <!-- <th>Jumlah</th> -->
                <th><button type="button" name="add" class="btn btn-success btn-sm add3"><i class="fa fa-plus"></i></button></th>
            </tr>
        </table>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <button type="submit" onclick="return confirm('Apakah data yang diisi sudah benar?')" class="btn btn-primary btn-sm full">Simpan</button>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <a href="<?php echo $cancel ?>" class="btn btn-danger btn-sm full">Kembali</a>
        </div>
    </div>
</div>
</form>
<link href="<?php echo PLUGINS ?>bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" />
<script src="<?php echo PLUGINS ?>bootstrap-select/js/bootstrap-select.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
$(document).on('click', '.add', function(){
    var html = '';
    html += '<tr>';
    html += '<td><input type="text" class="form-control" name="bagianAtas[]" required readonly></td>';
    html += '<td><input type="text" class="form-control" name="warnaAtas[]" required readonly></td>';
    html += '<td><input type="number" class="form-control" name="jmlAtas[]"  ></td>';
    html += '<td><input type="text" class="form-control" name="keteranganAts[]"  readonly></td>';
    html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button></td></tr>';
    $('#item_table').append(html);
 });
var i=0;
$(document).on('click', '.add3', function(){
    var html = '';
    html += '<tr>';
    html += '<td>';
    html += '<select class="form-control selectpicker" name="prods['+i+'][kodepo]" data-live-search="true" data-size="3" required>';
    <?php foreach ($po as $key => $value): ?>
    html += '<option value="<?php echo $value['id_produksi_po'] ?>"><?php echo $value['kode_po'] ?></option>';
    <?php endforeach ?>
    html += '</select>';
    html += '</td>';
    html += '<td><input type="text" class="form-control" name="prods['+i+'][gambar]" required ></td>';
    html += '<td><input type="text" class="form-control" name="prods['+i+'][model]"  ></td>';
    html += '<td><input type="text" name="prods['+i+'][lusin]" class="form-control" ></td>';
    html += '<td><input type="text" class="form-control" name="prods['+i+'][putaran]"></td>';
    html += '<td><input type="text" class="form-control" name="prods['+i+'][harga]" required></td>';
    // html += '<td><input type="number" class="form-control" name="jumlah[]" required></td>';
    // html += '<td><input type="text" class="form-control" name="keterangan[]"  ></td>';
    html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button></td></tr>';
	i++;
    $('#item_table3').append(html);
    $('.selectpicker').selectpicker('refresh');
 });

$(document).on('change', '#poSelect', function(){

    var dataid = $(this).children("option:selected").data('id');

    $.post( "<?php echo BASEURL.'kelolapo/seaechDataId' ?>", { idData: dataid } ).done(function( data ) {

        var obj = JSON.parse(data);
        $('.timPotong').val(obj.tim_potong_potongan);
        $('.jmlWarna').val(obj.jumlah_gambar_utama);
        $('.jumlahPotDz').val(obj.hasil_lusinan_potongan);
        $('.jumlahPotPcs').val(obj.hasil_lusinan_potongan * 12);
      });;
    });

$(document).on('click', '.remove', function(){
    $(this).closest('tr').remove();
});
    
});
 </script>

</form>