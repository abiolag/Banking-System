<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oarkard Bank - Secure Banking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #0056b3;
            --secondary-blue: #003d82;
            --accent-gold: #ffc107;
            --light-gray: #f8f9fa;
            --dark-gray: #343a40;
        }
        
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }
        
        .bank-header {
            background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
            color: white;
        }
        
        .account-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }
        
        .account-card:hover {
            transform: translateY(-2px);
        }
        
        .balance-display {
            font-size: 2rem;
            font-weight: bold;
            color: var(--primary-blue);
        }
        
        .quick-action {
            background: var(--light-gray);
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            transition: all 0.3s;
        }
        
        .quick-action:hover {
            background: var(--primary-blue);
            color: white;
            cursor: pointer;
        }
        
        .transaction-item {
            border-left: 4px solid var(--primary-blue);
            padding-left: 15px;
        }
        
        .footer {
            background: var(--dark-gray);
            color: white;
            padding: 40px 0;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bank-header">
        <div class="container">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <i class="fas fa-university me-2"></i>Oarkard Bank
            </a>
            
            <!-- In the navbar section, update the links -->
        <div class="navbar-nav ms-auto">
            @auth
                <span class="navbar-text me-3">
                    Welcome, {{ Auth::user()->name }}
                </span>
                <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                <a class="nav-link" href="{{ route('transfer.create') }}">Transfer</a>
                <a class="nav-link" href="{{ route('transactions') }}">Transactions</a>
                <a class="nav-link" href="{{ route('profile.show') }}">Profile</a>
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
                </form>
                <a class="nav-link" href="{{ route('users.index') }}">Bank Users</a>
            @else
                <a class="nav-link" href="{{ route('login') }}">Login</a>
                <a class="nav-link" href="{{ route('register') }}">Open Account</a>
            @endauth
            <!-- Optional: Add this to the navbar for easy testing -->

        </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>Oarkard Bank</h5>
                    <p>Secure banking for your financial future.</p>
                </div>
                <div class="col-md-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-light">About Us</a></li>
                        <li><a href="#" class="text-light">Contact</a></li>
                        <li><a href="#" class="text-light">Security</a></li>
                        <li><a href="#" class="text-light">Privacy Policy</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Contact</h5>
                    <p>
                        <i class="fas fa-phone me-2"></i>1-800-Oarkard<br>
                        <i class="fas fa-envelope me-2"></i>support@Oarkard.com<br>
                        <i class="fas fa-map-marker-alt me-2"></i>123 Financial District, New York, NY
                    </p>
                </div>
            </div>
            <div class="text-center mt-4">
                <p>&copy; 2025 Oarkard Bank. Member FDIC. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
    {{-- Session timeout warning --}}
<script>
// Show warning 2 minutes before session timeout
setTimeout(function() {
    const warningModal = new bootstrap.Modal(document.getElementById('sessionWarningModal'));
    warningModal.show();
}, 28 * 60 * 1000); // 28 minutes
</script>

<!-- Session Warning Modal -->
<div class="modal fade" id="sessionWarningModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title">Session About to Expire</h5>
            </div>
            <div class="modal-body">
                <p>Your session will expire in 2 minutes due to inactivity.</p>
                <p>Click anywhere to continue your session.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Continue Session</button>
                <a href="{{ route('logout') }}" class="btn btn-secondary">Logout Now</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>