<form class="form-group" action="<?php echo $action?>" method="post">
                    <table class="table">
                      <tr>
                        <td><label>Nama</label></td>
                        <td>:</td>
                        <td>
                        <select name="karyawan_id" class="form-control select2bs4" data-live-search="true">
                          <option value="*">Semua</option>
                          <?php foreach($nosj as $c){?>
                            <option value="<?php echo $c['id']?>"><?php echo strtoupper($c['nama'])?></option>
                          <?php } ?>
                        </select>
                        </td>
                        <td><label>Tanggal</label></td>
                        <td>:</td>
                        <td>
                          <input type="date" class="form-control" name="tanggal" value="<?php echo date('Y-m-d') ?>" required>
                        </td>
                      </tr>
                      <tr>
                        <td><label>Kedisiplinan</label></td>
                        <td>:</td>
                        <td>
                          <input type="text" name="kedisiplinan" class="form-control">
                        </td>
                        <td><label>Potongan Kedisiplinan</label></td>
                        <td>:</td>
                        <td>
                          <input type="text" name="kedisiplinan_pot" class="form-control">
                        </td>
                      </tr>
                      <tr>
                        <td><label>Kebersihan</label></td>
                        <td>:</td>
                        <td>
                          <input type="text" name="kebersihan" class="form-control">
                        </td>
                        <td><label>Potongan Kebersihan</label></td>
                        <td>:</td>
                        <td>
                          <input type="text" name="kebersihan_pot" class="form-control">
                        </td>
                      </tr>
                      <tr>
                        <td><label>Kontrol Video Call</label></td>
                        <td>:</td>
                        <td>
                          <input type="text" name="kontrol_vc" class="form-control">
                        </td>
                        <td><label>Potongan Kontrol Video Call</label></td>
                        <td>:</td>
                        <td>
                          <input type="text" name="kontrol_vc_pot" class="form-control">
                        </td>
                      </tr>
                      <tr>
                        <td><label>Foto Per 2 Jam</label></td>
                        <td>:</td>
                        <td>
                          <input type="text" name="foto" class="form-control">
                        </td>
                        <td><label>Potongan Per 2 Jam</label></td>
                        <td>:</td>
                        <td>
                          <input type="text" name="foto_pot" class="form-control">
                        </td>
                      </tr>
                      <tr>
                        <td><label>Ketentuan</label></td>
                        <td>:</td>
                        <td>
                          <input type="text" name="ketentuan" class="form-control">
                        </td>
                        <td><label>Potongan Ketentuan</label></td>
                        <td>:</td>
                        <td>
                          <input type="text" name="ketentuan_pot" class="form-control">
                        </td>
                      </tr>
                      
                     
                      <tr>
                        <td><label>Shift</label></td>
                        <td>:</td>
                        <td>
                            <select name="shift" class="form-select select2bs4">
                              <option value="Pagi">Pagi</option>
                              <option value="Malam">Malam</option>
                            </select>
                        </td>
                        <td><label>Keterangan</label></td>
                        <td>:</td>
                        <td>
                        <input type="text" class="form-control" name="keterangan">
                        </td>
                      </tr>
                      <tr>
                        <td></td>
                        <td></td>
                        <td>    </td>
                      </tr>
                    </table>
                    <?php $row=0;?>
                   
                  </form>
                  <div class="row">
                    <div class="col-md-12 pull-right text-right">
                       <a href="<?php echo $cancel?>" class="btn btn-danger text-white">Cancel</a>
                          <button onclick="simpan()" class="btn btn-primary">Simpan</button>
                    </div>
                  </div>
<script type="text/javascript">
    var i=0;
    info =window.location.origin;
   if(info=='http://localhost'){
    var uri=window.location.origin+'/fb2/Json/';
   }else{
    var uri=window.location.origin+'/Json/';
   }
    function addkirimgudang(){
        var html = '';
        html += '<tr>';
        html += '<td width="50px"><select type="text" class="form-control kirimautopo" name="products['+i+'][kode_po]" style="width:200px" required></select></td>';
        // html += '<td><select type="text" style="width:80%" class="selectpicker" name="products['+i+'][cmtjob]" data-size="4" data-live-search="true" data-title="Pilih item"><option></option><?php foreach ($pekerjaan as $key => $po) { ?><option value="<?php echo $po['id'] ?>" data-item="<?php echo $po['id'] ?>"><?php echo $po['nama_job']; ?></option><?php } ?></select></td>';
        html += '<td><input type="text" name="products['+i+'][rincian_po]"  required ></td>';
        html += '<td><input type="number" class="jumlah_pcs"  name="products['+i+'][jumlah_pcs]" required></td>';
        html += '<td><input type="text" value="1 plastik" name="products['+i+'][jml_barang]" required ></td>';
        html += '<td><input type="text" name="products['+i+'][keterangan]" required ></td>';
        html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button></td></tr>';
        i++;
        $('#addkirimgudang').append(html);
        //$('.selectpicker').selectpicker('refresh');
        $('.selectpicker').select2();
        $('.kirimautopo').select2({
          //theme: 'bootstrap4',
          placeholder: '--- Pilih ---',
            ajax: {
              url: uri+'search_po_kirimjahit',
              dataType: 'json',
              delay: 250,
              processResults: function (data) {
                return {
                  results: data
                };
              },
              cache: true
            }
        });
     }
$(document).ready(function(){

    $(document).on('click', '.remove', function(){
        c = confirm("Apaka yakin akan dihapus item ini ?");
        if(c==true){
          $(this).closest('tr').remove();
        }
    });

    // $(document).on('change', '.kirimautopo', function(e){
    //    alert(this.value);
    // });

        $(document).on('change', '.kirimautopo', function(e){
            var dataItem = this.value;
            var dai = $(this).closest('tr');
            var jumlahItem = 1000;
            // dai.find(".jumlah_pcs").val(jumlahItem);
            $.get( "<?php echo BASEURL.'Kelolapo/cariproduct' ?>", { id: dataItem } )
              .done(function( data ) {
                var obj = JSON.parse(data);
                console.log(obj);
                if(obj != null){
                  dai.find(".jumlah_pcs").val(obj.hasil_pieces_potongan);
                }else{
                  alert("Kode PO "+dataItem+" belum diinput pada buku potongan");
                  dai.closest('tr').remove();
                }
            });
        });

});
 </script>                  
<script type="text/javascript">
  function simpan(){
    const jeniscmt=$("#cmtKat").val();
    const cmtName=$("#cmtName").val();
    const cmtJob=$("#cmtJob").val();
    const poSelect=$("#poSelect").val();
    
      if(jeniscmt==''){
        alert("Jenis CMT harus dipilih");
        return false;
      }
      if(cmtName==''){
        alert("Nama CMT harus dipilih");
        return false;
      }
      if(cmtJob==''){
        alert("Pekerjaan CMT harus dipilih");
        return false;
      }
      if(poSelect==''){
        alert("PO harus dipilih");
        return false;
      }
    const c=confirm("Apakah yakin akan menyimpan?");
    if(c==true){
      $("form").submit();
    }else{
      return false;
    }
    
  }
  function cancel(){
    const url='<?php echo BASEURL?>';
    window.location.replace(url);
  }
$(document).ready(function(){

$(document).on('click', '.remove', function(){
    $(this).closest('tr').remove();
});


  $(document).on('change', '#cmtKats', function(){

    var jobCmt = $(this).children("option:selected").val();

    $.post( "<?php echo BASEURL.'kelolapo/searchCmt' ?>", { jobCmt: jobCmt } ).done(function( html ) {

        $('#cmtNames').html(html);
        //$('.select2bs4').selectpicker('refresh');
        $('.select2bs4').select2();
    
  });;
});

$(document).on('change', '#cmtNames', function(){

    var jobCmt = $(this).children("option:selected").val();
    $.post( "<?php echo BASEURL.'kelolapo/searchCmtJob' ?>",{jobCmt: jobCmt }).done(function( html ) {
      console.log(html);
            $('#cmtJob').html(html);
            //$('.select2bs4').selectpicker('refresh');
            $('.select2bs4').select2();
      });
});

$(document).on('change', '#poSelect', function(){
  /*
    $('#item_table').empty();
    var poid = $(this).children("option:selected").val();
    $.post( "<?php echo BASEURL.'Produksi/searchPO' ?>",{POid: poid }).done(function( html ) {
      console.log(html);
            $('#item_table').append(html);
    });

    $.post( "<?php echo BASEURL.'Produksi/searchPObahan' ?>",{POid: poid }).done(function( rincian ) {
      console.log(rincian);
            $('#rincianbahan').html(rincian);
    });
  */
});


});


</script>
