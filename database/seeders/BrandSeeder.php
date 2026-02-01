<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            // Technology & GPS Partners
            [
                'name' => 'Garmin',
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/5/5a/Garmin_logo.svg',
                'url' => 'https://www.garmin.com',
                'status' => true,
            ],
            [
                'name' => 'TomTom',
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/f/f8/TomTom_logo.svg',
                'url' => 'https://www.tomtom.com',
                'status' => true,
            ],
            [
                'name' => 'Qualcomm',
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/f/f6/Qualcomm-Logo.svg',
                'url' => 'https://www.qualcomm.com',
                'status' => true,
            ],
            [
                'name' => 'Intel',
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/7/7d/Intel_logo_%282006-2020%29.svg',
                'url' => 'https://www.intel.com',
                'status' => true,
            ],
            [
                'name' => 'Cisco',
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/0/08/Cisco_logo_blue_2016.svg',
                'url' => 'https://www.cisco.com',
                'status' => true,
            ],
            
            // Major Tech Companies
            [
                'name' => 'Apple',
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/f/fa/Apple_logo_black.svg',
                'url' => 'https://www.apple.com',
                'status' => true,
            ],
            [
                'name' => 'Microsoft',
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/4/44/Microsoft_logo.svg',
                'url' => 'https://www.microsoft.com',
                'status' => true,
            ],
            [
                'name' => 'Google',
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/2/2f/Google_2015_logo.svg',
                'url' => 'https://www.google.com',
                'status' => true,
            ],
            [
                'name' => 'Samsung',
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/2/24/Samsung_Logo.svg',
                'url' => 'https://www.samsung.com',
                'status' => true,
            ],
            [
                'name' => 'Dell',
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/1/18/Dell_logo_2016.svg',
                'url' => 'https://www.dell.com',
                'status' => true,
            ],
            [
                'name' => 'HP',
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/a/ad/HP_logo_2012.svg',
                'url' => 'https://www.hp.com',
                'status' => true,
            ],
            [
                'name' => 'Canon',
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/6/64/Canon_logo_2024.svg',
                'url' => 'https://www.canon.com',
                'status' => true,
            ],
            [
                'name' => 'Sony',
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/c/ca/Sony_logo.svg',
                'url' => 'https://www.sony.com',
                'status' => true,
            ],
            [
                'name' => 'LG',
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/b/bf/LG_logo_%282015%29.svg',
                'url' => 'https://www.lg.com',
                'status' => true,
            ],
            [
                'name' => 'Lenovo',
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/0/00/Lenovo_logo_2015.svg',
                'url' => 'https://www.lenovo.com',
                'status' => true,
            ],
        ];

        foreach ($brands as $brand) {
            Brand::updateOrCreate(['name' => $brand['name']], $brand);
        }
    }
}
