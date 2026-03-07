<html>
    <head></head>
    <body>
        <div class="title">
            <center>
                <h3>
                FORM AJUAN <?php echo $mingguan ?> FORBOYS<br>BAGIAN : <?php if ($parent['kategori'] == 1) {
                echo "SABLON";
                    } else if($parent['kategori'] == 2) { echo "BORDIR"; } else if($parent['kategori'] == 3) {echo "KONVEKSI";} else if($parent['kategori'] == 4) {echo "CABANG SUKABUMI";}?>
                </h3>
            </center>
        </div>
        <div class="subtitle">
            <table>
                <tr>
                    <td>Periode</td>
                    <td>:</td>
                    <td><?php $hari=date('l',strtotime($parent['tanggal'])); echo hari($hari); ?>,<?php echo format_tanggal($parent['tanggal']) ?></td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>:</td>
                    <td><?php echo $parent['status']==0 ? 'Belum Disetujui': 'Disetujui';?></td>
                </tr>
            </table>
        </div>
        <div class="body">
            <table border="1" style="border-collapse: collapse;width: 100%">

            <thead>

                <tr>

                    <th>NO.</th>

                    <th>NAMA AJUAN</th>
                    
                    <th>WARNA</th>

                    <th>JUMLAH</th>

                    <th>SATUAN</th>
                    <?php if( $parent['kategori']<4){ ?>
                    <th width="125">HARGA SATUAN (Rp)</th>

                    <th width="125">JUMLAH PEMBAYARAN (Rp)</th>

                    <th>TIPE PEMBAYARAN</th>

                    <th>NAMA SUPPLIER</th>
                    <?php } ?>
                    <th>KETERANGAN</th>
                </tr>

            </thead>

            <tbody>

            <?php $i=0; $total = 0;$no=1;$totalCash=0;$totalTF=0; $warna=null; ?>

            <?php foreach ($item_cash as $key => $tem): ?>
                <?php
                    if(isset($tem['nama_item'])){
                        $warna = $this->GlobalModel->QueryManualRow("
                        SELECT * FROM product where nama LIKE '".$tem['nama_item']."'
                        "); 
                    }    
                ?>
                <tr>
                    <td align="center"><?php echo $no++; ?></td>
                    <td><?php echo htmlspecialchars($tem['nama_item']) ?></td>

                    <td><?php echo !empty($warna) ? htmlspecialchars($warna['warna_item']):'' ?></td>

                    <td align="center"><?php echo $tem['jumlah'] ?></td>

                    <td><?php echo htmlspecialchars($tem['satuan']) ?></td>
                    
                    <?php if( $parent['kategori']<4){ ?>
                    <td width="125" align="center"><?php echo number_format($tem['harga']) ?></td>

                    <?php if ($tem['pembayaran'] == 2){ 

                        $totalTF+=$tem['jumlah'] * $tem['harga'];

                    } else { 

                        $totalCash+=$tem['jumlah'] * $tem['harga'];

                    } ?>

                    <td width="125"><?php echo number_format($tem['jumlah'] * $tem['harga']) ;?></td>

                    <td><?php echo ($tem['pembayaran']==1)?'Cash':'Transfer'; ?></td>

                    <td><?php echo htmlspecialchars($tem['supplier']); ?></td>
                    <?php } ?>
                    <td><?php echo htmlspecialchars($tem['keterangan']); ?></td>
                </tr>
                <?php $i++?>
            <?php endforeach ?>
                <?php
                    // Hitung jumlah baris kosong yang perlu ditambahkan
                    $jumlahProduk = count($item_cash);
                    $barisKosong = max(20 - $jumlahProduk, 0); // Pastikan jumlah baris kosong tidak negatif
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
                        </tr>
                    <?php } ?>
            </tbody>
            <tfoot>
                <?php if( $parent['kategori']<4){ ?>
                <tr style="background-color: yellow" class="yaprint">
                    <td colspan="3">Total Cash (Rp)</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        <?php //echo number_format($parent['cash'] + $parent['transfer']) ;?>
                        <?php echo number_format($parent['cash']) ;?>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <?php if($parent['status']!=1){?>
                    <td></td>
                    <?php } ?>
                </tr>
                <?php } ?>
            </tfoot>

            </table>
            <div class="break"></div>
            <table border="1" style="border-collapse: collapse;width: 100%">

            <thead>

                <tr>

                    <th>NO.</th>

                    <th>NAMA AJUAN</th>

                    <th>WARNA</th>

                    <th>JUMLAH</th>

                    <th>SATUAN</th>
                    <?php if( $parent['kategori']<4){ ?>
                    <th width="125">HARGA SATUAN (Rp)</th>

                    <th width="125">JUMLAH PEMBAYARAN (Rp)</th>

                    <th>TIPE PEMBAYARAN</th>

                    <th>NAMA SUPPLIER</th>
                    <?php } ?>
                    <th>KETERANGAN</th>
                </tr>

            </thead>

            <tbody>

                <?php $i=0; $total = 0;$no=1;$totalCash=0;$totalTF=0; ?>
                <?php foreach ($item_tf as $key => $tem): ?>
                <?php 
                    if(isset($tem['nama_item'])){
                        $warna = $this->GlobalModel->QueryManualRow("
                        SELECT * FROM product where nama LIKE '".$tem['nama_item']."'
                        "); 
                    }        
                ?>
                 <tr>
                    <td align="center"><?php echo $no++; ?></td>
                    <td><?php echo htmlspecialchars($tem['nama_item']) ?></td>
                    <td><?php echo !empty($warna) ? htmlspecialchars($warna['warna_item']):'' ?></td>
                    <td align="center"><?php echo $tem['jumlah'] ?></td>
                    <td><?php echo htmlspecialchars($tem['satuan']) ?></td>
                    <?php if( $parent['kategori']<4){ ?>
                    
                    <td width="125" align="center"><?php echo number_format($tem['harga']) ?></td>

                    <?php if ($tem['pembayaran'] == 2){ 

                        $totalTF+=$tem['jumlah'] * $tem['harga'];

                    } else { 

                        $totalCash+=$tem['jumlah'] * $tem['harga'];

                    } ?>

                    <td width="125"><?php echo number_format($tem['jumlah'] * $tem['harga']) ;?></td>

                    <td><?php echo ($tem['pembayaran']==1)?'Cash':'Transfer'; ?></td>

                    <td><?php echo htmlspecialchars($tem['supplier']); ?></td>
                    <?php } ?>
                    <td><?php echo htmlspecialchars($tem['keterangan']); ?></td>
                 </tr>

                
                <?php $i++?>
                <?php endforeach ?>
                <?php
                    // Hitung jumlah baris kosong yang perlu ditambahkan
                    $jumlahProduk = count($item_tf);
                    $barisKosong = max(20 - $jumlahProduk, 0); // Pastikan jumlah baris kosong tidak negatif
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
                        </tr>
                    <?php } ?>
            </tbody>
            <tfoot>
                <?php if( $parent['kategori']<4){ ?>
                    <tr style="background-color: yellow" class="yaprint">
                        <td colspan="3">Total Transfer (Rp)</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <?php echo number_format($parent['transfer']) ;?>
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <?php } ?>
            </tfoot>

            </table>
            <div class="rekening-info">
                <div class="rekening-info-label">
                <?php if( $parent['kategori']<4){ ?>               
                                <table border="1" style="border-collapse: collapse;width: 30%">

                                    <tr>

                                        <td>CASH</td>

                                        <td>Rp <?php echo number_format($parent['cash']) ?></td>

                                    </tr>

                                    <tr>

                                        <td>TRANSFER</td>

                                        <td>Rp <?php echo number_format($parent['transfer']) ?></td>

                                    </tr>

                                     <tr>

                                        <td>Total </td>

                                        <td>Rp <?php echo number_format($parent['cash']+$parent['transfer']) ?></td>

                                    </tr>


                                </table>
                                <?php } ?>
                </div>
            </div>
            <div class="ttd">
            <table>
                <tr>
                    <td colspan="4">Jakarta, <?php echo format_tanggal($parent['tanggal']) ?> </td>
                </tr>
                <tr align="center">
                    <td colspan="2">Mengetahui,<br> Supervisor</td>
                    <td colspan="2">Diperiksa oleh,<br>Admin Keuangan</td>
                    <td colspan="2">Dibuat oleh,<br>Admin Gudang</td>
                </tr>
                <tr align="center">
                    <td colspan="2">
                        <?php if(!empty($parent['paraf'])){ 
                            $src = (strlen($parent['paraf']) > 100) ? 'data:image/png;base64,'.$parent['paraf'] : BASEURL.'uploads/signatures/'.$parent['paraf'];
                        ?>
                            <img src="<?php echo $src ?>" height="100" alt="">
                            ( <b style="padding:0px 25pt 0px 25pt;font-weight:0 !important"></b> )
                        <?php }else { ?>
                        <br><br><br><br><br><br>
                        (__________________)
                        <?php } ?>
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
                    <td colspan="2">
                        <br><br><br><br><br><br>
                        (______Najwa______)
                    </td>
                </tr>
            </table>
        </div>
        </div>
    </body>
</html>