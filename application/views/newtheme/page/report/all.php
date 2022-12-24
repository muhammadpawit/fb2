<div class="row">
    <div class="col-md-6">
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
    <div class="col-md-6">
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
                        <th>Selisih</th>
                        <th>Stok Di Finishing</th>
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
        url='?';
    
        var sj = $('select[name=\'jenispo\']').val();

        if (sj != '*') {
          url += '&jenispo=' + encodeURIComponent(sj);
        }

        location =url;
      }


    $(document).ready(function () {
         const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);
            const page_type = urlParams.get('halaman');
            const jenispo = urlParams.get('jenispo');
            //alert(jenispo);
            url='?';

            if (jenispo != '*') {
              url += '&jenispo=' + encodeURIComponent(jenispo);
            }
        $('.ss').DataTable( {
            "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // converting to interger to find total
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // computing column Total of the complete result 
            var monTotal = api
                .column( 2 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
                
            var tueTotal = api
                    .column( 3 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
                    
                var wedTotal = api
                    .column( 4 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
                    
             var thuTotal = api
                    .column( 5 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
                    
             var friTotal = api
                    .column( 6 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

            var sfriTotal = api
                    .column( 7 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

            var dfriTotal = api
                    .column( 8 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

             var adfriTotal = api
                    .column( 9 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

            var adfriTotal = api
                    .column( 10 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
                
                    
                // Update footer by showing the total with the reference of the column index 
                $( api.column( 0 ).footer() ).html('Total');
                $( api.column( 1 ).footer() ).html('');
                $( api.column( 2 ).footer() ).html(monTotal);
                $( api.column( 3 ).footer() ).html(tueTotal);
                $( api.column( 4 ).footer() ).html(wedTotal);
                $( api.column( 5 ).footer() ).html(thuTotal);
                $( api.column( 6 ).footer() ).html(friTotal);
                $( api.column( 7 ).footer() ).html(sfriTotal);
                $( api.column( 8 ).footer() ).html(dfriTotal);
                $( api.column( 9 ).footer() ).html(adfriTotal);
                $( api.column( 10 ).footer() ).html(adfriTotal);
            },
            "processing": true,
            "serverSide": true,
            // "ordering": true,
            "searching":false,
            "paging":   false,
            "lengthChange": false,
            "ajax":'<?php echo BASEURL?>Json/monitor'+url,
            responsive: true,
        });

    });
</script>