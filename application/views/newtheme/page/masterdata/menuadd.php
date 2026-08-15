<style>
    .form-box {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
        margin-bottom: 24px;
        overflow: hidden;
    }

    .form-box-header {
        padding: 16px 20px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .form-box-title {
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-box-title i {
        color: #3c8dbc;
        font-size: 18px;
    }

    .form-box-body {
        padding: 24px;
    }

    .form-group label {
        font-weight: 600;
        color: #334155;
        font-size: 13px;
        margin-bottom: 6px;
    }

    .form-control {
        border-radius: 8px !important;
        border: 1px solid #cbd5e1 !important;
        padding: 8px 12px !important;
        height: auto !important;
        font-size: 13px !important;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .form-control:focus {
        border-color: #3c8dbc !important;
        box-shadow: 0 0 0 3px rgba(60, 141, 188, 0.15) !important;
    }

    .icon-radio-card {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px 12px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        margin-bottom: 8px;
        background: #f8fafc;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .icon-radio-card:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
    }

    .btn-save-menu {
        background-color: #3c8dbc;
        color: #ffffff !important;
        border-radius: 8px;
        padding: 9px 20px;
        font-size: 13px;
        font-weight: 600;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
    }

    .btn-save-menu:hover {
        background-color: #2b6cb0;
        box-shadow: 0 2px 4px rgba(60, 141, 188, 0.3);
    }

    .btn-cancel-menu {
        background-color: #ef4444;
        color: #ffffff !important;
        border-radius: 8px;
        padding: 9px 20px;
        font-size: 13px;
        font-weight: 600;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none !important;
        transition: all 0.2s ease;
    }

    .btn-cancel-menu:hover {
        background-color: #dc2626;
    }
</style>

<div class="form-box">
    <div class="form-box-header">
        <h3 class="form-box-title">
            <i class="fa fa-plus-circle"></i> Form Tambah Menu Baru
        </h3>
        <a href="<?php echo $kembali ?>" class="btn-cancel-menu">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="form-box-body">
        <form method="post" action="<?php echo $action ?>">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nama Menu Baru <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control" placeholder="Masukkan nama menu" required="required">
                    </div>
                    
                    <div class="form-group">
                        <label>URL Path <span class="text-danger">*</span></label>
                        <input type="text" name="url" class="form-control" placeholder="Contoh: Masterdata/menu" required="required">
                    </div>
                    
                    <div class="form-group">
                        <label>Urutan Tampil</label>
                        <input type="number" name="urutan" class="form-control" value="0">
                    </div>
                    
                    <div class="form-group">
                        <label>Pilihan Icon Menu <span class="text-danger">*</span></label>
                        <div class="icon-radio-card">
                            <input type="radio" name="icon" id="ic1" value="fas fa-tachometer-alt" required>
                            <label for="ic1" style="margin:0; font-weight:normal; cursor:pointer;"><i class="fas fa-tachometer-alt" style="color:#0284c7; width:20px;"></i> <strong>fas fa-tachometer-alt</strong> (Menu Utama)</label>
                        </div>
                        <div class="icon-radio-card">
                            <input type="radio" name="icon" id="ic2" value="fas fa-circle" required>
                            <label for="ic2" style="margin:0; font-weight:normal; cursor:pointer;"><i class="fas fa-circle" style="color:#0284c7; width:20px;"></i> <strong>fas fa-circle</strong> (Sub Menu 1)</label>
                        </div>
                        <div class="icon-radio-card">
                            <input type="radio" name="icon" id="ic3" value="far fa-dot-circle nav-icon" required>
                            <label for="ic3" style="margin:0; font-weight:normal; cursor:pointer;"><i class="far fa-dot-circle nav-icon" style="color:#0284c7; width:20px;"></i> <strong>far fa-dot-circle</strong> (Sub Menu 2)</label>
                        </div>
                        <div class="icon-radio-card">
                            <input type="radio" name="icon" id="ic4" value="fa fa-angle-right" required>
                            <label for="ic4" style="margin:0; font-weight:normal; cursor:pointer;"><i class="fa fa-angle-right" style="color:#0284c7; width:20px;"></i> <strong>fa fa-angle-right</strong> (Sub Menu 3)</label>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Group Menu / Parent Utama</label>
                        <select name="parent_id" id="grouping" class="form-control select2bs4" data-live-search="true">
                            <option value="0">Pilih Group Menu (Menu Utama)</option>
                            <?php foreach ($parent as $p) { ?>
                                <option value="<?php echo $p['id'] ?>"><?php echo $p['nama'] ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Sub Menu 1</label>
                        <select name="sub1" id="sub1" class="form-control" data-live-search="true">
                            <option value="0">Pilih Sub Menu 1</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Sub Menu 2</label>
                        <select name="sub2" id="sub2" class="form-control" data-live-search="true">
                            <option value="0">Pilih Sub Menu 2</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Sub Menu 3</label>
                        <select name="sub3" id="sub3" class="form-control" data-live-search="true">
                            <option value="0">Pilih Sub Menu 3</option>
                        </select>
                    </div>

                    <hr style="margin: 20px 0; border-color:#e2e8f0;">

                    <div class="form-group text-right">
                        <button type="submit" class="btn-save-menu">
                            <i class="fa fa-check"></i> Simpan Menu
                        </button>
                        <a href="<?php echo $kembali ?>" class="btn-cancel-menu" style="margin-left:8px;">
                            Batal
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
	$( "#grouping" ).change(function() {
  		$('#sub1').empty();
	  val = $(this).val();
	  $.get("<?php echo BASEURL . 'Masterdata/menugetsub/1' ?>?&parent_id="+val, 
	    function(data){   
	    console.log(data);
	    $('#sub1').append(data);
	  });
	});

	$( "#sub1" ).change(function() {
  		$('#sub2').empty();
	  val = $(this).val();
	  $.get("<?php echo BASEURL . 'Masterdata/menugetsub/2' ?>?&parent_id="+val, 
	    function(data){   
	    console.log(data);
	    $('#sub2').append(data);
	  });
	});

	$( "#sub2" ).change(function() {
  		$('#sub3').empty();
	  val = $(this).val();
	  $.get("<?php echo BASEURL . 'Masterdata/menugetsub' ?>?&parent_id="+val, 
	    function(data){   
	    console.log(data);
	    $('#sub3').append(data);
	  });
	});
</script>