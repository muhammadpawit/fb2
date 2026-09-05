<form method="post" action="<?php echo $action?>">
  <input type="hidden" name="id" value="<?php echo $kirim['id']?>">
  <div class="card card-default">
    <div class="card-header">
      <h3 class="card-title">Edit <?php echo $title ?> (No. SJ: <?php echo $kirim['nosj']?>)</h3>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-3">
          <div class="form-group">
            <label>Tanggal Kirim</label>
            <input type="text" name="tanggal" value="<?php echo date('Y-m-d', strtotime($kirim['tanggal']))?>" class="form-control datepicker" required>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label>CMT Tujuan (Jahit)</label>
            <select id="idcmt" class="form-control select2bs4" name="id_cmt" required>
              <option value="">-- Pilih CMT Tujuan --</option>
              <?php foreach ($cmt as $po) { ?>
                <option value="<?php echo $po['id_cmt'] ?>" <?php echo $po['id_cmt']==$kirim['idcmt']?'selected':'';?>>
                  <?php echo strtoupper($po['cmt_name']) ?>
                </option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label>Supir</label>
            <input type="text" name="supir" value="<?php echo isset($kirim['supir'])?$kirim['supir']:''?>" class="form-control" placeholder="Nama Supir">
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label>Pendamping</label>
            <input type="text" name="pendamping" value="<?php echo isset($kirim['pendamping'])?$kirim['pendamping']:''?>" class="form-control" placeholder="Nama Pendamping">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label>Keterangan Umum</label>
            <input type="text" name="keterangan" value="<?php echo $kirim['keterangan']?>" class="form-control" placeholder="Keterangan Surat Jalan">
          </div>
        </div>
      </div>

      <hr>

      <div class="row">
        <div class="col-md-12">
          <div class="table-responsive">
            <table class="table table-bordered table-striped" id="editdistribusi">
              <thead>
                <tr>
                  <th style="min-width:220px">Nama PO</th>
                  <th style="min-width:160px">Pekerjaan</th>
                  <th style="min-width:180px">Rincian PO</th>
                  <th style="min-width:100px">Jumlah Pcs</th>
                  <th style="min-width:120px">Jumlah Barang</th>
                  <th style="min-width:150px">Keterangan Detail</th>
                  <th style="width:50px">
                    <button type="button" class="btn btn-sm btn-success" onclick="tambahRowEdit()"><i class="fa fa-plus"></i></button>
                  </th>
                </tr>
              </thead>
              <tbody>
                <?php $i=0; foreach ($kirims as $item) { 
                  $po_obj = $this->GlobalModel->getDataRow('produksi_po', array('id_produksi_po' => $item['kode_po']));
                  if(empty($po_obj)) {
                    $po_obj = $this->GlobalModel->getDataRow('produksi_po', array('kode_po' => $item['kode_po']));
                  }
                  $po_name_display = !empty($po_obj) ? $po_obj['kode_po'] . ($po_obj['serian'] != '0' && !empty($po_obj['serian']) ? ' '.$po_obj['serian'] : '') : $item['kode_po'];
                ?>
                  <tr>
                    <input type="hidden" name="products[<?php echo $i ?>][iddetail]" value="<?php echo $item['id'] ?>">
                    <td>
                      <input type="hidden" name="products[<?php echo $i ?>][kode_po]" value="<?php echo $item['kode_po'] ?>">
                      <input type="text" value="<?php echo htmlspecialchars($po_name_display) ?>" class="form-control" readonly>
                    </td>
                    <td>
                      <select name="products[<?php echo $i ?>][cmtjob]" class="form-control select2-job" required style="width:100%">
                        <option value="">-- Pilih Job --</option>
                        <?php foreach ($pekerjaan as $j) { ?>
                          <option value="<?php echo $j['id'] ?>" <?php echo $j['id']==$item['cmtjob']?'selected':'';?>>
                            <?php echo strtoupper($j['nama_job']) ?>
                          </option>
                        <?php } ?>
                      </select>
                    </td>
                    <td><input type="text" name="products[<?php echo $i ?>][rincian_po]" value="<?php echo htmlspecialchars($item['rincian_po']) ?>" class="form-control" required></td>
                    <td><input type="number" name="products[<?php echo $i ?>][jumlah_pcs]" value="<?php echo $item['jumlah_pcs'] ?>" class="form-control" required></td>
                    <td><input type="text" name="products[<?php echo $i ?>][jml_barang]" value="<?php echo htmlspecialchars($item['jml_barang']) ?>" class="form-control" required></td>
                    <td><input type="text" name="products[<?php echo $i ?>][keterangan]" value="<?php echo htmlspecialchars($item['keterangan']) ?>" class="form-control"></td>
                    <td class="text-center">
                      <a href="<?php echo BASEURL.'Distribusipo/detailhapus/'.$item['id'].'/'.$kirim['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus item detail ini?')"><i class="fa fa-trash"></i></a>
                    </td>
                  </tr>
                <?php $i++; } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="card-footer text-right">
      <a href="<?php echo $cancel?>" class="btn btn-danger btn-sm">Batal</a>
      <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm('Apakah Anda yakin akan menyimpan perubahan ini?')">Simpan Perubahan</button>
    </div>
  </div>
</form>

<script type="text/javascript">
  var i = <?php echo isset($i)?$i:0 ?>;

  $(document).ready(function(){
    $('.datepicker').datepicker({
      dateFormat: 'yy-mm-dd',
      autoclose: true
    });
    $('.select2bs4, .select2-job').select2();
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
            q: params.term,
            except_id: '<?php echo $kirim['id'] ?>'
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

  function tambahRowEdit(){
    var html = '<tr>';
    html += '<input type="hidden" name="products['+i+'][iddetail]" value="0">';
    html += '<td>';
    html += '<select name="products['+i+'][kode_po]" class="form-control kodepo-select" required style="width:100%">';
    html += '<option value="">-- Cari & Pilih PO --</option>';
    <?php foreach ($kirim_po as $k) { 
      $po_disp = !empty($k['nama_po']) ? $k['nama_po'] . (!empty($k['serian']) && $k['serian'] != '0' ? ' '.$k['serian'] : '') : $k['kode_po'];
    ?>
      html += '<option value="<?php echo $k['kode_po'] ?>" data-pcs="<?php echo $k['jumlah_pcs'] ?>" data-rincian="<?php echo htmlspecialchars($k['rincian_po']) ?>" data-job="<?php echo $k['cmtjob'] ?>" data-barang="<?php echo htmlspecialchars($k['jml_barang']) ?>" data-ket="<?php echo htmlspecialchars($k['keterangan']) ?>"><?php echo strtoupper(htmlspecialchars($po_disp)) ?> (<?php echo $k['jumlah_pcs'] ?> pcs)</option>';
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
    $('#editdistribusi tbody').append($row);

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
    }
  });
</script>
