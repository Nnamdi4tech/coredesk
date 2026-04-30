<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CoreDesk - All-in-One Management Platform</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: #1e293b;
            overflow-x: hidden;
        }

        /* Navigation */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.25rem 5%;
            background: white;
            box-shadow: 0 2px 20px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .logo {
            font-size: 1.75rem;
            font-weight: 800;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            text-decoration: none;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 1rem;
            list-style: none;
        }

        .nav-links li {
            display: flex;
            align-items: center;
        }

        .nav-link {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            font-weight: 600;
            transition: all 0.3s ease;
            color: #64748b;
            text-decoration: none;
            border-radius: 8px;
        }

        .nav-link:hover {
            color: #3b82f6;
            background: #f1f5f9;
        }

        .nav-link i {
            margin-right: 0.5rem;
        }

        .logout-btn {
            background: none;
            border: none;
            cursor: pointer;
            width: 100%;
            text-align: left;
            font-family: 'Inter', sans-serif;
            font-size: 0.875rem;
            font-weight: 600;
            padding: 0.5rem 1rem;
            color: #64748b;
            transition: all 0.3s ease;
            border-radius: 8px;
        }

        .logout-btn:hover {
            color: #ef4444;
            background: #fef2f2;
        }

        .logout-btn i {
            margin-right: 0.5rem;
        }

        .user-name {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            font-weight: 600;
            color: #3b82f6;
            background: #eff6ff;
            border-radius: 8px;
            margin-left: 0.5rem;
        }

        .btn-outline {
            padding: 0.625rem 1.5rem;
            border: 2px solid #3b82f6;
            background: transparent;
            color: #3b82f6;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-outline:hover {
            background: #3b82f6;
            color: white;
        }

        .btn-primary {
            padding: 0.625rem 1.5rem;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.3s, box-shadow 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(59,130,246,0.4);
        }

        .btn-large {
            padding: 0.875rem 2.5rem;
            font-size: 1.1rem;
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 5rem 5%;
            text-align: center;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .hero p {
            font-size: 1.25rem;
            max-width: 600px;
            margin: 0 auto 2rem;
            opacity: 0.95;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .hero .btn-primary {
            background: white;
            color: #667eea;
        }

        .hero .btn-outline {
            border-color: white;
            color: white;
        }

        .hero .btn-outline:hover {
            background: white;
            color: #667eea;
        }

        /* Container */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 5rem 2rem;
        }

        /* Section Titles */
        .section-title {
            text-align: center;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .section-subtitle {
            text-align: center;
            color: #64748b;
            margin-bottom: 3rem;
            font-size: 1.125rem;
        }

        /* Features Grid */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .feature-card {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            border: 1px solid #e2e8f0;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);
        }

        .feature-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .feature-card h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: #1e293b;
        }

        .feature-card ul {
            list-style: none;
            margin-top: 1rem;
        }

        .feature-card li {
            margin: 0.75rem 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #475569;
        }

        .feature-card li i {
            color: #3b82f6;
            font-size: 0.875rem;
        }

        /* Why Choose Us */
        .why-section {
            background: #f8fafc;
        }

        .benefits-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .benefit-item {
            text-align: center;
            padding: 2rem;
            background: white;
            border-radius: 16px;
            transition: transform 0.3s;
        }

        .benefit-item:hover {
            transform: translateY(-5px);
        }

        .benefit-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .benefit-item h4 {
            font-size: 1.25rem;
            margin-bottom: 0.5rem;
        }

        /* How It Works */
        .steps {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 2rem;
            margin-top: 3rem;
        }

        .step {
            flex: 1;
            text-align: center;
            padding: 2rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 16px;
            min-width: 250px;
        }

        .step-number {
            width: 50px;
            height: 50px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: bold;
            margin: 0 auto 1rem;
        }

        .step h3 {
            margin-bottom: 1rem;
        }

        /* Roles Grid */
        .roles-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .role-card {
            text-align: center;
            padding: 1.5rem;
            background: #f1f5f9;
            border-radius: 12px;
            transition: all 0.3s;
        }

        .role-card:hover {
            background: #3b82f6;
            color: white;
            transform: translateY(-3px);
        }

        .role-card i {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .role-card h4 {
            font-size: 1.125rem;
            font-weight: 600;
        }

        /* Dashboard Preview */
        .dashboard-preview {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            color: white;
            text-align: center;
        }

        .dashboard-preview .section-title {
            color: white;
        }

        /* Trust Section */
        .trust-section {
            text-align: center;
            background: #f8fafc;
        }

        .trust-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: white;
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
        }

        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-align: center;
        }

        .cta-section h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .cta-section .btn-primary {
            background: white;
            color: #667eea;
            margin-top: 1rem;
        }

        /* Footer */
        .footer {
            background: #0f172a;
            color: #94a3b8;
            text-align: center;
            padding: 2rem;
        }

        .footer p {
            margin: 0.5rem 0;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2rem;
            }
            
            .section-title {
                font-size: 1.75rem;
            }
            
            .navbar {
                flex-direction: column;
                gap: 1rem;
            }
            
            .nav-links {
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .container {
                padding: 3rem 1rem;
            }
            
            .steps {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>

<!-- Navigation with Authentication -->
<nav class="navbar">
    <a href="/" class="logo">CoreDesk</a>
    <ul class="nav-links">
        @auth
            {{-- Logged in: show dashboard link and user name --}}
            <li class="flex items-center">
                <a href="{{ url('/admin/dashboard') }}" class="nav-link">
                    <i class="fa fa-tachometer-alt"></i>
                    <span class="hidden sm:inline">Dashboard</span>
                </a>
            </li>
            <li class="flex items-center">
                <span class="user-name">
                    <i class="fa fa-user"></i>
                    {{ Auth::user()->name }}
                </span>
            </li>
            <li class="flex items-center">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="fa fa-sign-out-alt"></i>
                        <span>Sign Out</span>
                    </button>
                </form>
            </li>
        @else
            {{-- Guest: show Sign In and Sign Up --}}
            <li class="flex items-center">
                <a href="{{ route('login') }}" class="nav-link">
                    <i class="fa fa-sign-in-alt"></i>
                    <span>Sign In</span>
                </a>
            </li>
            <li class="flex items-center">
                <a href="{{ route('register') }}" class="nav-link">
                    <i class="fa fa-user"></i>
                    <span>Sign Up</span>
                </a>
            </li>
        @endauth
    </ul>
</nav>

<!-- Hero Section -->
<section class="hero">
    <h1>Manage Your School, Church, Unions or Organization — All in One Place</h1>
    <p>A simple and powerful platform to manage people, records, finances, and communication — all from one dashboard.</p>
    <div class="hero-buttons">
        @guest
            <a href="{{ route('register') }}" class="btn-primary btn-large">Get Started</a>
            <a href="{{ route('login') }}" class="btn-outline btn-large">Login</a>
        @else
            <a href="{{ url('/admin/dashboard') }}" class="btn-primary btn-large">Go to Dashboard</a>
        @endguest
    </div>
</section>

<!-- Short Intro -->
<div class="container">
    <h2 class="section-title">What is CoreDesk?</h2>
    <p class="section-subtitle">CoreDesk is a modern management platform designed to help schools, churches, and organizations run smoothly without stress.<br>From managing members and staff to tracking records and finances, CoreDesk gives you complete control — anytime, anywhere.</p>
</div>

<!-- Features Section -->
<div class="container">
    <h2 class="section-title">Everything You Need to Run Your Organization</h2>
    <div class="features-grid">
        <div class="feature-card">
            <div class="feature-icon">🏫</div>
            <h3>For Schools</h3>
            <ul>
                <li><i class="fas fa-check-circle"></i> Manage students and teachers</li>
                <li><i class="fas fa-check-circle"></i> Record results and academic performance</li>
                <li><i class="fas fa-check-circle"></i> Track attendance and classes</li>
                <li><i class="fas fa-check-circle"></i> Handle fees and payments</li>
            </ul>
        </div>
        <div class="feature-card">
            <div class="feature-icon">⛪</div>
            <h3>For Churches</h3>
            <ul>
                <li><i class="fas fa-check-circle"></i> Manage members and workers</li>
                <li><i class="fas fa-check-circle"></i> Track attendance and contributions</li>
                <li><i class="fas fa-check-circle"></i> Send announcements and updates</li>
                <li><i class="fas fa-check-circle"></i> Organize departments and activities</li>
            </ul>
        </div>
        <div class="feature-card">
            <div class="feature-icon">🏢</div>
            <h3>For Organizations / Unions</h3>
            <ul>
                <li><i class="fas fa-check-circle"></i> Manage members and roles</li>
                <li><i class="fas fa-check-circle"></i> Track contributions and dues</li>
                <li><i class="fas fa-check-circle"></i> Send notifications and updates</li>
                <li><i class="fas fa-check-circle"></i> Keep structured records</li>
            </ul>
        </div>
    </div>
</div>

<!-- Why Choose Us -->
<section class="why-section">
    <div class="container">
        <h2 class="section-title">Why Choose CoreDesk?</h2>
        <div class="benefits-grid">
            <div class="benefit-item">
                <div class="benefit-icon">✅</div>
                <h4>Easy to Use</h4>
                <p>No technical knowledge required</p>
            </div>
            <div class="benefit-item">
                <div class="benefit-icon">🔒</div>
                <h4>Secure</h4>
                <p>Your data is safe and protected</p>
            </div>
            <div class="benefit-item">
                <div class="benefit-icon">👥</div>
                <h4>Multi-Access</h4>
                <p>Admins, staff, and members have controlled access</p>
            </div>
            <div class="benefit-item">
                <div class="benefit-icon">☁️</div>
                <h4>Cloud-Based</h4>
                <p>Access from anywhere</p>
            </div>
            <div class="benefit-item">
                <div class="benefit-icon">📈</div>
                <h4>Scalable</h4>
                <p>Works for small and large organizations</p>
            </div>
        </div>
    </div>
</section>

<!-- How It Works -->
<div class="container">
    <h2 class="section-title">Get Started in 3 Simple Steps</h2>
    <div class="steps">
        <div class="step">
            <div class="step-number">1</div>
            <h3>Create your organization account</h3>
        </div>
        <div class="step">
            <div class="step-number">2</div>
            <h3>Set up your dashboard (school, church, or union)</h3>
        </div>
        <div class="step">
            <div class="step-number">3</div>
            <h3>Start managing everything in one place</h3>
        </div>
    </div>
</div>

<!-- User Roles -->
<div class="container">
    <h2 class="section-title">Built for Every Role</h2>
    <div class="roles-grid">
        <div class="role-card">
            <i class="fas fa-crown"></i>
            <h4>Super Admin</h4>
            <p>Full control</p>
        </div>
        <div class="role-card">
            <i class="fas fa-user-tie"></i>
            <h4>Admin</h4>
            <p>Manage operations</p>
        </div>
        <div class="role-card">
            <i class="fas fa-chalkboard-user"></i>
            <h4>Staff / Teachers</h4>
            <p>Manage assigned duties</p>
        </div>
        <div class="role-card">
            <i class="fas fa-user-graduate"></i>
            <h4>Members / Students</h4>
            <p>View records and updates</p>
        </div>
    </div>
</div>

<!-- Dashboard Preview -->
<section class="dashboard-preview">
    <div class="container">
        <h2 class="section-title">A Dashboard That Gives You Full Control</h2>
        <p class="section-subtitle" style="color: #cbd5e1;">Monitor activities, track performance, manage users, and make decisions — all from one powerful dashboard.</p>
    </div>
</section>

<!-- Trust Section -->
<section class="trust-section">
    <div class="container">
        <h2 class="section-title">Your Data is Safe</h2>
        <p class="section-subtitle">We use secure systems to protect your information and ensure only authorized users have access.</p>
        <div class="trust-badge">
            <i class="fas fa-shield-alt" style="color: #3b82f6;"></i>
            <span>SSL Secure</span>
            <i class="fas fa-lock" style="color: #3b82f6;"></i>
            <span>Encrypted Data</span>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="cta-section">
    <div class="container">
        <h2>Start Managing Smarter Today</h2>
        <p>Create your organization in minutes and experience a better way to manage everything.</p>
        @guest
            <a href="{{ route('register') }}" class="btn-primary btn-large">👉 Create Your Account</a>
        @else
            <a href="{{ url('/admin/dashboard') }}" class="btn-primary btn-large">👉 Go to Dashboard</a>
        @endguest
    </div>
</section>

<!-- Footer -->
<footer class="footer">
    <p>© CoreDesk</p>
    <p>Built for Schools, Churches & Organizations</p>
    <p>📧 support@coredesk.com | 📞 +1 (555) 123-4567</p>
</footer>

</body>
</html>