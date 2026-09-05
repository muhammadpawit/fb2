<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Surat Jalan Distribusi PO Sukabumi</title>
<style type="text/css">
	 body{font-family: Arial, Helvetica, sans-serif; font-size: 14px; text-transform: capitalize;}
	 .hs { font-size: 16px; font-weight: bold; }
	 .title { text-align: center; margin-bottom: 20px; }
	 table { width: 100%; border-collapse: collapse; }
	 table.data th, table.data td { border: 1px solid #333; padding: 6px 8px; }
	 table.data th { background-color: #f2f2f2; }
	 .registered { font-size: 11px; font-style: italic; margin-top: 15px; }
</style>
</head>
<body>
<?php $hari = date('l', strtotime($kirim['tanggal'])); ?>

<div class="title">
    <h3 style="margin:0; text-decoration: underline;">SURAT JALAN DISTRIBUSI PO (CMT SUKABUMI)</h3>
    <p style="margin:5px 0 0 0;">Nomor SJ: <strong><?php echo $kirim['nosj'] ?></strong></p>
</div>

<table style="margin-bottom: 20px;">
    <tr>
        <td width="55%" valign="top">
            <table>
                <tr>
                    <td width="120"><strong>Asal Pengiriman</strong></td>
                    <td width="10">:</td>
                    <td>CMT Kantor Sukabumi</td>
                </tr>
                <tr>
                    <td><strong>Kepada Yth</strong></td>
                    <td>:</td>
                    <td><strong><?php echo strtoupper($cmt['cmt_name']) ?></strong></td>
                </tr>
                <tr>
                    <td><strong>Alamat</strong></td>
                    <td>:</td>
                    <td><?php echo ucfirst($cmt['alamat']) ?></td>
                </tr>
                <tr>
                    <td><strong>Phone</strong></td>
                    <td>:</td>
                    <td><?php echo $cmt['telephone'] ?></td>
                </tr>
            </table>
        </td>
        <td width="45%" valign="top">
            <table>
                <tr>
                    <td width="100"><strong>Hari / Tanggal</strong></td>
                    <td width="10">:</td>
                    <td><?php echo hari($hari) . ', ' . formatTanggalIndo($kirim['tanggal']) ?></td>
                </tr>
                <tr>
                    <td><strong>Supir</strong></td>
                    <td>:</td>
                    <td><?php echo isset($kirim['supir']) ? ucfirst($kirim['supir']) : '-' ?></td>
                </tr>
                <tr>
                    <td><strong>Pendamping</strong></td>
                    <td>:</td>
                    <td><?php echo isset($kirim['pendamping']) ? ucfirst($kirim['pendamping']) : '-' ?></td>
                </tr>
                <tr>
                    <td><strong>Keterangan</strong></td>
                    <td>:</td>
                    <td><?php echo !empty($kirim['keterangan']) ? $kirim['keterangan'] : '-' ?></td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<table class="data">
    <thead>
        <tr>
            <th width="30">No</th>
            <th>Kode PO</th>
            <th>Pekerjaan</th>
            <th>Rincian PO</th>
            <th width="90">Jumlah (Pcs)</th>
            <th width="100">Jml Barang</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        <?php 
          $no = 1;
          $total_pcs = 0;
          foreach($kirims as $k){
            $total_pcs += $k['jumlah_pcs'];
        ?>
            <tr>
                <td align="center"><?php echo $no++ ?></td>
                <td><strong><?php echo $k['kode_po'] ?></strong></td>
                <td><?php echo $k['job'] ?></td>
                <td><?php echo $k['rincian_po'] ?></td>
                <td align="right"><?php echo number_format($k['jumlah_pcs']) ?></td>
                <td align="center"><?php echo $k['jml_barang'] ?></td>
                <td><?php echo $k['keterangan'] ?></td>
            </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="4" align="right">TOTAL:</th>
            <th align="right"><?php echo number_format($total_pcs) ?></th>
            <th colspan="2"></th>
        </tr>
    </tfoot>
</table>

<br><br>

<table style="width:100%">
    <tr>
        <td style="width:40%" valign="top">
            <p>Catatan :</p>
            <ol style="padding-left:15px; margin:0;">
                <li>PO yang sudah diterima harap dicek dahulu potongan dan kelengkapannya.</li>
                <li>Apabila ada kekurangan, harap segera konfirmasi ke Kantor Cabang Sukabumi / QC.</li>
                <li>Batas maksimal konfirmasi 3 x 24 jam.</li>
                <li>Apabila tidak ada konfirmasi, PO dianggap komplit.</li>
            </ol>
        </td>
        <td style="width:60%" valign="top">
            <table border="1" style="border-collapse: collapse; width: 100%; margin-top: 10px;">
                <tr>
                    <td align="center" width="25%" style="padding: 5px;">Security</td>
                    <td align="center" width="25%" style="padding: 5px;">CMT Tujuan</td>
                    <td align="center" width="25%" style="padding: 5px;">Kepala Cabang</td>
                    <td align="center" width="25%" style="padding: 5px;">Admin SKB</td>
                </tr>
                <tr>
                    <td align="center" height="70" valign="bottom" style="padding-bottom: 5px;">................</td>
                    <td align="center" height="70" valign="bottom" style="padding-bottom: 5px;">................</td>
                    <td align="center" height="70" valign="bottom" style="padding-bottom: 5px;">................</td>
                    <td align="center" height="70" valign="bottom" style="padding-bottom: 5px;">VINA</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<div class="registered">
    <i>Registered by Forboys Production System <?php echo date('d-m-Y H:i:s'); ?></i>
</div>

</body>
</html>
