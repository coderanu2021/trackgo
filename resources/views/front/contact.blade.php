@extends('layouts.front')

@section('title', 'Contact Us - Zenis')

@section('content')
<div class="container" style="padding: 4rem 0;">
    <div style="max-width: 800px; margin: 0 auto;">
        <h1 style="text-align: center; margin-bottom: 3rem;">Get in Touch</h1>
        
        <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 4rem;">
            <div>
                <h3 style="margin-bottom: 1.5rem;">Contact Info</h3>
                <div style="margin-bottom: 1.5rem;">
                    <stron style="display:block; margin-bottom:0.25rem;">Address</stron>
                    <span style="color:var(--text);">123 Zenis St, New York, NY 10012</span>
                </div>
                <div style="margin-bottom: 1.5rem;">
                    <stron style="display:block; margin-bottom:0.25rem;">Phone</stron>
                    <span style="color:var(--text);">+1 234 567 890</span>
                </div>
                <div style="margin-bottom: 1.5rem;">
                    <stron style="display:block; margin-bottom:0.25rem;">Email</stron>
                    <span style="color:var(--text);">hello@zenis.com</span>
                </div>
            </div>
            
            <div style="background: white; padding: 2rem; border: 1px solid #e3e9ef; border-radius: 8px;">
                <form>
                    <div style="margin-bottom: 1rem;">
                        <label style="display:block; margin-bottom:0.5rem; font-weight:500;">Name</label>
                        <input type="text" style="width:100%; padding:0.75rem; border:1px solid #ddd; border-radius:4px; box-sizing:border-box;">
                    </div>
                    <div style="margin-bottom: 1rem;">
                        <label style="display:block; margin-bottom:0.5rem; font-weight:500;">Email</label>
                        <input type="email" style="width:100%; padding:0.75rem; border:1px solid #ddd; border-radius:4px; box-sizing:border-box;">
                    </div>
                    <div style="margin-bottom: 1rem;">
                        <label style="display:block; margin-bottom:0.5rem; font-weight:500;">Message</label>
                        <textarea rows="5" style="width:100%; padding:0.75rem; border:1px solid #ddd; border-radius:4px; box-sizing:border-box;"></textarea>
                    </div>
                    <button class="btn bg-primary" style="width:100%;">Send Message</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
