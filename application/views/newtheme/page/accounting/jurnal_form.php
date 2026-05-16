<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><?php echo $title ?></h3>
      </div>
      <form action="<?php echo $action ?>" method="post" id="jurnalForm">
        <div class="card-body">
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label>Tanggal</label>
                <input type="date" name="tanggal" class="form-control" value="<?php echo date('Y-m-d') ?>" required>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>No. Jurnal</label>
                <input type="text" name="no_jurnal" class="form-control" placeholder="Automatic if empty" value="JV-<?php echo date('YmdHis') ?>">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Keterangan Umum</label>
                <input type="text" name="keterangan_header" class="form-control" placeholder="Keterangan transaksi">
              </div>
            </div>
          </div>
          <hr>
          <table class="table table-bordered" id="tableJurnal">
            <thead>
              <tr>
                <th width="40%">Akun</th>
                <th width="20%">Debit</th>
                <th width="20%">Kredit</th>
                <th width="15%">Keterangan</th>
                <th width="5%"></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  <select name="details[0][id_akun]" class="form-control select2" required>
                    <option value="">Pilih Akun</option>
                    <?php foreach($akun as $a): ?>
                      <option value="<?php echo $a['id'] ?>"><?php echo $a['kode_akun'] ?> - <?php echo $a['nama_akun'] ?></option>
                    <?php endforeach; ?>
                  </select>
                </td>
                <td><input type="number" step="0.01" name="details[0][debit]" class="form-control debit" value="0"></td>
                <td><input type="number" step="0.01" name="details[0][kredit]" class="form-control kredit" value="0"></td>
                <td><input type="text" name="details[0][keterangan]" class="form-control"></td>
                <td></td>
              </tr>
              <tr>
                <td>
                  <select name="details[1][id_akun]" class="form-control select2" required>
                    <option value="">Pilih Akun</option>
                    <?php foreach($akun as $a): ?>
                      <option value="<?php echo $a['id'] ?>"><?php echo $a['kode_akun'] ?> - <?php echo $a['nama_akun'] ?></option>
                    <?php endforeach; ?>
                  </select>
                </td>
                <td><input type="number" step="0.01" name="details[1][debit]" class="form-control debit" value="0"></td>
                <td><input type="number" step="0.01" name="details[1][kredit]" class="form-control kredit" value="0"></td>
                <td><input type="text" name="details[1][keterangan]" class="form-control"></td>
                <td></td>
              </tr>
            </tbody>
            <tfoot>
              <tr>
                <th class="text-right">Total</th>
                <th><input type="text" id="total_debit" name="total_debit" class="form-control" readonly value="0"></th>
                <th><input type="text" id="total_kredit" name="total_kredit" class="form-control" readonly value="0"></th>
                <th></th>
                <th></th>
              </tr>
            </tfoot>
          </table>
          <button type="button" class="btn btn-info btn-sm" id="addRow"><i class="fa fa-plus"></i> Tambah Baris</button>
        </div>
        <div class="card-footer">
          <button type="submit" class="btn btn-success" id="btnSubmit">Simpan Jurnal</button>
          <a href="<?php echo $batal ?>" class="btn btn-danger">Batal</a>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let rowCount = 2;
    const addRowBtn = document.getElementById('addRow');
    const tableJurnal = document.getElementById('tableJurnal').getElementsByTagName('tbody')[0];
    
    addRowBtn.addEventListener('click', function() {
        let newRow = tableJurnal.insertRow();
        newRow.innerHTML = `
            <td>
              <select name="details[${rowCount}][id_akun]" class="form-control select2" required>
                <option value="">Pilih Akun</option>
                <?php foreach($akun as $a): ?>
                  <option value="<?php echo $a['id'] ?>"><?php echo $a['kode_akun'] ?> - <?php echo $a['nama_akun'] ?></option>
                <?php endforeach; ?>
              </select>
            </td>
            <td><input type="number" step="0.01" name="details[${rowCount}][debit]" class="form-control debit" value="0"></td>
            <td><input type="number" step="0.01" name="details[${rowCount}][kredit]" class="form-control kredit" value="0"></td>
            <td><input type="text" name="details[${rowCount}][keterangan]" class="form-control"></td>
            <td><button type="button" class="btn btn-danger btn-sm removeRow"><i class="fa fa-times"></i></button></td>
        `;
        rowCount++;
        // Initialize select2 for the new row if needed
        if(typeof $('.select2').select2 === 'function') {
            $('.select2').select2();
        }
    });

    document.addEventListener('click', function(e) {
        if(e.target && (e.target.classList.contains('removeRow') || e.target.parentElement.classList.contains('removeRow'))) {
            let row = e.target.closest('tr');
            row.remove();
            calculateTotal();
        }
    });

    document.addEventListener('input', function(e) {
        if(e.target && (e.target.classList.contains('debit') || e.target.classList.contains('kredit'))) {
            calculateTotal();
        }
    });

    function calculateTotal() {
        let totalDebit = 0;
        let totalKredit = 0;
        document.querySelectorAll('.debit').forEach(el => {
            totalDebit += parseFloat(el.value) || 0;
        });
        document.querySelectorAll('.kredit').forEach(el => {
            totalKredit += parseFloat(el.value) || 0;
        });
        document.getElementById('total_debit').value = totalDebit;
        document.getElementById('total_kredit').value = totalKredit;
        
        if(totalDebit !== totalKredit || totalDebit === 0) {
            document.getElementById('btnSubmit').disabled = true;
            document.getElementById('btnSubmit').title = "Debit dan Kredit harus sama dan tidak nol";
        } else {
            document.getElementById('btnSubmit').disabled = false;
            document.getElementById('btnSubmit').title = "";
        }
    }
    
    calculateTotal();
});
</script>
