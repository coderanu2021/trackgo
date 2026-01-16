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
                ['platform' => 'Facebook', 'url' => '#', 'icon' => 'facebook'],
                ['platform' => 'Twitter', 'url' => '#', 'icon' => 'twitter'],
                ['platform' => 'Instagram', 'url' => '#', 'icon' => 'instagram'],
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
            ['key' => 'site_currency', 'value' => 'USD'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
