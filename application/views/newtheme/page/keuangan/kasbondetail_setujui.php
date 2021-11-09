 
      <!-- Default box -->
      <div class="card card-info">
        <div class="card-header">
          <h3 class="card-title">Persetujuan Kasbon Karyawan</h3>
        </div>
        <div class="card-body">
          <div class="card-header"></div>
          <div class="table-responsive">
            <form method="post" action="<?php echo $action?>">
              <div class="form-group col-sm-12 col-lg-6">
                  <label>Tanggal</label>
                  <input type="date" id="tgl" name="tanggal" class="form-control" required="required" value="<?php echo $acc['tanggal']?>">
                  <input type="hidden" id="id" name="id" class="form-control" required="required" value="<?php echo $acc['id']?>">
              </div>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Tanggal</th>
                  <th>Nama Karyawan</th>
                  <th>Bagian</th>
                  <th>Jumlah Kasbon</th>
                  <th>Jumlah Di ACC</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($detail as $d){?>
                  <tr>
                    <td><input type="hidden" name="products[<?php echo $i?>][id]" value="<?php echo $d['id']?>"><?php echo $d['tanggal'];?></td>
                    <td><?php echo $d['nama'];?></td>
                    <td><?php echo $d['divisi'];?></td>
                    <td>Rp. <?php echo number_format($d['nominal']);?></td>
                    <td><input type="number" name="products[<?php echo $i?>][nominal_acc]" value="<?php echo $d['nominal'];?>" class="form-control"></td>
                  </tr>
                  <?php $i++?>
                <?php } ?>
              </tbody>
            </table>
            </form>
          </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer text-right">
          <a class="btn btn-info text-white" onclick="simpan()">Setujui</a>
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->
<script type="text/javascript">
  $(document).ready(function(){

    $('.select2').select2({
      theme: "classic",
      placeholder: 'Select an option'
    });

    


  });

  function iptgl(){
    var t=$("#tgl").val();
    $(".tgl").html(t);
  }

  var i=0;
  function addkasbon(){
    var t=$("#tgl").val();
    var html='';
    html+='<tr>';
    html+='<td><span class="tgl"></span></td>';
    html+='<td><select name="products['+i+'][idkaryawan]" class="form-control select2 select2bs4 karyawan" required><option value="">Pilih</option><?php foreach($karyawan as $k){?><option value="<?php echo $k['id']?>"><?php echo $k['nama']?></option><?php } ?></select></td>';
    html+='<td><span class="bagian"></span><input type="hidden" name="products['+i+'][bagian]" class="bag"/></td>';
    html+='<td><input type="text" name="products['+i+'][jumlah]"/></td>';
    html+='<td><i class="fa fa-trash remove"></i></td>';
    html+='</tr>';
    $("#addkasbon").append(html);
    $(".tgl").html(t);
    $('.select2').select2({
      theme: "classic",
      placeholder: 'Select an option'
    });
    $(document).on('change', '.karyawan', function(e){
            var select = $(this).find(':selected').val();
            var dai = $(this).closest('tr');
            $.get( "<?php echo BASEURL.'Masterdata/karyawanget' ?>", { id: select }  )
              .done(function( data ) {
                var obj = JSON.parse(data);
                console.log(obj);
                dai.find(".bagian").html(obj.nama);
                dai.find(".bag").val(obj.id);
            });
        });
    /*
    $(document).on('change', '.karyawan', function(){
        var select = $(this).find(':selected').val();
         $.get( "<?php echo BASEURL.'Masterdata/karyawanget' ?>", { id: select } )
          .done(function( data ) {
            var obj = JSON.parse(data);
            console.log(obj);
            $(".bagian-").html(obj);
            
        });
    });*/
    i++;
  }

  function simpan(){
    $("form").submit();
  }

  $(document).on('click', '.remove', function(){

        $(this).closest('tr').remove();

    });

</script>