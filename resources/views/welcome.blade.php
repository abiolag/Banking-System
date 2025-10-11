<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arkard - Modern Digital Banking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #0066cc;
            --dark-blue: #004499;
            --light-blue: #e6f2ff;
        }

        .navbar {
            background: rgba(0, 102, 204, 0.95);
            backdrop-filter: blur(10px);
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .hero-section {
            background: linear-gradient(135deg, var(--light-blue) 0%, #ffffff 100%);
            padding-top: 100px;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            color: #666;
            margin-bottom: 2rem;
        }

        .btn-primary {
            background-color: var(--primary-blue);
            border-color: var(--primary-blue);
            padding: 12px 30px;
            font-weight: 600;
        }

        .btn-primary:hover {
            background-color: var(--dark-blue);
            border-color: var(--dark-blue);
        }

        .feature-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            height: 100%;
            padding: 2rem;
        }

        .feature-card:hover {
            transform: translateY(-5px);
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-university me-2"></i>
                <strong>ARKARD</strong>
            </a>
            
                    <div class="navbar-nav ms-auto">
            @auth
                <a href="{{ url('/dashboard') }}" class="nav-link">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-light">Login</a>
                <a href="{{ route('register') }}" class="btn btn-outline-light ms-2">Open Account</a>
            @endauth
        </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="hero-title">Banking Made <span class="text-primary">Simple</span></h1>
                    <p class="hero-subtitle">Arkard brings you modern digital banking with security, speed, and transparency. Manage your money effortlessly from anywhere.</p>
                    <div class="hero-buttons">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn btn-primary btn-lg me-3">Go to Dashboard</a>
                        @else
                            <a href="{{ route('register') }}" class="btn btn-primary btn-lg me-3">Open Account</a>
                            <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg">Learn More</a>
                        @endauth
                    </div>
                    <div class="hero-features mt-4">
                        <div class="feature-item d-inline-block me-4">
                            <i class="fas fa-shield-alt text-primary me-2"></i>
                            <span>Bank-level Security</span>
                        </div>
                        <div class="feature-item d-inline-block me-4">
                            <i class="fas fa-bolt text-primary me-2"></i>
                            <span>Instant Transfers</span>
                        </div>
                        <div class="feature-item d-inline-block">
                            <i class="fas fa-globe text-primary me-2"></i>
                            <span>Global Access</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hero-image">
                        <img src="https://images.unsplash.com/photo-1554224155-6726b3ff858f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" 
                             alt="Modern Banking App" class="img-fluid rounded-3 shadow">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2>Why Choose Arkard?</h2>
                <p class="lead">Experience the future of banking with our innovative features</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card text-center">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-mobile-alt fa-3x text-primary"></i>
                        </div>
                        <h4>Mobile First</h4>
                        <p>Bank on the go with our intuitive mobile app designed for modern lifestyles.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card text-center">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-lock fa-3x text-primary"></i>
                        </div>
                        <h4>Secure & Safe</h4>
                        <p>Your money is protected with enterprise-grade security and encryption.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card text-center">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-piggy-bank fa-3x text-primary"></i>
                        </div>
                        <h4>Smart Savings</h4>
                        <p>Automated savings features help you grow your wealth effortlessly.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5 bg-primary text-white">
        <div class="container text-center">
            <h2>Ready to Start Your Banking Journey?</h2>
            <p class="lead mb-4">Join thousands of satisfied customers who trust Arkard with their finances.</p>
            @auth
                <a href="{{ url('/dashboard') }}" class="btn btn-light btn-lg">Go to Dashboard</a>
            @else
                <a href="{{ route('register') }}" class="btn btn-light btn-lg me-3">Get Started</a>
                <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg">Sign In</a>
            @endauth
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container text-center">
            <p>&copy; 2024 Arkard. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>