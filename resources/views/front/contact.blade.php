@extends('layouts.front')

@section('title', 'Contact Us - ' . ($settings['site_name'] ?? 'Etrackgo'))

@push('styles')
<style>
    .contact-container {
        padding: 2rem 0 4rem;
        background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
        min-height: 100vh;
    }
    
    /* Hero Section */
    .contact-hero {
        text-align: center;
        padding: 3rem 0 4rem;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: white;
        margin-bottom: 3rem;
        border-radius: 0 0 50px 50px;
        position: relative;
        overflow: hidden;
    }
    .contact-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        opacity: 0.3;
    }
    .contact-hero h1 {
        font-size: 3rem;
        font-weight: 900;
        margin-bottom: 1rem;
        position: relative;
        z-index: 2;
    }
    .contact-hero p {
        font-size: 1.2rem;
        opacity: 0.9;
        position: relative;
        z-index: 2;
        max-width: 600px;
        margin: 0 auto;
    }
    
    /* Layout */
    .contact-layout {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 4rem;
        align-items: start;
    }

    /* Contact Form */
    .contact-form {
        background: white;
        padding: 3rem;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    }

    .form-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: #1a1a1a;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .form-title i {
        color: var(--primary);
        font-size: 1.25rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
    }

    .form-control {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: #f9fafb;
        box-sizing: border-box;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary);
        background: white;
        box-shadow: 0 0 0 3px rgba(243, 112, 33, 0.1);
    }

    .form-control.is-invalid {
        border-color: #ef4444;
        background: #fef2f2;
    }

    .invalid-feedback {
        color: #ef4444;
        font-size: 0.875rem;
        margin-top: 0.25rem;
        display: block;
    }

    textarea.form-control {
        resize: vertical;
        min-height: 120px;
    }

    .btn-submit {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: white;
        border: none;
        padding: 1rem 2.5rem;
        border-radius: 12px;
        font-size: 1rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        width: 100%;
        justify-content: center;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(243, 112, 33, 0.4);
    }

    .btn-submit:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none;
    }

    /* Contact Info */
    .contact-info {
        background: white;
        padding: 3rem;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    }

    .info-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: #1a1a1a;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .info-title i {
        color: var(--primary);
        font-size: 1.25rem;
    }

    .contact-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        margin-bottom: 2rem;
        padding: 1.5rem;
        background: #f8fafc;
        border-radius: 16px;
        border: 1px solid #f1f5f9;
        transition: all 0.3s ease;
    }

    .contact-item:hover {
        background: white;
        border-color: var(--primary);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .contact-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    .contact-details h4 {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 0.5rem;
    }

    .contact-details p {
        color: #6b7280;
        margin: 0;
        line-height: 1.6;
    }

    .contact-details a {
        color: var(--primary);
        text-decoration: none;
        font-weight: 600;
    }

    .contact-details a:hover {
        text-decoration: underline;
    }

    /* Success/Error Messages */
    .alert {
        padding: 1rem 1.5rem;
        border-radius: 12px;
        margin-bottom: 2rem;
        font-weight: 600;
    }

    .alert-success {
        background: #f0fdf4;
        color: #166534;
        border: 1px solid #bbf7d0;
    }

    .alert-danger {
        background: #fef2f2;
        color: #dc2626;
        border: 1px solid #fecaca;
    }

    /* Business Hours */
    .business-hours {
        background: #f8fafc;
        padding: 1.5rem;
        border-radius: 16px;
        border: 1px solid #f1f5f9;
        margin-top: 2rem;
    }

    .business-hours h4 {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .hours-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .hours-list li {
        display: flex;
        justify-content: space-between;
        padding: 0.5rem 0;
        border-bottom: 1px solid #e5e7eb;
        color: #6b7280;
    }

    .hours-list li:last-child {
        border-bottom: none;
    }

    .hours-list .day {
        font-weight: 600;
        color: #374151;
    }

    /* Mobile Responsive Styles */
    @media (max-width: 992px) {
        .contact-layout { 
            grid-template-columns: 1fr; 
            gap: 2rem;
        }
        .contact-hero h1 { 
            font-size: 2.5rem; 
        }
        .contact-hero {
            padding: 2rem 0 3rem;
            margin-bottom: 2rem;
        }
        .contact-container {
            padding: 1rem 0 3rem;
        }
    }

    @media (max-width: 768px) {
        .contact-form, .contact-info {
            padding: 2rem 1.5rem;
        }
        .contact-hero h1 { 
            font-size: 2rem; 
        }
        .contact-hero p {
            font-size: 1rem;
        }
        .contact-hero {
            padding: 1.5rem 0 2.5rem;
            border-radius: 0 0 30px 30px;
        }
        .form-title, .info-title {
            font-size: 1.25rem;
        }
        .contact-item {
            padding: 1rem;
            gap: 0.75rem;
        }
        .contact-icon {
            width: 40px;
            height: 40px;
            font-size: 1rem;
        }
        .contact-details h4 {
            font-size: 1rem;
        }
        .hours-list li {
            flex-direction: column;
            gap: 0.25rem;
            align-items: flex-start;
        }
        .hours-list .day {
            font-size: 0.9rem;
        }
    }

    @media (max-width: 480px) {
        .container {
            padding: 0 1rem;
        }
        .contact-form, .contact-info {
            padding: 1.5rem 1rem;
            border-radius: 15px;
        }
        .contact-hero h1 { 
            font-size: 1.75rem; 
        }
        .contact-hero {
            padding: 1rem 0 2rem;
            border-radius: 0 0 20px 20px;
        }
        .form-control {
            padding: 0.75rem;
            font-size: 0.9rem;
        }
        .btn-submit {
            padding: 0.875rem 1.5rem;
            font-size: 0.9rem;
        }
        .contact-item {
            flex-direction: column;
            text-align: center;
            padding: 1rem 0.75rem;
        }
        .contact-icon {
            align-self: center;
        }
        .business-hours {
            padding: 1rem;
        }
        .hours-list li {
            padding: 0.375rem 0;
            font-size: 0.875rem;
        }
    }

    /* Landscape phone orientation */
    @media (max-width: 768px) and (orientation: landscape) {
        .contact-hero {
            padding: 1rem 0 1.5rem;
        }
        .contact-hero h1 {
            font-size: 1.75rem;
        }
        .contact-container {
            padding: 0.5rem 0 2rem;
        }
    }
</style>
@endpush

@section('content')
<section class="contact-container">
    <!-- Hero Section -->
    <div class="contact-hero">
        <div class="container">
            <h1>Get in Touch</h1>
            <p>We'd love to hear from you. Contact us for any inquiries about our GPS tracking solutions and technology services.</p>
        </div>
    </div>

    <div class="container">
        <div class="contact-layout">
            <!-- Contact Form -->
            <div class="contact-form">
                <h2 class="form-title">
                    <i class="fas fa-paper-plane"></i>
                    Send us a Message
                </h2>

                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i> Please fix the errors below.
                    </div>
                @endif

                <form action="{{ route('contact.submit') }}" method="POST" id="contact-form">
                    @csrf
                    
                    <div class="form-group">
                        <label for="name" class="form-label">Full Name *</label>
                        <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name') }}" required placeholder="Enter your full name">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Email Address *</label>
                        <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                               value="{{ old('email') }}" required placeholder="Enter your email address">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="tel" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                               value="{{ old('phone') }}" placeholder="Enter your phone number">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="subject" class="form-label">Subject *</label>
                        <input type="text" id="subject" name="subject" class="form-control @error('subject') is-invalid @enderror" 
                               value="{{ old('subject') }}" required placeholder="What is this regarding?">
                        @error('subject')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="message" class="form-label">Message *</label>
                        <textarea id="message" name="message" class="form-control @error('message') is-invalid @enderror" 
                                  required placeholder="Tell us more about your inquiry...">{{ old('message') }}</textarea>
                        @error('message')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn-submit">
                        <i class="fas fa-paper-plane"></i>
                        Send Message
                    </button>
                </form>
            </div>

            <!-- Contact Information -->
            <div class="contact-info">
                <h2 class="info-title">
                    <i class="fas fa-map-marker-alt"></i>
                    Contact Information
                </h2>

                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="contact-details">
                        <h4>Our Address</h4>
                        <p>{{ $settings['site_address'] ?? 'Aggarwal Complex Basement, Mahavir Chowk, Barnala Road, Near Civil Hospital, Sangrur HO-148001' }}</p>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <div class="contact-details">
                        <h4>Phone Number</h4>
                        <p><a href="tel:{{ $settings['site_phone'] ?? '+91-9876543210' }}">{{ $settings['site_phone'] ?? '+91-9876543210' }}</a></p>
                        <p style="font-size: 0.875rem; margin-top: 0.25rem;">Mon - Sat: 9:00 AM - 6:00 PM</p>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="contact-details">
                        <h4>Email Address</h4>
                        <p><a href="mailto:{{ $settings['site_email'] ?? 'info@etrackgo.com' }}">{{ $settings['site_email'] ?? 'info@etrackgo.com' }}</a></p>
                        <p style="font-size: 0.875rem; margin-top: 0.25rem;">We'll respond within 24 hours</p>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fab fa-whatsapp"></i>
                    </div>
                    <div class="contact-details">
                        <h4>WhatsApp</h4>
                        <p><a href="https://wa.me/919876543210" target="_blank">+91-9876543210</a></p>
                        <p style="font-size: 0.875rem; margin-top: 0.25rem;">Quick support & inquiries</p>
                    </div>
                </div>

                <!-- Business Hours -->
                <div class="business-hours">
                    <h4>
                        <i class="fas fa-clock"></i>
                        Business Hours
                    </h4>
                    <ul class="hours-list">
                        <li><span class="day">Monday - Friday</span> <span>9:00 AM - 6:00 PM</span></li>
                        <li><span class="day">Saturday</span> <span>9:00 AM - 4:00 PM</span></li>
                        <li><span class="day">Sunday</span> <span>Closed</span></li>
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- Embedded Map Section -->
        <div style="margin-top: 4rem;">
            <h2 style="text-align: center; font-size: 2rem; font-weight: 800; color: #1a1a1a; margin-bottom: 2rem;">
                <i class="fas fa-map-marked-alt" style="color: var(--primary);"></i>
                Find Us on Map
            </h2>
            <div style="border-radius: 20px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1); border: 1px solid #e2e8f0;">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3445.123456789!2d75.84!3d30.25!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMzDCsDE1JzAwLjAiTiA3NcKwNTAnMjQuMCJF!5e0!3m2!1sen!2sin!4v1234567890123!5m2!1sen!2sin" 
                    width="100%" 
                    height="450" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
            <p style="text-align: center; color: #6b7280; margin-top: 1rem; font-size: 0.9rem;">
                <i class="fas fa-info-circle"></i> 
                Click on the map to get directions
            </p>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.getElementById('contact-form').addEventListener('submit', function(e) {
        const submitBtn = this.querySelector('.btn-submit');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
    });
</script>
@endpush