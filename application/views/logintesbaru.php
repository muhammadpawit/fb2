<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Login - Forboys Production</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #6366f1;
            --primary-hover: #4f46e5;
            --gray-500: #64748b;
            --gray-300: #cbd5e1;
            --gray-100: #f1f5f9;
            --dark: #0f172a;
            --shadow: 0 30px 70px rgba(0,0,0,.15);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg,#f5f7fa,#c3cfe2);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        /* TOP PROGRESS BAR */
        #top-progress {
            position: fixed;
            top: 0;
            left: 0;
            height: 3px;
            width: 0%;
            background: linear-gradient(90deg,#6366f1,#22d3ee);
            z-index: 9999;
            transition: width .3s ease;
        }

        /* FULLSCREEN LOADING */
        #loading-overlay {
            position: fixed;
            inset: 0;
            background: rgba(255,255,255,.85);
            backdrop-filter: blur(6px);
            display: none;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            z-index: 9998;
        }

        #loading-overlay.active {
            display: flex;
        }

        .spinner {
            width: 56px;
            height: 56px;
            border: 6px solid #e5e7eb;
            border-top-color: var(--primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-bottom: 14px;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .loading-text {
            font-size: 14px;
            font-weight: 600;
            color: var(--dark);
        }

        /* CARD */
        .login-wrapper { width: 100%; max-width: 1000px; }

        .login-card {
            display: flex;
            background: white;
            border-radius: 26px;
            overflow: hidden;
            box-shadow: var(--shadow);
            animation: fadeUp .6s ease;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* LEFT */
        .login-illustration {
            width: 45%;
            background: linear-gradient(135deg,#6366f1,#4f46e5);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px;
        }

        .login-illustration img {
            width: 120px;
            margin-bottom: 20px;
        }

        .login-illustration h2 { font-size: 26px; margin-bottom: 10px; }
        .login-illustration p { font-size: 14px; opacity: .9; }

        /* RIGHT */
        .login-form { width: 55%; padding: 48px 40px; }

        .brand { text-align: center; margin-bottom: 28px; }
        .brand img { height: 70px; margin-bottom: 10px; }
        .brand h1 { font-size: 22px; color: var(--dark); }
        .brand p { font-size: 14px; color: var(--gray-500); }

        /* TOGGLE */
        .login-toggle {
            display: flex;
            background: var(--gray-100);
            border-radius: 12px;
            padding: 6px;
            margin-bottom: 28px;
        }

        .toggle-btn {
            flex: 1;
            padding: 12px;
            border: none;
            background: transparent;
            font-weight: 600;
            cursor: pointer;
            border-radius: 10px;
            color: var(--gray-500);
        }

        .toggle-btn.active {
            background: white;
            color: var(--primary);
            box-shadow: 0 4px 10px rgba(0,0,0,.1);
        }

        /* PANELS */
        .login-panel { display: none; animation: fadeSlide .4s ease; }
        .login-panel.active { display: block; }

        @keyframes fadeSlide {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* FORM */
        .form-group { margin-bottom: 20px; }
        .form-label { font-size: 14px; font-weight: 600; margin-bottom: 8px; display: block; }

        .form-input {
            width: 100%;
            padding: 14px 16px;
            border-radius: 12px;
            border: 2px solid var(--gray-300);
            font-size: 14px;
        }

        .btn-primary {
            width: 100%;
            padding: 14px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
        }

        /* GOOGLE BUTTON (FIX SIZE) */
        .btn-google {
            width: 100%;
            padding: 14px;
            border-radius: 12px;
            border: 2px solid var(--gray-300);
            background: #fff;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            cursor: pointer;
        }

        .btn-google img {
            width: 18px;
            height: 18px;
            display: block;
        }

        .btn-google:hover {
            border-color: var(--primary);
        }

        .footer {
            margin-top: 28px;
            text-align: center;
            font-size: 13px;
            color: var(--gray-500);
        }

        @media (max-width: 900px) {
            .login-card { flex-direction: column; }
            .login-illustration { display: none; }
            .login-form { width: 100%; }
        }
    </style>
</head>

<body>

<div id="top-progress"></div>

<div id="loading-overlay">
    <div class="spinner"></div>
    <div class="loading-text">Memproses login...</div>
</div>

<div class="login-wrapper">
    <div class="login-card">

        <div class="login-illustration">
            <div>
                <img src="<?php echo BASEURL ?>/assets/images/0001.png">
                <h2>Forboys Production</h2>
                <p>Sistem Produksi Terintegrasi</p>
            </div>
        </div>

        <div class="login-form">

            <div class="brand">
                <img src="<?php echo BASEURL ?>/assets/images/0001.png">
                <h1>Forboys Production</h1>
                <p>Production Management System</p>
            </div>

            <div class="login-toggle">
                <button class="toggle-btn active" data-target="email">Email</button>
                <button class="toggle-btn" data-target="google">Google</button>
            </div>

            <div class="login-panel active" id="email">
                <form method="POST" action="<?php echo BASEURL; ?>Auth/login">
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-input" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-input" required>
                    </div>

                    <button class="btn-primary">Masuk ke Dashboard</button>
                </form>
            </div>

            <div class="login-panel" id="google">
                <button class="btn-google" id="btnGoogle">
                    <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google">
                    Login dengan Google
                </button>
            </div>

            <div class="footer">
                &copy; <?php echo date('Y') ?> Forboys Production
            </div>

        </div>
    </div>
</div>

<script>
    // Toggle Email / Google
    document.querySelectorAll('.toggle-btn').forEach(btn => {
        btn.onclick = () => {
            document.querySelectorAll('.toggle-btn').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.login-panel').forEach(p => p.classList.remove('active'));
            btn.classList.add('active');
            document.getElementById(btn.dataset.target).classList.add('active');
        };
    });

    function startLoading() {
        document.getElementById('loading-overlay').classList.add('active');
        const bar = document.getElementById('top-progress');
        bar.style.width = '25%';
        setTimeout(() => bar.style.width = '60%', 300);
        setTimeout(() => bar.style.width = '90%', 700);
    }

    document.querySelector('#email form').addEventListener('submit', startLoading);

    document.getElementById('btnGoogle').addEventListener('click', function () {
        startLoading();
        window.location.href = "<?php echo $auth_url; ?>";
    });
</script>

</body>
</html>
