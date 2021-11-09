<link href="<?php echo PLUGINS ?>bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" />
<!-- Start Page content -->
<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">

                <div class="card-box">
                    <h4 class="header-title m-t-0 m-b-20">Kirim Setor Ke CMT</h4>
                    <div class="alert alert-dark alert-dismissible bg-dark text-white border-0 fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        Kalau ga ada value nya isi kolom nya dengan strip, Terima Kasih!
                    </div>
                    <?php if ($this->session->flashdata('msg')): ?>
                    <div class="alert alert-dark alert-dismissible bg-danger text-white border-0 fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <strong><?php echo $this->session->flashdata('msg'); ?></strong>                    
                    </div>
                    <?php endif ?>
                    <hr>
                   <form action="<?php echo BASEURL.'kelolapo/kirimsetorPoMassalAct' ?>" method="POST" enctype="multipart/form-data">
                   	<div class="row">
                        <div class="col-4">
                            <label>KODE NOTA</label>
                            <input type="text" name="kodenota" class="form-control" value="<?php echo generateReferenceNumber() ?>" required readonly >
                        </div>
                        <div class="col-4">
                        	<label>PROGRESS</label>
                            <select class="form-control selectpicker" id="progress" name="progress" title="Select Progress" data-live-search="true" required>
                            <?php foreach ($progress as $key => $prog): ?>
                                    <option value="<?php echo $prog['nama_progress'] ?>" ><?php echo $prog['nama_progress'] ?></option>
                            <?php endforeach ?>
                            </select>
                        </div>
                        <div class="col-4">
                        	<label>CMT</label>
                            <select class="form-control selectpicker" id="cmtKat" name="cmtKat" title="Select CMT" required data-live-search="true" >
                                <option value="SABLON">SABLON</option>
                                <option value="JAHIT">JAHIT</option>
                                <option value="BORDIR">BORDIR</option>
                            </select>
                        </div>
                        <div class="col-4">
                            <label>CMT NAME</label>
                            <select class="form-control selectpicker cmtName" id="cmtName" name="cmtName" title="Select CMT name" data-live-search="true" required></select>
                        </div>
 
                        <div class="form-group col-sm-12 col-lg-3">
                        	<label>Tanggal</label>
                        	<input type="date" class="form-control" name="tanggal" required>
                        </div>
                      
                        <div class="table-responsive">
                            <table class="table table-bordered" id="item_table">
                                <tr>
                                    <th>NAMA PO</th>
                                    <th>RINCIAN ATAS PO</th>
                                    <th>RINCIAN BWH PO</th>
                                    <th>JML PO</th>
                                    <th>JML BARANG</th>
                                    <th>CMTKAT</th>
                                    <th>CMTNAME</th>
                                    <th>CMTJOB</th>
                                    <th><button type="button" name="add" class="btn btn-success btn-sm add"><i class="fa fa-plus"></i></button></th>
                                </tr>
                                
                            </table>
                        </div>
                        
                   	</div>

                        <button type="submit" class="btn btn-primary">SUBMIT</button>

                   </form>

                </div>

            </div>

        </div>
        <!-- end row -->

    </div> <!-- container -->

</div> <!-- content -->
<script src="<?php echo PLUGINS ?>bootstrap-select/js/bootstrap-select.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
$(document).on('click', '.add', function(){
    var html = '';
    html += '<tr>';
    html += '<td><select class="form-control selectpicker poSelect" name="kode_po[]" data-size="3" required title="Select Nama PO" data-live-search="true"><?php foreach ($poProd as $key => $prod): ?><option selected="selected" data-idkode="<?php echo $prod['kode_po'] ?>" value="<?php echo $prod['kode_po'] ?>"><?php echo $prod['nama_po'].$prod['kode_po'] ?></option><?php endforeach ?></select></td>';
    html += '<td><input type="text" class="form-control rincianAtas" name="rincianAtas[]" readonly required></td>';
    html += '<td><input type="text" class="form-control rincianBwh" name="rincianBwh[]" readonly required></td>';
    html += '<td><input type="text" class="form-control jmlpo" name="jmlpo[]" required></td>';
    html += '<td><input type="text" class="form-control jmlbarang" name="jmlbarang[]"  required></td>';
    html += '<td><select class="form-control  cmtKat"  name="cmtKatTabl[]" title="Select CMT" required data-live-search="true" ><option value=""></option><option value="SABLON">SABLON</option><option value="JAHIT">JAHIT</option><option value="BORDIR">BORDIR</option></select></td>';
    html += '<td><select class="form-control cmtName" name="cmtNameTab[]" title="Select CMT name" data-live-search="true" required></select></td>';
    html += '<td><select class="form-control  cmtJob" name="cmtJob[]"  title="Select CMT name" data-live-search="true" required></select></td>';

    html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button></td></tr>';
    $('#item_table').append(html);
    $('.selectpicker').selectpicker('refresh');
 });


$('#item_table').on('change', 'select.poSelect', function(){
    var dataid = $(this).children("option:selected").data('idkode');
    // alert(dataid);
    var kelompok = $(this).closest('tr');

    $.post( "<?php echo BASEURL.'kelolapo/searchjumlahpotongan' ?>", { idData: dataid } ).done(function( data ) {
        var obj = JSON.parse(data);
        kelompok.find(".jmlpo").val(obj.totalPcs);
        
      });;
    });
$(document).on('change', 'select.poSelect', function(){

    var dataid = $(this).children("option:selected").val();
    var kelompok = $(this).closest('tr');

    $.post( "<?php echo BASEURL.'kelolapo/searchbagianpotonganAtas' ?>", { idData: dataid } ).done(function( data ) {
        kelompok.find(".rincianAtas").val(data);
        
      });;
    });
$(document).on('change', 'select.poSelect', function(){

    var dataid = $(this).children("option:selected").val();
    var kelompok = $(this).closest('tr');

    $.post( "<?php echo BASEURL.'kelolapo/searchbagianpotonganBwh' ?>", { idData: dataid } ).done(function( data ) {
        kelompok.find(".rincianBwh").val(data);
        
      });;
    });
$('#item_table').on('change', '.cmtKat', function(){

    var jobCmt = $(this).children("option:selected").val();
    var kelompok = $(this).closest('tr');
    // alert(jobCmt);
    $.post( "<?php echo BASEURL.'kelolapo/searchCmt' ?>", { jobCmt: jobCmt } ).done(function( html ) {

        kelompok.find('.cmtName').html(html);
    
  });;
});

$('#item_table').on('change', '.cmtName', function(){

    var jobCmt = $(this).children("option:selected").val();
    var kelompok = $(this).closest('tr');

    $.post( "<?php echo BASEURL.'kelolapo/searchCmtJob' ?>", { jobCmt: jobCmt } ).done(function( html ) {

        kelompok.find('.cmtJob').html(html);
        $('.selectpicker').selectpicker('refresh');
    
  });;
});


$(document).on('change', '#cmtKat', function(){

    var jobCmt = $(this).children("option:selected").val();
    $.post( "<?php echo BASEURL.'kelolapo/searchCmt' ?>", { jobCmt: jobCmt } ).done(function( html ) {

        $('#cmtName').html(html);
        $('.selectpicker').selectpicker('refresh');

  });;
});

$(document).on('change', '#cmtName', function(){

    var jobCmt = $(this).children("option:selected").val();

    $.post( "<?php echo BASEURL.'kelolapo/searchCmtJob' ?>", { jobCmt: jobCmt } ).done(function( html ) {

        $('#cmtJob').html(html);
        $('.selectpicker').selectpicker('refresh');
    
  });;
});

$(document).on('click', '.remove', function(){
    $(this).closest('tr').remove();
});
    
});
 </script>