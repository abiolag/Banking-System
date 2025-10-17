@extends('layouts.app')

@section('title', 'Register - Oarkard Bank')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Create Your Account</h4>
                </div>

                <div class="card-body">
                    <!-- Google OAuth Section - MOVED TO TOP -->
                    <div class="text-center mb-4">
                        <a href="{{ route('google.login') }}" class="btn btn-google btn-lg w-100">
                            <i class="fab fa-google me-2"></i> Sign up with Google
                        </a>
                    </div>

                    <div class="text-center my-4">
                        <div class="border-bottom"></div>
                        <span class="px-3 bg-white text-muted">Or sign up with email</span>
                    </div>

                    <!-- Regular Registration Form -->
                    <form method="POST" action="{{ route('register') }}">
    @csrf
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                                   name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                                   placeholder="Enter your full name">

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                   name="email" value="{{ old('email') }}" required autocomplete="email"
                                   placeholder="Enter your email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                                       name="password" required autocomplete="new-password"
                                       placeholder="Create a password">
                                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password')">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password-confirm" class="form-label">Confirm Password</label>
                            <div class="input-group">
                                <input id="password-confirm" type="password" class="form-control" 
                                       name="password_confirmation" required autocomplete="new-password"
                                       placeholder="Confirm your password">
                                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password-confirm')">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                Create Account
                            </button>
                        </div>

                        <div class="text-center mt-3">
                            <p class="mb-0">Already have an account? 
                                <a href="{{ route('login') }}" class="text-decoration-none">Sign in here</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword(inputId) {
    const passwordInput = document.getElementById(inputId);
    const toggleButton = passwordInput.parentNode.querySelector('button');
    const icon = toggleButton.querySelector('i');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>

<style>
.input-group .btn-outline-secondary {
    border-left: 0;
    border-color: #ced4da;
    transition: all 0.15s ease-in-out;
}

.input-group .btn-outline-secondary:hover {
    background-color: #e9ecef;
    border-color: #ced4da;
}

.input-group .form-control:focus {
    box-shadow: none;
    border-color: #86b7fe;
}

.input-group:focus-within .btn-outline-secondary {
    border-color: #86b7fe;
}
</style>
@endsection