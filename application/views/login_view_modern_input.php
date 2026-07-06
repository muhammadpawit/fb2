<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Forboys Production System</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Inter', sans-serif;
    background: #f8f9fa;
    color: #101828;
}

.wrapper {
    min-height: 100vh;
    display: flex;
    width: 100%;
}

.container {
    display: flex;
    width: 100%;
    min-height: 100vh;
}

.hero {
    flex: 1;
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}

.slide {
    position: absolute;
    inset: 0;
    opacity: 0;
    transition: .7s ease;
}

.slide.active {
    opacity: 1;
}

.slide img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.slide::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, rgba(0,0,0,0.1), rgba(0,0,0,0.5));
}

.hero-content {
    position: relative;
    z-index: 10;
    color: white;
    text-align: center;
    padding: 40px;
}

.hero-title {
    font-size: 36px;
    font-weight: 800;
    margin-bottom: 16px;
}

.hero-desc {
    font-size: 16px;
    opacity: 0.9;
    max-width: 450px;
    margin: 0 auto;
    line-height: 1.6;
}

/* Hide unneeded elements for simpler UI */
.badge, .hero-stats {
    display: none;
}

.dots {
    position: absolute;
    bottom: 30px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 8px;
    z-index: 15;
}

.dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: rgba(255,255,255,0.4);
    cursor: pointer;
}

.dot.active {
    background: white;
}

.login-area {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: #f8f9fa;
    padding: 24px;
}

.login-card {
    background: white;
    border-radius: 16px;
    padding: 40px;
    width: 100%;
    max-width: 420px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.04);
    text-align: center;
}

.logo {
    width: auto;
    height: auto;
    margin: 0 auto 30px auto;
    background: transparent;
    border: none;
    display: flex;
    justify-content: center;
    align-items: center;
}

.logo img {
    max-width: 200px;
    height: auto;
}

.label {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 20px;
    background: #eef5ff;
    color: #1565d8;
    font-size: 12px;
    font-weight: 600;
    margin-bottom: 16px;
}

.title {
    font-size: 26px;
    font-weight: 700;
    margin-bottom: 8px;
}

.subtitle {
    color: #667085;
    font-size: 14px;
    line-height: 1.6;
    margin-bottom: 24px;
}

.info {
    text-align: left;
    background: #f8fafc;
    border: 1px solid #e4e7ec;
    border-radius: 12px;
    padding: 16px;
    margin-bottom: 24px;
}

.info h3 {
    font-size: 14px;
    margin-bottom: 6px;
    color: #101828;
}

.info p {
    font-size: 13px;
    color: #667085;
    line-height: 1.5;
}

.google-btn {
    width: 100%;
    height: 52px;
    border: 1px solid #e4e7ec;
    border-radius: 12px;
    background: white;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 12px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.2s;
    color: #101828;
}

.google-btn:hover {
    background: #f9fafb;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

.google-btn svg {
    width: 20px;
}

.security {
    margin-top: 16px;
    font-size: 12px;
    color: #667085;
}

.footer {
    margin-top: 24px;
    padding-top: 16px;
    border-top: 1px solid #e4e7ec;
    font-size: 12px;
    color: #667085;
}

.version {
    margin-top: 24px;
    font-size: 13px;
    color: #98a2b3;
    font-weight: 500;
}

@media(max-width: 992px) {
    .container {
        flex-direction: column;
    }
    
    .hero {
        min-height: 40vh;
        width: 100%;
        flex: none;
    }
    
    .login-area {
        width: 100%;
        min-height: 60vh;
        flex: none;
    }
}

@media(max-width: 576px) {
    .login-card {
        padding: 30px 24px;
    }
    .hero-title {
        font-size: 28px;
    }
    .hero-desc {
        font-size: 14px;
    }
}

.spinner {
    width: 18px;
    height: 18px;
    border: 2px solid rgba(21,101,216,0.2);
    border-radius: 50%;
    border-top-color: #1565d8;
    animation: spin 1s ease-in-out infinite;
    display: inline-block;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}
</style>
</head>
<body>

<div class="wrapper">

    <div class="container">

        <section class="hero">

            <?php if (!empty($carousels)): ?>
                <?php $i = 0; foreach ($carousels as $c): ?>
                    <div class="slide <?php echo ($i == 0) ? 'active' : ''; ?>">
                        <img src="<?php echo BASEURL . 'assets/images/carousel/' . $c['image']; ?>" alt="<?php echo isset($c['alt_text']) ? $c['alt_text'] : ''; ?>">
                    </div>
                <?php $i++; endforeach; ?>
            <?php else: ?>
                <div class="slide active">
                    <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f">
                </div>
            <?php endif; ?>

            <div class="hero-content">

                <div class="badge">
                    Forboys Production System
                </div>

                <h1 class="hero-title">
                    Kelola Produksi Lebih Cepat dan Terintegrasi
                </h1>

                <p class="hero-desc">
                    Pantau order, bahan baku, progress produksi,
                    pengiriman, hingga laporan harian dalam satu sistem.
                </p>

                <div class="hero-stats">

                    <div class="stat">
                        <strong>24/7</strong>
                        <span>Monitoring</span>
                    </div>

                    <div class="stat">
                        <strong>100%</strong>
                        <span>Terintegrasi</span>
                    </div>

                    <div class="stat">
                        <strong>Realtime</strong>
                        <span>Update Data</span>
                    </div>

                </div>

            </div>

            <div class="dots">
                <?php if (!empty($carousels)): ?>
                    <?php for ($i = 0; $i < count($carousels); $i++): ?>
                        <div class="dot <?php echo ($i == 0) ? 'active' : ''; ?>"></div>
                    <?php endfor; ?>
                <?php else: ?>
                    <div class="dot active"></div>
                <?php endif; ?>
            </div>

        </section>

        <section class="login-area">

            <div class="login-card">

                <div class="logo">
                    <img src="https://forboysproduction.com//assets/images/0001.png" alt="Logo">
                </div>

                <div class="info">
                    <h3>Masuk dengan Google</h3>
                    <p>
                        Gunakan akun Google yang sudah terdaftar
                        untuk mengakses sistem dengan aman dan cepat.
                    </p>
                </div>

                <button type="button" class="google-btn" id="btn-login-google" onclick="loginGoogle()">

                    <svg viewBox="0 0 24 24">
                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                    </svg>

                    Lanjutkan dengan Google

                </button>

                <div class="security">
                    🔒 Login aman menggunakan Google OAuth
                </div>

                <div class="footer">
                    © 2020 - 2026 Forboys Production
                </div>

            </div>

            <div class="version">
                Versi 2.1.1.0
            </div>

        </section>

    </div>

</div>

<script>

const slides=document.querySelectorAll('.slide');
const dots=document.querySelectorAll('.dot');

let current=0;

function showSlide(index){

    slides.forEach(s=>s.classList.remove('active'));
    dots.forEach(d=>d.classList.remove('active'));

    slides[index].classList.add('active');
    dots[index].classList.add('active');

    current=index;
}

dots.forEach((dot,index)=>{
    dot.addEventListener('click',()=>{
        showSlide(index);
    });
});

setInterval(()=>{
    current=(current+1)%slides.length;
    showSlide(current);
},5000);

function loginGoogle() {
    const btn = document.getElementById('btn-login-google');
    btn.disabled = true;
    btn.innerHTML = '<div class="spinner"></div> Memuat...';
    window.location.href = '<?php echo $auth_url; ?>';
}

</script>

</body>
</html>