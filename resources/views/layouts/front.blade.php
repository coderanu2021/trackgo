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
            --primary-hover: var(--primary-dark);
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
        
        @media (max-width: 768px) {
            .container { padding: 0 10px; }
        }

        /* Hide mobile elements by default */
        .mobile-menu-btn,
        .mobile-nav-overlay,
        .mobile-nav {
            display: none;
        }


        
        /* 2. MIDDLE HEADER (Logo & Search) */
        .header-middle {
            padding: 10px 0;
            background: var(--white);
        }
        /* Base Desktop Styles - Default */
        .hm-flex {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 30px;
        }
        
        .logo {
            order: 0;
            flex-shrink: 0; /* Prevent logo from shrinking */
        }
        
        .zenis-search {
            flex: 1;
            max-width: 700px;
            position: relative;
        }
        
        .header-icons {
            order: 0;
            display: flex;
            gap: 25px;
            align-items: center;
            flex-shrink: 0; /* Prevent icons from shrinking */
        }
        .logo img { 
            height: 68px; 
            max-width: 200px;
            object-fit: contain;
        }
        
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
            padding: 0 10px;
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
            z-index: 1000; /* Ensure header is above content */
        }
        .hb-flex { display: flex; align-items: stretch; height: 50px; } /* Stretch items to full height */
        
        /* Vertical Menu Toggle */
        .vertical-menu-btn {
            background: var(--primary);
            color: white;
            width: 280px;
            padding: 0 1.25rem;
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
            font-size: 0.9rem;
            letter-spacing: 0.05em;
            z-index: 1001; /* Ensure button is above content but below dropdown */
        }
        
        .vertical-menu-btn:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(243, 112, 33, 0.3);
        }
        
        .vertical-menu-btn .menu-icon {
            margin-right: 0.75rem;
            font-size: 1rem;
        }
        
        .vertical-menu-btn .menu-text {
            flex: 1;
            text-align: left;
        }
        
        /* Simple Category Dropdown */
        .category-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            width: 280px;
            background: white;
            border: 1px solid var(--border);
            border-top: none;
            border-radius: 0 0 var(--radius-md) var(--radius-md);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
            z-index: 9999; /* Increased z-index to appear above everything */
            max-height: 500px;
            overflow-y: auto;
            overflow-x: visible; /* Allow subcategories to show outside */
        }
        
        .cat-dropdown-list {
            display: flex;
            flex-direction: column;
        }
        
        /* Category Item Container - Using exact home page structure */
        .category-item {
            position: relative;
        }
        
        .cat-link {
            padding: 0.85rem 1rem;
            border-bottom: 1px solid var(--border);
            font-size: 0.9rem;
            color: var(--text-main);
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: 0.2s;
        }
        
        .cat-link:last-child { 
            border-bottom: none; 
        }
        
        .cat-link:hover {
            background: linear-gradient(135deg, var(--primary-soft), rgba(243, 112, 33, 0.05));
            color: var(--primary);
            padding-left: 1.25rem;
            transform: translateX(2px);
        }
        
        .cat-link i {
            transition: all 0.2s ease;
        }
        
        .cat-link:hover i {
            transform: scale(1.1);
        }
        
        /* Category hover effects - Enhanced for better reliability */
        .category-dropdown .category-item:hover .cat-link {
            background: #f9f9f9 !important;
            color: var(--primary) !important;
            padding-left: 1.25rem !important;
        }
        
        .category-dropdown .category-item:hover .category-arrow {
            color: var(--primary) !important;
            transform: rotate(90deg) !important;
        }
        
        .category-dropdown .category-item:hover > .subcategory-dropdown {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
        
        /* Ensure subcategory dropdown stays visible when hovering over it */
        .category-dropdown .subcategory-dropdown:hover {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
        
        /* Keep parent category highlighted when hovering over subcategories */
        .category-dropdown .category-item:hover .subcategory-dropdown:hover ~ .cat-link,
        .category-dropdown .category-item .subcategory-dropdown:hover + .cat-link {
            background: #f9f9f9 !important;
            color: var(--primary) !important;
            padding-left: 1.25rem !important;
        }
        
        /* Enhanced subcategory positioning and visibility */
        .category-dropdown .subcategory-dropdown {
            visibility: hidden !important;
            opacity: 0 !important;
            transition: all 0.2s ease !important;
            pointer-events: auto !important;
        }
        
        /* Debug: Ensure hover areas are working */
        .category-dropdown .category-item {
            position: relative !important;
        }
        
        .category-dropdown .category-item .cat-link {
            position: relative !important;
            z-index: 1 !important;
        }
        
        /* Ensure subcategory dropdown appears above everything */
        .category-dropdown .subcategory-dropdown {
            z-index: 10001 !important;
        }
        
        /* Subcategory Dropdown - Exact copy from home page */
        .subcategory-dropdown {
            position: absolute;
            left: 100%;
            top: 0;
            width: 200px;
            background: white;
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-lg);
            z-index: 10000; /* Higher than parent dropdown */
            max-height: 300px;
            overflow-y: auto;
            display: none !important; /* Initially hidden */
        }
        
        .subcategory-dropdown .cat-link {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid var(--border-soft);
            font-size: 0.85rem;
        }
        
        .subcategory-dropdown .cat-link:hover {
            background: var(--primary-soft);
            color: var(--primary);
            padding-left: 1.25rem;
        }
        
        .subcategory-dropdown .cat-link:last-child {
            border-bottom: none;
        }
        
        /* Arrow rotation */
        .vertical-menu-btn.active #category-arrow {
            transform: rotate(180deg);
        }
        
        .vertical-menu-btn.active {
            background: var(--primary-dark);
            box-shadow: 0 4px 12px rgba(243, 112, 33, 0.3);
        }
        
        /* Category dropdown animation */
        .category-dropdown {
            animation: slideDown 0.3s ease-out;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Subcategory dropdown animation */
        .subcategory-dropdown-desktop {
            animation: slideRight 0.3s ease-out;
        }
        
        @keyframes slideRight {
            from {
                opacity: 0;
                transform: translateX(-10px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
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
            
            /* Hide mobile elements on desktop */
            .mobile-menu-btn,
            .mobile-nav-overlay,
            .mobile-nav {
                display: none !important;
            }
            
            /* Force desktop header layout - Override any mobile styles */
            .header-middle {
                padding: 10px 0;
                background: var(--white);
            }
            
            .hm-flex {
                display: flex !important;
                align-items: center !important;
                justify-content: space-between !important;
                gap: 30px !important;
                flex-wrap: nowrap !important;
                grid-template-columns: none !important;
                padding: 0 !important;
            }
            
            .logo {
                order: 0 !important;
                justify-self: unset !important;
                margin: 0 !important;
                flex: none !important;
            }
            
            .zenis-search {
                order: 0 !important;
                flex: 1 !important;
                max-width: 700px !important;
                margin: 0 !important;
                grid-column: unset !important;
                width: auto !important;
                position: relative !important;
            }
            
            .header-icons {
                order: 0 !important;
                justify-self: unset !important;
                margin-left: 0 !important;
                display: flex !important;
                gap: 25px !important;
                align-items: center !important;
                flex: none !important;
                grid-column: unset !important;
            }
            
            .header-icons .icon-box {
                display: flex !important;
                flex-direction: column !important;
                align-items: center !important;
                font-size: 12px !important;
                color: var(--text-main) !important;
                position: relative !important;
                min-width: auto !important;
            }
            
            .header-icons .icon-wrap {
                position: relative !important;
                font-size: 24px !important;
                margin-bottom: 2px !important;
                color: var(--secondary) !important;
            }
            
            .header-icons .icon-box span {
                font-weight: 600 !important;
                font-size: 12px !important;
                white-space: nowrap !important;
            }
        }
        @media (max-width: 992px) {
            .top-bar { display: none; }
            .header-bottom { display: none; } /* Desktop navigation hidden on mobile */
            
            /* Mobile-only header layout */
            .header-middle .hm-flex { 
                display: grid !important;
                grid-template-columns: auto auto auto auto 1fr !important;
                align-items: center !important;
                gap: 8px !important;
                flex-wrap: wrap !important;
                padding: 0 10px !important;
                justify-content: unset !important;
            }
            
            .header-middle .logo { 
                order: 5 !important; 
                justify-self: end !important;
                flex: none !important;
                display: flex !important;
                align-items: center !important;
            }
            
            .header-middle .logo img {
                height: 45px !important; /* Ensure logo is visible on mobile */
                max-width: 150px !important;
                object-fit: contain !important;
            }
            
            .header-middle .logo h2 {
                font-size: 24px !important; /* Smaller text logo on mobile */
                margin: 0 !important;
            }
            
            .header-middle .header-icons { 
                order: 2 !important; 
                justify-self: start !important;
                display: flex !important;
                gap: 8px !important;
                grid-column: 2 / 5 !important;
            }
            
            /* Mobile icon styling */
            .header-middle .header-icons .icon-box {
                flex-direction: column !important;
                align-items: center !important;
                font-size: 10px !important;
                min-width: auto !important;
            }
            
            .header-middle .header-icons .icon-wrap {
                font-size: 20px !important;
                margin-bottom: 2px !important;
            }
            
            .header-middle .header-icons .icon-box span {
                font-size: 9px !important;
                font-weight: 500 !important;
                white-space: nowrap !important;
            }
            
            .header-middle .zenis-search { 
                order: 6 !important; 
                grid-column: 1 / -1 !important;
                width: 100% !important; 
                max-width: 100% !important; 
                margin: 15px 0 0 0 !important;
                flex: none !important;
            }
            
            /* Mobile Menu Button - Only show on mobile, positioned on left */
            .mobile-menu-btn {
                display: flex !important;
                order: 1 !important;
                justify-self: start !important;
                background: none !important;
                border: none !important;
                font-size: 1.5rem !important;
                color: var(--secondary) !important;
                cursor: pointer !important;
                padding: 0.5rem !important;
                border-radius: 8px !important;
                transition: all 0.3s ease !important;
            }
            .mobile-menu-btn:hover {
                background: #f3f4f6;
                color: var(--primary);
            }
            
            /* Mobile Navigation Overlay - Only show on mobile */
            .mobile-nav-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                z-index: 998;
                opacity: 0;
                visibility: hidden;
                transition: all 0.3s ease;
                display: block;
            }
            .mobile-nav-overlay.active {
                opacity: 1;
                visibility: visible;
            }
            
            /* Mobile Navigation Menu - Only show on mobile */
            .mobile-nav {
                position: fixed;
                top: 0;
                left: -100%;
                width: 280px;
                height: 100%;
                background: white;
                z-index: 999;
                transition: all 0.3s ease;
                box-shadow: 5px 0 15px rgba(0, 0, 0, 0.1);
                overflow-y: auto;
                display: block;
            }
            .mobile-nav.active {
                left: 0;
            }
            
            .mobile-nav-header {
                padding: 1.5rem;
                border-bottom: 1px solid #e5e7eb;
                display: flex;
                justify-content: space-between;
                align-items: center;
                background: var(--primary);
                color: white;
            }
            
            .mobile-nav-title {
                font-size: 1.25rem;
                font-weight: 700;
                margin: 0;
                display: flex;
                align-items: center;
            }
            
            .mobile-nav-logo {
                height: 35px;
                max-width: 120px;
                object-fit: contain;
            }
            
            .mobile-nav-close {
                background: none;
                border: none;
                color: white;
                font-size: 1.5rem;
                cursor: pointer;
                padding: 0.25rem;
                border-radius: 4px;
                transition: all 0.3s ease;
            }
            .mobile-nav-close:hover {
                background: rgba(255, 255, 255, 0.1);
            }
            
            .mobile-nav-menu {
                padding: 0;
                margin: 0;
                list-style: none;
            }
            
            .mobile-nav-item {
                border-bottom: 1px solid #f3f4f6;
            }
            
            .mobile-nav-link {
                display: block;
                padding: 1rem 1.5rem;
                color: #374151;
                text-decoration: none;
                font-weight: 600;
                transition: all 0.3s ease;
                display: flex;
                align-items: center;
                gap: 0.75rem;
            }
            .mobile-nav-link:hover {
                background: #f9fafb;
                color: var(--primary);
                padding-left: 2rem;
            }
            
            .mobile-nav-link i {
                width: 20px;
                text-align: center;
                color: var(--primary);
            }
            
            /* Categories in Mobile Menu */
            .mobile-categories {
                padding: 1rem 0;
                border-top: 2px solid #f3f4f6;
                margin-top: 1rem;
            }
            
            .mobile-categories-title {
                padding: 0 1.5rem 1rem;
                font-size: 0.875rem;
                font-weight: 700;
                color: #6b7280;
                text-transform: uppercase;
                letter-spacing: 0.05em;
            }
            
            .mobile-category-link {
                display: block;
                padding: 0.75rem 1.5rem;
                color: #6b7280;
                text-decoration: none;
                font-size: 0.9rem;
                transition: all 0.3s ease;
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }
            .mobile-category-link:hover {
                background: #f9fafb;
                color: var(--primary);
                padding-left: 2rem;
            }
            
            .mobile-category-link i {
                width: 16px;
                text-align: center;
                font-size: 0.8rem;
                color: var(--primary);
            }
        }
        
        /* Extra small screens - ensure logo is always visible */
        @media (max-width: 480px) {
            .header-middle .hm-flex { 
                grid-template-columns: auto 1fr auto !important;
                gap: 5px !important;
            }
            
            .header-middle .logo { 
                order: 3 !important; 
                justify-self: end !important;
            }
            
            .header-middle .logo img {
                height: 40px !important;
                max-width: 120px !important;
            }
            
            .header-middle .logo h2 {
                font-size: 20px !important;
            }
            
            .header-middle .header-icons { 
                order: 2 !important; 
                justify-self: center !important;
                grid-column: 2 / 3 !important;
                gap: 5px !important;
            }
            
            .header-middle .header-icons .icon-box span {
                font-size: 8px !important;
            }
            
            .header-middle .header-icons .icon-wrap {
                font-size: 18px !important;
            }
        }

        /* Footer - Always Dark */
        footer {
            background: linear-gradient(rgba(26, 26, 26, 0.85), rgba(26, 26, 26, 0.85)), url('{{ isset($settings['site_footer_bg']) ? asset($settings['site_footer_bg']) : asset('uploads/footer-bg.jpg') }}') center/cover no-repeat;
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
            
            <!-- Mobile Menu Button (Hidden on Desktop) -->
            <button class="mobile-menu-btn" onclick="toggleMobileMenu()" style="display: none;">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </div>

    <!-- 3. Bottom Navigation -->
    <div class="header-bottom">
        <div class="container hb-flex">
            <!-- Vertical Menu Button with Categories Dropdown -->
            <div class="vertical-menu-btn" onclick="toggleCategoryDropdown()">
                <div style="display: flex; align-items: center;">
                    <i class="fas fa-bars menu-icon"></i>
                    <span class="menu-text">All Categories</span>
                </div>
                <i class="fas fa-angle-down" id="category-arrow" style="transition: all 0.3s ease;"></i>
                
                <!-- Category Dropdown (Hidden on Home Page) -->
                @if(!Request::is('/'))
                <div class="category-dropdown" id="category-dropdown" style="display: none;">
                    <div class="cat-dropdown-list">
                        @foreach($categories_global as $category)
                            @if($category->parent_id == null)
                                <!-- Parent Category - Using exact home page structure -->
                                <div class="category-item">
                                    <a href="{{ route('category.show', $category->slug) }}" class="cat-link">
                                        <span style="display:flex; align-items:center; gap:0.75rem;">
                                            @if($category->icon) <i class="{{ $category->icon }}" style="width:20px; text-align:center;"></i> @endif
                                            {{ $category->name }}
                                        </span>
                                        @if($category->children->count() > 0)
                                            <i class="fas fa-chevron-right category-arrow" style="font-size: 0.7rem; color: #ccc; transition: all 0.3s ease;"></i>
                                        @endif
                                    </a>
                                    
                                    @if($category->children->count() > 0)
                                        <div class="subcategory-dropdown" style="display: none; visibility: hidden; opacity: 0; position: absolute; left: 100%; top: 0; width: 200px; background: white; border: 1px solid var(--border); border-radius: var(--radius-md); box-shadow: var(--shadow-lg); z-index: 10000; max-height: 300px; overflow-y: auto; transition: all 0.2s ease;">
                                            @foreach($category->children as $child)
                                                <a href="{{ route('category.show', $child->slug) }}" class="cat-link" style="border-bottom: 1px solid var(--border-soft); font-size: 0.85rem;">
                                                    <span style="display:flex; align-items:center; gap:0.75rem;">
                                                        @if($child->icon)
                                                            <i class="{{ $child->icon }}" style="width:16px; text-align:center; color: var(--primary);"></i>
                                                        @else
                                                            <i class="fas fa-arrow-right" style="width:16px; text-align:center; color: var(--text-muted); font-size: 0.6rem;"></i>
                                                        @endif
                                                        {{ $child->name }}
                                                    </span>
                                                </a>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Main Nav -->
            <ul class="main-menu">
                <li><a href="{{ url('/') }}" class="menu-link">Home</a></li>
                <li><a href="{{ route('shop') }}" class="menu-link">Shop</a></li>
                <li><a href="{{ route('pricing') }}" class="menu-link">Pricing</a></li>
                <li><a href="{{ route('blogs.index') }}" class="menu-link">Blog</a></li>
                <li><a href="{{ route('gallery') }}" class="menu-link">Gallery</a></li>
                <li><a href="{{ route('about') }}" class="menu-link">About Us</a></li>
                <li><a href="{{ route('contact') }}" class="menu-link">Contact</a></li>
                <li><a href="{{ route('faqs') }}" class="menu-link">FAQ</a></li>
            </ul>
        </div>
    </div>

    <!-- Mobile Navigation Overlay -->
    <div class="mobile-nav-overlay" onclick="toggleMobileMenu()"></div>
    
    <!-- Mobile Navigation Menu -->
    <div class="mobile-nav">
        <div class="mobile-nav-header">
            <div class="mobile-nav-title">
                @if(isset($settings['site_logo']))
                    <img src="{{ asset($settings['site_logo']) }}" alt="{{ $settings['site_name'] ?? 'TrackGo' }}" class="mobile-nav-logo">
                @else
                    <span style="font-family:'Outfit'; font-weight:800; font-size:24px; color:white;">
                        {{ $settings['site_name'] ?? 'TrackGo' }}<span style="color:#fff;">.</span>
                    </span>
                @endif
            </div>
            <button class="mobile-nav-close" onclick="toggleMobileMenu()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <ul class="mobile-nav-menu">
            <li class="mobile-nav-item">
                <a href="{{ url('/') }}" class="mobile-nav-link">
                    <i class="fas fa-home"></i>
                    Home
                </a>
            </li>
            <li class="mobile-nav-item">
                <a href="{{ route('shop') }}" class="mobile-nav-link">
                    <i class="fas fa-shopping-bag"></i>
                    Shop
                </a>
            </li>
            <li class="mobile-nav-item">
                <a href="{{ route('pricing') }}" class="mobile-nav-link">
                    <i class="fas fa-tags"></i>
                    Pricing
                </a>
            </li>
            <li class="mobile-nav-item">
                <a href="{{ route('blogs.index') }}" class="mobile-nav-link">
                    <i class="fas fa-blog"></i>
                    Blog
                </a>
            </li>
            <li class="mobile-nav-item">
                <a href="{{ route('gallery') }}" class="mobile-nav-link">
                    <i class="fas fa-images"></i>
                    Gallery
                </a>
            </li>
            <li class="mobile-nav-item">
                <a href="{{ route('about') }}" class="mobile-nav-link">
                    <i class="fas fa-info-circle"></i>
                    About Us
                </a>
            </li>
            <li class="mobile-nav-item">
                <a href="{{ route('contact') }}" class="mobile-nav-link">
                    <i class="fas fa-envelope"></i>
                    Contact
                </a>
            </li>
            <li class="mobile-nav-item">
                <a href="{{ route('faqs') }}" class="mobile-nav-link">
                    <i class="fas fa-question-circle"></i>
                    FAQ
                </a>
            </li>
        </ul>
        
        <!-- Categories in Mobile Menu -->
        <div class="mobile-categories">
            <div class="mobile-categories-title">Categories</div>
            @foreach($categories_global->take(5) as $category)
                @if($category->parent_id == null)
                    <a href="{{ route('category.show', $category->slug) }}" class="mobile-category-link">
                        @if($category->icon)
                            <i class="{{ $category->icon }}"></i>
                        @else
                            <i class="fas fa-folder"></i>
                        @endif
                        {{ $category->name }}
                    </a>
                    <!-- Child Categories -->
                    @foreach($category->children->take(3) as $child)
                        <a href="{{ route('category.show', $child->slug) }}" class="mobile-category-link" style="padding-left: 2.5rem; font-size: 0.85rem;">
                            <i class="fas fa-arrow-right"></i>
                            {{ $child->name }}
                        </a>
                    @endforeach
                @endif
            @endforeach
            
            @if($categories_global->count() > 5)
                <a href="{{ route('shop') }}" class="mobile-category-link" style="font-weight: 600; color: var(--primary);">
                    <i class="fas fa-th-large"></i>
                    View All Categories
                </a>
            @endif
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
                    <div class="footer-title">Categories</div>
                    <ul class="footer-links">
                        @foreach($categories_global->take(4) as $category)
                            <li><a href="{{ route('category.show', $category->slug) }}">{{ $category->name }}</a></li>
                        @endforeach
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
                const mobileNav = document.querySelector('.mobile-nav');
                const overlay = document.querySelector('.mobile-nav-overlay');
                
                if (mobileNav && overlay) {
                    const isActive = mobileNav.classList.contains('active');
                    
                    if (isActive) {
                        // Close menu
                        mobileNav.classList.remove('active');
                        overlay.classList.remove('active');
                        document.body.style.overflow = 'auto';
                    } else {
                        // Open menu
                        mobileNav.classList.add('active');
                        overlay.classList.add('active');
                        document.body.style.overflow = 'hidden';
                    }
                }
            } catch (e) {
                console.warn('Mobile menu toggle error:', e);
            }
        }

        function toggleCategoryDropdown() {
            try {
                const dropdown = document.getElementById('category-dropdown');
                const arrow = document.getElementById('category-arrow');
                const button = document.querySelector('.vertical-menu-btn');
                
                // If dropdown doesn't exist (home page), do nothing
                if (!dropdown) {
                    return;
                }
                
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
                
                // If dropdown doesn't exist (home page), do nothing
                if (!dropdown || !button) {
                    return;
                }
                
                if (!button.contains(event.target)) {
                    dropdown.style.display = 'none';
                    arrow.style.transform = 'rotate(0deg)';
                    button.classList.remove('active');
                }
            } catch (e) {
                console.warn('Category dropdown close error:', e);
            }
        });

        // Close mobile menu when clicking on menu links
        document.addEventListener('DOMContentLoaded', function() {
            try {
                const mobileNavLinks = document.querySelectorAll('.mobile-nav-link, .mobile-category-link');
                mobileNavLinks.forEach(link => {
                    link.addEventListener('click', function() {
                        // Close mobile menu when navigating
                        const mobileNav = document.querySelector('.mobile-nav');
                        const overlay = document.querySelector('.mobile-nav-overlay');
                        
                        if (mobileNav && overlay) {
                            mobileNav.classList.remove('active');
                            overlay.classList.remove('active');
                            document.body.style.overflow = 'auto';
                        }
                    });
                });
            } catch (e) {
                console.warn('Mobile menu link handler error:', e);
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

                // Enhanced subcategory hover functionality for header dropdown
                $('.category-dropdown .category-item').each(function() {
                    const $categoryItem = $(this);
                    const $subcategoryDropdown = $categoryItem.find('.subcategory-dropdown');
                    
                    if ($subcategoryDropdown.length > 0) {
                        let showTimeout, hideTimeout;
                        
                        // Show subcategory on hover with slight delay
                        $categoryItem.on('mouseenter', function() {
                            clearTimeout(hideTimeout);
                            showTimeout = setTimeout(function() {
                                $subcategoryDropdown.css({
                                    'display': 'block',
                                    'visibility': 'visible',
                                    'opacity': '1'
                                });
                            }, 100);
                        });
                        
                        // Hide subcategory when leaving parent (with delay to allow moving to subcategory)
                        $categoryItem.on('mouseleave', function(e) {
                            clearTimeout(showTimeout);
                            const relatedTarget = e.relatedTarget;
                            
                            // Don't hide if moving to subcategory
                            if (!$subcategoryDropdown.is(relatedTarget) && !$subcategoryDropdown.has(relatedTarget).length) {
                                hideTimeout = setTimeout(function() {
                                    $subcategoryDropdown.css({
                                        'display': 'none',
                                        'visibility': 'hidden',
                                        'opacity': '0'
                                    });
                                }, 200);
                            }
                        });
                        
                        // Keep subcategory visible when hovering over it
                        $subcategoryDropdown.on('mouseenter', function() {
                            clearTimeout(hideTimeout);
                            $(this).css({
                                'display': 'block',
                                'visibility': 'visible',
                                'opacity': '1'
                            });
                        });
                        
                        // Hide subcategory when leaving it
                        $subcategoryDropdown.on('mouseleave', function() {
                            hideTimeout = setTimeout(function() {
                                $subcategoryDropdown.css({
                                    'display': 'none',
                                    'visibility': 'hidden',
                                    'opacity': '0'
                                });
                            }, 200);
                        });
                    }
                });

                // Force refresh subcategory positioning on window resize
                $(window).on('resize', function() {
                    $('.category-dropdown .subcategory-dropdown').each(function() {
                        $(this).css({
                            'display': 'none',
                            'visibility': 'hidden',
                            'opacity': '0'
                        });
                    });
                });

            } catch (error) {
                console.warn('Script initialization error:', error);
            }
        });

        // Global AJAX Add to Cart Function
        function addToCartAjax(productId) {
            console.log('Adding product to cart:', productId);
            
            // Show loading state
            const button = event.target.closest('button') || event.target.closest('a');
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
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
                    // Update cart count in header - find the cart badge specifically
                    const cartBadges = document.querySelectorAll('.icon-badge');
                    cartBadges.forEach(badge => {
                        if (badge.closest('.icon-box').querySelector('.fa-shopping-bag')) {
                            badge.textContent = data.cart_count;
                        }
                    });

                    // Show success message
                    showNotification('success', data.message);

                    // Reset button
                    button.innerHTML = '<i class="fas fa-check"></i>';
                    button.style.background = 'var(--success)';
                    
                    setTimeout(() => {
                        button.innerHTML = originalText;
                        button.style.background = '';
                        button.disabled = false;
                    }, 1500);
                } else {
                    throw new Error(data.message || 'Failed to add to cart');
                }
            })
            .catch(error => {
                console.error('Cart AJAX Error:', error);
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
