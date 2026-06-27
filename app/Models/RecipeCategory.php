<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class RecipeCategory extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'image', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'is_active'  => 'boolean',
        'sort_order' => 'integer',
    ];

    public function recipes()
    {
        return $this->hasMany(Recipe::class);
    }

    public function publishedRecipes()
    {
        return $this->hasMany(Recipe::class)->where('is_published', true);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function getImageUrlAttribute(): string
    {
        return $this->image ? Storage::url($this->image) : '';
    }
}
