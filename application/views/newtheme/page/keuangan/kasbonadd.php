<form method="post" action="<?php echo $action?>">
<div class="row">
  <div class="col-md-12">
    <div class="form-group">
      <label>Tanggal</label>
      <input type="text" id="tgl" name="tanggal" class="form-control datepicker" required="required" onblur="iptgl()">
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Tanggal</th>
                  <th>Nama Karyawan</th>
                  <th>Bagian</th>
                  <th>Jumlah Kasbon</th>
                  <th align="right"><a class="btn btn-info btn-sm text-white" onclick="addkasbon()"><i class="fa fa-plus"></i></a></th>
                </tr>
              </thead>
              <tbody id="addkasbon">
                
              </tbody>
            </table>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <a class="btn btn-info btn-sm text-white" onclick="simpan()">Simpan</a>
    <a class="btn btn-danger btn-sm text-white" href="<?php echo $batal?>">Batal</a>
  </div>
</div>
</form>
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
    html+='<td><select name="products['+i+'][idkaryawan]" class="form-control select2 select2bs4 karyawan" required data-live-search="true"><option value="">Pilih</option><?php foreach($karyawan as $k){?><option value="<?php echo $k['id']?>"><?php echo strtolower($k['nama'])?></option><?php } ?></select></td>';
    html+='<td><span class="bagian"></span><input type="hidden" name="products['+i+'][bagian]" class="bag"/></td>';
    html+='<td><input type="number" name="products['+i+'][jumlah]" class="form-control"></td>';
    html+='<td><i class="fa fa-trash remove"></i></td>';
    html+='</tr>';
    $("#addkasbon").append(html);
    $(".tgl").html(t);
    $('.select2').selectpicker();
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