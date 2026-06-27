<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomepageSetting extends Model
{
    protected $fillable = [
        'hero_active','categories_active',
        'bestsellers_active','bestsellers_heading','bestsellers_subheading','bestsellers_count',
        'about_active','promos_active',
        'featured_bakery_active','featured_bakery_heading','featured_bakery_subheading','featured_bakery_category','featured_bakery_count',
        'featured_sweets_active','featured_sweets_heading','featured_sweets_subheading','featured_sweets_category','featured_sweets_count',
        'signature_active','signature_heading','signature_subheading',
        'fresh_active','fresh_heading','fresh_subheading','fresh_count',
        'why_choose_active','why_choose_heading','why_choose_subheading',
        'cta_active','testimonials_active','testimonials_heading',
        'instagram_active','instagram_heading','instagram_handle',
        'seo_title','seo_description','seo_keywords','og_title','og_description','og_image',
    ];

    protected $casts = [
        'hero_active'            => 'boolean',
        'categories_active'      => 'boolean',
        'bestsellers_active'     => 'boolean',
        'about_active'           => 'boolean',
        'promos_active'          => 'boolean',
        'featured_bakery_active' => 'boolean',
        'featured_sweets_active' => 'boolean',
        'signature_active'       => 'boolean',
        'fresh_active'           => 'boolean',
        'why_choose_active'      => 'boolean',
        'cta_active'             => 'boolean',
        'testimonials_active'    => 'boolean',
        'instagram_active'       => 'boolean',
        'bestsellers_count'      => 'integer',
        'featured_bakery_count'  => 'integer',
        'featured_sweets_count'  => 'integer',
        'fresh_count'            => 'integer',
    ];

    public static function get(): static
    {
        return static::firstOrCreate(['id' => 1]);
    }
}
