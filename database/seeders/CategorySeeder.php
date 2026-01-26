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
    }
}
