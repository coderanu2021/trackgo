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
    <style>
        :root {
            --primary: {{ $settings['site_primary_color'] ?? '#f37021' }};
            --primary-dark: {{ $settings['site_primary_color_dark'] ?? '#d45e12' }};
            --secondary: {{ $settings['site_secondary_color'] ?? '#2d2e32' }};
            --text-main: #1e293b;
            --text-muted: #64748b;
            --bg-light: #f8fafc;
            --white: #ffffff;
            --border: #e2e8f0;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            --radius-md: 12px;
            --radius-lg: 20px;
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
            padding: 0 2rem;
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
            padding: 0.65rem 0;
            font-size: 0.85rem;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        .header-main {
            padding: 1.25rem 0;
            background: rgba(255,255,255,0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 1px solid var(--border);
        }

        .logo {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--secondary);
            letter-spacing: -0.03em;
        }
        .logo span { color: var(--primary); }

        .search-container {
            flex: 1;
            max-width: 550px;
            margin: 0 3rem;
            position: relative;
        }
        .search-bar {
            display: flex;
            background: var(--bg-light);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            overflow: hidden;
            transition: border-color 0.3s;
        }
        .search-bar:focus-within { border-color: var(--primary); }
        .search-bar input {
            flex: 1;
            padding: 0.75rem 1.25rem;
            border: none;
            background: transparent;
            outline: none;
            font-size: 0.95rem;
        }
        .search-bar button {
            background: var(--primary);
            color: white;
            border: none;
            padding: 0 1.5rem;
            font-size: 1.1rem;
            cursor: pointer;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 1.75rem;
        }
        .action-link {
            position: relative;
            font-size: 1.25rem;
            color: var(--secondary);
        }
        .action-link:hover { color: var(--primary); }
        .badge {
            position: absolute;
            top: -8px;
            right: -12px;
            background: var(--primary);
            color: white;
            font-size: 0.7rem;
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-weight: 700;
        }

        /* Navbar Links */
        .nav-links {
            display: flex;
            gap: 2.5rem;
        }
        .nav-item {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--secondary);
            padding: 1rem 0;
            position: relative;
        }
        .nav-item::after {
            content: '';
            position: absolute;
            bottom: 8px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--primary);
            transition: width 0.3s;
        }
        .nav-item:hover::after { width: 100%; }

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
    </style>
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
            <a href="{{ url('/') }}" class="logo">
                @if(isset($settings['site_logo']))
                    <img src="{{ asset($settings['site_logo']) }}" alt="{{ $settings['site_name'] }}" style="height: 55px; width: auto; object-fit: contain;">
                @else
                    {{ $settings['site_name'] ?? 'eTrack GO' }}<span>.</span>
                @endif
            </a>
            
            <div class="search-container">
                <form action="#" class="search-bar">
                    <input type="text" placeholder="Search premium projects & products...">
                    <button><i class="fas fa-search"></i></button>
                </form>
            </div>

            <div class="header-actions">
                <a href="{{ route('cart.index') }}" class="action-link">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span class="badge">{{ count(session()->get('cart', [])) }}</span>
                </a>
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="action-link" title="Dashboard">
                        <i class="fa-solid fa-user-shield"></i>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="action-link" title="Sign In">
                        <i class="fa-solid fa-user"></i>
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Navbar -->
    <nav style="background: white; border-bottom: 1px solid var(--border);">
        <div class="container">
            <ul class="nav-links">
                @php $menu = json_decode($settings['main_menu'] ?? '[]', true); @endphp
                @forelse($menu as $item)
                    <li><a href="{{ $item['url'] }}" class="nav-item">{{ $item['label'] }}</a></li>
                @empty
                    <li><a href="{{ url('/') }}" class="nav-item">Home</a></li>
                    <li><a href="{{ route('blogs.index') }}" class="nav-item">Blog</a></li>
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
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: center;">
                <div style="color: white;">
                    <h2 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 1rem; font-family: 'Outfit', sans-serif;">Join the Pulse.</h2>
                    <p style="font-size: 1.15rem; color: rgba(255,255,255,0.8); line-height: 1.6;">
                        Subscribe to our premium newsletter for exclusive insights, early access to projects, and strategic industry updates.
                    </p>
                </div>
                <div>
                    <form id="newsletter-form" style="display: flex; gap: 1rem; background: white; padding: 0.5rem; border-radius: 16px; box-shadow: 0 20px 40px rgba(0,0,0,0.1);">
                        @csrf
                        <input type="email" name="email" placeholder="Enter your professional email..." 
                               style="flex: 1; border: none; padding: 1rem 1.5rem; border-radius: 12px; font-size: 1rem; outline: none;" required>
                        <button type="submit" class="btn btn-primary" style="padding: 1rem 2rem; border-radius: 12px; font-weight: 800; display: flex; align-items: center; gap: 0.75rem;">
                            SUBSCRIBE <i class="fas fa-paper-plane" style="font-size: 0.85rem;"></i>
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
        $(document).ready(function() {
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
</body>
</html>
