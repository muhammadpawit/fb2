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

                    <div class="row">
                        <div class="col-12">
                            <table>
                                <tr>
                                    <td><strong>CMT SEBELUM</strong></td>
                                    <td>: <?php echo $cmt['cmt_name'] ?></td>
                                </tr>
                                <tr>
                                    <td><strong>PEKERJAAN SEBELUM</strong></td>
                                    <td>: <?php echo $masterCmt['cmt_job_jenis'] ?></td>
                                </tr>
                            </table>
                        </div>
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
                   <form action="<?php echo BASEURL.'kelolapo/kirimsetortambahAction' ?>" method="POST" enctype="multipart/form-data">
                   	<div class="row">
                        <div class="col-4">
                        	<label>PROGRESS</label>
                            <select class="form-control select2bs4" id="progress" name="progress" title="Select Progress" data-live-search="true">
                            <?php foreach ($progress as $key => $prog): ?>
                                <?php if ($prog['nama_progress'] == $poProd['progress']){ ?>
                                <?php } else { ?>
                                    <option value="<?php echo $prog['nama_progress'] ?>" ><?php echo $prog['nama_progress'] ?></option>
                                <?php } ?>
                            <?php endforeach ?>
                            </select>
                        </div>
                        <div class="col-4">
                        	<label>CMT</label>
                            <select class="form-control select2bs4" id="cmtKat" name="cmtKat" title="Select CMT" required data-live-search="true">
                                <option value="">Pilih</option>
                                <option value="SABLON">SABLON</option>
                                <option value="JAHIT">JAHIT</option>
                                <option value="BORDIR">BORDIR</option>
                            </select>
                        </div>
                       <div class="col-2">
                            <label>CMT NAME</label>
                            <select class="form-control selectpicker" id="namaCmt" name="cmtName"  title="Select CMT name" data-live-search="true">
                                <option value="">Pilih</option>
                            </select>
                        </div>
                         <div class="col-2">
                            <label>CMT JOB</label>
                            <select class="form-control selectpicker" id="cmtJobs" name="cmtJob"  title="Select CMT name" data-live-search="true">
                                <option value="">Pilih</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <h3 class="text-center">POTONGAN ATASAN</h3>
                            <hr>
                        </div>
                   		<div class="form-group col-sm-12 col-lg-3">
                        	<label>Nama PO</label>
                            <select class="form-control selectpicker" id="poSelect" name="namaPo" required title="Select Nama PO" data-live-search="true">
                                <option selected="selected" value="<?php echo $poProd['kode_po'] ?>"><?php echo $poProd['nama_po'].$poProd['kode_po'] ?></option>
                            </select>
                        </div>
                        <div class="form-group col-sm-12 col-lg-3">
                        	<label>Tanggal</label>
                        	<input type="date" class="form-control" name="tanggal" value="<?php echo $poProd['created_date'] ?>" required>
                        </div>
                        
                        <div class="form-group col-sm-12 col-lg-3">
                            <label>Jumlah Potong (Pcs)</label>
                            <input type="number" step="0.01" class="form-control jumlahPotPcs" name="jumlahPotPcs" value="<?php echo $parent['qty_tot_pcs'] ?>" required>
                        </div>
                        <div class="form-group col-sm-12 col-lg-3">
                        	<label>Jml Warna</label>
                        	<input type="number" class="form-control jmlWarna" name="jmlWarna" readonly value="<?php echo $poProd['jumlah_gambar_utama'] ?>" required>
                        </div>
                        <input type="hidden" name="kodeSetoran" value="<?php echo ((isset($poProd['id_kelolapo_kirim_setor']))? $poProd['id_kelolapo_kirim_setor']:"")?>">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="addkirimsetortambah">
                                <tr>
                                    <th>BAGIAN</th>
                                    <th>WARNA</th>
                                    <th>JML</th>
                                    <th>BANKE</th>
                                    <th>REJECT</th>
                                    <th>HILANG</th>
                                    <th>CLAIM</th>
                                    <th>KETERANGAN</th>
                                    <th><!-- <button type="button" name="addkirimsetortambah" class="btn btn-success btn-sm addkirimsetortambah"><i class="fa fa-plus"></i></button> --></th>
                                </tr>
                                <?php foreach ($atas as $key => $at): ?>

                                <tr>
								    <td><input type="text" class="form-control" name="bagianAtas[]" readonly value="<?php echo $at['bagian_potongan_atas'] ?>" required></td>
								    <td><input type="text" class="form-control" name="warnaAtas[]" readonly value="<?php echo $at['warna_potongan_atas'] ?>" required></td>
								    <td><input type="number" class="form-control" name="jmlAtas[]"  value="<?php echo $at['jumlah_potongan'] ?>" required></td>
                                    <td><input type="number" class="form-control" name="qtyBankeAtas[]"  value="<?php echo $at['qty_bangke_atas'] ?>" required></td>
                                    <td><input type="number" class="form-control" name="qtyRejectAtas[]"  value="<?php echo $at['qty_reject_atas'] ?>" required></td>
                                    <td><input type="number" class="form-control" name="qtyHilangAtas[]"  value="<?php echo $at['qty_hilang_atas'] ?>" required></td>
                                    <td><input type="number" class="form-control" name="qtyClaimAtas[]"  value="<?php echo $at['qty_claim_atas'] ?>" required></td>
								    <td><input type="text" class="form-control" name="keteranganAts[]"  value="<?php echo $at['keterangan_potongan'] ?>"></td>
								    <td><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button></td>
								</tr>
								<?php endforeach ?>
                            </table>
                        </div>
                        
                   	</div>

                    <div class="row">
                        <div class="col-sm-12">
                            <hr>
                            <h3 class="text-center">POTONGAN BAWAHAN</h3>
                            <hr>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-bordered" id="addkirimsetortambah2e">
                                <tr>
                                    <th>BAGIAN</th>
                                    <th>WARNA</th>
                                    <th>JML</th>
                                    <th>BANKE</th>
                                    <th>REJECT</th>
                                    <th>HILANG</th>
                                    <th>CLAIM</th>
                                    <th>KETERANGAN</th>
                                    <th><!-- <button type="button" name="addkirimsetortambah" class="btn btn-success btn-sm addkirimsetortambah2"><i class="fa fa-plus"></i></button> --></th>
                                </tr>
                                <?php foreach ($bawah as $key => $bw): ?>
                                	<tr>
									    <td><input type="text" class="form-control" name="bagianBwh[]" readonly value="<?php echo $bw['bagian_potongan_bawah'] ?>" required></td>
									    <td><input type="text" class="form-control" name="warnaBwh[]" readonly value="<?php echo $bw['warna_potongan_bawah'] ?>" required></td>
									    <td><input type="number" class="form-control" name="jmlBwh[]"  value="<?php echo $bw['jumlah_potongan'] ?>" required ></td>
                                        <td><input type="number" class="form-control" name="qtyBankeBwh[]"  value="<?php echo $bw['qty_bangke_bwh'] ?>" required ></td>
                                        <td><input type="number" class="form-control" name="qtyRejectBwh[]"  value="<?php echo $bw['qty_reject_bwh'] ?>" required></td>
                                        <td><input type="number" class="form-control" name="qtyHilangBwh[]"  value="<?php echo $bw['qty_hilang_bwh'] ?>" required></td>
                                        <td><input type="number" class="form-control" name="qtyClaimBwh[]"  value="<?php echo $bw['qty_claim_bwh'] ?>" required></td>
									    <td><input type="text" class="form-control" name="keteranganBwh[]"  value="<?php echo $bw['keterangan_potongan'] ?>"></td>
									    <td><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button></td>
									</tr>
                                <?php endforeach ?>
                              
                            </table>
                        </div>
                    </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>

                   </form>

                </div>

            </div>

        </div>
        <!-- end row -->

    </div> <!-- container -->

</div> <!-- content -->
 <script type="text/javascript">
$(document).ready(function(){
$(document).on('click', '.addkirimsetortambah', function(){
    var html = '';
    html += '<tr>';
    html += '<td><input type="text" class="form-control" name="bagianAtas[]" required></td>';
    html += '<td><input type="text" class="form-control" name="warnaAtas[]" required></td>';
    html += '<td><input type="number" class="form-control" name="jmlAtas[]"  ></td>';
    html += '<td><input type="text" class="form-control" name="keteranganAts[]"  ></td>';
    html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button></td></tr>';
    $('#addkirimsetortambah').append(html);
 });

$(document).on('click', '.addkirimsetortambah2', function(){
    var html = '';
    html += '<tr>';
    html += '<td><input type="text" class="form-control" name="bagianBwh[]" required></td>';
    html += '<td><input type="text" class="form-control" name="warnaBwh[]" required></td>';
    html += '<td><input type="number" class="form-control" name="jmlBwh[]"  ></td>';
    html += '<td><input type="text" class="form-control" name="keteranganBwh[]"  ></td>';
    html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button></td></tr>';
    $('#addkirimsetortambah2e').append(html);
 });

$(document).on('change', '#poSelect', function(){

    var dataid = $(this).children("option:selected").data('id');

    $.post( "<?php echo BASEURL.'kelolapo/seaechDataId' ?>", { idData: dataid } ).done(function( data ) {

        var obj = JSON.parse(data);
        $('.timPotong').val(obj.tim_potong_potongan);
        $('.jmlWarna').val(obj.jumlah_gambar_utama);
        $('.jumlahPotDz').val(obj.hasil_lusinan_potongan);
        $('.jumlahPotPcs').val(obj.hasil_lusinan_potongan * 12);
    });;
});

$(document).on('change', '#cmtKat', function(){

    var jobCmt = $(this).children("option:selected").val();

    $.post( "<?php echo BASEURL.'kelolapo/searchCmt' ?>", { jobCmt: jobCmt } ).done(function( html ) {

        $('#namaCmt').html(html);
        $('.selectpicker').selectpicker('refresh');
    
  });;
});

$(document).on('change', '#namaCmt', function(){
    var cmtKat=$("#cmtKat").val();
    var jobCmt = $(this).children("option:selected").val();
    
    if(cmtKat=="SABLON"){
        $.post( "<?php echo BASEURL.'kelolapo/searchCmtJobSablon' ?>", { jobCmt: jobCmt,kat:cmtKat } ).done(function( html ) {
            console.log(html);
            $('#cmtJobs').html(html);
            $('.selectpicker').selectpicker('refresh');
        });
    }else if(cmtKat=="JAHIT"){
        $.post( "<?php echo BASEURL.'kelolapo/searchCmtJobJahit' ?>", { jobCmt: jobCmt,kat:cmtKat } ).done(function( html ) {
            $('#cmtJobs').html(html);
            $('.selectpicker').selectpicker('refresh');
        });
    }else{
        $.post( "<?php echo BASEURL.'kelolapo/searchCmtJob' ?>", { jobCmt: jobCmt } ).done(function( html ) {
            $('#cmtJobs').html(html);
            $('.selectpicker').selectpicker('refresh');
        });
    }
});
$(document).on('click', '.remove', function(){
    $(this).closest('tr').remove();
});
    
});
 </script>
