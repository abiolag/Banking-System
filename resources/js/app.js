import './bootstrap';

// Password visibility toggle function
function togglePassword(inputId) {
    const passwordInput = document.getElementById(inputId);
    const toggleButton = passwordInput.parentNode.querySelector('button');
    const icon = toggleButton.querySelector('i');
    
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
}

// Add keyboard accessibility
document.addEventListener('DOMContentLoaded', function() {
    // Add event listeners to all password toggle buttons
    const toggleButtons = document.querySelectorAll('[onclick*="togglePassword"]');
    
    toggleButtons.forEach(button => {
        button.setAttribute('tabindex', '0');
        button.setAttribute('role', 'button');
        button.setAttribute('aria-label', 'Show password');
        
        button.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                const inputId = button.getAttribute('onclick').match(/'([^']+)'/)[1];
                togglePassword(inputId);
            }
        });
    });
});