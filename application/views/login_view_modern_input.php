<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <title>Login - Forboys Production System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta content="Aplikasi Sistem Produksi untuk Forboys Production" name="description" />
    <meta content="Forboys Production" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link rel="shortcut icon" href="<?php echo ASSETS; ?>images/favicon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --ink: #111827;
            --muted: #667085;
            --line: #d9e2ec;
            --panel: rgba(255, 255, 255, 0.94);
            --panel-strong: #ffffff;
            --brand: #1267d9;
            --brand-dark: #0b4fb4;
            --brand-soft: #e8f2ff;
            --mint: #1aa179;
            --amber: #f59e0b;
            --danger: #dc2626;
            --radius: 18px;
            --shadow: 0 24px 70px rgba(16, 24, 40, 0.16);
        }

        * { box-sizing: border-box; }

        html { min-height: 100%; }

        body {
            min-height: 100vh;
            margin: 0;
            font-family: 'Inter', Arial, sans-serif;
            color: var(--ink);
            background:
                linear-gradient(130deg, rgba(8, 47, 73, 0.82), rgba(18, 103, 217, 0.45)),
                url('<?php echo ASSETS; ?>images/bg-2.jpg') center/cover no-repeat fixed;
            overflow-x: hidden;
        }

        body::before,
        body::after {
            content: '';
            position: fixed;
            width: 340px;
            height: 340px;
            border-radius: 999px;
            pointer-events: none;
            z-index: 0;
            opacity: 0.34;
            filter: blur(10px);
            animation: drift 14s ease-in-out infinite alternate;
        }

        body::before {
            top: -120px;
            right: -90px;
            background: rgba(26, 161, 121, 0.74);
        }

        body::after {
            bottom: -150px;
            left: -120px;
            background: rgba(245, 158, 11, 0.58);
            animation-delay: -5s;
        }

        @keyframes drift {
            from { transform: translate3d(0, 0, 0) scale(1); }
            to { transform: translate3d(26px, -18px, 0) scale(1.08); }
        }

        .login-shell {
            position: relative;
            z-index: 1;
            width: min(1120px, calc(100% - 32px));
            min-height: 100vh;
            margin: 0 auto;
            display: grid;
            grid-template-columns: minmax(0, 1.05fr) minmax(360px, 440px);
            align-items: center;
            gap: 32px;
            padding: 40px 0;
        }

        .hero-panel {
            min-height: 620px;
            border-radius: 28px;
            padding: 24px;
            color: #ffffff;
            background:
                linear-gradient(145deg, rgba(6, 34, 59, 0.74), rgba(5, 55, 96, 0.34)),
                url('<?php echo ASSETS; ?>images/bg-1.jpg') center/cover no-repeat;
            box-shadow: var(--shadow);
            overflow: hidden;
            position: relative;
        }

        .hero-panel::after {
            content: '';
            position: absolute;
            inset: auto -20% -24% 32%;
            height: 260px;
            background: linear-gradient(90deg, rgba(26, 161, 121, 0.5), rgba(245, 158, 11, 0.42));
            border-radius: 999px;
            transform: rotate(-8deg);
        }

        .hero-carousel,
        .carousel-slide,
        .carousel-content,
        .carousel-dots {
            position: relative;
            z-index: 1;
        }

        .hero-carousel {
            height: 100%;
            min-height: 572px;
            border-radius: 22px;
            overflow: hidden;
            background: #0f172a;
        }

        .carousel-slide {
            position: absolute;
            inset: 0;
            opacity: 0;
            transform: scale(1.03);
            transition: opacity 0.75s ease, transform 1.1s ease;
        }

        .carousel-slide.active {
            opacity: 1;
            transform: scale(1);
        }

        .carousel-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .carousel-slide::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(4, 19, 34, 0.2), rgba(4, 19, 34, 0.46) 48%, rgba(4, 19, 34, 0.86));
        }

        .brand-chip {
            position: absolute;
            top: 20px;
            left: 20px;
            z-index: 2;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 8px 12px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.24);
            backdrop-filter: blur(16px);
            font-size: 13px;
            font-weight: 700;
        }

        .brand-chip img {
            width: 28px;
            height: 28px;
            object-fit: contain;
            border-radius: 8px;
            background: #ffffff;
            padding: 3px;
        }

        .carousel-content {
            position: absolute;
            left: 28px;
            right: 28px;
            bottom: 72px;
            max-width: 560px;
            z-index: 2;
        }

        .hero-copy {
            max-width: 560px;
            margin: 0;
            font-size: 17px;
            line-height: 1.7;
            color: rgba(255, 255, 255, 0.86);
        }

        .carousel-dots {
            position: absolute;
            left: 28px;
            bottom: 28px;
            display: inline-flex;
            gap: 9px;
            z-index: 2;
        }

        .carousel-dot {
            width: 32px;
            height: 4px;
            padding: 0;
            border: 0;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.38);
            cursor: pointer;
        }

        .carousel-dot.active {
            background: #ffffff;
        }

        .login-card {
            width: 100%;
            min-height: 620px;
            border-radius: 24px;
            padding: 30px;
            background: var(--panel);
            box-shadow: var(--shadow);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.72);
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .mobile-brand {
            display: none;
            align-items: center;
            gap: 12px;
            margin-bottom: 22px;
        }

        .mobile-brand img {
            width: 48px;
            height: 48px;
            object-fit: contain;
        }

        .mobile-brand strong {
            display: block;
            font-size: 18px;
        }

        .mobile-brand span {
            display: block;
            margin-top: 3px;
            color: var(--muted);
            font-size: 13px;
        }

        .card-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 7px 11px;
            border-radius: 999px;
            background: var(--brand-soft);
            color: var(--brand-dark);
            font-size: 12px;
            font-weight: 800;
            margin-bottom: 16px;
        }

        .card-eyebrow::before {
            content: '';
            width: 8px;
            height: 8px;
            border-radius: 999px;
            background: var(--mint);
            box-shadow: 0 0 0 5px rgba(26, 161, 121, 0.14);
        }

        .card-title {
            margin: 0;
            font-size: 30px;
            line-height: 1.15;
            font-weight: 800;
        }

        .card-copy {
            margin: 10px 0 24px;
            color: var(--muted);
            line-height: 1.65;
            font-size: 14px;
        }

        .alert {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 13px 14px;
            margin-bottom: 18px;
            border-radius: 14px;
            background: #fff1f2;
            border: 1px solid #fecdd3;
            color: #9f1239;
            font-size: 14px;
            font-weight: 700;
        }

        .alert svg {
            width: 18px;
            height: 18px;
            flex: 0 0 auto;
            margin-top: 1px;
        }

        .btn {
            width: 100%;
            min-height: 52px;
            border-radius: 14px;
            border: 0;
            font: inherit;
            font-size: 15px;
            font-weight: 800;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-decoration: none;
            transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
        }

        .btn svg {
            width: 20px;
            height: 20px;
        }

        .btn-google {
            background: #ffffff;
            color: #344054;
            border: 1px solid var(--line);
            box-shadow: 0 10px 26px rgba(16, 24, 40, 0.06);
        }

        .btn:hover { transform: translateY(-1px); }

        .btn.loading {
            pointer-events: none;
            opacity: 0.78;
        }

        .btn.loading .spinner { display: block; }

        .btn.loading .btn-icon { display: none; }

        .spinner {
            display: none;
            width: 18px;
            height: 18px;
            border-radius: 999px;
            border: 2px solid rgba(255, 255, 255, 0.46);
            border-top-color: #ffffff;
            animation: spin 0.75s linear infinite;
        }

        .btn-google .spinner {
            border-color: rgba(18, 103, 217, 0.18);
            border-top-color: var(--brand);
        }

        @keyframes spin { to { transform: rotate(360deg); } }

        .google-copy {
            padding: 18px;
            margin-bottom: 16px;
            border-radius: 16px;
            background: #f8fbff;
            border: 1px solid #e5edf5;
        }

        .google-copy h2 {
            margin: 0 0 8px;
            font-size: 18px;
        }

        .google-copy p {
            margin: 0;
            color: var(--muted);
            font-size: 14px;
            line-height: 1.6;
        }

        .secure-note {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 16px;
            color: #526070;
            font-size: 12px;
            font-weight: 700;
        }

        .secure-note svg {
            width: 16px;
            height: 16px;
            color: var(--mint);
        }

        .card-footer {
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid #e5edf5;
            color: #758195;
            text-align: center;
            font-size: 12px;
            font-weight: 700;
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.001ms !important;
                animation-iteration-count: 1 !important;
                scroll-behavior: auto !important;
            }
        }

        @media (max-width: 920px) {
            body {
                background:
                    linear-gradient(130deg, rgba(8, 47, 73, 0.78), rgba(18, 103, 217, 0.5)),
                    url('<?php echo ASSETS; ?>images/bg-2.jpg') center/cover no-repeat fixed;
            }

            .login-shell {
                min-height: 100svh;
                grid-template-columns: 1fr;
                width: min(520px, calc(100% - 28px));
                padding: 28px 0;
            }

            .hero-panel { display: none; }

            .mobile-brand { display: flex; }

            .login-card {
                min-height: auto;
                padding: 24px;
                border-radius: 22px;
            }
        }

        @media (max-width: 480px) {
            .login-shell {
                width: calc(100% - 22px);
                padding: 16px 0;
                align-items: start;
            }

            .login-card {
                padding: 20px;
                border-radius: 20px;
            }

            .card-title { font-size: 25px; }

            .card-copy { margin-bottom: 20px; }

        }
    </style>
</head>

<body>
    <main class="login-shell">
        <section class="hero-panel" aria-label="Forboys Production">
            <div class="hero-carousel" id="heroCarousel">
                <div class="brand-chip">
                    <img src="<?php echo BASEURL; ?>/assets/images/0001.png" alt="Forboys Production">
                    <span>Forboys Production</span>
                </div>

                <div class="carousel-slide active">
                    <img src="<?php echo ASSETS; ?>images/small/img-7.jpg" alt="Suasana produksi Forboys">
                </div>
                <div class="carousel-slide">
                    <img src="<?php echo ASSETS; ?>images/small/img-5.jpg" alt="Proses kerja produksi">
                </div>
                <div class="carousel-slide">
                    <img src="<?php echo ASSETS; ?>images/attached-files/img-3.jpg" alt="Koordinasi operasional">
                </div>

                <div class="carousel-content">
                    <p class="hero-copy">Pantau order, bahan, setoran, dan laporan harian tanpa harus bolak-balik tanya update. Semua dibuat lebih dekat dengan ritme kerja tim.</p>
                </div>

                <div class="carousel-dots" aria-label="Navigasi gambar">
                    <button type="button" class="carousel-dot active" data-slide="0" aria-label="Gambar 1"></button>
                    <button type="button" class="carousel-dot" data-slide="1" aria-label="Gambar 2"></button>
                    <button type="button" class="carousel-dot" data-slide="2" aria-label="Gambar 3"></button>
                </div>
            </div>
        </section>

        <section class="login-card" aria-label="Form login">
            <div class="mobile-brand">
                <img src="<?php echo BASEURL; ?>/assets/images/0001.png" alt="Forboys Production">
                <div>
                    <strong>Forboys Production</strong>
                    <span>Production Management System</span>
                </div>
            </div>

            <?php if ($this->session->flashdata('gagal')) { ?>
            <div class="alert" id="alertBox" role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
                </svg>
                <span><?php echo $this->session->flashdata('gagal'); ?></span>
            </div>
            <?php } ?>

            <span class="card-eyebrow">Akses sistem</span>
            <h2 class="card-title">Selamat datang kembali</h2>
            <p class="card-copy">Pilih metode masuk yang paling nyaman untuk melanjutkan pekerjaan Anda.</p>

            <div class="google-copy">
                <h2>Masuk lebih cepat</h2>
                <p>Gunakan akun Google yang sudah terdaftar di sistem Forboys untuk melanjutkan tanpa mengetik password manual.</p>
            </div>

            <button class="btn btn-google" id="googleLoginBtn" type="button">
                <span class="spinner" aria-hidden="true"></span>
                <svg class="btn-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                </svg>
                <span class="btn-text">Lanjutkan dengan Google</span>
            </button>

            <div class="secure-note">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.62-4.02A11.96 11.96 0 0112 2.94a11.96 11.96 0 01-8.62 3.04A12.02 12.02 0 003 9c0 5.59 3.82 10.29 9 11.62 5.18-1.33 9-6.03 9-11.62 0-1.04-.13-2.05-.38-3.02z" />
                </svg>
                <span>Login aman melalui Google OAuth</span>
            </div>

            <div class="card-footer">
                &copy; 2020 - <?php echo date('Y'); ?> Forboys Production
            </div>
        </section>
    </main>

    <script src="<?php echo ASSETS; ?>js/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            if ($('#alertBox').length) {
                setTimeout(function() {
                    $('#alertBox').fadeOut(350, function() {
                        $(this).remove();
                    });
                }, 5000);
            }

            var carouselIndex = 0;
            var carouselSlides = $('.carousel-slide');
            var carouselDots = $('.carousel-dot');

            function showCarouselSlide(index) {
                carouselIndex = index;
                carouselSlides.removeClass('active').eq(index).addClass('active');
                carouselDots.removeClass('active').eq(index).addClass('active');
            }

            carouselDots.on('click', function() {
                showCarouselSlide($(this).data('slide'));
            });

            if (carouselSlides.length > 1) {
                setInterval(function() {
                    showCarouselSlide((carouselIndex + 1) % carouselSlides.length);
                }, 4500);
            }

            $('#googleLoginBtn').on('click', function() {
                var btn = $(this);

                btn.addClass('loading').prop('disabled', true);
                btn.find('.btn-text').text('Menghubungkan...');

                setTimeout(function() {
                    window.location.href = "<?php echo $auth_url; ?>";
                }, 500);
            });
        });
    </script>
</body>
</html>
