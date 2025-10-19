@extends('layouts.app')

@section('title', 'Register - Oarkard Bank')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-user-plus me-2"></i>Create Your Banking Account</h4>
                </div>

                <div class="card-body">
                    <!-- Google OAuth Section -->
                    <div class="text-center mb-4">
                        <a href="{{ route('google.login') }}" class="btn btn-outline-danger btn-lg w-100">
                            <i class="fab fa-google me-2"></i> Sign up with Google
                        </a>
                    </div>

                    <div class="text-center my-4 position-relative">
                        <hr>
                        <span class="px-3 bg-white text-muted position-absolute top-50 start-50 
translate-middle">
                            Or complete the form below
                        </span>
                    </div>

                    <!-- Display All Errors -->
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <h6 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i>Please fix 
the following errors:</h6>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Registration Form -->
                    <form method="POST" action="{{ route('register') }}" id="registrationForm">
                        @csrf

                        <!-- Personal Information Section -->
                        <h5 class="border-bottom pb-2 mb-3"><i class="fas fa-user me-2"></i>Personal 
Information</h5>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Full Name *</label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid 
@enderror"
                                       name="name" value="{{ old('name') }}" required autofocus
                                       placeholder="John Doe">
                                @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Address *</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid 
@enderror"
                                       name="email" value="{{ old('email') }}" required
                                       placeholder="john@example.com">
                                @error('email')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone Number *</label>
                                <input id="phone" type="tel" class="form-control @error('phone') is-invalid 
@enderror"
                                       name="phone" value="{{ old('phone') }}" required
                                       placeholder="+1 (555) 123-4567">
                                @error('phone')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="date_of_birth" class="form-label">Date of Birth *</label>
                                <input id="date_of_birth" type="date" class="form-control 
@error('date_of_birth') is-invalid @enderror"
                                       name="date_of_birth" value="{{ old('date_of_birth') }}" required
                                       max="{{ date('Y-m-d', strtotime('-18 years')) }}">
                                @error('date_of_birth')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Address Section -->
                        <h5 class="border-bottom pb-2 mb-3 mt-4"><i class="fas fa-map-marker-alt 
me-2"></i>Address Information</h5>

                        <div class="mb-3">
                            <label for="address" class="form-label">Street Address *</label>
                            <input id="address" type="text" class="form-control @error('address') is-invalid 
@enderror"
                                   name="address" value="{{ old('address') }}" required
                                   placeholder="123 Main Street, Apt 4B">
                            @error('address')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="city" class="form-label">City *</label>
                                <input id="city" type="text" class="form-control @error('city') is-invalid 
@enderror"
                                       name="city" value="{{ old('city') }}" required
                                       placeholder="New York">
                                @error('city')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="state" class="form-label">State *</label>
                                <input id="state" type="text" class="form-control @error('state') is-invalid 
@enderror"
                                       name="state" value="{{ old('state') }}" required
                                       placeholder="NY">
                                @error('state')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="zip_code" class="form-label">ZIP Code *</label>
                                <input id="zip_code" type="text" class="form-control @error('zip_code') 
is-invalid @enderror"
                                       name="zip_code" value="{{ old('zip_code') }}" required
                                       placeholder="10001">
                                @error('zip_code')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Account Type Section -->
                        <h5 class="border-bottom pb-2 mb-3 mt-4"><i class="fas fa-university me-2"></i>Account 
Type</h5>

                        <div class="mb-3">
                            <label class="form-label">Select Account Type *</label>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-check card p-3 h-100 {{ old('account_type') == 'checking' ? 
'border-primary' : '' }}">
                                        <input class="form-check-input" type="radio" name="account_type"
                                               id="checking" value="checking" {{ old('account_type', 'checking') 
== 'checking' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="checking">
                                            <strong><i class="fas fa-check-circle me-1"></i>Checking</strong>
                                            <small class="d-block text-muted">For everyday transactions</small>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check card p-3 h-100 {{ old('account_type') == 'savings' ? 
'border-primary' : '' }}">
                                        <input class="form-check-input" type="radio" name="account_type"
                                               id="savings" value="savings" {{ old('account_type') == 'savings' 
? 'checked' : '' }}>
                                        <label class="form-check-label" for="savings">
                                            <strong><i class="fas fa-piggy-bank me-1"></i>Savings</strong>
                                            <small class="d-block text-muted">Earn interest on deposits</small>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check card p-3 h-100 {{ old('account_type') == 'business' ? 
'border-primary' : '' }}">
                                        <input class="form-check-input" type="radio" name="account_type"
                                               id="business" value="business" {{ old('account_type') == 
'business' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="business">
                                            <strong><i class="fas fa-briefcase me-1"></i>Business</strong>
                                            <small class="d-block text-muted">For business needs</small>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            @error('account_type')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Security Section -->
                        <h5 class="border-bottom pb-2 mb-3 mt-4"><i class="fas fa-lock me-2"></i>Security</h5>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Password *</label>
                                <div class="input-group">
                                    <input id="password" type="password" class="form-control @error('password') 
is-invalid @enderror"
                                           name="password" required minlength="8"
                                           placeholder="Minimum 8 characters">
                                    <button type="button" class="btn btn-outline-secondary" 
onclick="togglePassword('password')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    @error('password')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <small class="text-muted">Must be at least 8 characters</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password *</label>
                                <div class="input-group">
                                    <input id="password_confirmation" type="password" class="form-control"
                                           name="password_confirmation" required minlength="8"
                                           placeholder="Re-enter password">
                                    <button type="button" class="btn btn-outline-secondary" 
onclick="togglePassword('password_confirmation')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Terms and Submit -->
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="terms" required>
                            <label class="form-check-label" for="terms">
                                I agree to the <a href="#" target="_blank">Terms of Service</a> and <a href="#" 
target="_blank">Privacy Policy</a> *
                            </label>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-user-plus me-2"></i>Create Account
                            </button>
                        </div>

                        <div class="text-center mt-3">
                            <p class="mb-0">Already have an account?
                                <a href="{{ route('login') }}" class="text-decoration-none fw-bold">Sign in 
here</a>
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
    const toggleButton = passwordInput.parentElement.querySelector('button');
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

// Form validation feedback
document.getElementById('registrationForm').addEventListener('submit', function(e) {
    const password = document.getElementById('password').value;
    const passwordConfirmation = document.getElementById('password_confirmation').value;

    if (password !== passwordConfirmation) {
        e.preventDefault();
        alert('Passwords do not match!');
        return false;
    }

    if (password.length < 8) {
        e.preventDefault();
        alert('Password must be at least 8 characters long!');
        return false;
    }
});
</script>

<style>
.form-check.card {
    cursor: pointer;
    transition: all 0.3s ease;
}

.form-check.card:hover {
    border-color: #0d6efd !important;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}

.form-check.card input:checked ~ label {
    color: #0d6efd;
}

.input-group .btn-outline-secondary {
    border-left: 0;
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
