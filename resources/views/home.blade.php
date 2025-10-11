@extends('layouts.home')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center min-vh-100">
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
                        <div class="feature-item">
                            <i class="fas fa-shield-alt text-primary me-2"></i>
                            <span>Bank-level Security</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-bolt text-primary me-2"></i>
                            <span>Instant Transfers</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-globe text-primary me-2"></i>
                            <span>Global Access</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hero-image">
                        <img src="https://images.unsplash.com/photo-1554224155-6726b3ff858f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" 
                             alt="Modern Banking App" class="img-fluid rounded-3 shadow">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2>Why Choose Arkard?</h2>
                <p class="lead">Experience the future of banking with our innovative features</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card text-center p-4">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-mobile-alt fa-3x text-primary"></i>
                        </div>
                        <h4>Mobile First</h4>
                        <p>Bank on the go with our intuitive mobile app designed for modern lifestyles.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card text-center p-4">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-lock fa-3x text-primary"></i>
                        </div>
                        <h4>Secure & Safe</h4>
                        <p>Your money is protected with enterprise-grade security and encryption.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card text-center p-4">
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

    <!-- Stats Section -->
    <section class="stats-section py-5">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-3">
                    <h3 class="text-primary">50K+</h3>
                    <p>Happy Customers</p>
                </div>
                <div class="col-md-3">
                    <h3 class="text-primary">$1B+</h3>
                    <p>Transactions Processed</p>
                </div>
                <div class="col-md-3">
                    <h3 class="text-primary">24/7</h3>
                    <p>Customer Support</p>
                </div>
                <div class="col-md-3">
                    <h3 class="text-primary">99.9%</h3>
                    <p>Uptime Guarantee</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section py-5 bg-primary text-white">
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
@endsection