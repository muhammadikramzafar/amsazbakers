<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class MenuItem extends Model
{
    protected $fillable = [
        'menu_category_id', 'name', 'slug', 'sku',
        'price', 'discount_price',
        'featured_image', 'gallery',
        'short_description', 'description',
        'ingredients', 'nutritional_info', 'allergens',
        'calories', 'serving_size', 'preparation_time',
        'is_available', 'is_featured', 'is_bestseller',
        'is_chef_recommended', 'is_seasonal',
        'sort_order', 'is_active',
    ];

    protected $casts = [
        'price'              => 'decimal:2',
        'discount_price'     => 'decimal:2',
        'gallery'            => 'array',
        'is_available'       => 'boolean',
        'is_featured'        => 'boolean',
        'is_bestseller'      => 'boolean',
        'is_chef_recommended'=> 'boolean',
        'is_seasonal'        => 'boolean',
        'is_active'          => 'boolean',
        'calories'           => 'integer',
        'sort_order'         => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(MenuCategory::class, 'menu_category_id');
    }

    public function getDisplayPriceAttribute(): string
    {
        return 'Rs. ' . number_format($this->discount_price ?? $this->price, 0);
    }

    public function getImageUrlAttribute(): string
    {
        return $this->featured_image ? Storage::url($this->featured_image) : '';
    }

    public function getGalleryUrlsAttribute(): array
    {
        if (empty($this->gallery)) {
            return [];
        }
        return array_map(fn($path) => Storage::url($path), $this->gallery);
    }

    public function getAllImagesAttribute(): array
    {
        $images = [];
        if ($this->featured_image) {
            $images[] = Storage::url($this->featured_image);
        }
        foreach ($this->gallery_urls as $url) {
            $images[] = $url;
        }
        return $images;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->where('is_available', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeBestseller($query)
    {
        return $query->where('is_bestseller', true);
    }

    public function scopeChefRecommended($query)
    {
        return $query->where('is_chef_recommended', true);
    }
}
