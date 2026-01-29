<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    public function run()
    {
        $settings = [
            // Contact Info
            ['key' => 'site_phone', 'value' => '+402 763 282 46'],
            ['key' => 'site_email', 'value' => 'support@zenis.com'],
            ['key' => 'site_address', 'value' => '70 Washington Square South, New York, NY 10012, United States'],
            
            // Social Media (Stored as JSON)
            ['key' => 'social_links', 'value' => json_encode([
                ['platform' => 'Twitter', 'url' => 'https://x.com/EtrackG?s=09', 'icon' => 'twitter'],
                ['platform' => 'Facebook', 'url' => 'https://www.facebook.com/etrackgo1/', 'icon' => 'facebook'],
                ['platform' => 'Youtube', 'url' => 'https://www.youtube.com/c/etrackgo', 'icon' => 'youtube'],
            ]), 'type' => 'json'],

            // App Store Links (New section)
            ['key' => 'app_store_links', 'value' => json_encode([
                ['platform' => 'Google Play', 'url' => 'https://play.google.com/store/apps/details?id=app.etrack.go&hl=en_IN', 'icon' => 'google-play'],
                ['platform' => 'App Store', 'url' => 'https://apps.apple.com/in/app/e-track-go/id1615744929', 'icon' => 'apple'],
            ]), 'type' => 'json'],

            // Main Navigation (Stored as JSON for dynamic menu builder)
            ['key' => 'main_menu', 'value' => json_encode([
                ['label' => 'Home', 'url' => '/', 'type' => 'link'],
                ['label' => 'Shop', 'url' => '/shop', 'type' => 'link'],
                ['label' => 'Vendor', 'url' => '#', 'type' => 'link'],
                ['label' => 'Flash Deals', 'url' => '#', 'type' => 'link'],
                ['label' => 'About', 'url' => '/about', 'type' => 'link'],
                ['label' => 'Contact', 'url' => '/contact', 'type' => 'link'],
                ['label' => 'FAQs', 'url' => '/faqs', 'type' => 'link'],
            ]), 'type' => 'json'],

            // Site Identity
            ['key' => 'site_name', 'value' => 'Zenis'],
            ['key' => 'site_currency', 'value' => 'INR'],
            ['key' => 'site_currency_symbol', 'value' => '₹'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
