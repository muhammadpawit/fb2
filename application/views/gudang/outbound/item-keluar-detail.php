<style>
/* Custom Styles untuk Form Section */
.upload-section {
    border: 2px dashed #dee2e6;
    border-radius: 8px;
    padding: 20px;
    text-align: center;
    transition: all 0.3s ease;
}

.upload-section:hover {
    border-color: #007bff;
    background-color: #f8f9fa;
}

.image-preview-container {
    text-align: center;
    background: #f8f9fa;
    border-radius: 8px;
    padding: 15px;
}

.file-info {
    text-align: center;
}

.file-actions {
    text-align: center;
}

.card-header {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    color: white;
}

.form-label {
    font-weight: 600;
    color: #495057;
}

.custom-file-label::after {
    content: "Browse";
    background: #007bff;
    border-color: #007bff;
    color: white;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .image-preview-container img {
        max-height: 200px;
    }
    
    .file-actions .btn {
        margin-bottom: 5px;
    }
}
</style>
<form method="post" action="<?php echo $update; ?>" id="update">
    <div class="container-fluid">
    <!-- Header Section -->
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <h1>Forboys Production</h1>
                <h6>Alamat</h6>
                <address class="line-h-24">
                    JL.Z NO 1, Kel. Sukabumi Selatan, Kec Kebon Jeruk Kampung Baru, Jakarta Barat
                </address>
                <h3><strong>Faktur No. </strong><?php echo $barang[0]['faktur_no'] ?></h3>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="form-group">
                <table class="table table-bordered" style="font-size: 14pt;" cellpadding="3">
                    <tbody>
                        <tr>
                            <td colspan="2">
                                <strong>Jakarta</strong>, 
                                <input type="text" name="tanggal" class="form-control datepicker" 
                                       value="<?php echo date('Y-m-d', strtotime($barang[0]['created_date'])) ?>">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">Kepada Yth</td>
                        </tr>
                        <tr>
                            <td style="width: 30%;">Tuan/Toko</td>
                            <td>: <?php echo $barang[0]['nama_penerima']; ?></td>
                        </tr>
                        <tr>
                            <td>Tujuan</td>
                            <td>: <?php echo $barang[0]['tujuan_item']; ?></td>
                        </tr>
                        <tr>
                            <td>NAMA PO</td>
                            <td>: <?php echo $project['nama_po'] . $project['kode_po']; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Items Table Section -->
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered mt-4">
                        <thead class="thead-dark">
                            <tr>
                                <th style="width: 5%;">#</th>
                                <th style="width: 25%;">Nama Barang</th>
                                <th style="width: 10%;">Ukuran</th>
                                <th style="width: 10%;">Jumlah</th>
                                <th style="width: 10%;">Satuan</th>
                                <th style="width: 12%;">Harga Pcs</th>
                                <th style="width: 15%;" class="text-right">Total</th>
                                <th style="width: 13%;">Jml Per Dz</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $totals = 0;
                            $total = 0; 
                            $no = 1; 
                            foreach ($barang as $key => $item): 
                            ?>
                                <tr>
                                    <td><?php echo $no; ?></td>
                                    <td>
                                        <strong><?php echo $item['nama_item_keluar'] ?></strong>
                                    </td>
                                    <td>
                                        <strong><?php echo $item['ukuran_item_keluar'] ?></strong>
                                    </td>
                                    <td>
                                        <input type="number" 
                                               class="form-control form-control-sm" 
                                               name="prods[<?php echo $no?>][jumlah_item_keluar]" 
                                               value="<?php echo $item['jumlah_item_keluar'] ?>">
                                    </td>
                                    <td><?php echo $item['satuan_jumlah_keluar'] ?></td>
                                    <td>
                                        <input type="hidden" 
                                               name="prods[<?php echo $no?>][id_item_keluar]" 
                                               value="<?php echo $item['id_item_keluar']?>">
                                        <input type="number" 
                                               class="form-control form-control-sm" 
                                               name="prods[<?php echo $no?>][harga_item]" 
                                               value="<?php echo $item['harga_item']?>">
                                    </td>
                                    <?php 
                                    $total = $item['jumlah_item_keluar'] * $item['harga_item'];
                                    $totals += $total;
                                    ?>
                                    <td class="text-right">
                                        <strong>Rp <?php echo number_format($total, 0, ',', '.') ?></strong>
                                    </td>
                                    <td>
                                        <input type="number" 
                                               class="form-control form-control-sm" 
                                               name="prods[<?php echo $no?>][jumlah_item_perlusin]" 
                                               value="<?php echo $item['jumlah_item_perlusin'] ?>">
                                    </td>
                                </tr>
                            <?php 
                            $no++;
                            endforeach 
                            ?>
                            
                            <!-- Total Row -->
                            <tr class="table-info">
                                <td colspan="6" class="text-center">
                                    <strong>TOTAL KESELURUHAN</strong>
                                </td>
                                <td class="text-right">
                                    <strong>Rp <?php echo number_format($totals, 0, ',', '.') ?></strong>
                                </td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>      
            </div>
        </div>
    </div>
</div>
</form>
<form id="upload" method="post" action="<?php echo $lampiran?>" enctype="multipart/form-data">
    <div class="container-fluid">
    <!-- Form Section: Tanggal Kirim & Lampiran -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Informasi Pengiriman & Lampiran</h5>
                </div>
                <div class="card-body">
                    <!-- Hidden Input -->
                    <input type="hidden" name="kode_po" value="<?php echo $project['kode_po'] ?>">
                    <input type="hidden" name="id_produksi_po" value="<?php echo $project['id_produksi_po'] ?>">
                    
                    <!-- Tanggal Kirim -->
                    <div class="form-group mb-3">
                        <label for="tglkirim" class="form-label">
                            <i class="fas fa-calendar-alt"></i> Tanggal Kirim
                        </label>
                        <input type="text" 
                               id="tglkirim"
                               name="tglkirim" 
                               class="form-control datepicker" 
                               value="<?php echo !empty($l) ? $l['tglkirim'] : date('Y-m-d'); ?>" 
                               readonly
                               placeholder="Pilih tanggal pengiriman">
                    </div>
                    
                    <!-- Lampiran Section -->
                    <div class="form-group mb-3">
                        <label class="form-label">
                            <i class="fas fa-paperclip"></i> Lampiran
                        </label>
                        
                        <?php if (empty($l['foto'])): ?>
                            <!-- Upload Form -->
                            <div class="upload-section">
                                <div class="custom-file mb-3">
                                    <input type="file" 
                                           name="lampiran" 
                                           id="lampiran"
                                           class="custom-file-input form-control"
                                           accept="image/*,.pdf,.doc,.docx">
                                    <label class="custom-file-label" for="lampiran">
                                        Pilih file lampiran...
                                    </label>
                                </div>
                                <small class="form-text text-muted">
                                    <i class="fas fa-info-circle"></i> 
                                    Format yang didukung: JPG, PNG, PDF, DOC, DOCX (Max: 5MB)
                                </small>
                            </div>
                        <?php else: ?>
                            <!-- Display Existing File -->
                            <div class="existing-file-section">
                                <div class="file-preview mb-3">
                                    <?php 
                                    $file_extension = strtolower(pathinfo($l['foto'], PATHINFO_EXTENSION));
                                    $image_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                                    ?>
                                    
                                    <?php if (in_array($file_extension, $image_extensions)): ?>
                                        <!-- Image Preview -->
                                        <div class="image-preview-container">
                                            <img src="<?php echo BASEURL ?>assets/lampiran/<?php echo $l['foto'] ?>" 
                                                 alt="Lampiran" 
                                                 class="img-fluid rounded shadow-sm"
                                                 style="max-height: 300px; max-width: 100%; object-fit: contain;">
                                        </div>
                                    <?php else: ?>
                                        <!-- Non-Image File Preview -->
                                        <div class="file-info alert alert-info">
                                            <i class="fas fa-file-alt fa-2x mb-2"></i>
                                            <p class="mb-1"><strong>File:</strong> <?php echo $l['foto'] ?></p>
                                            <p class="mb-0"><strong>Type:</strong> <?php echo strtoupper($file_extension) ?></p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- File Actions -->
                                <div class="file-actions">
                                    <a href="<?php echo BASEURL ?>assets/lampiran/<?php echo $l['foto'] ?>" 
                                       target="_blank" 
                                       class="btn btn-outline-primary btn-sm me-2">
                                        <i class="fas fa-eye"></i> Lihat
                                    </a>
                                    <a href="<?php echo BASEURL ?>assets/lampiran/<?php echo $l['foto'] ?>" 
                                       download 
                                       class="btn btn-outline-success btn-sm">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Submit Button -->
                    <?php if (empty($l['foto'])): ?>
                        <div class="form-group mb-0">
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-upload"></i> Upload Lampiran
                                </button>
                            </div>
                            <small class="form-text text-muted text-center mt-2">
                                Klik untuk mengunggah file lampiran
                            </small>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
<div class="row no-print">
    <div class="col-md-4">
        <div class="form-group">
            <?php if(aksesedit()==1){?>
                <a onclick="update()" style="width: 100% !important;" class="btn btn-success waves-effect waves-light text-white"><i class="fa fa-save m-r-5"></i> Update</a>
            <?php }else{ ?>
                <button onclick="window.reload()" style="width: 100% !important;" class="btn btn-success waves-effect waves-light text-white" disabled><i class="fa fa-save m-r-5"></i> Silahkan melakukan otorisasi</button>
            <?php } ?>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <a href="<?php echo $cetak ?>" target="_blank" style="width: 100% !important;" class="btn btn-primary waves-effect waves-light"></i> Cetak</a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <a href="<?php echo $batal ?>" style="width: 100% !important;" class="btn btn-danger waves-effect waves-light"></i> Kembali</a>
        </div>
    </div>
</div>
<script type="text/javascript">
    function update(){
        $("#update").submit();
    }
</script>