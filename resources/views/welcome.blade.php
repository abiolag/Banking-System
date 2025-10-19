<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oarkard - Modern Digital Banking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-green: #00D54B;
            --dark-green: #00B140;
            --light-green: #E8F5E8;
            --dark-text: #1A1A1A;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            overflow-x: hidden;
        }

        .navbar {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            color: var(--dark-text) !important;
        }

        /* Hero Slider Styles */
        .hero-slider {
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--dark-green) 100%);
            color: white;
            padding: 120px 0 80px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
        }

        .slide {
            display: none;
            animation: fadeIn 0.5s ease-in;
        }

        .slide.active {
            display: flex;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            line-height: 1.1;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .btn-primary {
            background-color: white;
            border-color: white;
            color: var(--dark-green);
            padding: 12px 30px;
            font-weight: 600;
            border-radius: 25px;
        }

        .btn-outline-light {
            border: 2px solid white;
            color: white;
            padding: 12px 30px;
            font-weight: 600;
            border-radius: 25px;
            background: transparent;
        }

        .btn-outline-light:hover {
            background: white;
            color: var(--dark-green);
        }

        .slider-nav {
            position: absolute;
            bottom: 40px;
            left: 0;
            right: 0;
            display: flex;
            justify-content: center;
            gap: 10px;
            z-index: 10;
        }

        .slider-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .slider-dot.active {
            background: white;
            transform: scale(1.2);
        }

        .slider-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 10;
        }

        .slider-arrow:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .slider-arrow.prev {
            left: 20px;
        }

        .slider-arrow.next {
            right: 20px;
        }

        .email-form {
            max-width: 400px;
        }

        .form-control {
            border-radius: 12px;
            padding: 12px 15px;
            border: 2px solid #EAEAEA;
        }

        /* Features Section */
        .features-section {
            padding: 80px 0;
        }

        .feature-card {
            background: white;
            border-radius: 20px;
            padding: 2.5rem;
            text-align: center;
            border: 1px solid #EAEAEA;
            transition: transform 0.3s ease;
            height: 100%;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }

        .feature-card:hover {
            transform: translateY(-5px);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            background: var(--light-green);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
        }

        .feature-icon i {
            font-size: 2rem;
            color: var(--primary-green);
        }

        /* Featured In Section */
        .featured-section {
            background: #f8f9fa;
            padding: 60px 0;
            border-top: 1px solid #EAEAEA;
            border-bottom: 1px solid #EAEAEA;
        }

        .featured-label {
            font-weight: 600;
            color: var(--dark-text);
            margin-bottom: 0;
            white-space: nowrap;
            font-size: 1.1rem;
        }

        .featured-logos {
            display: flex;
            align-items: center;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 40px;
        }

        .featured-logo {
            height: 40px;
            filter: grayscale(100%);
            opacity: 0.7;
            transition: all 0.3s ease;
        }

        .featured-logo:hover {
            filter: grayscale(0%);
            opacity: 1;
        }

        .stat-section {
            background: var(--light-green);
            padding: 80px 0;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 700;
            color: var(--primary-green);
            margin-bottom: 0.5rem;
        }

        .cta-section {
            background: var(--dark-text);
            color: white;
            padding: 80px 0;
        }

        .disclaimer {
            font-size: 0.8rem;
            opacity: 0.8;
            margin-top: 1rem;
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-slider {
                padding: 100px 0 60px;
                text-align: center;
            }

            .slider-arrow {
                display: none;
            }

            .featured-logos {
                gap: 25px;
            }

            .featured-logo {
                height: 30px;
            }

            .features-section {
                padding: 60px 0;
            }
        }

        @media (max-width: 576px) {
            .featured-logos {
                gap: 20px;
            }
            
            .featured-logo {
                height: 25px;
            }
        }
        /* Mobile Responsive Improvements */
        @media (max-width: 768px) {
            /* Navigation improvements */
            .navbar-collapse {
                background: white;
                padding: 1rem;
                border-radius: 12px;
                margin-top: 1rem;
                box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            }
            
            .nav-link {
                padding: 0.75rem 0;
                border-bottom: 1px solid #f0f0f0;
                margin: 0;
            }
            
            .nav-link:last-child {
                border-bottom: none;
            }
            
            /* Main content padding for mobile */
            main {
                padding-top: 70px !important;
            }
            
            /* Button improvements for touch */
            .btn, .nav-link {
                min-height: 44px;
                display: flex;
                align-items: center;
            }
            
            /* Card improvements */
            .card {
                margin-bottom: 1rem;
            }
            
            .card-header {
                padding: 1rem;
            }
            
            /* Balance display */
            .balance-display {
                font-size: 2rem;
            }
            
            /* Quick actions grid */
            .quick-action {
                padding: 1rem;
                margin-bottom: 1rem;
            }
        }

        @media (max-width: 576px) {
            /* Hero section improvements */
            .hero-title {
                font-size: 2rem !important;
            }
            
            .hero-subtitle {
                font-size: 1.1rem;
            }
            
            /* Button stacking */
            .hero-buttons .btn {
                display: block;
                width: 100%;
                margin-bottom: 1rem;
            }
            
            .hero-buttons .btn:last-child {
                margin-bottom: 0;
            }
            
            /* Feature cards */
            .feature-card {
                padding: 1.5rem;
                margin-bottom: 1rem;
            }
            
            /* Form improvements */
            .form-control {
                font-size: 16px; /* Prevents zoom on iOS */
            }
            
            /* Table responsiveness */
            .table-responsive {
                font-size: 14px;
            }
        }

        /* Touch-friendly improvements */
        @media (hover: none) and (pointer: coarse) {
            .nav-link:hover {
                background-color: var(--light-green);
            }
            
            .btn:hover {
                transform: none;
            }
            
            .quick-action:hover {
                transform: none;
            }
        }

        /* Ensure proper tap targets */
        .nav-link, .btn {
            min-height: 44px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body>
    
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#">
            <strong>OARKARD</strong>
        </a>

        <!-- Mobile toggle button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Collapsible menu -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <div class="navbar-nav ms-auto">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-primary">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="nav-link me-3">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-primary mt-2 mt-lg-0">Open Account</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

    <!-- Hero Slider -->
    <section class="hero-slider">
        <div class="container position-relative">
            <!-- Slide 1: Cash Back & Credit -->
            <div class="slide active">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <h1 class="hero-title">
                            Get cash back.<sup></sup><br>
                            Build credit.<sup></sup><br>
                            Everyday.
                        </h1>
                        <p class="hero-subtitle">Introducing <strong>Oarkard Card.</strong><sup>™</sup></p>
                        

                        <div class="disclaimer">
                            <p>Oarkard is a financial technology company.</p>
                            <p>Learn how we collect and use your information by visiting our <a href="#" class="text-white text-decoration-underline">Privacy Notice ›</a></p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="text-center">
                            <img src="https://www.telegraph.co.uk/content/dam/personal-banking/2023/08/01/TELEMMGLPICT000344583025_16909109249080_trans_NvBQzQNjv4BqqVzuuqpFlyLIwiB6NTmJwfSVWeZ_vEN7c6bHu2jJnT8.jpeg?imwidth=1280" 
                                 alt="Oarkard Banking App" class="img-fluid rounded-3 shadow-lg">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 2: Fee-Free Banking -->
            <div class="slide">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <h1 class="hero-title">
                            Everyday, fee-<br>
                            free banking.
                        </h1>
                        <p class="hero-subtitle">
                            Open a Oarkard Checking Account for more ways to deposit and access your money without fees.
                        </p>
                        
                        <div class="hero-buttons">
                            <a href="{{ route('register') }}" class="btn btn-primary btn-lg me-3">Open Account</a>
                            <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg">Sign In</a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="text-center">
                        <img src="https://assets.huntingtonbank.com/api/public/content/1b678bde-woman-hiking.jpg?v=2d3535ee&t=HorizontalBanner1080x608" 
                            alt="Fee-Free Banking" class="img-fluid rounded-3 shadow-lg">
                    </div>
                    </div>
                </div>
            </div>

            <!-- Slide 3: MyPay -->
            <div class="slide">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <h1 class="hero-title">
                            Get up to $500<br>
                            of your pay with<br>
                            MyPay.<sup></sup>
                        </h1>
                        
                        <div class="hero-buttons">
                            <a href="{{ route('register') }}" class="btn btn-primary btn-lg me-3">Get Started</a>
                            <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg">Learn More</a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="text-center">
                            <img src="https://www.telegraph.co.uk/content/dam/personal-banking/2023/08/01/TELEMMGLPICT000344583025_16909109249080_trans_NvBQzQNjv4BqqVzuuqpFlyLIwiB6NTmJwfSVWeZ_vEN7c6bHu2jJnT8.jpeg?imwidth=1280" 
                                 alt="Oarkard Banking App" class="img-fluid rounded-3 shadow-lg">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 4: Offshore Banking -->
            <div class="slide">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <h1 class="hero-title">
                            Global Banking.<br>
                            Local Trust.
                        </h1>
                        <p class="hero-subtitle">
                            Access offshore banking with expert guidance. Diversify your assets internationally with Oarkard's secure global platform.
                        </p>
                        
                        <div class="hero-features mb-4">
                            <div class="row">
                                <div class="col-6">
                                    <div class="text-start">
                                        <i class="fas fa-globe me-2"></i>
                                        <span>Global Access</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-start">
                                        <i class="fas fa-shield-alt me-2"></i>
                                        <span>Secure</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-start">
                                        <i class="fas fa-chart-line me-2"></i>
                                        <span>Wealth Growth</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-start">
                                        <i class="fas fa-user-tie me-2"></i>
                                        <span>Expert Advice</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="hero-buttons">
                            <a href="{{ route('register') }}" class="btn btn-primary btn-lg me-3">Start Banking Globally</a>
                            <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg">Consult Expert</a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="text-center">
                            <img src="https://zagranportal.ru/wp-content/uploads/2018/05/schet-v-offshore.jpg" 
                                 alt="Global Offshore Banking" class="img-fluid rounded-3 shadow-lg">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slider Navigation -->
        <button class="slider-arrow prev" onclick="changeSlide(-1)">
        <i class="fas fa-chevron-left"></i>
        </button>
        <button class="slider-arrow next" onclick="changeSlide(1)">
            <i class="fas fa-chevron-right"></i>
        </button>

        <div class="slider-nav">
            <button class="slider-dot active" onclick="goToSlide(1)"></button>
            <button class="slider-dot" onclick="goToSlide(2)"></button>
            <button class="slider-dot" onclick="goToSlide(3)"></button>
            <button class="slider-dot" onclick="goToSlide(4)"></button>
        </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section bg-white">
        <div class="container">
            <div class="text-center mb-5">
                <h2>Why Choose Oarkard?</h2>
                <p class="lead text-muted">Experience the future of banking with our innovative features</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <h4>Instant Transfers</h4>
                        <p class="text-muted">Send and receive money instantly with zero waiting time. Real-time transfers 24/7.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-globe"></i>
                        </div>
                        <h4>Offshore Banking</h4>
                        <p class="text-muted">Secure global banking with international asset protection and wealth diversification.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <h4>Mobile Banking</h4>
                        <p class="text-muted">Bank on the go with our intuitive mobile app designed for modern lifestyles.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <h4>Expert Advice</h4>
                        <p class="text-muted">Personalized financial guidance from certified experts to help you make smart decisions.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h4>Wealth Building</h4>
                        <p class="text-muted">Long-term investment strategies and wealth management for financial independence.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured In Section (Moved below features) -->
    <section class="featured-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-2">
                    <p class="featured-label">Featured in:</p>
                </div>
                <div class="col-md-10">
                    <div class="featured-logos">
                        <img src="https://logodownload.org/wp-content/uploads/2017/04/forbes-logo-0.png" alt="Forbes" class="featured-logo" style="height: 25px;">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/66/CNN_International_logo.svg/2560px-CNN_International_logo.svg.png" alt="CNN" class="featured-logo" style="height: 25px;">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/77/The_New_York_Times_logo.png/800px-The_New_York_Times_logo.png" alt="New York Times" class="featured-logo" style="height: 25px;">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/62/BBC_News_2019.svg/1200px-BBC_News_2019.svg.png" alt="BBC" class="featured-logo" style="height: 25px;">
                        <img src="https://media.istockphoto.com/id/1472482441/vector/ecb-european-central-bank-symbol.jpg?s=1024x1024&w=is&k=20&c=4IxxVTt40Z3K3QYj8rXn4C03gkjqZkJvPETLX8d1MfE=" alt="European Central Bank" class="featured-logo" style="height: 30px;">
                        <img src="https://dealbreaker.com/.image/ar_215:100%2Cc_fill%2Ccs_srgb%2Cg_faces:center%2Cq_auto:good%2Cw_2560/MTYxMjc3MjA4NzE4MzUzOTA5/cftc.webp" alt="CFTC" class="featured-logo" style="height: 35px;">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stat-section">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-3">
                    <div class="stat-number">50K+</div>
                    <div class="text-muted">Happy Customers</div>
                </div>
                <div class="col-md-3">
                    <div class="stat-number">$1B+</div>
                    <div class="text-muted">Transactions</div>
                </div>
                <div class="col-md-3">
                    <div class="stat-number">24/7</div>
                    <div class="text-muted">Customer Support</div>
                </div>
                <div class="col-md-3">
                    <div class="stat-number">99.9%</div>
                    <div class="text-muted">Uptime</div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container text-center">
            <h2 class="mb-4">Ready to Start Your Banking Journey?</h2>
            <p class="lead mb-4">Join thousands of satisfied customers who trust Oarkard with their finances.</p>
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
            <p>&copy; 2025 Oarkard. All rights reserved. Member FDIC.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    let slideIndex = 0;
    const slides = document.querySelectorAll('.slide');
    const dots = document.querySelectorAll('.slider-dot');

    function showSlide(n) {
        // Hide all slides
        slides.forEach(slide => slide.classList.remove('active'));
        dots.forEach(dot => dot.classList.remove('active'));
        
        // Calculate new slide index
        slideIndex = (n + slides.length) % slides.length;
        
        // Show the current slide
        slides[slideIndex].classList.add('active');
        dots[slideIndex].classList.add('active');
    }

    function changeSlide(n) {
        showSlide(slideIndex + n);
    }

    function goToSlide(n) {
        showSlide(n - 1);
    }

    // Auto-advance slides every 5 seconds
    let slideInterval = setInterval(() => {
        changeSlide(1);
    }, 5000);

    // Pause auto-advance when user interacts with slider
    const sliderContainer = document.querySelector('.hero-slider');
    sliderContainer.addEventListener('mouseenter', () => {
        clearInterval(slideInterval);
    });

    sliderContainer.addEventListener('mouseleave', () => {
        slideInterval = setInterval(() => {
            changeSlide(1);
        }, 5000);
    });

    // Initialize first slide
    showSlide(0);
</script>
</body>
</html>