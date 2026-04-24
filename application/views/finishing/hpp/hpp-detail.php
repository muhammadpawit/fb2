<style type="text/css">
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

    body {
        background-color: #f8fafc;
        font-family: 'Inter', sans-serif;
        color: #1e293b;
    }

    .hpp-wrapper {
        max-width: 1300px;
        margin: 20px auto;
        background: #fff;
        padding: 30px;
        border-radius: 4px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .header-table {
        width: 100%;
        border: 1px solid #e2e8f0;
        border-collapse: collapse;
        margin-bottom: 25px;
    }

    .header-table td {
        border: 1px solid #e2e8f0;
        padding: 10px 15px;
        vertical-align: top;
        font-size: 13px;
    }

    .header-title {
        background: #1e293b;
        color: #fff;
        text-align: center;
        padding: 15px !important;
        text-transform: uppercase;
        letter-spacing: 3px;
        font-weight: 700;
        font-size: 20px !important;
    }

    .label-cell {
        background: #f8fafc;
        font-weight: 600;
        color: #64748b;
        width: 120px;
    }

    .value-cell {
        font-weight: 500;
        color: #0f172a;
    }

    .spec-cell {
        background: #fff;
        font-size: 12px;
        line-height: 1.6;
    }

    .spec-cell b {
        display: block;
        margin-bottom: 5px;
        color: #1e293b;
        border-bottom: 1px solid #f1f5f9;
        padding-bottom: 2px;
    }

    .image-cell {
        text-align: center;
        background: #fff;
        width: 20%;
    }

    .image-container {
        position: relative;
        display: inline-block;
        max-width: 100%;
    }

    .image-cell img {
        max-width: 100%;
        height: auto;
        border-radius: 2px;
    }

    .main-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    .main-table th {
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        padding: 12px 10px;
        font-size: 12px;
        text-transform: uppercase;
        color: #475569;
        font-weight: 700;
        text-align: center;
    }

    .main-table td {
        border: 1px solid #e2e8f0;
        padding: 8px 12px;
        font-size: 13px;
    }

    .main-table tr:nth-child(even) {
        background: #fcfdfe;
    }

    .total-row {
        background: #f8fafc !important;
        font-weight: 700;
    }

    .grand-total {
        background: #1e293b !important;
        color: #fff;
        font-size: 16px;
    }

    .signature-section {
        margin-top: 40px;
        display: flex;
        justify-content: flex-end;
    }

    .signature-wrap {
        width: 250px;
        text-align: center;
    }

    .signature-wrap .date {
        font-size: 12px;
        margin-bottom: 10px;
        color: #64748b;
    }

    .signature-wrap .title {
        font-weight: 700;
        text-decoration: underline;
        margin-top: 60px;
        display: block;
    }

    .no-print { display: block; }
    .print-only { display: none; }

    @media print {
        body { background: #fff !important; }
        .hpp-wrapper { padding: 0; box-shadow: none; border: none; max-width: 100%; }
        .header-title { background: #000 !important; color: #fff !important; -webkit-print-color-adjust: exact; }
        .label-cell { background: #f0f0f0 !important; -webkit-print-color-adjust: exact; }
        .main-table th { background: #f0f0f0 !important; -webkit-print-color-adjust: exact; }
        .grand-total { background: #000 !important; color: #fff !important; -webkit-print-color-adjust: exact; }
        .no-print { display: none !important; }
        .print-only { display: block !important; }
    }

    /* Loader */
    .loader-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255,255,255,0.8);
        z-index: 10000;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        backdrop-filter: blur(2px);
    }
    .spinner-hpp {
        width: 50px;
        height: 50px;
        border: 5px solid #f3f3f3;
        border-top: 5px solid #1e293b;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin-bottom: 15px;
    }
    @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }

    /* Fullscreen Modal Override */
    .modal-fullscreen {
        width: 100% !important;
        max-width: 100% !important;
        height: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    .modal-fullscreen .modal-content {
        height: 100% !important;
        border-radius: 0 !important;
        border: none !important;
    }
    .modal-fullscreen .modal-body {
        height: calc(100vh - 120px) !important;
        overflow-y: auto;
    }

    .btn-edit-image {
        position: absolute;
        top: 5px;
        right: 5px;
        background: #1e293b;
        color: white;
        border-radius: 4px;
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid white;
        cursor: pointer;
        transition: all 0.2s;
        z-index: 10;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }

    .btn-edit-image:hover {
        background: #334155;
        transform: scale(1.1);
    }
</style>

<div class="loader-overlay" id="loadingHPP">
    <div class="spinner-hpp"></div>
    <div style="font-weight: 700; color: #1e293b; letter-spacing: 1px;">SEDANG MEMPROSES...</div>
</div>

<!-- Modal Ganti Gambar -->
<div class="modal fade" id="modalGantiGambar" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ganti Gambar PO</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="<?php echo BASEURL.'finishing/submitImageHppsat' ?>" enctype="multipart/form-data" method="POST" class="hpp-upload-form">
                <div class="modal-body">
                    <input type="file" name="gambarPO1" class="form-control" accept="image/*" required>
                    <input type="hidden" name="kode_po" value="<?php echo $po['kode_po'] ?>">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Start Page content -->

<div class="content">
    <div class="container-fluid">
        <div class="row no-print mt-3 mb-3">
            <div class="col-md-12">
                <a href="<?php echo $back ?>" class="btn btn-outline-danger btn-sm"><i class="fa fa-arrow-left"></i> Kembali</a>
            </div>
        </div>

        <div class="hpp-wrapper">
            <table class="header-table">
                <tr>
                    <td colspan="5" class="header-title">HPP <?php echo $jenis?></td>
                </tr>
                <tr>
                    <td class="label-cell">PO</td>
                    <td class="value-cell"><?php echo $po['nama_hpp'] ?></td>
                    <td rowspan="7" class="spec-cell" width="25%">
                        <b>Spesifikasi PO</b>
                        <?php if(!empty($spek)){ foreach($spek as $s){ echo $s['kolom'].' : '.$s['isi'].'<br>'; } } ?>
                    </td>
                    <td rowspan="7" class="image-cell" colspan="2">
                        <?php if(!empty($po['gambar_po'])){ ?>
                            <div class="image-container">
                                <button type="button" class="btn-edit-image no-print" data-toggle="modal" data-target="#modalGantiGambar" title="Ganti Gambar">
                                    <i class="fa fa-pencil"></i>
                                </button>
                                <img src="<?php echo (strpos($po['gambar_po'], 'data:image') === 0) ? $po['gambar_po'] : BASEURL.$po['gambar_po'] ?>">
                            </div>
                        <?php } else { ?>
                            <form action="<?php echo BASEURL.'finishing/submitImageHppsat' ?>" enctype="multipart/form-data" method="POST" class="no-print hpp-upload-form">
                                <input type="file" name="gambarPO1" class="form-control form-control-sm" accept="image/*">
                                <input type="hidden" name="kode_po" value="<?php echo $po['kode_po'] ?>">
                                <button type="submit" class="btn btn-xs btn-warning mt-1 w-100">UPLOAD GAMBAR</button>
                            </form>
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td class="label-cell">JENIS</td>
                    <td class="value-cell"><?php echo $po['jenis_po'] ?? '-' ?></td>
                </tr>
                <tr>
                    <td class="label-cell">SIZE</td>
                    <td class="value-cell"><?php echo $pot['size_potongan'] ?? '-' ?></td>
                </tr>
                <tr>
                    <td class="label-cell">BAHAN</td>
                    <td class="value-cell"><?php echo $namabahan['nama_item_keluar'] ?? '-' ?></td>
                </tr>
                <tr>
                    <td class="label-cell">TIM POTONG</td>
                    <td class="value-cell"><?php echo strtoupper($timpotong ?? '-') ?></td>
                </tr>
                <tr>
                    <td class="label-cell">JUMLAH PO</td>
                    <td class="value-cell">
                        <?php echo isset($pot['hasil_pieces_potongan']) ? $pot['hasil_pieces_potongan'] : 0 ?> PCS / 
                        <?php echo isset($pot['hasil_lusinan_potongan']) ? $pot['hasil_lusinan_potongan'] : 0 ?> DZ
                    </td>
                </tr>
                <tr>
                    <td class="label-cell">CMT JAHIT</td>
                    <td class="value-cell"><?php echo strtoupper($namacmt ?? '-') ?></td>
                </tr>
            </table>

            <table class="main-table">
                <thead>
                            <tr>
                                <th width="50">No</th>
                                <th>Perincian Biaya</th>
                                <th width="150">Keterangan</th>
                                <th width="150">Harga (RP)</th>
                                <th width="180">Jumlah (RP)</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php $no=0;$resiko = 0;$total = 0; $totalAlat = 0; if (isset($bahan)): ?>

                            <?php foreach ($bahan as $key => $bahanAja): ?>

                                <?php if ($bahanAja['bahan_kategori'] == "UTAMA"){ ?>

                                <tr>
                                	                                    <td class="text-center"><?php echo $no+=1?></td>
                                    <td>

                                        BAHAN <?php echo $bahanAja['bahan_kategori'] ?>

                                    </td>

                                    <td class="text-center">

                                        <?php echo $bukupotongan['jumlah_pemakaian_bahan_utama'] ?>

                                    </td>

                                                                        <td class="text-center">

                                        <?php echo number_format($bahanAja['harga_item']) ?>

                                    </td>

                                                                        <td class="text-right"><?php echo number_format($bahanAja['harga_item'] * $bukupotongan['jumlah_pemakaian_bahan_utama']); ?></td>

                                    <?php 

                                    $totalAlat +=($bahanAja['harga_item'] * $bukupotongan['jumlah_pemakaian_bahan_utama']); 

                                    ?>

                                </tr>

                                

                                <?php } else if($bahanAja['bahan_kategori'] == "CELANA"){ ?>



                                <tr>
                                	                                    <td class="text-center"><?php echo $no+=1?></td>
                                    <td>

                                        BAHAN <?php echo $bahanAja['bahan_kategori'] ?>

                                    </td>

                                    <td class="text-center">

                                        <?php echo $bukupotongan['jumlah_pemakaian_bahan_variasi'] ?>

                                    </td>

                                                                        <td class="text-center">

                                        <?php echo number_format($bahanAja['harga_item']) ?>

                                    </td>

                                    <td align="right">

                                        <?php echo number_format($bahanAja['harga_item'] * $bukupotongan['jumlah_pemakaian_bahan_variasi']); ?>

                                    </td>

                                    <?php 

                                    $totalAlat += ($bahanAja['harga_item'] * $bukupotongan['jumlah_pemakaian_bahan_variasi']); 

                                    ?>

                                </tr>



                                <?php } else if($bahanAja['bahan_kategori'] == "KAINKANTONG") { ?> 

                                <tr>
                                	                                    <td class="text-center"><?php echo $no+=1?></td>
                                    <td>

                                        <?php echo str_replace("KAINKANTONG","KAIN - KANTONG",$bahanKantong['bahan_kategori']) ?>

                                    </td>

                                    <td class="text-center">

                                        <?php echo $bahanKantong['ukuran_item_keluar'] ?>

                                    </td>

                                                                        <td class="text-center">

                                        <?php echo number_format($bahanKantong['harga_item']) ?>

                                    </td>

                                    <td align="right">

                                        <?php echo number_format($bahanKantong['harga_item'] * $bahanKantong['ukuran_item_keluar']); ?>

                                    </td>

                                    <?php 

                                    $totalAlat += ($bahanKantong['harga_item'] * $bahanKantong['ukuran_item_keluar']); 

                                    ?>

                                </tr> 

                                <?php } ?>

                            <?php endforeach ?>
                            
                            <?php if(!empty($variasi)){?>
                                <tr>
                                    <td><?php echo $no+=1?></td>
                                    <td>

                                        BAHAN <?php echo $variasi['bahan_kategori'] ?>

                                    </td>

                                    <td class="text-center">

                                        <?php echo $variasi['ukuran_item_keluar'] ?>

                                    </td>

                                                                        <td class="text-center">

                                        <?php echo number_format($variasi['harga_item']) ?>

                                    </td>

                                    <td align="right">

                                        <?php echo number_format($variasi['harga_item'] * $variasi['ukuran_item_keluar']); ?>

                                    </td>

                                    <?php 

                                    $totalAlat += ($variasi['harga_item'] * $variasi['ukuran_item_keluar']); 

                                    ?>

                                </tr> 
                            <?php } ?>

                        <?php endif ?>



                            <?php if (isset($master_harga_potongan)): ?>

                                <tr>
                                	                                    <td class="text-center"><?php echo $no+=1?></td>
                                    <td>

                                        ONGKOS POTONG

                                    </td>

                                    <td class="text-center">

                                        12

                                    </td>

                                                                        <td class="text-center">

                                        <?php echo number_format($master_harga_potongan['harga_potongan']) ?>

                                    </td>

                                    <td align="right">

                                        <?php echo number_format($master_harga_potongan['harga_potongan'] * 12); ?>

                                    </td>

                                    <?php 

                                    $totalAlat += ($master_harga_potongan['harga_potongan'] * 12); 

                                    ?>

                                </tr>

                            <?php endif ?>



                                <?php $bordirHitung = 0; ?>

                                <?php $explodeSize = explode('-', $bukupotongan['size_potongan']); ?>

                                <?php foreach ($cmt as $key => $cmtt): ?>

                                    <tr>
                                                                            <td class="text-center"><?php echo $no+=1?></td>

                                        <td>
                                            <?php if($cmtt['kategori_cmt']=='JAHIT'){?>
                                                <?php echo $cmtt['kategori_cmt'] ?> : <?php echo strtoupper($cmtt['nama_cmt']) //echo strtoupper($produk['nama_cmt']) ?>
                                            <?php }else if($cmtt['kategori_cmt']=='BORDIR'){ ?>
                                                <?php if($produk['nama_po']=="PFK"){?>
                                                <?php echo $cmtt['kategori_cmt'] ?> : LUAR
                                                <?php }else{?>
                                                    <?php echo $cmtt['kategori_cmt'] ?> : DALAM
                                                <?php } ?>
                                            <?php }else{ ?>
                                                <?php if($cmtt['kategori_cmt']=='SABLON'){?>
                                                <?php echo $cmtt['kategori_cmt'] ?> : <?php echo $cmtt['id_master_cmt']>0?strtoupper($cmtt['nama_cmt']):' '; ?>
                                            <?php }?>
                                            <?php } ?>
                                            
                                        </td>

                                        <td></td>

                                        <td></td>

                                        <?php //if (isset($bordirer)){ ?>

                                            <?php if ($cmtt['kategori_cmt'] == "BORDIR"){ ?>


                                                
                                                <?php foreach ($bordirer as $key => $hasilBordir): ?>
                                                    <?php 
                                                        //$bordirHitung += $hasilBordir['total_tarif']; rumus lama
                                                        $bordirHitung += ($hasilBordir['total_stich']*0.18); // rumus baru
                                                    ?> 
                                                     

                                                <?php endforeach ?>
                                           
                                                <?php $totalAlat += $bordirHitung / $bukupotongan['hasil_lusinan_potongan']; ?>
                                            <td align="right">
                                                
                                                        <?php echo number_format($bordirHitung / $bukupotongan['hasil_lusinan_potongan']) ; ?>
                                            </td>



                                            <?php } else if($cmtt['kategori_cmt'] == "SABLON") { ?>

                                                <?php //if($produk['kode_po']=="SWF01" OR $produk['kode_po']=="FBS05" OR $produk['kode_po']=="FBS03" OR $produk['kode_po']=="FBO03" OR $produk['kode_po']=="HGSO03"){ // po if ?>
                                                <?php //if($cmtt['id_master_cmt_job']>=81){?>
                                                    <?php $totalAlat +=($cmtt['cmt_job_price']+$bawahansablon);  ?>
                                                    <td align="right"><?php echo number_format($cmtt['cmt_job_price']+$bawahansablon); ?></td>

                                                <?php //} else{?> 
                                                    <?php 
                                                        /*
                                                         if($cmtt['cmt_job_price']<=25000){
                                                            $totalAlat +=25000; 
                                                         }else{
                                                            $totalAlat +=($cmtt['cmt_job_price']);    
                                                         }
                                                         */
                                                         //$totalAlat +=25000; 

                                                         ?>   
                                                        <!--
                                                        <td>
                                                            <?php //echo number_format(25000); ?>   
                                                            <?php if($cmtt['cmt_job_price']<=25000){
                                                                //echo number_format(25000);
                                                            }else{
                                                                //echo number_format($cmtt['cmt_job_price']);
                                                            }?>
                                                            <?php //echo number_format($cmtt['cmt_job_price']); ?>   

                                                        </td>-->
                                                    <?php //} // end po if ?>

                                            <?php } else { ?>



                                             <?php 

                                             $totalAlat +=($cmtt['cmt_job_price']); 

                                             ?>   

                                            <td align="right">
                                                <?php echo number_format($cmtt['cmt_job_price']); ?>   

                                            </td>



                                            <?php } ?>

                                        <?php //} ?>

                                    </tr>

                                <?php endforeach ?>



                                <?php $rinciItem = 0;$rinciCmt=0; ?>

                                <?php foreach ($perincian as $key => $rinci): ?>

                                    <?php $explodeBordir = explode(' ', $rinci['nama_item_keluar']); ?>

                                    <?php if (strtoupper($rinci['nama_item_keluar']) == "KARET 555A" OR strtoupper($rinci['nama_item_keluar']) == "SIMULASI KARET 555A") {?>

                                    <tr>
                                                                            <td class="text-center"><?php echo $no+=1?></td>
                                        <td>

                                            <?php echo $rinci['nama_item_keluar'] ?>

                                        </td>

                                        <td class="text-center">

                                            <?php echo $rinci['jumlah_item_perlusin'] ?> 

                                        </td>

                                        <td>

                                            (<?php echo $rinci['harga_item'].' Roll) ('.round($rinci['harga_item'] / 48,1) ?> Pcs)

                                        </td>

                                        <?php 

                                        $total += ($rinci['harga_item'] / 48) * $rinci['jumlah_item_perlusin']; 

                                        ?>

                                        <td align="right">

                                            <?php echo number_format(($rinci['harga_item'] / 48) * $rinci['jumlah_item_perlusin']) ?>

                                        </td>

                                    </tr>

                                <?php } elseif (strtoupper($rinci['nama_item_keluar']) == "KARET 11A") {?>

                                    <tr>
                                                                            <td class="text-center"><?php echo $no+=1?></td>

                                        <td>

                                            <?php echo $rinci['nama_item_keluar'] ?>

                                        </td>

                                        <td class="text-center">

                                            <?php echo $rinci['jumlah_item_perlusin'] ?>

                                        </td>

                                                                            <td class="text-center">

                                            (<?php echo $rinci['harga_item'].' Roll) ('.round($rinci['harga_item'] / 72,1) ?> Pcs)

                                        </td>

                                        <?php 

                                        $total += ($rinci['harga_item'] / 72) * $rinci['jumlah_item_perlusin']; 

                                        ?>

                                        <td align="right">

                                            <?php echo number_format(($rinci['harga_item'] / 72) * $rinci['jumlah_item_perlusin']) ?>

                                        </td>

                                    </tr>

                                    <?php  } elseif (strtoupper($rinci['nama_item_keluar']) == "PITA" OR strtoupper($rinci['nama_item_keluar']) == "SIMULASI PITA" ) {?>

                                    <tr>
                                                                            <td class="text-center"><?php echo $no+=1?></td>
                                        <td>

                                            <?php echo $rinci['nama_item_keluar'] ?>

                                        </td>

                                        <td class="text-center">

                                            <?php echo $rinci['jumlah_item_perlusin'] ?>

                                        </td>

                                                                            <td class="text-center">

                                            (<?php echo $rinci['harga_item'].' Roll) ('.round( ($rinci['jumlah_item_keluar']*$rinci['harga_item'])  / $pot['hasil_lusinan_potongan']) ?> Pcs)

                                        </td>

                                        

                                        <?php 
                                            $hargapita=2000;
                                            
                                        $total += $hargapita; 

                                        ?>

                                        <td align="right">

                                            <?php echo number_format($hargapita) ?>

                                        </td>

                                    </tr>

                                   <?php  } elseif (strtoupper($rinci['nama_item_keluar']) == "LABEL 108") { ?>

                                    <tr>
                                                                            <td class="text-center"><?php echo $no+=1?></td>

                                        <td>

                                            <?php echo $rinci['nama_item_keluar'] ?>

                                        </td>

                                        <td class="text-center">

                                            <?php echo $rinci['jumlah_item_perlusin'] ?>

                                        </td>

                                                                            <td class="text-center">

                                            <?php echo $rinci['harga_item'] ?> 

                                        </td>

                                        <?php 

                                        $total += $rinci['harga_item'] * $rinci['jumlah_item_perlusin']; 

                                        ?>

                                        <td align="right">

                                            <?php echo number_format(($rinci['harga_item']) * $rinci['jumlah_item_perlusin']) ?>

                                        </td>

                                    </tr>

                                    <?php  } elseif (strtolower($explodeBordir[1]) == "bordir") {  ;?>

                                    <tr>

                                                                            <td class="text-center"><?php echo $no+=1?></td>

                                        <td>

                                            <?php echo $rinci['nama_item_keluar'] ?>

                                        </td>

                                        <td class="text-center">

                                            <?php echo $rinci['jumlah_item_perlusin'] ?>

                                        </td>

                                                                            <td class="text-center">

                                            (<?php echo $rinci['harga_item'].' Roll) ('.round($rinci['jumlah_item_keluar']*$rinci['harga_item'] / $pot['hasil_lusinan_potongan']) ?> Pcs)

                                        </td>

                                        <?php 
                                            $hargasizebordir=1000;
                                        $total += $hargasizebordir=1000;; 

                                        ?>

                                        <td align="right">

                                            <?php echo number_format($hargasizebordir) ?>

                                        </td>

                                    </tr> 

                                    

                                   <?php  } elseif (strtolower($rinci['nama_item_keluar']) == "simulasi size bordir" OR strtolower($rinci['nama_item_keluar']) == "size bordir") {  ;?>

                                                <tr>

                                                                                        <td class="text-center"><?php echo $no+=1?></td>

                                                    <td>

                                                        <?php echo $rinci['nama_item_keluar'] ?>

                                                    </td>

                                                    <td class="text-center">

                                                        <?php echo $rinci['jumlah_item_perlusin'] ?>

                                                    </td>

                                                                                        <td class="text-center">

                                                        (<?php echo $rinci['harga_item'].' Roll) ('.round($rinci['jumlah_item_keluar']*$rinci['harga_item'] / $pot['hasil_lusinan_potongan']) ?> Pcs)

                                                    </td>

                                                    <?php 
                                                        $hargasizebordir=1000;
                                                    $total += $hargasizebordir=1000;; 

                                                    ?>

                                                    <td align="right">

                                                        <?php echo number_format($hargasizebordir) ?>

                                                    </td>

                                                </tr> 



                                                <?php  } else { ?>

                                    <tr>

                                                                            <td class="text-center"><?php echo $no+=1?></td>

                                        <td>

                                            <?php echo $rinci['nama_item_keluar'] ?>

                                        </td>

                                        <td class="text-center">

                                            <?php echo $rinci['jumlah_item_perlusin'] ?>

                                        </td>

                                                                            <td class="text-center">

                                            <?php echo $rinci['harga_item'] ?>

                                        </td>

                                        <?php 

                                        $total += $rinci['jumlah_item_perlusin'] * $rinci['harga_item']; 

                                        ?>

                                        <td align="right">

                                            <?php echo number_format($rinci['jumlah_item_perlusin'] * $rinci['harga_item']) ?>

                                        </td>

                                    </tr>

                                    <?php } ?>

                                <?php $rinciItem += $rinci['jumlah_item_keluar'] * $rinci['harga_item']; ?>

                                <?php endforeach ?>
                                <?php $hargapertitik=0;?>
                                <?php foreach ($boronganmesin as $key => $mesin): ?>
                                    <?php 
                                        $hargapertitik=$mesin['harga_titik'];
                                        if(strtolower($produk['nama_po'])=="kfb" OR strtolower($produk['nama_po'])=="kkf" OR strtolower($produk['nama_po'])=="skf"
                                        OR strtolower($produk['nama_po'])=="ksf"
                                        ){
                                            $hargapertitik=30;
                                        }
                                    ?>
                                    <tr>

                                                                            <td class="text-center"><?php echo $no+=1?></td>

                                        <td><?php echo strtoupper((empty($mesin['keterangan']))?$mesin['kategori']:$mesin['kategori']) ?></td>

                                        <td class="text-center"><?php echo $mesin['jumlah_titik']*12 ?></td>

                                                                            <td class="text-center"><?php echo $hargapertitik ?></td>

                                        <td align="right"><?php echo number_format(($mesin['jumlah_titik']*12)*$hargapertitik) ?></td>

                                    </tr>

                                    <?php
                                        $total+=($mesin['jumlah_titik']*12)*$hargapertitik;
                                    ?>

                                <?php endforeach ?>

                                <?php foreach ($buangbenang as $key => $mesin): ?>

                                    <tr>

                                                                            <td class="text-center"><?php echo $no+=1?></td>

                                        <td><?php echo strtoupper((empty($mesin['keterangan']))?"Buang Benang":'Buang Benang') ?></td>

                                        <td class="text-center"><?php //echo $mesin['jumlah_pcs'] ?></td>

                                                                            <td class="text-center"><?php echo $mesin['harga'] ?></td>

                                        <td align="right"><?php echo number_format(($mesin['harga']*12)) ?></td>

                                    </tr>

                                    <?php
                                        $total+=($mesin['harga']*12);
                                    ?>

                                <?php endforeach ?>

                                <?php foreach ($packing as $key => $mesin): ?>

                                    <tr>

                                                                            <td class="text-center"><?php echo $no+=1?></td>

                                        <td><?php echo strtoupper((empty($mesin['keterangan']))?"Packing":$mesin['keterangan']) ?></td>

                                        <td class="text-center"><?php //echo $mesin['jumlah_pcs'] ?></td>

                                                                            <td class="text-center"><?php echo number_format( $mesin['harga_dz']/12,0) ?></td>

                                        <td align="right"><?php echo number_format($mesin['harga_dz']) ?></td>

                                    </tr>

                                    <?php
                                        $total+=($mesin['harga_dz']);
                                    ?>

                                <?php endforeach ?>

                                <?php foreach ($cucian as $key => $mesin): ?>
                                    <?php 
                                        //$harga=$mesin['harga'];
                                        //$harga=1000;
                                        $harga=$cucianhpp['cucianhpp'];
                                        /*
                                        if($produk['nama_po']=="KSK"){
                                            $harga=1000;
                                        }*/

                                    ?>

                                    <tr>

                                                                            <td class="text-center"><?php echo $no+=1?></td>

                                        <td><?php echo strtoupper((empty($mesin['keterangan']))?"cucian":'cucian') ?></td>

                                        <td class="text-center"><?php //echo $mesin['jumlah_pcs'] ?></td>

                                                                            <td class="text-center"><?php echo number_format($harga) ?></td>

                                        <td align="right"><?php echo number_format(($harga*12)) ?></td>

                                    </tr>

                                    <?php
                                        $total+=($harga*12);
                                    ?>

                                <?php endforeach ?>

                                <?php if(is_array($biayalain)){?>

                                    <?php foreach($biayalain as $b){?>

                                        <tr>

                                                                                <td class="text-center"><?php echo $no+=1?></td>

                                            <td><?php echo $b['namabiaya'] ?></td>

                                            <td class="text-center"><?php //echo $mesin['jumlah_pcs'] ?></td>

                                                                                <td class="text-center"><?php echo number_format($b['biaya']) ?></td>

                                            <td align="right"><?php echo number_format($b['biaya']) ?></td>

                                        </tr>

                                    <?php
                                        $total+=($b['biaya']);
                                    ?>

                                    <?php } ?>

                                <?php } ?>

                                <?php if(is_array($biayaperpo)){?>

                                    <?php foreach($biayaperpo as $b){?>

                                        <tr>

                                                                                <td class="text-center"><?php echo $no+=1?></td>

                                            <td><?php echo $b['nama_biaya'] ?></td>

                                            <td class="text-center">12<?php //echo $mesin['jumlah_pcs'] ?></td>

                                                                                <td class="text-center"><?php echo number_format($b['nominal']) ?></td>

                                            <td align="right"><?php echo number_format($b['nominal']) ?></td>

                                        </tr>

                                    <?php
                                        $total+=($b['nominal']);
                                    ?>

                                    <?php } ?>

                                    <?php } ?>


                        <tr style="background: #f8f9fa; font-weight: bold;">
                            <td colspan="4" class="text-right">TOTAL BIAYA PRODUKSI</td>
                            <td class="text-right">
                                <?php  
                                $totalHPP = $total + $totalAlat;
                                echo 'Rp ' . number_format($total + $totalAlat); 
                                ?>
                            </td>
                        </tr>

                        <tr style="background: #f1f5f9;">
                            <td colspan="4" class="text-right" style="vertical-align: middle; font-weight: 600; color: #475569;">BIAYA OPERASIONAL</td>
                            <td>
                                <form action="<?php echo BASEURL.'finishing/submitOperational' ?>" method="post" class="hpp-upload-form">
                                    <div class="input-group input-group-sm">
                                        <div class="print-only text-right w-100" style="font-weight: bold; padding: 5px;">
                                            <?php 
                                            // Prioritaskan nilai dari database (operaitonal_price)
                                            $opr = isset($po['operaitonal_price']) ? $po['operaitonal_price'] : 0;
                                            
                                            // Jika di DB masih 0, baru coba hitung dari selisih master harga (opsional/logic lama)
                                            if ($opr == 0 && isset($masterharga['hargahpp']) && $masterharga['hargahpp'] > 0) {
                                                $opr = $masterharga['hargahpp'] - $totalHPP;
                                            }
                                            
                                            echo 'Rp '.number_format($opr);
                                            ?>
                                        </div>
                                        <input type="number" class="form-control no-print text-right" name="valOperation" id="valOperation" value="<?php echo $opr ?? 0 ?>" style="font-weight: bold; border-color: #cbd5e1; color: #1e293b;">
                                        <input type="hidden" value="<?php echo $po['kode_po'] ?>" name="kode_po">
                                        <div class="input-group-append no-print">
                                            <button class="btn btn-dark" type="submit" name="button">UPDATE</button>
                                        </div>
                                    </div>
                                </form>
                            </td>
                        </tr>

                        <tr class="grand-total" style="font-size: 18px;">
                            <td colspan="4" class="text-right">GRAND TOTAL HPP (LUSIN)</td>
                            <td id="grandTotal" class="text-right">
                                Rp <?php 
                                    // Hitung Grand Total dari Total HPP + Operasional (agar sinkron)
                                    $grand = $totalHPP + $opr; 
                                    echo number_format($grand);?> 
                            </td>
                        </tr>

                        <tr style="background: #334155; color: white; font-weight: 700;">
                            <td colspan="4" class="text-right">HARGA PER PCS</td>
                            <td id="hargaPCS" class="text-right">
                                Rp <?php echo number_format($grand / 12) ?>
                            </td>
                        </tr>
                    </tbody>
                </table>

        <div class="signature-section">
            <div class="signature-wrap">
                <div class="date">TANGGAL : <?php echo strtoupper(date('d F Y')) ?></div>
                <div class="date">PARAF PERSETUJUAN / ACC PIMPINAN</div>
                <div style="height: 80px;"></div>
                <span class="title">( H.RICKO WENDRA )</span>
                <div style="font-size: 10px; color: #cbd5e1; margin-top: 15px; font-style: italic;">Registered by Forboys Production System</div>
            </div>
        </div>

        <div class="no-print mt-5 mb-5 text-center">
            <button type="button" class="btn btn-primary btn-lg px-5 shadow-sm" data-toggle="modal" data-target="#modalCetak">
                <i class="fa fa-print"></i> CETAK LAPORAN HPP
            </button>
        </div>

        <!-- Modal Cetak -->
        <div class="modal fade" id="modalCetak" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document" style="max-width: 450px; margin-top: 100px;">
                <div class="modal-content" style="border-radius: 8px; border: none; box-shadow: 0 15px 50px rgba(0,0,0,0.2);">
                    <div class="modal-header" style="background: #1e293b; color: white; border-radius: 8px 8px 0 0; padding: 20px;">
                        <h4 class="modal-title" style="font-weight: 700; font-size: 18px; text-transform: uppercase; letter-spacing: 1px;">Opsi Cetak Laporan</h4>
                        <button type="button" class="close" data-dismiss="modal" style="color: white; opacity: 0.8;">&times;</button>
                    </div>
                    <div class="modal-body text-center" style="padding: 25px;">
                        <!-- Pemilihan Cetak -->
                        <div id="pilihanCetak">
                            <div style="background: #f8fafc; padding: 20px; border-radius: 6px; border: 1px dashed #cbd5e1; margin-bottom: 25px;">
                                <div style="font-size: 12px; color: #64748b; text-transform: uppercase; margin-bottom: 5px;">HPP Produksi</div>
                                <div style="font-size: 18px; font-weight: 800; color: #1e293b;"><?php echo $po['nama_hpp'] ?></div>
                                <div style="font-size: 14px; color: #475569; margin-top: 5px; font-weight: 600;">Grand Total: Rp <?php echo number_format($grand) ?></div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <button onclick="printsubmit()" class="btn btn-outline-dark btn-block" style="padding: 12px; font-weight: 700;">
                                        <i class="fa fa-print fa-2x d-block mb-2"></i> PRINTER
                                    </button>
                                </div>
                                <div class="col-6">
                                    <button onclick="showPDF()" class="btn btn-outline-info btn-block" style="padding: 12px; font-weight: 700;">
                                        <i class="fa fa-file-pdf-o fa-2x d-block mb-2"></i> LIHAT PDF
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Preview PDF (Hidden by default) -->
                        <div id="previewPDF" style="display: none;">
                            <div class="mb-3 text-left">
                                <button onclick="hidePDF()" class="btn btn-sm btn-secondary"><i class="fa fa-arrow-left"></i> Kembali</button>
                                <a href="<?php echo $pdf ?>" target="_blank" class="btn btn-sm btn-info pull-right"><i class="fa fa-download"></i> Download</a>
                            </div>
                            <iframe src="" id="pdfFrame" style="width: 100%; height: 500px; border: 1px solid #ddd; border-radius: 4px;"></iframe>
                        </div>
                    </div>
                    <div class="modal-footer" style="padding: 15px; border-top: 1px solid #f1f5f9; background: #fbfbfb; border-radius: 0 0 8px 8px;">
                        <button type="button" class="btn btn-link btn-sm text-muted" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        <form action="<?php echo BASEURL.'finishing/hppproduksidetailAct' ?>" method="POST" id="submit" style="display:none;">
            <input type="hidden" name="hargasatuan" value="<?php echo ($grand / 12) ?>">
            <input type="hidden" name="kodepo" value="<?php echo $po['kode_po'] ?>">
        </form>
    </div>
</div>

<script type="text/javascript">

$( document ).ready(function() {

    $( "#valOperation" ).keyup(function() {

        var value = $(this).val();

        var tambah = (parseInt(<?php echo round($totalHPP) ?>)+parseInt(value));

        $('#grandTotal').text(tambah);

        $('#hargaPCS').text(new Intl.NumberFormat('en-IN', { maximumSignificantDigits: 3 }).format(Math.round(tambah/12)));

    });

});

function showPDF() {
    $('#pilihanCetak').hide();
    $('#previewPDF').show();
    $('#modalCetak .modal-dialog').addClass('modal-fullscreen');
    $('#pdfFrame').attr('src', '<?php echo $pdf ?>');
    $('#pdfFrame').css('height', '88vh');
}

function hidePDF() {
    $('#previewPDF').hide();
    $('#pilihanCetak').show();
    $('#modalCetak .modal-dialog').removeClass('modal-fullscreen');
    $('#modalCetak .modal-dialog').attr('style', 'max-width: 450px; margin: 100px auto;');
    $('#pdfFrame').attr('src', '');
}

function printsubmit(){
        window.print();
    $("#submit").submit();
}

$('.hpp-upload-form').on('submit', function() {
    $('#loadingHPP').css('display', 'flex');
});

</script>