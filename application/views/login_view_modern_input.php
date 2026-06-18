<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Forboys Production System</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<style>

:root{
    --primary:#1565d8;
    --primary-dark:#0d4cb1;

    --text:#101828;
    --muted:#667085;

    --border:#e4e7ec;

    --bg:#f7f9fc;

    --radius:24px;

    --shadow:
        0 10px 30px rgba(16,24,40,.08),
        0 30px 60px rgba(16,24,40,.08);
}

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:'Inter',sans-serif;
    background:var(--bg);
    color:var(--text);
}

.wrapper{
    min-height:100vh;
    padding:24px;
}

.container{
    max-width:1280px;
    margin:auto;

    display:grid;
    grid-template-columns:1.3fr 480px;
    gap:32px;

    align-items:center;
    min-height:calc(100vh - 48px);
}

.hero{
    position:relative;
    overflow:hidden;
    border-radius:32px;
    min-height:720px;
    box-shadow:var(--shadow);
}

.slide{
    position:absolute;
    inset:0;

    opacity:0;
    transition:.7s ease;
}

.slide.active{
    opacity:1;
}

.slide img{
    width:100%;
    height:100%;
    object-fit:cover;
}

.slide::after{
    content:'';

    position:absolute;
    inset:0;

    background:
        linear-gradient(
            180deg,
            rgba(0,0,0,.15),
            rgba(0,0,0,.35),
            rgba(0,0,0,.75)
        );
}

.hero-content{
    position:absolute;

    left:40px;
    right:40px;
    bottom:40px;

    z-index:10;
    color:white;
}

.badge{
    display:inline-flex;

    align-items:center;
    gap:8px;

    padding:10px 16px;

    border-radius:999px;

    background:rgba(255,255,255,.15);
    backdrop-filter:blur(15px);

    font-size:13px;
    font-weight:700;

    margin-bottom:20px;
}

.hero-title{
    font-size:56px;
    line-height:1.1;
    font-weight:800;

    max-width:650px;

    margin-bottom:18px;
}

.hero-desc{
    font-size:18px;
    line-height:1.8;

    color:rgba(255,255,255,.85);

    max-width:600px;
}

.hero-stats{
    display:flex;
    gap:12px;

    margin-top:28px;
}

.stat{
    flex:1;

    padding:16px;

    border-radius:18px;

    background:rgba(255,255,255,.12);
    backdrop-filter:blur(20px);
}

.stat strong{
    display:block;
    font-size:22px;
}

.stat span{
    font-size:13px;
    opacity:.8;
}

.dots{
    position:absolute;

    bottom:20px;
    right:20px;

    display:flex;
    gap:8px;

    z-index:15;
}

.dot{
    width:12px;
    height:12px;

    border-radius:50%;

    background:rgba(255,255,255,.4);
    cursor:pointer;
}

.dot.active{
    background:white;
}

.login-area{
    position:relative;
}

.login-card{
    background:white;

    border-radius:32px;

    padding:40px;

    box-shadow:var(--shadow);
}

.logo{
    width:70px;
    height:70px;

    border-radius:20px;

    background:#fff;
    border:1px solid var(--border);

    display:flex;
    justify-content:center;
    align-items:center;

    margin-bottom:24px;
}

.logo img{
    width:48px;
}

.label{
    display:inline-flex;

    align-items:center;
    gap:8px;

    padding:8px 14px;

    border-radius:999px;

    background:#eef5ff;
    color:var(--primary);

    font-size:12px;
    font-weight:700;
}

.title{
    font-size:38px;
    font-weight:800;

    margin-top:18px;
}

.subtitle{
    color:var(--muted);

    line-height:1.8;

    margin-top:12px;
    margin-bottom:30px;
}

.info{
    padding:18px;

    border-radius:18px;

    background:#f8fafc;

    border:1px solid var(--border);

    margin-bottom:24px;
}

.info h3{
    margin-bottom:8px;
    font-size:17px;
}

.info p{
    color:var(--muted);
    line-height:1.7;
    font-size:14px;
}

.google-btn{
    width:100%;
    height:60px;

    border:none;

    border-radius:18px;

    background:white;

    border:1px solid var(--border);

    cursor:pointer;

    display:flex;
    justify-content:center;
    align-items:center;
    gap:14px;

    font-size:15px;
    font-weight:700;

    transition:.25s;
}

.google-btn:hover{
    transform:translateY(-2px);

    box-shadow:
        0 10px 25px rgba(21,101,216,.15);
}

.google-btn svg{
    width:22px;
}

.security{
    margin-top:20px;

    text-align:center;

    color:var(--muted);

    font-size:13px;
}

.footer{
    margin-top:30px;

    padding-top:20px;

    border-top:1px solid var(--border);

    text-align:center;

    color:var(--muted);
    font-size:13px;
}

/* MOBILE */

@media(max-width:992px){

    .container{
        grid-template-columns:1fr;
        gap:0;
    }

    .hero{
        min-height:320px;
        border-radius:28px;
    }

    .hero-title{
        font-size:30px;
    }

    .hero-desc{
        font-size:14px;
    }

    .hero-content{
        left:24px;
        right:24px;
        bottom:24px;
    }

    .hero-stats{
        display:none;
    }

    .login-area{
        margin-top:-40px;
        z-index:20;
    }

    .login-card{
        border-radius:28px;
        padding:28px;
    }

    .title{
        font-size:28px;
    }
}

@media(max-width:576px){

    .wrapper{
        padding:14px;
    }

    .hero{
        min-height:260px;
    }

    .hero-title{
        font-size:24px;
    }

    .hero-desc{
        display:none;
    }

    .login-card{
        padding:22px;
    }
} 

.spinner {
    width: 20px;
    height: 20px;
    border: 3px solid rgba(21,101,216,0.3);
    border-radius: 50%;
    border-top-color: var(--primary);
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

                <span class="label">
                    Akses Sistem
                </span>

                <h2 class="title">
                    Selamat Datang Kembali
                </h2>

                <p class="subtitle">
                    Masuk ke Forboys Production System untuk
                    melanjutkan aktivitas dan memantau operasional produksi.
                </p>

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