<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Notifikasi Otorisasi</title>
</head>
<body style="margin:0; padding:0; font-family: 'Segoe UI', Arial, sans-serif; background-color:#eef2f7; color:#333;">

    <table width="100%" cellspacing="0" cellpadding="0" style="padding:40px 0; background-color:#eef2f7;">
        <tr>
            <td align="center">
                <table width="600" cellspacing="0" cellpadding="0" style="background-color:#ffffff; border-radius:12px; overflow:hidden; box-shadow:0 6px 18px rgba(0,0,0,0.1);">
                    
                    <!-- Header -->
                    <tr>
                        <td style="background:linear-gradient(135deg, #4f46e5, #6366f1); padding:25px; text-align:center; color:#fff;">
                            <h1 style="margin:0; font-size:22px;">Sistem Aplikasi</h1>
                            <p style="margin:5px 0 0; font-size:14px; opacity:0.9;">Notifikasi Otorisasi</p>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:35px;">
                            <h2 style="margin-top:0; color:#111; font-size:18px;">Halo, <?= $user['nama_user']; ?> 👋</h2>
                            <p style="line-height:1.8; font-size:15px; color:#444;">
                                Anda telah diberikan <strong>otorisasi akses</strong> pada sistem aplikasi.
                                Detail otorisasi Anda adalah sebagai berikut:
                            </p>

                            <table border="0" cellspacing="0" cellpadding="0" width="100%" style="margin:20px 0; border-collapse:collapse; font-size:14px;">
                                <tr>
                                    <td style="padding:10px; border:1px solid #ddd; background:#f9fafb;">Role / Hak Akses</td>
                                    <td style="padding:10px; border:1px solid #ddd;">Dapat mengedit dan menghapus data</td>
                                </tr>
                                <tr>
                                    <td style="padding:10px; border:1px solid #ddd; background:#f9fafb;">Batas Tanggal Otorisasi</td>
                                    <td style="padding:10px; border:1px solid #ddd;"><?= formatTanggalIndo($akses['batas']) .' pukul '.date('H:i:s',strtotime($akses['batas'])).' WIB.'; ?></td>
                                </tr>
                            </table>

                            <p style="font-size:14px; line-height:1.8; color:#444;">
                                Silakan pergunakan hak otorisasi anda dengan bijak. klik tombol di bawah ini untuk masuk ke sistem:
                            </p>

                            <p style="text-align:center; margin:30px 0;">
                                <a href="https://forboysproduction.com/Dash/welcome" 
                                   style="background:#4f46e5; color:#fff; text-decoration:none; padding:14px 30px; border-radius:8px; font-size:15px; display:inline-block; font-weight:500;">
                                    Masuk ke Sistem
                                </a>
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background:#f9fafb; padding:18px; text-align:center; font-size:12px; color:#666;">
                            Email ini dikirim otomatis oleh sistem. Mohon tidak membalas email ini.<br>
                            &copy; <?= date('Y'); ?> Forboys Production System
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>
</html>
