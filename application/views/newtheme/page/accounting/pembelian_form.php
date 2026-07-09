<div class="row">
  <div class="col-md-8">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><?php echo $title ?></h3>
      </div>
      <form action="<?php echo $action ?>" method="post">
        <?php if(isset($tagihan)): ?>
          <input type="hidden" name="id" value="<?php echo $tagihan['id'] ?>">
        <?php endif; ?>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Supplier</label>
                <select name="id_supplier" class="form-control select2bs4" data-live-search="true" required>
                  <option value="">Pilih Supplier</option>
                  <?php foreach($supplier as $s): ?>
                    <option value="<?php echo $s['id'] ?>" <?php echo (isset($tagihan) && $tagihan['id_supplier'] == $s['id']) ? 'selected' : '' ?>><?php echo $s['nama'] ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>No. Invoice Vendor</label>
                <input type="text" name="no_invoice" class="form-control" value="<?php echo isset($tagihan) ? $tagihan['no_invoice'] : '' ?>" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Tanggal Tagihan</label>
                <input type="date" name="tanggal" class="form-control" value="<?php echo isset($tagihan) ? date('Y-m-d', strtotime($tagihan['tanggal'])) : date('Y-m-d') ?>" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Jatuh Tempo</label>
                <input type="date" name="jatuh_tempo" class="form-control" value="<?php echo isset($tagihan) ? date('Y-m-d', strtotime($tagihan['jatuh_tempo'])) : date('Y-m-d', strtotime('+30 days')) ?>">
              </div>
            </div>
          </div>
          <div class="row mt-4">
            <div class="col-md-12">
              <h4>Daftar Item Disetujui (Gudang/Pengajuan)</h4>
              <div class="row mb-2">
                <div class="col-md-4">
                   <label>Filter Tanggal Awal</label>
                   <input type="date" id="filter_tgl_awal" class="form-control" value="<?php echo date('Y-m-01'); ?>">
                </div>
                <div class="col-md-4">
                   <label>Filter Tanggal Akhir</label>
                   <input type="date" id="filter_tgl_akhir" class="form-control" value="<?php echo date('Y-m-t'); ?>">
                </div>
                <div class="col-md-4">
                   <label>&nbsp;</label><br>
                   <button type="button" class="btn btn-info" id="btn-filter-pengajuan">Tampilkan Data</button>
                </div>
              </div>
              <div class="table-responsive" style="max-height: 350px; overflow-y: auto;">
                <table class="table table-bordered table-striped" style="margin-bottom: 0;">
                  <thead style="position: sticky; top: 0; background-color: #f8f9fa; z-index: 1;">
                    <tr>
                      <th><input type="checkbox" id="checkAll"> Pilih</th>
                      <th>Tanggal</th>
                      <th>Nama Item</th>
                      <th>Qty</th>
                      <th>Metode Transfer</th>
                      <th>Nominal</th>
                    </tr>
                  </thead>
                  <tbody id="list-pengajuan">
                    <tr>
                      <td colspan="6" class="text-center">Silakan pilih supplier terlebih dahulu</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label>Total Nominal</label>
            <input type="number" step="0.01" name="total" class="form-control" value="<?php echo isset($tagihan) ? $tagihan['total'] : '' ?>" required>
          </div>
          <div class="form-group">
            <label>Keterangan</label>
            <textarea name="keterangan" class="form-control" rows="3"><?php echo isset($tagihan) ? $tagihan['keterangan'] : '' ?></textarea>
          </div>
        </div>
        <div class="card-footer text-right">
          <button type="submit" class="btn btn-success" id="btn-simpan-tagihan">Simpan Tagihan</button>
          <a href="<?php echo $batal ?>" class="btn btn-danger">Batal</a>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  $(document).ready(function(){
    if(typeof $('.select2bs4').select2 === 'function') {
      $('.select2bs4').select2();
    } else if (typeof $('.selectpicker').selectpicker === 'function') {
      $('.selectpicker').selectpicker('refresh');
    }

    let checked_details = <?php echo isset($checked_details) ? json_encode(array_column($checked_details, 'id_pengajuan_detail')) : '[]' ?>;

    function loadPengajuan() {
      let id_supplier = $('select[name="id_supplier"]').val();
      let tgl_awal = $('#filter_tgl_awal').val();
      let tgl_akhir = $('#filter_tgl_akhir').val();
      let id_pembelian = $('input[name="id"]').val() || '';
      
      if(id_supplier) {
        $('#list-pengajuan').html('<tr><td colspan="6" class="text-center">Loading...</td></tr>');
        $.ajax({
          url: '<?php echo BASEURL ?>Utangusaha/get_approved_pengajuan',
          type: 'POST',
          data: { 
            id_supplier: id_supplier,
            tgl_awal: tgl_awal,
            tgl_akhir: tgl_akhir,
            id_pembelian: id_pembelian
          },
          dataType: 'json',
          success: function(res) {
            let html = '';
            if(res.length > 0) {
              $.each(res, function(i, item) {
                let metode = item.pembayaran == 1 ? 'Cash' : (item.pembayaran == 2 ? 'Transfer' : '-');
                let nominal = Math.ceil(parseFloat(item.harga) * parseFloat(item.jumlah));
                let dateStr = item.tanggal ? item.tanggal.substring(0, 10) : '-';
                
                let isChecked = checked_details.includes(item.id) || checked_details.includes(item.id.toString()) ? 'checked' : '';
                let isDisabled = isChecked ? '' : 'disabled';

                html += '<tr>';
                html += '<td><input type="checkbox" class="cek-item" name="id_pengajuan_detail[]" value="'+item.id+'" '+isChecked+'></td>';
                html += '<td>'+dateStr+'</td>';
                html += '<td>'+item.nama_item+'</td>';
                html += '<td>'+item.jumlah+' '+item.satuan+'</td>';
                html += '<td>'+metode+'</td>';
                html += '<td align="right">'+formatRupiah(nominal.toString())+'';
                html += '<input type="hidden" class="nominal-item" name="nominal_pengajuan[]" value="'+nominal+'" '+isDisabled+'>';
                html += '</td>';
                html += '</tr>';
              });
            } else {
              html = '<tr><td colspan="6" class="text-center">Tidak ada item yang disetujui untuk supplier dan periode ini</td></tr>';
            }
            $('#list-pengajuan').html(html);
            kalkulasiTotal();
          }
        });
      } else {
        $('#list-pengajuan').html('<tr><td colspan="6" class="text-center">Silakan pilih supplier terlebih dahulu</td></tr>');
        kalkulasiTotal();
      }
    }

    $('select[name="id_supplier"]').on('change', function() {
      loadPengajuan();
    });
    
    $('#btn-filter-pengajuan').on('click', function() {
      loadPengajuan();
    });

    if ($('select[name="id_supplier"]').val()) {
      loadPengajuan();
    }

    $(document).on('change', '.cek-item', function() {
      let isChecked = $(this).is(':checked');
      $(this).closest('tr').find('.nominal-item').prop('disabled', !isChecked);
      kalkulasiTotal();
    });

    $('#checkAll').on('change', function() {
      $('.cek-item').prop('checked', $(this).prop('checked')).trigger('change');
    });

    function kalkulasiTotal() {
      let total = 0;
      $('.cek-item:checked').each(function() {
        let nominal = parseFloat($(this).closest('tr').find('.nominal-item').val()) || 0;
        total += nominal;
      });
      $('input[name="total"]').val(total);
    }

    function formatRupiah(angka, prefix){
      var number_string = angka.replace(/[^,\d]/g, '').toString(),
      split   		= number_string.split(','),
      sisa     		= split[0].length % 3,
      rupiah     		= split[0].substr(0, sisa),
      ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
 
      if(ribuan){
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
      }
 
      rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
      return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }

    $('form').on('submit', function() {
      let btn = $('#btn-simpan-tagihan');
      btn.html('<i class="fa fa-spinner fa-spin"></i> Menyimpan...').prop('disabled', true);
    });
  });
</script>
