@php
$subdomain = request()->route('subdomain');
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>CoreDesk — Subscription & Billing</title>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --sidebar-w: 260px;
      --purple-dark: #5e35b1;
      --purple-mid: #7c4dff;
      --pink: #e91e8c;
      --blue: #1e88e5;
      --cyan: #00acc1;
      --green: #43a047;
      --emerald: #00897b;
      --amber: #fb8c00;
      --orange: #f4511e;
      --red: #e53935;
      --slate-700: #334155;
      --slate-500: #64748b;
      --slate-400: #94a3b8;
      --slate-300: #cbd5e1;
      --slate-100: #f1f5f9;
      --white: #ffffff;
      --bg: #f8fafc;
      --shadow: 0 4px 24px rgba(0,0,0,0.08);
      --shadow-lg: 0 8px 40px rgba(0,0,0,0.12);
      --radius: 16px;
      --radius-sm: 10px;
      --radius-xs: 7px;
      --font: 'Plus Jakarta Sans', sans-serif;
    }

    body {
      font-family: var(--font);
      background: var(--bg);
      color: var(--slate-700);
      min-height: 100vh;
      display: flex;
    }

    /* ── SIDEBAR ── */
    .sidebar {
      width: var(--sidebar-w);
      min-height: 100vh;
      background: white;
      box-shadow: var(--shadow);
      display: flex;
      flex-direction: column;
      position: fixed;
      left: 0; top: 0; bottom: 0;
      z-index: 100;
      border-radius: 0 var(--radius) var(--radius) 0;
      overflow: hidden;
    }

    .sidebar-logo {
      padding: 22px 20px 16px;
      display: flex;
      align-items: center;
      gap: 10px;
      border-bottom: 1px solid var(--slate-100);
    }

    .sidebar-logo-icon {
      width: 36px; height: 36px;
      background: linear-gradient(135deg, var(--purple-dark), var(--pink));
      border-radius: var(--radius-xs);
      display: flex; align-items: center; justify-content: center;
    }

    .sidebar-logo-icon i { color: white; font-size: 14px; }

    .sidebar-logo-text {
      font-size: 13px;
      font-weight: 700;
      color: var(--slate-700);
      line-height: 1.3;
    }

    .sidebar-logo-text span {
      display: block;
      font-size: 10px;
      font-weight: 500;
      color: var(--slate-400);
    }

    .sidebar-nav { flex: 1; padding: 12px 0; overflow-y: auto; }

    .nav-item {
      display: flex;
      align-items: center;
      gap: 10px;
      margin: 2px 10px;
      padding: 10px 12px;
      border-radius: var(--radius-sm);
      text-decoration: none;
      color: var(--slate-500);
      font-size: 13px;
      font-weight: 500;
      transition: all 0.15s;
      cursor: pointer;
    }

    .nav-item:hover { background: var(--slate-100); color: var(--slate-700); }

    .nav-item.active {
      background: linear-gradient(135deg, var(--purple-dark), var(--pink));
      color: white;
      box-shadow: 0 4px 12px rgba(94,53,177,0.3);
    }

    .nav-item .nav-icon {
      width: 30px; height: 30px;
      border-radius: var(--radius-xs);
      display: flex; align-items: center; justify-content: center;
      flex-shrink: 0;
      font-size: 12px;
    }

    .nav-item.active .nav-icon { background: rgba(255,255,255,0.2); color: white; }
    .nav-item:not(.active) .nav-icon { background: var(--slate-100); color: var(--slate-500); }

    .sidebar-footer {
      padding: 16px;
      border-top: 1px solid var(--slate-100);
    }

    .sidebar-help {
      background: linear-gradient(135deg, #667eea, #764ba2);
      border-radius: var(--radius-sm);
      padding: 14px;
      color: white;
      text-align: center;
    }

    .sidebar-help p { font-size: 11px; opacity: 0.85; margin: 4px 0 10px; }
    .sidebar-help h6 { font-size: 13px; font-weight: 700; }

    .sidebar-help a {
      display: block;
      background: white;
      color: #5e35b1;
      border-radius: 7px;
      padding: 6px;
      font-size: 11px;
      font-weight: 700;
      text-decoration: none;
    }

    /* ── MAIN ── */
    .main {
      margin-left: var(--sidebar-w);
      flex: 1;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    /* ── NAVBAR ── */
    .navbar {
      background: white;
      padding: 14px 28px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      box-shadow: 0 1px 0 var(--slate-100);
      position: sticky;
      top: 0;
      z-index: 50;
    }

    .navbar-left { display: flex; align-items: center; gap: 12px; }

    .navbar-search {
      display: flex;
      align-items: center;
      gap: 8px;
      background: var(--slate-100);
      border-radius: 20px;
      padding: 7px 14px;
      font-size: 12px;
      color: var(--slate-400);
    }

    .navbar-search input {
      border: none; background: transparent;
      font-family: var(--font);
      font-size: 12px;
      color: var(--slate-700);
      outline: none;
      width: 160px;
    }

    .navbar-right { display: flex; align-items: center; gap: 14px; }

    .navbar-icon-btn {
      width: 34px; height: 34px;
      border-radius: 50%;
      background: var(--slate-100);
      border: none;
      cursor: pointer;
      display: flex; align-items: center; justify-content: center;
      color: var(--slate-500);
      font-size: 13px;
      position: relative;
      transition: background 0.15s;
    }

    .navbar-icon-btn:hover { background: var(--slate-300); }

    .badge {
      position: absolute; top: 2px; right: 2px;
      width: 8px; height: 8px;
      background: var(--red);
      border-radius: 50%;
      border: 1.5px solid white;
    }

    .navbar-avatar {
      width: 34px; height: 34px;
      border-radius: 50%;
      background: linear-gradient(135deg, var(--purple-dark), var(--pink));
      display: flex; align-items: center; justify-content: center;
      color: white;
      font-size: 12px;
      font-weight: 700;
      cursor: pointer;
    }

    .navbar-user { font-size: 12px; font-weight: 600; color: var(--slate-700); cursor: pointer; }
    .navbar-user span { display: block; font-size: 10px; font-weight: 400; color: var(--slate-400); }

    /* ── PAGE CONTENT ── */
    .content { padding: 28px; flex: 1; }

    /* page header */
    .page-header {
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
      margin-bottom: 24px;
      flex-wrap: wrap;
      gap: 12px;
    }

    .page-header h3 { font-size: 22px; font-weight: 800; color: var(--slate-700); margin-bottom: 4px; }

    .breadcrumb { font-size: 12px; color: var(--slate-400); display: flex; align-items: center; gap: 6px; }
    .breadcrumb span { color: var(--slate-600); }

    .btn-back {
      display: flex; align-items: center; gap: 6px;
      padding: 8px 16px;
      border: 1.5px solid var(--slate-300);
      border-radius: var(--radius-xs);
      background: white;
      color: var(--slate-600);
      font-family: var(--font);
      font-size: 12px;
      font-weight: 600;
      cursor: pointer;
      text-decoration: none;
      transition: all 0.15s;
    }

    .btn-back:hover { background: var(--slate-100); }

    /* section card */
    .section-card {
      background: white;
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      overflow: hidden;
      margin-bottom: 20px;
    }

    .section-header {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 14px 20px;
    }

    .section-header.blue { background: linear-gradient(135deg, #1e88e5, #00acc1); }
    .section-header.purple { background: linear-gradient(135deg, #7c3aed, #e91e8c); }
    .section-header.green { background: linear-gradient(135deg, #2e7d32, #00897b); }

    .section-header-icon {
      width: 32px; height: 32px;
      background: rgba(255,255,255,0.2);
      border-radius: var(--radius-xs);
      display: flex; align-items: center; justify-content: center;
      color: white;
      font-size: 13px;
    }

    .section-header h6 { font-size: 14px; font-weight: 700; color: white; margin-bottom: 1px; }
    .section-header p { font-size: 11px; color: rgba(255,255,255,0.75); }

    .section-body { padding: 20px; }

    /* stat grid */
    .grid-4 { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; }
    .grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; }
    .grid-2 { display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; }

    .stat-box {
      background: var(--slate-100);
      border-radius: var(--radius-sm);
      padding: 14px 16px;
    }

    .stat-box .label { font-size: 10px; color: var(--slate-400); margin-bottom: 4px; font-weight: 500; letter-spacing: 0.5px; text-transform: uppercase; }
    .stat-box .value { font-size: 18px; font-weight: 800; color: var(--slate-700); }
    .stat-box .value.green { color: var(--green); }
    .stat-box .value.red { color: var(--red); }

    /* alert strip */
    .alert {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 10px 14px;
      border-radius: var(--radius-sm);
      margin-top: 14px;
      font-size: 12px;
      font-weight: 500;
    }

    .alert.amber { background: #fffbeb; border: 1px solid #fcd34d; color: #92400e; }
    .alert.green { background: #f0fdf4; border: 1px solid #86efac; color: #166534; }
    .alert i { font-size: 14px; flex-shrink: 0; }

    /* plan cards */
    .plans-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; }

    .plan-card {
      border: 2px solid var(--slate-300);
      border-radius: var(--radius-sm);
      overflow: hidden;
      display: flex;
      flex-direction: column;
      transition: box-shadow 0.2s, transform 0.2s;
      position: relative;
    }

    .plan-card:hover { box-shadow: var(--shadow-lg); transform: translateY(-2px); }
    .plan-card.active { border-color: #22c55e; box-shadow: 0 0 0 3px rgba(34,197,94,0.15); }

    .plan-head { padding: 16px 14px; text-align: center; }
    .plan-head[data-plan="free"] { background: linear-gradient(135deg, #f0fdf4, #dcfce7); }
    .plan-head[data-plan="starter"] { background: linear-gradient(135deg, #eff6ff, #dbeafe); }
    .plan-head[data-plan="growth"] { background: linear-gradient(135deg, #faf5ff, #ede9fe); }
    .plan-head[data-plan="pro"] { background: linear-gradient(135deg, #fffbeb, #fef3c7); }

    .plan-icon {
      width: 38px; height: 38px;
      border-radius: var(--radius-xs);
      display: flex; align-items: center; justify-content: center;
      margin: 0 auto 8px;
      font-size: 15px;
      color: white;
    }

    .plan-icon[data-plan="free"] { background: linear-gradient(135deg, #22c55e, #16a34a); }
    .plan-icon[data-plan="starter"] { background: linear-gradient(135deg, #3b82f6, #0ea5e9); }
    .plan-icon[data-plan="growth"] { background: linear-gradient(135deg, #a855f7, #ec4899); }
    .plan-icon[data-plan="pro"] { background: linear-gradient(135deg, #f59e0b, #ef4444); }

    .plan-name { font-size: 13px; font-weight: 800; color: var(--slate-700); text-transform: uppercase; }
    .plan-price { font-size: 20px; font-weight: 800; color: var(--slate-800); margin: 4px 0 1px; }
    .plan-period { font-size: 10px; color: var(--slate-400); }

    .plan-body { padding: 12px 14px; flex: 1; display: flex; flex-direction: column; }

    .plan-features { list-style: none; flex: 1; margin-bottom: 10px; }
    .plan-features li {
      display: flex; align-items: flex-start; gap: 6px;
      font-size: 11px; color: var(--slate-500);
      padding: 3px 0;
    }

    .plan-features li i { color: #22c55e; font-size: 10px; margin-top: 1px; flex-shrink: 0; }

    .plan-badge {
      font-size: 10px;
      padding: 4px 8px;
      border-radius: 6px;
      text-align: center;
      margin-bottom: 8px;
      font-weight: 500;
    }

    .plan-badge.amber { background: #fffbeb; color: #92400e; border: 1px solid #fcd34d; }
    .plan-badge.green { background: #f0fdf4; color: #166534; border: 1px solid #86efac; }
    .plan-badge.blue { background: #eff6ff; color: #1e40af; border: 1px solid #93c5fd; }

    .plan-btn {
      width: 100%;
      padding: 8px;
      border: none;
      border-radius: var(--radius-xs);
      font-family: var(--font);
      font-size: 11px;
      font-weight: 700;
      cursor: pointer;
      transition: all 0.15s;
      color: white;
    }

    .plan-btn:hover:not(:disabled) { opacity: 0.88; transform: scale(1.02); }
    .plan-btn:disabled { background: #e5e7eb; color: #9ca3af; cursor: not-allowed; transform: none; }
    .plan-btn[data-plan="free"] { background: linear-gradient(135deg, #4b5563, #374151); }
    .plan-btn[data-plan="starter"] { background: linear-gradient(135deg, #3b82f6, #0ea5e9); }
    .plan-btn[data-plan="growth"] { background: linear-gradient(135deg, #a855f7, #ec4899); }
    .plan-btn[data-plan="pro"] { background: linear-gradient(135deg, #f59e0b, #ef4444); }

    .best-value-badge {
      position: absolute; top: 0; right: 0;
      background: linear-gradient(135deg, #f59e0b, #ef4444);
      color: white;
      font-size: 9px;
      font-weight: 800;
      padding: 3px 8px;
      border-radius: 0 var(--radius-xs) 0 var(--radius-xs);
      letter-spacing: 0.5px;
    }

    /* ========== FALLBACK / DYNAMIC PLAN STYLES ========== */

/* Plan head background for custom plans */
.plan-head[data-plan="custom"] {
    background: linear-gradient(135deg, #e2e8f0, #cbd5e1);
}

/* Plan icon for custom plans */
.plan-icon[data-plan="custom"] {
    background: linear-gradient(135deg, #64748b, #475569);
}

/* Button for custom plans */
.plan-btn[data-plan="custom"] {
    background: linear-gradient(135deg, #64748b, #475569);
}

/* Plan badge for custom plans */
.plan-badge.gray {
    background: #f1f5f9;
    color: #475569;
    border: 1px solid #cbd5e1;
}

/* ✅ GENERAL FALLBACK - applies to ANY plan without specific styles */
.plan-head:not([data-plan="free"]):not([data-plan="starter"]):not([data-plan="growth"]):not([data-plan="pro"]):not([data-plan="custom"]) {
    background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
}

.plan-icon:not([data-plan="free"]):not([data-plan="starter"]):not([data-plan="growth"]):not([data-plan="pro"]):not([data-plan="custom"]) {
    background: linear-gradient(135deg, #64748b, #475569);
}

.plan-btn:not([data-plan="free"]):not([data-plan="starter"]):not([data-plan="growth"]):not([data-plan="pro"]):not([data-plan="custom"]) {
    background: linear-gradient(135deg, #64748b, #475569);
}

    

    /* step cards */
    .step-card {
      background: var(--slate-100);
      border-radius: var(--radius-sm);
      padding: 16px;
      text-align: center;
    }

    .step-num {
      width: 32px; height: 32px;
      border-radius: var(--radius-xs);
      display: flex; align-items: center; justify-content: center;
      margin: 0 auto 8px;
      font-size: 13px;
      font-weight: 800;
      color: white;
    }

    .step-card h6 { font-size: 12px; font-weight: 700; color: var(--slate-700); margin-bottom: 3px; }
    .step-card p { font-size: 10px; color: var(--slate-400); }

    /* bank / contact */
    .info-box {
      background: var(--slate-100);
      border-radius: var(--radius-sm);
      padding: 14px;
      border: 1px solid var(--slate-300);
    }

    .info-box-header {
      display: flex; align-items: center; gap: 8px;
      margin-bottom: 10px;
    }

    .info-box-header .icon {
      width: 26px; height: 26px;
      border-radius: 6px;
      display: flex; align-items: center; justify-content: center;
      font-size: 10px;
      color: white;
      flex-shrink: 0;
    }

    .info-box-header h6 { font-size: 12px; font-weight: 700; color: var(--slate-700); }

    .info-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 7px 10px;
      background: white;
      border-radius: 7px;
      margin-bottom: 5px;
      font-size: 11px;
    }

    .info-row .key { color: var(--slate-400); }
    .info-row .val { font-weight: 700; color: var(--slate-700); }

    .contact-row {
      display: flex;
      align-items: flex-start;
      gap: 10px;
      padding: 7px 10px;
      background: white;
      border-radius: 7px;
      margin-bottom: 5px;
      font-size: 11px;
    }

    .contact-row i { font-size: 13px; margin-top: 1px; flex-shrink: 0; }
    .contact-row .sub { font-size: 9px; color: var(--slate-400); margin-bottom: 2px; }
    .contact-row .val { font-weight: 700; color: var(--slate-700); }

    /* instructions */
    .instructions {
      background: #fffbeb;
      border: 1px solid #fcd34d;
      border-radius: var(--radius-sm);
      padding: 14px 16px;
      display: flex;
      gap: 10px;
      align-items: flex-start;
    }

    .instructions i { color: #d97706; font-size: 15px; flex-shrink: 0; margin-top: 1px; }
    .instructions h6 { font-size: 12px; font-weight: 700; color: #92400e; margin-bottom: 5px; }
    .instructions p { font-size: 11px; color: #92400e; line-height: 1.7; }

    /* footer */
    .footer {
      padding: 16px 28px;
      border-top: 1px solid var(--slate-100);
      display: flex;
      align-items: center;
      justify-content: space-between;
      font-size: 11px;
      color: var(--slate-400);
    }

    /* scrollbar */
    ::-webkit-scrollbar { width: 5px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: var(--slate-300); border-radius: 99px; }

    @media (max-width: 1024px) {
      .grid-4, .plans-grid { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 768px) {
      .sidebar { display: none; }
      .main { margin-left: 0; }
      .grid-4, .grid-3, .grid-2, .plans-grid { grid-template-columns: 1fr; }
      .content { padding: 16px; }
    }
  </style>
</head>
<body>

  <!-- SIDEBAR -->
  <aside class="sidebar">
    <div class="sidebar-logo">
      <div class="sidebar-logo-icon"><i class="fa fa-graduation-cap"></i></div>
      <div class="sidebar-logo-text">
        {{ app('tenant')->name ?? 'CoreDesk' }}
        <span>{{ $subdomain ?? '' }}.coredesk.local</span>
      </div>
    </div>

     @php
     $user = auth()->user();
     @endphp
    <nav class="sidebar-nav">
     {{-- SUPER ADMIN ONLY --}}
      @if($user && $user->role === 'super_admin')
      <a class="nav-item" href="{{ route('tenant.admin.dashboard', $subdomain) }}">
        <div class="nav-icon"><i class="fa fa-home"></i></div> Dashboard
      </a>
      
      <a class="nav-item active" href="#">
        <div class="nav-icon"><i class="fa fa-credit-card"></i></div> Upgrade Plan
      </a>
      <!-- <a class="nav-item" href="#">
        <div class="nav-icon"><i class="fa fa-file-alt"></i></div> Reports Card
      </a>
      <a class="nav-item" href="#">
        <div class="nav-icon"><i class="fa fa-poll"></i></div> Results
      </a>
      <a class="nav-item" href="#">
        <div class="nav-icon"><i class="fa fa-calendar-alt"></i></div> Class Timetable
      </a>
      <a class="nav-item" href="#">
        <div class="nav-icon"><i class="fa fa-clipboard-list"></i></div> Test Timetable
      </a>
      <a class="nav-item" href="#">
        <div class="nav-icon"><i class="fa fa-calendar-check"></i></div> Exam Timetable
      </a>
      <a class="nav-item" href="#">
        <div class="nav-icon"><i class="fa fa-users"></i></div> Users
      </a>
      <a class="nav-item" href="#">
        <div class="nav-icon"><i class="fa fa-cog"></i></div> Settings
      </a>
      <a class="nav-item" href="#" style="color:#e53935;">
        <div class="nav-icon" style="background:#fef2f2;"><i class="fa fa-sign-out-alt" style="color:#e53935;"></i></div> Sign Out
      </a> -->
    </nav>
    @endif

    <div class="sidebar-footer">
      <div class="sidebar-help">
        <h6>Need help?</h6>
        <p>Contact Us 24/7</p>
        <a href="#">+2348137159867</a>
      </div>
    </div>
  </aside>

  <!-- MAIN -->
  <div class="main">

    <!-- NAVBAR -->
     <nav class="navbar">
    <div class="navbar-left">
        @php
            $user = auth()->user();

            $student = null;
            if (function_exists('currentStudent') && (!$user || $user->role !== 'owner')) {
                $student = currentStudent();
            }

            if ($user) {
                $name = explode(' ', $user->name)[0];
                $fullName = $user->name;
                $email = $user->email;
                $roleLabel = match($user->role) {
                    'super_admin' => 'Super Admin',
                    'teacher'     => 'Teacher',
                    'accountant'  => 'Accountant',
                    'owner'       => 'Owner',
                    default       => ucfirst($user->role),
                };
                $initials = strtoupper(substr($user->name, 0, 1) . (str_contains($user->name, ' ') ? substr(strstr($user->name, ' '), 1, 1) : ''));
            } elseif ($student) {
                $name = explode(' ', $student->name)[0];
                $fullName = $student->name;
                $email = $student->email ?? '';
                $roleLabel = 'Student';
                $initials = strtoupper(substr($student->name, 0, 1) . (str_contains($student->name, ' ') ? substr(strstr($student->name, ' '), 1, 1) : ''));
            } else {
                $name = 'Guest';
                $fullName = 'Guest';
                $email = '';
                $roleLabel = 'Guest';
                $initials = 'G';
            }

            $hour = now()->hour;

            if ($hour >= 5 && $hour < 12) {
                $greeting = "Good morning, {$name} ☀️";
                $sub = "Hope you have a productive day ahead!";
            } elseif ($hour >= 12 && $hour < 14) {
                $greeting = "What a lovely afternoon, {$name} 🌤️";
                $sub = "Hope you've had lunch — you need the energy!";
            } elseif ($hour >= 14 && $hour < 17) {
                $greeting = "Good afternoon, {$name} 🌥️";
                $sub = "Keep pushing, you're doing great!";
            } elseif ($hour >= 17 && $hour < 20) {
                $greeting = "Good evening, {$name} 🌇";
                $sub = "It's past 6PM — hope you're not too exhausted!";
            } elseif ($hour >= 20 && $hour < 23) {
                $greeting = "Good evening, {$name} 🌙";
                $sub = "Wrapping up for the day? You've earned it!";
            } else {
                $greeting = "Burning the midnight oil, {$name}? 🌚";
                $sub = "Don't forget to rest — it's past midnight!";
            }
        @endphp

        <div class="navbar-search">
            <i class="fa fa-school" style="color:#94a3b8;font-size:11px;"></i>
            {{ $greeting }}
            <p>{{ now()->format('l, F j Y') }} &mdash; {{ $sub }}</p>
        </div>
    </div>

    <div class="navbar-right">
        <!-- <button class="navbar-icon-btn">
            <i class="fa fa-bell"></i>
            <span class="badge"></span>
        </button>
        <button class="navbar-icon-btn">
            <i class="fa fa-cog"></i>
        </button> -->

        {{-- Dynamic initials avatar --}}
        <div class="navbar-avatar">{{ $initials }}</div>

        {{-- Dynamic name and role --}}
        <div class="navbar-user">
            {{ $fullName }}
            <span>{{ $email }}</span>
        </div>
    </div>
</nav>
 

    <!-- PAGE CONTENT -->
    <div class="content">

      <!-- Page Header -->
      <div class="page-header">
        <div>
          <h3>Subscription & Billing</h3>
          <div class="breadcrumb">
            <i class="fa fa-home"></i> Dashboard
            <i class="fa fa-chevron-right" style="font-size:9px;"></i>
            <span>Billing</span>
          </div>
        </div>
        <a href="{{ route('tenant.admin.dashboard', $subdomain) }}" class="btn-back">
          <i class="fa fa-arrow-left"></i> Back to Dashboard
        </a>
      </div>

      <!-- SECTION 1: CURRENT SUBSCRIPTION -->
      <div class="section-card">
        <div class="section-header blue">
          <div class="section-header-icon"><i class="fa fa-credit-card"></i></div>
          <div>
            <h6>Current Subscription</h6>
            <p>Your active plan details</p>
          </div>
        </div>
        <div class="section-body">
          <div class="grid-4" style="margin-bottom:14px;">
            <div class="stat-box">
              <div class="label">Current Plan</div>
              <div class="value">{{ strtoupper($tenant->plan ?? 'FREE') }}</div>
            </div>
            <div class="stat-box">
              <div class="label">Status</div>
              <div class="value {{ ($tenant->is_active ?? true) ? 'green' : 'red' }}">
                {{ ($tenant->is_active ?? true) ? 'Active' : 'Inactive' }}
                @if($tenant->is_active ?? true)<i class="fa fa-check-circle" style="font-size:13px;"></i>@endif
              </div>
            </div>
            <div class="stat-box">
              <div class="label">Start Date</div>
              <div class="value" style="font-size:14px;">{{ $tenant->starts_at ? \Carbon\Carbon::parse($tenant->starts_at)->format('Y-m-d') : 'N/A' }}</div>
            </div>
            <div class="stat-box">
              <div class="label">Expiry Date</div>
              <div class="value" style="font-size:14px;">{{ $tenant->expires_at ? \Carbon\Carbon::parse($tenant->expires_at)->format('Y-m-d') : 'N/A' }}</div>
            </div>
          </div>
          
          @if(($tenant->plan ?? 'free') === 'free')
          <div class="alert amber">
            <i class="fa fa-exclamation-triangle"></i>
            <p><strong>You are on the FREE Plan —</strong> Limited to {{ $freePlan->max_students ?? 3 }} students and {{ $freePlan->max_teachers ?? 2 }} teacher(s). Upgrade to unlock more features.</p>
          </div>
          @elseif(($tenant->expires_at ?? null) && \Carbon\Carbon::parse($tenant->expires_at)->isPast())
          <div class="alert red" style="background:#fef2f2; border-color:#fecaca; color:#dc2626;">
            <i class="fa fa-exclamation-triangle"></i>
            <p><strong>Your subscription has expired!</strong> Please renew to continue using premium features.</p>
          </div>
          @else
          <div class="alert green">
            <i class="fa fa-check-circle"></i>
            <p><strong>Your subscription is active</strong> — Enjoy all features of the {{ strtoupper($tenant->plan) }} plan.</p>
          </div>
          @endif
        </div>
      </div>

      <!-- SECTION 2: UPGRADE PLANS -->
<div class="section-card">
  <div class="section-header purple">
    <div class="section-header-icon"><i class="fa fa-rocket"></i></div>
    <div>
      <h6>Upgrade Your Plan</h6>
      <p>Choose the perfect plan for your school</p>
    </div>
  </div>
  <div class="section-body">
    <div class="plans-grid">
      @foreach($plans as $plan)
      @php
        $planKey = strtolower($plan->name);
        $isCurrentPlan = ($tenant->plan ?? 'free') === $planKey;
        $isBestValue = $planKey === 'pro';
        $badgeText = '';
        $badgeClass = '';
        
        if ($planKey === 'free') {
          $badgeText = '⚠ Best for testing';
          $badgeClass = 'amber';
        } elseif ($planKey === 'starter') {
          $badgeText = '✅ Small private schools';
          $badgeClass = 'green';
        } elseif ($planKey === 'growth') {
          $badgeText = '🚀 Growing institutions';
          $badgeClass = 'blue';
        } elseif ($planKey === 'pro') {
          $badgeText = '🏆 Large or multi-campus schools';
          $badgeClass = 'amber';
        } else {
          // ✅ FALLBACK for any other plan name
          $badgeText = '📋 Custom Plan';
          $badgeClass = 'gray';
          $planColorClass = 'custom';
        }
        
        // Button color classes based on plan
        $btnColorClass = '';
        if ($planKey === 'free') $btnColorClass = 'btn-free';
        elseif ($planKey === 'starter') $btnColorClass = 'btn-starter';
        elseif ($planKey === 'growth') $btnColorClass = 'btn-growth';
        elseif ($planKey === 'pro') $btnColorClass = 'btn-pro';
      @endphp
      <div class="plan-card {{ $isCurrentPlan ? 'active' : '' }}">
    @if($isBestValue)<div class="best-value-badge">BEST VALUE</div>@endif
    <div class="plan-head" data-plan="{{ $planColorClass ?? $planKey }}">
        <div class="plan-icon" data-plan="{{ $planColorClass ?? $planKey }}">
            @if($planKey === 'free')
                <i class="fa fa-gift"></i>
            @elseif($planKey === 'starter')
                <i class="fa fa-star"></i>
            @elseif($planKey === 'growth')
                <i class="fa fa-chart-line"></i>
            @elseif($planKey === 'pro')
                <i class="fa fa-crown"></i>
            @else
                <i class="fa fa-layer-group"></i>
            @endif
        </div>
        <div class="plan-name">{{ strtoupper($plan->name) }}</div>
        <div class="plan-price">₦{{ number_format($plan->price, 0) }}</div>
        <div class="plan-period">per 30 days</div>
    </div>
    <div class="plan-body">
        <ul class="plan-features">
            <li><i class="fa fa-check-circle"></i> Up to {{ $plan->max_students ?? 'Unlimited' }} students</li>
            <li><i class="fa fa-check-circle"></i> {{ $plan->max_teachers ? 'Up to '.$plan->max_teachers.' teachers' : 'Unlimited teachers' }}</li>
            <li><i class="fa fa-check-circle"></i> Full dashboard access</li>
            <li><i class="fa fa-check-circle"></i> Result management</li>
            <li><i class="fa fa-check-circle"></i> Timetable & exams</li>
        </ul>
        <div class="plan-badge {{ $badgeClass }}">{{ $badgeText }}</div>
        @if($isCurrentPlan)
            <button class="plan-btn current-plan-btn" data-plan="{{ $planColorClass ?? $planKey }}" disabled>
                <i class="fa fa-check-circle"></i> Current Plan
            </button>
        @else
            <button class="plan-btn upgrade-btn {{ $btnColorClass }}" data-plan="{{ $planColorClass ?? $planKey }}" onclick="selectPlan('{{ $planKey }}')">
                Upgrade to {{ ucfirst($plan->name) }}
            </button>
        @endif
    </div>
</div>
      @endforeach
    </div>
  </div>
</div>

      <!-- SECTION 3: PAYMENT & RENEWAL -->
      <div class="section-card">
        <div class="section-header green">
          <div class="section-header-icon"><i class="fa fa-money-bill-wave"></i></div>
          <div>
            <h6>Payment & Renewal</h6>
            <p>How to upgrade or renew your subscription</p>
          </div>
        </div>
        <div class="section-body">

          <!-- Steps Row -->
          <div class="grid-3" style="margin-bottom:16px;">
            <div class="step-card">
              <div class="step-num" style="background:linear-gradient(135deg,#3b82f6,#0ea5e9);">1</div>
              <h6>Choose a Subscription</h6>
              <p>Select your preferred plan above</p>
            </div>
            <div class="step-card">
              <div class="step-num" style="background:linear-gradient(135deg,#a855f7,#ec4899);">2</div>
              <h6>Make Payment</h6>
              <p>Transfer to the account below</p>
            </div>
            <div class="step-card">
              <div class="step-num" style="background:linear-gradient(135deg,#22c55e,#16a34a);">3</div>
              <h6>Send Proof of Payment</h6>
              <p>Contact customer service</p>
            </div>
          </div>

          <!-- Bank + Contact Row -->
          <div class="grid-2" style="margin-bottom:16px;">

            <div class="info-box">
              <div class="info-box-header">
                <div class="icon" style="background:linear-gradient(135deg,#3b82f6,#0ea5e9);"><i class="fa fa-university"></i></div>
                <h6>Bank Transfer Details</h6>
              </div>
              <div class="info-row">
                <span class="key">Bank Name</span>
                <span class="val">Zenith Bank</span>
              </div>
              <div class="info-row">
                <span class="key">Account Name</span>
                <span class="val">Click Mart</span>
              </div>
              <div class="info-row">
                <span class="key">Account Number</span>
                <span class="val">1017058266</span>
              </div>
              <div class="info-row">
                <span class="key">A product Of </span>
                <span class="val">Hammock Tech Global Ltd</span>
              </div>
            </div>

            <div class="info-box">
              <div class="info-box-header">
                <div class="icon" style="background:linear-gradient(135deg,#22c55e,#16a34a);"><i class="fa fa-headset"></i></div>
                <h6>Customer Service</h6>
              </div>
              <div class="contact-row">
                <i class="fa fa-phone" style="color:#22c55e;"></i>
                <div>
                  <div class="sub">WhatsApp / Call / Text</div>
                  <div class="val">+234 813 715 9867</div>
                </div>
              </div>
              <div class="contact-row">
                <i class="fa fa-envelope" style="color:#3b82f6;"></i>
                <div>
                  <div class="sub">Email Addresses</div>
                  <div class="val">hammocktechglobal@gmail.com</div>
                  <!-- <div class="val">clickmartlogistic@gmail.com</div> -->
                </div>
              </div>
            </div>

          </div>

          <!-- Instructions -->
          <div class="instructions">
            <i class="fa fa-info-circle"></i>
            <div>
              <h6>How to Renew / Upgrade</h6>
              <p>
                1. Select your desired plan from the options above. &nbsp;
                2. Make payment to the bank account provided. &nbsp;
                3. Send your proof of payment (screenshot/receipt) via WhatsApp or Email. &nbsp;
                4. Include your school name and subdomain. &nbsp;
                5. Your subscription will be activated within 24 hours. &nbsp;
                <strong>Note:</strong> All payments are non-refundable. Subscription automatically expires after 30 days for paid plans.
              </p>
            </div>
          </div>

        </div>
      </div>
    </div>

    <!-- FOOTER -->
    <div class="footer">
      @include('layouts.footer')
    </div>

  </div><!-- /main -->

  <script>
    function selectPlan(plan) {
      alert('Please make payment to the bank account and send proof of payment to customer service.\n\nPlan selected: ' + plan.toUpperCase());
    }
  </script>

</body>
</html>