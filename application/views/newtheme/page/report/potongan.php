<div class="row">
    <div class="col-sm-2">
        <div class="form-group">
            <label>Tanggal Awal</label>
            <input type="text" name="tanggal1" id="tanggal1" class="form-control">
        </div>
    </div>
    <div class="col-sm-2">
        <div class="form-group">
            <label>Tanggal Akhir</label>
            <input type="text" name="tanggal2" id="tanggal2" class="form-control">
        </div>
    </div>
    <div class="col-sm-3">
        <label>Tim Potong</label>
        <select name="tim" id="tim" class="form-control select2bs4">
            <option value="*">Pilih</option>
            <?php foreach($timpotong as $t){ ?>
                <option value="<?= $t['id'] ?>"><?= $t['nama'] ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="col-sm-3">
        <label>NAMA PO</label>
        <select name="jenis" id="jenis" class="form-control select2bs4">
            <option value="*">Pilih</option>
            <?php foreach($jenis as $t){ ?>
                <option value="<?= $t['nama_jenis_po'] ?>"><?= $t['nama_jenis_po'] ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="col-sm-2">
        <div class="form-group">
            <label>Action</label><br>
            <button type="button" onclick="search_proses()" class="btn btn-info btn-sm">Filter</button>
            <a onclick="excelpotongan()" class="btn btn-info btn-sm text-white" target="_blank">Excel</a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered ss">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tanggal</th>
                    <th>Tim Potong</th>
                    <th>Nama PO</th>
                    <th>Roll Bahan</th>
                    <th>Panjang Gelaran</th>
                    <th>Pemakaian Bahan Kaos</th>
                    <th>Pemakaian Bahan Celana</th>
                    <th>Size</th>
                    <th>Jml PO (Dz)</th>
                    <th>Jml PO (Pcs)</th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot>
                <tr>
                    <th colspan="2">Total</th>
                    <th colspan="9"></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<script>
  function search_proses(){
    $('.ss').DataTable().ajax.reload();
}



$(document).ready(function () {

    // Inisialisasi select2
    $('.select2bs4').select2({ theme: 'bootstrap4' });

    // Inisialisasi DataTable
    var table = $('.ss').DataTable({
        processing: true,
        serverSide: true,
        searching: false,
        paging: true,
        lengthChange: true,
        pageLength: 10,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        ordering: false,
        responsive: true,

        ajax: {
            url: '<?= BASEURL ?>LaravelApi/report_potongan',
            type: 'GET',
            data: function(d){
                // Ambil value dari form
                d.tanggal_from = $('#tanggal1').val();
                d.tanggal_to   = $('#tanggal2').val();
                d.tim          = $('#tim').val();
                d.jenispo      = $('#jenis').val();
                d.page     = Math.ceil(d.start / d.length) + 1;
                d.per_page = d.length;
                d.draw     = d.draw;
            },
            dataSrc: function(res){
                return res.data || [];
            }
        },

        columns: [
            { data: 0 },  // No
            { data: 1 },  // Tanggal
            { data: 2 },  // Tim Potong
            { data: 3 },  // Nama PO
            { data: 4 },  // Roll Bahan
            { data: 5 },  // Panjang Gelaran
            { data: 6 },  // Pemakaian Bahan Kaos
            { data: 7 },  // Pemakaian Bahan Celana
            { data: 8 },  // Size
            { data: 9 },  // Jml PO (Dz)
            { data: 10 }  // Jml PO (Pcs)
        ],

        footerCallback: function(row, data){
            var api = this.api();
            var intVal = i => typeof i === 'string' ? i.replace(/,/g,'')*1 : typeof i === 'number' ? i : 0;

            // Loop kolom yang ingin dijumlahkan (4 sampai 10)
            for(let col=4; col<=10; col++){
                let total = api.column(col).data().reduce((a,b) => intVal(a) + intVal(b), 0);
                $(api.column(col).footer()).html(total);
            }
            $(api.column(0).footer()).html("Total");
        }
    });

    // Fungsi filter
    window.filter = function(){
        table.ajax.reload();
    };
});
</script>