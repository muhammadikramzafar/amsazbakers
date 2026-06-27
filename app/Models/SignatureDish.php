<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SignatureDish extends Model
{
    protected $fillable = ['name','description','price','image','tag','is_active','sort_order'];
    protected $casts    = ['is_active' => 'boolean', 'price' => 'decimal:2'];

    public function getImageUrlAttribute(): string
    {
        return $this->image ? Storage::url($this->image) : '';
    }

    public function getDisplayPriceAttribute(): string
    {
        return $this->price ? 'Rs. ' . number_format($this->price, 0) : '';
    }

    public function scopeActive($q) { return $q->where('is_active', true)->orderBy('sort_order'); }
}
