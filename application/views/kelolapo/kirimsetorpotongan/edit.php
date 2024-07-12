<!-- Start Page content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card-box">
                    <form action="<?php echo $action ?>" method="POST" enctype="multipart/form-data">
                    	<input type="hidden" name="kode_po" value="<?php echo $poProd['idpo']?>">
                    <div class="row">
                        <div class="col-12">
                            <table class="table table-bordered">
                            	<tr>
                            		<td><strong>Proses</strong></td>
                            		<td><?php echo strtolower($poProd['progress']).' '.strtolower($poProd['kategori_cmt'])?></td>
                            	</tr>
                                <tr>
                                    <td><strong>Nama CMT</strong></td>
                                    <td>
                                        <select name="cmt" class="form-control select2bs4" data-live-search="true" required>
                                            <option value="">Pilih</option>
                                            <?php foreach($listcmt as $c){?>
                                                <option value="<?php echo $c['id_cmt']?>" <?php echo $cmt['id_cmt']==$c['id_cmt']?'selected':''; ?>><?php echo strtolower($c['cmt_name'])?></option>
                                            <?php } ?>
                                        </select>                                            
                                        </td>
                                </tr>
                                <tr>
                                    <td><strong>Pekerjaan</strong></td>
                                    <td>
                                        <select name="job" class="form-control select2bs4" data-live-search="true">
                                            <option value="">Pilih</option>
                                            <?php foreach($listjob as $c){?>
                                                <option value="<?php echo $c['id']?>" <?php echo $poProd['id_master_cmt_job']==$c['id']?'selected':''; ?>><?php echo strtolower($c['nama_job'])?></option>
                                            <?php } ?>
                                        </select>        
                                        <?php //echo $masterCmt['cmt_job_jenis'] ?></td>
                                </tr>
                                <tr>
                                	<td><strong>Tanggal</strong></td>
                                	<td><input type="text" name="create_date" value="<?php echo $poProd['create_date']?>" class="form-control datepicker"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <hr>
                   	<div class="row">
                        <div class="col-12">
                            <h3 class="text-center">POTONGAN ATASAN</h3>
                            <hr>
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
								    <td><input type="number" class="form-control" name="jmlAtas[]" readonly value="<?php echo $at['jumlah_potongan'] ?>" required></td>
                                    <td><input type="number" class="form-control" name="qtyBankeAtas[]" readonly value="<?php echo $at['qty_bangke_atas'] ?>" required></td>
                                    <td><input type="number" class="form-control" name="qtyRejectAtas[]" readonly value="<?php echo $at['qty_reject_atas'] ?>" required></td>
                                    <td><input type="number" class="form-control" name="qtyHilangAtas[]" readonly value="<?php echo $at['qty_hilang_atas'] ?>" required></td>
                                    <td><input type="number" class="form-control" name="qtyClaimAtas[]" readonly value="<?php echo $at['qty_claim_atas'] ?>" required></td>
								    <td><input type="text" class="form-control" name="keteranganAts[]" readonly value="<?php echo $at['keterangan_potongan'] ?>"></td>
								    <td><!--<button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button>--></td>
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
