<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label>Nama PO</label>
            <select name="jenispo" class="form-control select2bs4" data-live-search="true">
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
            <select name="model_po" class="form-control select2bs4" data-live-search="true">
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
        <table class="table table-bordered ss">
                <thead>
                  <tr>
                        <th>No</th>
                        <th>Nama PO</th>
                        <th>Potongan</th>
                        <th>Pengecekan</th>
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
                        <th></th>
                    </tr>
                </tfoot>
              </table>
    </div>
</div>
<script type="text/javascript">
function search_proses(){
    let url = '?';
    let sj = $('select[name="jenispo"]').val();
    if (sj != '*') url += '&jenispo=' + encodeURIComponent(sj);

    let val = $('select[name="validasi"]').val();
    if (val != '*') url += '&validasi=' + encodeURIComponent(val);

    let model_po = $('select[name="model_po"]').val();
    if (model_po != '*') url += '&model_po=' + encodeURIComponent(model_po);

    location = url;
}

$(document).ready(function () {
    const params = new URLSearchParams(window.location.search);

    const jenispo  = params.get('jenispo')  ?? null;
    const validasi = params.get('validasi') ?? null;
    const model_po = params.get('model_po') ?? null;

    $('.ss').DataTable({
        processing: true,
        serverSide: true,
        searching: false,
        paging: true,
        lengthChange: true,
        pageLength: 25,
        ordering: false,

        ajax: {
            url: '<?php echo  BASEURL.("LaravelApi/monitor") ?>', // CI controller
            type: 'GET',
            data: function(d){
                d.jenispo  = jenispo;
                d.validasi = validasi;
                d.model_po = model_po;
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
            { data: 3 }, // Pengecekan
            { data: 4 }, // Sablon
            { data: 5 }, // Bordir
            { data: 6 }, // Kirim Jahit
            { data: 7 }, // Setor Jahit
            { data: 8 }, // Kirim Gudang
            { data: 9 }, // Rijek
            { data: 10 } // Selisih
        ],

        footerCallback: function (row, data) {
            let api = this.api();
            let intVal = i => typeof i === 'string' ? i.replace(/,/g, '')*1 : typeof i === 'number' ? i : 0;

            for (let col=2; col<=10; col++){
                let total = api.column(col).data().reduce((a,b) => intVal(a)+intVal(b), 0);
                $(api.column(col).footer()).html(total);
            }
            $(api.column(0).footer()).html("Total");
        },

        responsive: true
    });
});
</script>