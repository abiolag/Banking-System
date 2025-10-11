@extends('layouts.app')

@section('title', 'Complete Transfer - Token Required')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-shield-alt me-2"></i>Complete Your Transfer</h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <i class="fas fa-lock fa-3x text-primary mb-3"></i>
                        <h3 class="text-primary">Security Verification Required</h3>
                        <p class="text-muted">To complete your international transfer, please enter the verification token</p>
                    </div>

                    <!-- Token Input Box -->
                    <div class="token-box border rounded p-4 bg-light mb-4">
                        <div class="text-center">
                            <label for="transfer_token" class="form-label fw-bold text-dark mb-3">
                                <i class="fas fa-key me-2"></i>Please input the transfer Token to complete this transfer
                            </label>
                            <div class="row justify-content-center">
                                <div class="col-md-8">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text bg-white border-end-0">
                                            <i class="fas fa-lock text-muted"></i>
                                        </span>
                                        <input type="text" 
                                               class="form-control border-start-0 text-center fw-bold fs-5" 
                                               id="transfer_token" 
                                               placeholder="Enter 6-digit token"
                                               maxlength="6"
                                               style="letter-spacing: 2px;">
                                    </div>
                                    <div class="mt-2">
                                        <small class="text-muted">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Check your email or SMS for the verification token
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Transfer Details -->
                    <div class="transfer-details border rounded p-4 mb-4">
                        <h6 class="text-muted mb-3"><i class="fas fa-receipt me-2"></i>Transfer Details</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Reference Number:</strong><br>
                                   <span class="text-primary">{{ $transaction->transaction_ref }}</span></p>
                                <p><strong>Amount:</strong><br>
                                   <span class="fw-bold text-success">${{ number_format($transaction->amount, 2) }}</span></p>
                                <p><strong>Recipient:</strong><br>
                                   {{ $transaction->recipient_name }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Bank:</strong><br>
                                   {{ $transaction->bank_name }}</p>
                                <p><strong>Country:</strong><br>
                                   {{ $transaction->bank_country }}</p>
                                <p><strong>Account:</strong><br>
                                   {{ $transaction->iban }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                        <button type="button" class="btn btn-primary btn-lg me-md-2" id="verifyTokenBtn">
                            <i class="fas fa-check-circle me-2"></i>Verify & Complete Transfer
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-lg" id="resendTokenBtn">
                            <i class="fas fa-redo me-2"></i>Resend Token
                        </button>
                    </div>

                    <!-- Help Text -->
                    <div class="text-center mt-4">
                        <small class="text-muted">
                            <i class="fas fa-question-circle me-1"></i>
                            Having trouble? <a href="#" class="text-decoration-none">Contact support</a>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tokenInput = document.getElementById('transfer_token');
    const verifyBtn = document.getElementById('verifyTokenBtn');
    const resendBtn = document.getElementById('resendTokenBtn');
    const transactionId = {{ $transaction->id }};

    // Format token input (auto-uppercase and limit to 6 characters)
    tokenInput.addEventListener('input', function() {
        this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '').substring(0, 6);
    });

    // Verify token button handler
    verifyBtn.addEventListener('click', function() {
        const token = tokenInput.value.trim();
        
        if (!token) {
            showAlert('Please enter the verification token', 'danger');
            return;
        }

        if (token.length !== 6) {
            showAlert('Token must be 6 characters long', 'warning');
            return;
        }

        // Show loading state
        this.disabled = true;
        this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Verifying...';

        // Make API call to verify token
        fetch(`/transfer/verify-token/${transactionId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                token: token
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert(data.message, 'success');
                // Redirect to success page
                setTimeout(() => {
                    window.location.href = data.redirect_url;
                }, 1500);
            } else {
                showAlert(data.message, 'danger');
                this.disabled = false;
                this.innerHTML = '<i class="fas fa-check-circle me-2"></i>Verify & Complete Transfer';
            }
        })
        .catch(error => {
            showAlert('An error occurred. Please try again.', 'danger');
            this.disabled = false;
            this.innerHTML = '<i class="fas fa-check-circle me-2"></i>Verify & Complete Transfer';
        });
    });

    // Resend token button handler
    resendBtn.addEventListener('click', function() {
        this.disabled = true;
        this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Sending...';

        // Make API call to resend token
        fetch(`/transfer/resend-token/${transactionId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert(data.message, 'info');
                // For demo purposes, show the token (remove in production)
                console.log('New token:', data.token);
            } else {
                showAlert('Failed to resend token. Please try again.', 'danger');
            }
            this.disabled = false;
            this.innerHTML = '<i class="fas fa-redo me-2"></i>Resend Token';
        })
        .catch(error => {
            showAlert('An error occurred. Please try again.', 'danger');
            this.disabled = false;
            this.innerHTML = '<i class="fas fa-redo me-2"></i>Resend Token';
        });
    });

    // Enter key support
    tokenInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            verifyBtn.click();
        }
    });

    // Auto-focus on token input
    tokenInput.focus();

    // Helper function to show alerts
    function showAlert(message, type) {
        // Remove existing alerts
        const existingAlert = document.querySelector('.alert');
        if (existingAlert) {
            existingAlert.remove();
        }

        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show mt-3`;
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        document.querySelector('.card-body').insertBefore(alertDiv, document.querySelector('.token-box'));
    }
});
</script>

<style>
.token-box {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border: 2px dashed #dee2e6 !important;
}

.token-box:hover {
    border-color: #0d6efd !important;
    transition: border-color 0.3s ease;
}

#transfer_token {
    border: 2px solid #dee2e6;
    transition: all 0.3s ease;
}

#transfer_token:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}

.transfer-details {
    background-color: #f8f9fa;
    border-left: 4px solid #0d6efd;
}

.btn-lg {
    padding: 0.75rem 1.5rem;
    font-size: 1.1rem;
}
</style>
@endsection