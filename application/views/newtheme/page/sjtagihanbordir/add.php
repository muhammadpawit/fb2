<form class="form-group" method="post" action="<?php echo $action?>">
              <div class="row">
                <div class="col-4">
                  <div class="form-group">
                    <label>Tanggal Awal</label>
                    <input type="text" name="tanggal1" class="form-control" value="<?php echo date('Y-m-d')?>">
                  </div>
                </div>
                <div class="col-4">
                  <div class="form-group">
                    <label>Tanggal Akhir</label>
                    <input type="text" name="tanggal2" class="form-control" value="<?php echo date('Y-m-d')?>">
                  </div>
                </div>
                <div class="col-4">
                  <div class="form-group">
                    <label>Pemilik</label>
                    <select name="pemilik" class="form-control select2bs4" data-live-search="true">
                      <option value="-">Pilih</option>
                      <?php foreach($pemilik as $p){?>
                        <option value="<?php echo $p['id']?>"><?php echo $p['nama']?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                    <table class="table table-bordered" id="addbahankeluars">
                      <thead>
                        <tr>
                          <th>Tgl Kirim</th>
                          <th>Nama PO</th>
                          <th>Keterangan</th>
                          <th>Size</th>
                          <th>Sticth</th>
                          <th>Qty</th>
                          <th>Total Sticth</th>
                          <th>Harga</th>
                          <th>Total</th>
                          <th>Ket</th>
                          <th><button onclick="addbahankeluars()" type="button" name="add" class="btn btn-success btn-sm addbahankeluars"><i class="fa fa-plus"></i></button></th>
                        </tr>
                      </thead>
                      <tbody>
                        
                      </tbody>
                    </table>                  
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                    <div class="form-group">
                      <button type="submit" class="btn btn-success text-white">Simpan</button>
                      <a href="<?php echo $cancel?>" class="btn btn-danger text-white">Batal</a>
                    </div>
                </div>
              </div>
            </form>
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
            
<script type="text/javascript">
    //$.noConflict();
    var product_row=0;
      function addbahankeluars(){
        var html = '';
        html += '<tr id="product-row' + product_row + '">>';
        //html += '<td><input type="text" class="form-control datepicker" name="products['+product_row+'][tgl]" ></td>';
        html += '<td></td>';
        html += '<td style="display:none;"><input type="hidden" class="form-control id" name="products['+product_row+'][idpersediaan]" ><input type="hidden" class="form-control harga" name="products['+product_row+'][harga]" ></td>';
        html += '<td><input type="text" class="form-control" name="products['+product_row+'][kode_po]" data-id="'+product_row+'" onkeyup="komplit('+product_row+')" ></td>';
        //html += '<td><select type="text" class="form-control barang select2bs4" name="products['+i+'][nama]" data-live-search="true" data-title="Pilih item" required><option value="">Pilih</option><?php foreach ($barang as $key => $item) { ?><option value="<?php echo $item['id'] ?>,<?php echo $item['nama'] ?>" data-item="<?php echo $item['id'] ?>"><?php echo $item['nama'] ?></option><?php } ?></select></td>';
        html += '<td></td>';
        html += '<td></td>';
        html += '<td></td>';
        html += '<td></td>';
        html += '<td></td>';
        html += '<td></td>';
        html += '<td></td>';
        html += '<td></td>';
        html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button></td></tr>';
     
        product_row++;
        $('#addbahankeluars tbody').before(html);
        //$('.select2bs4').selectpicker('refresh');
        $( ".datepicker" ).datepicker({ 
          dateFormat: 'yy-mm-dd',
          maxDate:+1,
          yearRange: '2019:2070',
        });
        //$('.barang').select2({
          //theme: 'bootstrap4'
        //});
     };

    $(document).on('click', '.remove', function(){
        $(this).closest('tr').remove();
    });

    
function komplit(coba){
 // Single Select
 $("input[name='products["+coba+"][kode_po]']").autocomplete({
  source: function( request, response ) {
   // Fetch data
   $.ajax({
    url: "<?php echo BASEURL.'Suratjalanhrizon/searchbordir' ?>",
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
      var harga=Number(details_value['stich'])*Number(details_value['laporan_perkalian_tarif']);
      var total=Number(details_value['jumlah_naik_mesin'])*(Number(details_value['stich'])*Number(details_value['laporan_perkalian_tarif']));
      var totalsticth=Number(details_value['stich'])*Number(details_value['jumlah_naik_mesin']);
      var html='';
          html += '<tr>';
          html += '<td><input type="text" class="form-control datepicker" name="products['+coba+'][tgl]"></td>';
          html += '<td><input type="hidden" class="form-control" name="products['+coba+'][idpo]" value="'+ui.item.value+'"><input type="hidden" class="form-control" name="products['+coba+'][namapo]" value="'+ui.item.label+'">'+ui.item.label+'</td>';
          html += '<td><input type="hidden" class="form-control" name="products['+coba+'][keterangan]" value="'+details_value['bagian_bordir']+'">'+details_value['bagian_bordir']+'</td>';
          html += '<td><input type="hidden" class="form-control" name="products['+coba+'][size]" value="'+details_value['size']+'">'+details_value['size']+'</td>';
          html += '<td><input type="hidden" class="form-control" name="products['+coba+'][sticth]" value="'+details_value['stich']+'">'+details_value['stich']+'</td>';
          html += '<td><input type="hidden" class="form-control" name="products['+coba+'][qty]" value="'+details_value['jumlah_naik_mesin']+'">'+details_value['jumlah_naik_mesin']+'</td>';
          html += '<td><input type="hidden" class="form-control" name="products['+coba+'][totalsticth]" value="'+totalsticth.toFixed(0)+'">'+totalsticth.toFixed(0)+'</td>';

          html += '<td><input type="hidden" class="form-control" name="products['+coba+'][harga]" value="'+harga.toFixed(0)+'">'+harga.toFixed(0)+'</td>';

          html += '<td><input type="hidden" class="form-control" name="products['+coba+'][total]" value="'+total.toFixed(0)+'">'+total.toFixed(0)+'</td>';
          
          html += '<td><input type="text" class="form-control" name="products['+coba+'][ket]"></td>';

          html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button></td></tr>';

          html += '</tr>';

        $('#addbahankeluars tbody').before(html);
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


 </script>      