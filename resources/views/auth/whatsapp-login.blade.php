@extends('layouts.front')

@section('title', 'Login with WhatsApp - ' . ($settings['site_name'] ?? 'TrackGo'))

@section('content')
<div class="container" style="padding: 6rem 0;">
    <div style="max-width: 450px; margin: 0 auto;">
        <div style="background: white; padding: 3rem; border: 1px solid var(--border); border-radius: var(--radius-lg); box-shadow: var(--shadow-lg);">
            
            <!-- Header -->
            <div style="text-align: center; margin-bottom: 3rem;">
                <div style="width: 80px; height: 80px; background: #25D366; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; color: white; font-size: 2rem;">
                    <i class="fab fa-whatsapp"></i>
                </div>
                <h1 style="font-size: 1.75rem; margin-bottom: 0.5rem; color: var(--secondary); font-family: 'Outfit', sans-serif; font-weight: 800;">Login with WhatsApp</h1>
                <p style="color: var(--text-muted); font-size: 0.95rem;">Enter your phone number to receive an OTP on WhatsApp</p>
            </div>

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif

            @if(session('info'))
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> {{ session('info') }}
                </div>
            @endif

            <!-- Phone Number Form (Step 1) -->
            <div id="phone-form" style="{{ session('otp_sent') ? 'display: none;' : '' }}">
                <form id="send-otp-form">
                    @csrf
                    <div class="form-group" style="margin-bottom: 2rem;">
                        <label style="display: block; margin-bottom: 0.75rem; font-weight: 600; color: var(--secondary);">Phone Number</label>
                        <div style="position: relative;">
                            <div style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-weight: 600;">+91</div>
                            <input type="tel" name="phone" id="phone" class="form-control" 
                                   style="padding-left: 4rem;" 
                                   placeholder="9876543210" 
                                   value="{{ old('phone', session('phone')) }}" 
                                   required>
                        </div>
                        <small style="color: var(--text-muted); font-size: 0.85rem; margin-top: 0.5rem; display: block;">
                            <i class="fas fa-shield-alt" style="color: var(--success);"></i> 
                            We'll send a secure OTP to your WhatsApp
                        </small>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1rem; font-size: 1.1rem; font-weight: 700;">
                        <i class="fab fa-whatsapp"></i> Send OTP via WhatsApp
                    </button>
                </form>
            </div>

            <!-- OTP Verification Form (Step 2) -->
            <div id="otp-form" style="{{ session('otp_sent') ? '' : 'display: none;' }}">
                <div style="text-align: center; margin-bottom: 2rem;">
                    <div style="width: 60px; height: 60px; background: rgba(37, 211, 102, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; color: #25D366; font-size: 1.5rem;">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h3 style="margin-bottom: 0.5rem; color: var(--secondary);">Enter OTP</h3>
                    <p style="color: var(--text-muted); font-size: 0.9rem;">
                        We've sent a 6-digit code to<br>
                        <strong id="display-phone">{{ session('phone') }}</strong>
                    </p>
                </div>

                <form id="verify-otp-form">
                    @csrf
                    <input type="hidden" name="phone" id="hidden-phone" value="{{ session('phone') }}">
                    
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <label style="display: block; margin-bottom: 0.75rem; font-weight: 600; color: var(--secondary);">OTP Code</label>
                        <input type="text" name="otp" id="otp" class="form-control otp-input" 
                               placeholder="000000" 
                               maxlength="6" 
                               style="text-align: center; font-size: 1.5rem; font-weight: 700; letter-spacing: 0.5rem;" 
                               required>
                    </div>

                    <div class="form-group" style="margin-bottom: 2rem;">
                        <label style="display: block; margin-bottom: 0.75rem; font-weight: 600; color: var(--secondary);">Your Name (Optional)</label>
                        <input type="text" name="name" id="name" class="form-control" 
                               placeholder="Enter your name" 
                               value="{{ old('name') }}">
                        <small style="color: var(--text-muted); font-size: 0.85rem; margin-top: 0.5rem; display: block;">
                            This will be used for your profile
                        </small>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1rem; font-size: 1.1rem; font-weight: 700; margin-bottom: 1rem;">
                        <i class="fas fa-sign-in-alt"></i> Verify & Login
                    </button>

                    <div style="text-align: center;">
                        <button type="button" id="resend-otp" class="btn-link" style="color: var(--primary); font-weight: 600;">
                            <i class="fas fa-redo"></i> Resend OTP
                        </button>
                        <span style="margin: 0 1rem; color: var(--text-muted);">|</span>
                        <button type="button" id="change-phone" class="btn-link" style="color: var(--text-muted); font-weight: 600;">
                            <i class="fas fa-edit"></i> Change Number
                        </button>
                    </div>
                </form>
            </div>

            <!-- Admin Login Link -->
            <div style="text-align: center; margin-top: 2rem; padding-top: 2rem; border-top: 1px solid var(--border);">
                <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 0.5rem;">Admin Access?</p>
                <a href="{{ route('admin.login') }}" style="color: var(--primary); font-weight: 600; text-decoration: none;">
                    <i class="fas fa-user-shield"></i> Admin Login
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control {
        width: 100%;
        padding: 1rem 1.25rem;
        border: 2px solid var(--border);
        border-radius: 12px;
        outline: none;
        transition: 0.3s;
        font-size: 1rem;
        box-sizing: border-box;
    }
    
    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(243, 112, 33, 0.1);
    }

    .otp-input {
        font-family: 'Courier New', monospace;
    }

    .btn-link {
        background: none;
        border: none;
        cursor: pointer;
        font-size: 0.9rem;
        transition: 0.3s;
    }

    .btn-link:hover {
        opacity: 0.8;
    }

    .alert {
        padding: 1rem 1.25rem;
        border-radius: 12px;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-weight: 600;
    }

    .alert-success {
        background: rgba(16, 185, 129, 0.1);
        color: #065f46;
        border-left: 4px solid #10b981;
    }

    .alert-error {
        background: rgba(239, 68, 68, 0.1);
        color: #991b1b;
        border-left: 4px solid #ef4444;
    }

    .alert-info {
        background: rgba(59, 130, 246, 0.1);
        color: #1e40af;
        border-left: 4px solid #3b82f6;
    }

    /* Loading states */
    .btn:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }

    .loading {
        position: relative;
    }

    .loading::after {
        content: '';
        position: absolute;
        width: 20px;
        height: 20px;
        margin: auto;
        border: 2px solid transparent;
        border-top-color: currentColor;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    @keyframes spin {
        0% { transform: translate(-50%, -50%) rotate(0deg); }
        100% { transform: translate(-50%, -50%) rotate(360deg); }
    }

    /* Notification styles */
    .notification {
        position: fixed;
        top: 2rem;
        right: 2rem;
        z-index: 10000;
        max-width: 400px;
        padding: 1rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        transform: translateX(100%);
        opacity: 0;
        transition: all 0.3s ease;
    }

    .notification.show {
        transform: translateX(0);
        opacity: 1;
    }

    .notification-success {
        background: rgba(16, 185, 129, 0.95);
        color: white;
        border-left: 4px solid #10b981;
    }

    .notification-error {
        background: rgba(239, 68, 68, 0.95);
        color: white;
        border-left: 4px solid #ef4444;
    }

    .notification-content {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .container {
            padding: 3rem 1rem !important;
        }
        
        .container > div > div {
            padding: 2rem !important;
        }

        .notification {
            top: 1rem;
            right: 1rem;
            left: 1rem;
            max-width: none;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sendOtpForm = document.getElementById('send-otp-form');
    const verifyOtpForm = document.getElementById('verify-otp-form');
    const phoneForm = document.getElementById('phone-form');
    const otpForm = document.getElementById('otp-form');
    const resendBtn = document.getElementById('resend-otp');
    const changePhoneBtn = document.getElementById('change-phone');

    // Send OTP
    sendOtpForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
        
        const formData = new FormData(this);
        
        fetch('{{ route("whatsapp.send-otp") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show OTP form
                phoneForm.style.display = 'none';
                otpForm.style.display = 'block';
                
                // Update phone display
                const phone = formData.get('phone');
                document.getElementById('display-phone').textContent = '+91 ' + phone;
                document.getElementById('hidden-phone').value = phone;
                
                showNotification('success', data.message);
                
                // Focus on OTP input
                document.getElementById('otp').focus();
            } else {
                showNotification('error', data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('error', 'Something went wrong. Please try again.');
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        });
    });

    // Verify OTP
    verifyOtpForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Verifying...';
        
        const formData = new FormData(this);
        
        fetch('{{ route("whatsapp.verify-otp") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('success', data.message);
                
                // Redirect after short delay
                setTimeout(() => {
                    window.location.href = data.redirect_url || '{{ route("customer.dashboard") }}';
                }, 1000);
            } else {
                showNotification('error', data.message);
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('error', 'Something went wrong. Please try again.');
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        });
    });

    // Resend OTP
    resendBtn.addEventListener('click', function() {
        const phone = document.getElementById('hidden-phone').value;
        
        this.disabled = true;
        this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
        
        const formData = new FormData();
        formData.append('phone', phone);
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        
        fetch('{{ route("whatsapp.resend-otp") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            showNotification(data.success ? 'success' : 'error', data.message);
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('error', 'Failed to resend OTP. Please try again.');
        })
        .finally(() => {
            this.disabled = false;
            this.innerHTML = '<i class="fas fa-redo"></i> Resend OTP';
        });
    });

    // Change phone number
    changePhoneBtn.addEventListener('click', function() {
        phoneForm.style.display = 'block';
        otpForm.style.display = 'none';
        document.getElementById('phone').focus();
    });

    // Auto-format OTP input
    document.getElementById('otp').addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    // Auto-format phone input
    document.getElementById('phone').addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
});

// Notification function
function showNotification(type, message) {
    // Remove existing notifications
    const existingNotifications = document.querySelectorAll('.notification');
    existingNotifications.forEach(n => n.remove());
    
    // Create notification
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
            <span>${message}</span>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => notification.classList.add('show'), 100);
    
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => notification.remove(), 300);
    }, 4000);
}
</script>
@endsection