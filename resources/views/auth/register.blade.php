<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CoreDesk - Create Your School</title>
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
            overflow: auto; /* Changed from hidden to auto */
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
            overflow-y: auto; /* Allow scrolling if content overflows */
            min-height: 100vh;
        }

        /* Custom scrollbar for left panel */
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

        /* feature list on left */
        .features-list {
            margin-top: 50px;
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 380px;
        }
        .feature-item {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 24px;
            color: rgba(255,255,255,0.85);
            font-size: 0.9rem;
        }
        .feature-icon {
            width: 32px;
            height: 32px;
            background: rgba(255,255,255,0.15);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
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
            overflow-y: auto; /* Allow scrolling */
            min-height: 100vh;
        }

        /* Custom scrollbar for right panel */
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

        .register-card {
            width: 100%;
            max-width: 480px;
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

        .register-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.75rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 6px;
        }

        .register-subtitle {
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

        .subdomain-suggestions {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 8px;
            min-height: 40px;
            max-height: 120px;
            overflow-y: auto; /* Scroll for many suggestions */
        }

        .subdomain-btn {
            display: inline-block;
            padding: 4px 12px;
            font-size: 0.75rem;
            font-weight: 500;
            background: #f3f4f6;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            color: var(--text-muted);
            cursor: pointer;
            transition: all 0.2s;
        }

        .subdomain-btn:hover {
            background: var(--cd-purple);
            color: white;
            border-color: var(--cd-purple);
        }

        .subdomain-btn.active {
            background: linear-gradient(135deg, var(--cd-purple), var(--cd-deep));
            color: white;
            border-color: transparent;
        }

        .subdomain-preview {
            font-size: 0.7rem;
            color: var(--text-muted);
            margin-top: 6px;
        }

        .subdomain-preview span {
            color: var(--cd-purple);
            font-weight: 600;
        }

        .btn-register {
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
            width: 100%;
        }

        .btn-register:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
            opacity: 0.95;
        }

        .btn-register:active { transform: translateY(0); }

        /* error alert */
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
            .left-panel { min-height: auto; }
            .logo-icon { width: 80px; height: 80px; font-size: 2rem; margin-bottom: 20px; }
            .org-name { font-size: 1.6rem; }
            .features-list { margin-top: 30px; }
            .feature-item { font-size: 0.8rem; }
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
        .register-card { animation: fadeUp 0.5s ease both; }
        .left-panel .logo-icon { animation: fadeUp 0.5s 0.1s ease both; }
        .left-panel .org-name     { animation: fadeUp 0.5s 0.2s ease both; }
        .left-panel .org-divider  { animation: fadeUp 0.5s 0.3s ease both; }
        .left-panel .org-tagline  { animation: fadeUp 0.5s 0.4s ease both; }
        .left-panel .features-list { animation: fadeUp 0.5s 0.5s ease both; }

        /* Spinner styles */
.spinner-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    backdrop-filter: blur(3px);
}

.spinner {
    width: 50px;
    height: 50px;
    border: 5px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    border-top-color: var(--cd-purple);
    animation: spin 1s ease-in-out infinite;
}

.spinner-text {
    color: white;
    margin-top: 20px;
    font-size: 1rem;
    text-align: center;
}

.spinner-container {
    background: rgba(0, 0, 0, 0.9);
    padding: 30px;
    border-radius: 12px;
    text-align: center;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}
    </style>
</head>
<body>

    <!-- Scroll to Top Button -->
    <button class="scroll-top" id="scrollTopBtn" onclick="scrollToTop()">
        ↑
    </button>

    <!-- ══ LEFT PANEL - Branding & Features ══ -->
    <div class="left-panel">
        <div class="logo-icon">C</div>
        <h1 class="org-name">CoreDesk</h1>
        <div class="org-divider"></div>
        <p class="org-tagline">All-in-One Management Platform</p>
        
        <div class="features-list">
            <div class="feature-item">
                <div class="feature-icon">🚀</div>
                <span>Quick Setup — Get started in minutes</span>
            </div>
            <div class="feature-item">
                <div class="feature-icon">🔒</div>
                <span>Secure & Reliable — Enterprise-grade security</span>
            </div>
            <div class="feature-item">
                <div class="feature-icon">📊</div>
                <span>Powerful Dashboard — Full control at your fingertips</span>
            </div>
            <div class="feature-item">
                <div class="feature-icon">👥</div>
                <span>Multi-Access — Roles for every user type</span>
            </div>
        </div>
        
        <div class="flag-stripe"></div>
    </div>

    <!-- ══ RIGHT PANEL - Registration Form ══ -->
    <div class="right-panel">
        <div class="register-card">
            <div class="badge-icon">Get Started</div>
            <h2 class="register-title">Create Your Account</h2>
            <p class="register-subtitle">Set up your school in minutes</p>

            {{-- success/error messages --}}
            @if(session('success'))
                <div class="alert-success alert">
                    <span class="font-medium">Success!</span> {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert-danger alert">
                    <span class="font-medium">Error!</span> {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert-danger alert">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('tenant.register') }}">
                @csrf

                <!-- School Name -->
                <div class="mb-4">
                    <label for="school_name" class="form-label">School Name</label>
                    <input type="text" class="form-control" id="school_name" name="school_name" 
                           value="{{ old('school_name') }}" required autofocus 
                           placeholder="e.g., Excel International School">
                </div>

                <!-- Subdomain -->
                <div class="mb-4">
                    <label for="subdomain" class="form-label">choose your website name</label>
                    <div id="subdomain-suggestions" class="subdomain-suggestions">
                        <span class="subdomain-preview" style="color: #9ca3af; font-style: italic;">Start typing school name...</span>
                    </div>
                    <input type="hidden" name="subdomain" id="subdomain">
                    <div class="subdomain-preview">
                     Copy Your URL: <span id="subdomain-preview">your-school.coredesk.com.ng</span>
                    </div>
                </div>

                <!-- Owner Name -->
                <div class="mb-4">
                    <label for="name" class="form-label">Owner/Proprietor/Admin</label>
                    <input type="text" class="form-control" id="name" name="name" 
                           value="{{ old('name') }}" required 
                           placeholder="Full name">
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" 
                           value="{{ old('email') }}" required 
                           placeholder="you@example.com">
                </div>

                <!-- Location -->
                <div class="mb-4">
                    <label for="location" class="form-label">Enter Full Address</label>
                    <input type="text" class="form-control" id="location" name="location" 
                     value="{{ old('location') }}" required 
                     placeholder="e.g. No 25 Environmental Street, Abuja">
                </div>

                <!-- Phone -->
<div class="mb-4">
    <label for="phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
    <input type="tel" class="form-control" id="phone" name="phone"
           value="{{ old('phone') }}"
           placeholder="e.g. 08012345678"
           required
           pattern="[0-9]{11}"
           maxlength="11"
           title="Please enter a valid 11-digit phone number">
    <small class="text-muted">Enter exactly 11-digit phone number (e.g., 08012345678)</small>
    <div class="invalid-feedback" style="display: none; color: #dc3545; font-size: 0.75rem; margin-top: 4px;">
        Phone number must be exactly 11 digits
    </div>
</div>
                

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password" name="password" required 
                               placeholder="Create a secure password">
                        <span class="input-group-text toggle-password" style="cursor: pointer;">👁️</span>
                    </div>
                </div>

                <!-- Submit -->
                
                <button type="button" class="btn-register" onclick="confirmSchoolCreation()">Create School →</button>

                <p class="bottom-note">
                    Already have an account? <a href="{{ route('home') }}" style="color: var(--cd-purple); text-decoration: none; font-weight: 500;">Go Back</a>
                </p>
            </form>

            <p class="bottom-note">© {{ date('Y') }} CoreDesk. Built for Schools, Churches & Organizations.</p>
        </div>
    </div>

    <!-- Spinner Overlay -->
<div id="spinnerOverlay" class="spinner-overlay">
    <div class="spinner-container">
        <div class="spinner"></div>
        <div class="spinner-text">Creating your dashboard... Please wait</div>
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
        document.addEventListener('DOMContentLoaded', function () {
            const togglePwd = document.querySelector('.toggle-password');
            if (togglePwd) {
                togglePwd.addEventListener('click', function () {
                    const pwd = document.getElementById('password');
                    const type = pwd.type === 'password' ? 'text' : 'password';
                    pwd.type = type;
                    this.textContent = type === 'password' ? '👁️' : '🙈';
                });
            }

            // Subdomain suggestions
            const schoolInput = document.getElementById('school_name');
            const suggestionsDiv = document.getElementById('subdomain-suggestions');
            const hiddenSubdomain = document.getElementById('subdomain');
            const subdomainPreviewSpan = document.getElementById('subdomain-preview');

            let timeout = null;

            schoolInput.addEventListener('input', function () {
                clearTimeout(timeout);
                const schoolName = this.value.trim();
                
                if (schoolName.length < 2) {
                    suggestionsDiv.innerHTML = '<span class="subdomain-preview" style="color: #9ca3af; font-style: italic;">Start typing school name...</span>';
                    hiddenSubdomain.value = '';
                    subdomainPreviewSpan.textContent = 'your-school.coredesk.com.ng';
                    return;
                }

                timeout = setTimeout(() => {
                    fetch(`/check-subdomain?school_name=${encodeURIComponent(schoolName)}`)
                        .then(res => res.json())
                        .then(data => {
                            suggestionsDiv.innerHTML = '';

                            if (data.exists) {
                                const warning = document.createElement('p');
                                warning.className = 'text-danger';
                                warning.style.cssText = 'color: #dc3545; font-size: 0.75rem; margin-bottom: 8px;';
                                warning.textContent = '⚠️ This name already exists. Please choose another.';
                                suggestionsDiv.appendChild(warning);
                            }

                            data.suggestions.forEach(sub => {
                                const btn = document.createElement('button');
                                btn.type = 'button';
                                btn.className = 'subdomain-btn';
                                btn.textContent = sub + '.coredesk.com.ng';
                                btn.addEventListener('click', () => {
                                    hiddenSubdomain.value = sub;
                                    subdomainPreviewSpan.textContent = sub + '.coredesk.com.ng';
                                    document.querySelectorAll('.subdomain-btn').forEach(b => {
                                        b.classList.remove('active');
                                    });
                                    btn.classList.add('active');
                                });
                                suggestionsDiv.appendChild(btn);
                            });

                            if (data.suggestions.length === 0 && !data.exists) {
                                suggestionsDiv.innerHTML = '<span class="subdomain-preview" style="color: #9ca3af;">Generating suggestions...</span>';
                            }
                        });
                }, 300);
            });
        });
    </script>


<!-- sweet alert -->
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>


<style>
.swal-popup-custom {
    border-radius: 16px !important;
    padding: 2rem !important;
    max-width: 480px !important;
    font-family: 'DM Sans', sans-serif !important;
}
.swal-title-custom {
    font-family: 'Playfair Display', serif !important;
    font-size: 1.4rem !important;
    color: #1e1b2e !important;
    font-weight: 700 !important;
}
.swal-confirm-custom {
    border-radius: 8px !important;
    font-weight: 600 !important;
    font-size: 0.875rem !important;
    padding: 10px 20px !important;
}
.swal-cancel-custom {
    border-radius: 8px !important;
    font-weight: 600 !important;
    font-size: 0.875rem !important;
    padding: 10px 20px !important;
}
</style>


 <!-- phone number validation - UPDATED with spinner -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const phoneInput = document.getElementById('phone');
    
    // Real-time phone validation
    phoneInput.addEventListener('input', function() {
        this.value = this.value.replace(/\D/g, '').slice(0, 11);
        
        if (this.value.length !== 11) {
            this.style.borderColor = '#dc3545';
            this.setCustomValidity('Phone number must be exactly 11 digits');
        } else {
            this.style.borderColor = '#28a745';
            this.setCustomValidity('');
        }
    });
    
    // Form validation before SweetAlert
    window.confirmSchoolCreation = function() {
        const phone = phoneInput.value.trim();
        
        // Validate phone
        if (phone.length !== 11 || !/^\d{11}$/.test(phone)) {
            Swal.fire({
                title: 'Invalid Phone Number',
                text: 'Please enter a valid 11-digit phone number (e.g., 08012345678)',
                icon: 'error',
                confirmButtonColor: '#667eea'
            });
            phoneInput.focus();
            return;
        }
        
        // Check if subdomain is selected
        const subdomain = document.getElementById('subdomain').value;
        if (!subdomain) {
            Swal.fire({
                title: 'Subdomain Required',
                text: 'Please select a subdomain from the suggestions above.',
                icon: 'warning',
                confirmButtonColor: '#667eea'
            });
            return;
        }
        
        // Proceed with SweetAlert confirmation
        Swal.fire({
            title: 'Before You Proceed',
            html: `
                <div style="text-align:left; font-size:0.9rem; color:#374151; line-height:1.7;">
                    <p style="margin-bottom:12px;">You are about to create a <strong>School Management Dashboard</strong> that will include:</p>
                    <ul style="padding-left:18px; margin-bottom:16px; color:#4b5563;">
                        <li>Admin control panel</li>
                        <li>Teacher portal & result management</li>
                        <li>Student portal & report cards</li>
                    </ul>
                    <div style="background:#fef3c7; border-left:4px solid #f59e0b; padding:10px 14px; border-radius:6px; font-size:0.825rem; color:#92400e;">
                        <strong>⚠️ Important:</strong> By proceeding, you confirm that you are an authorised 
                        administrator, proprietor, or staff member of this school, and that you have 
                        permission to create this dashboard on behalf of your institution.
                    </div>
                </div>
            `,
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'Yes, Create Dashboard →',
            cancelButtonText: 'No, Cancel',
            confirmButtonColor: '#667eea',
            cancelButtonColor: '#6b7280',
            reverseButtons: true,
        }).then((result) => {
            if (result.isConfirmed) {
                // Show spinner
                const spinner = document.getElementById('spinnerOverlay');
                spinner.style.display = 'flex';
                
                // Submit form after 2 seconds
                setTimeout(() => {
                    form.submit();
                }, 2000);
            }
        });
    };
});
</script>
</body>
</html>