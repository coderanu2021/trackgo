<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks to allow truncation
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        \App\Models\Category::truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        // 1. GPS Tracker
        $gpsTracker = \App\Models\Category::create([
            'name' => 'GPS Tracker',
            'slug' => 'gps-tracker',
            'icon' => 'fas fa-map-marker-alt',
            'is_active' => true,
            'parent_id' => null
        ]);

        $gpsChildren = [
            'GPS for car',
            'GPS for bus',
            'GPS for bike',
            'GPS for truck',
            'GPS AIS140 for Commercial vehicle',
            'GPS for Asset tracker',
            'GPS helmate',
            'GPS for School Bag',
            'GPs for Staff',
            'GPS for School bus',
            'GPS for shoes army special',
            'GPS For pets'
        ];

        foreach ($gpsChildren as $child) {
            \App\Models\Category::create([
                'name' => $child,
                'slug' => \Illuminate\Support\Str::slug($child),
                'icon' => 'fas fa-circle', // Default icon
                'is_active' => true,
                'parent_id' => $gpsTracker->id
            ]);
        }

        // 2. Dash Cam
        $dashCam = \App\Models\Category::create([
            'name' => 'Dash Cam',
            'slug' => 'dash-cam',
            'icon' => 'fas fa-camera',
            'is_active' => true,
            'parent_id' => null
        ]);

        $dashChildren = [
            '2 G',
            '4 G dual',
            '4 G with ADAS'
        ];

        foreach ($dashChildren as $child) {
            \App\Models\Category::create([
                'name' => $child,
                'slug' => \Illuminate\Support\Str::slug($child),
                'icon' => 'fas fa-video',
                'is_active' => true,
                'parent_id' => $dashCam->id
            ]);
        }

        // 3. Industrial Products
        $industrial = \App\Models\Category::create([
            'name' => 'Industrial Products',
            'slug' => 'industrial-products',
            'icon' => 'fas fa-industry',
            'is_active' => true,
            'parent_id' => null
        ]);

        $industrialChildren = [
            'GPS project for Election department',
            'GPS for mining department',
            'GPS for ambulance',
            'GPS for police vans',
            'GPS transport department',
            'GPS for Schools',
            'LIVE STREAMING FOR ELECTIONS',
            'LIVE STREAMING FOR SCHOOL EXAMS',
            'VISITOR MANAEGEMT SYSTEM',
            'BOOM BARRIER',
            '4 G live streaming cameras',
            'Video wall for control rooms',
            'Control room setup for government departments'
        ];

        foreach ($industrialChildren as $child) {
            \App\Models\Category::create([
                'name' => $child,
                'slug' => \Illuminate\Support\Str::slug($child),
                'icon' => 'fas fa-cogs',
                'is_active' => true,
                'parent_id' => $industrial->id
            ]);
        }

        // 4. GPS Devices
        $gpsDevices = \App\Models\Category::create([
            'name' => 'GPS Devices',
            'slug' => 'gps-devices',
            'icon' => 'fas fa-satellite-dish',
            'is_active' => true,
            'parent_id' => null
        ]);

        $deviceChildren = [
            'Handheld GPS',
            'Marine GPS',
            'Aviation GPS',
            'Fitness GPS Watches'
        ];

        foreach ($deviceChildren as $child) {
            \App\Models\Category::create([
                'name' => $child,
                'slug' => \Illuminate\Support\Str::slug($child),
                'icon' => 'fas fa-device-mobile',
                'is_active' => true,
                'parent_id' => $gpsDevices->id
            ]);
        }

        // 5. Security Systems
        $security = \App\Models\Category::create([
            'name' => 'Security Systems',
            'slug' => 'security-systems',
            'icon' => 'fas fa-shield-alt',
            'is_active' => true,
            'parent_id' => null
        ]);

        $securityChildren = [
            'CCTV Cameras',
            'Access Control',
            'Alarm Systems',
            'Biometric Systems'
        ];

        foreach ($securityChildren as $child) {
            \App\Models\Category::create([
                'name' => $child,
                'slug' => \Illuminate\Support\Str::slug($child),
                'icon' => 'fas fa-lock',
                'is_active' => true,
                'parent_id' => $security->id
            ]);
        }

        // 6. Fleet Management
        $fleet = \App\Models\Category::create([
            'name' => 'Fleet Management',
            'slug' => 'fleet-management',
            'icon' => 'fas fa-truck',
            'is_active' => true,
            'parent_id' => null
        ]);

        $fleetChildren = [
            'Vehicle Tracking',
            'Driver Monitoring',
            'Fuel Management',
            'Route Optimization'
        ];

        foreach ($fleetChildren as $child) {
            \App\Models\Category::create([
                'name' => $child,
                'slug' => \Illuminate\Support\Str::slug($child),
                'icon' => 'fas fa-route',
                'is_active' => true,
                'parent_id' => $fleet->id
            ]);
        }

        // 7. IoT Solutions
        $iot = \App\Models\Category::create([
            'name' => 'IoT Solutions',
            'slug' => 'iot-solutions',
            'icon' => 'fas fa-wifi',
            'is_active' => true,
            'parent_id' => null
        ]);

        $iotChildren = [
            'Smart Sensors',
            'Environmental Monitoring',
            'Asset Tracking',
            'Remote Control Systems'
        ];

        foreach ($iotChildren as $child) {
            \App\Models\Category::create([
                'name' => $child,
                'slug' => \Illuminate\Support\Str::slug($child),
                'icon' => 'fas fa-microchip',
                'is_active' => true,
                'parent_id' => $iot->id
            ]);
        }
    }
}
