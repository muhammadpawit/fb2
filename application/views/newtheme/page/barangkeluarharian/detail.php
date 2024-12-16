<html>
  <head>

  </head>
  <body>
    <div class="title">
        <center>
            <h3><?php echo $title ?><br>
            No. Faktur  : <?php echo $d['id'] ?>
            </h3>
        </center>
    </div>
    <div class="subtitle">
        <table>
            <tr>
                <td>Kepada Yth</td>
                <td>:</td>
                <td><?php echo ucwords(strtolower($d['pengambil']))?></td>
            </tr>
        </table>
    </div>
    <div class="body">
        <table border="1" style="border-collapse: collapse; width: 100%; border-color: 1px solid #dee2e6 !important; font-size: 19.5px !important;">
            <thead>
                                            <tr>
                                                <th>No</th>

                                                <th>Nama Barang</th>

                                                <th>Satuan </th>
                                                <th>Jumlah</th>
                                                <?php if($d['bagian']==10){ ?>
                                                <th>Harga</th>
                                                <th>Total</th>
                                                <?php } ?>
                                            </tr>
            </thead>
            <tbody>
              <?php 
                  $totalqty=0;
                  $totalharga=0;
              ?>
            <?php $no=1; foreach ($barang as $key => $item): ?>

                    <tr>

                        <td align="center">
                          <?php echo $no; ?>
                        </td>

                        <td>

                        <?php echo $item['nama'] ?>

                        </td>

                        <td align="center"><?php echo $item['satuan'] ?></td>
                        <td align="center">
                            <?php echo number_format($item['jumlah']) ?>

                        </td>

                        <?php if($d['bagian']==10){ ?>

                        <td align="right">
                            <?php echo !empty($item['harga_skb']) ? number_format($item['harga_skb']) : 0; ?>

                        </td>

                        <td align="right">
                            <?php echo !empty($item['harga_skb']) ? number_format(($item['harga_skb']*$item['jumlah'])) : 0; ?>

                        </td>

                        <?php } ?>


                    </tr>
                    <?php 
                        $totalqty+=($item['jumlah'] );
                        $totalharga+=($item['harga_skb']*$item['jumlah']) ;
                    ?>
                    <?php $no++;?>
                    <?php endforeach ?>
                    <?php
                            // Hitung jumlah baris kosong yang perlu ditambahkan
                            $jumlahProduk = count($barang);
                            $barisKosong = max(10 - $jumlahProduk, 0); // Pastikan jumlah baris kosong tidak negatif
                        ?>
                        <?php for ($j = 0; $j < $barisKosong; $j++) { ?>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <?php if($d['bagian']==10){ ?>
                                    <td></td>
                                    <td></td>
                                    <?php } ?>
                                </tr>
                            <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                  <td colspan="3" align="center"><b>Total</b></td>
                  <td align="center">
                    <b><?php echo number_format($totalqty) ?></b>
                  </td>
                  <?php if($d['bagian']==10){ ?>
                  <td></td>
                  <td align="right">
                    <b><?php echo number_format($totalharga) ?></b>
                  </td>
                  <?php } ?>
                </tr>
            </tfoot>
        </table>
        <div class="rekening-info ml-0pt">
            <div class="form-group">
                <div class="rekening-info-label">
                    <table style="width: 100%;">
                        <tr>
                            <td colspan="3">Catatan : </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="ttd">
            <table>
                <tr>
                    <td colspan="4">Jakarta, <?php echo format_tanggal($d['tanggal']) ?> </td>
                </tr>
                <tr align="center">
                    <td>Security,</td>
                    <td>Mandor Finishing,</td>
                    <td>Admin Gudang,</td>
                    <td>Diterima oleh,</td>
                </tr>
                <tr align="center">
                    <td>
                        <br><br><br><br><br>
                        (________)
                    </td>
                    <td>
                        <br><br><br><br><br>
                        (<b style="padding:0px 5pt 0px 5pt;font-weight:0 !important">Kandar</b>)
                    </td>
                    <td>
                        <br><br><br><br><br>
                        (<b style="padding:0px 15pt 0px 15pt;font-weight:0 !important">Ifah</b>)
                    </td>
                    <td>
                        <br><br><br><br><br>
                        (________)
                    </td>
                </tr>
            </table>
        </div>
    </div>
      
        <div class="registered">
            <i>Registered by Forboys Production System <?php echo format_tanggal_jam(date('d-m-Y H:i:s')); ?></i>
        </div>
  </body>
</html>