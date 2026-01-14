<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Command Center | TrackGo</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    <style>
        :root {
            --primary: {{ $settings['site_primary_color'] ?? '#6366f1' }};
            --accent: {{ $settings['site_secondary_color'] ?? '#8b5cf6' }};
            --shadow-primary: 0 4px 14px 0 {{ $settings['site_primary_color'] ?? '#6366F1' }}4D; /* 30% opacity hex suffix 4D */
        }
    </style>
    
    <script>
        // Sidebar Theme initialization
        const currentSidebar = localStorage.getItem('sidebar-theme') || 'light';
        document.documentElement.setAttribute('data-sidebar', currentSidebar);
    </script>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
</head>
<body>
    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                @if(isset($settings['site_logo']))
                    <img src="{{ asset($settings['site_logo']) }}" alt="Logo" style="height: 40px; width: auto; object-fit: contain;">
                @else
                    <i class="fas fa-bolt"></i>
                @endif
                <span>{{ $settings['site_name'] ?? 'TrackGo' }}</span>
            </div>
            
            <nav class="sidebar-nav">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-grid-2"></i> Dashboard
                </a>
                
                <div style="margin: 1.5rem 0 0.5rem 1.25rem; font-size: 0.7rem; font-weight: 700; color: var(--sidebar-label); text-transform: uppercase; letter-spacing: 0.1em;">Content</div>
                
                <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <i class="fas fa-file-invoice"></i> Product Detail Builder
                </a>
                <a href="{{ route('admin.builder.index') }}" class="nav-link {{ request()->routeIs('admin.builder.*') ? 'active' : '' }}">
                    <i class="fas fa-rocket"></i> Landing Pages
                </a>
                <a href="{{ route('admin.blogs.index') }}" class="nav-link {{ request()->routeIs('admin.blogs.*') ? 'active' : '' }}">
                    <i class="fas fa-pen-nib"></i> Blog Posts
                </a>
                <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <i class="fas fa-tags"></i> Categories
                </a>
                <a href="{{ route('admin.banners.index') }}" class="nav-link {{ request()->routeIs('admin.banners.*') ? 'active' : '' }}">
                    <i class="fas fa-flag"></i> Home Banners
                </a>
                <a href="{{ route('admin.plans.index') }}" class="nav-link {{ request()->routeIs('admin.plans.*') ? 'active' : '' }}">
                    <i class="fas fa-layer-group"></i> Pricing Plans
                </a>
                <a href="{{ route('admin.faqs.index') }}" class="nav-link {{ request()->routeIs('admin.faqs.*') ? 'active' : '' }}">
                    <i class="fas fa-question-circle"></i> FAQs
                </a>
                <a href="{{ route('admin.newsletters.index') }}" class="nav-link {{ request()->routeIs('admin.newsletters.*') ? 'active' : '' }}">
                    <i class="fas fa-paper-plane"></i> Newsletter
                </a>

                <div style="margin: 1.5rem 0 0.5rem 1.25rem; font-size: 0.7rem; font-weight: 700; color: var(--sidebar-label); text-transform: uppercase; letter-spacing: 0.1em;">Management</div>
                
                <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <i class="fas fa-bag-shopping"></i> Orders
                </a>
                <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="fas fa-user-group"></i> Customers
                </a>
                <a href="{{ route('admin.subscriptions.index') }}" class="nav-link {{ request()->routeIs('admin.subscriptions.*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-check"></i> Users Subscription Manager
                </a>
                <a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <i class="fas fa-sliders"></i> Settings
                </a>
            </nav>

            <div style="margin-top: auto; padding-top: 2rem;">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="nav-link" style="width: 100%; background: none; border: none; cursor: pointer; color: #ef4444;">
                        <i class="fas fa-arrow-right-from-bracket"></i> Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header class="top-header">
                <div>
                    <div style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.85rem; font-weight: 600;">
                        <span style="color: var(--text-muted)">Admin</span>
                        <i class="fas fa-chevron-right" style="font-size: 0.6rem; color: var(--text-light)"></i>
                        <span style="color: var(--primary)">{{ Str::title(request()->segment(2) ?? 'Dashboard') }}</span>
                    </div>
                </div>

                <div style="display: flex; align-items: center; gap: 1.5rem;">
                    <button id="theme-toggle" class="btn btn-secondary" title="Toggle Sidebar Theme" style="padding: 0.5rem; width: 40px; height: 40px; justify-content: center; border-radius: 50%;">
                        <i class="fas fa-sidebar" id="theme-icon"></i>
                    </button>
                    <button class="btn btn-secondary" style="padding: 0.5rem; width: 40px; height: 40px; justify-content: center; border-radius: 50%;">
                        <i class="fas fa-bell"></i>
                    </button>
                    <div style="display: flex; align-items: center; gap: 0.75rem; border-left: 1px solid var(--border-soft); padding-left: 1.5rem;">
                        <div style="text-align: right;">
                            <div style="font-size: 0.9rem; font-weight: 700;">{{ auth()->user()->name }}</div>
                            <div style="font-size: 0.75rem; color: var(--text-muted);">Master Admin</div>
                        </div>
                        <div style="width: 45px; height: 45px; border-radius: 14px; background: linear-gradient(135deg, #6366f1, #8b5cf6); display: flex; align-items: center; justify-content: center; color: white; font-weight: 800; font-size: 1.2rem; box-shadow: var(--shadow-primary);">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    </div>
                </div>
            </header>

            <div class="page-content">
                @if(session('success'))
                    <div style="background: rgba(16, 185, 129, 0.1); color: #065f46; padding: 1.25rem 1.5rem; border-radius: var(--radius-md); margin-bottom: 2rem; border-left: 4px solid #10b981; display: flex; align-items: center; gap: 1rem; font-weight: 600;">
                         <i class="fas fa-circle-check" style="font-size: 1.25rem; color: #10b981;"></i> {{ session('success') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <!-- Initialize Tooltips & Theme Toggle -->
    <script>
        $(document).ready(function() {
            const themeToggle = document.getElementById('theme-toggle');
            const themeIcon = document.getElementById('theme-icon');
            const html = document.documentElement;

            themeToggle.addEventListener('click', () => {
                const currentSidebar = html.getAttribute('data-sidebar');
                const newTheme = currentSidebar === 'light' ? 'dark' : 'light';
                
                html.setAttribute('data-sidebar', newTheme);
                localStorage.setItem('sidebar-theme', newTheme);
            });
        });
    </script>
</body>
</html>
