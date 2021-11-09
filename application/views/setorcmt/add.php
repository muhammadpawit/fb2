<!-- DataTables -->
<link href="<?php echo PLUGINS ?>datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo PLUGINS ?>datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<!-- Responsive datatable examples -->
<link href="<?php echo PLUGINS ?>datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />    
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card-box table-responsive">
                    <div class="row">

                <div class="col-12">
                  <h4 class="text-center">Penerimaan PO</h4>
                </div>
                <div class="col-12 form-control">
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
                          <select class="form-control select2" id="progress" name="progress" title="Select Progress" data-live-search="true" required>
                              <?php foreach ($progress as $key => $prog): ?>
                                  <?php if ($prog['nama_progress'] == $poProd['progress']){ ?>
                                  <?php } else { ?>
                                      <option value="<?php echo $prog['nama_progress'] ?>" ><?php echo $prog['nama_progress'] ?></option>
                                  <?php } ?>
                              <?php endforeach ?>
                              </select>
                        </td>
                      </tr>
                      <tr>
                        <td><label>Jenis CMT</label></td>
                        <td>:</td>
                        <td>
                          <select class="form-control select2" id="cmtKat" name="cmtKat" title="Select CMT" required data-live-search="true" required>
                                  <option value="">Pilih</option>
                                  <option value="SABLON">SABLON</option>
                                  <option value="JAHIT">JAHIT</option>
                                  <option value="BORDIR">BORDIR</option>
                              </select>
                        </td>
                      </tr>
                      <tr>
                        <td><label>Nama CMT</label></td>
                        <td>:</td>
                        <td>
                          <select class="form-control select2" id="cmtName" name="cmtName" required title="Select CMT name" data-live-search="true" required>
                          </select>
                        </td>
                      </tr>
                      <!--
                      <tr>
                        <td><label>Pengerjaan</label></td>
                        <td>:</td>
                        <td>
                          <select class="form-control select2" id="cmtJob" name="cmtJob"  title="Select CMT name" data-live-search="true" required>
                              </select>
                        </td>
                      </tr>-->
                      <tr>
                        <td><label>No Surat Jalan</label></td>
                        <td>:</td>
                        <td>
                         <!--  <select class="form-control select2" name="sj[]" id="sj">
                              <option value=""></option>
                              <?php foreach($sj as $p){?>
                                <option value="<?php echo $p['id']?>"><?php echo $p['nosj']?></option>
                              <?php } ?>
                          </select> -->
                          <select name="sj" class="form-control select2" id="sj" data-live-search="true" required>
                            
                          </select>
                        </td>
                      </tr>
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
                        <td>
                          <a onclick="cancel()" class="btn btn-danger">Cancel</a>
                          <a onclick="simpan()" class="btn btn-primary">Simpan</a>
                        </td>
                      </tr>
                    </table>
                    <?php $row=0;?>
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th></th>
                          <th>Nama PO</th>
                          <th>Bagian</th>
                          <th>Warna</th>
                          <th>JML</th>
                          <th>BANKE</th>
                          <th>REJECT</th>
                          <th>HILANG</th>
                          <th>CLAIM</th>
                          <th>KETERANGAN</th>
                          <!--th align="right"><a onclick="add()" class="btn btn-success"><i class="fa fa-plus"></i></a></th-->
                        </tr>
                      </thead>
                      <tbody id="item_table">
                        
                      </tbody>
                    </table>
                    <div id="rincianbahan"></div>
                  </form>
                   <p>
                     
                   </p>
                </div>
                  </div>
                   <p class="text-muted font-14 m-b-30">

                    <?php if ($this->session->flashdata('msg')) { ?>

                    <div class="alert alert-primary alert-dismissible fade show" role="alert">

                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">

                            <span aria-hidden="true">×</span>

                        </button>
                           <?php echo $this->session->flashdata('msg'); ?> 

                    </div>

                       <?php } ?>

                    </p>
                </div>
            </div>
        </div>
    </div>
    
</div>
<link href="<?php echo BASEURL.'plugins/select2/css/select2.min.css'?>" rel="stylesheet" />
<script src="<?php echo BASEURL.'plugins/select2/js/select2.min.js'?>"></script>

<script type="text/javascript">
  function add(){
    var html='';
    html='<tr>';
    html+='<td>test</td>';
    html+='</tr>';
    $('#item_table').append(html);
  }
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
    const url='<?php echo $url?>';
    window.location.replace(url);
  }
$(document).ready(function(){

$(document).on('click', '.add', function(){
    const row='<?php echo $row?>';
    var html = '';
    html += '<tr>';
    html += '<td><select name="namaPo[]" class="form-control select2 poSelect"></select></td>';
    html += '<td><input type="text" class="form-control" name="warnaAtas[]" required></td>';
    html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button></td></tr>';
    $('#item_table').append(html);
    $.post( "<?php echo BASEURL.'Produksi/autocompletePO' ?>", { } ).done(function( data ) {
       $('.poSelect').html(data);
    });;
 });

$('.select2').select2();

$(document).on('click', '.remove', function(){
    $(this).closest('tr').remove();
});


  $(document).on('change', '#cmtKat', function(){

    var jobCmt = $(this).children("option:selected").val();
    $('#item_table').empty();
    $('#sj').empty();
    $.post( "<?php echo BASEURL.'kelolapo/searchCmt' ?>", { jobCmt: jobCmt } ).done(function( html ) {

        $('#cmtName').html(html);
        // $('.selectpicker').selectpicker('refresh');
    
  });;
});

$(document).on('change', '#cmtName', function(){

    var jobCmt = $(this).children("option:selected").val();
    var idcmt =jobCmt.split("-");
    $('#item_table').empty();
    $.post( "<?php echo BASEURL.'kelolapo/searchCmtJob' ?>",{jobCmt: jobCmt }).done(function( html ) {
            $('#cmtJob').html(html);
    });

    $.post( "<?php echo BASEURL.'Produksi/searchSJcmt' ?>",{idcmt: idcmt[0] }).done(function( data ) {
            $('#sj').html(data);
    });
});

$(document).on('change', '#sj', function(){
    $('#item_table').empty();
    var sj = $(this).children("option:selected").val();
    $.post( "<?php echo BASEURL.'Produksi/searchSJ' ?>",{sj: sj }).done(function( html ) {
      console.log(html);
            $('#item_table').append(html);
    });
});



});
</script>