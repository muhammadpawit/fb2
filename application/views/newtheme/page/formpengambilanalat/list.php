<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label for="">Tanggal Awal</label>
            <input type="text" name="tanggal1" id="tanggal1" value="<?php echo $tanggal1;?>" class="datepicker form-control">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="">Tanggal Akhir</label>
            <input type="text" name="tanggal2" id="tanggal2" value="<?php echo $tanggal2;?>" class="datepicker form-control">
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label for="">Status</label>
            <select name="status" id="status" class="form-control">
                <option value="">Semua</option>
                <option value="2" <?php echo isset($status_filter) && $status_filter == '2' ? 'selected' : ''; ?>>Menunggu Validasi</option>
                <option value="1" <?php echo isset($status_filter) && $status_filter == '1' ? 'selected' : ''; ?>>Tervalidasi</option>
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="">Aksi</label><br>
            <button onclick="filterstatus()" class="btn btn-sm btn-primary">Filter</button>
            <button type="button" class="btn btn-sm btn-primary" onclick="add_data()">Tambah</button>
        </div>
    </div>
</div>
<script>
function filterstatus(){
    var tgl1 = $("#tanggal1").val();
    var tgl2 = $("#tanggal2").val();
    var status = $("#status").val();
    var url = "?tanggal1=" + tgl1 + "&tanggal2=" + tgl2;
    if(status !== '') {
        url += "&status=" + status;
    }
    location.href = url;
}
</script>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <table class="table table-bordered table-hover yessearch">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Mandor</th>
                        <th>Shift</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($products as $p){ ?>
                        <tr>
                            <td><?php echo $p['no']?></td>
                            <td><?php echo $p['tanggal']?></td>
                            <td><?php echo $p['mandor']?></td>
                            <td><?php echo $p['shift']?></td>
                            <td><?php echo $p['status']?></td>
                            <td>
                                <a href="<?php echo $p['detail']?>" class="btn btn-xs btn-info">Detail</a>
                                <button type="button" class="btn btn-xs btn-warning" onclick="edit_data(<?php echo $p['id']?>)">Edit</button>
                                <a href="<?php echo BASEURL.'Formpengambilanalat/hapus/'.$p['id'] ?>" class="btn btn-xs btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalForm" tabindex="-1" role="dialog" aria-labelledby="modalFormLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width: 95% !important; width: 95% !important;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalFormLabel">Form Pengambilan Alat</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="formPengambilan" method="post" action="<?php echo $action?>">
        <input type="hidden" name="id" id="id_form">
        <?php if(strpos($_SERVER['REQUEST_URI'], 'konveksi') !== false){ ?>
          <input type="hidden" name="konveksi" value="2">
        <?php } ?>
        <?php if(strpos($_SERVER['REQUEST_URI'], 'finishing') !== false){ ?>
          <input type="hidden" name="konveksi" value="3">
        <?php } ?>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label>Tanggal</label>
                <input type="text" name="tanggal" id="tanggal" class="form-control datepicker" value="<?php echo date('Y-m-d')?>" required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Mandor</label>
                <input type="text" name="mandor" id="mandor" class="form-control" required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Shift</label>
                <select name="shift" id="shift" class="form-control" required>
                  <option value="">Pilih</option>
                  <option value="Pagi">Pagi</option>
                  <option value="Malam">Malam</option>
                </select>
              </div>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-12">
                <table class="table table-bordered" id="tableItem">
                  <thead>
                    <tr>
                      <th>Nama Barang</th>
                      <th>Stok</th>
                      <th>Jumlah</th>
                      <th>Satuan</th>
                      <th>Keterangan</th>
                      <th><button type="button" class="btn btn-success btn-sm" onclick="add_row()"><i class="fa fa-plus"></i></button></th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>                  
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="btnSimpan">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript">
var i = 0;

function add_data() {
    $('#formPengambilan')[0].reset();
    $('#id_form').val('');
    $('#tableItem tbody').empty();
    $('#modalForm').modal('show');
    add_row();
}

function add_row(data = null) {
    var html = '<tr>';
    html += '<td>';
    html += '<input type="hidden" name="products['+i+'][idpersediaan]" class="id_persediaan" value="'+(data ? data.id_persediaan : '')+'">';
    html += '<select class="form-control select2bs4 barang" name="products['+i+'][nama]" required onchange="get_stok(this)">';
    html += '<option value="">Pilih</option>';
    <?php foreach ($barang as $b) { ?>
        html += '<option value="<?php echo $b['nama_item'] ?>" data-item="<?php echo $b['id_persediaan'] ?>" '+(data && data.id_persediaan == '<?php echo $b['id_persediaan'] ?>' ? 'selected' : '')+'><?php echo $b['nama_item'] ?></option>';
    <?php } ?>
    html += '</select></td>';
    html += '<td><input type="number" class="form-control stok" name="products['+i+'][stok_saatini]" value="'+(data ? data.stock : 0)+'" readonly></td>';
    html += '<td><input type="number" class="form-control jumlah" name="products['+i+'][jumlah]" value="'+(data ? data.ajuan : '')+'" required oninput="val_stok(this)"></td>';
    html += '<td><input type="text" class="form-control satuan" name="products['+i+'][satuan]" value="'+(data ? data.satuan_jumlah_item : '')+'" readonly></td>';
    html += '<td><input type="text" class="form-control" name="products['+i+'][keterangan]" value="'+(data ? data.keterangan : '')+'"></td>';
    html += '<td><button type="button" class="btn btn-danger btn-sm" onclick="remove_row(this)"><i class="fa fa-trash"></i></button></td>';
    html += '</tr>';
    
    $('#tableItem tbody').append(html);
    $('.select2bs4').select2({
        dropdownParent: $('#modalForm'),
        width: '100%'
    });
    i++;
}

function remove_row(btn) {
    $(btn).closest('tr').remove();
}

function get_stok(select) {
    var id = $(select).find(':selected').data('item');
    var tr = $(select).closest('tr');
    tr.find('.id_persediaan').val(id);
    $.get("<?php echo BASEURL.'Gudang/itemkelSearchId' ?>", { id: id }, function(data) {
        var obj = JSON.parse(data);
        tr.find('.stok').val(obj.quantity);
        tr.find('.satuan').val(obj.satuan_jumlah_item);
    });
}

function val_stok(input) {
    var tr = $(input).closest('tr');
    var stok = parseFloat(tr.find('.stok').val()) || 0;
    var jumlah = parseFloat($(input).val()) || 0;
    if(jumlah > stok) {
        alert('Jumlah tidak boleh melebihi stok!');
        $(input).val(stok);
    }
}

function edit_data(id) {
    var btn = event.currentTarget;
    var originalHtml = $(btn).html();
    $(btn).html('<i class="fa fa-spinner fa-spin"></i> Loading...').attr('disabled', true);
    
    $.get("<?php echo BASEURL.'Formpengambilanalat/get_data/' ?>"+id, function(data) {
        var res = JSON.parse(data);
        $('#id_form').val(res.header.id);
        $('#tanggal').val(res.header.tanggal);
        $('#mandor').val(res.header.mandor);
        $('#shift').val(res.header.shift);
        $('#tableItem tbody').empty();
        res.details.forEach(function(item) {
            add_row(item);
        });
        $('#modalForm').modal('show');
        $(btn).html(originalHtml).attr('disabled', false);
    });
}

$('#formPengambilan').on('submit', function() {
    $('#btnSimpan').html('<i class="fa fa-spinner fa-spin"></i> Menyimpan...').attr('disabled', true);
});
</script>