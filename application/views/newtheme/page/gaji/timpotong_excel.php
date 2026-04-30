<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Laporan_Pembayaran_Tim_Potong_".date('d_m_Y',strtotime($prods['tanggal'])).".xls");
?>
<style>
    .text-center { text-align: center; }
    .text-right { text-align: right; }
    .bold { font-weight: bold; }
    .underline { text-decoration: underline; }
    .bg-light { background-color: #f2f2f2; }
    .bg-blue { background-color: #d9eaf7; }
    .bg-pink { background-color: #fce4d6; }
    .bg-grey { background-color: #e7e6e6; }
    .bg-orange { background-color: #f8cbad; }
    th { border: 1px solid #000; padding: 5px; }
    td { border: 1px solid #000; padding: 5px; }
    .no-border td { border: none !important; }
</style>

<table style="width: 100%;">
    <tr>
        <td colspan="2" style="border: none;"></td>
        <td colspan="5" class="text-center bold underline" style="font-size: 14pt; border: none;">
            Laporan Pembayaran Hasil Kerja Tim Potong <?php echo $timnya['nama']?>
        </td>
        <td colspan="3" style="border: none;" align="right" valign="top">
            <table style="border: 2px solid #28a745; border-collapse: collapse;">
                <tr>
                    <td style="color: #28a745; font-weight: bold; font-size: 10pt; text-align: center; border: 2px solid #28a745; padding: 5px;">
                        SUDAH DIBAYARKAN<br>
                        <?php echo formatTanggalIndo($prods['tanggal'], '1')?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<br>

<table border="1">
    <thead>
        <tr class="bg-light">
            <th width="30">No</th>
            <th>Tanggal</th>
            <th>Nama PO</th>
            <th>Jenis</th>
            <th>Size</th>
            <th>JML PO (Dz)</th>
            <th>JML PO (Pcs)</th>
            <th>Harga/Pcs</th>
            <th>Total Pendapatan</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $no = 1; 
        $total_dz = 0;
        $total_pcs = 0;
        foreach ($products as $p): 
            if ($p['total'] > 0): 
                $total_dz += $p['lusin'];
                $total_pcs += $p['pcs'];
        ?>
        <tr>
            <td class="text-center"><?= $no++ ?></td>
            <td class="text-center"><?= date('d/m/Y', strtotime($p['tanggal'])) ?></td>
            <td><?= $p['kode_po'] ?></td>
            <td class="text-center"><?= $p['jenis'] ?></td>
            <td class="text-center"><?= $p['size'] ?></td>
            <td class="text-right"><?= number_format($p['lusin'], 2) ?></td>
            <td class="text-right"><?= number_format($p['pcs']) ?></td>
            <td class="text-right"><?= number_format($p['harga']) ?></td>
            <td class="text-right"><?= number_format($p['total']) ?></td>
            <td></td>
        </tr>
        <?php 
            endif; 
        endforeach; 
        ?>
        <tr class="bg-blue bold">
            <td colspan="5" class="text-center">Total</td>
            <td class="text-right"><?= number_format($total_dz, 2) ?></td>
            <td class="text-right"><?= number_format($total_pcs) ?></td>
            <td></td>
            <td class="text-right"><?= number_format($totals) ?></td>
            <td></td>
        </tr>
        <tr class="bg-pink bold">
            <td colspan="8" class="text-center">Saving 5%</td>
            <td class="text-right"><?= number_format($savings) ?></td>
            <td></td>
        </tr>
        <tr class="bg-grey bold">
            <td colspan="8" class="text-center">POTONGAN PINJAMAN ( RP )</td>
            <td class="text-right"><?= number_format($claim) ?></td>
            <td></td>
        </tr>
        <tr class="bg-orange bold">
            <td colspan="8" class="text-center">JUMLAH ( RP )</td>
            <td class="text-right"><?= number_format($nominals) ?></td>
            <td></td>
        </tr>
    </tbody>
</table>

<br>

<table>
    <tr>
        <td colspan="6" style="border: none;" valign="top">
            <table style="border: none;">
                <tr><td colspan="4" style="border: none;" class="bold">Ketentuan Claim Potongan :</td></tr>
                <tr><td colspan="4" style="border: none;">1. Salah potong bahan di timbang x harga bahan</td></tr>
                <tr><td colspan="4" style="border: none;">2. Salah potong salur per PO ( 300.000 ) all size</td></tr>
                <tr><td colspan="4" style="border: none;">3. Kepala bahan di potong ( 5.000/pcs ), 2x dilakukan sama di potong ( 10.000/pcs )</td></tr>
            </table>
            <br>
            <table border="1" style="border-collapse: collapse;">
                <tr class="text-center bg-light bold"><td colspan="2">Harga Potong</td></tr>
                <tr><td>FBQ / KDT / KDO / HGO / KDOP / KDR / KDW / FBW / KOS / KOT</td><td class="text-center">250</td></tr>
                <tr><td>KDS / SWK / KSSK / KSTK / KDSP</td><td class="text-center">300</td></tr>
                <tr><td>FBS / SWE</td><td class="text-center">400</td></tr>
                <tr><td>SKW / SKF</td><td class="text-center">700</td></tr>
                <tr><td>KFB / KKE / KKW</td><td class="text-center">500</td></tr>
                <tr><td>HGK / SWH</td><td class="text-center">350</td></tr>
            </table>
        </td>
        <td style="border: none;"></td>
        <td colspan="3" style="border: none;" valign="top" align="right">
            <p class="text-center">Jakarta, <?php echo date('d F Y',strtotime($prods['tanggal']))?></p>
            <table border="1" style="width: 100%; border-collapse: collapse;">
                <tr class="text-center">
                    <th width="50%">Menyetujui</th>
                    <th width="50%">Di Buat oleh:</th>
                </tr>
                <tr class="text-center bold">
                    <td>SPV</td>
                    <td>ADM Keuangan</td>
                </tr>
                <tr>
                    <td height="60"></td>
                    <td height="60"></td>
                </tr>
                <tr class="text-center">
                    <td>( ................. )</td>
                    <td>( Mia )</td>
                </tr>
            </table>
            <p class="text-right" style="font-size: 8pt; font-style: italic;">Registered By Forboys Production System <?php echo date('d-m-Y H:i:s'); ?></p>
        </td>
    </tr>
</table>