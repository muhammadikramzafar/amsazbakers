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
        $categories = [
            ['name' => 'Bakery',         'slug' => 'bakery',         'icon' => 'fa-bread-slice', 'sort_order' => 1],
            ['name' => 'Sweets',         'slug' => 'sweets',         'icon' => 'fa-candy-cane',  'sort_order' => 2],
            ['name' => 'Cakes',          'slug' => 'cakes',          'icon' => 'fa-birthday-cake','sort_order' => 3],
            ['name' => 'Pastries',       'slug' => 'pastries',       'icon' => 'fa-cookie',       'sort_order' => 4],
            ['name' => 'Beverages',      'slug' => 'beverages',      'icon' => 'fa-mug-hot',      'sort_order' => 5],
            ['name' => 'Special Orders', 'slug' => 'special-orders', 'icon' => 'fa-star',         'sort_order' => 6],
        ];

        foreach ($categories as $category) {
            \App\Models\Category::updateOrCreate(['slug' => $category['slug']], $category);
        }
    }
}
