<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', $settings['site_name'] ?? 'TrackGo')</title>
    @if(isset($settings['site_favicon']))
        <link rel="icon" type="image/x-icon" href="{{ asset($settings['site_favicon']) }}">
    @endif
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        :root {
            --primary: {{ $settings['site_primary_color'] ?? '#f37021' }};
            --primary-dark: {{ $settings['site_primary_color_dark'] ?? '#d45e12' }};
            --primary-soft: {{ $settings['site_primary_color_soft'] ?? 'rgba(243, 112, 33, 0.1)' }};
            --secondary: {{ $settings['site_secondary_color'] ?? '#2d2e32' }};
            --secondary-dark: #1a1b1e;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --text-light: #94a3b8;
            --bg-light: #f8fafc;
            --white: #ffffff;
            --border: #e2e8f0;
            --border-soft: #f1f5f9;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 10px 15px -3px rgb(0 0 0 / 0.04);
            --shadow-lg: 0 20px 25px -5px rgb(0 0 0 / 0.05);
            --radius-md: 14px;
            --radius-lg: 24px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            color: var(--text-main);
            background-color: var(--white);
            overflow-x: hidden;
        }

        h1, h2, h3, .logo { font-family: 'Outfit', sans-serif; }
        
        a { text-decoration: none; color: inherit; transition: all 0.3s ease; }
        ul { list-style: none; padding: 0; margin: 0; }
        
        .container {
            max-width: 1300px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        @media (max-width: 768px) {
            .container { padding: 0 1rem; }
        }

        .flex { display: flex; }
        .items-center { align-items: center; }
        .justify-between { justify-content: space-between; }
        .gap-4 { gap: 1rem; }

        .btn {
            padding: 0.875rem 1.75rem;
            border-radius: var(--radius-md);
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        .btn-primary { background: var(--primary); color: white; }
        .btn-primary:hover { background: var(--primary-dark); transform: translateY(-2px); box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.3); }

        /* Navigation */
        .top-bar {
            background: var(--secondary);
            color: rgba(255,255,255,0.7);
            padding: 0.75rem 0;
            font-size: 0.8rem;
            font-weight: 500;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            letter-spacing: 0.02em;
        }
        .top-bar-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-main {
            padding: 1rem 0;
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 1px solid var(--border);
            transition: var(--transition);
        }
        .header-main.scrolled {
            padding: 0.75rem 0;
            box-shadow: var(--shadow-md);
        }

        .logo {
            font-size: 1.85rem;
            font-weight: 900;
            color: var(--secondary);
            letter-spacing: -0.04em;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .logo span { color: var(--primary); }

        .search-container {
            flex: 1;
            max-width: 600px;
            margin: 0 4rem;
            position: relative;
        }
        .search-bar {
            display: flex;
            background: var(--bg-light);
            border: 1.5px solid transparent;
            border-radius: var(--radius-md);
            overflow: hidden;
            transition: var(--transition);
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);
        }
        .search-bar:focus-within { 
            border-color: var(--primary); 
            background: var(--white);
            box-shadow: 0 0 0 4px var(--primary-soft);
        }
        .search-bar input {
            flex: 1;
            padding: 0.85rem 1.5rem;
            border: none;
            background: transparent;
            outline: none;
            font-size: 0.95rem;
            font-weight: 500;
            color: var(--text-main);
        }
        .search-bar input::placeholder { color: var(--text-muted); opacity: 0.8; }
        .search-bar button {
            background: var(--primary);
            color: white;
            border: none;
            padding: 0 1.75rem;
            font-size: 1rem;
            cursor: pointer;
            transition: var(--transition);
        }
        .search-bar button:hover { background: var(--primary-dark); }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 2rem;
        }
        .action-link {
            position: relative;
            font-size: 1.35rem;
            color: var(--secondary);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
        }
        .action-link:hover { color: var(--primary); transform: translateY(-2px); }
        .badge {
            position: absolute;
            top: -6px;
            right: -10px;
            background: var(--primary);
            color: white;
            font-size: 0.65rem;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-weight: 800;
            border: 2px solid var(--white);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        /* Navbar Links */
        .nav-links {
            display: flex;
            gap: 3rem;
        }
        .nav-item {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--secondary);
            padding: 1.15rem 0;
            display: block;
            position: relative;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            opacity: 0.85;
            transition: var(--transition);
        }
        .nav-item:hover { opacity: 1; color: var(--primary); }
        .nav-item::after {
            content: '';
            position: absolute;
            bottom: 0.75rem;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--primary);
            transition: var(--transition);
            border-radius: 2px;
        }
        .nav-item:hover::after { width: 100%; }

        /* Mobile Menu Toggle */
        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--secondary);
            cursor: pointer;
            padding: 0.5rem;
        }

        @media (max-width: 992px) {
            .top-bar { display: none; }
            .search-container { order: 3; margin: 1rem 0 0; max-width: 100%; width: 100%; display: none; }
            .header-main .container { flex-wrap: wrap; }
            .search-container.active { display: block; }
            .mobile-menu-btn { display: block; }
            .header-main { padding: 0.75rem 0; }
            .logo { font-size: 1.5rem; }
            
            .nav-links {
                display: none;
                flex-direction: column;
                gap: 0;
                position: fixed;
                top: 0;
                left: -100%;
                width: 300px;
                height: 100vh;
                background: white;
                z-index: 2000;
                padding: 2rem;
                box-shadow: 20px 0 40px rgba(0,0,0,0.1);
                transition: var(--transition);
            }
            .nav-links.active { display: flex; left: 0; }
            .nav-item { padding: 1.5rem 0; border-bottom: 1px solid var(--border-soft); width: 100%; }
            .nav-item::after { display: none; }
            
            .header-actions { gap: 1rem; }
            .action-link { font-size: 1.2rem; }

            .mobile-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.5);
                z-index: 1500;
                backdrop-filter: blur(5px);
            }
            .mobile-overlay.active { display: block; }

            .search-trigger-mobile { display: block !important; }
        }

        .search-trigger-mobile { display: none; }

        /* Footer */
        footer {
            background: var(--secondary);
            color: #94a3b8;
            padding: 6rem 0 3rem;
            margin-top: 6rem;
        }
        .footer-grid {
            display: grid;
            grid-template-columns: 1.5fr 1fr 1fr 1.2fr;
            gap: 4rem;
            margin-bottom: 4rem;
        }
        .footer-title {
            color: var(--white);
            font-family: 'Outfit', sans-serif;
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 2rem;
        }
        .footer-links li { margin-bottom: 1rem; transition: transform 0.3s; }
        .footer-links li:hover { transform: translateX(5px); }
        .footer-links a:hover { color: var(--white); }
        
        .social-icon {
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            background: rgba(255,255,255,0.05);
            color: white;
            transition: all 0.3s;
            border: 1px solid rgba(255,255,255,0.05);
        }
        .social-icon:hover {
            background: var(--primary);
            border-color: var(--primary);
            transform: translateY(-3px);
            box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.3);
        }

        /* Responsive Grids */
        @media (max-width: 992px) {
            .footer-grid { grid-template-columns: 1fr 1fr; gap: 3rem; }
            .newsletter-grid { grid-template-columns: 1fr !important; gap: 2rem !important; text-align: center; }
            .newsletter-grid form { max-width: 500px; margin: 0 auto; }
        }
        @media (max-width: 640px) {
            .footer-grid { grid-template-columns: 1fr; gap: 2.5rem; text-align: center; }
            .footer-links li { transform: none !important; }
            .footer-links li i { margin-top: 0 !important; }
            .footer-links li { justify-content: center; }
            .social-links { justify-content: center; }
            .flex { justify-content: center; }
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- Top Bar -->
    <div class="top-bar">
        <div class="container top-bar-content">
            <div class="flex gap-4">
                <span>{{ $settings['site_phone'] ?? '+1 234 567 890' }}</span>
                <span>{{ $settings['site_email'] ?? 'support@example.com' }}</span>
            </div>
            <div class="flex gap-4">
                <select style="background:none; color:white; border:none;"><option>English</option></select>
                <select style="background:none; color:white; border:none;"><option>{{ $settings['site_currency'] ?? 'USD' }}</option></select>
            </div>
        </div>
    </div>

    <!-- Header Main -->
    <header class="header-main">
        <div class="container flex items-center justify-between">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <button class="mobile-menu-btn" onclick="toggleMobileMenu()"><i class="fas fa-bars"></i></button>
                <a href="{{ url('/') }}" class="logo">
                    @if(isset($settings['site_logo']))
                        <img src="{{ asset($settings['site_logo']) }}" alt="{{ $settings['site_name'] }}" style="height: 45px; width: auto; object-fit: contain;">
                    @else
                        {{ $settings['site_name'] ?? 'eTrack GO' }}<span>.</span>
                    @endif
                </a>
            </div>
            
            <div class="search-container">
                <form action="#" class="search-bar">
                    <input type="text" placeholder="Search premium projects & products...">
                    <button><i class="fas fa-search"></i></button>
                </form>
            </div>

            <div class="header-actions">
                <button class="action-link search-trigger-mobile" onclick="toggleMobileSearch()" style="background:none; border:none; cursor:pointer;">
                    <i class="fa-solid fa-search"></i>
                </button>
                <a href="{{ route('cart.index') }}" class="action-link">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span class="badge">{{ count(session()->get('cart', [])) }}</span>
                </a>
                @auth
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="action-link" title="Admin Dashboard">
                            <i class="fa-solid fa-user-shield"></i>
                        </a>
                    @else
                        <a href="{{ route('customer.dashboard') }}" class="action-link" title="My Account">
                            <i class="fa-solid fa-user"></i>
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="action-link" title="Sign In">
                        <i class="fa-solid fa-user"></i>
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <div class="mobile-overlay" onclick="toggleMobileMenu()"></div>

    <!-- Navbar -->
    <nav style="background: white; border-bottom: 2px solid var(--border-soft); position: relative; z-index: 10;">
        <div class="container">
            <ul class="nav-links" id="main-nav">
                <div class="mobile-nav-header" style="display: none; padding-bottom: 2rem; border-bottom: 1px solid var(--border-soft); margin-bottom: 1rem; justify-content: space-between; align-items: center;">
                    <div class="logo">Manage<span>.</span></div>
                    <button onclick="toggleMobileMenu()" style="background:none; border:none; font-size: 1.5rem;"><i class="fas fa-times"></i></button>
                </div>
                <script>
                    if(window.innerWidth <= 992) {
                        document.querySelector('.mobile-nav-header').style.display = 'flex';
                    }
                </script>
                @php $menu = json_decode($settings['main_menu'] ?? '[]', true); @endphp
                @forelse($menu as $item)
                    @php 
                        $url = $item['url'] ?? '#';
                        if ($url === '#') {
                            if (strtolower($item['label'] ?? '') === 'shop') $url = route('shop');
                            if (strtolower($item['label'] ?? '') === 'home') $url = url('/');
                        }
                    @endphp
                    <li><a href="{{ $url }}" class="nav-item">{{ $item['label'] }}</a></li>
                @empty
                    <li><a href="{{ url('/') }}" class="nav-item">Home</a></li>
                    <li><a href="{{ route('shop') }}" class="nav-item">Shop</a></li>
                    <li><a href="{{ route('blogs.index') }}" class="nav-item">Blog</a></li>
                    <li><a href="{{ route('reviews.index') }}" class="nav-item">Reviews</a></li>
                    <li><a href="{{ route('pricing') }}" class="nav-item">Pricing</a></li>
                    <li><a href="{{ route('faqs') }}" class="nav-item">FAQs</a></li>
                    <li><a href="{{ route('about') }}" class="nav-item">About Us</a></li>
                    <li><a href="{{ route('contact') }}" class="nav-item">Contact</a></li>
                @endforelse
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    @yield('content')

    <!-- Newsletter Banner -->
    <section style="background: var(--primary); padding: 5rem 0; position: relative; overflow: hidden;">
        <div class="container" style="position: relative; z-index: 2;">
            <div class="newsletter-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: center;">
                <div style="color: white;">
                    <h2 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 1rem; font-family: 'Outfit', sans-serif;">Join the Pulse.</h2>
                    <p style="font-size: 1.15rem; color: rgba(255,255,255,0.8); line-height: 1.6;">
                        Subscribe to our premium newsletter for exclusive insights, early access to projects, and strategic industry updates.
                    </p>
                </div>
                <div>
                    <form id="newsletter-form" style="display: flex; gap: 1rem; background: white; padding: 0.5rem; border-radius: 16px; box-shadow: 0 20px 40px rgba(0,0,0,0.1);">
                        @csrf
                        <input type="email" name="email" placeholder="Enter your email..." 
                               style="flex: 1; border: none; padding: 1rem 1.5rem; border-radius: 12px; font-size: 1rem; outline: none;" required>
                        <button type="submit" class="btn btn-primary" style="padding: 1rem 2rem; border-radius: 12px; font-weight: 800; display: flex; align-items: center; gap: 0.75rem;">
                            SUBSCRIBE
                        </button>
                    </form>
                    <div id="newsletter-message" style="margin-top: 1rem; font-weight: 600; display: none;"></div>
                </div>
            </div>
        </div>
        <!-- Decorative Circle -->
        <div style="position: absolute; top: -50px; right: -50px; width: 300px; height: 300px; background: rgba(255,255,255,0.05); border-radius: 50%;"></div>
    </section>

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
            document.querySelector('.nav-links').classList.toggle('active');
            document.querySelector('.mobile-overlay').classList.toggle('active');
            document.body.style.overflow = document.body.style.overflow === 'hidden' ? 'auto' : 'hidden';
        }

        function toggleMobileSearch() {
            document.querySelector('.search-container').classList.toggle('active');
        }

        $(document).ready(function() {
            // Header scroll effect
            $(window).scroll(function() {
                if ($(this).scrollTop() > 50) {
                    $('.header-main').addClass('scrolled');
                } else {
                    $('.header-main').removeClass('scrolled');
                }
            });

            $('#newsletter-form').on('submit', function(e) {
                e.preventDefault();
                const form = $(this);
                const btn = form.find('button');
                const msg = $('#newsletter-message');
                
                btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> PROCESSING...');
                msg.hide();

                $.ajax({
                    url: "{{ route('newsletter.subscribe') }}",
                    method: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        if(response.success) {
                            form.slideUp();
                            msg.html(response.message).css('color', '#fff').fadeIn();
                        } else {
                            msg.html(response.message).css('color', '#fee2e2').fadeIn();
                            btn.prop('disabled', false).html('SUBSCRIBE <i class="fas fa-paper-plane"></i>');
                        }
                    },
                    error: function() {
                        msg.html('An unexpected error occurred. Please try again.').css('color', '#fee2e2').fadeIn();
                        btn.prop('disabled', false).html('SUBSCRIBE <i class="fas fa-paper-plane"></i>');
                    }
                });
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
