<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Slip Gaji</title>
    <style>
        /* Reset dasar untuk hasil stabil di mPDF */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Tahoma', Arial, sans-serif;
            background-color: #fff;
            color: #000;
            font-size: 12pt;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 15px 25px;
            border: 1px solid #000;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
        }

        .header h1 {
            font-size: 16pt;
            margin-bottom: 3px;
        }

        .header h2 {
            font-size: 12pt;
            font-weight: normal;
        }

        .separator {
            height: 1.5px;
            background: #000;
            margin: 10px 0 15px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11pt;
        }

        td {
            padding: 6px 5px;
            vertical-align: top;
        }

        .details-table td:first-child {
            width: 45%;
        }

        .details-table tr td:nth-child(2) {
            text-align: right;
        }

        .details-table tr.total td {
            font-weight: bold;
            border-top: 1px solid #000;
        }

        .footer {
            text-align: right;
            margin-top: 15px;
        }

        .signature-wrapper {
        width: 100%;
        margin-top: 50px;
        display: table;
    }

    .signature-col {
        display: table-cell;
        width: 50%;
        vertical-align: bottom;
        text-align: center;
    }

    .signature-col p {
        margin: 0 0 50px 0; /* jarak antara teks dan garis */
    }

    .signature-line {
        border-top: 1px solid #000;
        width: 200px;
        margin: 0 auto 5px auto;
    }

        p {
            margin-bottom: 5px;
        }

        b {
            font-weight: 600;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>FORBOYS PRODUCTION</h1>
        <h2>SLIP GAJI KARYAWAN</h2>
    </div>

    <div class="separator"></div>

    <table class="details-table">
        <tr>
            <td>Nama Karyawan</td>
            <td><b><?php echo strtoupper($nama) ?></b></td>
        </tr>
        <tr>
            <td>Jabatan / Divisi</td>
            <td><b><?php echo strtoupper($bagian) ?> / <?php echo strtoupper($divisi) ?></b></td>
        </tr>
        <tr>
            <td>Periode</td>
            <td><b><?php echo date('F', strtotime($slip['tanggal'])) . ' ' . date('Y', strtotime($slip['tanggal'])) ?></b></td>
        </tr>
        <tr>
            <td>Gaji Pokok</td>
            <td>Rp <?php echo number_format($slip['gajipokok']) ?>,-</td>
        </tr>
        <tr>
            <td>Gantungan Gaji</td>
            <td>Rp <?php echo number_format($slip['gantungan_gaji']) ?>,-</td>
        </tr>
        <tr>
            <td>Potongan Kasbon</td>
            <td>Rp <?php echo number_format($slip['potongan_kasbon']) ?>,-</td>
        </tr>
        <tr>
            <td>Pot. Pinjaman</td>
            <td>Rp <?php echo number_format($slip['potongan_pinjaman']) ?>,-</td>
        </tr>
        <tr>
            <td>Pot. Klaim</td>
            <td>Rp <?php echo number_format($slip['potongan_claim']) ?>,-</td>
        </tr>
        <tr>
            <td>Pot. Absensi</td>
            <td>Rp <?php echo number_format($slip['potongan_absensi']) ?>,-</td>
        </tr>
        <tr>
            <td>Pot. Terlambat</td>
            <td>Rp <?php echo number_format($slip['potongan_terlambat']) ?>,-</td>
        </tr>
        <tr class="total">
            <td>Total Gaji</td>
            <td>Rp <?php echo number_format($slip['subtotal']) ?>,-</td>
        </tr>
        <tr class="total">
            <td>Gaji Bersih</td>
            <td>Rp <?php echo number_format($slip['total']) ?>,-</td>
        </tr>
    </table>

    <div class="signature-wrapper">
        <div class="signature-col">
            <p>Admin Keuangan,</p>
            <div class="signature-line"></div>
            <p>Mia Melia</p>
        </div>
        <div class="signature-col">
            <p>Diterima Oleh,</p>
            <div class="signature-line"></div>
            <p><?php echo ucfirst($nama) ?></p>
        </div>
    </div>
</div>

</body>
</html>
