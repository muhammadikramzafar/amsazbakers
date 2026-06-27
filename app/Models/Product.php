<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'subcategory_id', 'name', 'slug', 'sku',
        'description', 'short_description', 'full_description',
        'ingredients', 'nutritional_info', 'allergens',
        'price', 'sale_price', 'image', 'gallery',
        'is_featured', 'is_bestseller', 'is_seasonal',
        'is_active', 'is_available', 'badge', 'sort_order',
    ];

    protected $casts = [
        'price'           => 'decimal:2',
        'sale_price'      => 'decimal:2',
        'gallery'         => 'array',
        'is_featured'     => 'boolean',
        'is_bestseller'   => 'boolean',
        'is_seasonal'     => 'boolean',
        'is_active'       => 'boolean',
        'is_available'    => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Category::class, 'subcategory_id');
    }

    public function getDisplayPriceAttribute(): string
    {
        return 'Rs. ' . number_format($this->sale_price ?? $this->price, 0);
    }

    public function getImageUrlAttribute(): string
    {
        return $this->image ? Storage::url($this->image) : '';
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
        if ($this->image) {
            $images[] = Storage::url($this->image);
        }
        foreach ($this->gallery_urls as $url) {
            $images[] = $url;
        }
        return $images;
    }

    public function getCartButtonTextAttribute(): string
    {
        $slug = $this->category?->slug ?? '';

        $foodSlugs  = ['pizza', 'fast-food', 'snacks', 'fried-items', 'deals', 'salad-chaat'];
        $sweetSlugs = ['sweets', 'cakes', 'pastries', 'ice-cream', 'bakery'];

        if (in_array($slug, $foodSlugs))  return 'Make It Mine';
        if (in_array($slug, $sweetSlugs)) return 'Save My Dessert';
        return 'Chef, Make This!';
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
}
