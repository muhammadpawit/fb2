<!-- Start Page content -->
<!-- Modal -->
<div id="myModalK" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h4 class="modal-title">Tambah Karyawan Baru</h4>
      </div>
      <div class="modal-body">
        <form method="post" action="<?php echo $savepekerja?>">
          <div class="form-group">
            <label>Nama </label>
            <input type="text" name="nama" class="form-control" required="required">
          </div>
          <button type="submit" class="btn btn-info">Simpan</button>
          <a class="btn btn-danger text-white" data-dismiss="modal">Batal</a>
        </form>
      </div>
      <div class="modal-footer">
        
      </div>
    </div>

  </div>
</div>

<form action="<?php echo $action ?>" method="POST">
  <input type="hidden" name="tanggals" value="<?php echo $tanggal?>">
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Tanggal</th>
                  <th>Nama Karyawan</th>
                  <th>Kode PO</th>
                  <th>Bagian Buang Benang</th>
                  <th>Size</th>
                  <th>Qty</th>
                  <th>Harga</th>
                  <th>Keterangan</th>
                </tr>
              </thead>
              <tbody>
                  <?php $i=0;?>
                  <?php foreach($prods as $p){ ?>
                    <input type="hidden" name="prods[<?php echo $i?>][id]" value="<?php echo $p['id_kelolapo_buang_benang']?>">
                    <tr>
                      <td><?php echo formatTanggalIndo($p['created_date']) ?></td>
                      <td><?php echo $p['nama'] ?></td>
                      <td><?php echo $p['kode_po'] ?></td>
                      <td><?php echo $p['bagian_buang_benang'] ?></td>
                      <td><?php echo $p['size_buang_benang'] ?></td>
                      <td><?php echo $p['qty_buang_benang'] ?></td>
                      <td><input type="number" name="prods[<?php echo $i?>][harga_buang_benan]" value="<?php echo $p['harga_buang_benan'] ?>"></td>
                      <td><?php echo $p['keterangan_buang_benang'] ?></td>
                    </tr>
                    <?php $i++;?>
                  <?php } ?>
              </tbody>
            </table>
        </div>
    </div>
</div>
<button type="submit" class="btn btn-primary">Simpan</button>
<a href="<?php echo $cancel?>" class="btn btn-danger text-white">Kembali</a>
</form>

 <script type="text/javascript">

$(document).ready(function(){

$( "#perkalianTarif" ).keyup(function() {

    var total = $('#totalStich').val();

    var perkali = $('#perkalianTarif').val();

    var tarif = total * perkali;

    $('#tarif').val(tarif);

});

$(document).on('click', '.addbbbordir', function(){

    var html = '';

    html += '<tr>';

    //html += '<td><input type="date" class="form-control" name="tanggal[]" step=0.01 required></td>';

    html += '<td width="200"><select name="namaPO[]" class="form-control select2bs4" data-live-search="true"><?php foreach($po as $p){?><option value="<?php echo $p['kode_po']?>"><?php echo $p['kode_po']?></option><?php } ?></select></td>';

    html += '<td><input type="text" class="form-control selectpicker" name="bagianBuang[]" required></td>';

    html += '<td><input type="text" class="form-control" name="size[]" ></td>';

    html += '<td><input type="number" class="form-control" name="qty[]" required></td>';

    html += '<td><input type="number" class="form-control" name="harga[]" step=0.01 required></td>';

    html += '<td><input type="text" class="form-control" name="keterangan[]" step=0.01 required></td>';



    html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button></td></tr>';

   

    $('#bbbordir').append(html);
    $('.select2bs4').select2();
    //$('.select2bs4').selectpicker('refresh');

 });



$(document).on('click', '.remove', function(){

    $(this).closest('tr').remove();

});

    

});

 </script>