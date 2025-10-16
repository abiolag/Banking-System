<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arkard - Modern Digital Banking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
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

    <!-- Main Content -->
    @yield('content')

    <!-- Footer -->
    <footer class="footer bg-dark text-white py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5><i class="fas fa-university me-2"></i>ARKARD</h5>
                    <p>Modern banking for the digital generation. Secure, fast, and transparent.</p>
                </div>
                <div class="col-md-2">
                    <h6>Products</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-light">Personal</a></li>
                        <li><a href="#" class="text-light">Business</a></li>
                        <li><a href="#" class="text-light">Savings</a></li>
                    </ul>
                </div>
                <div class="col-md-2">
                    <h6>Company</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-light">About</a></li>
                        <li><a href="#" class="text-light">Careers</a></li>
                        <li><a href="#" class="text-light">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-2">
                    <h6>Support</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-light">Help Center</a></li>
                        <li><a href="#" class="text-light">Security</a></li>
                        <li><a href="#" class="text-light">Privacy</a></li>
                    </ul>
                </div>
                <div class="col-md-2">
                    <h6>Follow Us</h6>
                    <div class="social-links">
                        <a href="#" class="text-light me-3"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-light me-3"><i class="fab fa-linkedin"></i></a>
                        <a href="#" class="text-light me-3"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <hr class="my-4">
            <div class="row">
                <div class="col-md-6">
                    <p>&copy; 2024 Arkard. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="#" class="text-light me-3">Terms</a>
                    <a href="#" class="text-light me-3">Privacy</a>
                    <a href="#" class="text-light">Cookies</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>