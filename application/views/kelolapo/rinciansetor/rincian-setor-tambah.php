<link href="<?php echo PLUGINS ?>bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" />

<!-- Start Page content -->
<div class="content">
    <div class="container-fluid">
    	
        <div class="row">
            <div class="col-md-12">

                <div class="card-box">
                    <h4 class="header-title m-t-0 m-b-20">Tambah Pengecekan Potongan</h4>
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

                   	<ul class="nav nav-pills navtab-bg nav-justified pull-in ">
	                    <li class="nav-item">
	                        <a href="#home1" data-toggle="tab" aria-expanded="false" class="nav-link">
	                            <i class="fi-monitor mr-2"></i> Rincian
	                        </a>
	                    </li>
	                    <li class="nav-item">
	                        <a href="#profile1" data-toggle="tab" aria-expanded="true" class="nav-link active">
	                            <i class="fi-head mr-2"></i>Rincian Setor
	                        </a>
	                    </li>
	                   
	                </ul>
	                <div class="tab-content">
	                    <div class="tab-pane" id="home1">
<form action="<?php echo BASEURL.'kelolapo/formpengecekanpotonganOnAct' ?>" method="POST" enctype="multipart/form-data">
	<div class="row">
    <div class="col-12">
        <h3 class="text-center">POTONGAN ATASAN</h3>
        <hr>
    </div>
		<div class="form-group col-sm-12 col-lg-3">
    	<label>Nama PO</label>
        <select class="form-control selectpicker" id="poSelect" name="namaPo" title="Select Nama PO" data-live-search="true" required>
            <option selected="selected" value="<?php echo $poProd['kode_po'] ?>"><?php echo $poProd['nama_po'].$poProd['kode_po'] ?></option>
        </select>
    </div>
    <div class="form-group col-sm-12 col-lg-3">
    	<label>Tanggal</label>
    	<input type="date" class="form-control" name="tanggal" value="<?php echo $poProd['created_date'] ?>" required readonly>
    </div>
    <div class="form-group col-sm-12 col-lg-3">
    	<label>Tim Potong</label>
    	<input type="text" class="form-control timPotong" name="timPotong" value="<?php echo $poProd['tim_potong_potongan'] ?>" required readonly>
    </div>
    
    <div class="form-group col-sm-12 col-lg-3">
    	<label>Jumlah Potong (Dz)</label>
    	<input type="number" step="0.01" class="form-control jumlahPotDz" name="jumlahPotDz" value="<?php echo $poProd['hasil_lusinan_potongan'] ?>" required readonly>
    </div>
    <div class="form-group col-sm-12 col-lg-3">
        <label>Jumlah Potong (Pcs)</label>
        <input type="number" step="0.01" class="form-control jumlahPotPcs" name="jumlahPotPcs" value="<?php echo $poProd['hasil_lusinan_potongan'] * 12 ?>" required readonly>
    </div>
    <div class="form-group col-sm-12 col-lg-3">
    	<label>Jml Warna</label>
    	<input type="number" class="form-control jmlWarna" name="jmlWarna" value="<?php echo $poProd['jumlah_gambar_utama'] ?>" required readonly>
    </div>
    

    
    <div class="table-responsive">
        <table class="table table-bordered" id="item_table">
            <tr>
                <th>BAGIAN</th>
                <th>WARNA</th>
                <th>JML</th>
                <th>KETERANGAN</th>
                
            </tr>
            <?php foreach ($atas as $key => $at): ?>
            <tr>
			    <td><input type="text" class="form-control" name="bagianAtas[]" value="<?php echo $at['bagian_potongan_atas'] ?>" required readonly></td>
			    <td><input type="text" class="form-control" name="warnaAtas[]" value="<?php echo $at['warna_potongan_atas'] ?>" required readonly></td>
			    <td><input type="number" class="form-control" name="jmlAtas[]"  value="<?php echo $at['jumlah_potongan'] - $at['qty_bangke_atas'] - $at['qty_reject_atas'] - $at['qty_hilang_atas'] - $at['qty_claim_atas'] ?>" required readonly></td>
			    <td><input type="text" class="form-control" name="keteranganAts[]"  value="<?php echo $at['keterangan_potongan'] ?>" readonly></td>
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
        <table class="table table-bordered" id="item_tabl2e">
            <tr>
                <th>BAGIAN</th>
                <th>WARNA</th>
                <th>JML</th>
                <th>KETERANGAN</th>
            </tr>
            <?php foreach ($bawah as $key => $bw): ?>
            	<tr>
				    <td><input type="text" class="form-control" name="bagianBwh[]" value="<?php echo $bw['bagian_potongan_bawah'] ?>" required readonly></td>
				    <td><input type="text" class="form-control" name="warnaBwh[]" value="<?php echo $bw['warna_potongan_bawah'] ?>" required readonly></td>
				    <td><input type="number" class="form-control" name="jmlBwh[]" value="<?php echo ($bw['jumlah_potongan'] - $bw['qty_bangke_bwh'] - $bw['qty_reject_bwh'] - $bw['qty_hilang_bwh'] - $bw['qty_claim_bwh']) ?>" required readonly ></td>
				    <td><input type="text" class="form-control" name="keteranganBwh[]"  value="<?php echo $bw['keterangan_potongan'] ?>" readonly></td>
				</tr>
            <?php endforeach ?>
          
        </table>
    </div>
</div>

</form>
	                    </div>

	                    <!-- RINCIAN INPUT SETOR CMT -->
	                    <div class="tab-pane show active" id="profile1">
	                        <form action="<?php echo BASEURL.'finishing/produksikaoscmtAct' ?>" method="post">
<div class="row">
    <div class="col-sm-12">
        <hr>
        <h3 class="text-center">SETOR CMT KAOS</h3>
        <hr>
    </div>
    <div class="form-group col-3">
    		<label>Nama Po</label>
    		<input type="text" class="form-control" name="nama_po" value="<?php echo $poProd['nama_po'] ?>" readonly>
    	</div>
    	<div class="form-group col-3">
    		<label>Kode Po</label>
    		<input type="text" class="form-control" name="kode_po" value="<?php echo $poProd['kode_po'] ?>" readonly>
    	</div>
    	<div class="form-group col-6">
    		<label>DZ(Lusin) Potongan</label>
    		<input type="text" class="form-control" name="hasilPotongan" value="<?php echo round($poProd['hasil_lusinan_potongan']) ?>" readonly>
    	</div>
    	<div class="form-group col-3">
    		<label>Jumlah Potongan</label>
    		<input type="text" class="form-control" name="pieceSetor" value="<?php echo round($poProd['hasil_lusinan_potongan'] * 12) ?>" readonly>
    	</div>
    	<div class="form-group col-3">
    		<label>Nama CMT</label>
    		<input type="text" class="form-control" name="nama_cmt" value="<?php echo $poProd['nama_cmt'] ?>" readonly>
    	</div>
    	<div class="form-group col-6">
    		<label>Jumlah Potongan(Yang Di Terima)</label>
    		<input type="text" class="form-control" name="jumlahditerima" required >
    	</div>
        <div class="form-group col-sm-12 col-lg-3">
        <label>Progress</label>
        <select class="form-control selectpicker" id="poSelect" name="progresName" title="Select Progress" data-live-search="true" required>
            <?php foreach ($progress as $key => $pro): ?>
            <option selected="selected" value="<?php echo $pro['id_proggresion_po'] ?>"><?php echo $pro['nama_progress'] ?></option>
            <?php endforeach ?>
        </select>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered" id="item_table3">
            <tr>
                <th>SIZE</th>
                <th>DZ(Lusin)</th>
                <th>PIECES</th>
                <th>BANGKE</th>
                <th>REJECT</th>
                <th>HILANG</th>
                <th>CLAIM</th>
                <th>KETERANGAN</th>
                <th><button type="button" name="add" class="btn btn-success btn-sm add3"><i class="fa fa-plus"></i></button></th>
            </tr>
            <?php if (!empty($setorcmtjahititem)): ?>
                <?php // pre($setorcmtjahititem) ?>
                <?php foreach ($setorcmtjahititem as $key => $jahitItem): ?>
            	<tr>
				    <td><input type="text" class="form-control" name="rinciansize[]" value="<?php echo $jahitItem['rincian_size'] ?>" required ></td>
				    <td><input type="text" class="form-control" name="rincianlusin[]" value="<?php echo $jahitItem['rincian_lusin'] ?>" required ></td>
				    <td><input type="number" class="form-control" name="rincianpiece[]" value="<?php echo $jahitItem['rincian_piece'] ?>" required  ></td>
				    <td><input type="number" name="banke[]" class="form-control" value="<?php echo $jahitItem['rincian_bangke'] ?>" required></td>
				    <td><input type="number" class="form-control" name="barangCacad[]" value="<?php echo $jahitItem['rincian_reject'] ?>" required></td>
				    <td><input type="number" class="form-control" name="hilangBarang[]" value="<?php echo $jahitItem['rincian_hilang'] ?>" required></td>
                    <td><input type="number" class="form-control" name="claimBarang[]" value="<?php echo $jahitItem['rincian_claim'] ?>" required></td>
                    <td><input type="text" class="form-control" name="keterangan[]" value="<?php echo $jahitItem['rincian_keterangan'] ?>" ></td>
				    <td></td>
				</tr>
                <?php endforeach ?>
            <?php endif ?>
        </table>
    </div>
    <?php if (empty($setorcmtjahititem)){ ?>
    <button class="btn btn-info" type="submit">submit</button>
    <?php } ?>
</div>
	                        </form>
	                    </div>
	                    
	                </div> 


                   

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
    html += '<td><input type="text" class="form-control" name="bagianAtas[]" required readonly></td>';
    html += '<td><input type="text" class="form-control" name="warnaAtas[]" required readonly></td>';
    html += '<td><input type="number" class="form-control" name="jmlAtas[]"  ></td>';
    html += '<td><input type="text" class="form-control" name="keteranganAts[]"  readonly></td>';
    html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button></td></tr>';
    $('#item_table').append(html);
 });

$(document).on('click', '.add3', function(){
    var html = '';
    html += '<tr>';
    html += '<td>';
    html += '<select class="form-control selectpicker" name="rinciansize[]" data-live-search="true" data-size="3" required>';
    <?php foreach ($size as $key => $value): ?>
    html += '<option value="<?php echo $value['nama_size'] ?>"><?php echo $value['nama_size'] ?></option>';
    <?php endforeach ?>
    html += '</select>';
    html += '</td>';
    html += '<td><input type="number" class="form-control" name="rincianlusin[]" required ></td>';
    html += '<td><input type="number" class="form-control" name="rincianpiece[]"  ></td>';
    html += '<td><input type="number" name="banke[]" class="form-control" ></td>';
    html += '<td><input type="number" class="form-control" name="barangCacad[]"></td>';
    html += '<td><input type="number" class="form-control" name="hilangBarang[]" required></td>';
    html += '<td><input type="number" class="form-control" name="claimBarang[]" required></td>';
    html += '<td><input type="text" class="form-control" name="keterangan[]"  ></td>';
    html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button></td></tr>';
    $('#item_table3').append(html);
    $('.selectpicker').selectpicker('refresh');
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

$(document).on('click', '.remove', function(){
    $(this).closest('tr').remove();
});
    
});
 </script>