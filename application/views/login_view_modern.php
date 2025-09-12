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
            --primary: #4361ee; /* Biru modern */
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
            max-width: 280px;
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

        .login-button.success {
            width: 60px;
            background: var(--accent);
        }

        .login-button.success .icon {
            margin-right: 0;
            transform: scale(1.5);
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

        /* Floating circles decoration */
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

        /* Responsive adjustments */
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
    <!-- Decorative circles -->
    <div class="circle"></div>
    <div class="circle"></div>

    <div class="login-container">
        <?php if ($this->session->flashdata('gagal')) { ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo $this->session->flashdata('gagal'); ?> 
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php } ?>

        <div class="logo-section">
            <img src="<?php echo BASEURL?>/assets/images/0001.png" alt="Forboys Production Logo">
        </div>
        
        <h1 class="system-title">Forboys Production System</h1>
        <p class="tagline">Selamat datang! Silakan masuk menggunakan akun Google Anda.</p>

        <button class="login-button" id="loginBtn">
            <svg class="icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path fill="currentColor" d="M12.545 10.239v3.821h5.445c-0.712 2.315-2.647 3.972-5.445 3.972-3.332 0-6.033-2.701-6.033-6.032s2.701-6.032 6.033-6.032c1.498 0 2.866 0.549 3.921 1.453l2.814-2.814c-1.798-1.677-4.175-2.715-6.735-2.715-5.522 0-10 4.479-10 10s4.478 10 10 10c8.396 0 10-7.496 10-9.999 0-0.781-0.082-1.533-0.23-2.253h-9.77z"/>
            </svg>
            <span class="text">Login dengan Google</span>
            <div class="spinner"></div>
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

            // Login button animation
            $('#loginBtn').on('click', function(e) {
                e.preventDefault();
                var btn = $(this);
                
                // Add loading class to show spinner
                btn.addClass('loading');
                
                // Simulate loading for demo purposes (remove this in production)
                setTimeout(function () {
                // After loading, show success state
                btn.removeClass('loading').addClass('success');

                btn.html(`
                    <svg class="icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path fill="currentColor" d="M12.545 10.239v3.821h5.445c-0.712 2.315-2.647 3.972-5.445 3.972-3.332 0-6.033-2.701-6.033-6.032s2.701-6.032 6.033-6.032c1.498 0 2.866 0.549 3.921 1.453l2.814-2.814c-1.798-1.677-4.175-2.715-6.735-2.715-5.522 0-10 4.479-10 10s4.478 10 10 10c8.396 0 10-7.496 10-9.999 0-0.781-0.082-1.533-0.23-2.253h-9.77z"/>
                    </svg>
                `);

                // Redirect after a short delay to show the animation
                setTimeout(function () {
                    window.location.href = "<?php echo $auth_url; ?>";
                }, 800);
            }, 1500);

            });
        });
    </script>
</body>
</html>