<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhyChooseFeature extends Model
{
    protected $fillable = ['icon_name','title','description','is_active','sort_order'];
    protected $casts    = ['is_active' => 'boolean'];

    public static array $icons = [
        'quality'  => 'Quality Ingredients',
        'fresh'    => 'Freshly Baked',
        'delivery' => 'Fast Delivery',
        'hygiene'  => 'Hygiene Standards',
        'price'    => 'Best Prices',
        'variety'  => 'Wide Variety',
        'custom'   => 'Custom Orders',
        'award'    => 'Award Winning',
        'clock'    => 'Same Day Ready',
        'heart'    => 'Made with Love',
    ];

    public function scopeActive($q) { return $q->where('is_active', true)->orderBy('sort_order'); }
}
