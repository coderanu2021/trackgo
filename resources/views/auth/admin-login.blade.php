@extends('layouts.front')

@section('title', 'Admin Login - ' . ($settings['site_name'] ?? 'TrackGo'))

@section('content')
<div class="container" style="padding: 6rem 0;">
    <div style="max-width: 450px; margin: 0 auto;">
        <div style="background: white; padding: 3rem; border: 1px solid var(--border); border-radius: var(--radius-lg); box-shadow: var(--shadow-lg);">
            
            <!-- Header -->
            <div style="text-align: center; margin-bottom: 3rem;">
                <div style="width: 80px; height: 80px; background: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; color: white; font-size: 2rem;">
                    <i class="fas fa-user-shield"></i>
                </div>
                <h1 style="font-size: 1.75rem; margin-bottom: 0.5rem; color: var(--secondary); font-family: 'Outfit', sans-serif; font-weight: 800;">Admin Login</h1>
                <p style="color: var(--text-muted); font-size: 0.95rem;">Enter your admin credentials to access the dashboard</p>
            </div>

            <!-- Error Messages -->
            @if($errors->any())
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    @foreach($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <div class="form-group" style="margin-bottom: 2rem;">
                    <label style="display: block; margin-bottom: 0.75rem; font-weight: 600; color: var(--secondary);">Email Address</label>
                    <input type="email" name="email" class="form-control" 
                           placeholder="admin@example.com" 
                           value="{{ old('email') }}" 
                           required autofocus>
                </div>

                <div class="form-group" style="margin-bottom: 2rem;">
                    <label style="display: block; margin-bottom: 0.75rem; font-weight: 600; color: var(--secondary);">Password</label>
                    <div style="position: relative;">
                        <input type="password" name="password" id="password" class="form-control" 
                               placeholder="Enter your password" 
                               required>
                        <button type="button" id="toggle-password" style="position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--text-muted); cursor: pointer;">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                    <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                        <input type="checkbox" name="remember" style="margin: 0;">
                        <span style="color: var(--text-muted); font-size: 0.9rem;">Remember me</span>
                    </label>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1rem; font-size: 1.1rem; font-weight: 700;">
                    <i class="fas fa-sign-in-alt"></i> Login to Admin Panel
                </button>
            </form>

            <!-- Customer Login Link -->
            <div style="text-align: center; margin-top: 2rem; padding-top: 2rem; border-top: 1px solid var(--border);">
                <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 0.5rem;">Customer Access?</p>
                <a href="{{ route('whatsapp.login') }}" style="color: #25D366; font-weight: 600; text-decoration: none;">
                    <i class="fab fa-whatsapp"></i> Login with WhatsApp
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

    /* Responsive */
    @media (max-width: 768px) {
        .container {
            padding: 3rem 1rem !important;
        }
        
        .container > div > div {
            padding: 2rem !important;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle password visibility
    const togglePassword = document.getElementById('toggle-password');
    const passwordInput = document.getElementById('password');
    
    togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        
        const icon = this.querySelector('i');
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
    });
});
</script>
@endsection