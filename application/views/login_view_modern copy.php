<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <title>Login - Forboys Production System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta content="Aplikasi Sistem Produksi untuk Forboys Production" name="description" />
    <meta content="Forboys Production" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link rel="shortcut icon" href="<?php echo ASSETS; ?>images/favicon.ico">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #6366f1;
            --primary-hover: #4f46e5;
            --primary-light: #818cf8;
            --accent: #ec4899;
            --success: #10b981;
            --danger: #ef4444;
            --dark: #0f172a;
            --gray-900: #1e293b;
            --gray-700: #334155;
            --gray-500: #64748b;
            --gray-300: #cbd5e1;
            --gray-100: #f1f5f9;
            --white: #ffffff;
            --shadow: 0 20px 50px rgba(0, 0, 0, 0.08);
            --shadow-hover: 0 25px 60px rgba(99, 102, 241, 0.15);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, #4895ef 0%, transparent 70%);
            opacity: 0.2;
            z-index: 0;
            animation: float 15s infinite alternate;
        }

        body::after {
            content: '';
            position: absolute;
            bottom: -50%;
            left: -50%;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, #f72585 0%, transparent 70%);
            opacity: 0.1;
            z-index: 0;
            animation: float 18s infinite alternate-reverse;
        }

        @keyframes float {
            0% {
                transform: translate(0, 0);
            }
            50% {
                transform: translate(-10%, -10%);
            }
            100% {
                transform: translate(10%, 10%);
            }
        }

        /* Login Container */
        .login-wrapper {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 440px;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 48px 40px;
            box-shadow: var(--shadow);
            animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(40px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* Logo & Brand */
        .brand-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .brand-header img {
            filter: drop-shadow(0 4px 12px rgba(0, 0, 0, 0.1));
        }

        .brand-title {
            font-size: 26px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 6px;
            letter-spacing: -0.5px;
        }

        .brand-subtitle {
            font-size: 15px;
            color: var(--gray-500);
            font-weight: 500;
        }

        /* Alert */
        .alert {
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            color: #991b1b;
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            font-weight: 500;
            animation: alertSlide 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes alertSlide {
            from {
                opacity: 0;
                transform: translateY(-15px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert::before {
            content: "⚠";
            font-size: 18px;
        }

        /* Login Methods Toggle */
        .login-methods {
            display: flex;
            gap: 12px;
            margin-bottom: 28px;
            background: var(--gray-100);
            padding: 6px;
            border-radius: 12px;
        }

        .method-btn {
            flex: 1;
            padding: 12px;
            border: none;
            background: transparent;
            color: var(--gray-700);
            font-size: 14px;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .method-btn svg {
            width: 18px;
            height: 18px;
        }

        .method-btn.active {
            background: white;
            color: var(--primary);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .method-btn:not(.active):hover {
            color: var(--primary);
        }

        /* Login Content */
        .login-content {
            position: relative;
        }

        .login-method {
            display: none;
            animation: fadeIn 0.4s ease-out;
        }

        .login-method.active {
            display: block;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            color: var(--gray-700);
            font-weight: 600;
            font-size: 14px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            color: var(--gray-500);
            pointer-events: none;
            transition: color 0.3s;
        }

        .form-input {
            width: 100%;
            padding: 14px 16px 14px 48px;
            border: 2px solid var(--gray-300);
            border-radius: 12px;
            background: white;
            font-size: 15px;
            color: var(--dark);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-family: 'Inter', sans-serif;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        }

        .form-input:focus + .input-icon {
            color: var(--primary);
        }

        .form-input::placeholder {
            color: var(--gray-500);
        }

        .password-toggle {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            padding: 6px;
            color: var(--gray-500);
            transition: color 0.3s;
            display: flex;
            align-items: center;
        }

        .password-toggle:hover {
            color: var(--primary);
        }

        .password-toggle svg {
            width: 20px;
            height: 20px;
        }

        .forgot-link {
            text-align: right;
            margin-top: 8px;
        }

        .forgot-link a {
            color: var(--primary);
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: color 0.3s;
        }

        .forgot-link a:hover {
            color: var(--primary-hover);
        }

        /* Buttons */
        .btn-primary {
            width: 100%;
            padding: 15px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 24px;
            position: relative;
        }

        .btn-primary:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(99, 102, 241, 0.3);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-primary svg {
            width: 20px;
            height: 20px;
            transition: transform 0.3s;
        }

        .btn-primary:hover svg {
            transform: translateX(3px);
        }

        .btn-primary.loading {
            pointer-events: none;
            opacity: 0.7;
        }

        .btn-primary.loading svg {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .btn-google {
            width: 100%;
            padding: 15px;
            background: white;
            color: var(--gray-700);
            border: 2px solid var(--gray-300);
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }

        .btn-google:hover {
            border-color: var(--primary);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .btn-google.loading {
            opacity: 0.7;
            transform: translateY(0);
        }

        .google-icon {
            width: 20px;
            height: 20px;
        }

        /* Welcome Text for Google Login */
        .welcome-message {
            text-align: center;
            margin-bottom: 24px;
        }

        .welcome-title {
            font-size: 22px;
            font-weight: 600;
            color: var(--gray-900);
            margin-bottom: 8px;
        }

        .welcome-text {
            font-size: 14px;
            color: var(--gray-500);
            line-height: 1.6;
        }

        /* Footer */
        .footer {
            text-align: center;
            margin-top: 28px;
            padding-top: 24px;
            border-top: 1px solid var(--gray-300);
        }

        .footer-text {
            font-size: 13px;
            color: var(--gray-500);
            font-weight: 500;
        }

        /* Security Badge */
        .security-info {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 20px;
            padding: 10px;
            background: rgba(99, 102, 241, 0.05);
            border-radius: 8px;
        }

        .security-info svg {
            width: 16px;
            height: 16px;
            color: var(--primary);
        }

        .security-info span {
            font-size: 12px;
            color: var(--gray-600);
            font-weight: 500;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .login-card {
                padding: 36px 28px;
                border-radius: 20px;
            }

            .brand-title {
                font-size: 22px;
            }

            .brand-header img {
                height: 80px;
            }

            .method-btn {
                font-size: 13px;
                padding: 10px;
            }
        }
    </style>
</head>

<body>
    <!-- Animated Background -->
    <div class="bg-shape shape-1"></div>
    <div class="bg-shape shape-2"></div>

    <!-- Login Card -->
    <div class="login-wrapper">
        <div class="login-card">
            <!-- Alert -->
            <?php if ($this->session->flashdata('gagal')) { ?>
            <div class="alert" id="alertBox">
                <?php echo $this->session->flashdata('gagal'); ?>
            </div>
            <?php } ?>

            <!-- Brand Header -->
            <div class="brand-header">
                <img src="<?php echo BASEURL?>/assets/images/0001.png" alt="Forboys Production Logo" style="height: 100px; width: auto; margin: 0 auto 20px; display: block;">
                <h1 class="brand-title">Forboys Production</h1>
                <p class="brand-subtitle">Production Management System</p>
            </div>

            <!-- Login Method Toggle -->
            <div class="login-methods">
                <button class="method-btn active" data-method="email">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <span>Email</span>
                </button>
                <button class="method-btn" data-method="google">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path fill="currentColor" d="M12.545 10.239v3.821h5.445c-0.712 2.315-2.647 3.972-5.445 3.972-3.332 0-6.033-2.701-6.033-6.032s2.701-6.032 6.033-6.032c1.498 0 2.866 0.549 3.921 1.453l2.814-2.814c-1.798-1.677-4.175-2.715-6.735-2.715-5.522 0-10 4.479-10 10s4.478 10 10 10c8.396 0 10-7.496 10-9.999 0-0.781-0.082-1.533-0.23-2.253h-9.77z"/>
                    </svg>
                    <span>Google</span>
                </button>
            </div>

            <!-- Login Content -->
            <div class="login-content">
                <!-- Email Login Method -->
                <div class="login-method active" id="emailMethod">
                    <form method="POST" action="<?php echo BASEURL; ?>Auth/login" id="loginForm">
                        <div class="form-group">
                            <label class="form-label" for="email">Email</label>
                            <div class="input-wrapper">
                                <input type="email" class="form-input" id="email" name="email" placeholder="nama@email.com" required>
                                <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                </svg>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="password">Password</label>
                            <div class="input-wrapper">
                                <input type="password" class="form-input" id="password" name="password" placeholder="Masukkan password" required>
                                <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                <button type="button" class="password-toggle" id="togglePassword">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" id="eyeIcon">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                            <div class="forgot-link">
                                <a href="<?php echo BASEURL; ?>auth/forgot-password">Lupa password?</a>
                            </div>
                        </div>

                        <button type="submit" class="btn-primary" id="loginBtn">
                            <span>Masuk ke Dashboard</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </button>
                    </form>

                    <div class="security-info">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        <span>Koneksi aman dengan enkripsi SSL</span>
                    </div>
                </div>

                <!-- Google Login Method -->
                <div class="login-method" id="googleMethod">
                    <div class="welcome-message">
                        <h2 class="welcome-title">Selamat Datang!</h2>
                        <p class="welcome-text">Masuk dengan akun Google Anda untuk mengakses sistem produksi dengan cepat dan aman</p>
                    </div>

                    <button class="btn-google" id="googleLoginBtn">
                        <svg class="google-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                        </svg>
                        <span>Lanjutkan dengan Google</span>
                    </button>

                    <div class="security-info">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        <span>Login aman melalui Google OAuth</span>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="footer">
                <p class="footer-text">&copy; 2020 - <?php echo date('Y')?> Forboys Production</p>
            </div>
        </div>
    </div>

    <script src="<?php echo ASSETS; ?>js/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // Auto-hide alert
            if ($('#alertBox').length) {
                setTimeout(function() {
                    $('#alertBox').fadeOut(400, function() {
                        $(this).remove();
                    });
                }, 5000);
            }

            // Toggle between login methods
            $('.method-btn').on('click', function() {
                const method = $(this).data('method');
                
                // Update active button
                $('.method-btn').removeClass('active');
                $(this).addClass('active');
                
                // Toggle content with animation
                $('.login-method').removeClass('active');
                
                setTimeout(function() {
                    if (method === 'email') {
                        $('#emailMethod').addClass('active');
                    } else {
                        $('#googleMethod').addClass('active');
                    }
                }, 50);
            });

            // Toggle password visibility
            $('#togglePassword').on('click', function() {
                const passwordInput = $('#password');
                const eyeIcon = $('#eyeIcon');
                const type = passwordInput.attr('type') === 'password' ? 'text' : 'password';
                
                passwordInput.attr('type', type);
                
                if (type === 'text') {
                    eyeIcon.html(`
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    `);
                } else {
                    eyeIcon.html(`
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    `);
                }
            });

            // Email login form submission
            $('#loginForm').on('submit', function(e) {
                e.preventDefault();
                const btn = $('#loginBtn');
                const btnText = btn.find('span');
                const btnIcon = btn.find('svg');
                
                // Show loading state
                btn.addClass('loading');
                btn.prop('disabled', true);
                btnText.text('Sedang Masuk...');
                
                // Submit form after animation
                setTimeout(() => {
                    this.submit();
                }, 800);
            });

            // Google login button
            $('#googleLoginBtn').on('click', function(e) {
                e.preventDefault();
                const btn = $(this);
                const btnText = btn.find('span');
                
                // Show loading state
                btn.addClass('loading').css('pointer-events', 'none');
                btnText.text('Menghubungkan ke Google...');
                
                // Add spinner
                btn.find('svg').css('animation', 'spin 1s linear infinite');
                
                // Redirect to Google OAuth
                setTimeout(function() {
                    window.location.href = "<?php echo $auth_url; ?>";
                }, 800);
            });
        });
    </script>