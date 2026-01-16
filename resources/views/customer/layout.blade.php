@extends('layouts.front')

@section('content')
<div class="container" style="margin-top: 4rem; margin-bottom: 6rem;">
    <div style="display: grid; grid-template-columns: 280px 1fr; gap: 3rem;">
        <!-- Sidebar -->
        <div class="customer-sidebar">
            <div class="card" style="padding: 2rem; border-radius: 20px; background: var(--bg-light); border: 1px solid var(--border-soft);">
                <div style="text-align: center; margin-bottom: 2.5rem;">
                    <div style="width: 80px; height: 80px; background: var(--primary); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; font-weight: 800; margin: 0 auto 1rem; font-family: 'Outfit';">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <h3 style="margin: 0; font-family: 'Outfit'; font-size: 1.25rem;">{{ Auth::user()->name }}</h3>
                    <p style="color: var(--text-muted); font-size: 0.85rem; margin-top: 0.25rem;">Customer Account</p>
                </div>

                <nav class="customer-nav">
                    <ul style="display: flex; flex-direction: column; gap: 0.5rem;">
                        <li>
                            <a href="{{ route('customer.dashboard') }}" class="customer-nav-link {{ request()->routeIs('customer.dashboard') ? 'active' : '' }}">
                                <i class="fas fa-th-large"></i> Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('customer.orders') }}" class="customer-nav-link {{ request()->routeIs('customer.orders') ? 'active' : '' }}">
                                <i class="fas fa-shopping-bag"></i> My Orders
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('customer.profile') }}" class="customer-nav-link {{ request()->routeIs('customer.profile') ? 'active' : '' }}">
                                <i class="fas fa-user-edit"></i> Edit Profile
                            </a>
                        </li>
                        <li style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid var(--border-soft);">
                            <form action="{{ route('logout') }}" method="POST" id="logout-form">
                                @csrf
                                <button type="submit" class="customer-nav-link" style="width: 100%; text-align: left; background: none; border: none; cursor: pointer; color: #ef4444;">
                                    <i class="fas fa-sign-out-alt"></i> Sign Out
                                </button>
                            </form>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="customer-content">
            @yield('customer_content')
        </div>
    </div>
</div>

<style>
    .customer-nav-link {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem 1.25rem;
        border-radius: 12px;
        color: var(--text-main);
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }
    .customer-nav-link i {
        width: 20px;
        font-size: 1.1rem;
        color: var(--text-muted);
        transition: all 0.3s ease;
    }
    .customer-nav-link:hover {
        background: var(--white);
        color: var(--primary);
    }
    .customer-nav-link:hover i {
        color: var(--primary);
    }
    .customer-nav-link.active {
        background: var(--primary);
        color: white;
    }
    .customer-nav-link.active i {
        color: white;
    }

    @media (max-width: 992px) {
        div[style*="grid-template-columns: 280px 1fr"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endsection
