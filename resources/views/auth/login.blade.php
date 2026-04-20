<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Login - Sistem Informasi Akademik Universitas Teknologi Bandung">
    <title>Login | SIAKAD UTB</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(145deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background:
                radial-gradient(circle at 30% 30%, rgba(99, 102, 241, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 70% 70%, rgba(139, 92, 246, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 50% 50%, rgba(14, 165, 233, 0.08) 0%, transparent 50%);
            animation: pulseGlow 8s ease-in-out infinite alternate;
            z-index: 0;
        }

        @keyframes pulseGlow {
            0% { opacity: 0.7; transform: scale(1); }
            100% { opacity: 1; transform: scale(1.05); }
        }

        /* Floating geometric shapes */
        .shape {
            position: absolute;
            border-radius: 50%;
            opacity: 0.06;
            animation: floatShape 20s ease-in-out infinite;
            z-index: 0;
        }

        .shape-1 { width: 300px; height: 300px; background: #6366f1; top: -80px; left: -60px; animation-delay: 0s; }
        .shape-2 { width: 200px; height: 200px; background: #0ea5e9; bottom: -50px; right: -30px; animation-delay: -7s; }
        .shape-3 { width: 150px; height: 150px; background: #8b5cf6; top: 10%; right: 20%; animation-delay: -3s; }
        .shape-4 { width: 80px; height: 80px; background: #f59e0b; bottom: 30%; left: 10%; animation-delay: -12s; border-radius: 20px; transform: rotate(45deg); }

        @keyframes floatShape {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            25% { transform: translate(20px, -20px) rotate(5deg); }
            50% { transform: translate(-15px, 15px) rotate(-3deg); }
            75% { transform: translate(10px, 5px) rotate(2deg); }
        }

        /* Grid dots */
        .dots-pattern {
            position: absolute;
            inset: 0;
            background-image: radial-gradient(circle, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 24px 24px;
            z-index: 0;
            pointer-events: none;
        }

        /* Login Card */
        .login-panel {
            width: 100%;
            max-width: 450px;
            background: rgba(15, 19, 40, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 24px;
            padding: 3rem 2.5rem;
            position: relative;
            z-index: 10;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
            animation: fadeSlideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-logo {
            width: 70px;
            height: 70px;
            border-radius: 20px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
            margin-bottom: 1.5rem;
            box-shadow: 0 15px 35px rgba(99, 102, 241, 0.3);
        }

        .login-header h3 {
            color: white;
            font-weight: 800;
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
            letter-spacing: -0.03em;
        }

        .login-header p {
            color: rgba(255,255,255,0.4);
            font-size: 0.9rem;
            margin-bottom: 0;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-group label {
            display: block;
            color: rgba(255,255,255,0.6);
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.5rem;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper .input-icon {
            position: absolute;
            left: 1.2rem;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255,255,255,0.3);
            font-size: 1.1rem;
            pointer-events: none;
            transition: color 0.3s ease;
        }

        .input-wrapper .form-input {
            width: 100%;
            padding: 0.9rem 1.2rem 0.9rem 3.2rem;
            background: rgba(255,255,255,0.03);
            border: 1.5px solid rgba(255,255,255,0.1);
            border-radius: 14px;
            color: white;
            font-size: 0.95rem;
            font-weight: 500;
            font-family: 'Plus Jakarta Sans', sans-serif;
            transition: all 0.3s ease;
            outline: none;
        }

        .input-wrapper .form-input::placeholder {
            color: rgba(255,255,255,0.25);
        }

        .input-wrapper .form-input:focus {
            border-color: rgba(99, 102, 241, 0.6);
            background: rgba(99, 102, 241, 0.05);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15);
        }

        .input-wrapper .form-input:focus + .input-icon,
        .input-wrapper .form-input:focus ~ .input-icon {
            color: #818cf8;
        }

        .toggle-password {
            position: absolute;
            right: 1.2rem;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255,255,255,0.4);
            cursor: pointer;
            font-size: 1.1rem;
            transition: color 0.3s ease;
            z-index: 5;
        }

        .toggle-password:hover {
            color: #818cf8;
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            margin-top: 1rem;
        }

        .form-check-input {
            background-color: rgba(255,255,255,0.08);
            border-color: rgba(255,255,255,0.15);
            border-width: 1.5px;
            width: 1.1em;
            height: 1.1em;
            margin-top: 0.15em;
            cursor: pointer;
        }

        .form-check-input:checked {
            background-color: #6366f1;
            border-color: #6366f1;
        }

        .form-check-label {
            color: rgba(255,255,255,0.5);
            font-size: 0.85rem;
            font-weight: 500;
            cursor: pointer;
        }

        .forgot-password {
            color: #818cf8;
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .forgot-password:hover {
            color: #c084fc;
            text-decoration: underline;
        }

        .btn-login {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border: none;
            border-radius: 14px;
            color: white;
            font-weight: 700;
            font-size: 1rem;
            font-family: 'Plus Jakarta Sans', sans-serif;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(99, 102, 241, 0.3);
        }

        .btn-login::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(99, 102, 241, 0.4);
        }

        .btn-login:hover::before {
            opacity: 1;
        }

        .btn-login span {
            position: relative;
            z-index: 1;
        }

        .alert-login {
            background: rgba(244, 63, 94, 0.1);
            border: 1px solid rgba(244, 63, 94, 0.2);
            color: #fb7185;
            border-radius: 12px;
            font-size: 0.85rem;
            font-weight: 500;
            padding: 0.8rem 1rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .alert-login.success {
            background: rgba(16, 185, 129, 0.1);
            border-color: rgba(16, 185, 129, 0.2);
            color: #34d399;
        }

        .login-footer {
            text-align: center;
            margin-top: 2rem;
            color: rgba(255,255,255,0.2);
            font-size: 0.8rem;
            font-weight: 500;
        }

        /* Responsive */
        @media (max-width: 575.98px) {
            .login-panel { padding: 2.5rem 1.5rem; border-radius: 0; min-height: 100vh; display: flex; flex-direction: column; justify-content: center; border: none; }
            body { padding: 0; }
        }
    </style>
</head>
<body>
    <div class="dots-pattern"></div>
    <div class="shape shape-1"></div>
    <div class="shape shape-2"></div>
    <div class="shape shape-3"></div>
    <div class="shape shape-4"></div>

    <div class="login-panel">
        <div class="login-header">
            <div class="login-logo">
                <i class="bi bi-mortarboard-fill"></i>
            </div>
            <h3>SIAKAD <span>UTB</span></h3>
            <p>Silakan masuk ke akun Anda</p>
        </div>

        @if($errors->any())
            <div class="alert-login">
                <i class="bi bi-exclamation-circle-fill"></i>
                {{ $errors->first() }}
            </div>
        @endif

        @if(session('success'))
            <div class="alert-login success">
                <i class="bi bi-check-circle-fill"></i>
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('login.process') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <div class="input-wrapper">
                    <input type="email"
                           class="form-input"
                           id="email"
                           name="email"
                           placeholder="nama@email.com"
                           value="{{ old('email') }}"
                           required
                           autofocus>
                    <i class="bi bi-envelope input-icon"></i>
                </div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <input type="password"
                           class="form-input"
                           id="password"
                           name="password"
                           placeholder="Masukkan password"
                           required>
                    <i class="bi bi-lock input-icon"></i>
                    <i class="bi bi-eye-slash toggle-password" onclick="togglePassword()" title="Tampilkan Password"></i>
                </div>
            </div>

            <div class="form-options">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label" for="remember">Ingat saya</label>
                </div>
                <a href="#" class="forgot-password">Lupa Password?</a>
            </div>

            <button type="submit" class="btn-login">
                <span><i class="bi bi-box-arrow-in-right me-2"></i> Masuk</span>
            </button>
        </form>

        <div class="login-footer">
            &copy; {{ date('Y') }} SIAKAD — Universitas Teknologi Bandung
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePassword() {
            var passInput = document.getElementById("password");
            var icon = document.querySelector(".toggle-password");
            
            if (passInput.type === "password") {
                passInput.type = "text";
                icon.classList.remove("bi-eye-slash");
                icon.classList.add("bi-eye");
                icon.title = "Sembunyikan Password";
            } else {
                passInput.type = "password";
                icon.classList.remove("bi-eye");
                icon.classList.add("bi-eye-slash");
                icon.title = "Tampilkan Password";
            }
        }
    </script>
</body>
</html>
