<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Zenis - eCommerce')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #ff6b00; /* Zenis Orange */
            --secondary: #2b3445; /* Dark Blue/Black */
            --text: #7d879c;
            --light: #f3f5f9;
            --white: #ffffff;
            --border: #e3e9ef;
        }
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            color: var(--secondary);
            background-color: var(--white);
        }
        a { text-decoration: none; color: inherit; transition: color 0.3s; }
        ul { list-style: none; padding: 0; margin: 0; }
        
        /* Utility */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }
        .flex { display: flex; }
        .items-center { align-items: center; }
        .justify-between { justify-content: space-between; }
        .gap-4 { gap: 1rem; }
        .text-primary { color: var(--primary); }
        .bg-primary { background-color: var(--primary); color: white; }
        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 4px;
            font-weight: 600;
            cursor: pointer;
            border: none;
        }

        /* Top Bar */
        .top-bar {
            background: var(--secondary);
            color: white;
            padding: 0.5rem 0;
            font-size: 0.875rem;
        }
        .top-bar-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Header */
        .header-main {
            padding: 1.5rem 0;
            border-bottom: 1px solid var(--border);
        }
        .logo {
            font-size: 2rem;
            font-weight: 800;
        }
        .search-bar {
            flex: 1;
            max-width: 600px;
            margin: 0 2rem;
            display: flex;
            border: 2px solid var(--primary);
            border-radius: 4px;
            overflow: hidden;
        }
        .search-bar input {
            flex: 1;
            padding: 0.75rem;
            border: none;
            outline: none;
        }
        .search-bar button {
            background: var(--primary);
            color: white;
            border: none;
            padding: 0 1.5rem;
            font-weight: 600;
        }
        .header-icons {
            display: flex;
            gap: 1.5rem;
        }
        .icon-btn {
            position: relative;
            font-size: 1.5rem;
        }
        .icon-badge {
            position: absolute;
            top: -5px;
            right: -10px;
            background: var(--primary);
            color: white;
            font-size: 0.75rem;
            padding: 2px 6px;
            border-radius: 50%;
        }

        /* Navbar */
        .navbar {
            background: white;
            border-bottom: 1px solid var(--border);
            padding: 0;
        }
        .nav-menu {
            display: flex;
            gap: 2rem;
        }
        .nav-link {
            padding: 1rem 0;
            font-weight: 600;
            display: block;
        }
        .nav-link:hover { color: var(--primary); }

        /* Footer */
        footer {
            background: var(--secondary);
            color: #aeb4be;
            padding: 4rem 0 2rem;
            margin-top: 4rem;
        }
        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 3rem;
            margin-bottom: 3rem;
        }
        .footer-title {
            color: white;
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }
        .footer-links li { margin-bottom: 0.75rem; }
        .footer-links a:hover { color: var(--primary); }
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
    <div class="header-main">
        <div class="container flex items-center justify-between">
            <a href="{{ url('/') }}" class="logo">{{ $settings['site_name'] ?? 'Zenis' }}<span class="text-primary">.</span></a>
            
            <div class="search-bar">
                <select style="border:none; padding: 0 1rem; border-right:1px solid #ddd; outline:none; background:#f5f5f5;">
                    <option>All Categories</option>
                </select>
                <input type="text" placeholder="Search for products...">
                <button>Search</button>
            </div>

            <div class="header-icons">
                <a href="#" class="icon-btn">♡ <span class="icon-badge">2</span></a>
                <a href="#" class="icon-btn">🛒 <span class="icon-badge">3</span></a>
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="icon-btn">👤</a>
                @else
                    <a href="{{ route('login') }}" class="icon-btn">👤</a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="container">
            <ul class="nav-menu">
                @php
                    $menu = json_decode($settings['main_menu'] ?? '[]', true);
                @endphp
                @forelse($menu as $item)
                    <li><a href="{{ $item['url'] }}" class="nav-link">{{ $item['label'] }}</a></li>
                @empty
                    <li><a href="{{ url('/') }}" class="nav-link">Home</a></li>
                    <li><a href="{{ route('about') }}" class="nav-link">About</a></li>
                    <li><a href="{{ route('contact') }}" class="nav-link">Contact</a></li>
                @endforelse
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    @yield('content')

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-grid">
                <div>
                    <div class="footer-title">{{ $settings['site_name'] ?? 'Zenis' }}</div>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Auctor libero id et, in gravida.</p>
                    <div class="flex gap-4" style="margin-top:1rem;">
                        @php
                            $socials = json_decode($settings['social_links'] ?? '[]', true);
                        @endphp
                        @foreach($socials as $social)
                            <a href="{{ $social['url'] }}" target="_blank" style="color:white; font-size:1.2rem;">{{ $social['platform'] }}</a>
                        @endforeach
                    </div>
                </div>
                <div>
                    <div class="footer-title">About Us</div>
                    <ul class="footer-links">
                        <li><a href="#">Careers</a></li>
                        <li><a href="#">Our Stores</a></li>
                        <li><a href="#">Our Cares</a></li>
                        <li><a href="#">Terms & Conditions</a></li>
                    </ul>
                </div>
                <div>
                    <div class="footer-title">Customer Care</div>
                    <ul class="footer-links">
                        <li><a href="#">Help Center</a></li>
                        <li><a href="#">How to Buy</a></li>
                        <li><a href="#">Track Your Order</a></li>
                        <li><a href="#">Returns & Refunds</a></li>
                    </ul>
                </div>
                <div>
                    <div class="footer-title">Contact Us</div>
                    <ul class="footer-links">
                        <li>{{ $settings['site_address'] ?? 'Address Here' }}</li>
                        <li>Email: {{ $settings['site_email'] ?? 'support@example.com' }}</li>
                        <li>Phone: {{ $settings['site_phone'] ?? '+1 234 567 890' }}</li>
                    </ul>
                </div>
            </div>
            <div style="text-align:center; padding-top:2rem; border-top:1px solid #3d4a5e;">
                &copy; {{ date('Y') }} Zenis. All Rights Reserved.
            </div>
        </div>
    </footer>

</body>
</html>
