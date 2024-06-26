<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slip Gaji</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
        }
        .header h2 {
            margin: 5px 0 0;
            font-size: 12px;
            font-weight: normal;
        }
        .separator {
            width: 100%;
            height: 2px;
            background: #000;
            margin: 10px 0;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
			font-size: 13.5px;
        }
        .details-table th, .details-table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .details-table th {
            background-color: #f9f9f9;
            width: 30%;
        }
        .details-table tr:last-child td {
            border-bottom: none;
        }
        .details-table .total {
            font-weight: bold;
        }
        .footer {
            text-align: right;
            margin-top: 20px;
        }
        .signature {
            margin-top: 50px;
            text-align: left;
        }
        .signature div {
            display: inline-block;
            width: 45%;
            vertical-align: top;
        }
        .signature div:last-child {
            text-align: right;
        }
        .signature-line {
            border-top: 1px solid #000;
            width: 200px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Forboys Production</h1>
            <h2>Slip Gaji Karyawan</h2>
        </div>
        <div class="separator"></div>
        <table class="details-table">
            <tr>
                <td>Nama Karyawan</td>
                <td>
					<b><?php echo strtoupper($nama) ?></b>
				</td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>
					<b><?php echo strtoupper($bagian) ?></b>
				</td>
            </tr>
            <tr>
                <td>Periode</td>
                <td>
					<b><?php echo date('F',strtotime($slip['tanggal']))?> <?php echo date('Y',strtotime($slip['tanggal']))?></b>
				</td>
            </tr>
            <tr>
                <td>Gaji Pokok</td>
                <td>
					<b>Rp <?php echo number_format(($slip['gajipokok']))?>,-</b>
				</td>
            </tr>
            <tr>
                <td>Gantungan Gaji</td>
                <td>
					<b>Rp <?php echo number_format(($slip['gantungan_gaji']))?>,-</b>
				</td>
            </tr>
            <tr>
                <td>Potongan Kasbon</td>
                <td>
					<b>Rp <?php echo number_format(($slip['potongan_kasbon']))?>,-</b>
				</td>
            </tr>
				<tr>
					<td>Pot.Pinjaman</td>
					<td>
						<b><?php echo number_format(($slip['potongan_pinjaman']))?></b>
					</td>
				</tr>
				<tr>
					<td>Pot.Klaim</td>
					<td>
						<b><?php echo number_format(($slip['potongan_claim']))?></b>
					</td>
				</tr>
				<tr>
					<td>Pot.Absensi</td>
					<td>
						<b><?php echo number_format(($slip['potongan_absensi']))?></b>
					</td>
				</tr>
				<tr>
					<td>Pot.Terlambat</td>
					<td>
						<b><?php echo number_format(($slip['potongan_terlambat']))?></b>
					</td>
				</tr>
            <tr class="total">
                <td>Total Gaji</td>
                <td>Rp <?php echo number_format(($slip['subtotal']))?>,-</td>
            </tr>
            <tr class="total">
                <td>Gaji Bersih</td>
                <td>Rp <?php echo number_format(($slip['total']))?>,-</td>
            </tr>
        </table>
        <div class="signature">
            <div>
                <p>Admin Keuangan,</p>
                <div class="signature-line"></div>
                <p>Nama Penyetujui</p>
            </div>
            <div>
                <p>Diterima Oleh,</p>
                <?php for($i=1;$i<=35;$i++){ echo '&nbsp;'; } ?><div class="signature-line"></div>
                <p>Nama Karyawan</p>
            </div>
        </div>
       
    </div>
</body>
</html>
