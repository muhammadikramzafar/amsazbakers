<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        SiteSetting::firstOrCreate(
            ['id' => 1],
            [
                'website_name'       => 'Azmeer Bakery',
                'tagline'            => 'Crafted with Love, Delivered Fresh',
                'country'            => 'Pakistan',
                'city'               => 'Lahore',
                'province'           => 'Punjab',
                'address'            => 'Main Market, Gulberg III, Lahore',
                'phone'              => '+92 300 0000000',
                'whatsapp'           => '+92 300 0000000',
                'email'              => 'info@azmeerbakery.pk',
                'opening_time'       => '08:00',
                'closing_time'       => '22:00',
                'weekly_holidays'    => ['Sunday'],
                'footer_description' => 'Azmeer Bakery has been serving the finest freshly baked goods, traditional sweets, and modern desserts in Pakistan since 1995.',
                'copyright_text'     => '© ' . date('Y') . ' Azmeer Bakery. All rights reserved.',
            ]
        );
    }
}
