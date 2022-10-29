      <!-- Default box -->
    <form method="post" action="<?php echo $action?>">      
      <div class="card card-info">
        <div class="card-body">
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label>Tanggal</label>
                <input type="text" name="tanggal" class="form-control datepicker" required="required">
              </div>
            </div>
            <!--<div class="col-md-6">
              <div class="form-group">
                <label>Sampai</label>
                <input type="date" name="tanggal2" class="form-control datepicker" required="required">
              </div>
            </div>-->
            <div class="col-md-3">
              <div class="form-group">
                <label>Bagian</label>
                <select name="jenis" class="form-control select2bs4" required="required">
                  <option value="">Pilih</option>
                  <option value="1">Konveksi</option>
                  <option value="2">Bordir</option>
                  <option value="3">Sablon</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Kebutuhan</label>
                <!-- <textarea name="kebutuhan" class="form-control" placeholder="contoh : Plastik, Size, dll" required="required"></textarea> -->
                <select name="kebutuhan" class="form-control select2bs4" data-live-search="true">
                  <option value="-">Pilih</option>
                  <?php foreach($products as $p){?>
                    <option value="<?php echo $p['nama']?>"><?php echo $p['nama']?></option>
                  <?php  } ?>
                </select>
              </div>
            </div>
            <div class="col-md-12">
              <label>Ajuan Roll</label>
            </div>
            <div class="col-md-4">
              <label>Kebutuhan</label>
              <input type="text" name="ajuan_kebutuhan" class="form-control" value="0" readonly>
            </div>
            <div class="col-md-4">
              <label>Stok</label>
              <input type="text" name="stok" class="form-control" required="required">
            </div>
            <div class="col-md-4">
              <label>Ajuan</label>
              <input type="number" name="jml_ajuan" class="form-control" value="0" readonly>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Keterangan</label>
                <input type="text" name="keterangan2" class="form-control" value="Untuk 1 minggu">
              </div>
            </div>
            <div class="col-md-12">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Nama PO</th>
                    <th>Plastik UK 23</th>
                    <th>Plastik UK 35</th>
                    <th>Plastik UK 25</th>
                    <th>Plastik UK 38</th>
                    <th>Plastik 28</th>
                    <th>Plastik 40</th>
                    <th>Pita</th>
                    <th>Karet</th>
                    <th>Size Bordir</th>
                    <th align="right"><a onclick="tambah()" class="btn btn-info btn-sm text-white"><i class="fa fa-plus"></i></a></th>
                  </tr>
                </thead>
                <tbody id="listajuan">
                  
                </tbody>
              </table>
              <div class="form-group">
                <button type="submit" class="btn btn-info">Simpan</button>
              </div>
            </div>
          </div>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </form>      
<script type="text/javascript">
  var i=0;
  function tambah() {
    var html='<tr id="product-row' + i + '">';
        //html+='<td><input type="text" name="products['+i+'][kode_po]" class="form-control" required="required" value="-"></td>';
        html += '<td><input type="text" class="form-control" name="products['+i+'][kode_po]" data-id="'+i+'" onkeyup="komplit('+i+')" ></td>';
        // html+='<td><input type="text" name="products['+i+'][jumlah_po]" class="form-control" required="required" value="0"></td>';
        // html+='<td><textarea cols="50" rows="5" name="products['+i+'][rincian_po]" class="form-control" required="required"></textarea></td>';
        // html+='<td><input type="text" name="products['+i+'][jml_pcs]" class="form-control" required="required" value="0"></td>';
        // html+='<td><input type="text" name="products['+i+'][jml_dz]" class="form-control" required="required" value="-"></td>';
        // html+='<td><textarea cols="50" rows="5" name="products['+i+'][keterangan]" class="form-control" required="required"></textarea></td>';
        // html+='<td><i class="fa fa-trash remove"></i></td>';
        html+='</tr>';
        $("#listajuan").append(html);
        $(".select2bs4").selectpicker('refresh');
        i++;
  }

function komplit(coba){
 // Single Select
 $("input[name='products["+coba+"][kode_po]']").autocomplete({
  source: function( request, response ) {
   // Fetch data
   $.ajax({
    url: "<?php echo BASEURL.'Json/search_po_pot' ?>",
    type: 'GET',
    dataType: "json",
    data: {
     search: request.term
    },
    success: function( data ) {
     response( data );
    }
   });
  },
  select: function (event, ui) {
     // Set selection
     $('#autocomplete').val(ui.item.label); // display the selected text
     $('#selectuser_id').val(ui.item.value); // save selected id to input
     var column=$(this).data("id");
     $('#product-row'+coba).remove();
     //console.log(ui.item['details']);
     for (j = 0; j < ui.item.count; j++) {
      details_value = ui.item['details'][j];
      var html='';
          html += '<tr>';
          html += '<td><input type="hidden" class="form-control" name="products['+coba+'][idpo]" value="'+ui.item.value+'"><input type="hidden" class="form-control" name="products['+coba+'][kode_po]" value="'+ui.item.label+'">'+ui.item.label+'</td>';

          html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button></td></tr>';

          html += '</tr>';

        $('#listajuan tbody').before(html);
        coba++;
        product_row=coba;
        $( ".datepicker" ).datepicker({ 
          dateFormat: 'yy-mm-dd',
          maxDate:+1,
          yearRange: '2019:2070',
        });
     }
  },
  focus: function(event, ui){
     $( "#autocomplete" ).val( ui.item.label );
     $( "#selectuser_id" ).val( ui.item.value );
     return false;
   },
 });
}

  $(document).on('click', '.remove', function(){

        $(this).closest('tr').remove();

    });

</script>