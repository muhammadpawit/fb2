<form action="<?php echo $action ?>" method="POST" enctype="multipart/form-data">
<div class="row">
  <div class="row">
    <div class="col-md-12">
      <div class="form-group">
        <label for="">Tanggal</label>
        <input type="text" name="tanggal" class="form-control datepicker" readonly required>
      </div>
    </div>
    <div class="col-md-12">
      <div class="form-group">
        <label for="">Kepada</label>
        <input type="text" name="kepada" class="form-control">
      </div>
    </div>
    <div class="col-md-12">
      <div class="form-group">
        <label for="">Keterangan</label>
        <textarea name="keterangan" id="" class="form-control" rows="5"></textarea>
      </div>
    </div>
  </div>
  <div class="col-md-12">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th width="200">KODE PO</th>
                  <th>GAMBAR</th>
                  <th>POSISI</th>
                  <th>STICH</th>
                  <th>QTY</th>
                  <th>KETERANGAN</th>
                  <th>
                    <a onclick="tambahlist()" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i></a>
                  </th>
                </tr>
              </thead>
              <tbody id="list">
                
              </tbody>
            </table>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <button type="submit" class="btn btn-sm full btn-success">Simpan</button>
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <a href="<?php echo $cancel ?>" class="btn btn-sm btn-danger full">Batal</a>
    </div>
  </div>
</div>
</form>
<script>
  var i=0;
  function tambahlist(){
   
    var html = '';
        html += '<tr>';
        html += '<td><select type="text" style="width:100%" class="selectpicker selectpickers" name="products['+i+'][idpo]" data-size="4" data-live-search="true" data-title="Pilih item" required><?php foreach ($pos as $key => $po) { ?><option value=""></option><option value="<?php echo $po['id'] ?>" data-item="<?php echo $po['id'] ?>"><?php echo $po['nama']; ?></option><?php } ?></select></td>';
        html += '<td><input type="text" name="products['+i+'][gambar]"  required ></td>';
        html += '<td><input type="text" name="products['+i+'][posisi]" class="posisi"  required ></td>';
        html += '<td><input type="number" class="stich" name="products['+i+'][stich]" required></td>';
        html += '<td><input type="text" class="qty" name="products['+i+'][qty]" required ></td>';
        html += '<td><input type="text" name="products['+i+'][keterangan]" required ></td>';
        html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button></td></tr>';
        i++;
        $('#list').append(html);
        $('.selectpicker').select2();
        $(".selectpickers").select2({
          ajax: {
          url:"<?php echo BASEURL?>Bordir/caripoluar",
            dataType: 'json',
          data: function (params) {
            return {
              po: params.term,
            };
          },
          delay: 250,
          processResults: function (data) {
            return {
              results: data
            };
          },
        },
        }).on("select2:select",function(e){
            id=$(this).val();
            var dai = $(this).closest('tr');
            console.log("pilihan : ",id);
            $.get("<?php echo BASEURL.'Bordir/detailinputanharian' ?>", { kodepo: id })
              .done(function(data) {
                console.log("Detail data received from server:", data);
                
                if (Array.isArray(data)) {
                  var rows = "";
                  var i = 0;
                  $.each(data, function(index, v) {
                      rows += `<tr>
                          <td><input type="hidden" name="products[${v.id}][idpo]" value="${v.idpo}"> <input type="text" name="products[${v.id}][namapo]" value="${v.namapo}"></td>
                          <td><input type="text" name="products[${v.id}][gambar]" value="-" style="width: 50px;"></td>
                          <td><input type="text" class="posisi" name="products[${v.id}][posisi]" value="${v.bagian_bordir}"></td>
                          <td><input type="text" class="stich" name="products[${v.id}][stich]" value="${v.stich}"></td>
                          <td><input type="text" class="qty" name="products[${v.id}][qty]" value="${v.jumlah_naik_mesin}"></td>
                          <td><input type="text" name="products[${v.id}][keterangan]" value="${v.keterangan || ''}"></td>
                          <td><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button></td>
                      </tr>`;
                      i++;
                  });
                  $("#list").append(rows);
                } else {
                  console.error("Data received is not valid:", data);
                }
              })
              .fail(function(jqXHR, textStatus, errorThrown) {
                console.error("Request failed:", textStatus, errorThrown);
              });
            });
  }
</script>