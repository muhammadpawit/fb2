<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Notifikasi Pengajuan Belanja Harian</title>
</head>
<body style="margin:0; padding:0; font-family: Arial, Helvetica, sans-serif; background-color:#f4f7fb; color:#333;">

    <table width="100%" cellspacing="0" cellpadding="0" style="background-color:#f4f7fb; padding:30px 0;">
        <tr>
            <td align="center">
                <table width="600" cellspacing="0" cellpadding="0" style="background-color:#ffffff; border-radius:12px; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.1);">
                    
                    <!-- Header -->
                    <tr>
                        <td style="background:linear-gradient(135deg, #16a34a, #22c55e); padding:20px; text-align:center; color:#fff;">
                            <h1 style="margin:0; font-size:20px;">Sistem Pengajuan</h1>
                            <p style="margin:0; font-size:14px;">Notifikasi Belanja Harian</p>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:30px;">
                            <h2 style="margin-top:0; color:#111;">Halo, <?= $nama_penerima; ?> 👋</h2>
                            <p style="line-height:1.6; font-size:14px; color:#444;">
                                Ada pengajuan belanja harian baru yang perlu ditinjau:
                            </p>

                            <table border="0" cellspacing="0" cellpadding="0" width="100%" style="margin:20px 0; border-collapse:collapse; font-size:14px;">
                                <tr>
                                    <td style="padding:8px; border:1px solid #ddd;">Hari / Tanggal</td>
                                    <td style="padding:8px; border:1px solid #ddd;"><?= $parent['tanggal']; ?></td>
                                </tr>
                                <tr>
                                    <td style="padding:8px; border:1px solid #ddd;">Divisi / Cabang</td>
                                    <td style="padding:8px; border:1px solid #ddd;"></td>
                                </tr>
                                <tr>
                                    <td style="padding:8px; border:1px solid #ddd;">Total Pengajuan</td>
                                    <td style="padding:8px; border:1px solid #ddd;"></td>
                                </tr>
                                <tr>
                                    <td style="padding:8px; border:1px solid #ddd;">Status</td>
                                    <td style="padding:8px; border:1px solid #ddd;">
                                        <span style="background:#facc15; color:#111; padding:4px 8px; border-radius:6px; font-size:12px;">
                                            <?= ucfirst($status); ?>
                                        </span>
                                    </td>
                                </tr>
                            </table>

                            <p style="font-size:14px; line-height:1.6; color:#444;">
                                Silakan klik tombol di bawah ini untuk melihat detail pengajuan.
                            </p>

                            <p style="text-align:center; margin:30px 0;">
                                <a href="<?= $url_detail; ?>" 
                                   style="background:#16a34a; color:#fff; text-decoration:none; padding:12px 24px; border-radius:8px; font-size:14px; display:inline-block;">
                                    Lihat Detail
                                </a>
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background:#f4f7fb; padding:15px; text-align:center; font-size:12px; color:#888;">
                            Email ini dikirim otomatis oleh sistem. Mohon tidak membalas email ini.
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>
</html>
