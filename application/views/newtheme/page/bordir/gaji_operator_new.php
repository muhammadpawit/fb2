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

    /* Accordion & Search Styling */
    .panel-group .panel {
        border-radius: 6px;
        margin-bottom: 12px;
        border: 1px solid #d2d6de;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        overflow: hidden;
    }
    .panel-default > .panel-heading {
        background: #fff;
        padding: 0;
        border: none;
    }
    .accordion-header-link {
        display: flex;
        align-items: center;
        padding: 15px 20px;
        text-decoration: none !important;
        color: #333;
        transition: background 0.2s;
        cursor: pointer;
    }
    .accordion-header-link:hover { background: #f9f9f9; }
    .header-info { display: flex; align-items: center; flex-grow: 1; }
    .header-right { display: flex; align-items: center; gap: 15px; }
    .employee-title { font-size: 15px; font-weight: 700; margin: 0; }
    .total-preview {
        font-weight: 700;
        color: #3c8dbc;
        font-size: 14px;
        background: #eef5f9;
        padding: 4px 10px;
        border-radius: 4px;
    }
    .employee-active-check {
        width: 22px;
        height: 22px;
        margin-right: 15px !important;
        cursor: pointer;
    }
    .fa-chevron-down { transition: transform 0.3s; font-size: 12px; color: #777; }
    .accordion-header-link.collapsed .fa-chevron-down { transform: rotate(-90deg); }
    .search-container { position: relative; margin-bottom: 20px; }
    .search-input {
        padding-left: 35px !important;
        border-radius: 20px !important;
        border: 2px solid #d2d6de !important;
        height: 40px !important;
    }
    .search-icon { position: absolute; left: 15px; top: 12px; color: #aaa; z-index: 5; }
    .salary-card.unchecked { opacity: 0.6; filter: grayscale(0.5); }
    .salary-card.unchecked .total-preview { background: #eee; color: #999; }
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
            <?php if(isset($_GET['kalkulasi']) || isset($is_edit)){?>
            <button type="button" class="btn btn-success btn-sm" onclick="proses()">Simpan</button>
            <?php } ?>
            <a href="<?php echo $batal?>" class="btn btn-danger btn-sm">Batal</a>
        </div>
    </div>
</div>

<?php if(isset($_GET['kalkulasi'])){?>
<div class="row mb-3" style="margin-bottom: 15px;">
    <div class="col-md-8">
        <div class="search-container">
            <i class="fa fa-search search-icon"></i>
            <input type="text" id="employeeSearch" class="form-control search-input" placeholder="Cari nama operator bordir...">
        </div>
    </div>
    <div class="col-md-4 text-right">
        <button type="button" class="btn btn-sm btn-default" onclick="toggleAll(true)"><i class="fa fa-check-square"></i> PILIH SEMUA</button>
        <button type="button" class="btn btn-sm btn-default" onclick="toggleAll(false)"><i class="fa fa-square-o"></i> BATAL SEMUA</button>
    </div>
</div>
<?php } ?>

<div class="row">
    <div class="col-md-12">
        <div class="panel-group" id="accordionGajiBordir" role="tablist" aria-multiselectable="true">
            <?php $i=0;?>
            <?php foreach($prods as $p){?>
            <div class="panel panel-default salary-card" id="box-<?php echo $i?>">
                <div class="panel-heading" role="tab" id="heading-<?php echo $i?>">
                    <div class="accordion-header-link collapsed">
                        <input type="checkbox" class="custom-checkbox-premium employee-active-check" name="products[<?php echo $i?>][idkaryawan]" value="<?php echo strtolower($p['id'])?>" checked onclick="event.stopPropagation();">
                        
                        <div class="header-info" role="button" data-toggle="collapse" data-parent="#accordionGajiBordir" href="#collapse-<?php echo $i?>" aria-expanded="false">
                            <h3 class="employee-title">
                                <i class="fa fa-user-circle mr-2"></i> <?php echo strtoupper($p['nama'])?> 
                            </h3>
                        </div>

                        <div class="header-right">
                            <span class="total-preview" id="preview-total-<?php echo $i?>">Rp 0</span>
                            <i class="fa fa-chevron-down" data-toggle="collapse" data-parent="#accordionGajiBordir" href="#collapse-<?php echo $i?>"></i>
                        </div>
                        
                        <input type="hidden" class="nama-input" name="products[<?php echo $i?>][nama_karyawan_bordir]" value="<?php echo strtolower($p['nama'])?>">
                        <input type="hidden" class="idkaryawan-input" value="<?php echo strtolower($p['id'])?>">
                    </div>
                </div>

                <div id="collapse-<?php echo $i?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-<?php echo $i?>">
                    <div class="panel-body">
                        <div class="row" style="margin-bottom: 15px;">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label style="font-size: 11px;">SHIFT UTAMA:</label>
                                    <select name="products[<?php echo $i?>][shift]" class="form-control input-sm shift-main-select" required>
                                        <option value="">Pilih Shift</option>
                                        <option value="1" <?php echo isset($p['shift']) && $p['shift']==1 ? 'selected' : '' ?>>PAGI</option>
                                        <option value="2" <?php echo isset($p['shift']) && $p['shift']==2 ? 'selected' : '' ?>>MALAM</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label style="font-size: 11px;">METODE PEMBAYARAN:</label>
                                    <select name="products[<?php echo $i?>][metode_pembayaran]" class="form-control input-sm metode-pembayaran-select" required>
                                        <option value="transfer" <?php echo isset($p['metode_pembayaran']) && $p['metode_pembayaran']=='transfer' ? 'selected' : '' ?>>Transfer</option>
                                        <option value="cash" <?php echo isset($p['metode_pembayaran']) && $p['metode_pembayaran']=='cash' ? 'selected' : '' ?>>Cash</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label style="font-size: 11px;">BIAYA ADMIN TRANSFER:</label>
                                    <input type="number" name="products[<?php echo $i?>][biaya_admin_transfer]" value="<?php echo isset($p['biaya_admin_transfer']) ? round($p['biaya_admin_transfer']) : 0 ?>" class="form-control input-sm admin-transfer-input" data-idx="<?php echo $i?>" placeholder="0">
                                </div>
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
                                <span class="summary-label">Admin Transfer</span>
                                <span class="summary-value text-red" id="total-admin-transfer-<?php echo $i?>"><?php echo number_format(isset($p['biaya_admin_transfer']) ? $p['biaya_admin_transfer'] : 0)?></span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-label">Bersih</span>
                                <span class="summary-value grand-total" id="grand-total-<?php echo $i?>"><?php echo number_format($total_gaji_awal - $total_potongan_awal - (isset($p['biaya_admin_transfer']) ? $p['biaya_admin_transfer'] : 0))?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php $i++?>
            <?php } ?>
        </div>
    </div>
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
        $('.salary-card:not(.unchecked)').find('.shift-main-select').each(function() {
            if ($(this).val() === "" || $(this).val() === null) {
                allShiftSelected = false;
                $(this).css('border-color', 'red');
                $(this).closest('.panel-collapse').collapse('show');
                $(this).focus();
                return false; 
            } else {
				$(this).css('border-color', '');
			}
        });

        if (!allShiftSelected) {
            alert("Harap pilih Shift untuk semua operator yang dicentang!");
            return false;
        }

        // BUNDLE DATA TO JSON
        var form = $('#payroll-form');
        var formData = {
            tanggal1: tanggal1,
            tanggal2: tanggal2,
            tempat: $('select[name="tempat"]').val(),
            products: []
        };

        $('.salary-card:not(.unchecked)').each(function() {
            var card = $(this);
            var product = {
                idkaryawan: card.find('.employee-active-check').val(),
                nama_karyawan_bordir: card.find('.nama-input').val(),
                shift: card.find('.shift-main-select').val(),
                metode_pembayaran: card.find('.metode-pembayaran-select').val(),
                biaya_admin_transfer: card.find('.admin-transfer-input').val(),
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

        if(formData.products.length == 0){
            alert("Harap pilih minimal satu karyawan untuk disimpan!");
            return false;
        }

        $('<input>').attr({
            type: 'hidden',
            name: 'payroll_json',
            value: JSON.stringify(formData)
        }).appendTo(form);

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

    function toggleAll(status) {
        $('.employee-active-check').prop('checked', status).trigger('change');
    }

    function updateAllPreviews() {
        $('.salary-card').each(function() {
            var idx = $(this).attr('id').split('-')[1];
            var isChecked = $(this).find('.employee-active-check').is(':checked');
            var bersih = isChecked ? $('#grand-total-' + idx).text() : '0';
            $('#preview-total-' + idx).text('Rp ' + bersih);
        });
    }

	$(document).ready(function(){
        $(document).on('input', '.gaji-input, .potongan-input, .admin-transfer-input', function() {
            var idx = $(this).data('idx');
            var total_gaji = 0;
            var total_potongan = 0;
            var admin_transfer = parseFloat($('.admin-transfer-input[data-idx="' + idx + '"]').val()) || 0;

            $('.gaji-input[data-idx="' + idx + '"]').each(function() {
                total_gaji += parseFloat($(this).val()) || 0;
            });

            $('.potongan-input[data-idx="' + idx + '"]').each(function() {
                total_potongan += parseFloat($(this).val()) || 0;
            });

            $('#total-gaji-' + idx).text(total_gaji.toLocaleString());
            $('#total-potongan-' + idx).text(total_potongan.toLocaleString());
            $('#total-admin-transfer-' + idx).text(admin_transfer.toLocaleString());
            $('#grand-total-' + idx).text((total_gaji - total_potongan - admin_transfer).toLocaleString());
            updateAllPreviews();
        });

        $(document).on('change', '.employee-active-check', function() {
            var $box = $(this).closest('.salary-card');
            if ($(this).is(':checked')) {
                $box.removeClass('unchecked');
            } else {
                $box.addClass('unchecked');
            }
            updateAllPreviews();
        });

        $(document).on('keyup', '#employeeSearch', function() {
            var value = $(this).val().toLowerCase();
            $('.salary-card').each(function() {
                var name = $(this).find('.employee-title').text().toLowerCase();
                if (name.indexOf(value) > -1) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        // Initial setup
        updateAllPreviews();
    });
</script>