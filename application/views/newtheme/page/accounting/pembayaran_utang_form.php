<form action="<?php echo $action ?>" method="POST">
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label>Tanggal</label>
        <input type="date" name="tanggal" class="form-control" value="<?php echo date('Y-m-d') ?>" required>
      </div>
      <div class="form-group">
        <label>No. Bayar</label>
        <input type="text" name="no_bayar" class="form-control" value="<?php echo isset($pembayaran) ? $pembayaran['no_bayar'] : $auto_bayar ?>" readonly required>
      </div>
      <div class="form-group">
        <label>Supplier</label>
        <select name="id_supplier" class="form-control select2bs4" data-live-search="true" required>
          <option value="">Pilih Supplier</option>
          <?php foreach($supplier as $s): ?>
            <option value="<?php echo $s['id'] ?>"><?php echo $s['nama'] ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label>Akun Kas</label>
        <select name="id_akun_kas" class="form-control select2bs4" data-live-search="true" required>
          <option value="">Pilih Akun Kas</option>
          <?php foreach($kas as $k): ?>
            <option value="<?php echo $k['id'] ?>"><?php echo $k['nama_akun'] ?> (<?php echo $k['kode_akun'] ?>)</option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="form-group">
        <label>Keterangan</label>
        <textarea name="keterangan" class="form-control" rows="3"></textarea>
      </div>
    </div>
  </div>

  <div class="row mt-4">
    <div class="col-md-12">
      <h4>Pilih Tagihan yang Dibayar</h4>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Pilih</th>
            <th>No. Invoice</th>
            <th>Tanggal</th>
            <th>Supplier</th>
            <th>Total Tagihan</th>
            <th>Nominal Dibayar</th>
          </tr>
        </thead>
        <tbody id="list-tagihan">
          <tr>
            <td colspan="6" class="text-center">Silakan pilih supplier terlebih dahulu</td>
          </tr>
        </tbody>
        <tfoot>
          <tr>
            <th colspan="5" class="text-right">Total Pembayaran</th>
            <th>
              <input type="number" name="total_bayar" id="total_bayar" class="form-control" value="0" readonly>
            </th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>

  <div class="row mt-4">
    <div class="col-md-12">
      <button type="submit" class="btn btn-success" id="btn-simpan-pembayaran">Simpan</button>
      <a href="<?php echo $batal ?>" class="btn btn-danger">Batal</a>
    </div>
  </div>
</form>

<script>
  $(document).ready(function(){
    if(typeof $('.select2bs4').select2 === 'function') {
      $('.select2bs4').select2();
    } else if (typeof $('.selectpicker').selectpicker === 'function') {
      $('.selectpicker').selectpicker('refresh');
    }

    $(document).on('change', '.cek-tagihan', function(){
      let isChecked = $(this).is(':checked');
      let tr = $(this).closest('tr');
      let inputNominal = tr.find('.nominal-bayar');
      
      if(isChecked){
        inputNominal.prop('readonly', false);
        let maxVal = inputNominal.attr('max');
        inputNominal.val(maxVal); // Default to full amount
      } else {
        inputNominal.prop('readonly', true);
        inputNominal.val(0);
      }
      kalkulasiTotal();
    });

    $('select[name="id_supplier"]').on('change', function() {
      let id_supplier = $(this).val();
      if(id_supplier) {
        $('#list-tagihan').html('<tr><td colspan="6" class="text-center">Loading...</td></tr>');
        $.ajax({
          url: '<?php echo BASEURL ?>Utangusaha/get_open_invoices',
          type: 'POST',
          data: { id_supplier: id_supplier },
          dataType: 'json',
          success: function(res) {
            let html = '';
            if(res.length > 0) {
              $.each(res, function(i, item) {
                let dateStr = item.tanggal ? item.tanggal.substring(0, 10) : '-';
                
                html += '<tr>';
                html += '<td><input type="checkbox" name="id_pembelian[]" value="'+item.id+'" class="cek-tagihan"></td>';
                html += '<td>'+item.no_invoice+'</td>';
                html += '<td>'+dateStr+'</td>';
                html += '<td>'+item.nama_supplier+'</td>';
                html += '<td align="right">'+formatRupiah(item.sisa.toString())+'</td>';
                html += '<td><input type="number" name="nominal[]" class="form-control nominal-bayar" value="0" min="0" max="'+item.sisa+'" readonly></td>';
                html += '</tr>';
              });
            } else {
              html = '<tr><td colspan="6" class="text-center">Tidak ada tagihan aktif untuk supplier ini</td></tr>';
            }
            $('#list-tagihan').html(html);
            kalkulasiTotal();
          }
        });
      } else {
        $('#list-tagihan').html('<tr><td colspan="6" class="text-center">Silakan pilih supplier terlebih dahulu</td></tr>');
        kalkulasiTotal();
      }
    });

    function formatRupiah(angka, prefix){
      var number_string = angka.replace(/[^,\d]/g, '').toString(),
      split   		= number_string.split(','),
      sisa     		= split[0].length % 3,
      rupiah     		= split[0].substr(0, sisa),
      ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
 
      if(ribuan){
        var separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
      }
 
      rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
      return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }

    $(document).on('input', '.nominal-bayar', function(){
      let maxVal = parseFloat($(this).attr('max'));
      let val = parseFloat($(this).val());
      if(val > maxVal) {
        $(this).val(maxVal);
      }
      kalkulasiTotal();
    });

    function kalkulasiTotal() {
      let total = 0;
      $('.nominal-bayar').each(function(){
        let val = parseFloat($(this).val()) || 0;
        total += val;
      });
      $('#total_bayar').val(total);
    }
    
    $('form').on('submit', function() {
      let btn = $('#btn-simpan-pembayaran');
      btn.html('<i class="fa fa-spinner fa-spin"></i> Menyimpan...').prop('disabled', true);
    });
  });
</script>
