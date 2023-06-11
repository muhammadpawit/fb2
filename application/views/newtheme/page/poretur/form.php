<form method="POST" action="<?php echo $action ?>">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label>Tanggal</label>
                <input type="text" name="tanggal" class="datepicker form-control" value="<?php echo date('Y-m-d') ?>" readonly required>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>Keterangan</label>
                <input type="text" name="keterangan" class="form-control" required>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>Kode PO</label>
                <select name="kode_po" class="form-control select2bs4 kode_po" required>
                    <option value=""></option>
                    <?php foreach(po_produksi_tahun('2022_2023') as $po){ ?>
                        <option value="<?php echo $po['id_produksi_po'] ?>,<?php echo $po['kode_po'] ?>"><?php echo $po['kode_po'] ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
            <table class="table table-bordered" id="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Size</th>
                        <th>Lusin</th>
                        <th>Piece</th>
                        <!-- <th>Tanggal</th> -->
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <button type="submit" class="btn btn-sm btn-success">Simpan</button>
            </div>
        </div>
    </div>
    <!-- <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Kode PO</th>
                            <th>Jumlah PCS</th>
                            <th width="50">
                                <button type="button" onclick="add()" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></button>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="list">

                    </tbody>
                </table>
            </div>
        </div>
    </div> -->
</form>

<script>
    var i=0;
    function add(){
        var html='';
            html+='<tr>';
            html+='<td></td>';
            html+='<td></td>';
            html+='<td></td>';
            html+='</tr>';
        $("#list").append(html);
    }

    $(document).ready(function () {
        let info =window.location.origin;
        if(info=='http://localhost'){
            var link=window.location.origin+'/fb2/';
        }else{
            var link=window.location.origin+'/';
        }
        $( ".kode_po" ).change(function() {
        //$("#data-table").empty();
        $('#sub1').empty();
        var cmts = $(this).val();
        //alert(cmts);
        $.get(link+'Poretur/caripo?&kode_po='+cmts, 
            function(data){   
            console.log(data);
            var table = document.getElementById('data-table');
            
            $("#data-table tbody").empty();
            var jsonData = JSON.parse(data);
            for (var i = 0; i < jsonData.length; i++) {
                var data = jsonData[i];
                var row = $("<tr></tr>");

                $("<td></td>").append($("<input>").attr("type", "text").attr("name", "prods["+i+"][id]").attr("value", data.id_finishing_kirim_gudang_rincian).val(data.id_finishing_kirim_gudang_rincian)).appendTo(row);
                $("<td></td>").append($("<input>").attr("type", "text").attr("name", "prods["+i+"][size]").attr("value", data.rincian_size).val(data.rincian_size)).appendTo(row);
                $("<td></td>").append($("<input>").attr("type", "text").attr("name", "prods["+i+"][rincian_lusin]").attr("value", data.rincian_lusin).val(data.rincian_lusin)).appendTo(row);
                $("<td></td>").append($("<input>").attr("type", "text").attr("name", "prods["+i+"][rincian_piece]").attr("value", data.rincian_piece).val(data.rincian_piece)).appendTo(row);
                //$("<td></td>").append($("<input>").attr("type", "text").val(data.created_date)).appendTo(row);
                $("<td></td>").append($("<input>").attr("type", "text").attr("name", "prods["+i+"][keterangan]").attr("value", data.katerangan_gudang_rincian).val(data.katerangan_gudang_rincian)).appendTo(row);

                row.appendTo("#data-table tbody");
            }
        });
        });
    });
</script>