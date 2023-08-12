      <!-- Default box -->
    <form method="post" action="<?php echo $action?>">      
      <div class="card card-info">
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
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
            <div class="col-md-6">
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
                    <option value="<?php echo $p['product_id']?>" data-item="<?php echo $p['product_id'] ?>"><?php echo $p['nama']?></option>
                  <?php  } ?>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Supplier</label>
                <!-- <textarea name="kebutuhan" class="form-control" placeholder="contoh : Plastik, Size, dll" required="required"></textarea> -->
                <select name="supplier_id" class="form-control select2bs4" data-live-search="true">
                  <option value="-">Pilih</option>
                  <?php foreach($supplier as $p){?>
                    <option value="<?php echo $p['id']?>"><?php echo $p['nama']?></option>
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
              <input type="text" name="stok" id="stok" class="form-control" required="required">
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
                    <th>Jumlah PO</th>
                    <th>Rincian PO</th>
                    <th>Jml Pcs</th>
                    <th>Jml Dz</th>
                    <th>Keterangan</th>
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
    var html='<tr>';
        html+='<td><input type="text" name="products['+i+'][kode_po]" class="form-control" required="required" value="-"></td>';
        html+='<td><input type="text" name="products['+i+'][jumlah_po]" class="form-control" required="required" value="0"></td>';
        html+='<td><textarea cols="50" rows="5" name="products['+i+'][rincian_po]" class="form-control" required="required"></textarea></td>';
        html+='<td><input type="text" name="products['+i+'][jml_pcs]" class="form-control" required="required" value="0"></td>';
        html+='<td><input type="text" name="products['+i+'][jml_dz]" class="form-control" required="required" value="0"></td>';
        html+='<td><textarea cols="50" rows="5" name="products['+i+'][keterangan]" class="form-control" required="required"></textarea></td>';
        html+='<td><i class="fa fa-trash remove"></i></td>';
        html+='</tr>';
        $("#listajuan").append(html);
        //$(".select2bs4").select2();
        i++;
  }

  $(document).on('click', '.remove', function(){

        $(this).closest('tr').remove();

    });

    $(document).on('change', '.select2bs4', function(e){
            var dataItem = $(this).find(':selected').data('item');
            //alert(dataItem);
            var type = '1';
            $.get( "<?php echo BASEURL.'Ajuanalatalat/cariproduct_stok' ?>", { id: dataItem } )
              .done(function( data ) {
                var obj = JSON.parse(data);
                console.log(obj);
                $("#stok").val(obj.quantity);
                $("#stok").attr("readonly",true);
            });
        });

</script>