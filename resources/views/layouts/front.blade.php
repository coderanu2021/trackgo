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

        body { font-family: 'Inter', sans-serif; color: var(--text-main);margin:0px; }
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
            min-width: 150px;
        }
        
        .cat-select option {
            padding: 8px 12px;
            color: var(--text-main);
        }
        
        .cat-select option[value^=""] {
            font-weight: 600;
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
            background: linear-gradient(135deg, var(--primary-soft), rgba(243, 112, 33, 0.05));
            color: var(--primary);
            padding-left: 1.25rem;
            transform: translateX(2px);
        }
        
        .cat-dropdown-link i {
            transition: all 0.2s ease;
        }
        
        .cat-dropdown-link:hover i {
            transform: scale(1.1);
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
            background: linear-gradient(rgba(26, 26, 26, 0.85), rgba(26, 26, 26, 0.85)), url('/uploads/footer_bg.jpg') center/cover no-repeat;
            color: #b0b0b0;
            padding: 5rem 0 2rem;
            font-size: 0.95rem;
            position: relative;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        
        footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(26, 26, 26, 0.9), rgba(26, 26, 26, 0.8));
            z-index: 1;
        }
        
        footer .container {
            position: relative;
            z-index: 2;
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

        /* Global Notification Styles */
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
            padding: 1rem 1.5rem;
            z-index: 10000;
            transform: translateX(400px);
            opacity: 0;
            transition: all 0.3s ease;
            border-left: 4px solid var(--primary);
        }

        .notification.show {
            transform: translateX(0);
            opacity: 1;
        }

        .notification-success {
            border-left-color: var(--success);
        }

        .notification-error {
            border-left-color: var(--error);
        }

        .notification-content {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 600;
            color: var(--text-main);
        }

        .notification-success .notification-content i {
            color: var(--success);
        }

        .notification-error .notification-content i {
            color: var(--error);
        }

        /* Button loading states */
        button:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        .add-cart-btn:disabled,
        .btn-cart-inline:disabled,
        .btn-large:disabled {
            pointer-events: none;
        }

        /* Product Action Icon Buttons */
        .product-actions-inline {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
            margin-top: 1rem;
        }

        .btn-cart-icon,
        .btn-wishlist-icon,
        .btn-view-icon {
            width: 40px;
            height: 40px;
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.9rem;
            text-decoration: none;
        }

        .btn-cart-icon {
            background: var(--primary);
            color: white;
        }

        .btn-cart-icon:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(243, 112, 33, 0.3);
        }

        .btn-wishlist-icon {
            background: rgba(239, 68, 68, 0.1);
            color: var(--error);
        }

        .btn-wishlist-icon:hover {
            background: var(--error);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        .btn-view-icon {
            background: rgba(99, 102, 241, 0.1);
            color: var(--info);
        }

        .btn-view-icon:hover {
            background: var(--info);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }

        /* Product overlay buttons (for hover effect) */
        .product-overlay .btn-icon {
            width: 35px;
            height: 35px;
            background: rgba(255, 255, 255, 0.95);
            color: var(--text-main);
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.85rem;
            text-decoration: none;
        }

        .product-overlay .btn-icon:hover {
            background: var(--primary);
            color: white;
            transform: scale(1.1);
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
                <form action="{{ route('shop') }}" method="GET" class="search-form">
                    <select class="cat-select" name="category">
                        <option value="">All Categories</option>
                        @foreach($categories_global as $category)
                            @if($category->parent_id == null)
                                <!-- Parent Category -->
                                <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                <!-- Child Categories -->
                                @foreach($category->children as $child)
                                    <option value="{{ $child->slug }}" {{ request('category') == $child->slug ? 'selected' : '' }}>
                                        &nbsp;&nbsp;→ {{ $child->name }}
                                    </option>
                                @endforeach
                            @endif
                        @endforeach
                    </select>
                    <input type="text" class="search-input" name="search" value="{{ request('search') }}" placeholder="Search for products...">
                    <button type="submit" class="search-btn">Search</button>
                </form>
            </div>

            <!-- Icons -->
            <div class="header-icons">
                @guest
                <a href="{{ route('whatsapp.login') }}" class="icon-box">
                    <div class="icon-wrap"><i class="fab fa-whatsapp"></i></div>
                    <span style="font-weight:600;">Login</span>
                </a>
                @else
                <a href="{{ Auth::user()->isAdmin() ? route('admin.dashboard') : route('customer.dashboard') }}" class="icon-box">
                    <div class="icon-wrap"><i class="fas fa-user-circle"></i></div>
                    <span style="font-weight:600;">{{ Str::limit(Auth::user()->name, 8) }}</span>
                </a>
                @endguest
                
                <a href="{{ route('wishlist.index') }}" class="icon-box">
                    <div class="icon-wrap">
                        <i class="far fa-heart"></i>
                        <span class="icon-badge">{{ count(session()->get('wishlist', [])) }}</span>
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
            <!-- Vertical Menu Button with Categories Dropdown -->
            <div class="vertical-menu-btn" onclick="toggleCategoryDropdown()">
                <span><i class="fas fa-bars" style="margin-right:10px;"></i> All Categories</span>
                <i class="fas fa-angle-down" id="category-arrow"></i>
                
                <!-- Category Dropdown -->
                <div class="category-dropdown" id="category-dropdown" style="display: none;">
                    <div class="cat-dropdown-list">
                        @foreach($categories_global as $category)
                            @if($category->parent_id == null)
                                <!-- Parent Category -->
                                <a href="{{ route('category.show', $category->slug) }}" class="cat-dropdown-link">
                                    @if($category->icon)
                                        <i class="{{ $category->icon }}" style="margin-right: 8px; color: var(--primary);"></i>
                                    @endif
                                    {{ $category->name }}
                                    @if($category->children->count() > 0)
                                        <i class="fas fa-angle-right" style="font-size: 0.8rem; color: var(--text-muted);"></i>
                                    @endif
                                </a>
                                <!-- Child Categories -->
                                @foreach($category->children as $child)
                                    <a href="{{ route('category.show', $child->slug) }}" class="cat-dropdown-link" style="padding-left: 2rem; font-size: 0.85rem;">
                                        @if($child->icon)
                                            <i class="{{ $child->icon }}" style="margin-right: 8px; color: var(--primary);"></i>
                                        @else
                                            <i class="fas fa-arrow-right" style="margin-right: 8px; color: var(--text-muted); font-size: 0.7rem;"></i>
                                        @endif
                                        {{ $child->name }}
                                    </a>
                                @endforeach
                            @endif
                        @endforeach
                    </div>
                </div>
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

        function toggleCategoryDropdown() {
            try {
                const dropdown = document.getElementById('category-dropdown');
                const arrow = document.getElementById('category-arrow');
                const button = document.querySelector('.vertical-menu-btn');
                
                if (dropdown.style.display === 'none' || dropdown.style.display === '') {
                    dropdown.style.display = 'block';
                    arrow.style.transform = 'rotate(180deg)';
                    button.classList.add('active');
                } else {
                    dropdown.style.display = 'none';
                    arrow.style.transform = 'rotate(0deg)';
                    button.classList.remove('active');
                }
            } catch (e) {
                console.warn('Category dropdown toggle error:', e);
            }
        }

        // Close category dropdown when clicking outside
        document.addEventListener('click', function(event) {
            try {
                const button = document.querySelector('.vertical-menu-btn');
                const dropdown = document.getElementById('category-dropdown');
                const arrow = document.getElementById('category-arrow');
                
                if (button && dropdown && !button.contains(event.target)) {
                    dropdown.style.display = 'none';
                    arrow.style.transform = 'rotate(0deg)';
                    button.classList.remove('active');
                }
            } catch (e) {
                console.warn('Category dropdown close error:', e);
            }
        });

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

                // Category dropdown hover enhancement
                $('.vertical-menu-btn').hover(
                    function() {
                        $(this).find('#category-arrow').addClass('rotated');
                    },
                    function() {
                        $(this).find('#category-arrow').removeClass('rotated');
                    }
                );

            } catch (error) {
                console.warn('Script initialization error:', error);
            }
        });

        // Global AJAX Add to Cart Function
        function addToCartAjax(productId) {
            // Show loading state
            const button = event.target.closest('button') || event.target.closest('a');
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
            button.disabled = true;

            // AJAX request to add to cart
            fetch(`/cart/add/${productId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update cart count in header
                    const cartBadge = document.querySelector('.icon-badge');
                    if (cartBadge) {
                        cartBadge.textContent = data.cart_count;
                    }

                    // Show success message
                    showNotification('success', data.message);

                    // Reset button
                    button.innerHTML = '<i class="fas fa-check"></i> Added!';
                    button.style.background = 'var(--success)';
                    
                    setTimeout(() => {
                        button.innerHTML = originalText;
                        button.style.background = '';
                        button.disabled = false;
                    }, 2000);
                } else {
                    throw new Error(data.message || 'Failed to add to cart');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('error', 'Failed to add product to cart. Please try again.');
                
                // Reset button
                button.innerHTML = originalText;
                button.disabled = false;
            });
        }

        // Global AJAX Add to Wishlist Function
        function addToWishlistAjax(productId) {
            // Show loading state
            const button = event.target.closest('button') || event.target.closest('a');
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            button.disabled = true;

            // AJAX request to add to wishlist
            fetch(`/wishlist/add/${productId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update wishlist count in header
                    const wishlistBadge = document.querySelector('.icon-badge');
                    if (wishlistBadge && wishlistBadge.closest('.icon-box').querySelector('.fa-heart')) {
                        wishlistBadge.textContent = data.wishlist_count;
                    }

                    // Show success message
                    showNotification('success', data.message);

                    // Change button to filled heart
                    button.innerHTML = '<i class="fas fa-heart"></i>';
                    button.style.color = 'var(--error)';
                    button.title = 'Added to Wishlist';
                    
                    setTimeout(() => {
                        button.disabled = false;
                    }, 1000);
                } else {
                    throw new Error(data.message || 'Failed to add to wishlist');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('error', 'Failed to add product to wishlist. Please try again.');
                
                // Reset button
                button.innerHTML = originalText;
                button.disabled = false;
            });
        }

        // Global AJAX Remove from Wishlist Function
        function removeFromWishlistAjax(productId) {
            // Show loading state
            const button = event.target.closest('button');
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            button.disabled = true;

            // AJAX request to remove from wishlist
            fetch(`/wishlist/remove`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({id: productId})
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update wishlist count in header
                    const wishlistBadge = document.querySelector('.icon-badge');
                    if (wishlistBadge && wishlistBadge.closest('.icon-box').querySelector('.fa-heart')) {
                        wishlistBadge.textContent = data.wishlist_count;
                    }

                    // Show success message
                    showNotification('success', data.message);

                    // Remove the item from the page
                    const wishlistItem = button.closest('.wishlist-item');
                    if (wishlistItem) {
                        wishlistItem.style.opacity = '0';
                        wishlistItem.style.transform = 'scale(0.8)';
                        setTimeout(() => {
                            wishlistItem.remove();
                            
                            // Check if wishlist is empty
                            const remainingItems = document.querySelectorAll('.wishlist-item');
                            if (remainingItems.length === 0) {
                                location.reload(); // Reload to show empty state
                            }
                        }, 300);
                    }
                } else {
                    throw new Error(data.message || 'Failed to remove from wishlist');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('error', 'Failed to remove product from wishlist. Please try again.');
                
                // Reset button
                button.innerHTML = originalText;
                button.disabled = false;
            });
        }

        // Global Notification function
        function showNotification(type, message) {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `notification notification-${type}`;
            notification.innerHTML = `
                <div class="notification-content">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
                    <span>${message}</span>
                </div>
            `;
            
            // Add to page
            document.body.appendChild(notification);
            
            // Show notification
            setTimeout(() => notification.classList.add('show'), 100);
            
            // Hide and remove notification
            setTimeout(() => {
                notification.classList.remove('show');
                setTimeout(() => document.body.removeChild(notification), 300);
            }, 3000);
        }
    </script>
    @stack('scripts')
</body>
</html>
