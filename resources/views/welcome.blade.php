<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/png" href="{{ asset('dashboard/build/assets/img/favicon.png') }}" />
    <title>CoreDesk — Complete School Management System</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Open Sans', sans-serif;
            color: #334155;
            background: #f8fafc;
            font-size: 15px;
            line-height: 1.7;
        }

        /* ── NAV ── */
        nav {
            position: sticky; top: 0; z-index: 100;
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(8px);
            border-bottom: 1px solid #e2e8f0;
            padding: 0 32px;
            display: flex; align-items: center; justify-content: space-between;
            height: 64px;
        }
        .nav-logo {
            font-size: 20px; font-weight: 700;
            color: #1e3a5f;
            letter-spacing: -0.5px;
            display: flex; align-items: center; gap: 8px;
        }
        .nav-logo span {
            display: inline-flex; align-items: center; justify-content: center;
            width: 32px; height: 32px;
            background: linear-gradient(135deg, #1e3a5f, #0f6e56);
            border-radius: 8px;
            color: #fff; font-size: 14px; font-weight: 700;
        }
        .nav-links { display: flex; align-items: center; gap: 8px; }
        .nav-links a {
            text-decoration: none; font-size: 13px; font-weight: 600;
            color: #475569; padding: 8px 16px; border-radius: 8px;
            transition: all .15s;
        }
        .nav-links a:hover { background: #f1f5f9; color: #1e3a5f; }
        .nav-links .btn-nav {
            background: #1e3a5f; color: #fff;
            padding: 9px 20px; border-radius: 8px; font-size: 13px; font-weight: 600;
            text-decoration: none; transition: opacity .15s;
        }
        .nav-links .btn-nav:hover { opacity: .88; background: #1e3a5f; color: #fff; }

        /* ── HERO ── */
        .hero {
            background: linear-gradient(135deg, #1e3a5f 0%, #0f4d3a 60%, #0f6e56 100%);
            padding: 96px 32px 80px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .hero::before {
            content: '';
            position: absolute; inset: 0;
            background-image: radial-gradient(circle at 20% 50%, rgba(255,255,255,0.04) 0%, transparent 50%),
                              radial-gradient(circle at 80% 20%, rgba(255,255,255,0.04) 0%, transparent 50%);
        }
        .hero-inner { position: relative; z-index: 1; max-width: 720px; margin: 0 auto; }
        .hero-badge {
            display: inline-flex; align-items: center; gap: 6px;
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.2);
            color: rgba(255,255,255,0.9);
            font-size: 12px; font-weight: 600; letter-spacing: .06em;
            padding: 5px 16px; border-radius: 20px;
            margin-bottom: 28px; text-transform: uppercase;
        }
        .hero h1 {
            font-size: clamp(28px, 4.5vw, 44px);
            font-weight: 700; color: #fff;
            line-height: 1.2; margin-bottom: 20px;
        }
        .hero h1 em { font-style: normal; color: #6ee7b7; }
        .hero p {
            font-size: 16px; color: rgba(255,255,255,0.75);
            max-width: 520px; margin: 0 auto 40px;
        }
        .hero-btns { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }
        .btn-hero-primary {
            display: inline-flex; align-items: center; gap: 8px;
            background: #fff; color: #1e3a5f;
            font-size: 14px; font-weight: 700;
            padding: 14px 28px; border-radius: 10px;
            text-decoration: none; transition: all .15s;
            box-shadow: 0 4px 14px rgba(0,0,0,0.15);
        }
        .btn-hero-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(0,0,0,0.2); }
        .btn-hero-outline {
            display: inline-flex; align-items: center; gap: 8px;
            background: transparent; color: #fff;
            border: 1.5px solid rgba(255,255,255,0.4);
            font-size: 14px; font-weight: 600;
            padding: 14px 28px; border-radius: 10px;
            text-decoration: none; transition: all .15s;
        }
        .btn-hero-outline:hover { background: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.7); }

        .hero-stats {
            display: flex; justify-content: center; gap: 40px;
            margin-top: 56px; flex-wrap: wrap;
        }
        .hero-stat { text-align: center; }
        .hero-stat .num { font-size: 28px; font-weight: 700; color: #fff; }
        .hero-stat .lbl { font-size: 12px; color: rgba(255,255,255,0.6); font-weight: 600; letter-spacing: .04em; text-transform: uppercase; }

        /* ── SECTIONS ── */
        .section { padding: 80px 32px; max-width: 1100px; margin: 0 auto; }
        .section-full { padding: 80px 32px; }
        .section-center { text-align: center; }
        .section-label {
            font-size: 11px; font-weight: 700; letter-spacing: .1em;
            text-transform: uppercase; color: #0f6e56;
            margin-bottom: 10px;
        }
        .section-title {
            font-size: clamp(22px, 3vw, 32px);
            font-weight: 700; color: #0f172a;
            margin-bottom: 14px; line-height: 1.25;
        }
        .section-sub {
            font-size: 15px; color: #64748b;
            max-width: 540px; line-height: 1.7;
            margin-bottom: 52px;
        }
        .section-center .section-sub { margin-left: auto; margin-right: auto; }

        hr.divider { border: none; border-top: 1px solid #e2e8f0; }

        /* ── CARDS ── */
        .grid-3 { display: grid; grid-template-columns: repeat(auto-fit, minmax(290px, 1fr)); gap: 20px; }
        .grid-2 { display: grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap: 20px; }
        .grid-4 { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; }

        .card {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 28px;
            transition: box-shadow .2s, transform .2s;
        }
        .card:hover { box-shadow: 0 8px 30px rgba(0,0,0,0.07); transform: translateY(-2px); }
        .card-icon {
            width: 48px; height: 48px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 22px; margin-bottom: 18px;
        }
        .icon-blue   { background: #dbeafe; }
        .icon-teal   { background: #d1fae5; }
        .icon-purple { background: #ede9fe; }
        .icon-amber  { background: #fef3c7; }
        .card h3 { font-size: 16px; font-weight: 700; color: #0f172a; margin-bottom: 8px; }
        .card p  { font-size: 13px; color: #64748b; line-height: 1.65; margin-bottom: 16px; }
        .tag-list { display: flex; flex-wrap: wrap; gap: 6px; }
        .tag {
            font-size: 11px; font-weight: 600;
            padding: 4px 10px; border-radius: 20px;
        }
        .tag-blue   { background: #dbeafe; color: #1d4ed8; }
        .tag-teal   { background: #d1fae5; color: #065f46; }
        .tag-purple { background: #ede9fe; color: #5b21b6; }
        .tag-amber  { background: #fef3c7; color: #92400e; }

        /* ── WHY ── */
        .why-bg { background: #f0fdf4; }
        .why-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; }
        .why-card {
            background: #fff;
            border: 1px solid #bbf7d0;
            border-radius: 14px; padding: 24px;
        }
        .why-icon {
            width: 40px; height: 40px;
            background: #dcfce7; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 14px; font-size: 18px;
        }
        .why-card h4 { font-size: 14px; font-weight: 700; color: #0f172a; margin-bottom: 6px; }
        .why-card p  { font-size: 13px; color: #64748b; line-height: 1.6; }

        /* ── STEPS ── */
        .steps-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 20px; }
        .step-card {
            background: #fff; border: 1px solid #e2e8f0;
            border-radius: 16px; padding: 28px; position: relative;
        }
        .step-num {
            width: 40px; height: 40px; border-radius: 50%;
            background: linear-gradient(135deg, #1e3a5f, #0f6e56);
            color: #fff; font-size: 16px; font-weight: 700;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 18px;
        }
        .step-card h3 { font-size: 15px; font-weight: 700; margin-bottom: 8px; color: #0f172a; }
        .step-card p  { font-size: 13px; color: #64748b; line-height: 1.65; }

        /* ── ROLES ── */
        .roles-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; }
        .role-card {
            background: #fff; border: 1px solid #e2e8f0;
            border-radius: 16px; padding: 24px; text-align: center;
        }
        .role-avatar {
            width: 52px; height: 52px; border-radius: 50%;
            margin: 0 auto 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 15px; font-weight: 700;
        }
        .av-navy   { background: #bfdbfe; color: #1e40af; }
        .av-teal   { background: #a7f3d0; color: #065f46; }
        .av-purple { background: #ddd6fe; color: #5b21b6; }
        .av-amber  { background: #fde68a; color: #92400e; }
        .role-card h4 { font-size: 14px; font-weight: 700; color: #0f172a; margin-bottom: 4px; }
        .role-card p  { font-size: 12px; color: #94a3b8; }

        /* ── DASHBOARD PREVIEW ── */
        .preview-wrap {
            background: #fff; border: 1px solid #e2e8f0;
            border-radius: 16px; overflow: hidden;
            box-shadow: 0 20px 60px rgba(0,0,0,0.08);
            margin-top: 40px;
        }
        .preview-bar {
            background: #f8fafc; border-bottom: 1px solid #e2e8f0;
            padding: 12px 20px;
            display: flex; align-items: center; gap: 8px;
        }
        .dot { width: 10px; height: 10px; border-radius: 50%; }
        .preview-body { padding: 24px; }
        .preview-stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin-bottom: 20px; }
        .ps { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 14px; }
        .ps .lbl { font-size: 11px; color: #94a3b8; font-weight: 600; text-transform: uppercase; letter-spacing: .05em; margin-bottom: 4px; }
        .ps .val { font-size: 20px; font-weight: 700; color: #0f172a; }
        .ps .sub { font-size: 11px; color: #0f6e56; font-weight: 600; margin-top: 2px; }
        .preview-bars { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 16px; }
        .bar-row { display: flex; align-items: center; gap: 12px; margin-bottom: 10px; }
        .bar-row:last-child { margin-bottom: 0; }
        .bar-lbl { font-size: 11px; color: #94a3b8; font-weight: 600; width: 30px; flex-shrink: 0; }
        .bar-track { flex: 1; height: 7px; background: #e2e8f0; border-radius: 4px; overflow: hidden; }
        .bar-fill { height: 100%; border-radius: 4px; transition: width .6s ease; }

        /* ── TRUST ── */
        .trust-bg { background: #f8fafc; }
        .trust-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 16px; }
        .trust-item {
            background: #fff; border: 1px solid #e2e8f0;
            border-radius: 12px; padding: 20px;
            display: flex; align-items: flex-start; gap: 14px;
        }
        .trust-dot-wrap {
            width: 36px; height: 36px; border-radius: 10px;
            background: #d1fae5; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center;
            font-size: 16px;
        }
        .trust-item strong { display: block; font-size: 13px; font-weight: 700; color: #0f172a; margin-bottom: 3px; }
        .trust-item p { font-size: 12px; color: #64748b; line-height: 1.5; }

        /* ── CTA ── */
        .cta-section {
            background: linear-gradient(135deg, #0f6e56 0%, #1e3a5f 100%);
            padding: 88px 32px; text-align: center;
        }
        .cta-section h2 { font-size: clamp(24px, 3.5vw, 36px); font-weight: 700; color: #fff; margin-bottom: 14px; }
        .cta-section p { font-size: 16px; color: rgba(255,255,255,0.75); max-width: 460px; margin: 0 auto 36px; }
        .btn-cta {
            display: inline-flex; align-items: center; gap: 8px;
            background: #fff; color: #1e3a5f;
            font-size: 15px; font-weight: 700;
            padding: 15px 36px; border-radius: 10px;
            text-decoration: none; transition: all .15s;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
        }
        .btn-cta:hover { transform: translateY(-2px); box-shadow: 0 8px 28px rgba(0,0,0,0.25); }

        /* ── FOOTER ── */
        footer {
            background: #0f172a;
            padding: 48px 32px;
            text-align: center;
        }
        .footer-logo { font-size: 22px; font-weight: 700; color: #fff; margin-bottom: 8px; }
        .footer-sub { font-size: 13px; color: #64748b; margin-bottom: 24px; }
        .footer-links { display: flex; justify-content: center; gap: 24px; flex-wrap: wrap; margin-bottom: 28px; }
        .footer-links a { font-size: 13px; color: #94a3b8; text-decoration: none; transition: color .15s; }
        .footer-links a:hover { color: #fff; }
        .footer-copy { font-size: 12px; color: #475569; }

        @media (max-width: 640px) {
            nav { padding: 0 16px; }
            .hero { padding: 64px 16px 56px; }
            .section { padding: 56px 16px; }
            .section-full { padding: 56px 16px; }
            .preview-stats { grid-template-columns: repeat(2, 1fr); }
            .hero-stats { gap: 24px; }
        }

        /* ── MOBILE NAV ── */
        .nav-toggle {
            display: none;
            flex-direction: column;
            gap: 5px;
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px;
        }
        .nav-toggle span {
            display: block;
            width: 24px; height: 2px;
            background: #1e3a5f;
            border-radius: 2px;
            transition: all .25s;
        }
        .nav-toggle.open span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
        .nav-toggle.open span:nth-child(2) { opacity: 0; }
        .nav-toggle.open span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

        @media (max-width: 768px) {
            .nav-toggle { display: flex; }
            .nav-links {
                display: none;
                position: absolute;
                top: 64px; left: 0; right: 0;
                background: rgba(255,255,255,0.98);
                border-bottom: 1px solid #e2e8f0;
                flex-direction: column;
                align-items: stretch;
                padding: 12px 16px 20px;
                gap: 4px;
                z-index: 99;
            }
            .nav-links.open { display: flex; }
            .nav-links a { padding: 10px 14px; border-radius: 8px; font-size: 14px; }
            .nav-links .btn-nav {
                margin-top: 8px; text-align: center;
                padding: 11px 20px;
            }
        }
    </style>
</head>
<body>

    <!-- NAV -->
    <nav>
        <div class="nav-logo">
            <span>CD</span> CoreDesk
        </div>
        
        <button class="nav-toggle" id="navToggle" aria-label="Toggle menu">
            <span></span><span></span><span></span>
        </button>
        <div class="nav-links" id="navLinks">
            <a href="#features">Features</a>
            <a href="#how-it-works">How It Works</a>
            <a href="{{ route('register') }}" class="btn-nav">Get Started</a>
        </div>
    </nav>

    <!-- HERO -->
    <section class="hero">
        <div class="hero-inner">
            <div class="hero-badge">
                <i class="fa fa-circle" style="font-size:7px;color:#6ee7b7;"></i>
                Complete School Management System
            </div>
            <h1>Manage Your School — <em>All in One Place</em></h1>
            <p>A simple and powerful platform to manage students, staff, academics, finances, and communication — all from one dashboard.</p>
            <div class="hero-btns">
                <a href="{{ route('register') }}" class="btn-hero-primary">
                    <i class="fa fa-rocket"></i> Get Started — Create Your School Account
                </a>
                <div class="login-help-wrapper" style="position: relative; display: inline-block;">
                    <a href="#" class="btn-hero-outline" id="loginHelpBtn" style="cursor: pointer;">
                        <i class="fa fa-sign-in-alt"></i> Login to Your School
                    </a>
                    <div class="login-tooltip" id="loginTooltip" style="display: none; position: absolute; bottom: 100%; left: 50%; transform: translateX(-50%); margin-bottom: 10px; background: #1e293b; color: white; padding: 12px 16px; border-radius: 8px; font-size: 13px; white-space: nowrap; z-index: 100; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                        <i class="fa fa-info-circle"></i> Use your school's subdomain:<br>
                        <strong style="color: #6ee7b7;">yourschool.coredesk.local/login</strong>
                        <div style="position: absolute; top: 100%; left: 50%; transform: translateX(-50%); width: 0; height: 0; border-left: 6px solid transparent; border-right: 6px solid transparent; border-top: 6px solid #1e293b;"></div>
                    </div>
                </div>
            </div>
            <div class="hero-stats">
                <div class="hero-stat">
                    <div class="num" data-count="500" data-suffix="+">0+</div>
                    <div class="lbl">Schools</div>
                </div>
                <div class="hero-stat">
                    <div class="num" data-count="50000" data-suffix="+" data-format="compact">0+</div>
                    <div class="lbl">Students Managed</div>
                </div>
                <div class="hero-stat">
                    <div class="num" data-count="99.9" data-suffix="%" data-decimals="1">0%</div>
                    <div class="lbl">Uptime</div>
                </div>
            </div>
        </div>
    </section>

    <!-- WHAT IS COREDESK -->
    <div class="section section-center">
        <div class="section-label">About</div>
        <div class="section-title">What is CoreDesk for Schools?</div>
        <p class="section-sub">CoreDesk is a modern school management platform designed to help schools run smoothly without stress. From managing students and staff to tracking academics and finances, CoreDesk gives you complete control — anytime, anywhere.</p>

        <div class="preview-wrap" style="max-width:760px;margin:0 auto;">
            <div class="preview-bar">
                <div class="dot" style="background:#ef4444;"></div>
                <div class="dot" style="background:#f59e0b;"></div>
                <div class="dot" style="background:#22c55e;"></div>
                <span style="font-size:12px;color:#94a3b8;font-weight:600;margin-left:8px;">CoreDesk School Dashboard Preview</span>
            </div>
            <div class="preview-body">
                <div class="preview-stats">
                    <div class="ps"><div class="lbl">Students</div><div class="val" data-count="1240" data-format="comma">0</div><div class="sub">+12 this week</div></div>
                    <div class="ps"><div class="lbl">Teachers</div><div class="val" data-count="48">0</div><div class="sub">Active</div></div>
                    <div class="ps"><div class="lbl">Revenue</div><div class="val" data-count="3.2" data-prefix="₦" data-suffix="M" data-decimals="1">₦0M</div><div class="sub">This term</div></div>
                    <div class="ps"><div class="lbl">Attendance</div><div class="val" data-count="94" data-suffix="%">0%</div><div class="sub">Today</div></div>
                </div>
                <div class="preview-bars">
                    <div style="font-size:12px;font-weight:700;color:#64748b;margin-bottom:14px;">Monthly Activity Overview</div>
                    <div class="bar-row"><span class="bar-lbl">Jan</span><div class="bar-track"><div class="bar-fill" style="width:65%;background:linear-gradient(90deg,#1e3a5f,#185FA5);"></div></div><span style="font-size:11px;color:#94a3b8;">65%</span></div>
                    <div class="bar-row"><span class="bar-lbl">Feb</span><div class="bar-track"><div class="bar-fill" style="width:80%;background:linear-gradient(90deg,#1e3a5f,#185FA5);"></div></div><span style="font-size:11px;color:#94a3b8;">80%</span></div>
                    <div class="bar-row"><span class="bar-lbl">Mar</span><div class="bar-track"><div class="bar-fill" style="width:72%;background:linear-gradient(90deg,#1e3a5f,#185FA5);"></div></div><span style="font-size:11px;color:#94a3b8;">72%</span></div>
                    <div class="bar-row"><span class="bar-lbl">Apr</span><div class="bar-track"><div class="bar-fill" style="width:91%;background:linear-gradient(90deg,#0f6e56,#22c55e);"></div></div><span style="font-size:11px;color:#0f6e56;font-weight:700;">91%</span></div>
                </div>
            </div>
        </div>
    </div>

    <hr class="divider">

    <!-- FEATURES (Now 2 cards - School focused with expanded content) -->
    <div id="features" class="section">
        <div class="section-label">Features</div>
        <div class="section-title">Everything Your School Needs to Thrive</div>
        <p class="section-sub">CoreDesk covers every school workflow in one powerful platform — from academics to administration.</p>
        <div class="grid-3">
            <div class="card">
                <div class="card-icon icon-blue">📚</div>
                <h3>Academic Management</h3>
                <p>Complete academic cycle management — from enrollment to result publications and transcripts.</p>
                <div class="tag-list">
                    <span class="tag tag-blue">Student records</span>
                    <span class="tag tag-blue">Results & grades</span>
                    <span class="tag tag-blue">Attendance tracking</span>
                    <span class="tag tag-blue">Transcripts</span>
                </div>
            </div>
            <div class="card">
                <div class="card-icon icon-teal">💰</div>
                <h3>Financial Management</h3>
                <p>Track school fees, expenses, and generate financial reports with ease.</p>
                <div class="tag-list">
                    <span class="tag tag-teal">Fee payments</span>
                    <span class="tag tag-teal">Expense tracking</span>
                    <span class="tag tag-teal">Financial reports</span>
                    <span class="tag tag-teal">Receipts</span>
                </div>
            </div>
            <div class="card">
                <div class="card-icon icon-purple">👥</div>
                <h3>Staff & HR Management</h3>
                <p>Manage teachers and non-teaching staff, payroll, and performance records.</p>
                <div class="tag-list">
                    <span class="tag tag-purple">Staff records</span>
                    <span class="tag tag-purple">Payroll</span>
                    <span class="tag tag-purple">Leave management</span>
                    <span class="tag tag-purple">Performance</span>
                </div>
            </div>
        </div>
    </div>

    <hr class="divider">

    <!-- WHY COREDESK -->
    <section class="section-full why-bg">
        <div style="max-width:1100px;margin:0 auto;padding:0 32px;">
            <div class="section-label">Why CoreDesk</div>
            <div class="section-title">Why Choose CoreDesk for Your School?</div>
            <p class="section-sub">Built with simplicity and power in mind — so you spend less time managing and more time educating.</p>
            <div class="why-grid">
                <div class="why-card">
                    <div class="why-icon">✅</div>
                    <h4>Easy to Use</h4>
                    <p>No technical knowledge required. Get your school online in minutes.</p>
                </div>
                <div class="why-card">
                    <div class="why-icon">🔒</div>
                    <h4>Secure</h4>
                    <p>Your school's data is protected with industry-standard security.</p>
                </div>
                <div class="why-card">
                    <div class="why-icon">👥</div>
                    <h4>Multi-Access</h4>
                    <p>Admins, teachers, students, and parents each have role-based access.</p>
                </div>
                <div class="why-card">
                    <div class="why-icon">☁️</div>
                    <h4>Cloud-Based</h4>
                    <p>Access your dashboard from anywhere — any device, any time.</p>
                </div>
                <div class="why-card">
                    <div class="why-icon">📈</div>
                    <h4>Scalable</h4>
                    <p>Works seamlessly for small nursery schools and large secondary schools alike.</p>
                </div>
            </div>
        </div>
    </section>

    <hr class="divider">

    <!-- HOW IT WORKS -->
    <div id="how-it-works" class="section section-center">
        <div class="section-label">Get Started</div>
        <div class="section-title">Get Your School Online in 3 Simple Steps</div>
        <p class="section-sub">You can be up and running in under 10 minutes — no setup fees, no technical knowledge needed.</p>
        <div class="steps-grid">
            <div class="step-card">
                <div class="step-num">1</div>
                <h3>Create your school account</h3>
                <p>Register your school with just a few basic details — name, location, and admin email.</p>
            </div>
            <div class="step-card">
                <div class="step-num">2</div>
                <h3>Set up your dashboard</h3>
                <p>Configure classes, subjects, add teachers, and enroll students.</p>
            </div>
            <div class="step-card">
                <div class="step-num">3</div>
                <h3>Start managing</h3>
                <p>Track attendance, record results, manage fees — everything from one dashboard.</p>
            </div>
        </div>
    </div>

    <hr class="divider">

    <!-- USER ROLES -->
    <div class="section">
        <div class="section-label">Access Levels</div>
        <div class="section-title">Built for Every School Role</div>
        <p class="section-sub">Every person in your school gets exactly the access they need — no more, no less.</p>
        <div class="roles-grid">
            <div class="role-card">
                <div class="role-avatar av-navy">SA</div>
                <h4>Super Admin</h4>
                <p>Full platform control and oversight</p>
            </div>
            <div class="role-card">
                <div class="role-avatar av-teal">AD</div>
                <h4>School Admin</h4>
                <p>Manage daily school operations</p>
            </div>
            <div class="role-card">
                <div class="role-avatar av-purple">TC</div>
                <h4>Teachers</h4>
                <p>Record results, take attendance, manage classes</p>
            </div>
            <div class="role-card">
                <div class="role-avatar av-amber">ST</div>
                <h4>Students</h4>
                <p>View results, timetable, and announcements</p>
            </div>
        </div>
    </div>

    <hr class="divider">

    <!-- TRUST -->
    <section class="section-full trust-bg">
        <div style="max-width:1100px;margin:0 auto;padding:0 32px;">
            <div class="section-label" style="text-align:center;">Security</div>
            <div class="section-title" style="text-align:center;">Your School's Data is Safe</div>
            <p class="section-sub" style="text-align:center;margin-left:auto;margin-right:auto;">We use secure systems to protect your school's information and ensure only authorized users have access.</p>
            <div class="trust-grid">
                <div class="trust-item">
                    <div class="trust-dot-wrap">🔐</div>
                    <div>
                        <strong>Encrypted storage</strong>
                        <p>All school data is stored securely using industry-standard encryption protocols.</p>
                    </div>
                </div>
                <div class="trust-item">
                    <div class="trust-dot-wrap">🛡️</div>
                    <div>
                        <strong>Role-based access</strong>
                        <p>Each user only sees what they are authorized to view — nothing more.</p>
                    </div>
                </div>
                <div class="trust-item">
                    <div class="trust-dot-wrap">⚡</div>
                    <div>
                        <strong>Always available</strong>
                        <p>Cloud infrastructure ensures your school's data is accessible 24/7 from anywhere.</p>
                    </div>
                </div>
                <div class="trust-item">
                    <div class="trust-dot-wrap">💾</div>
                    <div>
                        <strong>Regular backups</strong>
                        <p>Automatic backups keep your school's records safe against unexpected data loss.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="cta-section">
        <h2>Start Managing Your School Smarter Today</h2>
        <p>Create your school account in minutes and experience a better way to manage everything.</p>
        <a href="{{ route('register') }}" class="btn-cta">
            <i class="fa fa-rocket"></i> Create Your School Account — It's Free
        </a>
    </section>

    <footer>
        <div class="footer-logo">CoreDesk</div>
        <div class="footer-sub">
            Complete School Management System
        </div>
        <div class="footer-links">
            <a href="#">Home</a>
            <a href="#features">Features</a>
            <a href="#how-it-works">How It Works</a>
            <a href="{{ route('register') }}">Register</a>
            <a href="#">Contact</a>
            <a href="#">Support</a>
            <a href="#">Privacy Policy</a>
        </div>

        {{-- Service pitch --}}
        <div style="margin: 20px auto; max-width: 480px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 10px; padding: 14px 20px;">
            <p style="font-size: 13px; color: #94a3b8; margin-bottom: 6px;">
                💡 <strong style="color: #e2e8f0;">Need a custom school management system?</strong>
            </p>
            <p style="font-size: 12px; color: #64748b; line-height: 1.6;">
                We build custom school systems, educational platforms, and more. 
                <a href="tel:+2348137159867" style="color: #6ee7b7; font-weight: 700; text-decoration: none;">Contact Hammock Tech Global →</a>
            </p>
        </div>

        <div class="footer-copy">© <script>document.write(new Date().getFullYear())</script> CoreDesk — A product of Hammock Tech Global. All rights reserved.</div>
    </footer>
</body>
</html>

<script>
    const loginBtn = document.getElementById('loginHelpBtn');
    const tooltip = document.getElementById('loginTooltip');
    
    loginBtn.addEventListener('mouseenter', () => {
        tooltip.style.display = 'block';
    });
    
    loginBtn.addEventListener('mouseleave', () => {
        tooltip.style.display = 'none';
    });

    const navToggle = document.getElementById('navToggle');
    const navLinks = document.getElementById('navLinks');
    navToggle.addEventListener('click', () => {
        navToggle.classList.toggle('open');
        navLinks.classList.toggle('open');
    });
</script>

<script>
(function () {
  function easeOutQuart(t) { return 1 - Math.pow(1 - t, 4); }

  function animateCounter(el) {
    const target = parseFloat(el.dataset.count);
    const suffix = el.dataset.suffix || '';
    const prefix = el.dataset.prefix || '';
    const decimals = parseInt(el.dataset.decimals || '0');
    const format = el.dataset.format || '';
    const duration = 1800;
    const start = performance.now();

    function frame(now) {
      const elapsed = now - start;
      const progress = Math.min(elapsed / duration, 1);
      const eased = easeOutQuart(progress);
      const current = target * eased;
      let display;
      if (format === 'compact') {
        display = current >= 1000 ? Math.round(current / 1000) + 'K' : Math.round(current).toString();
      } else if (format === 'comma') {
        display = Math.round(current).toLocaleString();
      } else if (decimals > 0) {
        display = current.toFixed(decimals);
      } else {
        display = Math.round(current).toString();
      }
      el.textContent = prefix + display + suffix;
      if (progress < 1) requestAnimationFrame(frame);
    }
    requestAnimationFrame(frame);
  }

  function runAll() {
    document.querySelectorAll('[data-count]').forEach(function (el, i) {
      setTimeout(function () { animateCounter(el); }, i * 80);
    });
  }

  const observer = new IntersectionObserver(function (entries, obs) {
    entries.forEach(function (e) {
      if (e.isIntersecting) { runAll(); obs.disconnect(); }
    });
  }, { threshold: 0.3 });

  const trigger = document.querySelector('[data-count]');
  if (trigger) observer.observe(trigger);
})();
</script>