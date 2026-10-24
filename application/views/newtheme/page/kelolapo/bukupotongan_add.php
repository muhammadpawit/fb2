<style type="text/css">
    .bpd-form {
        --navy: #1e3a5f;
        --navy-lt: #eef3f9;
        --line: #dfe5ec;
        --muted: #6b7a90;
        font-size: 12px;
    }

    .bpd-form .row {
        margin-left: -6px;
        margin-right: -6px;
    }

    .bpd-form .row > [class*="col-"] {
        padding-left: 6px;
        padding-right: 6px;
    }

    /* Toolbar */
    .bpd-form-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 8px;
        padding-bottom: 8px;
        margin-bottom: 12px;
        border-bottom: 1px solid var(--line);
    }

    .bpd-form-bar h3 {
        margin: 0;
        font-size: 15px;
        font-weight: 700;
        color: var(--navy);
    }

    .bpd-form-bar h3 small {
        font-size: 12px;
        color: var(--muted);
        margin-left: 6px;
    }

    .bpd-form .btn {
        font-size: 11px;
        font-weight: 600;
    }

    .bpd-form .btn-navy {
        background: var(--navy);
        border-color: var(--navy);
        color: #fff !important;
    }

    .bpd-form .btn-navy:hover,
    .bpd-form .btn-navy:focus {
        background: #152b47;
        border-color: #152b47;
        color: #fff !important;
    }

    /* Panels */
    .bpd-form-panel {
        border: 1px solid var(--line);
        border-radius: 4px;
        margin-bottom: 14px;
        background: #fff;
    }

    .bpd-form-panel-h {
        background: var(--navy-lt);
        color: var(--navy);
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .4px;
        padding: 6px 12px;
        border-bottom: 1px solid var(--line);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .bpd-form-panel-b {
        padding: 12px;
    }

    /* Form Fields */
    .bpd-form label {
        font-size: 11px;
        font-weight: 600;
        color: #334155;
        margin-bottom: 4px;
    }

    .bpd-form .form-control {
        height: 30px;
        font-size: 12px;
        padding: 4px 8px;
        border-color: #cbd5e1;
        border-radius: 4px;
    }

    .bpd-form .form-control:focus {
        border-color: var(--navy);
        box-shadow: 0 0 0 2px rgba(30, 58, 95, 0.15);
    }

    .bpd-form input[type="file"].form-control {
        padding: 3px 6px;
        height: auto;
    }

    /* Dynamic Tables */
    .bpd-form-table {
        margin: 0;
        width: 100%;
    }

    .bpd-form-table > thead > tr > th,
    .bpd-form-table > tr > th {
        background: var(--navy);
        color: #fff !important;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        border-bottom: none;
        padding: 6px 8px;
        vertical-align: middle;
        text-align: center;
    }

    .bpd-form-table > tbody > tr > td,
    .bpd-form-table > tr > td {
        padding: 5px 8px;
        font-size: 12px;
        vertical-align: middle;
        border-bottom: 1px solid #f0f3f7;
    }

    .bpd-form-table .form-control {
        height: 26px;
        font-size: 11px;
        padding: 2px 6px;
    }

    /* Image Preview Box */
    .img-preview-box {
        display: none;
        margin-top: 6px;
        border: 1px dashed #cbd5e1;
        border-radius: 4px;
        padding: 6px;
        background: #f8fafc;
        text-align: center;
        position: relative;
    }

    .img-preview-thumb {
        max-height: 120px;
        max-width: 100%;
        object-fit: contain;
        border-radius: 3px;
        border: 1px solid #e2e8f0;
        background: #fff;
        cursor: zoom-in;
    }

    .img-preview-badge {
        display: inline-block;
        font-size: 9px;
        font-weight: 700;
        color: #1e3a5f;
        background: #e0e7ff;
        padding: 2px 6px;
        border-radius: 3px;
        margin-bottom: 4px;
    }
</style>

<!-- Modal Zoom Image Preview -->
<div class="modal fade" id="modalZoomAdd" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="background:transparent;border:none;box-shadow:none;">
            <div class="text-right" style="padding-bottom:5px;">
                <button type="button" class="close" data-dismiss="modal" style="color:#fff;opacity:1;font-size:28px;">&times;</button>
            </div>
            <div class="text-center">
                <img id="imgZoomAdd" src="" style="max-width:100%;max-height:85vh;border-radius:6px;background:#fff;padding:6px;box-shadow:0 10px 30px rgba(0,0,0,0.5);">
            </div>
        </div>
    </div>
</div>

<div class="bpd-form">
    <!-- Flash message -->
    <?php if ($this->session->flashdata('msg')) { ?>
        <div class="alert alert-danger alert-dismissible" style="padding:8px 30px 8px 12px;font-size:12px;margin-bottom:10px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <?php echo $this->session->flashdata('msg'); ?> 
        </div>
    <?php } ?>

    <form action="<?php echo $action ?>" method="POST" enctype="multipart/form-data">
        <!-- Top Toolbar -->
        <div class="bpd-form-bar">
            <h3>
                TAMBAH BUKU POTONGAN
                <small>Input Rincian Bahan Utama &amp; Variasi PO</small>
            </h3>
            <div>
                <a href="<?php echo BASEURL . 'kelolapo/bukupotongan'; ?>" class="btn btn-default btn-sm">
                    <i class="fa fa-arrow-left"></i> Batal / Kembali
                </a>
                <button type="submit" class="btn btn-navy btn-sm">
                    <i class="fa fa-save"></i> Simpan Buku Potongan
                </button>
            </div>
        </div>

        <!-- PANEL I: INFORMASI UTAMA & POTONGAN BAHAN UTAMA -->
        <div class="bpd-form-panel">
            <div class="bpd-form-panel-h">
                <span><i class="fa fa-cut mr-1"></i> I. Informasi &amp; Potongan Bahan Utama</span>
            </div>
            <div class="bpd-form-panel-b">
                <div class="row">
                    <!-- Column 1 -->
                    <div class="col-md-4">
                        <div class="form-group" style="margin-bottom:10px;">
                            <label>Tanggal <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="tanggal" value="<?php echo $tgl ?>" required>
                        </div>
                        <div class="form-group" style="margin-bottom:10px;">
                            <label>Nama PO <span class="text-danger">*</span></label>
                            <select class="form-control autopoiinputpotongan" name="namaPo" id="poSelect" required>
                                <option value="">Pilih PO</option>
                            </select>
                        </div>
                        <div class="form-group" style="margin-bottom:10px;">
                            <label>Referensi PO</label>
                            <select class="form-control autopo" name="refPO">
                                <option value="">Pilih Referensi</option>
                            </select>
                        </div>
                    </div>

                    <!-- Column 2 -->
                    <div class="col-md-4">
                        <div class="form-group" style="margin-bottom:10px;">
                            <label>Tim Potong <span class="text-danger">*</span></label>
                            <select name="timPotong" class="form-control select2bs4" data-live-search="true" required>
                                <option value="">Pilih Tim Potong</option>
                                <?php foreach ($timpotong as $tp) { ?>
                                    <option value="<?php echo $tp['id'] ?>"><?php echo $tp['nama'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group" style="margin-bottom:10px;">
                            <label>Size Bahan <span class="text-danger">*</span></label>
                            <select name="sizeBahan" class="form-control select2bs4" data-live-search="true" required>
                                <option value="">Pilih Size</option>
                                <?php foreach ($mastersize as $tp) { ?>
                                    <option value="<?php echo $tp['size'] ?>"><?php echo $tp['size'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group" style="margin-bottom:10px;">
                            <label>Jumlah Size / Gambar (Maks 12) <span class="text-danger">*</span></label>
                            <input type="number" max="12" class="form-control" name="jumlahGambar" required placeholder="Contoh: 12">
                        </div>
                    </div>

                    <!-- Column 3 -->
                    <div class="col-md-4">
                        <div class="form-group" style="margin-bottom:10px;">
                            <label>Panjang Gelaran (cm)</label>
                            <input type="number" step="0.01" class="form-control" name="panjangGelaran" placeholder="0.00">
                        </div>
                        <div class="form-group" style="margin-bottom:10px;">
                            <label>Pemakaian Bahan (yard) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="pemakaianBahan" required placeholder="0.00">
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group" style="margin-bottom:10px;">
                                    <label>Sample Bahan 1</label>
                                    <input type="file" class="form-control file-preview-act" name="sempleBhnImg" accept="image/*" data-target="#boxPrevU1">
                                    <div id="boxPrevU1" class="img-preview-box">
                                        <span class="img-preview-badge">Preview Bahan 1</span>
                                        <img src="" class="img-preview-thumb img-preview-click" alt="Preview 1">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group" style="margin-bottom:10px;">
                                    <label>Sample Bahan 2</label>
                                    <input type="file" class="form-control file-preview-act" name="sempleBhnImg2" accept="image/*" data-target="#boxPrevU2">
                                    <div id="boxPrevU2" class="img-preview-box">
                                        <span class="img-preview-badge">Preview Bahan 2</span>
                                        <img src="" class="img-preview-thumb img-preview-click" alt="Preview 2">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabel Detail Bahan Utama -->
                <div style="margin-top:10px; border:1px solid var(--line); border-radius:4px; overflow:hidden;">
                    <table class="table table-hover bpd-form-table">
                        <thead>
                            <tr>
                                <th>Bidang Bahan</th>
                                <th>Warna</th>
                                <th>Kode Bahan</th>
                                <th>Berat Bahan (Kg)</th>
                                <th>Sisa Bahan (Kg)</th>
                                <th>Pemakaian Bahan (Yard)</th>
                                <th>Banyak Lapis Dz</th>
                                <th style="width:40px;"></th>
                            </tr>
                        </thead>
                        <tbody id="listbahanutama">
                            <tr>
                                <td colspan="8" class="text-center text-muted" style="padding:15px;">
                                    <i class="fa fa-arrow-up mr-1"></i> Pilih Nama PO di atas untuk memuat rincian bahan utama secara otomatis.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- PANEL II: POTONGAN BAHAN VARIASI -->
        <div class="bpd-form-panel">
            <div class="bpd-form-panel-h">
                <span><i class="fa fa-layer-group mr-1"></i> II. Potongan Bahan Variasi</span>
            </div>
            <div class="bpd-form-panel-b">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group" style="margin-bottom:10px;">
                            <label>Panjang Gelar Variasi (cm)</label>
                            <input type="text" class="form-control" name="panjangGelaranVariasi" placeholder="0.00">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group" style="margin-bottom:10px;">
                            <label>Pemakaian Gelaran Variasi (yard)</label>
                            <input type="number" class="form-control" step="0.01" name="pemakaianGelaranVariasi" placeholder="0.00">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group" style="margin-bottom:10px;">
                            <label>Sample Bahan Variasi 1</label>
                            <input type="file" class="form-control file-preview-act" name="sempleBhnImgVar" accept="image/*" data-target="#boxPrevV1">
                            <div id="boxPrevV1" class="img-preview-box">
                                <span class="img-preview-badge">Preview Variasi 1</span>
                                <img src="" class="img-preview-thumb img-preview-click" alt="Preview Variasi 1">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group" style="margin-bottom:10px;">
                            <label>Sample Bahan Variasi 2</label>
                            <input type="file" class="form-control file-preview-act" name="sempleBhnImgVardua" accept="image/*" data-target="#boxPrevV2">
                            <div id="boxPrevV2" class="img-preview-box">
                                <span class="img-preview-badge">Preview Variasi 2</span>
                                <img src="" class="img-preview-thumb img-preview-click" alt="Preview Variasi 2">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabel Detail Bahan Variasi -->
                <div style="margin-top:10px; border:1px solid var(--line); border-radius:4px; overflow:hidden;">
                    <table class="table table-hover bpd-form-table" id="listbahan">
                        <thead>
                            <tr>
                                <th>Bidang Bahan</th>
                                <th>Warna</th>
                                <th>Kode Bahan</th>
                                <th>Berat Bahan (Kg)</th>
                                <th>Sisa Bahan (Kg)</th>
                                <th>Pemakaian Bahan (Yard)</th>
                                <th>Banyak Lapis Dz</th>
                                <th style="width:40px; text-align:center;">
                                    <button type="button" name="add" class="btn btn-success btn-xs add2" title="Tambah Baris Variasi">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Baris variasi akan dimuat via ajax atau tombol add -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Action Footer -->
        <div class="bpd-form-bar" style="border-top:1px solid var(--line);border-bottom:none;padding-top:10px;margin-top:5px;">
            <div>
                <span class="text-muted" style="font-size:11px;">Pastikan data pemakaian dan lapis sudah sesuai sebelum menyimpan.</span>
            </div>
            <div>
                <a href="<?php echo BASEURL . 'kelolapo/bukupotongan'; ?>" class="btn btn-default btn-sm">
                    <i class="fa fa-times"></i> Batal
                </a>
                <button type="submit" class="btn btn-navy btn-sm">
                    <i class="fa fa-save"></i> Simpan Buku Potongan
                </button>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
$(document).ready(function(){

    // Real-time Preview Saat Pilih File Gambar
    $('.file-preview-act').on('change', function(){
        var input = this;
        var targetBox = $(this).data('target');
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $(targetBox).find('img').attr('src', e.target.result);
                $(targetBox).fadeIn(200);
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            $(targetBox).fadeOut(200);
        }
    });

    // Zoom Preview Modal
    $(document).on('click', '.img-preview-click', function() {
        var src = $(this).attr('src');
        if (src) {
            $('#imgZoomAdd').attr('src', src);
            $('#modalZoomAdd').modal('show');
        }
    });

    $(document).on('change', '#poSelect', function(){
        $('#listbahanutama').empty();
        $('#listbahan tbody tr').detach();
        var poid = $(this).children("option:selected").val();
        console.log(poid);
        var explode = poid.split("-");
        $('#item_table').empty();

        $.post("<?php echo BASEURL.'Kelolapo/searchPO' ?>", {kodepo: poid}).done(function(json) {
            console.log(json);
            if(json == ''){
                var html = '<tr><td colspan="8" class="text-center text-danger font-weight-bold" style="padding:15px;">Tidak Ada Data untuk PO ' + (explode[1] ? explode[1] : poid) + '</td></tr>';
                $("#listbahanutama").append(html); 
            } else {
                $("#listbahanutama").append(json); 
            }
        });

        $('#listbahan tbody').empty();
        $.post("<?php echo BASEURL.'Kelolapo/searchPObahan' ?>", {kodepo: poid}).done(function(json) {
            console.log(json);
            if(json == ''){
                var html = '<tr><td colspan="8" class="text-center text-danger font-weight-bold" style="padding:15px;">Tidak Ada Data untuk PO ' + (explode[1] ? explode[1] : poid) + '</td></tr>';
                $("#listbahan").append(html); 
            } else {
                $("#listbahan").append(json); 
            }
        });

        $.post("<?php echo BASEURL.'Kelolapo/cekharga' ?>", {kodepo: poid}).done(function(json) {
            console.log('cek harga ' + json);
            if(json == '0'){
                alert("Harga potongan untuk PO ini belum disetting");
                location.reload();
            }
        });
    });

    $(document).on('click', '.remove', function(){
        $(this).closest('tr').remove();
    });

});
</script>