<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Sweets',        'slug' => 'sweets',       'sort_order' => 1,  'is_active' => true],
            ['name' => 'Pizza',         'slug' => 'pizza',        'sort_order' => 2,  'is_active' => true],
            ['name' => 'Snacks',        'slug' => 'snacks',       'sort_order' => 3,  'is_active' => true],
            ['name' => 'Dairy',         'slug' => 'dairy',        'sort_order' => 4,  'is_active' => true],
            ['name' => 'Coffee & Tea',  'slug' => 'coffee-tea',   'sort_order' => 5,  'is_active' => true],
            ['name' => 'Juices',        'slug' => 'juices',       'sort_order' => 6,  'is_active' => true],
            ['name' => 'Shakes',        'slug' => 'shakes',       'sort_order' => 7,  'is_active' => true],
            ['name' => 'Ice Cream',     'slug' => 'ice-cream',    'sort_order' => 8,  'is_active' => true],
            ['name' => 'Salad & Chaat', 'slug' => 'salad-chaat',  'sort_order' => 9,  'is_active' => true],
            ['name' => 'Fried Items',   'slug' => 'fried-items',  'sort_order' => 10, 'is_active' => true],
            ['name' => 'Fast Food',     'slug' => 'fast-food',    'sort_order' => 11, 'is_active' => true],
            ['name' => 'Deals',         'slug' => 'deals',        'sort_order' => 12, 'is_active' => true],
            ['name' => 'Bakery',        'slug' => 'bakery',       'sort_order' => 13, 'is_active' => true],
            ['name' => 'Cakes',         'slug' => 'cakes',        'sort_order' => 14, 'is_active' => true],
            ['name' => 'Pastries',      'slug' => 'pastries',     'sort_order' => 15, 'is_active' => true],
            ['name' => 'Beverages',     'slug' => 'beverages',    'sort_order' => 16, 'is_active' => true],
        ];

        foreach ($categories as $cat) {
            \App\Models\Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }
    }
}
