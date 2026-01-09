@extends('layouts.front')

@section('title', 'About Us - Zenis')

@section('content')
<div class="container" style="padding: 4rem 0;">
    <h1 style="font-size: 2.5rem; margin-bottom: 2rem;">About Zenis</h1>
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: center;">
        <div>
            <img src="https://images.unsplash.com/photo-1556761175-5973dc0f32e7?q=80&w=1000&auto=format&fit=crop" style="width:100%; border-radius:8px;" alt="Office">
        </div>
        <div>
            <h2 style="font-size: 1.75rem; margin-bottom: 1rem;">Our Story</h2>
            <p style="color: var(--text); margin-bottom: 1.5rem; line-height: 1.8;">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
            </p>
            <p style="color: var(--text); margin-bottom: 1.5rem; line-height: 1.8;">
                Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            </p>
            <div style="display: flex; gap: 2rem;">
                <div>
                    <strong style="display:block; font-size:2rem; color:var(--primary);">10k+</strong>
                    <span style="color:var(--text);">Happy Customers</span>
                </div>
                <div>
                    <strong style="display:block; font-size:2rem; color:var(--primary);">15+</strong>
                    <span style="color:var(--text);">Years Experience</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
