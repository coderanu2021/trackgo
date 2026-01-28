<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', $settings['site_name'] ?? 'TrackGo')</title>
    @if(isset($settings['site_favicon']))
        <link rel="icon" type="image/x-icon" href="{{ asset($settings['site_favicon']) }}">
    @endif
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /* Cache buster: {{ time() }} */
        /* Debug: Primary={{ $settings['site_primary_color'] ?? 'NOT_SET' }}, Secondary={{ $settings['site_secondary_color'] ?? 'NOT_SET' }} */
        :root {
            /* Dynamic Colors from Admin Settings */
            --primary: {{ $settings['site_primary_color'] ?? '#f37021' }}; /* Primary Color */
            --primary-dark: #d65d14; /* Keep static for now */
            --secondary: #1a1a1a; /* Force black for headings - ignore admin setting */
            --text-main: #333333;
            --text-muted: #666666;
            --white: #ffffff;
            --border: #e5e5e5;
            --border-soft: #f1f5f9;
            --transition: all 0.3s ease;
            
            /* Layout variables */
            --radius-sm: 6px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --shadow-sm: 0 2px 8px rgba(0,0,0,0.05);
            --shadow-lg: 0 10px 30px rgba(0,0,0,0.1);
            --bg-light: #f8fafc;
            --text-light: #94a3b8;
            --primary-soft: rgba(243, 112, 33, 0.1);
            
            /* Separate variable for navigation background */
            --nav-bg: {{ $settings['site_secondary_color'] ?? '#1a1a1a' }}; /* This can be dynamic */
        }

        body { font-family: 'Inter', sans-serif; color: var(--text-main); }
        a { text-decoration: none; color: inherit; transition: var(--transition); }
        ul { list-style: none; padding: 0; margin: 0; }
        
        .container { max-width: 1400px; margin: 0 auto; padding: 0 15px; }


        
        /* 2. MIDDLE HEADER (Logo & Search) */
        .header-middle {
            padding: 25px 0;
            background: var(--white);
        }
        .hm-flex {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 30px;
        }
        .logo img { height: 45px; }
        
        /* Search Box */
        .zenis-search {
            flex: 1;
            max-width: 700px;
            position: relative;
        }
        .search-form {
            display: flex;
            border: 2px solid var(--primary);
            border-radius: 50px;
            overflow: hidden;
            height: 50px;
        }
        .cat-select {
            background: #f5f5f5;
            border: none;
            padding: 0 15px;
            border-right: 1px solid #ddd;
            color: var(--text-main);
            font-weight: 500;
            outline: none;
            cursor: pointer;
            display: none; /* Hidden on smaller screens */
        }
        .search-input {
            flex: 1;
            border: none;
            padding: 0 20px;
            font-size: 15px;
            outline: none;
        }
        .search-btn {
            background: var(--primary);
            color: white;
            border: none;
            padding: 0 30px;
            font-weight: 600;
            text-transform: uppercase;
            cursor: pointer;
            transition: 0.3s;
        }
        .search-btn:hover { background: var(--primary-dark); }

        /* Header Icons */
        .header-icons { display: flex; gap: 25px; align-items: center; }
        .icon-box {
            display: flex;
            flex-direction: column;
            align-items: center;
            font-size: 12px;
            color: var(--text-main);
            position: relative;
        }
        .icon-wrap {
            position: relative;
            font-size: 24px;
            margin-bottom: 2px;
            color: var(--secondary);
        }
        .icon-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: var(--primary);
            color: white;
            font-size: 10px;
            height: 18px;
            width: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }
        .icon-box:hover .icon-wrap { color: var(--primary); }

        /* 3. BOTTOM NAVBAR (Yellow/Primary or Dark) */
        .header-bottom {
            background: var(--nav-bg); /* Use separate variable for navigation */
            color: white;
            position: relative;
        }
        .hb-flex { display: flex; align-items: stretch; height: 50px; } /* Stretch items to full height */
        
        /* Vertical Menu Toggle */
        .vertical-menu-btn {
            background: var(--primary);
            color: white;
            width: 260px;
            padding: 0 20px;
            font-weight: 700;
            text-transform: uppercase;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            position: relative;
            flex-shrink: 0;
            transition: all 0.3s ease;
            height: 50px;
        }
        
        .vertical-menu-btn:hover {
            background: var(--primary-dark);
        }
        
        /* Simple Category Dropdown */
        .category-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            width: 260px;
            background: white;
            border: 1px solid var(--border);
            border-top: none;
            border-radius: 0 0 var(--radius-md) var(--radius-md);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            z-index: 1000;
            max-height: 400px;
            overflow-y: auto;
        }
        
        .cat-dropdown-list {
            display: flex;
            flex-direction: column;
        }
        
        .cat-dropdown-link {
            padding: 0.85rem 1rem;
            border-bottom: 1px solid var(--border);
            font-size: 0.9rem;
            color: var(--text-main);
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: 0.2s;
        }
        
        .cat-dropdown-link:last-child { 
            border-bottom: none; 
        }
        
        .cat-dropdown-link:hover {
            background: #f9f9f9;
            color: var(--primary);
            padding-left: 1.25rem;
        }
        
        /* Arrow rotation */
        .vertical-menu-btn.active #category-arrow {
            transform: rotate(180deg);
        }
        
        /* Main Menu */
        .main-menu { display: flex; gap: 10px; align-items: center; height: 100%; } /* Align-items center for links inside the bar */
        .menu-link {
            display: block;
            padding: 15px 20px;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 14px;
            color: #443e3e;
            position: relative;
        }
        .menu-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 3px;
            background: var(--primary);
            transition: 0.3s;
        }
        .menu-link:hover { color: var(--primary); }
        .menu-link:hover::after { width: 100%; }

        /* Responsive */
        @media (min-width: 993px) {
            .cat-select { display: block; }
        }
        @media (max-width: 992px) {
            .top-bar { display: none; }
            .header-bottom { display: none; } /* Mobile Menu converts this */
            .zenis-search { margin: 0 10px; order: 3; width: 100%; max-width: 100%; margin-top: 15px; }
            .hm-flex { flex-wrap: wrap; }
            .logo { order: 1; }
            .header-icons { order: 2; margin-left: auto; }
        }

        /* Footer - Always Dark */
        footer {
            background-color: #1a1a1a; /* Always dark, ignore admin setting */
            color: #b0b0b0;
            padding: 5rem 0 2rem;
            font-size: 0.95rem;
        }
        .footer-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 3rem;
            margin-bottom: 3rem;
        }
        @media (max-width: 992px) {
            .footer-grid { grid-template-columns: repeat(2, 1fr); gap: 2rem; }
        }
        @media (max-width: 576px) {
            .footer-grid { grid-template-columns: 1fr; }
        }
        .footer-title {
            color: white;
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            font-size: 1.25rem;
            margin-bottom: 1.5rem;
        }
        .footer-links li {
            margin-bottom: 0.85rem;
            transition: 0.3s;
        }
        .footer-links a:hover {
            color: var(--primary);
            padding-left: 5px;
        }
        .social-icon {
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.05);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: 0.3s;
            color: white;
        }
        .social-icon:hover {
            background: var(--primary);
            transform: translateY(-3px);
        }
    </style>
    @stack('styles')
</head>
<body>



    <!-- 2. Middle Header -->
    <div class="header-middle">
        <div class="container hm-flex">
            <!-- Logo -->
            <a href="{{ url('/') }}" class="logo">
                @if(isset($settings['site_logo']))
                    <img src="{{ asset($settings['site_logo']) }}" alt="{{ $settings['site_name'] }}">
                @else
                    <h2 style="font-family:'Outfit'; font-weight:800; font-size:32px; margin:0; color:var(--secondary);">
                        Zenis<span style="color:var(--primary);">.</span>
                    </h2>
                @endif
            </a>

            <!-- Search Bar -->
            <div class="zenis-search">
                <form action="#" class="search-form">
                    <select class="cat-select">
                        <option>All Categories</option>
                        <option>Electronics</option>
                        <option>Fashion</option>
                    </select>
                    <input type="text" class="search-input" placeholder="Search for products...">
                    <button type="submit" class="search-btn">Search</button>
                </form>
            </div>

            <!-- Icons -->
            <div class="header-icons">
                @guest
                <a href="{{ route('login') }}" class="icon-box">
                    <div class="icon-wrap"><i class="far fa-user"></i></div>
                    <span style="font-weight:600;">Account</span>
                </a>
                @else
                <a href="{{ Auth::user()->isAdmin() ? route('admin.dashboard') : route('customer.dashboard') }}" class="icon-box">
                    <div class="icon-wrap"><i class="fas fa-user-circle"></i></div>
                    <span style="font-weight:600;">{{ Str::limit(Auth::user()->name, 8) }}</span>
                </a>
                @endguest
                
                <a href="#" class="icon-box">
                    <div class="icon-wrap">
                        <i class="far fa-heart"></i>
                        <span class="icon-badge">0</span>
                    </div>
                    <span style="font-weight:600;">Wishlist</span>
                </a>

                <a href="{{ route('cart.index') }}" class="icon-box">
                    <div class="icon-wrap">
                        <i class="fas fa-shopping-bag"></i>
                        <span class="icon-badge">{{ count(session()->get('cart', [])) }}</span>
                    </div>
                    <span style="font-weight:600;">My Cart</span>
                </a>
            </div>
        </div>
    </div>

    <!-- 3. Bottom Navigation -->
    <div class="header-bottom">
        <div class="container hb-flex">
            <!-- Vertical Menu Button (No dropdown) -->
            <div class="vertical-menu-btn">
                <span><i class="fas fa-bars" style="margin-right:10px;"></i> All Categories</span>
                <i class="fas fa-angle-down"></i>
            </div>

            <!-- Main Nav -->
            <ul class="main-menu">
                <li><a href="{{ url('/') }}" class="menu-link">Home</a></li>
                <li><a href="{{ route('shop') }}" class="menu-link">Shop</a></li>
                <li><a href="{{ route('blogs.index') }}" class="menu-link">Blog</a></li>
                <li><a href="{{ route('about') }}" class="menu-link">About Us</a></li>
                <li><a href="{{ route('contact') }}" class="menu-link">Contact</a></li>
                <li style="margin-left:20px; color:var(--primary); font-weight:700; padding:15px 0;">
                    <i class="fas fa-tags"></i> SPECIAL OFFER
                </li>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    @yield('content')

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-grid">
                <div>
                    <div class="footer-title">{{ $settings['site_name'] ?? 'TrackGo' }}</div>
                    <p style="line-height: 1.8;">{{ $settings['site_footer_about'] ?? 'Your premium business companion for project and order management tracking.' }}</p>
                    <div class="flex gap-4" style="margin-top:2.5rem;">
                        @php $socials = json_decode($settings['social_links'] ?? '[]', true); @endphp
                        @foreach($socials as $social)
                            <a href="{{ $social['url'] }}" target="_blank" class="social-icon" title="{{ $social['platform'] }}">
                                <i class="fab fa-{{ strtolower($social['platform']) }}"></i>
                            </a>
                        @endforeach
                    </div>
                </div>
                <div>
                    <div class="footer-title">Quick Explore</div>
                    <ul class="footer-links">
                        @php $quickLinks = json_decode($settings['footer_quick_links'] ?? '[]', true); @endphp
                        @forelse($quickLinks as $link)
                            <li><a href="{{ $link['url'] }}">{{ $link['label'] }}</a></li>
                        @empty
                            <li><a href="{{ url('/') }}">Home Portal</a></li>
                            <li><a href="{{ route('pricing') }}">Strategic Pricing</a></li>
                            <li><a href="{{ route('faqs') }}">Knowledge Base</a></li>
                            <li><a href="{{ route('about') }}">Who We Are</a></li>
                            <li><a href="{{ route('contact') }}">Support Center</a></li>
                        @endforelse
                    </ul>
                </div>
                <div>
                    <div class="footer-title">Company</div>
                    <ul class="footer-links">
                        @php $companyLinks = json_decode($settings['footer_company_links'] ?? '[]', true); @endphp
                        @forelse($companyLinks as $link)
                            <li><a href="{{ $link['url'] }}">{{ $link['label'] }}</a></li>
                        @empty
                            <li><a href="#">Career Opportunities</a></li>
                            <li><a href="#">Privacy Framework</a></li>
                            <li><a href="#">Legal Terms</a></li>
                        @endforelse
                    </ul>
                </div>
                <div>
                    <div class="footer-title">Contact</div>
                    <ul class="footer-links">
                        <li style="display:flex; gap:1rem;"><i class="fas fa-location-dot" style="margin-top:0.4rem; color: var(--primary);"></i> {{ $settings['site_address'] ?? '123 Business St, Suite 100' }}</li>
                        <li style="display:flex; gap:1rem;"><i class="fas fa-envelope" style="margin-top:0.4rem; color: var(--primary);"></i> {{ $settings['site_email'] ?? 'support@trackgo.com' }}</li>
                        <li style="display:flex; gap:1rem;"><i class="fas fa-phone" style="margin-top:0.4rem; color: var(--primary);"></i> {{ $settings['site_phone'] ?? '+1 234 567 890' }}</li>
                    </ul>
                </div>
            </div>
            <div style="text-align:center; padding-top:2.5rem; border-top:1px solid rgba(255,255,255,0.1); font-size:0.9rem; letter-spacing: 0.02em;">
                &copy; {{ date('Y') }} {{ $settings['site_name'] ?? 'TrackGo' }}. Crafted with Precision in the Digital Forge.
            </div>
        </div>
    </footer>

    <script>
        function toggleMobileMenu() {
            try {
                const navLinks = document.querySelector('.nav-links');
                const overlay = document.querySelector('.mobile-overlay');
                if (navLinks) navLinks.classList.toggle('active');
                if (overlay) overlay.classList.toggle('active');
                document.body.style.overflow = document.body.style.overflow === 'hidden' ? 'auto' : 'hidden';
            } catch (e) {
                console.warn('Mobile menu toggle error:', e);
            }
        }

        function toggleMobileSearch() {
            try {
                const searchContainer = document.querySelector('.search-container');
                if (searchContainer) searchContainer.classList.toggle('active');
            } catch (e) {
                console.warn('Mobile search toggle error:', e);
            }
        }

        function toggleUserMenu() {
            try {
                const menu = document.getElementById('user-dropdown');
                if (menu) menu.classList.toggle('active');
            } catch (e) {
                console.warn('User menu toggle error:', e);
            }
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            try {
                const container = document.querySelector('.user-menu-container');
                const menu = document.getElementById('user-dropdown');
                if (container && menu && !container.contains(event.target) && menu.classList.contains('active')) {
                    menu.classList.remove('active');
                }
            } catch (e) {
                console.warn('Dropdown close error:', e);
            }
        });

        $(document).ready(function() {
            try {
                // Header scroll effect
                $(window).scroll(function() {
                    try {
                        if ($(this).scrollTop() > 50) {
                            $('.header-main').addClass('scrolled');
                        } else {
                            $('.header-main').removeClass('scrolled');
                        }
                    } catch (e) {
                        console.warn('Scroll effect error:', e);
                    }
                });

            } catch (error) {
                console.warn('Script initialization error:', error);
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
