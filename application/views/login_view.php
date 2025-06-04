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
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <style type="text/css">
        :root {
            --primary-color: #007bff;
            --google-red: #EA4335;
            --google-red-hover: #CC3326;
            --text-dark: #333333;
            --text-medium: #666666;
            --text-light: #aaaaaa;
            --card-bg: #ffffff;
            --body-bg-gradient: url('http://googleusercontent.com/image_generation_content/2'); /* Gambar Latar Belakang Pilihan 2 */
            --shadow-light: 0 5px 15px rgba(0, 0, 0, 0.08);
            --shadow-medium: 0 10px 30px rgba(0, 0, 0, 0.15);
            --border-radius-card: 15px;
            --border-radius-button: 10px;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--body-bg-gradient);
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
            color: var(--text-dark);
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            background-color: cadetblue;
        }

        .login-container {
            background-color: var(--card-bg);
            padding: 40px;
            border-radius: var(--border-radius-card);
            box-shadow: var(--shadow-medium);
            text-align: center;
            max-width: 420px;
            width: 100%;
            position: relative;
            animation: fadeIn 0.8s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .logo-section {
            margin-bottom: 30px;
        }

        .logo-section img {
            max-height: 100px;
            width: auto;
            margin-bottom: 15px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        .system-title {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            color: var(--text-dark);
            font-size: 1.8em;
            margin-top: 0;
            margin-bottom: 10px;
        }

        .tagline {
            color: var(--text-medium);
            font-size: 1em;
            line-height: 1.6;
            margin-bottom: 35px;
        }

        /* Google Login Button */
        .google-login-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: var(--google-red);
            color: white;
            padding: 14px 25px;
            border-radius: var(--border-radius-button);
            text-decoration: none;
            font-size: 1.05em;
            font-weight: 600;
            transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
            box-shadow: var(--shadow-light);
            width: 100%;
            max-width: 300px;
            margin: 0 auto;
        }

        .google-login-button:hover {
            background-color: var(--google-red-hover);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
        }

        .google-icon {
            width: 20px;
            height: 20px;
            margin-right: 10px;
            background-image: url('data:image/svg+xml;utf8,<svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 48 48"><path fill="#fff" d="M24 9.5c3.27 0 5.83 1.17 7.74 3.06l5.77-5.77C34.42 2.71 29.54 0 24 0 14.07 0 5.48 5.76 1.83 14.06l6.81 5.26C9.9 14.88 16.42 9.5 24 9.5z"/><path fill="#fff" d="M46.7 23.36c0-1.85-.16-3.6-.47-5.32H24v10.02h12.63c-.8 4.05-3.07 7.39-6.32 9.61L36.96 44C43.08 39.54 46.7 32.1 46.7 23.36z"/><path fill="#fff" d="M1.83 14.06C.7 17.06 0 20.18 0 23.36s.7 6.3 1.83 9.3l6.81-5.26C5.48 27.12 4.93 24.9 4.93 23.36c0-1.54.55-3.76 3.7-5.26L1.83 14.06z"/><path fill="#fff" d="M24 48c6.64 0 12.25-2.26 16.33-6.14l-6.81-5.26c-2.48 1.63-5.61 2.76-9.52 2.76-7.58 0-14.1-5.38-16.27-12.6L1.83 32.66C5.48 40.24 14.07 48 24 48z"/></svg>');
            background-repeat: no-repeat;
            background-size: contain;
            background-position: center;
        }

        /* Alert Styling */
        .alert {
            position: absolute;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            width: calc(100% - 40px);
            max-width: 400px;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 0.95em;
            box-shadow: var(--shadow-light);
            z-index: 1000;
            opacity: 0;
            animation: slideInTop 0.5s forwards;
        }

        @keyframes slideInTop {
            from { opacity: 0; transform: translate(-50%, -40px); }
            to { opacity: 1; transform: translate(-50%, 0); }
        }

        .alert-danger {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }
        .alert .close {
            font-size: 1.5rem;
            line-height: 1;
            padding: 0;
            background-color: transparent;
            border: 0;
            float: right;
            opacity: 0.7;
            margin-left: 15px;
            color: inherit;
        }
        .alert .close:hover {
            opacity: 1;
        }

        /* Footer Styling */
        .footer {
            position: absolute;
            bottom: 20px;
            left: 0;
            width: 100%;
            text-align: center;
            color: rgba(255, 255, 255, 0.75);
            font-size: 0.9em;
            font-weight: 500;
        }
        .account-copyright {
            margin-bottom: 0;
        }

        /* Responsive Adjustments */
        @media (max-width: 576px) {
            body {
                padding: 15px;
            }
            .login-container {
                padding: 30px 25px;
                border-radius: 10px;
            }
            .logo-section img {
                max-height: 80px;
            }
            .system-title {
                font-size: 1.5em;
            }
            .tagline {
                font-size: 0.9em;
                margin-bottom: 25px;
            }
            .google-login-button {
                padding: 12px 20px;
                font-size: 1em;
                max-width: none;
            }
            .google-icon {
                width: 18px;
                height: 18px;
                margin-right: 8px;
            }
            .alert {
                width: calc(100% - 30px);
                font-size: 0.85em;
            }
            .footer {
                bottom: 10px;
                font-size: 0.8em;
            }
        }
    </style>
</head>

<body>

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
            <img src="https://forboysproduction.com/assets/images/0001.jpg" alt="Forboys Production Logo">
        </div>
        
        <h1 class="system-title">Forboys Production System</h1>
        <p class="tagline">Selamat datang! Silakan masuk menggunakan akun Google Anda.</p>

        

        <a href="<?php echo $auth_url; ?>" class="google-login-button">
            <span class="google-icon"></span>
            Login dengan Google
        </a>

    </div> <div class="footer">
        <p class="account-copyright">&copy; 2020 - <?php echo date('Y')?> Forboys Production</p>
    </div>

    <script src="<?php echo ASSETS; ?>js/jquery.min.js"></script>
    <script src="<?php echo ASSETS; ?>js/popper.min.js"></script>
    <script src="<?php echo ASSETS; ?>js/bootstrap.min.js"></script>
    
    <script>
        // Script untuk menutup alert flashdata jika Bootstrap Anda tidak menanganinya secara otomatis.
        $(document).ready(function() {
            $('.alert .close').on('click', function() {
                $(this).closest('.alert').fadeOut(300, function() {
                    $(this).remove();
                });
            });

            // Auto-hide alert after 5 seconds
            if ($('.alert').length) {
                setTimeout(function() {
                    $('.alert').fadeOut(500, function() {
                        $(this).remove();
                    });
                }, 5000);
            }
        });
    </script>
</body>
</html>