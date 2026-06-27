<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class BlogCategory extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'image', 'color', 'sort_order', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public function posts() { return $this->hasMany(BlogPost::class); }

    public function publishedPosts() { return $this->hasMany(BlogPost::class)->where('status', 'published'); }

    public function scopeActive($q) { return $q->where('is_active', true); }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? Storage::url($this->image) : null;
    }
}
