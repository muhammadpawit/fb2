<link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    /* Modern AdminLTE 2 Facelift */
    .payroll-wrapper {
        font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;
        background: #ecf0f5;
        padding: 15px;
    }
    
    .filter-card {
        background: #fff;
        border-radius: 4px;
        box-shadow: 0 1px 1px rgba(0,0,0,0.1);
        border-top: 3px solid #3c8dbc;
        margin-bottom: 20px;
        padding: 20px;
    }
    
    .employee-box {
        background: #fff;
        border-radius: 4px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        border-top: 3px solid #d2d6de;
        margin-bottom: 25px;
        transition: all 0.3s ease;
    }
    
    .employee-box:hover {
        border-top-color: #3c8dbc;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    
    .employee-box-header {
        padding: 12px 15px;
        border-bottom: 1px solid #f4f4f4;
        display: flex;
        align-items: center;
        background: #fafafa;
    }
    
    .employee-title {
        font-size: 15px;
        font-weight: 700;
        margin: 0;
        color: #333;
        flex-grow: 1;
    }
    
    .payroll-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .payroll-table th {
        background: #f9f9f9;
        font-size: 11px;
        font-weight: 700;
        color: #777;
        text-transform: uppercase;
        padding: 8px 12px;
        border-bottom: 1px solid #eee;
    }
    
    .payroll-table td {
        padding: 10px 12px;
        border-bottom: 1px solid #f4f4f4;
        vertical-align: middle;
        font-size: 13px;
    }
    
    .col-check { width: 40px; text-align: center; }
    .col-label { width: 140px; font-weight: 600; color: #555; }
    .col-salary { text-align: right; color: #3c8dbc; font-weight: 700; }
    .col-input { width: 100px; }
    
    .modern-input {
        width: 100%;
        padding: 6px 10px;
        border: 1px solid #d2d6de;
        border-radius: 3px;
        text-align: right;
        font-weight: 700;
        transition: border-color 0.2s;
    }
    
    .modern-input:focus { border-color: #3c8dbc; outline: none; }
    
    .custom-checkbox-premium { width: 18px; height: 18px; cursor: pointer; }
    
    .btn-modern {
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-radius: 3px;
        padding: 8px 16px;
    }
    
    .btn-modern-info { background: #00c0ef; color: #fff; border: 1px solid #00acd6; }
    .btn-modern-success { background: #00a65a; color: #fff; border: 1px solid #008d4c; }

    .badge-dept {
        font-size: 10px;
        background: #e1ecf4;
        color: #39739d;
        padding: 2px 6px;
        border-radius: 3px;
        margin-left: 5px;
    }
    
    .row-highlight { background: #f0f7ff !important; }
    .row-danger { color: #dd4b39; }
    .row-success { color: #00a65a; }
    
    .row-total-footer {
        background: #3c8dbc;
        color: white;
        font-weight: 800;
    }

    /* Accordion Enhancements */
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
    }

    .accordion-header-link:hover {
        background: #f9f9f9;
    }

    .accordion-header-link.collapsed .fa-chevron-down {
        transform: rotate(-90deg);
    }

    .fa-chevron-down {
        transition: transform 0.3s;
        font-size: 12px;
        color: #777;
    }

    .employee-active-check {
        width: 22px;
        height: 22px;
        margin-right: 15px !important;
        cursor: pointer;
    }

    .panel-body {
        padding: 20px;
        background: #fff;
        border-top: 1px solid #f4f4f4;
    }

    .header-info {
        display: flex;
        align-items: center;
        flex-grow: 1;
    }

    .header-right {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .total-preview {
        font-weight: 700;
        color: #3c8dbc;
        font-size: 14px;
        background: #eef5f9;
        padding: 4px 10px;
        border-radius: 4px;
    }

    .employee-box.unchecked {
        opacity: 0.6;
        filter: grayscale(0.5);
        background: #fdfdfd;
    }

    .employee-box.unchecked .total-preview {
        background: #eee;
        color: #999;
    }

    .search-container {
        position: relative;
        margin-bottom: 20px;
    }

    .search-input {
        padding-left: 35px !important;
        border-radius: 20px !important;
        border: 2px solid #d2d6de !important;
        transition: all 0.3s;
        height: 40px !important;
        box-shadow: none !important;
    }

    .search-input:focus {
        border-color: #3c8dbc !important;
        box-shadow: 0 0 8px rgba(60,141,188,0.2) !important;
    }

    .search-icon {
        position: absolute;
        left: 15px;
        top: 12px;
        color: #aaa;
        z-index: 5;
    }
</style>

<div class="payroll-wrapper">
    <!-- Alert System -->
    <div class="row">
        <div class="col-md-12">
            <?php if ($this->session->flashdata('msg')) { ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <i class="icon fa fa-check"></i> <?php echo $this->session->flashdata('msg'); ?>
            </div>
            <?php } ?>
            <?php if ($this->session->flashdata('msgt')) { ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <i class="icon fa fa-ban"></i> <?php echo $this->session->flashdata('msgt'); ?>
            </div>
            <?php } ?>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-card">
        <div class="row align-items-end">
            <div class="col-md-4">
                <div class="form-group mb-0">
                    <label style="font-size: 11px; font-weight: 800; color: #777;">TANGGAL AWAL</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        <input type="text" id="filter_tanggal1" value="<?php echo $tanggal1?>" class="form-control datepicker" readonly>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group mb-0">
                    <label style="font-size: 11px; font-weight: 800; color: #777;">TANGGAL AKHIR</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        <input type="text" id="filter_tanggal2" value="<?php echo $tanggal2?>" class="form-control datepicker" readonly>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-right">
                <a href="<?php echo BASEURL ?>Gaji/gudang" class="btn btn-modern btn-default">
                    <i class="fa fa-arrow-left mr-1"></i> KEMBALI
                </a>
                <button type="button" class="btn btn-modern btn-modern-info" onclick="filter()">
                    <i class="fa fa-sync-alt mr-1"></i> KALKULASI
                </button>
                <?php if(isset($_GET['tanggal_awal'])){ ?>
                    <button type="button" class="btn btn-modern btn-modern-success" onclick="proses()">
                        <i class="fa fa-save mr-1"></i> PROSES SIMPAN
                    </button>
                <?php } ?>
            </div>
        </div>
    </div>

    <?php if(isset($_GET['tanggal_awal'])){ ?>
    <div class="row mb-3" style="margin-bottom: 15px;">
        <div class="col-md-8">
            <div class="search-container">
                <i class="fa fa-search search-icon"></i>
                <input type="text" id="employeeSearch" class="form-control search-input" placeholder="Cari nama karyawan...">
            </div>
        </div>
        <div class="col-md-4 text-right">
            <button type="button" class="btn btn-sm btn-default" onclick="toggleAll(true)"><i class="fa fa-check-square"></i> PILIH SEMUA</button>
            <button type="button" class="btn btn-sm btn-default" onclick="toggleAll(false)"><i class="fa fa-square-o"></i> BATAL SEMUA</button>
        </div>
    </div>
    <form method="post" action="<?php echo $action?>" id="formGaji">
        <input type="hidden" name="tanggal1" value="<?php echo $tanggal1?>" style="display:none">
        <input type="hidden" name="tanggal2" value="<?php echo $tanggal2?>" style="display:none">
        <div class="row">
            <div class="col-md-12">
                <div class="panel-group" id="accordionGaji" role="tablist" aria-multiselectable="true">
                    <?php $i=0?>
                    <?php foreach($harian as $h){?>
                    <div class="panel panel-default employee-box" id="box-<?php echo $i?>">
                        <div class="panel-heading" role="tab" id="heading-<?php echo $i?>">
                            <div class="accordion-header-link collapsed">
                                <input type="checkbox" class="custom-checkbox-premium employee-active-check" name="products[<?php echo $i?>][idkaryawan]" value="<?php echo strtolower($h['id'])?>" checked onclick="event.stopPropagation();">
                                
                                <div class="header-info" role="button" data-toggle="collapse" data-parent="#accordionGaji" href="#collapse-<?php echo $i?>" aria-expanded="false">
                                    <h3 class="employee-title">
                                        <?php echo strtoupper($h['nama'])?> 
                                        <span class="badge-dept"><?php echo strtoupper($h['bagian'])?></span>
                                    </h3>
                                </div>

                                <div class="header-right">
                                    <span class="total-preview employee-total-label">Rp 0</span>
                                    <i class="fa fa-chevron-down" data-toggle="collapse" data-parent="#accordionGaji" href="#collapse-<?php echo $i?>"></i>
                                </div>
                                
                                <input type="hidden" name="products[<?php echo $i?>][nama]" value="<?php echo strtolower($h['nama'])?>">
                                <input type="hidden" class="base-salary-hidden" value="<?php echo $h['gaji']; ?>">
                            </div>
                        </div>
                        <div id="collapse-<?php echo $i?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-<?php echo $i?>">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="payroll-table">
                                            <thead>
                                                <tr>
                                                    <th class="col-check"><i class="fa fa-check-square"></i></th>
                                                    <th class="col-label">ITEM / HARI</th>
                                                    <th class="text-right">RP / HARI</th>
                                                    <th class="text-center col-input">JAM KERJA</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                $days = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];
                                                $labels = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum\'at', 'Sabtu'];
                                                foreach($days as $idx => $day){
                                                ?>
                                                <tr class="day-row">
                                                    <td class="col-check"><input type="checkbox" class="custom-checkbox-premium day-check calc-trigger" name="products[<?php echo $i?>][<?php echo $day?>]" value="<?php echo $labels[$idx]?>" checked></td>
                                                    <td class="col-label"><?php echo $labels[$idx]?></td>
                                                    <td class="col-salary"><?php echo number_format($h['gaji'])?></td>
                                                    <td class="col-input">
                                                        <input type="number" step="any" name="products[<?php echo $i?>][<?php echo $day?>jamkerja]" value="12" class="modern-input hour-input calc-trigger">
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                                <tr class="day-row sunday">
                                                    <td class="col-check"><input type="checkbox" class="custom-checkbox-premium day-check calc-trigger" name="products[<?php echo $i?>][minggu]" value="Minggu"></td>
                                                    <td class="col-label">Minggu</td>
                                                    <td class="col-salary"><?php echo number_format($h['gaji'])?></td>
                                                    <td class="col-input">
                                                        <input type="number" step="any" name="products[<?php echo $i?>][minggujamkerja]" value="0" class="modern-input hour-input calc-trigger">
                                                    </td>
                                                </tr>
                                                <tr class="row-highlight">
                                                    <td class="col-check"><input type="checkbox" name="products[<?php echo $i?>][lembur]" value="lembur" checked class="lembur-check calc-trigger"></td>
                                                    <td class="col-label">Lembur (Total)</td>
                                                    <td colspan="2">
                                                        <input type="number" name="products[<?php echo $i?>][lemburs]" value="<?php echo !empty($h['lembur'])?$h['lembur']:0;?>" class="modern-input row-success lembur-input calc-trigger">
                                                    </td>
                                                </tr>
                                                <tr class="row-highlight">
                                                    <td class="col-check"><input type="checkbox" name="products[<?php echo $i?>][insentif]" value="insentif" class="insentif-check calc-trigger"></td>
                                                    <td class="col-label">Insentif</td>
                                                    <td class="col-salary"><?php echo number_format($h['gaji'])?></td>
                                                    <td class="text-center"><small class="text-muted">6 Hari Kerja</small></td>
                                                </tr>
                                                <tr>
                                                    <td class="col-check"></td>
                                                    <td class="col-label row-danger">Pot. Claim</td>
                                                    <td colspan="2"><input type="number" name="products[<?php echo $i?>][claim]" value="0" class="modern-input row-danger claim-input calc-trigger"></td>
                                                </tr>
                                                <tr>
                                                    <td class="col-check"></td>
                                                    <td class="col-label row-danger">Pinjaman</td>
                                                    <td colspan="2"><input type="number" name="products[<?php echo $i?>][pinjaman]" value="0" class="modern-input row-danger loan-input calc-trigger"></td>
                                                </tr>
                                                <tr>
                                                    <td class="col-check"></td>
                                                    <td class="col-label row-danger">Kasbon</td>
                                                    <td colspan="2"><input type="number" name="products[<?php echo $i?>][jumlah_kasbon]" value="0" class="modern-input row-danger kasbon-input calc-trigger"></td>
                                                </tr>
                                                <tr>
                                                    <td class="col-check"></td>
                                                    <td class="col-label row-danger">Warteg</td>
                                                    <td colspan="2"><input type="number" name="products[<?php echo $i?>][warteg]" value="0" class="modern-input row-danger warteg-input calc-trigger"></td>
                                                </tr>
                                                <tr class="row-highlight">
                                                    <td class="col-check"></td>
                                                    <td class="col-label">Saving Minggu Ini</td>
                                                    <td colspan="2"><input type="number" name="products[<?php echo $i?>][saving]" value="0" class="modern-input text-info saving-input calc-trigger"></td>
                                                </tr>
                                                <tr class="row-highlight">
                                                    <td class="col-check"></td>
                                                    <td class="col-label">Keluarkan Saving</td>
                                                    <td colspan="2"><input type="number" name="products[<?php echo $i?>][jumlah_keluar_saving]" value="<?php echo isset($h['saving']) ? $h['saving'] : 0; ?>" class="modern-input row-success release-input calc-trigger"></td>
                                                </tr>
                                            </tbody>
                                        </table>
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
    <?php } ?>
</div>

<script type="text/javascript">
	function proses(){
		var tanggal1 =$("#filter_tanggal1").val();
		var tanggal2 =$("#filter_tanggal2").val();
		if(tanggal1===""){ alert("Tanggal awal harus diisi"); return false; }
		if(tanggal2===""){ alert("Tanggal akhir harus diisi"); return false; }
		
        if(confirm('Apakah Anda yakin data gaji sudah benar dan siap disimpan?')){
            $('<input>').attr({type: 'hidden', name: 'tanggal1', value: tanggal1}).appendTo('#formGaji');
            $('<input>').attr({type: 'hidden', name: 'tanggal2', value: tanggal2}).appendTo('#formGaji');
		    $("#formGaji").submit();
        }
	}

	function filter(){
		var tanggal1 =$("#filter_tanggal1").val();
		var tanggal2 =$("#filter_tanggal2").val();
		var url='?';
		if(tanggal1==="" || tanggal2===""){ alert("Tanggal awal & akhir harus diisi"); return false; }
		url +='&tanggal_awal='+tanggal1+'&tanggal_akhir='+tanggal2;
		location = url;
	}

    function calculateAll() {
        $('.employee-box').each(function() {
            var $box = $(this);
            var baseSalary = parseFloat($box.find('.base-salary-hidden').val()) || 0;
            var total = 0;

            // 0. Check if employee is active
            if (!$box.find('.employee-active-check').is(':checked')) {
                $box.find('.employee-total-label').text('Rp 0');
                return;
            }

            // 1. Daily Salaries based on attendance and hours
            $box.find('.day-row').each(function() {
                var $row = $(this);
                if ($row.find('.day-check').is(':checked')) {
                    var hours = parseFloat($row.find('.hour-input').val()) || 0;
                    total += (hours / 12) * baseSalary;
                }
            });

            // 2. Overtime
            if ($box.find('.lembur-check').is(':checked')) {
                total += parseFloat($box.find('.lembur-input').val()) || 0;
            }

            // 3. Incentive
            if ($box.find('.insentif-check').is(':checked')) {
                total += baseSalary;
            }

            // 4. Deductions
            total -= parseFloat($box.find('.claim-input').val()) || 0;
            total -= parseFloat($box.find('.loan-input').val()) || 0;
            total -= parseFloat($box.find('.kasbon-input').val()) || 0;
            total -= parseFloat($box.find('.warteg-input').val()) || 0;
            total -= parseFloat($box.find('.saving-input').val()) || 0;

            // 5. Release Saving
            total += parseFloat($box.find('.release-input').val()) || 0;

            // 6. Rounding (Rp 500 logic)
            var grandTotal = Math.ceil(total / 500) * 500;
            if (grandTotal < 0) grandTotal = 0;

            $box.find('.employee-total-label').text('Rp ' + grandTotal.toLocaleString());
        });
    }

    function toggleAll(status) {
        $('.employee-active-check').prop('checked', status).trigger('change');
    }

    $(document).ready(function(){
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        });

        // Trigger calculation on any input change
        $(document).on('input change', '.calc-trigger', function() {
            calculateAll();
        });

        // Toggle visual state for employee active check
        $(document).on('change', '.employee-active-check', function() {
            var $box = $(this).closest('.employee-box');
            if ($(this).is(':checked')) {
                $box.removeClass('unchecked');
            } else {
                $box.addClass('unchecked');
            }
            calculateAll();
        });

        // Search Functionality
        $(document).on('keyup', '#employeeSearch', function() {
            var value = $(this).val().toLowerCase();
            $('.employee-box').each(function() {
                var name = $(this).find('.employee-title').text().toLowerCase();
                if (name.indexOf(value) > -1) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        // Initial calculation
        calculateAll();
        
        // Initial state for checkboxes
        $('.employee-active-check').each(function() {
            if (!$(this).is(':checked')) {
                $(this).closest('.employee-box').addClass('unchecked');
            }
        });
    });
</script>
