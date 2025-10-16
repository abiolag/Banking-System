<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Oarkard - Modern Banking')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-green: #00D54B;
            --dark-green: #00B140;
            --light-green: #E8F5E8;
            --dark-text: #1A1A1A;
            --light-gray: #F8F9FA;
            --medium-gray: #6C757D;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #FFFFFF;
            color: var(--dark-text);
        }
        
        .navbar {
            background: #FFFFFF !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 1rem 0;
        }
        
        .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            color: var(--dark-text) !important;
        }
        
        .nav-link {
            color: var(--dark-text) !important;
            font-weight: 500;
            margin: 0 0.5rem;
        }
        
        .nav-link:hover {
            color: var(--primary-green) !important;
        }
        
        .btn-primary {
            background-color: var(--primary-green);
            border-color: var(--primary-green);
            font-weight: 600;
            padding: 0.5rem 1.5rem;
        }
        
        .btn-primary:hover {
            background-color: var(--dark-green);
            border-color: var(--dark-green);
        }
        
        .btn-outline-primary {
            color: var(--primary-green);
            border-color: var(--primary-green);
            font-weight: 600;
        }
        
        .btn-outline-primary:hover {
            background-color: var(--primary-green);
            color: white;
        }
        
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            margin-bottom: 1.5rem;
        }
        
        .card-header {
            background: white;
            border-bottom: 1px solid #EAEAEA;
            border-radius: 16px 16px 0 0 !important;
            padding: 1.5rem;
            font-weight: 600;
        }
        
        .balance-display {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--dark-text);
        }
        
        .quick-action {
            background: var(--light-gray);
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            text-decoration: none;
            color: var(--dark-text);
            display: block;
        }
        
        .quick-action:hover {
            background: var(--primary-green);
            color: white;
            transform: translateY(-2px);
            border-color: var(--primary-green);
            text-decoration: none;
        }
        
        .feature-card {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            height: 100%;
            border: 1px solid #EAEAEA;
        }
        
        .progress {
            height: 8px;
            border-radius: 10px;
        }
        
        .progress-bar {
            background-color: var(--primary-green);
            border-radius: 10px;
        }
        
        .footer {
            background: var(--dark-text);
            color: white;
            padding: 3rem 0 2rem;
            margin-top: 4rem;
        }
        
        .hero-section {
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--dark-green) 100%);
            color: white;
            padding: 6rem 0;
        }
        
        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }
        
        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            text-align: center;
            border: 1px solid #EAEAEA;
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-green);
            margin-bottom: 0.5rem;
        }
        
        .transaction-item {
            border-bottom: 1px solid #EAEAEA;
            padding: 1rem 0;
        }
        
        .transaction-item:last-child {
            border-bottom: none;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <strong>OARKARD</strong>
            </a>
            
            <div class="navbar-nav ms-auto">
                @auth
                    <span class="navbar-text me-3">
                        Welcome, {{ Auth::user()->name }}
                    </span>
                    <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                    <a class="nav-link" href="{{ route('transfer.create') }}">Transfer</a>
                    <a class="nav-link" href="{{ route('transactions') }}">Transactions</a>
                    <a class="nav-link" href="{{ route('profile.show') }}">Profile</a>
                    <a class="nav-link" href="{{ route('users.index') }}">Bank Users</a>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-primary btn-sm ms-2">Logout</button>
                    </form>
                @else
                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                    <a class="btn btn-primary" href="{{ route('register') }}">Open Account</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main style="padding-top: 80px;">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5 class="mb-3"><strong>OARKARD</strong></h5>
                    <p>Modern banking for the digital age. Secure, fast, and transparent.</p>
                </div>
                <div class="col-md-4">
                    <h5 class="mb-3">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-light text-decoration-none">About Us</a></li>
                        <li><a href="#" class="text-light text-decoration-none">Contact</a></li>
                        <li><a href="#" class="text-light text-decoration-none">Security</a></li>
                        <li><a href="#" class="text-light text-decoration-none">Privacy Policy</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5 class="mb-3">Contact</h5>
                    <p>
                        <i class="fas fa-phone me-2"></i>1-800-OARKARD<br>
                        <i class="fas fa-envelope me-2"></i>support@oarkard.com<br>
                        <i class="fas fa-map-marker-alt me-2"></i>123 Financial District
                    </p>
                </div>
            </div>
            <div class="text-center mt-4 pt-3 border-top border-secondary">
                <p>&copy; 2025 Oarkard Bank. Member FDIC. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>