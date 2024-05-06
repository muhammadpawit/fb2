<form class="form-group" action="<?php echo $action?>" method="post">
                    <table class="table">
                      <tr>
                        <td><label>Tanggal</label></td>
                        <td>:</td>
                        <td>
                          <input type="date" class="form-control" name="tanggal" value="<?php echo date('Y-m-d') ?>" required>
                        </td>
                      </tr>
                      <tr>
                        <td><label>Proses</label></td>
                        <td>:</td>
                        <td>
                          <select class="form-control select2bs4" id="progress" name="progress" title="Pilih Progress" data-live-search="true" required>
                              <?php foreach ($progress as $key => $prog): ?>
                                      <option value="<?php echo $prog['nama_progress'] ?>" ><?php echo $prog['nama_progress'] ?></option>
                              <?php endforeach ?>
                              </select>
                        </td>
                      </tr>
                      <tr>
                        <td><label>Jenis CMT</label></td>
                        <td>:</td>
                        <td>
                          <select class="form-control select2bs4" id="cmtKats" name="cmtKat" title="Pilih CMT" required data-live-search="true" required>
                                  <option value="">Pilih</option>
                                  <option value="SABLON">SABLON</option>
                                  <!-- <option value="JAHIT">JAHIT</option> -->
                                  <!--<option value="BORDIR">BORDIR</option>-->
                              </select>
                        </td>
                      </tr>
                      <tr>
                        <td><label>Nama CMT</label></td>
                        <td>:</td>
                        <td>
                          <select class="form-control select2bs4" id="cmtNames" name="cmtName" required title="Pilih Nama CMT" data-live-search="true" required>
                          </select>
                        </td>
                      </tr>
                      <!--
                      <tr>
                        <td><label>Pengerjaan</label></td>
                        <td>:</td>
                        <td>
                          <select class="form-control select2bs4" name="cmtJob" data-live-search="true" required>
                            <option value="">Pilih</option>
                            <?php foreach($pekerjaan as $pk){?>
                              <option value="<?php echo $pk['id']?>-<?php echo $pk['nama_job']?>"><?php echo $pk['nama_job']?></option>
                            <?php }  ?>
                          </select>
                        </td>
                      </tr>-->
                      <!--
                      <tr>
                        <td><label>Pilih PO</label></td>
                        <td>:</td>
                        <td>
                          <select class="form-control select2bs4" name="namaPo[]" multiple="multiple" id="poSelect" data-live-search="true" required>
                              <option value=""></option>
                              <?php foreach($po as $p){?>
                                <option value="<?php echo $p['kode_po']?>"><?php echo $p['kode_po']?></option>
                              <?php } ?>
                          </select>
                        </td>
                      </tr>
                    -->
                      <tr>
                        <td><label>Keterangan</label></td>
                        <td>:</td>
                        <td>
                          <textarea name="keterangan" class="form-control"></textarea>
                        </td>
                      </tr>
                      <tr>
                        <td></td>
                        <td></td>
                        <td>    </td>
                      </tr>
                    </table>
                    <?php $row=0;?>
                    <p>Setiap PO yang akan di kirim harus sudah diinput pada pengecekan.</p>
                    <table class="table table-bordered" id="addkirimgudang">
                        <tr>
                          <th>Nama PO</th>
                          <th>Pekerjaan</th>
                          <th>Rincian PO</th>
                          <th>Jumlah PO (Pcs)</th>
                          <th>Jumlah Barang</th>
                          <th>Keterangan</th>
                          <th><button type="button" name="add" class="btn btn-success btn-sm addkirimgudang" onclick="addkirimgudang()"><i class="fa fa-plus"></i></button></th>
                        </tr>
                    </table>
                    <div id="rincianbahan"></div>
                  </form>
                  <div class="row">
                    <div class="col-md-12 pull-right text-right">
                       <a href="<?php echo $cancel?>" class="btn btn-danger text-white">Cancel</a>
                          <button onclick="simpan()" class="btn btn-primary">Simpan</button>
                    </div>
                  </div>
<script type="text/javascript">
    var i=0;
    function addkirimgudang(){
        var html = '';
        html += '<tr>';
        html += '<td><select type="text" class="form-control selectpicker kodepo kirimautopo" name="products['+i+'][kode_po]" data-size="4" data-live-search="true" data-title="Pilih item" required><option>Pilih</option><?php foreach ($kodepo as $key => $po) { ?><option value="<?php echo $po['idpo'] ?>" data-item="<?php echo $po['idpo'] ?>"><?php echo $po['nama_po'].' '.$po['kode_po'] ?></option><?php } ?></select></td>';
        html += '<td><select type="text" class="form-control selectpicker" name="products['+i+'][cmtjob]" data-size="4" data-live-search="true" data-title="Pilih item" required><?php foreach ($pekerjaan as $key => $po) { ?><option value="<?php echo $po['id'] ?>" data-item="<?php echo $po['id'] ?>"><?php echo $po['nama_job']; ?></option><?php } ?></select></td>';
        html += '<td><input type="text" class="form-control" name="products['+i+'][rincian_po]"  required ></td>';
        html += '<td><input type="number" class="form-control jumlah_pcs"  name="products['+i+'][jumlah_pcs]" required ></td>';
        html += '<td><input type="text" class="form-control" value="1 plastik" name="products['+i+'][jml_barang]" required ></td>';
        html += '<td><input type="text" class="form-control" name="products['+i+'][keterangan]" required ></td>';
        html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button></td></tr>';
        i++;
        $('#addkirimgudang').append(html);
        //$('.selectpicker').selectpicker('refresh');
        $('.selectpicker').select2();
     }
$(document).ready(function(){

    $(document).on('click', '.remove', function(){
        $(this).closest('tr').remove();
    });

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

    // $(document).on('change', '.selectpicker', function(e){
    //     /*
    //     var dataItem = $(this).find(':selected').data('item');
    //     var dai = $(this).closest('tr');
    //     var jumlahItem = $('#piecesPo').val();
    //     $.get( "<?php echo BASEURL.'finishing/kirimgudangsendRincinan' ?>", { kodepo: dataItem } )
    //       .done(function( data ) {
    //         var obj = JSON.parse(data);
    //         console.log(obj);
    //         dai.find(".jumlahPc").val(obj.jumlah_pcs_po);
    //     });*/
    // });
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
        $('.select2bs4').selectpicker('refresh');
    
  });;
});

$(document).on('change', '#cmtNames', function(){

    var jobCmt = $(this).children("option:selected").val();
    $.post( "<?php echo BASEURL.'kelolapo/searchCmtJob' ?>",{jobCmt: jobCmt }).done(function( html ) {
      console.log(html);
            $('#cmtJob').html(html);
            $('.select2bs4').selectpicker('refresh');
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
