@extends('customer.layout')

@section('customer_content')
<div class="dashboard-header" style="margin-bottom: 3rem;">
    <h1 style="font-size: 2.25rem; font-weight: 800; margin: 0; font-family: 'Outfit';">Edit Profile</h1>
    <p style="color: var(--text-muted); margin-top: 0.5rem; font-size: 1.1rem;">Update your personal information and security settings.</p>
</div>

@if(session('success'))
    <div style="background: rgba(34, 197, 94, 0.1); color: #22c55e; padding: 1.25rem 2rem; border-radius: 16px; font-weight: 700; margin-bottom: 2.5rem; display: flex; align-items: center; gap: 1rem; border: 1px solid rgba(34, 197, 94, 0.2);">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

<div class="card" style="background: var(--white); border-radius: 24px; box-shadow: var(--shadow-md); border: 1px solid var(--border-soft); padding: 3rem;">
    <form action="{{ route('customer.profile.update') }}" method="POST">
        @csrf
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
            <div class="form-group">
                <label style="display: block; font-size: 0.85rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.75rem; margin-left: 0.25rem;">Full Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                       style="width: 100%; padding: 1.15rem 1.5rem; background: var(--bg-light); border: 1.5px solid transparent; border-radius: 16px; font-size: 1rem; font-weight: 600; outline: none; transition: all 0.3s;"
                       onfocus="this.style.borderColor='var(--primary)'; this.style.background='white'; this.style.boxShadow='0 0 0 4px var(--primary-soft)'"
                       onblur="this.style.borderColor='transparent'; this.style.background='var(--bg-light)'; this.style.boxShadow='none'" required>
                @error('name') <span style="color: #ef4444; font-size: 0.85rem; font-weight: 600; margin-top: 0.5rem; display: block;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label style="display: block; font-size: 0.85rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.75rem; margin-left: 0.25rem;">Email Address</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                       style="width: 100%; padding: 1.15rem 1.5rem; background: var(--bg-light); border: 1.5px solid transparent; border-radius: 16px; font-size: 1rem; font-weight: 600; outline: none; transition: all 0.3s;"
                       onfocus="this.style.borderColor='var(--primary)'; this.style.background='white'; this.style.boxShadow='0 0 0 4px var(--primary-soft)'"
                       onblur="this.style.borderColor='transparent'; this.style.background='var(--bg-light)'; this.style.boxShadow='none'" required>
                @error('email') <span style="color: #ef4444; font-size: 0.85rem; font-weight: 600; margin-top: 0.5rem; display: block;">{{ $message }}</span> @enderror
            </div>
        </div>

        <div style="margin-top: 3rem; padding-top: 3rem; border-top: 1px solid var(--border-soft);">
            <h3 style="font-family: 'Outfit'; font-size: 1.25rem; margin: 0 0 2rem;">Security Update <span style="font-size: 0.85rem; color: var(--text-muted); font-weight: 400; font-family: 'Inter';">(Leave blank to keep current password)</span></h3>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
                <div class="form-group">
                    <label style="display: block; font-size: 0.85rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.75rem; margin-left: 0.25rem;">New Password</label>
                    <input type="password" name="password" 
                           style="width: 100%; padding: 1.15rem 1.5rem; background: var(--bg-light); border: 1.5px solid transparent; border-radius: 16px; font-size: 1rem; font-weight: 600; outline: none; transition: all 0.3s;"
                           onfocus="this.style.borderColor='var(--primary)'; this.style.background='white'; this.style.boxShadow='0 0 0 4px var(--primary-soft)'"
                           onblur="this.style.borderColor='transparent'; this.style.background='var(--bg-light)'; this.style.boxShadow='none'">
                    @error('password') <span style="color: #ef4444; font-size: 0.85rem; font-weight: 600; margin-top: 0.5rem; display: block;">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label style="display: block; font-size: 0.85rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.75rem; margin-left: 0.25rem;">Confirm New Password</label>
                    <input type="password" name="password_confirmation" 
                           style="width: 100%; padding: 1.15rem 1.5rem; background: var(--bg-light); border: 1.5px solid transparent; border-radius: 16px; font-size: 1rem; font-weight: 600; outline: none; transition: all 0.3s;"
                           onfocus="this.style.borderColor='var(--primary)'; this.style.background='white'; this.style.boxShadow='0 0 0 4px var(--primary-soft)'"
                           onblur="this.style.borderColor='transparent'; this.style.background='var(--bg-light)'; this.style.boxShadow='none'">
                </div>
            </div>
        </div>

        <div style="margin-top: 3.5rem;">
            <button type="submit" class="btn btn-primary" style="padding: 1.25rem 3.5rem; border-radius: 18px; font-size: 1.1rem; letter-spacing: 0.02em;">
                Save Changes <i class="fas fa-save" style="margin-left: 0.75rem; opacity: 0.8;"></i>
            </button>
        </div>
    </form>
</div>
@endsection
