<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=pengiriman_alat_cmt.xls");
?>  
<br>
<br>
<br>
<table style="width: 100%">
    <tr>
        <td>
            <h3>Forboys Production<br>
            Alamat<br>
            JL.Z NO 1, Kel. Sukabumi Selatan, Kec Kebon Jeruk Kampung Baru, Jakarta Barat
            </h3>
            <h3><strong>Faktur No. </strong><?php echo $barang[0]['faktur_no'] ?></h3>
        </td>
        <td valign="top" colspan="2">
            <h1>Surat Jalan Item Keluar</h1>
        </td>
        <td>
            <table style="font-size: 16pt;outline-style: solid;width: 100%" cellpadding="3">
                                    <tr>
                                        <td colspan="2"><strong>Jakarta</strong>, <?php echo date('Y-m-d') ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">Kepada Yth</td>
                                    </tr>
                                    <tr>
                                        <td>Tuan/Toko</td>
                                        <td>: <?php echo $barang[0]['nama_penerima']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Tujuan</td>
                                        <td>: <?php echo $barang[0]['tujuan_item']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>NAMA PO</td>
                                        <td>: <?php echo $project['nama_po'].$project['kode_po']; ?></td>
                                    </tr>
                                </table>
        </td>
    </tr>
</table><br>
                                <table style="width: 100%;border-collapse: collapse;" border="1">
                                    <thead>
                                    <tr><th>#</th>
                                        <th>Nama Barang</th>
                                        <th>Jumlah / Satuan</th>
                                        <th>Harga Pcs</th>
                                        <th>Item Perlusin</th>
                                        <th class="text-right">Total</th>
                                    </tr></thead>
                                    <tbody>
                                        <?php $total = 0; ?>
                                <?php $no=1; foreach ($barang as $key => $item): ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td>
                                            <b><?php echo $item['nama_item_keluar'] ?></b> 
                                        </td>
                                        <td><?php echo $item['jumlah_item_keluar'] ?> <?php echo $item['satuan_jumlah_keluar'] ?></td>
                                        <td><?php echo ($item['harga_item']) ?></td>
                                        <td><?php echo ($item['jumlah_item_perlusin']) ?></td>
                                        <?php 
                                        $total += $item['jumlah_item_keluar'] * $item['harga_item'];
                                         ?>
                                        <td class="text-right"><?php echo ($item['jumlah_item_keluar'] * $item['harga_item']) ?></td>
                                    </tr>
                                <?php endforeach ?>
                                    
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="5"><b>Total</b></td>
                                            <td><h4>Rp. <?php echo ($total) ?></h4></td>
                                        </tr>
                                    </tfoot>
                                </table>