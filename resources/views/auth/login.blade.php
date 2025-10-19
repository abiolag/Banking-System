@extends('layouts.app')

@section('title', 'Login - Oarkard Bank')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Sign In to Your Account</h4>
                </div>

                <div class="card-body">
                    <!-- Google OAuth Section - MOVED TO TOP -->
                    <div class="text-center mb-4">
                        <a href="{{ route('google.login') }}" class="btn btn-google btn-lg w-100">
                            <i class="fab fa-google me-2"></i> Continue with Google
                        </a>
                    </div>

                    <div class="text-center my-4">
                        <div class="border-bottom"></div>
                        <span class="px-3 bg-white text-muted">Or sign in with email</span>
                    </div>

                    <!-- Regular Login Form -->
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                   name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                   placeholder="Enter your email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="position-relative">
                                <input id="password" type="password" 
                                    class="form-control password-field @error('password') is-invalid @enderror"
                                    name="password" 
                                    required 
                                    autocomplete="current-password"
                                    placeholder="Enter your password">
                                
                                <!-- Mobile-friendly toggle button -->
                                <button type="button" 
                                        class="btn password-toggle-btn"
                                        onclick="togglePasswordVisibility('password')">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                Remember Me
                            </label>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                Sign In
                            </button>
                        </div>

                        <div class="text-center mt-3">
                            @if (Route::has('password.request'))
                                <a class="text-decoration-none" href="{{ route('password.request') }}">
                                    Forgot Your Password?
                                </a>
                            @endif
                        </div>
                    </form>

                    <div class="text-center mt-4">
                        <p class="mb-0">Don't have an account? 
                            <a href="{{ route('register') }}" class="text-decoration-none">Sign up here</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function togglePasswordVisibility(inputId) {
    const passwordInput = document.getElementById(inputId);
    const toggleButton = document.querySelector(`[onclick="togglePasswordVisibility('${inputId}')"]`);
    const icon = toggleButton.querySelector('i');
    
    // Toggle password visibility
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
        toggleButton.setAttribute('aria-label', 'Hide password');
    } else {
        passwordInput.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
        toggleButton.setAttribute('aria-label', 'Show password');
    }
    
    // Ensure input stays focused (important for mobile)
    setTimeout(() => {
        passwordInput.focus();
    }, 10);
}

// Add touch event listeners for better mobile support
document.addEventListener('DOMContentLoaded', function() {
    const passwordToggle = document.querySelector('.password-toggle-btn');
    if (passwordToggle) {
        // Prevent any default touch behaviors that might interfere
        passwordToggle.addEventListener('touchstart', function(e) {
            e.preventDefault();
        }, { passive: false });
        
        passwordToggle.addEventListener('touchend', function(e) {
            e.preventDefault();
            const passwordInput = document.getElementById('password');
            togglePasswordVisibility('password');
        }, { passive: false });
    }
});
</script>

<style>
/* Password toggle mobile optimization */
.password-toggle-btn {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    background: transparent;
    border: none;
    color: #6c757d;
    padding: 8px;
    min-height: 44px;
    min-width: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 5;
    border-radius: 6px;
    transition: all 0.15s ease;
}

.password-toggle-btn:hover {
    background-color: rgba(0, 0, 0, 0.05);
    color: #495057;
}

.password-field {
    padding-right: 60px !important;
    font-size: 16px;
    height: 50px;
}

/* Mobile-specific fixes */
@media (max-width: 768px) {
    .password-field {
        font-size: 16px !important;
        height: 50px !important;
        padding: 12px 15px 12px 15px !important;
        -webkit-user-select: text !important;
        user-select: text !important;
        touch-action: manipulation;
    }
    
    .password-toggle-btn {
        right: 8px;
        min-height: 44px;
        min-width: 44px;
        background: rgba(255, 255, 255, 0.9);
        border: 1px solid #dee2e6;
    }
    
    /* iOS Safari specific fixes */
    @supports (-webkit-touch-callout: none) {
        .password-field {
            font-size: 16px !important;
            line-height: 1.4 !important;
        }
        
        .password-toggle-btn {
            -webkit-touch-callout: none;
            -webkit-user-select: none;
        }
    }
}

/* Focus states */
.password-field:focus {
    box-shadow: 0 0 0 0.2rem rgba(0, 213, 75, 0.25);
    border-color: #00D54B;
}

.password-field:focus + .password-toggle-btn {
    border-color: #00D54B;
    color: #00D54B;
}
</style>
@endsection