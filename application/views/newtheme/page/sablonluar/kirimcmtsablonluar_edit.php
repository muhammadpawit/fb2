<form class="form-group" action="<?php echo $action?>" method="post">
  <input type="hidden" name="id" value="<?php echo $kirim['id']?>">
  <div class="card card-default">
    <div class="card-header">
      <h3 class="card-title"><strong>Edit Surat Jalan: <?php echo $kirim['nosj'] ?></strong></h3>
    </div>
    <div class="card-body">
      <table class="table">
        <tr>
          <td style="width: 15%"><label>No. Surat Jalan</label></td>
          <td style="width: 2%">:</td>
          <td>
            <input type="text" class="form-control" value="<?php echo $kirim['nosj'] ?>" readonly>
          </td>
        </tr>
        <tr>
          <td><label>Tanggal</label></td>
          <td>:</td>
          <td>
            <input type="date" class="form-control" name="tanggal" value="<?php echo date('Y-m-d', strtotime($kirim['tanggal'])) ?>" required>
          </td>
        </tr>
        <tr>
          <td><label>Proses</label></td>
          <td>:</td>
          <td>
            <select class="form-control select2bs4" id="progress" name="progress" title="Pilih Progress" data-live-search="true" required>
              <?php foreach ($progress as $key => $prog): ?>
                <option value="<?php echo $prog['nama_progress'] ?>"><?php echo $prog['nama_progress'] ?></option>
              <?php endforeach ?>
            </select>
          </td>
        </tr>
        <tr>
          <td><label>Jenis CMT</label></td>
          <td>:</td>
          <td>
            <select class="form-control select2bs4" id="cmtKats" name="cmtKat" title="Pilih CMT" required data-live-search="true">
              <option value="SABLON" <?php echo ($kirim['cmtkat'] == 'SABLON' || empty($kirim['cmtkat'])) ? 'selected' : ''; ?>>SABLON</option>
            </select>
          </td>
        </tr>
        <tr>
          <td><label>Nama CMT</label></td>
          <td>:</td>
          <td>
            <select class="form-control select2bs4" name="cmtName" required title="Pilih Nama CMT" data-live-search="true">
              <?php foreach($listcmt as $c){?>
                <option value="<?php echo $c['id_cmt']?>-<?php echo $c['cmt_name']?>" <?php echo $c['id_cmt'] == $kirim['idcmt'] ? 'selected' : ''; ?>>
                  <?php echo strtolower($c['cmt_name'])?>
                </option>
              <?php } ?>
            </select>
          </td>
        </tr>
        <tr>
          <td><label>Keterangan</label></td>
          <td>:</td>
          <td>
            <textarea name="keterangan" class="form-control"><?php echo $kirim['keterangan'] ?></textarea>
          </td>
        </tr>
      </table>

      <hr>
      <p class="text-muted">Setiap PO yang akan di kirim harus sudah diinput pada pengecekan.</p>
      
      <div class="table-responsive">
        <table class="table table-bordered table-striped" id="addkirimgudang">
          <thead>
            <tr>
              <th style="min-width: 220px">Nama PO</th>
              <th style="min-width: 200px">Pekerjaan</th>
              <th style="min-width: 120px">Harga</th>
              <th style="min-width: 120px">Jumlah PO (Pcs)</th>
              <th style="min-width: 140px">Jumlah Barang</th>
              <th style="min-width: 180px">Keterangan</th>
              <th style="width: 60px" class="text-center">
                <button type="button" name="add" class="btn btn-success btn-sm addkirimgudang" onclick="addkirimgudang()"><i class="fa fa-plus"></i></button>
              </th>
            </tr>
          </thead>
          <tbody>
            <?php $i = 0; ?>
            <?php if (!empty($kirims)): ?>
              <?php foreach ($kirims as $d): ?>
              <tr>
                <td>
                  <select class="form-control select2bs4 kodepo" name="products[<?php echo $i ?>][kode_po]" data-live-search="true" required style="width:100%">
                    <option value="">Pilih PO</option>
                    <?php foreach ($kodepo as $po) { ?>
                      <option value="<?php echo $po['id'] ?>" <?php echo $po['id'] == $d['kode_po'] ? 'selected' : ''; ?>>
                        <?php echo $po['nama'] ?>
                      </option>
                    <?php } ?>
                  </select>
                </td>
                <td>
                  <select class="form-control select2bs4" name="products[<?php echo $i ?>][cmtjob]" data-live-search="true" required style="width:100%">
                    <option value="">Pilih Pekerjaan</option>
                    <?php foreach ($pekerjaan as $job) { ?>
                      <option value="<?php echo $job['id'] ?>" <?php echo $job['id'] == $d['cmtjob'] ? 'selected' : ''; ?>>
                        <?php echo $job['nama_job']; ?>
                      </option>
                    <?php } ?>
                  </select>
                </td>
                <td><input type="number" class="form-control" name="products[<?php echo $i ?>][rincian_po]" value="<?php echo $d['rincian_po'] ?>" required></td>
                <td><input type="number" class="form-control" name="products[<?php echo $i ?>][jumlah_pcs]" value="<?php echo $d['jumlah_pcs'] ?>" required></td>
                <td><input type="text" class="form-control" name="products[<?php echo $i ?>][jml_barang]" value="<?php echo htmlspecialchars($d['jml_barang']) ?>" required></td>
                <td><input type="text" class="form-control" name="products[<?php echo $i ?>][keterangan]" value="<?php echo htmlspecialchars($d['keterangan']) ?>"></td>
                <td class="text-center">
                  <button type="button" class="btn btn-danger btn-sm remove"><i class="fa fa-trash"></i></button>
                </td>
              </tr>
              <?php $i++; ?>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
      <div id="rincianbahan"></div>
    </div>
    <div class="card-footer text-right">
      <a href="<?php echo $cancel?>" class="btn btn-danger text-white">Batal</a>
      <button type="button" onclick="simpan()" class="btn btn-primary">Simpan Perubahan</button>
    </div>
  </div>
</form>

<!-- Template untuk row baru -->
<table style="display:none">
  <tbody id="row-template">
    <tr>
      <td>
        <select class="form-control new-select2 kodepo" name="products[INDEX][kode_po]" data-live-search="true" required style="width:100%">
          <option value="">Pilih PO</option>
          <?php foreach ($kodepo as $po) { ?>
            <option value="<?php echo $po['id'] ?>"><?php echo htmlspecialchars($po['nama']) ?></option>
          <?php } ?>
        </select>
      </td>
      <td>
        <select class="form-control new-select2" name="products[INDEX][cmtjob]" data-live-search="true" required style="width:100%">
          <option value="">Pilih Pekerjaan</option>
          <?php foreach ($pekerjaan as $job) { ?>
            <option value="<?php echo $job['id'] ?>"><?php echo htmlspecialchars($job['nama_job']) ?></option>
          <?php } ?>
        </select>
      </td>
      <td><input type="number" class="form-control" name="products[INDEX][rincian_po]" required></td>
      <td><input type="number" class="form-control" name="products[INDEX][jumlah_pcs]" required></td>
      <td><input type="text" class="form-control" value="1 plastik" name="products[INDEX][jml_barang]" required></td>
      <td><input type="text" class="form-control" name="products[INDEX][keterangan]"></td>
      <td class="text-center">
        <button type="button" class="btn btn-danger btn-sm remove"><i class="fa fa-trash"></i></button>
      </td>
    </tr>
  </tbody>
</table>

<script type="text/javascript">
  var i = <?php echo isset($i) ? $i : 0 ?>;

  function addkirimgudang(){
    var rowHtml = $('#row-template').html().replace(/INDEX/g, i);
    var $newRow = $(rowHtml);
    $('#addkirimgudang tbody').append($newRow);
    $newRow.find('.new-select2').select2();
    i++;
  }

  $(document).ready(function(){
    $('.select2bs4').select2();

    $(document).on('click', '.remove', function(){
      $(this).closest('tr').remove();
    });
  });

  function simpan(){
    const jeniscmt = $("#cmtKats").val();
    const cmtName = $('select[name="cmtName"]').val();

    if(jeniscmt == ''){
      alert("Jenis CMT harus dipilih");
      return false;
    }
    if(!cmtName){
      alert("Nama CMT harus dipilih");
      return false;
    }
    if($('#addkirimgudang tbody tr').length === 0){
      alert("Minimal harus ada 1 item PO dalam rincian pengiriman");
      return false;
    }

    const c = confirm("Apakah Anda yakin akan menyimpan perubahan ini?");
    if(c == true){
      $("form").submit();
    } else {
      return false;
    }
  }
</script>
