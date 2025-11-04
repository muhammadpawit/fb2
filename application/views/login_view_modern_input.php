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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style type="text/css">
        :root {
            --primary: #4361ee;
            --primary-light: #4895ef;
            --primary-dark: #3a0ca3;
            --secondary: #7209b7;
            --accent: #f72585;
            --dark: #212529;
            --light: #f8f9fa;
            --gray: #6c757d;
            --glass: rgba(255, 255, 255, 0.25);
            --glass-border: rgba(255, 255, 255, 0.18);
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.12);
            --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 25px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: var(--dark);
            line-height: 1.6;
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
            background: radial-gradient(circle, var(--primary-light) 0%, transparent 70%);
            opacity: 0.2;
            z-index: -1;
            animation: float 15s infinite alternate;
        }

        body::after {
            content: '';
            position: absolute;
            bottom: -50%;
            left: -50%;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, var(--accent) 0%, transparent 70%);
            opacity: 0.1;
            z-index: -1;
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

        .login-container {
            background: var(--glass);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 480px;
            box-shadow: var(--shadow-lg);
            text-align: center;
            position: relative;
            overflow: hidden;
            transform: translateY(0);
            opacity: 1;
            transition: var(--transition);
            animation: fadeInUp 0.8s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--primary), var(--accent));
        }

        .logo-section {
            margin-bottom: 30px;
            position: relative;
        }

        .logo-section img {
            height: 150px;
            width: auto;
            margin: 0 auto 20px;
            display: block;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
        }

        .system-title {
            font-weight: 700;
            color: var(--dark);
            font-size: 2rem;
            margin-bottom: 8px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            display: inline-block;
        }

        .tagline {
            color: var(--gray);
            font-size: 1rem;
            margin-bottom: 32px;
            font-weight: 400;
        }

        /* Form Styles */
        .login-form {
            width: 100%;
            margin-bottom: 24px;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: var(--dark);
            font-weight: 500;
            font-size: 0.9375rem;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper svg {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            color: var(--gray);
            pointer-events: none;
        }

        .form-control {
            width: 100%;
            padding: 14px 16px 14px 48px;
            border: 2px solid var(--glass-border);
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(8px);
            font-size: 1rem;
            color: var(--dark);
            transition: var(--transition);
            font-family: 'Inter', sans-serif;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            background: rgba(255, 255, 255, 0.6);
            box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.1);
        }

        .form-control::placeholder {
            color: var(--gray);
            opacity: 0.7;
        }

        .password-toggle {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px;
            color: var(--gray);
            transition: var(--transition);
        }

        .password-toggle:hover {
            color: var(--primary);
        }

        .password-toggle svg {
            width: 20px;
            height: 20px;
        }

        .forgot-password {
            text-align: right;
            margin-top: 8px;
        }

        .forgot-password a {
            color: var(--primary);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: var(--transition);
        }

        .forgot-password a:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        .login-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: var(--primary);
            color: white;
            padding: 16px 32px;
            border-radius: 50px;
            text-decoration: none;
            font-size: 1rem;
            font-weight: 600;
            transition: var(--transition);
            box-shadow: var(--shadow-md);
            width: 100%;
            margin: 0 auto;
            position: relative;
            overflow: hidden;
            border: none;
            cursor: pointer;
        }

        .login-button:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(67, 97, 238, 0.3);
        }

        .login-button:active {
            transform: translateY(0);
        }

        .login-button .icon {
            width: 20px;
            height: 20px;
            margin-right: 12px;
            transition: var(--transition);
        }

        .login-button .text {
            transition: var(--transition);
        }

        .login-button .spinner {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
            opacity: 0;
            transition: var(--transition);
        }

        @keyframes spin {
            to {
                transform: translate(-50%, -50%) rotate(360deg);
            }
        }

        .login-button.loading .text {
            opacity: 0;
            transform: translateX(10px);
        }

        .login-button.loading .icon {
            opacity: 0;
            transform: translateX(-10px);
        }

        .login-button.loading .spinner {
            opacity: 1;
        }

        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            margin: 24px 0;
            color: var(--gray);
            font-size: 0.875rem;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--glass-border);
        }

        .divider span {
            padding: 0 16px;
            font-weight: 500;
        }

        /* Google Login Button */
        .google-login-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: white;
            color: var(--dark);
            padding: 14px 24px;
            border-radius: 50px;
            text-decoration: none;
            font-size: 0.9375rem;
            font-weight: 600;
            transition: var(--transition);
            box-shadow: var(--shadow-sm);
            width: 100%;
            border: 2px solid var(--glass-border);
            cursor: pointer;
        }

        .google-login-button:hover {
            background: #f8f9fa;
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            border-color: var(--primary-light);
        }

        .google-login-button .icon {
            width: 20px;
            height: 20px;
            margin-right: 12px;
        }

        .alert-danger {
            background: linear-gradient(135deg, #f44336, #d32f2f);
            color: #fff;
            border-radius: 8px;
            padding: 12px 18px;
            box-shadow: 0 4px 10px rgba(244, 67, 54, 0.3);
            border-left: 6px solid #b71c1c;
            font-weight: 500;
            letter-spacing: 0.3px;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: fadeIn 0.3s ease-in-out;
            margin-bottom: 20px;
        }

        .alert-danger::before {
            content: "⚠️";
            font-size: 18px;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-5px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .footer {
            position: fixed;
            bottom: 20px;
            left: 0;
            width: 100%;
            text-align: center;
            color: var(--gray);
            font-size: 0.875rem;
            font-weight: 400;
        }

        .footer p {
            opacity: 0.8;
        }

        .circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(113, 9, 183, 0.1);
            z-index: -1;
            animation: float 15s infinite ease-in-out;
        }

        .circle:nth-child(1) {
            width: 150px;
            height: 150px;
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }

        .circle:nth-child(2) {
            width: 200px;
            height: 200px;
            bottom: 15%;
            right: 10%;
            animation-delay: 2s;
        }

        @media (max-width: 768px) {
            .login-container {
                padding: 32px 24px;
                border-radius: 16px;
            }
            
            .system-title {
                font-size: 1.75rem;
            }
            
            .login-button {
                padding: 14px 24px;
                font-size: 0.9375rem;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 16px;
            }
            
            .login-container {
                padding: 24px 20px;
            }
            
            .logo-section img {
                height: 70px;
                margin-bottom: 16px;
            }
            
            .system-title {
                font-size: 1.5rem;
            }
            
            .tagline {
                font-size: 0.9375rem;
                margin-bottom: 24px;
            }
        }
    </style>
</head>

<body>
    <div class="circle"></div>
    <div class="circle"></div>

    <div class="login-container">
        <?php if ($this->session->flashdata('gagal')) { ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo $this->session->flashdata('gagal'); ?> 
        </div>
        <?php } ?>

        <div class="logo-section">
            <img src="<?php echo BASEURL?>/assets/images/0001.png" alt="Forboys Production Logo">
        </div>
        
        <h1 class="system-title">Forboys Production System</h1>
        <p class="tagline">Selamat datang! Silakan masuk ke sistem produksi.</p>

        <!-- Email/Password Login Form -->
        <form class="login-form" method="POST" action="<?php echo BASEURL; ?>Auth/login" id="loginForm">
            <div class="form-group">
                <label for="email">Email</label>
                <div class="input-wrapper">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <input type="email" class="form-control" id="email" name="email" placeholder="nama@email.com" required>
                </div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
                    <button type="button" class="password-toggle" id="togglePassword">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" id="eyeIcon">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
                <div class="forgot-password">
                    <a href="<?php echo BASEURL; ?>auth/forgot-password">Lupa password?</a>
                </div>
            </div>

            <button type="submit" class="login-button" id="loginBtn">
                <svg class="icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
                <span class="text">Masuk</span>
                <div class="spinner"></div>
            </button>
        </form>

        <!-- Divider -->
        <div class="divider">
            <span>atau</span>
        </div>

        <!-- Google Login -->
        <button class="google-login-button" id="googleLoginBtn">
            <svg class="icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path fill="#4285F4" d="M12.545 10.239v3.821h5.445c-0.712 2.315-2.647 3.972-5.445 3.972-3.332 0-6.033-2.701-6.033-6.032s2.701-6.032 6.033-6.032c1.498 0 2.866 0.549 3.921 1.453l2.814-2.814c-1.798-1.677-4.175-2.715-6.735-2.715-5.522 0-10 4.479-10 10s4.478 10 10 10c8.396 0 10-7.496 10-9.999 0-0.781-0.082-1.533-0.23-2.253h-9.77z"/>
            </svg>
            <span>Login dengan Google</span>
        </button>
    </div>

    <div class="footer">
        <p>&copy; 2020 - <?php echo date('Y')?> Forboys Production</p>
    </div>

    <script src="<?php echo ASSETS; ?>js/jquery.min.js"></script>
    <script src="<?php echo ASSETS; ?>js/popper.min.js"></script>
    <script src="<?php echo ASSETS; ?>js/bootstrap.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Handle alert closing
            $('.alert .close').on('click', function() {
                $(this).closest('.alert').animate({
                    opacity: 0,
                    height: 0,
                    padding: 0,
                    margin: 0
                }, 300, function() {
                    $(this).remove();
                });
            });

            // Auto-hide alert after 5 seconds
            if ($('.alert').length) {
                setTimeout(function() {
                    $('.alert').animate({
                        opacity: 0,
                        height: 0,
                        padding: 0,
                        margin: 0
                    }, 500, function() {
                        $(this).remove();
                    });
                }, 5000);
            }

            // Toggle password visibility
            $('#togglePassword').on('click', function() {
                const passwordInput = $('#password');
                const type = passwordInput.attr('type') === 'password' ? 'text' : 'password';
                passwordInput.attr('type', type);
                
                // Toggle eye icon
                if (type === 'text') {
                    $('#eyeIcon').html(`
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    `);
                } else {
                    $('#eyeIcon').html(`
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    `);
                }
            });

            // Login form submission
            $('#loginForm').on('submit', function(e) {
                e.preventDefault();
                var btn = $('#loginBtn');
                
                // Add loading state
                btn.addClass('loading');
                btn.prop('disabled', true);
                
                // Submit form after animation
                setTimeout(function() {
                    e.target.submit();
                }, 800);
            });

            // Google login button
            $('#googleLoginBtn').on('click', function(e) {
                e.preventDefault();
                window.location.href = "<?php echo $auth_url; ?>";
            });
        });
    </script>
</body>
</html>