<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'name', 'slug', 'description', 'price', 'sale_price',
        'image', 'is_featured', 'is_active', 'is_available', 'badge', 'sort_order',
    ];

    protected $casts = [
        'price'        => 'decimal:2',
        'sale_price'   => 'decimal:2',
        'is_featured'  => 'boolean',
        'is_active'    => 'boolean',
        'is_available' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getDisplayPriceAttribute(): string
    {
        return 'Rs. ' . number_format($this->sale_price ?? $this->price, 0);
    }
}
