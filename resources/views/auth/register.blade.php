@extends('layouts.front')

@section('title', 'Join TrackGo - Create Your Account')

@section('content')
<div class="auth-wrapper" style="background: radial-gradient(circle at top right, #f8fafc 0%, #e2e8f0 100%); padding: 6rem 0; min-height: 80vh; display: flex; align-items: center;">
    <div class="container">
        <div style="max-width: 550px; margin: 0 auto; position: relative;">
            <!-- Glow Effect -->
            <div style="position: absolute; width: 300px; height: 300px; background: var(--primary); filter: blur(150px); opacity: 0.1; top: -50px; right: -50px; z-index: 0;"></div>
            
            <div class="auth-card" style="background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.5); border-radius: 40px; padding: 4rem; box-shadow: var(--shadow-lg); position: relative; z-index: 1;">
                <div style="text-align: center; margin-bottom: 3rem;">
                    <h1 style="font-family: 'Outfit'; font-size: 2.5rem; font-weight: 800; color: var(--secondary); margin: 0; letter-spacing: -0.02em;">Digital Onboarding<span>.</span></h1>
                    <p style="color: var(--text-muted); font-size: 1.1rem; margin-top: 0.75rem;">Initialize your portal access and manage your strategic assets.</p>
                </div>

                @if($errors->any())
                    <div style="background: rgba(239, 68, 68, 0.08); color: #ef4444; padding: 1.5rem; border-radius: 20px; font-size: 0.9rem; font-weight: 600; margin-bottom: 2.5rem; border: 1px solid rgba(239, 68, 68, 0.15);">
                        <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.5rem;">
                            <i class="fas fa-exclamation-triangle"></i> Access Denied - Payload Errors:
                        </div>
                        <ul style="margin: 0; padding-left: 1.5rem; opacity: 0.9;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="form-group" style="margin-bottom: 1.75rem;">
                        <label style="display: block; font-size: 0.75rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.75rem; padding-left: 0.5rem;">Identification Name</label>
                        <input type="text" name="name" class="form-input-auth" placeholder="e.g. Alexander Pierce" value="{{ old('name') }}" required autofocus>
                    </div>

                    <div class="form-group" style="margin-bottom: 1.75rem;">
                        <label style="display: block; font-size: 0.75rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.75rem; padding-left: 0.5rem;">Official Email Key</label>
                        <input type="email" name="email" class="form-input-auth" placeholder="name@company.systems" value="{{ old('email') }}" required>
                    </div>

                    <div class="form-group" style="margin-bottom: 1.75rem;">
                        <label style="display: block; font-size: 0.75rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.75rem; padding-left: 0.5rem;">Secure Phrase (Password)</label>
                        <input type="password" name="password" class="form-input-auth" placeholder="••••••••••••" required>
                    </div>

                    <div class="form-group" style="margin-bottom: 2.5rem;">
                        <label style="display: block; font-size: 0.75rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.75rem; padding-left: 0.5rem;">Verify Phrase</label>
                        <input type="password" name="password_confirmation" class="form-input-auth" placeholder="••••••••••••" required>
                    </div>

                    <button type="submit" class="btn-auth-submit">
                        Launch Dashboard <i class="fas fa-rocket" style="margin-left: 0.75rem;"></i>
                    </button>
                </form>

                <div style="margin-top: 3rem; text-align: center; color: var(--text-muted); font-size: 0.95rem;">
                    Already authenticated? <a href="{{ route('login') }}" style="color: var(--primary); font-weight: 700; text-decoration: none; border-bottom: 2px solid var(--primary-soft);">Back to Login</a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-input-auth {
        width: 100%;
        padding: 1.25rem 1.75rem;
        background: rgba(255, 255, 255, 0.9);
        border: 1px solid rgba(0, 0, 0, 0.05);
        border-radius: 20px;
        font-size: 1rem;
        font-weight: 500;
        box-sizing: border-box;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        outline: none;
    }
    .form-input-auth:focus {
        border-color: var(--primary);
        background: white;
        box-shadow: 0 0 0 5px var(--primary-soft);
        transform: translateY(-2px);
    }
    .btn-auth-submit {
        width: 100%;
        padding: 1.25rem;
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 20px;
        font-weight: 800;
        font-size: 1.1rem;
        font-family: 'Outfit';
        text-transform: uppercase;
        letter-spacing: 0.05em;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 15px 30px -5px rgba(99, 102, 241, 0.4);
    }
    .btn-auth-submit:hover {
        background: var(--primary-dark);
        transform: translateY(-3px) scale(1.01);
        box-shadow: 0 25px 35px -5px rgba(99, 102, 241, 0.5);
    }
</style>
@endsection

