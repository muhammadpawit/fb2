<style>
    .salary-card {
        border: 1px solid #d2d6de;
        border-radius: 4px;
        margin-bottom: 20px;
        background: #fff;
        box-shadow: 0 1px 1px rgba(0,0,0,0.1);
    }
    .salary-card .card-header {
        background: #3c8dbc;
        color: white;
        padding: 8px 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .salary-card .card-header h4 {
        margin: 0;
        font-size: 16px;
        font-weight: 600;
    }
    .table-salary {
        width: 100%;
        margin-bottom: 0;
    }
    .table-salary thead th {
        background: #f9f9f9;
        border-bottom: 2px solid #eee;
        color: #333;
        font-size: 12px;
        padding: 10px;
        text-transform: uppercase;
    }
    .table-salary tbody td {
        padding: 8px 10px;
        vertical-align: middle;
        border-bottom: 1px solid #f4f4f4;
        font-size: 13px;
    }
    .date-label {
        color: #333;
        font-weight: 700;
        display: block;
    }
    .input-salary {
        height: 30px;
        padding: 2px 8px;
        font-size: 13px;
        border: 1px solid #ccc;
        border-radius: 3px;
        width: 100%;
    }
    .input-salary:focus {
        border-color: #3c8dbc;
        outline: 0;
        box-shadow: none;
    }
    .summary-section {
        padding: 10px 15px;
        background: #fbfbfb;
        border-top: 1px solid #eee;
        display: flex;
        justify-content: flex-end;
        gap: 30px;
    }
    .summary-item {
        text-align: right;
    }
    .summary-label {
        font-size: 11px;
        color: #777;
        display: block;
        text-transform: uppercase;
    }
    .summary-value {
        font-size: 15px;
        font-weight: 700;
        color: #333;
    }
    .grand-total {
        color: #3c8dbc;
        font-size: 18px;
    }
    .filter-box {
        background: #fff;
        border: 1px solid #d2d6de;
        padding: 15px;
        margin-bottom: 20px;
    }
</style>

<div class="row">
  <div class="col-md-12">
    <?php if ($this->session->flashdata('msg')) { ?>
    <div class="alert alert-success alert-dismissible" role="alert">
      	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<?php echo $this->session->flashdata('msg'); ?> 
    </div>
    <?php } ?>
    <?php if ($this->session->flashdata('msgt')) { ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
      	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<?php echo $this->session->flashdata('msgt'); ?> 
    </div>
    <?php } ?>
  </div>
</div>

<form method="post" action="<?php echo $action?>" id="payroll-form">
<div class="filter-box no-print">
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label>Tanggal Awal</label>
                <input type="text" name="tanggal1" id="tanggal1" value="<?php echo $tanggal1?>" class="form-control datepicker">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Tanggal Akhir</label>
                <input type="text" name="tanggal2" id="tanggal2" value="<?php echo $tanggal2?>" class="form-control datepicker">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Tempat</label>
                <select name="tempat" class="form-control select2bs4" required="required">
                    <option value="*">Pilih Lokasi</option>
                    <option value="1" <?php echo $tempat==1?'selected':'';?>>Rumah</option>
                    <option value="2" <?php echo $tempat==2?'selected':'';?>>Cipadu</option>
                </select>
            </div>
        </div>
        <div class="col-md-3" style="padding-top: 25px;">
            <button type="button" class="btn btn-primary btn-sm" onclick="kalkulasi()">Kalkulasi</button>
            <?php if(isset($_GET['kalkulasi'])){?>
            <button type="button" class="btn btn-success btn-sm" onclick="proses()">Simpan</button>
            <?php } ?>
            <a href="<?php echo $batal?>" class="btn btn-danger btn-sm">Batal</a>
        </div>
    </div>
</div>

<div class="row">
	<?php $i=0;?>
	<?php foreach($prods as $p){?>
	<div class="col-md-12">
        <div class="salary-card">
            <div class="card-header">
                <h4><i class="fa fa-user"></i> <?php echo strtoupper($p['nama'])?></h4>
                <div class="form-inline">
                    <small class="mr-2">SHIFT:</small>
                    <select name="products[<?php echo $i?>][shift]" class="form-control input-sm" required style="height: 25px; padding: 0 5px; font-size: 11px;">
                        <option value="">Pilih</option>
                        <option value="1">PAGI</option>
                        <option value="2">MALAM</option>
                    </select>
                </div>
            </div>
            
            <table class="table-salary">
                <thead>
                    <tr>
                        <th width="120">Tanggal</th>
                        <th width="100">Hari</th>
                        <th width="150">Gaji</th>
                        <th width="100">Shift</th>
                        <th width="120">Mandor</th>
                        <th width="150">Potongan</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $har=0; $total_gaji_awal=0; $total_potongan_awal=0; foreach($p['hari'] as $h){?>
                        <tr>
                            <td style="display:none">
                                <input type="hidden" class="idkaryawan-input" name="products[<?php echo $i?>][idkaryawan]" value="<?php echo strtolower($p['id'])?>">
                                <input type="hidden" class="nama-input" name="products[<?php echo $i?>][nama_karyawan_bordir]" value="<?php echo strtolower($p['nama'])?>">
                                <input type="hidden" class="hari-input" name="products[<?php echo $i?>][det][<?php echo $har?>][hari]" value="<?php echo $h['hari']?>">
                                <input type="hidden" class="bonus-input" name="products[<?php echo $i?>][det][<?php echo $har?>][bonus]" value="0">
                                <input type="hidden" class="um-input" name="products[<?php echo $i?>][det][<?php echo $har?>][um]" value="0">
                                <input type="hidden" class="mandor-input" name="products[<?php echo $i?>][det][<?php echo $har?>][mandor]" value="<?php echo $h['mandor'] ?>">
                                <input type="hidden" class="shift-det-input" name="products[<?php echo $i?>][det][<?php echo $har?>][shift]" value="<?php echo $h['shift'] ?>">
                            </td>
                            <td><span class="date-label"><?php echo date('d-m-Y',strtotime($h['tanggal']))?></span></td>
                            <td><?php echo $h['hari'] ?></td>
                            <td>
                                <input type="number" name="products[<?php echo $i?>][det][<?php echo $har?>][gaji]" value="<?php echo round($h['nominal'])?>" class="input-salary gaji-input" data-idx="<?php echo $i?>">
                            </td>
                            <td><span class="label label-info"><?php echo $h['shift'] ?></span></td>
                            <td><?php echo $h['mandor'] ?></td>
                            <td>
                                <input type="number" name="products[<?php echo $i?>][det][<?php echo $har?>][pot]" value="<?php echo round($h['potongan'])?>" class="input-salary potongan-input" data-idx="<?php echo $i?>">
                            </td>
                            <td>
                                <input type="text" name="products[<?php echo $i?>][det][<?php echo $har?>][keterangan]" class="input-salary" value="<?php echo $h['keterangan']?>">
                            </td>
                        </tr>
                    <?php 
                        $total_gaji_awal += round($h['nominal']);
                        $total_potongan_awal += round($h['potongan']);
                        $har++; 
                    ?>
                    <?php } ?>
                </tbody>
            </table>
            
            <div class="summary-section">
                <div class="summary-item">
                    <span class="summary-label">Total Gaji</span>
                    <span class="summary-value" id="total-gaji-<?php echo $i?>"><?php echo number_format($total_gaji_awal)?></span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Potongan</span>
                    <span class="summary-value text-red" id="total-potongan-<?php echo $i?>"><?php echo number_format($total_potongan_awal)?></span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Bersih</span>
                    <span class="summary-value grand-total" id="grand-total-<?php echo $i?>"><?php echo number_format($total_gaji_awal - $total_potongan_awal)?></span>
                </div>
            </div>
        </div>
	</div>
	<?php $i++?>
	<?php } ?>
</div>
</form>

<script type="text/javascript">
	function proses(){
		var tanggal1 =$("#tanggal1").val();
		var tanggal2 =$("#tanggal2").val();
		if(tanggal1===""){
			alert("Tanggal awal harus diisi");
			$("#tanggal1").focus();
			return false;
		}
		if(tanggal2===""){
			alert("Tanggal akhir harus diisi");
			$("#tanggal2").focus();
			return false;
		}
		
		var allShiftSelected = true;
        $('select[name$="[shift]"]').each(function() {
            if ($(this).val() === "" || $(this).val() === null) {
                allShiftSelected = false;
                $(this).css('border-color', 'red');
                $(this).focus();
                return false; 
            } else {
				$(this).css('border-color', '');
			}
        });

        if (!allShiftSelected) {
            alert("Harap pilih Shift untuk semua operator yang tampil!");
            return false;
        }

        // BUNDLE DATA TO JSON TO BYPASS PHP max_input_vars limit (default 1000)
        // Ini memastikan semua data karyawan terkirim meskipun jumlahnya sangat banyak.
        var form = $('#payroll-form');
        var formData = {
            tanggal1: tanggal1,
            tanggal2: tanggal2,
            tempat: $('select[name="tempat"]').val(),
            products: []
        };

        $('.salary-card').each(function(index) {
            var card = $(this);
            var product = {
                idkaryawan: card.find('.idkaryawan-input').val(),
                nama_karyawan_bordir: card.find('.nama-input').val(),
                shift: card.find('select[name*="[shift]"]').val(),
                det: []
            };

            card.find('tbody tr').each(function() {
                var row = $(this);
                product.det.push({
                    hari: row.find('.hari-input').val(),
                    gaji: row.find('.gaji-input').val(),
                    bonus: row.find('.bonus-input').val(),
                    um: row.find('.um-input').val(),
                    pot: row.find('.potongan-input').val(),
                    pinjaman: 0,
                    keterangan: row.find('input[name*="[keterangan]"]').val(),
                    mandor: row.find('.mandor-input').val(),
                    shift: row.find('.shift-det-input').val()
                });
            });

            formData.products.push(product);
        });

        // Masukkan data JSON ke satu input hidden
        $('<input>').attr({
            type: 'hidden',
            name: 'payroll_json',
            value: JSON.stringify(formData)
        }).appendTo(form);

        // Hapus attribute 'name' dari input asli agar tidak dikirim secara individual
        // dan tidak membentur limit max_input_vars server.
        form.find('input, select').not('[name="payroll_json"]').removeAttr('name');

		Swal({
            title: 'Sedang Menyimpan...',
            text: 'Harap tunggu sebentar',
            allowOutsideClick: false,
            onOpen: () => {
                Swal.showLoading()
            }
        });

		form.submit();
	}

	function kalkulasi(){
		var url='?&kalkulasi=1';
		var tanggal1 =$('input[name=\'tanggal1\']').val();
		var tanggal2 =$('input[name=\'tanggal2\']').val();
		var tempat =$('select[name=\'tempat\']').val();
		if(tempat=="*"){
			alert("Tempat harus dipilih. Rumah / Cipadu");
			return false;
		}
		if(tanggal1!=""){
			url+='&tanggal1='+tanggal1;
		}
		if(tanggal2!=""){
			url+='&tanggal2='+tanggal2;
		}
		if(tempat!="*"){
			url+='&tempat='+tempat;
		}

		Swal({
            title: 'Sedang Mengkalkulasi...',
            text: 'Harap tunggu sebentar',
            allowOutsideClick: false,
            onOpen: () => {
                Swal.showLoading()
            }
        });

		location=url;
	}

	$(document).on('input', '.gaji-input, .potongan-input', function() {
		var idx = $(this).data('idx');
		var total_gaji = 0;
		var total_potongan = 0;

		$('.gaji-input[data-idx="' + idx + '"]').each(function() {
			total_gaji += parseFloat($(this).val()) || 0;
		});

		$('.potongan-input[data-idx="' + idx + '"]').each(function() {
			total_potongan += parseFloat($(this).val()) || 0;
		});

		$('#total-gaji-' + idx).text(total_gaji.toLocaleString());
		$('#total-potongan-' + idx).text(total_potongan.toLocaleString());
		$('#grand-total-' + idx).text((total_gaji - total_potongan).toLocaleString());
	});
</script>