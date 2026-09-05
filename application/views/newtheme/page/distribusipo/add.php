<form method="post" action="<?php echo $action?>">
  <div class="card card-default">
    <div class="card-header">
      <h3 class="card-title"><?php echo $title ?> (Pengiriman dari CMT Kantor Sukabumi)</h3>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-3">
          <div class="form-group">
            <label>Tanggal Kirim</label>
            <input type="text" name="tanggal" value="<?php echo date('Y-m-d')?>" class="form-control datepicker" required>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label>CMT Tujuan (Jahit)</label>
            <select id="idcmt" class="form-control select2bs4" name="id_cmt" required>
              <option value="">-- Pilih CMT Tujuan --</option>
              <?php foreach ($cmt as $po) { ?>
                <option value="<?php echo $po['id_cmt'] ?>"><?php echo strtoupper($po['cmt_name']) ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label>Supir</label>
            <input type="text" name="supir" class="form-control" placeholder="Nama Supir">
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label>Pendamping</label>
            <input type="text" name="pendamping" class="form-control" placeholder="Nama Pendamping">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label>Keterangan Umum</label>
            <input type="text" name="keterangan" class="form-control" placeholder="Keterangan Surat Jalan">
          </div>
        </div>
      </div>

      <hr>

      <div class="row">
        <div class="col-md-12">
          <div class="alert alert-info text-white">
            <strong>Catatan:</strong> Pilih PO yang berasal dari CMT Kantor Sukabumi untuk didistribusikan.
          </div>
          <div class="table-responsive">
            <table class="table table-bordered table-striped" id="adddistribusi">
              <thead>
                <tr>
                  <th style="min-width:220px">Nama PO (CMT Kantor Sukabumi)</th>
                  <th style="min-width:160px">Pekerjaan</th>
                  <th style="min-width:180px">Rincian PO</th>
                  <th style="min-width:100px">Jumlah Pcs</th>
                  <th style="min-width:120px">Jumlah Barang</th>
                  <th style="min-width:150px">Keterangan Detail</th>
                  <th style="width:50px">
                    <button type="button" class="btn btn-sm btn-success" onclick="tambahRow()"><i class="fa fa-plus"></i></button>
                  </th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="card-footer text-right">
      <a href="<?php echo $cancel?>" class="btn btn-danger btn-sm">Batal</a>
      <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm('Apakah Anda yakin akan menyimpan Surat Jalan Distribusi ini?')">Simpan</button>
    </div>
  </div>
</form>

<script type="text/javascript">
  var i = 0;

  $(document).ready(function(){
    $('.datepicker').datepicker({
      dateFormat: 'yy-mm-dd',
      autoclose: true
    });
    $('.select2bs4').select2();
  });

  $(document).on('click', '.remove-row', function(){
    $(this).closest('tr').remove();
  });

  function initPoSelect2(selector){
    $(selector).select2({
      placeholder: '-- Cari & Pilih PO --',
      allowClear: true,
      ajax: {
        url: '<?php echo BASEURL ?>Distribusipo/search_po_sukabumi',
        dataType: 'json',
        delay: 250,
        data: function (params) {
          return {
            q: params.term
          };
        },
        processResults: function (data) {
          return {
            results: data
          };
        },
        cache: true
      }
    });
  }

  function tambahRow(){
    var cmt = $("#idcmt").val();
    if(!cmt){
      alert("CMT Tujuan harus dipilih terlebih dahulu!");
      return false;
    }

    var html = '<tr>';
    html += '<td>';
    html += '<select name="products['+i+'][kode_po]" class="form-control kodepo-select" data-row="'+i+'" required style="width:100%">';
    html += '<option value="">-- Cari & Pilih PO --</option>';
    <?php foreach ($kirim as $k) { 
      $po_display = !empty($k['nama_po']) ? $k['nama_po'] . (!empty($k['serian']) && $k['serian'] != '0' ? ' '.$k['serian'] : '') : $k['kode_po'];
    ?>
      html += '<option value="<?php echo $k['kode_po'] ?>" data-pcs="<?php echo $k['jumlah_pcs'] ?>" data-rincian="<?php echo htmlspecialchars($k['rincian_po']) ?>" data-job="<?php echo $k['cmtjob'] ?>" data-barang="<?php echo htmlspecialchars($k['jml_barang']) ?>" data-ket="<?php echo htmlspecialchars($k['keterangan']) ?>"><?php echo strtoupper(htmlspecialchars($po_display)) ?> (<?php echo $k['jumlah_pcs'] ?> pcs)</option>';
    <?php } ?>
    html += '</select>';
    html += '</td>';

    html += '<td>';
    html += '<select name="products['+i+'][cmtjob]" class="form-control select2-job job-select" required style="width:100%">';
    html += '<option value="">-- Pilih Job --</option>';
    <?php foreach ($pekerjaan as $j) { ?>
      html += '<option value="<?php echo $j['id'] ?>"><?php echo strtoupper($j['nama_job']) ?></option>';
    <?php } ?>
    html += '</select>';
    html += '</td>';

    html += '<td><input type="text" name="products['+i+'][rincian_po]" class="form-control rincian-input" required></td>';
    html += '<td><input type="number" name="products['+i+'][jumlah_pcs]" class="form-control pcs-input" required></td>';
    html += '<td><input type="text" name="products['+i+'][jml_barang]" class="form-control barang-input" value="1 plastik" required></td>';
    html += '<td><input type="text" name="products['+i+'][keterangan]" class="form-control ket-input"></td>';
    html += '<td class="text-center"><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fa fa-trash"></i></button></td>';
    html += '</tr>';

    var $row = $(html);
    $('#adddistribusi tbody').append($row);

    $row.find('.select2-job').select2();
    initPoSelect2($row.find('.kodepo-select'));
    i++;
  }

  $(document).on('change', '.kodepo-select', function(){
    var tr = $(this).closest('tr');
    var selectData = $(this).select2('data');

    if(selectData && selectData.length > 0 && selectData[0].jumlah_pcs !== undefined){
      var data = selectData[0];
      if(data.jumlah_pcs !== undefined) tr.find('.pcs-input').val(data.jumlah_pcs);
      if(data.rincian_po !== undefined && data.rincian_po !== '') tr.find('.rincian-input').val(data.rincian_po);
      if(data.cmtjob !== undefined && data.cmtjob > 0) tr.find('.job-select').val(data.cmtjob).trigger('change');
      if(data.jml_barang !== undefined && data.jml_barang !== '') tr.find('.barang-input').val(data.jml_barang);
      if(data.keterangan !== undefined) tr.find('.ket-input').val(data.keterangan);
    } else {
      var selected = $(this).find(':selected');
      var pcs = selected.data('pcs');
      var rincian = selected.data('rincian');
      var job = selected.data('job');
      var barang = selected.data('barang');
      var ket = selected.data('ket');

      if(pcs !== undefined) tr.find('.pcs-input').val(pcs);
      if(rincian !== undefined && rincian !== '') tr.find('.rincian-input').val(rincian);
      if(job !== undefined && job !== '') tr.find('.job-select').val(job).trigger('change');
      if(barang !== undefined && barang !== '') tr.find('.barang-input').val(barang);
      if(ket !== undefined) tr.find('.ket-input').val(ket);

      var kodepo = selected.val();
      if(kodepo){
        $.get("<?php echo BASEURL.'Distribusipo/carip' ?>", { po: kodepo }, function(data){
          if(data){
            var obj = typeof data === 'string' ? JSON.parse(data) : data;
            if(obj.jumlah_pcs) tr.find('.pcs-input').val(obj.jumlah_pcs);
            if(obj.rincian_po) tr.find('.rincian-input').val(obj.rincian_po);
            if(obj.cmtjob) tr.find('.job-select').val(obj.cmtjob).trigger('change');
            if(obj.jml_barang) tr.find('.barang-input').val(obj.jml_barang);
            if(obj.keterangan) tr.find('.ket-input').val(obj.keterangan);
          }
        });
      }
    }
  });
</script>
