<?php
// Redesigned Modern Form - Tambah Inputan Mesin Bordir (PO Dalam)
// Backup file: harianmesinbordirnaik-form_original.php
?>
<style type="text/css">
    /* Scoped Modern Styles for Bordir Form */
    .fbm-container {
        --fbm-navy: #1e3a5f;
        --fbm-navy-dark: #152b47;
        --fbm-navy-light: #f0f4f9;
        --fbm-blue: #2563eb;
        --fbm-blue-subtle: #eff6ff;
        --fbm-blue-border: #bfdbfe;
        --fbm-green: #10b981;
        --fbm-green-subtle: #ecfdf5;
        --fbm-green-border: #a7f3d0;
        --fbm-purple: #8b5cf6;
        --fbm-purple-subtle: #f5f3ff;
        --fbm-border: #e2e8f0;
        --fbm-label: #475569;
        --fbm-text: #0f172a;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        color: var(--fbm-text);
        padding: 4px 2px;
    }

    /* Modal override if rendered inside bootstrap modal */
    #modal-tambah .modal-content,
    #modal-edit .modal-content {
        border-radius: 14px !important;
        border: none !important;
        box-shadow: 0 20px 45px rgba(15, 23, 42, 0.16) !important;
        overflow: hidden !important;
    }

    #modal-tambah .modal-header,
    #modal-edit .modal-header {
        background: linear-gradient(135deg, #1e3a5f 0%, #2b4c7e 100%) !important;
        color: #ffffff !important;
        padding: 16px 24px !important;
        border-bottom: 1px solid rgba(255,255,255,0.1) !important;
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        flex-direction: row !important;
    }

    #modal-tambah .modal-header::before,
    #modal-tambah .modal-header::after,
    #modal-edit .modal-header::before,
    #modal-edit .modal-header::after {
        display: none !important;
        content: none !important;
    }

    #modal-tambah .modal-title,
    #modal-edit .modal-title {
        color: #ffffff !important;
        font-size: 16px !important;
        font-weight: 700 !important;
        letter-spacing: 0.3px !important;
        margin: 0 !important;
        padding: 0 !important;
        display: flex !important;
        align-items: center !important;
        gap: 10px !important;
        order: 1 !important;
        flex: 1 1 auto !important;
        text-align: left !important;
        float: none !important;
    }

    #modal-tambah .modal-title i,
    #modal-edit .modal-title i {
        color: #93c5fd !important;
    }

    #modal-tambah .modal-header .close,
    #modal-edit .modal-header .close {
        color: #ffffff !important;
        opacity: 0.85 !important;
        text-shadow: none !important;
        font-size: 24px !important;
        font-weight: 300 !important;
        line-height: 1 !important;
        padding: 4px 10px !important;
        margin: 0 !important;
        background: rgba(255,255,255,0.12) !important;
        border-radius: 6px !important;
        border: none !important;
        order: 2 !important;
        float: none !important;
        transition: all 0.2s ease !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        cursor: pointer !important;
    }

    #modal-tambah .modal-header .close:hover,
    #modal-edit .modal-header .close:hover {
        opacity: 1 !important;
        background: rgba(255,255,255,0.25) !important;
    }

    #modal-tambah .modal-body,
    #modal-edit .modal-body {
        background: #f8fafc !important;
        padding: 20px 24px !important;
    }

    /* Card Panels */
    .fbm-card {
        background: #ffffff;
        border: 1px solid var(--fbm-border);
        border-radius: 10px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
        margin-bottom: 20px;
        overflow: hidden;
        transition: box-shadow 0.2s ease, border-color 0.2s ease;
    }

    .fbm-card:hover {
        border-color: #cbd5e1;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.05);
    }

    .fbm-card-header {
        background: #f8fafc;
        border-bottom: 1px solid var(--fbm-border);
        padding: 11px 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .fbm-card-title {
        margin: 0;
        font-size: 13px;
        font-weight: 700;
        color: var(--fbm-navy);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .fbm-card-title i {
        font-size: 15px;
    }

    .fbm-card-badge {
        font-size: 11px;
        font-weight: 600;
        padding: 3px 9px;
        border-radius: 20px;
        letter-spacing: 0.3px;
    }

    .fbm-badge-blue {
        background: var(--fbm-blue-subtle);
        color: var(--fbm-blue);
        border: 1px solid var(--fbm-blue-border);
    }

    .fbm-badge-purple {
        background: var(--fbm-purple-subtle);
        color: var(--fbm-purple);
        border: 1px solid #ddd6fe;
    }

    .fbm-badge-green {
        background: var(--fbm-green-subtle);
        color: #059669;
        border: 1px solid var(--fbm-green-border);
    }

    .fbm-card-body {
        padding: 18px;
    }

    /* Form Fields */
    .fbm-form-group {
        margin-bottom: 15px;
    }

    .fbm-label {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 11.5px;
        font-weight: 600;
        color: var(--fbm-label);
        margin-bottom: 6px;
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }

    .fbm-label i {
        color: #94a3b8;
        font-size: 12px;
    }

    .fbm-label .required-star {
        color: #ef4444;
        font-weight: 700;
        margin-left: 2px;
    }

    .fbm-input-wrap {
        position: relative;
    }

    .fbm-input {
        height: 38px !important;
        font-size: 12.5px !important;
        color: #1e293b !important;
        background: #ffffff !important;
        border: 1px solid #cbd5e1 !important;
        border-radius: 6px !important;
        padding: 6px 12px !important;
        transition: all 0.2s ease !important;
        box-shadow: 0 1px 2px rgba(0,0,0,0.02) !important;
        width: 100% !important;
    }

    .fbm-input:focus {
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15) !important;
        outline: none !important;
        background: #ffffff !important;
    }

    .fbm-input::placeholder {
        color: #94a3b8 !important;
        font-size: 12px !important;
    }

    /* Select2 Alignment */
    .fbm-container .select2-container {
        width: 100% !important;
    }

    .fbm-container .select2-container .select2-selection--single {
        height: 38px !important;
        border: 1px solid #cbd5e1 !important;
        border-radius: 6px !important;
        padding: 5px 10px !important;
        background: #ffffff !important;
        box-shadow: 0 1px 2px rgba(0,0,0,0.02) !important;
        transition: all 0.2s ease !important;
    }

    .fbm-container .select2-container--default .select2-selection--single .select2-selection__rendered,
    .fbm-container .select2-container--bootstrap4 .select2-selection--single .select2-selection__rendered {
        line-height: 26px !important;
        font-size: 12.5px !important;
        color: #1e293b !important;
        padding-left: 2px !important;
    }

    .fbm-container .select2-container--default .select2-selection--single .select2-selection__arrow,
    .fbm-container .select2-container--bootstrap4 .select2-selection--single .select2-selection__arrow {
        height: 36px !important;
        right: 8px !important;
    }

    .fbm-container .select2-container--open .select2-selection--single {
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15) !important;
    }

    /* Highlighted Stat / Calculation Cards */
    .fbm-calc-box {
        background: #ffffff;
        border: 1px solid var(--fbm-border);
        border-radius: 8px;
        padding: 12px 14px;
        margin-bottom: 12px;
        transition: all 0.2s ease;
        position: relative;
    }

    .fbm-calc-box.fbm-box-stich {
        background: linear-gradient(to bottom right, #ffffff, var(--fbm-blue-subtle));
        border-color: var(--fbm-blue-border);
    }

    .fbm-calc-box.fbm-box-tarif {
        background: linear-gradient(to bottom right, #ffffff, var(--fbm-green-subtle));
        border-color: var(--fbm-green-border);
    }

    .fbm-calc-box.fbm-box-target {
        background: linear-gradient(to bottom right, #ffffff, var(--fbm-purple-subtle));
        border-color: #ddd6fe;
    }

    .fbm-calc-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 6px;
    }

    .fbm-calc-label {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #475569;
        margin: 0;
    }

    .fbm-calc-tag {
        font-size: 9.5px;
        font-weight: 700;
        text-transform: uppercase;
        padding: 2px 6px;
        border-radius: 4px;
    }

    .fbm-calc-input {
        font-size: 16px !important;
        font-weight: 700 !important;
        height: 42px !important;
        text-align: right !important;
        border-radius: 6px !important;
    }

    .fbm-box-stich .fbm-calc-input {
        color: #1e40af !important;
        border-color: #93c5fd !important;
        background: #ffffff !important;
    }

    .fbm-box-tarif .fbm-calc-input {
        color: #065f46 !important;
        border-color: #6ee7b7 !important;
        background: #ffffff !important;
    }

    .fbm-box-target .fbm-calc-input {
        color: #5b21b6 !important;
        border-color: #c4b5fd !important;
        background: #ffffff !important;
    }

    .fbm-calc-formula {
        font-size: 10.5px;
        color: #64748b;
        margin-top: 4px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    /* Footer Action Bar */
    .fbm-footer-bar {
        background: #ffffff;
        border: 1px solid var(--fbm-border);
        border-radius: 10px;
        padding: 14px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }

    .fbm-footer-hint {
        font-size: 12px;
        color: #64748b;
        display: flex;
        align-items: center;
        gap: 8px;
        margin: 0;
    }

    .fbm-footer-hint i {
        color: #3b82f6;
        font-size: 14px;
    }

    .fbm-footer-actions {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .fbm-btn {
        height: 38px;
        padding: 0 20px;
        font-size: 12.5px;
        font-weight: 600;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.2s ease;
        cursor: pointer;
        border: 1px solid transparent;
        text-decoration: none !important;
    }

    .fbm-btn-cancel {
        background: #ffffff;
        border-color: #cbd5e1;
        color: #475569 !important;
    }

    .fbm-btn-cancel:hover {
        background: #f1f5f9;
        border-color: #94a3b8;
        color: #0f172a !important;
    }

    .fbm-btn-submit {
        background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 100%);
        color: #ffffff !important;
        box-shadow: 0 2px 6px rgba(37, 99, 235, 0.25);
    }

    .fbm-btn-submit:hover {
        background: linear-gradient(135deg, #152b47 0%, #1d4ed8 100%);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.35);
        transform: translateY(-1px);
    }

    .fbm-btn-submit:active {
        transform: translateY(0);
    }

    @media (max-width: 768px) {
        .fbm-footer-bar {
            flex-direction: column;
            align-items: stretch;
        }
        .fbm-footer-actions {
            justify-content: flex-end;
        }
    }
</style>

<div class="fbm-container">
<form action="<?php echo BASEURL.'bordir/addharianmesinsave' ?>" method="POST" id="form-bordir-harian">
<input type="hidden" name="jenis" value="<?php echo $jenis?>">

<!-- ============================================== -->
<!-- CARD 1: INFORMASI OPERASIONAL & SHIFT           -->
<!-- ============================================== -->
<div class="fbm-card">
    <div class="fbm-card-header">
        <h4 class="fbm-card-title">
            <i class="fa fa-sliders text-primary"></i>
            Informasi Operasional & Shift Mesin
        </h4>
        <span class="fbm-card-badge fbm-badge-blue">
            <i class="fa fa-users"></i> Personel & Mesin
        </span>
    </div>
    <div class="fbm-card-body">
        <div class="row">
            <!-- TANGGAL -->
            <div class="col-md-4 col-sm-6">
                <div class="fbm-form-group">
                    <label class="fbm-label">
                        <i class="fa fa-calendar"></i> Tanggal Produksi <span class="required-star">*</span>
                    </label>
                    <div class="fbm-input-wrap">
                        <input type="text" class="form-control fbm-input datepicker" name="tanggal" value="<?php echo date('Y-m-d') ?>" required autocomplete="off">
                    </div>
                </div>
            </div>

            <!-- NAMA PO -->
            <div class="col-md-4 col-sm-6">
                <div class="fbm-form-group">
                    <label class="fbm-label">
                        <i class="fa fa-tag"></i> Nama / Kode PO <span class="required-star">*</span>
                    </label>
                    <select name="namaPo" id="namaPo" class="form-control select2bs4 fbm-input" data-live-search="TRUE" required>
                        <option value="">-- Pilih Kode PO --</option>
                        <?php foreach($po as $p){?>
                            <option value="<?php echo $p['kode_po']?>"><?php echo $p['kode_po']?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <!-- SHIFT -->
            <div class="col-md-4 col-sm-6">
                <div class="fbm-form-group">
                    <label class="fbm-label">
                        <i class="fa fa-clock-o"></i> Shift Kerja <span class="required-star">*</span>
                    </label>
                    <select class="form-control select2bs4 shift fbm-input" name="shift" title="Pilih Shift" data-live-search="TRUE" required>
                        <option value="PAGI" data-shift="PAGI">PAGI</option>
                        <option value="MALAM" data-shift="MALAM">MALAM</option>
                    </select>
                </div>
            </div>

            <!-- ABSENSI -->
            <div class="col-md-4 col-sm-6">
                <div class="fbm-form-group">
                    <label class="fbm-label">
                        <i class="fa fa-check-square-o"></i> Status Kehadiran <span class="required-star">*</span>
                    </label>
                    <select class="form-control select2bs4 shift fbm-input" name="kehadiran" id="kehadiran" title="Pilih Kehadiran" data-live-search="TRUE" required>
                        <option value="HADIR" data-shift="HADIR" data-jam="12">HADIR (12 Jam)</option>
                        <option value="IZIN" data-shift="IZIN" data-jam="12">IZIN (12 Jam)</option>
                        <option value="1/2HARI" data-shift="1/2HARI" data-jam="6">1/2 HARI (6 Jam)</option>
                    </select>
                </div>
            </div>

            <!-- JAM KERJA -->
            <div class="col-md-4 col-sm-6">
                <div class="fbm-form-group">
                    <label class="fbm-label">
                        <i class="fa fa-hourglass-half"></i> Jam Kerja (Jam) <span class="required-star">*</span>
                    </label>
                    <input type="number" class="form-control fbm-input selectpicker shift" name="jamkehadiran" id="jamkerja" placeholder="Contoh: 12" value="12" required>
                </div>
            </div>

            <!-- NAMA OPERATOR -->
            <div class="col-md-4 col-sm-6">
                <div class="fbm-form-group">
                    <label class="fbm-label">
                        <i class="fa fa-user"></i> Nama Operator <span class="required-star">*</span>
                    </label>
                    <select class="form-control select2bs4 fbm-input" data-live-search="TRUE" name="namaOperator" required>
                        <option value="">-- Pilih Operator --</option>
                        <?php foreach ($operator as $key => $op): ?>
                            <option value="<?php echo $op['id_master_karyawan_bordir'] ?>"><?php echo $op['nama_karyawan_bordir'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>

            <!-- NAMA MANDOR -->
            <div class="col-md-4 col-sm-6">
                <div class="fbm-form-group">
                    <label class="fbm-label">
                        <i class="fa fa-id-badge"></i> Nama Mandor <span class="required-star">*</span>
                    </label>
                    <input type="text" name="mandor" class="form-control fbm-input" placeholder="Masukkan nama mandor" required>
                </div>
            </div>

            <!-- JAGA MESIN -->
            <div class="col-md-4 col-sm-6">
                <div class="fbm-form-group">
                    <label class="fbm-label">
                        <i class="fa fa-cogs"></i> Jaga Mesin Bordir <span class="required-star">*</span>
                    </label>
                    <select class="form-control select2bs4 fbm-input" name="mesin" required>
                        <option value="">-- Pilih Mesin --</option>
                        <?php foreach ($mesin as $key => $me): ?>
                        <option value="<?php echo $me['nomer_mesin'] ?>"><?php echo $me['nomer_mesin'] ?> (<?php echo $me['nama_mesin'] ?>)</option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>

            <!-- GAMBAR -->
            <div class="col-md-4 col-sm-6">
                <div class="fbm-form-group">
                    <label class="fbm-label">
                        <i class="fa fa-picture-o"></i> Kode / Nama Gambar <span class="required-star">*</span>
                    </label>
                    <input type="text" class="form-control fbm-input" name="gambar" placeholder="Masukkan nama/kode gambar" required>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============================================== -->
<!-- CARD 2: SPESIFIKASI & DETAIL BORDIR             -->
<!-- ============================================== -->
<div class="fbm-card">
    <div class="fbm-card-header">
        <h4 class="fbm-card-title">
            <i class="fa fa-scissors text-info"></i>
            Spesifikasi & Bagian Bordir
        </h4>
        <span class="fbm-card-badge fbm-badge-purple">
            <i class="fa fa-puzzle-piece"></i> Detail Item
        </span>
    </div>
    <div class="fbm-card-body">
        <div class="row">
            <!-- POSISI BORDIR -->
            <div class="col-md-4 col-sm-6">
                <div class="fbm-form-group">
                    <label class="fbm-label">
                        <i class="fa fa-crosshairs"></i> Posisi Bordir <span class="required-star">*</span>
                    </label>
                    <input type="text" class="form-control fbm-input" name="yangdibordir" placeholder="Contoh: Dada, Punggung, Topi" required>
                </div>
            </div>

            <!-- SIZE -->
            <div class="col-md-2 col-sm-6">
                <div class="fbm-form-group">
                    <label class="fbm-label">
                        <i class="fa fa-text-width"></i> Size / Ukuran <span class="required-star">*</span>
                    </label>
                    <input type="text" class="form-control fbm-input" name="size" placeholder="S, M, L, XL" required>
                </div>
            </div>

            <!-- JUMLAH BAGIAN YANG DI BORDIR -->
            <div class="col-md-3 col-sm-6">
                <div class="fbm-form-group">
                    <label class="fbm-label">
                        <i class="fa fa-cubes"></i> Jml Bagian di Bordir <span class="required-star">*</span>
                    </label>
                    <input type="number" class="form-control fbm-input" name="jumlahbagian" placeholder="Jumlah bagian" value="" required>
                </div>
            </div>

            <!-- JUMLAH SIZE -->
            <div class="col-md-3 col-sm-6">
                <div class="fbm-form-group">
                    <label class="fbm-label">
                        <i class="fa fa-sort-amount-asc"></i> Jumlah Size <span class="required-star">*</span>
                    </label>
                    <input type="text" class="form-control fbm-input" name="jumlah_size" placeholder="Jumlah size" value="" required>
                </div>
            </div>

            <!-- SPON -->
            <div class="col-md-6 col-sm-6">
                <div class="fbm-form-group">
                    <label class="fbm-label">
                        <i class="fa fa-square"></i> Spon <span class="required-star">*</span>
                    </label>
                    <input type="number" class="form-control fbm-input" name="spon" placeholder="0" required>
                </div>
            </div>

            <!-- APL -->
            <div class="col-md-6 col-sm-6">
                <div class="fbm-form-group">
                    <label class="fbm-label">
                        <i class="fa fa-clone"></i> APL <span class="required-star">*</span>
                    </label>
                    <input type="number" class="form-control fbm-input" name="apl" placeholder="0" required>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============================================== -->
<!-- CARD 3: DATA PRODUKSI, STICH & HASIL TAGIHAN    -->
<!-- ============================================== -->
<div class="fbm-card">
    <div class="fbm-card-header">
        <h4 class="fbm-card-title">
            <i class="fa fa-calculator text-success"></i>
            Data Produksi, Stich & Tagihan
        </h4>
        <span class="fbm-card-badge fbm-badge-green">
            <i class="fa fa-bolt"></i> Kalkulasi Otomatis
        </span>
    </div>
    <div class="fbm-card-body">
        <div class="row">
            <!-- INPUT PRODUKSI -->
            <div class="col-md-3 col-sm-6">
                <div class="fbm-form-group">
                    <label class="fbm-label">
                        <i class="fa fa-arrow-circle-up text-primary"></i> Jml Naik Mesin <span class="required-star">*</span>
                    </label>
                    <input type="number" class="form-control fbm-input" name="jmlNaik" id="jmlNaik" step="0.01" placeholder="0" required>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="fbm-form-group">
                    <label class="fbm-label">
                        <i class="fa fa-arrow-circle-down text-info"></i> Jml Turun Mesin <span class="required-star">*</span>
                    </label>
                    <input type="number" class="form-control fbm-input" id="jmlTurun" name="jmlTurun" step="0.01" placeholder="0" required>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="fbm-form-group">
                    <label class="fbm-label">
                        <i class="fa fa-hashtag"></i> Stich (per Pcs) <span class="required-star">*</span>
                    </label>
                    <input type="number" class="form-control fbm-input" id="stich" name="stich" placeholder="0" required>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="fbm-form-group">
                    <label class="fbm-label">
                        <i class="fa fa-percent"></i> Target Perkalian Tagihan
                    </label>
                    <input type="hidden" class="form-control" id="perkalianTarget" name="perkalianTarget">
                    <input type="number" step="any" class="form-control fbm-input" id="perkalianTarif" name="perkalianTarif" value="0.19">
                </div>
            </div>
        </div>

        <!-- HIGHLIGHTED CALCULATION RESULT CARDS -->
        <div class="row" style="margin-top: 10px;">
            <!-- TOTAL STICH -->
            <div class="col-md-4 col-sm-12">
                <div class="fbm-calc-box fbm-box-stich">
                    <div class="fbm-calc-header">
                        <label class="fbm-calc-label">
                            <i class="fa fa-calculator text-primary"></i> Total Stich
                        </label>
                        <span class="fbm-calc-tag bg-primary text-white">Auto</span>
                    </div>
                    <input type="number" class="form-control fbm-input fbm-calc-input" id="totalStich" name="totalStich" step="0.01" placeholder="0" required>
                    <div class="fbm-calc-formula">
                        <i class="fa fa-info-circle"></i> Jml Turun × Stich
                    </div>
                </div>
            </div>

            <!-- TAGIHAN -->
            <div class="col-md-4 col-sm-12">
                <div class="fbm-calc-box fbm-box-tarif">
                    <div class="fbm-calc-header">
                        <label class="fbm-calc-label">
                            <i class="fa fa-money text-success"></i> Tagihan (Rp)
                        </label>
                        <span class="fbm-calc-tag bg-success text-white">Otomatis</span>
                    </div>
                    <input type="text" class="form-control fbm-input fbm-calc-input" id="tarif" name="tarif" placeholder="0" required>
                    <div class="fbm-calc-formula">
                        <i class="fa fa-info-circle"></i> Total Stich × Target Tarif
                    </div>
                </div>
            </div>

            <!-- TARGET MESIN -->
            <div class="col-md-4 col-sm-12">
                <div class="fbm-calc-box fbm-box-target">
                    <div class="fbm-calc-header">
                        <label class="fbm-calc-label">
                            <i class="fa fa-bullseye text-purple"></i> Target Mesin
                        </label>
                        <span class="fbm-calc-tag bg-secondary text-white">Target</span>
                    </div>
                    <input type="text" class="form-control fbm-input fbm-calc-input" id="target" name="target" placeholder="0" required>
                    <div class="fbm-calc-formula">
                        <i class="fa fa-info-circle"></i> Total Stich × Target Perkalian
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============================================== -->
<!-- FOOTER ACTION BAR                              -->
<!-- ============================================== -->
<div class="fbm-footer-bar">
    <div class="fbm-footer-hint">
        <i class="fa fa-info-circle"></i>
        <span><b>Info:</b> Total Stich dan Tagihan akan dihitung otomatis saat <i>Jml Turun</i> dan <i>Stich</i> diisi.</span>
    </div>
    <div class="fbm-footer-actions">
        <a href="<?php echo $kembali?>" class="btn btn-danger fbm-btn fbm-btn-cancel" data-dismiss="modal">
            <i class="fa fa-times"></i> Batal
        </a>
        <button type="submit" class="btn btn-info fbm-btn fbm-btn-submit">
            <i class="fa fa-check"></i> Simpan Inputan
        </button>
    </div>
</div>

</form>
</div>

<script type="text/javascript">
$(document).ready(function(){

    // Fungsi kalkulasi otomatis Total Stich & Tagihan
    function calculateBordir() {
        var jmlTurun = parseFloat($('#jmlTurun').val()) || 0;
        var stich = parseFloat($('#stich').val()) || 0;
        var perkali = parseFloat($('#perkalianTarif').val()) || 0;
        var targetPerkali = parseFloat($('#perkalianTarget').val()) || 0;

        // Hitung total stich
        if (jmlTurun > 0 && stich > 0) {
            var totalStich = jmlTurun * stich;
            $('#totalStich').val(totalStich);

            // Hitung tarif
            if (perkali > 0) {
                var tarif = totalStich * perkali;
                $('#tarif').val(Math.round(tarif));
            }

            // Hitung target jika perkalian target ada
            if (targetPerkali > 0) {
                $('#target').val(totalStich * targetPerkali);
            }
        }
    }

    // Event listener: saat stich atau jmlTurun diketik
    $('#stich, #jmlTurun').on('input keyup change', function() {
        var jmlTurun = parseFloat($('#jmlTurun').val()) || 0;
        var stich = parseFloat($('#stich').val()) || 0;
        var total = jmlTurun * stich;
        $('#totalStich').val(total);

        var perkali = parseFloat($('#perkalianTarif').val()) || 0;
        if (total > 0 && perkali > 0) {
            var tarif = total * perkali;
            $('#tarif').val(Math.round(tarif));
        }
    });

    // Event listener: saat perkalianTarif diubah
    $('#perkalianTarif').on('input keyup change', function() {
        var total = parseFloat($('#totalStich').val()) || 0;
        var perkali = parseFloat($(this).val()) || 0;
        var tarif = total * perkali;
        $('#tarif').val(Math.round(tarif));
    });

    // Event listener: saat totalStich diedit manual
    $('#totalStich').on('input keyup change', function() {
        var total = parseFloat($(this).val()) || 0;
        var perkali = parseFloat($('#perkalianTarif').val()) || 0;
        if (total > 0 && perkali > 0) {
            var tarif = total * perkali;
            $('#tarif').val(Math.round(tarif));
        }
    });

    // Event listener: perkalianTarget
    $('#perkalianTarget').on('input keyup change', function() {
        var total = parseFloat($('#totalStich').val()) || 0;
        var perkali = parseFloat($(this).val()) || 0;
        $('#target').val(total * perkali);
    });

    // Event listener: kehadiran -> jam kerja
    $('#kehadiran').on('change', function() {
        var jam = $(this).children("option:selected").data('jam');
        if (jam) {
            $('#jamkerja').val(jam);
        }
    });

    // Default jam kerja jika kosong
    if (!$('#jamkerja').val()) {
        var defaultJam = $('#kehadiran').children("option:selected").data('jam');
        if (defaultJam) {
            $('#jamkerja').val(defaultJam);
        }
    }

    // Inisialisasi ulang datepicker dan select2 jika form dimuat via modal AJAX
    if ($.isFunction($.fn.datepicker)) {
        $('.datepicker').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd'
        });
    }

    if ($.isFunction($.fn.select2)) {
        $('.select2bs4').select2({
            width: '100%'
        });
    }

    // Event listener untuk baris dinamis (kompatibilitas fungsi bawaan)
    $(document).on('click', '.add', function(){
        var html = '';
        html += '<tr>';
        html += '<td><input type="number" class="form-control" name="jmlNaik" step=0.01 required></td>';
        html += '<td><input type="number" class="form-control" name="jmlTurun" step=0.01 required></td>';
        html += '<td><input type="text" class="form-control" name="size" ></td>';
        html += '<td><input type="number" class="form-control" name="stich" required></td>';
        html += '<td><input type="number" class="form-control" name="totalStich" step=0.01 required></td>';
        html += '<td><input type="number" class="form-control" name="perkalianTarif" step=0.01 required></td>';
        html += '<td><input type="number" class="form-control" name="perkalianTarget" step=0.01 required></td>';
        html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button></td></tr>';

        var html2 = '';
        html2 += '<tr>';
        html2 += '<td><input type="number" class="form-control" name="spon" ></td>';
        html2 += '<td><input type="number" class="form-control" name="apl" required></td>';
        html2 += '<td><input type="text" class="form-control" name="yangdibordir" step=0.01 required></td>';
        html2 += '<td><input type="text" class="form-control" name="kendala"></td>';
        html2 += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button></td></tr>';
        
        $('#item_table').append(html);
        $('#item_table2').append(html2);
    });

    $(document).on('click', '.remove', function(){
        $(this).closest('tr').remove();
    });

});
</script>