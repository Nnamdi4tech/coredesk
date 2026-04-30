@php
    $host = request()->getHost();
    $subdomain = explode('.', $host)[0];
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CoreDesk - Sign In</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --cd-purple: #667eea;
            --cd-purple-dark: #5a67d8;
            --cd-purple-light: #7f9cf5;
            --cd-deep: #764ba2;
            --cd-white: #ffffff;
            --cd-gold: #fbbf24;
            --cd-gold-light: #fcd34d;
            --text-dark: #1e1b2e;
            --text-muted: #6b7280;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
            background: var(--cd-purple-dark);
            display: flex;
            align-items: stretch;
            overflow: auto;
        }

        /* Custom scrollbar styling */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--cd-purple);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--cd-deep);
        }

        /* ── LEFT PANEL ── */
        .left-panel {
            width: 50%;
            background: linear-gradient(155deg, #667eea 0%, #764ba2 50%, #8b5cf6 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 60px 50px;
            position: relative;
            overflow-y: auto;
            min-height: 100vh;
        }

        .left-panel::-webkit-scrollbar {
            width: 6px;
        }

        .left-panel::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        .left-panel::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 10px;
        }

        /* decorative circles */
        .left-panel::before {
            content: '';
            position: absolute;
            width: 500px; height: 500px;
            border-radius: 50%;
            border: 60px solid rgba(255,255,255,0.04);
            top: -120px; left: -120px;
        }
        .left-panel::after {
            content: '';
            position: absolute;
            width: 350px; height: 350px;
            border-radius: 50%;
            border: 40px solid rgba(255,255,255,0.05);
            bottom: -80px; right: -80px;
        }

        .logo-icon {
            width: 120px; height: 120px;
            border-radius: 50%;
            background: rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            border: 5px solid rgba(255,255,255,0.25);
            box-shadow: 0 8px 40px rgba(0,0,0,0.3), 0 0 0 10px rgba(255,255,255,0.06);
            margin-bottom: 36px;
            position: relative;
            z-index: 1;
            transition: transform 0.4s ease;
            font-size: 3.5rem;
            font-weight: 800;
            color: white;
        }
        .logo-icon:hover { transform: scale(1.04); }

        .org-name {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            font-weight: 700;
            color: #ffffff;
            text-align: center;
            line-height: 1.25;
            position: relative;
            z-index: 1;
            letter-spacing: 0.01em;
            margin-bottom: 16px;
        }

        .org-divider {
            width: 60px; height: 3px;
            background: var(--cd-gold-light);
            border-radius: 2px;
            margin: 0 auto 20px;
            position: relative;
            z-index: 1;
        }

        .org-tagline {
            font-size: 0.875rem;
            color: rgba(255,255,255,0.75);
            text-align: center;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            position: relative;
            z-index: 1;
            font-weight: 300;
        }

        /* quote section */
        .quote-section {
            margin-top: 60px;
            position: relative;
            z-index: 1;
            max-width: 380px;
            text-align: center;
        }

        .quote-text {
            font-size: 1.1rem;
            color: rgba(255,255,255,0.9);
            font-style: italic;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .quote-author {
            font-size: 0.85rem;
            color: rgba(255,255,255,0.7);
            font-weight: 500;
        }

        /* stripe bottom */
        .flag-stripe {
            position: absolute;
            bottom: 0; left: 0; right: 0;
            height: 5px;
            background: linear-gradient(to right,
                var(--cd-purple) 33.3%,
                var(--cd-white) 33.3%, var(--cd-white) 66.6%,
                var(--cd-deep) 66.6%);
            z-index: 2;
        }

        /* ── RIGHT PANEL ── */
        .right-panel {
            width: 50%;
            background: #f8f9fc;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 60px 50px;
            position: relative;
            overflow-y: auto;
            min-height: 100vh;
        }

        .right-panel::-webkit-scrollbar {
            width: 6px;
        }

        .right-panel::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.05);
        }

        .right-panel::-webkit-scrollbar-thumb {
            background: var(--cd-purple);
            border-radius: 10px;
        }

        .right-panel::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 4px;
            background: linear-gradient(to right, var(--cd-purple), var(--cd-gold-light));
        }

        .login-card {
            width: 100%;
            max-width: 440px;
        }

        .badge-icon {
            display: inline-block;
            background: rgba(102, 126, 234, 0.1);
            color: var(--cd-purple-dark);
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            padding: 4px 12px;
            border-radius: 20px;
            border: 1px solid rgba(102, 126, 234, 0.2);
            margin-bottom: 20px;
        }

        .login-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.75rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 6px;
        }

        .login-subtitle {
            font-size: 0.875rem;
            color: var(--text-muted);
            margin-bottom: 36px;
            font-weight: 300;
        }

        .form-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-dark);
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 6px;
        }

        .form-control {
            border: 1.5px solid #e5e7eb;
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 0.925rem;
            font-family: 'DM Sans', sans-serif;
            background: #ffffff;
            color: var(--text-dark);
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-control:focus {
            border-color: var(--cd-purple);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.12);
            outline: none;
        }

        .input-group .form-control {
            border-right: none;
            border-radius: 8px 0 0 8px;
        }

        .input-group-text {
            border: 1.5px solid #e5e7eb;
            border-left: none;
            border-radius: 0 8px 8px 0;
            background: #ffffff;
            cursor: pointer;
            padding: 12px 14px;
            transition: background 0.2s;
        }

        .input-group-text:hover {
            background: #f3f4f6;
        }

        .form-check-input:checked {
            background-color: var(--cd-purple);
            border-color: var(--cd-purple);
        }

        .form-check-label {
            font-size: 0.875rem;
            color: var(--text-muted);
        }

        .forgot-link {
            font-size: 0.825rem;
            color: var(--cd-purple);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }
        .forgot-link:hover {
            color: var(--cd-purple-dark);
            text-decoration: underline;
        }

        .btn-login {
            background: linear-gradient(135deg, var(--cd-purple), var(--cd-deep));
            border: none;
            border-radius: 8px;
            padding: 12px 32px;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.925rem;
            font-weight: 500;
            color: #fff;
            letter-spacing: 0.04em;
            cursor: pointer;
            transition: transform 0.15s, box-shadow 0.15s, opacity 0.15s;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .btn-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
            opacity: 0.95;
        }

        .btn-login:active { transform: translateY(0); }

        /* alert styling */
        .alert-danger, .alert-success {
            border-radius: 8px;
            border: none;
            font-size: 0.875rem;
            margin-bottom: 24px;
            padding: 12px 16px;
        }
        .alert-danger {
            background: #fdf0f0;
            border-left: 4px solid #dc3545;
        }
        .alert-success {
            background: #e8f5e9;
            border-left: 4px solid #4caf50;
        }

        .bottom-note {
            margin-top: 32px;
            font-size: 0.75rem;
            color: #a0aec0;
            text-align: center;
        }

        /* Scroll to top button */
        .scroll-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, var(--cd-purple), var(--cd-deep));
            color: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            display: none;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            transition: all 0.3s;
            z-index: 1000;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .scroll-top:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }

        .scroll-top.show {
            display: flex;
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 768px) {
            body { flex-direction: column; }
            .left-panel, .right-panel { width: 100%; min-height: auto; padding: 40px 24px; }
            .left-panel { min-height: 300px; }
            .logo-icon { width: 80px; height: 80px; font-size: 2rem; margin-bottom: 20px; }
            .org-name { font-size: 1.6rem; }
            .quote-section { margin-top: 30px; }
            .quote-text { font-size: 0.9rem; }
            .scroll-top {
                bottom: 20px;
                right: 20px;
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }
        }

        /* entrance animation */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .login-card { animation: fadeUp 0.5s ease both; }
        .left-panel .logo-icon { animation: fadeUp 0.5s 0.1s ease both; }
        .left-panel .org-name     { animation: fadeUp 0.5s 0.2s ease both; }
        .left-panel .org-divider  { animation: fadeUp 0.5s 0.3s ease both; }
        .left-panel .org-tagline  { animation: fadeUp 0.5s 0.4s ease both; }
        .left-panel .quote-section { animation: fadeUp 0.5s 0.5s ease both; }
    </style>
</head>
<body>

    <!-- Scroll to Top Button -->
    <button class="scroll-top" id="scrollTopBtn" onclick="scrollToTop()">
        ↑
    </button>

    <!-- ══ LEFT PANEL - Branding ══ -->
    <div class="left-panel">
        <div class="logo-icon">C</div>
        <h1 class="org-name">CoreDesk</h1>
        <div class="org-divider"></div>
        <p class="org-tagline">All-in-One Management Platform</p>
        
        <div class="quote-section">
            <div class="quote-text">
                "The most comprehensive platform for managing schools, churches, and organizations. Everything we needed in one place."
            </div>
            <div class="quote-author">
                — Michael Ade, School Administrator
            </div>
        </div>
        
        <div class="flag-stripe"></div>
    </div>

    <!-- ══ RIGHT PANEL - Login Form ══ -->
    <div class="right-panel">
        <div class="login-card">
            <div class="badge-icon">Welcome Back</div>
            <h2 class="login-title">Sign in to CoreDesk</h2>
            <p class="login-subtitle">Access your dashboard and manage your organization</p>

            <!-- Session Status -->
            @if(session('status'))
                <div class="alert-success alert">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Validation Errors -->
            @if($errors->any())
                <div class="alert-danger alert">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('tenant.login', $subdomain) }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-4">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" 
                           value="{{ old('email') }}" required autofocus 
                           placeholder="you@example.com">
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password" name="password" required 
                               placeholder="Enter your password">
                        <span class="input-group-text toggle-password" id="togglePassword">👁️</span>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="mb-4 form-check">
                    <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                    <label class="form-check-label" for="remember_me">Remember me</label>
                </div>

                <!-- Submit + Forgot -->
                <div class="d-flex justify-content-between align-items-center">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
                    @endif
                    <button type="submit" class="btn-login">Sign In →</button>
                </div>
            </form>

            <p class="bottom-note">
                Don't have an account? <a href="{{ route('register') }}" style="color: var(--cd-purple); text-decoration: none; font-weight: 500;">Create one now</a>
            </p>

            <p class="bottom-note">© {{ date('Y') }} CoreDesk. Built for Schools, Churches & Organizations.</p>
        </div>
    </div>

    <script>
        // Scroll to top functionality
        window.addEventListener('scroll', function() {
            const scrollBtn = document.getElementById('scrollTopBtn');
            if (window.pageYOffset > 300) {
                scrollBtn.classList.add('show');
            } else {
                scrollBtn.classList.remove('show');
            }
        });

        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const pwd = document.getElementById('password');
            const type = pwd.type === 'password' ? 'text' : 'password';
            pwd.type = type;
            this.textContent = type === 'password' ? '👁️' : '🙈';
        });
    </script>

</body>
</html>