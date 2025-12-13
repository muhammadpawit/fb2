<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label>Nama PO</label>
            <select name="jenispo" id="jenispo" class="form-control select2bs4" data-live-search="true">
                <option value="*">Semua</option>
                <?php foreach($jenis as $j){?>
                    <option value="<?php echo $j['id_jenis_po']?>" <?php echo $j['id_jenis_po']==$jenispo?'selected':'';?>><?php echo $j['nama_jenis_po']?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Model PO</label>
            <select name="model_po" id="model_po" class="form-control select2bs4" data-live-search="true">
                <option value="*">Semua</option>
                <?php foreach($model_pos as $j){?>
                    <option value="<?php echo $j['id']?>" <?php echo $j['id']==$model_po?'selected':'';?>><?php echo $j['nama_model']?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <label>Validasi PO</label>
        <select id="validasi" name="validasi">
            <option value="*">Semua</option>
            <option value="0">Tidak</option>
            <option value="1">Ya</option>
        </select>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Aksi</label><br>
            <button class="btn btn-info btn-sm" onclick="search_proses()">Filter</button>
        </div>
    </div>
    <div class="col-md-12">
        <table class="table table-bordered ss" style="width: auto;">
                <thead>
                  <tr>
                        <th width="2%">No</th>
                        <th>Nama PO</th>
                        <th>Potongan</th>
                        <!-- <th>Pengecekan</th> -->
                        <th>Sablon</th>
                        <th>Bordir</th>
                        <th>Kirim Jahit</th>
                        <th>Setor Jahit</th>
                        <th>Kirim Gudang</th>
                         <th>Rijek</th>
                         <th>Selisih</th>
                         <!-- <th>Bangke</th> -->
                  </tr>
                </thead>
                <tbody>
                  
                </tbody>
                <tfoot>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </tfoot>
              </table>
    </div>
</div>
<script type="text/javascript">
function search_proses(){
     $('.ss').DataTable().ajax.reload();
}

$(document).ready(function () {
    const params = new URLSearchParams(window.location.search);

    

    
    $('.ss').DataTable({
        processing: true,
        serverSide: true,
        searching: false,
        paging: true,
        lengthChange: true,
        pageLength: 10,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]], // pilihan jumlah row
        ordering: false,

        ajax: {
            url: '<?php echo  BASEURL.("LaravelApi/proses_produksi") ?>', // CI controller
            type: 'GET',
            data: function(d){

                const jenispo  = $('#jenispo').val();
                const validasi = $('#validasi').val();
                const model_po = $('#model_po').val();
                d.jenispo  = jenispo !== '*' ? jenispo : null;
                d.validasi = validasi !== '*' ? validasi : null;
                d.model_po = model_po !== '*' ? model_po : null;
                d.page     = Math.ceil(d.start / d.length) + 1;
                d.per_page = d.length;
                d.draw     = d.draw;

                return d; // wajib
            },
            dataSrc: function(res){
                return res.data || [];
            }
        },

        columns: [
            { data: 0 }, // No
            { data: 1 }, // Nama PO
            { data: 2 }, // Potongan
            { data: 3 }, // Sablon
            { data: 4 }, // Bordir
            { data: 5 }, // Kirim Jahit
            { data: 6 }, // Setor Jahit
            { data: 7 }, // Kirim Gudang
            { data: 8 }, // Rijek
            { data: 9 } // Selisih
        ],

        footerCallback: function (row, data) {
            let api = this.api();
            let intVal = i => typeof i === 'string' ? i.replace(/,/g, '')*1 : typeof i === 'number' ? i : 0;

            for (let col=2; col<=9; col++){
                let total = api.column(col).data().reduce((a,b) => intVal(a)+intVal(b), 0);
                $(api.column(col).footer()).html(total);
            }
            $(api.column(0).footer()).html("Total");
        },

        responsive: true
    });

    // Fungsi filter
    window.filter = function(){
        table.ajax.reload();
    };
});
</script>