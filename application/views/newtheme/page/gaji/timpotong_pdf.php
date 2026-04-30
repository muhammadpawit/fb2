<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pembayaran Tim Potong</title>
    <style>
        @page { margin: 15px; }
        body { font-family: Arial, sans-serif; font-size: 8.5pt; color: #333; line-height: 1.1; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .bold { font-weight: bold; }
        .underline { text-decoration: underline; }
        .bg-light { background-color: #f2f2f2; }
        .bg-blue { background-color: #d9eaf7; }
        .bg-pink { background-color: #fce4d6; }
        .bg-grey { background-color: #e7e6e6; }
        .bg-orange { background-color: #f8cbad; }
        
        .title { font-size: 13pt; margin-bottom: 10px; text-transform: uppercase; }
        
        table { width: 100%; border-collapse: collapse; margin-bottom: 5px; table-layout: fixed; word-wrap: break-word; }
        th, td { border: 1px solid #000; padding: 2px 3px; font-size: 7.5pt; }
        
        .no-border { border: none !important; }
        .no-border td { border: none !important; }
        
        .footer-section { margin-top: 10px; }
        .signature-table th { background: none; font-weight: normal; border: 1px solid #000; }
        .signature-table td { height: 45px; vertical-align: bottom; border: 1px solid #000; }
        
        .info-table td { border: none; padding: 1px; }
    </style>
</head>
<body>
    <table class="no-border" style="margin-bottom: 20px;">
        <tr>
            <td width="20%"></td>
            <td width="60%" class="text-center">
                <div class="title bold underline" style="margin-bottom: 0;">
                    Laporan Pembayaran Hasil Kerja Tim Potong <?php echo isset($timnya['nama']) ? $timnya['nama'] : ''; ?>
                </div>
            </td>
            <td width="30%" valign="top">
                <div style="border: 2px solid #28a745; color: #28a745; padding: 2px 4px; font-weight: bold; font-size: 9pt; border-radius: 4px; display: inline-block; text-transform: uppercase;text-align:center">
                    Sudah Dibayarkan<br> <?php echo formatTanggalIndo($prods['tanggal'], '1')?>
                </div>
            </td>
        </tr>
    </table>

    <table>
        <thead>
            <tr class="bg-light">
                <th width="20">No</th>
                <th width="60">Tanggal</th>
                <th>Nama PO</th>
                <th width="45">Jenis</th>
                <th width="50">Size</th>
                <th width="45">Dz</th>
                <th width="45">Pcs</th>
                <th width="45">Harga</th>
                <th width="70">Total</th>
                <th width="40">Ket</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1; 
            $total_dz = 0;
            $total_pcs = 0;
            if(!empty($products)){
                foreach ($products as $p){
                    if ($p['total'] > 0){
                        $total_dz += $p['lusin'];
                        $total_pcs += $p['pcs'];
            ?>
            <tr>
                <td class="text-center"><?php echo $no++; ?></td>
                <td class="text-center"><?php echo $p['tanggal']; ?></td>
                <td><?php echo $p['kode_po']; ?></td>
                <td class="text-center"><?php echo $p['jenis']; ?></td>
                <td class="text-center"><?php echo $p['size']; ?></td>
                <td class="text-right"><?php echo number_format($p['lusin'], 2); ?></td>
                <td class="text-right"><?php echo number_format($p['pcs']); ?></td>
                <td class="text-right"><?php echo number_format($p['harga']); ?></td>
                <td class="text-right"><?php echo number_format($p['total']); ?></td>
                <td></td>
            </tr>
            <?php 
                    }
                }
            }
            ?>
            <tr class="bg-blue bold">
                <td colspan="5" class="text-center">Total</td>
                <td class="text-right"><?php echo number_format($total_dz, 2); ?></td>
                <td class="text-right"><?php echo number_format($total_pcs); ?></td>
                <td></td>
                <td class="text-right"><?php echo number_format($totals); ?></td>
                <td></td>
            </tr>
            <tr class="bg-pink bold">
                <td colspan="8" class="text-center">Saving 5%</td>
                <td class="text-right"><?php echo number_format($savings); ?></td>
                <td></td>
            </tr>
            <tr class="bg-grey bold">
                <td colspan="8" class="text-center">POTONGAN PINJAMAN ( RP )</td>
                <td class="text-right"><?php echo number_format($claim); ?></td>
                <td></td>
            </tr>
            <tr class="bg-orange bold">
                <td colspan="8" class="text-center">JUMLAH ( RP )</td>
                <td class="text-right"><?php echo number_format($nominals); ?></td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <div class="footer-section">
        <table class="no-border">
            <tr>
                <td width="55%" valign="top">
                    <p class="bold">Ketentuan Claim Potongan :</p>
                    <p>1. Salah potong bahan di timbang x harga bahan</p>
                    <p>2. Salah potong salur per PO ( 300.000 ) all size</p>
                    <p>3. Kepala bahan di potong ( 5.000/pcs ), 2x dilakukan sama di potong ( 10.000/pcs )</p>
                    
                    <br>
                    <table style="width: 280px; border-collapse: collapse;">
                        <tr class="text-center bg-light bold">
                            <td colspan="2" style="border: 1px solid #000;">Harga Potong</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000;">FBQ / KDT / KDO / HGO / KDOP / KDR / KDW / FBW / KOS / KOT</td>
                            <td class="text-center" style="border: 1px solid #000;">250</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000;">KDS / SWK / KSSK / KSTK / KDSP</td>
                            <td class="text-center" style="border: 1px solid #000;">300</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000;">FBS / SWE</td>
                            <td class="text-center" style="border: 1px solid #000;">400</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000;">SKW / SKF</td>
                            <td class="text-center" style="border: 1px solid #000;">700</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000;">KFB / KKE / KKW</td>
                            <td class="text-center" style="border: 1px solid #000;">500</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000;">HGK / SWH</td>
                            <td class="text-center" style="border: 1px solid #000;">350</td>
                        </tr>
                    </table>
                </td>
                <td width="5%" class="no-border"></td>
                <td width="40%" valign="top">
                    <p class="text-center">Jakarta, <?php echo date('d F Y', strtotime($prods['tanggal'])); ?></p>
                    <table class="signature-table">
                        <tr class="text-center">
                            <th width="50%">Menyetujui</th>
                            <th width="50%">Di Buat oleh:</th>
                        </tr>
                        <tr class="text-center bold">
                            <td>SPV</td>
                            <td>ADM Keuangan</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr class="text-center">
                            <td>( ................. )</td>
                            <td>( Mia )</td>
                        </tr>
                    </table>
                    <p class="text-right" style="font-size: 8pt; font-style: italic; margin-top: 10px;">
                        Registered By Forboys Production System <?php echo date('d-m-Y H:i:s'); ?>
                    </p>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
