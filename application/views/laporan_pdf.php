<!DOCTYPE html>
<html>
<head>
    <title><?= $title_pdf ?></title>
</head>
<body>
    <h1><?= $title_pdf ?></h1>
    <table style="width: 100%;border:1px solid black;border-collapse:collapse" border="1" cellpadding="4">
        <tr>
            <th>Tanggal</th>
            <th>Nama Alat</th>
            <th>Jumlah</th>
            <th>Nama CMT</th>
            <th>Keterangan</th>
            <!-- Tambahkan kolom lain sesuai data -->
        </tr>
        <?php foreach ($results as $row): ?>
            <tr>
                <td><?= $row['tanggal'] ?></td>
                <td><?= $row['namaalat'] ?></td>
                <td align="center"><?= $row['jumlah'] ?></td>
                <td><?= $row['cmt_name'] ?></td>
                <td><?= $row['keterangan'] ?></td>
                <!-- Tambahkan data lain sesuai kebutuhan -->
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
