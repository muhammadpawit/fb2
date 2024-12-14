<html>
    <title><?php echo $title ?></title>
    <head>
        <style>
            body{
                font-family: Verdana, Geneva, Tahoma, sans-serif;
            }
            .header {
                text-align: center; font-family: Arial, sans-serif; font-size: 12pt; margin-bottom: 20px;
            }

            .break {
                page-break-after: always;
            }

            .subtitle table {
                width: 35%;
            }

            .body {
                margin-top:12pt;
            }

            div.body table, 
            div.body thead th, 
            div.body td {
                font-size: 10pt !important;
                padding:3pt;
            }
            

            div.lampiran{
                font-size: inherit;
            }

            .ttd {
                margin-top:10pt;
                float: right;
            }

            div.ttd table {
                text-align: right;
            }

            .label {
                font-weight: bold;
                margin-bottom: 5pt;
            }


           /* Membungkus kedua kolom dalam container */
            .content-wrapper {
                width: 100%;
                display: block; /* Memastikan container mengisi seluruh lebar */
                margin: 15pt 0px 0px 0px;
            }

            /* Menyusun content kiri dan kanan secara berdampingan */
            .content-kiri, .content-kanan {
                display: inline-block;
                vertical-align: top;
                width: 48%; /* Kolom kiri dan kanan */
                margin-right: 1%; /* Memberikan jarak antara kedua kolom */
            }

            .content-kiri table, .content-kanan table {
                width: 100%;
                border-collapse: collapse;
            }

            .content-kiri td, .content-kanan td, .content-kiri th, .content-kanan th {
                font-size: 10pt;
                padding: 3pt;
                border: 1px solid black;
            }

            .form-group{
                margin-bottom: 20pt;
            }

            .rekening-info {
                margin-top:10pt;
                float:left;
                margin-left: 5pt;
                padding: 20pt;
            }


        </style>
    </head>
    <body>
    


    <div class="title">
        <center>
            <h3>PEMBAYARAN UPAH JAHIT PO KAOS & KEMEJA<br>
            Periode : <?php echo $detail['keterangan'] ?>
            </h3>
        </center>
    </div>
    <div class="subtitle">
        <table>
            <tr>
                <td>Nama CMT</td>
                <td>:</td>
                <td><?php echo ucwords(strtolower($namacmt))?></td>
            </tr>
            <tr>
                <td>Periode Pembayaran</td>
                <td>:</td>
                <td><?php echo format_tanggal($detail['tanggal']) ?></td>
            </tr>
        </table>
    </div>

    <div class="body">
        <table border="1" style="border-collapse: collapse;width: 100%">
            <thead>
                <tr>
                    <th rowspan="2" style="vertical-align : middle;text-align:center;">No</th>
                    <th rowspan="2" style="vertical-align : middle;text-align:center;">Rincian PO</th>
                    <th colspan="2" style="vertical-align : middle;text-align:center;">Potongan PO</th>
                    <th colspan="2" style="vertical-align : middle;text-align:center;">Jumlah PO</th>
                    <th colspan="2" style="vertical-align : middle;text-align:center;">Jumlah Setor PO</th>
                    <th rowspan="2" style="vertical-align : middle;text-align:center;">Harga/Dz (Rp)</th>
                    <th rowspan="2" style="vertical-align : middle;text-align:center;">Total (Rp)</th>
                    <th rowspan="2" style="vertical-align : middle;text-align:center;">Keterangan</th>
                </tr>
                <tr style="vertical-align : middle;text-align:center;">
                    <td>Dz</td>
                    <td>Pcs</td>
                    <td>Dz</td>
                    <td>Pcs</td>
                    <td>Dz</td>
                    <td>Pcs</td>
                </tr>
            </thead>
            <tbody>
            <?php $n=1;$jmlpodz=0;$jmlpopcs=0;$jmldz=0;$jmlpcs=0;$total=0;$potongan=0;?>
                <?php foreach($products as $p){?>
                    <?php
                        $potongan+=($p['potongan']);
                        $jmlpodz+=($p['jumlah_po_dz']);
                        $jmlpopcs+=($p['jumlah_po_pcs']);
                        $jmldz+=($p['jumlah_dz']);
                        $jmlpcs+=($p['jumlah_pcs']);
                        //$total+=($p['jumlah_dz']*$p['harga']);
                        $total+=($p['total']-$p['potpertama']);
                    ?>
                    <tr>
                        <td align="center"><?php echo $n++?></td>
                        <td><?php echo strtoupper($p['kode_po'])?></td>
                        <td align="center"><?php echo number_format(($p['potongan']/12),2)?></td>
                        <td align="center"><?php echo $p['potongan']?></td>
                        <td align="center"><?php echo number_format($p['jumlah_po_dz'],2)?></td>
                        <td align="center"><?php echo $p['jumlah_po_pcs']?></td>
                        <td align="center"><?php echo number_format($p['jumlah_dz'],2)?></td>
                        <td align="center"><?php echo $p['jumlah_pcs']?></td>
                        <td align="center"><?php echo number_format($p['harga'])?></td>
                        <td align="center"><?php echo number_format($p['total']-$p['potpertama'])?></td>
                        <td style="background-color: <?php echo strtolower($p['keterangan'])=='pembayaran 80 %' ? 'yellow':'#5cfaa1' ?>;">
                            <?php echo strtolower($p['keterangan'])?>
                        </td>
                    </tr>
                <?php }?>
                <?php
                    // Hitung jumlah baris kosong yang perlu ditambahkan
                    $jumlahProduk = count($products);
                    $barisKosong = max(10 - $jumlahProduk, 0); // Pastikan jumlah baris kosong tidak negatif
                ?>
                <?php for ($j = 0; $j < $barisKosong; $j++) { ?>
                        <tr>
                            <td>&nbsp;</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?php } ?>
            </tbody>
            <tfoot>
                <tr style="background-color: #ffb0f3">
                    <td colspan="2" align="center"><b>Total</b></td>
                    <td align="center"><b><?php echo number_format(($potongan/12),2)?></b></td>
                    <td align="center"><b><?php echo $potongan?></b></td>
                    <td align="center"><b><?php echo $jmlpodz?></b></td>
                    <td align="center"><b><?php echo $jmlpopcs?></b></td>
                    <td align="center"><b><?php echo $jmldz?></b></td>
                    <td align="center"><b><?php echo $jmlpcs?></b></td>
                    <td></td>
                    <td align="center"><b><?php echo number_format($total)?></b></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="9" align="center"><b>Pengembalian Bangke</b></td>
                    <td align="center"><b><?php echo number_format($detail['pengembalian_bangke'])?></b></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="9" align="center"><b>Potongan Bangke</b></td>
                    <td align="center"><b><?php echo number_format($detail['potongan_bangke'])?></b></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="9" align="center"><b>Potongan Alat</b></td>
                    <td align="center"><b><?php echo number_format($detail['potongan_alat'])?></b></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="9" align="center"><b>Potongan Mesin</b></td>
                    <td align="center"><b><?php echo number_format($detail['potongan_mesin'])?></b></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="9" align="center"><b>Potongan Permak</b></td>
                    <td align="center"><b><?php echo number_format($detail['potongan_vermak'])?></b></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="9" align="center"><b>Biaya Transport Antar & Penjemputan Po</td>
                    <td align="center"><b><?php echo number_format($detail['biaya_transport']-$detail['potongan_transport'])?></b></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="9" align="center"><b>Potongan Pinjaman/Claim</td>
                    <td align="center"><b><?php echo number_format($detail['potongan_lainnya'])?></b></td>
                    <td></td>
                </tr>
                <tr style="background-color: yellow">
                    <td colspan="9" align="center"><b>Total Yang diterima</b></td>
                    <td align="center">
                        <b>
                            <?php if($detail['potongan_transport']==0){?>
                                <?php echo number_format($detail['total']+$detail['potongan_transport']) ?>
                            <?php }else{ ?>
                                <?php echo number_format($detail['total']) ?>
                            <?php } ?>
                        </b>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="9" align="center">
                        
                    </td>
                    <td colspan="2">
                        <!-- <b> -->
                            <i>
                            <?php if($detail['potongan_transport']==0){?>
                                    <?php echo ucwords(terbilang($detail['total']+$detail['potongan_transport'])) ?>
                                <?php }else{ ?>
                                    <?php echo ucwords(terbilang($detail['total'])) ?>
                                <?php } ?>
                                Rupiah
                            </i>
                        <!-- </b> -->
                    </td>
                </tr>
            </tfoot>
        </table>
        <?php if(isset($rek['cmt_name'])){ ?>
        <div class="rekening-info">
            <div class="form-group">
                <div class="rekening-info-label">
                    <table style="width: 100%;">
                        <tr>
                            <td colspan="3">Pembayaran Dilakukan Melalui Rekening</td>
                        </tr>
                        <tr>
                            <td width="35">
                                Bank
                            </td>
                            <td width="2">:</td>
                            <td width="300">
                                <?php echo !empty($rek['bank']) ? $rek['bank'] : 'belum diisi'?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Atas Nama 
                            </td>
                            <td>:</td>
                            <td>
                                <?php echo !empty($rek['an']) ? $rek['an'] : 'belum diisi'?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Nomor Rekening
                            </td>
                            <td>:</td>
                            <td>
                                <?php echo !empty($rek['norek']) ? $rek['norek'] : 'belum diisi'?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <?php } ?>
        <div class="ttd">
            <table>
                <tr>
                    <td colspan="4">Jakarta, <?php echo format_tanggal($detail['tanggal']) ?> </td>
                </tr>
                <tr align="center">
                    <td colspan="2">Mengetahui,<br> Supervisor</td>
                    <td colspan="2">Dibuat oleh,<br>Admin Keuangan</td>
                </tr>
                <tr align="center">
                    <td colspan="2">
                        <br><br><br><br><br><br>
                        (__________________)
                    </td>
                    <td colspan="2">
                        <?php if(!empty($ttd)){ ?>
                            <img src="<?php echo BASEURL ?>/uploads/ttd/<?php echo $ttd ?>" height="100" alt="">
                            ( <b style="padding:0px 25pt 0px 25pt;font-weight:0 !important">Mia</b> )
                        <?php }else { ?>
                        <br><br><br><br><br><br>
                        (__________________)
                        <?php } ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="registered">
        <i>Registered by Forboys Production System <?php echo format_tanggal_jam(date('d-m-Y H:i:s')); ?></i>
    </div>

    <div class="break"></div>
    <div class="lampiran">
        <h3>Lampiran</h3>
        <hr>
    </div>
    

    <div class="content-wrapper">
        <div class="content-kiri">
            <div class="form-group">
                <div class="label">Ketentuan CMT</div>
                <table>
                    <thead>
                        <tr align="center">
                            <th>Jumlah Dz</th>
                            <th>Harga (Rp)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach(table('harga_transport') as $h){?>
                            <tr>
                                <td><?php echo $h['keterangan']?></td>
                                <td align="right"><?php echo number_format($h['harga'])?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="form-group">
                <div class="label">Potongan Klaim / Bangke</div>
                <table style="background-color: white;width: 100%;border:1px solid black" cellpadding="5">
                        <tr>
                            <td>Potongan tidak ada bangke Rp.50.000/pcs</td>
                        </tr>
                        <tr>
                            <td>Potongan bangke tidak komplit Rp.25.000/pcs</td>
                        </tr>
                        <tr>
                            <td>Setelan (tidak ada bangke) Rp.40.000/pcs</td>
                        </tr>
                        <tr>
                            <td>Setelan (tidak komplit) Rp.20.000/pcs</td>
                        </tr>
                        <tr>
                            <td>BS dimasukan packingan Rp.100.000/pcs</td>
                        </tr>
                    </table>
            </div>
            <div class="form-group">
                    <div class="label">
                        Daftar Harga <?php echo ucwords(strtolower($namacmt))?>
                    </div>
                    <table style="width: 100%;border:1px solid black" cellpadding="5">
                            <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama PO</th>
                                        <th>Harga Lama/Dz</th>
                                        <th>Harga Baru/Dz</th>
                                        <!-- <th>Status</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $number=1;?>
                                    <?php foreach(daftarharga_cmt($detail['idcmt']) as $r){?>
                                        <tr>
                                            <td><?php echo $number++?></td>
                                            <td><?php echo $r['namapo']?></td>
                                            <td><?php echo ($r['hargalama'])?></td>
                                            <td><?php echo ($r['hargabaru'])?></td>
                                            <!-- <td><small><?php echo $r['keterangan']?></small></td> -->
                                        </tr>
                                    <?php } ?>

                                    <?php foreach(globaldaftarharga($lokasi) as $r){?>
                                        <tr>
                                            <td><?php echo $number++?></td>
                                            <td><?php echo $r['namapo']?></td>
                                            <td><?php echo number_format($r['hargalama'])?></td>
                                            <td><?php echo number_format($r['hargabaru'])?></td>
                                            <!-- <td><small><?php echo $r['keterangan']?></small></td> -->
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
            </div>
            <?php if(!empty($saldo_bangke)){?>
            <div class="form-group">
                <div class="label">Potongan Bangke Yang Belum Dikembalikan</div>
                <table border="1" style="border-collapse: collapse;width: 100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama PO</th>
                            <th>Qty</th>
                            <th>Harga/Pcs</th>
                            <th>Jumlah</th>
                            <!-- <th>Keterangan</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php $nomor2=1;$kb=0;?>
                        <?php foreach($saldo_bangke as $b){?>
                            <tr>
                                <td><?php echo $nomor2++?></td>
                                <td><?php echo strtoupper($b['kode_po'])?></td>
                                <td align="center"><?php echo $b['qty']?></td>
                                <td><?php echo number_format($b['harga'])?></td>
                                <td><?php echo number_format($b['qty']*$b['harga'])?></td>
                                <!-- <td><?php echo strtolower($b['keterangan'])?></td> -->
                            </tr>
                            <?php $kb+=($b['qty']*$b['harga']);?>
                        <?php } ?>
                        <?php
                            $jumlahProduk = count($saldo_bangke);
                            $barisKosongbangke = max(5 - $jumlahProduk, 0);
                        ?>
                        <?php for ($j = 0; $j < $barisKosongbangke; $j++) { ?>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <!-- <td></td> -->
                                </tr>
                            <?php } ?>
                        <tr>
                            <td colspan="4" align="center">Total</td>
                            <td><b><?php echo number_format($kb)?></b></td>
                            <!-- <td></td> -->
                        </tr>
                    </tbody>
                </table>
            </div>
            <?php } ?>
        </div>

        <div class="content-kanan">
            <div class="form-group">
                <div class="label" style="color:red">Potongan Alat</div>
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Rincian</th>
                            <th>Jumlah</th>
                            <th>Harga/Pcs</th>
                            <th>Total</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $nomor=1;$al=0;?>
                        <?php foreach($alat as $b){?>
                            <tr>
                                <td><?php echo $nomor++?></td>
                                <td><?php echo ucfirst($b['rincian'])?></td>
                                <td><?php echo $b['qty']?></td>
                                <td><?php echo number_format($b['harga'])?></td>
                                <td><?php echo number_format($b['qty']*$b['harga'])?></td>
                                <td><?php echo strtolower($b['keterangan'])?></td>
                            </tr>
                            <?php $al+=($b['qty']*$b['harga']);?>
                        <?php } ?>
                        <?php
                            $jumlahProduk = count($alat);
                            $barisKosongalat = max(5 - $jumlahProduk, 0);
                        ?>
                        <?php for ($j = 0; $j < $barisKosongalat; $j++) { ?>
                            <tr>
                                <td>&nbsp;</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td colspan="4" align="center"><b>Total</b></td>
                            <td><b style="color:red"><?php echo number_format($al)?></b></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <?php if(!empty($bangke)){?>
            <div class="form-group">
                <div class="label red">Potongan Bangke</div>
                <table border="1" style="border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama PO</th>
                            <th>Jumlah Potongan/Bangke</th>
                            <th>Harga/Pcs</th>
                            <th>Jumlah</th>
                            <!-- <th>Keterangan</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php $nomor=1;$bang=0;?>
                        <?php foreach($bangke as $b){?>
                            <tr>
                                <td><?php echo $nomor++?></td>
                                <td><?php echo strtoupper($b['kode_po'])?></td>
                                <td><?php echo $b['qty']?></td>
                                <td><?php echo number_format($b['harga'])?></td>
                                <td><?php echo number_format($b['qty']*$b['harga'])?></td>
                                <!-- <td><?php echo strtolower($b['keterangan'])?></td> -->
                            </tr>
                            <?php $bang+=($b['qty']*$b['harga']);?>
                        <?php } ?>
                        <?php
                            $jumlahProduk = count($bangke);
                            $barisKosongbangke = max(5 - $jumlahProduk, 0);
                        ?>
                        <?php for ($j = 0; $j < $barisKosongbangke; $j++) { ?>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <!-- <td></td> -->
                                </tr>
                            <?php } ?>
                        <tr>
                            <td colspan="4" align="center">Total</td>
                            <td><b class="red"><?php echo number_format($bang)?></b></td>
                            <!-- <td></td> -->
                        </tr>
                    </tbody>
                </table>
            </div>
            <?php } ?>
            <?php if(!empty($vermak)){?>
            <div class="form-group">
                <div class="label red">Potongan Permak</div>
                <table border="1" style="border-collapse: collapse;width: 100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Rincian</th>
                            <th>Jumlah</th>
                            <th>Potongan</th>
                            <th>Total</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $nomor=1;$av=0;?>
                        <?php foreach($vermak as $b){?>
                            <tr>
                                <td><?php echo $nomor++?></td>
                                <td><?php echo strtoupper($b['rincian'])?></td>
                                <td><?php echo $b['qty']?></td>
                                <td><?php echo number_format($b['harga'])?></td>
                                <td><?php echo number_format($b['qty']*$b['harga'])?></td>
                                <td><?php echo strtolower($b['keterangan'])?></td>
                            </tr>
                            <?php $av+=($b['qty']*$b['harga']);?>
                        <?php } ?>
                        <?php
                            $jumlahProduk = count($vermak);
                            $barisKosongvermak = max(5 - $jumlahProduk, 0);
                        ?>
                        <?php for ($j = 0; $j < $barisKosongvermak; $j++) { ?>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            <?php } ?>
                        <tr>
                            <td colspan="4" align="center">Total</td>
                            <td><b class="red"><?php echo number_format($av)?></b></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <?php } ?>
        </div>
    </div>


            
    </body>
</html>