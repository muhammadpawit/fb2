<link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    .payroll-wrapper {
        font-family: 'Source Sans Pro', sans-serif;
        background: #ecf0f5;
        padding: 15px;
    }
    .header-card {
        background: #fff;
        padding: 20px;
        border-radius: 4px;
        border-top: 3px solid #3c8dbc;
        margin-bottom: 25px;
        text-align: center;
        box-shadow: 0 1px 1px rgba(0,0,0,0.1);
    }
    .employee-box {
        background: #fff;
        border-radius: 4px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        border-top: 3px solid #d2d6de;
        margin-bottom: 25px;
    }
    .employee-box-header {
        padding: 12px 15px;
        border-bottom: 1px solid #f4f4f4;
        background: #fafafa;
        font-weight: 700;
        color: #333;
    }
    .payroll-table { width: 100%; border-collapse: collapse; }
    .payroll-table th {
        background: #f9f9f9; font-size: 11px; font-weight: 700; color: #777;
        text-transform: uppercase; padding: 10px 15px; border-bottom: 1px solid #eee;
    }
    .payroll-table td { padding: 10px 15px; border-bottom: 1px solid #f4f4f4; font-size: 13px; }
    .text-amount { text-align: right; font-weight: 700; color: #333; }
    .text-income { color: #00a65a; }
    .text-danger { color: #dd4b39; }
    
    .row-highlight { background: #f9f9f9; font-weight: 700; }
    .row-total { background: #3c8dbc; color: #fff; font-weight: 800; }
    .row-total td { border-bottom: none; }
    
    .summary-box {
        background: #00a65a; color: #fff; padding: 15px 25px; border-radius: 4px;
        display: inline-block; margin-top: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    
    .btn-modern {
        border-radius: 3px; font-weight: 600; text-transform: uppercase;
        padding: 8px 20px; transition: all 0.2s;
    }

    @media print { .no-print { display: none !important; } }
</style>

<div class="payroll-wrapper">
    <div class="header-card">
        <h2 style="margin: 0; font-weight: 800; color: #333;"><?php echo $title ?></h2>
        <p style="margin: 10px 0 0; color: #777; font-weight: 600;">
            <i class="fa fa-calendar mr-2"></i> PERIODE: <?php echo isset($gaji['tanggal1']) ? formatTanggalIndo($gaji['tanggal1']).' s.d '.formatTanggalIndo($gaji['tanggal2']) : '-' ?>
        </p>
        <div class="summary-box">
            <span style="font-size: 12px; display: block; opacity: 0.8;">TOTAL PEMBULATAN</span>
            <span style="font-size: 20px; font-weight: 800;" id="total_pembulatan_header">Rp 0</span>
        </div>
    </div>

    <div class="row">
        <?php $totalpembulatan=0; $total_seluruh=0;?>
        <?php foreach($karyawans as $k){?>
        <div class="col-md-4">
            <div class="employee-box">
                <div class="employee-box-header">
                    <i class="fa fa-user-circle mr-2 text-primary"></i> <?php echo strtoupper($k['nama'])?>
                </div>
                <div class="employee-box-body">
                    <table class="payroll-table">
                        <thead>
                            <tr>
                                <th>DESKRIPSI ITEM</th>
                                <th class="text-right">NOMINAL (RP)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td>Senin</td><td class="text-amount"><?php echo number_format($k['senin'])?></td></tr>
                            <tr><td>Selasa</td><td class="text-amount"><?php echo number_format($k['selasa'])?></td></tr>
                            <tr><td>Rabu</td><td class="text-amount"><?php echo number_format($k['rabu'])?></td></tr>
                            <tr><td>Kamis</td><td class="text-amount"><?php echo number_format($k['kamis'])?></td></tr>
                            <tr><td>Jumat</td><td class="text-amount"><?php echo number_format($k['jumat'])?></td></tr>
                            <tr><td>Sabtu</td><td class="text-amount"><?php echo number_format($k['sabtu'])?></td></tr>
                            <tr><td>Minggu</td><td class="text-amount"><?php echo number_format($k['minggu'])?></td></tr>
                            <tr class="text-income"><td>Lembur</td><td class="text-amount">+ <?php echo number_format($k['lembur'])?></td></tr>
                            <tr class="text-income"><td>Insentif</td><td class="text-amount">+ <?php echo number_format($k['insentif'])?></td></tr>
                            <tr class="text-danger"><td>Pot. Claim</td><td class="text-amount">- <?php echo number_format($k['claim'])?></td></tr>
                            <tr class="text-danger"><td>Pot. Pinjaman</td><td class="text-amount">- <?php echo number_format($k['pinjaman'])?></td></tr>
                            <tr class="text-danger"><td>Pot. Warteg</td><td class="text-amount">- <?php echo number_format($k['warteg'])?></td></tr>
                            
                            <?php 
                                $sub = $k['senin']+$k['selasa']+$k['rabu']+$k['kamis']+$k['jumat']+$k['sabtu']+$k['minggu']+$k['lembur']+$k['insentif']-$k['claim']-$k['pinjaman']-$k['warteg'];
                                $grand = $sub;
                                if(isset($k['saving'])){
                                    $grand = $grand - $k['saving'] + $k['keluarkansaving'];
                                }
                                $pembulatan = pembulatangaji($grand);
                                $totalpembulatan += $pembulatan;
                                $total_seluruh += $grand;
                            ?>

                            <tr class="row-highlight">
                                <td>SUB TOTAL</td>
                                <td class="text-amount"><?php echo number_format($sub); ?></td>
                            </tr>
                            
                            <?php if(isset($k['saving'])){ ?>
                            <tr class="text-info"><td>Saving Minggu Ini</td><td class="text-amount">- <?php echo number_format($k['saving']) ?></td></tr>
                            <tr class="text-income"><td>Keluarkan Saving</td><td class="text-amount">+ <?php echo number_format($k['keluarkansaving']) ?></td></tr>
                            <?php } ?>

                            <tr class="row-total">
                                <td>GAJI DITERIMA</td>
                                <td class="text-right">Rp <?php echo number_format($pembulatan); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>

    <div class="row mt-4 no-print" style="margin-top: 20px; margin-bottom: 50px;">
        <div class="col-md-12">
            <a href="<?php echo $kembali?>" class="btn btn-default btn-modern"><i class="fa fa-arrow-left mr-2"></i> KEMBALI</a>
            <button class="btn btn-success btn-modern" onclick="excel()"><i class="fa fa-file-excel mr-2"></i> EXCEL</button>
            <?php 
                $segment = $this->uri->segment(2); 
                $pdf_url = BASEURL.'Gaji/'.$segment.'/'.$id.'?pdf=true';
            ?>
            <button class="btn btn-info btn-modern" onclick="showPdfModal('<?php echo $pdf_url ?>')"><i class="fa fa-file-pdf mr-2"></i> CETAK PDF</button>
        </div>
    </div>
</div>

<!-- Modal PDF Preview -->
<div class="modal fade" id="pdfModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" style="width: 95%;">
        <div class="modal-content" style="border-radius: 4px;">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                <h4 class="modal-title" style="font-weight: 700;"><i class="fa fa-file-pdf mr-2"></i> PREVIEW LAPORAN GAJI</h4>
            </div>
            <div class="modal-body" style="padding: 0; height: 75vh;">
                <div id="pdfLoading" style="display:flex; justify-content:center; align-items:center; height:100%;">
                    <div class="text-center">
                        <i class="fa fa-refresh fa-spin fa-3x text-primary"></i>
                        <p style="margin-top:10px; font-weight: 700;">Memuat Dokumen...</p>
                    </div>
                </div>
                <iframe id="pdfIframe" style="width: 100%; height: 100%; border: none; display:none;"></iframe>
            </div>
            <div class="modal-footer">
                <a id="pdfDownloadLink" href="<?php echo $pdf_url ?>" target="_blank" class="btn btn-success btn-flat">DOWNLOAD PDF</a>
                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">TUTUP</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    document.getElementById('total_pembulatan_header').innerText = 'Rp <?php echo number_format($totalpembulatan)?>';
    function excel(){
        url = window.location.href + (window.location.href.indexOf('?') >= 0 ? '&' : '?') + 'excel=1';
        location = url;
    }
    function showPdfModal(pdfUrl){
        $('#pdfLoading').show();
        $('#pdfIframe').hide();
        $('#pdfIframe').attr('src', pdfUrl);
        $('#pdfModal').modal('show');
        $('#pdfIframe').on('load', function(){
            $('#pdfLoading').hide();
            $('#pdfIframe').show();
        });
    }
    $('#pdfModal').on('hidden.bs.modal', function () {
        $('#pdfIframe').attr('src', '');
    });
</script>