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
</style>

<div class="payroll-wrapper">
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
                <a href="<?php echo BASEURL ?>Finishing/gajifinishing" class="btn btn-modern btn-default">
                    <i class="fa fa-arrow-left mr-1"></i> KEMBALI
                </a>
                <button type="button" class="btn btn-modern btn-modern-success" onclick="proses()">
                    <i class="fa fa-save mr-1"></i> UPDATE DATA
                </button>
            </div>
        </div>
    </div>

    <form method="post" action="<?php echo $action?>" id="formGaji">
        <input type="hidden" name="id" value="<?php echo $id?>">
        <input type="hidden" name="tanggal1" value="<?php echo $tanggal1?>" style="display:none">
        <input type="hidden" name="tanggal2" value="<?php echo $tanggal2?>" style="display:none">
        <div class="row">
            <?php $i=0?>
            <?php foreach($harian as $h){?>
            <div class="col-md-6">
                <div class="employee-box">
                    <div class="employee-box-header">
                        <input type="hidden" name="products[<?php echo $i?>][iddetail]" value="<?php echo $h['iddetail']?>">
                        <input type="checkbox" class="custom-checkbox-premium mr-2 employee-active-check" name="products[<?php echo $i?>][idkaryawan]" value="<?php echo strtolower($h['id'])?>" checked>
                        <h3 class="employee-title">
                            <?php echo strtoupper($h['nama'])?> 
                            <span class="badge-dept"><?php echo strtoupper($h['bagian'])?></span>
                        </h3>
                        <input type="hidden" name="products[<?php echo $i?>][nama]" value="<?php echo strtolower($h['nama'])?>">
                        <input type="hidden" class="base-salary-hidden" value="<?php echo $h['gaji']; ?>">
                    </div>
                    <div class="employee-box-body">
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
                                    <td class="col-check"><input type="checkbox" class="custom-checkbox-premium day-check calc-trigger" name="products[<?php echo $i?>][<?php echo $day?>]" value="<?php echo $labels[$idx]?>" <?php echo $h[$day]>0?'checked':''?>></td>
                                    <td class="col-label"><?php echo $labels[$idx]?></td>
                                    <td class="col-salary"><?php echo number_format($h['gaji'])?></td>
                                    <td class="col-input">
                                        <input type="number" name="products[<?php echo $i?>][<?php echo $day?>jamkerja]" value="<?php echo $h[$day]?>" class="modern-input hour-input calc-trigger">
                                    </td>
                                </tr>
                                <?php } ?>
                                <tr class="day-row sunday">
                                    <td class="col-check"><input type="checkbox" class="custom-checkbox-premium day-check calc-trigger" name="products[<?php echo $i?>][minggu]" value="Minggu" <?php echo $h['minggu']>0?'checked':''?>></td>
                                    <td class="col-label">Minggu</td>
                                    <td class="col-salary"><?php echo number_format($h['gaji'])?></td>
                                    <td class="col-input">
                                        <input type="number" name="products[<?php echo $i?>][minggujamkerja]" value="<?php echo $h['minggu']?>" class="modern-input hour-input calc-trigger">
                                    </td>
                                </tr>
                                <tr class="row-highlight">
                                    <td class="col-check"><input type="checkbox" name="products[<?php echo $i?>][lembur]" value="lembur" <?php echo $h['lembur']>0?'checked':''?> class="lembur-check calc-trigger"></td>
                                    <td class="col-label">Lembur (Total)</td>
                                    <td colspan="2">
                                        <input type="number" name="products[<?php echo $i?>][lemburs]" value="<?php echo $h['lembur'];?>" class="modern-input row-success lembur-input calc-trigger">
                                    </td>
                                </tr>
                                <tr class="row-highlight">
                                    <td class="col-check"><input type="checkbox" name="products[<?php echo $i?>][insentif]" value="insentif" <?php echo $h['insentif']==1?'checked':''?> class="insentif-check calc-trigger"></td>
                                    <td class="col-label">Insentif</td>
                                    <td class="col-salary"><?php echo number_format($h['gaji'])?></td>
                                    <td class="text-center"><small class="text-muted">6 Hari Kerja</small></td>
                                </tr>
                                <tr>
                                    <td class="col-check"></td>
                                    <td class="col-label row-danger">Pot. Claim</td>
                                    <td colspan="2"><input type="number" name="products[<?php echo $i?>][claim]" value="<?php echo $h['claim']?>" class="modern-input row-danger claim-input calc-trigger"></td>
                                </tr>
                                <tr>
                                    <td class="col-check"></td>
                                    <td class="col-label row-danger">Pinjaman</td>
                                    <td colspan="2"><input type="number" name="products[<?php echo $i?>][pinjaman]" value="<?php echo $h['pinjaman']?>" class="modern-input row-danger loan-input calc-trigger"></td>
                                </tr>
                                <tr>
                                    <td class="col-check"></td>
                                    <td class="col-label row-danger">Kasbon</td>
                                    <td colspan="2"><input type="number" name="products[<?php echo $i?>][jumlah_kasbon]" value="<?php echo $h['kasbon']?>" class="modern-input row-danger kasbon-input calc-trigger"></td>
                                </tr>
                                <tr>
                                    <td class="col-check"></td>
                                    <td class="col-label row-danger">Warteg</td>
                                    <td colspan="2"><input type="number" name="products[<?php echo $i?>][warteg]" value="<?php echo $h['warteg']?>" class="modern-input row-danger warteg-input calc-trigger"></td>
                                </tr>
                                <tr class="row-highlight">
                                    <td class="col-check"></td>
                                    <td class="col-label">Saving Minggu Ini</td>
                                    <td colspan="2"><input type="number" name="products[<?php echo $i?>][saving]" value="<?php echo $h['saving']?>" class="modern-input text-info saving-input calc-trigger"></td>
                                </tr>
                                <tr class="row-highlight">
                                    <td class="col-check"></td>
                                    <td class="col-label">Keluarkan Saving</td>
                                    <td colspan="2"><input type="number" name="products[<?php echo $i?>][jumlah_keluar_saving]" value="<?php echo $h['keluarkansaving']?>" class="modern-input row-success release-input calc-trigger"></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr class="row-total-footer">
                                    <td colspan="2">ESTIMASI DITERIMA</td>
                                    <td colspan="2" class="text-right">
                                        <span class="employee-total-label">Rp 0</span>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <?php $i++?>
            <?php } ?>
        </div>
    </form>
</div>

<script type="text/javascript">
	function proses(){
		var tanggal1 =$("#filter_tanggal1").val();
		var tanggal2 =$("#filter_tanggal2").val();
		if(tanggal1===""){ alert("Tanggal awal harus diisi"); return false; }
		if(tanggal2===""){ alert("Tanggal akhir harus diisi"); return false; }
		
        if(confirm('Apakah Anda yakin data gaji sudah benar dan siap diupdate?')){
            $('<input>').attr({type: 'hidden', name: 'tanggal1', value: tanggal1}).appendTo('#formGaji');
            $('<input>').attr({type: 'hidden', name: 'tanggal2', value: tanggal2}).appendTo('#formGaji');
		    $("#formGaji").submit();
        }
	}

    function calculateAll() {
        $('.employee-box').each(function() {
            var $box = $(this);
            var baseSalary = parseFloat($box.find('.base-salary-hidden').val()) || 0;
            var total = 0;

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

        // Initial calculation
        calculateAll();
    });
</script>
