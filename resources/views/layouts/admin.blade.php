<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Command Center | TrackGo</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Font Awesome 6.5.1 from multiple CDNs for reliability -->
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="preconnect" href="https://use.fontawesome.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.5.1/css/all.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v6.0.0/css/all.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-forms.css') }}">
    
    <style>
        /* Ensure Font Awesome icons display properly */
        .fas, .far, .fab, .fal, .fad, .fa {
            font-family: "Font Awesome 6 Free", "Font Awesome 6 Pro", "Font Awesome 5 Free", "Font Awesome 5 Pro", "FontAwesome" !important;
            font-weight: 900;
            font-style: normal;
            font-variant: normal;
            text-rendering: auto;
            line-height: 1;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            display: inline-block;
            text-decoration: inherit;
        }
        
        .far {
            font-weight: 400;
        }
        
        .fab {
            font-weight: 400;
            font-family: "Font Awesome 6 Brands", "Font Awesome 5 Brands" !important;
        }
        
        /* Enhanced fallback system for missing icons */
        .fas:before, .far:before, .fab:before {
            display: inline-block;
            text-decoration: inherit;
            width: 1em;
            text-align: center;
        }
        
        /* Comprehensive icon fallbacks for admin panel */
        .fa-layer-group:before { content: "⚏"; font-size: 1.1em; }
        .fa-boxes-stacked:before { content: "📦"; }
        .fa-file-invoice:before { content: "📄"; }
        .fa-pen-nib:before { content: "✏️"; }
        .fa-tags:before { content: "🏷️"; }
        .fa-star:before { content: "⭐"; }
        .fa-flag:before { content: "🚩"; }
        .fa-question-circle:before { content: "❓"; }
        .fa-bag-shopping:before { content: "🛍️"; }
        .fa-user-group:before { content: "👥"; }
        .fa-calendar-check:before { content: "📅"; }
        .fa-sliders:before { content: "🎛️"; }
        .fa-grid-2:before { content: "⚏"; }
        .fa-fingerprint:before { content: "👆"; }
        .fa-compass:before { content: "🧭"; }
        .fa-pencil-square:before { content: "✏️"; }
        .fa-arrow-right-from-bracket:before { content: "🚪"; }
        .fa-sidebar:before { content: "⚏"; }
        .fa-bell:before { content: "🔔"; }
        .fa-circle-check:before { content: "✅"; }
        .fa-bars-staggered:before { content: "☰"; }
        .fa-chevron-right:before { content: "▶"; }
        .fa-save:before { content: "💾"; }
        .fa-check-circle:before { content: "✅"; }
        .fa-trash-can:before { content: "🗑️"; }
        .fa-times:before { content: "✖"; }
        .fa-circle-info:before { content: "ℹ️"; }
        
        /* Common page builder icons */
        .fa-font:before { content: "T"; }
        .fa-image:before { content: "🖼️"; }
        .fa-link:before { content: "🔗"; }
        .fa-columns:before { content: "⚏"; }
        .fa-cog:before { content: "⚙️"; }
        .fa-trash:before { content: "🗑️"; }
        .fa-plus:before { content: "+"; }
        .fa-minus:before { content: "-"; }
        .fa-upload:before { content: "⬆️"; }
        .fa-check:before { content: "✓"; }
        .fa-spinner:before { content: "⟳"; }
        .fa-cubes:before { content: "⚏"; }
        .fa-chart-line:before { content: "📊"; }
        .fa-clock-rotate-left:before { content: "🕐"; }
        .fa-list-check:before { content: "☑️"; }
        .fa-folder-tree:before { content: "📁"; }
        .fa-external-link-alt:before { content: "↗"; }
        .fa-bars:before { content: "☰"; }
        .fa-angle-down:before { content: "▼"; }
        
        /* Ensure icons are visible and properly sized */
        .fas, .far, .fab {
            min-width: 1em;
            text-align: center;
            vertical-align: middle;
        }
        
        /* Force icon display for critical elements */
        .sidebar .nav-link i,
        .btn i,
        .icon-wrap i {
            font-family: "Font Awesome 6 Free", "Font Awesome 6 Pro", "Font Awesome 5 Free", "Font Awesome 5 Pro", "FontAwesome", sans-serif !important;
            font-weight: 900 !important;
            font-style: normal !important;
        }
        
        /* DataTables styling fixes */
        .table-container {
            overflow-x: auto;
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        #builder-table {
            width: 100% !important;
            border-collapse: collapse;
        }
        
        #builder-table th,
        #builder-table td {
            padding: 1rem !important;
            border-bottom: 1px solid var(--border-soft) !important;
            vertical-align: middle !important;
        }
        
        #builder-table th {
            background: var(--bg-light) !important;
            font-weight: 600 !important;
            color: var(--text-main) !important;
            text-transform: uppercase !important;
            font-size: 0.75rem !important;
            letter-spacing: 0.05em !important;
        }
        
        #builder-table tbody tr:hover {
            background: var(--bg-light) !important;
        }
        
        /* Ensure operations column is visible */
        #builder-table th:last-child,
        #builder-table td:last-child {
            min-width: 120px !important;
            width: 120px !important;
        }
        
        /* DataTables controls styling */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            margin: 1rem !important;
        }
        
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid var(--border-soft) !important;
            border-radius: 8px !important;
            padding: 0.5rem 1rem !important;
        }
        
        :root {
            /* Dynamic overrides if needed from backend settings */
            --primary: {{ $settings['site_primary_color'] ?? '#f37021' }};
            --accent: {{ $settings['site_secondary_color'] ?? '#ff8c42' }};
        }
        
        /* Auto-Collapse Handling */
        .sidebar.collapsed {
            width: 80px !important;
        }
        .sidebar.collapsed .sidebar-header span,
        .sidebar.collapsed .sidebar-label,
        .sidebar.collapsed .nav-link span {
            display: none !important;
        }
        .sidebar.collapsed .sidebar-header {
            justify-content: center;
            padding: 0;
        }
        .sidebar.collapsed .nav-link {
            justify-content: center;
            padding: 0.75rem;
        }
        .sidebar.collapsed .nav-link i {
            margin: 0;
            font-size: 1.25rem;
        }
        .sidebar.collapsed + .main-content {
            margin-left: 80px !important;
        }
        
        .collapse-toggle {
            cursor: pointer;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            transition: all 0.2s;
            color: var(--sidebar-text);
        }
        .collapse-toggle:hover {
            background: var(--sidebar-nav-hover);
            color: var(--sidebar-header-text);
        }

        /* Profile Dropdown trigger area */
        .user-profile-trigger {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border-left: 1px solid var(--border-soft);
            padding-left: 1.5rem;
            cursor: pointer;
        }
    </style>
    
    <script>
        // Sidebar Theme & Collapse initialization
        const currentSidebar = localStorage.getItem('sidebar-theme') || 'light';
        document.documentElement.setAttribute('data-sidebar', currentSidebar);
        
        document.addEventListener('DOMContentLoaded', () => {
            const isCollapsed = localStorage.getItem('sidebar-collapsed') === 'true';
            if (isCollapsed) {
                document.querySelector('.sidebar').classList.add('collapsed');
            }
        });
    </script>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    
    <!-- Font Awesome Fallback Check and Enhancement -->
    <script>
        // Enhanced Font Awesome loading check
        document.addEventListener('DOMContentLoaded', function() {
            // Test multiple Font Awesome icons to ensure proper loading
            const testIcons = ['fas fa-home', 'fas fa-layer-group', 'fas fa-boxes-stacked'];
            let fontAwesomeLoaded = false;
            
            testIcons.forEach(iconClass => {
                const testIcon = document.createElement('i');
                testIcon.className = iconClass;
                testIcon.style.position = 'absolute';
                testIcon.style.left = '-9999px';
                testIcon.style.fontSize = '16px';
                document.body.appendChild(testIcon);
                
                const computedStyle = window.getComputedStyle(testIcon, ':before');
                const content = computedStyle.getPropertyValue('content');
                const fontFamily = computedStyle.getPropertyValue('font-family');
                
                // Check if Font Awesome is properly loaded
                if (content && content !== 'none' && content !== '""' && 
                    (fontFamily.includes('Font Awesome') || fontFamily.includes('FontAwesome'))) {
                    fontAwesomeLoaded = true;
                }
                
                document.body.removeChild(testIcon);
            });
            
            // If Font Awesome isn't loaded properly, add additional fallbacks
            if (!fontAwesomeLoaded) {
                console.warn('Font Awesome not fully loaded, adding additional fallbacks...');
                
                // Add additional CSS fallbacks
                const fallbackCSS = document.createElement('style');
                fallbackCSS.textContent = `
                    .fas, .far, .fab { 
                        font-family: "Font Awesome 6 Free", "Font Awesome 5 Free", sans-serif !important; 
                        font-weight: 900 !important;
                    }
                    .far { font-weight: 400 !important; }
                    .fab { font-family: "Font Awesome 6 Brands", "Font Awesome 5 Brands", sans-serif !important; }
                `;
                document.head.appendChild(fallbackCSS);
                
                // Try loading from additional CDN
                const fallbackLink = document.createElement('link');
                fallbackLink.rel = 'stylesheet';
                fallbackLink.href = 'https://maxcdn.bootstrapcdn.com/font-awesome/6.0.0/css/all.min.css';
                fallbackLink.crossOrigin = 'anonymous';
                document.head.appendChild(fallbackLink);
            } else {
                console.log('Font Awesome loaded successfully');
            }
            
            // Force refresh of icon rendering after a short delay
            setTimeout(() => {
                const allIcons = document.querySelectorAll('.fas, .far, .fab');
                allIcons.forEach(icon => {
                    icon.style.fontFamily = '"Font Awesome 6 Free", "Font Awesome 6 Pro", "Font Awesome 5 Free", "Font Awesome 5 Pro", "FontAwesome", sans-serif';
                });
            }, 500);
            
            // Ensure DataTables are properly initialized
            setTimeout(() => {
                if (typeof $.fn.DataTable !== 'undefined') {
                    // Reinitialize any DataTables that might not have loaded properly
                    $('table[id$="-table"]').each(function() {
                        if (!$.fn.DataTable.isDataTable(this)) {
                            console.log('Reinitializing DataTable for:', this.id);
                            $(this).DataTable({
                                "pageLength": 10,
                                "ordering": true,
                                "info": true,
                                "responsive": true,
                                "autoWidth": false,
                                "language": {
                                    "search": "",
                                    "searchPlaceholder": "Search repository...",
                                    "paginate": {
                                        "previous": "<i class='fas fa-chevron-left'></i>",
                                        "next": "<i class='fas fa-chevron-right'></i>"
                                    }
                                }
                            });
                        }
                    });
                }
            }, 1000);
        });
    </script>
</head>
<body>
    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <div style="display: flex; align-items: center; gap: 0.75rem; flex: 1; overflow: hidden;">
                    @if(isset($settings['site_logo']))
                        <img src="{{ asset($settings['site_logo']) }}" alt="Logo" style="height: 32px; width: auto; object-fit: contain;">
                    @else
                        <i class="fas fa-bolt text-primary"></i>
                    @endif
                    <span style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $settings['site_name'] ?? 'TrackGo' }}</span>
                </div>
                <div id="sidebar-collapse-btn" class="collapse-toggle" title="Toggle Sidebar">
                    <i class="fas fa-bars-staggered"></i>
                </div>
            </div>
            
            <nav class="sidebar-nav">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-grid-2"></i> <span>Dashboard</span>
                </a>
                
                <div class="sidebar-label">Page Builders</div>
                
                <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <i class="fas fa-boxes-stacked"></i> <span>Product Builder</span>
                </a>
                <a href="{{ route('admin.pages.index') }}" class="nav-link {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}">
                    <i class="fas fa-file-invoice"></i> <span>Page Builder</span>
                </a>
                <a href="{{ route('admin.blogs.index') }}" class="nav-link {{ request()->routeIs('admin.blogs.*') ? 'active' : '' }}">
                    <i class="fas fa-pen-nib"></i> <span>Blog Builder</span>
                </a>
                
                <div class="sidebar-label"><span>Content</span></div>
                <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <i class="fas fa-tags"></i> <span>Categories</span>
                </a>
                <a href="{{ route('admin.brands.index') }}" class="nav-link {{ request()->routeIs('admin.brands.*') ? 'active' : '' }}">
                    <i class="fas fa-star"></i> <span>Brands</span>
                </a>
                <a href="{{ route('admin.banners.index') }}" class="nav-link {{ request()->routeIs('admin.banners.*') ? 'active' : '' }}">
                    <i class="fas fa-flag"></i> <span>Home Banners</span>
                </a>
                <a href="{{ route('admin.plans.index') }}" class="nav-link {{ request()->routeIs('admin.plans.*') ? 'active' : '' }}">
                    <i class="fas fa-layer-group"></i> <span>Pricing Plans</span>
                </a>
                <a href="{{ route('admin.faqs.index') }}" class="nav-link {{ request()->routeIs('admin.faqs.*') ? 'active' : '' }}">
                    <i class="fas fa-question-circle"></i> <span>FAQs</span>
                </a>
                <a href="{{ route('admin.reviews.index') }}" class="nav-link {{ request()->routeIs('admin.reviews.index') ? 'active' : '' }}">
                    <i class="fas fa-star"></i> <span>Product Reviews</span>
                </a>
                <a href="{{ route('admin.gallery.index') }}" class="nav-link {{ request()->routeIs('admin.gallery.*') ? 'active' : '' }}">
                    <i class="fas fa-images"></i> <span>Gallery</span>
                </a>
                <a href="{{ route('admin.gallery-categories.index') }}" class="nav-link {{ request()->routeIs('admin.gallery-categories.*') ? 'active' : '' }}">
                    <i class="fas fa-folder-tree"></i> <span>Gallery Categories</span>
                </a>

                <div class="sidebar-label"><span>Management</span></div>
                
                <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <i class="fas fa-bag-shopping"></i> <span>Orders</span>
                </a>
                <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="fas fa-user-group"></i> <span>Customers</span>
                </a>
                <a href="{{ route('admin.subscriptions.index') }}" class="nav-link {{ request()->routeIs('admin.subscriptions.*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-check"></i> <span>Subscription Manager</span>
                </a>
                <a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <i class="fas fa-sliders"></i> <span>Settings</span>
                </a>
            </nav>

            <div style="margin-top: auto; padding-top: 2rem;">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="nav-link" style="width: 100%; background: none; border: none; cursor: pointer; color: #ef4444;">
                        <i class="fas fa-arrow-right-from-bracket"></i> <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header class="top-header">
                <div>
                    <div style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.85rem; font-weight: 500;">
                        <span style="color: var(--text-light)">Admin</span>
                        <i class="fas fa-chevron-right" style="font-size: 0.6rem; color: var(--text-light)"></i>
                        <span style="color: var(--primary); font-weight: 600;">{{ Str::title(request()->segment(2) ?? 'Dashboard') }}</span>
                    </div>
                </div>

                <div style="display: flex; align-items: center; gap: 1rem;">
                    <button id="theme-toggle" class="btn btn-secondary" title="Toggle Sidebar Theme" style="padding: 0; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; border-radius: 50%; box-shadow: none; border-color: transparent;">
                        <i class="fas fa-sidebar" id="theme-icon" style="color: var(--text-muted);"></i>
                    </button>
                    <!-- Notification Bell Placeholder -->
                    <button class="btn btn-secondary" style="padding: 0; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; border-radius: 50%; box-shadow: none; border-color: transparent;">
                        <i class="fas fa-bell" style="color: var(--text-muted);"></i>
                    </button>
                    
                    <div class="user-profile-trigger">
                        <div style="text-align: right;">
                            <div style="font-size: 0.85rem; font-weight: 600; color: var(--text-main);">{{ auth()->user()->name }}</div>
                            <div style="font-size: 0.75rem; color: var(--text-muted);">Master Admin</div>
                        </div>
                        <div style="width: 40px; height: 40px; border-radius: 10px; background: linear-gradient(135deg, var(--primary), var(--accent)); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 1rem; box-shadow: var(--shadow-primary);">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    </div>
                </div>
            </header>

            <div class="page-content">
                @if(session('success'))
                    <div style="background: #ecfdf5; color: #047857; padding: 1rem 1.5rem; border-radius: var(--radius-md); margin-bottom: 2rem; border-left: 4px solid #10b981; display: flex; align-items: center; gap: 1rem; font-weight: 500; box-shadow: var(--shadow-sm);">
                         <i class="fas fa-circle-check" style="font-size: 1.25rem; color: #10b981;"></i> {{ session('success') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <script>
        $(document).ready(function() {
            try {
                const themeToggle = document.getElementById('theme-toggle');
                const sidebarBtn = document.getElementById('sidebar-collapse-btn');
                const sidebar = document.querySelector('.sidebar');
                const html = document.documentElement;

                if (themeToggle) {
                    themeToggle.addEventListener('click', () => {
                        try {
                            const currentSidebar = html.getAttribute('data-sidebar');
                            const newTheme = currentSidebar === 'light' ? 'dark' : 'light';
                            
                            html.setAttribute('data-sidebar', newTheme);
                            localStorage.setItem('sidebar-theme', newTheme);
                        } catch (e) {
                            console.warn('Theme toggle error:', e);
                        }
                    });
                }

                if (sidebarBtn && sidebar) {
                    sidebarBtn.addEventListener('click', () => {
                        try {
                            sidebar.classList.toggle('collapsed');
                            localStorage.setItem('sidebar-collapsed', sidebar.classList.contains('collapsed'));
                        } catch (e) {
                            console.warn('Sidebar toggle error:', e);
                        }
                    });
                }
            } catch (error) {
                console.warn('Admin script initialization error:', error);
            }
        });
    </script>
</body>
</html>
